<?php
/*
 * Enable support for SEO Information.
 */
function add_custom_fields() {
	add_meta_box( 'my_sectionid', 'SEO情報', 'my_custom_fields', 'post', 'normal', 'high');
	add_meta_box( 'my_sectionid', 'SEO情報', 'my_custom_fields', 'page', 'normal', 'high');
}

// 各投稿・固定ページにSEO情報メタボックスを挿入
function my_custom_fields() {
	global $post;
	$meta_keywords = '';
	$meta_description = '';
	// アドレスバーに数字が含まれていたら既存投稿の編集
	if (preg_match("/[0-9]/", $_SERVER['REQUEST_URI'])) :
		$meta_keywords = get_post_meta($post->ID,'meta_keywords',true);
		$meta_description = get_post_meta($post->ID,'meta_description',true);
	endif;
	// 全投稿に設定しているグローバルメタ情報を取得するため、最新の1件だけを取得
	if (isset($post) && $post !== '') :
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
			endwhile;
		endif;
		$global_meta_keywords = array_key_exists('global_meta_keywords', $global_custom)? $global_custom['global_meta_keywords'][0]: '';
		$global_meta_description = array_key_exists('global_meta_description', $global_custom)? $global_custom['global_meta_description'][0]: '';
	endif;

	// 設定済みのグローバルメタ情報を上書き削除しないように、全投稿を検索
	if (!isset($global_meta_keywords)) :
		$allpost = new WP_Query( array(
						'posts_per_page' => 1,
						'post_status' => 'publish',
						'orderby' => 'date',
						'order' => 'DESC',
						'meta_query' => array(
							array(
								'key' => 'global_meta_keywords',
								'value' => '',
								'compare' => '!='
							)
						)
					) );
		if ($allpost->have_posts()) :
			while ( $allpost->have_posts() ) :
				$allpost->the_post();
				$custom = get_post_custom();
				$global_meta_keywords = array_key_exists('global_meta_keywords', $custom) ? $custom['global_meta_keywords'][0] : '';
				$global_meta_description = array_key_exists('global_meta_description', $custom) ? $custom['global_meta_description'][0] : '';
			endwhile;
		endif;
		wp_reset_postdata();
	endif;
	if (!isset($global_meta_description)) :
		$allpost = new WP_Query( array(
						'posts_per_page' => 1,
						'post_status' => 'publish',
						'orderby' => 'date',
						'order' => 'DESC',
						'meta_query' => array(
							array(
								'key' => 'global_meta_description',
								'value' => '',
								'compare' => '!='
							)
						)
					) );
		if ($allpost->have_posts()) :
			while ( $allpost->have_posts() ) :
				$allpost->the_post();
				$custom = get_post_custom();
				$global_meta_description = array_key_exists('global_meta_description', $custom) ? $custom['global_meta_description'][0] : '';
			endwhile;
		endif;
		wp_reset_postdata();
	endif;
	echo '<p>キーワード（meta keyword） ※複数入れる場合はカンマ（,）区切り。<br />';
	echo '<input type="text" name="meta_keywords" value="'.esc_html($meta_keywords).'" maxlength="160" size="80" style="max-width: 100%;" /></p>';
	echo '<input type="hidden" name="global_meta_keywords" value="'.esc_html($global_meta_keywords).'" style="max-width: 100%;" />';
	echo '<p>概要（meta description） ※全角64文字程度を推奨。160文字以内。<br />';
	echo '<textarea name="meta_description" maxlength="160" cols="80" rows="3" style="max-width: 100%;" >'.esc_html($meta_description).'</textarea></p>';
	echo '<input type="hidden" name="global_meta_description" value="'.esc_html($global_meta_description).'" />';
}

// 各投稿・固定ページの公開・更新時にSEO情報メタボックスの情報を更新
function save_custom_fields( $post_id ) {
	if(isset($_POST['global_meta_keywords']) && $_POST['global_meta_keywords'] !== '') :
		update_post_meta($post_id, 'global_meta_keywords', $_POST['global_meta_keywords'] );
	endif;
	if(isset($_POST['meta_keywords'])) :
		update_post_meta($post_id, 'meta_keywords', $_POST['meta_keywords'] );
	elseif (!get_post_meta($post_id,'meta_keywords',true)) :
		delete_post_meta($post_id, 'meta_keywords');
	endif;
	if(isset($_POST['global_meta_description']) && $_POST['global_meta_description'] !== '') :
		update_post_meta($post_id, 'global_meta_description', $_POST['global_meta_description'] );
	endif;
	if(isset($_POST['meta_description'])) :
		update_post_meta($post_id, 'meta_description', $_POST['meta_description'] );
	elseif (!get_post_meta($post_id,'meta_description',true)) :
		delete_post_meta($post_id, 'meta_description');
	endif;
}

add_action('admin_menu', 'add_custom_fields');
add_action('save_post', 'save_custom_fields');

