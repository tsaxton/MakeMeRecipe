<?php
require('databaselogin.php');
if(array_key_exists('recipe',$_GET) && array_key_exists('user',$_GET)){
    $sql = "INSERT INTO recipelist (userid, searchid, favorited) VALUES ({$_GET['user']}, '{$_GET['recipe']}', 1)";
    //echo $sql;
    $ret = mysql_query($sql);
    if($ret){
	echo "success";
    }
    else{
	echo "failed";
    }
}
else{
    echo "failed";
}
