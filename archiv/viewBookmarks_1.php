<?php include '../php/header.inc.php';?>
<style>
  .bookmarkTable {font-size: 1em; display: none;}
  .bookmarkTable td, .bookmarkTable th {padding: 0; padding-right: 1em;line-height: 1.5em;}
  .bookmarkTable .labels {font-size: 0.8em;}
  .bookmarkTable .labels button {display:none;}
  .bookmarkTable .labels.edit button {display:inline-block;}
  .bookmarkTable .labels.edit .showLabels {display:none;}
  .bookmarkTable .label {background-color: #ccddff; border-radius: 2px; margin-right: 0.5em; padding: 0 0.3em; }
  .bookmarkTable .sorter-false i:not(.icon) {display:none;}
  .bookmarkTable .modified {min-width: 4em; font-size: 0.8em;}
  .tablesorter-dropbox .tablesorter-filter-row td {padding: 0px;}
  .tablesorter-dropbox .tablesorter-filter {margin: 0px; width: 100%;}
  .editchecked {font-size: 0.7em; display:none;}
  button+span.editChecked{display: none;}
  button.edit+span.editChecked{display: inline-block;}
  
  .treeSelect loo-tree{display: none;}
  .treeSelect.show loo-tree{display: block;}
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
              <h2><img src="../img/loooping.svg" style="width:1.6em; margin-right: 0.4em;">Bookmarks Viewer</h2>
            </header>
          
          <div>
            <label><input type="checkbox" class="include-x">x</label>
            <label><input type="text" class="searchstring"></label>
            <span class="treeSelect"><button class="toggleTree">Tree</button><loo-tree src='<?=$srcTree?>' type="applyTree"></loo-tree></span>
            <label><input type="checkbox" class="include-subfolders" checked><i class="icon icon-file-symlink-directory"></i></label>
          </div>
          <div class="editchecked">Markierte (<span class="checkCount">0</span>): 
            <button class="deleteChecked">löschen</button>
            <button class="addLabelsToChecked"     >Labels hinzufügen</button> <span class="editChecked"><button class="ok">OK</button><button class="cancel">Cancel</button></span>
            <button class="removeLabelsFromChecked">Labels entfernen</button>  <span class="editChecked"><button class="ok">OK</button><button class="cancel">Cancel</button></span>
            <button class="addStatusToChecked"     >Status hinzufügen</button> <span class="editChecked"><button class="ok">OK</button><button class="cancel">Cancel</button></span>
            <button class="removeStatusFromChecked">Status entfernen</button>  <span class="editChecked"><button class="ok">OK</button><button class="cancel">Cancel</button></span>
          </div>
          
          <p class="filterResults"></p>
          <table class="bookmarkTable">
            <thead><tr>
              <th class="sorter-false" style="width:4em"></th>
              <th class="sorter-false" style="width:1.6em"><input class="checkAll" type='checkbox'></th>
              <th>Bookmark</th>
              <th class="modified">Mod</th><!--th>Add</th-->
              <th class="filter-match" style="width:4em"><i class="icon icon-clipboard2"></i></th>
              <th class="labelheader labels filter-match"><i class="icon icon-label"></i></th>
            </tr></thead>
            <tbody></tbody>
          </table>
        </div>
    </div> <!-- #main -->
</div> <!-- #main-container -->
<?php include '../php/prefooterscripts.inc.php';?>
<script>
  var looD = {};
  var bookmarksfile = "<?=$bookmarks?>"
  var bookmarkspath = bookmarksfile.slice(3); //ohne ../
  loadBookmarks();
  function loadBookmarks() {
    $.getJSON(bookmarksfile)
    .done(function(bookmarksJson) {
      looD.bookmarks = bookmarksJson;
      findDuplicates();
      createTable();
      $(".include-x").on("change", createTable);
    });
  }
    
  $(".toggleTree").on("click", function(e) {$(this).closest(".treeSelect").toggleClass("show");});
  $("loo-tree").on("recheck", function(e) {
    $(this).closest(".treeSelect").removeClass("show");
    createTable();
  });
  $(".searchstring").on("input", createTable);
  $(".include-x, .include-subfolders").on("change", createTable);
  
  function filterBookmarks() {
    var filtered = looD.bookmarks.filter(function(b) {return $(".include-x:checked").length?true:(!b.status || b.status.indexOf("x") == -1);});
    var searchstring = $(".searchstring").val().toLowerCase();
    var labels = $(".treeSelect loo-tree")[0].tree.getChecked(false, $(".include-subfolders:checked").length);
    var searchIn = ["title", "href", "details", "status", "labels"]
    if(searchstring.length >= 3) {
      filtered = filtered.filter(function(b) {
        return searchIn.filter(function(prop) {return b[prop] && b[prop].toLowerCase().indexOf(searchstring) > -1;}).length;
      });
    }
    if(labels.length) {
      filtered = filtered.filter(function(b) {
        return labels.filter(function(l) {return b.labels && b.labels.split(",").indexOf(l) > -1;}).length;
      });
    }
    if(searchstring.length < 3 && !labels.length) {
      filtered = [];
    }
    $(".filterResults").html("<span style='background-color: #ccddff;'>" + $(".treeSelect loo-tree")[0].tree.getChecked(false, false) + "</span> " +  filtered.length + " of " + looD.bookmarks.length + " Bookmarks selected")
    return filtered;
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

  function createTable() {
    var filteredBookmarks = filterBookmarks();
    _.templateSettings = {interpolate: /\{\{(.+?)\}\}/g}; // {{test}}
    var rowTemplate = _.template("<tr data-title='{{_.escape(b.title)}}'>"+
    "<td class='preview' data-href='{{b.href}}'><img src='{{getIconPath(b)}}' style='width:16px; height:16px;'></td>"+
    "<td class='boxes'><input class='checkMe' type='checkbox'></td>"+
    "<td class='bookmark__descriptions'>"+
      "<span data-type='title' class='bookmark__title' title='{{b.title}}'>{{b.title.slice(0,40)+(b.title.length>40?'...':'')}}</span><br>"+
      "<span data-type='details' class='details' title='{{b.details}}'>{{b.details?b.details.slice(0,40)+'...</span><br>':'</span>'}}"+
      "<span data-type='href' class='href' title='{{b.href}}'>{{b.href.slice(b.href.indexOf('://') + 3, b.href.indexOf('/', b.href.indexOf('://') + 5))}}</span>"+
    "</td>" +
    "<td class='modified'>{{getDateFromDOb(new Date(b.mod*1000)).slice(0,10)}}</td>" + // "<td>{{getDateFromDOb(new Date(b.add*1000))}}</td>" +
    "<td class='status'>{{b.status?b.status.split(','):'-'}}</td>"+
    "<td class='labels' data-labels='{{b.labels}}'>{{labels}}</td>"+
    "</tr>");
    var $bookmarkTable = $(".bookmarkTable")[filteredBookmarks.length ? "show" : "hide"]();
    var $bookmarkTableBody = $bookmarkTable.find("tbody").empty();
    var b, notInInfos, preview, labels;
    for(var i = 0; i< filteredBookmarks.length; i++) {
      b = filteredBookmarks[i];
      //preview = f.folder == "img"?"<img width=50 height=30 src='"+src+"'>":"<iframe width=50 height=30 src='"+src+"'></iframe>";
      //info = f.folder == "img"?"imgsize...":"";
      labels = (b.labels?b.labels.split(",").reduce(function(old,el,i){return old + "<span class='label' data-label='"+el+"'>"+el+"&nbsp;<i class='removeLabel icon-x'></i></span>";}, ""):"") + "<span class='showLabels'>+++</span><button class='ok'>ok</button><button class='cancel'>cancel</button>";
      $bookmarkTableBody.append(rowTemplate({b: b, labels: labels}))
    }
    //$bookmarkTable.off("click.updateCms").on("click.updateCms", ".updateCms", updateCms);
    //$bookmarkTable.off("click.labels").on("click.labels", ".showLabels", chooseLabel);
    $bookmarkTable.off("click.preview").on("click.preview", ".preview", showPreview);
    $bookmarkTable.off("click.removeLabel").on("click.removeLabel", ".removeLabel", removeLabel);
    $bookmarkTable.off("click.rename").on("click.rename", ".bookmark__descriptions span:not(.edit)", renameDialog);
    $bookmarkTable.off("change.checkAll").on("change.checkAll", ".checkAll", function() {$bookmarkTable.find("tr:not(.filtered)").find(".checkMe").prop("checked", $(this).prop("checked")); countChecked();});
    //$bookmarkTable.off("click.labelChoice").on("click.labelChoice", ".labelheader:not(.edit)", filterLabel);
    $bookmarkTable.off("click.changeCheck").on("click.changeCheck", ".checkMe", countChecked);
    setTimeout(function() {$(".info").each(function(){
        if($(this).text().indexOf("imgsize")>=0) {
          var w = $(this).closest("tr").find("img")[0].naturalWidth;
          var h = $(this).closest("tr").find("img")[0].naturalHeight;
          $(this).text(w + "x" + h);}
        })}, 2000)
    $bookmarkTable.tablesorter({theme: "dropbox", headerTemplate : '{content} {icon}', widgets: ["filter"]});
    $bookmarkTable.trigger("update", [true]);
    countChecked();
    //$.tablesorter.setFilters( $('.bookmarkTable') , looD.appliedFilters, true);
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
//    createTable();
//  }
  
//  function filterLabel(e) {
//    var $cell = $(this).addClass("edit");
//    var $tree = $("<loo-tree src='<?=$srcTree?>' checklist='"+looD.checkedLabels+"'></loo-tree>").appendTo($cell);
//    $cell.find(".ok").off("click.ok").on("click.ok", filterLabels.bind(this, $tree[0]));
//    $cell.find(".cancel").off("clickCancel").on("click.cancel", closeLabel.bind(this));
//  }
  
//  function filterLabels(tree) {
//    looD.appliedFilters = $.tablesorter.getFilters($('.bookmarkTable'));
//    looD.appliedFilters[$(this).index()] = tree.tree.getChecked(false, true).join("|");
//    looD.checkedLabels = tree.tree.getChecked(false, false).join(",");
//    $.tablesorter.setFilters( $('.bookmarkTable') , looD.appliedFilters, true);
//    closeLabel.call(this);
//  }
  
//  function chooseLabel() {
//    var $cell = $(this).closest("td").addClass("edit");
//    var $tree = $("<loo-tree src='<?=$srcTree?>' type='manageTree applyTree' checklist='"+$cell.data('labels')+"'></loo-tree>").appendTo($cell);
//    $cell.find(".ok").on("click", updateLabel.bind(this));
//    $cell.find(".cancel").on("click", closeLabel.bind(this));
//    //$tree[0].addEventListener("recheck", updateLabel.bind(this));  
//  }

  function showPreview() {
    var $iframe  = $("<iframe width='100%' height='600px' src='"+$(this).data("href")+"'></iframe>"); //.on("load", function(e) {$(this)[0].src = "javascript:(function(){alert(window.location.href);})();"; });//log($(this)[0].contentWindow.history);});
    $("<tr>").append($("<td colspan='6'></td>").append($iframe)).insertAfter($(this).closest("tr"));
    $("<tr>").append($("<td colspan='6'></td>").append($iframe)).insertAfter($(this).closest("tr"));
  }
  
  function updateLabel(e) {
    var $cell = $(this).closest("td");
    var title = $(this).closest("tr").data("title");
    var content = _.findWhere(looD.bookmarks, {title: title});
    content.labels = $cell.find("loo-tree").attr("checklist");
    $.post("../php/saveSafeCentral.php", {code: localStorage.looopCode, path: bookmarkspath, task: "JSONupdate", key:"title", value: title, content: content}, responseAnalyzer).then(createTable);
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
    $.post("../php/saveSafeCentral.php", {code: localStorage.looopCode, path: bookmarkspath, task: "JSONupdate", key:"title", value: title, content: content}, responseAnalyzer).then(createTable);
  }
  
  function closeLabel(e) {
    var $cell = $(this).closest("td,th");
    setTimeout(function(){$cell.removeClass("edit")}, 0)
    $cell.find("loo-tree").remove();
  }
  
  function renameDialog() {
    var title = $(this).closest("tr").data("title");
    var $el = $(this).addClass("edit");
    log($(this).data("title"))
    var oldtext = $(this).text();
    var oldval = $(this).attr("title");
    var type = $(this).data("type");
    var $input = $("<input value='"+oldval+"'>").appendTo($el.empty());
    var $ok = $("<button>OK</button>").appendTo($el);
    var $cancel = $("<button>cancel</button>").appendTo($el);
    $cancel.on("click", function() {$el.empty().text(oldtext).removeClass("edit")});
    $ok.on("click", function() {
      var content = _.findWhere(looD.bookmarks, {title: title});
      content[type] = $input.val();  
      $.post("../php/saveSafeCentral.php", {code: localStorage.looopCode, path: bookmarkspath, task: "JSONupdate", key:"title", value: title, content: content}, responseAnalyzer).then(createTable);
    });
  }
  
// Markierte
$("div.editchecked>button").on("click", function(){$(this).addClass("edit");})

$("div.editchecked").find("button.cancel, button.ok").on("click", function(){
  $(this).closest("span").prevAll("button.edit").removeClass("edit");
  $(this).closest("span").find(".temp").remove();
});
  



function countChecked() {
  var numChecked = $("tr:not(.filtered)").find(".checkMe:checked").length
  $(".checkCount").text(numChecked);
  $(".editchecked")[numChecked>0 ? "show" : "hide"]();
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
  $.post("../php/saveSafeCentral.php", {code: localStorage.looopCode, task: "save", path: bookmarkspath, content: JSON.stringify(looD.bookmarks)}, createTable);
}

</script>
<?php include '../php/footer.inc.php';?>
