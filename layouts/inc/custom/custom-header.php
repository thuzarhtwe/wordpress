<?php
function theme_header_customizer($wp_customize) {
	// Start of the Header Options
 $wp_customize->add_panel('themename_header_options', array(
		'capabitity' => 'edit_theme_options',
		'description' => __('Change the Header Settings from here as you want.', 'themename'),
		'priority' => 30,
		'title' => __('ロゴオプション', 'themename')
 ));

 // logo upload options
 $wp_customize->add_section('themename_header_logo', array(
		'priority' => 1,
		'title' => __('ヘッダーロゴ', 'themename'),
		'panel' => 'themename_header_options'
 ));

if ( ! function_exists('the_custom_logo') ) {

	$wp_customize->add_setting('themename_logo', array(
		'default' => '',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw'
	));

	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'themename_logo', array(
		'label' => __('Upload logo for your header here.', 'themename'),
		'section' => 'themename_header_logo',
		'setting' => 'themename_logo'
	)));
}

 $wp_customize->add_setting('themename_header_logo_placement', array(
		'default' => 'header_text_only',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'themename_radio_select_sanitize'
 ));

 $wp_customize->add_control('themename_header_logo_placement', array(
		'type' => 'radio',
		'label' => __('ロゴ表示を下記により選択してください。', 'themename'),
		'section' => 'themename_header_logo',
		'choices' => array(
			 'header_logo_only' => __('ヘッダーロゴのみ', 'themename'),
			 'header_text_only' => __('ヘッダータイトルのみ', 'themename'),
			 'show_both' => __('両方表示', 'themename'),
			 'disable' => __('両方非表示', 'themename')
		)
 ));
}
add_action('customize_register', 'theme_header_customizer');
function themename_radio_select_sanitize( $input, $setting ) {
		 // Ensuring that the input is a slug.
		 $input = sanitize_key( $input );
		 // Get the list of choices from the control associated with the setting.
		 $choices = $setting->manager->get_control( $setting->id )->choices;
		 // If the input is a valid key, return it, else, return the default.
		 return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
?>
