<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package IT_Firms
 */

get_header();
?>
<link rel="stylesheet" href="<?php echo IT_HIPL_THEME_DIR;?>/assets/css/error.min.css">
 
		<!-- ---------- Latest News Section End --------- -->
			<section class="error-page section-spacing">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-9 col-sm-10 col-12 mx-auto">
                    <div class="error-img"><img src="<?php echo IT_HIPL_THEME_DIR;?>/assets/images/error.svg" alt="404"></div>
                    <div class="content">
                        <h1>Page Not Found</h1>
                        <p>Oops! It looks like the page you're trying to access can't be found right now. Please go back to the homepage</p>
                        <a href="<?php echo site_url();?>" class="btn btn-theme3">back to home</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ---------- Latest News Section End --------- -->

	 

<?php
get_footer();