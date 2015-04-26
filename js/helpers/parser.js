function Parser(termstring, $renderDom, $resultDom){
  //var parser = this;
  
  this.countParsing = 0;
  
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
    accentUp: 0.1
  };
  
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
 
//  this.specialSeq = [
//    {seq: " _", type: "render"},
//  ];
//  this.parenthesis = [
//    {seq: "(", value: +1},
//    {seq: ")", value: -1},
//  ];
};


Parser.prototype.constructor = function() {
  this.output = [];
  this.tokens = []; //string separated by recognized Tokens
  this.stack = []; //needed for parsing
  //this.tree = [];
  this.renderTree = [];
  this.parse(this.termstring);
  this.render(this.$renderDom );
  this.eval(this.$resultDom );
};

Parser.prototype.update = function(options) {
  if(options) {
    if(options.termstring) this.termstring = options.termstring;
  }
  this.constructor();
};

Parser.prototype.operators = [
  {symbol: "+", numArgs: 2, precedence: 1, assocRight: 0, fn: function add(a,b) {return +a+b;}},
  {symbol: "-", numArgs: 2, precedence: 1, assocRight: 0, fn: function subtract(a,b) {return a-b;}},
  {symbol: "*", numArgs: 2, precedence: 2, assocRight: 0, fn: function multiply(a,b) {return a*b;}},
  {symbol: "'", numArgs: 2, precedence: 3, assocRight: 0, fn: function multiplyImplicit(a,b) {return a*b;}},
  {symbol: "/", numArgs: 2, precedence: 2, assocRight: 0, fn: function divide(a,b) {return a/b;}},
  {symbol: "^", numArgs: 2, precedence: 4, assocRight: 1, fn: function pow(a,b) {return Math.pow(a,b);}}
];
  
Parser.prototype.functions = [
  {name: "sqrt",    numArgs: 1, fn: sqrt},
  {name: "cbrt",    numArgs: 1, fn: cbrt},
  {name: "fort",    numArgs: 1, fn: function fort(a) {return Math.pow(a,0.25);}},
  {name: "sin",     numArgs: 1, fn: sin},
  {name: "cos",     numArgs: 1, fn: cos},
  {name: "tan",     numArgs: 1, fn: tan},
  {name: "arcsin",  numArgs: 1, fn: arcsin},
  {name: "arccos",  numArgs: 1, fn: arccos},
  {name: "arctan",  numArgs: 1, fn: arctan},
  {name: "minus",   numArgs: 1, fn: function minus(a) {return  -a;}},
  {name: "hasPar",  numArgs: 1, fn: function hasPar(a) {return a;}}
//  {name: " ",       numArgs: 1, fn: function hasSpaceBefore(a) {return a;}}
    //expression Modifiers
//  {name: "delta"    numArgs: 1, fn: function(){return a;}},
//  {name: "bar"      numArgs: 1, fn: function(){return a;}},
//  {name: "vec"      numArgs: 1, fn: function(){return a;}},
//  {name: "abs"      numArgs: 1, fn: function(){return a;}},
//  {name: "abl"      numArgs: 1, fn: function(){return a;}},
//  {name: "dot"      numArgs: 1, fn: function(){return a;}},
//  {name: "ddot"     numArgs: 1, fn: function(){return a;}},
//  {name: "of"       numArgs: 1, fn: function(){return a;}}
];

Parser.prototype.expressionModifiers = [
  {name: "delta"},
  {name: "bar"},
  {name: "vec"},
  {name: "abs"},
  {name: "abl"},
  {name: "dot"},
  {name: "ddot"},
  {name: "of"}
];

