<?php
/*
* Template Name: DTE Benefits
*
*
* @package astra-child
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header(); 
if (is_user_logged_in()) { ?>


<main class="rj-dte-benefits">
    <div class="rj-benefits-vif">
        <div class="container">
            <div class="enroll-box">
                <h3>
                    Welcome to your Down to Earth Benefits
                </h3>
                <a href="http://www.dayforcehcm.com" target="_blank">
                    Click to Enroll
                </a>
            </div>
        </div>
    </div>
    <section class="rj-main">
        <div class="container">
        <h1 class="rj-main-heading">About Your Benefits</h1> 

        <div class="row">

        <?php
                $rj_benfits_paged = get_query_var('paged') ? get_query_var('paged') : 1;
                $rj_benefits_args = array(
                    'paged' => $rj_benfits_paged,
                    'post_type' => 'dte_benefits',
                    // 'posts_per_page' => 9, // Add this line to set number of posts per page
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'language', 
                            'terms' => 'english',
                            'field' => 'slug',
                        )
                    ),
                );
                $rj_benfits_query = new WP_Query($rj_benefits_args);

                while ($rj_benfits_query->have_posts()) :
                    $rj_benfits_query->the_post(); ?>
                
                    <article class="col-lg-4 col-md-6 mb-4">
                        <div class="rj-post-container">
                            <?php if (has_post_thumbnail()) : ?>
                                <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>" 
                                    alt="<?php echo esc_attr($image_alt ?: get_the_title()); ?>" 
                                    title="<?php echo esc_attr($image_title ?: get_the_title()); ?>"
                                    class="post-thumb">
                            <?php endif; ?>

                            
                            <div class="rj-post-content">                                   
                                <h2>
                                    <?php echo get_the_title(); ?>
                                </h2>  

                                <div class="rj-post-desc">
                                    <?php echo get_the_content(); ?>
                                </div>    
                                
                                <?php if(get_post_meta($post->ID, 'button_text', true ) !=''){ ?>
                                <!-- <a href="<?php //echo esc_url(get_post_meta($post->ID, '_pdf_url', true )); ?>" target="_blank"> -->
                                <a href="<?php echo esc_url(get_the_permalink()); ?>" class="rj-read-more">
                                        <?php echo esc_html(get_post_meta($post->ID, 'button_text', true )); ?>
                                </a>
                                <?php } ?>
                            </div>
                        </div>
                    </article>

            <?php endwhile; ?>

            </div>
        </div>
    </section>

    <section class="rj-need-help">
        <div class="container">

            <h2>need help with your MEDICAL COVERAGE? Call the VITORI CONCIERGE at 1.866.661.2553</h2>                              
        </div>
    </section>

    <section class="accessing-benefits-sec">
        <div class="container">
            <h2 class="rj-main-heading">ACCESSING YOUR BenefitS</h2>

            <div class="row">
                <div class="col-md-6">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/accessing-image.webp' ?>" alt="">
                </div>
                <div class="col-md-6 text-align-center">
                    <h3 class="rj-enrollment">The Benefits Enrollment Site</h3>
                    <p class="rj-enrollment-text">Benefits is now part of the payroll and HR system!  To visit the enrollment site, click "Login to Your Benefits" in the menu at the top of any page to be sent to the Dayforce website to login.</p>
                    <p>
                    You can also visit <a href="www.dayforcehcm.com" target="_blank">www.dayforcehcm.com</a> or download the Dayforce app to access your payroll and benefits.
                    </p>

                    <span class="access-line">---------------------------------------------------------</span>

                    <h3>The Mobile Wallet</h3>
                    
                    <p>
                    My Mobile Wallet is the easy way to find your benefits contact information, from any device, wherever you are.  The mobile wallet allows you to see more information on any benefit including group numbers, phone numbers, e-mail addresses, websites, and more.  Visit <a href="https://dtebenefits.com/view-my-mobile-wallet" target="_blank">https://dtebenefits.com/view-my-mobile-wallet</a> and bookmark the site today! 
                    </p>
                </div>
            </div>

        </div>
    </section>

    <section class="benefits-id-cards">
        <div class="container">
            <h2 class="rj-main-heading">Getting copies of Your benefits ID cards</h2>

            <?php if ( have_posts() ) :
                $rj_id_cards_args = array(
                    'post_type' => 'benefits_id_cards'
                );
                $rj_id_cards_query = new WP_Query( $rj_id_cards_args ); ?>
                <div class="row">
                    <?php while($rj_id_cards_query->have_posts()) :
                    $rj_id_cards_query->the_post(); ?>
                        <div class="col-md-4 id-benefits-cards">
                            <h3><?php echo get_the_title(); ?></h3>
                            <p><?php echo get_the_content(); ?></p>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <h3><?php esc_html_e('No posts found','astra-child'); ?></h3>
            <?php endif; ?>
            
        </div>
    </section>

    <section class="access-benefits-enrollment">
        <div class="container">
            <h3>Access the benefits enrollment website to sign up for benefits or view your current elections here:</h3>
            <a href="">Login to your benefits</a>
        </div>
    </section>

    <section class="other-benefits">
        <div class="container">
            <h2 class="rj-main-heading">Other Benefits</h2>
        <?php if ( have_posts() ) :
                $rj_id_cards_args = array(
                    'post_type' => 'other_benefits'
                );
                $rj_id_cards_query = new WP_Query( $rj_id_cards_args ); ?>
                <div class="row">
                    <?php while($rj_id_cards_query->have_posts()) :
                    $rj_id_cards_query->the_post(); ?>
                        <div class="col-md-4 id-benefits-cards">
                            <h3><?php echo get_the_title(); ?></h3>

                            <?php $image_id = get_post_thumbnail_id();
                                $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
                                $image_title = get_the_title($image_id); ?>
                                <img class="post-thumb" src="<?php echo esc_url(get_the_post_thumbnail_url( get_the_ID(), 'medium' )); ?>" alt="<?php echo esc_attr(($image_alt) ? $image_alt : get_the_title() ); ?>" title="<?php echo esc_attr(($image_title) ? $image_title : get_the_title() ); ?>">


                            <p><?php echo get_the_content(); ?></p>

                            <a href="<?php echo get_post_meta(get_the_ID(), 'button_text', true); ?>" class="rj-read-more">
                                <?php echo get_post_meta(get_the_ID(), 'button_link', true); ?>
                            </a>

                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <h3><?php esc_html_e('No posts found','astra-child'); ?></h3>
            <?php endif; ?>
        </div>
    </section>

    <section class="dte-care-fund">
        <div class="container">
            <h2 class="rj-main-heading">NEW – DTE I Care Fund is now live! </h2>
            <div class="row">
                <div class="col-md-5">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/dte-care-fund.webp' ?>" alt="">
                </div>
                <div class="col-md-7">
                    <p>During our recent Open Enrollment period, you were offered the opportunity to contribute to the DTE I Care Fund.  This fund is designed to help our valued team members during times of personal crisis using donations from fellow team members and the company.  A grant of up to $1,000 can be given to a team member to help cover funeral expenses or a home catastrophe.  The fund can also match up to $500 for money raised by our employees for a team member in need.  </p>

                    <h3>To Apply for Funds:</h3>

                    <p>You can call Helping HandsTM at 706.754.6884 (Mention you are with Down to Earth) or visit the More Benefits Information page below to get a copy of the Application and Flyer for this program to submit to ICare@down2earthinc.com.</p>

                    <h3>Contribution Changes:</h3>
                    <p>If you want to sign up to contribute to the fund outside of a benefits enrollment period, you can email the I Care deduction request form to ICare@down2earthinc.com to have the deduction started.  Forms can be found on the DTE I Care Fund page.  All contributions are tax-deductible and additional or one-time contributions can be made directly to the fund by check sent to Provision Bridge, PO Box 157, Tallulah Falls, GA 30573 (Note:  Down to Earth I Care Fund – Fund #16085 on the memo).</p>
                </div>
            </div>
        </div>
    </section>

    <section class="goAlerts">
        <h2 class="rj-main-heading">goAlerts</h2>
        <a href="">Go to the Hot Topics</a>
    </section>

    <section class="benefits-contact-us">
        <div class="container">
            <h2 class="rj-main-heading">Contact the Down to Earth Team</h2>
            <div class="row">
                <div class="col-md-6">
                    <h3>Address</h3>
                    <a href=""> 2701 Maitland Center Parkway, Suite 200 Maitland, FL 32751</a>
                </div>
                <div class="col-md-6">
                    <h3>Email</h3>
                    <p>Benefits: <a href="mailto:benefits@down2earthinc.com">benefits@down2earthinc.com</a></p>
                    <p>Payroll: <a href="mailto:D2EPayroll@down2earthinc.com">D2EPayroll@down2earthinc.com</a></p>
                </div>
                <div class="col-md-6">
                    <h3>Phone</h3>
                    <a href =""> 321.263.2700 - Monday-Friday 9am-5pm EST</a>
                    
                </div>
                <div class="col-md-6">
                    <h3>Mobile Wallet</h3>
                    <a href="">https://dtebenefits.com/view-my-mobile-wallet</a>
                    <p>Visit and bookmark the site today!</p>
                </div>
            </div>
        </div>
    </section>

<main>

<?php 
}else{
    get_template_part('/rj-employee-portal/template-parts/custom-login-form');
}
get_footer(); 