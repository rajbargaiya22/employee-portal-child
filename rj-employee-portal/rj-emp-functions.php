<?php
function rj_enqueue_styles() {

   wp_enqueue_style( 'rj-parent-style', get_template_directory_uri() . '/style.css' );
   wp_enqueue_style( 'rj-child-style',  get_stylesheet_directory_uri() . '/rj-employee-portal/rj-em-style.css',  array('rj-parent-style'),  wp_get_theme()->get('Version') 
   );
    
    wp_enqueue_style( 'rj-bootstrap', get_stylesheet_directory_uri(). '/rj-employee-portal/assets/css/bootstrap.css', false, false );
    wp_enqueue_style( 'rj-slick-css',  get_stylesheet_directory_uri() . '/rj-employee-portal/assets/css/slick-theme.css' );

    wp_enqueue_script('rj-bootstrap-js', get_stylesheet_directory_uri(). '/rj-employee-portal/assets/js/bootstrap.js', false, false);
    wp_enqueue_script('rj-slick-js', get_stylesheet_directory_uri(). '/rj-employee-portal/assets/js/slick.min.js', array('jquery'), false, false);

    wp_enqueue_script('rj-custom-js', get_stylesheet_directory_uri() . '/rj-employee-portal/assets/js/rj-custom.js', array('jquery'), '1.0', true);
    wp_localize_script('rj-custom-js', 'ajaxurl', admin_url('admin-ajax.php'));   

}

add_action( 'wp_enqueue_scripts', 'rj_enqueue_styles' );


function rj_admin_enquee_styles(){
    wp_enqueue_style( 'rj-admin-style', get_stylesheet_directory_uri(). '/rj-employee-portal/admin/admin-style.css' );
    wp_enqueue_media();
    wp_enqueue_script('rj-admin-js', get_stylesheet_directory_uri() . '/rj-employee-portal/admin/assets/js/admin-js.js', array('jquery'), null, true);
}
add_action( 'admin_enqueue_scripts', 'rj_admin_enquee_styles' );



require get_stylesheet_directory() . "/rj-employee-portal/admin/rj-post-types.php";
require get_stylesheet_directory() . "/rj-employee-portal/admin/rj-custom-roles.php";
require get_stylesheet_directory() . "/rj-employee-portal/admin/rj-company-newsletter-image-box.php";
require get_stylesheet_directory() . "/rj-employee-portal/admin/rj-new-vendor-meta-box.php";
require get_stylesheet_directory() . "/rj-employee-portal/admin/rj-vendor-list-metabox.php";
require get_stylesheet_directory() . "/rj-employee-portal/admin/rj-aspire-metabox.php";
require get_stylesheet_directory() . '/rj-employee-portal/inc/rj-customizer.php';

function get_search_suggestions() {
    $query = sanitize_text_field($_POST['query']);
    
    // Get all public post types
    $post_types = get_post_types(array('public' => true));
    
    $results = array();
    
    foreach ($post_types as $post_type) {
        $args = array(
            's' => $query,
            'post_type' => $post_type,
            'posts_per_page' => -1 // Get all matching posts
        );
        
        $search_query = new WP_Query($args);
        
        if ($search_query->have_posts()) {
            $results[$post_type] = array();
            while ($search_query->have_posts()) {
                $search_query->the_post();
                $results[$post_type][] = array(
                    'title' => get_the_title(),
                    'url' => get_permalink(),
                    'excerpt' => wp_trim_words(get_the_excerpt(), 20)
                );
            }
            wp_reset_postdata();
        }
    }
    
    if (!empty($results)) {
        wp_send_json_success($results);
    } else {
        wp_send_json_error('No results found');
    }
}
add_action('wp_ajax_get_search_suggestions', 'get_search_suggestions');
add_action('wp_ajax_nopriv_get_search_suggestions', 'get_search_suggestions');
  

//  hide the admin bar 
add_action('after_setup_theme', 'rj_employee_portak_remove_admin_bar');
function rj_employee_portak_remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin() ) {
        show_admin_bar(false);
    }
}


