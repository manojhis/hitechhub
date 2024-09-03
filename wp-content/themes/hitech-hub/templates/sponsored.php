<?php 
/* Template Name: Sponsored */

get_header();
?>
<!-- Banner Section Start -->
<section class="banner-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 col-sm-12 col-12">
                <div class="banner-content">
                    <h1 class="banner-title"><?php the_title();?></h1>
                    <p><?php the_content();?></p>
                </div>
            </div>
            <div class="col-lg-5 col-sm-12 col-12 text-lg-start text-center">
                <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
                <img src="<?= $image[0] ?>" alt="sponsored">
                <!-- <img src="<?php //echo IT_HIPL_THEME_DIR;?>/assets/images/banner-img/sponsored-banner-img.svg" alt="sponsored"> -->
            </div>
        </div>
    </div>
</section>
<!-- Banner Section End -->

<!-- sponsore Section Start -->
<section class="sponsore-section section-spacing">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-12">
                <div class="sponsore-group">
                    
                    <div class="sponsore-badges nav flex-lg-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
					<button class="nav-link active" id="v-pills-home-tab" data-name="App Development Badges" data-image="https://hitechhub.co/wp-content/uploads/2024/07/Mobile-App-Development-company.svg">App Development Badges</button>
				
					<button class="nav-link " id="v-pills-badges2-tab" data-name="Web Development Badges" data-image="https://hitechhub.co/wp-content/uploads/2024/07/Web-Development-company.svg">Web Development Badges</button>
					<button class="nav-link " id="v-pills-badges3-tab" data-name="Ecommerce Development Badges" data-image="https://hitechhub.co/wp-content/uploads/2024/07/Ecommerce-Development-company.svg">Ecommerce Development Badges</button>
					<button class="nav-link " id="v-pills-badges4-tab" data-name="Laravel Development Badges" data-image="https://hitechhub.co/wp-content/uploads/2024/07/Laravel-Development-Companies.svg">Laravel Development Badges</button>
					<button class="nav-link " id="v-pills-badges5-tab" data-name="Flutter Development Badges" data-image="https://hitechhub.co/wp-content/uploads/2024/07/Flutter-App-Development-Companies.svg">Flutter Development Badges</button>
					<button class="nav-link " id="v-pills-badges7-tab" data-name="NodeJS Development Badges" data-image="https://hitechhub.co/wp-content/uploads/2024/07/Node-Js-Development-Companies.svg">NodeJS Development Badges</button>
					<button class="nav-link " id="v-pills-badges8-tab" data-name="React JS Development Badges" data-image="https://hitechhub.co/wp-content/uploads/2024/07/React-Js-Development-Companies.svg">React JS Development Badges</button>
					<button class="nav-link " id="v-pills-badges9-tab" data-name="Front End Development Badges" data-image="https://hitechhub.co/wp-content/uploads/2024/07/Frontend-Developers.svg">Front End Development Badges</button>
					<button class="nav-link " id="v-pills-badges10-tab" data-name="Back End Development Badges" data-image="https://hitechhub.co/wp-content/uploads/2024/07/Backend-Developers.svg">Back End Development Badges</button>
					<button class="nav-link " id="v-pills-badges11-tab" data-name="Vue Js Development Badges" data-image="https://hitechhub.co/wp-content/uploads/2024/07/Vue-Js-Development-Companies.svg">Vue Js Development Badges</button>
					<button class="nav-link " id="v-pills-badges12-tab" data-name="Web Design Development Badges" data-image="https://hitechhub.co/wp-content/uploads/2024/07/Web-Design-Companies.svg">Web Design Development Badges</button>
					</div>  
                    <div class="sponsore-details tab-content" id="v-pills-tabContent">
                        
                               <div class="tab-pane fade show active" id="v-pills-badges">
								<div class="sponsore-card">
								<div class="top-heading">
								<h2 class="sponsore-title">Leaders Matrix Badges</h2>
								<p>If your company is featured in a Leaders Matrix feel free to display a badge on your website. Please include a link to the corresponding research page. Sample HTML is provided.</p>
								<div class="sub-title">
								<h2 class="sponsore-title">Leaders Matrix Badges</h2>
								<p>Select suitable badge type for your website:</p>
								</div>
								</div>
								<div class="sponsore-brands">
								<div class="sponsore-logo"><img class="sponsor-logo-new" src="https://hitechhub.co/wp-content/uploads/2024/07/Mobile-App-Development-company.svg" alt="App Development Badges"></div>
								</div>
								<form action="" class="form">
								<div class="input-box">
								<div class="form-group">
								<label>Width (px)</label>
								<input type="text" data-id="0" class="form-control badge_width" placeholder="1024">
								</div>
								<div class="form-group">
								<label>Height (px)</label>
								<input type="text" data-id="0" class="form-control badge_height" placeholder="1024">
								</div>
								</div>
								</form>
								<div class="script-card">
								<p class="text">
								&lt;div&gt;&lt;a target="_blank" href="https://hitechhub.co/wp-content/themes/it-firms/assets/images/badges/Mobile-App-Developers-badges.svg"&gt;&lt;
								img src="https://hitechhub.co/wp-content/themes/it-firms/assets/images/badges/Mobile-App-Developers-badges.svg" alt="
								Platform Developers Badges" title="Platform Developers Badges" style="width:<span data-id="badge_width0">1024px</span>;height:<span data-id="badge_height0">1024px</span>"&gt;&lt;/a&gt;&lt;/div&gt;
								</p>
								</div>
								<div class="getbtn text-end"><a href="/get-listed/" class="btn btn-theme1">Get Listed</a></div>
								</div>
								</div>
                           
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- sponsore Section End -->
<?php
get_footer(); 
?>
<script> 
jQuery(document).ready(function(){
	jQuery(".nav-link").click(function(){
		jQuery(".nav-link").removeClass('active');
		jQuery(this).addClass('active');
		var get_logo = jQuery(this).attr('data-image');
		var get_name = jQuery(this).attr('data-name');
		jQuery(".sponsor-logo-new").attr('src',get_logo);
		jQuery(".sponsor-logo-new").attr('alt',get_name);
		jQuery(".text").html('&lt;div&gt;&lt;a target="_blank" href="'+get_logo+'"&gt;&lt;img src="'+get_logo+'" alt="'+get_name+'" title="'+get_name+'" style="width:<span data-id="badge_width0">1024px</span>;height:<span data-id="badge_height0">1024px</span>"&gt;&lt;/a&gt;&lt;/div&gt;');
	});
});
</script>