<div ng-view></div>

<script id="templates/home.html" type="text/ng-template">
    <div class="ng-tag">
        <span class="btn" ng-click="home()" style="color:#08C;"><span class="glyphicon glyphicon-home"></span></span>
        <span ng-repeat="tag in tags" ng-class="tag.tagged ? 'tagged': ''" ng-bind="tag.tag + ' ' + tag.total" ng-click="tagClick(tag)"></span>
        <span class="btn" ng-click="new()" style="color:#84b76d;"><span class="glyphicon glyphicon-plus"></span></span>
    </div>

    <div class="ng-blog-content">
        <p ng-repeat="blog in blogs">
            <a href="#blog/{{blog.cid}}">{{blog.title}} </a>
        </p>
    </div>
</script>

<script id="templates/blog.html" type="text/ng-template">
    <div class="ng-tag">
        <span class="btn" ng-click="content()" style="color: #84b76d;"><span class="glyphicon glyphicon-inbox"></span></span>
        <span ng-repeat="tag in tags" ng-class="tag.tagged ? 'tagged': ''" ng-bind="tag.tag" ng-click="tagClick(tag)"></span>
        <span class="btn" ng-click="edit()" style="color:#f90;"><span class="glyphicon glyphicon-pencil"></span></span>
        <span class="btn" style="color:gray;"><a href="/ng/blog?id={{blog.cid}}" target="_blank"><span class="glyphicon glyphicon-link"></span></a></span>
    </div>

    <div ng-bind-html="blog.text | markdown" class="ng-blog"></div>
</script>

<script id="templates/edit.html" type="text/ng-template">

    <div class="edit-toolbar">
        <span ng-click="content()" class="btn" style="color: #84b76d;"> <span class="glyphicon glyphicon-inbox"></span> </span>
        <span ng-click="cancel(blog)" class="btn" style="color: gray;" ng-show="blog.cid !== 0"> <span class="glyphicon glyphicon-arrow-left"></span> </span>
        <span ng-click="save(blog)" class="btn" style="color:#f90;"> <span class="glyphicon glyphicon-ok"></span> </span>
    </div>

    <div id="textarea-wrap">
        <textarea ng-model="blog.text" class="form-control"></textarea>
    </div>

    <div class="edit-preview">
        <div ng-bind-html="blog.text | markdown" class="ng-blog-preview"></div>
    </div>
</script>