// ダッシュボードトップのSEO情報メタボックスの「保存」ボタン押下時に、jQueryによるAjax通信でphpを呼び出す
function add_my_ajaxurl() {
?>
	<script>
		var ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
	</script>
<?php
}
add_action( 'wp_head', 'add_my_ajaxurl', 1 );

// ダッシュボードトップにSEO情報メタボックスを追加
function topseo_add_custom_box() {
	add_meta_box('my_meta_id', 'SEO情報', 'topseo_inner_custom_box', 'dashboard', 'normal', 'high', 'topseo_save_postdata');
}

// ダッシュボードトップに追加するSEO情報メタボックスの初期設定
function topseo_inner_custom_box() {
	global $post;
	$global_meta_keywords = '';
	$global_meta_description = '';
	if (isset($post) && $post !== '') :
		$global_meta_keywords = get_post_meta($post->ID, 'global_meta_keywords', true);
		$global_meta_description = get_post_meta($post->ID, 'global_meta_description', true);
	endif;
	// global_meta_keywordsメタ情報が""(空)ではない投稿を検索して値を取得
	$key_allpost = new WP_Query( array(
						'posts_per_page' => 1,
						'post_status' => 'publish',
						'orderby' => 'date',
						'order' => 'DESC',
						'meta_query' => array(
							array(
								'key' => 'global_meta_keywords',
								'value' => '',
								'compare' => '!='
							)
						)
					) );
	if ($key_allpost->have_posts()) :
		while ( $key_allpost->have_posts() ) :
			$key_allpost->the_post();
			$key_custom = get_post_custom();
			if (isset($key_custom) && $key_custom !== '') {
				$global_meta_keywords = array_key_exists('global_meta_keywords', $key_custom) ? $key_custom['global_meta_keywords'][0] : '';
			}
		endwhile;
	endif;
	wp_reset_postdata();

	// global_meta_descriptionメタ情報が""(空)ではない投稿を検索して値を取得
	$desc_allpost = new WP_Query( array(
						'posts_per_page' => 1,
						'post_status' => 'publish',
						'orderby' => 'date',
						'order' => 'DESC',
						'meta_query' => array(
							array(
								'key' => 'global_meta_description',
								'value' => '',
								'compare' => '!='
							)
						)
					) );
	if ($desc_allpost->have_posts()) :
		while ( $desc_allpost->have_posts() ) :
			$desc_allpost->the_post();
			$desc_custom = get_post_custom();
			if (isset($desc_custom) && $desc_custom !== '') {
				$global_meta_description = array_key_exists('global_meta_description', $desc_custom) ? $desc_custom['global_meta_description'][0] : '';
			}
		endwhile;
	endif;
	wp_reset_postdata();

	$direc = get_bloginfo('template_directory');
	wp_enqueue_script('admin_print_styles', $direc . '/js/top-seo.js');
	echo '<p>キーワード（meta keyword） ※複数入れる場合はカンマ（,）区切り。<br />';
	echo '<input id="seo-keywords" type="text" name="global_meta_keywords" value="'.esc_html($global_meta_keywords).'" maxlength="160" size="60" style="max-width: 100%;" /></p>';
	echo '<p>概要（meta description） ※全角64文字程度を推奨。160文字以内。<br />';
	echo '<textarea id="seo-description" name="global_meta_description" maxlength="160" cols="60" rows="3" style="max-width: 100%;" >'.esc_html($global_meta_description).'</textarea></p>';
	echo '<input id="seo-submit" class="button button-primary button-large button-seo" type="submit" value="保存" name="publish" />';
}

// 最新の投稿1件を取得し、グローバルメタ情報を設定して更新
function topseo_save_postdata($post_id) {
	$allpost = new WP_Query( array(
					'posts_per_page' => 1,
					'post_status' => 'publish',
					'orderby' => 'date',
					'order' => 'DESC'
				) );
	if ($allpost->have_posts()) :
		while ( $allpost->have_posts() ) :
			$allpost->the_post();
			$seo_postID = $allpost->posts[0]->ID;
			add_post_meta($seo_postID, 'global_meta_keywords', '0', true);
			add_post_meta($seo_postID, 'global_meta_description', '0', true);
			if(isset($_POST['meta_keywords']) && $_POST['meta_keywords'] !== '') :
				update_post_meta($seo_postID, 'global_meta_keywords', $_POST['meta_keywords'] );
			else :
				delete_post_meta($seo_postID, 'global_meta_keywords');
			endif;
			if(isset($_POST['meta_description']) && $_POST['meta_description'] !== '') :
				update_post_meta($seo_postID, 'global_meta_description', $_POST['meta_description'] );
			else :
				delete_post_meta($seo_postID, 'global_meta_description');
			endif;
		endwhile;
	endif;
	wp_reset_postdata();
}

add_action('admin_menu', 'topseo_add_custom_box');
add_action('wp_ajax_topseo_save_postdata', 'topseo_save_postdata');
add_action('wp_ajax_nopriv_topseo_save_postdata', 'topseo_save_postdata' );
?>