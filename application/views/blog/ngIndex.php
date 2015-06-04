<div ng-app="blog">
    <div ng-controller="blogCtrl">
        <textarea ng-model="blog.content"></textarea>

        <div ng-bind-html="blog.content | marked"></div>
    </div>
</div>
