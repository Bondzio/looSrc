function Tree(jsonPath, $ul) {
  var that = this;
  this.path = jsonPath;
  this.$ul = $ul;
  this.$ul.on("dragover", "li", this.allowDrop.bind(this));
  this.$ul.on("drop", "li", this.onDrop.bind(this));
  this.$ul.on("dragstart", "li.label", this.onDragStart.bind(this));
  this.$ul.on("dragenter", "li.pasteBefore", function(){$(this).addClass("draghover")});
  this.$ul.on("dragleave", "li.pasteBefore", function(){$(this).removeClass("draghover")});
  
  this.$ul.on("click", ".icon-triangle-up",   function() {that.moveUp(   $(this).closest('li').data('name')); that.update();});
  this.$ul.on("click", ".icon-triangle-down", function() {that.moveDown( $(this).closest('li').data('name')); that.update();});
  this.$ul.on("click", ".icon-triangle-left", function() {that.moveLeft( $(this).closest('li').data('name')); that.update();});
  this.$ul.on("click", ".icon-triangle-right",function() {that.moveRight($(this).closest('li').data('name')); that.update();});
  
  this.$ul.on("click", ".pasteBefore", function() {$(this).addClass("add");});
  this.$ul.on("click", ".pasteBefore.add button.ok", this.add.bind(this));
  
  this.reset();
}

Tree.prototype.NAME = 0;
Tree.prototype.SUBTREE = 1;
Tree.prototype.COLLAPSED = 2;

Tree.prototype.reset = function(){
  $.getJSON(this.path).then(this.analyzeTree.bind(this))
}

Tree.prototype.analyzeTree = function(jsondata) {
  this.tree = jsondata;
  this.labels = this.getLabelNames();
  this.renderTree();
}

Tree.prototype.getLabelNames = function() {
  return _.flatten(this.tree);
}

Tree.prototype.renderTree = function($ul, subtree) {
  var $ul = $ul || this.$ul;
  var tree = subtree || this.tree[0][this.SUBTREE];
  var that = this;
  $ul.empty();
  _.each(tree, function(item) {
    var $liBefore = $("<li class='pasteBefore' data-name='"+ item[that.NAME]+"'><span><i class='icon icon-plus'></i>&nbsp;<input name='newItem'><button class='ok'>ok</button></span></li>").appendTo($ul);
    var $li= $("<li class='label' draggable='true' data-name='"+ item[that.NAME]+"'><span>"+item[that.NAME]+ " <i class='icon icon-triangle-left'></i> <i class='icon icon-triangle-right'></i> <i class='icon icon-triangle-up'></i> <i class='icon icon-triangle-down'></i></span></li>").appendTo($ul);
    var $ulSub = $("<ul></ul>").appendTo($li);
    if(item[that.SUBTREE].length && !item[that.COLLAPSED]) that.renderTree($ulSub, item[that.SUBTREE]);
  }); 
}

Tree.prototype.getPathOfElement = function(label, subtree) {
  var tree = subtree || this.tree;
  for (var i=0; i < tree.length; i++) {
    var item = tree[i]; 
    if(item[this.NAME] === label) return [label];
    var branch = this.getPathOfElement(label, item[this.SUBTREE]);
    if(branch !== false) {
      branch.unshift(item[this.NAME]);
      return branch;
    }
  }
  return false;
}

Tree.prototype.getNumericPathOfElement = function(label, subtree) {
  var tree = subtree || this.tree;
  for(var i=0; i < tree.length; i++) {
    var item = tree[i]; 
    if(item[this.NAME] === label) return [i];
    var branch = this.getNumericPathOfElement(label, item[this.SUBTREE]);
    if(branch !== false) {
      branch.unshift(i);
      return branch;
    }
  }
  return false;
}

//Tree.prototype.getItemFromNumericPath = function(label, subtree) {
//  var tree = subtree || this.tree;
//  for(var i=0; i < tree.length; i++) {
//    var item = tree[i]; 
//    if(item[this.NAME] === label) return [i];
//    var branch = this.getNumericPathOfElement(label, item[this.SUBTREE]);
//    if(branch !== false) {
//      branch.unshift(i);
//      return branch;
//    }
//  }
//  return false;
//}

Tree.prototype.getParentOfElement = function(label) {
  var p = this.getPathOfElement(label);
  return p.length>1?p[p.length-2]:null;
}

Tree.prototype.doWithItem = function(name, callback) {
  var that=this;
  this.doWithEach(function(item){if(item[that.NAME]===name){return callback(item);};})
}

Tree.prototype.doWithEach = function(callback, subtree) {
  var tree = subtree || this.tree;
  var that = this;
  _.each(tree, function (item) {
    callback(item);
    if (item[that.SUBTREE].length) that.doWithEach(callback, item[that.SUBTREE])
  });
}

Tree.prototype.getItemObjFromName = function(label, subtree) {
  var tree = subtree || this.tree;
  for (var i in tree) {
    var item = tree[i];
    if(item[this.NAME] === label) return item;
    var branch = this.getItemObjFromName(label, item[this.SUBTREE]);
    if(branch !== false) {
      return branch;
    }
  }
  return false;
}

