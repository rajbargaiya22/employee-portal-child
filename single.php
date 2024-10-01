<?php
/**
 * The template for displaying all single posts.
 *
 *
 * @package Astra-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); 
if (is_user_logged_in()) {
?>

<article class="rj-single-post">
    <div class="container ">
    <?php
        if ( have_posts() ) :
          while ( have_posts() ) : the_post(); ?>
            <h1 class="rj-main-heading">
                <?php echo get_the_title(); ?>
            </h1>

            <?php if('company_newsletter' == get_post_type()){ ?>
                <?php $image_id = get_post_thumbnail_id();
                    $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
                    $image_title = get_the_title($image_id); 
                    
                    $multiple_images = get_post_meta($post->ID, '_custom_image_ids', true);
                    $multiple_images = $multiple_images ? explode(',', $multiple_images) : array();

                    if(count($multiple_images) > 0){ ?>
                        <div class="single-newsletter-thumb">
                            
                            <div class="news-images">
                                <?php get_template_part('/rj-employee-portal/template-parts/border'); ?>
                                <img class="post-thumb" src="<?php echo esc_url(get_the_post_thumbnail_url( get_the_ID(), 'medium' )); ?>" alt="<?php echo esc_attr(($image_alt) ? $image_alt : get_the_title() ); ?>" title="<?php echo esc_attr(($image_title) ? $image_title : get_the_title() ); ?>">
                            </div>

                            <?php
                            foreach ($multiple_images as $single_id) : ?>
                                <div class="news-images">
                                    <?php get_template_part('/rj-employee-portal/template-parts/border'); ?>
                                    <img class="post-thumb" src="<?php echo esc_url(wp_get_attachment_image_url( $single_id, 'medium' )); ?>" alt="<?php echo esc_attr(($image_alt) ? $image_alt : get_the_title() ); ?>" title="<?php echo esc_attr(($image_title) ? $image_title : get_the_title() ); ?>">
                                </div>
                                <?php
                            endforeach; ?>
                        </div>
                        <?php 	
                    }else{ 
                        if ( has_post_thumbnail() ) { ?>
                        <img class="post-thumb" src="<?php echo esc_url(get_the_post_thumbnail_url( get_the_ID(), 'medium' )); ?>" alt="<?php echo esc_attr(($image_alt) ? $image_alt : get_the_title() ); ?>" title="<?php echo esc_attr(($image_title) ? $image_title : get_the_title() ); ?>">
                        <?php } 
                    } ?>
            <?php }else{ 
                    if(has_post_thumbnail()){
                        $image_id = get_post_thumbnail_id();
                        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
                        $image_title = get_the_title($image_id);
                        $image_url = get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>
            
                        <?php if ($image_url){ ?>
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(($image_alt) ? $image_alt : get_the_title() ); ?>" title="<?php echo esc_attr(($image_title) ? $image_title : get_the_title() ); ?>">
                        <?php }else{ ?>
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/dummy-post-image.webp'); ?>" alt="<?php echo esc_attr(($image_alt) ? $image_alt : get_the_title() ); ?>" title="<?php echo esc_attr(($image_title) ? $image_title : get_the_title() ); ?>">
                        <?php } 
                    }    
             } ?>


            <?php $content = get_the_content();  ?>
                <div class="single-post-content">
                    <?php echo $content; ?>
                </div>
               

            <?php
                $pdf_url = get_post_meta(get_the_ID(), '_pdf_url', true);
                
                if ($pdf_url) { 
                    $doc_type = pathinfo($pdf_url, PATHINFO_EXTENSION); 

                    if($doc_type == 'pdf'){
                        echo '<a href="' . esc_url($pdf_url) . '" class="rj-read-more"  download>Download PDF</a>';
                    }elseif($doc_type == 'docx'){
                        echo '<a href="' . esc_url($pdf_url) . '" class="rj-read-more"  download>Download Doc</a>';
                    }else{
                        echo '<a href="' . esc_url($pdf_url) . '" class="rj-read-more"  download>Download Excel</a>';
                    }


                    if($doc_type == 'pdf'){ ?>
                        <iframe src="<?php echo esc_url($pdf_url); ?>" width="100%" height="600px" class="rj-single-post-iframe">
                            <p>Your browser doesn't support iframes. Please download the PDF to view it: <a href="<?php echo esc_url($pdf_url) ?>">Download PDF</a>.</p>
                        </iframe>
                    <?php }else{ ?>
                        <iframe src="https://docs.google.com/viewer?url=<?php echo $pdf_url; ?>&embedded=true" style="width:100%; height:600px;"  frameborder="0" class="rj-single-post-iframe">
                        </iframe>
                    <?php } ?>

                <!-- <iframe src="https://docs.google.com/gview?url=http://remote.url.tld/path/to/document.doc&embedded=true"></iframe> -->
                
                



            <?php } ?>    

            <?php if ( 'new_vendor' == get_post_type() ) { ?>
                <?php
                    $pdf_data = get_post_meta(get_the_ID(), 'pdf_repeater', true);
                    if (!empty($pdf_data)) {
                        echo '<div class="row">';
                        foreach ($pdf_data as $item) {
                            $doc_type = pathinfo($item['url'], PATHINFO_EXTENSION); 
                            
                            ?>
                            <div class="col-md-4">
                                <h3 class="rj-vendor-form-title">
                                    <?php echo esc_html($item['title']); ?>
                                </h3>

                                <?php if($doc_type == 'pdf'){ ?>
                                    <iframe src="<?php echo esc_url($item['url']); ?>" width="100%" height="300px" class="rj-single-post-iframe">
                                        <p>Your browser doesn't support iframes. Please download the PDF to view it: <a href="<?php echo esc_url($item['url']) ?>">Download PDF</a>.</p>
                                    </iframe>
                                <?php }else{ ?>
                                    <iframe src="https://docs.google.com/viewer?url=<?php echo $item['url']; ?>&embedded=true" style="width:100%; height:300px;"  frameborder="0" class="rj-single-post-iframe">
                                    </iframe>
                                <?php } ?>



                                <!-- <iframe src="<?php // echo esc_url($item['url']) ?>" width="100%" height="300px">
                                    <p>Your browser doesn't support iframes. Please download the PDF to view it: <a href="<?php // echo esc_url($item['url']); ?>">Download PDF</a>.</p>
                                </iframe> -->


                                <?php
                                    if($doc_type == 'pdf'){ ?>
                                        <a href="<?php echo esc_url($item['url']) ?>" target="_blank" class="rj-read-more vendor-view-more">
                                            <?php echo esc_html('View PDF'); ?>
                                        </a>
                                    <?php }elseif($doc_type == 'docx'){ ?>
                                        <a href="<?php echo esc_url($item['url']) ?>" target="_blank" class="rj-read-more vendor-view-more">
                                            <?php echo esc_html('View PDF'); ?>
                                        </a>
                                    <?php }else{ ?>
                                        <a href="<?php echo esc_url($item['url']) ?>" target="_blank" class="rj-read-more vendor-view-more">
                                            <?php echo esc_html('View PDF'); ?>
                                        </a>
                                    <?php } ?>

                                
                            </div>
                            <?php
                        }
                        echo '</div>';
                    }
                } ?>    
            
            
        <?php endwhile; endif;; ?>
    </div>
</article>

<?php }else{
    get_template_part('/rj-employee-portal/template-parts/custom-login-form');
}
get_footer(); ?>
