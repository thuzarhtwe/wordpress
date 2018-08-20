<?php
/**
 *  functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package scm_test
 */

  // Displays the site logo
   if ( ! function_exists( 'themename_the_custom_logo' ) ) {
     /**
   	* Displays the optional custom logo.
   	*/
     function themename_the_custom_logo() {
   	 if ( function_exists( 'the_custom_logo' )  && ( get_theme_mod( 'themename_logo','' ) == '') ) {
   		the_custom_logo();
   	 }
     }
   }
 if ( ! function_exists( 'themename_render_header_image' ) ) :
 /**
  * Shows the small info text on top header part
  */
 function themename_render_header_image() {
 	if ( function_exists( 'the_custom_header_markup' ) ) {
 		do_action( 'themename_header_image_markup_render' );
 		the_custom_header_markup();
 	} else {
 		$header_image = get_header_image();
 		if( ! empty( $header_image ) ) {
 			if ( get_theme_mod( 'themename_header_image_link', 0 ) == 1 ) { ?>
 				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
 			<?php } ?>
 				<div class="header-image-wrap"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></div>
 			<?php if ( get_theme_mod( 'themename_header_image_link', 0 ) == 1 ) { ?>
 				</a>
 				<?php
 			}
 		}
 	}
 }
 endif;

if ( ! function_exists('_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function _setup() {
		//Add custom logo
		add_theme_support( 'custom-logo', array(
		'flex-width' => true,
		'flex-height' => true,
		));
		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 * Support for feature image
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(array(
			'primary' => esc_html__( 'メインメニュー', '' )
		));

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support('html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		));

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support('post-formats', array(
			'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
		));

		add_filter( "comments_open", "__return_false");
	}
endif; // _setup

add_action('after_setup_theme', '_setup');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');


// Post excerpt character limitation
function dynamic_excerpt() { // Variable excerpt length. Length is set in characters
	global $post;
	$text = $post->post_excerpt;
	if ('' == $text) :
		$text = apply_filters('the_content', get_the_content(''));
		$text = str_replace(']]>', ']]>', $text);
	endif;
	$text = strip_shortcodes($text); // optional, recommended
	$text = strip_tags($text); // use ' $text = strip_tags($text,'<p><a>'); ' if you want to keep some tags
	$length = 80;// define length
	if (!$text) :
		echo get_the_excerpt();
	elseif(mb_strlen(trim($text)) <= $length) :
		echo $text;
	elseif (get_post_gallery(get_the_ID(), false) && !get_the_excerpt()) :
		echo get_the_excerpt();
	else :
		echo mb_substr($text, 0 , $length).' [...]'; // Use this is if you want a unformatted text block
	endif;
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function _widgets_init() {
	register_sidebar(array(
		'name'          => 'サイドバー',
		'id'            => 'sidebar',
		'description'   => '任意のウィジェットを登録してください。',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>'
	));

	register_sidebar(array(
		'name'          => esc_html__( 'フッターメニュー', '' ),
		'id'            => 'footer-widget',
		'description'   => 'ここに「カスタムメニュー」ウィジェットを登録することで、任意のメニューツリーを複数表示することができます。',
		'before_widget' => '<div class="footer-widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>'
	));

	register_sidebar(array(
		'name'          => 'コピーライト',
		'id'            => 'copyright',
		'description'   => 'ここに「テキスト」ウィジェットを登録することで、コピーライトが表示できます。',
		'before_widget' =>'',
		'after_widget'  =>''
	));
}
add_action('widgets_init', '_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function _scripts() {
	// Load main stylesheet.
	wp_enqueue_style( 'scm_test-style', get_stylesheet_uri() );
	// Load font awesome css
	wp_enqueue_style( 'scm_test-font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css' );
	// Load seo form css
	wp_enqueue_style( 'admin_print_styles', get_template_directory_uri() . '/layouts/top-seo.css', array(), '20130115', true );
	// Load minified bundle js
	wp_enqueue_script( 'scm_test-script', get_template_directory_uri() . '/assets/script/bundle.min.js', array('jquery'), '', true);
	// Load navigation json_decode(json)
	wp_enqueue_script( 'scm_test-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

  wp_enqueue_script( 'scm_test-grid', get_template_directory_uri() . '/js/grid.js', array(), '20120206', true );

  wp_enqueue_script( 'scm_test-masonry', get_template_directory_uri() . '/js/masonry.js', array(), '20120206', true );
	// Helps with accessibility for keyboard
	wp_enqueue_script( 'scm_test-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	// Helps td to judge whether padding needs to be added or not depending on a tag inside of td.
	wp_enqueue_script( 'scm_test-td-padding', get_template_directory_uri() . '/src/js/td-padding.js', array(), '20120206', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', '_scripts' );

/**
 * Load Slider.
 */
require get_template_directory() . '/inc/slider/slider.php';

/**
 * Load Slider Post Type.
 */
require get_template_directory() . '/inc/slider/slider-post-type.php';


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Load  Breadcrumb file.
 */
require get_template_directory() . '/inc/custom/breadcrumb.php';

/**
 * Load  SEO file.
 */
require get_template_directory() . '/inc/custom/seo.php';

/**
 * Load  Header-ID file.
 */
require get_template_directory() . '/inc/custom/idClass.php';

/**
 * Load  Media Upload file.
 */
require get_template_directory() . '/inc/custom/mediaUpload.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
* Load Search Filter.
*/
require get_template_directory() . '/inc/custom/searchFilter.php';

/**
 * Load Jetpack compatibility file.
*/
require get_template_directory() . '/inc/jetpack.php';

/**
* Load Popular Posts.
*/
require get_template_directory() . '/inc/custom/popularPosts.php';

/**
* Load Search Filter.
*/
require get_template_directory() . '/inc/custom/relatedPosts.php';



/**
* Load  Customizer for Theme color.
*/
require get_template_directory() . '/inc/custom/customizer-themecolor.php';

/**
* Load  Customizer for Fontawesome.
*/
require get_template_directory() . '/inc/custom/customizer-fontawesome.php';

/**
* Load  Customizer for PopularPost header
*/
require get_template_directory() . '/inc/custom/customizer-popularPosts-header.php';

/**
* Load  Customizer for RelatedPost header
*/
require get_template_directory() . '/inc/custom/customizer-relatedPosts-header.php';


/**
* Load  Customizer for Custom Feature posts
*/
require get_template_directory() . '/inc/custom/custom-header.php';
