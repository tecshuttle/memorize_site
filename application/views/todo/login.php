<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Todo List</title>

    <link rel="stylesheet" href="/css/bootstrap-3.1.1/css/bootstrap.min.css">

    <style>
        body {
            margin: 1em;
            padding: 15px 0px 10px 0;
            font-size: 12px;
        }

        #todo-week {
            width: 98%;
            margin: 0 auto;
        }

        .connectedSortable {
            width: 14.2857%;
            min-height: 10em;
            list-style-type: none;
            float: left;
            border-radius: 4px;
        }

        .day_title {
            width: 14.2857%;
            float: left;
            padding: 0 0 0 5px;
            font-weight: bold;
        }

        .today {
            color: deeppink;
        }

        .connectedSortable li {
            margin: 5px 0;
            cursor: pointer;
            text-align: justify;
        }

        .connectedSortable span {
            float: right;
        }

        .connectedSortable:hover {
            background-color: ghostwhite;
        }

        .connectedSortable li:hover, pre:hover {
            color: hotpink;
        }

        .ui-sortable {
            padding: 0 5px 10px 5px;
        }

        .done_job {
            color: #ddd;
        }

        .ui-state-highlight {
            width: 100%;
            height: 1.5em;
            border: dotted 2px #ddd;
            background: transparent;
        }

        .badge {
            padding: 2px 4px;
            font-size: 0.8em;
            background-color: #ddd;
            border-radius: 7px;
        }

        .day_job_time {
            margin-left: 5em;
        }

        .form-control {
            height: 26px;
            padding: 6px 7px;
            font-size: 12px;
        }

        .form-horizontal .control-label {
            padding-top: 4px;
        }

        .form-group {
            margin-bottom: 8px
        }

        .modal-header {
            padding: 7px 15px;
        }

        .modal-footer {
            margin-top: 0px;
            padding: 11px 20px 11px;
        }

        .modal-body {
            padding: 10px 20px;
        }

        .popover-content {
            padding: 5px 7px
        }

        .popover {
            border-radius: 5px;
        }

        #todo-backlog {
            border: 1px solid #ddd;
            height: 3em;
            clear: both;
            width: 100%;
        }
    </style>

</head>

<body>

<div class="col-xs-12 col-sm-12" style="text-align: center;">
    <h2> Simple Todo List</h2>

    <h2> 时间，看起来多，用起来少！ </h2>
</div>


<form action="/user/login_submit" method="post">
    <div class="form-group">
        <input type="email" class="form-control" name="email" placeholder="请您输入用户名">
    </div>

    <div class="form-group">
        <input type="password" class="form-control" name="pwd" placeholder="请您输入密码">
    </div>

    <button type="submit" class="col-xs-12 col-sm-12 btn btn-primary">登录</button>
</form>

<br/> <br/> <br/>

<a href="/user/register" class="col-xs-4 col-sm-4 btn btn-link">立即注册</a>
<span class="col-xs-4 col-sm-4 "></span>
<a href="" class="col-xs-4 col-sm-4 btn btn-link">忘记密码？</a>

</body>

<script src="/js/jquery-1.11.1.min.js"></script>
<script src="/css/bootstrap-3.1.1/js/bootstrap.min.js"></script>

</html>