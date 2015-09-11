<?php
//print_r($_SERVER);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Main</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/navbar.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Insta Bot</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a onclick="main()" href="#">Главная</a></li>
              <li ><a onclick="taskAdd()" href="#">Добавить задание</a></li>
              <li><a onclick="uploads()" href="#">Загрузки</a></li>
              <li><a onclick="clean()" href="#">Clear Error</a></li>
              
              
            </ul>

            
          </div>
        </div>
      </nav>
<script>
    function clean(){
      $("#mainComponent").fadeIn("slow");
      document.getElementById('mainFrame').src = 'clean.php';
  } 
  function main(){
      $("#mainComponent").fadeOut("slow");
      //$('#mainFrame').attr('src','/quest_add.php');
      //document.getElementById('mainFrame').src = '';
  } 
 function taskAdd(){
      //$('#mainFrame').attr('src','/quest_add.php');
      $("#mainComponent").fadeIn("slow");
      document.getElementById('mainFrame').src = 'task_add.php';
  }             
  function uploads(){
      $("#mainComponent").fadeIn("slow");
      document.getElementById('mainFrame').src = 'uploads.php';
  }
  function start(){
     var id = $("#num").val();
     var all = $( "#comp"+id+"" ).val();
     var key = $("#key").val();
     
     $.get("bot.php?task="+id+"&key="+key+"", function( data ) {
         $( "#id"+id+"" ).text( data );
         if(data == 'Task comlete'){
             clearInterval(timerid);
             clearTimeout(timerid);
         }
  
    });
    
     var timerid = setInterval(function() {
         $.get("bot.php?task="+id+"&key="+key+"", function( data ) {
         $( "#id"+id+"" ).text( data );
         if(data == 'Task comlete'){
             clearInterval(timerid);
             clearTimeout(timerid);
         }
  
    });
}, 3000);
        
  

      //alert($("#id1").val());
      
      //alert( data );

  }
  
   

</script>
      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
          <!--<h3>Статистика</h3>-->
          <p><h4>Задания</h4></p>
      <table border="1">
          <thead>
              <tr>
                  <td>Id Задания</td>
                  <td>Id записи</td>
                  <td>Выполнено</td>
                  <td>Всего</td>
                  
              </tr>
          </thead>
          <?php
          include 'mysql.php';
          $db = new SafeMySQL();
          $tasks = $db->getAll("SELECT * FROM tasks");
          
          for($i=0;$i<count($tasks);$i++){
              if($tasks[$i]['complete']>= $tasks[$i]['all']){
                  continue;
              }
              echo '<tr>';
              echo '<td>'.$tasks[$i][id].'</td>';
              echo '<td>'.$tasks[$i][messId].'</td>';
              echo '<td id="id'.$tasks[$i][id].'">'.$tasks[$i][complete].'</td>';
              echo '<td id="comp'.$tasks[$i][id].'">'.$tasks[$i][all].'</td>';
           
              echo '</tr>';
          }
          
          ?>
         
      </table>
      <br><br>
        <p>
            <input type="text" id="key" placeholder="Key">
            <br>
            <input type="text"  id="num" name="num" placeholder="Номер задания"><br>
            <a class="btn btn-lg btn-primary" onclick="start();"  role="button">Запуск</a>
            
            &nbsp;<a class="btn btn-lg btn-primary" href="#" id="stop" role="button">Остановить</a>
        </p>
      </div>
      
      <!--Подкгрузка фрейма -->
      <div id="mainComponent" style="display:none" class="jumbotron">
           <iframe id="mainFrame" src=""  width="100%" height="700px" seamless  allowTransparency>
            Ваш браузер не поддерживает плавающие фреймы!
           </iframe>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