Parser.prototype.expressionFix = [
  {name: "euler", char: "e"},
  //Greek Chars
  {name:"Alpha", char:"&#x0391;"},{name:"Beta", char:"&#x0392;"},{name:"Gamma", char:"&#x0393;"},{name:"Delta", char:"&#x0394;"},{name:"Epsilon", char:"&#x0395;"},{name:"Zeta", char:"&#x0396;"},{name:"Eta", char:"&#x0397;"},{name:"Theta", char:"&#x0398;"},{name:"Iota", char:"&#x0399;"},{name:"Kappa", char:"&#x039A;"},{name:"Lambda", char:"&#x039B;"},{name:"Mu", char:"&#x039C;"},{name:"Nu", char:"&#x039D;"},{name:"Xi", char:"&#x039E;"},{name:"Omicron", char:"&#x039F;"},{name:"Pi", char:"&#x03A0;"},{name:"Rho", char:"&#x03A1;"},{name:"Sigma", char:"&#x03A3;"},{name:"Tau", char:"&#x03A4;"},{name:"Upsilon", char:"&#x03A5;"},{name:"Phi", char:"&#x03A6;"},{name:"Chi", char:"&#x03A7;"},{name:"Psi", char:"&#x03A8;"},{name:"Omega", char:"&#x03A9;"},{name:"alpha", char:"&#x03B1;"},{name:"beta", char:"&#x03B2;"},{name:"gamma", char:"&#x03B3;"},{name:"delta", char:"&#x03B4;"},{name:"epsilon", char:"&#x03B5;"},{name:"zeta", char:"&#x03B6;"},{name:"eta", char:"&#x03B7;"},{name:"theta", char:"&#x03B8;"},{name:"iota", char:"&#x03B9;"},{name:"kappa", char:"&#x03BA;"},{name:"lambda", char:"&#x03BB;"},{name:"mu", char:"&#x03BC;"},{name:"nu", char:"&#x03BD;"},{name:"xi", char:"&#x03BE;"},{name:"omicron", char:"&#x03BF;"},{name:"pi", char:"&#x03C0;"},{name:"rho", char:"&#x03C1;"},{  name:"#x03C2;"},{name:"sigma", char:"&#x03C3;"},{name:"tau", char:"&#x03C4;"},{name:"upsilon", char:"&#x03C5;"},{name:"phi", char:"&#x03C6;"},{name:"chi", char:"&#x03C7;"},{name:"psi", char:"&#x03C8;"},{name:"omega", char:"&#x03C9;"}
];

