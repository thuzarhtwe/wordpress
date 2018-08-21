<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package scm_test
 */
get_header();
?>
<section id="primary" class="content-area">
	<main id="main" class="site-main-archive" role="main">
		<?php if ( have_posts() ) : ?>
			<header class="page-header">
				<h2 class="page-title">
					<?php printf( esc_html__( '「%s」で検索した結果', '' ), '<span>' . get_search_query() . '</span>' ); ?>
				</h2>
			</header><!-- .page-header -->
			<div class="top-page">
				<?php
					while ( have_posts() ) : the_post();
						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_format() );
					endwhile;
					// Display pagination
					// the_posts_pagination();
				else :
					get_template_part( 'template-parts/content', 'none' );
				endif;
				?>
			</div>
	</main><!-- #main -->
</section><!-- #primary -->
<br/><br/>
<?php the_posts_pagination(); ?>
<?php
	get_sidebar();
	get_footer();
?>
