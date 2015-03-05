<?php    
require 'config.php'; 
require 'functions.php'; 

$uid = $_REQUEST['uid']; 
$cid = $_REQUEST['cid']; 
$sec = $_REQUEST['sec']; 


$sql = "SELECT ID FROM reading_time WHERE cid = $cid AND uid = $uid";
$rows = mysql_query($sql);

if (mysql_num_rows($rows) > 0) {
    $sql  = "UPDATE reading_time SET second = second + $sec WHERE cid = $cid AND uid = $uid";
} else {
    $sql  = "INSERT INTO reading_time (uid, cid, second) VALUES ($uid,$cid,$sec)";
}

//echo $sql;

mysql_query($sql); 

//end file
