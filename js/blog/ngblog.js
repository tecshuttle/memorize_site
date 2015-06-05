var blog = angular.module('blog', ['ngRoute', 'ngSanitize']);

blog.controller('blogCtrl', ['$scope', '$http',
    function ($scope, $http) {
        $scope.blogs = [
            {cid: 1},
            {cid: 2},
            {cid: 3}
        ];

        $http.post('/vue/getList', {
            data: $scope.text
        }).success(function (blogs, status, headers, config) {
                $scope.blogs = blogs.data;
            }).error(function (data, status, headers, config) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
            });
    }
]);

blog.filter('marked', function () {
    return marked;
});


//end file
