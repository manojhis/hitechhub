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
            <div class="col-lg-8 col-sm-12 col-12">
                <div class="banner-content">
                    <h1 class="banner-title"><?php the_title();?></h1>
                    <?php 
                        $additional_content = get_field( "additional_content" );
                        if( $additional_content ) {
                            echo "<p>".$additional_content."</p>";
                        }
                    ?>
                    <!-- <p>Creating a mobile app can be confusing, with many challenges. You may feel lost and unsure where to go next to achieve your dream app. We've been your guide on this journey, mapping out the best paths and uncovering the most skilled developers.</p> -->
                </div>
            </div>
            <div class="col-lg-4 col-sm-12 col-12 text-lg-start text-center">
            <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/banner-img/banner-form.svg" alt="form">
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
                <?php the_content(); ?>
                <!-- <div class="allcontent">
                    <div class="item">
                        <h2 class="title">The Role of the Top Mobile Application Development Companies in India</h2>
                        <p>Forget the stereotypical image of programmers in dark basements. App development is an art form where skilled individuals transform lines of code into captivating experiences. They're not just code writers; they're architects of interactive experiences.</p>
                        <p>Think about them as your quality assurance specialists, meticulously testing every line to ensure a seamless journey. After launch, they stay with you long-term, providing technical support and updates and working hard to fix bugs.</p>
                        <p>Remember, you're not just buying technical expertise but investing in a partnership that brings your vision to life. Choose wisely, and your app will stand out amongst the crowd, captivating users and achieving its full potential.</p>
                    </div>
                    <div class="item">
                        <h2 class="title">The cost and duration of developing an app vary widely</h2>
                        <p>Researching for costs and timelines of the top 10 mobile application development in India; does it feel like a riddle?</p>
                        <p>First, imagine the pricing as a fascinating puzzle. A basic app costs around $1,500, while complex marvels can reach $250,000+. Remember, just like maintaining an artefact, your app needs upkeep (15-20% annual cost) to keep it shining.</p>
                        <p>Now, the timeline. A simple app can be ready in a month, while intricate ones might take a year to perfect. Top mobile app development companies understand how to manage budget, complexity, and time effectively. They can create a product that aligns with your vision and provides exceptional value.</p>
                        <p>Instead of hiring a coder, look for a partner who understands your dreams. This partner should also be able to calculate costs and assist you from the idea stage to the launch and beyond. You can hire an <a href="javascript:;" target="_blank" class="fw-bold">IT services company</a> to assist with different projects in such situations.</p>
                    </div>
                    <div class="item">
                        <h2 class="title">Why Opt for a Top mobile application development company in India?</h2>
                        <p>Researching for costs and timelines of the top 10 mobile application development in India; does it feel like a riddle?</p>
                        <ul>
                            <li>In-App Purchase & Freemium Model</li>
                            <li>Advertising (via banner, video, native ad, interstitial ad, incentivized ad)</li>
                            <li>App Merchandise & E-commerce</li>
                            <li>Subscription Model</li>
                            <li>Referral Marketing</li>
                            <li>Crowd-funding</li>
                            <li>Sponsorship</li>
                            <li>Email Marketing</li>
                        </ul>
                    </div>
                    <div class="item">
                        <h2 class="title">Editorial Procedure</h2>
                        <p>Our core audiences are a group of mankind who are interested in developing applications, websites, and software or eCommerce solutions. In a more precise way, they are business authorities, entrepreneurs, Start-ups, mid-sized businesses, or well-established enterprises. Your Guest post must have to help our audiences for attaining actionable outcomes.</p>
                        <p>Pleasantly take note that we don’t approve of the same topics as those topics flooding is something we dislike to do. We are actively looking for fresh, new concepts, tactics, and suggestions to comfort our readers in making firm business-oriented decisions.</p>
                    </div>
                    <div class="item">
                        <h2 class="title">What Benefits You will get from HiTech Hub?</h2>
                        <p>Our core audiences are a group of mankind who are interested in developing applications, websites, and software or eCommerce solutions. In a more precise way, they are business authorities, entrepreneurs, Start-ups, mid-sized businesses, or well-established enterprises. Your Guest post must have to help our audiences for attaining actionable outcomes.</p>
                        <p>Pleasantly take note that we don’t approve of the same topics as those topics flooding is something we dislike to do. We are actively looking for fresh, new concepts, tactics, and suggestions to comfort our readers in making firm business-oriented decisions.</p>
                    </div>
                    <div class="item">
                        <ul>
                            <li>We will provide you with a byline along with your biography, and a back-link. Hence, readers or audiences can able to find you with less hassle.</li>
                            <li>We will publish or promote your article on Socially engaging channels like Facebook and Twitter.</li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="contact-to-mail">
                            <div class="left-side">
                                <div class="icon"><img src="<?php //echo IT_HIPL_THEME_DIR;?>/assets/images/icon/draft.svg" alt="draft"></div>
                                <h2 class="contact-title">Get a chance for featuring your byline of HiTech Hub!</h2> 
                            </div>
                            <div class="right-side">
                                <div class="send-articale-title">Send your valuable article to</div>
                                <a href="mailto:business@hitechhub.co">business@hitechhub.co</a>
                            </div>
                        </div>
                    </div>
                </div> -->
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