const FPS = 200;
var lastTime = new Date();
var canvas, context2D, buffer;
var width, height, bufferSize;

window.onload = function ()
{
	//Get context, precalc some variables, and create screen buffer
	canvas = document.getElementById('canvas');
	context2D = canvas.getContext('2d');
	width = canvas.width;
	height = canvas.height;
	bufferSize = width*height;
	buffer = context2D.createImageData(width, height);
	
	context2D.font = 'bold 10px sans-serif';
	setInterval(update, 1000/FPS);
}

function update()
{
	//FPS Calc
	var currentTime = new Date();
	var currentFPS = Math.floor(1000 / (currentTime.getTime() - lastTime.getTime()));
	lastTime = currentTime;
	
	//Pick random shade for every pixel (0-255)
	for(var i = 0; i < bufferSize; i++) {
		var c = Math.floor(Math.random()*255);
		var index = i*4;
		buffer.data[index++] = c;
		buffer.data[index++] = c;
		buffer.data[index++] = c;
		buffer.data[index++] = 255;
	}
	
	//Flip buffer to canvas
	context2D.putImageData(buffer, 0,0);
	
	//Debug, Resolution, FPS Display
	context2D.fillStyle = 'rgba(32,64,128,0.75)';
	context2D.fillRect(2,7, 98,12);
	context2D.fillStyle = '#FFF';
	context2D.fillText(width + "x" + height + " @ " + currentFPS + " fps", 4, 16);
}
