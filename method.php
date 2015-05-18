<?php
$batchDB['host'] = 'localhost';
$batchDB['user'] = 'root';
$batchDB['pwd']  = 'tec007DB';

$conn = mysql_connect( $batchDB['host'], $batchDB['user'], $batchDB['pwd'] ) OR die( 1 );
mysql_select_db('memorize', $conn) OR die( 1 );
mysql_query( "set character set 'utf8'" );

$uid = $_REQUEST['uid'];

$rows_json = stripslashes($_REQUEST['rows_json']);

file_put_contents("rows.txt", (__FILE__ .  '    ' . $rows_json), FILE_APPEND);

$logtxt = __FILE__ . "     uid: " . $uid . "\n";

if ($rows_json =='') {
    $result = array(
        'total' => 123456
    );

    echo json_encode($result);
    exit;
}

$rows = json_decode($rows_json);

$line = ""; 

$num = 0;
foreach ($rows as $k => $item) {

    $id             = $item->id;
    $question       = str_replace("'", "''", $item->question);
    $answer         = str_replace("'", "''", $item->answer);
    $explain        = str_replace("'", "''", $item->explain);
    $type_id        = $item->type_id;
    $next_play_date = $item->next_play_date;
    $familiar       = $item->familiar;
    $correct_count  = $item->correct_count;
    $create_date    = $item->create_date;
    $sync_state     = '';
    $mtime          = $item->mtime;


    //如果提交的记录id，网站没有记录，可能是同步时漏了，重新添加，
    $sql = "SELECT * FROM questions WHERE _id = $id AND uid = $uid";  

    $rs = mysql_query($sql, $conn); 

    if (mysql_numrows($rs) == 0) {
        $sync_state = 'add';
    }

    if ($sync_state == 'add') {
        if (mysql_numrows($rs) == 0) {
            $sync_state = '';
        }

        $sql = "INSERT INTO questions (_id, uid, question, answer, `explain`, type_id, "
            . "next_play_date, familiar, correct_count, create_date, sync_state, mtime) "
            . "VALUES ($id, $uid, '$question', '$answer', '$explain', '$type_id', "
            . "'$next_play_date', $familiar, $correct_count, '$create_date', '$sync_state', $mtime)";  

    } else {
        $sql = "UPDATE questions SET "
            . "question = '$question', answer = '$answer', `explain` = '$explain', "
            . "type_id = '$type_id', next_play_date = '$next_play_date', familiar = $familiar, "
            . "correct_count = $correct_count, mtime = $mtime "
            . "WHERE `_id` = $id AND uid = $uid";  
    }

    file_put_contents("rows.txt", (__FILE__ .  '    ' . $sql), FILE_APPEND);

    mysql_query($sql, $conn); 

    $logtxt .= $sql . "\n";
}

$result = array(
    'success' => 'ok',
    'total' => count($rows)
);

$logtxt .= 'total : ' . count($rows). "\n\n";

file_put_contents("rows.txt", $logtxt, FILE_APPEND);

echo json_encode($result);

//end file
