<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Telescope
 */

get_header(); ?>

	<div id="site-main">

		<div class="wrapper wrapper-main clearfix">
		
			<main id="site-content" class="site-main" role="main">
			
				<div class="site-content-wrapper clearfix">

					<div class="ilovewp-page-intro ilovewp-archive-intro">
						<?php
							the_archive_title( '<h1 class="title-page widget-title">', '</h1>' );
							the_archive_description( '<div class="taxonomy-description">', '</div>' );
						?>
					</div><!-- .ilovewp-page-intro -->

					<?php if ( have_posts() ) : ?>
					
					<div class="ilovewp-columns ilovewp-columns-<?php if ( 1 == get_theme_mod( 'telescope_front_featured_categories', 0 ) || is_active_sidebar( 'sidebar-secondary' ) ) { echo '2'; } else { echo '1'; } ?> clearfix">
					
						<div class="ilovewp-column ilovewp-column-1">
					
							<div class="ilovewp-column-wrapper clearfix">

								<?php /* Start the Loop */ ?>
								<ul id="recent-posts" class="ilovewp-posts ilovewp-posts-archive clearfix">
								<?php while ( have_posts() ) : the_post(); ?>
					
									<?php
					
										/*
										 * Include the Post-Format-specific template for the content.
										 * If you want to override this in a child theme, then include a file
										 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
										 */
										get_template_part( 'template-parts/content' );
									?>
					
								<?php endwhile; ?>
								
								</ul><!-- .ilovewp-posts .ilovewp-posts-archive -->

							</div><!-- .ilovewp-column-wrapper -->
						
						</div><!-- .ilovewp-column .ilovewp-column-1 -->
							
						<?php get_sidebar('archives'); ?>
						
					</div><!-- .ilovewp-columns .ilovewp-columns-2 -->
		
					<?php 
					$args['prev_text'] = '<span class="nav-link-label"><span class="genericon genericon-previous" aria-hidden="true"></span></span>' . __('Older Posts', 'telescope');
					$args['next_text'] = __('Newer Posts', 'telescope') . '<span class="nav-link-label"><span class="genericon genericon-next" aria-hidden="true"></span></span>';
					the_posts_navigation($args); ?>
		
				<?php else : ?>
		
					<?php get_template_part( 'template-parts/content', 'none' ); ?>
		
				<?php endif; ?>
					
				</div><!-- .site-content-wrapper .clearfix -->
				
			</main><!-- #site-content -->
			
			<?php get_sidebar(); ?>
		
		</div><!-- .wrapper .wrapper-main -->

	</div><!-- #site-main -->

<?php get_footer(); ?>