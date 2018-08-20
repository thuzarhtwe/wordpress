<?php
// Create Custom Post Type
function register_staff_posttype() {
    $label = array(
        'name'              => _x( 'スタッフ', 'post type general name' ),
        'singular_name'     => _x( 'スタッフ', 'post type singular name' ),
        'add_new'           => __( '新規追加' ),
        'add_new_item'      => __( '新規追加' ),
        'edit_item'         => __( 'スタッフ編集' ),
        'new_item'          => __( '新規スタッフ' ),
        'view_item'         => __( 'スタッフ表示' ),
        'search_items'      => __( 'スタッフ検索' ),
        'not_found'         => __( 'スタッフ' ),
        'not_found_in_trash'=> __( 'スタッフ' ),
        'parent_item_colon' => __( 'スタッフ' ),
        'menu_name'         => __( 'スタッフ' )
    );

    $taxonomies = array();

    $supports = array('title','editor','thumbnail');

    $post_type_args = array(
        'labels'            => $label,
        'singular_label'    => __('スタッフ'),
        'public'            => true,
        'show_ui'           => true,
        'publicly_queryable'=> true,
        'query_var'         => true,
        'capability_type'   => 'post',
        'has_archive'       => false,
        'hierarchical'      => false,
        'rewrite'           => array( 'slug' => 'staff'),
        'supports'          => $supports,
        'menu_position'     => 6, // Where it is in the menu. Change to 6 and it's below posts. 11 and it's below media, etc.
        'menu_icon'         => '',
        'taxonomies'        => $taxonomies
    );
    register_post_type('staff',$post_type_args);
}
add_action('init', 'register_staff_posttype');

function add_menu_icons_style() {
	echo '<style>
    #adminmenu #menu-posts-staff div.wp-menu-image::before {
		  content: "\f483";
	  }
	</style>';
}
add_action( 'admin_head', 'add_menu_icons_style' );
