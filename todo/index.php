<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="manifest" href="manifest.json">
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
