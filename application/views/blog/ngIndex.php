<div ng-view></div>

<script id="templates/home.html" type="text/ng-template">
    <div class="ng-tag">
        <span><a href="#/edit/0">New</a></span>
        <span ng-repeat="tag in tags" ng-class="tag.tagged ? 'tagged': ''" ng-bind="tag.tag + ' ' + tag.total" ng-click="tagClick(tag)"></span>
    </div>

    <div class="ng-blog">
        <p ng-repeat="blog in blogs">
            <a href="#blog/{{blog.cid}}">{{blog.title}} </a>
        </p>
    </div>
</script>

<script id="templates/blog.html" type="text/ng-template">
    <div class="ng-tag">
        <span><a href="#/">content</a></span>
        <span ng-repeat="tag in tags" ng-class="tag.tagged ? 'tagged': ''" ng-bind="tag.tag" ng-click="tagClick(tag)"></span>
        <span><a href="#/edit/{{blog.cid}}">edit</a></span>
    </div>

    <div ng-bind-html="blog.text | markdown" class="ng-blog"></div>
</script>

<script id="templates/edit.html" type="text/ng-template">

    <div class="edit-toolbar">
        <span ng-click="cancel(blog)" class="btn">
            <span class="glyphicon glyphicon-arrow-left"></span>
        </span>

        <span ng-click="save(blog)" class="btn">
            <span class="glyphicon glyphicon-ok"></span>
        </span>
    </div>

    <div id="textarea-wrap">
        <textarea ng-model="blog.text" class="form-control"></textarea>
    </div>

    <div class="edit-preview">
        <div ng-bind-html="blog.text | markdown" class="blog-content"></div>
    </div>
</script>


