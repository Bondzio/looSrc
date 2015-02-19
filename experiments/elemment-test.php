<?php include '../php/header.inc.php';?>
<link rel="import" href="../elements/element-test.html">
<?php include '../php/postheader.inc.php';?>
<!-- content here-->
<h1>hi</h1>
<element-test c="000" d="4"></element-test>
<?php include '../php/prefooterscripts.inc.php';?>
<script>
  $(document).ready( function() {
    $("element-test")[0].e = "yai!";
    log($("element-test").prop("c"));
    $("element-test").attr("c",7);
    $("element-test").prop("f",122);
    setTimeout(function() {log($("element-test").attr("c"));}, 0);
  })
  
  //script here
  //log("console says hi, too.")
</script>
<?php include '../php/footer.inc.php';?>
