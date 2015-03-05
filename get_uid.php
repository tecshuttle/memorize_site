<?php
$batchDB['host'] = 'localhost';
$batchDB['user'] = 'root';
$batchDB['pwd']  = 'root';

$conn = mysql_connect( $batchDB['host'], $batchDB['user'], $batchDB['pwd'] ) OR die( 1 );
mysql_select_db('memorize', $conn) OR die( 1 );
mysql_query( "set character set 'utf8'" );

$name = $_REQUEST['name'];
$pwd = $_REQUEST['pwd'];


$sql = "SELECT uid FROM users WHERE name = '$name' AND pwd = '$pwd'";  

$rs = mysql_query($sql, $conn); 

$uid = 0;
if (mysql_numrows($rs) == 0) {
    //
} else {
    $row = mysql_fetch_array($rs, MYSQL_ASSOC);
    $uid =  $row['uid'];
}

$result = $name . '|' . $uid. '|login'; 

echo $result;

file_put_contents("rows.txt", (__FILE__ . '   name:'.$name .'   pwd:'. $pwd . '   result:' . $result . "\n"), FILE_APPEND);

//end file
