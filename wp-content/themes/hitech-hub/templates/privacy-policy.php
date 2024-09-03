<?php 
/* Template Name: Privacy Policy */

get_header();
?>
<!-- Banner Section Start -->
<section class="banner-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-12 col-12">
                <div class="banner-content">
                    <h1 class="banner-title"><?php the_title();?></h1>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Section End -->

<!-- Content Section Start -->
<section class="content-section section-spacing">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-12">       
                <div class="allcontent">
                    <?php the_content();?>
                </div>                
            </div>   
		</div>
    </div>
</section>
<!-- Content Section End -->
<?php
get_footer(); 