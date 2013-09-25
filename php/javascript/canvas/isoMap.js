const FPS = 200;
var lastTime = new Date();
var canvas, context2D, buffer, heightmap;

var keyDown = {};
var keyUp = {};
const KEY = {
	LEFT: 37,
	UP: 38,
	RIGHT: 39,
	DOWN: 40,
	ADD: 107,
	SUB: 109
};

var viewport = {
	x: 0,
	y: 0,
	size: 256,
	scale: 0
};

window.onload = function (){
	//Get context, precalc some variables, and create screen buffer
	canvas = document.getElementById('canvas');
	canvas.centerX = canvas.width / 2;
	canvas.centerY = canvas.height / 2;
	context2D = canvas.getContext('2d');
	context2D.font = 'bold 10px sans-serif';
	buffer = context2D.createImageData(canvas.width,canvas.height);
	buffer.lineHeight = buffer.width * 4;
	
	//Load heightmap image and convert to imageData object
	var img = new Image();
	img.src = "images/map.png";
	img.onload = function () {
	    var hiddenCanvas = document.createElement('canvas');
		var hiddenContext = hiddenCanvas.getContext("2d");
		hiddenCanvas.width = img.width;
		hiddenCanvas.height = img.height;
		hiddenContext.drawImage(img, 0,0, img.width,img.height, 0,0,hiddenCanvas.width,hiddenCanvas.height);
		heightmap = hiddenContext.getImageData(0,0, hiddenCanvas.width,hiddenCanvas.height);
		
		//scale heightmap values (alpha channel) to lower range
		for(var i = 0; i < heightmap.data.length; i += 4) {
			heightmap.data[i+3] /= 2;
		}
		setInterval(update, 1000/FPS);
	};
	
	//Keyboard controls
	document.onkeydown = function(event) {
		for(var i in KEY) {
			if(event.keyCode == KEY[i]) {
				keyDown[event.keyCode] = true;
				return false;
			}
		}
	};
	
	document.onkeyup = function(event) {
		keyUp[event.keyCode] = true;
	};

};

//Clears keyUp & keyDown buffers
function clearKeys()
{
	for(var i in keyUp) {
		if(keyUp[i]) {
			keyDown[i] = false;
			keyUp[i] = false;
		}
	}
};

//Checks key buffers and moves/scales viewport 
function checkKeys()
{
	var speed = 1 / ((viewport.scale+1));
	var xVel = 0;
	var yVel = 0;
	
	if(keyDown[KEY.RIGHT]) {
		xVel += speed;
		yVel -= speed;
	}
	if(keyDown[KEY.LEFT]) {
		xVel -= speed;
		yVel += speed;
	}
	if(keyDown[KEY.DOWN]) {
		xVel += speed;
		yVel += speed;
	}
	if(keyDown[KEY.UP]) {
		xVel -= speed;
		yVel -= speed;
	}
	if(keyUp[KEY.ADD]) {
		viewport.scale++;
		viewport.size = 255 >> viewport.scale;
	}
	if(keyUp[KEY.SUB]) {
		if(viewport.scale > 0) {
			viewport.scale--;
			viewport.size = 255 >> viewport.scale;
		}
	}
	
	setViewport(viewport.x+xVel, viewport.y+yVel);
	clearKeys();
};

//Set viewport position clipped to heightmap dimensions
function setViewport(x,y)
{
	if((x > 0)&&(x < heightmap.width-viewport.size)) {
		viewport.x = x;
	}
	
	if((y > 0)&&(y < heightmap.height-viewport.size)) {
		viewport.y = y;
	}
};

function update()
{
	var canvasCenterX = canvas.centerX;
	var canvasCenterY = canvas.centerY >> 1;
	var heightmapData = heightmap.data;
	var heightmapWidth = heightmap.width;
	var bufferData = buffer.data;
	var bufferWidth = buffer.width;
	var bufferLineHeight = buffer.lineHeight;
	var bufferDataLength = bufferData.length;
	var viewportScale = viewport.scale;
	
	//fps calc
	var currentTime = new Date();
	var currentFPS = Math.floor(1000 / (currentTime.getTime() - lastTime.getTime()));
	lastTime = currentTime;
	
	//clear buffer
	for(var i = 0; i < bufferDataLength; i += 4) {
		bufferData[i] = 0;
		bufferData[i+1] = 0;
		bufferData[i+2] = 0;
		bufferData[i+3] = 255;
	}
	
	//draw heightmap
	for(var u = 256; u > 0; u--) {
		for(var v = 256; v > 0; v--) {
			var mapX = Math.ceil(viewport.x +(u >> viewportScale));
			var mapY = Math.ceil(viewport.y +(v >> viewportScale));
			
			var mapIndex = ((mapY * heightmapWidth) + mapX) << 2;
			var r = heightmapData[mapIndex];
			var g = heightmapData[mapIndex+1];
			var b = heightmapData[mapIndex+2];
			var height = heightmapData[mapIndex+3];
			
			var screenX = canvasCenterX + (u-v);
			var screenY = canvasCenterY + ((u+v) >> 1) - height;
			var index = ((screenY * bufferWidth) + screenX) << 2;
			var count = 0;
			
			if(index < bufferLineHeight) {
				break;
			}
			
			while(height > 0) {
				bufferData[index] = r-count;
				bufferData[index+1] = g-count;
				bufferData[index+2] = b-count;
				bufferData[index+3] = 255;
				index += bufferLineHeight;
				height -= 2;
				if(count < 255) { count += 8; }
				if((bufferData[index] != 0)&&(bufferData[index+1] != 0)&&(bufferData[index+2] != 0)) {
					break;	//no overdraw
				}
			}
		}
	}
	
	//flip buffer
	context2D.putImageData(buffer, 0,0);
	
	//draw stats
	context2D.fillStyle = 'rgba(32,64,128,0.75)';
	context2D.fillRect(2,7, 98,12);
	context2D.fillStyle = '#FFF';
	context2D.fillText(canvas.width + "x" + canvas.height + " @ " + currentFPS + " fps ", 4, 16);
	context2D.fillText("scale: " + viewport.scale + "x", 4, canvas.height-16);
	context2D.fillText(heightmap.width + "x" + heightmap.height + " map loaded", 4, canvas.height-4);
	context2D.fillText(viewport.x + "/" + viewport.y, canvas.width-64, canvas.height-4);
	checkKeys();
};
