<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.me/
 *
 * @package scm_test
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function scm_test_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'scm_test_infinite_scroll_render',
		'footer'    => 'wrapper',
	) );
} // end function scm_test_jetpack_setup
add_action( 'init', 'scm_test_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function scm_test_infinite_scroll_render() {
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/content', get_post_format() );
	endwhile;
} // end function scm_test_infinite_scroll_render
