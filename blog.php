<?php
/*
Template Name: Blog
*/
?>

<?php get_header(); ?>

		<div id="blog-content">
		    <?php query_posts($query_string . '&cat='); ?>

		    <?php
		        $recentPosts = new WP_Query();
		        $recentPosts->query('showposts=7'.'&paged='.$paged);
		        $temp = $wp_query;
		        $wp_query= null;
		        $wp_query = new WP_Query();
		        $wp_query->query('showposts=7'.'&paged='.$paged);
		    ?>

		    <?php while ($recentPosts->have_posts()) : $recentPosts->the_post(); ?>

		        <div class="single-content">
		        	<div class="single-image">
		        		<?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) : ?>
		                    <a href="<?php the_permalink(); ?>" ><?php the_post_thumbnail('blog'); ?></a>
		                <?php endif; ?>
		            </div>
		            <div class="title">
		                <a href="<?php the_permalink(); ?>"><h2 class="entry-title"><?php the_title(); ?></h2></a>
		            </div>

		            <div class="meta">
		                written on <?php the_time('F jS, Y') ?> | <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?>
		            </div>

		            <div class="content">
		                <?php the_excerpt(); ?>
		                <a class="more right" href="<?php the_permalink(); ?>">read more...</a>
		            </div>
		        </div>
		    <?php endwhile; ?>

		    <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentyten' ) ); ?></div>
		    <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?></div>

		    <?php $wp_query = null; $wp_query = $temp;?>
		</div>

		<div id="sidebar">
			<?php get_sidebar(); ?>
		</div>
	</div>

</div>

<?php get_footer(); ?>