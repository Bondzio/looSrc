<?php include '../php/header.inc.php';?>
<link rel="import" href="../elements/element-test.html">
<script type="text/javascript" src="../js/libs/fontChecker.js"></script>
<style>
  body {padding:1em; 
        font-family: Calibri;
        font-family: Cambria Math;
        font-family: "Latin Modern Roman 10";
        font-family: Asana;
        font-family: Open Sans;
        font-family: Droid Serif;
        font-family: Cambria;
        }
  
  .term {position:relative;
    line-height: 1.2;
    white-space: nowrap;
  }
  
  .number { word-spacing: -0.07em; white-space: nowrap; }
  
  .term span {display: inline-block;
    /*background-color: rgba(0,0,255,0.01);outline: 1px solid gray;*/
  }
  .term svg {position:relative;}
  
  .operator__sign {margin: 0 0.2em;}
  .operator__sign.multiplyImplicit {margin: 0 0.05em;}
  
  .enumerator {vertical-align: text-bottom;}
  .denominator {vertical-align: text-top;}
  
  .enumerator>.openpar:first-child {display:none;}
  .enumerator>.closepar:last-child {display:none;}
  .denominator>.openpar:first-child {display:none;}
  .denominator>.closepar:last-child {display:none;}
  .exponent>.openpar:first-child {display:none;}
  .exponent>.closepar:last-child {display:none;}
  
  .exponent {vertical-align: text-bottom;}
  
  .symbol {font-style: italic; /*padding-right: 0.15em; margin-right: 0;*/ }
  
</style>


<?php include '../php/postheader.inc.php';?>
<!-- content here-->
<h1>Mathtest</h1>
<input id="eq"><button id="ok">OK</button>
<!--<div id="tokens"><BR>
    <span class="r">R
      <span class="a up">up
        <span class="r">R
          <span class="a up">up</span>
          <span class="a down">down</span>
          ..
        </span>
      </span>
      <span class="a down">down</span>
      Here we go on... ............. ............. . ................ ............. ...........
    </span>
  </div>-->
<br>
<!--<label><input type="range" value=75 min=0 max=100 data-scale=0.01 data-for="parser.rOpt.fracReducer"/>fracReducer = <span>12</span></label><br>
label><input type="range" value=50 min=0 max=200 data-scale=0.01 data-for="parser.rOpt.fracUp"/>fracUp = <span>12</span></label><br>
<label><input type="range" value=50 min=0 max=200 data-scale=0.01 data-for="parser.rOpt.fracDown"/>fracDown = <span>12</span></label><br
<label><input type="range" value=0 min=-100 max=100 data-scale=0.001 data-for="parser.rOpt.fracBarOffset"/>fracBarOffset = <span>12</span></label><br>-->
<br>
<div id="output"></div>
<span class="term term1"></span> = <span class="result1"></span> This is result number one<br>This is result number one<br>
<span class="term term2"></span> = <span class="result2"></span><br><br>
<?php include '../php/prefooterscripts.inc.php';?>
<script type="text/javascript">
  
  var parser1 = new Parser("1/8", $(".term1"), $(".result1"));
  var parser2 = new Parser("1/(y^2+v_vec^2)", $(".term2"), $(".result2"));
  
  var fd = new Detector()
  log("Arial", fd.detect("Arial"))
  log("Cambria", fd.detect("Cambria"))
  log("uijiurr", fd.detect("kndrjnbrg"))
  log("Latin Modern Roman 10", fd.detect("Latin Modern Roman 10"))
  
  //log(parser.output);
  //setTimeout(function() {parser.parse("7/5"); parser.render($(".term"));}, 100);
  $("#ok").on("click", function() {parser1.update({termstring: $("#eq").val()});});
  $("input[type=range]").on("change", function() {parser1.update();});
//  $(document).ready( function() {
////    var parsed2 = math.parse('sqrt(x^2 + x/4 + 3*sin(60))');
////    //logNodes(parsed2);
////    //log(parsed2);
////    
////    var parser = new Parser();
////    parser.parse("9.81e3*5/2");
////    log(parser.output);
////    
////    var parser = new Parser();
////    parser.parse("sqrt(x^2 + x/4 + 3*sin(60))");
////    log(parser.output);
////    
////    var parser = new Parser();
////    parser.parse("v_878_{zuzuz}*5");
////    log(parser.output);
//    
//    
//    
////      $("#tokens").empty();
////      for(var i=0; i<parser.tokens.length; i++) {
//        var p = parser.tokens[i];
//        $("#tokens").append("<span style='margin: 0.2em; border: 1px solid blue' title='"+p.type+"'>"+p.string+"</span>")
//      }
//      $("#output").empty();
//      for(var i=0; i<parser.output.length; i++) {
////        var p = parser.output[i];
////        $("#output").append("<div style='margin: 0.2em; border: 1px solid blue' title='"+p.type+"'>"+JSON.stringify(p)+"</div>")
////      }
//      //log(parser.tree);
//    });
//    
//    //$.publish("endofready"); log("endready");
//  })
//  
//  function logNodes(node) {
//    if(node.type == "FunctionNode") {
//      log("Function: " + node.name);
//      node.args.forEach(logNodes);
//    }
//    else if(node.type == "OperatorNode") {
//      log("Operator: " + node.op + " " + node.fn);
//      node.args.forEach(logNodes);
//    }
//    else if(node.type == "ConstantNode") {
//      log("Constant: " + node.value + " " + node.valueType);
//    }
//    else if(node.type == "SymbolNode") {
//      log("Symbol: " + node.name);
//    }
//    else {
//      log("Other Nodetype: " + node.type);
//    }
//  }
</script>
<?php include '../php/footer.inc.php';?>
