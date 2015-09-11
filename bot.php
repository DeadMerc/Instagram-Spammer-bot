
<?php

/*
 * @autor:Maxim Milchakov
 * @link:vk.com/max7771
 * @date:02 2015 
 */

include 'mysql.php';
include 'functions.php';
$db = new SafeMySQL();
//Auth
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

if (!empty($_GET['task'])) {
    $task = $_GET['task'];
} else {
    die('Where task?');
}
$task = $db->getAll("SELECT * FROM tasks WHERE id = ?i AND key_id = ?s", $task,$user_id);
$task = $task[0];
if ($task) {
//print_r($task);
    if ($task['complete'] < $task['all']) {
        
    } else {
        die('Task comlete');
    }
    //$user = $db->getAll("SELECT * FROM users WHERE complete <'4' ");
    $user = $db->getAll("SELECT * FROM users WHERE key_id = ?s",$user_id);
    for($i=0;$i<count($user);$i++){
        $is_it = $db->getAll("SELECT * FROM users_used WHERE login = ?s and messId = ?i AND key_id = ?s",$user[$i]['login'],$task['messId'],$user_id);
        if(empty($is_it)){
            $user = $user[$i];
            //print_r($user);
            $to_bd = array('messId'=>$task['messId'],'login'=>$user['login'],'key_id'=>$user_id);
            // ВРЕМЕННО не использовать для одной записи
            //$db->query("INSERT INTO users_used SET ?u",$to_bd);
            break;
        }
    }
    //$user = $user[0];
    $user['complete']++;
    $db->query("UPDATE users SET complete=?i WHERE id = ?i AND key_id = ?s", $user['complete'], $user['id'],$user_id);
    $login = $user['login'];
    $pass = $user['pass'];

    $in = new InstaBot($user_id);
    $in->getKey();
    $testStatus = $in->getStatus();
    if(!$testStatus){
        //echo ;
        die($testStatus);
    }

    //echo $in->Auth($login, $pass);
    //print_r($login . ':' . $pass);
    if(empty($login) or empty($pass)){
        die('Not found accounts.');
    }
    $testAuth = $in->Auth($login, $pass);
    if (preg_match('/true/', $testAuth)) {
        $answer = $in->sendMess($task['messId'], $names);
        
        //print_r($answer);
        if($answer == 'ok'){
            $task['complete'] ++;
            $db->query("UPDATE tasks SET complete=?i WHERE id = ?i AND key_id = ?s", $task['complete'], $task['id'],$user_id);
            echo $task['complete'];
        }else{
            echo $answer;
        }
        
    } elseif(preg_match('/false/', $testAuth)) {
        // DEBUG
        //print_r($login . ':' . $pass);
        var_dump($testAuth);
        echo 'Bad login or password,user with Login:'.$login.' deleted in DB.';
        //ВРЕМЕННО
        $db->query("DELETE FROM users WHERE login=?s and pass=?s AND key_id = ?s", $login,$pass,$user_id);
    }else{
        var_dump($testAuth);
    }
} else {
    echo 'Not Found Task';
}