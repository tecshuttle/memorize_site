<div ng-controller="blogCtrl">
    <div ng-repeat="blog in blogs" ng-bind-html="blog.text | marked"></div>
</div>

