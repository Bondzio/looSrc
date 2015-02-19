<?php
header('content-type: text/html; charset=utf-8');
include 'start.inc.php';

if(md5($_POST["code"]) !== "dec27e1fdd14887609b268b72f547b5c") {
  $response->add("error", "falscher Code im Localhost");
  $response->send();
  exit();
}

$task = $_POST["task"];
$path = $_POST["path"];
$content = isset($_POST["content"])?$_POST["content"]:"";


//backup
if($task !== "create" && $task !== "createImage" ) {
  $pathinfo = pathinfo($path);
  $dirname = $pathinfo["dirname"];
  $filename = $pathinfo["filename"];
  $extension = $pathinfo["extension"];
  $now = date("YmdHis");
  $response->add("log", $pathinfo);
  copy("../$path", "../archiv/auto/$dirname/$filename-$now.$extension");
}

//JSONinsert, JSONupdate, JSONdelete
if(substr($task, 0, 4) === "JSON") {
  $json = json_decode(file_get_contents("../$path"), true);
  
  if(substr($task, 4) === "replace") {
    $json = json_decode($content, true);
  }
  else if(substr($task, 4) === "insert") {
    $json[] = $content;
  }
  else {
    $key = $_POST["key"];
    $val = $_POST["value"];
    $response->add("log", $key);
    foreach($json as $index=>$obj) {
      if($obj[$key] == $val) {
        if(substr($task, 4) === "update") {
          $json[$index] = $content;
        }
        if(substr($task, 4) === "delete") {
          unset($json[$index]);
        }
      }
    }
  }
  file_put_contents("../$path", json_encode($json));
  $response->add($filename, $json);
}
//
else if ($task == "save") {
  file_put_contents("../$path", $content);
}
else if ($task == "create") {
  file_put_contents("../$path", $content);
}

//
else if ($task == "rename") {
  $newpath = $_POST["newpath"];
  rename("../$path", "../$newpath");
  //unlink("../$path");
}
else if ($task == "delete") {
  rename("../$path", "../archiv/auto/$path");
  //unlink("../$path");
}
else if ($task == "createImage") {
	$content = str_replace('data:image/png;base64,', '', $content);
	$content = str_replace(' ', '+', $content);
	$data = base64_decode($content);
	$success = file_put_contents("../$path", $data);
}

$response->send();