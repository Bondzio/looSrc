chrome.tabs.getSelected(null, function(tab) {

  document.getElementsByName('href')[0].value = tab.url;
  document.getElementsByName('title')[0].value = tab.title;
  var img = new Image();
  img.onload = function() {
    canvas = document.getElementById("favicon");
    var context = canvas.getContext("2d");
    context.drawImage(this, 0, 0, 16, 16);
    var imageData = canvas.toDataURL("image/png");//context.getImageData(0, 0, 16,16);
    document.getElementsByName('icon')[0].value = imageData;
  }
  img.src = tab.favIconUrl;
  document.getElementById("save").addEventListener("click", function() {
    var newBookmark = {
      title:  document.getElementsByName('title')[0].value,
      details:document.getElementsByName('details')[0].value,
      add:    Math.round((new Date()).getTime()/1000),
      mod:    Math.round((new Date()).getTime()/1000),
      href:   document.getElementsByName('href')[0].value,
      status: document.getElementsByName('status')[0].value,
      labels: document.getElementsByName('labels')[0].value,
      icon:   document.getElementsByName('icon')[0].value,
      iconurl: tab.favIconUrl,
    }
    
    chrome.storage.sync.get(["savecentral", "code", "path"], function(items) {
      
      var data = {code: items.code, task: "JSONinsert", path: items.path, content: newBookmark}
      $.post(items.savecentral, data, function(resp) {
        document.getElementById("myDiv").innerHTML = "Bookmark saved!";
        setTimeout(function() {window.close();}, 500)
      })
    });
  })
});