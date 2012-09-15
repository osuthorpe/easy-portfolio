<!DOCTYPE html>
<html <?php language_attributes(); ?>>

	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<title><?php echo bloginfo( 'name' ); ?> <?php echo wp_title(); ?> </title>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="screen" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
		<?php wp_head(); ?>
	</head>
	
	<body id="<?php echo get_option('bk_layout'); ?>" <?php body_class(); ?>>
		<div id="fullscreen">
			<div id="nav-wrapper">
				<div id="navigation">
					<div id="logo" class="left clear">
						<?php if ( get_option('bk_logo') == '') { ?>
						    <h1 class="site-title"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
						<?php } else { ?>
						    <a class="logo" href="<?php echo home_url(); ?>"><img src="<?php echo get_option('bk_logo'); ?>" alt="<?php bloginfo( 'name' ); ?>"/></a>
						<?php } ?>
					</div>
					<div id="social-icons">
						<div class="icon facebook">
							<a class="social-link" href="http://www.facebook.com">facebook</a>
						</div>
						<div class="icon twitter">
							<a class="social-link" href="http://www.facebook.com">twitter</a>
						</div>
						<div class="icon dribble">
							<a class="social-link" href="http://www.facebook.com">dribble</a>
						</div>
						<div class="icon flickr">
							<a class="social-link" href="http://www.facebook.com">flickr</a>
						</div>
						<div class="icon youtube">
							<a class="social-link" href="http://www.facebook.com">youtube</a>
						</div>
					</div>
					<div id="nav" class="clear">
						<?php if ( has_nav_menu( 'primary-menu' ) ) {
						    wp_nav_menu( array( 'container_id' => 'menu', 'container_class' => 'ddsmoothmenu', 'theme_location' => 'primary-menu') );
						} ?>
					</div>
				</div>
				<div id="openClose">Menu</div>
			</div>