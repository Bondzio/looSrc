<?php include '../php/header.inc.php';?>
<style>
  body {
    background-color: white;
    padding: 1em; 
  }
  #similar {font-size: 0.8em;}
  #similar p {margin: 0.2em 0 0 0; font-weight: bold;}
  #similar a {font-size: 0.8em;}
</style>
<?php include '../php/postheader.inc.php';

$tree = filter_input(INPUT_GET, "tree", FILTER_SANITIZE_STRING);
if($tree === "physics") {
  $srcTree = "../cms/labels.json";
  $bookmarkstable = "bookmarksPhysics";
}
if($tree === "web") {
  $srcTree = "../cms/weblabels.json";
  $bookmarkstable = "bookmarksWeb";
}

?>
  <h3>Save Bookmark <?=$tree?></h3>
  <div id="currentLink">
    <img class='favicon' alt="Bookmark for the New Site" src="">
<!--    <canvas id="favicon" width="16" height="16"></canvas>-->
    <table>
      <tr><td>Title:   </td><td><input name="title" value="<?=filter_input(INPUT_GET, "title", FILTER_SANITIZE_STRING)?>"></td></tr>
      <tr><td>Details: </td><td><input name="details"></td></tr>
      <tr><td>URL:     </td><td><input name="href" value="<?=filter_input(INPUT_GET, "url", FILTER_SANITIZE_URL)?>"></td></tr>
      <tr><td>Status:  </td><td><input name="status" value="y"></td></tr>
      <tr><td>Labels:  </td><td><input name="labels"></td></tr>
<!--    <tr><td>Icon:    </td><td><input name="icon"></td></tr>-->
    </table>
    <button id="save">Save</button>
    <div id="myDiv"></div>
    <div id="similar"></div>
    <div>
      <loo-tree src='<?=$srcTree ?>' type='manageTree applyTree'></loo-tree>
    </div>
  </div>
<?php include '../php/prefooterscripts.inc.php';?>
<script>
  document.getElementsByTagName('loo-tree')[0].addEventListener("click", function(e) {
    document.getElementsByName('labels')[0].value = e.target.tree.getChecked();
  });
  
  var b = document.getElementsByName('href')[0].value;
  document.getElementsByClassName('favicon')[0].src = "http://www.google.com/s2/favicons?domain=" + b.slice(b.indexOf('://') + 3, b.indexOf('/', b.indexOf('://') + 5));

  document.getElementById("save").addEventListener("click", function() {
    var newBookmark = {
      title:    document.getElementsByName('title')[0].value,
      details:  document.getElementsByName('details')[0].value,
      added:    Math.round((new Date()).getTime()/1000),
      modified: Math.round((new Date()).getTime()/1000),
      href:     document.getElementsByName('href')[0].value,
      status:   document.getElementsByName('status')[0].value,
      labels:   document.getElementsByName('labels')[0].value
      //icon:    document.getElementsByName('icon')[0].value,
      //iconurl: tab.favIconUrl,
    }
    
    var data = {code: localStorage.looopCode, task: "INSERT", table: "<?=$bookmarkstable?>", values: [newBookmark], unique: "title"}
    $.post("../php/dbCentral.php", data, responseAnalyzer).then(function(data) {
      document.getElementById("myDiv").innerHTML = JSON.parse(data).message ? JSON.parse(data).message.join(" ") : "Bookmark saved!";
    });
//    function(resp) {
//      log(resp)
//      document.getElementById("myDiv").innerHTML = "Bookmark saved!";
//      //setTimeout(function() {window.close();}, 500)
//    });
  })
  
  var href = document.getElementsByName('href')[0].value;
  var short = href.slice(href.indexOf('://') + 3, href.indexOf('/', href.indexOf('://') + 5));
  $.post("../php/dbCentral.php", {code: localStorage.looopCode, task: "getJson", table: "<?=$bookmarkstable?>", where: "href LIKE '%"+short+"%'"}).then(function(d) {
    similars = JSON.parse(d);
    if(similars.length) {
      $("#similar").html("<h4>Ähnliche Bookmarks</h4>" + similars.map(function(s){return "<div><p>"+s.title+"</p><a href='"+s.href+"'>"+s.href+"</a></div>";}).join(""));
      
    }
  });
  
  //  var img = new Image();
  //  img.onload = function() {
  //    canvas = document.getElementById("favicon");
  //    var context = canvas.getContext("2d");
  //    context.drawImage(this, 0, 0, 16, 16);
  //    var imageData = canvas.toDataURL("image/png");//context.getImageData(0, 0, 16,16);
  //    document.getElementsByName('icon')[0].value = imageData;
  //  }
  //img.src = tab.location + favIconUrl;
</script>
<?php include '../php/footer.inc.php';?>