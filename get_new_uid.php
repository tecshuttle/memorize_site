<?php
$batchDB['host'] = 'localhost';
$batchDB['user'] = 'root';
$batchDB['pwd']  = 'root';

$conn = mysql_connect( $batchDB['host'], $batchDB['user'], $batchDB['pwd'] ) OR die( 1 );
mysql_select_db('memorize', $conn) OR die( 1 );
mysql_query( "set character set 'utf8'" );

$name = $_REQUEST['name'];
$pwd = $_REQUEST['pwd'];


$sql = "SELECT uid FROM users WHERE name = '$name'";  

$rs = mysql_query($sql, $conn); 

$uid = 0;

if (mysql_numrows($rs) == 0) {
    $sql = "insert into users (name, pwd) values ('$name', '$pwd')";  
    mysql_query($sql, $conn); 
} 

$uid = mysql_insert_id();

$result = $name . '|' . $uid. '|register'; 

echo $result;

file_put_contents("rows.txt", (__FILE__ . '   name:' . $name . '   pwd:' . $pwd . '   result:' . $result . "\n"), FILE_APPEND);

//end file
