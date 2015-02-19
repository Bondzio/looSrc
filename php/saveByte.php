<?php
header('content-type: text/html; charset=utf-8');
include 'start.inc.php';

$uint8 = $_POST["uint8"];

$pack="";

//foreach($uint8 as $i) {
//  $pack .= pack("C", $i);
//}

file_put_contents("../experiments/uint8.txt", $uint8);

//$unpack = array();
//while(strlen($pack) > 0) {
//  $next = substr($pack, 0, 1);
//  echo unpack("C", $next)[1];
//  $pack = substr($pack, 1);
//}
//
echo $uint8;