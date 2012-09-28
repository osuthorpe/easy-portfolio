<?php get_header(); ?>
	<div id="main-content">
		<div id="blog-content">
		<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class('single-content'); ?>>

				<div class="title">
	                <h2 class="entry-title"><?php the_title(); ?></h2>
	            </div>

		        <div class="single-image">
		        		<?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) : ?>
		                    <?php the_post_thumbnail('blog'); ?>
		                <?php endif; ?>
	            </div>

	            <div class="post-tags page-tags">
        			<?php the_tags('',', ',''); ?>
        		</div>

	            <div class="content">
	                <?php the_content(); ?>
	                <?php wp_link_pages(); ?>
	            </div>
		    </div>

		    <?php comments_template('', true); ?>
	    <?php endwhile; ?>
	    <?php endif; ?>
	</div>

	<div id="sidebar">
		<?php get_sidebar(); ?>
	</div>

</div>

<?php get_footer(); ?>