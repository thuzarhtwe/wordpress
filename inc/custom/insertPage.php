<?php

/** Register default page **/
function insert_page() {

  $my_post = array(
    'post_name'     => 'about',
    'post_title'    => 'このサイトについて',
    'post_content'  => 'これはデフォルトで最初に挿入される固定ページです。サイトの説明を記載する等の用途にお使いください。スラッグは「about」固定ですが、ページのタイトルは自由に変更可能です。本固定ページのサムネイルとして設定した画像が本ウィジェットの背景画像になります。',
    'post_status'   => 'publish',
    'post_type'     => 'page'
  );

  // Check duplication
  $about_query = new WP_Query( array(
    'post_type' => 'page',
    'pagename' => 'about'
  ));
  $about_wild_query = new WP_Query( array(
    'post_type' => 'page',
    'orderby' => 'date',
    'order' => 'DESC',
    'posts_per_page' => -1,
    'nopaging' => true
  ));

  if ($about_query->have_posts()) :
    return;
  else :
    if ($about_wild_query->have_posts()) :
      $wild_count = 0;
      $total_count = $about_wild_query->found_posts;
      for ($wild_count = 0; $wild_count < $total_count; $wild_count++) :
        $slug = $about_wild_query->posts[$wild_count]->post_name;
        $word_to_compare = substr($slug, 0, mb_strlen('about'));
        if ($word_to_compare === 'about') :
          return;
        endif;
      endfor;
    endif;
    wp_insert_post($my_post);
  endif;
}
add_action( 'after_setup_theme', 'insert_page' );
function the_insert_page(){ 
  $about_query = new WP_Query( array(
    'post_type'   => 'page',
    'post_status' => 'publish',
    'pagename'    => 'about'
  ) );
  if ($about_query->have_posts()):
    while ($about_query->have_posts()): 
      $about_query->the_post();
      if (has_post_thumbnail( $post->ID ) ):
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
      endif;   
      echo '<div class="insert-page">';
      if (has_post_thumbnail()):
          the_post_thumbnail();
      else :
          the_dummy_thumbnail();
      endif;
    
      echo '<div class="about-description">';
      echo '<h3 class="about-title">';
      echo '<a href="';
      the_permalink();
      echo '">';
      echo mb_strimwidth(get_the_title(), 0, 74, '...');
      echo '</a>';
      echo '</h3>';
      echo '<div class="about-summary">';
      echo '<p>';
      echo dynamic_excerpt();
      echo '</p>';
      echo '</div>';
      echo '</div>';
      echo '<div class="read-more">';
      echo '<a href="';
      the_permalink();
      echo '">';
      echo 'もっと見る';
      echo '</a>';
      echo '</div>';
      echo '</div>';
    endwhile;
  endif;
}
?>