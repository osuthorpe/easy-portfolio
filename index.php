<?php get_header();

	get_template_part( 'menu', 'index' );

	$args = array( 'post_type' => 'portfolio' );
	$loop = new WP_Query( $args );
	while ( $loop->have_posts() ) : $loop->the_post(); ?>
	<div id="main-content">
		<div id='galleria'>
            <?php
				global $wpdb, $post;

				$meta = get_post_meta(get_the_ID(), 'bk_photo', false);
				if (!is_array($meta)) $meta = (array) $meta;
				$meta = implode(',', $meta);
				$images = $wpdb->get_col("
                    SELECT ID FROM $wpdb->posts
                    WHERE post_type = 'attachment'
                    AND post_parent = $post->ID
                    AND ID in ($meta)
                    ORDER BY menu_order ASC
                ");

				foreach ($images as $att) {
					$src = wp_get_attachment_image_src($att, 'full');
					$src_thumb = wp_get_attachment_image_src( $att, 'thumbnail' );
					$src = $src[0];
					$src_thumb = $src_thumb[0];
					$image_meta = get_post($att);
					$title= $image_meta->post_title;
					$desc= $image_meta->post_content;
					$caption= $image_meta->post_excerpt;
					$alt= get_post_meta($att, '_wp_attachment_image_alt', true);

					// show image
					echo "<img src='{$src}' data-title='{$title}' data-description='{$title}'>";
			} ?>
		</div><!-- end container -->
		<script>
			Galleria.loadTheme('<?php echo get_template_directory_uri()."/js/themes/classic/galleria.classic.js" ?>');
			Galleria.run('#galleria');
    	</script>
	</div>
	<?php endwhile; ?>
<?php get_footer(); ?>