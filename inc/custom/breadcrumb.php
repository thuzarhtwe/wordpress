<?php
//breadcrumb
function the_breadcrumb() {
	$showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$delimiter = '&raquo;'; // delimiter between crumbs
	$fontawesome_post = new WP_Query(
							array(
								'posts_per_page' => 1,
								'post_status' => 'publish',
								'orderby' => 'date',
								'order' => 'DESC',
								'meta_query' => array(
									array(
										'key' => 'fa-home',
										'value' => '',
										'compare' => '!='
									)
								)
							)
						);
	$fontawesome_custom = array();
	if ($fontawesome_post->have_posts()) :
		while ( $fontawesome_post->have_posts() ) :
			$fontawesome_post->the_post();
			$fontawesome_custom = get_post_custom();
		endwhile;
	endif;
	wp_reset_postdata();
	if (array_key_exists("fa-home", $fontawesome_custom)) :
		$fa_home = $fontawesome_custom["fa-home"][0];
		if (preg_match("/^fa-/", $fa_home)) :
			$home = '<i class="fa ' . $fa_home . '" aria-hidden="true"></i>';
		else :
			$home = '<i class="fa">' . $fa_home . '</i>';
		endif;
	else :
		$home = '<i class="fa fa-home" aria-hidden="true"></i>';
	endif;
	$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
	$before = '<span class="current">'; // tag before the current crumb
	$after = '</span>'; // tag after the current crumb

	global $post;
	$homeLink = get_bloginfo('url');

	if (is_home() || is_front_page()) :
		if ($showOnHome == 1) : 
			echo '<div class="crumbs"><a href="' . $homeLink . '">' . $home . '</a></div>';
		endif;
	else :
		echo '<div class="crumbs"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';

		if ( is_category() ) :
			$thisCat = get_category(get_query_var('cat'), false);
			if ($thisCat->parent != 0) : 
				echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
			endif;
			echo $before . '「' . single_cat_title('', false) . '」カテゴリー内の記事' . $after;

		elseif ( is_search() ) :
			echo $before . '「' . get_search_query() . '」で検索した結果' . $after;

		elseif ( is_day() ) :
			echo '<a href="' . get_year_link(get_the_time('Y 1')) . '">' . get_the_time('Y') . '年</a> ' . $delimiter . ' ';
			echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
			echo $before . get_the_time('j') . '日' . $after;

		elseif ( is_month() ) :
			echo '<a href="' . get_year_link(get_the_time('Y 1')) . '">' . get_the_time('Y') . '年</a> ' . $delimiter . ' ';
			echo $before . get_the_time('F') . $after;

		elseif ( is_year() ) :
			echo $before . get_the_time('Y') . '年' . $after;

		elseif ( is_single() && !is_attachment() ) :
			if ( get_post_type() != 'post' ) :
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
				if ($showCurrent == 1) :
					echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
				endif;
			else :
				$cat = get_the_category(); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
				if ($showCurrent == 0) : 
					$cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
				endif;
				echo $cats;
				if ($showCurrent == 1) :
					echo $before . get_the_title() . $after;
				endif;
			endif;

		elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) :
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;

		elseif ( is_attachment() ) :
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
			if ($showCurrent == 1) :
				echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
			endif;

		elseif ( is_page() && !$post->post_parent ) :
			if ($showCurrent == 1) :
				echo $before . get_the_title() . $after;
			endif;

		elseif ( is_page() && $post->post_parent ) :
			$parent_id	= $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) :
				$page = get_page($parent_id);
				$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
				$parent_id	= $page->post_parent;
			endwhile;
			$breadcrumbs = array_reverse($breadcrumbs);
			for ($i = 0; $i < count($breadcrumbs); $i++) :
				echo $breadcrumbs[$i];
				if ($i != count($breadcrumbs)-1) echo ' ' . $delimiter . ' ';
			endfor;
			if ($showCurrent == 1) : 
				echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
			endif;

		elseif ( is_tag() ) :
			echo $before . '「' . single_tag_title('', false) . '」タグのついた記事' . $after;

		elseif ( is_author() ) :
			global $author;
			$userdata = get_userdata($author);
			echo $before . '「' . $userdata->display_name . '」による記事' .$after;

		elseif ( is_404() ) :
			echo $before . '404エラー' . $after;
		endif;

		if ( get_query_var('paged') ) :
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			echo get_query_var('paged') . 'ページ目';
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		endif;
		echo '</div>';
	endif;
} // end qt_custom_breadcrumbs()
?>