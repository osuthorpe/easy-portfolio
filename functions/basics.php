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

function bk_admin_favicon() {
    echo '<link rel="shortcut icon" type="image/png" href="'.of_get_option('bk_favicon').'" />';
}
add_action('admin_head', 'bk_admin_favicon');

function bk_portfolio_icons() { ?>
    <style type="text/css" media="screen">
        #menu-posts-portfolio .wp-menu-image {
            background: url(<?php bloginfo('template_url') ?>/images/photo-album.png) no-repeat 7px -17px !important;
            background-size: 16px 40px;
        }
        #menu-posts-portfolio:hover .wp-menu-image, #menu-posts-portfolio.wp-has-current-submenu .wp-menu-image {
            background-position:7px 7px !important;
        }
        #icon-edit.icon32-posts-portfolio {
            background: url(<?php bloginfo('template_url') ?>/images/portfolio-32x32.png) no-repeat 7px 3px;
            background-size: 32px 32px;
        }
    </style>
<?php }

add_action( 'admin_head', 'bk_portfolio_icons' );

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

function bk_search_form( $form ) {

    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
    <div><label class="screen-reader-text" for="s">' . __('Search for:','bk-media') . '</label>
    <input type="text" placeholder="Search" value="' . get_search_query() . '" name="s" id="s" class="widget-search"/>
    <input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
    </div>
    </form>';

    return $form;
}

add_filter( 'get_search_form', 'bk_search_form' );

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
      Galleria Video Shortcode
-----------------------------------------*/

function bk_galleria_video($atts, $content) {
    return '<a href="'.$content.'"><span class="video">Watch the Video</span></a>';
}

function bk_register_shortcodes() {
   add_shortcode('video', 'bk_galleria_video');
}

add_action( 'init', 'bk_register_shortcodes');


/*-----------------------------------------
      Excerpt Settings
-----------------------------------------*/

function bk_wp_trim_excerpt($text) {
    $raw_excerpt = $text;
    if ( '' == $text ) {
        //Retrieve the post content.
        $text = get_the_content('');

        //Delete all shortcode tags from the content.
        $text = strip_shortcodes( $text );

        $text = apply_filters('the_content', $text);
        $text = str_replace(']]>', ']]&gt;', $text);

        $allowed_tags = '<p>,<a>,<em>,<strong>,<img>'; /*** MODIFY THIS. Add the allowed HTML tags separated by a comma.***/
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
add_filter('get_the_excerpt', 'bk_wp_trim_excerpt');

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

add_filter( 'post_thumbnail_html', 'bk_remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'bk_remove_thumbnail_dimensions', 10 );

function bk_remove_thumbnail_dimensions( $html ) {
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
  remove version info from head and feeds
------------------------------------------*/

function bk_complete_version_removal() {
    return '';
}
add_filter('the_generator', 'bk_complete_version_removal');

/*------------------------------------------
  Redirect CSS3PIE call
------------------------------------------*/

function bk_css_pie ( $vars ) {
    $vars[] = 'pie';
    return $vars;
}

add_filter( 'query_vars' , 'bk_css_pie'); //WordPress will now interpret the PIE variable in the url

function bk_load_pie() {
    if ( get_query_var( 'pie' ) == "true" ) {
        header( 'Content-type: text/x-component' );
        wp_redirect( get_bloginfo('template_url').'/PIE.htc' ); // adjust the url to where PIE.htc is located, in this example we are fetching in the themes includes directory
        // Stop WordPress entirely since we just want PIE.htc
        exit;
    }
}

add_action( 'template_redirect', 'bk_load_pie' );

/*------------------------------------------
  User Styles for Theme
------------------------------------------*/

function bk_user_styles() {
    $background = of_get_option('bk_main_background');
    $galleria_background = of_get_option('bk_portfolio_background');
    $header = of_get_option('bk_header_type');
    $title = of_get_option('bk_title_type');
    $body = of_get_option('bk_body_type');
    $nav = of_get_option('bk_menu_type');
    ?>
    <style type="text/css">
        body {
            <?php if($background['image']) {
                echo "background-image: url(" . $background['image'] . ");";
            } else {
                echo "background-color:" . $background['color'] . ";";
            } ?>
        }
        .galleria-container {
            <?php if($background['image']) {
                echo "background-image: url(" . $galleria_background['image'] . ");";
            } else {
                echo "background-color:" . $galleria_background['color'] . ";";
            } ?>
        }
        #header a {
            font-size: <?php echo $header['size']; ?>;
            font-family: <?php echo "'".$header['face']."'"; ?>;
            font-style: <?php echo $header['style']; ?>;
            color: <?php echo $header['color']; ?>;
        }
        #navigation li a {
            font-size: <?php echo $nav['size']; ?>;
            font-family: <?php echo "'".$nav['face']."'"; ?>;
            font-style: <?php echo $nav['style']; ?>;
            color: <?php echo $nav['color']; ?>;
        }
        h1, h2, h3, h4, h5, h6 {
	        font-family: <?php echo "'".$header['face']."'"; ?>;
            color: <?php echo $title['color']; ?>;
        }
        #blog-content h2 {
	        font-size: <?php echo $title['size']; ?>;
            font-family: <?php echo "'".$title['face']."'"; ?>;
            font-style: <?php echo $title['style']; ?>;
            color: <?php echo $title['color']; ?>;
        }
        body {
	        font-size: <?php echo $body['size']; ?>;
            font-family: <?php echo "'".$body['face']."'"; ?>;
            font-style: <?php echo $body['style']; ?>;
            color: <?php echo $body['color']; ?>;
        }
        a,
        #portfolio-content .portfolio-link h4 a:hover,
        #navigation a:hover {
            color: <?php echo of_get_option('bk_link_color'); ?>;
        }
        a:hover,
        #portfolio-content .portfolio-link h4 a {
            color: <?php echo of_get_option('bk_link_hover_color'); ?>;
        }
        .subheader,
        p.lead,
        blockquote,
        blockquote p,
        blockquote cite,
        blockquote cite a,
        blockquote cite a:visited,
        blockquote cite a:visited,
        hr,
        .wp-caption {
             color: <?php echo of_get_option('bk_secondary_color'); ?>;
        }
        .gallery-caption,
        .sticky,
        {
	        background: <?php echo of_get_option('bk_accent_color'); ?>;
        }
        #header,
        #blog-content .single-content,
        .contact-address h5,
        .widgettitle {
			border-bottom-color: <?php echo of_get_option('bk_accent_color'); ?>;
		}
        blockquote {
            border-left-color: <?php echo of_get_option('bk_accent_color'); ?>;
        }
        input#searchsubmit,
        #social .social-icon {
            background-color: <?php echo of_get_option('bk_icon_color'); ?>;
        }
        input#searchsubmit:hover,
        #social .social-icon:hover {
            background-color: <?php echo of_get_option('bk_icon_hover_color'); ?>;
        }
    </style>
<?php }
add_action('wp_head', 'bk_user_styles');


/*------------------------------------------
  TGM Plugin Activation Scripts
------------------------------------------*/

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
function bk_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        // This is an example of how to include a plugin from the WordPress Plugin Repository
        array(
            'name'      => 'Wordpress GZIP Compression',
            'slug'      => 'wordpress-gzip-compression',
            'required'  => false,
        ),
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

add_action( 'tgmpa_register', 'bk_register_required_plugins' );

?>
