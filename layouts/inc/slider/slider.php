<?php

// Enqueue Flexslider Files
function wptuts_slider_scripts() {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_style( 'flex-style', get_template_directory_uri() . '/inc/slider/css/flexslider.css' );
    wp_enqueue_script( 'flex-script', get_template_directory_uri() .  '/inc/slider/js/jquery.flexslider-min.js', array( 'jquery' ), false, true );
}
add_action( 'wp_enqueue_scripts', 'wptuts_slider_scripts' );

// Initialize Slider
function wptuts_slider_initialize() { ?>
    <script type="text/javascript" charset="utf-8">
      jQuery(document).ready(function($){
        $(document).ready(function() {
          if ($('.flexslider').size() > 0 ) {
            $('.flexslider').flexslider({
              animation: "fade",
              direction: "horizontal",
              slideshowSpeed: 7000,
              animationSpeed: 600
            });
          }
        });
      });
    </script>
<?php
}
add_action( 'wp_head', 'wptuts_slider_initialize' );

// Save data from meta box
function wptuts_slidelink_2_save($post_id) {
    global $post;
    global $slidelink_2_metabox;

    // verify nonce
    if(isset($_POST['wptuts_slidelink_2_meta_box_nonce'])) :
        if (!wp_verify_nonce($_POST['wptuts_slidelink_2_meta_box_nonce'], basename(__FILE__))) :
            return $post_id;
        endif;
    endif;

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) :
        return $post_id;
    endif;

    // check permissions
    if (isset($_POST['post_type'])) :
        if ('page' == $_POST['post_type']) :
            if (!current_user_can('edit_page', $post_id)) :
                return $post_id;
            endif;
        elseif (!current_user_can('edit_post', $post_id)) :
            return $post_id;
        endif;
    endif;

    if (isset($slidelink_2_metabox['fields'])) :
        foreach ($slidelink_2_metabox['fields'] as $field) :

            $old = get_post_meta($post_id, $field['id'], true);
            $new = isset($_POST[$field['id']])? $_POST[$field['id']] : '';

            if ($new && $new != $old) :
                if($field['type'] == 'date') :
                    $new = wptuts_format_date($new);
                    update_post_meta($post_id, $field['id'], $new);
                else :
                    if(is_string($new)) :
                        $new = $new;
                    endif;
                    update_post_meta($post_id, $field['id'], $new);
                endif;
            elseif ('' == $new && $old) :
                delete_post_meta($post_id, $field['id'], $old);
            endif;
        endforeach;
    endif;
}
add_action('save_post', 'wptuts_slidelink_2_save');

// Create Slider
function wptuts_slider_template() {
    $slides = new WP_Query(
        array(
            'posts_per_page'    => -1,
            'post_type'         => 'slides',
            'order'             => 'DESC'
        )
    );
    if ($slides->have_posts()) : ?>
        <div class="flexslider">
            <ul class="slides">
            <?php
                while ( $slides->have_posts() ) : $slides->the_post();
            ?>
                <li>
                    <?php
                        if ( get_post_meta( get_the_id(), 'wptuts_slideurl', true) != '' ) : ?>
                        <a href="<?php echo esc_url( get_post_meta( get_the_id(), 'wptuts_slideurl', true) ); ?>">
                    <?php endif; ?>
                    <?php if(has_post_thumbnail()): ?>
                        <?php the_post_thumbnail(); ?></a>
                    <?php else: ?>
                        <img src="<?php echo get_option('ink_image') ? get_option('ink_image') : bloginfo('template_directory') . '/src/images/thumbnail.png'; ?>" />
                    <?php endif; ?>
                </li>
            <?php endwhile; ?>
            </ul><!-- .slides -->
        </div><!-- .flexslider -->
    <?php endif;
    wp_reset_postdata();
}
