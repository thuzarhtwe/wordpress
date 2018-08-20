<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package scm_test
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-thumbnail">
		<a href="<?php the_permalink(); ?>" rel="bookmark">
		<?php
			if (has_post_thumbnail()):
				the_post_thumbnail();
			else :
				the_dummy_thumbnail();
			endif;
		?>
		</a>
	</div>
	<header class="entry-header">
		<h2 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark">
				<?php
				echo mb_strimwidth(get_the_title(), 0, 35, '...');
				?>
			</a>
		</h2>
	</header><!-- .entry-header -->
	<div class="entry-summary">
		<?php dynamic_excerpt(); ?>
	</div><!-- .entry-summary -->
	<footer class="entry-footer">
		<?php scm_test_entry_footer(); ?>
	</footer><!-- .entry-footer -->
	<div class="read-more">
		<a href="<?php the_permalink(); ?>" rel="bookmark">Read More</a>
	</div>
</article><!-- #post-## -->
