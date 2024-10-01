<?php 
// Register the meta box
function add_multiple_image_uploader_meta_box() {
    add_meta_box(
        'multiple_image_uploader_meta_box',
        'Multiple Image Uploader',
        'render_multiple_image_uploader_meta_box',
        'company_newsletter', // Change this to your post type
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'add_multiple_image_uploader_meta_box');

// Render the meta box content
function render_multiple_image_uploader_meta_box($post) {
    wp_nonce_field(basename(__FILE__), 'multiple_image_uploader_nonce');
    $image_ids = get_post_meta($post->ID, '_custom_image_ids', true);
    $image_ids = $image_ids ? explode(',', $image_ids) : array();
    ?>
    <div class="custom-multiple-image-uploader">
        <div id="image-preview-container">
            <?php foreach ($image_ids as $image_id) : ?>
                <div class="image-preview">
                    <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                    <button class="remove-image" data-id="<?php echo $image_id; ?>">X</button>
                </div>
            <?php endforeach; ?>
        </div>
        <input id="upload_images_button" type="button" class="button" value="Upload Images" />
        <input type="hidden" name="custom_image_ids" id="custom_image_ids" value="<?php echo esc_attr(implode(',', $image_ids)); ?>" />
    </div>
    <script>
   jQuery(document).ready(function($){
    var mediaUploader;
    $('#upload_images_button').click(function(e) {
        e.preventDefault();
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Images',
            button: {
                text: 'Choose Images'
            },
            multiple: true
        });
        mediaUploader.on('select', function() {
            var attachments = mediaUploader.state().get('selection').toJSON();
            var imageIds = $('#custom_image_ids').val() ? $('#custom_image_ids').val().split(',') : [];
            attachments.forEach(function(attachment) {
                if (!imageIds.includes(attachment.id.toString())) {
                    imageIds.push(attachment.id);
                    // Get the best available size
                    var imageUrl = attachment.sizes && attachment.sizes.thumbnail ? 
                                   attachment.sizes.thumbnail.url : 
                                   attachment.sizes && attachment.sizes.full ? 
                                   attachment.sizes.full.url : 
                                   attachment.url;
                    $('#image-preview-container').append(
                        '<div class="image-preview">' +
                        '<img src="' + imageUrl + '" />' +
                        '<button class="remove-image" data-id="' + attachment.id + '">X</button>' +
                        '</div>'
                    );
                }
            });
            $('#custom_image_ids').val(imageIds.join(','));
        });
        mediaUploader.open();
    });

    $(document).on('click', '.remove-image', function() {
        var imageId = $(this).data('id');
        var imageIds = $('#custom_image_ids').val().split(',');
        imageIds = imageIds.filter(function(id) { return id != imageId; });
        $('#custom_image_ids').val(imageIds.join(','));
        $(this).parent('.image-preview').remove();
    });
});
    </script>
    <style>
    .image-preview { 
        display: inline-block; 
        margin: 10px; 
        text-align: center; 
        position: relative;
    }
    .remove-image{
        position: absolute;
        top: 5px;
        right: 5px;

    }

    .image-preview img { max-width: 150px; max-height: 150px; }
    
    </style>
    <?php
}

// Save the image IDs
function save_multiple_image_uploader_meta_box($post_id) {
    if (!isset($_POST['multiple_image_uploader_nonce']) || !wp_verify_nonce($_POST['multiple_image_uploader_nonce'], basename(__FILE__))) {
        return $post_id;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    if (isset($_POST['custom_image_ids'])) {
        update_post_meta($post_id, '_custom_image_ids', sanitize_text_field($_POST['custom_image_ids']));
    }
}
add_action('save_post', 'save_multiple_image_uploader_meta_box');


// Monthly Newsletter
function register_monthly_newsletter_type() {
    $labels = array(
        'name'                  => 'Monthly Newsletters',
        'singular_name'         => 'Monthly Newsletter',
        'menu_name'             => 'Monthly Newsletters',
        'name_admin_bar'        => 'Monthly Newsletter',
        'archives'              => 'ajfashionArchives',
        'attributes'            => 'Item Attributes',
        'parent_item_colon'     => 'Parent Item:',
        'all_items'             => 'Monthly Newsletters',
        'add_new_item'          => 'Add New Monthly Newsletter',
        'add_new'               => 'Add New',
        'new_item'              => 'New Item',
        'edit_item'             => 'Edit Item',
        'update_item'           => 'Update Item',
        'view_item'             => 'View Item',
        'view_items'            => 'View Items',
        'search_items'          => 'Search Item',
        'not_found'             => 'Not found',
        'not_found_in_trash'    => 'Not found in Trash',
        'featured_image'        => 'Featured Image',
        'set_featured_image'    => 'Set featured image',
        'remove_featured_image' => 'Remove featured image',
        'use_featured_image'    => 'Use as featured image',
        'insert_into_item'      => 'Insert into item',
        'uploaded_to_this_item' => 'Uploaded to this item',
        'items_list'            => 'Items list',
        'items_list_navigation' => 'Items list navigation',
        'filter_items_list'     => 'Filter items list',

    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => 'edit.php?post_type=company_newsletter',  // This makes it appear under Posts
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'monthly_newsletter' ),
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'thumbnail', ),
        'has_archive'        => true,
        'exclude_from_search'   => false,
        'publicly_queryable' => true,
        'capability_type'    => 'post',

        'label'                 => 'Monthly Newsletter',
        // 'description'           => 'Post Type Description',
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        'taxonomies'            => array( 'fashion_category' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => 'edit.php?post_type=company_newsletter',
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',

    );

    register_post_type( 'monthly_newsletter', $args );
}
add_action( 'init', 'register_monthly_newsletter_type' );