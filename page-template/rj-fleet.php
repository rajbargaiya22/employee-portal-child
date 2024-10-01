<?php
/*
* Template Name: Fleet
*
*
* @package astra-child
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();  
if (is_user_logged_in()) { ?>
    <main>
        <div class="container">
        <h1 class="rj-main-heading">Fleet</h1>

            <div style="display: flex; gap: 15px">
                <a href="https://cloud.samsara.com/signin" target="_blank" class="rj-read-more">Samsara</a>
                <a href="https://secure.fleetio.com/users/sign_in" target="_blank" class="rj-read-more">Fleetio</a>
            </div>

            <?php $content = get_the_content();  ?>
            <div class="single-post-content">
                <?php echo $content; ?>
            </div>
        </div>
    </main>
<?php 
}else{
    get_template_part('/rj-employee-portal/template-parts/custom-login-form');
}
get_footer(); ?>