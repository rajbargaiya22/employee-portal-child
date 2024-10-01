<?php 
// Hook into the 'init' action to register custom post types and taxonomies
add_action('init', 'rj_employee_portal_posts_init');

// Function to register custom post types
function rj_employee_portal_posts_init() {
    $post_types = array(
        'HR Benefits' => array(
            'singular'  => 'HR Benefit',
            'plural'    => 'HR Benefits',
            'menu_icon' => 'hr-benefit',
            'supports'  => array('title', 'editor', 'thumbnail'),
        ),
        'New Vendor' => array(
            'singular'  => 'New Vendor',
            'plural'    => 'New Vendors',
            'menu_icon' => 'company-newsletter',
            'supports'  => array('title', 'editor', 'thumbnail'),
        ),
        'DTE Benefits' => array(
            'singular'  => 'DTE Benefit',
            'plural'    => 'DTE Benefits',
            'menu_icon' => 'company-newsletter',
            'supports'  => array('title', 'editor', 'thumbnail'),
            'taxonomy'  => array(
                'Language' => array(
                    'singular' => 'Language',
                    'plural'   => 'Languages',
                )
            )
        ),

        'Other Benefits' => array(
            'singular'  => 'Other Benefit',
            'plural'    => 'Other Benefits',
            'menu_icon' => 'company-newsletter',
            'supports'  => array('title', 'editor', 'thumbnail'),
            'show_in_menu' => 'edit.php?post_type=dte_benefits'
        ),
        
        'Benefits ID Cards' => array(
            'singular'  => 'Benefits ID Card',
            'plural'    => 'Benefits ID Cards',
            'menu_icon' => 'company-newsletter',
            'supports'  => array('title', 'editor', 'thumbnail'),
            'show_in_menu' => 'edit.php?post_type=dte_benefits'
        ),

        'ICARE Perks' => array(
            'singular'  => 'ICARE Perk',
            'plural'    => 'ICARE Perks',
            'menu_icon' => 'company-newsletter',
            'supports'  => array('title', 'editor', 'thumbnail'),
            'taxonomy'  => array(
                'Language' => array(
                    'singular' => 'Language',
                    'plural'   => 'Languages',
                )
            )
        ),
        'ADP' => array(
            'singular'  => 'ADP',
            'plural'    => 'ADP',
            'menu_icon' => 'company-newsletter',
            'supports'  => array('title', 'editor', 'thumbnail'),
            'taxonomy'  => array(
                'Language' => array(
                    'singular' => 'Language',
                    'plural'   => 'Languages',
                )
            )
        ),
        'Company Newsletter' => array(
            'singular'  => 'Company Newsletter',
            'plural'    => 'Company Newsletters',
            'menu_icon' => 'company-newsletter',
            'supports'  => array('title', 'editor', 'thumbnail'),
        ),
        'Safety Policy' => array(
            'singular'  => 'Safety Policy',
            'plural'    => 'Safety Policies',
            'menu_icon' => 'safety-policy',
            'supports'  => array('title', 'editor', 'thumbnail'),
        ),
        'IT Help Desk' => array(
            'singular'  => 'IT Help Desk',
            'plural'    => 'IT Help Desk',
            'menu_icon' => 'it-help-desk',
            'supports'  => array('title', 'editor', 'thumbnail'),
        ),
        'DTE Policy' => array(
            'singular'  => 'DTE Policy',
            'plural'    => 'DTE Policies',
            'menu_icon' => 'company-newsletter',
            'supports'  => array('title', 'editor', 'thumbnail'),
        ),
        'HR Forms' => array(
            'singular'  => 'HR Form',
            'plural'    => 'HR Form',
            'menu_icon' => 'company-newsletter',
            'supports'  => array('title', 'editor', 'thumbnail'),
        ),
        'Vendor List' => array(
            'singular'  => 'Vendor List',
            'plural'    => 'Vendor List',
            'menu_icon' => 'company-newsletter',
            'supports'  => array('title', 'editor'),
        ),
        'Aspire' => array(
            'singular'  => 'Aspire',
            'plural'    => 'Aspire',
            'menu_icon' => 'company-newsletter',
            'supports'  => array('title', 'editor'),
        ),
    );

    // Register custom post types
    foreach ($post_types as $menu_name => $post_details) {
        $post_type_name = strtolower(str_replace(' ', '_', $menu_name));

        $labels = array(
            'name'                  => _x($post_details['plural'], 'Post type general name', 'astra-child'),
            'singular_name'         => _x($post_details['singular'], 'Post type singular name', 'astra-child'),
            'menu_name'             => _x($menu_name, 'Admin Menu text', 'astra-child'),
            'name_admin_bar'        => _x($post_details['singular'], 'Add New on Toolbar', 'astra-child'),
            'add_new'               => __('Add New', 'astra-child'),
            'add_new_item'          => __('Add New ' . $post_details['singular'], 'astra-child'),
            'new_item'              => __('New ' . $post_details['singular'], 'astra-child'),
            'edit_item'             => __('Edit ' . $post_details['singular'], 'astra-child'),
            'view_item'             => __('View ' . $post_details['singular'], 'astra-child'),
            'all_items'             => __('All ' . $post_details['plural'], 'astra-child'),
            'search_items'          => __('Search ' . $post_details['plural'], 'astra-child'),
            'parent_item_colon'     => __('Parent ' . $post_details['plural'] . ':', 'astra-child'),
            'not_found'             => __('No ' . $post_details['plural'] . ' found.', 'astra-child'),
            'not_found_in_trash'    => __('No ' . $post_details['plural'] . ' found in Trash.', 'astra-child'),
            'featured_image'        => _x($post_details['singular'] . ' Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'astra-child'),
            'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'astra-child'),
            'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'astra-child'),
            'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'astra-child'),
            'archives'              => _x($post_details['singular'] . ' archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'astra-child'),
            'insert_into_item'      => _x('Insert into ' . $post_details['singular'], 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'astra-child'),
            'uploaded_to_this_item' => _x('Uploaded to this ' . $post_details['singular'], 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'astra-child'),
            'filter_items_list'     => _x('Filter ' . $post_details['singular'] . ' list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'astra-child'),
            'items_list_navigation' => _x($post_details['plural'] . ' list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'astra-child'),
            'items_list'            => _x($post_details['plural'] . ' list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'astra-child'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'menu_icon'          => get_stylesheet_directory_uri() . '/rj-employee-portal/admin/assets/images/' . $post_details['menu_icon'] . '.png',
            'publicly_queryable' => true,
            'show_ui'            => true,
            // 'show_in_menu'       => $post_details['show_in_menu'] ? $post_details['show_in_menu'] : true,
            'query_var'          => true,
            'rewrite'            => array('slug' => $post_type_name),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => $post_details['supports'],
        );

        if( array_key_exists('show_in_menu', $post_details) ){
            $args['show_in_menu'] = $post_details['show_in_menu'];
        }else{
            $args['show_in_menu'] = true;
        }

        register_post_type($post_type_name, $args);
    }

}

// Function to register custom taxonomies
add_action( 'init', 'rj_employee_portal_register_taxonomies', 0 );
function rj_employee_portal_register_taxonomies() {
    $post_types = array('dte_benefits', 'icare_perks', 'adp');
    $taxonomy = 'language';
    
    $tax_labels = array(
        'name'                       => _x('Languages', 'taxonomy general name', 'astra-child'),
        'singular_name'              => _x('Language', 'taxonomy singular name', 'astra-child'),
        'search_items'               => __('Search Languages', 'astra-child'),
        'popular_items'              => __('Popular Languages', 'astra-child'),
        'all_items'                  => __('All Languages', 'astra-child'),
        'edit_item'                  => __('Edit Language', 'astra-child'),
        'update_item'                => __('Update Language', 'astra-child'),
        'add_new_item'               => __('Add New Language', 'astra-child'),
        'new_item_name'              => __('New Language Name', 'astra-child'),
        'separate_items_with_commas' => __('Separate languages with commas', 'astra-child'),
        'add_or_remove_items'        => __('Add or remove languages', 'astra-child'),
        'choose_from_most_used'      => __('Choose from the most used languages', 'astra-child'),
        'not_found'                  => __('No languages found.', 'astra-child'),
        'menu_name'                  => __('Languages', 'astra-child'),
    );
    
    $tax_args = array(
        'hierarchical'          => true,
        'labels'                => $tax_labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        // 'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array('slug' => $taxonomy),
    );
    
    register_taxonomy($taxonomy, $post_types, $tax_args);
}


// add meta box to each post type START
function rj_employee_portal_all_posts_add_pdf_metabox() {
    $post_types = array(
        'hr_benefits',
        'new_vendor',
        'dte_benefits',
        'other_benefits',
        'icare_perks',
        'adp',
        'company_newsletter',
        'safety_policy',
        'it_help_desk',
        'dte_policy',
        'hr_forms',
        'monthly_newsletter'
    );

    foreach ($post_types as $post_type) {
        add_meta_box(
            'pdf_upload_metabox',
            'Upload PDF',
            'rj_employee_portal_render_pdf_metabox',
            $post_type,
            'normal',
            'default'
        );
    }
}
add_action('add_meta_boxes', 'rj_employee_portal_all_posts_add_pdf_metabox');

function rj_employee_portal_render_pdf_metabox($post) {
    wp_nonce_field(basename(__FILE__), 'pdf_metabox_nonce');
    $pdf_url = get_post_meta($post->ID, '_pdf_url', true);
    ?>
    <p>
        <label for="pdf_url">PDF URL:</label>
        <input type="text" name="pdf_url" id="pdf_url" value="<?php echo esc_attr($pdf_url); ?>" class="widefat" />
    </p>
    <p>
        <input type="button" id="pdf_upload_button" class="button" value="Upload PDF" />
    </p>
 

	<p>
	<label for="button_text">Button Text:</label>
	 <input type="text" name="button_text" id="button_text" value="<?php echo esc_attr(get_post_meta($post->ID, 'button_text', true)); ?>" />
	</p>

    <?php 
    if ( 'it_help_desk' == get_post_type() || 'dte_benefits' == get_post_type() || 'other_benefits' == get_post_type() ) { ?>
        <label for="button_link">Button Link:</label>
        <input type="text" name="button_link" id="button_link" value="<?php echo esc_attr(get_post_meta($post->ID, 'button_link', true)); ?>" />
    <?php } ?>

    <?php
}

function save_pdf_metabox($post_id) {
    if (!isset($_POST['pdf_metabox_nonce']) || !wp_verify_nonce($_POST['pdf_metabox_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    if (isset($_POST['pdf_url'])) {
        update_post_meta($post_id, '_pdf_url', sanitize_text_field($_POST['pdf_url']));
    }
    if (isset($_POST['button_text'])) {
        update_post_meta($post_id, 'button_text', sanitize_text_field($_POST['button_text']));
    }
    if (isset($_POST['button_link'])) {
        update_post_meta($post_id, 'button_link', sanitize_text_field($_POST['button_link']));
    }
}
add_action('save_post', 'save_pdf_metabox');

// add meta box to each post type END


