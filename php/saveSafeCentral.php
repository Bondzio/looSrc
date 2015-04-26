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

//JSONreplace, JSONinsert, JSONupdate, JSONdelete, 
if(substr($task, 0, 4) === "JSON") {
  $json = json_decode(file_get_contents("../$path"), true);
  if(substr($task, 4) === "replace") {$json = json_decode($_POST["content"]);}
  
  if(substr($task, 4, 8) === "multiple") {
    $itemarray = json_decode($_POST["itemarray"], true);
    foreach($itemarray as $i=>$item) {
      jsonTasks($json, substr($task, 12), $item);
    }
  }
  else {
    $obj = array(
      "key"=> isset($_POST["key"]) ? $_POST["key"] : null,
      "value" => isset($_POST["value"]) ? $_POST["value"] : null,
      "content" => isset($_POST["content"]) ? $_POST["content"] : null);
    jsonTasks($json, substr($task, 4), $obj);
  }
  $success = file_put_contents("../$path", json_encode($json));
  $response->add("log", "ok" . $success);
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

function jsonTasks(&$json, $task, $obj) {
  global $response;
  if($task === "insert")  {
    if(isset($_POST["uniquetitle"])) {
      foreach($json as $index=>$next) {
        if($json[$index]["title"] === $obj["content"]["title"]) {
          $response->add("message", "Title exists already!");
          $response->send();
          exit();
        }
      }
    }
    $json[] = $obj["content"];
  }
  if($task === "update" || $task === "delete") {
    foreach($json as $index=>$next) {
      if($json[$index][$obj["key"]] === $obj["value"]) {
        if($task === "update") {$json[$index] = $obj["content"];}
        if($task === "delete") {array_splice($json, $index, 1);}
      }
    }
  }
  return $json;
}