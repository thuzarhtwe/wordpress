<?php
/**
 * scm_test Theme Customizer.
 *
 * @package scm_test
 */

if ( ! function_exists( 'scm_test_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog
	 *
	 * @see scm_test_custom_header_setup().
	 */
	function scm_test_style() {
		// Theme color
		$header_text_color = get_header_textcolor();
		// $body_bg_image = get_background_image();
		$body_bg_color = get_background_color();
		$theme_bgcolor1 = get_theme_mod( 'themename_theme_bgcolor1' );
		$header_bgcolor = get_theme_mod( 'themename_header_bgcolor' );
		$theme_hovercolor = get_theme_mod( 'themename_theme_hovercolor' );
		$widget_bgcolor = get_theme_mod( 'themename_widget_bgcolor' );
		$mainpost_bgcolor = get_theme_mod( 'themename_mainpost_bgcolor' );
		$popularpost_bgcolor = get_theme_mod( 'themename_popularpost_bgcolor' );
		$a_bgcolor =get_theme_mod( 'themename_a_bgcolor' );
		$readmore_bgcolor = get_theme_mod( 'themename_readmore_bgcolor' );
		$text_color = get_theme_mod ( 'themename_text_color' );

		$widget_title_fontawesome = get_theme_mod( 'themename_widget_title_fontawesome' );
		$widget_list_fontawesome = get_theme_mod( 'themename_widget_list_fontawesome' );
		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
	 		// Has the text been hidden?
	 		if ( 'blank' === $header_text_color ) :
	 	?>
	 		.site-title,
	 		.site-description {
	 			position: absolute;
	 			clip: rect(1px, 1px, 1px, 1px);
	 		}
	 	<?php
	 		// If the user has set a custom color for the text use that.
	 		else :
	 	?>
	 		.site-title a,
	 		.site-description {
	 			color: #<?php echo esc_attr( $header_text_color ); ?>;
	 		}
	 	<?php endif; ?>
		body{
			background-color: #<?php echo esc_attr( $body_bg_color ); ?>;
		}
			.site-header{
				background-color: <?php echo esc_attr( $theme_bgcolor1 ); ?>;
			}
			.site-main-single .post .entry-content p,
			.site .site-content .content-area .site-main-archive .top-page .post .entry-summary,
			.site .site-content .content-area .site-main .entry-summary{
				color: <?php echo esc_attr( $text_color ); ?>;
			}
			.site .site-content .content-area .site-main-archive .top-page .post .read-more a:hover,
			.site .site-content .content-area .site-main .top-page .post .read-more a:hover{
				background-color: <?php echo esc_attr( $theme_bgcolor1 ); ?>;
			}
			.site .site-content .content-area .site-main .top-page .post .read-more a{
				color: <?php echo esc_attr( $theme_bgcolor1 ); ?>;
			}
			.main-navigation ul{
				background-color: <?php echo esc_attr( $theme_bgcolor1 ); ?>;
			}
			.main-navigation li{
				background-color: <?php echo esc_attr( $header_bgcolor ); ?>;
			}
			.widget_posts ul li a,
			.site .site-content .content-area .site-main .entry-header h2 a,
			.site .site-content .content-area .site-main-archive .top-page .post .entry-header h2 a,
			.site .site-content .content-area .site-main .entry-footer span a,
			.site .site-content .content-area .site-main-archive .top-page .post .entry-footer span a,
			.pagination .page-numbers,
			.widget-area a,
			.site-main-single a,
			.main-navigation a{
				color: <?php echo esc_attr( $a_bgcolor ); ?>;
			}
			.widget_posts h2{
				background-color: <?php echo esc_attr( $popularpost_bgcolor ); ?>;
			}
			.widget_posts ul li{
				background-color: <?php echo esc_attr( $popularpost_bgcolor ); ?>;
			}
			.site .site-content .content-area .site-main .error-404,
			.site .site-content .content-area .site-main-archive .top-page .post,
			.site .site-content .content-area .site-main-archive .no-results,
			.site .site-content .content-area .site-main .top-page .post,
			.site-main-single{
				background-color: <?php echo esc_attr( $mainpost_bgcolor ); ?>;
			}
			.site .site-content .content-area .site-main-archive .top-page .post .read-more a,
			.site .site-content .content-area .site-main .top-page .post .read-more a{
				background-color: <?php echo esc_attr( $readmore_bgcolor ); ?>;
			}
			.pagination .page-numbers.current, .pagination a.page-numbers:hover{
				background-color: <?php echo esc_attr( $readmore_bgcolor ); ?>;
			}
			.pagination .page-numbers.current, .pagination a.page-numbers:hover{
				color: <?php echo esc_attr( $theme_hovercolor ); ?>;
			}
			.widget{
					background-color: <?php echo esc_attr( $widget_bgcolor ); ?>;
			}
			.site .site-content .content-area .site-main-archive .top-page .post .read-more a:hover,
			.site .site-content .content-area .site-main .top-page .post .read-more a:hover{
				color: <?php echo esc_attr( $readmore_bgcolor ); ?>;
			}

			.header-menu ul li a:hover{
				background-color: <?php echo esc_attr( $theme_bgcolor1 ); ?>;
			}
			.main-navigation .current-menu-ancestor>a,.main-navigation .current-menu-item>a,.main-navigation .current_page_ancestor>a,.main-navigation .current_page_item>a{
				background-color: <?php echo esc_attr( $theme_bgcolor1 ); ?>;
			}
			.main-navigation .current-menu-ancestor>a,.main-navigation .current-menu-item>a,.main-navigation .current_page_ancestor>a,.main-navigation .current_page_item>a{
				color: <?php echo esc_attr( $theme_hovercolor ); ?>;
			}
			.header-menu ul li:hover{
				color: <?php echo esc_attr( $theme_bgcolor1 ); ?>;
			}
			.site-title a:hover{
				color: <?php echo esc_attr( $theme_bgcolor1 ); ?>;
			}
			.header-menu ul li a:hover,
			.site-branding .site-title a:hover{
					color: <?php echo esc_attr( $theme_hovercolor ); ?>;
			}
			.widget .widget-title::before {
				content: '\<?php echo esc_attr( $widget_title_fontawesome ); ?>';
			}
			.widget ul li::before {
				content: '\<?php echo esc_attr( $widget_list_fontawesome ); ?>';
			}
		</style>
		<?php
	}
endif; // scm_test_style

if ( ! function_exists( 'scm_test_admin_header_style' ) ) :
/**
	 * Styles the header image displayed on the Appearance > Header admin panel.
	 *
	 * @see scm_test_custom_header_setup().
	 */
	function scm_test_admin_header_style() {
	?>
		<style type="text/css">
			.appearance_page_custom-header #headimg {
				border: none;
			}
			#headimg h1,
			#desc {
			}
			#headimg h1 {
			}
			#headimg h1 a {
			}
			#desc {
			}
			#headimg img {
			}
		</style>
	<?php
	}
