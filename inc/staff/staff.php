<?php
// Save data from meta box
add_action('save_post', 'wptuts_staff_2_save');
function wptuts_staff_2_save($post_id) {
  global $post;
  global $stafflink_2_metabox;

  // verify nonce
  if(isset($_POST['wptuts_stafflink_2_meta_box_nonce'])) {
    if (!wp_verify_nonce($_POST['wptuts_stafflink_2_meta_box_nonce'], basename(__FILE__))) {
      return $post_id;
    }
  }

  // check autosave
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return $post_id;
  }

  // check permissions
  if (isset($_POST['post_type'])) {
    if ('page' == $_POST['post_type']) {
      if (!current_user_can('edit_page', $post_id)) {
        return $post_id;
      }
    } elseif (!current_user_can('edit_post', $post_id)) {
      return $post_id;
    }
  }

  if (isset($stafflink_2_metabox['fields'])) {
    foreach ($stafflink_2_metabox['fields'] as $field) {

      $old = get_post_meta($post_id, $field['id'], true);
      $new = isset($_POST[$field['id']])? $_POST[$field['id']] : '';

      if ($new && $new != $old) {
        if($field['type'] == 'date') {
          $new = wptuts_format_date($new);
          update_post_meta($post_id, $field['id'], $new);
        } else {
          if(is_string($new)) {
            $new = $new;
          }
          update_post_meta($post_id, $field['id'], $new);
        }
      } elseif ('' == $new && $old) {
        delete_post_meta($post_id, $field['id'], $old);
      }
    }
  }
}
function wptuts_staff_template() {
  $staff = new WP_Query(
  array(
    'posts_per_page'    => 4,
    'post_type'         => 'staff',
  )
);
if ($staff->have_posts()): ?>
  <div class="staff">
    <?php the_custom_Staff(); ?>
    <ul>
      <?php
      while ( $staff->have_posts() ) : $staff->the_post();
      ?>
      <?php
      if ( get_post_meta( get_the_id(), 'wptuts_staffurl', true) != '' ) { ?>
        <a href="<?php echo esc_url( get_post_meta( get_the_id(), 'wptuts_staffurl', true) ); ?>">
        <?php }?>
      <li>
        <div class="title">
          <a href="<?php the_permalink();?>">
            <?php echo mb_strimwidth(get_the_title(), 0, 55, '...'); ?>
          </a>
        </div>
        <a href="<?php the_permalink(); ?>" rel="bookmark">
          <?php
            if(has_post_thumbnail()):
              the_post_thumbnail();
            endif;
          ?>
        </a>
          <div class="summary">
            <?php dynamic_excerpt(100);?>
          </div>
      </li>
    <?php endwhile; ?>
  </ul><!-- .slides -->
</div>
<?php
endif;
wp_reset_postdata();
} ?>
