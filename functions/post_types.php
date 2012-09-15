<?php
/* 
 * Custom Post types and taxonomies
 */

$cpts = array(
	'Portfolio' => array( // unique value
        'post_type' => 'Portfolio', // post type name
        'supports' => array( 'title', 'post_format', 'thumbnail' ), // supports title, editor, author, comments etc. (optional, default: title, editor)
        'singular' => 'Portfolio', // post type singular label
        'plural' => 'Portfolios', // post type plural label
        'item_singular' => 'Portfolio', // post type singular item label (optional, if none is supplied, uses singular)
        'item_plural' => 'Portfolios', // post type plural item label (optional, if none is supplied, uses plural)
        'menu_position' => '20', // post type position in backend menu (optional, default: 20)
        'slug' => 'Portfolio', // post type slug
    ),
);

$ctaxs = array(
    'tx' => array(
        'taxonomy' => 'type', // taxonomy name
        'singular' => 'type', // taxonomy singular label
        'plural' => 'types', // taxonomy plural label
        'hierarchical' => 'true', // taxonomy hierarchical
        'slug' => 'type', // taxonomy slug
        'pts' => array('Gear') // post types that are supported by the taxonomy
    )
);



/*-----------------------------------------
      Custom Post Types
-----------------------------------------*/

if(is_array($cpts)) {
add_action('init', 'wpreso_custom_posttypes');
}
function wpreso_custom_posttypes() {
	global $cpts;
	foreach($cpts as $cpt){
		$item_singular_label = ((isset($cpt['item_singular']) && !empty($cpt['item_singular']))? $cpt['item_singular'] : $cpt['singular'] );
		$item_plural_label = ((isset($cpt['item_plural']) && !empty($cpt['item_plural']))? $cpt['item_plural'] : $cpt['plural'] );
		$menu_position = ((isset($cpt['position']) && !empty($cpt['position']))? $cpt['position'] :  20);
		$labels = array(
			'name' => __($cpt['plural'], 'wpreso'),
			'singular_name' => __($cpt['singular'], 'wpreso'),
			'add_new' => __('Add New', 'wpreso'),
			'add_new_item' => __('Add New '.$item_singular_label, 'wpreso'),
			'edit_item' => __('Edit '.$item_singular_label, 'wpreso'),
			'new_item' => __('New '.$item_singular_label, 'wpreso'),
			'view_item' => __('View '.$item_singular_label, 'wpreso'),
			'search_items' => __('Search '.$item_plural_label, 'wpreso'),
			'not_found' =>  __('No '.$item_plural_label.' Found', 'wpreso'),
			'not_found_in_trash' => __('No '.$item_plural_label.' found in Trash', 'wpreso'),
			'parent_item_colon' => ''
		);
		$supports = ((isset($cpt['supports']) && !empty($cpt['supports']) && is_array($cpt['supports']))? $cpt['supports'] : array( 'title', 'editor') );
		$args = array(
			'label' => __($cpt['singular'], 'wpreso'),
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'map_meta_cap' => true,
			'_builtin' => false,
			'rewrite' => array('slug' => $cpt['slug']),
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => $menu_position,
			'supports' => $supports
		);
		register_post_type($cpt['post_type'],$args);
		flush_rewrite_rules();

	}
	add_filter('post_updated_messages', 'wpreso_posttype_updated_messages');
	function wpreso_posttype_updated_messages( $messages ) {
		global $cpts;
		foreach($cpts as $cpt){
			$messages[$cpt['post_type']] = array(
				0 => '', // Unused. Messages start at index 1.
				1 => sprintf( __($cpt['singular'].' Updated. <a href="%s">View '.$cpt['singular'].'</a>', 'wpreso'), esc_url( get_permalink($post_ID) ) ),
				2 => __('Custom Field Updated.', 'wpreso'),
				3 => __('Custom Field Deleted.', 'wpreso'),
				4 => __($cpt['singular'].' Updated.', 'wpreso'),
				/* translators: %s: date and time of the revision */
				5 => isset($_GET['revision']) ? sprintf( __($cpt['singular'].' restored to revision from %s', 'wpreso'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				6 => sprintf( __($cpt['singular'].' Published. <a href="%s">View '.$cpt['singular'].'</a>', 'wpreso'), esc_url( get_permalink($post_ID) ) ),
				7 => __($cpt['singular'].' Saved.', 'wpreso'),
				8 => sprintf( __($cpt['singular'].' Submitted. <a target="_blank" href="%s">Preview '.$cpt['singular'].'</a>', 'wpreso'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
				9 => sprintf( __($cpt['singular'].' scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview '.$cpt['singular'].'</a>', 'wpreso'),
				  // translators: Publish box date format, see http://php.net/date
				  date_i18n( __( 'd/m-Y @ H:i', 'wpreso'), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
				10 => sprintf( __($cpt['singular'].' Draft Updated. <a target="_blank" href="%s">Preview '.$cpt['singular'].'</a>', 'wpreso'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
			);
			return $messages;
		}
	}
}


/*-----------------------------------------
      Custom Taxonomies
-----------------------------------------*/

if(is_array($ctaxs)){
add_action('init', 'wpreso_custom_taxonomies');
}
function wpreso_custom_taxonomies(){
	global $ctaxs;
	foreach($ctaxs as $ct){
		// Add new taxonomy, make it hierarchical (like categories)
		$taxlabels = array(
			'name' => __( $ct['plural'], 'wpreso' ),
			'singular_name' => __( $ct['singular'], 'wpreso'),
			'search_items' =>  __( 'Search '.$ct['plural'], 'wpreso'),
			'all_items' => __( 'All '.$ct['plural'], 'wpreso'),
			'parent_item' => __( 'Parent '.$ct['singular'], 'wpreso'),
			'parent_item_colon' => __( 'Parent '.$ct['singular'].':', 'wpreso'),
			'edit_item' => __( 'Edit '.$ct['singular'], 'wpreso'),
			'update_item' => __( 'Update '.$ct['singular'], 'wpreso'),
			'add_new_item' => __( 'Add New '.$ct['singular'], 'wpreso'),
			'new_item_name' => __( 'New '.$ct['singular'].' name', 'wpreso'),
		);

		register_taxonomy($ct['taxonomy'],$ct['pts'], array(
			'hierarchical' => $ct['hierarchical'],
			'labels' => $taxlabels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => $ct['slug'] ),
		));
	}
}



/*-----------------------------------------
      Custom Post type columns
-----------------------------------------*/

add_filter('manage_edit-portfolio_columns', 'maak_portfolio_columns');
function maak_portfolio_columns($columns) {
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
    	"title" => "Portfolio Title",
    	"description" => "Description",
		'images' => 'Images',
	);
	
    return $columns;
}
add_action('manage_posts_custom_column',  'show_portfolio_columns');
function show_portfolio_columns($name) {
 $args = array(
   'post_type' => 'attachment',
   'post_parent' => $post->ID
  );
    global $post;
    switch ($name) {
    	case 'description':
    		$meta = get_post_meta(get_the_ID(), 'bk_portfolio_desc', true);
			echo $meta;
    		break;
        case 'images':
		  	global $wpdb, $post;
                    
            $meta = get_post_meta( get_the_ID(  ), 'bk_photo', false );
            if ( !is_array( $meta ) )
                $meta = ( array ) $meta;
            
            if ( !empty( $meta ) ) {
                $meta = implode( ',', $meta );
                $images = $wpdb->get_col( "
                    SELECT ID FROM $wpdb->posts
                    WHERE post_type = 'attachment'
                    AND ID IN ( $meta )
                    ORDER BY menu_order ASC
                " );
                foreach ( $images as $att ) {
                    $src = wp_get_attachment_image_src( $att, 'thumbnail' );
                    $src = $src[0];
                    $image_meta = get_post($att);
                    $title= $image_meta->post_title;
                    $desc= $image_meta->post_content;
                    $caption= $image_meta->post_excerpt;
                    $alt= get_post_meta($att, '_wp_attachment_image_alt', true);
            
                    // Show image
                    echo "<img style='margin:5px;' src='{$src}' />";
                }
            }		
    }
}
?>
