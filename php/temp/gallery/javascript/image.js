function deleteImage(imageID)
{
	if(!confirm("Remove Image?")) {
		return false;
	}
	
	var previewElement = document.getElementById("imagePreview");
	var imagesField = document.getElementById("images");
	var fileNamesField = document.getElementById("fileNames");
	var images = imagesField.value.split(',');
	var fileNames = fileNamesField.value.split(',');
	var newImages = "";
	var newFileNames = "";
	
	for(var i = 0; i < images.length; i++) {
		if(images[i] != imageID) {
			if(images[i] != "" && fileNames[i] != "") {
				newImages += images[i] + ",";
				newFileNames += fileNames[i] + ",";
			}
		}
	}
	
	imagesField.value = newImages;
	fileNamesField.value = newFileNames;
	
	imagePreview();
}

function imagePreview()
{
	var previewElement = document.getElementById("imagePreview");
	var imagesField = document.getElementById("images");
	var fileNamesField = document.getElementById("fileNames");
	
	if(!previewElement) {
		previewElement = window.parent.document.getElementById("imagePreview");
	}
	if(!imagesField) {
		imagesField = window.parent.document.getElementById("images");
	}
	if(!fileNamesField) {
		fileNamesField = window.parent.document.getElementById("fileNames");
	}
	
	var images = imagesField.value.split(',');
	var fileNames = fileNamesField.value.split(',');
	var html = "<ul class='products'>";
	
	for(var i = 0; i < images.length; i++) {
		if(fileNames[i] != "") {
			html += "<li>";
			html += "<img src='imageResize.php?f=images/upload/" + fileNames[i] + "&w=200&h=100' class='preview'/>";
			html += "<br/><a href='javascript:void(0)' onclick='deleteImage(" + images[i] + ")' class='edit'>Remove Image</a>";
			html += "</li>";
		}
	}
	
	previewElement.innerHTML = html;
}