Tree.prototype.moveUp = function(element) {
  var p = this.getItemObjFromName(this.getParentOfElement(element));
  if(!p) return log("no parent found");
  for(var me=0; me<p[this.SUBTREE].length; me++) {      
    if(p[this.SUBTREE][me][this.NAME] == element) {
      moveInArray(p[this.SUBTREE], +me, +me-1);
      return;
    }
  }
}

Tree.prototype.moveDown = function(element) {
  var p = this.getItemObjFromName(this.getParentOfElement(element));
  if(!p) return log("no parent found");
  for(var me=0; me<p[this.SUBTREE].length; me++) {      
    if(p[this.SUBTREE][me][this.NAME] == element) {
      moveInArray(p[this.SUBTREE], me, me+1)
      return;
    }
  }
}

Tree.prototype.moveLeft = function(element) {
  var p = this.getItemObjFromName(this.getParentOfElement(element));
  if(!p) return log("no parent found");
  if(this.getNumericPathOfElement(p[this.NAME]).length <= 1) {log("is already on top level"); return;}
  var grandparent = this.getItemObjFromName(this.getParentOfElement(p[this.NAME]));
  for(var me=0; me<p[this.SUBTREE].length; me++) {      
    if(p[this.SUBTREE][me][this.NAME] == element) {
      var toMove = p[this.SUBTREE].splice(me, 1)[0];
      grandparent[this.SUBTREE].splice([this.getNumericPathOfElement(p[this.NAME])[this.getNumericPathOfElement(p[this.NAME]).length-1]+1], 0, toMove);
      break;
    }
  }
}

Tree.prototype.moveRight = function(element) {
  var p = this.getItemObjFromName(this.getParentOfElement(element));
  if(!p) return log("no parent found");
  for(var me=0; me<p[this.SUBTREE].length; me++) {      
    if(p[this.SUBTREE][me][this.NAME] == element) {
      if(me==0) {log("cannot nest first entry, move down first"); return;}
      var toMove = p[this.SUBTREE].splice(me, 1)[0];
      p[this.SUBTREE][me-1][this.SUBTREE].push(toMove);
      break;
    }
  }
}

function moveInArray(targetArray, indexFrom, indexTo) {
  if(indexTo <0 || indexTo>targetArray.length-1) {log("indexTo out of bounds"); return;}
  var step = sign(indexTo - indexFrom);
  var targetElement = targetArray[indexFrom]; 
  for (var Element = +indexFrom; Element != +indexTo; Element += step){
      targetArray[Element] = targetArray[Element + step]; 
  }
  targetArray[indexTo] = targetElement;
}

Tree.prototype.spliceElement = function(element) {
  var p = this.getItemObjFromName(this.getParentOfElement(element));
  for(var me=0; me<p[this.SUBTREE].length; me++) {      
    if(p[this.SUBTREE][me][this.NAME] == element) {
      return p[this.SUBTREE].splice(me, 1)[0];
    }
  }
}

Tree.prototype.pasteElementAtPath = function(target, path, before) {
  var pos = this.tree[0];
  for(var i = 1; i < path.length-(before?1:0); i++) {
    pos = pos[this.SUBTREE][path[i]];
  }
  if(before) {
    pos[this.SUBTREE].splice(path[path.length-1], 0, target);
  }
  else {
    pos[this.SUBTREE].push(target);
  }
}

Tree.prototype.onDrop = function(e) {
  var el = $(e.currentTarget);
  var a = el.data("name");
  var from = e.originalEvent.dataTransfer.getData("text");
  var toMove = this.spliceElement(from);
  var before = el.hasClass("pasteBefore");
  var path = this.getNumericPathOfElement(a);
  this.pasteElementAtPath(toMove, path, before);
  //log(a, before, from, toMove, path);
  this.update();
  e.preventDefault();
  e.stopPropagation();
}

Tree.prototype.onDragStart = function(e) {
  e = e.originalEvent;
  e.dataTransfer.setData("text", $(e.target).data("name"));
  e.stopPropagation();
}

Tree.prototype.allowDrop = function(e) {
  log(e)
  if(e.originalEvent.dataTransfer.getData("text") == $(e.currentTarget).data("name")) {return true;}
  e.preventDefault();
  return false;
}

Tree.prototype.save = function() {
  //log("save", this.tree);
  //log(JSON.stringify(this.tree))
  return $.post("../php/saveSafeCentral.php", {path: this.path.slice(3), content: JSON.stringify(this.tree), task: "JSONreplace", code: localStorage.looopCode});
}

Tree.prototype.update = function() {
  this.renderTree();
  this.save().then(function(data){log(data);});
}

Tree.prototype.add = function(e) {
  log("add", e);
  var el = $(e.currentTarget);
  var a = el.closest(".pasteBefore").find("input").val();
  log("add", a);
  var before = true;
  var path = this.getNumericPathOfElement(el.closest(".pasteBefore").data("name"));
  this.pasteElementAtPath([a, []], path, before);
  this.update();
}