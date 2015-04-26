<?php include '../php/header.inc.php';?>
<style>
  .filetable {font-size: 0.75em; }
  .fileTable td, .fileTable th{padding: 0; padding-right: 1em;line-height: 1.5em;}
  .fileTable .labels {font-size: 0.8em;}
  .fileTable .labels button {display:none;}
  .fileTable .labels.edit button {display:inline-block;}
  .fileTable .labels.edit .showLabels {display:none;}
  .fileTable .label {background-color: #ccddff; border-radius: 2px; margin-right: 0.5em; padding: 0 0.3em; }
  .fileTable .sorter-false i:not(.icon) {display:none;}
  .fileTable .modified {min-width: 7em; font-size: 0.8em;}
  .tablesorter-dropbox .tablesorter-filter {margin: 0px; width: 100%;}
  .tablesorter-dropbox .tablesorter-filter-row td {padding: 0px;}
  .editchecked {font-size: 0.7em;}
  button+span.editChecked{display: none;}
  button.edit+span.editChecked{display: inline-block;}
</style>
<?php include '../php/postheader.inc.php';

$tree = filter_input(INPUT_GET, "tree", FILTER_SANITIZE_STRING);
if($tree === "web") {
  $srcTree = "../cms/weblabels.json";
  $bookmarks = "../cms/webbookmarks.json";
}
//else if($tree === "physics") {}
else {
  $srcTree = "../cms/labels.json";
  $bookmarks = "../cms/bookmarks.json";
}
?>
<div class="main-container">
    <div class="main wrapper clearfix">
        <div>
            <header>
              <h2><img src="../img/loooping.svg" style="width:1.6em; margin-right: 0.4em;">Bookmarks Organizer</h2>
            </header>
          
          <div><label><input type="checkbox" class="include-x">x</label></div>
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
              <th>Title</th>
              <th>Details</th>
              <th>Link</th>
              <th class="modified">Mod</th><!--th>Add</th-->
              <th class="filter-match" style="width:4em"><i class="icon icon-clipboard2"></i></th>
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
  start = $.now();
  var bookmarksfile = "<?=$bookmarks?>"
  var bookmarkspath = bookmarksfile.slice(3); //ohne ../
  loadBookmarks();
  function loadBookmarks() {
    $.getJSON(bookmarksfile)
    .done(function(bookmarksJson) {
      log("loaded", $.now()-start)
      looD.bookmarks = bookmarksJson;
      findDuplicates(); 
      createFileTable();
      log("rendered", $.now()-start)
      $(".include-x").on("change", createFileTable);
    });
  }
  
  function findDuplicates() {
    looD.bookmarks.forEach(function(b) {
      looD.bookmarks.forEach(function(c) {
        if(b==c) return;
        if(b.title == c.title) {log ("duplicateTitle:", b.title);}
        //if(b.href == c.href) {log ("duplicateHref:", b.href);}
      });
    });
  }
  
  function getIconPath(b) {
    //log(b, b.href.slice(b.href.indexOf('://') + 3, b.href.indexOf('/', b.href.indexOf('://') + 5)) + "'");
    return ("http://www.google.com/s2/favicons?domain=" + b.href.slice(b.href.indexOf('://') + 3, b.href.indexOf('/', b.href.indexOf('://') + 5)));
    //    if(bookmark.iconpath === "") return "../img/favicons/questionmark.png";
    //    var filename = bookmark.href;
    //    if(filename.indexOf("//")>0) filename = filename.slice(filename.indexOf("//")+2);
    //    if(filename.indexOf("www.")>=0) filename = filename.slice(filename.indexOf("www.")+4);
    //    if(filename.indexOf("/")>=0) filename = filename.slice(0, filename.indexOf("/"));
    //    return "../img/favicons/" + filename + ".png"
  }
//  
//  function verify() {
//    rows = $("tbody").find("tr");
//    errors=[];
//    for(var i=0; i<rows.length; i++) {
//      t = rows.eq(i).data("title");
//      orig = _.findWhere(looD.bookmarks, {title: t});
//      if(!orig) {errors.push({t: t, o: looD.bookmarks[i].title})}
//    }
//    log(JSON.stringify(errors));
//  }
//  
//  importBookmarks();
//  
//  function importBookmarks() {
//    $.getJSON("../cms/bookmarksImport_1.json")
//    .done(function(bookmarksJson) {
//      looD.bookmarks = bookmarksJson;
//      looD.newBookmarks = [];
//      log(bookmarksJson);
//      rearrangeBookmarks(looD.bookmarks, "Web");
//      log(looD.newBookmarks);
//      $.post("../php/saveSafeCentral.php", {code: localStorage.looopCode, path: bookmarkspath, task: "save", content: JSON.stringify(looD.newBookmarks)}, responseAnalyzer);
//    });
//  }
//  
//  function rearrangeBookmarks(b, labelsToApply) {
//    var n;
//    for(var i = 0; i < b.links.length; i++) {
//      if(b.links[i].links) {
//        rearrangeBookmarks(b.links[i], labelsToApply + "," + b.links[i].group);
//      }
//      else {
//        n = $.extend({}, b.links[i]);
//        n.labels = labelsToApply;
//        n.mod = n.add;
//        looD.newBookmarks.push(n);
//      }
//    }
//  }

  function createFileTable() {
     _.templateSettings = {interpolate: /\{\{(.+?)\}\}/g}; // {{test}}
    var rowTemplate = _.template("<tr data-title='{{_.escape(b.title)}}'>"+
    "<td class='preview'><img src='{{getIconPath(b)}}' style='width:16px; height:16px;'></td>"+
    "<td class='boxes'><input class='checkMe' type='checkbox'></td>"+
    "<td data-type='title' class='title' title='{{b.title}}'>{{b.title.slice(0,40)+(b.title.length>40?'...':'')}}</td>"+
    "<td data-type='details' class='details' title='{{b.details}}'>{{b.details?b.details.slice(0,10)+'...':''}}</td>"+
    "<td data-type='href' class='href'><a href='{{b.href}}'>{{b.href.slice(b.href.indexOf('://') + 3, b.href.indexOf('/', b.href.indexOf('://') + 5))}}</a></td>"+
    "<td class='modified'>{{getDateFromDOb(new Date(b.mod*1000)).slice(0,10)}}</td>" + // "<td>{{getDateFromDOb(new Date(b.add*1000))}}</td>" +
    "<td class='status'>{{b.status?b.status.split(','):'-'}}</td>"+
    "<td class='labels' data-labels='{{b.labels}}'>{{labels}}</td>"+
    "</tr>");
    var $fileTable = $(".fileTable");
    var $fileTableBody = $fileTable.find("tbody").empty();
    var b, notInInfos, preview, labels;
    for(var i = 0; i< looD.bookmarks.length; i++) {
      b = looD.bookmarks[i];
      //preview = f.folder == "img"?"<img width=50 height=30 src='"+src+"'>":"<iframe width=50 height=30 src='"+src+"'></iframe>";
      //info = f.folder == "img"?"imgsize...":"";
      if($(".include-x:checked").length == 0 && b.status && b.status.indexOf("x") > -1) {continue;}
      labels = (b.labels?b.labels.split(",").reduce(function(old,el,i){return old + "<span class='label' data-label='"+el+"'>"+el+"&nbsp;<i class='removeLabel icon-x'></i></span>";}, ""):"") + "<span class='showLabels'>+++</span><button class='ok'>ok</button><button class='cancel'>cancel</button>";
      $fileTableBody.append(rowTemplate({b: b, labels: labels}))
    }
    //$fileTable.off("click.updateCms").on("click.updateCms", ".updateCms", updateCms);
    $fileTable.off("click.labels").on("click.labels", ".showLabels", chooseLabel);
    $fileTable.off("click.removeLabel").on("click.removeLabel", ".removeLabel", removeLabel);
    $fileTable.off("click.rename").on("click.rename", ".title:not(.edit), .details:not(.edit), .href:not(.edit)", renameDialog);
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

//  function updateCms(e) {
//    var content = {
//      file: $(this).closest("tr").data("file"),
//      folder: $(this).closest("tr").data("folder")
//    }
//    $.post("../php/saveSafeCentral.php", {code: localStorage.looopCode, path: "cms/cms.json", task: "JSONinsert", content: content}, responseAnalyzer);
//  }

  //$.subscribe("response.cms", checkFiles);

//  function checkFiles() {
//    looD.filelist = _.map(looD.files, function(obj){return obj.file;});
//    looD.infolist = _.map(looD.cms, function(obj){return obj.file;});
//    looD.merge = looD.files.map(function(f){return _.extend(f, _.findWhere(looD.cms, {file: f.file}) || {notininfos: true});});
//    looD.notInInfos = _.difference(looD.filelist, looD.infolist);
//    looD.notInFiles = _.difference(looD.infolist, looD.filelist);
//    if(looD.notInInfos.length!==0) {log("not all Files are in sync");}
//    createFileTable();
//  }
  
  function filterLabel(e) {
    var $cell = $(this).addClass("edit");
    var $tree = $("<loo-tree src='<?=$srcTree?>' checklist='"+looD.checkedLabels+"'></loo-tree>").appendTo($cell);
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
    var $tree = $("<loo-tree src='<?=$srcTree?>' type='manageTree applyTree' checklist='"+$cell.data('labels')+"'></loo-tree>").appendTo($cell);
    $cell.find(".ok").on("click", updateLabel.bind(this));
    $cell.find(".cancel").on("click", closeLabel.bind(this));
    //$tree[0].addEventListener("recheck", updateLabel.bind(this));  
  }
  
  function updateLabel(e) {
    var $cell = $(this).closest("td");
    var title = $(this).closest("tr").data("title");
    var content = _.findWhere(looD.bookmarks, {title: title});
    content.labels = $cell.find("loo-tree").attr("checklist");
    $.post("../php/saveSafeCentral.php", {code: localStorage.looopCode, path: bookmarkspath, task: "JSONupdate", key:"title", value: title, content: content}, responseAnalyzer).then(createFileTable);
    closeLabel.call(this);
  }
  
  function removeLabel(e) {
    var $cell = $(this).closest("td");
    var title = $(this).closest("tr").data("title");
    var content = _.findWhere(looD.bookmarks, {title: title});
    var labelarray = content.labels.split(",");
    labelarray.splice(labelarray.indexOf($(this).closest(".label").data("label")), 1);
    content.labels = labelarray.join(",");
    log(content.labels);
    $.post("../php/saveSafeCentral.php", {code: localStorage.looopCode, path: bookmarkspath, task: "JSONupdate", key:"title", value: title, content: content}, responseAnalyzer).then(createFileTable);
  }
  
  function closeLabel(e) {
    var $cell = $(this).closest("td,th");
    setTimeout(function(){$cell.removeClass("edit")}, 0)
    $cell.find("loo-tree").remove();
  }
  
  function renameDialog() {
    var title = $(this).closest("tr").data("title");
    var $cell=$(this).addClass("edit");
    var oldval=$cell.text();
    var type = $(this).data("type");
    var $input = $("<input value='"+oldval+"'>").appendTo($cell.empty());
    var $ok = $("<button>OK</button>").appendTo($cell);
    var $cancel = $("<button>cancel</button>").appendTo($cell);
    $cancel.on("click", function() {$cell.empty().text(oldval).removeClass("edit")});
    $ok.on("click", function() {
      var content = _.findWhere(looD.bookmarks, {title: title});
      content[type] = $input.val();  
      $.post("../php/saveSafeCentral.php", {code: localStorage.looopCode, path: bookmarkspath, task: "JSONupdate", key:"title", value: title, content: content}, responseAnalyzer).then(createFileTable);
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
    for(var j=looD.bookmarks.length-1; j>=0; j--) {
      if(checked[i].title === looD.bookmarks[j].title) {looD.bookmarks.splice(j, 1); break;}
    }
  }
  saveBookmarks();
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
    saveBookmarks();
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
      //log(checked[i]);
     }
    saveBookmarks();
  });
}

