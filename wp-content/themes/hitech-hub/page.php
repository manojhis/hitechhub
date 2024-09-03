<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package IT_Firms
 */

get_header();
?>
<link rel="stylesheet" href="<?php echo IT_HIPL_THEME_DIR;?>/assets/css/write-for-us.min.css">
<!-- Banner Section Start -->
<section class="banner-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 col-sm-12 col-12">
                <div class="banner-content">
                    <h1 class="banner-title"><?php the_title();?></h1>
                    <?php 
                        $additional_content = get_field( "additional_content" );
                        if( $additional_content ) {
                            echo "<p>".$additional_content."</p>";
                        }
                    ?>
                </div>
            </div>
            <div class="col-lg-5 col-sm-12 col-12 text-lg-start text-center">
                <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
            <img src="<?= $image[0] ?>" alt="form">
            </div>
        </div>
    </div>
</section>
<!-- Banner Section End -->

<!-- Content Section Start -->
<section class="content-section write-us">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-sm-12 col-12">
                <div class="allcontent">
                    <?php the_content(); ?>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-sm-12 col-12">
                <div class="wigts-side d-flex flex-column">
                    <div class="onsultation-card support-banner ">
                        <div class="icon"><img src="<?= get_stylesheet_directory_uri() ?>/assets/images/icon/draft.svg" alt="draft"></div>
                        <h3 class="title">Get a chance for featuring your byline of HiTech Hub!</h3>
                        <p>Send your valuable article to</p>
                        <a href="mailto:business@hitechhub.co" class="link">business@hitechhub.co</a>
                    </div>
                </div>
            </div>
		</div>
    </div>
</section>
<!-- Content Section End -->
<?php
get_footer();