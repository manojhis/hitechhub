<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package IT_Firms
 */
get_header();
$current_url = add_query_arg(array(), home_url($wp->request));
if(have_posts()){
    while(have_posts()){
        the_post();
        $blogID         =   get_the_ID();
        $postthumId     =   get_post_thumbnail_id($blogID);
        $blogimage      =   wp_get_attachment_url($postthumId, 'full');
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <!-- Blog Section Start -->
            <section class="content-section singal-blog">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-9 col-lg-8 col-md-12 col-12">
                            <div class="allcontent">
								<?php if($blogimage){ ?>
                                <div class="singal-post-img"><img src="<?= $blogimage ?>" alt="singal-post"></div>
								<?php } ?>
                                <h1 class="blog-title"><?= the_title() ?></h1>
                                <div class="blog-desc">
                                    <?= the_content() ?>
                                </div>
                                <?php 
                                if(have_rows('faqs')){
                                    ?>
                                        <h2 class="title"><?= the_title() ?> FAQs</h2>
                                        <div class="accordion" id="accordionExample">
                                            <?php 
                                            $counter = 1;
                                            while(have_rows('faqs')): the_row();
                                                $title = get_sub_field('title');
                                                $description = get_sub_field('description'); ?>
                                                    <div class="accordion-item border-0">
                                                        <h2 class="accordion-header">
                                                            <button class="accordion-button shadow-none <?php if($counter!=1) { echo 'collapsed'; } ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?=$counter ?>" aria-expanded="<?php if($counter == 1) { echo 'true'; } else { echo 'false'; } ?>" aria-controls="collapse<?=$counter ?>"><?= $title ?></button>
                                                        </h2>
                                                        <div id="collapse<?=$counter ?>" class="accordion-collapse collapse <?php if($counter == 1) { echo 'show'; }?>" aria-labelledby="heading<?=$counter ?>" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <?= $description ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                $counter++;
                                            endwhile; 
                                            ?>
                                        </div>
                                    <?php
                                }
                                ?>
                                <?php 
                                global $post;
                                $author_id = $post->post_author;
                                $user = get_userdata($author_id);
                                $image = get_field('profile_image', 'user_' . $user->ID);
                                $designation = get_user_meta($author_id, 'designation', true);
                                $info = get_user_meta($author_id, 'about_info', true); 
                                ?>
                                <div class="author-card">
                                    <?php if( $image['url'] == '' ){
                                        $image['url'] = get_stylesheet_directory_uri()."/assets/images/default_author.jpg";
                                    } ?>
                                    <div class="author-img"><img src="<?= $image['url'] ?>" alt="author"></div>
                                    <div class="author-details">
                                        <h3 class="author-name"><?= $user->first_name. ' '.$user->last_name?></h3>
                                        <span class="author-position"><?= $designation ?></span>
                                        <p><?= $info ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-12 col-12">
                            <div class="wigts-side">
                                <div class="blog-admin-details">
                                    <div class="blog-admin-item">
                                        <div class="content-side">
                                            <div class="user">Author</div>
                                            <p><?php echo get_author_name();?></p>
                                        </div>
                                    </div>
                                    <div class="blog-admin-item">
                                        <div class="content-side">
                                            <div class="user">Date</div>
                                            <p><?= get_the_date( 'd-F-Y' ) ?></p>
                                        </div>
                                    </div>
                                    <div class="blog-admin-item">
                                        <div class="content-side">
                                            <div class="user">View</div>
                                            <p><?php echo do_shortcode('[post-views]'); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="wigts-side">
                                <div class="onsultation-card">
                                    <h3 class="title text-center">Top Categories</h3>
                                    <ul class="tag-list">
                                        <?php 
                                         $args = array(
                                                'taxonomy'   => 'blog-category',
                                                'orderby'    => 'name',
                                                'show_count' => true,
                                                'title_li'   => '',
                                            );  
                                            wp_list_categories($args);
                                        ?>   
                                    </ul>
                                </div>
                            </div>
                            <div class="wigts-side">
                                <div class="onsultation-card support-banner">
                                    <div class="icon"><img src="<?= get_stylesheet_directory_uri() ?>/assets/images/icon/draft.svg" alt="draft"></div>
                                    <h3 class="title">NEED HELP SELECTING A COMPANY?</h3>
                                    <p>With the fast-paced world of  web development today, keeping pace.</p>
                                    <a href="/find-an-agency" class="btn btn-theme1 w-100">Connect With Us</a>
                                </div>
                            </div>
                            <div class="wigts-side">
                                <div class="onsultation-card last-card">
                                    <h3 class="title text-center fw-bold">Need Consultation?</h3>
                                    <form action="POST" class="form d-flex flex-column" id="itfirms-contact-form">
                                        <div class="input-field"><input type="hidden" name="itf_edit_id"></div>
                                        <div class="input-field"><input type="hidden" name="contact_current_time" name="contact_current_time" value="<?= time() ?>"><input type="hidden" name="contact_current_page" name="contact_current_page" value="<?php echo $current_url; ?>"></div>
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
                                        <div class="success-msg" style="display:none; color:green;"></div>
                                        <div class="error-msg" style="display:none; color:red;"></div>
                                        <button type="submit" class="btn themebtn btn-theme1" id="itfirms-submit-contact-form-btn">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Blog Section End -->
        </article><!-- #post-<?php the_ID(); ?> -->
        
        <!-- ---------- Latest News Section End --------- -->
        <?php 
        $front_page_id = get_option('page_on_front');
        if( have_rows('content', $front_page_id) ):
            while ( have_rows('content', $front_page_id) ) : the_row(); 
                if( get_row_layout() == 'blog_section' ):
                    echo do_shortcode('[recommended-articles]');
                endif;
            endwhile;
        endif; ?>
        <!-- ---------- Latest News Section End --------- -->
        <?php
    }
}
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