Parser.prototype.parse = function(string) {
  
  var parser = this;
  var spaceBefore = 0;
  
  if(++this.countParsing > 1000) {log("zu viel Parsing"); return;}
  
  var checkForOperator = function(symbol) {
    var matchingOperator = parser.operators.filter(function(el) {return el.symbol === symbol;});
    return matchingOperator.length > 0 ? matchingOperator[0] : false;
  };
  
  var couldBeImplicit = function(reststring) {
    while(reststring[0] === " ") {reststring = reststring.slice(1);}
    if(!reststring.length) return false; // keine Implizit wenn Stringende
    if(checkForOperator(reststring[0])) return false; // keine Implizit mit Operator
    if(reststring[0] === "(") return true; // Implizit mit Klammer
    if(reststring[0] === ")") return false; // Implizit mit Klammer
    for(var k=reststring.length; k>0; k--) {
      if(!isNaN(+reststring.slice(0, k)) && reststring[k-1] !== " ") return false; // keine Implizit mit Zahl
    }
    if(parser.functions.filter(function(f) {return reststring.indexOf(f.name)>-1;}).length) return true; // Implizit mit Funktion
    return true; // Implizit mit Variable
  };

  //check for space
  while(string[0] === " " && spaceBefore <10) {
    this.tokens.push({type: "space", string: " "});
    spaceBefore++;
    string = string.slice(1);
  }

  //check for operators
  var o;
  if(o = checkForOperator(string[0])) {
    while(this.stack.length > 0 && this.stack[0].type === "Operator" && ((this.stack[0].precedence >= o.precedence && !o.assocRight) || this.stack[0].precedence > o.precedence)) {
      this.output.push(this.stack.shift());
    }
    this.stack.unshift($.extend(o, {type: "Operator", spaceBefore: spaceBefore}));
    this.tokens.push({type: "Operator", string: o.symbol});
    this.parse(string.slice(o.symbol.length));
    return;
  }

  
  //check for function
  for(var f=0; f<this.functions.length; f++) {
    if(string.indexOf(this.functions[f].name)===0) {
      log("found fn ", this.functions[f].name);
      this.stack.unshift($.extend(this.functions[f], {type: "Function", spaceBefore: spaceBefore}));
      this.tokens.push({type: "Function", string: this.functions[f].name});
      var rest = string.slice(this.functions[f].name.length);
      if(rest.length<=0) {throw new Error("function without argument");}
      else {this.parse(rest);}
      return;
    }
  }

  //check for left parenthesis
  if(string[0] === "(") {
    this.stack.unshift({type: "leftPar", spaceBefore: spaceBefore});
    this.tokens.push({type: "leftPar", string: "("});
    this.parse(string.slice(1)); return;
  }
  //check for right parenthesis
  if(string[0] === ")") {
    this.tokens.push({type: "rightPar", string: ")"});
    var topOfStack = this.stack.shift();
    while(topOfStack.type !== "leftPar" && this.stack.length > 0) {
      this.output.push(topOfStack);
      topOfStack = this.stack.shift();
    }
    if(topOfStack.type !== "leftPar") {throw new Error("Syntax Error: Parenthesis do not match");}
    if(this.stack[0] && this.stack[0].type === "Function") {
      this.output.push(this.stack.shift());
    }
    else {
      this.output.push($.extend(this.functions[(this.functions.map(function(f) {return f.name;})).indexOf("hasPar")], {type: "Function", spaceBefore: spaceBefore}));
    }
    var rest = string.slice(1);
    if(couldBeImplicit(rest)) {rest = "'" + rest;}
    this.parse(rest);
    return;
  }

  //check for number
  for(var i=string.length; i>0; i--) {
    if(!isNaN(+string.slice(0, i)) && string[i-1] !== " ") {
      this.output.push({type: "Number", val: +string.slice(0, i), spaceBefore: spaceBefore});
      this.tokens.push({type: "Number", string: string.slice(0, i), val: +string.slice(0, i)});
      var rest = string.slice(i);
      if(couldBeImplicit(rest)) {rest = "'" + rest;}
      this.parse(rest);
      return;
    }
  }

  //check for identifier
  var pos = 0;
  var openbrace = 0;
  var expr = [];
  var mod = "";
  
  while(this.expressionModifiers.filter(function(m) {return string.slice(pos).indexOf(m.name+"_")===0;}).length && pos < string.length) {
    var mod = this.expressionModifiers.filter(function(m) {return (string.slice(pos)).indexOf(m.name)===0;})[0];
    expr.push(mod.name);
    pos+=mod.name.length+1;
  }
  if(this.expressionFix.filter(function(fix) {return string.slice(pos).indexOf(fix.name)===0;}).length) {
    var exprFix = this.expressionFix.filter(function(fix) {return string.slice(pos).indexOf(fix.name)===0;})[0];
    expr.push(exprFix.name);
    pos+=exprFix.name.length;
  }
  else if(string.slice(pos).length>0){
    if(string[pos] === "{") {
      end = string.slice(pos).indexOf("}");
      if(end === -1) {throw new Error("Unmatched Brace {");}
      expr.unshift(string.slice(pos + 1, end));
      pos += end+1;
    }
    else {
      expr.unshift(string[pos++]);
    }
  }
  while(string[pos] === "_") {
    var end = ++pos;
    while(openbrace > 0 || (string[end] !== " " && string[end] !== ")" && !checkForOperator(string[end]) && end < string.length && string[end] !== "_")) {
      if(string[end] === "{") openbrace++;
      if(string[end] === "}") openbrace--;
      //log(openbrace > 0 , string[end] !== " " , string[end] !== ")" , !checkForOperator(string[end]) , end < string.length , string[end] !== "_")
      if(end >= string.length) {throw new Error("infinite parsing" + string); break;}
      end++;
    }
    expr.push(string.slice(pos, end));
    pos = (string[end] === " "?(end+1):end);
    
  }
  if(pos>0) {
    this.output.push({type: "Identifier", val: expr.join("_"), spaceBefore: spaceBefore});
    this.tokens.push({type: "Identifier", string: expr.join("_")});
    var rest = string.slice(pos);
    if(couldBeImplicit(rest)) {rest = "'" + rest;}
    this.parse(rest);
    return;
  }
  
  if(string.length===0) {
    while(this.stack.length) {this.output.push(this.stack.shift());}
  }
  //
  //
  log(this.output);
  log(this.tokens);
};

