<div ng-view></div>

<script id="templates/home.html" type="text/ng-template">
    <div class="ng-blog">
        <p ng-repeat="blog in blogs">
            <a href="#blog/{{blog.cid}}">{{blog.title}} </a>
        </p>
    </div>
</script>

<script id="templates/blog.html" type="text/ng-template">
    <div class="ng-tag">
        <span ng-repeat="tag in tags" ng-class="tag.tagged ? 'tagged': ''" ng-bind="tag.tag" ng-click="tagClick(tag)"></span>
    </div>

    <div ng-bind-html="blog.text | markdown" class="ng-blog"></div>
</script>


