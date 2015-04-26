<?php include '../php/header.inc.php';?>
<link rel="import" href="../elements/element-test.html">
<link id="mathCss" rel="stylesheet" href="../css/math.css">
<?php include '../php/postheader.inc.php';?>
<!-- content here-->
<h1>hi</h1>
<span style="display: inline-block;">1</span>    <span style="display: inline-block; position: relative; width: 2em;">b
  <span class='divisionbar' style='width:3em; position:absolute;'><svg height='1em' width='3em' viewBox='0 0 3 1'><line x1='0' y1='0.65' x2='3' y2='0.65' style='stroke:currentColor;stroke-width:0.005em'/></line></svg></span><span style="display: inline-block;  position: absolute; left:0; top:0.5em"><span style="display: inline-block; position:relative; font-size:0.7em">2<span style="display: inline-block;  position: absolute; left:0; top:0.5em"><span style="display: inline-block;  font-size:0.7em">4</span></span></span></span></span>
<br><br>


<span class='term'>
<span class="operator divide" style="width:0.8049999999999999em;">
  <span class="divisionbar" style="width:0.8049999999999999em;">
    <svg height="1em" width="0.8049999999999999em" viewBox="0 0 0.8049999999999999 1">
      <line x1="0" y1="0.65" x2="0.8049999999999999" y2="0.65" style="stroke:currentColor;stroke-width:0.0028em">
      </line>
    </svg>
  </span>
  <span class="arg1 fracUp" style="top: -0.548029em; left: 0.14em;">
    <span class="enumerator" style="font-size: 0.7em">
      <span class="operator divide" style="width:0.7612499999999999em">
        <span class="divisionbar" style="width:0.7612499999999999em;">
          <svg height="1em" width="0.7612499999999999em" viewBox="0 0 0.7612499999999999 1">
          <line x1="0" y1="0.65" x2="0.7612499999999999" y2="0.65" style="stroke:currentColor;stroke-width:0.0028em">
          </line>
          </svg>
        </span>
        <span class="arg1 fracUp" style="top: -0.548029em; left: 0.13999999999999996em;">
          <span class="enumerator" style="font-size: 0.7em">
            <span class="operator divide" style="width:0.67375em">
              <span class="divisionbar" style="width:0.67375em;">
                <svg height="1em" width="0.67375em" viewBox="0 0 0.67375 1">
                <line x1="0" y1="0.65" x2="0.67375" y2="0.65" style="stroke:currentColor;stroke-width:0.0028em">
                </line>
                </svg>
              </span>
              <span class="arg1 fracUp" style="top: -0.4em; left: 0.13999999999999999em;">
                <span class="enumerator" style="font-size: 0.7em">
                  <span class="number">
                  5</span>
                </span>
              </span>
              <span class="arg2 fracDown" style="top: 0.40280000000000005em; left: 0.13999999999999999em;">
                <span class="denominator" style="font-size: 0.7em">
                  <span class="number">
                  6</span>
                </span>
              </span>
            </span>
          </span>
        </span>
        <span class="arg2 fracDown" style="top: 0.40280000000000005em; left: 0.18374999999999994em;">
          <span class="denominator" style="font-size: 0.7em">
            <span class="number">
            7</span>
          </span>
        </span>
      </span>
    </span>
  </span>
  <span class="arg2 fracDown" style="top: 0.5596em; left: 0.161875em;">
    <span class="denominator" style="font-size: 0.7em">
      <span class="openpar">
      (
      </span>
      <span class="operator divide" style="width:0.67375em">
        <span class="divisionbar" style="width:0.67375em;">
          <svg height="1em" width="0.67375em" viewBox="0 0 0.67375 1">
          <line x1="0" y1="0.65" x2="0.67375" y2="0.65" style="stroke:currentColor;stroke-width:0.0028em">
          </line>
          </svg>
        </span>
        <span class="arg1 fracUp" style="top: -0.4em; left: 0.13999999999999999em;">
          <span class="enumerator" style="font-size: 0.7em">
            <span class="number">
            7</span>
          </span>
        </span>
        <span class="arg2 fracDown" style="top: 0.40280000000000005em; left: 0.13999999999999999em;">
          <span class="denominator" style="font-size: 0.7em">
            <span class="number">
            8</span>
          </span>
        </span>
      </span>
      <span class="closepar">
      )
      </span>
    </span>
  </span>
</span
</span>
  
  
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
