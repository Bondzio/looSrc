<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
  </head>
  <body>
    <h1>Web Experiments</h1>
    <ul>
    <?php
      $files = scandir("./");
      foreach($files as $index=>$file){
        if($index>1 && stripos($file, ".")>0) {
          echo "<li><a href='$file'>$file</a></li>";
        }
        else {
          echo "<li><a href='$file/index.php'>$file</a></li>";
        }
      }
    ?>
    </ul>
  </body>
</html>
