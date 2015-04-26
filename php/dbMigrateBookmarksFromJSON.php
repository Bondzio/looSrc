<?php
header('content-type: text/html; charset=utf-8');
include 'start.inc.php';

//if(md5($_POST["code"]) !== "dec27e1fdd14887609b268b72f547b5c") {
//  $response->add("error", "falscher Code im Localhost");
//  $response->send();
//  exit();
//}

header("Content-Type: text/html; charset=utf-8");
define('DBUSER', 'u259909164_looop');
define('DBNAME', 'u259909164_loodb');
define('DBPASSWORD', 'XsTVUeq36dnoNihB');
include_once 'classes/Database.class.php';
$db = new Database();

$json = json_decode(file_get_contents("../cms/webbookmarks.json"), true);
foreach($json as $b) {
  $title = $b['title'];
  $href = $b['href'];
  $details = isset($b['details'])?$b['details']:"";
  $labels =  isset($b['labels'])?$b['labels']:"";
  $status = isset($b['status'])?$b['status']:"";
  $mod = isset($b['mod'])?$b['mod']:0;
  $add = isset($b['add'])?$b['add']:0;
  if(stripos($labels, "40 W")!==false) {
  //echo "INSERT INTO bookmarksPhysics (title, href, details, labels, status, modified, added) VALUES ($title, $href, $details, $labels, $status, $mod, $add)<br>";
  }
  $db->query("INSERT INTO bookmarksWeb (title, href, details, labels, status, modified, added) VALUES (;0,;1,;2,;3,;4,;5,;6)", $title, $href, $details, $labels, $status, $mod, $add);
}
//

//
//$test = $db->query("SELECT * FROM test");

?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
  </head>
  <body id="b">
  hi

  <script>
//<?php
//while($t = $test->fetch_assoc()) {
//  //var_dump($t);
//  echo "o=".json_encode($t)."; document.getElementById('b').innerHTML += 'hi' + o.content + '<br>';";
//}
////?>
    
  </script>
  </body>






