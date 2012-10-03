<?php
/**
 * Theme Colors and Images Settings Functions file
 *
 * Below is an example of creating a new tab for your Theme Options page:
 */

$main_settings_tab = array(
	"name" => "main_settings",
	"title" => __("Main Settings","bk-media"),
	'sections' => array(
		'color_scheme' => array(
			'name' => 'color_scheme',
			'title' => __( 'Color Scheme', 'upfw' ),
			'description' => __( 'Select your color scheme.','upfw' )
		)
	)
);

register_theme_option_tab($main_settings_tab);

$style_settings_tab = array(
  "name" => "style_settings",
  "title" => __("Style Settings","bk-media"),
  'sections' => array(
    'color_scheme' => array(
      'name' => 'color_scheme',
      'title' => __( 'Color Scheme', 'upfw' ),
      'description' => __( 'Select your color scheme.','upfw' )
    )
  )
);

register_theme_option_tab($style_settings_tab);

// The following example shows you how to register theme options and assign them to tabs:

$options = array(
  'theme_color_scheme' => array(
  	"tab" => "main_settings",
  	"name" => "theme_color_scheme",
  	"title" => "Theme Color Scheme",
  	"description" => __( "Select a color scheme for your website", "example" ),
  	"section" => "color_scheme",
  	"since" => "1.0",
      "id" => "color_scheme",
      "type" => "select",
      "default" => "light",
      "valid_options" => array(
      	"light" => array(
      		"name" => "light",
      		"title" => __( "Light", "example" )
      	),
      	"dark" => array(
      		"name" => "dark",
      		"title" => __( "Dark", "example" )
      	)
      )
  ),
  "theme_footertext" => array(
  	"tab" => "colors_and_images",
  	"name" => "theme_footertext",
  	"title" => "Theme Footer Text",
  	"description" => __( "Enter text to be displayed in your footer", "example" ),
  	"section" => "color_scheme",
  	"since" => "1.0",
      "id" => "color_scheme",
      "type" => "text",
      "default" => "Copyright 2012 UpThemes"
  ),
  "font_color" => array(
  	"tab" => "colors_and_images",
  	"name" => "font_color",
  	"title" => "Font Color",
  	"description" => __( "Select a font color for your theme", "example" ),
  	"section" => "color_scheme",
  	"since" => "1.0",
      "id" => "color_scheme",
      "type" => "text",
      "default" => "Copyright 2012 UpThemes"
  )
);

register_theme_options($options);

/*
 * The different types of options you can define are: text, color, image, select, list, multiple, textarea, page, pages, category, categories
 */

?>