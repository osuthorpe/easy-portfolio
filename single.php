<?php get_header(); ?>

	<div id="main-content">
		<div id="blog-content">
		    <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class('single-content'); ?>>
		        	<div class="single-image">
		        		<?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) : ?>
		                    <?php the_post_thumbnail('blog'); ?>
		                <?php endif; ?>
		            </div>
		            <div class="title">
		                <h2 class="entry-title"><?php the_title(); ?></h2>
		            </div>

		            <div class="meta">
		                written on <?php the_time('F jS, Y') ?> | <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?>
		            </div>

		            <div class="post-tags page-tags">
	        			<?php the_tags('',', ',''); ?>
	        		</div>

		            <div class="content">
		                <?php the_content(); ?>
		                <?php wp_link_pages(); ?>
		            </div>

			        <div id="nav-below" class="navigation">
						<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'framework' ) . '</span> %title' ); ?></div>
						<div class="nav-next right"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'framework' ) . '</span>' ); ?></div>
					</div><!-- #nav-below -->
				</div>

			    <?php comments_template('', true); ?>

			<?php endwhile; ?>
	    	<?php endif; ?>
		</div>

		<div id="sidebar">
			<ul><?php get_sidebar(); ?></ul>
		</div>
	</div>

</div>

<?php get_footer(); ?>