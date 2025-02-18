<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Telescope
 */

get_header(); ?>

	<div id="site-main" class="content-home">

		<?php if ( is_home() && !is_paged() ) { ?>
		
			<?php
			if ( 1 == get_theme_mod( 'telescope_front_featured_posts', 1 ) ) {
				get_template_part( 'template-parts/content', 'home-featured' );
			}
			?>

		<?php } ?>

		<div class="wrapper wrapper-main clearfix">
		
			<main id="site-content" class="site-main" role="main">
			
				<div class="site-content-wrapper clearfix">

					<?php if ( have_posts() ) : ?>
					
					<?php if ( is_home() && ! is_front_page() ) : ?>
						<header>
							<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
						</header>
					<?php endif; ?>

					<div class="ilovewp-columns ilovewp-columns-<?php if ( 1 == get_theme_mod( 'telescope_front_featured_categories', 0 ) || is_active_sidebar( 'sidebar-secondary' ) ) { echo '2'; } else { echo '1'; } ?> clearfix">
					
						<div class="ilovewp-column ilovewp-column-1">
					
							<div class="ilovewp-column-wrapper clearfix">

								<p class="widget-title"><?php echo __('[:en]Latest Posts[:ru]Последние сообщения'); ?></p>
								
								<ul id="recent-posts" class="ilovewp-posts ilovewp-posts-archive clearfix">
									
									<?php while (have_posts()) : the_post(); ?>
									
									<?php get_template_part( 'template-parts/content'); ?>
									
									<?php endwhile; ?>
									
								</ul><!-- #recent-posts .ilovewp-posts .ilovewp-posts-archive -->

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