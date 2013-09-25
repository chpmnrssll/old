function toggleImage(elementID, src, description) {
	var element = document.getElementById(elementID);
	
	if(element.style.display == 'none') {
		element.style.display = 'block';
		if(src) {
			element.innerHTML = '<a class="close" href="javascript:void(0)" onclick="hideImage(\'' + elementID + '\')">X</a>';
			element.innerHTML += '<img src=' + src + ' class="full"/>';
		}
		if(description) {
			if(description != "") {
				element.innerHTML += '<span style="border: 1px solid #000; background:#FFF">' + description + '</span>';
			}
		}	
	}
	else {
		element.style.display = 'none';
		element.innerHTML = '';
	}
}

function showImage(elementID, src, description) {
	toggleImage('bgFade');
	toggleImage(elementID, src, description);
}

function hideImage(elementID) {
	toggleImage('bgFade');
	toggleImage(elementID);
}
