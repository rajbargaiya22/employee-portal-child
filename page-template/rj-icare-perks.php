<?php
/*
* Template Name: ICARE Perks
*
*
* @package astra-child
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header(); 
if (is_user_logged_in()) {
?>


<main>
    <div class="container">
       <h1>About your benefits</h1> 

       <?php
            $rj_benfits_paged = get_query_var('paged') ? get_query_var('paged') : 1;
            $rj_benefits_args = array(
                'paged' => $rj_benfits_paged,
                'post_type' => 'icare_perks',
                // 'posts_per_page' => 9, // Add this line to set number of posts per page
                'tax_query' => array(
                    array(
                        'taxonomy' => 'language', 
                        'terms' => 'english',
                        'field' => 'slug',
                    )
                ),
            );
            $rj_benfits_query = new WP_Query($rj_benefits_args);

            while ($rj_benfits_query->have_posts()) :
                $rj_benfits_query->the_post(); ?>
            

            <?php if (has_post_thumbnail()) : ?>
                <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>" 
                     alt="<?php echo esc_attr($image_alt ?: get_the_title()); ?>" 
                     title="<?php echo esc_attr($image_title ?: get_the_title()); ?>">
            <?php endif; ?>
            <h2><?php the_title(); ?></h2>    

            <?php if(get_post_meta($post->ID, 'button_text', true ) !=''){ ?>
            <!-- <a href="<?php //echo esc_url(get_post_meta($post->ID, '_pdf_url', true )); ?>" target="_blank"> -->
            <a href="<?php echo esc_url(get_the_permalink()); ?>">
                    <?php echo esc_html(get_post_meta($post->ID, 'button_text', true )); ?>
            </a>
            <?php } ?>

          <?php endwhile; ?>


    </div>
</main>

<?php
}else{
    get_template_part('/rj-employee-portal/template-parts/custom-login-form');
}
get_footer(); 