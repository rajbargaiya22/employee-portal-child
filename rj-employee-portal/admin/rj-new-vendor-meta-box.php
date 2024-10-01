<?php 
// New vendor meta box for pdf uploading

function add_pdf_repeater_meta_box() {
    add_meta_box(
        'pdf_repeater_meta_box',
        'PDF Uploads',
        'render_pdf_repeater_meta_box',
        'new_vendor', // Change this to the post type you want to add the meta box to
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_pdf_repeater_meta_box');

function render_pdf_repeater_meta_box($post) {
    wp_nonce_field(basename(__FILE__), 'pdf_repeater_nonce');
    $pdf_data = get_post_meta($post->ID, 'pdf_repeater', true);
    ?>
    <div id="pdf_repeater_container">
        <?php
        if (!empty($pdf_data)) {
            foreach ($pdf_data as $index => $item) {
                ?>
                <div class="pdf-item">
                    <p>
                        <label for="pdf_title_<?php echo $index; ?>">Title:</label>
                        <input type="text" name="pdf_repeater[<?php echo $index; ?>][title]" id="pdf_title_<?php echo $index; ?>" value="<?php echo esc_attr($item['title']); ?>" />
                    </p>
                    <p>
                        <label for="pdf_upload_<?php echo $index; ?>">PDF URL:</label>
                        <input type="text" name="pdf_repeater[<?php echo $index; ?>][url]" id="pdf_upload_<?php echo $index; ?>" value="<?php echo esc_url($item['url']); ?>" />
                        <button class="upload_pdf_button button">Upload PDF</button>
                    </p>
                    <button class="remove_pdf_button button">Remove</button>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <button id="add_pdf_button" class="button">Add PDF</button>

    <script>
    jQuery(document).ready(function($) {
        var container = $('#pdf_repeater_container');
        var addButton = $('#add_pdf_button');
        var index = <?php echo !empty($pdf_data) ? max(array_keys($pdf_data)) + 1 : 0; ?>;

        addButton.on('click', function(e) {
            e.preventDefault();
            addPdfItem();
        });

        container.on('click', '.upload_pdf_button', function(e) {
            e.preventDefault();
            var button = $(this);
            var customUploader = wp.media({
                title: 'Upload PDF',
                button: { text: 'Use this PDF' },
                multiple: false,
                library: { type: 'application/pdf' }
            }).on('select', function() {
                var attachment = customUploader.state().get('selection').first().toJSON();
                button.prev('input').val(attachment.url);
            }).open();
        });

        container.on('click', '.remove_pdf_button', function(e) {
            e.preventDefault();
            $(this).closest('.pdf-item').remove();
        });

        function addPdfItem() {
            var item = $('<div class="pdf-item">' +
                '<p><label for="pdf_title_' + index + '">Title:</label> ' +
                '<input type="text" name="pdf_repeater[' + index + '][title]" id="pdf_title_' + index + '" /></p>' +
                '<p><label for="pdf_upload_' + index + '">PDF URL:</label> ' +
                '<input type="text" name="pdf_repeater[' + index + '][url]" id="pdf_upload_' + index + '" />' +
                '<button class="upload_pdf_button button">Upload PDF</button></p>' +
                '<button class="remove_pdf_button button">Remove</button>' +
                '</div>');
            container.append(item);
            index++;
        }
    });
    </script>
    <?php
}


function save_pdf_repeater_meta($post_id) {
    if (!isset($_POST['pdf_repeater_nonce']) || !wp_verify_nonce($_POST['pdf_repeater_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    if (isset($_POST['pdf_repeater'])) {
        $pdf_data = array();
        foreach ($_POST['pdf_repeater'] as $item) {
            if (!empty($item['title']) && !empty($item['url'])) {
                $pdf_data[] = array(
                    'title' => sanitize_text_field($item['title']),
                    'url' => esc_url_raw($item['url'])
                );
            }
        }
        update_post_meta($post_id, 'pdf_repeater', $pdf_data);
    } else {
        delete_post_meta($post_id, 'pdf_repeater');
    }
}
add_action('save_post', 'save_pdf_repeater_meta');