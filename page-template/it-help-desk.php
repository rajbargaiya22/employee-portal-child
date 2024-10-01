<?php
/*
* Template Name: IT Help Desk
*
*
* @package astra-child
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header(); ?>


<main class="rj-main">
    <div class="container">
    
        <div class="row">
            <div class="col-md-7 it-help-box">
                <div>

                    <h1 class="rj-main-heading">IT Help Desk</h1> 

                    <p> 
                        <b>
                            <?php echo esc_html(get_theme_mod('rj_employee_portal_help_desk_subhead', 'Need It Support? Please contact the IT Helpdesk')); ?>
                        </b>
                    </p>

                    <p>
                        <b><?php echo esc_html(get_theme_mod('rj_employee_portal_help_desk_contact_text', 'Phone : ')); ?></b>
                        <a href="tel:<?php echo esc_attr(get_theme_mod('rj_employee_portal_help_desk_contact_num', '888-585-0202')); ?>">
                            <?php echo esc_html(get_theme_mod('rj_employee_portal_help_desk_contact_num', '888-585-0202')); ?>
                        </a>
                    </p>

                    <p>
                        <?php echo esc_html(get_theme_mod('rj_employee_portal_help_desk_text', 'Option 2 for support, then 1 for IT support')); ?>
                    </p>

                    <p>
                        <b><?php echo esc_html(get_theme_mod('rj_employee_portal_help_desk_mail_text', 'Email : ')); ?></b>
                        <a href="mailto:<?php echo esc_attr(get_theme_mod('rj_employee_portal_help_desk_mail', 'support@spar.com')); ?>">
                            <?php echo esc_html(get_theme_mod('rj_employee_portal_help_desk_mail', 'support@spar.com')); ?>
                        </a>
                    </p>

                    <p>
                        <strong>
                            <?php echo esc_html(get_theme_mod('rj_employee_portal_help_desk_person', 'Henry Grablewski')); ?>
                        </strong>
                        <?php echo esc_html(get_theme_mod('rj_employee_portal_help_desk_person_designation', 'Down To Earth Director of IT')); ?>
                    </p>

                    <p>
                        <b><?php echo esc_html(get_theme_mod('rj_employee_portal_help_desk_office_contact_text', 'Phone : ')); ?></b>
                        <a href="tel:<?php echo esc_attr(get_theme_mod('rj_employee_portal_help_desk_office_contact_num', '407-637-7355')); ?>">
                            <?php echo esc_html(get_theme_mod('rj_employee_portal_help_desk_office_contact_num', '407-637-7355')); ?>
                        </a>
                    </p>
                
                    <p>
                        <b><?php echo esc_html(get_theme_mod('rj_employee_portal_help_desk_mobile_contact_text', 'Mobile : ')); ?></b>
                        <a href="tel:<?php echo esc_attr(get_theme_mod('rj_employee_portal_help_desk_mobile_contact_num', '689-500-8765')); ?>">
                            <?php echo esc_html(get_theme_mod('rj_employee_portal_help_desk_mobile_contact_num', '689-500-8765')); ?>
                        </a>
                    </p>

                    <a href="http://maps.google.com/maps?q=<?php echo esc_attr(get_theme_mod('rj_employee_portal_help_desk_address', '500 Winderley Place Suite 222 Maitland, FL 32751')); ?>" target="_blank">
                        <?php echo esc_html(get_theme_mod('rj_employee_portal_help_desk_address', '500 Winderley Place Suite 222 Maitland, FL 32751')); ?>
                    </a>
                </div>
            </div>
            <div class="col-md-5">
                <img src="<?php echo esc_url(get_stylesheet_directory_uri(). '/assets/images/it-help-desk.png'); ?>" alt="">
            </div>
        </div>

        <div class="contact-page-forms">
            <a href="https://employee-portal.dhaninfo.net/wp-content/uploads/2024/08/IT-Support-Contact-Information-1.docx" class="rj-read-more" download target="_blank">
                IT-Support-Contact-Information
            </a>
            <a href="https://forms.office.com/r/2Nvv1APUJQ" class="rj-read-more" target="_blank">IT New Hire Form</a>
            <a href="https://forms.office.com/pages/responsepage.aspx?id=oFraijPWDkmsihMRQ9JsWIAI2UruqShKildMVSu6u45URDUxWE5aODFRNlJGWTAxVEtKMVU4WElDNi4u&route=shorturl" class="rj-read-more" target="_blank">IT Support Feedback Form</a>
        </div>
    </div>
</main>

<?php get_footer(); 