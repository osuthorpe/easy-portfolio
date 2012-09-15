<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/docs/define-meta-boxes
 */

/********************* META BOX DEFINITIONS ***********************/

/**
 * Prefix of meta keys (optional)
 * Use underscore (_) at the beginning to make keys hidden
 * Alt.: You also can make prefix empty to disable it
 */
// Better has an underscore as last sign
$prefix = 'bk_';

global $meta_boxes;

$meta_boxes = array();

// first meta box
$meta_boxes[] = array(
	'id' => 'portfolio_images',		// meta box id, unique per meta box
	'title' => 'Gallery Images',	// meta box title
	'pages' => array('portfolio','Gallery'),	// post types, accept custom post types as well, default is array('post'); optional
	'context' => 'normal',		// where the meta box appear: normal (default), advanced, side; optional
	'priority' => 'high',		// order of meta box: high (default), low; optional

	'fields' => array(
        array(
            'name' => 'Portfolio Images',
            'desc' => 'upload your portfolio images',
            'id' => $prefix . 'photo',
            'type' => 'plupload_image'					// image upload
        ),
        array(
            'name' => 'Portfolio Description',
            'desc' => 'upload your portfolio images',
            'id' => $prefix . 'portfolio_desc',
            'type' => 'textarea'					// image upload
        ), // list of meta fields
		array(
			'name' => 'front-page',
			'title' => 'Front Page',
			'desc' => 'make this portfolio the first page portfolio?',
			'id' => $prefix . 'is_front_page',
			'type' => 'radio',
			'options' => array(
				'yes' => 'yes',
				'no' => 'no'),
			'std' => 'no',
		),
	),
);
		

/********************* META BOX REGISTERING ***********************/

/**
 * Register meta boxes
 *
 * @return void
 */
function bk_register_meta_boxes()
{
	global $meta_boxes;

	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( class_exists( 'RW_Meta_Box' ) )
	{
		foreach ( $meta_boxes as $meta_box )
		{
			new RW_Meta_Box( $meta_box );
		}
	}
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'bk_register_meta_boxes' );