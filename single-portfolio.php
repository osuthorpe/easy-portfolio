<?php get_header(); ?>

<div id="main-content">
	 <?php while ( have_posts() ) : the_post(); ?>
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
					echo "<img src='{$src}' data-title='{$title}' data-description='{$caption}'>";
				}

				echo apply_filters('the_content', get_post_meta($post->ID, 'bk_video', true));
			?>
		</div>

		<script>
			Galleria.loadTheme('<?php echo get_template_directory_uri()."/js/themes/simple/galleria.simple.js" ?>');
			Galleria.run('#galleria', {
				transition: <?php echo "'".of_get_option('bk_standard_transition')."'"; ?>,
		        touchTransition: 'slide',
		        fullscreenTransition: <?php echo "'".of_get_option('bk_fullscreen_transition')."'"; ?>,
		        fullscreenCrop: <?php echo of_get_option('bk_fullscreen_crop'); ?>,
		        responsive: false,
		        autoplay: <?php echo of_get_option('bk_standard_play'); ?>,
		        imageCrop: <?php echo of_get_option('bk_standard_crop'); ?>,
			    extend: function() {
			        var gallery = this,
			            w,h;
			        $(window).resize(function() {
			        	var is_fullscreen = $('.galleria-fullscreen').hasClass('open');

			        	if (!is_fullscreen) {
			        		viewPortWidth = $(window).width();
				            w = $('#main-content').width();
				            h = 0;
				            if (480 < viewPortWidth < 960) {
				            	h = $(window).height() - $('#header').height() - $('#navigation').height() - 30;
				            }
				            if (viewPortWidth > 960) {
				            	h = $(window).height() - $('#header').height() - 35;
				            }
				            $('#galleria').add('.galleria-container').width(w).height(h);
				            gallery.rescale(w, h);
				        }
			        });
			    }
			});
    	</script>
	<?php endwhile; ?>
</div>

<?php get_footer(); ?>