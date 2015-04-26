<?php include '../php/header.inc.php';?>
<link rel="import" href="../elements/element-test.html">
<?php include '../php/postheader.inc.php';?>
<!-- content here-->
<h1>hi</h1>
<div class="result">
  
</div>
<?php include '../php/prefooterscripts.inc.php';?>
<script>
  time = $.now();
  function gV() {
    $.get("http://192.168.178.38/zumArduino", function(r) {
      
      dt = $.now()-time;
      time = $.now();
      $(".result").append(dt + " - " + r+"<br>");
      gV();
    }).fail(gV);

  };
  gV();
  //setInterval(gV, 50);
</script>
<?php include '../php/footer.inc.php';?>
