<?php
/*
Template Name: Porfolios
*/
?>

<?php get_header(); ?>

<div id="content">
    <div id="primary-content" class="column11 left ">
        <?php
            $new = new WP_Query('post_type=portfolio');
            while ($new->have_posts()) : $new->the_post();
        ?>
        
		<div class="mosaic-block bar">
			<a href="<?php the_permalink(); ?>" target="_self" class="mosaic-overlay">
				<div class="details">
					<h4><?php the_title(); ?></h4><br/>
					<p><?php echo get_post_meta(get_the_ID(), 'bk_portfolio_desc', true); ?></p>
				</div>
			</a>
			<div class="mosaic-backdrop"><?php the_post_thumbnail('portfolio-thumb'); ?></div>
		</div>
		
        <?php endwhile; ?>
    </div>
    
    <?php get_sidebar(); ?>
    
</div>

<?php get_footer(); ?>