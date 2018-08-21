<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package scm_test
 */
?>
			</div><!-- .site-content -->
			<?php
				// Get Footer ID
				$idclass_post = new WP_Query(
									array(
										'posts_per_page' => 1,
										'post_status' => 'publish',
										'orderby' => 'date',
										'order' => 'DESC',
										'meta_query' => array(
											array(
												'key' => 'colophon',
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
			<footer id="<?php echo array_key_exists('colophon', $idclass_custom)? $idclass_custom['colophon'][0] : 'colophon'; ?>" class="site-footer" role="contentinfo">
				<!-- Display page top -->
				<div id="pagetop" class="pagetop">
					<a href="#"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>
				</div><!-- #pagetop -->

				<!-- Display footer widget(Optional) -->
				<div class="footer-widgets">
					<?php
						if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-widget')):
						endif;
					?>
				</div><!-- .footer-widget -->

				<!-- Display Footer Copyright -->
				<div class="site-info">
					<?php
						if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('copyright')):
						endif;
					?>
				</div><!-- .site-info -->
			</footer><!-- .site-footer -->
		</div><!-- .hfeed .site #page -->
		<?php wp_footer(); ?>
	</body>
</html>
