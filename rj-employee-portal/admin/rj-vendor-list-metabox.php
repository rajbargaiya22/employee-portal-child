<?php
function rj_employee_portal_vendor_list_metabox() {
    add_meta_box(
        'vendor_details',
        'Vendor Details',
        'rj_employee_portal_render_vendor_list_metabox',
        'vendor_list',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'rj_employee_portal_vendor_list_metabox');

function rj_employee_portal_render_vendor_list_metabox($post) {
    wp_nonce_field(basename(__FILE__), 'rj_employee_portal_vendor_list_metabox_nonce');
    

    // $fields = array('Phone', 'Contact No', 'Email', 'Address', 'City', 'State', 'Zip Code');
    $fields = array(
                    'Contact No' => 'tel',
                    'Email'      => 'email',
                    'Address'    => 'text',
                    'City'       => 'text',
                    'State'      => 'text',
                    'Zip Code'   => 'text',
                    'Website Link'  => 'text',
                    'Category'  => 'text',
                );

    foreach ($fields as $field => $type) {
        $field_name = strtolower(str_replace(' ', '_', $field));
        ?>
        <p>
            <label for="<?php echo esc_attr($field_name); ?>"><?php echo esc_html($field); ?>:</label>
            <input
                type="<?php echo esc_attr($type) ?>"
                name="<?php echo esc_attr($field_name); ?>"
                id="<?php echo esc_attr($field_name); ?>"
                value="<?php echo esc_attr(get_post_meta($post->ID, $field_name, true)); ?>"
                class="widefat"
            />
        </p>
        <?php
    }

    /*
    $aspire_vendor = get_post_meta($post->ID, 'aspire_vendor', true);
    ?>
    <p>
        <label for="aspire_vendor">Aspire Vendor:</label>
        <select name="aspire_vendor" id="aspire_vendor" class="widefat">
            <option value="">--</option>
            <option value="yes" <?php selected($aspire_vendor, 'yes'); ?>>Yes</option>
            <option value="no" <?php selected($aspire_vendor, 'no'); ?>>No</option>
        </select>
    </p>
    <?php */
}

function save_rj_employee_portal_vendor_list_metabox($post_id) {
    if (!isset($_POST['rj_employee_portal_vendor_list_metabox_nonce']) || 
        !wp_verify_nonce($_POST['rj_employee_portal_vendor_list_metabox_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    $fields = array('Phone', 'Contact No', 'Email', 'Address', 'City', 'State', 'Zip Code', 'Website Link', 'Category');
    foreach ($fields as $field) {
        $field_name = strtolower(str_replace(' ', '_', $field));
        if (isset($_POST[$field_name])) {
            update_post_meta($post_id, $field_name, sanitize_text_field($_POST[$field_name]));
        }
    }

    // if (isset($_POST['aspire_vendor'])) {
    //     update_post_meta($post_id, 'aspire_vendor', sanitize_text_field($_POST['aspire_vendor']));
    // }

}
add_action('save_post', 'save_rj_employee_portal_vendor_list_metabox');



// Function to get the shared metafield value
function get_shared_metafield_value() {
    return get_option('vendor_list_excel_file', '');
}

// Add submenu page to the vendor_list custom post type
function add_shared_file_submenu() {
    add_submenu_page(
        'edit.php?post_type=vendor_list',
        'Vendor List Excel',
        'Vendor List Excel',
        'manage_options',
        'vendor-list-excel',
        'shared_metafield_page'
    );
}
add_action('admin_menu', 'add_shared_file_submenu');

// Admin page content
function shared_metafield_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    wp_enqueue_media();
   
    if (isset($_POST['submit_shared_metafield'])) {
        if (isset($_POST['shared_metafield']) && check_admin_referer('vendor_list_excel_upload')) {
            update_option('vendor_list_excel_file', esc_url_raw($_POST['shared_metafield']));
            echo '<div class="notice notice-success"><p>File updated successfully.</p></div>';
        }
    }
   
    $value = get_shared_metafield_value();
   
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form method="post" action="">
            <?php wp_nonce_field('vendor_list_excel_upload'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="shared_metafield">Excel File</label></th>
                    <td>
                        <input type="hidden" name="shared_metafield" id="shared_metafield" value="<?php echo esc_attr($value); ?>">
                        <input type="button" id="upload_file_button" class="button" value="Upload File">
                        <?php if ($value): ?>
                            <p>Current file: <span id="current_file"><?php echo esc_html(basename($value)); ?></span></p>
                            
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            <?php submit_button('Save Changes', 'primary', 'submit_shared_metafield'); ?>
        </form>
   
        <?php if ($value): ?>
            <h2>Download File</h2>
            <p><a href="<?php echo esc_url(add_query_arg('download_excel', '1', admin_url('admin-post.php'))); ?>" class="button">Download Excel File</a></p>
        <?php endif; ?>
    </div>

    <script>
    jQuery(document).ready(function($){
        $('#upload_file_button').click(function(e) {
            e.preventDefault();
            var custom_uploader = wp.media({
                title: 'Choose Excel File',
                button: {
                    text: 'Use this file'
                },
                multiple: false,
                library: {
                    type: ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
                }
            }).on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                $('#shared_metafield').val(attachment.url);
                $('#current_file').text(attachment.filename);
            }).open();
        });
    });
    </script>
    <?php
}

// Handle file download
function handle_excel_download() {
    if (isset($_GET['download_excel']) && current_user_can('manage_options')) {
        $file_url = get_shared_metafield_value();
        if ($file_url) {
            $file_path = str_replace(site_url('/'), ABSPATH, $file_url);
            if (file_exists($file_path)) {
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
                header('Content-Length: ' . filesize($file_path));
                readfile($file_path);
                exit;
            }
        }
    }
}
add_action('admin_post_nopriv_download_excel', 'handle_excel_download');
add_action('admin_post_download_excel', 'handle_excel_download');

// Display the metafield value in your theme
function display_vendor_list_excel_link() {
    $file_url = get_shared_metafield_value();
    if ($file_url) {
        $download_url = add_query_arg('download_excel', '1', admin_url('admin-post.php'));
        echo '<a href="' . esc_url($download_url) . '">Download Vendor List Excel</a>';
    }
}

// ====== csv to post =============
add_action('admin_menu', 'csv_to_post_menu');

function csv_to_post_menu() {
    add_submenu_page('edit.php?post_type=vendor_list', 'CSV to Vendor List', 'CSV to Vendor List', 'manage_options', 'csv-to-post', 'csv_to_post_page');
}

// Create admin page
function csv_to_post_page() {
    ?>
    <div class="wrap">
        <h1>CSV to Vendor List</h1>
        <b>CSV Format : </b>
        <em>Name, Content, Contat No, Email, Address, City, State, Zip, Website Link, Category</em>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="csv_file" accept=".csv">
            <input type="submit" name="submit" value="Import CSV">
        </form>
    </div>
    <?php
    if (isset($_POST['submit'])) {
        process_csv($_FILES['csv_file']['tmp_name']);
    }
}

// Process CSV file
function process_csv($file) {
    if (($handle = fopen($file, "r")) !== FALSE) {
        fgetcsv($handle, 1000, ",");
        
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (empty($data[0]) && empty($data[1])) {
                continue; 
            }
            
            $title = sanitize_text_field($data[0]);
            $content = wp_kses_post($data[1]);
            $contact_num = $data[2];
            $email = $data[3];
            $address = $data[4];
            $city = $data[5];
            $state = $data[6];
            $zip = $data[7];
            $website = $data[8];
            $category = $data[9];
            // $aspire = $data[10];

            $existing_post = get_page_by_title($title, OBJECT, 'vendor_list');
            
            if ($existing_post) {
                echo "Post already exists: $title<br>";
                continue;
            }
            
            $post_id = wp_insert_post(array(
                'post_title'    => $title,
                'post_content'  => $content,
                'post_status'   => 'publish',
                'post_author'   => get_current_user_id(),
                'post_type'     => 'vendor_list'
            ));

            echo $aspire . "<br>";
            
            update_post_meta($post_id, 'contact_no', $contact_num);
            update_post_meta($post_id, 'email', $email);
            update_post_meta($post_id, 'address', $address);
            update_post_meta($post_id, 'city', $city);
            update_post_meta($post_id, 'state', $state);
            update_post_meta($post_id, 'website_link', $website);
            update_post_meta($post_id, 'category', $category);
            update_post_meta($post_id, 'zip_code', $zip);
            // update_post_meta($post_id, 'aspire_vendor', sanitize_text_field($aspire) );
            // if($aspire == 'Yes' || $aspire == 'yes'){
            //     update_post_meta($post_id, 'aspire_vendor', 'yes' );
            // }else{
            //     update_post_meta($post_id, 'aspire_vendor', 'no' );
            // }

        }
        fclose($handle);
    }
}