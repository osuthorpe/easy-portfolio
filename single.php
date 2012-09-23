<?php get_header(); ?>

<div id="wrapper">

	<div id="navigation">
		<?php	get_template_part( 'menu', 'index' ); ?>
	</div>

	<div id="main-content">
		<div id="blog-content">
		    <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class('single-content'); ?>>
		        	<div class="single-image">
		        		<?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) : ?>
		                    <a href="<?php the_permalink(); ?>" ><?php the_post_thumbnail('blog'); ?></a>
		                <?php endif; ?>
		            </div>
		            <div class="title">
		                <a href="<?php the_permalink(); ?>"><h2 class="entry-title"><?php the_title(); ?></h2></a>
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
			<?php get_sidebar(); ?>
		</div>
	</div>

</div>

<?php get_footer(); ?>