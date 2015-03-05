<?php

$post = var_export($_POST, true);

file_put_contents("rows.txt", (__FILE__ .  '    post : ' . $post . "\n\n"), FILE_APPEND);

//end file
