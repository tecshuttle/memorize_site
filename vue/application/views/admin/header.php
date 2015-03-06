<!Doctype html>
<html xmlns=http://www.w3.org/1999/xhtml>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <meta http-equiv=Content-Type content="text/html;charset=utf-8">
    <title><?=$msg?></title>
    <base href="<?=$base_url?>">

    <?php foreach($css as $cssFile):?>
        <link rel="stylesheet" type="text/css" href="<?=$cssFile?>" />
    <?php endforeach;?>

    <script type="text/javascript">
        //var uploadUserName = "ijobsadmin";
        //var department = "部门";
        //var isAdmin = false; //true;
        //var isAllApp = true;
        //var roleInfo = {'roleName':'超级管理员', 'appsName':''};
        //var userRole = [];//用户所属业务
        //var isGeneralVersion = false;
        //var basePath = 'http://127.0.0.1:8080/tms2web/';
        //var url = window.encodeURIComponent(basePath);
    </script>

</head>

<body>