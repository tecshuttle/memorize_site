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

        .when('/edit/:cid', {
            templateUrl: 'templates/edit.html',
            controller: 'editCtrl'
        })

        .otherwise({
            redirectTo: '/'
        });
});

blog.controller('blogCtrl', ['$scope', '$http', '$routeParams', '$location',
    function ($scope, $http, $routeParams, $location) {
        $scope.blog = [];
        $scope.tags = [];

        $http.post('/ng/getBlog', {
            cid: $routeParams.cid
        }).success(function (blog, status, headers, config) {
                $scope.blog = blog;

                $http.post('/tag_api/getList', {
                    //cid: $routeParams.cid
                }).success(function (tags, status, headers, config) {
                        $scope.tags = tags;

                        $scope.markTag();
                    });
            });

        $scope.markTag = function () {
            for (var i in $scope.tags) {
                for (var j in $scope.blog.tags) {
                    if ($scope.tags[i].id === $scope.blog.tags[j].tag_id) {
                        $scope.tags[i].tagged = true;
                    }
                }
            }
        }

        //文章：添加、删除标签
        $scope.tagClick = function (tag) {
            tag.tagged = !tag.tagged;

            $http.post('/tag_api/tag', {
                blog_id: $scope.blog.cid,
                tag_id: tag.id,
                is_tagged: tag.tagged
            });
        }

        $scope.content = function () {
            $location.path('/');
        }

        $scope.edit = function () {
            $location.path('/edit/' + $scope.blog.cid);
        }
    }
]);

blog.controller('editCtrl', ['$scope', '$http', '$routeParams', '$location',
    function ($scope, $http, $routeParams, $location) {
        $scope.blog = {
            cid: 0,
            text: '# hello'
        };

        if ($routeParams.cid !== '0') {
            $http.post('/ng/getBlog', {
                cid: $routeParams.cid
            }).success(function (blog, status, headers, config) {
                    $scope.blog = blog;
                });
        }

        $scope.content = function () {
            $location.path('/');
        }

        $scope.cancel = function (blog) {
            $location.path("/blog/" + $scope.blog.cid);
        }

        $scope.save = function (blog) {
            $http.post('/ng/save', {
                cid: blog.cid,
                text: blog.text
            }).success(function (result, status, headers, config) {
                    if (blog.cid === 0) {
                        $location.path('/');
                    } else {
                        $location.path('/blog/' + blog.cid);
                    }
                });
        }
    }
]);


blog.controller('contentCtrl', ['$scope', '$http', '$location',
    function ($scope, $http, $location) {
        $scope.blogs = [];
        $scope.tags = [];

        //显示标签所属文章
        $scope.tagClick = function (tag) {
            tag.tagged = !tag.tagged;
            $scope.loadContent();
        }

        $scope.loadContent = function () {
            var tagged_id = [];

            for (var i in $scope.tags) {
                if ($scope.tags[i].tagged) {
                    tagged_id.push($scope.tags[i].id);
                }
            }

            $http.post('/ng/getList', {
                tagged_id: tagged_id.join(', ')
            }).success(function (blogs, status, headers, config) {
                    $scope.blogs = blogs;
                });
        }

        $http.post('/tag_api/getListTotal', {
            //cid: $routeParams.cid
        }).success(function (tags, status, headers, config) {
                $scope.tags = tags;
            });

        $scope.loadContent();

        $scope.new = function () {
            $location.path('/edit/0');
        }

        $scope.home = function () {
            window.location.href = '//www.tomtalk.net';
        }
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