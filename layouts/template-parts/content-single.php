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
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title">', esc_url( get_permalink() ) ), '</h2>' ); ?>
		<div class="entry-meta">
			<?php scm_test_entry_footer(); ?>
		</div><!-- entry-meta -->
	</header><!-- entry-header -->
	<?php if (has_post_thumbnail()): ?>
		<div class="entry-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
	<?php endif; ?>
	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->
	<div class="post-navigation">
		<div class="nav-previous alignleft"><?php previous_post_link(); ?></div>
		<div class="nav-next alignright"><?php next_post_link(); ?></div>
	</div>
	<?php relatedPosts(); ?>
	<!-- post navigation -->

</article><!-- #post-## -->
