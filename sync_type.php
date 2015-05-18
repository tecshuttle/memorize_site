<?php
$batchDB['host'] = 'localhost';
$batchDB['user'] = 'root';
$batchDB['pwd']  = 'tec007DB';

$conn = mysql_connect( $batchDB['host'], $batchDB['user'], $batchDB['pwd'] ) OR die( 1 );
mysql_select_db('memorize', $conn) OR die( 1 );
mysql_query( "set character set 'utf8'" );

$uid = $_REQUEST['uid'];

$sql = "SELECT * FROM item_type WHERE uid = '$uid' AND sync_state <> ''";  

$rows = mysql_query($sql, $conn); 

$data = array();

while ( $row = mysql_fetch_array($rows, MYSQL_ASSOC) ) { 
    array_push($data, $row); 
}

$result = 'NA'; 

if (count($data) > 0) {
    $result = json_encode($data); 
}

file_put_contents("rows.txt", (__FILE__ . '   uid:'.$uid . '   result:' . $result . "\n"), FILE_APPEND);

$sql = "UPDATE item_type SET sync_state = '' WHERE uid = $uid";  

$rows = mysql_query($sql, $conn); 

echo $result;


//end file
