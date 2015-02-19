function Parser(termstring, $renderDom, $resultDom){
  //var parser = this;
  
  this.termstring = termstring;
  this.$renderDom = $renderDom;
  this.$resultDom = $resultDom;
  
  //Cambria
  this.renderingOptions = {
    fracReducer: 0.75,
    fracUpStandard: 0.5,
    fracDownStandard: 0.5,
    fracBarOffset: -0.068,
    fracMargin: 0.11,
    expReducer: 0.68,
    expUp: 0.52,
  };
  
//Open Sans
//  this.renderingOptions = {
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
}

Parser.prototype.update = function(options) {
  if(options) {
    if(options.termstring) this.termstring = options.termstring;
  }
  this.constructor();
}

Parser.prototype.operators = [
  {symbol: "+", numArgs: 2, precedence: 1, assocRight: 0, fn: function add(a,b) {return +a+b;}},
  {symbol: "-", numArgs: 2, precedence: 1, assocRight: 0, fn: function subtract(a,b) {return a-b;}},
  {symbol: "*", numArgs: 2, precedence: 2, assocRight: 0, fn: function multiply(a,b) {return a*b;}},
  {symbol: " ", numArgs: 2, precedence: 3, assocRight: 0, fn: function multiplyImplicit(a,b) {return a*b;}},
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
];

Parser.prototype.parse = function(string) {
  
  var parser = this;
  
  var checkForOperator = function(symbol) {
    var matchingOperator = parser.operators.filter(function(el) {return el.symbol === symbol});
    return matchingOperator.length > 0 ? matchingOperator[0] : false;
  };
  
  //check for operators
  var o;
  if(o = checkForOperator(string[0])) {
    while(this.stack.length > 0 && this.stack[0].type === "Operator" && ((this.stack[0].precedence >= o.precedence && !o.assocRight) || this.stack[0].precedence > o.precedence)) {
      this.output.push(this.stack.shift());
    }
    this.stack.unshift($.extend(o, {type: "Operator"}));
    this.tokens.push({type: "Operator", string: o.symbol});
    this.parse(string.slice(o.symbol.length));
    return;
  }
  //check for function
  for(var f=0; f<this.functions.length; f++) {
    if(string.indexOf(this.functions[f].name)==0) {
      this.stack.unshift($.extend(this.functions[f], {type: "Function"}));
      this.tokens.push({type: "Function", string: this.functions[f].name});
      this.parse(string.slice(this.functions[f].name.length));
      return;
    }
  }
  //check for left parenthesis
  if(string[0] === "(") {
    this.stack.unshift({type: "leftPar"});
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
    if(this.stack[0] && this.stack[0].type == "Function") {
      this.output.push(this.stack.shift());
    }
    else {
      this.output.push($.extend(this.functions[(this.functions.map(function(f) {return f.name;})).indexOf("hasPar")], {type: "Function"}));
    }
    this.parse(string.slice(1)); return;
  }
  //check for space
  if(string[0] === " ") {
    this.tokens.push({type: "space", string: " "});
    this.parse(string.slice(1)); return;
  }
  //check for number
  for(var i=string.length; i>0; i--) {
    if(!isNaN(+string.slice(0, i)) && string[i-1] !== " ") {
      this.output.push({type: "Number", val: +string.slice(0, i)});
      this.tokens.push({type: "Number", string: string.slice(0, i), val: +string.slice(0, i)});
      this.parse(string.slice(i));
      return;
    }
  }
  //check for identifier
  var pos = 0;
  var openbrace = 0;
  while(openbrace > 0 || (string[pos] !== " " && string[pos] !== ")" && !checkForOperator(string[pos]) && pos < string.length)) {
    pos++;
    if(string[pos] === "{") openbrace++;
    if(string[pos] === "}") openbrace--;
    if(pos > string.length) {throw new Error("infinite parsing" + string); break;}
  }
  if(pos>0) {
    this.output.push({type: "Identifier", val: string.slice(0, pos)});
    this.tokens.push({type: "Identifier", string: string.slice(0, pos)});
    this.parse(string.slice(pos)); return;
  }
  if(string.length===0) {
    while(this.stack.length) {this.output.push(this.stack.shift());}
  }
  //log(this.output);
};

