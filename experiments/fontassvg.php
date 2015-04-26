<?php include '../php/header.inc.php';?>
<link id="mathCss" rel="stylesheet" href="../css/math.css">
<?php include '../php/postheader.inc.php';?>
<!-- content here-->
<h1>hi</h1>
<div id="test">a</div>
<?php include '../php/prefooterscripts.inc.php';?>
<script>
  $(document).ready( function() {
    $.get("../css/webfonts/DroidSerif-Regular-webfont.svg", function(d) {
      var cs = window.getComputedStyle($("#test")[0], null);
      var fontsize = parseFloat(cs.getPropertyValue('font-size'));
      var hem = $("#test").height()/fontsize;
      var $svgfont = $(d);
      var unitsPerEm = $svgfont.find("font-face").attr("units-per-em");
      var ascent = -$svgfont.find("font-face").attr("ascent") * 1.1;
      var mb = 1.1*$svgfont.find("font-face").attr("descent")/unitsPerEm;
      var a = $svgfont.find("glyph[unicode=a]").attr("d");
      var q = $svgfont.find("glyph[unicode=q]").attr("d");
      var d = $svgfont.find("glyph[unicode=d]").attr("d");
      var aw = +$svgfont.find("glyph[unicode=a]").attr("horiz-adv-x");
      var qw = +$svgfont.find("glyph[unicode=q]").attr("horiz-adv-x");
      var dw = +$svgfont.find("glyph[unicode=d]").attr("horiz-adv-x");
      document.getElementById("test").innerHTML += "<svg style='vertical-align:baseline; margin-bottom:"+mb+"em;' height='1.1em' width='"+(aw/unitsPerEm)+"em' viewBox = '0 "+ascent+" "+aw+" "+(unitsPerEm*1.1)+"'><path transform='scale(1 -1)' d='"+a+"' fill='black'></path></svg>";
      document.getElementById("test").innerHTML += "<svg style='vertical-align:baseline; margin-bottom:"+mb+"em;' height='1.1em' width='"+(qw/unitsPerEm)+"em' viewBox = '0 "+ascent+" "+qw+" "+(unitsPerEm*1.1)+"'><path transform='scale(1 -1)' d='"+q+"' fill='black'></path></svg>";
      document.getElementById("test").innerHTML += "<svg style='vertical-align:baseline; margin-bottom:"+mb+"em;' height='1.1em' width='"+(dw/unitsPerEm)+"em' viewBox = '0 "+ascent+" "+dw+" "+(unitsPerEm*1.1)+"'><path transform='scale(1 -1)' d='"+d+"' fill='black'></path></svg>";
    })
  })
</script>
<?php include '../php/footer.inc.php';?>
