<?php
function relatedPosts() {
	global $post;
	$tags = wp_get_post_tags($post->ID);
	if ($tags) :
		$tag_ids = array();
		foreach($tags as $individual_tag) :
			$tag_ids[] = $individual_tag->term_id;
		endforeach;
		$args=array(
				'tag__in' => $tag_ids,
				'post__not_in' => array($post->ID),
				'posts_per_page'=> 4, // Number of related posts to display.
				'ignore_sticky_posts' => 1
			);
		$my_query = new WP_Query( $args );
		if ($my_query->have_posts()) :
			echo '<aside class="widget widget-related-post">';
			echo '<h3 class="widget-title">関連記事</h3>';
			echo '<ul>';
			while( $my_query->have_posts() ) :
				$my_query->the_post();
				echo '<li>';
				echo '<a href="';
				the_permalink();
				echo '">';
				echo mb_strimwidth(get_the_title(),'0','30','...');
				if (has_post_thumbnail()):
					the_post_thumbnail();
				else :
					the_dummy_thumbnail();
				endif;
				echo '</a>';
				echo '</li>';
			endwhile;
			echo '</ul>';
			echo "</aside>";
		endif;
	endif;
	wp_reset_query();
}
?>
