<?php

/*-----------------------------------------
      Include basic set-up functions
-----------------------------------------*/

include (TEMPLATEPATH . '/functions/basics.php'); //basic WP settings
include (TEMPLATEPATH . '/functions/load-javascript.php'); //Load Javascript for theme
include (TEMPLATEPATH . '/functions/post_types.php'); //adds custom post types


// Re-define meta box path and URL
define( 'RWMB_URL', trailingslashit( get_stylesheet_directory_uri() . '/functions/meta-box' ) );
define( 'RWMB_DIR', trailingslashit( TEMPLATEPATH . '/functions/meta-box' ) );

// Include the meta box script
require_once RWMB_DIR . 'meta-box.php';

// Include the meta box definition
include RWMB_DIR . 'meta-box-usage.php';

if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/functions/admin/' );
	require_once dirname( __FILE__ ) . '/functions/admin/options-framework.php';
}
?>