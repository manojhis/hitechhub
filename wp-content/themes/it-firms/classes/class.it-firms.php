<?php
if(!defined('ABSPATH')){
    exit();
}
/**
 * CLASS ITFirms
 */
if(!class_exists('ITFirms', false)){
    class ITFirms{
        public static function init(){
            require_once(get_template_directory().'/classes/class.itfirms-backend.php');
            require_once(get_template_directory().'/classes/class.itfirms-ajax-handler.php');
            require_once(get_template_directory().'/classes/class.itfirms-taxonomy-rewrite.php');

            // add_action( 'init', [__CLASS__, 'itf_import_company_cb'] );
            // add_action('process_csv_chunk', [__CLASS__, 'process_csv_chunk'], 10, 2);

            add_action( 'wp_enqueue_scripts', [__CLASS__, 'itf_enqueue_styles_cb'] );
            //search suggetion..
            add_action( 'wp_ajax_itfirms_search', [__CLASS__, 'itfirms_search_cb'] );
            add_action( 'wp_ajax_nopriv_itfirms_search', [__CLASS__, 'itfirms_search_cb'] );
            add_action( 'pre_get_posts', [__CLASS__, 'custom_posts_per_custom_post_type_archive' ]);

            //Submit Contact Form..
            add_action( 'wp_ajax_itfirms_contact_submit', [__CLASS__, 'itfirms_contact_submit_cb'] );
            add_action( 'wp_ajax_nopriv_itfirms_contact_submit', [__CLASS__, 'itfirms_contact_submit_cb'] );
        }
        
        // Old Import Code
        /*
        public static function itf_import_company_cb(){
            $file_path = get_template_directory().'/assets/csv/company_data.csv';
            // Open the CSV file
            if(($handle = fopen($file_path, 'r')) !== false){
                // Read the header row
                $header = fgetcsv($handle, 1000, ',');
                // Loop through the remaining rows
                while (($row = fgetcsv($handle, 1000, ',')) !== false){
                    // Combine the header with the row data to create an associative array
                    $data = array_combine($header, $row);

                    $title                      =   $data['company_name'];
                    $company_logo               =   $data['company_logo'];
                    $company_website_url        =   $data['company_website_url'];
                    $address                    =   $data['address'];
                    $mobile_num                 =   $data['mobile_num'];
                    $history                    =   $data['history'];
                    $people                     =   $data['people'];
                    $rate                       =   $data['rate'];
                    $purse                      =   $data['purse'];
                    $review_count               =   $data['review_count'];
                    $description                =   $data['description'];
                    $service_points             =   $data['service_points'];
                    $created_at                 =   $data['created_at'];
                    $updated_at                 =   $data['updated_at'];

                    $publish_date               =   date('Y-m-d H:i:s', strtotime($created_at)); 

                    $existing_post              =   get_page_by_title($title, OBJECT, 'agency');

                    if($existing_post === null){
                        $post_id = wp_insert_post([
                            'post_title'   =>   $title,
                            'post_type'    =>   'agency',
                            'post_status'  =>   'publish',
                            'post_date'    =>   $publish_date,
                        ]);
                        if(!is_wp_error($post_id)){
                            update_post_meta($post_id, 'company_website', $company_website_url);
                            update_post_meta($post_id, 'total_employees', $people);
                            update_post_meta($post_id, 'founding_year', $history);
                            update_post_meta($post_id, 'admin_contact_phone', $mobile_num);
                            update_post_meta($post_id, 'company_logo', $company_logo);
                            update_post_meta($post_id, 'description', $description);
                            update_post_meta($post_id, 'street', $address);
                            update_post_meta($post_id, 'contact_number', $mobile_num);
                            update_post_meta($post_id, 'reviews', $review_count);
                            update_post_meta($post_id, 'rate', $rate);
                            update_post_meta($post_id, 'purse', $purse);
                        }
                    }
                }
                // Close the file handle
                fclose($handle);
            }else{
                echo "Error opening the file.";
            }
        }
        */


        // New Import Code
        /*
        public static function itf_import_company_cb(){
            if(isset($_GET['operation']) && $_GET['operation'] == 'import'){
                $file_path      =   get_template_directory().'/assets/csv/company_data.csv';
                $chunk_size     =   100; // Number of rows to process per chunk
                $chunks         =   [];
            
                // Open the CSV file
                if(($handle = fopen($file_path, 'r')) !== false){
                    // Read the header row
                    $header = fgetcsv($handle, 1000, ',');
            
                    // Loop through the remaining rows
                    while (($row = fgetcsv($handle, 1000, ',')) !== false){
                        // Combine the header with the row data to create an associative array
                        $data = array_combine($header, $row);
                        $chunks[] = $data;
                        // If chunk is full, schedule a cron event
                        if(count($chunks) >= $chunk_size){
                            self::schedule_import_chunk($chunks);
                            $chunks = []; // Reset the chunk
                        }
                    }
            
                    // Schedule the remaining chunk
                    if(!empty($chunks)){
                        self::schedule_import_chunk($chunks);
                    }
            
                    // Close the file handle
                    fclose($handle);
                }else{
                    echo "Error opening the file.";
                }
            }
        }

        // Schedule a cron event to process the chunk
        public static function schedule_import_chunk($chunk){
            $timestamp = time();
            $unique = wp_unique_id('import_chunk_');
            wp_schedule_single_event($timestamp, 'process_csv_chunk', [$chunk, $unique]);
        }

        public static function process_csv_chunk($chunk, $unique_id){
            foreach($chunk as $data){
                $title                  =   $data['company_name'];
                $company_logo           =   $data['company_logo'];
                $company_website_url    =   $data['company_website_url'];
                $address                =   $data['address'];
                $mobile_num             =   $data['mobile_num'];
                $history                =   $data['history'];
                $people                 =   $data['people'];
                $rate                   =   $data['rate'];
                $purse                  =   $data['purse'];
                $review_count           =   $data['review_count'];
                $description            =   $data['description'];
                $service_points         =   $data['service_points'];
                $created_at             =   $data['created_at'];
                $updated_at             =   $data['updated_at'];
        
                $publish_date = date('Y-m-d H:i:s', strtotime($created_at)); 
        
                $existing_post = get_page_by_title($title, OBJECT, 'agency');
        
                if($existing_post === null){
                    $post_id = wp_insert_post([
                        'post_title'    =>  $title,
                        'post_type'     =>  'agency',
                        'post_status'   =>  'publish',
                        'post_date'     =>  $publish_date,
                    ]);
                    if(!is_wp_error($post_id)){

                        update_post_meta($post_id, 'company_website', $company_website_url);
                        update_post_meta($post_id, 'total_employees', $people);
                        update_post_meta($post_id, 'founding_year', $history);
                        update_post_meta($post_id, 'admin_contact_phone', $mobile_num);
                        update_post_meta($post_id, 'description', $description);
                        update_post_meta($post_id, 'street', $address);
                        update_post_meta($post_id, 'contact_number', $mobile_num);
                        update_post_meta($post_id, 'reviews', $review_count);
                        update_post_meta($post_id, 'rate', $rate);
                        update_post_meta($post_id, 'purse', $purse);
                        update_post_meta($post_id, 'services_listed_from_excel', $service_points);

                        // Upload company logo and get the URL
                        $company_logo = self::upload_image_from_url($company_logo);
                        update_post_meta($post_id, 'company_logo', $company_logo);
                    }
                }
            }
        }

        // Function to upload image from URL and return the URL of the uploaded image
        public static function upload_image_from_url($image_url){
            // Check if image URL is empty or invalid
            if(empty($image_url) || !filter_var($image_url, FILTER_VALIDATE_URL)){
                return null;
            }

            $upload_dir = wp_upload_dir();
            $custom_dir = $upload_dir['basedir'] . '/agencies-logo';
            $custom_url = $upload_dir['baseurl'] . '/agencies-logo';

            // Create the custom directory if it doesn't exist
            if(!wp_mkdir_p($custom_dir)){
                return null;
            }

            $image_data = @file_get_contents($image_url);
            if($image_data === false){
                return null;
            }

            $filename = basename($image_url);
            $file = $custom_dir . '/' . $filename;
            if(file_put_contents($file, $image_data) === false){
                return null;
            }

            $wp_filetype = wp_check_filetype($filename, null);
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => sanitize_file_name($filename),
                'post_content' => '',
                'post_status' => 'inherit',
                'guid' => $custom_url . '/' . $filename
            );

            $attach_id = wp_insert_attachment($attachment, $file);
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata($attach_id, $file);
            wp_update_attachment_metadata($attach_id, $attach_data);

            return wp_get_attachment_url($attach_id);
        }
        */
        

        public static function itf_enqueue_styles_cb(){
            $version = time();
            // Enqueue additional stylesheet
            wp_enqueue_style('itfirms-bootstrap-min-css', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), $version, 'all');
           /* wp_enqueue_style('itfirms-blog-details-min-css', get_template_directory_uri() . '/assets/css/blog-details.min.css', array(), $version, 'all');
            wp_enqueue_style('itfirms-list-page-min-css', get_template_directory_uri() . '/assets/css/list-page.min.css', array(), $version, 'all');
            wp_enqueue_style('company-list-page-min-css', get_template_directory_uri() . '/assets/css/company-list-page.min.css', array(), $version, 'all');
            wp_enqueue_style('index-min-css', get_template_directory_uri() . '/assets/css/index.min.css', array(), $version, 'all');*/
            
            // Enqueue jQuery (already included with WordPress)
            wp_enqueue_script('jquery');
            // Enqueue Additional script
            wp_enqueue_script('itfirms-bootstrap-bundle-min-js', get_template_directory_uri() . '/assets/libs/bootstrap/js/bootstrap.bundle.min.js', array('jquery'), $version, true);
            wp_enqueue_script('itfirms-main-js', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), $version, true);
            wp_enqueue_script('itfirmsFunctions-js', get_template_directory_uri() . '/assets/js/itfirmsFunctions.js', array('jquery'), $version, true);
            // Localize the script with new data
            $itfirmsScriptdata = array(
                'ajaxUrl'    => admin_url( 'admin-ajax.php')
            );
            wp_localize_script( 'itfirmsFunctions-js', 'itfirmsScriptData', $itfirmsScriptdata );
        }

        /**
         * SEARCH
         */
        public static function itfirms_search_cb(){
            $return = [];
            $search = (isset($_POST['search'])) ? $_POST['search'] : '';
            $output = '';
            if(!empty($search)){
                $args   = [
                    'post_type'         =>  array('post'), 
                    'posts_per_page'    =>  -1, 
                    'post_status'       =>  'publish',
                ];
                
                // Add the filter to search only by title
                add_filter('posts_where', function($where, $wp_query) use ($search) {
                    global $wpdb;
                    $where .= " AND {$wpdb->posts}.post_title LIKE '%" . esc_sql($wpdb->esc_like($search)) . "%'";
                    return $where;
                }, 10, 2);
    
                
                $query  = new WP_Query($args);
                if($query->have_posts()){
                    $titles = array();
                    while($query->have_posts()){
                        $query->the_post();
                        $output .= '<li><a style="color:#000;" href="'.get_permalink().'">'.get_the_title().'</a></li>';
                    }
                    wp_reset_postdata();
                }
            }
            $return['output'] = $output;
            echo json_encode($return);
            exit;
        }

        public static function custom_posts_per_custom_post_type_archive($query){
            if(!is_admin() && $query->is_main_query() && (is_category() || is_archive())){
                $query->set('posts_per_page', 5); // Adjust the number here
            }
        }

        public static function  itfirms_contact_submit_cb(){
            $name       =   (isset($_POST['itf_contact_name']))     ?   $_POST['itf_contact_name']      :   '';
            $email      =   (isset($_POST['itf_contact_email']))    ?   $_POST['itf_contact_email']     :   '';
            $phone      =   (isset($_POST['itf_contact_phone']))    ?   $_POST['itf_contact_phone']     :   '';
            $msg        =   (isset($_POST['itf_contact_message']))  ?   $_POST['itf_contact_message']   :   '';
            $edit_id    =   (isset($_POST['itf_edit_id']))  ?   $_POST['itf_edit_id']   :   '';
            $contact_current_time   =   (isset($_POST['contact_current_time'])) ? $_POST['contact_current_time'] : '';
            $current_url            =   (isset($_POST['contact_current_page'])) ? $_POST['contact_current_page'] : '';
            $ip_address             =   get_ipinfo(); 
            $datetimenow            =   current_time('Y-m-d H:i:s');
            $data                   =   json_decode($ip_address, true);
            $visitorTimezone        =   $data['timezone'];
            $dateTime               =   new DateTime('now', new DateTimeZone($visitorTimezone));
            $visiter_time           =   $dateTime->format('Y-m-d H:i:s');
            $return     =   [];
            global $wpdb;
            $tableName = $wpdb->prefix.'contact_list';
            if(!empty($contact_current_time)){
                $checkrowalreadyexists = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."contact_list` WHERE time='$contact_current_time' LIMIT 1");
                if(!empty($checkrowalreadyexists)){
                    $data = [
                        'name'          =>  $name,
                        'email'         =>  $email,
                        'contact_no'    =>  $phone,
                        'description'   =>  $msg,
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
                        'email'         =>  $email,
                        'contact_no'    =>  $phone,
                        'description'   =>  $msg,
                        'ip_info'       =>  $ip_address,
                        'page_url'      =>  $current_url,
                        'create_date'   =>  $datetimenow,
                        'visiter_time'  =>  $visiter_time,
                        'time'          =>  $contact_current_time,
                    ];
                    $result = $wpdb->insert($tableName, $data);
                    if($result){
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
            exit;
        }
    }

    ITFirms::init();
}