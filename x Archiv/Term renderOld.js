function Term(termstring, $renderDom, $resultDom){
  //var term = this;
  this.termstring = termstring;
  this.$renderDom = $renderDom;
  this.$resultDom = $resultDom;
  
    //Cambria
  this.rOpt = {
    fracReducer: 0.75,
    fracUpStandard: 0.42,
    fracDownStandard: 0.5,
    fracBarOffset: -0.068,
    fracMargin: 0.10,
    expReducer: 0.55,
    expUp: 0.52,
    accentUp: 0.1,
    indexReducer: 0.55,
    indexDown: 1
  };
  
//Tinos
//  this.rOpt = {
//    fracReducer: 0.75,
//    fracUpStandard: 0.45,
//    fracDownStandard: 0.5,
//    fracBarOffset: 0,
//    fracMargin: 0.10,
//    expReducer: 0.55,
//    expUp: 0.52,
//    accentUp: 0.1,
//    indexReducer: 0.55,
//    indexDown: 1,
//  };
//  
//Open Sans
//  this.rOpt = {
//    fracReducer: 0.75,
//    fracUpStandard: 0.5,
//    fracDownStandard: 0.5,
//    fracBarOffset: 0,
//    fracMargin: 0.14,
//    expReducer: 0.68,
//    expUp: 0.52,
//  };
  this.constructor();
};

