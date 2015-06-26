<div ng-view></div>

<script id="templates/home.html" type="text/ng-template">
    <p ng-repeat="blog in blogs">
        <a href="#blog/{{blog.cid}}">{{blog.title}} </a>
    </p>
</script>

<script id="templates/blog.html" type="text/ng-template">
    <div ng-bind-html="blog.text | markdown"></div>
</script>


