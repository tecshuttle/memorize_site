<?php
header("Access-Control-Allow-Origin: *");

if (isset($_COOKIE['uid'])) {
    $uid = $_COOKIE['uid'];
} else {
    if ($_REQUEST['devMode'] === 'true') {
        $uid = 1;
    } else {
        echo json_encode(array('ret_code' => -1, 'msg' => 'no login'));
        exit;
    }
}

//配置数据库
$batchDB['host'] = 'localhost';
$batchDB['user'] = 'root';
$batchDB['pwd'] = ($_SERVER['HTTP_HOST'] == 'memo.zenho.com' ? '123' : 'tec007DB');

$conn = mysql_connect($batchDB['host'], $batchDB['user'], $batchDB['pwd']) OR die(1);
mysql_select_db('memorize', $conn) OR die(1);
mysql_query("set character set 'utf8'");

//获取post参数
$color = $_REQUEST['color'];
$fade_out = $_REQUEST['fade_out'];
$id = $_REQUEST['_id'];
$name = $_REQUEST['type_name'];
$priority = $_REQUEST['priority'];
$sync_state = $_REQUEST['sync_state'];

//id为0则新增记录
if ($id == 0) {
    $sql = "INSERT INTO item_type (uid, name, priority, color, fade_out) "
        . "VALUES ($uid, '$name', $priority, '$color', $fade_out)";
} else {
    $sql = "UPDATE item_type SET "
        . "name = '$name', priority = $priority, color = '$color', fade_out = $fade_out "
        . ($sync_state == 'add' ? '' : " , sync_state = 'modify' ")
        . "WHERE `id` = $id";
}

mysql_query($sql, $conn);

$rec_id = mysql_insert_id();

$result = array(
    'sql' => $sql,
    'id' => ($rec_id == 0 ? $id : $rec_id),
    'ret' => true
);

echo json_encode($result);

//end file
