<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package IT_Firms
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
   
    <link rel="stylesheet" href="<?php echo IT_HIPL_THEME_DIR;?>/assets/css/header.min.css">
    <link rel="stylesheet" href="<?php echo IT_HIPL_THEME_DIR;?>/assets/css/footer.min.css">
	<?php wp_head(); ?>
	
	<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NXN84FNK');</script>
<!-- End Google Tag Manager -->
</head>
<body <?php body_class(); ?>>
  
    <!-- ---------- Header Start --------- -->
    <header class="site-header">
        <nav class="navbar navbar-expand-lg" aria-label="Offcanvas navbar large">
            <div class="container-fluid px-0">
                <a class="navbar-brand" href="<?php echo site_url();?>"><img src="<?php echo IT_HIPL_THEME_DIR;?>/assets/images/logo.svg" alt="logo"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2">
                <img src="<?php echo IT_HIPL_THEME_DIR;?>/assets/images/icon/menu.svg" alt="menu">
                </button>
                <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
                    <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbar2Label"><img src="<?php echo IT_HIPL_THEME_DIR;?>/assets/images/logo.svg" alt="logo"></h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav align-items-center">
                            <li class="nav-item dropdown big-nav show"><a class="nav-link" href="javascript:;"> Services</a>
                                <div class="sub-menu">
                                    <ul class="nav nav-pills flex-column" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="pills-categories-tab" data-bs-toggle="pill" data-bs-target="#pills-categories" type="button" role="tab" aria-controls="pills-categories" aria-selected="true">Popular Categories</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-categories2-tab" data-bs-toggle="pill" data-bs-target="#pills-categories2" type="button" role="tab" aria-controls="pills-categories2" aria-selected="false">Mobile App Development</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-categorie3-tab" data-bs-toggle="pill" data-bs-target="#pills-categorie3" type="button" role="tab" aria-controls="pills-categorie3" aria-selected="false">Web Development</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-categories4-tab" data-bs-toggle="pill" data-bs-target="#pills-categories4" type="button" role="tab" aria-controls="pills-categories4" aria-selected="false">Ecommerce</button>
                                        </li>                                        
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-categories" role="tabpanel" aria-labelledby="pills-categories-tab" tabindex="0">
                                            <div class="row tab-link-group">
                                                <div class="col-sm-12 col-12">
                                                    <?php 
                                                        if(has_nav_menu('header-find-services')){
                                                            wp_nav_menu( array(
                                                            'theme_location' => 'header-find-services',
                                                            'walker'         => new Header_Walker_Nav_Menu(),
                                                            'container'      => false,  
                                                            'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                                            'menu_class'     => 'find-service-nav',  
                                                            ) );
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-categories2" role="tabpanel" aria-labelledby="pills-categories2-tab" tabindex="0">
                                            <div class="row tab-link-group">
                                                <div class="col-sm-12 col-12">
                                                    <ul class="find-service-nav">
                                                        <li><a class="menu-item" href="javascript:;">Platform</a></li>
                                                        <ul class="nav-list">
                                                            <li><a class="menu-item" href="javascript:;">Digital Marketing Agencies</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Social Media Marketing</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Small Business Digital Marketing</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Integrated Marketing</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Inbound Marketing</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Email Marketing</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Google Adwords</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Facebook Marketing</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Instagram Marketing</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Influencer Marketing</a></li>
                                                        </ul>
                                                        <li><a class="menu-item" href="javascript:;">LOCATION</a></li>
                                                        <ul class="nav-list">
                                                            <li><a class="menu-item px-0" href="javascript:;">India</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">USA</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">London</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">UK</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">America</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">Poland</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">Canada</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">Australia</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">Ukraine</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">California</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">Chicago</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">New York</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">Bengaluru</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">Noida</a></li>
                                                        </ul>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-categorie3" role="tabpanel" aria-labelledby="pills-categorie3-tab" tabindex="0">
                                            <div class="row tab-link-group">
                                                <div class="col-sm-12 col-12">
                                                    <ul class="find-service-nav">
                                                        <li><a class="menu-item" href="javascript:;">Platform</a></li>
                                                        <ul class="nav-list">
                                                            <li><a class="menu-item" href="javascript:;">Ecommerce Development</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Mobile App Development</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Software Development</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Web Development</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Magento Development</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Shopify Developers</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Wordpress Development</a></li>
                                                            <li><a class="menu-item" href="javascript:;">eCommerce App Development</a></li>
                                                            <li><a class="menu-item" href="javascript:;">iOS App Development</a></li>
                                                            <li><a class="menu-item" href="javascript:;">OroCommerce Development</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Pimcore Development</a></li>
                                                            <li><a class="menu-item" href="javascript:;">B2B Ecommerce Development</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Adobe Commerce Development</a></li>
                                                        </ul>
                                                        <li><a class="menu-item" href="javascript:;">LOCATION</a></li>
                                                        <ul class="nav-list">
                                                            <li><a class="menu-item px-0" href="javascript:;">India</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">USA</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">London</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">UK</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">America</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">Poland</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">Canada</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">Australia</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">Ukraine</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">California</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">Chicago</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">New York</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">Bengaluru</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">Noida</a></li>
                                                        </ul>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-categories4" role="tabpanel" aria-labelledby="pills-categories4-tab" tabindex="0">
                                            <div class="row tab-link-group">
                                                <div class="col-sm-12 col-12">
                                                    <ul class="find-service-nav">
                                                        <li><a class="menu-item" href="javascript:;">Platform</a></li>
                                                        <ul class="nav-list">
                                                            <li><a class="menu-item" href="javascript:;">Social Media Marketing</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Content Marketing</a></li>
                                                            <li><a class="menu-item" href="javascript:;">eCommerce Marketing Agencies</a></li>
                                                            <li><a class="menu-item" href="javascript:;">App Marketing</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Search Engine Marketing</a></li>
                                                            <li><a class="menu-item" href="javascript:;">B2B Digital Marketing</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Digital Marketing For Startups</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Small Business Digital Marketing</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Integrated Marketing</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Inbound Marketing</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Email Marketing</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Facebook Marketing</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Instagram Marketing</a></li>
                                                            <li><a class="menu-item" href="javascript:;">Influencer Marketing</a></li>
                                                        </ul>
                                                        <li><a class="menu-item" href="javascript:;">LOCATION</a></li>
                                                        <ul class="nav-list">
                                                            <li><a class="menu-item px-0" href="javascript:;">India</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">USA</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">London</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">UK</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">America</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">Poland</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">Canada</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">Australia</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">Ukraine</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">California</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">Chicago</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">New York</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">Bengaluru</a></li>
                                                            <li><a class="menu-item px-0" href="javascript:;">Noida</a></li>
                                                        </ul>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown"><a class="nav-link" href="javascript:;"> Resources</a>
                                <ul class="sub-menu">
                                    <li><a class="menu-item" href="/blogs">Blog</a></li>
									<li><a class="menu-item" href="/interviews">Interviews</a></li>
									<li><a class="menu-item" href="/press-release">Press Release</a></li>
                                </ul>
                            </li>
                            <li class="nav-item"><a class="nav-link active" aria-current="page" href="/contact-us">Contact Us</a> </li>
                        </ul>
                        <div class="right-side-nav d-flex align-items-center ms-auto">
                            <form class="searchBox d-xl-block d-none" role="search" id="itf-search-form">
                                <input class="form-control" type="search" id="itfirms-search-input" placeholder="Find IT Solutions" aria-label="Search">
                                <button class="search border-0 p-0 shadow-none" type="search" id="itfirms-search-btn"><img src="<?php echo IT_HIPL_THEME_DIR;?>/assets/images/icon/search.svg" alt="search"></button>
                                <div class="list" id="suggetions-list"></div>
                            </form>
							<a class="btn btn-outline-theme1" href="/write-for-us/" class="btn btn-theme3">Write For Us</a>                       
                            <a href="/get-listed/" class="btn btn-theme3">Get Listed</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- ---------- Header End --------- -->