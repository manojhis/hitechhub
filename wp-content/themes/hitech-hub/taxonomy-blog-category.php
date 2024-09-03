<?php 
get_header(); 
$current_url = add_query_arg(array(), home_url($wp->request)); 
?>
<!-- Banner Section Start -->
<section class="banner-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-sm-12 col-12">
                <div class="banner-content">
                    <h1 class="banner-title">Stay Updated With the latest</h1>
                    <p>Creating a mobile app can be confusing, with many challenges. You may feel lost and unsure where to go next to achieve your dream app. We've been your guide on this journey, mapping out the best paths and uncovering the most skilled developers.</p>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12 col-12 text-lg-start text-center">
            <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/banner-img/banner-form.svg" alt="form">
            </div>
        </div>
    </div>
</section>
<!-- Banner Section End -->
<section class="blog-section blog-page">
    <div class="container">
        <div class="row">
            <div class="col-xl-9 col-lg-8 col-sm-12 col-12">
                <div class="blogs">
                    <?php
                    if ( have_posts() ) : ?>
                        <header class="page-header">
                            <?php
                                the_archive_title( '<h1 class="page-title">', '</h1>' );
                                the_archive_description( '<div class="taxonomy-description">', '</div>' );
                            ?>
                        </header><!-- .page-header -->
                        <?php
                        /* Start the Loop */
                        while ( have_posts() ) :
                            the_post();
                            $postID = get_the_ID();
                            $post_thumb_id  =   get_post_thumbnail_id($post_id);
                            $attachment_url =   wp_get_attachment_image_url($post_thumb_id);
                        ?>
                            <div class="blog-item">
                                <div class="blog-body flex-xl-row flex-column">
                                    <div class="blog-img">
                                        <img src="<?= $attachment_url ?>" alt="blog">
                                    </div>
                                    <div class="blog-description">
                                        <a href="<?= the_permalink() ?>"><h2 class="blog-title"><?= get_the_title() ?></h2></a>
                                        <div class="postdesc">
                                            <p><?= substr(strip_tags(get_the_content()), 0, 200).'...' ?></p>
                                        </div>
                                        <div class="readmore-btn d-flex"><a href="<?= the_permalink() ?>" class="btn btn-theme1">Read More</a></div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        endwhile;
                        the_posts_navigation();
                    else :
                        get_template_part( 'template-parts/content', 'none' );
                    endif;
                    ?>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-12 col-12">
                <div class="wigts-side d-flex flex-column">
                    <div class="onsultation-card contact">
                        <h3 class="title text-center">Need Consultation?</h3>
                        <form action="POST" class="form d-flex flex-column" id="itfirms-contact-form">
                            <div class="input-field"><input type="hidden" name="itf_edit_id"></div>
                            <div class="input-field">
                                <input type="hidden" name="contact_current_time" name="contact_current_time" value="<?= time() ?>">
                                <input type="hidden" name="contact_current_page" name="contact_current_page" value="<?php echo $current_url; ?>">
                            </div>
                            <div class="input-field"><input type="text" name="itf_contact_name" class="form-control itf-fields-change" placeholder="Name*"></div>
                            <div class="input-field"><input type="email" name="itf_contact_email" class="form-control itf-fields-change" placeholder="Email Address*"></div>
                            <div class="input-field"><input type="tel" name="itf_contact_phone" class="form-control itf-fields-change" placeholder="Contact Number"></div>
                            <div class="input-field"><textarea name="itf_contact_message" class="form-control" rows="4" placeholder="Description"></textarea></div>
                            <div class="form-group enter-value">
                                <div class="input-field">
                                    <span class="itf_contact_question" id="itf_contact_question"></span>
                                    <input type="hidden" name="itf_contact_tcaptcha" id="itf_contact_tcaptcha" value="">
                                    <input type="text" name="" placeholder="Value*" class="form-control"  id="itf_contact_captcha_ans">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-theme1" id="itfirms-submit-contact-form-btn">Submit</button>
                        </form>
                    </div>
                    <div class="onsultation-card support-banner">
                        <div class="icon"><img src="<?= get_stylesheet_directory_uri() ?>/assets/images/icon/draft.svg" alt="draft"></div>
                        <h3 class="title">NEED HELP SELECTING A COMPANY?</h3>
                        <p>With the fast-paced world of  web development today, keeping pace.</p>
                        <a href="/find-an-agency" class="btn btn-theme1 w-100">Connect With Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
 
<?php
get_sidebar();
get_footer();
?>
<script type="text/javascript">
var total;
function getRandom() {
    return Math.ceil(20 * Math.random());
}
function createSum() {
    var e = getRandom(),
        a = getRandom();
    (total = e + a),
        jQuery("#itf_contact_question").text(e + " + " + a + " = "),
        jQuery("#itf_contact_tcaptcha").val(total);
}
jQuery(document).ready(function () {
    createSum()
});
</script>