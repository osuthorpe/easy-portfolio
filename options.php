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
		'name' => __('Mobile App Icon', 'options_framework_theme'),
		'desc' => __('Upload an icon for mobile home screens [Width: 57px, Height: 57px].', 'options_framework_theme'),
		'id' => 'bk_mobile_icon',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Mobile App Icon HD', 'options_framework_theme'),
		'desc' => __('Upload a larger icon for tablets and high resolution devices [Width: 104px, Height: 104px].', 'options_framework_theme'),
		'id' => 'bk_mobile_icon_hd',
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
		'desc' => __('Copy and paste your google tracking code here, should start with XA-.', 'options_framework_theme'),
		'id' => 'bk_google_code',
		'std' => '',
		'type' => 'textarea');

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
		'name' => __('Icon Type', 'options_framework_theme'),
		'desc' => __('Select dark for a light background, light for a darker background.', 'options_framework_theme'),
		'id' => 'bk_icon_type',
		'std' => 'dark',
		'type' => 'select',
		'class' => 'mini',
		'options' => $icon_array);

	$options[] = array(
		'name' => __('Accent Color', 'options_framework_theme'),
		'desc' => __('Color for the lines in the design.', 'options_framework_theme'),
		'id' => 'bk_accent_color',
		'std' => '#222222',
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

	$options[] = array(
		'name' => __('Text Editor', 'options_framework_theme'),
		'type' => 'heading' );

	/**
	 * For $settings options see:
	 * http://codex.wordpress.org/Function_Reference/wp_editor
	 *
	 * 'media_buttons' are not supported as there is no post to attach items to
	 * 'textarea_name' is set by the 'id' you choose
	 */

	$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);

	$options[] = array(
		'name' => __('Custom Typography', 'options_framework_theme'),
		'desc' => __('Custom typography options.', 'options_framework_theme'),
		'id' => "custom_typography",
		'std' => $typography_defaults,
		'type' => 'typography',
		'options' => $typography_options );

	$options[] = array(
		'name' => __('Default Text Editor', 'options_framework_theme'),
		'desc' => sprintf( __( 'You can also pass settings to the editor.  Read more about wp_editor in <a href="%1$s" target="_blank">the WordPress codex</a>', 'options_framework_theme' ), 'http://codex.wordpress.org/Function_Reference/wp_editor' ),
		'id' => 'example_editor',
		'type' => 'editor',
		'settings' => $wp_editor_settings );

	$options[] = array(
		'name' => __('Input Text Mini', 'options_framework_theme'),
		'desc' => __('A mini text input field.', 'options_framework_theme'),
		'id' => 'example_text_mini',
		'std' => 'Default',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('Input Text', 'options_framework_theme'),
		'desc' => __('A text input field.', 'options_framework_theme'),
		'id' => 'example_text',
		'std' => 'Default Value',
		'type' => 'text');

	$options[] = array(
		'name' => __('Textarea', 'options_framework_theme'),
		'desc' => __('Textarea description.', 'options_framework_theme'),
		'id' => 'example_textarea',
		'std' => 'Default Text',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('Select a Category', 'options_framework_theme'),
		'desc' => __('Passed an array of categories with cat_ID and cat_name', 'options_framework_theme'),
		'id' => 'example_select_categories',
		'type' => 'select',
		'options' => $options_categories);

	$options[] = array(
		'name' => __('Select a Tag', 'options_check'),
		'desc' => __('Passed an array of tags with term_id and term_name', 'options_check'),
		'id' => 'example_select_tags',
		'type' => 'select',
		'options' => $options_tags);

	$options[] = array(
		'name' => __('Select a Page', 'options_framework_theme'),
		'desc' => __('Passed an pages with ID and post_title', 'options_framework_theme'),
		'id' => 'example_select_pages',
		'type' => 'select',
		'options' => $options_pages);

	$options[] = array(
		'name' => __('Example Info', 'options_framework_theme'),
		'desc' => __('This is just some example information you can put in the panel.', 'options_framework_theme'),
		'type' => 'info');

	$options[] = array(
		'name' => __('Input Checkbox', 'options_framework_theme'),
		'desc' => __('Example checkbox, defaults to true.', 'options_framework_theme'),
		'id' => 'example_checkbox',
		'std' => '1',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Check to Show a Hidden Text Input', 'options_framework_theme'),
		'desc' => __('Click here and see what happens.', 'options_framework_theme'),
		'id' => 'example_showhidden',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Hidden Text Input', 'options_framework_theme'),
		'desc' => __('This option is hidden unless activated by a checkbox click.', 'options_framework_theme'),
		'id' => 'example_text_hidden',
		'std' => 'Hello',
		'class' => 'hidden',
		'type' => 'text');

	$options[] = array(
		'name' => "Example Image Selector",
		'desc' => "Images for layout.",
		'id' => "example_images",
		'std' => "2c-l-fixed",
		'type' => "images",
		'options' => array(
			'1col-fixed' => $imagepath . '1col.png',
			'2c-l-fixed' => $imagepath . '2cl.png',
			'2c-r-fixed' => $imagepath . '2cr.png')
	);

	$options[] = array(
		'name' => __('Multicheck', 'options_framework_theme'),
		'desc' => __('Multicheck description.', 'options_framework_theme'),
		'id' => 'example_multicheck',
		'std' => $multicheck_defaults, // These items get checked by default
		'type' => 'multicheck',
		'options' => $multicheck_array);

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