<?php
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
$batchDB['pwd'] = ($_SERVER['HTTP_HOST'] == 'memo.zenho.com' ? '123' : 'root');

$conn = mysql_connect($batchDB['host'], $batchDB['user'], $batchDB['pwd']) OR die(1);
mysql_select_db('memorize', $conn) OR die(1);
mysql_query("set character set 'utf8'");

//只插入偶数记录
mysql_query("SET @@auto_increment_offset=2");
mysql_query("SET @@auto_increment_increment=2");

//获取post参数
$id = $_REQUEST['_id'];
$type_id = $_REQUEST['type_id'];
$question = $_REQUEST['question'];
$answer = $_REQUEST['answer'];
$explain = $_REQUEST['explain'];
$sync_state = $_REQUEST['sync_state'];
$mtime = isset($_REQUEST['mtime']) ? $_REQUEST['mtime'] : '';

//id为0则新增记录
$today = date('Y-m-d', time());
$time = time();

if (!empty($mtime)) {
    $sql = "UPDATE questions SET mtime = $mtime, sync_state = 'modify' WHERE `_id` = $id AND uid = $uid";
} else if ($id == 0) {
    $sql = "INSERT INTO questions (uid, question, answer, `explain`, type_id, next_play_date, mtime) "
        . "VALUES ($uid, '$question', '$answer', '$explain', $type_id, '$today', $time)";
} else {
    $sql = "UPDATE questions SET "
        . "question = '$question', answer = '$answer', `explain` = '$explain', type_id = $type_id, mtime = $time "
        . ($sync_state == 'add' ? '' : " , sync_state = 'modify' ")
        . "WHERE `_id` = $id AND uid = $uid";
}

$db_result = mysql_query($sql, $conn);

$rec_id = mysql_insert_id();

$result = array(
    'sql' => $sql,
    'id' => ($rec_id == 0 ? $id : $rec_id),
    'ret' => true
);

header("Access-Control-Allow-Origin: *");

echo json_encode($result);

//end file
