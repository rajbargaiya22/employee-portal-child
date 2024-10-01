<?php
/*
* Template Name: Company Policy
*
*
* @package astra-child
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header(); 
if (is_user_logged_in()) {
?>


<div id="rj-newsletter" class="rj-main">
	<div class="container">
    <h1 class="rj-main-heading">Company Policy</h1>
    	<div class="row">
				<?php if ( have_posts() ) :
		      $rj_newsletter_paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
					$rj_bookmarks_args = array(
						'paged' => $rj_newsletter_paged,
                        'post_type' => 'dte_policy',
					);
					$rj_newsletter_query = new WP_Query( $rj_bookmarks_args );
					while($rj_newsletter_query->have_posts()) :
					   $rj_newsletter_query->the_post();
						 ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="rj-post-container">
                            <?php $image_id = get_post_thumbnail_id();
                            $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
                            $image_title = get_the_title($image_id); ?>
                            <img class="post-thumb" src="<?php echo esc_url(get_the_post_thumbnail_url( get_the_ID(), 'medium' )); ?>" alt="<?php echo esc_attr(($image_alt) ? $image_alt : get_the_title() ); ?>" title="<?php echo esc_attr(($image_title) ? $image_title : get_the_title() ); ?>">

                            <div class="rj-post-content">                                   
                                <h2>
									<a href="<?php echo get_the_permalink(); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
										<?php echo get_the_title(); ?>
									</a>
								</h2>  
                                <p class="rj-post-desc"><?php echo get_the_content(); ?></p>

                                <a href="<?php echo get_the_permalink(); ?>" title="<?php echo esc_attr(get_the_title()); ?>" class="rj-read-more">
									<?php echo esc_html('Read More', 'astra-child'); ?>
								</a>

                                <?php
                                $pdf_url = get_post_meta(get_the_ID(), 'pdf_upload', true);
                                /* if ($pdf_url) {
                                     echo '<a href="' . esc_url($pdf_url) . '" target="_blank">Download PDF</a>';
                                     } 
                                     <embed src="<?php echo esc_url($pdf_url) ?>" type="application/pdf" width="100%" height="400px" /> 
    
                                    <object data="<?php echo esc_url($pdf_url) ?>" type="application/pdf" width="100%" height="600px">
                                        <p>Your browser doesn't support PDF viewing. Please download the PDF to view it: <a href="path/to/your/file.pdf">Download PDF</a>.</p>
                                    </object>
    
    
                                    <iframe src="<?php echo esc_url($pdf_url) ?>" width="100%" height="600px">
                                        <p>Your browser doesn't support iframes. Please download the PDF to view it: <a href="path/to/your/file.pdf">Download PDF</a>.</p>
                                    </iframe>
                                     */
                                 ?>


                            </div>
                        </div>
                    </div>
            <?php endwhile; wp_reset_postdata(); ?>
					</div>
					<div class="rj-post-navigation">
						<?php
							$big = 999999999;
							echo paginate_links( array(
								'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
								'format' => 'paged=%#%',
								'current' =>  (get_query_var('paged') ? get_query_var('paged') : 1),
								'total' => $rj_newsletter_query->max_num_pages
							) );
						?>
					</div>
			<?php else : ?>
				<h3><?php esc_html_e('No posts found','astra-child'); ?></h3>
			<?php endif; ?>
	</div>
</div>

<?php 
}else{
	get_template_part('/rj-employee-portal/template-parts/custom-login-form');
}
get_footer(); 