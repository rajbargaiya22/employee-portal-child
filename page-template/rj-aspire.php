<?php
/*
* Template Name: Aspire Training
*
*
* @package astra-child
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();  

if (is_user_logged_in()) { ?>

	<main class="rj-main">
		<div class="container">
            <div class="new-vendor-heading">
            <h1 class="rj-main-heading">
                    <?php echo esc_html_e('Aspire Training', 'astra-child'); ?>
                </h1>

                <a href="<?php echo esc_url('https://care.youraspire.com/en/'); ?>" class="rj-read-more" target="_blank">
                    Aspire Care
                </a>
            </div>

        

			<div class="row">

       <?php
            $rj_benfits_paged = get_query_var('paged') ? get_query_var('paged') : 1;
            $rj_benefits_args = array(
                'paged' => $rj_benfits_paged,
                'post_type' => 'aspire',
                'orderby' => 'date',
                // 'posts_per_page' => 9,
            );
            $rj_benfits_query = new WP_Query($rj_benefits_args);

            while ($rj_benfits_query->have_posts()) :
                $rj_benfits_query->the_post(); ?>
            
            <article class="col-md-6 mb-4">
                <div class="rj-post-container">
                    <?php if (has_post_thumbnail()) : ?>
                        <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>" 
                            alt="<?php echo esc_attr($image_alt ?: get_the_title()); ?>" 
                            title="<?php echo esc_attr($image_title ?: get_the_title()); ?>"
                            class="post-thumb">
                    <?php endif; ?>

                    
                    <div class="rj-post-content rj-aspire-contents">                                   
                        <h2 class="aspire-title">
                            <?php echo get_the_title(); ?>
                        </h2>  

                        <p class="rj-post-desc"><?php echo get_the_content(); ?></p>    

                        <?php
                        $field_values = get_post_meta(get_the_ID(), '_dynamic_field_values', true);

                        if ($field_values) { ?>

                            <div class="accordion" id="<?php echo get_the_ID(); ?>">
                                <?php foreach ($field_values as $index => $group) { ?>
                                    <div class="accordion-item">
                                        <h3 class="accordion-header">
                                            <button class="accordion-button <?php if($index != 0){ echo "collapsed"; } ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo get_the_ID() . $index ; ?>" aria-expanded="<?php if($index == 0){ echo "true"; }else{ echo "false"; } ?>" aria-controls="collapse<?php echo get_the_ID() . $index; ?>">
                                                <?php echo esc_html(esc_html($group['heading'])); ?>
                                            </button>
                                        </h3>
                                        <div id="collapse<?php echo get_the_ID() . $index; ?>" class="accordion-collapse collapse <?php if($index == 0){ echo "show"; } ?>" data-bs-parent="#<?php echo get_the_ID(); ?>">
                                        <div class="accordion-body">
                                            <?php 
                                                if (!empty($group['subheadings'])) {
                                                    foreach ($group['subheadings'] as $key => $subheading) {
                                                        echo "<h4>"; 
                                                        get_template_part('/rj-employee-portal/template-parts/aspire-icon');
                                                        echo "<a href='" . esc_url($group['urls'][$key]) . "' target='_blank'>" . esc_html($subheading) . "</a>
                                                        </h4>";
                                                    }
                                                }
                                            ?>
                                        </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>                        
                        <?php } ?>


                    </div>
                </div>
            </article>

          <?php endwhile; ?>

        </div>
    </div>
		</div>
	</main>

<?php }else{
	get_template_part('/rj-employee-portal/template-parts/custom-login-form');
} ?>
<?php get_footer(); 