<?php
function wpb_get_post_views($postID) {
    $count_key = 'popular_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count=='') :
        delete_post_meta($postID, $count_key, true);
        add_post_meta($postID, $count_key, '0', true);
         return "0 view";
    elseif ($count=='1') :
    	 return "1 view";
    endif;
    return $count.' views';
}

function wpb_set_post_views($postID) {
    $count_key = 'popular_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count=='') :
        $count = 0;
        delete_post_meta($postID, $count_key, true);
        add_post_meta($postID, $count_key, '1', true);
    else :
        $count++;
        update_post_meta($postID, $count_key, $count);
    endif;
}

//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

// Popular Posts Block
function popularPosts() {
    $popularpost = new WP_Query(
                      array(
                      	'posts_per_page'      => 8,
                      	'post_status'	        => 'publish',
                      	'post_type'		        => 'post',
                      	'meta_key' 	          => 'popular_post_views_count',
                      	'orderby'		          => 'meta_value_num',
                      	'order' 	            => 'DESC',
                      	'ignore_sticky_posts' => true
                  	  )
                    );

    if ($popularpost->have_posts()) :
      	echo '<aside class="widget_posts">';
      	echo the_custom_popularPost();
      	echo '<ul>';
        while ( $popularpost->have_posts() ) : $popularpost->the_post();
        	  echo '<li>';
        		  echo '<a href="';
        		    the_permalink();
        		  echo '">';
              echo '<div class="entry-thumbnail">';
              if (has_post_thumbnail()):
                the_post_thumbnail();
              else :
                the_dummy_thumbnail();
              endif;
              echo '</div>';
                echo '<p>';
                echo mb_strimwidth(get_the_title(),'0','60','...');
                echo '</p>';
              echo '</a>';
              echo '<span class="view-counts">'.wpb_get_post_views(get_the_id()).'</span>';
            echo '</li>';
    		endwhile;
		    echo '</ul>';
	      echo "</aside>";
    endif;
}
?>
