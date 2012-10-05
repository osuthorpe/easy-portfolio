<?php get_header(); ?>
	<div id="main-content">
		<div id="galleria-wrapper">
			<?php $front_id = of_get_option('bk_front_page');
			$args = array(
				'post_type' => 'portfolio',
				'p' => $front_id );
			$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) : $loop->the_post(); ?>
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
							echo "<img src='{$src}' data-title='{$title}' data-description='{$caption}' alt='{$caption}'>";
					} ?>
				</div>
				<script>
					Galleria.loadTheme('<?php echo get_template_directory_uri()."/js/themes/classic/galleria.classic.js" ?>');
					Galleria.run('#galleria', {
					    extend: function() {
					        var gallery = this,
					            w,h;
					        $(window).resize(function() {
					            w = $('#main-content').width();
					            h = $(this).height() - $('#header').height() - 20;
					            $('#galleria').add('.galleria-container').width(w).height(h);
					            gallery.rescale(w, h);
					        });
					    }
					});

		    	</script>
			<?php endwhile; ?>
		</div>
	</div>

</div>

<?php get_footer(); ?>