Parser.prototype.render = function($el) {
  var parser = this;
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
    if(token.type === "Number") {
      string = "<span class='"+token.type.toLowerCase()+"'>"+token.val+"</span>";
    }
    if(token.type === "Identifier") {

//      for(var b = 0; b < token.val.length; b++) {
//        //if(["g", "j", "p", "q", "y"].indexOf(token.val[b]) >= 0) {overlap.bottom = 0.1; break;}
//      }
      var arr = token.val.split("_");
      var checkFixExpression = parser.expressionFix.filter(function(exp) {return exp.name===arr[0];});
      if(checkFixExpression.length) {arr[0] = checkFixExpression[0].char}
      var temp = "<span class='symbol'>"+arr[0]+"</span>";
      var isHigh = (["b", "d", "f", "h", "i", "j", "k", "l", "t"].indexOf(arr[0]) >= 0 || arr[0] !== arr[0].toLowerCase());
      overlap.top = 0;
      log(arr[0], isHigh?"isHigh":"isflat");
      for(var i = arr.length-1; i>=1; i--) {
        if(arr[i] === "delta") {
          temp = "<span class='mod delta'>&#x394;</span>" + temp;
        }
        if(arr[i] === "abl") {
          temp =  temp + "<span class='mod delta'>&#x2032;</span>";
        }
        var h = 1;
        var w = getDimensions(temp).w+0.2;
        if(arr[i] === "vec") {
          overlap.top += isHigh?0.1:0;
          isHigh = true;
          var vecUp = isHigh?(100*(overlap.top+parser.rOpt.accentUp)):0;
          log(vecUp);
          var svgArr = [[10*w,32-vecUp], [100*w-15,32-vecUp], [100*w-17,24-vecUp], [100*w, 34-vecUp], [100*w-17,44-vecUp], [100*w-15, 36-vecUp], [10*w, 36-vecUp]];
          var path = "M"+((svgArr.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" Z";
          temp = "<span class='mod vec' style='position:relative; height:"+h+"em; width:"+w+"em'><svg height='"+h+"em' width='"+w+"em' style='position:absolute; left: 0; top:-"+0+"em;' viewBox='0 0 "+w*100+" "+h*100+"'><path d='"+path+"' stroke='none'></path></svg><span style='position:relative; left:0.06em'>"+temp+"</span></span>";
        }
        else if(arr[i] === "bar") {
          overlap.top += isHigh?0.1:0;
          isHigh = true;
          var vecUp = isHigh?(100*(overlap.top+parser.rOpt.accentUp)):0;
          var svgArr = [[10*w,30-vecUp], [100*w,30-vecUp], [100*w, 34-vecUp], [10*w, 34-vecUp]];
          var path = "M"+((svgArr.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" Z";
          temp = "<span class='mod bar' style='position:relative; height:"+h+"em; width:"+w+"em'><svg height='"+h+"em' width='"+w+"em' style='position:absolute; left: 0; top:-"+0+"em;' viewBox='0 0 "+w*100+" "+h*100+"'><path d='"+path+"' stroke='none'></path></svg><span style='position:relative; left:0.06em'>"+temp+"</span></span>";
        }
        else if(arr[i] === "abs") {
          h = 1.1;
          w = w+0.1;
          var svgArr1 = [[0,20], [4,20], [4, 110], [0, 110]];
          var svgArr2 = [[100*w, 20], [100*w-4,20], [100*w-4, 110], [100*w, 110]];
          var path = "M"+((svgArr1.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" M"+((svgArr2.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" Z";
          temp = "<span class='mod abs' style='position:relative; height:"+h+"em; width:"+w+"em'><svg height='"+h+"em' width='"+w+"em' style='position:absolute; left: 0; top:-"+0+"em;' viewBox='0 0 "+w*100+" "+h*100+"'><path d='"+path+"' stroke='none'></path></svg><span style='position:relative; left:0.11em'>"+temp+"</span></span>";
        }
      }
      string = "<span class='identifier' style='position:relative;'>" + temp + "</span>";
    }
    else if(token.type === "Operator" || token.type === "Function") {
      var args = currentNodes.slice(currentNodes.length - token.numArgs);
      currentNodes = currentNodes.slice(0, currentNodes.length - token.numArgs);
      overlap.top    = max.apply(null, args.map(function(arg){return arg.overlap.top;}));
      overlap.bottom = max.apply(null, args.map(function(arg){return arg.overlap.bottom;}));

      if(token.symbol === "+") {string = "<span class='operator "+token.fn.name+"'><span class='arg1'>"+args[0].html+"</span><span class='operator__sign "+token.fn.name+"'>&#x002b;</span><span class='arg2'>"+args[1].html+"</span></span>";}
      if(token.symbol === "-") {string = "<span class='operator "+token.fn.name+"'><span class='arg1'>"+args[0].html+"</span><span class='operator__sign "+token.fn.name+"'>&#x2212;</span><span class='arg2'>"+args[1].html+"</span></span>";}
      if(token.symbol === "*") {string = "<span class='operator "+token.fn.name+"'><span class='arg1'>"+args[0].html+"</span><span class='operator__sign "+token.fn.name+"'>&#x22C5</span><span class='arg2'>"+args[1].html+"</span></span>";}
      if(token.symbol === "'") {string = "<span class='operator "+token.fn.name+"'><span class='arg1'>"+args[0].html+"</span><span class='operator__sign "+token.fn.name+"' title='implicitMiltiplication'></span><span class='arg2'>"+args[1].html+"</span></span>";}
      if(token.symbol === " ") {string = "<span class='operator "+token.fn.name+"'><span class='arg1'>"+args[0].html+"</span><span class='operator__sign "+token.fn.name+"'></span><span class='arg2'>"+args[1].html+"</span></span>";}
      if(token.symbol === "/") {
        //log(args[0].node);
        var z = args[0];
        var n = args[1];
        var zw = z.node.name === "hasPar"?z.args[0].w:z.w;
        var nw = n.node.name === "hasPar"?n.args[0].w:n.w;
        var fracReducer = parser.rOpt.fracReducer; //ES6 explode
        var fracBarOffset = parser.rOpt.fracBarOffset;
        var fracUpStandard = parser.rOpt.fracUpStandard;
        var fracDownStandard = parser.rOpt.fracDownStandard;
        var fracBarStandard = 0.35;
        var fracBar = fracBarStandard + fracBarOffset;
        var fracBarThickness = 0.07 * fracReducer;
        var fracMargin = parser.rOpt.fracMargin;
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
        var expUp = parser.rOpt.expUp;
        var expReducer = parser.rOpt.expReducer;
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

Parser.prototype.eval = function($el, scope) {
  $el.empty();

  var evalNode = function(token) {
    if(token.type === "Number") {
      currentNodes.push(token.val);
    }
    if(token.type ===  "Identifier") {
      if(scope && scope[token.val] !== undefined) {
        currentNodes.push(scope[token.val]);
      }
      else {
        //throw new Error(scope?"no scope":(token.val + " not defined in scope"));
        log(scope?"no scope":(token.val + " not defined in scope"));
      }
    }
    else if(token.type === "Operator" || token.type === "Function") {
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