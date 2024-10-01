<?php
/*
* Template Name: HR Benefits
*
*
* @package astra-child
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();  

if (is_user_logged_in()) { ?>

	<main class="rj-main">
		<div class="container">
			<div>
				

				<div class="row">
					<div class="col-md-6">
						<h1 class="rj-main-heading">
							<?php echo esc_html_e('Human Resources & Benefits', 'astra-child'); ?>
						</h1>
					</div>
					<div class="col-md-6">
						<div class="hr-benefits-grid">
							<a href="https://www.dayforcehcm.com/mydayforce/login.aspx" target="_blank" class="hr-option">
								<?php echo esc_html_e('Dayforce', 'astra-child'); ?>
							</a>
							<a href="<?php echo esc_url(get_permalink(get_page_by_title('Company Policy'))); ?>" class="hr-option"> 
								<?php echo esc_html_e('Company Policies', 'astra-child'); ?>
							</a>
							<?php /*
							<a href="<?php echo esc_url(get_permalink(get_page_by_title('New vendor'))); ?>" class="hr-option">
								<?php echo esc_html_e('New Vendor Request', 'astra-child'); ?>
							</a>
							*/ ?>

							<a href="<?php echo esc_url(get_permalink(get_page_by_title('DTE Benefits'))); ?>" class="hr-option">
								<?php echo esc_html_e('DTE Benefits', 'astra-child'); ?>
							</a>

							<?php /*
							<button id="" data-bs-toggle="modal" href="#rj-dte-benefits" role="button" class="hr-option">
								<?php echo esc_html_e('DTE Benefits', 'astra-child'); ?>
							</button>

							<div class="modal fade" id="rj-dte-benefits" aria-hidden="true" aria-labelledby="rj-dte-benefitsLabel" tabindex="-1">
								<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-header">
											<h3 class="modal-title" id="rj-dte-benefitsLabel">
												<?php echo esc_html_e('Choose Language', 'astra-child'); ?>
											</h3>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											<div class="row">
												<div class="col-md-6">
													<h4 class="modal-title">
														<?php echo esc_html_e('ENGLISH', 'astra-child'); ?>
													</h4>	

													<div class="d-flex flex-column" style="display: flex; flex-direction: column;">
														<a href="<?php echo esc_url(get_permalink(get_page_by_title('DTE Benefits'))); ?>">
															<?php echo esc_html_e('DTE Benefits', 'astra-child'); ?>
														</a>
														<a href="<?php echo esc_url(get_permalink(get_page_by_title('ICare perks'))); ?>">
															<?php echo esc_html_e('ICARE Perks', 'astra-child'); ?>
														</a>
														<a href="">
															<?php echo esc_html_e('ADP', 'astra-child'); ?>
														</a>
													</div>

												</div>
												<div class="col-md-6">
													<h4 class="modal-title">
														<?php echo esc_html_e('ESPANOL', 'astra-child'); ?>
													</h4>	

													<div class="d-flex flex-column" style="display: flex; flex-direction: column;">
														<a href="">
															<?php echo esc_html_e('DTE Benefits', 'astra-child'); ?>
														</a>
														<a href="">
															<?php echo esc_html_e('ICARE Perks', 'astra-child'); ?>
														</a>
														<a href="">
															<?php echo esc_html_e('ADP', 'astra-child'); ?>
														</a>
													</div>

												</div>
											</div>
										</div>
									</div>
								</div>
							</div> 
							*/ ?>
								
							<a href="<?php echo esc_url(get_permalink(get_page_by_title('HR Forms'))); ?>" class="hr-option">
								<?php echo esc_html_e('HR Forms', 'astra-child'); ?>
							</a>

						</div>
					</div>
				</div>


			</div>
		</div>
	</main>

<?php }else{
	get_template_part('/rj-employee-portal/template-parts/custom-login-form');
} ?>
<?php get_footer(); 