endif; // scm_test_admin_header_style

if ( ! function_exists( 'scm_test_admin_header_image' ) ) :
	/**
	 * Custom header image markup displayed on the Appearance > Header admin panel.
	 *
	 * @see scm_test_custom_header_setup().
	 */
	function scm_test_admin_header_image() {
	?>
		<div id="headimg">
			<h1 class="displaying-header-text">
				<a id="name" style="<?php echo esc_attr( 'color: #' . get_header_textcolor() ); ?>" onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
			</h1>
			<div class="displaying-header-text" id="desc" style="<?php echo esc_attr( 'color: #' . get_header_textcolor() ); ?>"><?php bloginfo( 'description' ); ?></div>
			<?php if ( get_header_image() ) : ?>
			<img src="<?php header_image(); ?>" alt="">
			<?php endif; ?>
		</div>
	<?php
	}
endif; // scm_test_admin_header_image

if ( ! function_exists( 'themename_get_option' ) ) :
	function themename_get_option( $themename_name, $themename_default = false ) {
	$themename_config = get_option( 'themename' );

	if ( ! isset( $themename_config ) ) :
		return $sthemename_default;
	else:
		$themename_options = $themename_config;
	endif;
	if ( isset( $themename_options[$themename_name] ) ):
		return $themename_options[$themename_name];
	else:
		return $themename_default;
	endif;
	}
	endif;

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function themename_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport                      = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport               = 'postMessage';
}
add_action( 'customize_register', 'themename_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function scm_test_customize_preview_js() {
	wp_enqueue_script( 'scm_test_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'scm_test_customize_preview_js' );
?>
