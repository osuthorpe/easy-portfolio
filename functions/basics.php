<?php
/*
 * Basic functions for wordpress
 */


/*------------------------------
        Custom Admin Styles
-------------------------------*/

function bk_enqueue_admin_style() {

     $admin_handle = 'bk_admin_stylesheet';
     $admin_stylesheet = get_template_directory_uri() . '/css/admin.css';

     wp_enqueue_style( $admin_handle, $admin_stylesheet );
}

add_action('admin_print_styles', 'bk_enqueue_admin_style', 11 );

add_theme_support( 'automatic-feed-links' );

/*------------------------------
        Menu Support
-------------------------------*/

//Register Wordpress 3.0+ Menu
function bk_register_menus() {
    register_nav_menus(array(
        'primary-menu' => __('Primary Menu', 'bk-media'),
    ));
}
add_action('init', 'bk_register_menus');


// add home page as option in menu
function bk_home_page_menu_args( $args ) {
    $args['show_home'] = true;
    return $args;
}
add_filter( 'wp_page_menu_args', 'bk_home_page_menu_args' );

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
        'description' => __( 'sidebar','bk-media'),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => "</li>",
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ) );
}

add_action( 'init', 'new_widgets_init' );

function my_search_form( $form ) {

    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
    <div><label class="screen-reader-text" for="s">' . __('Search for:','bk-media') . '</label>
    <input type="text" placeholder="Search" value="' . get_search_query() . '" name="s" id="s" class="widget-search"/>
    <input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
    </div>
    </form>';

    return $form;
}

add_filter( 'get_search_form', 'my_search_form' );

/*-----------------------------------------
      Add Post Thumbnails Support
-----------------------------------------*/

if ( function_exists( 'add_theme_support' ) ) { // Added in 2.9
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 104, 104, true ); // Main Thumbnail
    add_image_size( 'thumbnail', 75, 75, true ); //Gallery Thumbnail
    add_image_size( 'portfolio-thumb', 200, 200, true); //Portfolio Menu Thumbnail
    add_image_size('blog', 620, 9999, false); //Blog page image
    add_image_size('portfolil-thumb-narrow', 460, 100, true);
}

/*-----------------------------------------
      Excerpt Settings
-----------------------------------------*/

function custom_wp_trim_excerpt($text) {
    $raw_excerpt = $text;
    if ( '' == $text ) {
        //Retrieve the post content.
        $text = get_the_content('');

        //Delete all shortcode tags from the content.
        $text = strip_shortcodes( $text );

        $text = apply_filters('the_content', $text);
        $text = str_replace(']]>', ']]&gt;', $text);

        $allowed_tags = '<p>,<a>,<em>,<strong>'; /*** MODIFY THIS. Add the allowed HTML tags separated by a comma.***/
        $text = strip_tags($text, $allowed_tags);

        $excerpt_word_count = 200; /*** MODIFY THIS. change the excerpt word count to any integer you like.***/
        $excerpt_length = apply_filters('excerpt_length', $excerpt_word_count);

        $excerpt_end = '[...]'; /*** MODIFY THIS. change the excerpt endind to something else.***/
        $excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end);

        $words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
        if ( count($words) > $excerpt_length ) {
            array_pop($words);
            $text = implode(' ', $words);
            $text = $text . $excerpt_more;
        } else {
            $text = implode(' ', $words);
        }
    }
    return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'custom_wp_trim_excerpt');

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


/*-----------------------------------------------------------------------------------*/
/*  RESPONSIVE IMAGE FUNCTIONS
/*-----------------------------------------------------------------------------------*/

add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );

function remove_thumbnail_dimensions( $html ) {
        $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
        return $html;
}

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


/*------------------------------------------
  remove version info from head and feeds
------------------------------------------*/

function bk_complete_version_removal() {
    return '';
}
add_filter('the_generator', 'complete_version_removal');


/*------------------------------------------
  User Styles for Theme
------------------------------------------*/

function bk_user_styles() {
    $background = of_get_option('bk_main_background');
    ?>
    <style type="text/css">
        body {
            <?php if($background['image']) {
                echo "background-image: url(" . $background['image'] . ");";
            } else {
                echo "background-color:" . $background['color'] . ";";
            } ?>
        }
    </style>
<?php }
add_action('wp_head', 'bk_user_styles');


/*------------------------------------------
  TGM Plugin Activation Scripts
------------------------------------------*/

add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function my_theme_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        // This is an example of how to include a plugin from the WordPress Plugin Repository
        array(
            'name'      => 'W3 Total Cache',
            'slug'      => 'w3-total-cache',
            'required'  => false,
        ),
        array(
            'name'      => 'Wordpress Firewall 2',
            'slug'      => 'wordpress-firewall-2',
            'required'  => false,
        ),

    );

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'domain'            => 'bk-media',          // Text domain - likely want to be the same as your theme.
        'default_path'      => '',                          // Default absolute path to pre-packaged plugins
        'parent_menu_slug'  => 'themes.php',                // Default parent menu slug
        'parent_url_slug'   => 'themes.php',                // Default parent URL slug
        'menu'              => 'install-required-plugins',  // Menu slug
        'has_notices'       => true,                        // Show admin notices or not
        'is_automatic'      => false,                       // Automatically activate plugins after installation or not
        'message'           => '',                          // Message to output right before the plugins table
        'strings'           => array(
            'page_title'                                => __( 'Install Required Plugins', 'bk-media' ),
            'menu_title'                                => __( 'Install Plugins', 'bk-media' ),
            'installing'                                => __( 'Installing Plugin: %s', 'bk-media' ), // %1$s = plugin name
            'oops'                                      => __( 'Something went wrong with the plugin API.', 'bk-media' ),
            'notice_can_install_required'               => _n_noop( 'Easy Portfolio theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_install_recommended'            => _n_noop( 'Easy Portfolio theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_install'                     => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
            'notice_can_activate_required'              => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_activate_recommended'           => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_activate'                    => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
            'notice_ask_to_update'                      => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_update'                      => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
            'install_link'                              => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                             => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
            'return'                                    => __( 'Return to Required Plugins Installer', 'bk-media' ),
            'plugin_activated'                          => __( 'Plugin activated successfully.', 'bk-media' ),
            'complete'                                  => __( 'All plugins installed and activated successfully. %s', 'bk-media' ), // %1$s = dashboard link
            'nag_type'                                  => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
        )
    );

    tgmpa( $plugins, $config );

}

?>
