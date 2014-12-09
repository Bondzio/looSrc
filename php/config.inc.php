<?php
  define('HOST', '');

  define('PATHTOSERVER', 'http://' . $_SERVER["SERVER_NAME"]);
  define('SERVER', $_SERVER["SERVER_NAME"]); 

  //Siteroot: 
  $siteroot = substr(substr($_SERVER["REQUEST_URI"], 1), 0, strpos(substr($_SERVER["REQUEST_URI"],1), "/"));
  if($siteroot == "php") {$siteroot = "";}
  define('SITEROOT', $siteroot);

  if ($siteroot !== "") {$siteroot = "/" . $siteroot;}
  define('FULLURL', PATHTOSERVER . $siteroot);
  