Parser.prototype.render = function($el) {
  
  var parser = this;
  this.renderTree = [];
  $el.empty();
  
  var createNode = function(token) {
    var string;
    var overlap = {top: 0, bottom: 0};
    if(token.type == "Number") {
      string = "<span class='"+token.type.toLowerCase()+"'>"+token.val+"</span>";
    }
    if(token.type == "Identifier") {
//      overlap.top = -0.05;
//      for(var b = 0; b < token.val.length; b++) {
//        if(["b", "d", "f", "h", "i", "j", "k", "l", "t"].indexOf(token.val[b]) >= 0) {overlap.top = 0; break;}
//      }
      for(var b = 0; b < token.val.length; b++) {
        if(["g", "j", "p", "q", "y"].indexOf(token.val[b]) >= 0) {overlap.bottom = 0.1; break;}
      }
      string = "<span class='"+token.type.toLowerCase()+"'>"+token.val+"</span>";
    }
    else if(token.type == "Operator" || token.type == "Function") {
      var args = currentNodes.slice(currentNodes.length - token.numArgs);
      currentNodes = currentNodes.slice(0, currentNodes.length - token.numArgs);
      overlap.top    = max.apply(null, args.map(function(arg){return arg.overlap.top;}));
      overlap.bottom = max.apply(null, args.map(function(arg){return arg.overlap.bottom;}));

      if(token.symbol == "+") {string = "<span class='operator "+token.fn.name+"'><span class='arg1'>"+args[0].html+"</span><span class='operator__sign "+token.fn.name+"'>&#x002b;</span><span class='arg2'>"+args[1].html+"</span></span>";}
      if(token.symbol == "-") {string = "<span class='operator "+token.fn.name+"'><span class='arg1'>"+args[0].html+"</span><span class='operator__sign "+token.fn.name+"'>&#x2212;</span><span class='arg2'>"+args[1].html+"</span></span>";}
      if(token.symbol == "*") {string = "<span class='operator "+token.fn.name+"'><span class='arg1'>"+args[0].html+"</span><span class='operator__sign "+token.fn.name+"'>&#x22C5</span><span class='arg2'>"+args[1].html+"</span></span>";}
      if(token.symbol == " ") {string = "<span class='operator "+token.fn.name+"'><span class='arg1'>"+args[0].html+"</span><span class='operator__sign "+token.fn.name+"'></span><span class='arg2'>"+args[1].html+"</span></span>";}
      if(token.symbol == "/") {
        log(args[0].node);
        var z = args[0];
        var n = args[1];
        var zw = z.node.name === "hasPar"?z.args[0].w:z.w;
        var nw = n.node.name === "hasPar"?n.args[0].w:n.w;
        var fracReducer = parser.renderingOptions.fracReducer; //ES6 explode
        var fracBarOffset = parser.renderingOptions.fracBarOffset;
        var fracUpStandard = parser.renderingOptions.fracUpStandard;
        var fracDownStandard = parser.renderingOptions.fracDownStandard;
        var fracBarStandard = 0.35;
        var fracBar = fracBarStandard + fracBarOffset;
        var fracBarThickness = 0.07 * fracReducer;
        var fracMargin = parser.renderingOptions.fracMargin;
        //lineheight = 1.2;
        var fracUp = fracUpStandard + fracMargin + fracBarOffset + fracReducer * z.overlap.bottom; //1fracBar //(args[0].h*fracReducer - fracBar) + fracMargin;
        var fracDown = fracDownStandard + fracBarThickness + fracMargin - fracBarOffset + fracReducer * n.overlap.top; //1 - fracBar + fracMargin// + (args[1].h);
        overlap.top = fracReducer * (fracUp + z.overlap.top); //fracUp - 1 + fracReducer * (1 + z.overlap.top)
        overlap.bottom = fracReducer * (fracDown + n.overlap.bottom); //fracDown - 1 + fracReducer * (1 + n.overlap.bottom)
        var width = (max(zw,nw) + 0.4) * fracReducer // parseFloat(window.getComputedStyle($el[0], null).getPropertyValue('font-size')));
        string = "<span class='operator "+token.fn.name+"' style='position:relative; width:"+width+"em'>" +
          "<span class='divisionbar' style='width:"+width+"em; position:relative;'><svg height='1em' width='"+width+"em' viewBox='0 0 "+width+" 1'><line x1='0' y1='"+(1-fracBar)+"' x2='"+width+"' y2='"+(1-fracBar)+"' style='stroke:currentColor;stroke-width:"+fracBarThickness+"'/></line></svg></span>" +
          "<span class='arg1' style='position: absolute; top: -"+ fracUp+"em; left: "+ 0.5 * (width-zw*fracReducer)+"em;'><span class='enumerator' style='font-size: " +(100*fracReducer+"%")+"'>"+args[0].html+"</span></span>" +
          "<span class='arg2' style='position: absolute; top: "+fracDown+"em; left: "+ 0.5 * (width-nw*fracReducer)+"em;'><span class='denominator' style='font-size: "+(100*fracReducer+"%")+"'>"+args[1].html+"</span></span></span>";
      }
      if(token.symbol == "^") {
        var expUp = parser.renderingOptions.expUp;
        var expReducer = parser.renderingOptions.expReducer;
        var expMargin = 0.15;
        overlap.top = args[0].overlap.top + expUp + expReducer - 1 + expReducer*args[1].overlap.top;
        var width = args[0].w + expMargin + expReducer * args[1].w;
        string = "<span class='operator "+token.fn.name+"' style='position:relative; width:"+width+"em; display:inline-block;'><span class='arg1'>"+args[0].html+"</span><span class='arg2' style='position: absolute; top: -"+(args[0].overlap.top+expUp)+"em; right: 0em; margin-left: "+expMargin+"em;'><span class='exponent' style='font-size: "+(100*expReducer)+"%'>&nbsp;"+args[1].html+"</span></span></span>";
      }  
      if(["sin", "cos", "tan", "arcsin", "arccos", "arctan"].indexOf(token.name) >= 0) {
        string = "<span class='function "+token.name+"'><span class='functionname'>"+token.name+"</span>(<span class='arg1'>"+args[0].html+"</span>)</span>";
      }
      if(token.name == "minus") {string = "<span class='function "+token.fn.name+"'><span class='functionname'>&nbsp;&#x2212;&nbsp;</span><span class='arg1'>"+args[0].html+"</span></span>";}
      if(token.name == "sqrt" || token.name == "cbrt" || token.name == "fort") {
        var h = 1.1 + args[0].overlap.top + args[0].overlap.bottom/2;
        var radixFrontwidth = 0.7;
        var radixStroke = 100*0.07;
        var width = args[0].w + radixFrontwidth + 0.1;
        overlap.top = 0.1 + args[0].overlap.top;
        var svgArr = [[65.859,0+radixStroke],[42.129,96.4*h+radixStroke],[18.574,54.505*h+radixStroke],[6.973,59.896*h+radixStroke],[4.922,56.204*h],[22.559,47.298*h],[41.426,80.814*h],[41.66,80.814*h],[61.582,0],[100*width,0],[100*width,0+radixStroke],[65.859*h,0+radixStroke]];
        var path = "M"+((svgArr.map(function(point) {return ""+point[0]+" "+point[1];})).join(" L"))+" Z";
        var radix = "";
        if(token.name == "cbrt" || token.name == "fort" ) {
          radix = "<span style='position:absolute; left: 0; top:-"+overlap.top+"em; font-size:50%;'>"+(token.name === "cbrt"?3:4)+"</span>"
        }
        string = "<span class='function "+token.fn.name+"' style='position:relative'><span class='functionname' style='position:relative; width:"+radixFrontwidth+"em;'>&nbsp;"+radix+"<svg height='"+h+"em' width='"+width+"em' style='position:absolute; left: 0; top:-"+args[0].overlap.top+"em;' viewBox='0 0 "+width*100+" "+h*100+"'><path d='"+path+"' stroke='none'></path></svg></span><span class='arg1'>"+args[0].html+"</span></span>";
      }
      if(token.name == "hasPar") {
        string = "<span class='openpar'>(</span>"+args[0].html+"<span class='closepar'>)</span>";
      }
    }

    var $node = $("<span>"+string+"</span>").appendTo(measuringNode.empty());
    var cs = window.getComputedStyle($node[0], null);
    var fontsize = parseFloat(cs.getPropertyValue('font-size'))
    //alert(string)
    //currentNodes.push({html: string, w: $node.width()/fontsize, h: $node.height()/fontsize, fh: fontsize, overlap: overlap});
    currentNodes.push({html: string, w: $node.width()/fontsize, overlap: overlap, node: token, args: args});
    measuringNode.empty();
  }

  var measuringNode = $("<div style='position:absolute; width: 200em;'></div>").appendTo($el);
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

//  this.createTree = function() {
//    var currentNodes = [];
//    for(var i = this.output.length-1; i>=0; i--) {
//      var next = this.output[i];
//      if(next.type == "Number" || next.type == "Identifier") {
//        currentNodes.push({node: next, args: []});
//      }
//      else {
//        var args = currentNodes.slice(currentNodes.length - next.numArgs);
//        currentNodes = currentNodes.slice(0, currentNodes.length - next.numArgs);
//        currentNodes.push({node: next, args: args})
//      }
//    }
//    log(currentNodes)
//    return currentNodes[0];
//  };
  