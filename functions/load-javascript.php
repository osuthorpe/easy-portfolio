<?php
/*------------------------------
       Include jQuery Scripts
-------------------------------*/

function bk_load_all_scripts() {
    if( !is_admin() ) {
        wp_deregister_script('jquery');

        wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', false, '1.7.1');
        wp_register_script('jqueryui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js', false, '1.8.16');
        wp_register_script('lightbox', get_template_directory_uri().'/js/jquery.colorbox-min.js', 'jquery');
        wp_register_script('fullscreen', get_template_directory_uri().'/js/jquery.fullscreen.js', 'jquery');
        wp_register_script('easing', get_template_directory_uri().'/js/jquery.easing.min.js', 'jquery');
        wp_register_script('mosaic', get_template_directory_uri().'/js/mosaic.1.0.1.min.js', 'jquery');
        
        wp_enqueue_script('jquery');
        wp_enqueue_script('easing');
    }
}

add_action('init' , 'bk_load_all_scripts');

function bk_openClose() { ?>
	<script>
		bk_close();
		
		$('#openClose').click(function() {
			if ($(this).is('.opened')) {
				bk_close();
			} else {
				bk_open();
			}
		
			
		});
		
		function bk_close() {
			navHeight = $('#navigation').height();
			$('#navigation').animate(
			    { marginTop: -navHeight }, // what we are animating
			    {
			        duration: 'medium', // how fast we are animating
			        easing: 'swing', // the type of easing
			});
			$('#openClose').removeClass("opened").addClass('closed');
		}
		
		function bk_open() {
			$('#navigation').animate(
			    { marginTop: 0 }, // what we are animating
			    {
			        duration: 'medium', // how fast we are animating
			        easing: 'swing', // the type of easing
			});
			$('#openClose').removeClass("closed").addClass('opened');
		}
	</script>	
<?php }

add_action('wp_footer', 'bk_openClose');

function bk_jquery_scripts() {

    if ( is_page_template('blog.php') && !is_admin() ) {
    	wp_enqueue_script('lightbox'); ?>

		<script type="text/javascript">
		
			jQuery(document).ready(function(){
				jQuery(".colorbox").colorbox({
				    maxWidth:'90%',
				    maxHeight:'90%',
				    scalePhotos:true,
				    scrolling: false
				});
			});
		</script>
	<?php }
	
	if (is_page_template('portfolios.php') && !is_admin() ) {
		wp_enqueue_script('mosaic'); ?>
		
		<script type="text/javascript">  	
			jQuery(function($){
				$('.bar').mosaic({
					animation:	'slide',
					speed : 200,
				});
		    });    
		</script>
	<?php }
}

add_action('wp_head', 'bk_jquery_scripts');

