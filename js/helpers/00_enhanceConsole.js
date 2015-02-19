// Full version of `log` that:
// * Prevents errors on console methods when no console present.
// * Exposes a global 'log' function that preserves line numbering and formatting.
(function () {
var method;
var noop = function () { };
var methods = [
'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
'timeStamp', 'trace', 'warn'
];
var length = methods.length;
var console = (window.console = window.console || {});
 
while (length--) {
method = methods[length];
 
// Only stub undefined methods.
if (!console[method]) {
console[method] = noop;
}
}
 
if (Function.prototype.bind) {
window.log = Function.prototype.bind.call(console.log, console);
}
else {
window.log = function() {
$("#Log").append("<p>"+arguments[0]+"</p>");
Function.prototype.apply.call(console.log, console, arguments);
};
}
})();

function logError(err) {
  //console.error(err);
  if(window.innerWidth< window.innerHeight||true) {
    document.body.innerHtml += "<p>"+err+"</p>";
  }
}

window.onerror = logError;

function assert(a, b) {console.assert(a, b);}