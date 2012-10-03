<!doctype html>
<!--[if lt IE 9]><html class="ie"><![endif]-->
<!--[if gte IE 9]><!--><html <?php language_attributes(); ?>><!--<![endif]-->

	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="initial-scale=1; maximum-scale=1">
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<link rel="shortcut icon" href="<?php bloginfo( 'stylesheet_url' ); ?>/images/favicon.ico">
		<link rel="apple-touch-icon" href="<?php bloginfo( 'stylesheet_url' ); ?>/images/apple-touch-icon.png">
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
			<?php if ( of_get_option('bk_logo') == '') { ?>
			    <h1 class="site-title"><a href="<?php echo home_url(); ?>"><?php echo of_get_option('bk_site_title') ?></a></h1>
			<?php } else { ?>
			    <a class="logo" href="<?php echo home_url(); ?>"><img src="<?php echo of_get_option('bk_logo'); ?>" alt="<?php bloginfo( 'name' ); ?>"/></a>
			<?php } ?>
			<div id="pull">Menu</div>
		</div>

		<div id="wrapper">

			<div id="navigation" class="closed">
				<?php	get_template_part( 'menu', 'index' ); ?>
			</div>