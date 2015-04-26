<?php include '../php/header.inc.php';?>
<link rel="import" href="../elements/element-test.html">
<script type="text/javascript" src="../js/libs/fontChecker.js"></script>
<link id="mathCss" rel="stylesheet" href="../css/math.css">
<?php include '../php/postheader.inc.php';?>
<!-- content here-->
<h1>Mathtest</h1>
<input id="eq"><button id="ok">OK</button>
<br>
<!--label><input type="range" value=75 min=0 max=100 data-scale=0.01 data-for="term1.rOpt.fracReducer"/>fracReducer = <span>12</span></label><br>
<label><input type="range" value=50 min=0 max=200 data-scale=0.01 data-for="term1.rOpt.fracUpStandard"/>fracUp = <span>12</span></label><br>
<label><input type="range" value=50 min=0 max=200 data-scale=0.01 data-for="term1.rOpt.fracDownStandard"/>fracDown = <span>12</span></label><br>
<label><input type="range" value=50 min=0 max=200 data-scale=0.01 data-for="term1.rOpt.fracNestOverlap"/>fracNestOverlap = <span>1</span></label><br>
<label><input type="range" value=0 min=-100 max=100 data-scale=0.001 data-for="term1.rOpt.fracBarOffset"/>fracBarOffset = <span>12</span></label><br-->
<br>
<div id="output"></div>
<span class="term term1"></span> = <span class="result1"></span> This is result number one<br>This is result number one<br>
<span class="term term2"></span> = <span class="result2"></span><br><br>
<?php include '../php/prefooterscripts.inc.php';?>
<script type="text/javascript">
  
  var term1 = new Term("(minus(b)+sqrt(b^2-4ac))/2a", $(".term1"), $(".result1"));
  var term2 = new Term("1/(y^2+v_vec^`2)", $(".term2"), $(".result2"));
  
  setTimeout(function() {term1.update(); term2.update();}, 100);
//  var fd = new Detector()
//  log("Arial", fd.detect("Arial"))
//  log("Cambria", fd.detect("Cambria"))
//  log("uijiurr", fd.detect("kndrjnbrg"))
//  log("Latin Modern Roman 10", fd.detect("Latin Modern Roman 10"))
  
  //log(term.output);
  //setTimeout(function() {term.parse("7/5"); term.render($(".term"));}, 100);
  $("#ok").on("click", function() {term1.update({termstring: $("#eq").val()});});
  $("input[type=range]").on("change", function() {term1.update();});

</script>
<?php include '../php/footer.inc.php';?>