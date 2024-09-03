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
<link rel="stylesheet" href="<?php echo IT_HIPL_THEME_DIR;?>/assets/css/company-list-page.min.css">
<!-- Banner Section Start -->
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
	                    
						<?php if(get_field('user_picture'))
						{ ?>
						<img src="<?php echo get_field('user_picture');?>" alt="<?= ucfirst(get_the_title()) ?>">
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
					<div class="company-reating">
						<?php 
						while(have_posts()) :
							the_post();
							
							$postid 			= 	get_the_ID();
							$post_type 			= 	get_post_type();
							if($post_type == 'post'){
								$industries 		= 	get_post_meta($postid, 'industry', true);
								$selectedindustries = 	[];
								if(!empty($industries) && is_array($industries)){
									$industriesQueries  = 	['relation'  =>  'OR',];
									foreach($industries as $ind){
										$industriesQueries[] 		= [
											'key' 		=> 'industry',
											'value' 	=> $ind,
											'compare' 	=> 'LIKE'
										];
									}
								}
								$industriesString = (!empty($selectedindustries) && is_array($selectedindustries)) ? implode(',', $selectedindustries) : $selectedindustries;
								$location 			= 	get_post_meta($postid, 'location', true);
								$selectedlocation 	= 	[];
								if(!empty($location) && is_array($location)){
									$locationQueries  = 	['relation'  =>  'OR',];
									foreach($location as $loc){
										$locationQueries[] 		= [
											'key' 		=> 'location',
											'value' 	=> $loc,
											'compare' 	=> 'LIKE'
										];
									}
								}
								$locationString = (!empty($selectedlocation) && is_array($selectedlocation)) ? implode(',', $selectedlocation) : $selectedlocation;
								$services 			= 	get_post_meta($postid, 'services', true);
								$selectedservices 	= 	[];
								if(!empty($services) && is_array($services)){
									$servicesQueries  = 	['relation'  =>  'OR',];
									foreach($services as $serv){
										$servicesQueries[] 		= [
											'key' 		=> 'services',
											'value' 	=> $serv,
											'compare' 	=> 'LIKE'
										];
									}
								}
								$servicesString = (!empty($selectedservices) && is_array($selectedservices)) ? implode(',', $selectedservices) : $selectedservices;
								
								$paged  = (get_query_var('paged')) ? get_query_var('paged') : 1;
								
								$args   = [
									'post_type' 		=> 	'agency',
									'post_status' 		=> 	'publish',
									'posts_per_page'	=>	-1,
									'orderby'			=>	'date',
									'order'				=>	'DESC',
								];
				
								$meta_query = ['relation' => 'AND',];
				
								if(isset($industriesQueries) && !empty($industriesQueries)){
									$meta_query[] = $industriesQueries;
								}
								if(isset($locationQueries) && !empty($locationQueries)){
									$meta_query[] = $locationQueries;
								}
								if(isset($servicesQueries) && !empty($servicesQueries)){
									$meta_query[] = $servicesQueries;
								}
				
								if(!empty($meta_query)){
									$args['meta_query'] = $meta_query;
								}
								$companies = (!empty(get_posts($args))) ? get_posts($args) : [];

								if(have_rows('add_companies')){
									while(have_rows('add_companies')): the_row();
										$select_company          	=   get_sub_field('select_company');
										$position    				=   (int) get_sub_field('position');
										$expire_membership_date    	=   get_sub_field('expire_membership_date');
										$expiredate 				= 	(!empty($expire_membership_date)) ? date_create_from_format('d/m/Y', $expire_membership_date)->format('Y-m-d') : '';
										$currentDate 				= 	date('Y-m-d');
										if($expiredate >= $currentDate || $expiredate == ''){
											$selectedCompID 	= 	$select_company->ID;
											$companies_ids 		= 	array_column($companies, 'ID');

											if(in_array($selectedCompID, $companies_ids)){

												$companies = array_filter($companies, function ($post) use ($selectedCompID){
													return $post->ID !== $selectedCompID;
												});

												$order_number = $position - 1;
												array_splice($companies, $order_number, 0, array($select_company));

											}else{

												$order_number = $position - 1;
												array_splice($companies, $order_number, 0, array($select_company));

											}
										}
									endwhile;
								}

								$number_of_comp 	= 	get_post_meta($postid, 'number_of_companies', true);
								$comp_limit 		= 	(!empty($number_of_comp)) ? (int)$number_of_comp : '';
								if(!empty($comp_limit)){
									$companies = array_slice($companies, 0, $comp_limit);
								}
								if(!empty($companies)){
									$company_count 	= (is_array($companies)) ? count($companies) : 0;
									$countercheck	= 1;
									foreach($companies as $key => $comp){
										$compID 				= $comp->ID;
										$company_logo 			= (!empty(get_post_meta($compID, 'company_logo', true))) ? get_post_meta($compID, 'company_logo', true) : site_url().'/wp-content/themes/it-firms/assets/images/company-logo.png';
										 
										$sales_email 			= (!empty(get_post_meta($compID, 'sales_email', true))) ? get_post_meta($compID, 'sales_email', true) : '';
										$admin_contact_phone 	= (!empty(get_post_meta($compID, 'admin_contact_phone', true))) ? get_post_meta($compID, 'admin_contact_phone', true) : '';
										if(!empty($admin_contact_phone)){
											$formatted_number = '+1-' . substr($admin_contact_phone, 0, 3) . '-' . substr($admin_contact_phone, 3, 3) . '-' . substr($admin_contact_phone, 6);
										}else{
											$formatted_number = '';
										}
										$total_employees 	= 	(!empty(get_post_meta($compID, 'total_employees', true))) ? get_post_meta($compID, 'total_employees', true) : '';
										$founding_year 		= 	(!empty(get_post_meta($compID, 'founding_year', true))) ? get_post_meta($compID, 'founding_year', true) : '';
										$purse 				= 	(!empty(get_post_meta($compID, 'purse', true))) ? get_post_meta($compID, 'purse', true) : '';
										$rate 				= 	(!empty(get_post_meta($compID, 'rate', true))) ? get_post_meta($compID, 'rate', true) : '';
										$company_website 	= 	(!empty(get_post_meta($compID, 'company_website', true))) ? get_post_meta($compID, 'company_website', true) : '';
										$location 			= 	(!empty(get_post_meta($compID, 'location', true))) ? get_post_meta($compID, 'location', true) : [];

										$agency_industry   	= 	(!empty(get_post_meta($compID, 'industry', true))) ? get_post_meta($compID, 'industry', true) : [];
										$agency_services    = 	(!empty(get_post_meta($compID, 'services', true))) ? get_post_meta($compID, 'services', true) : [];
										$tagline 			=	(!empty(get_post_meta($compID, 'tagline', true))) ? get_post_meta($compID, 'tagline', true) : '';
										global $wp;	
										if(($countercheck == 2) || ($countercheck == 10) || ($countercheck == $company_count)){
											?>
											<div class="company-item">
												<div class="company-side get-conntect">
													<div class="connetct-body">
														<div class="comapny-details d-flex align-items-sm-center flex-md-row flex-column">
															<div class="conntect-img"><img src="<?php echo IT_HIPL_THEME_DIR;?>/assets/images/icon/draft.svg" alt="conntect"></div>
															<div class="company-name">
																<h3 class="company-title">Get Connected With A Company For Free</h3>
																<p class="m-0">Tell us about your project, and we'll match you with vetted companies that meet your requirements.</p>
															</div>
														</div>
														<a href="/find-an-agency" class="btn btn-theme1">GET STARTED</a>
													</div>
												</div>
											</div>
											<?php 
										} 
										?>
										<div class="company-item">
											<div class="company-side">
												<div class="comapny-details d-flex align-items-sm-center flex-sm-row flex-column">
													<div class="company-logo"><a href="<?= $company_website ?>?utm_source=<?= home_url( $wp->request ) ?>&utm_medium=referral&utm_campaign=<?= get_bloginfo('name') ?>"><img src="<?= $company_logo ?>" alt="<?= ucfirst($comp->post_title) ?>" target="_blank" rel="nofollow"></a></div>
													<div class="company-name">
														<h3 class="company-title"><a href="<?= $company_website ?>?utm_source=<?= home_url( $wp->request ) ?>&utm_medium=referral&utm_campaign=<?= get_bloginfo('name') ?>" target="_blank" rel="nofollow"><?= ucfirst($comp->post_title) ?></a></h3>
														<p class="m-0"><?= ucfirst($tagline) ?></p>
													</div>
												</div>
												<div class="company-list-body">
												<div class="read-text">
													<p class="add-read-more"><?php echo $comp->post_content; ?></p>
													<a href="javascript:;" class="read-more">Read More</a>
												</div>
													<div class="discription">
														
															<?php
															if (!empty($agency_industry) && is_array($agency_industry)) {
															?>
														<div class="categorie-list">
															<h4 class="discription-title">Industry</h4>
															<ul class="industry-list list">
																<?php
																$sliced_array = array_slice($agency_industry, 0, 5);
																foreach($sliced_array as $industry){ 
																	$industryAray = get_term($industry);
																
																	$term_id = $industryAray->term_id;
																	$icon = get_field('icon', 'term_' . $term_id);
																	if($icon) {
																		?>
																		<li>
																			<a class="tags"><img src="<?= $icon['url'] ?>" alt="<?php echo $industryAray->name;?>"></a>
																		</li><?php 
																	}
																}?> </ul> </div><?php
															} ?>
															
														
														<div class="categorie-list">																	
															<?php 
															if(!empty($location) && is_array($location)){
																?>
																<h4 class="discription-title">Location</h4>
																<ul class="list">
																	<?php
																	$location_array = array_slice($location, 0, 4);
																	foreach($location_array as $loc){
																		if (get_term($loc)->parent == 0) {
																			$loctionAray = get_term($loc);
																			?>
																			<li><a class="tags fw-medium"><?= $loctionAray->name ?></a></li>
																			<?php
																		}
																	}
																	?>
																</ul>
																<?php
															}
															?>
														</div>
													</div>
													
												</div>
											</div>
											<div class="details-side">
												<ul class="card-details">
													<?php 
													if(!empty($founding_year)){
														?>
													<li>
														<span class="icon-img"><img src="<?= get_stylesheet_directory_uri() ?>/assets/images/icon/bulding.svg" alt="bulding"></span>
														Founded <?= $founding_year ?>
													</li>
													<?php 
													}
													if(!empty($purse)){
														?>
													<li>
														<span class="icon-img"><img src="<?= get_stylesheet_directory_uri() ?>/assets/images/icon/dollor.svg" alt="dollor"></span>
														<?= $purse ?>/hr
													</li>
													<?php 
													}
													if(!empty($total_employees)){
														?>
													<li>
														<span class="icon-img"><img src="<?= get_stylesheet_directory_uri() ?>/assets/images/icon/users.svg" alt="users"></span>
														<?= $total_employees ?>
													</li>
													<?php 
													}
													
														?>
													<li>
														<?php 
														//print_r($services);		
														$first_term = $agency_services[0];
														$term = get_term($services[0]);
														$term_name = $term->name;
														$term_link = get_term_link($term); ?>
														<span class="icon-img"><img src="<?= get_stylesheet_directory_uri() ?>/assets/images/icon/tag-fill.svg" alt="tag"></span>
														<a href="<?= esc_url($term_link) ?>"><?= esc_html( $term_name ) ?></a>
													</li>
													<?php 
													if(!empty($sales_email)){
														?>
														<li>
															<span class="icon-img"><img src="<?= get_stylesheet_directory_uri() ?>/assets/images/icon/project-budget.svg" alt="project-budget"></span>
															<a href="mailto:<?= $sales_email ?>" class="fw-medium text-decoration-none"><?= $sales_email ?></a>
														</li>
														<?php
													}
													?>
													<?php 
													if(!empty($admin_contact_phone)){
														?>
													<li>
														<span class="icon-img"><img src="<?= get_stylesheet_directory_uri() ?>/assets/images/icon/call-red.svg" alt="phone"></span>
														<?= $admin_contact_phone ?>
													</li>
													<?php
													}
													?>
												</ul>
												<div class="contact-button d-flex flex-lg-column flex-md-row flex-column">														 
													<a href="<?= $company_website ?>?utm_source=<?= home_url( $wp->request ) ?>&utm_medium=referral&utm_campaign=<?= get_bloginfo('name') ?>" target="_blank" rel="nofollow" class="btn themebtn w-100 btn-theme1"><span class="btn-icon"><img src="<?= get_stylesheet_directory_uri() ?>/assets/images/icon/globe.svg" alt="globe"></span> Visit Website</a>
												</div>
											</div>
										</div>
										<?php
										$countercheck++;
									}
								}else{
									?>
									<p class="nothingf" style="display:none;">Nothing Found!</p>
									<?php
								}
							}
						endwhile;
						?>
					</div>
				 
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
						 <div class="item">
							 <?= get_post_meta(get_the_ID(), 'additional_description', true) ?>
						 </div>
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
						 ?>
						 <div class="item">
							 <h2 class="title">Tags :</h2>
							 <div class="service-providers">
								 <ul>
									 <?php
									 $tags = get_the_tags($post->ID);

									if ($tags) {									
										foreach ($tags as $tag) {
											echo '<li>'.$tag->name.'</li>';											
										}
										
									}
									 ?>
									 
								 </ul>
							 </div>
						 </div>
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
</style>
<?php
get_sidebar();
get_footer();
?>