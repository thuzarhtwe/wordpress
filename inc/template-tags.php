<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package scm_test
 */

if ( ! function_exists( 'scm_test_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function scm_test_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) :
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
		endif;

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);

		$posted_on = sprintf(
			esc_html_x( '%s', 'post date', 'scm_test' ), $time_string
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
	}
endif;

if ( ! function_exists( 'scm_test_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function scm_test_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) :
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'scm_test' ) );
			if ( $categories_list && scm_test_categorized_blog() ) :
				$fontawesome_post = new WP_Query(
										array(
											'posts_per_page' => 1,
											'post_status' => 'publish',
											'orderby' => 'date',
											'order' => 'DESC',
											'meta_query' => array(
												array(
													'key' => 'fa-folder-open',
													'value' => '',
													'compare' => '!='
												)
											)
										)
									);
				$fontawesome_custom = array();
				if ($fontawesome_post->have_posts()) :
					while ( $fontawesome_post->have_posts() ) :
						$fontawesome_post->the_post();
						$fontawesome_custom = get_post_custom();
					endwhile;
				endif;
				wp_reset_postdata();
				if (array_key_exists("fa-folder-open", $fontawesome_custom)) :
					$fa_folder = $fontawesome_custom["fa-folder-open"][0];
					if (preg_match("/^fa-/", $fa_folder)) :
						$folder = '<i class="fa ' . $fa_folder . '" aria-hidden="true"></i>';
					else :
						$folder = '<i class="fa">' . $fa_folder . '</i>';
					endif;
				else :
					$folder = '<i class="fa fa-folder-open" aria-hidden="true"></i>';
				endif;
				printf( '<span class="cat-links">' . $folder . esc_html__( '%1$s', 'scm_test' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			endif;

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'scm_test' ) );
			if ( $tags_list ) :
				$fontawesome_post = new WP_Query(
										array(
											'posts_per_page' => 1,
											'post_status' => 'publish',
											'orderby' => 'date',
											'order' => 'DESC',
											'meta_query' => array(
												array(
													'key' => 'fa-tags',
													'value' => '',
													'compare' => '!='
												)
											)
										)
									);
				$fontawesome_custom = array();
				if ($fontawesome_post->have_posts()) :
					while ( $fontawesome_post->have_posts() ) :
						$fontawesome_post->the_post();
						$fontawesome_custom = get_post_custom();
					endwhile;
				endif;
				wp_reset_postdata();
				if (array_key_exists("fa-tags", $fontawesome_custom)) :
					$fa_tags = $fontawesome_custom["fa-tags"][0];
					if (preg_match("/^fa-/", $fa_tags)) :
						$tags = '<i class="fa ' . $fa_tags . '" aria-hidden="true"></i>';
					else :
						$tags = '<i class="fa">' . $fa_tags . '</i>';
					endif;
				else :
					$tags = '<i class="fa fa-tags" aria-hidden="true"></i>';
				endif;
				printf( '<span class="tags-links">' . $tags . esc_html__( '%1$s', 'scm_test' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			endif;
			$fontawesome_post = new WP_Query(
									array(
										'posts_per_page' => 1,
										'post_status' => 'publish',
										'orderby' => 'date',
										'order' => 'DESC',
										'meta_query' => array(
											array(
												'key' => 'fa-eye',
												'value' => '',
												'compare' => '!='
											)
										)
									)
								);
			$view_count= wpb_get_post_views(get_the_id());
			$fontawesome_custom = array();
				if ($fontawesome_post->have_posts()) :
					while ( $fontawesome_post->have_posts() ) :
						$fontawesome_post->the_post();
						$fontawesome_custom = get_post_custom();
					endwhile;
				endif;
				wp_reset_postdata();
				if (array_key_exists("fa-eye", $fontawesome_custom)) :
					$fa_eye = $fontawesome_custom["fa-eye"][0];
					if (preg_match("/^fa-/", $fa_eye)) :
						$eye = '<i class="fa ' . $fa_eye . '" aria-hidden="true"></i>';
					else :
						$eye = '<i class="fa">' . $fa_eye . '</i>';
					endif;
				else :
					$eye = '<i class="fa fa-eye" aria-hidden="true"></i>';
				endif;
				printf( '<span class="view-count">' . $eye . esc_html__( '%1$s', 'scm_test' ) . '</span>', $view_count ); // WPCS: XSS OK.
		endif;
	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function scm_test_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'scm_test_categories' ) ) ) :
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
								'fields'     => 'ids',
								'hide_empty' => 1,

								// We only need to know if there is more than one category.
								'number'     => 2,
							) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'scm_test_categories', $all_the_cool_cats );
	endif;

	if ( $all_the_cool_cats > 1 ) :
		// This blog has more than 1 category so scm_test_categorized_blog should return true.
		return true;
	else :
		// This blog has only 1 category so scm_test_categorized_blog should return false.
		return false;
	endif;
}

/**
 * Flush out the transients used in scm_test_categorized_blog.
 */
function scm_test_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) :
		return;
	endif;
	// Like, beat it. Dig?
	delete_transient( 'scm_test_categories' );
}
add_action( 'edit_category', 'scm_test_category_transient_flusher' );
add_action( 'save_post',     'scm_test_category_transient_flusher' );
