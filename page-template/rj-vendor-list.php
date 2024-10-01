<?php
/*
 * Template Name: Vendor List
 *
 * @package astra-child
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$user = wp_get_current_user();
$allowed_roles = array('regionals', 'branch_managers', 'office_managers', 'accounting', 'administrator');

if (is_user_logged_in() && array_intersect($allowed_roles, (array) $user->roles)) {
    ?>
    <div class="rj-main">
        <div class="container">

        <div class="new-vendor-heading">
            <h1 class="rj-main-heading">Vendor List</h1>

            <div style="display: flex; gap:10px; flex-wrap:wrap;">
                <?php if(!empty(get_option('vendor_list_excel_file')) ){ ?>
                    <a href="<?php echo esc_url(get_option('vendor_list_excel_file', true)); ?>" download="download" class="rj-read-more">
                        Download Vendor List
                    </a>
                <?php } ?>

                <a href="<?php echo esc_url(get_permalink(get_page_by_title('New vendor'))); ?>" class="rj-read-more">
                    <?php echo esc_html_e('New Vendor Request', 'astra-child'); ?>
				</a>

            </div>

        </div>
        
        <?php /*
            $pdf_url = get_option('vendor_list_excel_file');
            
            if ($pdf_url) { 
                $doc_type = pathinfo($pdf_url, PATHINFO_EXTENSION); 

            if($doc_type == 'pdf'){ ?>
                    <iframe src="<?php echo esc_url($pdf_url); ?>" width="100%" height="600px" class="rj-single-post-iframe">
                        <p>Your browser doesn't support iframes. Please download the PDF to view it: <a href="<?php echo esc_url($pdf_url) ?>">Download PDF</a>.</p>
                    </iframe>
                <?php }else{ ?>
                    <iframe src="https://docs.google.com/viewer?url=<?php echo $pdf_url; ?>&embedded=true" style="width:100%; height:600px;"  frameborder="0" class="rj-single-post-iframe">
                    </iframe>
                <?php } ?>              
            <?php } */ ?> 
        


        <?php 

        
        
        get_template_part('/rj-employee-portal/template-parts/rj-vendor-search'); ?>

        <div id="rj-vendor-list">
            
            <?php
            $rj_newsletter_paged = get_query_var('paged') ? get_query_var('paged') : 1;
            $rj_bookmarks_args = array(
                'paged' => $rj_newsletter_paged,
                'post_type' => 'vendor_list',
                // 'posts_per_page' => 9, 
            );
            $rj_newsletter_query = new WP_Query($rj_bookmarks_args);

            if ($rj_newsletter_query->have_posts()) : ?>
                <div class="row">
                    <?php while ($rj_newsletter_query->have_posts()) :
                        $rj_newsletter_query->the_post();
                        $image_id = get_post_thumbnail_id();
                        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
                        $image_title = get_the_title($image_id);
                        ?>
                        <div class="col-lg-4 col-md-6 mb-4" style="margin-bottom: 20px">
                            <div class="rj-post-container">
                                <?php if (has_post_thumbnail()) : ?>
                                    <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>" 
                                         alt="<?php echo esc_attr($image_alt ?: get_the_title()); ?>" 
                                         title="<?php echo esc_attr($image_title ?: get_the_title()); ?>">
                                <?php endif; ?>
                                <div class="rj-post-content">                                  
                                    <h2>
                                        <?php echo get_the_title(); ?>
                                    </h2>  
                                    <?php if ( !empty( get_the_content() ) ){ ?>
                                        <p class="mb-0"><?php echo get_the_content(); ?></p>
                                    <?php } ?>
                                    
                                    <?php if(get_post_meta($post->ID, 'website_link', true) != ''){ ?>
                                        <span class="strategic-vendor">
                                            <?php echo esc_html('Strategic Vendor'); ?>
                                            
                                        </span>    
                                    <?php } ?>
                                    
                                    <?php if(get_post_meta($post->ID, 'category', true) != ''){ ?>
                                        <span>
                                            <?php echo "<b>Category : </b>" . esc_html(get_post_meta($post->ID, 'category', true)); ?>
                                        </span>    
                                    <?php } ?>
                                    <?php if(get_post_meta($post->ID, 'contact_no', true) != ''){ ?>
                                        <a href="tel:<?php  echo esc_attr(get_post_meta($post->ID, 'contact_no', true)); ?>">
                                        <?php echo "<b>Phone : </b>" . esc_html(get_post_meta($post->ID, 'contact_no', true)); ?>
                                        </a>
                                    <?php } ?>
                                    <?php if(get_post_meta($post->ID, 'email', true) != ''){ ?>
                                        <a href="mailto:<?php  echo esc_attr(get_post_meta($post->ID, 'email', true)); ?>">
                                        <?php echo "<b>Email : </b>" . esc_html(get_post_meta($post->ID, 'email', true)); ?>
                                        </a>
                                    <?php } ?>

                                    <?php if(get_post_meta($post->ID, 'website_link', true) != ''){ ?>
                                        <a href="<?php echo esc_url(get_post_meta($post->ID, 'website_link', true)); ?>" target="_blank">
                                            <?php echo "<b>Website : </b>" . esc_html(get_post_meta($post->ID, 'website_link', true)); ?>
                                        </a>
                                    <?php } ?>

                                    <address>
                                        <?php if( (get_post_meta($post->ID, 'address') != '') || (get_post_meta($post->ID, 'city') != '') || (get_post_meta($post->ID, 'state') != '') || (get_post_meta($post->ID, 'zip_code') != '') ){ 

                                            $address = get_post_meta($post->ID, 'address', true) ? (get_post_meta($post->ID, 'address', true) . ', ' ): '' ;
                                            $city = get_post_meta($post->ID, 'city', true) ? (get_post_meta($post->ID, 'city', true) . ', ' ): '' ;
                                            $state = get_post_meta($post->ID, 'state', true) ? (get_post_meta($post->ID, 'state', true) ): '' ;
                                            $zip_code = get_post_meta($post->ID, 'zip_code', true) ? ( '-' . get_post_meta($post->ID, 'zip_code', true) ): '' ; ?>
                                            
                                            <a href="http://maps.google.com/maps?q=<?php echo esc_attr($address . $city . $state . $zip_code); ?>" target="_blank">
                                                <?php echo "<b>Address : </b>" . esc_html($address . $city . $state . $zip_code);  ?>
                                            </a>
                                        <?php } ?>
                                    </address>

                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div class="rj-post-navigation">
                    <?php
                    echo paginate_links(array(
                        'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                        'format' => 'paged=%#%',
                        'current' => max(1, get_query_var('paged')),
                        'total' => $rj_newsletter_query->max_num_pages
                    ));
                    ?>
                </div>
            <?php else : ?>
                <h3><?php esc_html_e('No posts found', 'astra-child'); ?></h3>
            <?php 
            endif; 
            wp_reset_postdata(); ?>
            </div>
        </div>
    </div>
    <?php } else {
    if (!is_user_logged_in()) {
        $args = array(
            'redirect' => home_url($_SERVER['REQUEST_URI']),
            'form_id' => 'loginform-custom',
            'label_username' => __('Username'),
            'label_password' => __('Password'),
            'label_remember' => __('Remember Me'),
            'label_log_in' => __('Log In'),
            'remember' => true
        );
        wp_login_form($args);
    } else {
        echo '<p>You do not have permission to view this page.</p>';
    }
}

get_footer();