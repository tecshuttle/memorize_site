<?php
$lastCode = 89;

$versionCode = $_REQUEST['versionCode'];

$result = 'already newest version.';

if ($versionCode < $lastCode) {
    $result = 'update';
} 

echo $result;

file_put_contents("rows.txt", (__FILE__ .  '    user version : ' . $versionCode . '     current version : ' . $lastCode . '    result : ' . $result . "\n\n"), FILE_APPEND);

//end file
