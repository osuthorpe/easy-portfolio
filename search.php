<?php get_header(); ?>

<div id="main-content">
	<div id="blog-content">
		<h3 class="page-title">Search Result for <?php /* Search Count */ $allsearch = &new WP_Query("s=$s&showposts=-1"); $key = esc_html($s, 1); $count = $allsearch->post_count; _e('','bk-media'); _e('<span class="search-terms">','bk-media'); echo $key; _e('</span>','bk-media'); _e(' &mdash; ','bk-media'); echo $count . ' '; _e('articles','bk-media'); wp_reset_query(); ?></h3>


        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

            <?php
				// Replace the_exerpt() with:
				$excerpt = get_the_excerpt();
				$keys = explode(" ",$s);
				$excerpt = preg_replace('/('.implode('|', $keys) .')/iu', '<strong>\0</strong>', $excerpt);
			?>

			<div class="single-content">
	            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

	            <div class="content">
	                <?php echo $excerpt; ?>
	                <p class="tags"><?php the_tags('Tagged with: ',' , ',''); ?></p>
	                <a class="more right" href="<?php the_permalink(); ?>">read more...</a>
	            </div>

	        </div>

        <?php endwhile; else: ?>

            <p><?php _e('Sorry, no posts matched your search criteria.', 'bkmedia'); ?></p>

        <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'bkmedia' ) ); ?></div>
        <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'bkmedia' ) ); ?></div>
        <?php endif; ?>
	</div>

	<div id="sidebar">
		<?php get_sidebar(); ?>
	</div>
</div>

<?php get_footer(); ?>