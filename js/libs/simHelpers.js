//var maxHeight = window.innerHeight;
//var maxWidth = window.innerWidth;
var nextStep = (function(){return window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||function(t){window.setTimeout(t,1e3/60);};})();

$(window).on("touchmove", function(e) {e.preventDefault()})

function beforeStart() {
  var allscripts = $("script").get().reduce(function(old, current) {return old + current.textContent;}, "");
  var imgpaths = (/img: "(.*)",/g.execAll(allscripts)).map(function(el) {return el[1];});
  preloadImages(imgpaths, function() {
    buildWorld();
    setup();
    loopStart();
  }) 
}

function loopStart() {
  if(typeof loopExtension == "function") {
    loopExtension();
  }
  loop();
  nextStep(loopStart);
};

function mapPropsToActor(proparray, actor) {
  for(var i =0; i < proparray.length; i++) {
    var n = proparray[i];
    actor[n] = window[n] || null;
  }
}

sqrt = Math.sqrt;
sqr = function(a) {return a*a;};
sin = Math.sin;
cos = Math.cos;

function pyth(c1, c2) {
  return window.Math.sqrt(c1 * c1 + c2 * c2);
}
function dist(obj1, obj2) {
  return pyth(obj1.x - obj2.x, obj1.y - obj2.y);
}
function solveQuadratic(a, b, c) {
  var diskr = b*b - 4*a*c;
  if (diskr<0) {
    return [];
  }
  else if(diskr === 0) {
    return [-b/2/a];
  }
  else {
    return [(-b+window.Math.sqrt(diskr))/2/a, (-b-window.Math.sqrt(diskr))/2/a];
  }
}


var testmode = true;
var watches = [];

function watch() {
  
}

