<!doctype html>
<!--[if lt IE 9]><html class="ie"><![endif]-->
<!--[if gte IE 9]><!--><html <?php language_attributes(); ?>><!--<![endif]-->

	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
		<meta name="viewport" content="width=device-width; initial-scale=1; maximum-scale=1">
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<title><?php echo bloginfo( 'name' ); ?> <?php echo wp_title(); ?> </title>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="screen" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<div id="header" class="left clear">
			<?php if ( get_option('bk_logo') == '') { ?>
			    <h1 class="site-title"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
			<?php } else { ?>
			    <a class="logo" href="<?php echo home_url(); ?>"><img src="<?php echo get_option('bk_logo'); ?>" alt="<?php bloginfo( 'name' ); ?>"/></a>
			<?php } ?>
		</div>