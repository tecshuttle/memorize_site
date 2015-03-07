<?php
require 'config.php'; 
require 'functions.php'; 
require 'verycd_title.php'; 

require('./templates/class_template.php');    
$path = './templates/';    
$tpl = & new Template($path);    

if (isset($_SESSION['uid'])) {
    header('location:./list.php'); 
}

$sql  = "SELECT count(*) AS total FROM contents"; 
$rows = mysql_query($sql, $conn);
$blog_num = mysql_fetch_array($rows);

$sql  = "SELECT count(*) AS total FROM users"; 
$rows = mysql_query($sql, $conn);
$user_num = mysql_fetch_array($rows);

$tpl->set('return', $_REQUEST['return']);    
$tpl->set('blog_num', $blog_num['total']);    
$tpl->set('user_num', $user_num['total']);    

$tpl->set('verycd_title', $verycd_title);    

$tpl->set('ga', $ga);  //google analytics   

echo $tpl->fetch('welcome.tpl.php');    

//end file
