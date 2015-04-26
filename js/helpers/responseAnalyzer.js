function responseAnalyzer(responseArray) {
  var i;
  if(responseArray.slice(0,1) !== "{" && responseArray.slice(0,1) !== "[") {
    logError("Fehler im responseAnalyzer: " + responseArray);
  }
  var answer = JSON.parse(responseArray);
  //log(answer)
  for(i in answer.log)   {log(answer.log[i]);}
  for(i in answer.error) {log(answer.error[i]);}
  if (answer.alert) {log(answer.alert.join("\n"));}//{showModalReloadAlert(answer.alert.join("\n"));}
  if (answer.message) {
    var $msg = $("<div style='position:absolute; top: 0.5em; right: 0.5em; padding: 0.5em; background-color: #cde;'></div>").html(answer.message.join("\n")).appendTo($("body"));
    setTimeout(function() {$msg.fadeOut();}, 2000);
  }
  var props = ["cms", "files"];
  for(var p in props) {
    var property = props[p];
    if (answer[property]) {
      looD[property] = answer[property][answer[property].length - 1];
      $.publish("response."+property);
    }
  }

  for(i in answer.callback) {
    setTimeout(function() {(window[answer.callback[i]])();} , 1);
  }
  for(i in answer.callbackWithArgs) {
    var fnc = answer.callbackWithArgs[i][0];
    setTimeout(function() {(window[fnc]).apply(this, answer.callbackWithArgs[i].slice(1));} , 1);
  }
  if (answer.returnvalue) return answer.returnvalue[answer.returnvalue.length-1];
}

$(document).ajaxError(function(e, data) {
  if(!data.responseJSON) return;
  log(data.responseJSON.message, data.responseJSON.code);
});