$(".addLabelsToChecked").on("click", addLabelsToChecked)
function addLabelsToChecked() {
  var $editspan = $(this).next("span");
  var $tree = $("<loo-tree class='temp' src='<?=$srcTree?>'></loo-tree>").appendTo($editspan);
  $editspan.find(".ok").off("click.save").on("click.save", function() {
    var checked = getChecked();
    var newLabels = $tree[0].tree.getChecked();
    for(var i=0; i<checked.length; i++) {
      var bookmarkObj = checked[i];
      bookmarkObj.labels = bookmarkObj.labels.split(",");
      newLabels.forEach(function(label) {if(bookmarkObj.labels.indexOf(label)<0) {bookmarkObj.labels.push(label);}});
      bookmarkObj.labels = bookmarkObj.labels.join(",");
    }
    saveBookmarks();
  });
}

function getChecked() {
  return $("tr:not(.filtered)").find(".checkMe:checked").get().map(function(el) {return _.findWhere(looD.bookmarks, {title: $(el).closest("tr").data("title")});});
}

function saveBookmarks() {
  //log(looD.bookmarks);
  $.post("../php/saveSafeCentral.php", {code: localStorage.looopCode, task: "save", path: bookmarkspath, content: JSON.stringify(looD.bookmarks)}, createFileTable);
}

</script>
<?php include '../php/footer.inc.php';?>
