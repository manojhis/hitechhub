<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package IT_Firms
 */

get_header();
?>
<style>
div#ajax-company-list-section .loader {
	text-align: center;
}
div#ajax-company-list-section .loader img.hitech-hub-loader {
    width: 100px;
	height: 100px;
}
</style>
<!-- Banner Section Start -->
	<section class="sec_top_header">
	  <div class="container">
	        <div class="col-lg-12 col-sm-12 col-12">
	        	<div class="sec_top_text">
		        	<div class="sec_top_tilte"><?= ucfirst(get_the_title()) ?></div>
		        	<a href="https://hitechhub.co/find-an-agency" target="_blank" class="sec_top_link">
				        Need Help Selecting a Company?
				    </a>
				</div>
	        </div>
	  </div>
	</section>
	<section class="banner-section comapny-list">
	    <div class="container">
	        <div class="row align-items-center">
	            <div class="col-lg-8 col-sm-12 col-12">
	                <div class="banner-content">
	                    <h1 class="banner-title text-white"><?= ucfirst(get_the_title()) ?></h1>
	                    <div class="sub-title">THE BEST OF <?php echo date('M Y'); ?></div>
	                </div>
	            </div>
				<div class="col-lg-4 col-sm-12 col-12">
	                <div class="comapny-list-img text-lg-start text-center">
						<?php 
							$child_service = get_field("services");
							$service_id = get_term( $child_service[0], 'services' )->parent;
							if(get_field('user_picture')){ ?>
								<img src="<?php echo get_field('user_picture');?>" alt="<?= ucfirst(get_the_title()) ?>">
							<?php } else if(get_field( 'badge', 'services_'.$service_id )) { ?>
								<img src="<?php echo get_field( 'badge', 'services_'.$service_id );?>" alt="<?= ucfirst(get_the_title()) ?>">
							<?php } else { ?>
								<img src="<?php echo IT_HIPL_THEME_DIR;?>/assets/images/banner-img/company-list-banner-img.svg" alt="company">
							<?php }
						?>
						
	                </div>
	            </div>
	        </div>
	    </div>
	</section>
	<!-- Banner Section End -->

    <!-- Contant Section Start -->
    <section class="content-banner">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-12">
					<div class="single-content-banner">
						<?= the_content() ?>
					</div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contant Section End -->

	<!-- Company List Card Start -->
	<section class="company-list-card singgle-post-list ">
		<div class="container">
			<div class="row">
			    <div class="col-sm-12 col-12">
                    <div class="blog-section-title">
                        <div class="heading-title"><h2><?= esc_html(get_post_meta(get_the_ID(), 'sub_heading', true)) ?></h2></div>
                        <div class="blogs-date">Last updated: <?php echo date('M d, Y'); ?></div>
                    </div>
                </div>
				<div class="col-sm-12 col-12">
					<?php 
					while(have_posts()) :
						the_post();
						$postid 			= 	get_the_ID();
						$post_type 			= 	get_post_type();
						?>
						<input type="hidden" id="current-post-id" value="<?= $postid ?>">
						<input type="hidden" id="current-post-type" value="<?= $post_type ?>">
						<?php
					endwhile;
					?>
					<div class="company-reating" id="ajax-company-list-section"></div>
					<div class="pagination-container" id="ajax-pagination-container-section"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- Company List Card End -->

	<div class="content-section section-spacing">
		<div class="container">
			<div class="row">
				<!-- Footer Description -->
				 <div class="col-sm-12 col-12">
					 <div class="allcontent">
						<?php if(!empty(get_post_meta(get_the_ID(), 'additional_description', true))){ ?>
							<div class="item">
								<?= get_post_meta(get_the_ID(), 'additional_description', true) ?>
							</div>
						<?php } ?>
						 <?php 
						 if(have_rows('faqs')){
							 ?>
							 <div class="item">
								 <h2 class="title"><?= the_title() ?> FAQs</h2>
								 <div class="accordion" id="accordionExample">
									 <?php 
									 $counter = 1;
									 while(have_rows('faqs')): the_row();
										 if($counter == 1){
											 $faqs_question          =   get_sub_field('faqs_question');
											 $faqs_description    	=   get_sub_field('faqs_description');
											 ?>
											 <div class="accordion-item border-0">
												 <h2 class="accordion-header" id="headingOne">
													 <button class="accordion-button shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
														 <?= $faqs_question ?>
													 </button>
												 </h2>
												 <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
													 <div class="accordion-body">
														 <?= $faqs_description ?>
													 </div>
												 </div>
											 </div>
											 <?php
										 }else{
											 ?>
											 <div class="accordion-item border-0">
												 <h2 class="accordion-header" id="headingTwo">
													 <button class="accordion-button shadow-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
														 <?= $faqs_question ?>
													 </button>
												 </h2>
												 <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
													 <div class="accordion-body">
														 <?= $faqs_description ?>
													 </div>
												 </div>
											 </div>
											 <?php
										 }
										 $counter++;
									 endwhile; 
									 ?>
								 </div>
							 </div>
							 <?php
						 }
						 
						 $tags = get_the_tags($post->ID);
						 if(!empty($tags)){
							 ?>
						 	 <div class="item">
								 <h2 class="title">Other Service Providers in India</h2>
								 <div class="service-providers">
									 <ul>
										 <?php
										 if($tags){									
											foreach($tags as $tag){
												echo '<li>'.$tag->name.'</li>';											
											}
										 }
										 ?>

									 </ul>
								 </div>
							 </div>
						 	<?php
						 }
						 ?>
					 </div>
				 </div>
			</div>
		</div>
	</div>
