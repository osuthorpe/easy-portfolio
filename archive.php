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
		            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

		            <div class="content">
		                <?php the_excerpt(); ?>
		                <p class="tags"><?php the_tags('Tagged with: ',' • ',''); ?></p>
		                <a class="more right" href="<?php the_permalink(); ?>">read more...</a>
		            </div>

		        </div>

	        <?php endwhile; else: ?>

	            <h4><?php _e('Sorry, no posts matched your criteria.', 'bkmedia'); ?></h4>

	        <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'bkmedia' ) ); ?></div>
	        <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'bkmedia' ) ); ?></div>
	        <?php endif; ?>
		</div>

		<div id="sidebar">
			<ul><?php get_sidebar(); ?></ul>
		</div>
	</div>

<?php get_footer(); ?>