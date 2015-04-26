<!DOCTYPE html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
        <title>Loooping</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/initialize.css">
        <link rel="stylesheet" href="../css/loooping.css">
        <link rel="stylesheet" href="../css/icons.css">
        <script src="../js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script>window.jQuery || document.write('<script src="../js/vendor/jquery-1.11.1.min.js"><\/script>')</script>
    </head>
<body>
<!-- content here-->
<h1>hi</h1>
	<button id="11" class="led">Toggle Pin 11</button> <!-- button for pin 11 -->
	<button id="12" class="led">Toggle Pin 12</button> <!-- button for pin 12 -->
	<button id="13" class="led">Toggle Pin 13</button> <!-- button for pin 13 -->
<div class="result">
  
</div>
<?php include '../php/prefooterscripts.inc.php';?>
<script>
  
  $(document).ready(function(){
    $(".led").click(function(){
      var p = $(this).attr('id'); // get id value (i.e. pin13, pin12, or pin11)
      //$.get("http://192.168.178.39/", {pin:p}); // execute get request
      $.get("http://192.168.4.1/", {pin:p}); // execute get request
    });
  });
  
  time = $.now();
  function gV() {
    $.get("http://192.168.178.38/zumArduino", function(r) {
      
      dt = $.now()-time;
      time = $.now();
      $(".result").append(dt + " - " + r+"<br>");
      gV();
    }).fail(gV);

  };
  //gV();
  //setInterval(gV, 50);
</script>
</body>
</html>
