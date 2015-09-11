<meta charset="UTF-8">
<?php
/*
 * @autor:Maxim Milchakov
 * @link:vk.com/max7771
 * @date:02 2015 
 */

include 'mysql.php';
$db = new SafeMySQL();

if(!empty($_POST['key'])){
    $si = $db->getRow("SELECT * FROM access WHERE key_num = ?s",$_POST['key']);
    if(!$si){
        die('Access denied. I want ban your ip, yes?');
    }else{
        $user_id = $si['id'];
    }
}else{
    die('Where key?');
}

$uploaddir = 'uploads/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
$i = 0;
$b = 0;
echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    //echo "Файл корректен и был успешно загружен.\n";
    $name = $_FILES['userfile']['name'];
    //echo $name;
    if (file_exists($uploaddir . $name)) {


        $f = fopen($uploaddir . $name, "r");

        // Читать построчно до конца файла
        while (!feof($f)) {
            if (preg_match('/@/', fgets($f))) {
                //echo fgets($f) . "<br />"; 
                $text = fgets($f);
                //$isit = $db->getAll("SELECT id FROM comments WHERE text=?s",$text);
                //print_r($isit);
                //if (empty($isit)) {
                    $is = $db->query("INSERT INTO comments SET text=?s,key_id=?i ",fgets($f),$user_id);
                    if ($is) {
                        // успешное добавление
                        $i++;
                    }
                //} else {
                    //счётчик который уже есть
                   // $b++;
                //}
            } else {
                echo('Не найдено @ в сообщении.');
            }
        }

        fclose($f);
    } else {
        echo 'Ошибка открытия / загрузки файла.';
    }
} else {
    //echo "Возможная атака с помощью файловой загрузки!\n";
}

//echo 'Некоторая отладочная информация:';
//print_r($_FILES);
echo 'Успешно добавлено:' . $i . ' строк.<br>';
//echo 'Повторное добавление:'.$b;
print "</pre>";
