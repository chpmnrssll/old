//config
$tsMargin=30;							//first and last thumbnail margin (for better cursor interaction) 
$scrollEasing=600;						//scroll easing amount (0 for no easing) 
$scrollEasingType="easeOutCirc";		//scroll easing type
$thumbnailsContainerOpacity=0.0;			//thumbnails area default opacity 0.8
$thumbnailsContainerMouseOutOpacity=0.0;	//thumbnails area opacity on mouse out
$thumbnailsOpacity=0.5;					//thumbnails default opacity 0.6
$nextPrevBtnsInitState="show";			//next/previous image buttons initial state ("hide" or "show")
$keyboardNavigation="on";				//enable/disable keyboard navigation ("on" or "off")
$slideShow="on";						//enable/disable slideShow ("on" or "off")
$slideInterval=10000;					//time in ms between slides
$slideTimer=null;

//cache vars
$thumbnails_wrapper=$("#thumbnails_wrapper");
$outer_container=$("#outer_container");
$thumbScroller=$(".thumbScroller");
$thumbScroller_container=$(".thumbScroller .container");
$thumbScroller_content=$(".thumbScroller .image");
$thumbScroller_thumb=$(".thumbScroller .thumb");
$preloader=$("#preloader");
$bgimg=$("#bgimg");
$img_title=$("#img_title");
$img_text=$("#img_text");;
$nextImageBtn=$(".nextImageBtn");
$prevImageBtn=$(".prevImageBtn");

$(document).ready(function () {
	$('#nav li').hover(
		function () {
			//show its submenu
			$('ul', this).slideDown(200);
		},
		function () {
			//hide its submenu
			$('ul', this).slideUp(100);
		}
	);
});

$(window).load(function() {
	ShowHideNextPrev($nextPrevBtnsInitState);
	//thumbnail scroller
	$thumbScroller_container.css("marginLeft",$tsMargin+"px"); //add margin
	sliderLeft=$thumbScroller_container.position().left;
	sliderWidth=$outer_container.width();
	$thumbScroller.css("width",sliderWidth);
	var totalContent=0;
	fadeSpeed=200;
	
	var $the_outer_container=document.getElementById("outer_container");
	var $placement=findPos($the_outer_container);
	
	$thumbScroller_content.each(function () {
		var $this=$(this);
		totalContent+=$this.innerWidth();
		$thumbScroller_container.css("width",totalContent);
		$this.children().children().children(".thumb").fadeTo(fadeSpeed, $thumbnailsOpacity);
	});

	$thumbScroller.mousemove(function(e){
		if($thumbScroller_container.width()>sliderWidth){
	  		var mouseCoords=(e.pageX - $placement[1]);
	  		var mousePercentX=mouseCoords/sliderWidth;
	  		var destX=-((((totalContent+($tsMargin*2))-(sliderWidth))-sliderWidth)*(mousePercentX));
	  		var thePosA=mouseCoords-destX;
	  		var thePosB=destX-mouseCoords;
	  		if(mouseCoords>destX){
		  		$thumbScroller_container.stop().animate({left: -thePosA}, $scrollEasing,$scrollEasingType); //with easing
	  		} else if(mouseCoords<destX){
		  		$thumbScroller_container.stop().animate({left: thePosB}, $scrollEasing,$scrollEasingType); //with easing
	  		} else {
				$thumbScroller_container.stop();  
	  		}
		}
	});

	$thumbnails_wrapper.fadeTo(fadeSpeed, $thumbnailsContainerOpacity);
	$thumbnails_wrapper.hover(
		function(){ //mouse over
			var $this=$(this);
			$this.stop().fadeTo("slow", 1);
		},
		function(){ //mouse out
			var $this=$(this);
			$this.stop().fadeTo("slow", $thumbnailsContainerMouseOutOpacity);
		}
	);

	$thumbScroller_thumb.hover(
		function(){ //mouse over
			var $this=$(this);
			$this.stop().fadeTo(fadeSpeed, 1);
		},
		function(){ //mouse out
			var $this=$(this);
			$this.stop().fadeTo(fadeSpeed, $thumbnailsOpacity);
		}
	);

	//on window resize scale image and reset thumbnail scroller
	$(window).resize(function() {
		FullScreenBackground("#bgimg",$bgimg.data("newImageW"),$bgimg.data("newImageH"));
		$thumbScroller_container.stop().animate({left: sliderLeft}, 400,"easeOutCirc"); 
		var newWidth=$outer_container.width();
		$thumbScroller.css("width",newWidth);
		sliderWidth=newWidth;
		$placement=findPos($the_outer_container);
	});

	$outer_container.data("nextImage",$(".image").first().next().find("a").attr("href"));
	$outer_container.data("prevImage",$(".image").last().find("a").attr("href"));
	
	//load 1st image
	var the1stImg = new Image();
	the1stImg.onload = CreateDelegate(the1stImg, theNewImg_onload);
	//the1stImg.src = $bgimg.attr("src");
	the1stImg.src = $(".image").first().find("a").attr("href");		//first image in container
	$img_title.data("imageTitle", $(".thumb").first().attr("title"));
	$img_text.data("imageText", $(".thumb").first().attr("text"));
});

