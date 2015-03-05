<?php
$batchDB['host'] = 'localhost';
$batchDB['user'] = 'root';
$batchDB['pwd']  = ($_SERVER['HTTP_HOST'] == 'memo.zenho.com' ? '123' : 'root');

$conn = mysql_connect( $batchDB['host'], $batchDB['user'], $batchDB['pwd'] ) OR die( 1 );
mysql_select_db('memorize', $conn) OR die( 1 );
mysql_query( "set character set 'utf8'" );

$uid = $_REQUEST['uid'];

$uid = $uid ? $uid : 1;



$sql = "SELECT * FROM item_type WHERE uid = $uid AND priority !=0 ORDER BY priority ASC";

$rows = mysql_query($sql, $conn);

$data = array();
while ( $row = mysql_fetch_array($rows, MYSQL_ASSOC) ) { 
    array_push($data, $row); 
} 

header("Access-Control-Allow-Origin: *");

echo json_encode($data); 

//end file
