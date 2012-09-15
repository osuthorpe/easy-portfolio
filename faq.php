<?php
/*
Template Name: FAQ
*/
?>

<?php get_header(); ?>

<div id="content">
	<div id="primary-content">
		<div id="post-<?php the_ID(); ?>" <?php post_class('page'); ?>>		
			<div class="expand-collapse">    
				<?php
					$args = array( 'post_type' => 'faq', );
					$loop = new WP_Query( $args );
					while ( $loop->have_posts() ) : $loop->the_post();
						echo '<h3>';
						the_title();
						echo '</h3>';
						echo '<div>';
						the_content();
						echo '</div>';
					endwhile;
				?>
			</div>
		</div>
	</div>
	
	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>