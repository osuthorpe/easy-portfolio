<?php get_header(); ?>

<div id="content">
	<div id="primary-content" class="column11">
		<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class('page'); ?>>
	        
		        <div class="single-title">
		        	<h1><?php the_title(); ?></h1>
		        </div>
		        
		        <div class="post-tags page-tags">
		        	<?php the_tags('',', ',''); ?>
		        </div>
		        
		        <?php if((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) {
		        	the_post_thumbnail('archive-thumb');
		        } ?>
		        
		        <div class="post-content page-content">
		        	<?php the_content(); ?>
		        	<?php wp_link_pages(); ?>
		        </div>
		        
		        <?php comments_template('', true); ?>
		    </div>
	    <?php endwhile; ?>
	    <?php endif; ?>
	</div>
	
	<?php get_sidebar(); ?>
    
</div>

<?php get_footer(); ?>