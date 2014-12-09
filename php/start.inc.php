<?php
function __autoload($class){        //Laden von Klassen
    $path = "classes/" . $class . ".class.php";
    if(file_exists($path)){
        require_once($path);
    }
    else{
        if(ERRORS){
            die("Klassendatei <strong>$path</strong> konnte nicht gefunden werden");
        }
    }
}

include_once 'Response.class.php';
include_once 'config.inc.php';
$response = new Response();

//Error Handler
/* @TODO noch anpassen */
function getErrorHandler($errno,$errmsg,$filename,$linenum) {
  global $response;
  $zeit = date("Y-m-d H:i:s", time()). "\n";
  $error = $filename . ":" . $linenum . " ";
  $error .= $errmsg;
  if(isset($_SESSION["errorcount"])) {
    $_SESSION["errorcount"] += 1;
  }
  else {
    $_SESSION["errorcount"] = 0;
  }
  
  $response->add("error", $error);
}

set_error_handler("getErrorHandler");
?>
