<?php get_header(); ?>

<div id="content">
	<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var('taxonomy')); ?>

	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
	
		<div class="gearItem">
			<?php the_title(); ?>
			<?php the_content(); ?>
		</div>

    <?php endwhile; ?>
    <?php endif; ?>
</div>

<?php get_footer(); ?>