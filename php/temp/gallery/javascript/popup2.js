function toggle(elementID) {
	var element = document.getElementById(elementID);
	
	if(!element) {
		element = window.parent.document.getElementById(elementID);
	}
	
	if (element.style.display == 'none') {
		element.style.display = 'block';
	} else {
		element.style.display = 'none';
		//element.innerHTML = '';
	}
}

function show(elementID) {
	toggle('bgFade');
	toggle(elementID);
}

function hide(elementID) {
	toggle('bgFade');
	toggle(elementID);
}
