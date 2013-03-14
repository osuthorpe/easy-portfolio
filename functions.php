<?php

//WP settings
if( file_exists(get_template_directory().'/functions/basics.php') )
	include_once(get_template_directory().'/functions/basics.php');
	
//WP Custom Pointers
/*
if( file_exists(get_template_directory().'/functions/pointers.php') )
	include_once(get_template_directory().'/functions/pointers.php');
*/

//Load Javascript for themes
if( file_exists(get_template_directory().'/functions/load-javascript.php') )
	include_once(get_template_directory().'/functions/load-javascript.php');

//adds custom post types
if( file_exists(get_template_directory().'/functions/post_types.php') )
	include_once(get_template_directory().'/functions/post_types.php');

// Load Options Theme Framework
if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );
	require_once dirname( __FILE__ ) . '/inc/options-framework.php';
}

// Re-define meta box path and URL
define( 'RWMB_URL', trailingslashit( get_stylesheet_directory_uri() . '/functions/meta-box' ) );
define( 'RWMB_DIR', trailingslashit( get_stylesheet_directory() . '/functions/meta-box' ) );

// Include the meta box script
if( file_exists(get_template_directory().'/functions/meta-box/meta-box.php') )
	include_once(get_template_directory().'/functions/meta-box/meta-box.php');

// Include the meta box definition (the file where you define meta boxes, see `demo/demo.php`)
if( file_exists(get_template_directory().'/functions/meta-box/meta-box-usage.php') )
	include_once(get_template_directory().'/functions/meta-box/meta-box-usage.php');

// Load TGM Required Plugins Scripts
if( file_exists(get_template_directory().'/functions/class-tgm-plugin-activation.php') )
	require_once(get_template_directory().'/functions/class-tgm-plugin-activation.php');

// Twitter Widget Plugin ** Twitter API 1.1 breaks functionallity. Have to rework code before it will work again **
//if( file_exists(get_template_directory().'/functions/twitter-widget.php') )
//	include_once(get_template_directory().'/functions/twitter-widget.php');