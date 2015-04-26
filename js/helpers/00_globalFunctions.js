// aliasing important functions into global namespace
var sin     = Math.sin;
var cos     = Math.cos;
var tan     = Math.tan;
var arctan  = Math.atan;
var atan2   = Math.atan2;
var arcsin  = Math.asin;
var arccos  = Math.acos;

var exp     = Math.exp;
var ln      = Math.log;
var log10   = Math.log10 || function(x) {return Math.log(x) / Math.LN10;}
var pow     = Math.pow;
var sqrt    = Math.sqrt;
var cbrt    = Math.cbrt;

var abs     = Math.abs;
var round   = Math.round;
var ceil    = Math.ceil;
var floor   = Math.floor;
var max     = Math.max;
var min     = Math.min;

var sign    = Math.sign || function(x) {if(typeof x !== "number") {return Math.NaN;} return x>0?1:x<0?-1:0;};

var rand    = Math.random;

var hypot   = Math.hypot || function(a,b) {return sqrt(a*a+b*b);};
var cath    = function(c,b) {return sqrt(c*c-b*b);};

//CONSTANT NUMBERS
var PI      = Math.PI;
var E       = Math.E;
var SQRT1_2 = Math.SQRT1_2;
var SQRT2   = Math.SQRT2;
var LN2     = Math.LN2;

var cblog = function(msg) {return function(data) {log(msg, data);};};

var g = 9.81;
var g_round = 10;
var euler = 2.71;
var pi = 3.1415926535;
var q_e = 1.6e-19;
var G = 6.67e-11;
var c = 299792458;
var c_round = 3e8;

globalConstants = {
  g : {val:  9.81, unit: "m/s^2"},
  g_round : {val:  10, unit: "m/s^2"},
  euler : {val:  2.71, unit: false},
  pi : {val:  3.1415926535, unit: false},
  q_e : {val:  1.6e-19, unit: "C"},
  G : {val:  6.67e-11, unit: "Nm^2/kg^2"},
  c : {val:  299792458, unit: "m/s"},
  c_round : {val:  3e8, unit: "m/s"},
}
