const FPS = 200;
var lastTime = new Date();
var canvas, context2D, buffer;
var width, height, bufferSize;
var turbulence = {}, yIndex = {}, count = 0;

window.onload = function ()
{
	//Get context, precalc some variables, and create screen buffer
	canvas = document.getElementById('canvas');
	context2D = canvas.getContext('2d');
	width = canvas.width;
	height = canvas.height;
	bufferSize = width*height;
	buffer = context2D.createImageData(canvas.width, canvas.height);
	turbulence = context2D.createImageData(canvas.width, canvas.height);
	
	//Precalc y*width values for each horizontal line
	for(var y = 0; y < height; y++)
		yIndex[y] = y*width;
	
	//Precalc random turbulence values
	for(var i = 0; i < bufferSize; i++)
		turbulence[i] = Math.random()+0.5;
	
	context2D.font = 'bold 10px sans-serif';
	setInterval(update, 1000/FPS);
}

function update()
{
	//FPS Calc
	var currentTime = new Date();
	var currentFPS = Math.floor(1000 / (currentTime.getTime() - lastTime.getTime()));
	lastTime = currentTime;
	
	//Fill bottom line of buffer with random fire colors
	for(x = 0; x < width; x++) {
		var index = (yIndex[height-1] + x) << 2;
		var c = Math.floor(Math.random()*255);
		buffer.data[index++] = c << 1;			// r * 2
		buffer.data[index++] = c;				// g
		buffer.data[index++] = c >> 1;			// b / 2
		buffer.data[index++] = 255;				// a
	}
	
	//Loop through buffer averaging pixels left, right, and below current
	var index;
	for(y = height-2; y > 0; y--) {
		for(x = 0; x < width; x++) {
			index = (yIndex[y] + x-1) << 2;		//x-1 = left
			var r1 = buffer.data[index++];
			var g1 = buffer.data[index++];
			var b1 = buffer.data[index++];
			
			index = (yIndex[y] + x+1) << 2;		//x+1 = right
			var r2 = buffer.data[index++];
			var g2 = buffer.data[index++];
			var b2 = buffer.data[index++];
			
			index = (yIndex[y+1] + x) << 2;		//y+1 = below
			var r3 = buffer.data[index++];
			var g3 = buffer.data[index++];
			var b3 = buffer.data[index++];
			
			index = (yIndex[y] + x) << 2;		//current pixel
			var t = turbulence[((yIndex[y] + x)+(count))%bufferSize];
			
			//Average pixels, add turbulence, & write to buffer
			buffer.data[index++] = (r1+r2 >> 1)*t + r3 >> 1;
			buffer.data[index++] = (g1+g2 >> 1)*t + g3 >> 1;
			buffer.data[index++] = (b1+b2 >> 1)*t + b3 >> 1;
			buffer.data[index++] = 255;
		}
	}
	
	//Move turbulence index a random amount each frame
	count += Math.floor(Math.random()*bufferSize);
	
	//Flip buffer to canvas
	context2D.putImageData(buffer, 0,0);
	
	//Debug, Resolution, FPS Display
	context2D.fillStyle = 'rgba(32,64,128,0.75)';
	context2D.fillRect(2, 7, 92,12);
	context2D.fillStyle = '#FFF';
	context2D.fillText(width + "x" + height + " @ " + currentFPS + " fps", 4, 16);
}
