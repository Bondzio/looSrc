<?php include '../php/header.inc.php';?>
<style>
  .fileTable td, .fileTable th{padding-right: 1em;}
  .fileTable tr {border-bottom: 0.5em solid white;}
  .fileTable .tags {font-size: 0.8em;}
  .fileTable .tags button {display:none;}
  .fileTable .tags.edit button {display:inline-block;}
  .fileTable .tags.edit .showTags {display:none;}
  .fileTable .label {background-color: #ccddff; border-radius: 2px; margin-right: 0.5em; padding: 0 0.3em; }
  .fileTable .sorter-false i:not(.icon) {display:none;}
  .tablesorter-dropbox .tablesorter-filter {margin: 0px; width: 100%;}
  .tablesorter-dropbox .tablesorter-filter-row td {padding: 0px;}
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

          <table class="fileTable">
            <thead><tr>
              <th class="sorter-false" style="width:4em"></th>
              <th class="sorter-false" style="width:1.6em"><input class="checkAll" type='checkbox'></th>
              <th class="filter-select" style="width:6em">Folder</th><th>File</th>
              <th class="sorter-false" style="width:4em">Info</th>
              <th style="width:5em">kB</th><th>Modified</th>
              <th class="sorter-false" style="width:2em">Sync</th>
              <th style="width:4em"><i class="icon icon-clipboard2"></i></th>
              <th class="labelheader tags sorter-false filter-match"><i class="icon icon-label"></i>&nbsp;&nbsp;<button class='ok'>ok</button><button class='cancel'>cancel</button></th>
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
      "<td class='info'>{{info}}</td><td>{{round(f.stats.size/1000)}}</td><td>{{f.stats.modified}}</td><td class='sync'>{{notInInfos}}</td><td>{{f.status||'-'}}</td><td class='tags' data-tags='{{f.tags}}'>{{tags}}</td></tr>");
    var $fileTable = $(".fileTable");
    var $fileTableBody = $fileTable.find("tbody").empty();
    var f, notInInfos, preview, src, tags, info;
    for(var i in looD.merge) {
      f = looD.merge[i];
      //log(f);
      notInInfos = (_.contains(looD.notInInfos, looD.merge[i].file)?"<button class='updateCms'>in Infos eintragen</button>":"ok");
      src = "../" + f.folder + "/" + f.file;
      preview = f.folder == "img"?"<img width=50 height=30 src='"+src+"'>":"<iframe width=50 height=30 src='"+src+"'></iframe>";
      info = f.folder == "img"?"imgsize...":"";
      tags = (f.tags?f.tags.split(",").reduce(function(old,el,i){return old + "<span class='label'>"+el+"</span>";}, ""):"") + "<span class='showTags'>+++</span><button class='ok'>ok</button><button class='cancel'>cancel</button>";
      $fileTableBody.append(rowTemplate({f: f, notInInfos: notInInfos, info: info, preview: preview, tags: tags}))
    }
    $fileTable.off("click.updateCms").on("click.updateCms", ".updateCms", updateCms);
    $fileTable.off("click.tags").on("click.tags", ".showTags", chooseLabel);
    $fileTable.off("click.rename").on("click.rename", ".folder:not(.edit), .file:not(.edit)", renameDialog);
    $fileTable.off("change.checkAll").on("change.checkAll", ".checkAll", function() {$fileTable.find(".checkMe").prop("checked", $(this).prop("checked"));});
    $fileTable.off("click.labelChoice").on("click.labelChoice", ".labelheader:not(.edit)", filterLabel);
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
    var $tree = $("<loo-tree src='../cms/labels.json' type='applyTree' checklist='"+$cell.data('tags')+"'></loo-tree>").appendTo($cell);
    $cell.find(".ok").on("click", updateLabel.bind(this));
    $cell.find(".cancel").on("click", closeLabel.bind(this));
    //$tree[0].addEventListener("recheck", updateLabel.bind(this));  
  }
  
  function updateLabel(e) {
    var $cell = $(this).closest("td");
    var file = $(this).closest("tr").data("file");
    var content = _.findWhere(looD.cms, {file: file});
    content.tags = $cell.find("loo-tree").attr("checklist")
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
  

  

</script>
<?php include '../php/footer.inc.php';?>
