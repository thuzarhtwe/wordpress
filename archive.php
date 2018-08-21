<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package scm_test
 */

get_header();
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main-archive" role="main">
		<h2 class="page-title">
			<?php
				if (is_day()) : /* 日別アーカイブ */
					echo '<span>'. get_the_time('Y') .'年'. get_the_time('n'). '月' . get_the_time('d'). '日</span>';
				elseif (is_month()) : /* 月別アーカイブ */
					echo '<span>'. get_the_time('Y') .'年'. get_the_time('n'). '月</span>';
				elseif (is_year()) : /* 年別アーカイブ */
					echo '<span>'. get_the_time('Y') .'年</span>';
				elseif (is_category()) :
					echo '<span>「' . single_cat_title('', false) . '」カテゴリー内の記事</span>';
				elseif (is_tag()) :
					echo '「' . single_tag_title('', false) . '」タグのついた記事';
				else :
					echo 'アーカイブ';
				endif;
			?>
		</h2><!-- .page-title -->
		<?php
			if ( have_posts() ) :
				// Display posts list
				echo '<section class="top-page">';
					while ( have_posts() ) :
						the_post();
						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_format() );
					endwhile;
				echo '</section>';
				// the_posts_pagination();
			else :
				get_template_part( 'template-parts/content', 'none' );
			endif;
		?><br/><br/>
		<?php the_posts_pagination(); ?>
	</main><!-- #main -->
</div><!-- #primary -->
<!-- <?php the_posts_pagination(); ?> -->
<?php
	get_sidebar();
	get_footer();
?>
