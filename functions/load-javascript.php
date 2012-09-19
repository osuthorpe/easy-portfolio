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
        wp_register_script('galleria', get_template_directory_uri().'/js/galleria-1.2.8.min.js', 'jquery');
        
        wp_enqueue_script('jquery');
        wp_enqueue_script('galleria');
    }
}

add_action('init' , 'bk_load_all_scripts');

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
}

add_action('wp_head', 'bk_jquery_scripts');

?>