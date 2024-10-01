<?php
function rj_employee_posrtal_add_custom_roles() {

    $roles = array(
            'Employees', 
            'Regionals', 
            'Branch Managers', 
            'Office Managers', 
            'Accounting', 
        );

    foreach ($roles as $key => $role) {
        add_role(
            strtolower(str_replace(' ', '-', $role)),
            $role,
            array(
                'read' => true,
                'edit_posts' => true,
                'delete_posts' => false,
                // Add more capabilities as needed
            )
        );
    }
}
add_action('init', 'rj_employee_posrtal_add_custom_roles');




// adding the location fields in user form 
function add_custom_user_fields($operation) {
    if ($operation !== 'add-new-user') return;
    ?>
    <h3>Additional Information</h3>
    <table class="form-table">
        <tr>
            <th><label for="location">Location</label></th>
            <!-- <td>
                <input type="text" name="location" id="location" class="regular-text" />
            </td> -->
            <td>
                <select name="location" id="location" class="regular-text">
                    <option value="">Select Location</option>
                    <option value="north_region">North Region</option>
                    <option value="central_region">Central Region</option>
                    <option value="southeast-region">Southeast Region</option>
                    <option value="west_region">West Region</option>
                    <option value="sw_region">SW Region</option>
                    <option value="west_region">West Region</option>
                    <option value="west_region">West Region</option>
                    
                </select>
            </td>
        </tr>
    </table>
    <?php
}
add_action('user_new_form', 'add_custom_user_fields');

function save_custom_user_fields($user_id) {    
    if (isset($_POST['location'])) {
        update_user_meta($user_id, 'location', sanitize_text_field($_POST['location']));
    }
}
add_action('user_register', 'save_custom_user_fields');

function add_custom_user_columns($columns) {
    $columns['location'] = 'Location';
    return $columns;
}
add_filter('manage_users_columns', 'add_custom_user_columns');

function display_custom_user_columns($value, $column_name, $user_id) {
    switch ($column_name) {
        case 'location':
            return get_user_meta($user_id, 'location', true);
        default:
            return $value;
    }
}
add_filter('manage_users_custom_column', 'display_custom_user_columns', 10, 3);
