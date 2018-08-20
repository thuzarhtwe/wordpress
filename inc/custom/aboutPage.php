<?php
function theme_about_page_customizer($wp_customize) {
	$wp_customize->add_section('scm_test_about_scheme', array(
		'title'    => 'このサイトについて'
	));
	// Page Title
	$wp_customize->add_setting('about_title', array(
		'default' => 'このサイトについて',
	));
	$wp_customize->add_control('about_title', array(
		'label'   => 'ここで、ページタイトルについて',
		'section' => 'scm_test_about_scheme',
		'type'    => 'text',
	));

	// Page Image
	$wp_customize->add_setting('about_image_upload', array(
		'default'        => $GLOBALS['about_image'],
		'capability'     => 'edit_theme_options',
		'type'           => 'theme_mod'
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'about_image_upload', array(
		'label'    => __('ダミー画像アップロード', get_bloginfo('name')),
		'section'  => 'scm_test_about_scheme',
		'settings' => 'about_image_upload'
	)));

	// Excerpt
	$wp_customize->add_setting('about_excerpt', array(
		'default' => 'これはデフォルトで最初に挿入される固定ページです。サイトの説明を記載する等の用途にお使いください。スラッグは「page_about」固定ですが、ページのタイトルは自由に変更可能です。本固定ページのサムネイルとして設定した画像がトップページの本投稿箇所の背景画像になります',
	));
	$wp_customize->add_control('about_excerpt', array(
		'label'   => 'ここではページの抜粋について',
		'section' => 'scm_test_about_scheme',
		'type'    => 'textarea',
	));
}
add_action('customize_register', 'theme_about_page_customizer');

function the_custom_about() {
	echo '<aside class="about">';
	if( get_theme_mod( 'about_image_upload', $GLOBALS['about_image'] ) ) :
		echo '<img src="';
		echo get_theme_mod( 'about_image_upload' , $GLOBALS['about_image'] );
		echo '" alt="';
		echo esc_attr( get_bloginfo( 'name', 'display' ) );
		echo '">';
	else :
		echo '<img src="';
		echo $GLOBALS['image_path'];
		echo '">';
	endif;
	echo '<div class="about-excerpt">';
	echo '<h3>';
	echo  get_theme_mod( 'about_title','このサイトについて');
	echo '</h3><p>';
	echo  get_theme_mod( 'about_excerpt','これはデフォルトで最初に挿入される固定ページです。サイトの説明を記載する等の用途にお使いください。スラッグは「page_about」固定ですが、ページのタイトルは自由に変更可能です。本固定ページのサムネイルとして設定した画像がトップページの本投稿箇所の背景画像になります' );
	echo '</p></div>';
	echo '</aside>';
}
?>