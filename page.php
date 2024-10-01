<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Astra-child
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); 
if (is_user_logged_in()) {
?>

<article class="rj-single-post">
    <div class="container ">
		<?php if ( have_posts() ) :
				while ( have_posts() ) : the_post(); ?>

			<h1 class="rj-main-heading">
                <?php echo get_the_title(); ?>
            </h1>

			<?php $content = get_the_content();  ?>
                <div class="single-post-content">
                    <?php echo $content; ?>
                </div>

		<?php endwhile; endif;; ?>
	</div>
</article>

<?php
}else{
    get_template_part('/rj-employee-portal/template-parts/custom-login-form');
}
get_footer(); ?>
