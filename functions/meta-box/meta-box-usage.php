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
            'type' => 'textarea'
        ),
	),
);

$meta_boxes[] = array(
	'id' => 'contact',		// meta box id, unique per meta box
	'title' => 'Contact Details',	// meta box title
	'pages' => array('page'),	// post types, accept custom post types as well, default is array('post'); optional
	'context' => 'normal',		// where the meta box appear: normal (default), advanced, side; optional
	'priority' => 'high',		// order of meta box: high (default), low; optional

	'fields' => array(
        array(
            'name' => 'Street',
            'desc' => '221B Baker Street.',
            'id' => $prefix . 'street_contact',
            'type' => 'text'					// image upload
        ),
        array(
            'name' => 'City, State, Zip',
            'desc' => 'Marylebone, OR 97330',
            'id' => $prefix . 'city_contact',
            'type' => 'text'					// image upload
        ),
        array(
            'name' => 'Country',
            'desc' => 'U.S.A.',
            'id' => $prefix . 'country_contact',
            'type' => 'text'					// image upload
        ),
        array(
            'name' => 'Phone Number',
            'desc' => 'example: 503.443.3234',
            'id' => $prefix . 'phone_contact',
            'type' => 'text'
        ),
        array(
            'name' => 'email',
            'desc' => 'example: johnny.appleseed@gmail.com',
            'id' => $prefix . 'email_contact',
            'type' => 'text'
        ),
	),
	'only_on'    => array(
		//'id'       => array( 1, 2 ),
		// 'slug'  => array( 'news', 'blog' ),
		'template' => array( 'contact.php' ),
		//'parent'   => array( 10 )
	),
);


/********************* META BOX REGISTERING ***********************/

/**
 * Register meta boxes
 *
 * @return void
 */
function rw_register_meta_boxes()
{
	global $meta_boxes;

	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( class_exists( 'RW_Meta_Box' ) ) {
		foreach ( $meta_boxes as $meta_box ) {
			if ( isset( $meta_box['only_on'] ) && ! rw_maybe_include( $meta_box['only_on'] ) ) {
				continue;
			}

			new RW_Meta_Box( $meta_box );
		}
	}
}

add_action( 'admin_init', 'rw_register_meta_boxes' );

/**
 * Check if meta boxes is included
 *
 * @return bool
 */
function rw_maybe_include( $conditions ) {
	// Include in back-end only
	if ( ! defined( 'WP_ADMIN' ) || ! WP_ADMIN ) {
		return false;
	}

	// Always include for ajax
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return true;
	}

	if ( isset( $_GET['post'] ) ) {
		$post_id = $_GET['post'];
	}
	elseif ( isset( $_POST['post_ID'] ) ) {
		$post_id = $_POST['post_ID'];
	}
	else {
		$post_id = false;
	}

	$post_id = (int) $post_id;
	$post    = get_post( $post_id );

	foreach ( $conditions as $cond => $v ) {
		// Catch non-arrays too
		if ( ! is_array( $v ) ) {
			$v = array( $v );
		}

		switch ( $cond ) {
			case 'id':
				if ( in_array( $post_id, $v ) ) {
					return true;
				}
			break;
			case 'parent':
				$post_parent = $post->post_parent;
				if ( in_array( $post_parent, $v ) ) {
					return true;
				}
			break;
			case 'slug':
				$post_slug = $post->post_name;
				if ( in_array( $post_slug, $v ) ) {
					return true;
				}
			break;
			case 'template':
				$template = get_post_meta( $post_id, '_wp_page_template', true );
				if ( in_array( $template, $v ) ) {
					return true;
				}
			break;
		}
	}

	// If no condition matched
	return false;
}