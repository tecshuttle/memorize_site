<?php
$batchDB['host'] = 'localhost';
$batchDB['user'] = 'root';
$batchDB['pwd']  = 'tec007DB';

$conn = mysql_connect( $batchDB['host'], $batchDB['user'], $batchDB['pwd'] ) OR die( 1 );
mysql_select_db('memorize', $conn) OR die( 1 );
mysql_query( "set character set 'utf8'" );

$uid = $_REQUEST['uid'];

$sql = "SELECT * FROM users WHERE uid = $uid"; 

$rows = mysql_query($sql, $conn); 

$result = ''; 

if (mysql_num_rows($rows) === 0) {
    init_new_user_db($uid);
    $result = 'new user db ok!'; 
} else {
    prepare_user_db_for_download($uid); 
    $result = 'prepare user db for download!'; 
}

echo $result;

//end

function init_new_user_db($uid) {
    global $conn;

    // items
    $mtime = time();

    $play_mtime = date("Y-m-d", time());

    $item1 = "($uid, '这是一个紧要事项', '事项内容','bug','" . $play_mtime . "'," . $mtime . "),";
    $item2 = "($uid, '待办事项', '事项内容','todo','" . $play_mtime .  "'," . $mtime . "),";
    $item3 = "($uid, '备忘条目', '备忘内容','memo','" . $play_mtime . "'," . $mtime . "),";
    $item4 = "($uid, '这是一个填空题示例。请写出Tom的生日：', '19790312','quiz','" . $play_mtime . "'," . $mtime . "),";
    $item5 = "($uid, '这是一个选择题示例。Tom的是男生吗？', '是|不是|1','quiz','" . $play_mtime . "'," . $mtime . ")";

    $init_questions = "INSERT INTO questions (uid, question, answer, type, next_play_date, mtime) VALUES ";
    $init_questions .= $item1 . $item2 . $item3 . $item4 . $item5;

    file_put_contents("rows.txt", (__FILE__ . '   sql:'.$init_questions . "\n"), FILE_APPEND);

    mysql_query($init_questions, $conn); 

    // type 
    $type1 = "($uid, 'memo', 0, '000000', 0, 'add'),";
    $type2 = "($uid, 'bug', 0, 'bd362f', 0, 'add'),";
    $type3 = "($uid, 'todo', 0, 'DAA520', 0, 'add'),";
    $type4 = "($uid, 'quiz', 0, '0088CC', 0, 'add')";

    $init_item_type = "INSERT INTO item_type (uid, name, priority, color, fade_out, sync_state) VALUES ";
    $init_item_type .= $type1 . $type2 . $type3 . $type4;

    file_put_contents("rows.txt", (__FILE__ . '   sql:'.$init_item_type . "\n"), FILE_APPEND);

    mysql_query($init_item_type, $conn); 
} 

function prepare_user_db_for_download($uid) {
    global $conn;

    $questions = "UPDATE questions SET sync_state = 'add' WHERE uid = $uid";
    mysql_query($questions, $conn); 

    $item_type = "UPDATE item_type SET sync_state = 'add' WHERE uid = $uid";
    mysql_query($item_type, $conn); 
}

//end file
