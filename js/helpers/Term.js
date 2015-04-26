function Term(termstring, scope){
  //var term = this;
  this.termstring = termstring;
  this.scope = scope || [];
  
  //Droid Serif Rendering Options
  this.rOpt = {
    signHeight: 0.65,
    signWidth: 0.5,
    strokeThickness: 0.035,
    fracReducer: 0.7,
    fracUpStandard: 0.50,
    fracDownStandard: 0.50,
    fracMargin: 0.1,
    fracNestOverlapTop: 1,
    fracNestOverlapBottom: 1.02,
    expReducer: 0.6,
    expUp: 0.45,
    expMargin: 0.1,
    accentUp: 0.1,
    indexReducer: 0.55,
    indexDown: 1
  };
  
  var sw = this.rOpt.signWidth;
  var sh = this.rOpt.signHeight;
  var st2 = this.rOpt.strokeThickness / 2;
  this.seq = [
  //  {type: "spaceBefore", seq: /^([\`\ ]+)/,         name: "hasSpaceBefore",   fn: function hasSpaceBefore(a) {return a;} },
  //  {type: "spaceAfter" , seq: /^([\´]+)/,           name: "hasSpaceAfter",    fn: function hasSpaceAfter(a)  {return a;} },
    {type: "operator", seq: /^(\+)/,     numArgs: 2, name: "add",              fn: function add(a,b) {return +a+b;}             , symbol: "+", precedence: 1, assocRight: 0, unicode: "&#x002b;", signWidth: this.rOpt.signWidth, svgArr: [[0,sh - st2],[sw/2 - st2, sh - st2],[sw/2 - st2, sh - sw/2],[sw/2 + st2, sh - sw/2],[sw/2 + st2, sh - st2], [sw, sh-st2], [sw, sh+st2], [sw/2 + st2, sh + st2],[sw/2 + st2, sh + sw/2], [sw/2 - st2, sh + sw/2], [sw/2 - st2, sh + st2], [0, sh + st2]]},
    {type: "operator", seq: /^(\-)/,     numArgs: 2, name: "subtract",         fn: function subtract(a,b) {return a-b;}         , symbol: "-", precedence: 1, assocRight: 0, unicode: "&#x2212;", signWidth: this.rOpt.signWidth, svgArr: [[0,sh - st2],[sw/2 - st2, sh - st2], [sw, sh-st2], [sw, sh+st2], [0, sh + st2]]},
    {type: "operator", seq: /^(\*)/,     numArgs: 2, name: "multiply",         fn: function multiply(a,b) {return a*b;}         , symbol: "*", precedence: 2, assocRight: 0, unicode: "&#x2219;", signWidth: 0.4 * this.rOpt.signWidth, innerSvg: "<circle style='fill:currentColor; stroke-width:0' cx='"+(this.rOpt.signWidth/5)+"' cy='"+this.rOpt.signHeight+"' r='"+this.rOpt.strokeThickness+"'></circle>"},
    {type: "operator", seq: /^(\')/,     numArgs: 2, name: "multiplyImplicit", fn: function multiplyImplicit(a,b) {return a*b;} , symbol: "'", precedence: 3, assocRight: 0, unicode: "", signWidth: 0.1 * this.rOpt.signWidth, innerSvg: "" },
    {type: "operator", seq: /^(\/)/,     numArgs: 2, name: "divide",           fn: function divide(a,b) {return a/b;}           , symbol: "/", precedence: 2, assocRight: 0 },
    {type: "operator", seq: /^(\^)/,     numArgs: 2, name: "pow",              fn: function pow(a,b) {return Math.pow(a,b);}    , symbol: "^", precedence: 4, assocRight: 1 },
    {type: "function", seq: /^(sqrt)/,   numArgs: 1, name: "sqrt",             fn: sqrt},
    {type: "function", seq: /^(cbrt)/,   numArgs: 1, name: "cbrt",             fn: cbrt},
    {type: "function", seq: /^(fort)/,   numArgs: 1, name: "fort",             fn: function fort(a) {return Math.pow(a,0.25);}},
    {type: "function", seq: /^(sin)/,    numArgs: 1, name: "sin",              fn: sin},
    {type: "function", seq: /^(cos)/,    numArgs: 1, name: "cos",              fn: cos},
    {type: "function", seq: /^(tan)/,    numArgs: 1, name: "tan",              fn: tan},
    {type: "function", seq: /^(arcsin)/, numArgs: 1, name: "arcsin",           fn: arcsin},
    {type: "function", seq: /^(arccos)/, numArgs: 1, name: "arccos",           fn: arccos},
    {type: "function", seq: /^(arctan)/, numArgs: 1, name: "arctan",           fn: arctan},
    {type: "function", seq: /^(minus)/,  numArgs: 1, name: "minus",            fn: function minus(a) {return  -a;}},
    {type: "function", seq: /^(hasPar)/, numArgs: 1, name: "hasPar",           fn: function hasPar(a) {return a;}},
    {type: "function", seq: /^(abs)/,    numArgs: 1, name: "abs",              fn: abs},
    {type: "leftPar",  seq: /^(\()/ },
    {type: "rightPar", seq: /^(\))/ },
    {type: "number",   seq: /^([0-9]*\.?[0-9]+(?:[eE][-+]?[0-9]+)?)/},
    {type: "unit",     seq: /^(\[.*?\])/}
  ];

  this.identifiers = [
    {part: "euler", char: "e"},
    //Greek Chars
    {part: "Alpha", char:"&#x0391;"},{part:"Beta", char:"&#x0392;"},{part:"Gamma", char:"&#x0393;"},{part:"Delta", char:"&#x0394;"},{part:"Epsilon", char:"&#x0395;"},{part:"Zeta", char:"&#x0396;"},{part:"Eta", char:"&#x0397;"},{part:"Theta", char:"&#x0398;"},{part:"Iota", char:"&#x0399;"},{part:"Kappa", char:"&#x039A;"},{part:"Lambda", char:"&#x039B;"},{part:"Mu", char:"&#x039C;"},{part:"Nu", char:"&#x039D;"},{part:"Xi", char:"&#x039E;"},{part:"Omicron", char:"&#x039F;"},{part:"Pi", char:"&#x03A0;"},{part:"Rho", char:"&#x03A1;"},{part:"Sigma", char:"&#x03A3;"},{part:"Tau", char:"&#x03A4;"},{part:"Upsilon", char:"&#x03A5;"},{part:"Phi", char:"&#x03A6;"},{part:"Chi", char:"&#x03A7;"},{part:"Psi", char:"&#x03A8;"},{part:"Omega", char:"&#x03A9;"},{part:"alpha", char:"&#x03B1;"},{part:"beta", char:"&#x03B2;"},{part:"gamma", char:"&#x03B3;"},{part:"delta", char:"&#x03B4;"},{part:"epsilon", char:"&#x03B5;"},{part:"zeta", char:"&#x03B6;"},{part:"eta", char:"&#x03B7;"},{part:"theta", char:"&#x03B8;"},{part:"iota", char:"&#x03B9;"},{part:"kappa", char:"&#x03BA;"},{part:"lambda", char:"&#x03BB;"},{part:"mu", char:"&#x03BC;"},{part:"nu", char:"&#x03BD;"},{part:"xi", char:"&#x03BE;"},{part:"omicron", char:"&#x03BF;"},{part:"pi", char:"&#x03C0;"},{part:"rho", char:"&#x03C1;"},{  part:"#x03C2;"},{part:"sigma", char:"&#x03C3;"},{part:"tau", char:"&#x03C4;"},{part:"upsilon", char:"&#x03C5;"},{part:"phi", char:"&#x03C6;"},{part:"chi", char:"&#x03C7;"},{part:"psi", char:"&#x03C8;"},{part:"omega", char:"&#x03C9;"},
    {part: "\{.*?\}", special: "inBraces"},
    {part: "(.)", special: "oneChar"}
  ];

  this.variableModifiers = [
    {name: "delta", seq: /^(delta)/  },
    {name: "bar"  , seq: /^(bar)/    },
    {name: "vec"  , seq: /^(vec)/    },
    {name: "abs"  , seq: /^(abs)/    },
    {name: "abl"  , seq: /^(abl)/    },
    {name: "dot"  , seq: /^(dot)/    },
    {name: "ddot" , seq: /^(ddot)/   },
    {name: "of"   , seq: /^\((.*?)\)/},
    {name: "index", seq: /^\{(.*?)\}/},
    {name: "index", seq: /^([^\_]*)/}
  ];
  
  this.constructor();
};

Term.prototype.constructor = function() {
  this.parsings = this.seq;
  for(var i=0; i<this.identifiers.length; i++) {
    var seq = new RegExp("^(" + this.identifiers[i].part + ")");
    var modseq = new RegExp("^(" + this.identifiers[i].part + "(?:(?:_[A-z0-9\\?]*?)|(?:_\\{.*?\\})|(?:_\\(.*?\\)))*)(?:$|[\\+\\-\\*\\/\\ \\}\\^\\´\\`\\)])");
    this.parsings.push($.extend({}, this.identifiers[i], {seq: modseq, type: "variable"}));
    this.parsings.push($.extend({}, this.identifiers[i], {seq: seq, type: "variable"}));
  }
  this.update();
};



Term.prototype.update = function(options) {
  if(options) {
    if(options.termstring) this.termstring = options.termstring;
  }
  this.output = [];
  this.tokens = []; //string separated by recognized Tokens
  this.stack = []; //needed for parsing

  this.countParsing = 0;
  this.parse(this.termstring);
  this.createTree();
};

Term.prototype.parse = function(string) {

  var term = this;
  var spaceBefore = 0, spaceAfter = 0;
  if(++this.countParsing > 1000) {log("zu viel Parsing"); return;}
  
  while((string[0] === "`" || string[0] === " ") && spaceBefore < 10) {
    this.tokens.push({type: "spaceBefore", string: string[0]});
    spaceBefore++;
    string = string.slice(1);
  }
  
  //find token
  var found = "";
  for(var i=0; i<term.seq.length; i++) {
    found = term.seq[i].seq.exec(string);
    if(found) {
      var token = $.extend({}, term.seq[i], {raw: found[1]});
      term.tokens.push(token);
      string = string.slice(token.raw.length);
      break;
    }
    if(!found && i === term.seq.length-1) {
      log("parsingError", string); return;
    }
  }
     
  while(string[0] === "´" && spaceAfter < 10) {
    this.tokens.push({type: "spaceAfter", string: string[0]});
    spaceAfter++;
    string = string.slice(1);
  }

  if(token.type === "operator") {
    while(this.stack.length > 0 && this.stack[0].type === "operator" && ((this.stack[0].precedence >= token.precedence && !token.assocRight) || this.stack[0].precedence > token.precedence)) {
      this.output.push(this.stack.shift());
    }
    this.stack.unshift($.extend(token, {spaceBefore: spaceBefore, spaceAfter: spaceAfter}));
  }

  if(token.type === "function" || token.type === "leftPar") {
    this.stack.unshift($.extend(token, {spaceBefore: spaceBefore, spaceAfter: spaceAfter}));
  }

  if(token.type === "rightPar") {
    var topOfStack = this.stack.shift();
    while(topOfStack.type !== "leftPar" && this.stack.length > 0) {
      this.output.push(topOfStack);
      topOfStack = this.stack.shift();
    }
    if(topOfStack.type !== "leftPar") {throw new Error("Syntax Error: Parenthesis do not match");}
    if(this.stack[0] && this.stack[0].type === "function") {
      this.output.push(this.stack.shift());
    }
    else {
      this.output.push($.extend({}, this.seq[(this.seq.map(function(f) {return f.name;})).indexOf("hasPar")], {type: "function", spaceBefore: spaceBefore}));
    }
  }
  
  if(token.type === "number") {
    this.output.push($.extend(token, {val: +token.raw, spaceBefore: spaceBefore, spaceAfter: spaceAfter}));
  }
  
  if(token.type === "unit") {
    this.output.push($.extend(token, {val: +token.raw, spaceBefore: spaceBefore, spaceAfter: spaceAfter}));
  }
  
  if(token.type === "variable") {
    var symbol = token.char || (token.special == "inBraces" ? token.raw.split("_")[0].slice(1,-1) : token.raw.split("_")[0]);
    var resttext = token.raw.indexOf("_") > -1 ? token.raw.slice(token.raw.indexOf("_")+1) : "";
    var modifiers = [];
    while(resttext.length > 0) {
      for(var m = 0; m < term.variableModifiers.length; m++) {
        if(term.variableModifiers[m].seq.exec(resttext)) {
          var mod = {name: term.variableModifiers[m].name, val: term.variableModifiers[m].seq.exec(resttext)[1]};
          modifiers.push(mod);
          resttext = resttext.slice(term.variableModifiers[m].seq.exec(resttext)[0].length)
          break;
        }
      }
      if(resttext.indexOf("_") === 0) {resttext = resttext.slice(1);}
    }
    this.output.push($.extend(token, {symbol: symbol, modifiers: modifiers, spaceBefore: spaceBefore, spaceAfter: spaceAfter}));
  }

  // checkForImplicitMultiplication
  if(["variable", "number", "rightPar"].indexOf(token.type) > -1) {
    var reststring = string;
    while(reststring[0] === " " || reststring[0] === "`") {reststring = reststring.slice(1);}
    if(reststring.length) {
      //find token
      for(var i=0; i<term.seq.length; i++) {
        found = term.seq[i].seq.exec(reststring);
        if(found) {var next = $.extend({}, term.seq[i], {raw: found[1]}); break;}
      }
      if(["leftPar", "function", "variable"].indexOf(next.type) > -1) {
        string = "'" + string;
      }
    }
  };

  //put stack to output or continue parsing
  if(string.length <= 0) {
    while(this.stack.length) {this.output.push(this.stack.shift());}
  }
  else {
    this.parse(string);
  }
};

Term.prototype.renderNode = function(token, route) {
  var term = this;
  var route = route || "";  
  var string;
  var overlap = {top: 0, bottom: 0};
  
  var getDimensions = function(htmlstring) {
    var $node = $("<span>"+htmlstring+"</span>").appendTo(term.measuringNode.empty());
    var cs = window.getComputedStyle($node[0], null);
    var fontsize = parseFloat(cs.getPropertyValue('font-size'));
    var dim = {
      fontsize: fontsize,
      h: $node.height()/fontsize,
      w: $node.width()/fontsize
    };
    return dim;
  };
  
  if(token.args) {
    var argNodes = token.args.map(function(t, index) {
      var addRoute = "";
      if(token.name === "divide") {var addRoute = index==0?".fracUp ":".fracDown ";}
      if(token.name === "pow" && index==1) {var addRoute = ".expUp ";}
      return term.renderNode(t, route + addRoute);
    });
    overlap.top    = max.apply(null, argNodes.map(function(arg){return arg.overlap.top;}));
    overlap.bottom = max.apply(null, argNodes.map(function(arg){return arg.overlap.bottom;}));
  }

  if(token.type === "number")   {
    string = "<span class='"+token.type.toLowerCase()+"'>"+token.val+"</span>";
  }
 
  if(token.type === "unit")   {
    string = "<span class='"+token.type.toLowerCase()+"'>"+token.raw.slice(1,-1)+"</span>";
  }
  if(token.type === "variable") {

    //for(var b = 0; b < token.val.length; b++) {
    //  //if(["g", "j", "p", "q", "y"].indexOf(token.val[b]) >= 0) {overlap.bottom = 0.1; break;}
    //}
    //log(token);
    var temp = "<span class='symbol'>"+token.symbol+"</span>";
    var symbolW = getDimensions(temp).w;
    var isHigh = (["b", "d", "f", "h", "i", "j", "k", "l", "t"].indexOf(token.symbol) >= 0 || token.symbol !== token.symbol.toLowerCase());
    overlap.top = 0;
    for(var i = 0; i < token.modifiers.length; i++) {

      var mod = token.modifiers[i].name;
      if(mod === "delta") {temp = "<span class='mod delta'>&#x394;</span>" + temp;}
      if(mod === "abl")   {temp =  temp + "<span class='mod abl'>&#x2032;</span>";}
      if(mod === "index") {
        var index = token.modifiers[i].val;
        var indexDown = term.rOpt.indexDown;
        var indexReducer = term.rOpt.indexReducer;
        var indexMargin = 0.05;
        var width = symbolW + indexMargin + indexReducer * getDimensions("<span>"+index+"</span>").w;
        temp = "<span class='variable-with-index' style='position:relative; width:"+width+"em; display:inline-block;'>" + temp + "<span class='mod index' style='position: absolute; top: +"+(indexDown)+"em; right: 0em; margin-left: "+indexMargin+"em; font-size: "+(100*indexReducer)+"%''>"+index+"</span></span>";
      }
      var h = 1;
      var w = getDimensions(temp).w+0.2;
      if(mod === "vec") {
        overlap.top += isHigh?0.2:0;
        var vecUp = (overlap.top + term.rOpt.accentUp);
        var svgArr = [[10*w, 32], [100*w-15, 32], [100*w-17, 24], [100*w, 34], [100*w-17, 44], [100*w-15, 36], [10*w, 36]];
        var path = "M"+((svgArr.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" Z";
        temp = "<span class='mod vec' style='position:relative; height:"+h+"em; width:"+w+"em;'><svg height='"+h+"em' width='"+w+"em' style='position:absolute; left: 0; top:-"+vecUp+"em;' viewBox='0 0 "+w*100+" "+h*100+"'><path d='"+path+"' stroke='none'></path></svg><span style='position:relative; left:0.06em'>"+temp+"</span></span>";
        isHigh = true;
      }
      else if(mod === "bar") {
        overlap.top += isHigh?0.1:0;
        isHigh = true;
        var vecUp = isHigh?(100*(overlap.top+term.rOpt.accentUp)):0;
        var svgArr = [[10*w,30-vecUp], [100*w,30-vecUp], [100*w, 34-vecUp], [10*w, 34-vecUp]];
        var path = "M"+((svgArr.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" Z";
        temp = "<span class='mod bar' style='position:relative; height:"+h+"em; width:"+w+"em;'><svg height='"+h+"em' width='"+w+"em' style='position:absolute; left: 0; top:-"+0+"em;' viewBox='0 0 "+w*100+" "+h*100+"'><path d='"+path+"' stroke='none'></path></svg><span style='position:relative; left:0.06em'>"+temp+"</span></span>";
      }
      else if(mod === "abs") {
        h = 1.1;
        w = w+0.1;
        var svgArr1 = [[0,20], [4,20], [4, 110], [0, 110]];
        var svgArr2 = [[100*w, 20], [100*w-4,20], [100*w-4, 110], [100*w, 110]];
        var path = "M"+((svgArr1.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" M"+((svgArr2.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" Z";
        temp = "<span class='mod abs' style='position:relative; height:"+h+"em; width:"+w+"em'><svg height='"+h+"em' width='"+w+"em' style='position:absolute; left: 0; top:-"+0+"em;' viewBox='0 0 "+w*100+" "+h*100+"'><path d='"+path+"' stroke='none'></path></svg><span style='position:relative; left:0.11em'>"+temp+"</span></span>";
      }
      else if(mod === "of") {
        var ttt = new Term(token.modifiers[i].val, this.scope);
        temp += "<span class='mod of outer'>(<span class='of inner'>"+ttt.getRenderedFormula()+"</span>)</span>";
      }
    }
    string = "<span class='variable' style='position:relative;'>" + temp + "</span>";
  }
  if(token.type === "operator")   {
    if(token.name === "divide") {
      var z = argNodes[0].node.name === "hasPar" ? argNodes[0].argNodes[0] : argNodes[0];
      var n = argNodes[1].node.name === "hasPar" ? argNodes[1].argNodes[0] : argNodes[1];
      var fracReducer = term.rOpt.fracReducer; //ES6 explode
      var fracUpStandard = term.rOpt.fracUpStandard;
      var fracDownStandard = term.rOpt.fracDownStandard;
      var fracBar = term.rOpt.signHeight;
      var fracMargin = term.rOpt.fracMargin;
      var strokeThickness = term.rOpt.strokeThickness;
      //lineheight = 1.2;
//      if(z.overlap.bottom > 0) {this.specialPositions.push({path: route + ".fracUp ", key: "top", value: fracReducer * z.overlap.bottom});}
//      if(n.overlap.top > 0) {this.specialPositions.push({path: route + ".fracDown ", key: "top", value: fracReducer * n.overlap.top});}
      var fracUp = fracUpStandard + fracMargin + fracReducer * z.overlap.bottom; //1fracBar //(argNodes[0].h*fracReducer - fracBar) + fracMargin;
      var fracDown = fracDownStandard + strokeThickness + fracMargin + fracReducer * n.overlap.top - (1-fracReducer); //1 - fracBar + fracMargin// + (argNodes[1].h);
      overlap.top = term.rOpt.fracNestOverlapTop * fracReducer * (fracUp + z.overlap.top); //fracUp - 1 + fracReducer * (1 + z.overlap.top)
      overlap.bottom = term.rOpt.fracNestOverlapBottom * fracReducer * (fracDown + n.overlap.bottom); //fracDown - 1 + fracReducer * (1 + n.overlap.bottom)
      var width = (max(z.w,n.w) + 0.4) * fracReducer; // parseFloat(window.getComputedStyle($el[0], null).getPropertyValue('font-size')));
      var svgArr = [[0,fracBar - strokeThickness/2],[width,fracBar - strokeThickness/2],[width, fracBar + strokeThickness/2],[0, fracBar + strokeThickness/2]];
      var path = "M"+((svgArr.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" Z";
      string = "<span class='operator "+token.name+"' style='width:"+(width+0.2)+"em;'>" +
        "<span class='divisionbar' style='width:"+width+0.1+"em;'><svg height='1em' width='"+width+"em' viewBox='0 0 "+width+" 1'><path d='"+path+"' stroke='none'></path></svg></span>" +
        "<span class='arg1 fracUp' style='top: -"+ fracUp+"em; left: "+ 0.5 * (width-z.w*fracReducer)+"em;'><span class='enumerator' style='font-size: " +(fracReducer+"em")+"'>"+z.html+"</span></span>" +
        "<span class='arg2 fracDown' style='top: "+fracDown+"em; left: "+ 0.5 * (width-n.w*fracReducer)+"em;'><span class='denominator' style='font-size: "+(fracReducer+"em")+"'>"+n.html+"</span></span></span>";
    }
    if(token.name === "pow") {
      var expReducer = term.rOpt.expReducer;
      var expMargin = term.rOpt.expMargin;
      var expUp = term.rOpt.expUp + argNodes[0].overlap.top + expReducer*argNodes[1].overlap.bottom * expReducer;
      overlap.top =  expUp - (1 - expReducer * (1 + argNodes[1].overlap.top));
      var width = argNodes[0].w + expMargin + expReducer * argNodes[1].w + 0.1;
      string = "<span class='operator "+token.name+"' style='position:relative; width:"+width+"em; display:inline-block;'><span class='arg1'>"+argNodes[0].html+"</span><span class='arg2' style='position: relative; top: -"+expUp+"em; right: 0em; margin-left: "+expMargin+"em;'><span class='exponent' style='font-size: "+(100*expReducer)+"%'>"+argNodes[1].html+"</span></span></span>";
    }
    if(token.name === "add" || token.name === "subtract") {
      var path = "M"+((token.svgArr.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" Z";
      string = "<span class='operator "+token.name+"'><span class='arg1'>"+argNodes[0].html+"</span>" +
        "<span class='operator__sign "+token.fn.name+"' style='width:"+token.signWidth+"em;'><svg height='1em' width='"+token.signWidth+"em' viewBox='0 0 "+token.signWidth+" 1'><path d='"+path+"' stroke='none'></path></svg></span>" +
        "<span class='arg2'>"+argNodes[1].html+"</span></span>";
    }
    else if(token.name === "multiply" || token.name === "multiplyImplicit") {
      string = "<span class='operator "+token.name+"'><span class='arg1'>"+argNodes[0].html+"</span>" +
        "<span class='operator__sign "+token.fn.name+"' style='width:"+token.signWidth+"em;'><svg height='1em' width='"+token.signWidth+"em' viewBox='0 0 "+token.signWidth+" 1'>"+token.innerSvg+"</svg></span>" +
        "<span class='arg2'>"+argNodes[1].html+"</span></span>";
    }
  }
  if(token.type === "function") {
    if(["sin", "cos", "tan", "arcsin", "arccos", "arctan"].indexOf(token.name) >= 0) {
      string = "<span class='function "+token.name+"'><span class='functionname'>"+token.name+"</span>(<span class='arg1'>"+argNodes[0].html+"</span>)</span>";
    }
    if(token.name === "minus") {
      var path = "M"+((this.seq.filter(function(el) {return el.name==="subtract";})[0].svgArr.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" Z";
      string = "<span class='function "+token.fn.name+"'><span class='functionname operator__sign' style='width:"+this.rOpt.signWidth+"em;'><svg height='1em' width='"+this.rOpt.signWidth+"em' viewBox='0 0 "+this.rOpt.signWidth+" 1'><path d='"+path+"' stroke='none'></path></svg></span><span class='arg1'>"+argNodes[0].html+"</span></span>";
    }
    if(token.name === "sqrt" || token.name === "cbrt" || token.name === "fort") {
      var h = 1.1 + argNodes[0].overlap.top + argNodes[0].overlap.bottom/2;
      var radixFrontwidth = 0.7;
      var radixStroke = 100*1.3*this.rOpt.strokeThickness;
      var width = argNodes[0].w + radixFrontwidth + 0.1;
      overlap.top = 0.1 + argNodes[0].overlap.top;
      var svgArr = [[65.859,0+radixStroke],[42.129,96.4*h+radixStroke],[18.574,54.505*h+radixStroke],[6.973,59.896*h+radixStroke],[4.922,56.204*h],[22.559,47.298*h],[41.426,80.814*h],[41.66,80.814*h],[61.582,0],[100*width,0],[100*width,0+radixStroke],[65.859*h,0+radixStroke]];
      var path = "M"+((svgArr.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" Z";
      var radix = "";
      if(token.name === "cbrt" || token.name === "fort" ) {
        radix = "<span style='position:absolute; left: 0; top:-"+overlap.top+"em; font-size:50%;'>"+(token.name === "cbrt"?3:4)+"</span>";
      }
      string = "<span class='function "+token.name+"' style='position:relative;'><span class='functionname' style='position:absolute; width:"+radixFrontwidth+"em; height:"+h+"em; top:-"+argNodes[0].overlap.top+"em;'><svg height='"+h+"em' width='"+width+"em' viewBox='0 0 "+width*100+" "+h*100+"'><path d='"+path+"' stroke='none'></path></svg>&nbsp;"+radix+"</span><span class='arg1' style='margin-left: "+radixFrontwidth+"em;'>"+argNodes[0].html+"</span></span>";
    }
    if(token.name === "abs") {
      var h = 1.1 + argNodes[0].overlap.top + argNodes[0].overlap.bottom/2;
      var w = argNodes[0].w + 0.2;
      var svgArr1 = [[0,20], [4,20], [4, 110], [0, 110]];
      var svgArr2 = [[98*w, 20], [98*w-4,20], [98*w-4, 110], [98*w, 110]];
      var path = "M"+((svgArr1.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" M"+((svgArr2.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" Z";
      string = "<span class='function "+token.name+"' style='position:relative; height:"+h+"em; width:"+w+"em'><svg height='"+h+"em' width='"+w+"em' style='position:absolute; left: 0; top:-"+0+"em;' viewBox='0 0 "+w*100+" "+h*100+"'><path d='"+path+"' stroke='none'></path></svg><span style='position:relative; left:0.11em'><span class='arg1'>"+argNodes[0].html+"</span></span></span>";
    }
    if(token.name === "hasPar") {
      if(argNodes[0].node.name === "divide") {
        string = argNodes[0].html;
      }
      else {
        string = "<span class='hasPar'><span class='openpar'>(</span>"+argNodes[0].html+"<span class='closepar'>)</span></span>";
      }
    }
    
  }
  if(token.spaceBefore) {
    string = $("<span>"+string+"</span>").children("span").css("margin-left", $("<span>"+string+"</span>").children("span").css("margin-left") + token.spaceBefore*0.1+"em").addBack().html();
  }
  if(token.spaceAfter) {
    string = $("<span>"+string+"</span>").children("span").css("margin-right", $("<span>"+string+"</span>").children("span").css("margin-right") + token.spaceAfter*0.1+"em").addBack().html();
  }
  
  return {html: string, w: getDimensions(string).w, overlap: overlap, node: token, argNodes: argNodes};
};

Term.prototype.createTree = function() {
  this.tree = [];
  for(var i = 0; i < this.output.length; i++) {
    var token = this.output[i];
    if(token.type === "operator" || token.type === "function") {
      var args = this.tree.slice(this.tree.length - token.numArgs);
      this.tree = this.tree.slice(0, this.tree.length - token.numArgs);
      token = $.extend(token, {args: args});
    }
    this.tree.push(token);
  }
};

Term.prototype.createEvaltree = function() {
  this.evaltree = [];
  var scope = this.scope;
  for(var i = 0; i < this.output.length; i++) {
    var token = this.output[i];
    if(token.type === "operator" || token.type === "function") {
      var args = this.evaltree.slice(this.evaltree.length - token.numArgs);
      this.evaltree = this.evaltree.slice(0, this.evaltree.length - token.numArgs);
      token = $.extend(token, {args: args});
    }
    //this.evaltree.push(token);
    this.evaltree.push(token.type == "variable" ? this.evalInScope(token).subtree : token);
  }
};

Term.prototype.evalInScope = function(token) {
  if(this.scope.filter(function(data) {return token.raw==data.v}).length) {
    var zahl = this.scope.filter(function(data) {return token.raw==data.v})[0].z;
    var einheit = this.scope.filter(function(data) {return token.raw==data.v})[0].e;
    var subtree = new Term("(" + (zahl<0 ? "minus("+(-zahl)+")" : zahl) + "'[" + einheit + "])", this.scope)
    return {val: zahl, unit: einheit || 1, subtree: subtree.tree[0]};
  }
  else if(window[token.raw] !== undefined) {
    return {val: (window[token.raw]), unit: 1, subtree: {val:NaN}};
  }
  else {
    //throw new Error(scope?"no scope":(token.val + " not defined in scope"));
    log(this.scope?(token.val + " not defined in scope"):"no scope");
    return {val: NaN, unit: 1, subtree: {val:NaN}};
  }
};

Term.prototype.getRenderedFormula = function() {
  this.createTree();
  //render on resize!!
  this.specialPositions = [];
  this.measuringNode = $("<div style='position:absolute; width: 200em; left: -200em; visibility: hidden;'></div>").appendTo("body");
  this.renderedHtml = this.renderNode(this.tree[0]).html;
  this.measuringNode.remove();
  return this.renderedHtml;
}

Term.prototype.getNumericalSolution = function(scope) {
  this.scope = scope || this.scope;
  this.createTree();
  this.createEvaltree();
  this.measuringNode = $("<div style='position:absolute; width: 200em; left: -200em; visibility: hidden;'></div>").appendTo("body");
  this.evalHtml = this.renderNode(this.evaltree[0]).html;
  this.measuringNode.remove();
  return this.evalHtml;
}

Term.prototype.getFinalResult = function(scope) {
  var term = this;
  this.scope = scope || this.scope;

  var evalNode = function(token) {
    if(token.type === "number") {currentNodes.push(token.val);}
    if(token.type === "unit")   {currentNodes.push(1);}
    if(token.type ===  "variable") {currentNodes.push(term.evalInScope(token).val);}
    else if(token.type === "operator" || token.type === "function") {
      var args = currentNodes.slice(currentNodes.length - token.numArgs);
      currentNodes = currentNodes.slice(0, currentNodes.length - token.numArgs);
      currentNodes.push(token.fn.apply(null, args));
    }
  };

  var currentNodes = [];
  for(var i = 0; i < this.output.length; i++) {
    evalNode(this.output[i]);
  }
  //return currentNodes[0];
  var precision = this.scope.precision || 3;
  if(currentNodes.length) {
    var result = +currentNodes[0];
    result = precision < log10(result) ? result.toFixed(0) : result.toPrecision(precision);
    var t = new Term(result < 0 ? "minus(" + abs(result) + ")" : result);
    return "<span class='finalResult'>" + t.getRenderedFormula() + "</span>";
  }
  else {
    return "";
  }
};