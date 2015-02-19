<?php include '../php/header.inc.php';?>
<style>
  body {padding: 1em;}
  .slideshow h1 {display: inline-block; font-size: 1.5rem; margin: 0 0 1em 0;}
  .slide .comment {font-size: 1rem;}
  .part {display: inline-block; margin-right: 1.5em; text-align: center;}
</style>
<?php include '../php/postheader.inc.php';?>
<!-- content here-->
<!--<object class="objTemplate" CLASSID="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" height="320" CODEBASE="http://www.apple.com/qtactivex/qtplugin.cab">
    <param name="autoplay" value="true">
    <param name="loop" value="true">
    <param name="controller" value="false">
    <embed src="<?php echo '../video/' . $file;?>" height="320" autoplay="true" loop="true" controller="false" pluginspage="http://www.apple.com/quicktime/"></embed>
</object>-->

<div class="slideshow">
  <h1>Quanten</h1>
  <button class="rw"><i class='icon icon-chevron-left'></i></button>
  <button class="fwd"><i class='icon icon-chevron-right'></i></button>
  <div class="slide">
    <div class="part" style="width: 100%;">
      <div class='comment'>Wie kann man sich einen Quant vorstellen?</div>
      <iframe width="100%" height="400px" src="../experiments/threeJS/QuantRotating.html"></iframe>
    </div>
  </div>
