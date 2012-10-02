<?php get_header(); ?>

	<div id="main-content">
		<div id="blog-content">
			<h1 class="page-title">
	            <?php if ( is_day() ) : ?>
	                <?php printf( __( 'Daily Archives: <span>%s</span>', 'bkmedia' ), get_the_date() ); ?>
	            <?php elseif ( is_month() ) : ?>
	                <?php printf( __( 'Monthly Archives: <span>%s</span>', 'bkmedia' ), get_the_date( 'F Y' ) ); ?>
	            <?php elseif ( is_year() ) : ?>
	                <?php printf( __( 'Yearly Archives: <span>%s</span>', 'bkmedia' ), get_the_date( 'Y' ) ); ?>
	            <?php else : ?>
	                <?php _e( 'Blog Archives', 'bkmedia' ); ?>
	            <?php endif; ?>
	        </h1>

	        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	        	<div class="single-content">
		            <h4><?php the_title(); ?></h4>
		            <?php the_excerpt(); ?>
		            <div class="post-tags page-tags">
	        			<?php the_tags('',', ',''); ?>
	        		</div>
		        </div>

	        <?php endwhile; else: ?>

	            <p><?php _e('Sorry, no posts matched your criteria.', 'bkmedia'); ?></p>

	        <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'bkmedia' ) ); ?></div>
	        <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'bkmedia' ) ); ?></div>
	        <?php endif; ?>
		</div>

		<div id="sidebar">
			<?php get_sidebar(); ?>
		</div>
	</div>

</div>

<?php get_footer(); ?>