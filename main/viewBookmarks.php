<?php include '../php/header.inc.php';?>
<style>
  .list {font-size: 0.8em;}
  
  .bookmark {background-color: #ccddff; margin: 0.5em 0;}
  .bookmark.x {background-color: #eeeeee;}
  .bookmark.z {background-color: #ddeeff;}
  .bookmark.w {background-color: #ccffcc;}
  .bookmark.y {background-color: #ffffbb;}
  .bookmark.n {background-color: #ffeecc;}
  
  .bookmark__labels {font-size: 0.8em;}
  .bookmark__labels button {display:none;}
  .bookmark__labels.edit button {display:inline-block;}
  .bookmark__labels.edit .bookmark__chooseNewLabel {display:none;}
  .bookmark__labels .label {color: white; background-color: #000; display: inline-block; border-radius: 2px; margin: 0.15em; padding: 0 0.3em;}
  
  .bookmark__icon img     {width: 100%;}
  .bookmark__check input  {width: 100%;}
  .bookmark__description>div {overflow: hidden;}
  
  .bookmark__icon         {vertical-align: top; display:inline-block; width: 1.5em;}
  .bookmark__check        {vertical-align: top; display:inline-block; width: 1.5em;}
  .bookmark__description  {vertical-align: top; display:inline-block; width: calc(84% - 9em);}
  /*.bookmark__status       {vertical-align: top; display:inline-block; width: 2em;}*/
  .bookmark__labels       {vertical-align: top; display:inline-block; width: calc(6em + 14%);}
  /*.bookmark__modified     {display:inline-block; width: 5em; font-size: 0.8em;}*/
  
  .bookmark__title {font-weight: semi-bold;}
  .bookmark__details {font-size: 80%;}
  .bookmark__href {font-size: 80%; color: #1B67AD;}
  
  .bookmark__edit {display:none;}
  .bookmark.edit .bookmark__edit {display:block; margin: 0.2em 0 0.2em 3em;}
  .bookmark.edit .bookmark__details {width: 100%; height: 1.5em;}
  
  .toggle-status {background: none; border: 0.1em solid black;}
  .bookmark.x .toggle-x {background-color: black; color: white;}
  .bookmark.z .toggle-z {background-color: black; color: white;}
  .bookmark.w .toggle-w {background-color: black; color: white;}
  .bookmark.y .toggle-y {background-color: black; color: white;}
  
  
  .editchecked {font-size: 0.7em; display:none;}
  button+span.editChecked{display: none;}
  button.edit+span.editChecked{display: inline-block;}
  
  .filterTree {display: none;}
  .filterTree.show {display: block;}
  
  .filter-status[data-val='1'] {background-color: #000; color: #fff;}
  .filter-status[data-val='0'] {background-color: #ddd; color: #b55; text-decoration: line-through;}
  
  @media only screen and (max-width: 640px) {
    .bookmarks--check {display:none;}
    .bookmark__check {display:none; }
    .bookmark__icon {display:inline-block; width: 3em;}
  }
</style>
<?php include '../php/postheader.inc.php';

$tree = filter_input(INPUT_GET, "tree", FILTER_SANITIZE_STRING);
if($tree === "web") {
  $srcTree = "../cms/weblabels.json";
  $bookmarkstable = "bookmarksWeb";
}
//else if($tree === "physics") {}
else {
  $tree = "physics";
  $srcTree = "../cms/labels.json";
  $bookmarkstable = "bookmarksPhysics";
}
?>
<div class="main-container">
  <div class="main wrapper clearfix">
    <div>
      <header>
        <h2><img alt="Loooping" src="../img/loooping.svg" style="width:1.6em; margin-right: 0.4em;">Bookmarks Viewer</h2>
      </header>

      <div>
        <label><input type="text" class="searchstring"></label>
        <span class="treeSelect"><button class="toggleTree">Tree</button><loo-tree class="filterTree" src='<?=$srcTree?>' type="applyTree"></loo-tree></span>
        <button class="filter-status filter-w" data-val="2" data-which="w">w</button>
        <button class="filter-status filter-x" data-val="0" data-which="x">x</button>
        <button class="filter-status filter-y" data-val="2" data-which="y">y</button>
        <button class="filter-status filter-z" data-val="2" data-which="z">z</button>
        <label><input type="checkbox" class="include-subfolders" checked><i class="icon icon-file-symlink-directory"></i></label>
        <select class='sort' name='sort'>
          <option value='labels'>Label</option>
          <option value='title'>Titel</option>
          <option value='details'>Details</option>
          <option value='status'>Status</option>
          <option value='modified'>Geändert</option>
        </select>
      </div>

      <p class="filterResults"></p>
      
      <p class="bookmarks--check"><label><input class="checkAll" type='checkbox'> Check All</label></p>
      <div class="bookmarks--check editchecked">Markierte (<span class="checkCount">0</span>): 
        <button class="deleteChecked">löschen</button>
        <button class="addLabelsToChecked"     >Labels hinzufügen</button> <span class="editChecked"><button class="ok">OK</button><button class="cancel">Cancel</button></span>
        <button class="removeLabelsFromChecked">Labels entfernen</button>  <span class="editChecked"><button class="ok">OK</button><button class="cancel">Cancel</button></span>
        <button class="addStatusToChecked"     >Status hinzufügen</button> <span class="editChecked"><button class="ok">OK</button><button class="cancel">Cancel</button></span>
        <button class="removeStatusFromChecked">Status entfernen</button>  <span class="editChecked"><button class="ok">OK</button><button class="cancel">Cancel</button></span>
      </div>
   
      <div class="bookmark--template template">
        <div class="bookmark__icon"></div><div class="bookmark__check"><input class='checkMe' type='checkbox'></div><div class="bookmark__description">
          <div class="bookmark__title changeMe" data-type='title'></div>
          <div class="bookmark__details changeMe" data-type='details'></div>
          <div class="bookmark__href changeMe" data-type='href'></div><a class="bookmark__link" href=''>-></a>
        </div>
        <!--div class="bookmark__modified"></div-->
        <!--div class="bookmark__status"></div-->
        <div class="bookmark__labels"></div>
        <div class="bookmark__edit">
          <button class="toggle-status toggle-w" data-which="w">w</button>
          <button class="toggle-status toggle-x" data-which="x">x</button>
          <button class="toggle-status toggle-y" data-which="y">y</button>
          <button class="toggle-status toggle-z" data-which="z">z</button>
          <button class="bookmark__delete"><i class="icon icon-trashcan"></i></button>
        </div>
      </div>
      
      <div class="list"></div>

    </div>
  </div> <!-- #main -->
</div> <!-- #main-container -->
<?php include '../php/prefooterscripts.inc.php';?>
<script>

var looD = {};
var tree = "<?=$tree?>";
var bookmarkstable = "<?=$bookmarkstable?>";

window.addEventListener('polymer-ready', loadBookmarks);

function loadBookmarks() {
  $.post("../php/dbCentral.php", {code: localStorage.looopCode, table: bookmarkstable, task: "getJson"}).then(function(d) {
    //getState();
    looD.bmJson = JSON.parse(d);
    renderSelectedBookmarks();
    findDuplicates();
  });
  getState();
}

//Event Listeners for Search, Filter And Sort
$(".toggleTree").on("click", function()   {if(!$(".filterTree").hasClass("show")) {$(".filterTree")[0].tree.uncheckAll();} $(".filterTree").toggleClass("show");});
$(".filterTree").on("recheck", function() {$(".filterTree").removeClass("show"); renderSelectedBookmarks();});
$(".filter-status").on("click", function(){var neu = (+$(this).data("val")+1)%3; $(this).data("val", neu).attr("data-val", neu); renderSelectedBookmarks();});
$(".searchstring").on("input", renderSelectedBookmarks);
$(".include-subfolders").on("change", renderSelectedBookmarks);
$(".sort").on("change", renderSelectedBookmarks);

//Event Listeners for Single Bookmarks
var $list = $(".list");
$list.on("mousedown touchstart", ".bookmark__icon", function(e){bookmarkFromTarget($(this)).startTimer(); e.preventDefault();});
$list.on("mouseup touchend", ".bookmark__icon",     function() {bookmarkFromTarget($(this)).preview();});
$list.on("change", ".checkMe",                      function() {bookmarkFromTarget($(this)).$div.removeClass("edit").addClass($(this).is(":checked")?"edit":"");});
$list.on("click", ".bookmark__chooseNewLabel",      function() {bookmarkFromTarget($(this)).chooseNewLabel();});
$list.on("click", ".bookmark__updateLabel",         function() {bookmarkFromTarget($(this)).updateLabel();});
$list.on("click", ".bookmark__closeLabelChooser",   function() {bookmarkFromTarget($(this)).closeLabelChooser();});
$list.on("click", ".bookmark__removeLabel",         function() {bookmarkFromTarget($(this)).removeLabel($(this).closest(".label").data("label"));});
$list.on("click", ".bookmark .changeMe:not(.edit)", function() {bookmarkFromTarget($(this)).renameDialog(this);});
$list.on("click", ".toggle-status",                 function() {bookmarkFromTarget($(this)).toggleStatus($(this).data("which"));});
$list.on("click", ".bookmark__delete",              function() {bookmarkFromTarget($(this)).delete();});

function renderSelectedBookmarks() {
  looD.bookmarks = looD.bmJson.map(function(b) {return new Bookmark(b);});
  var $list = $(".list").empty();
  var filtered = filterBookmarks();
  var sorted = sortBookmarks(filtered)
  if(sorted.length > 100) {sorted = sorted.slice(0,100); log("more than 100 Bookmarks!");}
  sorted.forEach(function(b) {$list.append(b.render());});
  countChecked();
}

function filterBookmarks() {
  var filtered = looD.bookmarks;
  filterStatus = {};
  $(".filter-status").each(function(e) {
    f = {which: $(this).data("which"), val: $(this).data("val")};
    filterStatus[$(this).data("which")] = $(this).data("val");
    filtered = filtered.filter(function(b) {return f.val == 2 ? true : (f.val == 1 ? (b.status && b.status.indexOf(f.which) > -1) : (!b.status || b.status.indexOf(f.which) == -1));});
  });
  var includeSubfolders = !!$(".include-subfolders:checked").length;
  var searchstring = $(".searchstring").val().toLowerCase();
  var checkedLabels = $(".filterTree")[0].tree ? $(".filterTree")[0].tree.getChecked(false, false) : "";
  var labels = $(".filterTree")[0].tree ? $(".filterTree")[0].tree.getChecked(false, includeSubfolders) : "";
  var searchIn = ["title", "href", "details", "status", "labels"];
  filtered = filtered.filter(function(b) {
    return searchIn.filter(function(prop) {return b[prop] && b[prop].toLowerCase().indexOf(searchstring) > -1;}).length;
  });
  if(labels.length) {
    filtered = filtered.filter(function(b) {
      return labels.filter(function(l) {return b.labels && b.labels.split(",").indexOf(l) > -1;}).length;
    });
  }
  $(".filterResults").html("<span style='background-color: #ccddff;'>" + checkedLabels + "</span> " +  filtered.length + " / " + looD.bookmarks.length);
  saveState({searchstring: searchstring, labels: checkedLabels, includeSubfolders: includeSubfolders, filterStatus: filterStatus}); //schöner mit ES6
  return filtered;
}

function sortBookmarks(bmlist) {
  looD.sortlist = (looD.sortlist || []).filter(function(s) {return s !== $(".sort").val()}).concat([$(".sort").val()]);
  for(var i = 0; i<looD.sortlist.length; i++) {
    var crit = looD.sortlist[i];
    if(crit == "modified") {
      bmlist = bmlist.sort(function(bm1, bm2) {return sign(bm1[crit] - bm2[crit]);})
    }
    if(crit == "labels") {
      var tree = $(".filterTree")[0].tree;
      checked = tree.getChecked();
      bmlist = bmlist.sort(function(bm1, bm2) {
        l1 = bm1.labelArray && bm1.labelArray.filter(function(l){return checked.length==0 || checked.filter(function(c) {return tree.isElementDescendantOf(l, c);}).length;}) || [];
        l2 = bm2.labelArray && bm2.labelArray.filter(function(l){return checked.length==0 || checked.filter(function(c) {return tree.isElementDescendantOf(l, c);}).length;}) || [];
        return tree.labels.indexOf(l1[0]) - tree.labels.indexOf(l2[0]);
      })
    }
    else {
      bmlist = bmlist.sort(function(bm1, bm2) {return bm1[crit] > bm2[crit] ? +1 : (bm1[crit] < bm2[crit] ? -1 : (bmlist.indexOf(bm1) > bmlist.indexOf(bm2)? +1 : -1));});
    }
  }
  return bmlist;
}

function findDuplicates() {
  looD.bookmarks.forEach(function(b) {
    looD.bookmarks.forEach(function(c) {
      if(b===c) return;
      if(b.title === c.title) {log ("duplicateTitle:", b.title);}
      if(b.href === c.href) {log ("duplicateHref:", b.href);}
    });
  });
}

function Bookmark(bookmarkObj) {
  var b = this;
  b = $.extend(b, bookmarkObj);
  b.originalJson = bookmarkObj;
  b.labelArray = b.labels ? b.labels.split(",") : [];
}

Bookmark.prototype.$template = $(".bookmark--template").clone().removeClass("bookmark--template template").addClass("bookmark");

Bookmark.prototype.getIconPath = function() {
  return ("http://www.google.com/s2/favicons?domain=" + this.href.slice(this.href.indexOf('://') + 3, this.href.indexOf('/', this.href.indexOf('://') + 5)));
};

Bookmark.prototype.render = function() {
  var b = this;
  b.$div = b.$template.clone().data("title", b.title);
  b.$div.find(".bookmark__icon").append("<img src='" + b.getIconPath() + "'>");
  b.$div.find(".checkMe").prop("checked", looD.checkedTitles.indexOf(b.title) >= 0);
  b.$div.find(".bookmark__title").html(b.title);
  b.$div.find(".bookmark__details").html(b.details);
  b.$div.find(".bookmark__href").text(b.href.slice(b.href.indexOf('://') + 3, b.href.indexOf('/', b.href.indexOf('://') + 5)));
  b.$div.find(".bookmark__link").attr("href", b.href);
  b.$div.addClass(b.status?b.status.split(',').join(" "):"n");
  //b.$div.find(".bookmark__status").text(b.status?b.status.split(','):'-');
  b.$div.find(".bookmark__modified").text(getDateFromDOb(new Date(b.mod*1000)).slice(0,10));
  b.$div.find(".bookmark__labels").data("labels", b.labels)
    .html(b.labelArray.reduce(function(old,el,i){return old + "<span class='label' data-label='"+el+"'>"+el+"&nbsp;<i class='bookmark__removeLabel icon-x'></i></span> ";}, "") +
          "<span class='bookmark__chooseNewLabel'>+++</span><button class='ok bookmark__updateLabel'>ok</button><button class='cancel bookmark__closeLabelChooser'>cancel</button>");
  return b.$div;
};

Bookmark.prototype.startTimer = function() {this.clickstart = $.now(); };
Bookmark.prototype.preview = function() {
  var b = this;
  if(!b.clickstart) return;
  var clicklength = $.now() - b.clickstart;
  if(clicklength < 300) {
    if(b.$iframe) {
      b.$div.removeClass("edit");
      b.$iframe.remove();
      b.$iframe = null;
    }
    else {
      b.$iframe  = $("<iframe width='100%' height='400px' src='" + b.href + "'></iframe>").appendTo(b.$div);
      b.showEdit();
    }
  }
  else if(clicklength < 10000) {
    var win = window.open(b.href, '_blank');
    win.focus();
    b.showEdit();
  }
  b.clickstart = null;
};

Bookmark.prototype.showEdit = function() {
  this.$div.addClass("edit");
};

Bookmark.prototype.chooseNewLabel = function() {
  var b = this;
  $("<loo-tree src='<?=$srcTree?>' type='manageTree applyTree' checklist='"+b.labels+"'></loo-tree>").appendTo(b.$div.find(".bookmark__labels").addClass("edit"));
};

Bookmark.prototype.updateLabel = function() {
  var b = this;
  b.$div.find("loo-tree").attr("checklist").split(",").forEach(function(l) {b.addLabel(l);});
  b.closeLabelChooser();
};

Bookmark.prototype.addLabel = function(labelname) {
  var b = this;
  if(b.labelArray.indexOf(labelname) === -1) {
    b.labelArray.push(labelname);
  }
  b.labels = b.originalJson.labels = b.labelArray.join(",");
  $.post("../php/dbCentral.php", {code: localStorage.looopCode, table: bookmarkstable, task: "UPDATE", values: [{key:"title", value: b.title, newValues: b.originalJson}]}, responseAnalyzer).then(renderSelectedBookmarks);
};

Bookmark.prototype.closeLabelChooser = function() {
  var b = this;
  b.$div.find("loo-tree").remove();
  setTimeout(function(){b.$div.find(".bookmark__labels").removeClass("edit");}, 0);
};

Bookmark.prototype.removeLabel = function(labelname) {
  var b = this;
  b.labelArray.splice(b.labelArray.indexOf(labelname), 1);
  b.labels = b.originalJson.labels = b.labelArray.join(",");
  $.post("../php/dbCentral.php", {code: localStorage.looopCode, table: bookmarkstable, task: "UPDATE", values: [{key:"title", value: b.title, newValues: b.originalJson}]}, responseAnalyzer).then(renderSelectedBookmarks);
};

Bookmark.prototype.renameDialog = function(element) {
  var b = this;
  var $el = $(element).addClass("edit");
  var oldtext = $el.text();
  var oldtitle = b.title;
  var type = $el.data("type");
  var $input = $("<input value='"+b[type]+"'>").appendTo($el.empty());
  var $ok = $("<button>OK</button>").appendTo($el);
  var $cancel = $("<button>cancel</button>").appendTo($el);
  $cancel.on("click", function() {$el.empty().text(oldtext).removeClass("edit");});
  $ok.on("click", function() {
    if(!!bookmarkFromTitle($input.val()) && $input.val() !== oldtitle) {
      return alert("Name existiert schon!");
    }
    b[type] = b.originalJson[type] = $input.val();  
    $.post("../php/dbCentral.php", {code: localStorage.looopCode, table: bookmarkstable, task: "UPDATE", values: [{key:"title", value: oldtitle, newValues: b.originalJson}]}, responseAnalyzer).then(renderSelectedBookmarks);
  });
};

Bookmark.prototype.toggleStatus = function(which) {
  var b = this;
  var statusarray = b.status ? b.status.split(",") : [];
  if(statusarray.indexOf(which) > -1) {
    statusarray.splice(statusarray.indexOf(which), 1);
  }
  else {
    statusarray.push(which);
  }
  b.status = b.originalJson.status = statusarray.join(",");
  $.post("../php/dbCentral.php", {code: localStorage.looopCode, table: bookmarkstable, task: "UPDATE", values: [{key:"title", value: b.title, newValues: b.originalJson}]}, responseAnalyzer).then(renderSelectedBookmarks);
};

Bookmark.prototype.delete = function() {
  var b = this;
  looD.bmJson.splice(looD.bmJson.indexOf(b.originalJson), 1);
  $.post("../php/dbCentral.php", {code: localStorage.looopCode, table: bookmarkstable, task: "DELETE", values: [{key:"title", value: b.title}]}, responseAnalyzer).then(renderSelectedBookmarks);
};

//Handle multiple Bookmarks
$list.on("click", ".checkMe", countChecked);
$("body").on("change", ".checkAll", function() {$list.find(".bookmark").find(".checkMe").prop("checked", $(this).prop("checked")); countChecked();});
$(".deleteChecked").on("click", deleteChecked);
$(".removeLabelsFromChecked").on("click", {prop: "labels"}, removePropertyFromChecked);
$(".removeStatusFromChecked").on("click", {prop: "status"}, removePropertyFromChecked);
$(".addStatusToChecked").on("click", {prop: "status"}, addPropertyToChecked);
$(".addLabelsToChecked").on("click", addLabelsToChecked);
$("div.editchecked>button").on("click", function(){$(this).addClass("edit");});
$("div.editchecked").find("button.cancel, button.ok").on("click", function(){
  $(this).closest("span").prevAll("button.edit").removeClass("edit");
  $(this).closest("span").find(".temp").remove();
});

function countChecked() {
  var checked = getChecked();
  looD.checkedTitles = checked.map(function(b) {return b.title;});
  saveState({checkedTitles: looD.checkedTitles});
  $(".checkCount").text(checked.length);
  $(".editchecked")[checked.length ? "show" : "hide"]();
}

function getChecked() {
  return $list.find(".checkMe:checked").get().map(function(el) {return bookmarkFromTarget($(el));});
}

function deleteChecked() {
  var itemarray = [];
  getChecked().forEach(function(b) {
    itemarray.push({key: "title", value: b.title});
    looD.bmJson.splice(looD.bmJson.indexOf(b.originalJson), 1);
  });
  $.post("../php/dbCentral.php", {code: localStorage.looopCode, task: "DELETE", table: bookmarkstable, values: itemarray}, responseAnalyzer).then(renderSelectedBookmarks);
}

function removePropertyFromChecked(e) {
  var prop = e.data.prop;
  var itemarray = [];
  var $editspan = $(this).next("span");
  var $propertyInput = $("<input class='temp'></>").appendTo($editspan);
  $editspan.find(".ok").off("click.save").on("click.save", function() {
    var removeProp = $propertyInput.val();
    getChecked().forEach(function(b) {
      if(!b.originalJson[prop]) return; //b.originalJson[prop] = "";
      b.originalJson[prop] = b[prop] = b.originalJson[prop].split(",").filter(function(el) {return el !== removeProp;}).join(",");
      itemarray.push({key: "title", value: b.title, newValues: $.extend({}, b.originalJson)});
    });
    $.post("../php/dbCentral.php", {code: localStorage.looopCode, task: "UPDATE", table: bookmarkstable, values: itemarray}, responseAnalyzer).then(renderSelectedBookmarks);
  });
}

function addPropertyToChecked(e) {
  var prop = e.data.prop;
  var itemarray = [];
  var $editspan = $(this).next("span");
  var $propertyInput = $("<input class='temp'></>").appendTo($editspan);
  $editspan.find(".ok").off("click.save").on("click.save", function() {
    var changeProp = $propertyInput.val();
    getChecked().forEach(function(b) {
      b.originalJson[prop] = b[prop] = (b[prop] ? b[prop].split(",") : []).filter(function(el) {return el !== changeProp;}).concat([changeProp]).join(",");
      itemarray.push({key: "title", value: b.title, newValues: $.extend({}, b.originalJson)});
    });
    $.post("../php/dbCentral.php", {code: localStorage.looopCode, task: "UPDATE", table: bookmarkstable, values: itemarray}, responseAnalyzer).then(renderSelectedBookmarks);
  });
}

function addLabelsToChecked() {
  var $editspan = $(this).next("span");
  var itemarray = [];
  var $tree = $("<loo-tree class='temp' src='<?=$srcTree?>'></loo-tree>").appendTo($editspan);
  $editspan.find(".ok").off("click.save").on("click.save", function() {
    var newLabels = $tree[0].tree.getChecked();
    getChecked().forEach(function(b) {
      newLabels.forEach(function(label) {if(b.labelArray.indexOf(label)<0) {b.labelArray.push(label);}});
      b.labels =  b.originalJson.labels = b.labelArray.join(",");
      itemarray.push({key: "title", value: b.title, newValues: $.extend({}, b.originalJson)});
    });
    $.post("../php/dbCentral.php", {code: localStorage.looopCode, task: "UPDATE", table: bookmarkstable, values: itemarray}, responseAnalyzer).then(renderSelectedBookmarks);
  });
}
  
function bookmarkFromTarget(target) {
  var title = target.closest(".bookmark").data("title");
  return bookmarkFromTitle(title);
}

function bookmarkFromTitle(title) {
  var selected = looD.bookmarks.filter(function(b) {return b.title === title;});
  if(selected.length > 1) {throw new Error("Duplicate title");}
  if(selected.length ===1) {return selected[0];}
  return false;
}

function getState() {
  looD.checkedTitles = [];
  if(localStorage[tree]) {
    try {
      var state = JSON.parse(localStorage[tree]);
      $(".searchstring").val(state.searchstring || "");
      $(".filter-x").attr("data-val", state.filterStatus.x).data("val", state.filterStatus.x);
      $(".filter-w").attr("data-val", state.filterStatus.w).data("val", state.filterStatus.w);
      $(".filter-y").attr("data-val", state.filterStatus.y).data("val", state.filterStatus.y);
      $(".filter-z").attr("data-val", state.filterStatus.z).data("val", state.filterStatus.z);
      $(".include-subfolders").prop("checked", state.includeSubfolders);
      $(".filterTree")[0].setAttribute("checklist", state.labels || "");
      $(".filterTree")[0].tree.buildTree();
      looD.checkedTitles = state.checkedTitles || [];
    }
    catch(e) {log("states not found");}
  }
}

function saveState(params) {
  localStorage[tree] = JSON.stringify($.extend(JSON.parse(localStorage[tree] || "{}"), params));
}

//  function importBookmarks() {
//    $.getJSON("../cms/bookmarksImport_1.json")
//    .done(function(bookmarksJson) {
//      looD.bookmarks = bookmarksJson;
//      looD.newBookmarks = [];
//      log(bookmarksJson);
//      rearrangeBookmarks(looD.bookmarks, "Web");
//      log(looD.newBookmarks);
//      $.post("../php/dbCentral.php", {code: localStorage.looopCode, table: bookmarkstable, task: "save", content: JSON.stringify(looD.newBookmarks)}, responseAnalyzer);
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
//
//function saveBookmarks() {
//  //log(looD.bookmarks);
//  $.post("../php/dbCentral.php", {code: localStorage.looopCode, task: "save", table: bookmarkstable, content: JSON.stringify(looD.bmJson)}, renderSelectedBookmarks);
//}

</script>
<?php include '../php/footer.inc.php';?>