Term.prototype.seq = [
//  {type: "spaceBefore", seq: /^([\`\ ]+)/,         name: "hasSpaceBefore",   fn: function hasSpaceBefore(a) {return a;} },
//  {type: "spaceAfter" , seq: /^([\´]+)/,           name: "hasSpaceAfter",    fn: function hasSpaceAfter(a)  {return a;} },
  {type: "operator", seq: /^(\+)/,     numArgs: 2, name: "add",              fn: function add(a,b) {return +a+b;}             , symbol: "+", precedence: 1, assocRight: 0 },
  {type: "operator", seq: /^(\-)/,     numArgs: 2, name: "subtract",         fn: function subtract(a,b) {return a-b;}         , symbol: "-", precedence: 1, assocRight: 0 },
  {type: "operator", seq: /^(\*)/,     numArgs: 2, name: "multiply",         fn: function multiply(a,b) {return a*b;}         , symbol: "*", precedence: 2, assocRight: 0 },
  {type: "operator", seq: /^(\')/,     numArgs: 2, name: "multiplyImplicit", fn: function multiplyImplicit(a,b) {return a*b;} , symbol: "'", precedence: 3, assocRight: 0 },
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
  {type: "leftPar",  seq: /^(\()/ },
  {type: "rightPar", seq: /^(\))/ },
  {type: "number",   seq: /^([0-9]*\.?[0-9]+(?:[eE][-+]?[0-9]+)?)/}
];

Term.prototype.identifiers = [
  {part: "euler", char: "e"},
  //Greek Chars
  {part: "Alpha", char:"&#x0391;"},{part:"Beta", char:"&#x0392;"},{part:"Gamma", char:"&#x0393;"},{part:"Delta", char:"&#x0394;"},{part:"Epsilon", char:"&#x0395;"},{part:"Zeta", char:"&#x0396;"},{part:"Eta", char:"&#x0397;"},{part:"Theta", char:"&#x0398;"},{part:"Iota", char:"&#x0399;"},{part:"Kappa", char:"&#x039A;"},{part:"Lambda", char:"&#x039B;"},{part:"Mu", char:"&#x039C;"},{part:"Nu", char:"&#x039D;"},{part:"Xi", char:"&#x039E;"},{part:"Omicron", char:"&#x039F;"},{part:"Pi", char:"&#x03A0;"},{part:"Rho", char:"&#x03A1;"},{part:"Sigma", char:"&#x03A3;"},{part:"Tau", char:"&#x03A4;"},{part:"Upsilon", char:"&#x03A5;"},{part:"Phi", char:"&#x03A6;"},{part:"Chi", char:"&#x03A7;"},{part:"Psi", char:"&#x03A8;"},{part:"Omega", char:"&#x03A9;"},{part:"alpha", char:"&#x03B1;"},{part:"beta", char:"&#x03B2;"},{part:"gamma", char:"&#x03B3;"},{part:"delta", char:"&#x03B4;"},{part:"epsilon", char:"&#x03B5;"},{part:"zeta", char:"&#x03B6;"},{part:"eta", char:"&#x03B7;"},{part:"theta", char:"&#x03B8;"},{part:"iota", char:"&#x03B9;"},{part:"kappa", char:"&#x03BA;"},{part:"lambda", char:"&#x03BB;"},{part:"mu", char:"&#x03BC;"},{part:"nu", char:"&#x03BD;"},{part:"xi", char:"&#x03BE;"},{part:"omicron", char:"&#x03BF;"},{part:"pi", char:"&#x03C0;"},{part:"rho", char:"&#x03C1;"},{  part:"#x03C2;"},{part:"sigma", char:"&#x03C3;"},{part:"tau", char:"&#x03C4;"},{part:"upsilon", char:"&#x03C5;"},{part:"phi", char:"&#x03C6;"},{part:"chi", char:"&#x03C7;"},{part:"psi", char:"&#x03C8;"},{part:"omega", char:"&#x03C9;"},
  {part: "\{.*?\}", special: "inBraces"},
  {part: ".", special: "oneChar"}
];

Term.prototype.variableModifiers = [
  {name: "delta", seq: /(delta)/  },
  {name: "bar"  , seq: /(bar)/    },
  {name: "vec"  , seq: /(vec)/    },
  {name: "abs"  , seq: /(abs)/    },
  {name: "abl"  , seq: /(abl)/    },
  {name: "dot"  , seq: /(dot)/    },
  {name: "ddot" , seq: /(ddot)/   },
  {name: "of"   , seq: /\((.)*?\)/},
  {name: "index", seq: /\{(.)*?\}/},
  {name: "index", seq: /(.*)/     }
];

Term.prototype.constructor = function() {
  this.output = [];
  this.tokens = []; //string separated by recognized Tokens
  this.stack = []; //needed for parsing
  //this.tree = [];
  this.renderTree = [];
  this.parse(this.termstring);
  this.createTree();
  this.render(this.$renderDom );
  this.eval(this.$resultDom );
  this.countParsing = 0;
  
  this.parsings = this.seq;
  for(var i=0; i<this.identifiers.length; i++) {
    var seq = new RegExp("^(" + this.identifiers[i].part + ")");
    var modseq = new RegExp("^(" + this.identifiers[i].part + "(?:_[A-z0-9\\?\\(\\)]*?)*?(?:_\\{.*?\\})*?)(?:$|[\\+\\-\\*\\/\\ \\}\\^])");
    this.parsings.push($.extend({}, this.identifiers[i], {seq: modseq, type: "variable"}));
    this.parsings.push($.extend({}, this.identifiers[i], {seq: seq, type: "variable"}));
  }
};

Term.prototype.update = function(options) {
  if(options) {
    if(options.termstring) this.termstring = options.termstring;
  }
  this.constructor();
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
      this.output.push($.extend(this.seq[(this.seq.map(function(f) {return f.name;})).indexOf("hasPar")], {type: "function", spaceBefore: spaceBefore}));
    }
  }
  
  if(token.type === "number") {
    this.output.push($.extend(token, {val: +token.raw, spaceBefore: spaceBefore, spaceAfter: spaceAfter}));
  }
  
  if(token.type === "variable") {
    var parts = token.raw.split("_");
    var symbol = token.char || (token.special == "inBraces" ? parts[0].slice(1,-1) : parts[0]);
    var modifiers = [];
    for(var p = 1; p < parts.length; p++) {
      for(var m = 0; m < term.variableModifiers.length; m++) {
        if(term.variableModifiers[m].seq.exec(parts[p])) {
          var mod = {name: term.variableModifiers[m].name, val: term.variableModifiers[m].seq.exec(parts[p])[1]};
          modifiers.push(mod);
          break;
        }
      }
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

Term.prototype.render = function($el) {
  var term = this;
  this.renderTree = [];
  $el.empty();
  
  var measuringNode = $("<div style='position:absolute; width: 200em;'></div>").appendTo($el);
  var getDimensions = function(htmlstring) {
    var $node = $("<span>"+htmlstring+"</span>").appendTo(measuringNode.empty());
    var cs = window.getComputedStyle($node[0], null);
    var fontsize = parseFloat(cs.getPropertyValue('font-size'));
    var dim = {
      fontsize: fontsize,
      h: $node.height()/fontsize,
      w: $node.width()/fontsize
    };
    measuringNode.empty();
    return dim;
  };
  
  var createNode = function(token) {
    var string;
    var overlap = {top: 0, bottom: 0};
    if(token.type === "number") {
      string = "<span class='"+token.type.toLowerCase()+"'>"+token.val+"</span>";
    }
    if(token.type === "variable") {

      //for(var b = 0; b < token.val.length; b++) {
      //  //if(["g", "j", "p", "q", "y"].indexOf(token.val[b]) >= 0) {overlap.bottom = 0.1; break;}
      //}
      //log(token);
      var temp = "<span class='symbol'>"+token.symbol+"</span>";
      var symbolW = getDimensions(temp).w
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
          temp = "<span class='variable-with-index' style='position:relative; width:"+width+"em; display:inline-block;'>" + temp + "<span class='mod index' style='position: absolute; top: +"+(indexDown)+"em; right: 0em; margin-left: "+indexMargin+"em; font-size: "+(100*indexReducer)+"%''>"+index+"</span>";
        }
        var h = 1;
        var w = getDimensions(temp).w+0.2;
        if(mod === "vec") {
          overlap.top += isHigh?0.1:0;
          isHigh = true;
          var vecUp = isHigh?(100*(overlap.top+term.rOpt.accentUp)):0;
          var svgArr = [[10*w,32-vecUp], [100*w-15,32-vecUp], [100*w-17,24-vecUp], [100*w, 34-vecUp], [100*w-17,44-vecUp], [100*w-15, 36-vecUp], [10*w, 36-vecUp]];
          var path = "M"+((svgArr.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" Z";
          temp = "<span class='mod vec' style='position:relative; height:"+h+"em; width:"+w+"em'><svg height='"+h+"em' width='"+w+"em' style='position:absolute; left: 0; top:-"+0+"em;' viewBox='0 0 "+w*100+" "+h*100+"'><path d='"+path+"' stroke='none'></path></svg><span style='position:relative; left:0.06em'>"+temp+"</span></span>";
        }
        else if(mod === "bar") {
          overlap.top += isHigh?0.1:0;
          isHigh = true;
          var vecUp = isHigh?(100*(overlap.top+term.rOpt.accentUp)):0;
          var svgArr = [[10*w,30-vecUp], [100*w,30-vecUp], [100*w, 34-vecUp], [10*w, 34-vecUp]];
          var path = "M"+((svgArr.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" Z";
          temp = "<span class='mod bar' style='position:relative; height:"+h+"em; width:"+w+"em'><svg height='"+h+"em' width='"+w+"em' style='position:absolute; left: 0; top:-"+0+"em;' viewBox='0 0 "+w*100+" "+h*100+"'><path d='"+path+"' stroke='none'></path></svg><span style='position:relative; left:0.06em'>"+temp+"</span></span>";
        }
        else if(mod === "abs") {
          h = 1.1;
          w = w+0.1;
          var svgArr1 = [[0,20], [4,20], [4, 110], [0, 110]];
          var svgArr2 = [[100*w, 20], [100*w-4,20], [100*w-4, 110], [100*w, 110]];
          var path = "M"+((svgArr1.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" M"+((svgArr2.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" Z";
          temp = "<span class='mod abs' style='position:relative; height:"+h+"em; width:"+w+"em'><svg height='"+h+"em' width='"+w+"em' style='position:absolute; left: 0; top:-"+0+"em;' viewBox='0 0 "+w*100+" "+h*100+"'><path d='"+path+"' stroke='none'></path></svg><span style='position:relative; left:0.11em'>"+temp+"</span></span>";
        }
      }
      string = "<span class='variable' style='position:relative;'>" + temp + "</span>";
    }
    else if(token.type === "operator" || token.type === "function") {
      var args = currentNodes.slice(currentNodes.length - token.numArgs);
      currentNodes = currentNodes.slice(0, currentNodes.length - token.numArgs);
      overlap.top    = max.apply(null, args.map(function(arg){return arg.overlap.top;}));
      overlap.bottom = max.apply(null, args.map(function(arg){return arg.overlap.bottom;}));

      if(token.symbol === "+") {string = "<span class='operator "+token.fn.name+"'><span class='arg1'>"+args[0].html+"</span><span class='operator__sign "+token.fn.name+"'>&#x002b;</span><span class='arg2'>"+args[1].html+"</span></span>";}
      if(token.symbol === "-") {string = "<span class='operator "+token.fn.name+"'><span class='arg1'>"+args[0].html+"</span><span class='operator__sign "+token.fn.name+"'>&#x2212;</span><span class='arg2'>"+args[1].html+"</span></span>";}
      if(token.symbol === "*") {string = "<span class='operator "+token.fn.name+"'><span class='arg1'>"+args[0].html+"</span><span class='operator__sign "+token.fn.name+"'>&#x2219;</span><span class='arg2'>"+args[1].html+"</span></span>";}
      if(token.symbol === "'") {string = "<span class='operator "+token.fn.name+"'><span class='arg1'>"+args[0].html+"</span><span class='operator__sign "+token.fn.name+"' title='implicitMiltiplication'></span><span class='arg2'>"+args[1].html+"</span></span>";}
      if(token.symbol === " ") {string = "<span class='operator "+token.fn.name+"'><span class='arg1'>"+args[0].html+"</span><span class='operator__sign "+token.fn.name+"'></span><span class='arg2'>"+args[1].html+"</span></span>";}
      if(token.symbol === "/") {
        //log(args[0].node);
        var z = args[0];
        var n = args[1];
        var zw = z.node.name === "hasPar"?z.args[0].w:z.w;
        var nw = n.node.name === "hasPar"?n.args[0].w:n.w;
        var fracReducer = term.rOpt.fracReducer; //ES6 explode
        var fracBarOffset = term.rOpt.fracBarOffset;
        var fracUpStandard = term.rOpt.fracUpStandard;
        var fracDownStandard = term.rOpt.fracDownStandard;
        var fracBarStandard = 0.35;
        var fracBar = fracBarStandard + fracBarOffset;
        var fracBarThickness = 0.07 * fracReducer;
        var fracMargin = term.rOpt.fracMargin;
        //lineheight = 1.2;
        var fracUp = fracUpStandard + fracMargin + fracBarOffset + fracReducer * z.overlap.bottom; //1fracBar //(args[0].h*fracReducer - fracBar) + fracMargin;
        var fracDown = fracDownStandard + fracBarThickness + fracMargin - fracBarOffset + fracReducer * n.overlap.top; //1 - fracBar + fracMargin// + (args[1].h);
        overlap.top = fracReducer * (fracUp + z.overlap.top); //fracUp - 1 + fracReducer * (1 + z.overlap.top)
        overlap.bottom = fracReducer * (fracDown + n.overlap.bottom); //fracDown - 1 + fracReducer * (1 + n.overlap.bottom)
        var width = (max(zw,nw) + 0.4) * fracReducer; // parseFloat(window.getComputedStyle($el[0], null).getPropertyValue('font-size')));
        string = "<span class='operator "+token.fn.name+"' style='position:relative; width:"+width+"em'>" +
          "<span class='divisionbar' style='width:"+width+"em; position:relative;'><svg height='1em' width='"+width+"em' viewBox='0 0 "+width+" 1'><line x1='0' y1='"+(1-fracBar)+"' x2='"+width+"' y2='"+(1-fracBar)+"' style='stroke:currentColor;stroke-width:"+fracBarThickness+"'/></line></svg></span>" +
          "<span class='arg1' style='position: absolute; top: -"+ fracUp+"em; left: "+ 0.5 * (width-zw*fracReducer)+"em;'><span class='enumerator' style='font-size: " +(100*fracReducer+"%")+"'>"+args[0].html+"</span></span>" +
          "<span class='arg2' style='position: absolute; top: "+fracDown+"em; left: "+ 0.5 * (width-nw*fracReducer)+"em;'><span class='denominator' style='font-size: "+(100*fracReducer+"%")+"'>"+args[1].html+"</span></span></span>";
      }
      if(token.symbol === "^") {
        var expUp = term.rOpt.expUp;
        var expReducer = term.rOpt.expReducer;
        var expMargin = 0.05;
        overlap.top = args[0].overlap.top + expReducer*args[1].overlap.top; // + expUp + expReducer - 1;
        var width = args[0].w + expMargin + expReducer * args[1].w;
        string = "<span class='operator "+token.fn.name+"' style='position:relative; width:"+width+"em; display:inline-block;'><span class='arg1'>"+args[0].html+"</span><span class='arg2' style='position: absolute; top: -"+(args[0].overlap.top+expUp)+"em; right: 0em; margin-left: "+expMargin+"em;'><span class='exponent' style='font-size: "+(100*expReducer)+"%'>&nbsp;"+args[1].html+"</span></span></span>";
      }  
      if(["sin", "cos", "tan", "arcsin", "arccos", "arctan"].indexOf(token.name) >= 0) {
        string = "<span class='function "+token.name+"'><span class='functionname'>"+token.name+"</span>(<span class='arg1'>"+args[0].html+"</span>)</span>";
      }
      if(token.name === "minus") {string = "<span class='function "+token.fn.name+"'><span class='functionname'>&nbsp;&#x2212;&nbsp;</span><span class='arg1'>"+args[0].html+"</span></span>";}
      if(token.name === "sqrt" || token.name == "cbrt" || token.name == "fort") {
        var h = 1.1 + args[0].overlap.top + args[0].overlap.bottom/2;
        var radixFrontwidth = 0.7;
        var radixStroke = 100*0.07;
        var width = args[0].w + radixFrontwidth + 0.1;
        overlap.top = 0.1 + args[0].overlap.top;
        var svgArr = [[65.859,0+radixStroke],[42.129,96.4*h+radixStroke],[18.574,54.505*h+radixStroke],[6.973,59.896*h+radixStroke],[4.922,56.204*h],[22.559,47.298*h],[41.426,80.814*h],[41.66,80.814*h],[61.582,0],[100*width,0],[100*width,0+radixStroke],[65.859*h,0+radixStroke]];
        var path = "M"+((svgArr.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" Z";
        var radix = "";
        if(token.name === "cbrt" || token.name == "fort" ) {
          radix = "<span style='position:absolute; left: 0; top:-"+overlap.top+"em; font-size:50%;'>"+(token.name === "cbrt"?3:4)+"</span>"
        }
        string = "<span class='function "+token.fn.name+"' style='position:relative'><span class='functionname' style='position:relative; width:"+radixFrontwidth+"em;'>&nbsp;"+radix+"<svg height='"+h+"em' width='"+width+"em' style='position:absolute; left: 0; top:-"+args[0].overlap.top+"em;' viewBox='0 0 "+width*100+" "+h*100+"'><path d='"+path+"' stroke='none'></path></svg></span><span class='arg1'>"+args[0].html+"</span></span>";
      }
      if(token.name === "hasPar") {
        string = "<span class='openpar'>(</span>"+args[0].html+"<span class='closepar'>)</span>";
      }
    }
    if(token.spaceBefore) {
      string = $("<span>"+string+"</span>").children("span").css("margin-left", $("<span>"+string+"</span>").children("span").css("margin-left") + token.spaceBefore*0.05+"em").addBack().html();
    }
    currentNodes.push({html: string, w: getDimensions(string).w, overlap: overlap, node: token, args: args});
    
  };

  var currentNodes = [];
  for(var i = 0; i < this.output.length; i++) {
    createNode(this.output[i]);
  }
  
  measuringNode.remove();
  //return currentNodes[0];
  //render on resize!!
  $el.append(currentNodes.length?currentNodes[0].html:"");
};

Term.prototype.eval = function($el, scope) {
  $el.empty();

  var evalNode = function(token) {
    if(token.type === "number") {
      currentNodes.push(token.val);
    }
    if(token.type ===  "variable") {
      if(scope && scope[token.raw] !== undefined) {
        currentNodes.push(scope[token.raw]);
      }
      else if(window[token.raw] !== undefined) {
        currentNodes.push(window[token.raw]);
      }
      else {
        //throw new Error(scope?"no scope":(token.val + " not defined in scope"));
        log(scope?"no scope":(token.val + " not defined in scope"));
      }
    }
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
  $el.append(currentNodes.length?currentNodes[0]:"");
};


Term.prototype.createTree = function() {
  this.tree = [];
  for(var i = 0; i < this.output.length; i++) {
    var token = this.output[i];
    if(token.type === "operator" || token.type === "function") {
      var args = this.tree.slice(this.tree.length - token.numArgs);
      this.tree = this.tree.slice(0, this.tree.length - token.numArgs);
      $.extend(token, {args: args});
    }
    this.tree.push(token);
  }
  log(this.tree);
  this.renderNode(this.tree[0])
};

Term.prototype.renderNode = function(token) {
  if(token.args) {
    var argNodes = token.args.map(this.renderNode.bind(this));
  }
  $("body").append("<br>"+token.val);
  
  var string;
  var overlap = {top: 0, bottom: 0};
  if(token.type === "number") {
      string = "<span class='"+token.type.toLowerCase()+"'>"+token.val+"</span>";
  }
//  if(token.type === "variable") {
//
//    //for(var b = 0; b < token.val.length; b++) {
//    //  //if(["g", "j", "p", "q", "y"].indexOf(token.val[b]) >= 0) {overlap.bottom = 0.1; break;}
//    //}
//    //log(token);
//    var temp = "<span class='symbol'>"+token.symbol+"</span>";
//    var symbolW = getDimensions(temp).w
//    var isHigh = (["b", "d", "f", "h", "i", "j", "k", "l", "t"].indexOf(token.symbol) >= 0 || token.symbol !== token.symbol.toLowerCase());
//    overlap.top = 0;
//    for(var i = 0; i < token.modifiers.length; i++) {
//
//      var mod = token.modifiers[i].name;
//      if(mod === "delta") {temp = "<span class='mod delta'>&#x394;</span>" + temp;}
//      if(mod === "abl")   {temp =  temp + "<span class='mod abl'>&#x2032;</span>";}
//      if(mod === "index") {
//        var index = token.modifiers[i].val;
//        var indexDown = term.rOpt.indexDown;
//        var indexReducer = term.rOpt.indexReducer;
//        var indexMargin = 0.05;
//        var width = symbolW + indexMargin + indexReducer * getDimensions("<span>"+index+"</span>").w;
//        temp = "<span class='variable-with-index' style='position:relative; width:"+width+"em; display:inline-block;'>" + temp + "<span class='mod index' style='position: absolute; top: +"+(indexDown)+"em; right: 0em; margin-left: "+indexMargin+"em; font-size: "+(100*indexReducer)+"%''>"+index+"</span>";
//      }
//      var h = 1;
//      var w = getDimensions(temp).w+0.2;
//      if(mod === "vec") {
//        overlap.top += isHigh?0.1:0;
//        isHigh = true;
//        var vecUp = isHigh?(100*(overlap.top+term.rOpt.accentUp)):0;
//        var svgArr = [[10*w,32-vecUp], [100*w-15,32-vecUp], [100*w-17,24-vecUp], [100*w, 34-vecUp], [100*w-17,44-vecUp], [100*w-15, 36-vecUp], [10*w, 36-vecUp]];
//        var path = "M"+((svgArr.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" Z";
//        temp = "<span class='mod vec' style='position:relative; height:"+h+"em; width:"+w+"em'><svg height='"+h+"em' width='"+w+"em' style='position:absolute; left: 0; top:-"+0+"em;' viewBox='0 0 "+w*100+" "+h*100+"'><path d='"+path+"' stroke='none'></path></svg><span style='position:relative; left:0.06em'>"+temp+"</span></span>";
//      }
//      else if(mod === "bar") {
//        overlap.top += isHigh?0.1:0;
//        isHigh = true;
//        var vecUp = isHigh?(100*(overlap.top+term.rOpt.accentUp)):0;
//        var svgArr = [[10*w,30-vecUp], [100*w,30-vecUp], [100*w, 34-vecUp], [10*w, 34-vecUp]];
//        var path = "M"+((svgArr.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" Z";
//        temp = "<span class='mod bar' style='position:relative; height:"+h+"em; width:"+w+"em'><svg height='"+h+"em' width='"+w+"em' style='position:absolute; left: 0; top:-"+0+"em;' viewBox='0 0 "+w*100+" "+h*100+"'><path d='"+path+"' stroke='none'></path></svg><span style='position:relative; left:0.06em'>"+temp+"</span></span>";
//      }
//      else if(mod === "abs") {
//        h = 1.1;
//        w = w+0.1;
//        var svgArr1 = [[0,20], [4,20], [4, 110], [0, 110]];
//        var svgArr2 = [[100*w, 20], [100*w-4,20], [100*w-4, 110], [100*w, 110]];
//        var path = "M"+((svgArr1.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" M"+((svgArr2.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" Z";
//        temp = "<span class='mod abs' style='position:relative; height:"+h+"em; width:"+w+"em'><svg height='"+h+"em' width='"+w+"em' style='position:absolute; left: 0; top:-"+0+"em;' viewBox='0 0 "+w*100+" "+h*100+"'><path d='"+path+"' stroke='none'></path></svg><span style='position:relative; left:0.11em'>"+temp+"</span></span>";
//      }
//    }
//    string = "<span class='variable' style='position:relative;'>" + temp + "</span>";
//  }
//  else if(token.type === "operator" || token.type === "function") {
//    var args = currentNodes.slice(currentNodes.length - token.numArgs);
//    currentNodes = currentNodes.slice(0, currentNodes.length - token.numArgs);
//    overlap.top    = max.apply(null, args.map(function(arg){return arg.overlap.top;}));
//    overlap.bottom = max.apply(null, args.map(function(arg){return arg.overlap.bottom;}));
//
//    if(token.symbol === "+") {string = "<span class='operator "+token.fn.name+"'><span class='arg1'>"+args[0].html+"</span><span class='operator__sign "+token.fn.name+"'>&#x002b;</span><span class='arg2'>"+args[1].html+"</span></span>";}
//    if(token.symbol === "-") {string = "<span class='operator "+token.fn.name+"'><span class='arg1'>"+args[0].html+"</span><span class='operator__sign "+token.fn.name+"'>&#x2212;</span><span class='arg2'>"+args[1].html+"</span></span>";}
//    if(token.symbol === "*") {string = "<span class='operator "+token.fn.name+"'><span class='arg1'>"+args[0].html+"</span><span class='operator__sign "+token.fn.name+"'>&#x2219;</span><span class='arg2'>"+args[1].html+"</span></span>";}
//    if(token.symbol === "'") {string = "<span class='operator "+token.fn.name+"'><span class='arg1'>"+args[0].html+"</span><span class='operator__sign "+token.fn.name+"' title='implicitMiltiplication'></span><span class='arg2'>"+args[1].html+"</span></span>";}
//    if(token.symbol === " ") {string = "<span class='operator "+token.fn.name+"'><span class='arg1'>"+args[0].html+"</span><span class='operator__sign "+token.fn.name+"'></span><span class='arg2'>"+args[1].html+"</span></span>";}
//    if(token.symbol === "/") {
//      //log(args[0].node);
//      var z = args[0];
//      var n = args[1];
//      var zw = z.node.name === "hasPar"?z.args[0].w:z.w;
//      var nw = n.node.name === "hasPar"?n.args[0].w:n.w;
//      var fracReducer = term.rOpt.fracReducer; //ES6 explode
//      var fracBarOffset = term.rOpt.fracBarOffset;
//      var fracUpStandard = term.rOpt.fracUpStandard;
//      var fracDownStandard = term.rOpt.fracDownStandard;
//      var fracBarStandard = 0.35;
//      var fracBar = fracBarStandard + fracBarOffset;
//      var fracBarThickness = 0.07 * fracReducer;
//      var fracMargin = term.rOpt.fracMargin;
//      //lineheight = 1.2;
//      var fracUp = fracUpStandard + fracMargin + fracBarOffset + fracReducer * z.overlap.bottom; //1fracBar //(args[0].h*fracReducer - fracBar) + fracMargin;
//      var fracDown = fracDownStandard + fracBarThickness + fracMargin - fracBarOffset + fracReducer * n.overlap.top; //1 - fracBar + fracMargin// + (args[1].h);
//      overlap.top = fracReducer * (fracUp + z.overlap.top); //fracUp - 1 + fracReducer * (1 + z.overlap.top)
//      overlap.bottom = fracReducer * (fracDown + n.overlap.bottom); //fracDown - 1 + fracReducer * (1 + n.overlap.bottom)
//      var width = (max(zw,nw) + 0.4) * fracReducer; // parseFloat(window.getComputedStyle($el[0], null).getPropertyValue('font-size')));
//      string = "<span class='operator "+token.fn.name+"' style='position:relative; width:"+width+"em'>" +
//        "<span class='divisionbar' style='width:"+width+"em; position:relative;'><svg height='1em' width='"+width+"em' viewBox='0 0 "+width+" 1'><line x1='0' y1='"+(1-fracBar)+"' x2='"+width+"' y2='"+(1-fracBar)+"' style='stroke:currentColor;stroke-width:"+fracBarThickness+"'/></line></svg></span>" +
//        "<span class='arg1' style='position: absolute; top: -"+ fracUp+"em; left: "+ 0.5 * (width-zw*fracReducer)+"em;'><span class='enumerator' style='font-size: " +(100*fracReducer+"%")+"'>"+args[0].html+"</span></span>" +
//        "<span class='arg2' style='position: absolute; top: "+fracDown+"em; left: "+ 0.5 * (width-nw*fracReducer)+"em;'><span class='denominator' style='font-size: "+(100*fracReducer+"%")+"'>"+args[1].html+"</span></span></span>";
//    }
//    if(token.symbol === "^") {
//      var expUp = term.rOpt.expUp;
//      var expReducer = term.rOpt.expReducer;
//      var expMargin = 0.05;
//      overlap.top = args[0].overlap.top + expReducer*args[1].overlap.top; // + expUp + expReducer - 1;
//      var width = args[0].w + expMargin + expReducer * args[1].w;
//      string = "<span class='operator "+token.fn.name+"' style='position:relative; width:"+width+"em; display:inline-block;'><span class='arg1'>"+args[0].html+"</span><span class='arg2' style='position: absolute; top: -"+(args[0].overlap.top+expUp)+"em; right: 0em; margin-left: "+expMargin+"em;'><span class='exponent' style='font-size: "+(100*expReducer)+"%'>&nbsp;"+args[1].html+"</span></span></span>";
//    }  
//    if(["sin", "cos", "tan", "arcsin", "arccos", "arctan"].indexOf(token.name) >= 0) {
//      string = "<span class='function "+token.name+"'><span class='functionname'>"+token.name+"</span>(<span class='arg1'>"+args[0].html+"</span>)</span>";
//    }
//    if(token.name === "minus") {string = "<span class='function "+token.fn.name+"'><span class='functionname'>&nbsp;&#x2212;&nbsp;</span><span class='arg1'>"+args[0].html+"</span></span>";}
//    if(token.name === "sqrt" || token.name == "cbrt" || token.name == "fort") {
//      var h = 1.1 + args[0].overlap.top + args[0].overlap.bottom/2;
//      var radixFrontwidth = 0.7;
//      var radixStroke = 100*0.07;
//      var width = args[0].w + radixFrontwidth + 0.1;
//      overlap.top = 0.1 + args[0].overlap.top;
//      var svgArr = [[65.859,0+radixStroke],[42.129,96.4*h+radixStroke],[18.574,54.505*h+radixStroke],[6.973,59.896*h+radixStroke],[4.922,56.204*h],[22.559,47.298*h],[41.426,80.814*h],[41.66,80.814*h],[61.582,0],[100*width,0],[100*width,0+radixStroke],[65.859*h,0+radixStroke]];
//      var path = "M"+((svgArr.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" Z";
//      var radix = "";
//      if(token.name === "cbrt" || token.name == "fort" ) {
//        radix = "<span style='position:absolute; left: 0; top:-"+overlap.top+"em; font-size:50%;'>"+(token.name === "cbrt"?3:4)+"</span>"
//      }
//      string = "<span class='function "+token.fn.name+"' style='position:relative'><span class='functionname' style='position:relative; width:"+radixFrontwidth+"em;'>&nbsp;"+radix+"<svg height='"+h+"em' width='"+width+"em' style='position:absolute; left: 0; top:-"+args[0].overlap.top+"em;' viewBox='0 0 "+width*100+" "+h*100+"'><path d='"+path+"' stroke='none'></path></svg></span><span class='arg1'>"+args[0].html+"</span></span>";
//    }
//    if(token.name === "hasPar") {
//      string = "<span class='openpar'>(</span>"+args[0].html+"<span class='closepar'>)</span>";
//    }
//  }
//  if(token.spaceBefore) {
//    string = $("<span>"+string+"</span>").children("span").css("margin-left", $("<span>"+string+"</span>").children("span").css("margin-left") + token.spaceBefore*0.05+"em").addBack().html();
//  }
//  currentNodes.push({html: string, w: getDimensions(string).w, overlap: overlap, node: token, args: args});
//
//};

//var currentNodes = [];
//for(var i = 0; i < this.output.length; i++) {
//  createNode(this.output[i]);
//}
//
//measuringNode.remove();
////return currentNodes[0];
////render on resize!!
//$el.append(currentNodes.length?currentNodes[0].html:"");
};

Term.prototype.renderFunctions = {
  number: function(token)   {
    return "<span class='"+token.type.toLowerCase()+"'>"+token.val+"</span>";
  },
  operator: function(token, argNodes) {
    return "<span class='operator "+token.fn.name+"'><span class='arg1'>"+argNodes[0].html+"</span><span class='operator__sign "+token.fn.name+"'>" + token.unicode + "</span><span class='arg2'>"+argNodes[1].html+"</span></span>";
  }
}