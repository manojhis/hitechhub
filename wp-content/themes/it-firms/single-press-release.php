<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package IT_Firms
 */
get_header();
?>
<link rel="stylesheet" href="<?php echo IT_HIPL_THEME_DIR;?>/assets/css/interview-details.min.css">
        
<!-- Content Section Start -->
<section class="content-section section-spacing">
    <div class="container">
        <div class="row">
            <?php
            if(have_posts()){
                while(have_posts()){
                    the_post();
                    $blogID = get_the_ID();
                    $postthumId = get_post_thumbnail_id($blogID);
                    $blogimage = wp_get_attachment_url($postthumId, 'full');
                    ?>
                    <div class="col-xl-9 col-lg-8 col-md-12 col-12">
                        <div class="allcontent">
                            <div class="item">
                                <div class="singal-post-img"><img src="<?php echo $blogimage; ?>" alt="singal-post"></div>
                                <h1 class="blog-title"><?php the_title(); ?></h1>
                                <?php the_content(); ?>
                            </div>  
                            <div class="item">
                                <div class="abouts-itfirm">
                                    <h2 class="title">About Best It Firm</h2> 
                                    <p><a href="javascript:;" class="fw-bold">Best It Firm</a> highlights companies that show exceptional quality and a strong commitment to authenticity. They recognise the outstanding skills and notable achievements that differentiate companies via careful screening and knowledge of market trends. Best It Firm challenges you to reflect on brilliance, gain the power of recognition, and join the ranks of exceptional companies.</p>
                                </div>
                            </div>
                        </div>
                    </div><?php     
                } 
            } ?>
            <div class="col-xl-3 col-lg-4 col-md-12 col-12">
                <div class="contact-card">
                    <div class="address-details">
                        <div class="top-content">
                            <h2 class="title fw-normal">Get Listed Now!</h2>
                            <p>Empowering Digital Commerce Transformation</p>
                        </div>
                        <div class="contact d-flex flex-column">
                            <div class="icon d-flex align-items-center justify-content-center"><img src="<?php echo IT_HIPL_THEME_DIR;?>/assets/images/icon/email-fill.svg" alt="email"></div>
                            <div class="contact-details">
                                <div class="contact-label">EMAIL US</div>
                                <a href="mailto:business@hitechhub.co" class="links">business@hitechhub.co</a>
                            </div>
                        </div>
                    </div>
                    <div class="contact-btn"><a href="/contact-us" class="btn btn-white w-100">Contact Us Now!</a></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Latest News Section End -->
<?php
get_footer();
?>