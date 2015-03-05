<?php
include 'auth.php';

header("Access-Control-Allow-Origin: *");

$batchDB['host'] = 'localhost';
$batchDB['user'] = 'root';
$batchDB['pwd'] = ($_SERVER['HTTP_HOST'] == 'memo.zenho.com' ? '123' : 'root');

$conn = mysql_connect($batchDB['host'], $batchDB['user'], $batchDB['pwd']) OR die(1);
mysql_select_db('memorize', $conn) OR die(1);
mysql_query("set character set 'utf8'");

$uid = get_uid();

// get user all types 
$t_sql = "SELECT id, name, color FROM item_type WHERE uid = $uid AND priority !=0";
$type_rows = mysql_query($t_sql, $conn);

$type = array();
while ($row = mysql_fetch_array($type_rows, MYSQL_ASSOC)) {
    array_push($type, array('type_id' => $row['id'], 'type' => $row['name'], 'color' => $row['color']));
}

// get user used types
$q_sql = "SELECT COUNT(1) AS count, q.type_id, t.name AS type, t.color FROM questions AS q LEFT JOIN item_type AS t ON (q.type_id = t.id) "
    . "WHERE q.uid = $uid AND t.uid = $uid AND t.priority !=0 GROUP BY q.type_id ORDER BY count DESC";
$question_rows = mysql_query($q_sql, $conn);


$data = array();
while ($row = mysql_fetch_array($question_rows, MYSQL_ASSOC)) {
    array_push($data, $row);
}

// add unused type into data array
foreach ($type as $t) {

    $used = false;

    foreach ($data as &$d) {
        if ($d['type_id'] === $t['type_id']) {
            $used = true;
        }
    }

    if (!$used) {
        $t['count'] = 0;
        array_push($data, $t);
    }
}

header("Access-Control-Allow-Origin: *");

echo json_encode($data);

//end file
