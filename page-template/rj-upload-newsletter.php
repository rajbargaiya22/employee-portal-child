<?php
/*
 * Template Name: Upload Newsletter
 *
 * @package astra-child
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();


if (is_user_logged_in()) { ?>

<div id="upload-newsletter" class="rj-main">
    <div class="container">
        <h1 class="rj-main-heading">Upload Newsletter</h1>
    
        <form id="frontend-post-form" class="frontend-post-form" method="post" enctype="multipart/form-data">
            <label for="post_title">Post Title</label>
            <input type="text" name="post_title" id="post_title" placeholder="Post Title" required>

            <label for="post_content">Post Content</label>
            <textarea name="post_content" id="post_content" placeholder="Post Content" required></textarea>

            <label for="post_images">Upload Images

                <span class="news-images-btn">Select Images</span>
            </label>
            <input type="file" name="post_images[]" id="post_images" accept="image/*" multiple>
            <input type="submit" value="Submit Post">
            <?php wp_nonce_field('frontend_post_nonce', 'frontend_post_nonce_field'); ?>
        </form>

    </div>
</div>

<?php 
}else{
    get_template_part('/rj-employee-portal/template-parts/custom-login-form');
} 
 get_footer(); ?>