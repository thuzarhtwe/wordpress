<?php
/**
 * scm_test Theme Color Customizer.
 *
 * @package scm_test
 */
/**
 * Sets up the WordPress core custom header and custom background features.
 *
 * @since SCM Test 1.0
 *
 * @see scm_test_style()
 *
 * @uses scm_test_style()
 * @uses scm_test_admin_header_style()
 * @uses scm_test_admin_header_image()
 */
// $bg_image_path = get_template_directory_uri().'/src/images/background.gif';
function themename_custom_header_and_background() {
	$default_body_background_color   = "ffffff";
	$default_text_color              = "ff15c2";

	/**
	 * Filter the arguments used when adding 'custom-background' support in SCM Test.
	 *
	 * @since SCM Test 1.0
	 *
	 * @param array $args {
	 *     An array of custom-background support arguments.
	 *
	 *     @type string $default-color Default color of the background.
	 * }
	 */
	add_theme_support( 'custom-background', apply_filters( 'themename_custom_background_args', array(
		'default-color' => $default_body_background_color,
		'default-image' => $GLOBALS['bg_image_path'],
		'wp-head-callback'         => 'scm_test_style',
		'admin-preview-callback'   => 'scm_test_admin_background_image'
	) ) );

	/**
	 * Filter the arguments used when adding 'custom-header' support in SCM Test.
	 *
	 * @since SCM Test 1.0
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type string $default-text-color Default color of the header text.
	 *     @type int      $width            Width in pixels of the custom header image. Default 1200.
	 *     @type int      $height           Height in pixels of the custom header image. Default 280.
	 *     @type bool     $flex-height      Whether to allow flexible-height header images. Default true.
	 *     @type callable $wp-head-callback Callback function used to style the header image and text
	 *                                      displayed on the blog.
	 * }
	 */
	add_theme_support( 'custom-header', apply_filters( 'themename_custom_header_args', array(
		'default-image'            => '',
		'default-text-color'       => $default_text_color,
		'flex-height'              => true,
		'flex-width'               => true,
		'uploads'                  => true,
		'wp-head-callback'         => 'scm_test_style',
		'admin-head-callback'      => 'scm_test_admin_header_style',
		'admin-preview-callback'   => 'scm_test_admin_header_image'
	) ) );
}
add_action( 'after_setup_theme', 'themename_custom_header_and_background' );
function theme_customize_register( $wp_customize ) {
  $wp_customize->remove_section( 'header_image');
}
add_action( 'customize_register', 'theme_customize_register', 50 );
/**
 * Adds color supports for the Customizer.
 *
 * @since SCM Test 1.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function header_footer_color_customizer($wp_customize) {
	$default_theme_bgcolor1 = "#000000";
  $defaule_header_bgcolor = "#b3daff";
	$default_theme_hovercolor = "#ffffff";
	$default_widget_bgcolor = "#b3daff";
	$default_mainpost_bgcolor = "#f0f0f0";
	$default_popularpost_bgcolor ="#c3c3c3";
	$default_a_bgcolor = "#9e0c78";
	$default_readmore_bgcolor = "red";
	$default_text_color = "black";

	$wp_customize->add_setting('themename_theme_bgcolor1', array(
		'default'           => $default_theme_bgcolor1,
		'wp-head-callback'  => 'scm_test_style',
		'transport'         => 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'themename_theme_bgcolor1', array(
		'label'      => 'Theme bgcolor1',
		'section'    => 'colors',
		'settings'   => 'themename_theme_bgcolor1',
	)));
	$wp_customize->add_setting('themename_header_bgcolor', array(
		'default'           => $defaule_header_bgcolor,
		'wp-head-callback'  => 'scm_test_style',
		'transport'         => 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'themename_header_bgcolor', array(
		'label'      => 'Header bgcolor',
		'section'    => 'colors',
		'settings'   => 'themename_header_bgcolor',
	)));
	$wp_customize->add_setting('themename_theme_hovercolor', array(
		'default'           => $default_theme_hovercolor,
		'wp-head-callback'  => 'scm_test_style',
		'transport'         => 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'themename_theme_hovercolor', array(
		'label'      => 'Theme hovercolor',
		'section'    => 'colors',
		'settings'   => 'themename_theme_hovercolor',
	)));
	$wp_customize->add_setting('themename_widget_bgcolor', array(
		'default'           => $default_widget_bgcolor,
		'wp-head-callback'  => 'scm_test_style',
		'transport'         => 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'themename_widget_bgcolor', array(
		'label'      => 'Widget bgcolor',
		'section'    => 'colors',
		'settings'   => 'themename_widget_bgcolor',
	)));
	$wp_customize->add_setting('themename_mainpost_bgcolor', array(
		'default'           => $default_mainpost_bgcolor,
		'wp-head-callback'  => 'scm_test_style',
		'transport'         => 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'themename_mainpost_bgcolor', array(
		'label'      => 'Main Post bgcolor',
		'section'    => 'colors',
		'settings'   => 'themename_mainpost_bgcolor',
	)));
	$wp_customize->add_setting('themename_popularpost_bgcolor', array(
		'default'           => $default_popularpost_bgcolor,
		'wp-head-callback'  => 'scm_test_style',
		'transport'         => 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'themename_popularpost_bgcolor', array(
		'label'      => 'Popular bgcolor',
		'section'    => 'colors',
		'settings'   => 'themename_popularpost_bgcolor',
	)));
	$wp_customize->add_setting('themename_a_bgcolor', array(
		'default'           => $default_a_bgcolor,
		'wp-head-callback'  => 'scm_test_style',
		'transport'         => 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'themename_a_bgcolor', array(
		'label'      => 'A bgcolor',
		'section'    => 'colors',
		'settings'   => 'themename_a_bgcolor',
	)));
	$wp_customize->add_setting('themename_readmore_bgcolor', array(
		'default'           => $default_readmore_bgcolor,
		'wp-head-callback'  => 'scm_test_style',
		'transport'         => 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'themename_readmore_bgcolor', array(
		'label'      => 'ReadMore bgcolor',
		'section'    => 'colors',
		'settings'   => 'themename_readmore_bgcolor',
	)));
	$wp_customize->add_setting('themename_text_color', array(
		'default'           => $default_text_color,
		'wp-head-callback'  => 'scm_test_style',
		'transport'         => 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'themename_text_color', array(
		'label'      => 'Text color',
		'section'    => 'colors',
		'settings'   => 'themename_text_color',
	)));
}
add_action('customize_register', 'header_footer_color_customizer');

/**
 * Add postMessage support for site title and description for the Theme color Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme color Customizer object.
 */
function themename_customize_color_register( $wp_customize ) {
	$wp_customize->get_setting( 'themename_theme_bgcolor1' )->transport      = 'postMessage';
	$wp_customize->get_setting( 'themename_header_bgcolor' )->transport      = 'postMessage';
	$wp_customize->get_setting( 'themename_theme_hovercolor' )->transport      = 'postMessage';
	$wp_customize->get_setting( 'themename_widget_bgcolor' )->transport      = 'postMessage';
	$wp_customize->get_setting( 'themename_mainpost_bgcolor' )->transport      = 'postMessage';
	$wp_customize->get_setting( 'themename_popularpost_bgcolor' )->transport      = 'postMessage';
	$wp_customize->get_setting( 'themename_a_bgcolor' )->transport      = 'postMessage';
	$wp_customize->get_setting( 'themename_text_color' )->transport      = 'postMessage';
// 	$wp_customize->get_setting( 'themename_readmore_bgcolor' )->transport      = 'postMessage';
}
add_action( 'customize_register', 'themename_customize_color_register' );
?>
