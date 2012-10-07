<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	//Icon Types
	$icon_array = array(
		'light' => __('light', 'options_framework_theme'),
		'dark' => __('dark', 'options_framework_theme')
	);

	// Multicheck Array
	$multicheck_array = array(
		'one' => __('French Toast', 'options_framework_theme'),
		'two' => __('Pancake', 'options_framework_theme'),
		'three' => __('Omelette', 'options_framework_theme'),
		'four' => __('Crepe', 'options_framework_theme'),
		'five' => __('Waffle', 'options_framework_theme')
	);

	//boolean options
	$boolean_array = array(
		'true' => __('Yes', 'options_framework_theme'),
		'false' => __('No', 'options_framework_theme')
	);

	//Trasition Options
	$transition_array = array(
		'fade' => __('fade', 'options_framework_theme'),
		'flash' => __('flash', 'options_framework_theme'),
		'pulse' => __('pulse', 'options_framework_theme'),
		'slide' => __('slide', 'options_framework_theme'),
		'fadeslide' => __('fadeslide', 'options_framework_theme')
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '#ffffff',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$header_typography_defaults = array(
		'size' => '30px',
		'face' => 'georgia',
		'style' => 'normal',
		'color' => '#222222' );

	$title_typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#222222' );

	$menu_typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'normal',
		'color' => '#222222' );

	$body_typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'normal',
		'color' => '#222222' );

	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// Pull all the portfolios into an array
	$options_portfolios = array();
	$args = array(
		'post_type' => 'portfolio',
		'orderby'   => 'title',
    	'order'     => 'ASC',);
	$options_portfolio_obj = get_posts($args);
	$options_portfolios[''] = 'Select a portfolio:';
	foreach ($options_portfolio_obj as $portfolio) {
		$options_portfolios[$portfolio->ID] = $portfolio->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';

	//Default site title from wordpress title
	$site_title = get_bloginfo('name');

	//Default copyright notice
	$copyright = '© ' . $site_title . ', All rights reserved';

	$options = array();

	/*
	 * General Options Tab
	 */
	$options[] = array(
		'name' => __('General', 'options_framework_theme'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Site Title', 'options_framework_theme'),
		'desc' => __('Set the Title of your site', 'options_framework_theme'),
		'id' => 'bk_site_title',
		'std' => $site_title,
		'type' => 'text');

	$options[] = array(
		'name' => __('Site Logo', 'options_framework_theme'),
		'desc' => __('Upload your logo to display in the header [Width: 400px, Height: 50px].', 'options_framework_theme'),
		'id' => 'bk_logo',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Favicon', 'options_framework_theme'),
		'desc' => __('Upload a favicon to display next to your url in the address bar *Required Dimentions* (Width: 16px, Height: 16px).', 'options_framework_theme'),
		'id' => 'bk_favicon',
		'std' => 'http://dev.alexthorpe.com/wp-content/uploads/2012/10/picture.png',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Mobile App Icon', 'options_framework_theme'),
		'desc' => __('Upload an icon for mobile home screens *Required Dimentions* (Width: 144px, Height: 144px).', 'options_framework_theme'),
		'id' => 'bk_mobile_icon',
		'std' => 'http://dev.alexthorpe.com/wp-content/uploads/2012/10/web-app-icon.png',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Front Page Portfolio', 'options_framework_theme'),
		'desc' => __('Select your portfolio for the home page', 'options_framework_theme'),
		'id' => 'bk_front_page',
		'type' => 'select',
		'options' => $options_portfolios);

	$options[] = array(
		'name' => __('Copyright', 'options_framework_theme'),
		'desc' => __('Set the copyright you want at the bottom of the site', 'options_framework_theme'),
		'id' => 'bk_copyright',
		'std' => $copyright,
		'type' => 'text');

	$options[] = array(
		'name' => __('Google Tracking Code', 'options_framework_theme'),
		'desc' => __('Copy and paste your google tracking code here, should start with UA-.', 'options_framework_theme'),
		'id' => 'bk_google_code',
		'std' => '',
		'type' => 'text');

	/*
	 *	Styles & Colors
	 */

	$options[] = array(
		'name' => __('Styles & Colors', 'options_framework_theme'),
		'type' => 'heading');

	$options[] = array(
		'name' =>  __('Main Background', 'options_framework_theme'),
		'desc' => __('Change the background CSS.', 'options_framework_theme'),
		'id' => 'bk_main_background',
		'std' => $background_defaults,
		'type' => 'background');

	$options[] = array(
		'name' => __('Social Media Icons Color', 'options_framework_theme'),
		'desc' => __('Color for the social media icon backgrounds.', 'options_framework_theme'),
		'id' => 'bk_social_color',
		'std' => '#222222',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Social Media Icons Hover Color', 'options_framework_theme'),
		'desc' => __('Color for hovering over the social media icons.', 'options_framework_theme'),
		'id' => 'bk_social_hover_color',
		'std' => '#444444',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Accent Color', 'options_framework_theme'),
		'desc' => __('Color for the accents in the design.', 'options_framework_theme'),
		'id' => 'bk_accent_color',
		'std' => '#e9e9e9',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Link Color', 'options_framework_theme'),
		'desc' => __('Default color for any links in the theme.', 'options_framework_theme'),
		'id' => 'bk_link_color',
		'std' => '#0099cc',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Link Hover Color', 'options_framework_theme'),
		'desc' => __('Default color for any time link is hovered over.', 'options_framework_theme'),
		'id' => 'bk_link_hover_color',
		'std' => '#444444',
		'type' => 'color' );

	$options[] = array( 'name' => __('Header Typography', 'options_framework_theme'),
		'desc' => __('Type settings for the header of the site.', 'options_framework_theme'),
		'id' => "bk_header_type",
		'std' => $header_typography_defaults,
		'type' => 'typography' );

	$options[] = array( 'name' => __('Title Typography', 'options_framework_theme'),
		'desc' => __('Type settings for the title fields on the site.', 'options_framework_theme'),
		'id' => "bk_title_type",
		'std' => $title_typography_defaults,
		'type' => 'typography' );

	$options[] = array( 'name' => __('Menu Typography', 'options_framework_theme'),
		'desc' => __('Type settings for the main menu of the site.', 'options_framework_theme'),
		'id' => "bk_menu_type",
		'std' => $menu_typography_defaults,
		'type' => 'typography' );

	$options[] = array( 'name' => __('Body Typography', 'options_framework_theme'),
		'desc' => __('Type settings for the body text on the site.', 'options_framework_theme'),
		'id' => "bk_body_type",
		'std' => $body_typography_defaults,
		'type' => 'typography' );

	/*
	 *	Portfolios
	 */

	$options[] = array(
		'name' => __('Portfolios', 'options_framework_theme'),
		'type' => 'heading' );

	$options[] = array(
		'name' =>  __('Portfolio Background', 'options_framework_theme'),
		'desc' => __('Change the background for the Portfolio (if blank will be same as main background).', 'options_framework_theme'),
		'id' => 'bk_portfolio_background',
		'std' => $background_defaults,
		'type' => 'background');

	$options[] = array(
		'name' => __('Crop Images', 'options_framework_theme'),
		'desc' => __('If yes then all images are cropped to fit the portfolio frame', 'options_framework_theme'),
		'id' => 'bk_standard_crop',
		'std' => 'true',
		'type' => 'radio',
		'options' => $boolean_array,);

	$options[] = array(
		'name' => __('Autoplay Slideshow', 'options_framework_theme'),
		'desc' => __('Should the slideshow start automatically when the gallery is loaded', 'options_framework_theme'),
		'id' => 'bk_standard_play',
		'std' => 'false',
		'type' => 'radio',
		'options' => $boolean_array);

	$options[] = array(
		'name' => __('Transition', 'options_framework_theme'),
		'desc' => __('Set the transition effect', 'options_framework_theme'),
		'id' => 'bk_standard_transition',
		'std' => 'fade',
		'type' => 'select',
		'class' => 'mini',
		'options' => $transition_array);

	$options[] = array(
		'name' => __('Speed', 'options_framework_theme'),
		'desc' => __('How long should each image apear in the slideshow (in Milliseconds)', 'options_framework_theme'),
		'id' => 'bk_standard_speed',
		'std' => '2000',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('Show Thumbnails', 'options_framework_theme'),
		'desc' => __('If yes then thumbnails will be visible', 'options_framework_theme'),
		'id' => 'bk_standard_thumbnails',
		'std' => 'false',
		'type' => 'radio',
		'options' => $boolean_array);

	$options[] = array(
		'name' => __('Fullscreen Crop Images', 'options_framework_theme'),
		'desc' => __('If yes then all images are cropped to fill the entire screen in fullscreen mode', 'options_framework_theme'),
		'id' => 'bk_fullscreen_crop',
		'std' => 'false',
		'type' => 'radio',
		'options' => $boolean_array,);

	$options[] = array(
		'name' => __('Fullscreen Transition', 'options_framework_theme'),
		'desc' => __('Set the transition effect for fullscreen mode', 'options_framework_theme'),
		'id' => 'bk_fullscreen_transition',
		'std' => 'slide',
		'type' => 'select',
		'class' => 'mini',
		'options' => $transition_array);

	/*
	 *	Social Media
	 */
	$options[] = array(
		'name' => __('Social Media', 'options_framework_theme'),
		'type' => 'heading' );

	$options[] = array(
		'name' => __('Twitter', 'options_framework_theme'),
		'desc' => __('Add your twitter name', 'options_framework_theme'),
		'id' => 'bk_twitter',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Facebook', 'options_framework_theme'),
		'desc' => __('Add your twitter url', 'options_framework_theme'),
		'id' => 'bk_facebook',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Flickr', 'options_framework_theme'),
		'desc' => __('Add your flickr url', 'options_framework_theme'),
		'id' => 'bk_flickr',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('500px', 'options_framework_theme'),
		'desc' => __('Add your 500px url', 'options_framework_theme'),
		'id' => 'bk_500px',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Youtube', 'options_framework_theme'),
		'desc' => __('Add your youtube url', 'options_framework_theme'),
		'id' => 'bk_youtube',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Vimeo', 'options_framework_theme'),
		'desc' => __('Add your Vimeo url', 'options_framework_theme'),
		'id' => 'bk_vimeo',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Dribble', 'options_framework_theme'),
		'desc' => __('Add your dribble url', 'options_framework_theme'),
		'id' => 'bk_dribble',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Linkedin', 'options_framework_theme'),
		'desc' => __('Add your Linkedin url', 'options_framework_theme'),
		'id' => 'bk_linkedin',
		'std' => '',
		'type' => 'text');
	/*
	 *	Advanced
	 */
	$options[] = array(
		'name' => __('Advanced', 'options_framework_theme'),
		'type' => 'heading' );

	$options[] = array(
		'name' => __('Custom CSS', 'options_framework_theme'),
		'desc' => __('Advanced users only. Enter your own css to overide any defaults in the theme.', 'options_framework_theme'),
		'id' => 'bk_advanced_css',
		'std' => '',
		'type' => 'textarea');

	return $options;
}

/*
 * This is an example of how to add custom scripts to the options panel.
 * This example shows/hides an option when a checkbox is clicked.
 */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function($) {

	$('#example_showhidden').click(function() {
  		$('#section-example_text_hidden').fadeToggle(400);
	});

	if ($('#example_showhidden:checked').val() !== undefined) {
		$('#section-example_text_hidden').show();
	}

});
</script>

<?php
}