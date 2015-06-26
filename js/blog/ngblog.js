var blog = angular.module('blog', ['ngSanitize', 'ngRoute']);

blog.config(function ($routeProvider) {
    $routeProvider
        .when('/', {
            templateUrl: 'templates/home.html',
            controller: 'contentCtrl'
        })

        .when('/blog/:cid', {
            templateUrl: 'templates/blog.html',
            controller: 'blogCtrl'
        })

        .otherwise({
            redirectTo: '/'
        });
});

blog.controller('blogCtrl', ['$scope', '$http', '$routeParams',
    function ($scope, $http, $routeParams) {
        $scope.blog = [];

        $http.post('/ng/getBlog', {
            cid: $routeParams.cid
        }).success(function (blog, status, headers, config) {
                $scope.blog = blog;
            });
    }
]);


blog.controller('contentCtrl', ['$scope', '$http',
    function ($scope, $http) {
        $scope.blogs = [];

        $http.post('/ng/getList', {
            //data: $scope.text
        }).success(function (blogs, status, headers, config) {
                $scope.blogs = blogs;
            });
    }
]);

blog.filter('markdown', function ($sce) {
    var converter = new Showdown.converter();
    return function (value) {
        var html = converter.makeHtml(value || '');
        return $sce.trustAsHtml(html);
    };
});

//end file