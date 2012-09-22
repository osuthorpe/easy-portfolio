<?php
/*
Template Name: Porfolios
*/
?>

<?php get_header(); ?>

<div id="wrapper">

	<div id="navigation">
		<?php	get_template_part( 'menu', 'index' ); ?>
	</div>

	<div id="main-content">
        <?php
            $new = new WP_Query('post_type=portfolio');
            while ($new->have_posts()) : $new->the_post();
        ?>

		<div class="mosaic-block fade">
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

</div>

<?php get_footer(); ?>