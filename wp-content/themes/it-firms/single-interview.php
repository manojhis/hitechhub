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
        
<!--  Content Section Start -->
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
                        </div>
                    </div><?php     
                } 
            } ?>
            <div class="col-xl-3 col-lg-4 col-md-12 col-12">
                <div class="wigts-side d-flex flex-column">
                    <?php 
                        $the_query = new WP_Query( array(
                            'post_type' => 'interview',
                            'posts_per_page' => 5,
                            'post__not_in'   => array( get_the_ID() )
                        )); 
                        if ( $the_query->have_posts() ) {
                    ?>
                    <div class="onsultation-card">
                        <h3 class="title">Recent Interviews</h3>
                        <ul class="tag-list">
                            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                        <?php endwhile; wp_reset_postdata(); ?>
                        </ul>
                    </div><?php 
                } ?>
                    <div class="onsultation-card support-banner">
                        <div class="icon"><img src="<?php echo IT_HIPL_THEME_DIR;?>/assets/images/icon/draft.svg" alt="draft"></div>
                        <h3 class="title">NEED HELP SELECTING A COMPANY?</h3>
                        <p>With the fast-paced world of  web development today, keeping pace.</p>
                        <a href="/contact-us" class="btn btn-theme1 w-100">Connect With Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Latest News Section End -->
<?php
get_footer();
?>