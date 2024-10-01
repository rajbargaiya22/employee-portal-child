<?php
/*
* Template Name: Company Newsletter
*
*
* @package astra-child
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header(); 
	if (is_user_logged_in()) { ?>

<main id="rj-newsletter" class="rj-main">
	<div class="container">

		<div class="new-vendor-heading">
			<h1 class="rj-main-heading">Company Newsletter</h1>

			<a href="<?php echo esc_url(get_the_permalink(get_page_by_title('Upload Newsletter'))); ?>" class="rj-read-more">
				Upload Newsletter
			</a>
		</div>

		<div class="row">
			<?php if ( have_posts() ) :
				$rj_newsletter_paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				$rj_bookmarks_args = array(
					'paged' => $rj_newsletter_paged,
					'post_type' => 'company_newsletter',
				);
				$rj_newsletter_query = new WP_Query( $rj_bookmarks_args );
				while($rj_newsletter_query->have_posts()) :
					$rj_newsletter_query->the_post(); ?>

					<article class="col-lg-4 col-md-6 mb-4">
                        <div class="rj-post-container">
                           <?php $image_id = get_post_thumbnail_id();
                            $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
                            $image_title = get_the_title($image_id); 
							
                            $multiple_images = get_post_meta($post->ID, '_custom_image_ids', true);
    						$multiple_images = $multiple_images ? explode(',', $multiple_images) : array();

							if(count($multiple_images) > 0){ ?>
								<div class="newsletter-carousel">
									
									<img class="post-thumb" src="<?php echo esc_url(get_the_post_thumbnail_url( get_the_ID(), 'medium' )); ?>" alt="<?php echo esc_attr(($image_alt) ? $image_alt : get_the_title() ); ?>" title="<?php echo esc_attr(($image_title) ? $image_title : get_the_title() ); ?>">

									<?php
										foreach ($multiple_images as $single_id) : ?>
											<img class="post-thumb" src="<?php echo esc_url(wp_get_attachment_image_url( $single_id, 'medium' )); ?>" alt="<?php echo esc_attr(($image_alt) ? $image_alt : get_the_title() ); ?>" title="<?php echo esc_attr(($image_title) ? $image_title : get_the_title() ); ?>">
											<?php
										endforeach; ?>
								</div>
								
								<?php 	
							}else{ ?>
								<img class="post-thumb" src="<?php echo esc_url(get_the_post_thumbnail_url( get_the_ID(), 'medium' )); ?>" alt="<?php echo esc_attr(($image_alt) ? $image_alt : get_the_title() ); ?>" title="<?php echo esc_attr(($image_title) ? $image_title : get_the_title() ); ?>">
							<?php } ?>

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

								<time datetime="<?php echo esc_attr(get_the_date()); ?>">
									<?php echo esc_html(get_the_date()); ?>
								</time>
                            </div>
                        </div>
                    </article>

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

			<h2 class="rj-main-heading">Monthly Newsletter</h2>

			<?php if ( have_posts() ) :
				$rj_monthly_newsletter_args = array(
					'post_type' => 'monthly_newsletter',
					'posts_per_page' => -1
				);
				$rj_monthly_newsletter_query = new WP_Query( $rj_monthly_newsletter_args ); ?>

				<div class="rj-monthly-newsletter">
					<?php while($rj_monthly_newsletter_query->have_posts()) :
						$rj_monthly_newsletter_query->the_post(); ?>
						<a href="<?php echo get_the_permalink(); ?>">
							<?php echo get_the_date('F') . " " . get_the_date('Y');  ?>
						</a>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			<?php else : ?>
				<h3><?php esc_html_e('No monthly newsletter found','astra-child'); ?></h3>
			<?php endif; ?>
		</div>
	</div>
</main>


<?php 
	}else{
		get_template_part('/rj-employee-portal/template-parts/custom-login-form');
	}
get_footer(); ?>