<?php
header('content-type: text/html; charset=utf-8');

session_save_path("../session_temp");

session_start();
$_SESSION['Text'] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis nunc eu ut elit eget adipiscing facilisis turpis.";
phpinfo();
?>