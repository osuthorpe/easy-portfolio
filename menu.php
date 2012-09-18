<div id="nav" class="clear">
	<?php if ( has_nav_menu( 'primary-menu' ) ) {
	    wp_nav_menu( array( 'container_id' => 'menu', 'container_class' => 'main-menu', 'theme_location' => 'primary-menu') );
	} ?>
</div>