<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package scm_test
 */
?>
<section class="no-results not-found">
	<header class="page-header">
		<h2 class="page-title"><span><?php esc_html_e( 'お探しのページは見つかりませんでした。', 'scm_' ); ?></span></h2>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php 
			if ( is_home() && current_user_can( 'publish_posts' ) ) :
				echo '<p>';
			 	printf( wp_kses( __( '最初の登録をする準備はできましたか? <a href="%1$s">ここから始めましょう！</a>.', 'scm_' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) );
			 	echo '</p>';
			elseif ( is_search() ) :
				echo '<p>';
				esc_html_e( '申し訳ありません。検索ワードに該当する記事が見つかりませんでした。他のワードでもう一度お願いいたします。', 'scm_' );
				echo '</p>';
				get_search_form();
			else :
				echo '<p>';
				esc_html_e( 'お探しのものは見つかりませんでした。もしかしたら検索で見つかるかもしれません。', 'scm_' );
				echo '</p>';
				get_search_form();
			endif;
		?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
