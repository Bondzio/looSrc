/** function drawArrow()
 * 
 * @param {object} params from, x1, y1, to, x2, y2, color, thickness, alpha, headsize, pointiness
 * @returns {undefined}
 */
function drawArrow(params) {
  var params = params || {};
  params.from = params.from || {};
  params.to = params.to || {};
  var x1 = params.x1 || params.from.x || 0;
  var y1 = params.y1 || params.from.y || 0;
  var x2 = params.x2 || params.to.x || 0;
  var y2 = params.y2 || params.to.y || 0;
  var length = Math.sqrt((x1-x2)*(x1-x2) + (y1-y2)*(y1-y2));
  var angle = Math.atan2((y2-y1), (x2-x1));
  var color = params.color || "#900";
  var thickness = params.thickness || 3;
  var alpha = params.alpha || 1;
  var headsize = params.headsize || Math.min(10+10*thickness, length/3);
  var pointiness = params.pointiness || 0.2;

  var arrow = new PIXI.Graphics();
  
  arrow.lineStyle(thickness, color, alpha);
  arrow.moveTo(x1, y1);
  arrow.lineTo(x2 - 0.8*headsize*Math.cos(angle), y2 - 0.8*headsize*Math.sin(angle));
  arrow.lineStyle(color, 0, 0);
  arrow.beginFill(color, alpha);
  arrow.moveTo(x2, y2);
  arrow.lineTo(x2+headsize*Math.cos(angle+Math.PI+pointiness), y2+headsize*Math.sin(angle+Math.PI+pointiness));
  arrow.lineTo(x2+headsize*Math.cos(angle+Math.PI-pointiness), y2+headsize*Math.sin(angle+Math.PI-pointiness));
  arrow.lineTo(x2, y2);
  arrow.endFill();
  
  //stage.addChild(arrow);
  //renderer.render(stage);
  
  return arrow;
}

/** function drawLine()
 * 
 * @param {object} params from, x1, y1, to, x2, y2, color, thickness, alpha
 * @returns {undefined}
 */
function drawLine(params) {
  var params = params || {};
  params.from = params.from || {};
  params.to = params.to || {};
  var x1 = params.x1 || params.from.x || 0;
  var y1 = params.y1 || params.from.y || 0;
  var x2 = params.x2 || params.to.x || 0;
  var y2 = params.y2 || params.to.y || 0;
  var color = params.color || 0x000099;
  //console.log(color);
  var thickness = params.thickness || 3;
  var alpha = params.alpha || 1;

  var line = new PIXI.Graphics();
  
  line.lineStyle(thickness, color, alpha);
  line.moveTo(x1, y1);
  line.lineTo(x2, y2);
  
  //stage.addChild(line);
  //renderer.render(stage);
  
  return line;
}


function SpriteObject(img, x, y, params) {
  var params = params || {};
  var texture = params.texture || new PIXI.Texture.fromImage(img);
	this.sprite = new PIXI.Sprite(texture);
  this.x = x || 0;
  this.y = y || 0;
  this.sprite.position = toScreen(this);
  this.sprite.rotation = params.rotation || 0;
  this.sprite.anchor = params.anchor || {x:0.5, y:0.5};
  this.sprite.scale = params.scale || {x:1, y:1};
  this.sprite.alpha = params.alpha || 1;
  return this.sprite;
}

PIXI.DisplayObjectContainer.prototype.removeAll = function()
{
  while(this.children&&this.children.length>0)
  {
    this.removeChild(this.children[0]);
  }
};

