<?php 
/*
* Template Name: Contact
*/
if(!defined('ABSPATH')){
    exit();
}
get_header();
$current_url = add_query_arg(array(), home_url($wp->request));
?>
<link rel="stylesheet" href="<?php echo IT_HIPL_THEME_DIR;?>/assets/css/contact-us.min.css">

<!-- contact Us Form Section Start -->
<section class="contact-us section-spacing">
    <div class="container">
        <div class="row">
            <div class="col-xxl-9 col-lg-8 col-md-12 col-sm-12">
                <div class="contactus-card h-100">
                    <h1 class="title">Get in touch now!</h1>
                    <p>Receive Proposals From Best Agencies for Free</p>
                    <form action="POST" class="form" id="cotact-page-contact-form"> 
                        <div class="input-box">
                            <div class="input-field"><input type="hidden" name="contact_edit_id" id="contact_edit_id"></div>
                            <div class="input-field"><input type="hidden" name="contact_current_time" name="contact_current_time" value="<?= time() ?>"><input type="hidden" name="contact_current_page" name="contact_current_page" value="<?php echo $current_url; ?>"></div>
                            <div class="input-field"><input type="text" class="form-control contact-form-c-f" placeholder="First Name*" name="contact_name"></div>
                            <div class="input-field"><input type="text" class="form-control contact-form-c-f" placeholder="Last Name"  name="contact_Lname"></div>
                            <div class="input-field"><input type="email" class="form-control contact-form-c-f" placeholder="Email*"     name="contact_email"></div>
                            <div class="input-field"><input type="tel" class="form-control contact-form-c-f" placeholder="Phone" name="contact_phone"></div>
                        </div>
                        <div class="message">
                            <div class="input-field"><textarea class="form-control" rows="4" placeholder="Message" name="contact_message"></textarea></div>
                            <div class="form-group enter-value">
                                <div class="input-field">
                                    <span class="contact_question" id="contact_question"></span>
                                    <input type="hidden" name="tcaptcha_ans" id="tcaptcha_ans" value="">
                                    <input type="text" name="" placeholder="Value*" class="form-control"  id="contact_captcha_ans">
                                </div>
                                <span class="contactcaptchaempty common_error_message" style="visibility: hidden;"></span>
                                <span class="contactinvalidcaptcha common_error_message" style="visibility: hidden;"></span>
                            </div>
                            <button type="submit" class="btn btn-theme1" id="contactpage-submit-btn">Submit</button>
                        </div>
                        <div class="error-msg" style="color:red; display:none;"></div>
                        <div class="success-msg" style="color:green; display:none;"></div>
                    </form>
                </div>
            </div>
            <div class="col-xxl-3 col-lg-4 col-md-12 col-sm-12">
                <div class="contact-card h-100">
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
                    <div class="contact-btn"><a href="/get-listed" class="btn btn-white w-100">Get Listed!</a></div>
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
<script type="text/javascript">
var total;
function getRandom() {
    return Math.ceil(20 * Math.random());
}
function createSum() {
    var e = getRandom(),
        a = getRandom();
    (total = e + a),
        jQuery("#question").text(e + " + " + a + "="),
        jQuery("#captchans").val(""),
        jQuery("#footer_question").text(e + " + " + a + "="),
        jQuery("#footer_captcha_ans").val(""),
        jQuery("#career_question").text(e + " + " + a + "="),
        jQuery("#career_captcha_ans").val(""),
        jQuery("#contact_question").text(e + " + " + a + " = "),
        jQuery("#tcaptcha_ans").val(total),
        jQuery("#contact_captcha_ans").val(""),
        checkInput();
}
function checkInput() {
    var e = jQuery("#captchans").val(),
        a = jQuery("#footer_captcha_ans").val(),
        t = jQuery("#career_captcha_ans").val(),
        s = jQuery("#contact_captcha_ans").val();
}    
jQuery(document).ready(function () {
    createSum()
});
</script>