function bk_fullscreen() {
	if ((is_singular('portfolio') || is_home()) && !is_admin() ) { ?>
		<script>
			//config
			//set default images view mode
			$defaultViewMode="normal"; //full, normal, original
			$tsMargin=30; //first and last thumbnail margin (for better cursor interaction) 
			$scrollEasing=600; //scroll easing amount (0 for no easing) 
			$scrollEasingType="easeOutCirc"; //scroll easing type 
			$thumbnailsContainerOpacity=0.8; //thumbnails area default opacity
			$thumbnailsContainerMouseOutOpacity=0; //thumbnails area opacity on mouse out
			$thumbnailsOpacity=0.6; //thumbnails default opacity
			$nextPrevBtnsInitState="show"; //next/previous image buttons initial state ("hide" or "show")
			$keyboardNavigation="on"; //enable/disable keyboard navigation ("on" or "off")
			
			//cache vars
			$thumbnails_wrapper=$("#thumbnails_wrapper");
			$outer_container=$("#outer_container");
			$thumbScroller=$(".thumbScroller");
			$thumbScroller_container=$(".thumbScroller .container");
			$thumbScroller_content=$(".thumbScroller .content");
			$thumbScroller_thumb=$(".thumbScroller .thumb");
			$preloader=$("#preloader");
			$toolbar=$("#toolbar");
			$toolbar_a=$("#toolbar a");
			$bgimg=$("#bgimg");
			$img_title=$("#img_title");
			$nextImageBtn=$(".nextImageBtn");
			$prevImageBtn=$(".prevImageBtn");
			
			$(window).load(function() {
				$toolbar.data("imageViewMode",$defaultViewMode); //default view mode
				if($defaultViewMode=="full"){
					$toolbar_a.html("<img src='<?php echo get_template_directory_uri(); ?>/css/img/toolbar_n_icon.png' width='50' height='50'  />").attr("onClick", "ImageViewMode('normal');return false").attr("title", "Restore");
				} else {
					$toolbar_a.html("<img src='<?php echo get_template_directory_uri(); ?>/css/img/toolbar_fs_icon.png' width='50' height='50'  />").attr("onClick", "ImageViewMode('full');return false").attr("title", "Maximize");
				}
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
			
				//load 1st image
				var the1stImg = new Image();
				the1stImg.onload = CreateDelegate(the1stImg, theNewImg_onload);
				the1stImg.src = $bgimg.attr("src");
				$outer_container.data("nextImage",$(".content").first().next().find("a").attr("href"));
				$outer_container.data("prevImage",$(".content").last().find("a").attr("href"));
			});
			
			function BackgroundLoad($this,imageWidth,imageHeight,imgSrc){
				$this.fadeOut("fast",function(){
					$this.attr("src", "").attr("src", imgSrc); //change image source
					FullScreenBackground($this,imageWidth,imageHeight); //scale background image
					$preloader.fadeOut("fast",function(){$this.fadeIn("slow");});
					var imageTitle=$img_title.data("imageTitle");
					if(imageTitle){
						$this.attr("alt", imageTitle).attr("title", imageTitle);
						$img_title.fadeOut("fast",function(){
							$img_title.html(imageTitle).fadeIn();
						});
					} else {
						$img_title.fadeOut("fast",function(){
							$img_title.html($this.attr("title")).fadeIn();
						});
					}
				});
			}
			
			//mouseover toolbar
			if($toolbar.css("display")!="none"){
				$toolbar.fadeTo("fast", 0.4);
			}
			$toolbar.hover(
				function(){ //mouse over
					var $this=$(this);
					$this.stop().fadeTo("fast", 1);
				},
				function(){ //mouse out
					var $this=$(this);
					$this.stop().fadeTo("fast", 0.4);
				}
			);
			
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
				$img_title.data("imageTitle", title_attr); //store image title
			}
			
			//get next/prev images
			function GetNextPrevImages(curr){
				var nextImage=curr.parents(".content").next().find("a").attr("href");
				if(nextImage==null){ //if last image, next is first
					var nextImage=$(".content").first().find("a").attr("href");
				}
				$outer_container.data("nextImage",nextImage);
				var prevImage=curr.parents(".content").prev().find("a").attr("href");
				if(prevImage==null){ //if first image, previous is last
					var prevImage=$(".content").last().find("a").attr("href");
				}
				$outer_container.data("prevImage",prevImage);
			}
			
			//switch image
			function SwitchImage(img){
				$preloader.fadeIn("fast"); //show preloader
				var theNewImg = new Image();
				theNewImg.onload = CreateDelegate(theNewImg, theNewImg_onload);
				theNewImg.src = img;
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
				if($toolbar.data("imageViewMode")!="original"){ //scale
					var picHeight = imageHeight / imageWidth;
					var picWidth = imageWidth / imageHeight;
					if($toolbar.data("imageViewMode")=="full"){ //fullscreen size image mode
						if ((winHeight / winWidth) < picHeight) {
							$(theItem).attr("width",winWidth);
							$(theItem).attr("height",picHeight*winWidth);
						} else {
							$(theItem).attr("height",winHeight);
							$(theItem).attr("width",picWidth*winHeight);
						};
					} else { //normal size image mode
						if ((winHeight / winWidth) > picHeight) {
							$(theItem).attr("width",winWidth);
							$(theItem).attr("height",picHeight*winWidth);
						} else {
							$(theItem).attr("height",winHeight);
							$(theItem).attr("width",picWidth*winHeight);
						};
					}
					$(theItem).css("margin-left",(winWidth-$(theItem).width())/2);
					$(theItem).css("margin-top",(winHeight-$(theItem).height())/2);
				} else { //no scale
					$(theItem).attr("width",imageWidth);
					$(theItem).attr("height",imageHeight);
					$(theItem).css("margin-left",(winWidth-imageWidth)/2);
					$(theItem).css("margin-top",(winHeight-imageHeight)/2);
				}
			}
			
			//Image view mode function - fullscreen or normal size
			function ImageViewMode(theMode){
				$toolbar.data("imageViewMode", theMode);
				FullScreenBackground($bgimg,$bgimg.data("newImageW"),$bgimg.data("newImageH"));
				if(theMode=="full"){
					$toolbar_a.html("<img src='<?php echo get_template_directory_uri(); ?>/css/img/toolbar_n_icon.png' width='50' height='50'  />").attr("onClick", "ImageViewMode('normal');return false").attr("title", "Restore");
				} else {
					$toolbar_a.html("<img src='<?php echo get_template_directory_uri(); ?>/css/img/toolbar_fs_icon.png' width='50' height='50'  />").attr("onClick", "ImageViewMode('full');return false").attr("title", "Maximize");
				}
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
		<?php } ?>
	</script>
<?php }

add_action('wp_footer', 'bk_fullscreen');

?>