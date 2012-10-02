<?php
/*
 * Custom Post types and taxonomies
 */

add_action( 'init', 'create_my_post_types' );

function create_my_post_types() {
	register_post_type( 'portfolio',
		array(
			'labels' => array(
				'name' => __( 'Portfolios','bk-media' ),
				'singular_name' => __( 'Portfolio','bk-media' ),
				'add_new' => __( 'Add New','bk-media' ),
				'add_new_item' => __( 'Add New Portfolio','bk-media' ),
				'edit' => __( 'Edit','bk-media' ),
				'edit_item' => __( 'Edit Portfolio','bk-media' ),
				'new_item' => __( 'New Portfolio','bk-media' ),
				'view' => __( 'View Portfolio','bk-media' ),
				'view_item' => __( 'View Portfolio','bk-media' ),
				'search_items' => __( 'Search Portfolios','bk-media' ),
				'not_found' => __( 'No Portfolios Found','bk-media' ),
				'not_found_in_trash' => __( 'No portfolios found in Trash','bk-media' )
			),
			'public' => true,
			'supports' => array( 'title', 'thumbnail' ),
		)
	);
}

/*-----------------------------------------
      Custom Post type columns
-----------------------------------------*/

add_filter('manage_edit-portfolio_columns', 'maak_portfolio_columns');
function maak_portfolio_columns($columns) {
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
    	"title" => "Portfolio Title",
    	"portfolio-description" => "Description",
		'portfolio-images' => 'Images',
	);

    return $columns;
}

add_action('manage_posts_custom_column',  'show_portfolio_columns');
function show_portfolio_columns($name) {
 $args = array(
   'post_type' => 'attachment'
  );
    global $post;
    switch ($name) {
    	case 'portfolio-description':
    		$meta = get_post_meta(get_the_ID(), 'bk_portfolio_desc', true);
			echo $meta;
    		break;
        case 'portfolio-images':
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