</div>
<?php include '../php/prefooterscripts.inc.php';?>
<script>

  var slideshow = {
    div: $(".slideshow"),
    activeIndex: 5,
    get numSlides() {
      return this.div.find(".slide").length;
    },
    fwd: function() {
      this.activeIndex = (this.activeIndex+1) % this.numSlides;
      this.render();
    },
    rw: function() {
      this.activeIndex = max(this.activeIndex-1, 0);
      this.render();
    },
    render: function() {
      log("hi");
      this.div.find(".slide").hide();
      this.div.find(".slide").eq(this.activeIndex).show();
    }
  };
  $(window).on("keydown", function(e) {if(e.which == 39 || e.which==40) {slideshow.fwd();}});
  $(".fwd").on("click", slideshow.fwd.bind(slideshow));
  $(".rw").on("click", slideshow.rw.bind(slideshow));
  
  
  var files = [
    {w: 320, h: 480, comment: "Phase als Farbe statt als komplexe Zahl", file: "Quanten-UniGraz-100 Phase als Farbe statt als komplexe Zahl.mov"}, 
    {w: 320, h: 480, comment: "Welle mit Farbe als Phase", file: "Quanten-UniGraz-100 Welle mit Farbe als Phase.mov"},
    {w: 320, h: 480, comment: "Quant als Wellenpaket", file: "Quanten-UniGraz-107 Schnelles Wellenpaket.mov"}, 
    {w: 320, h: 480, comment: "Interferenz als Farbmischung", file: "Quanten-UniGraz-101 Farbmischung.mov"}, 
    {w: 320, h: 480, comment: "Betrag als Helligkeit", file: "Quanten-UniGraz-101 Farbmischung1.mov"}, 
    {w: 320, h: 480, comment: "Interferenz von Wellen unterschiedlicher Wellenlänge", file: "Quanten-UniGraz-102 Interferenz von Wellen.mov"}, 
  //{w: 320, h: 480, comment: "Double Slit z", file: "Quanten-UniGraz-103 Double Slit z.mov"}, 
    {w: 320, h: 480, comment: "Doppelspalt mit Farbquanten", file: "Quanten-UniGraz-103 DoubleSlit.mov"}, 
    {w: 320, h: 480, comment: "Doppelspalt je nach Wellenlänge", file: "Quanten-UniGraz-103 Doppelspalt je nach Wellenlaenge.mov", loop: "palindrome"},
    {w: 320, h: 480, comment: "Reflexion an Wand", file: "Quanten-UniGraz-110 Reflexion an Wand.mov"},
    {w: 320, h: 480, comment: "Wovon hängt die Wellenlänge eines Quants ab?", file: "Quanten-UniGraz-108 Verschiedene Impulse.mov"}, 
    {w: 720, h: 480, comment: "Wellenpakete unterschiedlicher Masse", file: "Quanten-UniGraz-107 Wellenpakete unterschiedlicher Masse.mov"}, 
    {w: 320, h: 480, comment: "Superposition verschiedener Impulse", file: "Quanten-UniGraz-109 Superposition verschiedener Impulse.mov"}, 
    {w: 320, h: 480, comment: "Zerfliessen eines Wellenpakets (Impuls unscharf)", file: "Quanten-UniGraz-114 Zerfliessen eines Wellenpakets (Impuls unscharf).mov"},
    {w: 320, h: 480, comment: "Wellenpaket wenig zerfliessend<br>(Impuls genau bekannt, aber Ort nicht)", file: "Quanten-UniGraz-107 Wellenpaket wenig zerfliessend (Impuls genau bekannt, aber Ort nicht).mov"},
    {w: 320, h: 480, comment: "Wellenpaket stark zerfliessend<br>(Impuls ungenau bekannt)", file: "Quanten-UniGraz-107 Wellenpaket stark zerfliessend (Impuls ungenau bekannt).mov", sameSlide: true},
    //{w: 320, h: 480, comment: "Wellenpakete unterschiedlicher Masse", file: "Quanten-UniGraz-107 Wellenpakete unterschiedlicher Masse.mov"}, 
    {w: 320, h: 480, comment: "Ort oder Impuls scharf", file: "Quanten-UniGraz-115 Ort vs Impuls scharf.mov", loop: "palindrome"}, 
    {w: 320, h: 480, comment: "Im Kräftefeld", file: "Quanten-UniGraz-120 wurfpar-klass.mov"}, 
    {w: 320, h: 480, comment: "Kleines Teilchen im Kräftefeld", file: "Quanten-UniGraz-120 wurfpar-kleinquant.mov"}, 
    {w: 320, h: 480, comment: "Elektron in der Nähe einesd Atomkerns<br>(Coulomb Orbit)", file: "Quanten-UniGraz-200 Coulomb Orbit.mov"}, 
    {w: 320, h: 480, comment: "Orbital Kreis gross (n=59)", file: "Quanten-UniGraz-202 Orbital Kreis gross n 59.mov"}, 
    {w: 320, h: 480, comment: "Orbital Kreis mittel (n=7)", file: "Quanten-UniGraz-202 Orbital Kreis mittel 7.mov"}, 
    {w: 320, h: 480, comment: "Orbital Kreis klein (n=1)", file: "Quanten-UniGraz-202 Orbital Kreis klein.mov"}, 
    {w: 320, h: 480, comment: "Radiale Knoten", file: "Quanten-UniGraz-208 Radiale Knoten.mov"}, 
    {w: 480, h: 480, comment: "Gegenläufige Wellen", file: "Quanten-UniGraz-209 Superposition-2-pm1.mov"}, 
    {w: 480, h: 480, comment: "Gegenläufige Wellen (n=3)", file: "Quanten-UniGraz-209 Superposition-4-pm3.mov"}, 
    {w: 480, h: 480, comment: "Superposition Gallery", file: "Quanten-UniGraz-215 Superposition Gallery.mov"}, 
    //{w: 320, h: 480, comment: "Isosurface Hydrogen 11-5-3", file: "Quanten-UniGraz-210 Isosurface Hydrogen 11-5-3.mov"}, 
    {w: 320, h: 480, comment: "Angeregtes Wasserstoffatom (11,5,3)", file: "Quanten-UniGraz-210 slice-horiz-hydrogen-11-5-3.mov"}, 
    {w: 320, h: 480, comment: "Angeregtes Wasserstoffatom (11,5,3)", file: "Quanten-UniGraz-210 slice-vert-hydrogen-11-5-3.mov"}, 
    {w: 320, h: 480, comment: "Typische Orbitale", file: "Quanten-UniGraz-220 Orbitale 242-320.mov"}, 
    {w: 320, h: 480, comment: "Übergang (3,1,0 -> 4,2,1)<br>Änderung des Drehimpulses mit polarisiertem Photon", file: "Quanten-UniGraz-222 TransitionCircular310-421.mov"}
  ];
  
  var $mov = $("<object CLASSID='clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B' CODEBASE='http://www.apple.com/qtactivex/qtplugin.cab'>"+
    "<param name='autoplay' value='true'><param name='loop' value='true'><param name='controller' value='false'>"+
    "<embed autoplay='true' height='320' loop='true' controller='false' scale='aspect' pluginspage='http://www.apple.com/quicktime/'></embed></object>");
  
  for(f=0; f<files.length; f++) {
    if(!files[f].sameSlide) {
      $(".slideshow").append("<div class='slide'></div>");
    }
    $slide = $(".slideshow").find(".slide").last();
    $part = $("<div class='part'></div>").appendTo($slide);
    $("<div class='comment'>"+ files[f].comment + "</div>").appendTo($part);
    $newMov = $mov.clone();
    $newMov.find("embed").attr("src", "../video/" + files[f].file).attr("width", files[f].w);
    if(files[f].loop == "palindrome") {$newMov.find("embed")[0].setAttribute("loop", "palindrome");}
    //if(files[f].scale == "palindrome") {$newMov.find("embed")[0].setAttribute("loop", "palindrome");}
    $newMov.appendTo($part);
  }
  
  slideshow.render();

</script>
<?php include '../php/footer.inc.php';?>
