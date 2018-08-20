<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package scm_test
 */
get_header(); 
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main-single" role="main">
		<?php 
			while ( have_posts() ) : 
				the_post(); 
				wpb_set_post_views(get_the_ID());
				get_template_part( 'template-parts/content', 'single' );
			endwhile; 
		?>
	</main><!-- #main -->
</div><!-- #primary -->
<?php 
	get_sidebar();
	get_footer(); 
?>