function BackgroundLoad($this,imageWidth,imageHeight,imgSrc){
	$this.fadeOut("fast",function(){
		$this.attr("src", "").attr("src", imgSrc); //change image source
		FullScreenBackground($this,imageWidth,imageHeight); //scale background image
		$preloader.fadeOut("fast",function(){$this.fadeIn("slow");});
		var imageTitle=$img_title.data("imageTitle");
		if(imageTitle){
			//$this.attr("alt", imageTitle).attr("title", imageTitle);
			$img_title.html(imageTitle);
		} else {
			$img_title.html($this.attr("title"));
		}
		
		$img_text.html($img_text.data("imageText"));
	});
}

//Clicking on thumbnail changes the background image
$("#outer_container a").click(function(event){
	event.preventDefault();
	var $this=$(this);
	GetNextPrevImages($this);
	GetImageTitle($this);
	SwitchImage(this);
	ShowHideNextPrev("show");
}); 

//next/prev images buttons
$nextImageBtn.click(function(event){
	event.preventDefault();
	SwitchImage($outer_container.data("nextImage"));
	var $this=$("#outer_container a[href='"+$outer_container.data("nextImage")+"']");
	GetNextPrevImages($this);
	GetImageTitle($this);
});

$prevImageBtn.click(function(event){
	event.preventDefault();
	SwitchImage($outer_container.data("prevImage"));
	var $this=$("#outer_container a[href='"+$outer_container.data("prevImage")+"']");
	GetNextPrevImages($this);
	GetImageTitle($this);
});

//next/prev images keyboard arrows
if($keyboardNavigation=="on"){
$(document).keydown(function(ev) {
    if(ev.keyCode == 39) { //right arrow
        SwitchImage($outer_container.data("nextImage"));
		var $this=$("#outer_container a[href='"+$outer_container.data("nextImage")+"']");
		GetNextPrevImages($this);
		GetImageTitle($this);
        return false; // don't execute the default action (scrolling or whatever)
    } else if(ev.keyCode == 37) { //left arrow
        SwitchImage($outer_container.data("prevImage"));
		var $this=$("#outer_container a[href='"+$outer_container.data("prevImage")+"']");
		GetNextPrevImages($this);
		GetImageTitle($this);
        return false; // don't execute the default action (scrolling or whatever)
    }
});
}

//automatically change slide
if($slideShow=="on") setSlideTimer();

function setSlideTimer() {
	$slideTimer = setInterval(
		function () {
			SwitchImage($outer_container.data("nextImage"));
			var $this=$("#outer_container a[href='"+$outer_container.data("nextImage")+"']");
			GetNextPrevImages($this);
			GetImageTitle($this);
		}, $slideInterval);
}

function ShowHideNextPrev(state){
	if(state=="hide"){
		$nextImageBtn.fadeOut();
		$prevImageBtn.fadeOut();
	} else {
		$nextImageBtn.fadeIn();
		$prevImageBtn.fadeIn();
	}
}

//get image title
function GetImageTitle(elem){
	var title_attr=elem.children("img").attr("title"); //get image title attribute
	var text_attr=elem.children("img").attr("text"); //get image text attribute
	$img_title.data("imageTitle", title_attr); //store image title
	if(text_attr) {
		$img_text.data("imageText", text_attr); //store image text
	} else {
		$img_text.data("imageText", "");
	}
}

//get next/prev images
function GetNextPrevImages(curr){
	var nextImage=curr.parents(".image").next().find("a").attr("href");
	if(nextImage==null){ //if last image, next is first
		var nextImage=$(".image").first().find("a").attr("href");
	}
	$outer_container.data("nextImage",nextImage);
	var prevImage=curr.parents(".image").prev().find("a").attr("href");
	if(prevImage==null){ //if first image, previous is last
		var prevImage=$(".image").last().find("a").attr("href");
	}
	$outer_container.data("prevImage",prevImage);
}

//switch image
function SwitchImage(img){
	clearInterval($slideTimer);
	$preloader.fadeIn("fast"); //show preloader
	var theNewImg = new Image();
	theNewImg.onload = CreateDelegate(theNewImg, theNewImg_onload);
	theNewImg.src = img;
	if($slideShow=="on") setSlideTimer();
}

//get new image dimensions
function CreateDelegate(contextObject, delegateMethod){
	return function(){
		return delegateMethod.apply(contextObject, arguments);
	}
}

//new image on load
function theNewImg_onload(){
	$bgimg.data("newImageW",this.width).data("newImageH",this.height);
	BackgroundLoad($bgimg,this.width,this.height,this.src);
}

//Image scale function
function FullScreenBackground(theItem,imageWidth,imageHeight){
	var winWidth=$(window).width();
	var winHeight=$(window).height();
	var picHeight = imageHeight / imageWidth;
	var picWidth = imageWidth / imageHeight;
	if ((winHeight / winWidth) < picHeight) {
		$(theItem).attr("width",winWidth);
		$(theItem).attr("height",picHeight*winWidth);
	} else {
		$(theItem).attr("height",winHeight);
		$(theItem).attr("width",picWidth*winHeight);
	};
	$(theItem).css("margin-left",(winWidth-$(theItem).width())/2);
	$(theItem).css("margin-top",(winHeight-$(theItem).height())/2);
}

//function to find element Position
function findPos(obj) {
	var curleft = curtop = 0;
	if (obj.offsetParent) {
		curleft = obj.offsetLeft
		curtop = obj.offsetTop
		while (obj = obj.offsetParent) {
			curleft += obj.offsetLeft
			curtop += obj.offsetTop
		}
	}
	return [curtop, curleft];
}
