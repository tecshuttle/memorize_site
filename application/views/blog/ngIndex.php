<div ng-controller="blogCtrl">
    <div ng-repeat="blog in blogs" ng-bind-html="blog.text | markdown"></div>
</div>

