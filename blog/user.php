<?php
require 'config.php'; 
require 'functions.php'; 

require('./templates/class_template.php');    
$path = './templates/';    
$tpl = & new Template($path);    

session_start(); 

$uid = $_REQUEST['uid'];

//用户信息
$sql  = "SELECT * FROM users where uid = $uid"; 
$rows = mysql_query($sql, $conn);
$user = mysql_fetch_array($rows); 
$tpl->set('user', $user);    

//看过的文章
$sql  = "SELECT c.cid, c.title, t.second FROM reading_time as t left join contents as c on (t.cid = c.cid) where t.uid = $uid"; 
$rows = mysql_query($sql, $conn);
$tpl->set('read_blog_list', $rows);    

$tpl->set('ga', $ga);  //google analytics   
echo $tpl->fetch('user.tpl.php');    

//end file
