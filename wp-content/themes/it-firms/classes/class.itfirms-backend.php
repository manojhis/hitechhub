<?php
if(!defined('ABSPATH')){
    exit();
}
/**
 * CLASS ITFirmsBackend
 */
if(!class_exists('ITFirmsBackend', false)){
    class ITFirmsBackend{
        public static function init(){
            //LEADS
            add_action( 'admin_menu', [__CLASS__, 'itf_register_admin_menus_cb'] );

            //Agency Columns
            add_filter( 'manage_agency_posts_columns', [__CLASS__, 'itf_agency_columns_cb'] );
            add_action( 'manage_agency_posts_custom_column', [__CLASS__, 'itf_agency_column_val_cb'], 10, 2 );
            add_filter( 'manage_edit-agency_sortable_columns', [__CLASS__, 'itf_sortable_agency_columns_cb'] );
            add_action( 'pre_get_posts', [__CLASS__, 'itf_agency_order_column_orderby_cb'] );
        }

        //COMPANIES
        public static function itf_register_admin_menus_cb(){
            add_menu_page(
                'Leads',               
                'Leads',               
                'manage_options',      
                'leads-admin-page',    
                [__CLASS__, 'companies_admin_page_cb'], 
                'dashicons-businessperson', 
                20                     
            );

            // Add Companies submenu
            add_submenu_page(
                'leads-admin-page',    
                'Companies',           
                'Companies',           
                'manage_options',      
                'companies-admin-page',
                [__CLASS__, 'companies_admin_page_cb'] 
            );

            // Add Contact List submenu
            add_submenu_page(
                'leads-admin-page',    
                'Form Submissions',        
                'Form Submissions',        
                'manage_options',      
                'contact-form-submissions', 
                [__CLASS__, 'display_contact_form_submissions_page']
            );

            // Add Contact List submenu
            add_submenu_page(
                'leads-admin-page',    
                'Proposals',        
                'Proposals',        
                'manage_options',      
                'proposals-form-submissions', 
                [__CLASS__, 'display_proposals_form_submissions_page']
            );

            // Add Contact List submenu
            add_submenu_page(
                'leads-admin-page',    
                'Import Posts',        
                'Import Posts',        
                'manage_options',      
                'import-posts-page', 
                [__CLASS__, 'itf_import_posts_page_cb']
            );
        }

        public static function companies_admin_page_cb(){
            global $wpdb;
            $per_page       = 10;
            $current_page   = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
            $companies      = self::get_companies($per_page, $current_page);

            echo '<div class="wrap">';
            echo '<h1 class="wp-heading-inline">Manage Companies</h1>';
            echo '<hr class="wp-header-end">';
            echo '<div class="companies-admin-page">';
            // Display companies data
            echo '<table class="widefat" id="companies-list">';
            echo '<thead>
                    <tr>
                        <th>No.</th>
                        <th>Logo</th>
                        <th>Company Name</th>
                        <th>Website Url</th>
                        <th>Country</th>
                        <th>Established On</th>
                        <th>Employees</th>
                        <th>Rate</th>
                        <th>Email</th>
                        <th>Services</th>
                        <th>Contact</th>
                        <th>Clients</th>
                        <th>Description</th>
                        <th>IP Address</th>
                        <th>Page URL</th>
                        <th>System Time</th>
                        <th>Client Time</th>
                    </tr>
                </thead>';
            echo '<tbody>';
            $count = 1;
            foreach($companies as $company){
                $user_ip_info = json_decode($company['ip_info'], true);
                echo '<tr>';
                echo '<td>' . esc_html($count) . '</td>';
                echo '<td><img src="'.$company['comp_logo'].'" height="80" width="80"></td>';
                echo '<td>' . esc_html($company['title']) . '</td>';
                echo '<td>' . esc_html($company['website_url']) . '</td>';
                echo '<td>' . esc_html($company['country_name']) . '</td>';
                echo '<td>' . esc_html($company['comp_established_on']) . '</td>';
                echo '<td>' . esc_html($company['employees']) . '</td>';
                echo '<td>' . esc_html($company['hourly_rate']) . '</td>';
                echo '<td>' . esc_html($company['comp_email']) . '</td>';
                echo '<td>' . esc_html($company['services_provided']) . '</td>';
                echo '<td>' . esc_html($company['comp_contact']) . '</td>';
                echo '<td>' . esc_html($company['key_client']) . '</td>';
                echo '<td>' . esc_html($company['description']) . '</td>';
                echo '<td>' . esc_html($user_ip_info['ip']) . '</td>';
                echo '<td>' . esc_html($company['page_url']) . '</td>';
                echo '<td>' . esc_html($company['create_date']) . '</td>';
                echo '<td>' . esc_html($company['client_time']) . '</td>';
                echo '</tr>';

                $count++;
            }
            echo '</tbody>';
            echo '</table>';

            // Pagination
            $total_items = $wpdb->get_var("SELECT COUNT(id) FROM {$wpdb->prefix}companies_list");
            $total_pages = ceil($total_items / $per_page);

            if($total_pages > 1){
                $page_links = paginate_links(array(
                    'base' => add_query_arg('paged', '%#%'),
                    'format' => '',
                    'prev_text' => __('&laquo; Previous'),
                    'next_text' => __('Next &raquo;'),
                    'total' => $total_pages,
                    'current' => $current_page
                ));

                if($page_links){
                    echo '<div class="tablenav">';
                    echo '<div class="tablenav-pages">';
                    echo '<span class="displaying-num">' . sprintf(_n('1 item', '%s items', $total_items), number_format_i18n($total_items)) . '</span>';
                    echo '<span class="pagination-links">' . $page_links . '</span>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            echo '</div>';
            echo '</div>';
        }

        public static function get_companies($per_page = 10, $page_number = 1){
            global $wpdb;
            $table_name     =   $wpdb->prefix.'companies_list';
            $offset         =   ($page_number - 1) * $per_page;
            $sql            =   "SELECT * FROM $table_name ORDER BY create_date DESC LIMIT $per_page OFFSET $offset";
            $results        =   $wpdb->get_results($sql, 'ARRAY_A');
            return $results;
        }
        
        public static function display_contact_form_submissions_page(){
            global $wpdb;
            $per_page       =   10;
            $current_page   =   isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
            $submissions    =   self::get_contact_form_submissions($per_page, $current_page);

            echo '<div class="wrap">';
            echo '<div class="itfirms-contact-list-page">';
            echo '<h1 class="wp-heading-inline">Contact Form Submissions</h1>';
            echo '<hr class="wp-header-end">';

            // Display submissions data
            echo '<table class="widefat" id="contact-list">';
            echo '<thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Description</th>
                        <th>IP Address</th>
                        <th>Page URL</th>
                        <th>Current Time</th>
                        <th>Client Time</th>
                    </tr>
                </thead>';
            echo '<tbody>';
            $count = 1;
            foreach($submissions as $submission){
                $user_ip_info = json_decode($submission['ip_info'], true);
                echo '<tr>';
                echo '<td>' . esc_html($count) . '</td>';
                echo '<td>' . esc_html($submission['name']) . '</td>';
                echo '<td>' . esc_html($submission['email']) . '</td>';
                echo '<td>' . esc_html($submission['contact_no']) . '</td>';
                echo '<td>' . esc_html($submission['description']) . '</td>';
                echo '<td>' . esc_html($user_ip_info['ip']) . '</td>';
                echo '<td>' . esc_html($submission['page_url']) . '</td>';
                echo '<td>' . esc_html($submission['create_date']) . '</td>';
                echo '<td>' . esc_html($submission['visiter_time']) . '</td>';
                echo '</tr>';
                $count++;
            }
            echo '</tbody>';
            echo '</table>';

            // Pagination
            $total_items = $wpdb->get_var("SELECT COUNT(id) FROM {$wpdb->prefix}contact_list");
            $total_pages = ceil($total_items / $per_page);

            if($total_pages > 1){
                $page_links = paginate_links(array(
                    'base'      =>  add_query_arg('paged', '%#%'),
                    'format'    =>  '',
                    'prev_text' =>  __('&laquo; Previous'),
                    'next_text' =>  __('Next &raquo;'),
                    'total'     =>  $total_pages,
                    'current'   =>  $current_page
                ));

                if($page_links){
                    echo '<div class="tablenav">';
                    echo '<div class="tablenav-pages">';
                    echo '<span class="displaying-num">' . sprintf(_n('1 item', '%s items', $total_items), number_format_i18n($total_items)) . '</span>';
                    echo '<span class="pagination-links">' . $page_links . '</span>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            echo '</div>';
            echo '</div>';
        }

        public static function get_contact_form_submissions($per_page = 10, $page_number = 1){
            global $wpdb;
            $table_name     =   $wpdb->prefix.'contact_list';
            $offset         =   ($page_number - 1) * $per_page;
            $sql            =   "SELECT * FROM $table_name ORDER BY create_date DESC LIMIT $per_page OFFSET $offset";
            $results        =   $wpdb->get_results($sql, 'ARRAY_A');
            return $results;
        }

        //AGENCY COLUMNS
        public static function itf_agency_columns_cb($columns){
            $new_columns = [];
            foreach($columns as $key => $value){
                if($key == 'date'){
                    $new_columns['agency_order'] = __('Agency Order', 'it-firms');
                    $new_columns['featured'] = __('Featured', 'it-firms');
                }
                $new_columns[$key] = $value;
            }
            return $new_columns;
        }

        public static function itf_agency_column_val_cb($column, $post_id){
            switch($column){
                case 'agency_order':
                    $agency_order = get_post_meta($post_id, 'company_order', true);
                    echo esc_html($agency_order);
                    break;
        
                case 'featured':
                    $featured = get_post_meta($post_id, 'featured_assign', true);
                    echo $featured ? __('Yes', 'it-firms') : __('No', 'it-firms');
                    break;
            }
        }

        public static function itf_sortable_agency_columns_cb($columns){
            $columns['agency_order'] = 'agency_order';
            return $columns;
        }

        public static function itf_agency_order_column_orderby_cb($query){
            if(!is_admin()){
                return;
            }
            $orderby = $query->get('orderby');

            if('agency_order' == $orderby){
                $query->set('meta_key', 'company_order');
                $query->set('orderby', 'meta_value');
            }
        }

        //IMPORT POSTS
        public static function itf_import_posts_page_cb(){
            ?>
            <div class="wrap" id="importplaylists-section">
                <h1>Posts Importer</h1>
                <form id="playlists-importForm" enctype="multipart/form-data" method="POST">
                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row"><label for="posts_import_file">Import File (CSV):</label></th>
                            <td><input type="file" name="posts_import_file" id="posts_import_file" accept=".csv"/></td>
                        </tr>
                    </table>
                    <?php submit_button('Import'); ?>
                </form>
                <?php self::handle_csv_upload(); ?>
            </div>
            <?php
        }

        //HANDLE CSV UPLOAD
        public static function handle_csv_upload(){
            if(isset($_FILES['posts_import_file']) && $_FILES['posts_import_file']['error'] == 0){
                // Check the file extension and MIME type
                $file_info          =   pathinfo($_FILES['posts_import_file']['name']);
                $file_extension     =   strtolower($file_info['extension']);
                $mime_type          =   mime_content_type($_FILES['posts_import_file']['tmp_name']);
                $allowed_extensions =   ['csv'];
                $allowed_mime_types =   ['text/csv', 'application/csv', 'text/plain', 'application/vnd.ms-excel'];

                if(!in_array($file_extension, $allowed_extensions) || !in_array($mime_type, $allowed_mime_types)){
                    echo '<div class="error"><p>Please upload a valid CSV file.</p></div>';
                    return;
                }

                $file   =   $_FILES['posts_import_file']['tmp_name'];
                $handle =   fopen($file, 'r');
                if($handle !== false){
                    $counter = 0;
                    // Loop through CSV rows
                    while(($data = fgetcsv($handle, 1000, ',')) !== false){
                        if($counter != 0){
                            $title         =   esc_html($data[0]);
                            $service       =   esc_html($data[1]);
                            $location      =   esc_html($data[2]);
                            $industry      =   esc_html($data[3]);
                            $slug          =   sanitize_title($data[4]);
                            $metatitle     =   esc_html($data[5]);
                            $metaDesc      =   $data[6];

                            $services       =   get_term_by('slug', $service, 'services');
                            $service_id     =   (!empty($services)) ? [$services->term_id] : '';

                            $location       =   get_term_by('slug', $location, 'location');
                            $location_id    =   (!empty($location)) ? [$location->term_id] : '';

                            $industries      =   get_term_by('slug', $industry, 'industries');
                            $industries_id   =   (!empty($industries)) ? [$industries->term_id] : '';

                            // Insert the post
                            $post_id = wp_insert_post([
                                'post_title'    =>  wp_strip_all_tags($title),
                                'post_type'     =>  'post',
                                'post_name'     =>  $slug,
                            ]);

                            // If post was successfully inserted
                            if($post_id){
                                // Add/Update post meta
                                update_post_meta($post_id, 'sub_heading', $metatitle);
                                update_post_meta($post_id, 'additional_description', $metaDesc);

                                if(!empty($service_id)){
                                    update_post_meta($post_id, 'services', $service_id); 
                                }

                                if(!empty($location_id)){
                                    update_post_meta($post_id, 'location', $location_id); 
                                }

                                if(!empty($industries_id)){
                                    update_post_meta($post_id, 'industry', $industries_id); 
                                }
                            }
                        }
                        $counter++;
                    }
                    fclose($handle);
                    echo '<div class="updated"><p>Import completed.</p></div>';
                }else{
                    echo '<div class="error"><p>Unable to open the file.</p></div>';
                }
            }
        }

        //proposals
        public static function display_proposals_form_submissions_page(){
            global $wpdb;
            $per_page       =   10;
            $current_page   =   isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
            $submissions    =   self::get_proposals_list_submissions($per_page, $current_page);

            echo '<div class="wrap">';
            echo '<div class="itfirms-proposals-list-page">';
            echo '<h1 class="wp-heading-inline">Proposals</h1>';
            echo '<hr class="wp-header-end">';

            // Display submissions data
            echo '<table class="widefat" id="contact-list">';
            echo '<thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Budget</th>
                        <th>Description</th>
                        <th>IP Address</th>
                        <th>Page URL</th>
                        <th>Current Time</th>
                        <th>Client Time</th>
                    </tr>
                </thead>';
            echo '<tbody>';
            $count = 1;
            foreach($submissions as $submission){
                // echo '<pre>';
                // print_r($submission);
                // echo '</pre>';
                $user_ip_info = json_decode($submission['ip_info'], true);
                echo '<tr>';
                echo '<td>' . esc_html($count) . '</td>';
                echo '<td>' . esc_html($submission['name']) . '</td>';
                echo '<td>' . esc_html($submission['email']) . '</td>';
                echo '<td>' . esc_html($submission['subject']) . '</td>';
                echo '<td>' . esc_html($submission['budget']) . '</td>';
                echo '<td>' . esc_html($submission['description']) . '</td>';
                echo '<td>' . esc_html($user_ip_info['ip']) . '</td>';
                echo '<td>' . esc_html($submission['page_url']) . '</td>';
                echo '<td>' . esc_html($submission['created']) . '</td>';
                echo '<td>' . esc_html($submission['visiter_time']) . '</td>';
                echo '</tr>';
                $count++;
            }
            echo '</tbody>';
            echo '</table>';

            // Pagination
            $total_items = $wpdb->get_var("SELECT COUNT(id) FROM {$wpdb->prefix}proposals_list");
            $total_pages = ceil($total_items / $per_page);

            if($total_pages > 1){
                $page_links = paginate_links(array(
                    'base'      =>  add_query_arg('paged', '%#%'),
                    'format'    =>  '',
                    'prev_text' =>  __('&laquo; Previous'),
                    'next_text' =>  __('Next &raquo;'),
                    'total'     =>  $total_pages,
                    'current'   =>  $current_page
                ));

                if($page_links){
                    echo '<div class="tablenav">';
                    echo '<div class="tablenav-pages">';
                    echo '<span class="displaying-num">' . sprintf(_n('1 item', '%s items', $total_items), number_format_i18n($total_items)) . '</span>';
                    echo '<span class="pagination-links">' . $page_links . '</span>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            echo '</div>';
            echo '</div>';
        }

        public static function get_proposals_list_submissions($per_page = 10, $page_number = 1){
            global $wpdb;
            $table_name     =   $wpdb->prefix.'proposals_list';
            $offset         =   ($page_number - 1) * $per_page;
            $sql            =   "SELECT * FROM $table_name ORDER BY created DESC LIMIT $per_page OFFSET $offset";
            $results        =   $wpdb->get_results($sql, 'ARRAY_A');
            return $results;
        }
    }

    ITFirmsBackend::init();
}