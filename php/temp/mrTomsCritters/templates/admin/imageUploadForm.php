		<div id="bgFade" class="background" style="display:none;"></div>
		<div id="imageUploadForm" class="upload" style="display:none;">
			<a class="close" href="javascript:void(0)" onclick="hide('imageUploadForm')">X</a>
			<strong>Upload Image</strong>
			<form action="admin.php?action=uploadImage" target="uploadIframe" method="post" autocomplete="off" enctype="multipart/form-data" style="text-align:center;">
				<br/>
				<input type="file" name="image" id="image" style="border: 1px solid;"/>
				<br/>
				<textarea name="description" id="description" placeholder="Description (optional)" maxlength="100000" style="width: 240px; height: 50px;"></textarea>
				<br/>
				<input type="submit" name="submit" value="OK" />
			</form>
		</div>
