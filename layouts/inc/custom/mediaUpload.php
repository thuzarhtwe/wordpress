<?php

add_action('customize_register', 'dummy_image_customizer');
$image_path = get_template_directory_uri().'/src/images/thumbnail.png';
function dummy_image_customizer($wp_customize) {

  $wp_customize->add_section('themename_dummy_photo_scheme', array(
    'title'    => 'ダミー画像アップロード'
    ));
  $wp_customize->add_setting('dummy_image_upload', array(
    'default'        => $GLOBALS['image_path'],
    'capability'     => 'edit_theme_options',
    'type'            => 'theme_mod'
    ));
  $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'dummy_image_upload', array(
    'label'    => __('ダミー画像アップロード', get_bloginfo('name')),
    'section'  => 'themename_dummy_photo_scheme',
    'settings' => 'dummy_image_upload'
    )));
}
function the_dummy_thumbnail() {
 $dummy_image_path = $GLOBALS['image_path'];
 if( get_theme_mod( 'dummy_image_upload' ) ) :
  $dummy_image_path = get_theme_mod( 'dummy_image_upload' );
 endif;
 echo '<img src="';
 echo $dummy_image_path;
 echo '" alt="';
 echo esc_attr( get_bloginfo( 'name', 'display' ) );
 echo '">';
}
?>
