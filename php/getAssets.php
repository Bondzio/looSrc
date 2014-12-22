<?php 
include 'start.inc.php';
$folders=array("img", "html", "video");
$assets = array();
foreach($folders as $folder) {
  $entries = scandir("../$folder");
  foreach($entries as $index=>$file){
    if(stripos($file, ".")>0) {
      $stat = stat("../$folder/$file");
      $stats = array("modified"=>date("Y.m.d H:i", $stat["mtime"]), "size"=>$stat["size"]);
      $assets[] = array("file"=> $file, "folder"=> $folder, "stats" => $stats);
    }
  }
}
echo json_encode($assets);
