<?php
/*
 * Basic functions for wordpress
 */


/*------------------------------
        Custom Admin Styles
-------------------------------*/

function mytheme_enqueue_admin_style() {

     $admin_handle = 'mytheme_admin_stylesheet';
     $admin_stylesheet = get_template_directory_uri() . '/css/admin.css';

     wp_enqueue_style( $admin_handle, $admin_stylesheet );
}

add_action('admin_print_styles', 'mytheme_enqueue_admin_style', 11 );
add_theme_support( 'automatic-feed-links' );

/*------------------------------
        Menu Support
-------------------------------*/

//Register Wordpress 3.0+ Menu
function bk_register_menus() {
    register_nav_menus(array(
        'primary-menu' => __('Primary Menu', 'easy_theme'),
    ));
}
add_action('init', 'bk_register_menus');


// add home page as option in menu
function bk_home_page_menu_args( $args ) {
    $args['show_home'] = true;
    return $args;
}
add_filter( 'wp_page_menu_args', 'bk_home_page_menu_args' );

/*------------------------------
    Custom Background Support
-------------------------------*/

add_custom_background();

add_editor_style();
if ( ! isset( $content_width ) ) $content_width = 600;
$GLOBALS['content_width'] = 600;


/*------------------------------
        Add Widgets
-------------------------------*/

function new_widgets_init() {
    register_sidebar( array(
        'name' => 'Sidebar',
        'id' => 'one',
        'description' => __( 'sidebar', 'easy_theme'),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => "</li>",
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ) );
    register_sidebar( array(
        'name' => 'Footer Area One',
        'id' => 'foot_one',
        'description' => __( 'footer area 1', 'easy_theme'),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => "</li>",
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ) );
    register_sidebar( array(
        'name' => 'Footer Area Two',
        'id' => 'foot_two',
        'description' => __( 'footer area 2', 'easy_theme'),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => "</li>",
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ) );
    register_sidebar( array(
        'name' => 'Footer Area Three',
        'id' => 'foot_three',
        'description' => __( 'footer area 3', 'easy_theme'),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => "</li>",
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ) );
}

add_action( 'init', 'new_widgets_init' );

/*-----------------------------------------
      Add Post Thumbnails Support
-----------------------------------------*/

if ( function_exists( 'add_theme_support' ) ) { // Added in 2.9
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 104, 104, true ); // Main Thumbnail
    add_image_size( 'thumbnail', 75, 75, true ); //Gallery Thumbnail
    add_image_size( 'portfolio-thumb', 200, 150, true); //Portfolio Menu Thumbnail
}

/*-----------------------------------------
       enable threaded comments
------------------------------------------*/

function bk_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
            case '' :
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <div id="comment-<?php comment_ID(); ?>">
        <div class="comment-author vcard">
            <?php echo get_avatar( $comment, 40 ); ?>
            <?php printf( __( '%s <span class="says">says:</span>', 'bk' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
        </div><!-- .comment-author .vcard -->
        <?php if ( $comment->comment_approved == '0' ) : ?>
            <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'bk' ); ?></em>
            <br />
        <?php endif; ?>

        <div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
            <?php
                /* translators: 1: date, 2: time */
                printf( __( '%1$s at %2$s', 'bk' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'bk' ), ' ' );
            ?>
        </div><!-- .comment-meta .commentmetadata -->

        <div class="comment-body"><?php comment_text(); ?></div>

        <div class="reply">
            <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
        </div><!-- .reply -->
    </div><!-- #comment-##  -->

	<?php
            break;
            case 'pingback'  :
            case 'trackback' :
	?>
	<li class="post pingback">
            <p><?php _e( 'Pingback:', 'bk' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'bk' ), ' ' ); ?></p>
	<?php
            break;
	endswitch;
}

/*-----------------------------------------------------------------------------------*/
/*	Filters that allow shortcodes in Text Widgets
/*-----------------------------------------------------------------------------------*/

add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');


/*------------------------------------------
       Remove header junk
------------------------------------------*/

remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);



/*------------------------------------------
       Sets custom excerpt length
------------------------------------------*/

function bk_custom_excerpt_length($length) {
    return 200;
}
add_filter('excerpt_length', 'bk_custom_excerpt_length');

function new_excerpt_more($more) {
    global $post;
    return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

/*------------------------------------------
       Sets the custom favicon
------------------------------------------*/

// add a favicon
function bk_blog_favicon() {
    echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('wpurl').'/favicon.ico" />';
}
add_action('wp_head', 'bk_blog_favicon');


// add a favicon for your admin
function bk_admin_favicon() {
    echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('stylesheet_directory').'/images/favicon.png" />';
}
add_action('admin_head', 'bk_admin_favicon');


/*------------------------------------------
  remove version info from head and feeds
------------------------------------------*/

function bk_complete_version_removal() {
    return '';
}
add_filter('the_generator', 'complete_version_removal');

?>
