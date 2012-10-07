<!doctype html>
<!--[if lt IE 9]><html class="ie"><![endif]-->
<!--[if gte IE 9]><!--><html <?php language_attributes(); ?>><!--<![endif]-->

	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="initial-scale=1; maximum-scale=1">
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<link rel="icon" type="image/png" href="<?php echo of_get_option('bk_favicon'); ?>">
		<link rel="apple-touch-icon" size="144x144" href="<?php echo of_get_option('bk_mobile_icon'); ?>">
		<link rel="apple-touch-icon" size="114x114" href="<?php echo of_get_option('bk_mobile_icon'); ?>">
		<link rel="apple-touch-icon" size="72x72" href="<?php echo of_get_option('bk_mobile_icon'); ?>">
		<link rel="apple-touch-icon" size="57x57" href="<?php echo of_get_option('bk_mobile_icon'); ?>">
		<title><?php echo bloginfo( 'name' ); ?> <?php echo wp_title(); ?> </title>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="screen" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<?php wp_head(); ?>
		<?php if(of_get_option('bk_google_code') != '') { ?>
			<script type="text/javascript">
		        var _gaq = _gaq || [];
		        _gaq.push(['_setAccount', <?php echo "'".of_get_option('bk_google_code')."'"; ?>]);
		        _gaq.push(['_trackPageview']);

		        (function() {
		        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		        })();
		    </script>
	    <?php } ?>
	</head>

	<body <?php body_class(); ?>>
		<div id="header" class="left clear">
			<?php if ( of_get_option('bk_logo') == '') { ?>
			    <h1 class="site-title"><a href="<?php echo home_url(); ?>"><?php echo of_get_option('bk_site_title') ?></a></h1>
			<?php } else { ?>
			    <a class="logo" href="<?php echo home_url(); ?>"><img src="<?php echo of_get_option('bk_logo'); ?>" alt="<?php bloginfo( 'name' ); ?>"/></a>
			<?php } ?>

			<div id="social-pull">Menu</div>

			<div id="pull">Menu</div>

			<div id="social" class="closed">
				<?php
					if ( of_get_option('bk_twitter') ) {
						echo '<a href="http://www.twitter.com/'. of_get_option('bk_twitter') .'" target="_blank" class="social-icon twitter">twitter</a>';
					}
					if ( of_get_option('bk_facebook') ) {
						echo '<a href="'. of_get_option('bk_facebook') .'" target="_blank" class="social-icon facebook">facebook</a>';
					}
					if ( of_get_option('bk_flickr') ) {
						echo '<a href="'. of_get_option('bk_flickr') .'" target="_blank" class="social-icon flickr">flickr</a>';
					}
					if ( of_get_option('bk_500px') ) {
						echo '<a href="'. of_get_option('bk_500px') .'" target="_blank" class="social-icon five-hundred">500px</a>';
					}
					if ( of_get_option('bk_dribble') ) {
						echo '<a href="'. of_get_option('bk_dribble') .'" target="_blank" class="social-icon dribble">dribble</a>';
					}
					if ( of_get_option('bk_linkedin') ) {
						echo '<a href="'. of_get_option('bk_linkedin') .'" target="_blank" class="social-icon linkedin">linkedin</a>';
					}
					if ( of_get_option('bk_youtube') ) {
						echo '<a href="'. of_get_option('bk_youtube') .'" target="_blank" class="social-icon youtube">youtube</a>';
					}
					if ( of_get_option('bk_vimeo') ) {
						echo '<a href="'. of_get_option('bk_vimeo') .'" target="_blank" class="social-icon vimeo">vimeo</a>';
					}
				?>
			</div>
		</div>

		<div id="wrapper">

			<div id="navigation" class="closed">
				<?php get_template_part( 'menu', 'index' ); ?>
			</div>