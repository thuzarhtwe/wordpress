<?php
/**
 * Adds fontawesome supports for the Customizer.
 *
 * @since SCM Test 1.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function fontawesome_customizer($wp_customize) {
	$default_widget_title_fontawesome = "f047";
	$default_widget_list_fontawesome = "f047";
	// Font-awesome icon of Widget Change Section
	$wp_customize->add_section( new WP_Customize_Section($wp_customize, 'fontawesome_section' , array(
	    'title'      => 'ウイジェットのFont-Awesome変更用',
	    'priority'   => 100,
	)));
	// Font-awesome icon of Widget Title
	$wp_customize->add_setting('themename_widget_title_fontawesome', array(
		'default'           => $default_widget_title_fontawesome,
		'wp-head-callback'  => 'scm_test_style',
		'transport'         => 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'themename_widget_title_fontawesome', array(
		'label'      => '※Font Awesomeサイト(https://fortawesome.github.io/Font-Awesome/icons/)からユニコードをここに入力してください。',
		'section'    => 'fontawesome_section',
		'description' => 'ウイジェットタイトル',
		'settings'   => 'themename_widget_title_fontawesome'
	)));
	// Font-awesome icon of Widget List
	$wp_customize->add_setting('themename_widget_list_fontawesome', array(
		'default'           => $default_widget_list_fontawesome,
		'wp-head-callback'  => 'scm_test_style',
		'transport'         => 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'themename_widget_list_fontawesome', array(
		'label'      => '',
		'section'    => 'fontawesome_section',
		'description' => 'ウイジェットリスト',
		'settings'   => 'themename_widget_list_fontawesome'
	)));
}
add_action('customize_register', 'fontawesome_customizer');

/**
 * Add postMessage support for site title and description for the Theme fontawesome Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme fontawesome Customizer object.
 */
function themename_customize_fontawesome_register( $wp_customize ) {
	$wp_customize->get_setting( 'themename_widget_title_fontawesome' )->transport = 'postMessage';
	$wp_customize->get_setting( 'themename_widget_list_fontawesome' )->transport = 'postMessage';
}
add_action( 'customize_register', 'themename_customize_fontawesome_register' );
?>