function handle_vendor_search() {
    $args = array(
        'post_type' => 'vendor_list',
        'posts_per_page' => -1, // Adjust this as needed
    );

    // Check for search parameters and adjust query
    if (!empty($_GET['vendor-name'])) {
        $args['s'] = sanitize_text_field($_GET['vendor-name']);
    }
    if (!empty($_GET['address'])) {
        $args['meta_query'][] = array(
            'key' => 'address',
            'value' => sanitize_text_field($_GET['address']),
            'compare' => 'LIKE',
        );
    }
    if (!empty($_GET['city'])) {
        $args['meta_query'][] = array(
            'key' => 'city',
            'value' => sanitize_text_field($_GET['city']),
            'compare' => 'LIKE',
        );
    }
    if (!empty($_GET['zip_code'])) {
        $args['meta_query'][] = array(
            'key' => 'zip_code',
            'value' => sanitize_text_field($_GET['zip_code']),
            'compare' => 'LIKE',
        );
    }
    if (!empty($_GET['aspire_vendor'])) {
        $args['meta_query'][] = array(
            'key' => 'aspire_vendor',
            'value' => sanitize_text_field($_GET['aspire_vendor']),
            'compare' => '=',
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) : ?>
        <div class="row">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="col-lg-4 col-md-6 mb-4"  style="margin-bottom: 10px">
                    <div class="rj-post-container">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>" 
                                 alt="<?php echo esc_attr(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)); ?>" 
                                 title="<?php echo esc_attr(get_the_title(get_post_thumbnail_id())); ?>">
                        <?php endif; ?>
                        <div class="rj-post-content">
                            <h2><?php the_title(); ?></h2>
                            <?php if ( !empty( get_the_content() ) ){ ?>
                                <p class="mb-0"><?php echo get_the_content(); ?></p>
                            <?php } ?>

                            <?php if(get_post_meta(get_the_ID(), 'website_link', true) != ''){ ?>
                                <span class="strategic-vendor">
                                    <?php echo esc_html('Strategic Vendor'); ?>
                                </span>    
                            <?php } ?>

                            <?php if(get_post_meta(get_the_ID(), 'category', true) != ''){ ?>
                                <span>
                                    <?php echo "<b>Category : </b>" . esc_html(get_post_meta(get_the_ID(), 'category', true)); ?>
                                </span>    
                            <?php } ?>

                            <?php if (get_post_meta(get_the_ID(), 'contact_no', true)) : ?>
                                <a href="tel:<?php echo esc_attr(get_post_meta(get_the_ID(), 'contact_no', true)); ?>">
                                    <b>Phone : </b><?php echo esc_html(get_post_meta(get_the_ID(), 'contact_no', true)); ?>
                                </a>
                            <?php endif; ?>
                            <?php if (get_post_meta(get_the_ID(), 'email', true)) : ?>
                                <a href="mailto:<?php echo esc_attr(get_post_meta(get_the_ID(), 'email', true)); ?>">
                                    <b>Email : </b><?php echo esc_html(get_post_meta(get_the_ID(), 'email', true)); ?>
                                </a>
                            <?php endif; ?>

                            <?php if(get_post_meta(get_the_ID(), 'website_link', true) != ''){ ?>
                                <a href="<?php echo esc_url(get_post_meta(get_the_ID(), 'website_link', true)); ?>" target="_blank">
                                    <?php echo "<b>Website : </b>" . esc_html(get_post_meta(get_the_ID(), 'website_link', true)); ?>
                                </a>
                            <?php } ?>

                            <address>
                                <?php 
                                $address = get_post_meta(get_the_ID(), 'address', true);
                                $city = get_post_meta(get_the_ID(), 'city', true);
                                $state = get_post_meta(get_the_ID(), 'state', true);
                                $zip_code = get_post_meta(get_the_ID(), 'zip_code', true);
                                if ($address || $city || $state || $zip_code) : ?>
                                    <a href="http://maps.google.com/maps?q=<?php echo esc_attr(implode(', ', array_filter([$address, $city, $state, $zip_code]))); ?>" target="_blank">
                                        <b>Address : </b><?php echo esc_html(implode(', ', array_filter([$address, $city, $state, $zip_code]))); ?>
                                    </a>
                                <?php endif; ?>
                            </address>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php
        echo paginate_links(array(
            'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
            'format' => 'paged=%#%',
            'current' => max(1, get_query_var('paged')),
            'total' => $query->max_num_pages
        ));
    else : ?>
        <h3><?php esc_html_e('No vendors found', 'astra-child'); ?></h3>
    <?php
    endif;

    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_vendor_search', 'handle_vendor_search');
add_action('wp_ajax_nopriv_vendor_search', 'handle_vendor_search');


//  newsletter upload 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['frontend_post_nonce_field'])) {
    if (wp_verify_nonce($_POST['frontend_post_nonce_field'], 'frontend_post_nonce')) {
        $post_title = sanitize_text_field($_POST['post_title']);
        $post_content = wp_kses_post($_POST['post_content']);

        // Insert post
        $post_id = wp_insert_post(array(
            'post_title'    => $post_title,
            'post_content'  => $post_content,
            'post_status'   => 'pending',
            'post_author'   => get_current_user_id(),
            'post_type'     => 'company_newsletter'
        ));

        if ($post_id && !is_wp_error($post_id)) {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');

            $image_ids = array();

            // Check if files were uploaded
            if (!empty($_FILES['post_images']['name'][0])) {
                foreach ($_FILES['post_images']['name'] as $key => $value) {
                    if (!empty($_FILES['post_images']['name'][$key])) {
                        $file = array(
                            'name'     => $_FILES['post_images']['name'][$key],
                            'type'     => $_FILES['post_images']['type'][$key],
                            'tmp_name' => $_FILES['post_images']['tmp_name'][$key],
                            'error'    => $_FILES['post_images']['error'][$key],
                            'size'     => $_FILES['post_images']['size'][$key]
                        );

                        // Temporarily reassign $_FILES for the upload
                        $_FILES['upload_file'] = $file;
                        $attachment_id = media_handle_upload('upload_file', $post_id);

                        if (!is_wp_error($attachment_id)) {
                            array_push($image_ids, $attachment_id);
                        } else {
                            // Handle upload error
                            echo 'Error uploading file: ' . $attachment_id->get_error_message();
                        }
                    }
                }


                if (!empty($image_ids)) {
                    set_post_thumbnail($post_id, $image_ids[0]);

                    array_shift($image_ids);

                    $image_ids_string = implode(',', $image_ids);                 

                    $result = update_post_meta($post_id, '_custom_image_ids', sanitize_text_field($image_ids_string));
                    if ($result === false) {
                        echo 'Failed to update meta field.';
                    }
                }
            }

            wp_redirect(home_url('company-newsletter'));
            exit;
        } else {
            echo "Error submitting post: " . $post_id->get_error_message();
        }
    } else {
        echo "Nonce verification failed.";
    }
}



function enqueue_customizer_scripts() {
    wp_enqueue_script('custom-customizer', get_template_directory_uri() . '/js/customizer.js', array('jquery', 'customize-controls'), '', true);
}
add_action('customize_controls_enqueue_scripts', 'enqueue_customizer_scripts');