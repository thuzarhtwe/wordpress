<?php
	function theme_staff_header_customizer($wp_customize) {
	$wp_customize->add_section('themename_staff_scheme', array(
		'title'    => 'スタッフリストのタイトル',
		'priority'   => 80,
	));
	// Page Title
	$wp_customize->add_setting('staff_header', array(
		'default' => 'スタッフリスト',
	));
	$wp_customize->add_control('staff_header', array(
		'label'   => 'スタッフリストのタイトル',
		'section' => 'themename_staff_scheme',
		'type'    => 'text',
	));
}
add_action('customize_register', 'theme_staff_header_customizer');
function the_custom_Staff() {
	echo '<h2>';
	echo  get_theme_mod( 'staff_header','スタッフリスト');
	echo '</h2>';
}
?>