<style>
.blog-section-title {
    padding-bottom: 50px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}
.blogs-date {
    font-size: var(--fs-18);
    line-height: 30px;
    color: #930043;
    font-weight: var(--fw-600);
}
div#ajax-pagination-container-section .pagination a.pagination-link {
    color: #fff;
    background-color: #930043;
    padding: 8px 15px;
    text-decoration: none;
	font-weight: 600;
}
div#ajax-pagination-container-section .pagination {
    text-align: center !important;
    justify-content: center;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}
div#ajax-pagination-container-section {
    margin-top: 30px;
}
div#ajax-pagination-container-section .pagination span.current-page {
    background: #17313b;
    padding: 8px 15px;
    color: #ffff;
    font-weight: 600;
}
</style>
<?php
get_sidebar();
get_footer();
?>
<script>

jQuery(document).ready(function(){
    function loadCompanies(page){
		var post_id 	= jQuery('#current-post-id').val();
		var post_type 	= jQuery('#current-post-type').val();
		jQuery('#ajax-company-list-section').html('');
		jQuery('#ajax-pagination-container-section').html('');
		jQuery('html, body').animate({ scrollTop: 600 }, 'fast');
		jQuery('#ajax-company-list-section').html('<div class="loader"><img class="hitech-hub-loader" src="https://hitechhub.co/wp-content/uploads/2024/08/hitechhub-loader-1.gif" /></div>');
		jQuery.ajax({
            url		: '<?= admin_url('admin-ajax.php') ?>',
            type	: 'POST',
            data	: {
                action			: 	'load_paginated_companies',
				post_id 		: 	post_id,
				post_type 		: 	post_type,
                page			: 	page,
            },
            success : function(response){
				const res = JSON.parse(response);
				if(res.companies_list){
					jQuery('#ajax-company-list-section').html('');
					jQuery('#ajax-company-list-section').html(res.companies_list);
				}
				if(res.pagination){
					jQuery('#ajax-pagination-container-section').html('');
					jQuery('#ajax-pagination-container-section').html(res.pagination);
				}
				addReadMoreProcess(620, "Read More", "Read Less", ".trim-text");
            }
        });
    }

    jQuery(document).on('click', '.pagination-link', function(e){
        e.preventDefault();
        var page = jQuery(this).data('page');
        loadCompanies(page);
    });

    // Initial load
    loadCompanies(1);
	
	//Add Read More Function..
	function addReadMoreProcess(charLimit, readMoreText, readLessText, selector){
		// Select all elements that match the selector
		var elements = document.querySelectorAll(selector);

		elements.forEach(function(element) {
			var content = element.textContent.trim();

			// Check if the content length exceeds the character limit
			if (content.length > charLimit) {
				var visibleText = content.slice(0, charLimit);
				var hiddenText = content.slice(charLimit);

				// Build the new content with Read More / Read Less
				var newContent = `${visibleText}<span class="dots">...</span><span class="more-text" style="display:none;">${hiddenText}</span>`;
				newContent += `<span class="read-more" style="color:blue; cursor:pointer;">${readMoreText}</span>`;
				newContent += `<span class="read-less" style="color:blue; cursor:pointer; display:none;">${readLessText}</span>`;

				// Replace the original content
				element.innerHTML = newContent;

				// Add event listeners for the Read More and Read Less links
				element.querySelector('.read-more').addEventListener('click', function() {
					element.querySelector('.dots').style.display = 'none';
					element.querySelector('.more-text').style.display = 'inline';
					this.style.display = 'none';
					element.querySelector('.read-less').style.display = 'inline';
				});

				element.querySelector('.read-less').addEventListener('click', function() {
					element.querySelector('.dots').style.display = 'inline';
					element.querySelector('.more-text').style.display = 'none';
					this.style.display = 'none';
					element.querySelector('.read-more').style.display = 'inline';
				});
			}
		});
	}

	const secheader = document.querySelector(".sec_top_header");
	const toggleClass = "is-sticky";

	window.addEventListener("scroll", () => {
	const currentScroll = window.pageYOffset;
	if (currentScroll > 150) {
		secheader.classList.add(toggleClass);
	} else {
		secheader.classList.remove(toggleClass);
	}
	});
});

</script>