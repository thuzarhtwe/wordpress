<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package scm_test
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php
			// Get post meta data
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
			wp_reset_postdata();
			// Get custom meta data
			$custom = get_post_custom();
		?>
		<!-- Meta Description -->
		<?php if(!empty($custom['meta_description'][0]) && !is_home()) : ?>
		 	<meta name="description" content="<?php echo $custom['meta_description'][0] ?>" />
		<?php elseif(is_home() && !is_paged()): ?>
		 	<meta name="description" content="<?php echo array_key_exists('global_meta_description', $global_custom)? $global_custom['global_meta_description'][0]: '' ?>" />
		<?php else: ?>
			<meta name="description" content="" />
		<?php endif; ?>
		<!-- Meta Keywords -->
		<?php if(is_category() || is_tag()) : ?>
			<meta name="keywords" content="<?php echo single_cat_title('', false) ?>" />
	  <?php elseif(!empty($custom['meta_keywords'][0]) && !is_home() && !is_search()) : ?>
			<meta name="keywords" content="<?php echo $custom['meta_keywords'][0]; ?>" />
		<?php elseif(is_home() && !is_paged()): ?>
			<meta name="keywords" content="<?php echo array_key_exists('global_meta_keywords', $global_custom)? $global_custom['global_meta_keywords'][0]: '' ?>" />
		<?php else: ?>
			 <meta name="keywords" content="" />
		<?php endif; ?>
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<div id="page" class="hfeed site">
			<?php
				// Get header id name
				$idclass_post = new WP_Query(
									array(
										'posts_per_page' => 1,
										'post_status' => 'publish',
										'orderby' => 'date',
										'order' => 'DESC',
										'meta_query' => array(
											array(
												'key' => 'masthead',
												'value' => '',
												'compare' => '!='
											)
										)
									)
								);
				$idclass_custom = array();
				if ($idclass_post->have_posts()) :
					while ( $idclass_post->have_posts() ) :
						$idclass_post->the_post();
						$idclass_custom = get_post_custom();
					endwhile;
				endif;
				wp_reset_postdata();
			?>
			<header id="<?php echo array_key_exists('masthead', $idclass_custom)? $idclass_custom['masthead'][0] : 'masthead'; ?>" class="site-header" role="banner">
				<!-- Display Site Logo, Title, Description -->
				<div class="site-branding">
					<!-- <?php //if ( get_header_image() ) : ?>
						<div class="logo">
							<a href="<?php //echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<img src="<?php //header_image(); ?>" alt="<?php// echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
							</a>
						</div>
					<?php //else: ?>
						<h1 class="site-title">
							<a href="<?php //echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php// bloginfo( 'name' ); ?></a>
						</h1>
						<p class="site-description"><?php //bloginfo( 'description' ); ?></p>
					<?php //endif; ?> -->


      <?php
      if((get_theme_mod('themename_header_logo_placement', 'header_text_only') == 'show_both' )) {
         $show_both_class = 'show-both';
      } else {
         $show_both_class = '';
      }
      ?>
      <div class="header-wrapper <?php echo $show_both_class; ?> clearfix">
            <div class="header-wrap">
            <?php
               if((get_theme_mod('themename_header_logo_placement', 'header_text_only') == 'show_both' || get_theme_mod('themename_header_logo_placement', 'header_text_only') == 'header_logo_only') ) {
               ?>
                  <div class="logo">
                  	<?php if ( get_theme_mod('themename_logo', '') != '') { ?>
                  		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url(get_theme_mod('themename_logo')); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
										<?php } ?>

										<?php if (function_exists('the_custom_logo') && has_custom_logo( $blog_id = 0 )) {
											themename_the_custom_logo();
										} ?>

                  </div><!-- #logo -->
               <?php
               }
               $screen_reader = '';
               if ( get_theme_mod( 'themename_header_logo_placement', 'header_text_only' ) == 'header_logo_only' || (get_theme_mod( 'themename_header_logo_placement', 'header_text_only' ) == 'disable' )) {
                  $screen_reader = 'screen-reader-text';
               }
               ?>
               <div id="header-text" class="<?php echo $screen_reader; ?>">
                  <?php if ( is_front_page() || is_home() ) : ?>
                     <h1 id="site-title" class="site-title">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                     </h1><!-- #site-title -->
                  <?php else : ?>
                     <h3 id="site-title" class="site-title">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                     </h3><!-- #site-title -->
                  <?php endif; ?>
                  <?php
                  $description = get_bloginfo( 'description', 'display' );
                  if ( $description || is_customize_preview() ) : ?>
                     <p id="site-description" class="site-description"><?php echo $description; ?></p>
                  <?php endif;?><!-- #site-description -->
               </div><!-- #header-text -->
            </div><!-- .header-wrap end -->
					</div><!-- .header-wrapper end -->
				</div><!-- .site-branding -->
				<!-- Display Menu -->
				<div class="header-menu">
					<?php if(has_nav_menu( 'primary')) : ?>
						<nav id="site-navigation" class="main-navigation" role="navigation">
							<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"> メニュー</button>
							<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
						</nav>
					<?php endif; ?>
				</div>
			</header><!-- .site-header -->

			<!-- if home(index) page, display slider. For other, display breadcrumb -->
			<?php
				if(is_home() && !is_paged()) :
					echo wptuts_slider_template("[slide]");
				else :
					the_breadcrumb();
				endif;
			?>
			<!-- Content -->
			<div id="content" class="site-content">
