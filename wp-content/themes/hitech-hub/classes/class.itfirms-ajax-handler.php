<?php
if(!defined('ABSPATH')){
    exit();
}
/**
 * CLASS ITFirmsAjaxHandler
 */
if(!class_exists('ITFirmsAjaxHandler', false)){
    class ITFirmsAjaxHandler{
        public static function init(){
            //CONTACT FORM
            add_action('wp_ajax_contact_form_submit', [__CLASS__, 'contact_form_submit_cb']);
            add_action('wp_ajax_nopriv_contact_form_submit', [__CLASS__, 'contact_form_submit_cb']);

            //Proposals FORM
            add_action('wp_ajax_proposals_submit', [__CLASS__, 'proposals_submit_cb']);
            add_action('wp_ajax_nopriv_proposals_submit', [__CLASS__, 'proposals_submit_cb']);
			
			//Load Companies
            add_action('wp_ajax_load_paginated_companies', [__CLASS__, 'load_paginated_companies_cb']);
            add_action('wp_ajax_nopriv_load_paginated_companies', [__CLASS__, 'load_paginated_companies_cb']);
        }

        //CONTACT FORM AJAX HANDLER
        public static function contact_form_submit_cb(){
            $contact_edit_id        =   (isset($_POST['contact_edit_id'])) ? $_POST['contact_edit_id'] : '';
            $contact_current_time   =   (isset($_POST['contact_current_time'])) ? $_POST['contact_current_time'] : '';
            $contact_name           =   (isset($_POST['contact_name'])) ? $_POST['contact_name'] : '';
            $contact_Lname          =   (isset($_POST['contact_Lname'])) ? $_POST['contact_Lname'] : '';
            $contact_email          =   (isset($_POST['contact_email'])) ? $_POST['contact_email'] : '';
            $contact_subject        =   (isset($_POST['contact_subject'])) ? $_POST['contact_subject'] : '';
            $contact_phone        =   (isset($_POST['contact_phone'])) ? $_POST['contact_phone'] : '';
            $contact_message        =   (isset($_POST['contact_message'])) ? $_POST['contact_message'] : '';
            $current_url            =   (isset($_POST['contact_current_page'])) ? $_POST['contact_current_page'] : '';
            $name                   =   $contact_name.' '.$contact_Lname;
            $ip_address             =   get_ipinfo(); 
            $datetimenow            =   current_time('Y-m-d H:i:s');
            $data                   =   json_decode($ip_address, true);
            $visitorTimezone        =   $data['timezone'];
            $dateTime               =   new DateTime('now', new DateTimeZone($visitorTimezone));
            $visiter_time           =   $dateTime->format('Y-m-d H:i:s');

            $return                 =   [];
            global $wpdb;
            $tableName              =   $wpdb->prefix.'contact_list';
            if(!empty($contact_current_time)){
                $checkrowalreadyexists = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."contact_list` WHERE time='$contact_current_time' LIMIT 1");
                if(!empty($checkrowalreadyexists)){
                    $data = [
                        'name'          =>  $name,
                        'email'         =>  $contact_email,
                        'contact_no'    =>  $contact_phone,
                        'subject'       =>  $contact_subject,
                        'description'   =>  $contact_message,
                    ];

                    $where = [
                        'time' => $contact_current_time,
                    ];

                    $result = $wpdb->update($tableName, $data, $where);
                    if($result !== false){
                        $return['status']   =   true;
                        $return['msg']      =   'Information submitted successfully!';
                    }else{
                        $return['status']   =   false;
                        $return['msg']      =   'Failed to insert data.';
                    }
                }else{
                    $data = [
                        'name'          =>  $name,
                        'email'         =>  $contact_email,
                        'contact_no'    =>  $contact_phone,
                        'subject'       =>  $contact_subject,
                        'description'   =>  $contact_message,
                        'ip_info'       =>  $ip_address,
                        'page_url'      =>  $current_url,
                        'create_date'   =>  $datetimenow,
                        'visiter_time'  =>  $visiter_time,
                        'time'          =>  $contact_current_time,
                    ];
                    $result = $wpdb->insert($tableName, $data);
                    
                    if($result){
						$email_address  =  get_field('email_address_for_frontend_forms', 'option');
						$subject        =  'New Contact Us Form Submission';
						$message = "
							<h2 style='color: #333;'>New Contact Us Form Submission</h2>
							<p style='font-size: 14px; color: #555;'>You have received a new message from the Contact Us form on your website. Please review the        details of the submission by clicking the link below:
							</p>
							<p style='font-size: 14px;'>
								<strong>Submission Details:</strong>
								<br>
								<a href='" . esc_url(site_url('/wp-admin/admin.php?page=contact-form-submissions')) . "' style='color: #0073aa; text-decoration: none;'>
									View Contact Form Submission
								</a>
							</p>
							<hr style='border: none; border-top: 1px solid #ddd;'>
							<p style='font-size: 12px; color: #888;'>
								This notification was sent from the Contact Us form on your website.
							</p>
						";
						$headers = array(
							'Content-Type: text/html; charset=UTF-8',
							'From: Website Contact Form <no-reply@' . parse_url(site_url(), PHP_URL_HOST) . '>'
						);

						wp_mail($email_address, $subject, $message, $headers);
						
                        $return['status']   =   true;
                        $return['msg']      =   'Information submitted successfully!';
                    }else{
                        $return['status']   =   false;
                        $return['msg']      =   'Failed to insert data.';
                    }
                }
            }else{
                $return['status']   =   false;
                $return['msg']      =   'Failed to insert data. Please refresh page and try again.';
            }
            echo json_encode($return);
            exit();
        }


        //PROPOSAL FOMR AJAX HANDLER
        public static function proposals_submit_cb(){
            $contact_current_time   =   (isset($_POST['contact_current_time'])) ? $_POST['contact_current_time'] : '';
            $p_first_name           =   (isset($_POST['p_first_name'])) ? $_POST['p_first_name'] : '';
            $p_last_name            =   (isset($_POST['p_last_name'])) ? $_POST['p_last_name'] : '';
            $p_email                =   (isset($_POST['p_email'])) ? $_POST['p_email'] : '';
            $p_subject              =   (isset($_POST['p_subject'])) ? $_POST['p_subject'] : '';
            $p_message              =   (isset($_POST['p_message'])) ? $_POST['p_message'] : '';
            $p_budget               =   (isset($_POST['p_budget'])) ? $_POST['p_budget'] : '';
            $current_url            =   (isset($_POST['contact_current_page'])) ? $_POST['contact_current_page'] : '';
            
            $name                   =   $p_first_name.' '.$p_last_name;
            $ip_address             =   get_ipinfo(); 
            $datetimenow            =   current_time('Y-m-d H:i:s');
            $data                   =   json_decode($ip_address, true);
            $visitorTimezone        =   $data['timezone'];
            $dateTime               =   new DateTime('now', new DateTimeZone($visitorTimezone));
            $visiter_time           =   $dateTime->format('Y-m-d H:i:s');
            $return                 =   [];
            global $wpdb;
            $tableName              =   $wpdb->prefix.'proposals_list';
            if(!empty($contact_current_time)){
                $checkrowalreadyexists = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."proposals_list` WHERE time='$contact_current_time' LIMIT 1");
                if(!empty($checkrowalreadyexists)){
                    $data = [
                        'name'          =>  $name,
                        'email'         =>  $p_email,
						'budget'        =>  $p_budget,
                        'subject'       =>  $p_subject,
                        'description'   =>  $p_message
                    ];

                    $where = [
                        'time' => $contact_current_time,
                    ];

                    $result = $wpdb->update($tableName, $data, $where);

                    if($result !== false){
                        $return['status']   =   true;
                        $return['msg']      =   'Information submitted successfully!';
                    }else{
                        $return['status']   =   false;
                        $return['msg']      =   'Failed to insert data.';
                    }
                }else{
                    $data = [
                        'name'          =>  $name,
                        'email'         =>  $p_email,
                        'budget'        =>  $p_budget,
                        'subject'       =>  $p_subject,
                        'description'   =>  $p_message,
                        'ip_info'       =>  $ip_address,
                        'page_url'      =>  $current_url,
                        'created'       =>  $datetimenow,
                        'visiter_time'  =>  $visiter_time,
                        'time'          =>  $contact_current_time,
                    ];

                    $result = $wpdb->insert($tableName, $data);
                    
                    if($result){
						$email_address = get_field('email_address_for_frontend_forms', 'option');
						$subject       =  'New Proposal Request Form Submission';
						$message = "
							<h2 style='color: #333;'>New Proposal Request Submission</h2>
							<p style='font-size: 14px; color: #555;'>
								A new proposal request has been submitted. Please review the details of the request by clicking the link below:
							</p>
							<p style='font-size: 14px;'>
								<strong>Submission Details:</strong>
								<br>
								<a href='" . esc_url(site_url('/wp-admin/admin.php?page=proposals-form-submissions')) . "' style='color: #0073aa; text-decoration: none;'>
									View Proposal Request Submission
								</a>
							</p>
						";
						$headers = array(
							'Content-Type: text/html; charset=UTF-8',
							'From: Get Proposals <no-reply@' . parse_url(site_url(), PHP_URL_HOST) . '>'
						);

						wp_mail($email_address, $subject, $message, $headers);
						
                        $return['status']   =   true;
                        $return['msg']      =   'Information submitted successfully!';
                    }else{
                        $return['status']   =   false;
                        $return['msg']      =   'Failed to insert data.';
                    }
                }                
            }else{
                $return['status']   =   false;
                $return['msg']      =   'Failed to insert data. Please refresh page and try again.';
            }
            echo json_encode($return);
            exit();
        }
		
		public static function load_paginated_companies_cb(){
            $postid          =   isset($_POST['post_id'])      ?   intval($_POST['post_id'])   :   '';
            $post_type       =   isset($_POST['post_type'])    ?   $_POST['post_type']         :   '';
            $page            =   isset($_POST['page'])         ?   intval($_POST['page'])      :   1;
            $posts_per_page  =   20;
            $return          =   [];
            $html            =   '';
            $paginationHtml  =   '';
            if(!empty($postid) && !empty($post_type) && $post_type == 'post'){
                //Industries..
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
                $industriesString   =   (!empty($selectedindustries) && is_array($selectedindustries)) ? implode(',', $selectedindustries) : $selectedindustries;

                //Location..
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

                //Services..
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
                
                // $paged  = (get_query_var('paged')) ? get_query_var('paged') : 1;
                
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

                $companies 			= 	get_posts($args);
                $companies 			= 	(!empty($companies) && is_array($companies)) ? array_values($companies) : [];
                $final_companies 	= 	[];
                $used_positions 	= 	[];

                //Manage Post Selected Companies From ACF...
                $add_companies      =   get_field('add_companies', $postid);
                if($add_companies && !empty($add_companies)){
                    foreach($add_companies as $row){
                        if(!empty($row['select_company'])){
                            $select_company             =   $row['select_company'];
                            $position                   =   (!empty($row['position'])) ? (int) $row['position'] - 1 : 0;
                            $expire_membership_date     =   $row['expire_membership_date'];
                            $expiredate                 =   (!empty($expire_membership_date)) ? date_create_from_format('d/m/Y', $expire_membership_date)->format('Y-m-d') : '';
                            $currentDate                =   date('Y-m-d');
                    
                            if($expiredate >= $currentDate || $expiredate == ''){
                                $selectedCompID 	= 	$select_company->ID;
                                $companies_ids 		= 	array_column($companies, 'ID');

                                if(in_array($selectedCompID, $companies_ids)){

                                    $companies = array_filter($companies, function ($post) use ($selectedCompID){
                                        return $post->ID !== $selectedCompID;
                                    });

                                    $companies = array_values($companies);

                                }

                                $final_companies[$position] 	= 	$select_company;
                                $used_positions[] 				= 	$position;
                                
                            }
                        }
                    }
                }
                
                //Manage Default Companies..
                if(!empty($companies)){
                    foreach($companies as $original_company){
                        $position = 0;
                        while(isset($final_companies[$position])){
                            $position++;
                        }
                        $final_companies[$position] = $original_company;
                    }
                }
                
                //Sorting Companies
                ksort($final_companies);

                $number_of_comp 	= 	get_post_meta($postid, 'number_of_companies', true);
                $comp_limit 		= 	(!empty($number_of_comp)) ? (int)$number_of_comp : '';

                if(!empty($comp_limit)){
                    $final_companies  =  array_slice($final_companies, 0, $comp_limit, true);
                }
                
                $total_posts            =   (is_array($final_companies)) ? count($final_companies) : 0;
                $total_pages            =   ceil($total_posts / $posts_per_page);
                $offset                 =   ($page - 1) * $posts_per_page;
                $companies_to_display   =   array_slice($final_companies, $offset, $posts_per_page);

                if(!empty($companies_to_display)){
                    $company_count 	= 	(is_array($companies_to_display)) ? count($companies_to_display) : 0;
                    $countercheck	= 	1;
                    foreach($companies_to_display as $key => $comp){
                        $compID 				=   $comp->ID;
                        $company_logo 			=   (!empty(get_post_meta($compID, 'company_logo', true))) ? get_post_meta($compID, 'company_logo', true) : site_url().'/wp-content/uploads/2024/08/placeholder.jpg';
                        $sales_email 			=   (!empty(get_post_meta($compID, 'sales_email', true))) ? get_post_meta($compID, 'sales_email', true) : '';
                        $admin_contact_phone 	=   (!empty(get_post_meta($compID, 'admin_contact_phone', true))) ? get_post_meta($compID, 'admin_contact_phone', true) : '';
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
                            $html .= '<div class="company-item">
                                <div class="company-side get-conntect">
                                    <div class="connetct-body">
                                        <div class="comapny-details d-flex align-items-sm-center flex-md-row ">
                                            <div class="conntect-img"><img src="'.IT_HIPL_THEME_DIR.'/assets/images/icon/draft.svg" alt="conntect"></div>
                                            <div class="company-name">
                                                <h3 class="company-title">Get Connected With A Company For Free</h3>
                                                <p class="m-0">Tell us about your project, and we\'ll match you with vetted companies that meet your requirements.</p>
                                            </div>
                                        </div>
                                        <a href="/find-an-agency" class="btn btn-theme1">GET STARTED</a>
                                    </div>
                                </div>
                            </div>';
                        }

                        $html .='
                        <div class="company-item">
                            <div class="company-side">
                                <div class="comapny-details d-flex align-items-sm-center flex-sm-row">
                                    <div class="company-logo"><a href="'.$company_website.'?utm_source='.home_url( $wp->request ).'&utm_medium=referral&utm_campaign='.get_bloginfo('name').' target="_blank" rel="nofollow""><img src="'.$company_logo.'" alt="'.ucfirst($comp->post_title).'" target="_blank" rel="nofollow"></a></div>
                                    <div class="company-name">
                                        <h3 class="company-title"><a href="'.$company_website.'?utm_source='.home_url( $wp->request ).'&utm_medium=referral&utm_campaign='.get_bloginfo('name').'" target="_blank" rel="nofollow">'.ucfirst($comp->post_title).'</a></h3>
                                        <p class="m-0">'.ucfirst($tagline).'</p>
                                    </div>
                                </div>
                                <div class="company-list-body">
                                <div class="read-text">
                                    <p class="add-read-more trim-text">'.$comp->post_content.'</p>
                                    <!-- <a href="javascript:;" class="read-more">Read More</a> -->
                                </div>
                                    <div class="discription">';
                                        if(!empty($agency_industry) && is_array($agency_industry)){
                                            $html .=' <div class="categorie-list">
                                            <h4 class="discription-title">Industry</h4>
                                            <ul class="industry-list list">';
                                                $sliced_array = array_slice($agency_industry, 0, 5);
                                                foreach($sliced_array as $industry){ 
                                                    $industryAray   =   get_term($industry);
                                                    $term_id        =   $industryAray->term_id;
                                                    $icon           =   get_field('icon', 'term_' . $term_id);
                                                    if($icon){

                                                        $html .= '<li>
                                                            <a class="tags"><img src="'.$icon['url'].'" alt="'.$industryAray->name.'"></a>
                                                        </li>';
                                                    }
                                                }
                                                $html .= '</ul></div>';
                                            }
                                        
                                        $html .= '<div class="categorie-list">';
                                            if(!empty($location) && is_array($location)){

                                                $html .= '<h4 class="discription-title">Location</h4>
                                                <ul class="list">';

                                                    $location_array = array_slice($location, 0, 4);
                                                    foreach($location_array as $loc){
                                                        if(get_term($loc)->parent == 0){
                                                            $loctionAray = get_term($loc);
                                                            $html .= '<li><a class="tags fw-medium">'.$loctionAray->name.'</a></li>';
                                                        }
                                                    }
                                                $html .= '
                                                </ul>';
                                            }
                                        $html .= '</div>
                                    </div>
                                </div>
                            </div>
                            <div class="details-side">
                                <ul class="card-details">';
                                    if(!empty($founding_year)){
                                        $html .= '
                                        <li>
                                            <span class="icon-img"><img src="'.IT_HIPL_THEME_DIR.'/assets/images/icon/bulding.svg" alt="bulding"></span>
                                            Founded '.$founding_year.'
                                        </li>';
                                    }
                                    if(!empty($purse)){
                                        $html .= 
                                        '<li>
                                            <span class="icon-img"><img src="'.IT_HIPL_THEME_DIR.'/assets/images/icon/dollor.svg" alt="dollor"></span>
                                            '.$purse.'/hr
                                        </li>';
                                    }
                                    if(!empty($total_employees)){
                                        $html .= '
                                        <li>
                                            <span class="icon-img"><img src="'.IT_HIPL_THEME_DIR.'/assets/images/icon/users.svg" alt="users"></span>
                                            '.$total_employees.'
                                        </li>';
                                    }

                                    $html .= '
                                    <li>';
                                        $first_term     =   $agency_services[0];
                                        $term           =   get_term($services[0]);
                                        $term_name      =   $term->name;
                                        $term_link      =   get_term_link($term); 
                                        $html .= '
                                        <span class="icon-img"><img src="'.IT_HIPL_THEME_DIR.'/assets/images/icon/tag-fill.svg" alt="tag"></span>
                                        <a href="'.esc_url($term_link).'">'.esc_html( $term_name ).'</a>
                                    </li>';
                                    if(!empty($sales_email)){
                                        $html .= '
                                        <li>
                                            <span class="icon-img"><img src="'.IT_HIPL_THEME_DIR.'/assets/images/icon/email_icon.svg" alt="project-budget"></span>
                                            <a href="mailto:'.$sales_email.'" class="fw-medium text-decoration-none">'.$sales_email.'</a>
                                        </li>';
                                    }
                                    if(!empty($admin_contact_phone)){
                                        $html .= '
                                        <li>
                                            <span class="icon-img"><img src="'.IT_HIPL_THEME_DIR.'/assets/images/icon/call-calling.svg" alt="phone"></span>
                                            '.$admin_contact_phone.'
                                        </li>';
                                    }
                                $html .= '</ul>
                                <div class="contact-button d-flex flex-lg-column flex-md-row flex-column">														 
                                    <a href="'.$company_website.'?utm_source='.home_url( $wp->request ).'&utm_medium=referral&utm_campaign='.get_bloginfo('name').'" target="_blank" rel="nofollow" class="btn themebtn w-100 btn-theme1"><span class="btn-icon"><img src="'.IT_HIPL_THEME_DIR.'/assets/images/icon/globe.svg" alt="globe"></span> Visit Website</a>
                                </div>
                            </div>
                        </div>';
                        $countercheck++;
                    }
                }else{
                    $html .= '<p class="nothingf" style="display:none;">Nothing Found!</p>';
                }

                if($total_pages > 1){
                    $paginationHtml .= '<div class="pagination">';
                    if($page > 1){
                        $paginationHtml .= '<a href="#" class="pagination-link" data-page="' . ($page - 1) . '">&laquo; Previous</a>';
                    }
                    for($i = 1; $i <= $total_pages; $i++){
                        if($i === $page){
                            $paginationHtml .= '<span class="current-page">' . $i . '</span>';
                        }else{
                            $paginationHtml .= '<a href="#" class="pagination-link" data-page="' . $i . '">' . $i . '</a>';
                        }
                    }
                    if($page < $total_pages){
                        $paginationHtml .= '<a href="#" class="pagination-link" data-page="' . ($page + 1) . '">Next &raquo;</a>';
                    }
                    $paginationHtml .= '</div>';
                }
            }
            $return['companies_list']   =   $html;
            $return['pagination']       =   $paginationHtml;
            echo json_encode($return);
            exit();
        }
    }

    ITFirmsAjaxHandler::init();
}