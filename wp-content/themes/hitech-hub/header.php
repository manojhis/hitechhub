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
	<?php wp_head(); ?>
	<meta name="google-site-verification" content="uYabyEEMtTK2M8r4Q31GjABXBDt2m6CoI5IQz0gtcc0" />
	<!-- Google Tag Manager -->
	<script>
	(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-NXN84FNK');
	</script>
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
                                                    <?php 
                                                        if(has_nav_menu('header-app-development')){
                                                            wp_nav_menu( array(
                                                            'theme_location' => 'header-app-development',
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
                                        <div class="tab-pane fade" id="pills-categorie3" role="tabpanel" aria-labelledby="pills-categorie3-tab" tabindex="0">
                                            <div class="row tab-link-group">
                                                <div class="col-sm-12 col-12">
                                                <?php 
                                                        if(has_nav_menu('header-web-development')){
                                                            wp_nav_menu( array(
                                                            'theme_location' => 'header-web-development',
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
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown"><a class="nav-link" href="<?= site_url() ?>/blogs"> Resources</a>
                                <ul class="sub-menu">
                                    <li><a class="menu-item" href="<?= site_url() ?>/blogs">Blog</a></li>
									<li><a class="menu-item" href="<?= site_url() ?>/interviews">Interviews</a></li>
									<li><a class="menu-item" href="<?= site_url() ?>/press-release">Press Release</a></li>
                                </ul>
                            </li>
                            <li class="nav-item"><a class="nav-link active" aria-current="page" href="<?= site_url() ?>/contact-us">Contact Us</a> </li>
                        </ul>
                        <div class="right-side-nav d-flex align-items-center ms-auto">
                            <form class="searchBox d-xl-block d-none" role="search" id="itf-search-form">
                                <input class="form-control" type="search" id="itfirms-search-input" placeholder="Find IT Solutions" aria-label="Search">
                                <button class="search border-0 p-0 shadow-none" type="search" id="itfirms-search-btn"><img src="<?php echo IT_HIPL_THEME_DIR;?>/assets/images/icon/search.svg" alt="search"></button>
                                <div class="list" id="suggetions-list"></div>
                            </form>
							<a class="btn btn-outline-theme1" href="<?= site_url() ?>/write-for-us" class="btn btn-theme3">Write For Us</a>                       
                            <a href="<?= site_url() ?>/get-listed" class="btn btn-theme3">Get Listed</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- ---------- Header End --------- -->