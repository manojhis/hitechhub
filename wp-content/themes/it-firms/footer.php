<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package IT_Firms
 */

?>
    <!--  Footer Section Start -->
    <footer class="footer">
        <div class="container">
            <div class="row usefull-footer-links ">
            <div class="col-xl-5 col-sm-12 col-12">
                    <!-- <div class="footer-logo"><img src="<?php echo IT_HIPL_THEME_DIR;?>/assets/images/logo-white.svg" alt="logo"></div> -->
                    <h4 class="footer-link-title">ABout HITECH HUB</h4>
                    <p>Hitech Hub is a highly regarded platform for discovering and evaluating leading eCommerce, mobile, and web development companies. It offers reliable and accurate insights into top IT organizations and global trends, helping users make informed decisions about technology and digital services.</p>
                    <ul class="social-icons d-flex align-items-center">
                        <li><a href="https://www.linkedin.com/company/hitech-hub" target="_blank"><img src="<?php echo IT_HIPL_THEME_DIR;?>/assets/images/icon/LinkedIn.svg" alt="LinkedIn"></a></li>
                    </ul>
                </div>
                <div class="col-xl-7 col-sm-12 col-12">
                    <div class="usefull-footer-links grid-footer-link">
                        <div class="footer-link-group order-md-1 order-2">
                            <h4 class="footer-link-title">Resources</h4>
                            <?php 
                            if(has_nav_menu('footer-resources')){
                                wp_nav_menu( array(
                                'theme_location' => 'footer-resources',
                                'walker'         => new Footer_Walker_Nav_Menu(),
                                'container'      => false,
                                'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                'menu_class'     => 'footer-nav d-flex flex-column',
                                ) );
                            }
                            ?>
                        </div>
                        <div class="footer-link-group order-md-2 order-1">
                            <h4 class="footer-link-title">Find Services</h4>
                            <?php 
                            if(has_nav_menu('footer-find-services')){
                                wp_nav_menu( array(
                                'theme_location' => 'footer-find-services',
                                'walker'         => new Footer_Walker_Nav_Menu(),
                                'container'      => false,
                                'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                'menu_class'     => 'footer-nav d-grid',
                                ) );
                            }
                            ?>
                        </div>
                    </div>                       
                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="container">
                <div class="row row-gap-1">
                    <div class="col-sm-12 col-12"><div class="copyright-title">Copyright © <?php echo date('Y');?> <a href="https://hitechhub.co/" target="_blank">HITECH HUB</a> All Rights Reserved.</div></div>
                    <!-- <div class="col-lg-auto col-12">
                        <ul class="footer-nav d-flex justify-content-center align-items-center gap-0">                      
                            <li><a class="footer-nav-link" href="/privacy-policy/">Privacy Policy</a></li>
                        </ul>
                    </div> -->
                </div>
            </div>
        </div>
    </footer>
    <!--  Footer Section End -->

    <!-- Modal -->
    <div class="modal fade project-popup" id="aboutproject" tabindex="-1" aria-labelledby="aboutprojectLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="employers-group">
                        <img src="<?php echo IT_HIPL_THEME_DIR;?>/assets/images/employe-group.png" alt="employe">
                    </div>
                    <div class="message-side">
                        <div class="bulding"><img src="<?php echo IT_HIPL_THEME_DIR;?>/assets/images/company.svg" alt="company"></div>
                        <h2 class="title">Need Help Selecting the Right Agency?</h2>
                        <p>Search, find and decide on a service provider in record time. Read verified reviews from real business leaders just like you. Browse 280,000 vetted businesses worldwide.</p>
                        <a href="<?php echo site_url();?>/find-an-agency/"><button class="btn btn-theme3">Tell Us About Your Project</button></a>
                    </div>
                    <button type="button" class="close-popup" data-bs-dismiss="modal" aria-label="Close"><img src="<?php echo IT_HIPL_THEME_DIR;?>/assets/images/icon/close.svg" alt="close"></button>
                </div>
            </div>
        </div>
    </div>
<?php wp_footer(); ?>
<!-- <script>
    window.addEventListener('load', function() {
        setTimeout(function() {
            var myModal = new bootstrap.Modal(document.getElementById('aboutproject'));
            myModal.show();
        }, 15000); 
    });
</script> -->
</body>
</html>
   