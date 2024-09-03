<?php 
/*
 * Template Name: Home Page
 */
if(!defined('ABSPATH')){
    exit();
}
get_header();
?>
<link rel="stylesheet" href="<?php echo IT_HIPL_THEME_DIR;?>/assets/css/index.min.css">
<?php
if( have_rows('content') ):

    while ( have_rows('content') ) : the_row(); 

    if(get_row_layout() == 'banner_section'):
    $banner_heading = get_sub_field('banner_heading'); 
    $banner_description = get_sub_field('banner_description'); 
    ?>

    <!-- Banner Section Start -->
    <section class="hero-banner">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-9 col-sm-12 col-12">
                    <div class="inner-top-banner">
                        <div class="banner-content text-center">
                            <h1 class="banner-title"><?php echo $banner_heading; ?></h1>
                            <div class="bdesc"><?php echo $banner_description; ?></div>
                        </div>
                        <form class="searchBox" role="search" id="itf-search-forms">
                            <input class="form-control mw-100" type="search" id="itfirms-search-inputs" placeholder="Find IT Solutions" aria-label="Search">
                            <button class="search border-0 p-0 shadow-none" type="search" id="itfirms-search-btn"><img src="<?php echo IT_HIPL_THEME_DIR;?>/assets/images/icon/search.svg" alt="search"></button>
                            <div class="list" id="suggetions-lists"></div>
                     </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->

    <!-- Agencies Section Start -->
    <section class="content-banner">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="agencie-card">
                        <h2 class="title text-center">Hitech Hub is a B2B marketplace for discovering top agencies</h2>
                        <div class="agencies">
                            <div class="agencies-item">
                            <div class="icon"><img src="<?= get_stylesheet_directory_uri() ?>/assets/images/icon/verified-companies.svg" alt="verified-companies"></div>
                                <div class="agencies-details">
                                    <h3 class="agencies-title">Verified Companies</h3>
                                    <p>Choose the best agency from lists of third-party verified agencies.</p>
                                </div>
                            </div>
                            <div class="agencies-item">
                            <div class="icon"><img src="<?= get_stylesheet_directory_uri() ?>/assets/images/icon/agencies.svg" alt="agencies"></div>
                                <div class="agencies-details">
                                    <h3 class="agencies-title">Identical match matching</h3>
                                    <p>Reliable source to reduce time spending finding & get matched</p>
                                </div>
                            </div>
                            <div class="agencies-item">
                            <div class="icon"><img src="<?= get_stylesheet_directory_uri() ?>/assets/images/icon/industry.svg" alt="industry"></div>
                                <div class="agencies-details">
                                    <h3 class="agencies-title">Guides & Industry Data</h3>
                                    <p>Access business tips and new data on trending topics.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Agencies Section End -->

    <?php
    elseif( get_row_layout() == 'service_section' ): 
        
    ?>

    <!-- Development Section Start -->
    <section class="development-section section-spacing">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="section-heading">
                        <div class="title-heading">
                            <h2 class="title"><?= esc_html(get_sub_field('service_heading')) ?></h2>
                            <div class="sdesc"><?= get_sub_field('service_description') ?></div>
                        </div>
                    </div>
                    <div class="development-card-group">
                        <?php 
                        $achievements = get_sub_field('main_services'); 
                        if(isset($achievements)){
                           
                            foreach($achievements as $ms){
                                ?>
                                <div class="development-card">
                                    <div class="development-card-header">
                                        <div class="icon"><img src="<?= $ms['main_service_icon'] ?>" alt="mobile-app"></div>
                                        <h3 class="title"><?= esc_html($ms['main_service_name']) ?></h3>
                                    </div>
                                    <div class="development-card-body">
                                        <?php 
                                        $add_service_item = (array) $ms['add_service_item'];
                                        if(!empty($add_service_item) && is_array($add_service_item)){
                                            foreach($add_service_item as $asi){
                                                ?>
                                                <div class="categories-item">
                                                    <h4 class="categories-title"><?= esc_html($asi['service_item_name']) ?></h4>
                                                    <?php 
                                                    $postskeys = (array) $asi['posts'];
                                                    if(!empty($postskeys) && is_array($postskeys)){
                                                        ?>
                                                        <ul class="categories-list">
                                                            <?php 
                                                            foreach($postskeys as $p){
                                                                if(!empty($p['select_services'])){
                                                                    $service_post_id = $p['select_services'][0];
                                                                    $permalink = get_the_permalink($service_post_id);
                                                                  ?>
                                                                    <li><a href="<?php echo esc_url($permalink);?>" class="tags"><?= $p['post_name'] ?></a></li>
                                                                    <?php      
                                                                }else{
                                                                    ?>
                                                                    <li><span><?= $p['post_name'] ?></span></li>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </ul>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Development Section End -->
    
    <?php
    elseif( get_row_layout() == 'featured_agency' ): 
    ?>
    
    <!-- Featured Agencies Section Start -->
    <section class="featured-section section-spacing">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="section-heading">
                        <div class="title-heading">
                                <h2 class="title"><?= esc_html(get_sub_field('featured_heading')) ?></h2>
                                <p><?= get_sub_field('featrued_description') ?></p>
                        </div>
                        <!--<a href="javascript:;" class="btn btn-theme1">View All Agencies</a>-->
                    </div>
                    <div class="featured-card-group">
                        <?php 
                        if(get_sub_field('select_agency')){
                            $agencies = (array) get_sub_field('select_agency');
                            if(!empty($agencies) && is_array($agencies)){
                                foreach($agencies as $age){
                                    $ageID  =   $age->ID;
                                    $logo   =   get_post_meta($ageID, 'company_logo', true);
                                    ?>
                                    <div class="featured-card">
                                        <div class="icon"><img src="<?= $logo ?>" alt="icon"></div>
                                        <h3 class="title"><?= ucfirst($age->post_title) ?></h3>
                                        <p>Empowering Digital Commerce Transformation</p>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                        <div class="featured-card contact-card">
                            <div class="top-content">
                                <h3 class="title fw-normal">Get Listed Now!</h3>
                                <p>Empowering Digital Commerce Transformation</p>
                            </div>
                            <div class="contact-btn"><a href="/find-an-agency" class="btn btn-white">Get Listed</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Featured Agencies Section End -->
    <?php
    elseif( get_row_layout() == 'cta_banner' ): 
    ?>
    <!-- CTA Section End -->
    <section class="cta-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-sm-12 col-12">
                    <?php 
                    if(!empty(get_sub_field('cta_banner_label'))){
                        ?>
                        <h2 class="title"><?= esc_html(get_sub_field('cta_banner_label')) ?></h2>
                        <?php
                    }  
                    if(!empty(get_sub_field('cta_banner_label'))){
                        ?>
                        <p class="cta-desc"><?= get_sub_field('cta_banner_label') ?></p>
                        <?php
                    }   
                    ?>
                    <a href="/contact-us" class="btn btn-white">Get Started Now!</a>
                </div>
            </div>
        </div>
    </section>
    <!-- CTA Section End -->
    <?php
    elseif( get_row_layout() == 'how_it_work_section' ): 
    ?>

        <!-- How To Work Section End -->
        <section class="how-to-work section-spacing">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xxl-6 col-xl-5 col-sm-12 col-12">
                    <div class="left-side">
                        <h2 class="title"><?php echo get_sub_field('label');?></h2>
                        <p><?php echo get_sub_field('description');?></p>
                        <a href="/contact-us" class="btn btn-theme1">Contact Us Now!</a>
                    </div>
                </div>
                <div class="col-xxl-6 col-xl-7 col-sm-12 col-12">
                <div class="circle-group mx-xl-0 mx-auto">
                        <div class="round-circle-group d-sm-flex d-none">
                            <div class="logo"><img src="<?= get_stylesheet_directory_uri() ?>/assets/images/rectangle-logo.svg" alt="logo"></div>
                        </div>
                        <div class="project-card project-one">
                            <div class="project-count">01</div>
                            <p>Define important parameters</p>
                        </div>
                        <div class="project-card project-two">
                            <div class="project-count">02</div>
                            <p>Decide project with hand-picked firms</p>
                        </div>
                        <div class="project-card project-three">
                            <div class="project-count">03</div>
                            <p>Decide project with hand-picked firms</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- How To Work Section End -->
    <?php
    elseif( get_row_layout() == 'blog_section' ): 
    ?>
    <!-- Latest News Section Start -->
    <?php echo do_shortcode('[recommended-articles]');?>
    <!-- Latest News Section End -->
    <?php
    endif; 
    endwhile;
endif; ?>
<?php
get_footer();