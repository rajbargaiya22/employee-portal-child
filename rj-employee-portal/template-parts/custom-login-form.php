<?php 
/*
* Custom login form   
*/ ?>

<main class="rj-main">
    <div class="container" >
        <h1 class="rj-main-heading text-center">All Employees</h1>
        <p>You must have been issued a username and password to access this page.
        To obtain access, please contact Amanda Perez in Procurement.</p>

        <div style="max-width: 400px; margin: auto">
        <?php
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
        ?>
        </div>
    </div>
</main>