<?php include '../php/header.inc.php';?>
<script type="text/javascript" src="../js/libs/htmlToCanvas.js"></script>
<?php include '../php/postheader.inc.php';?>
<!-- content here-->
<h1>Font Metrics</h1>
<canvas id="c" width="400" height="400"></canvas>
<?php include '../php/prefooterscripts.inc.php';?>
<script>
  var cwidth = 400;
  var cheight = 400;  
  
var c=document.getElementById("c");
var ctx=c.getContext("2d");

rasterizeHTML.drawHTML('<style>*{font-size:100px;margin:0;padding:0;}</style><span style="font-family: Cambria; padding:20px;"><i>f</i></span>', c).then(getData);

function getData(){
  var cwidth = 400;
  var cheight = 400;
  log("hiho");
  var imageData = ctx.getImageData(0, 0, cwidth, cheight);
  var data = imageData.data;
  //log("d", data);
  pos=0;
  while (pos < data.length) {
    if(data[pos+3] >0 ) {
      var top = Math.floor(pos/(cwidth*4)); break;
    }
    pos += 4;
  }
  pos=data.length-4;
  while (pos >= 0) {
    if(data[pos+3] >0 ) {
      var bottom = Math.ceil(pos/(cwidth*4)); break;
    }
    pos=pos-4;
  }
  log(top, bottom);
  ctx.moveTo(60,top);
  ctx.lineTo(60, bottom);
  ctx.stroke();
}

//var data = '<svg xmlns="http://www.w3.org/2000/svg" width="400" height="400">' +
//           '<foreignObject width="100%" height="100%">' +
//           '<div xmlns="http://www.w3.org/1999/xhtml" style="font-size:100px">' +
//             '<span style="font-family: Open Sans">x</span>' +
//           '</div>' +
//           '</foreignObject>' +
//           '</svg>';
//
//var DOMURL = window.URL || window.webkitURL || window;
//
//var img = new Image();
//var svg = new Blob([data], {type: 'image/svg+xml;charset=utf-8'});
//var url = DOMURL.createObjectURL(svg);
//
//img.onload = function () {
//  ctx.drawImage(img, 0, 0);
//   // grabbing image data
//  var imageData = ctx.getImageData(0, 0, cwidth, cheight);
//  var data = imageData.data;
//  // calculating top
//  var top = 0;
//  var pos = 0;
//  while (pos < data.length) {
//    if (data[pos + 3]) {
//      pos -= pos % (cwidth * 4); // back to beginning of the line
//      top = (pos / 4) / cwidth; // calculate pixel position
//      log(top);
//      break;
//    }
//    pos += 4;
//  } 
//  // calculating bottom
//  var bottom = 0;
//  var pos = data.length;
//  while (pos > 0) {
//    if (data[pos + 3]) {
//    pos -= pos % (cwidth * 4); // back to beginning of the line
//    bottom = (pos / 4) / cwidth;
//    bottom -= offsety - fontSize;
//    pos = 0; // exit loop
//    }
//    pos -= 4;
//  }
//  // calculating left
//  DOMURL.revokeObjectURL(url);
//}
//
//img.src = url;
//
////ctx.font="100px Cambria";
////ctx.fillText("=-+xFg",100,100);
////
////ctx.font="30px Verdana";
////// Create gradient
////var gradient=ctx.createLinearGradient(0,0,c.width,0);
////gradient.addColorStop("0","magenta");
////gradient.addColorStop("0.5","blue");
////gradient.addColorStop("1.0","red");
////// Fill with gradient
////ctx.fillStyle=gradient;
////ctx.fillText("Big smile!",10,90);
//
//(function() {
//var fontFamily = "Arial, sans-serif";
//var fontSize = 14;
//getFontMetrics = function(props) {
//    var ctx = props.ctx;
//    var text = props.text;
//    var bboxHeight = props.bboxHeight;
//    var canvasHeight = props.canvasHeight;
//    var baseline = props.baseline || "alphabetic";
//    var flip = props.flip || false;
//    var drawBaseline = props.drawBaseline || false;
//    if (props.fontFamily) fontFamily = props.fontFamily;
//    if (props.fontSize) fontSize = props.fontSize;
//    // setting up the canvas
//    ctx.save(); // create canvas to use as buffer
//    ctx.font = fontSize + "px " + fontFamily;
//    var textWidth = ctx.measureText(text).width;
//    // This keeps font in-screen, measureText().width doesn't
//    // quite do it in some cases. For instance "j", or the letter "f"
//    // in the font "Zapfino".
//    var offsetx = fontSize * 2;
//    var offsety = fontSize * 2;
//    var cwidth = ctx.canvas.width = Math.round(textWidth + offsetx * 2);
//    var cheight = ctx.canvas.height = canvasHeight ? canvasHeight : Math.round(offsety * 2);
//    if (typeof(baseline) == "string") {
//        offsety = 0; // using <canvas> baseline
// ctx.textBaseline = baseline;
// }
// // ctx.font has to be called twice because resetting the size resets the state
// if (flip) ctx.scale(1, -1);
// ctx.font = fontSize + "px " + fontFamily
// ctx.fillText(text, offsetx, (typeof(bboxHeight)=="number" ? bboxHeight : offsety));
// // drawing baseline
// if (drawBaseline) {
// ctx.fillRect(0, canvasHeight/2, ctx.canvas.width, 1);
// }
// // grabbing image data
// var imageData = ctx.getImageData(0, 0, cwidth, cheight);
// var data = imageData.data;
// // calculating top
// var top = 0;
// var pos = 0;
// while (pos < data.length) { if (data[pos + 3]) { pos -= pos % (cwidth * 4);} // back to beginning of the line top = (pos / 4) / cwidth; // calculate pixel position top -= offsety - fontSize; pos = data.length; // exit loop } pos += 4; } // calculating bottom var bottom = 0; var pos = data.length; while (pos > 0) {
// if (data[pos + 3]) {
// pos -= pos % (cwidth * 4); // back to beginning of the line
// bottom = (pos / 4) / cwidth;
// bottom -= offsety - fontSize;
// pos = 0; // exit loop
// }
// pos -= 4;
// }
// // calculating left
// var left = 0;
// var col = 0, row = 0; // left bounds
// while (row < cheight && col < cwidth) {
// var px = data[(row * cwidth * 4) + (col * 4) + 3];
// if (px) {
// left = col - offsetx;
// row = cheight;
// col = cwidth;
// }
// row ++;
// if (row % cheight == 0) {
// row = 0;
// col++;
// }
// }
// // calculating right
// var right = 0;
// var col = cwidth, row = 0; // right bounds
// while (row < cheight && col > 0) {
// if (data[(row * cwidth * 4) + (col * 4) + 3]) {
// right = col - offsetx;
// row = cheight;
// col = cwidth;
// }
// row ++;
// if (row % cheight == 0) {
// row = 0;
// col --;
// }
// }
// // calculating real-bottom
// var realBottom = 0;
// var pos = data.length;
// while (pos > 0) {
// if (data[pos + 3]) {
// pos -= pos % (cwidth * 4); // back to beginning of the line
// realBottom = (pos / 4) / cwidth;
// pos = 0; // exit loop
// }
// pos -= 4;
// }
// // restoring state
// ctx.restore();
// // returning raw-metrics
// return {
// "left": (-left),
// "top": (fontSize - top),
// "width": (right - left),
// "height": (bottom - top),
// "bottom": realBottom
// }
//};
//})();

//getFontMetrics({ctx : ctx})
</script>
<?php include '../php/footer.inc.php';?>
