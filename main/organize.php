<?php include '../php/header.inc.php';?>
<style>
  .fileTable td, .fileTable th{padding-right: 1em;}
  .fileTable tr {border-bottom: 0.5em solid white;}
  .fileTable .labels {font-size: 0.8em;}
  .fileTable .labels button {display:none;}
  .fileTable .labels.edit button {display:inline-block;}
  .fileTable .labels.edit .showLabels {display:none;}
  .fileTable .label {background-color: #ccddff; border-radius: 2px; margin-right: 0.5em; padding: 0 0.3em; }
  .fileTable .sorter-false i:not(.icon) {display:none;}
  .tablesorter-dropbox .tablesorter-filter {margin: 0px; width: 100%;}
  .tablesorter-dropbox .tablesorter-filter-row td {padding: 0px;}
  .editchecked {font-size: 0.7em;}
  button+span.editChecked{display: none;}
  button.edit+span.editChecked{display: inline-block;}
</style>
<?php include '../php/postheader.inc.php';?>
<!--<form action="../php/uploadImage.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>-->
<div class="header-container ">
  <header class="wrapper menu clearfix">
    <span class="title"><img src="../img/looopingBright.svg" style="width:2em;"></span>
  </header>  
</div>
<div class="main-container">
    <div class="main wrapper clearfix">
        <div>
            <header>
              <h2>Organizer</h2>
            </header>
          
          <div class="editchecked">Markierte (<span class="checkCount">0</span>): 
            <button class="deleteChecked">löschen</button>
            <button class="addLabelsToChecked"     >Labels hinzufügen</button> <span class="editChecked"><button class="ok">OK</button><button class="cancel">Cancel</button></span>
            <button class="removeLabelsFromChecked">Labels entfernen</button>  <span class="editChecked"><button class="ok">OK</button><button class="cancel">Cancel</button></span>
            <button class="addStatusToChecked"     >Status hinzufügen</button> <span class="editChecked"><button class="ok">OK</button><button class="cancel">Cancel</button></span>
            <button class="removeStatusFromChecked">Status entfernen</button>  <span class="editChecked"><button class="ok">OK</button><button class="cancel">Cancel</button></span>
          </div>

          <table class="fileTable">
            <thead><tr>
              <th class="sorter-false" style="width:4em"></th>
              <th class="sorter-false" style="width:1.6em"><input class="checkAll" type='checkbox'></th>
              <th class="filter-select" style="width:6em">Folder</th><th>File</th>
              <th class="sorter-false" style="width:4em">Info</th>
              <th style="width:5em">kB</th><th>Modified</th>
              <th class="sorter-false" style="width:2em">Sync</th>
              <th style="width:4em"><i class="icon icon-clipboard2"></i></th>
              <th class="labelheader labels sorter-false filter-match"><i class="icon icon-label"></i>&nbsp;&nbsp;<button class='ok'>ok</button><button class='cancel'>cancel</button></th>
            </tr></thead>
            <tbody></tbody>
          </table>
        </div>
    </div> <!-- #main -->
</div> <!-- #main-container -->
<?php include '../php/prefooterscripts.inc.php';?>
<script>
  var looD = {};
  reset();
  
  function reset() {
    $.when($.getJSON("../php/getAssets.php"), $.getJSON("../cms/cms.json" ))
    .done(function(filesPhp, cmsJson) {
      looD.files = filesPhp[0];
      looD.cms = cmsJson[0];
      checkFiles();
    });
  }

  function createFileTable() {
     _.templateSettings = {interpolate: /\{\{(.+?)\}\}/g}; // {{test}}
    var rowTemplate = _.template("<tr data-file='{{f.file}}' data-folder='{{f.folder}}'><td class='preview'>{{preview}}</td><td class='boxes'><input class='checkMe' type='checkbox'></td><td class='folder'>{{f.folder}}</td><td class='file'>{{f.file}}</td>"+
      "<td class='info'>{{info}}</td><td>{{round(f.stats.size/1000)}}</td><td>{{f.stats.modified}}</td><td class='sync'>{{notInInfos}}</td><td>{{f.status||'-'}}</td><td class='labels' data-labels='{{f.labels}}'>{{labels}}</td></tr>");
    var $fileTable = $(".fileTable");
    var $fileTableBody = $fileTable.find("tbody").empty();
    var f, notInInfos, preview, src, labels, info;
    for(var i in looD.merge) {
      f = looD.merge[i];
      //log(f);
      notInInfos = (_.contains(looD.notInInfos, looD.merge[i].file)?"<button class='updateCms'>in Infos eintragen</button>":"ok");
      src = "../" + f.folder + "/" + f.file;
      preview = f.folder == "img"?"<img width=50 height=30 src='"+src+"'>":"<iframe width=50 height=30 src='"+src+"'></iframe>";
      info = f.folder == "img"?"imgsize...":"";
      labels = (f.labels?f.labels.split(",").reduce(function(old,el,i){return old + "<span class='label'>"+el+"</span>";}, ""):"") + "<span class='showLabels'>+++</span><button class='ok'>ok</button><button class='cancel'>cancel</button>";
      $fileTableBody.append(rowTemplate({f: f, notInInfos: notInInfos, info: info, preview: preview, labels: labels}))
    }
    $fileTable.off("click.updateCms").on("click.updateCms", ".updateCms", updateCms);
    $fileTable.off("click.labels").on("click.labels", ".showLabels", chooseLabel);
    $fileTable.off("click.rename").on("click.rename", ".folder:not(.edit), .file:not(.edit)", renameDialog);
    $fileTable.off("change.checkAll").on("change.checkAll", ".checkAll", function() {$fileTable.find("tr:not(.filtered)").find(".checkMe").prop("checked", $(this).prop("checked")); countChecked();});
    $fileTable.off("click.labelChoice").on("click.labelChoice", ".labelheader:not(.edit)", filterLabel);
    $fileTable.off("click.changeCheck").on("click.changeCheck", ".checkMe", countChecked);
    setTimeout(function() {$(".info").each(function(){
        if($(this).text().indexOf("imgsize")>=0) {
          var w = $(this).closest("tr").find("img")[0].naturalWidth;
          var h = $(this).closest("tr").find("img")[0].naturalHeight;
          $(this).text(w + "x" + h);}
        })}, 2000)
    $fileTable.tablesorter({theme: "dropbox", headerTemplate : '{content} {icon}', widgets: ["filter"]});
    $fileTable.trigger("update", [true]);
    $.tablesorter.setFilters( $('.fileTable') , looD.appliedFilters, true);
  }

  function updateCms(e) {
    var content = {
      file: $(this).closest("tr").data("file"),
      folder: $(this).closest("tr").data("folder")
    }
    $.post("../php/saveSafeCentral.php", {code: localStorage.looopCode, path: "cms/cms.json", task: "JSONinsert", content: content}, responseAnalyzer);
  }

  $.subscribe("response.cms", checkFiles);

  function checkFiles() {
    looD.filelist = _.map(looD.files, function(obj){return obj.file;});
    looD.infolist = _.map(looD.cms, function(obj){return obj.file;});
    looD.merge = looD.files.map(function(f){return _.extend(f, _.findWhere(looD.cms, {file: f.file}) || {notininfos: true});});
    looD.notInInfos = _.difference(looD.filelist, looD.infolist);
    looD.notInFiles = _.difference(looD.infolist, looD.filelist);
    if(looD.notInInfos.length!==0) {log("not all Files are in sync");}
    createFileTable();
  }
  
  function filterLabel(e) {
    var $cell = $(this).addClass("edit");
    var $tree = $("<loo-tree src='../cms/labels.json' type='applyTree' checklist='"+looD.checkedLabels+"'></loo-tree>").appendTo($cell);
    $cell.find(".ok").off("click.ok").on("click.ok", filterLabels.bind(this, $tree[0]));
    $cell.find(".cancel").off("clickCancel").on("click.cancel", closeLabel.bind(this));
  }
  
  function filterLabels(tree) {
    looD.appliedFilters = $.tablesorter.getFilters($('.fileTable'));
    looD.appliedFilters[$(this).index()] = tree.tree.getChecked(false, true).join("|");
    looD.checkedLabels = tree.tree.getChecked(false, false).join(",");
    $.tablesorter.setFilters( $('.fileTable') , looD.appliedFilters, true);
    closeLabel.call(this);
  }
  
  function chooseLabel() {
    var $cell = $(this).closest("td").addClass("edit");
    var $tree = $("<loo-tree src='../cms/labels.json' type='applyTree' checklist='"+$cell.data('labels')+"'></loo-tree>").appendTo($cell);
    $cell.find(".ok").on("click", updateLabel.bind(this));
    $cell.find(".cancel").on("click", closeLabel.bind(this));
    //$tree[0].addEventListener("recheck", updateLabel.bind(this));  
  }
  
  function updateLabel(e) {
    var $cell = $(this).closest("td");
    var file = $(this).closest("tr").data("file");
    var content = _.findWhere(looD.cms, {file: file});
    content.labels = $cell.find("loo-tree").attr("checklist")
    $.post("../php/saveSafeCentral.php", {code: localStorage.looopCode, path: "cms/cms.json", task: "JSONupdate", key:"file", value: file, content: content}, responseAnalyzer);
    closeLabel.call(this);
  }
  
  function closeLabel(e) {
    var $cell = $(this).closest("td,th");
    setTimeout(function(){$cell.removeClass("edit")}, 0)
    $cell.find("loo-tree").remove();
  }
  
  function renameDialog() {
    var $cell=$(this).addClass("edit");
    var oldname=$cell.text();
    var $input = $("<input value='"+oldname+"'>").appendTo($cell.empty());
    var $ok = $("<button>OK</button>").appendTo($cell);
    var $cancel = $("<button>cancel</button>").appendTo($cell);
    $cancel.on("click", function() {$cell.empty().text(oldname).removeClass("edit")});
    $ok.on("click", function() {
      var oldfolder = $cell.closest("tr").data("folder");
      var oldfile   = $cell.closest("tr").data("file");
      var newfolder = $cell.hasClass("folder") ? $input.val() : oldfolder;
      var newfile   = $cell.hasClass("file")   ? $input.val() : oldfile;
      //$cell.empty().text($input.val()).removeClass("edit");
      var oldpath = oldfolder + "/" + oldfile;
      var newpath = newfolder + "/" + newfile;
      var content = _.findWhere(looD.cms, {file: oldfile});
      content.folder = newfolder;  
      content.file = newfile;
      log("oldfile: " + oldfile + " content: ", content);
      $.post("../php/saveSafeCentral.php", {code: localStorage.looopCode, task: "rename", path: oldpath, newpath: newpath})
      .fail(function(data) {log("failed", data.responseJSON.message);})
      .done(function() {
        $.post("../php/saveSafeCentral.php", {code: localStorage.looopCode, task: "JSONupdate", path: "cms/cms.json", key:"file", value: oldfile, content: content}, reset);
      });
    });
    
  }
  
// Markierte
$("div.editchecked>button").on("click", function(){$(this).addClass("edit");})

$("div.editchecked").find("button.cancel, button.ok").on("click", function(){
  $(this).closest("span").prevAll("button.edit").removeClass("edit");
  $(this).closest("span").find(".temp").remove();
});
  
function countChecked() {
  $(".checkCount").text($("tr:not(.filtered)").find(".checkMe:checked").length);
}

$(".deleteChecked").on("click", deleteChecked);
function deleteChecked() {
  var checked = getChecked();
  for(var i=0; i<checked.length; i++) {
    for(var j=looD.cms.length-1; j>=0; j--) {
      if(checked[i].file === looD.cms[j].file) {looD.cms.splice(j, 1);}
    }
    $.post("../php/saveSafeCentral.php", {code: localStorage.looopCode, task: "delete", path: checked[i].folder + "/" + checked[i].file});
  }
  saveCms();
}

$(".removeLabelsFromChecked").on("click", {prop: "labels"}, removePropertyFromChecked);
$(".removeStatusFromChecked").on("click", {prop: "status"}, removePropertyFromChecked);
function removePropertyFromChecked(e) {
  var prop = e.data.prop;
  var $editspan = $(this).next("span");
  var $propertyInput = $("<input class='temp'></>").appendTo($editspan);
  $editspan.find(".ok").off("click.save").on("click.save", function() {
    var checked = getChecked();
    var removeProp = $propertyInput.val();
    for(var i=0; i<checked.length; i++) {
      checked[i][prop] = checked[i][prop].split(",");
      if(checked[i][prop].indexOf(removeProp)>=0) {checked[i][prop].splice(checked[i][prop].indexOf(removeProp), 1);}
      checked[i][prop] = checked[i][prop].join(",");
     }
    saveCms();
  });
}

$(".addStatusToChecked").on("click", {prop: "status"}, addPropertyToChecked);
function addPropertyToChecked(e) {
  var prop = e.data.prop;
  var $editspan = $(this).next("span");
  var $propertyInput = $("<input class='temp'></>").appendTo($editspan);
  $editspan.find(".ok").off("click.save").on("click.save", function() {
    var checked = getChecked();
    var changeProp = $propertyInput.val();
    for(var i=0; i<checked.length; i++) {
      checked[i][prop] = checked[i][prop]?checked[i][prop].split(","):[];
      if(checked[i][prop].indexOf(changeProp)<0) {checked[i][prop].push(changeProp);}
      checked[i][prop] = checked[i][prop].join(",");
      log(checked[i]);
     }
    saveCms();
  });
}

$(".addLabelsToChecked").on("click", addLabelsToChecked)
function addLabelsToChecked() {
  var $editspan = $(this).next("span");
  var $tree = $("<loo-tree class='temp' src='../cms/labels.json' type='applyTree'></loo-tree>").appendTo($editspan);
  $editspan.find(".ok").off("click.save").on("click.save", function() {
    var checked = getChecked();
    var newLabels = $tree[0].tree.getChecked();
    for(var i=0; i<checked.length; i++) {
      var obj = checked[i];
      obj.labels = obj.labels?obj.labels.split(","):[];
      newLabels.forEach(function(label) {if(obj.labels.indexOf(label)<0) {obj.labels.push(label);}});
      obj.labels = obj.labels.join(",");
    }
    saveCms();
  });
}

function getChecked() {
  return $("tr:not(.filtered)").find(".checkMe:checked").get().map(function(el) {return _.findWhere(looD.cms, {file: $(el).closest("tr").data("file")});});
}

function saveCms() {
  $.post("../php/saveSafeCentral.php", {code: localStorage.looopCode, task: "save", path: "cms/cms.json", content: JSON.stringify(looD.cms)}, reset);
}
  

</script>
<?php include '../php/footer.inc.php';?>
