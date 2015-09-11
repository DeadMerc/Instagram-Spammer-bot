<?php

/*
 * @autor:Maxim Milchakov
 * @link:vk.com/max7771
 * @date:02 2015 
 */
$start = microtime(true);

require './threads.php';

$threads = new Threads;
if(empty($_GET['all']) or empty($_GET['task'])){
    echo $_GET['all'].':'.$_GET['task'];
    die('Not all<br>');
}
for ($i=0;$i<$_GET['all'];$i++) {
    $threads->newThread('bot.php?', array('task' => $_GET['task']));
}

while (false !== ($result = $threads->iteration())) {
    if (!empty($result)) {
        echo $result."<br>";
    }
}

$end = microtime(true);
echo "Execution time ".round($end - $start, 2)."<br>";

?>