<?php get_header(); ?>

<div id="content">
	<div id="primary-content" class="column11">
		<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class('page'); ?>>

		        <div class="single-title">
		        	<h1><?php the_title(); ?></h1>
		        </div>

		        <div class="post-meta-top">
		        	<small>This entry was posted on
					<?php the_time('l, F jS, Y') ?> at
					<?php the_time() ?> under <?php the_category(', ') ?></small>
		        </div>

		        <div class="post-tags page-tags">
		        	<?php the_tags('',', ',''); ?>
		        </div>


		        <?php if((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) {
	the_post_thumbnail('post-thumb');
} ?>

		        <div class="post-content page-content">
		        	<?php the_content(); ?>
		        	<?php wp_link_pages(); ?>
		        </div>

		        <div id="nav-below" class="navigation">
					<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'framework' ) . '</span> %title' ); ?></div>
					<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'framework' ) . '</span>' ); ?></div>
				</div><!-- #nav-below -->

		        <?php comments_template('', true); ?>
		    </div>

	    <?php endwhile; ?>
	    <?php endif; ?>
	</div>

	<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>