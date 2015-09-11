<meta charset="UTF-8">
<?php
/*
 * @autor:Maxim Milchakov
 * @link:vk.com/max7771
 * @date:02 2015 
 */
include 'mysql.php';
$db = new SafeMySQL();

if (!empty($_POST['messId'])and ! empty($_POST['all'])) {
    if (!empty($_POST['key'])) {
        $si = $db->getRow("SELECT * FROM access WHERE key_num = ?s", $_POST['key']);
        if (!$si) {
            die('Access denied. I want ban your ip, yes?');
        } else {
            $user_id = $si['id'];
        }
    } else {
        die('Where key?');
    }
    $data = array('messId' => $_POST['messId'], 'all' => $_POST['all'], 'key_id' => $user_id);
    $is = $db->query("INSERT INTO tasks SET ?u", $data);
    if ($is) {
        echo 'Успешно добавлено, добавить ещё?<br>';
    }
}
?>
<form method="POST" action="">
    Key<br>
    <input type="text" value="<?=$_GET['key']?>" name="key" placeholder="Ключ доступа"><br>
    MessID<br>
    <input type="text" name="messId" placeholder="Id сообщения инста"><br>
    All<br>
    <input type="text" name="all" placeholder="Кол-во сообщений"><br>
    <input type="submit" value="Submit">
</form>
