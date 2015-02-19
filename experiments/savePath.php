<?php include '../php/header.inc.php';?>
<link rel="import" href="../elements/element-test.html">
<?php include '../php/postheader.inc.php';?>
<!-- content here-->
<body>
<div class="log"></div>
<svg width="1000" height="1000">
  <circle cx="50" cy="50" r="40" stroke="green" stroke-width="4" fill="yellow" />
  <path id="path" d="M20,20 L170,370 C150,460 380,180 270,190" stroke="green" stroke-width="1" fill="none"/>
</svg>
</body>
<?php include '../php/prefooterscripts.inc.php';?>
<script>

down = false;

$("body").on("touchstart mousedown", startInput)
$(window).on("touchmove mousemove", getInput)
$(window).on("touchend mouseup", endInput)


function startInput(e) {
  //$(".log").text(e.originalEvent.touches[0].pageX)
  xs = [e.pageX||e.originalEvent.touches[0].pageX];
  ys = [e.pageY||e.originalEvent.touches[0].pageY];
  ts = [0];
  last = e.timeStamp;
  down = true;
  dprof="M"+xs[0]+","+ys[0] + (xs.length>1?(" C" + (xs[0]+(xs[1]-xs[0])/3)+ "," +(ys[0]+(ys[1]-ys[0])/3)+" "):" Q");
  ddef ="M"+xs[0]+","+ys[0] + " C" + xs[0]+ "," + ys[0] + " ";
}

function getInput(e) {
  if(down) {
    e.preventDefault();
    xs.push(e.pageX||e.originalEvent.touches[0].pageX);
    ys.push(e.pageY||e.originalEvent.touches[0].pageY);
//    ts.push(e.timeStamp - last);
//    last = e.timeStamp
    var l = xs.length - 2;
    var a = getControlPoints(xs[l>0?l-1:0],ys[l>0?l-1:0],xs[l],ys[l],xs[l+1],ys[l+1],0.4)
    ddef += a[0]+","+a[1]+" "+xs[l]+","+ys[l]+ " " + a[2]+","+a[3]+" ";
    dprof = xs[xs.length-1]+","+ys[ys.length-1] + " " + xs[xs.length-1]+","+ys[ys.length-1];
    document.getElementById("path").setAttribute("d", ddef + dprof);
  }
}

function endInput(e) {
  //getInput(e);
  //log(ts);
  down = false;
  t16 = new Uint8Array(ts.length);
//  for(var i= 0; i < ts.length; i++) {
//    t16[i] = ts[i];
//  }
  chain = ts.reduce(function(prev, next, index){return prev + ("00"+next).slice(-3)}, "")
  t16.set(ts);
  //log(chain);
  //t bringt nicht viel, das fast immer 8 ms...
//  var d="M"+xs[0]+","+ys[0] + (xs.length>1?(" C" + (xs[0]+(xs[1]-xs[0])/3)+ "," +(ys[0]+(ys[1]-ys[0])/3)+" "):" Q");
//  
//  for(var i = 1; i<xs.length-1 ; i++) {
//    a = getControlPoints(xs[i-1],ys[i-1],xs[i],ys[i],xs[i+1],ys[i+1],0.4)
//    d+= a[0]+","+a[1]+" "+xs[i]+","+ys[i]+ " " + a[2]+","+a[3]+" ";
//  }
//  d+=xs[xs.length-1]+","+ys[ys.length-1] + " " + xs[xs.length-1]+","+ys[ys.length-1];
//  document.getElementById("path").setAttribute("d", d);
}

function getControlPoints(x0,y0,x1,y1,x2,y2,t){
  var d01=Math.sqrt(Math.pow(x1-x0,2)+Math.pow(y1-y0,2));
  var d12=Math.sqrt(Math.pow(x2-x1,2)+Math.pow(y2-y1,2));
  if(d01+d12===0) {return[x1, y1, x1, y1]}
  var fa=t*d01/(d01+d12);   // scaling factor for triangle Ta
  var fb=t*d12/(d01+d12);   // ditto for Tb, simplifies to fb=t-fa
  var p1x=x1-fa*(x2-x0);    // x2-x0 is the width of triangle T
  var p1y=y1-fa*(y2-y0);    // y2-y0 is the height of T
  var p2x=x1+fb*(x2-x0);
  var p2y=y1+fb*(y2-y0);  
  return [p1x,p1y,p2x,p2y];
}



uint8 = "";
for(var i = 1; i < 50; i++){
  //uint8 += String.fromCharCode(((i+16)%240)+16);
}
log(uint8)

//$.post("../php/saveByte.php", {uint8: String.fromCharCode(255)}, function(data) {log(data.charCodeAt(0));});

//String form charcode 0 seems forbidden;
</script>
<?php include '../php/footer.inc.php';?>
