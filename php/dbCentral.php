<?php
header("Content-Type: text/html; charset=utf-8");
include 'start.inc.php';

if(md5($_POST["code"]) !== "dec27e1fdd14887609b268b72f547b5c") {
  $response->add("error", "falscher Code im Localhost");
  $response->send();
  exit();
}

$task = $_POST["task"];
$table = $_POST["table"];
$values = isset($_POST["values"])?$_POST["values"]:"";

$db = new Database();

if($task == "INSERT") {
  $values = $_POST["values"];
  foreach($values as $row) {
    if(isset($_POST["unique"])) {
      $try = $db->query("SELECT * FROM $table WHERE " . $_POST["unique"] . "=;0", $row[$_POST["unique"]]);
      if($try->fetch_assoc()) {
        $response->add("message", "Title exists already!");
        continue;
      }
    }
    $q1 = "INSERT INTO $table (" . implode(",", array_keys($row)) . ") VALUES (";
    for($i = 0; $i < count($row); $i++) {
      $q1 .= ";" . $i . ($i < count($row)-1 ? ", " : ")"); // ;0, ;1, ...)
    }
    $queryargs = array_merge(array($q1), array_values($row));
    call_user_func_array(array($db, "query"), $queryargs);
    $response->add("message", $db->affected_rows() == 1 ? "insert ok!" : "not found");
  }
}

if($task == "UPDATE") {
  foreach($values as $row) {
    $q1 = "UPDATE $table SET ";
    $i = 0;
    $newValues = array();
    foreach($row["newValues"] as $key => $val) {
      $q1 .= $key . "=;" . $i . ($i < count($row["newValues"])-1 ? ", " : " "); // z.B. title=;0, href=;1, ...)
      $newValues[] = $val;
      $i++;
    }
    $q1 .= " WHERE " . $row["key"] . " = ;" . $i; 
    $queryargs = array_merge(array($q1), $newValues, array($row["value"]));
    call_user_func_array(array($db, "query"), $queryargs);
    $response->add("message", $db->affected_rows() == 1 ? "update ok!" : "not found");
  }
}

if($task == "DELETE") {
  $values = $_POST["values"];
  foreach($values as $row) {
    $db->query("DELETE FROM $table WHERE " . $row["key"] . "=;0", $row["value"]);
    $response->add("message", $db->affected_rows() == 1 ? "successfully deleted!" : "not found");
  }
}

if($task == "CUSTOM") {
  $db->query($_POST["statement"]);
}

if($task == "getJson") {
  $columns = isset($_POST["columns"])?$_POST["columns"]:"*";
  $where = isset($_POST["where"])?(" WHERE " . $_POST["where"]):"";
  $q = $db->query("SELECT " . $columns . " FROM $table" . $where);
  $arr = array();
  while($r = $q->fetch_assoc()) {$arr[] = $r;}
  echo json_encode($arr);
  exit();
}

//$response->add("log", "ok");
$response->send();