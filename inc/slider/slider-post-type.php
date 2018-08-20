<?php

// Enqueue Flexslider Files
function wptuts_jquery_scripts() {
    wp_enqueue_script( 'jquery' );
}
add_action( 'wp_enqueue_scripts', 'wptuts_jquery_scripts' );

// Create Custom Post Type
function register_slides_posttype() {
    $labels = array(
        'name'              => _x( 'スライダー画像', 'post type general name' ),
        'singular_name'     => _x( 'スライダー画像', 'post type singular name' ),
        'add_new'           => __( 'スライダー画像を追加' ),
        'add_new_item'      => __( 'スライダー画像を追加' ),
        'edit_item'         => __( 'スライダー画像を編集' ),
        'new_item'          => __( '新規スライダー画像' ),
        'view_item'         => __( 'スライダー画像を見る' ),
        'search_items'      => __( 'スライダー画像を検索する' ),
        'not_found'         => __( 'スライダー画像' ),
        'not_found_in_trash'=> __( 'スライダー画像' ),
        'parent_item_colon' => __( 'スライダー画像' ),
        'menu_name'         => __( 'スライダー画像' )
    );

    $taxonomies = array();

    $supports = array('title','thumbnail');

    $post_type_args = array(
        'labels'            => $labels,
        'singular_label'    => __('Slide'),
        'public'            => true,
        'show_ui'           => true,
        'publicly_queryable'=> true,
        'query_var'         => true,
        'capability_type'   => 'post',
        'has_archive'       => false,
        'hierarchical'      => false,
        'rewrite'           => array( 'slug' => 'slides', 'with_front' => false ),
        'supports'          => $supports,
        'menu_position'     => 6, // Where it is in the menu. Change to 6 and it's below posts. 11 and it's below media, etc.
        'menu_icon'         => '',
        'taxonomies'        => $taxonomies
    );
    register_post_type('slides', $post_type_args);
}
add_action('init', 'register_slides_posttype');

// Add icon in admin menu slider
function add_menu_icons_styles() {
	echo '<style>
        #adminmenu #menu-posts-slides div.wp-menu-image:before {
    		  content: "\f233";
    	  }
	</style>';
}
add_action( 'admin_head', 'add_menu_icons_styles' );
