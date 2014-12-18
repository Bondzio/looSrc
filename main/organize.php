<?php include '../php/header.inc.php';?>
<form action="../php/uploadImage.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>
<div class="header-container ">
  <header class="wrapper menu clearfix">
    <span class="title"><img src="../img/looopingBright.svg" style="width:2em;"></span>
    <div class="right">&nbsp;&nbsp;</div>
    <div class="right">&nbsp;&nbsp;</div>
    <div class="right">&nbsp;&nbsp;</div>
    <div class="right">&nbsp;&nbsp;</div>
  </header>  
</div>
<div class="main-container">
    <div class="main wrapper clearfix">

        <div>
            <header>
              <h2>Organizer</h2>
            </header>

<!--          <table class="fileTable">
            tr><th>Datei</th><th>Ordner</th><th>Vorschau</th></tr

          </table>-->
          <aha-table class="fileTable" selectable searchable copyable removable data-sizelist="50" copytitle="copy">
            <aha-column name="folder" type="string" sortable searchable editable></aha-column>
            <aha-column name="file"   type="string" sortable searchable editable></aha-column>
            <aha-column name="status"  type="string" sortable searchable editable></aha-column>
            <aha-column name="rating"   type="choice" sortable searchable placeholder="-" editable></aha-column>
          </aha-table>
          <loo-dropdown></loo-dropdown>
        </div>

        <!--aside>
            <h3>aside</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sodales urna non odio egestas tempor. Nunc vel vehicula ante. Etiam bibendum iaculis libero, eget molestie nisl pharetra in. In semper consequat est, eu porta velit mollis nec. Curabitur posuere enim eget turpis feugiat tempor. Etiam ullamcorper lorem dapibus velit suscipit ultrices.</p>
        </aside-->

    </div> <!-- #main -->
</div> <!-- #main-container -->

<script>
  var looD = {};
  $.when($.getJSON("../php/getAssets.php"), $.getJSON("../cms/cms.json" ))
    .done(function(filesPhp, cmsJson) {
      looD.files = filesPhp[0];
      looD.cms = cmsJson[0];
      checkFiles();
    });

  function createFileTable() {
    _.templateSettings = {interpolate: /\{\{(.+?)\}\}/g}; // {{test}}
    var rowTemplate = _.template("<tr data-file='{{f.file}}' data-folder='{{f.folder}}'><td><input type='checkbox'></td><td>{{f.folder}}</td><td>{{f.file}}</td><td><iframe width=200 height=100 src='../{{f.folder}}/{{f.file}}'></iframe></td><td>{{notInInfos}}</td><td class='tags'><select></select></td></tr>");
    var $fileTable = $(".fileTable").empty();
    for(var i in looD.files) {
      $fileTable.append(rowTemplate({f: looD.files[i], notInInfos: (_.contains(looD.notInInfos, looD.files[i].file)?"<button class='updateCms'>in Infos eintragen</button>":"ok")}))
    }
    $fileTable.off("click.updateCms").on("click.updateCms", ".updateCms", updateCms);
    $("aha-table")[0].data = looD.merge;
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

</script>
<?php include '../php/footer.inc.php';?>
