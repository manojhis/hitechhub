<?php 
/*
* Template Name: Blogs
*/
if(!defined('ABSPATH')){
    exit();
}
get_header();
$current_url = add_query_arg(array(), home_url($wp->request));
?>
<!-- Banner Section Start -->
<section class="banner-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 col-sm-12 col-12">
                <div class="banner-content">
                    <h1 class="banner-title"><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </div>
            </div>
            <div class="col-lg-5 col-sm-12 col-12 text-lg-start text-center align-self-end">
                <?php 
                    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID )); ?>
                <img src="<?= $image[0] ?>" alt="form">
            </div>
        </div>
    </div>
</section>
<!-- Banner Section End -->

<!-- Blog Section Start -->
<section class="blog-section blog-page">
    <div class="container">
        <div class="row">
            <div class="col-xl-9 col-lg-8 col-sm-12 col-12">
                <div class="blogs">
                    <?php
                    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; 

                    $args = [
                        'post_type'         =>  'blog', 
                        'post_status'       =>  'publish', 
                        'posts_per_page'    =>  5,
                        'paged'             =>  $paged,
                        'orderby'           =>  'date',
                        'order'             =>  'DESC',
                    ];
                    $query = new WP_Query( $args );
                    if($query->have_posts()) :
                        while($query->have_posts()) : $query->the_post();
                            $postID         =   get_the_ID();
                            $post_thumb_id  =   get_post_thumbnail_id($post_id);
                            $attachment_url =   wp_get_attachment_image_url($post_thumb_id) != '' ? wp_get_attachment_image_url($post_thumb_id, 'full') : get_stylesheet_directory_uri()."/assets/images/default_blog.jpg" ;
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
                        wp_reset_postdata(); 
                    else :
                        echo '<p>' . __( 'No posts found.', 'text-domain' ) . '</p>';
                    
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
                        <p>With the fast-paced world of  web development today, keeping pace.</p>
                        <a href="/find-an-agency" class="btn btn-theme1 w-100">Connect With Us</a>
                    </div>
                </div>
            </div>
            <?php 
            if($query->have_posts()){
                ?>
                <div class="col-sm-12 col-12">
                    <div class="paginationbar">
                    <?php
                    $big = 999999999;
                    $pagination = paginate_links(array(
                        'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                        'format'    => '?paged=%#%',
                        'current'   => max(1, get_query_var('paged')),
                        'total'     => $query->max_num_pages,
                        'prev_next' => true,
                        'prev_text' => __('<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 18L9 12L15 6" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'),
                        'next_text' => __('<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 18L15 12L9 6" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'),
                        'type'      => 'array',
                    ));
                    if($pagination){
                        echo '<ul class="pagination justify-content-center">';
                        foreach($pagination as $page_link){
                            echo '<li class="page-item">' . $page_link . '</li>';
                        }
                        echo '</ul>';
                    }
                    ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>
<!-- Blog Section End -->
<?php
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