<?php 
/* Template Name: Find Agency */

get_header();
$current_url = add_query_arg(array(), home_url($wp->request));
?>
<!-- contact Us Form Section Start -->
<section class="contact-us section-spacing">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-12 col-12">
                <div class="section-heading">
                    <div class="title-heading">
                        <h1 class="title"><?php the_title();?></h1>
                       	<?php the_content();?>
                    </div>
                    <div class="proposal-img"><img src="<?php echo IT_HIPL_THEME_DIR;?>/assets/images/proposal.svg" alt="proposal"></div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-12">
                <div class="contactus-card">
                    <h2 class="title">Get Proposals</h2>
                    <p>Receive Proposals From Best Agencies for Free</p>
                    <form action="POST" class="form" id="proposals-form-id">
                        <input type="hidden" name="contact_current_time" id="contact_current_time" value="<?= time() ?>">
                        <div class="input-box">
                            <div class="input-field">
                                <input type="text" name="p_first_name" class="proposals-form-c-f form-control" placeholder="First Name*">
                            </div>
                            <div class="input-field">
                                <input type="text" name="p_last_name" class="proposals-form-c-f form-control" placeholder="Last Name">
                            </div>
                            <div class="input-field">
                                <select class="budget-select" name="p_budget">
                                    <option value="BU">Budget</option>
                                    <option value="Less than $5,000">Less than $5,000</option>
                                    <option value="$5,000-$10,000">$5,000 - $10,000</option>
                                    <option value="$10,000-$20,000">$10,000 - $20,000</option>
                                    <option value="$20,000-$35,000">$20,000 - $35,000</option>
                                    <option value="$35,000-$50,000">$35,000 - $50,000</option>
                                    <option value="$50,000-$1,00,000">$50,000 - $1,00,000</option>
                                    <option value="$1,00,000+">$1,00,000+</option>
                                </select>
                            </div>
                            <div class="input-field">
                                <input type="tel" name="p_subject" class="proposals-form-c-f form-control" placeholder="Contact Number">
                            </div>
                        </div>
                        <div class="message">
                            <div class="input-field">
                                <input type="email" name="p_email" class="proposals-form-c-f form-control" placeholder="Email*">
                            </div>
                            <div class="input-field">
                                <textarea name="p_message" class="form-control" rows="11" placeholder="Enter Message"></textarea>
                            </div>
                            <input type="hidden" name="contact_current_page" name="contact_current_page" value="<?php echo $current_url; ?>">
                            <div class="form-group enter-value">
                                <div class="input-field">
                                    <span class="p_question" id="p_question"></span>
                                    <input type="hidden" name="p_tcaptcha_ans" id="p_tcaptcha_ans" value="">    
                                    <input type="text" name="" placeholder="Value*" class="form-control" id="p_captcha_ans">
                                </div>
                            </div>
                            <div class="policy">By signing in you agree to our <a href="/privacy-policy">Privacy Policy</a>.</div>
                            <button type="submit" class="btn btn-theme1" id="proposals-form-submit-btn">Submit</button>
                            <div class="error_message" style="color:red; display:none;"></div>
                            <div class="success-msg" style="color:green; display:none;"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- contact Us Form Section End -->

<!-- Latest News Section End -->
<?php 
$front_page_id = get_option('page_on_front');
if( have_rows('content', $front_page_id) ):
    while ( have_rows('content', $front_page_id) ) : the_row(); 
        if( get_row_layout() == 'blog_section' ):
            echo do_shortcode('[recommended-articles]');
        endif;
    endwhile;
endif; ?>
<!-- Latest News Section End -->
    
<?php 
get_footer();
?>
<script src="<?php echo IT_HIPL_THEME_DIR;?>/assets/libs/select2/select2.min.js"></script>
<script>
    jQuery(document).ready(function() {
        jQuery('.budget-select').select2();
    });
    var total;
    function getRandom() {
        return Math.ceil(20 * Math.random());
    }
    function createSum() {
        var e = getRandom(),
            a = getRandom();
        (total = e + a),
            jQuery("#p_question").text(e + " + " + a + " = "),
            jQuery("#p_tcaptcha_ans").val(total);
    }
    jQuery(document).ready(function () {
        createSum()
    });
</script>