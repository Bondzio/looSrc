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
var pow     = Math.pow;
var sqrt    = Math.sqrt;

var abs     = Math.abs;
var round   = Math.round;
var ceil    = Math.ceil;
var floor   = Math.floor;
var max     = Math.max;
var min     = Math.min;

var sign    = Math.sign || function(x) {if(typeof x !== "number") {return NaN}; return x>0?1:x<0?-1:0};

var rand    = Math.random;

var hypot   = Math.hypot || function(a,b) {return sqrt(a*a+b*b)};
var cath    = function(c,b) {return sqrt(c*c-b*b)};

//CONSTANT NUMBERS
PI      = Math.PI
E       = Math.E
SQRT1_2 = Math.SQRT1_2;
SQRT2   = Math.SQRT2
LN2     = Math.LN2;