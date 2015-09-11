

<meta charset="utf-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
    function setAll(){
        
        $("#key").val($("#key_data").val());
        $("#key1").val($("#key_data").val());
        $("#key2").val($("#key_data").val());
    }
</script>
<input type="text" id="key_data" value="<?=$_GET['key']?>"  onchange="setAll()" placeholder="Key">
<br>
<br>
<form enctype="multipart/form-data" action="uploads_acc.php" method="POST">
    <input type="hidden" value="<?=$_GET['key']?>" id="key" name="key">
    Отправить файл c аккаунтами: <input name="userfile"  type="file" />
    <input type="submit" value="Send File" /><br>
</form>    
<form enctype="multipart/form-data" action="uploads_com.php" method="POST">  
    <input type="hidden" value="<?=$_GET['key']?>" id="key1" name="key">
    Отправить файл c комментами: <input name="userfile" type="file" />
    <input type="submit" value="Send File" />
</form>
<form enctype="multipart/form-data" action="uploads_proxy.php" method="POST"> 
    <input type="hidden" value="<?=$_GET['key']?>" id="key2" name="key">
    Отправить файл c прокси: <input name="userfile" type="file" />
    <input type="submit" value="Send File" />
</form>
<?php

