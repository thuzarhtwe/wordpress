<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package scm_test
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header">
		<?php the_title( '<h2 class="page-title">', '</h2>' ); ?>
	</header><!-- .page-header -->

	<?php if (has_post_thumbnail()): ?>
		<div class="entry-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
	<?php endif; ?>
	
	<section class="page-content">
		<?php the_content(); ?>
	</section><!-- .page-content -->
</article><!-- #post-## -->
