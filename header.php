<?php
/**
 * The header for Astra Theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<?php astra_html_before(); ?>
<html <?php language_attributes(); ?>>
<head>
<?php astra_head_top(); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php 
if ( apply_filters( 'astra_header_profile_gmpg_link', true ) ) {
	?>
	 <link rel="profile" href="https://gmpg.org/xfn/11"> 
	 <?php
} 
?>
<?php wp_head(); ?>
<?php astra_head_bottom(); ?>
</head>

<body <?php astra_schema_body(); ?> <?php body_class(); ?>>
<?php astra_body_top(); ?>
<?php wp_body_open(); ?>

<a
	class="skip-link screen-reader-text"
	href="#content"
	role="link"
	title="<?php echo esc_attr( astra_default_strings( 'string-header-skip-link', false ) ); ?>">
		<?php echo esc_html( astra_default_strings( 'string-header-skip-link', false ) ); ?>
</a>

<div
<?php
	echo astra_attr(
		'site',
		array(
			'id'    => 'page',
			'class' => 'hfeed site',
		)
	);
	?>
>
	<?php
	astra_header_before();

	// astra_header(); ?>

	<!-- astra_header_after(); -->
  <!-- <div class="container"> -->

    <div class="rj-header-container">
      <div class="container rj-header">
        <?php if (has_custom_logo() && get_theme_mod('rj_employee_portal_site_logo', true) != 0) { ?>
          <div class="rj-logo">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr(get_bloginfo( 'name' )); ?>">
              <?php
              $image_alt = get_bloginfo( 'name' );
              $custom_logo_id = get_theme_mod( 'custom_logo' );
              $logo_url = wp_get_attachment_image_src( $custom_logo_id , 'full' ); ?>
              <img src="<?php echo esc_url($logo_url[0]); ?>" alt="<?php echo esc_attr(($image_alt) ? $image_alt : get_the_title() ); ?>" title="<?php echo esc_attr(($image_alt) ? $image_alt : get_the_title() ); ?>" >
            </a>
                
            <div class="">
              <?php if (get_theme_mod('rj_employee_portal_site_title', false) != 0){ ?>
                <h1 class="mb-0">
                  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr(get_bloginfo( 'name' )); ?>">
                    <?php $site_title = get_bloginfo( 'name' );
                    echo $site_title; ?>
                  </a>
                </h1>
              <?php } ?>
                
                <?php if (get_theme_mod('rj_employee_portal_site_description', false) != 0){ ?>
                  <p class="mb-0">
                    <?php $site_desc = get_bloginfo( 'description' );
                    echo $site_desc;
                    ?>
                  </p>
              <?php } ?>
            </div>
          </div>
        <?php }else { ?>
            <?php if (get_theme_mod('rj_employee_portal_site_title', true) != 0 ){ ?>
              <h1 class="mb-0">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr(get_bloginfo( 'name' )); ?>">
                  <?php $site_title = get_bloginfo( 'name' );
                  echo $site_title; ?>
                </a>
              </h1>
            <?php } ?>
                
            <?php if (get_theme_mod('rj_employee_portal_site_description', true) != 0 ){ ?>
              <p class="mb-0">
                <?php $site_desc = get_bloginfo( 'description' );
                  echo $site_desc; ?>
              </p>
            <?php }
          } ?>

          <div class="rj-header-search">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="rj-home-icon">
              <?php get_template_part('/rj-employee-portal/template-parts/home-icon'); ?>
            </a>
            <?php get_search_form(); ?>
          </div>
      </div>
    </div>

<?php
	// astra_content_before();
	?>
	<div id="content" class="site-content">
    <div class="ast-container1">
      <?php astra_content_top(); ?>
      