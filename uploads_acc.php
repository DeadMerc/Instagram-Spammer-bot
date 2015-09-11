<meta charset="UTF-8">
<?php
/*
 * @autor:Maxim Milchakov
 * @link:vk.com/max7771
 * @date:02 2015 
 */


//die('Developed');
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
            //if (preg_match('/:/', fgets($f))) {
                //echo fgets($f) . "<br />"; 
                $text = fgets($f);
                //$isit = $db->getAll("SELECT id FROM comments WHERE text=?s",$text);
                //print_r($isit);
                //if (empty($isit)) {
                $text = explode(':', $text);
                if(empty($text[0]) or empty($text[1])){
                    continue;
                }
                    $is = $db->query("INSERT INTO users SET login=?s,pass=?s,key_id=?i",$text[0],$text[1],$user_id);
                    if ($is) {
                        echo $text[0].':'.$text[1].'<br>';
                        // успешное добавление
                        $i++;
                    }
                //} else {
                    //счётчик который уже есть
                   // $b++;
                //}
            //} else {
            //    echo('Не найдено : в аккаунте.');
            //}
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
