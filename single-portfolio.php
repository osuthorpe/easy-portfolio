<?php get_header();
	$args = array( 'post_type' => 'portfolio' );
	$loop = new WP_Query( $args );
	while ( $loop->have_posts() ) : $loop->the_post(); ?>

		<div id="bg">
			<a href="#" class="nextImageBtn" title="next"><img </a>
			<a href="#" class="prevImageBtn" title="previous"></a>
			<?php echo get_the_post_thumbnail($id, 'full', array('id' => 'bgimg')); ?>
		</div>

		<div id="preloader">
			<img src="<?php echo get_template_directory_uri(); ?>/css/img/preloader.gif" width="16" height="16">
		</div>

		<div id="img_title"></div>

		<div id="toolbar">
			<a href="#" class="fullscreen-toogle" title="Maximize" onclick="ImageViewMode('full');return false">
				Fullscreen
			</a>
		</div>

		<div id="thumbnails_wrapper">
			<div id="outer_container">
				<div class="thumbScroller">
					<div class="container">
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
								echo "<div class='content'>";
								echo "<div><a href='{$src}'><img src='{$src_thumb}' class='thumb' title='{$title}' alt='{$caption}'></a></div>";
								echo "</div>";
					
						} ?>
					</div><!-- end container -->
				</div><!-- end scroller -->
			</div><!-- end outer_container -->
		</div><!-- end thumbnail wrapper -->
	<?php endwhile; ?>
<?php get_footer(); ?>