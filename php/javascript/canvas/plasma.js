const FPS = 200;
var lastTime = new Date();
var canvas, context2D, buffer;
var width, height, bufferSize;
var yIndex = {}, palette = {}, sinc = {};
var tmp = 0;

window.onload = function ()
{
	//Get context, precalc some variables, and create screen buffer
	canvas = document.getElementById('canvas');
	context2D = canvas.getContext('2d');
	width = canvas.width;
	height = canvas.height;
	bufferSize = width*height;
	buffer = context2D.createImageData(canvas.width, canvas.height);
	
	//Precalc y*width values for each horizontal line
	for(var y = 0; y < height; y++)
		yIndex[y] = y*width;
	
	//Precalc 256 color palette r,g,b values
	for(var i = 0; i < 256; i++) {
		palette[i] = {}
		palette[i].r = ~~(128 + 128 * Math.sin(Math.PI * i / 64));
		palette[i].g = ~~(128 + 128 * Math.sin(Math.PI * i / 96));
		palette[i].b = ~~(128 + 128 * Math.sin(Math.PI * i / 128));
	}
	
	//Precalc Math.sin table
	for(var i = 0; i < 1800; i++) {
		sinc[i] = (Math.sin((3.1416*i)/180)*1024);
	}
	
	context2D.font = 'bold 10px sans-serif';
	setInterval(update, 1000/FPS);
}

function update()
{
	//FPS Calc
	var currentTime = new Date();
	var currentFPS = Math.floor(1000 / (currentTime.getTime() - lastTime.getTime()));
	lastTime = currentTime;
	
	var index, color, xc, yc;
	tmp = (tmp + 1) % 720;
	
	//Main loop with optimized magic plasma color formula
	for(y = 0; y < height; y++) {
		yc = 128 + ((sinc[(y << 1)+(tmp >> 1)] + sinc[y+(tmp << 1)] + (sinc[(y >> 1)+tmp] << 1)) >> 6);
		for(x = 0; x < width; x++) {
			xc = 128 + (((sinc[x+(tmp << 1)] << 1) + sinc[(x << 1)+(tmp >> 1)] + (sinc[x+tmp] << 1)) >> 6);
			
			index = (yIndex[y] + x) << 2;			//current pixel
			color = Math.abs(((yc*xc) >> 5) % 255);	//current color
			buffer.data[index++] = palette[color].r;
			buffer.data[index++] = palette[color].g;
			buffer.data[index++] = palette[color].b;
			buffer.data[index++] = 255;
		}
	}
	
	//Flip buffer to canvas
	context2D.putImageData(buffer, 0,0);
	
	//Debug, Resolution, FPS Display
	context2D.fillStyle = 'rgba(32,64,128,0.75)';
	context2D.fillRect(2, 7, 92,12);
	context2D.fillStyle = '#FFF';
	context2D.fillText(width + "x" + height + " @ " + currentFPS + " fps", 4, 16);
}
