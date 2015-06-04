var blog = angular.module('blog', ['ngRoute', 'ngSanitize']);

blog.controller('blogCtrl', ['$scope',
        function ($scope) {
            $scope.greeting = {
                text: 'hello'
            };
        }
    ]).filter('marked', function () {
        return marked;
    });


//end file
