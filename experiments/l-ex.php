<?php include '../php/header.inc.php';?>
<link rel="import" href="../elements/l-ex.html">
<link rel="import" href="../elements/l-data.html">
<link rel="import" href="../elements/l-eq.html">
<link id="mathCss" rel="stylesheet" href="../css/math.css">
<?php include '../php/postheader.inc.php';?>
<!-- content here-->
<h1>Example test</h1>
<l-ex>
  <q>Eine Kraft von <data v="F" z="300" e="N" form="v=zu"></data> wirkt während <data v="t_delta" z="30" e="s" form="wu"></data>. Wie gross ist der Impuls?</q>
  <br><br>
  <dfn v="p" f="F*t_delta" form="v=f=n=zu"></dfn>
</l-ex>
<l-ex>
  <q>Quadratische Gleichung <data v="a" z="4" e="N" form="v=zu"></data>; <data v="b" z="6" e="s" form="v=zu"></data>; <data v="c" z="-1" e="s" form="v=zu"></data>;</q>
  <data v="x" z="1" e="s" form="v=zu"></data>
  <!--dfn v="t" f="ax^2 + bx + c" form="v=f=n=zu"></dfn-->
  <br><br>
  <dfn v="t_1" f="(minus(b)+sqrt(b^2-4ac))/2a" form="v=f=n=zu"></dfn>
  <br><br>
  <dfn v="t_2" f="(minus(b)-sqrt(b^2-4ac))/2a" form="v=f=n=zu"></dfn>
  <br><br>
</l-ex>
<l-ex>
  <q><data v="t_delta" z="0.5" e="s" form="v=zu"></data>; <data v="v_vec" z="30" e="m/s" form="v=zu"></data>; <data v="a_vec" z="30" e="m/s^2" form="wu"></data></q>
  <br><br><dfn v="v_neu" f="(v_vec + a_vec*t_delta)/2" form="v=f=n=zu"></dfn>
</l-ex>
<?php include '../php/prefooterscripts.inc.php';?>
<script>
  var q = new Quantities();
  

</script>
<?php include '../php/footer.inc.php';?>
