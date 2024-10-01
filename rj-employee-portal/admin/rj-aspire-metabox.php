<?php
function rj_employee_portal_add_aspire_metafields_box() {
    add_meta_box(
        'rj_employee_portal_aspire_metafields_box',
        'Aspire Details',
        'rj_employee_portal_add_aspire_metafields_callback',
        'aspire',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'rj_employee_portal_add_aspire_metafields_box');

// Meta box callback function
function rj_employee_portal_add_aspire_metafields_callback($post) {
    wp_nonce_field('rj_ep_aspire_metafields_nonce', 'rj_ep_aspire_metafields_nonce');
   
    $number_of_fields = get_post_meta($post->ID, '_number_of_fields', true);
    $field_values = get_post_meta($post->ID, '_dynamic_field_values', true);
    ?>
    <p class="rj-em-heading-num">
        <label for="number_of_fields">Number of fields:</label>
        <input type="number" id="number_of_fields" name="number_of_fields" value="<?php echo esc_attr($number_of_fields); ?>" min="0">
        <button type="button" id="generate_fields">Generate Fields</button>
    </p>
    <div id="rj_ep_aspire_headings">
        <?php
        if ($number_of_fields && $field_values) {
            for ($i = 0; $i < $number_of_fields; $i++) {
                $heading = isset($field_values[$i]['heading']) ? $field_values[$i]['heading'] : '';
                $subheadings = isset($field_values[$i]['subheadings']) ? $field_values[$i]['subheadings'] : array();
                $urls = isset($field_values[$i]['urls']) ? $field_values[$i]['urls'] : array();
                
                echo '<div class="rj_ep_aspire_field_group">';
                echo '<p>';
                echo '<label for="rj_ep_aspire_label_' . $i . '">Heading:</label> ';
                echo '<input type="text" id="rj_ep_aspire_label_' . $i . '" name="rj_ep_aspire_headings[' . $i . '][heading]" value="' . esc_attr($heading) . '">';
                echo '</p>';
                echo '<div class="subfields-container">';
                if (!empty($subheadings)) {
                    foreach ($subheadings as $key => $subheading) {
                        echo '<p>';
                        echo '<label>Subheading:</label><input type="text" name="rj_ep_aspire_headings[' . $i . '][subheadings][]" value="' . esc_attr($subheading) . '"> ';
                        echo '</p>';
                        echo '<p>';
                        echo '<label>URL: </label><input type="text" name="rj_ep_aspire_headings[' . $i . '][urls][]" value="' . esc_attr($urls[$key]) . '">';
                        echo '</p>';
                    }
                }
                echo '</div>';
                echo '<button type="button" class="add_subfields" data-group="' . $i . '">Add Subfields</button>';
                echo '</div>';
            }
        }
        ?>
    </div>
    <button type="button" id="add_more_fields">Add More Headings</button>

    <script>
    jQuery(document).ready(function($) {
        var fieldCounter = <?php echo intval($number_of_fields); ?>;

        function addSubfields(groupId) {
            var container = $('#rj_ep_aspire_headings .rj_ep_aspire_field_group').eq(groupId).find('.subfields-container');
            var newFieldsHtml = '<p>' +
                '<label>Subheading:</label><input type="text" name="rj_ep_aspire_headings[' + groupId + '][subheadings][]" value=""> ' + '</p><p>' +
                '<label>URL: </label><input type="text" name="rj_ep_aspire_headings[' + groupId + '][urls][]" value="">' +
                '</p>';
            container.append(newFieldsHtml);
        }

        $('#generate_fields').on('click', function() {
            var number = parseInt($('#number_of_fields').val());
            var fieldsHtml = '';
            var existingFields = $('#rj_ep_aspire_headings .rj_ep_aspire_field_group');
            
            for (var i = 0; i < number; i++) {
                var existingField = (i < existingFields.length) ? $(existingFields[i]) : null;
                var heading = existingField ? existingField.find('input[name^="rj_ep_aspire_headings"][name$="[heading]"]').val() : '';
                var subfieldsHtml = existingField ? existingField.find('.subfields-container').html() : '';

                fieldsHtml += '<div class="rj_ep_aspire_field_group"><p>' +
                    '<label for="rj_ep_aspire_label_' + i + '">Heading:</label> ' +
                    '<input type="text" id="rj_ep_aspire_label_' + i + '" name="rj_ep_aspire_headings[' + i + '][heading]" value="' + heading + '">' +
                    '</p><div class="subfields-container">' + subfieldsHtml + '</div>' +
                    '<button type="button" class="add_subfields" data-group="' + i + '">Add Subfields</button></div>';
            }
            $('#rj_ep_aspire_headings').html(fieldsHtml);
            fieldCounter = number;
        });

        $('#add_more_fields').on('click', function() {
            var newFieldsHtml = '<div class="rj_ep_aspire_field_group"><p>' +
                '<label for="rj_ep_aspire_label_' + fieldCounter + '">Heading:</label> ' +
                '<input type="text" id="rj_ep_aspire_label_' + fieldCounter + '" name="rj_ep_aspire_headings[' + fieldCounter + '][heading]" value="">' +
                '</p><div class="subfields-container"></div><button type="button" class="add_subfields" data-group="' + fieldCounter + '">Add Subfields</button> </div>';
            $('#rj_ep_aspire_headings').append(newFieldsHtml);
            fieldCounter++;
            $('#number_of_fields').val(fieldCounter);
        });

        $(document).on('click', '.add_subfields', function() {
            var groupId = $(this).data('group');
            addSubfields(groupId);
        });
    });
    </script>
    <?php
}

// Save meta box data
function save_rj_ep_aspire_metafields($post_id) {
    if (!isset($_POST['rj_ep_aspire_metafields_nonce']) ||
        !wp_verify_nonce($_POST['rj_ep_aspire_metafields_nonce'], 'rj_ep_aspire_metafields_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    if (isset($_POST['number_of_fields'])) {
        update_post_meta($post_id, '_number_of_fields', sanitize_text_field($_POST['number_of_fields']));
    }
    if (isset($_POST['rj_ep_aspire_headings'])) {
        $field_values = array();
        foreach ($_POST['rj_ep_aspire_headings'] as $index => $group) {
            $field_values[$index] = array(
                'heading' => sanitize_text_field($group['heading']),
                'subheadings' => isset($group['subheadings']) ? array_map('sanitize_text_field', $group['subheadings']) : array(),
                'urls' => isset($group['urls']) ? array_map('esc_url_raw', $group['urls']) : array()
            );
        }
        update_post_meta($post_id, '_dynamic_field_values', $field_values);
    }
}
add_action('save_post', 'save_rj_ep_aspire_metafields');