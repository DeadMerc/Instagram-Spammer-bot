<?php

/*
 * @autor:Maxim Milchakov
 * @link:vk.com/max7771
 * @date:02 2015 
 */

include_once 'mysql.php';
$db = new SafeMySQL();
if(!empty($_GET['key'])){
    $si = $db->getRow("SELECT * FROM access WHERE key_num = ?s",$_GET['key']);
    if(!$si){
        die('Access denied. I want ban your ip, yes?');
    }else{
        $user_id = $si['id'];
    }
}else{
    die('Where key?');
}
$db->query("DELETE FROM users_used WHERE key_id = ?i",$user_id);
$db->query("DELETE FROM users WHERE key_id = ?i",$user_id);
$db->query("DELETE FROM comments WHERE key_id = ?i",$user_id);
$db->query("DELETE FROM proxy WHERE key_id = ?i",$user_id);

echo 'DB cleaned';