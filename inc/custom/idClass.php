<?php
/*
 * Enable support for ID-Class Information.
 */
function save_custom_header_fields( $post_id ) {
	if(isset($_POST['masthead']) && $_POST['masthead'] !== '') :
		update_post_meta($post_id, 'masthead', $_POST['masthead'] );
	else :
		delete_post_meta($post_id, 'masthead');
	endif;
	if(isset($_POST['colophon']) && $_POST['colophon'] !== '') :
		update_post_meta($post_id, 'colophon', $_POST['colophon'] );
	else :
		delete_post_meta($post_id, 'colophon');
	endif;
	if(isset($_POST['secondary']) && $_POST['secondary'] !== '') :
		update_post_meta($post_id, 'secondary', $_POST['secondary'] );
	else :
		delete_post_meta($post_id, 'secondary');
	endif;
}

add_action('admin_menu', 'add_custom_fields');
add_action('save_post', 'save_custom_header_fields');

//Add SEO meta box at dashboard front pages
function add_idclass_ajaxurl() {
?>
	<script>
		var ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
	</script>
<?php
}
add_action( 'wp_head', 'add_idclass_ajaxurl', 1 );

function header_add_custom_box() {
	add_meta_box('header_meta_id', 'ID・クラス変更用', 'header_inner_custom_box', 'dashboard', 'normal', 'high', 'header_save_postdata');
}

function header_inner_custom_box() {
	$masthead = '';
	$colophon = '';
	$secondary = '';
	if (isset($post) && $post !== '') :
		$masthead = get_post_meta($post->ID, 'masthead', true);
		$colophon = get_post_meta($post->ID, 'colophon', true);
		$secondary = get_post_meta($post->ID, 'secondary', true);
	endif;
	$allpost = new WP_Query( array(
		'posts_per_page' => 1,
		'post_status' => 'publish',
		'orderby' => 'date',
		'order' => 'DESC'
	) );
	if ($allpost->have_posts()) :
		while ( $allpost->have_posts() ) :
			$allpost->the_post();
			$global_custom = get_post_custom();
			$masthead = array_key_exists('masthead', $global_custom) ? $global_custom['masthead'][0] : '';
			$colophon = array_key_exists('colophon', $global_custom) ? $global_custom['colophon'][0] : '';
			$secondary = array_key_exists('secondary', $global_custom) ? $global_custom['secondary'][0] : '';
		endwhile;
	endif;
	$direc = get_bloginfo('template_directory');
	wp_enqueue_script('id_class_scripts', $direc . '/js/id-class.js');
	echo '<pre style="background-color: rgb(238, 238, 238);padding: 5px;box-sizing: border-box;box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.09) inset;">';
	echo 'ヘッダー（header.php）<br />';
	echo ' &lt;header id="※※※①※※※" class="site-header" role="banner"&gt;<br />';
	echo 'サイドバー（sidebar.php）<br />';
	echo ' &lt;div id="※※※②※※※" class="widget-area" role="complementary"&gt;<br />';
	echo 'フッター（footer.php）<br />';
	echo ' &lt;div id="※※※③※※※" class="site-footer" role="contentinfo"&gt;<br />';
	echo '</pre>';
	echo '<hr />';
	echo '<p>①ヘッダー部ID（masthead） ※複数入れる場合は半角スペース（ ）区切り。<br />';
	echo '<input id="id-masthead" type="text" name="masthead" value="'.esc_html($masthead).'" maxlength="160" size="60" style="max-width: 100%;" /></p>';
	echo '<p>②サイドバー部ID（secondary） ※複数入れる場合は半角スペース（ ）区切り。<br />';
	echo '<input id="id-secondary" type="text" name="secondary" value="'.esc_html($secondary).'" maxlength="160" size="60" style="max-width: 100%;" /></p>';
	echo '<p>③フッター部ID（colophon） ※複数入れる場合は半角スペース（ ）区切り。<br />';
	echo '<input id="id-colophon" type="text" name="colophon" value="'.esc_html($colophon).'" maxlength="160" size="60" style="max-width: 100%;" /></p>';
	echo '<input id="id-submit" class="button button-primary button-large button-id" type="submit" value="保存" name="publish" />';
}

function header_save_postdata($post_id) {
	$allpost = new WP_Query( array(
					'posts_per_page' => 1,
					'post_status' => 'publish',
					'orderby' => 'date',
					'order' => 'DESC'
				) );
	if ($allpost->have_posts()) :
		while ( $allpost->have_posts() ) :
			$allpost->the_post();
			$header_postID = $allpost->posts[0]->ID;
			add_post_meta($header_postID, 'masthead', '0', true);
			add_post_meta($header_postID, 'colophon', '0', true);
			add_post_meta($header_postID, 'secondary', '0', true);
			if(isset($_POST['ajax_masthead']) && $_POST['ajax_masthead'] !== '') :
				update_post_meta($header_postID, 'masthead', $_POST['ajax_masthead'] );
			else :
				delete_post_meta($header_postID, 'masthead');
			endif;
			if(isset($_POST['ajax_colophon']) && $_POST['ajax_colophon'] !== '') :
				update_post_meta($header_postID, 'colophon', $_POST['ajax_colophon'] );
			else :
				delete_post_meta($header_postID, 'colophon');
			endif;
			if(isset($_POST['ajax_secondary']) && $_POST['ajax_secondary'] !== '') :
				update_post_meta($header_postID, 'secondary', $_POST['ajax_secondary'] );
			else :
				delete_post_meta($header_postID, 'secondary');
			endif;
		endwhile;
	endif;
}

add_action('admin_menu', 'header_add_custom_box');
add_action('wp_ajax_header_save_postdata', 'header_save_postdata');
add_action('wp_ajax_nopriv_header_save_postdata', 'header_save_postdata' );
?>
