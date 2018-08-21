<?php
/*search result not inclue page*/
function SearchFilter($query) {
	if ($query->is_search) :
		// $query->set('post_type', 'page');
		$query->set('post_type', array('post', 'taxonomy'  => 'category'));
	endif;
	return $query;
}
add_filter('pre_get_posts', 'SearchFilter');

/*
 * Empty Search
*/
function empty_search_redirect( $wp_query ) {
	if ( $wp_query->is_main_query() && $wp_query->is_search && ! $wp_query->is_admin ) :
		$s = $wp_query->get( 's' );
		$s = trim( $s );
		if ( empty( $s ) ) :
			wp_safe_redirect( home_url('/') );
			exit;
		endif;
	endif;
}
add_action( 'parse_query', 'empty_search_redirect' );
?>