<?php
/*
Template Name: Porfolios
*/
?>

<?php get_header(); ?>

<div id="portfolio-content">
    <?php
        $new = new WP_Query('post_type=portfolio');
        while ($new->have_posts()) : $new->the_post();
    ?>

    <div class="portfolio-link">
		<div class="mosaic-block fade">
			<a href="<?php the_permalink(); ?>" target="_self" class="mosaic-overlay">
				<div class="details">
					<p><?php echo get_post_meta(get_the_ID(), 'bk_portfolio_desc', true); ?></p>
				</div>
			</a>
			<div class="mosaic-backdrop large"><?php the_post_thumbnail('portfolio-thumb'); ?></div>
		</div>

		<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	</div>

    <?php endwhile; ?>
</div>

<div id="sidebar">
	<ul><?php get_sidebar(); ?></ul>
</div>

<?php get_footer(); ?>