<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package scm_test
 */

if ( ! is_active_sidebar( 'sidebar' ) ) {
	return;
}
// Get sidebar id name
$idclass_post = new WP_Query(
					array(
						'posts_per_page' => 1,
						'post_status' => 'publish',
						'orderby' => 'date',
						'order' => 'DESC',
						'meta_query' => array(
							array(
								'key' => 'secondary',
								'value' => '',
								'compare' => '!='
							)
						)
					)
				);
$idclass_custom = array();
if ($idclass_post->have_posts()) :
	while ( $idclass_post->have_posts() ) :
		$idclass_post->the_post();
		$idclass_custom = get_post_custom();
	endwhile;
endif;
wp_reset_postdata();
?>
<aside id="<?php echo array_key_exists('secondary', $idclass_custom)? $idclass_custom['secondary'][0] : 'secondary'; ?>" class="widget-area" role="complementary">
	<?php
	wp_reset_postdata();
	dynamic_sidebar( 'sidebar' );
	?>
</aside><!-- .widget-area -->
