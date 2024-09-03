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
			
			add_action( 'admin_footer', [__CLASS__, 'hth_manage_admin_menu_pages_popups_cb'] );
			
			//Entry Details Process
			add_action('wp_ajax_get_entry_details', [__CLASS__, 'hth_get_entry_details_cb']);
			add_action('wp_ajax_nopriv_get_entry_details', [__CLASS__, 'hth_get_entry_details_cb']);
			
			//Entry Delete Process
			add_action('wp_ajax_delete_entry_process', [__CLASS__, 'delete_entry_process_cb']);
			add_action('wp_ajax_nopriv_delete_entry_process', [__CLASS__, 'delete_entry_process_cb']);
			
			//Fetch Edit Entries in Edit model
			add_action('wp_ajax_get_entry_details_edit', [__CLASS__, 'hth_get_entry_details_edit_cb']);
			add_action('wp_ajax_nopriv_get_entry_details_edit', [__CLASS__, 'hth_get_entry_details_edit_cb']);
			
			//Edit Company Entry proces
			add_action('wp_ajax_hth_edit_company_entry_process', [__CLASS__, 'hth_edit_company_entry_process_cb']);
			add_action('wp_ajax_nopriv_hth_edit_company_entry_process', [__CLASS__, 'hth_edit_company_entry_process_cb']);
			
			//Edit Contact Us Entry
			add_action('wp_ajax_hth_edit_contactus_entry_process', [__CLASS__, 'hth_edit_contactus_entry_process_cb']);
			add_action('wp_ajax_nopriv_hth_edit_contactus_entry_process', [__CLASS__, 'hth_edit_contactus_entry_process_cb']);
			
			//Edit Proposal Entry
			add_action('wp_ajax_hth_edit_proposal_entry_process', [__CLASS__, 'hth_edit_proposal_entry_process_cb']);
			add_action('wp_ajax_nopriv_hth_edit_proposal_entry_process', [__CLASS__, 'hth_edit_proposal_entry_process_cb']);
        }

        //COMPANIES
        public static function itf_register_admin_menus_cb(){
            $current_user = wp_get_current_user();
            $last_login_time = get_user_meta ( $current_user->ID, 'last_login', true );
            $flag = self::get_flag_count( 'companies_list' );
            $label = $flag > 0 ? 'Leads <span class="awaiting-mod leads-bubble">'.$flag.'</span>' : 'Leads';
            add_menu_page(
                'Leads',
                $label,
                'manage_options',
                'leads-admin-page',
                [__CLASS__, 'companies_admin_page_cb'], 
                'dashicons-businessperson', 
                2
            );

            // Add Companies submenu
            // add_submenu_page(
            //     'leads-admin-page',    
            //     'Companies',           
            //     'Companies',           
            //     'manage_options',      
            //     'companies-admin-page',
            //     [__CLASS__, 'companies_admin_page_cb'] 
            // );

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
            // add_submenu_page(
            //     'leads-admin-page',    
            //     'Import Posts',        
            //     'Import Posts',        
            //     'manage_options',      
            //     'import-posts-page', 
            //     [__CLASS__, 'itf_import_posts_page_cb']
            // );
        }

        public static function companies_admin_page_cb(){
            global $wpdb;
            //reset the wd_status
            self::reset_flag_count( 'companies_list' );
            // $per_page       = 10;
            // $current_page   = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
            // $companies      = self::get_companies($per_page, $current_page);
            $companies         = self::get_companies();

            echo '<div class="wrap itfirms-contact-list-page">';
            echo '<h1 class="wp-heading-inline">Manage Companies</h1>';
            echo '<hr class="wp-header-end">';
            echo '<div class="companies-admin-page">';
			echo '<form method="POST" id="leads-admin-page-form">';
			echo '<div class="bulk-actions" style="margin-bottom: 15px;">';
			echo '<select name="bulk_action" id="bulk_action">
					<option value="">Bulk Actions</option>
					<option value="delete">Delete Selected</option>
				  </select>';
			echo '<button type="submit" class="button action" name="apply_bulk_action">Apply</button>';
			echo '</div>';
			echo '<div class="custom-admin-loader" style="display:none; text-align:center;"><img class="hitech-hub-loader" src="https://hitechhub.co/wp-content/uploads/2024/08/hitechhub-loader-1.gif" height="30" width="30" /></div>';
			
            // Display companies data
            echo '<table class="widefat" id="companies-list">';
            echo '<thead>
                    <tr>
                        <th><input type="checkbox" id="custom-select-all-companies"></th>
                        <th>Logo</th>
                        <th>Company Name</th>
						<th>Email</th>
                        <th>Website Url</th>
						<th>IP Address</th>
						<th>IP Location</th>
						<th>Submitted On</th>
                        <th>Actions</th>
                    </tr>
                </thead>';
            echo '<tbody>';
            $count = 1;
            foreach($companies as $company){
                $user_ip_info 	= 	(!empty($company['ip_info'])) ? json_decode($company['ip_info'], true) : [];
				$ipcity	  		= 	(isset($user_ip_info['city'])) ? $user_ip_info['city'] : '';
				$ipregion	    = 	(isset($user_ip_info['region'])) ? $user_ip_info['region'] : '';
                echo '<tr>';
                echo '<td><input type="checkbox" class="custom-hth-company-checkbox" name="selected_companies[]" value="' . esc_attr($company['id']) . '"></td>';
                echo '<td><img src="'.$company['comp_logo'].'" height="80" width="80"></td>';
                echo '<td>' . esc_html($company['title']) . '</td>';
				echo '<td>' . esc_html($company['comp_email']) . '</td>';
                echo '<td>' . esc_html($company['website_url']) . '</td>';
				echo '<td>' . esc_html((isset($user_ip_info['ip'])) ? $user_ip_info['ip'] : '') . '</td>';
				echo '<td>' . esc_html($ipcity) . '</td>';
                echo '<td>' . esc_html($company['create_date']) . '</td>';
                echo '<td>
				<div class="action_btn">
                	<a href="javascript:;" id="view-company" data-id="'.$company['id'].'" data-tablename="companies_list" class="dashicons dashicons-visibility custom-view-details"></a>
                    <a href="#" id="edit-company" data-tableName="companies_list" data-id="' . $company['id'] . '" class="dashicons dashicons-edit edit-details"></a>
                    <a href="#" id="delete-company" data-tableName="companies_list" data-id="' . $company['id'] . '" class="dashicons dashicons-trash delete-entry"></a>
				</div>
                </td>';
                echo '</tr>';

                $count++;
            }
            echo '</tbody>';
            echo '</table>';

            // Pagination
            /*
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
			*/
            echo '</div>';
			echo '</form>';
            echo '</div>';
			self::companies_bulk_action_handler();
        }
		
		//HANDLE COMPANIES BULK PROCESS
		public static function companies_bulk_action_handler(){
			global $wpdb;
			if (isset($_POST['apply_bulk_action']) && isset($_POST['bulk_action']) && $_POST['bulk_action'] === 'delete') {
				if(isset($_POST['selected_companies']) && !empty($_POST['selected_companies'])){
					$company_ids = array_map('intval', $_POST['selected_companies']);
					if(!empty($company_ids)){
						foreach($company_ids as $id){
							$wpdb->delete($wpdb->prefix . 'companies_list', ['id' => $id], ['%d']);
						}
						// Ensure there is no output before the redirect
                		if (!headers_sent()) {
                    		wp_redirect(add_query_arg('paged', $_GET['paged'], admin_url('admin.php?page=leads-admin-page')));
                    		exit();
                		} else {
							echo '<script type="text/javascript">';
							echo 'window.location.href="'. add_query_arg('paged', $_GET['paged'], admin_url('admin.php?page=leads-admin-page')) .'";';
							echo '</script>';
							exit();
                		}
					}
				}
			}
		}

        public static function get_companies(){
            global $wpdb;
            $table_name     =   $wpdb->prefix.'companies_list';
            //$offset         =   ($page_number - 1) * $per_page;
            $sql            =   "SELECT * FROM $table_name ORDER BY create_date DESC";
            $results        =   $wpdb->get_results($sql, 'ARRAY_A');
            return $results;
        }
        
        public static function display_contact_form_submissions_page(){
            global $wpdb;
            $submissions    =   self::get_contact_form_submissions();

            echo '<div class="wrap">';
            echo '<div class="itfirms-contact-list-page">';
            echo '<h1 class="wp-heading-inline">Contact Form Submissions</h1>';
            echo '<hr class="wp-header-end">';
			echo '<form method="POST" id="contact-form-page-form">';
			echo '<div class="bulk-actions" style="margin-bottom: 15px;">';
			echo '<select name="bulk_action" id="bulk_action">
					<option value="">Bulk Actions</option>
					<option value="delete">Delete Selected</option>
				  </select>';
			echo '<button type="submit" class="button action" name="apply_bulk_action">Apply</button>';
			echo '</div>';
			echo '<div class="custom-admin-loader" style="display:none; text-align:center;"><img class="hitech-hub-loader" src="https://hitechhub.co/wp-content/uploads/2024/08/hitechhub-loader-1.gif" height="30" width="30" /></div>';
			
            // Display submissions data
            echo '<table class="widefat" id="contact-list">';
            echo '<thead>
                    <tr>
                        <th><input type="checkbox" id="custom-select-all-companies"></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>IP Address</th>
						<th>IP Location</th>
                        <th>Current Time</th>
                        <th>Client Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>';
            echo '<tbody>';
            $count = 1;
            foreach($submissions as $submission){
                $user_ip_info   =   (!empty($submission['ip_info'])) ? json_decode($submission['ip_info'], true) : [];
				$ipcity	  		= 	(isset($user_ip_info['city']))   ? $user_ip_info['city']   : '';
				$ipregion	    = 	(isset($user_ip_info['region'])) ? $user_ip_info['region'] : '';
				$ipaddress      =	(isset($user_ip_info['ip']))     ? $user_ip_info['ip']     : '';
                echo '<tr>';
                echo '<td><input type="checkbox" class="custom-hth-company-checkbox" name="selected_contacts[]" value="' . esc_attr($submission['id']) . '"></td>';
                echo '<td>' . esc_html($submission['name']) . '</td>';
                echo '<td>' . esc_html($submission['email']) . '</td>';
                echo '<td>' . esc_html($submission['contact_no']) . '</td>';
                echo '<td>' . esc_html($ipaddress) . '</td>';
				echo '<td>' . esc_html($ipcity) . '</td>';
                echo '<td>' . esc_html($submission['create_date']) . '</td>';
                echo '<td>' . esc_html($submission['visiter_time']) . '</td>';
                echo '<td>
					<div class="action_btn">
						<a href="#" id="view-submission" data-tableName="contact_list" data-id="' . $submission['id'] . '" class="dashicons dashicons-visibility custom-view-details"></a>
						<a href="#" id="edit-submission" data-tableName="contact_list" data-id="' . $submission['id'] . '" class="dashicons dashicons-edit edit-details"></a>
						<a href="#" id="delete-submission" data-tableName="contact_list" data-id="' . $submission['id'] . '" class="dashicons dashicons-trash delete-entry"></a>
					</div>
                </td>';
                echo '</tr>';
                $count++;
            }
            echo '</tbody>';
            echo '</table>';

            // Pagination
            /*
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
			*/
            echo '</div>';
			echo '</form>'; 
            echo '</div>';
			self::contact_handle_bulk_delete_action();
        }
		
		//HANDLE CONTACT BULK ACTION
		public static function contact_handle_bulk_delete_action(){
			global $wpdb;
			if (isset($_POST['apply_bulk_action']) && isset($_POST['bulk_action']) && $_POST['bulk_action'] === 'delete') {
				if(isset($_POST['selected_contacts']) && !empty($_POST['selected_contacts'])){
					$contact_ids = array_map('intval', $_POST['selected_contacts']);
					if(!empty($contact_ids)){
						foreach($contact_ids as $id){
							$wpdb->delete($wpdb->prefix . 'contact_list', ['id' => $id], ['%d']);
						}
						// Ensure there is no output before the redirect
                		if (!headers_sent()) {
                    		wp_redirect(add_query_arg('paged', $_GET['paged'], admin_url('admin.php?page=contact-form-submissions')));
                    		exit(); // Make sure to exit after redirecting
                		} else {
							echo '<script type="text/javascript">';
							echo 'window.location.href="'. add_query_arg('paged', $_GET['paged'], admin_url('admin.php?page=contact-form-submissions')) .'";';
							echo '</script>';
							exit();
                		}
					}
				}
			}
		}

        public static function get_contact_form_submissions(){
            global $wpdb;
            $table_name     =   $wpdb->prefix.'contact_list';
            $offset         =   ($page_number - 1) * $per_page;
            $sql            =   "SELECT * FROM $table_name ORDER BY create_date DESC";
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
            
            $submissions    =   self::get_proposals_list_submissions();

            echo '<div class="wrap">';
            echo '<div class="itfirms-proposals-list-page itfirms-contact-list-page">';
            echo '<h1 class="wp-heading-inline">Proposals</h1>';
            echo '<hr class="wp-header-end">';
			echo '<form method="post" id="bulk-delete-form">';
			echo '<div class="bulk-actions" style="margin-bottom: 15px;">';
			echo '<select name="bulk_action" id="bulk_action">
					<option value="">Bulk Actions</option>
					<option value="delete">Delete Selected</option>
				  </select>';
			echo '<button type="submit" class="button action" name="apply_bulk_action">Apply</button>';
			echo '</div>';
			echo '<div class="custom-admin-loader" style="display:none; text-align:center;"><img class="hitech-hub-loader" src="https://hitechhub.co/wp-content/uploads/2024/08/hitechhub-loader-1.gif" height="30" width="30" /></div>';
			
            // Display submissions data
            echo '<table class="widefat" id="proposals-list">';
            echo '<thead>
                    <tr>
                        <th><input type="checkbox" id="custom-select-all-companies"></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Budget</th>
                        <th>IP Address</th>
						<th>IP Location</th>
                        <th>Current Time</th>
                        <th>Client Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>';
            echo '<tbody>';
            $count = 1;
            foreach($submissions as $submission){
                $user_ip_info   =   (!empty($submission['ip_info'])) ? json_decode($submission['ip_info'], true) : [];
				$ipcity	  		= 	(isset($user_ip_info['city']))   ? $user_ip_info['city']   : '';
				$ipregion	    = 	(isset($user_ip_info['region'])) ? $user_ip_info['region'] : '';
				$ipaddress      =	(isset($user_ip_info['ip']))     ? $user_ip_info['ip']     : '';
                echo '<tr>';
                echo '<td><input type="checkbox" class="custom-hth-company-checkbox" name="selected_proposals[]" value="' . esc_attr($submission['id']) . '"></td>';
                echo '<td>' . esc_html($submission['name']) . '</td>';
                echo '<td>' . esc_html($submission['email']) . '</td>';
                echo '<td>' . esc_html($submission['subject']) . '</td>';
                echo '<td>' . esc_html($submission['budget']) . '</td>';
                echo '<td>' . esc_html($ipaddress) . '</td>';
				echo '<td>' . esc_html($ipcity) . '</td>';
                echo '<td>' . esc_html($submission['created']) . '</td>';
                echo '<td>' . esc_html($submission['visiter_time']) . '</td>';
                echo '<td>
					<div class="action_btn">
						<a href="#" id="view-proposals" data-tableName="proposals_list" data-id="' . $submission['id'] . '" class="dashicons dashicons-visibility custom-view-details"></a>
						<a href="#" id="edit-proposals" data-tableName="proposals_list" data-id="' . $submission['id'] . '" class="dashicons dashicons-edit edit-details"></a>
						<a href="#" id="delete-proposals" data-tableName="proposals_list" data-id="' . $submission['id'] . '" class="dashicons dashicons-trash delete-entry"></a>
					</div>
                </td>';
                echo '</tr>';
                $count++;
            }
            echo '</tbody>';
            echo '</table>';

            // Pagination
            /*
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
			*/
            echo '</div>';
			echo '</form>';
            echo '</div>';
			
			// Handle bulk delete action
    		self::proposals_handle_bulk_delete_action();
        }

        public static function get_proposals_list_submissions(){
            global $wpdb;
            $table_name     =   $wpdb->prefix.'proposals_list';
            $offset         =   ($page_number - 1) * $per_page;
            $sql            =   "SELECT * FROM $table_name ORDER BY created DESC";
            $results        =   $wpdb->get_results($sql, 'ARRAY_A');
            return $results;
        }

        public static function get_flag_count( $tableName ){
            global $wpdb;
            $table_name = $wpdb->prefix .''. $tableName;
            $flag_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE wd_status = 1"); 
            return $flag_count;
        }

        public static function reset_flag_count( $tableName ) {
            global $wpdb;
            $table_name = $wpdb->prefix .''. $tableName ;
            $wpdb->update($table_name, array('wd_status' => 0), array('wd_status' => 1));
        }
		
		//Manage menu pages popups
		public static function hth_manage_admin_menu_pages_popups_cb(){
			if(isset($_GET['page']) && ($_GET['page'] === 'leads-admin-page' || $_GET['page'] === 'contact-form-submissions' || $_GET['page'] === 'proposals-form-submissions')){
				?>
                <!-- Entry View Details Model -->
				<div id="custom-view-details-popup" class="view-details-popup" style="display:none;">
					<div class="details-popup-content">
						<span class="close-popup">&times;</span>
						<h2 id="popup-title">Test test 123</h2>
						<div id="popup-content">
							<div class="outer-main">
							  <div class="row-outer">
								<div class="name">Company Title</div>
								<div class="name-detail">Test test 123</div>
							  </div>
							  <div class="row-outer">
								<div class="name">Website URL</div>
								<div class="name-detail">https://web.com</div>
							  </div>
							  <div class="row-outer">
								<div class="name">Company Contact</div>
								<div class="name-detail">123545125422</div>
							  </div>
							  <div class="row-outer">
								<div class="name">Company Email</div>
								<div class="name-detail">vijaykharol.hipl@gmail.com</div>
							  </div>
							  <div class="row-outer">
								<div class="name">Established On</div>
								<div class="name-detail">1980</div>
							  </div>
							  <div class="row-outer">
								<div class="name">Country</div>
								<div class="name-detail">india</div>
							  </div>
							  <div class="row-outer">
								<div class="name">No. of Employees</div>
								<div class="name-detail">0-10</div>
							  </div>
							  <div class="row-outer">
								<div class="name">Hourly Rate</div>
								<div class="name-detail">$25-$49/hr.</div>
							  </div>
							  <div class="row-outer">
								<div class="name">Services Provided</div>
								<div class="name-detail">Web Development</div>
							  </div>
							  <div class="row-outer">
								<div class="name">Client</div>
								<div class="name-detail">test</div>
							  </div>
							  <div class="row-outer dis">
								<div class="name">Description</div>
								<div class="name-detail">https://web.com</div>
							  </div>
							</div>
						</div>
					</div>
				</div>
				<!-- Entry Edit Details Model -->
				<div id="custom-entry-edit-details-popup" class="view-details-popup" style="display:none;">
					<div class="details-popup-content">
						<span class="close-popup">&times;</span>
						<h2 id="popup-title">Test test 123</h2>
						<div id="popup-content">
							<div class="outer-main edit-form">
							  <div class="row-outer">
								<div class="name">Company Title</div>
								<div class="name-detail">
								  <input type="text" name="">
								</div>
							  </div>
							  <div class="row-outer">
								<div class="name">Website URL</div>
								<div class="name-detail">
								  <input type="text" name=""></div>
							  </div>
							  <div class="row-outer">
								<div class="name">Company Contact</div>
								<div class="name-detail">
								  <input type="text" name="">
								</div>
							  </div>
							  <div class="row-outer">
								<div class="name">Company Email</div>
								<div class="name-detail">
								  <input type="text" name=""></div>
							  </div>
							  <div class="row-outer">
								<div class="name">Established On</div>
								<div class="name-detail">
								  <input type="text" name=""></div>
							  </div>
							  <div class="row-outer">
								<div class="name">Country</div>
								<div class="name-detail">
								  <input type="text" name=""></div>
							  </div>
							  <div class="row-outer">
								<div class="name">No. of Employees</div>
								<div class="name-detail">
								  <input type="text" name=""></div>
							  </div>
							  <div class="row-outer">
								<div class="name">Hourly Rate</div>
								<div class="name-detail">
								  <input type="text" name=""></div>
							  </div>
							  <div class="row-outer">
								<div class="name">Services Provided</div>
								<div class="name-detail">
								  <input type="text" name=""></div>
							  </div>
							  <div class="row-outer">
								<div class="name">Client</div>
								<div class="name-detail">
								  <input type="text" name=""></div>
							  </div>
							  <div class="row-outer full">
								<div class="name">Description</div>
								<div class="name-detail">
								  <textarea placeholder="Description"></textarea>
							  </div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
		}
		
		//Entry Details Handler
		public static function hth_get_entry_details_cb(){
			global $wpdb;
			$entry_id  = (isset($_POST['id'])) 			? intval($_POST['id'])  : '';
			$tableName = (isset($_POST['tableName'])) 	? $_POST['tableName'] 	: '';
			$return	   = [];
			$html	   = '';
			if(empty($entry_id)){
				$return['status'] 	= 	false;
				$return['msg'] 		= 	"Oop's something went wrong, please refresh the page and try again. Thanks!";
			}else if(empty($tableName)){
				$return['status'] 	= 	false;
				$return['msg'] 		= 	"Oop's something went wrong, please refresh the page and try again. Thanks!";
			}else if(!current_user_can('edit_posts')){
				$return['status'] 	= 	false;
				$return['msg'] 		= 	"You do not have permission to edit posts.";
			}else{
				$table_name 	= 	$wpdb->prefix.$tableName;
				$entryData 		= 	$wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id='$entry_id' LIMIT 1"));
				if(!empty($entryData)){
					if($tableName == 'companies_list'){
						$ipdata 		= 	(!empty($entryData->ip_info)) ? json_decode($entryData->ip_info, true) : [];
						$ipinfo_string 	= 	implode(', ', $ipdata);
						$html = '
							<div class="details-popup-content">
								<span class="close-popup">&times;</span>
								<h2 id="popup-title">'.$entryData->title.'</h2>
								<div id="popup-content">
									<div class="outer-main">
									  <div class="row-outer">
										<div class="name">Company Name</div>
										<div class="name-detail">'.$entryData->title.'</div>
									  </div>
									  <div class="row-outer">
										<div class="name">Website URL</div>
										<div class="name-detail">'.$entryData->website_url.'</div>
									  </div>
									  <div class="row-outer">
										<div class="name">Company Contact</div>
										<div class="name-detail">'.$entryData->comp_contact.'</div>
									  </div>
									  <div class="row-outer">
										<div class="name">Company Email</div>
										<div class="name-detail">'.$entryData->comp_email.'</div>
									  </div>
									  <div class="row-outer">
										<div class="name">Established On</div>
										<div class="name-detail">'.$entryData->comp_established_on.'</div>
									  </div>
									  <div class="row-outer">
										<div class="name">Country</div>
										<div class="name-detail">'.$entryData->country_name.'</div>
									  </div>
									  <div class="row-outer">
										<div class="name">No. of Employees</div>
										<div class="name-detail">'.$entryData->employees.'</div>
									  </div>
									  <div class="row-outer">
										<div class="name">Hourly Rate</div>
										<div class="name-detail">'.$entryData->hourly_rate.'</div>
									  </div>
									  <div class="row-outer dis">
										<div class="name">Services Provided</div>
										<div class="name-detail">'.$entryData->services_provided.'</div>
									  </div>
									  <div class="row-outer dis">
										<div class="name">Key Client</div>
										<div class="name-detail">'.$entryData->key_client.'</div>
									  </div>
									  <div class="row-outer dis">
										<div class="name">Description</div>
										<div class="name-detail">'.$entryData->description.'</div>
									  </div>
									  <div class="row-outer">
										<div class="name">Submitted On</div>
										<div class="name-detail">'.$entryData->create_date.'</div>
									  </div>
									  <div class="row-outer">
										<div class="name">Client Submitted On</div>
										<div class="name-detail">'.$entryData->client_time.'</div>
									  </div>
									  <div class="row-outer dis">
										<div class="name">IP Infomation</div>
										<div class="name-detail">'.$ipinfo_string.'</div>
									  </div>
									</div>
								</div>
							</div>
						';
					}else if($tableName == 'contact_list'){
						$ipdata 		= 	(!empty($entryData->ip_info)) ? json_decode($entryData->ip_info, true) : [];
						$ipinfo_string 	= 	implode(', ', $ipdata);
						$html = '
							<div class="details-popup-content">
								<span class="close-popup">&times;</span>
								<h2 id="popup-title">'.$entryData->name.'</h2>
								<div id="popup-content">
									<div class="outer-main">
									  <div class="row-outer">
										<div class="name">Name</div>
										<div class="name-detail">'.$entryData->name.'</div>
									  </div>
									  <div class="row-outer">
										<div class="name">Email</div>
										<div class="name-detail">'.$entryData->email.'</div>
									  </div>
									  <div class="row-outer">
										<div class="name">Contact</div>
										<div class="name-detail">'.$entryData->contact_no.'</div>
									  </div>
									  <div class="row-outer">
										<div class="name">Subject</div>
										<div class="name-detail">'.$entryData->subject.'</div>
									  </div>
									  <div class="row-outer dis">
										<div class="name">Description</div>
										<div class="name-detail">'.$entryData->description.'</div>
									  </div>
									  <div class="row-outer">
										<div class="name">Page URL</div>
										<div class="name-detail">'.$entryData->page_url.'</div>
									  </div>
									  <div class="row-outer">
										<div class="name">Submitted On</div>
										<div class="name-detail">'.$entryData->create_date.'</div>
									  </div>
									  <div class="row-outer">
										<div class="name">Visitor Submitted</div>
										<div class="name-detail">'.$entryData->visiter_time.'</div>
									  </div>
									  <div class="row-outer">
										<div class="name">IP Infomation</div>
										<div class="name-detail">'.$ipinfo_string.'</div>
									  </div>
									</div>
								</div>
							</div>
						';
					}else if($tableName == 'proposals_list'){
						$ipdata 		= 	(!empty($entryData->ip_info)) ? json_decode($entryData->ip_info, true) : [];
						$ipinfo_string 	= 	implode(', ', $ipdata);
						$html = '
							<div class="details-popup-content">
								<span class="close-popup">&times;</span>
								<h2 id="popup-title">'.$entryData->name.'</h2>
								<div id="popup-content">
									<div class="outer-main">
									  <div class="row-outer">
										<div class="name">Name</div>
										<div class="name-detail">'.$entryData->name.'</div>
									  </div>
									  <div class="row-outer">
										<div class="name">Email</div>
										<div class="name-detail">'.$entryData->email.'</div>
									  </div>
									  <div class="row-outer">
										<div class="name">Budget</div>
										<div class="name-detail">'.$entryData->budget.'</div>
									  </div>
									  <div class="row-outer">
										<div class="name">Subject</div>
										<div class="name-detail">'.$entryData->subject.'</div>
									  </div>
									  <div class="row-outer dis">
										<div class="name">Description</div>
										<div class="name-detail">'.$entryData->description.'</div>
									  </div>
									  <div class="row-outer">
										<div class="name">Page URL</div>
										<div class="name-detail">'.$entryData->page_url.'</div>
									  </div>
									  <div class="row-outer">
										<div class="name">Submitted On</div>
										<div class="name-detail">'.$entryData->created.'</div>
									  </div>
									  <div class="row-outer">
										<div class="name">Visitor Submitted</div>
										<div class="name-detail">'.$entryData->visiter_time.'</div>
									  </div>
									  <div class="row-outer">
										<div class="name">IP Infomation</div>
										<div class="name-detail">'.$ipinfo_string.'</div>
									  </div>
									</div>
								</div>
							</div>
						';
					}
					$return['status'] 	= 	true;
					$return['msg'] 		= 	"Process Completed Successfully!";
					$return['html']     = 	$html;
				}else{
					$return['status'] 	= 	false;
					$return['msg'] 		= 	"Oop's something went wrong, please refresh the page and try again. Thanks!";
				}
			}
			echo json_encode($return);
			exit();
		}
		
		//HANDLE FETCH ENTRIES EDIT MODEL PROCESS
		public static function hth_get_entry_details_edit_cb(){
			global $wpdb;
			$entry_id  = (isset($_POST['entryid'])) 			? intval($_POST['entryid'])  : '';
			$tableName = (isset($_POST['tableName'])) 	? $_POST['tableName'] 	: '';
			$return	   = [];
			$html	   = '';
			if(empty($entry_id)){
				$return['status'] 	= 	false;
				$return['msg'] 		= 	"Oop's something went wrong, please refresh the page and try again. Thanks!";
			}else if(empty($tableName)){
				$return['status'] 	= 	false;
				$return['msg'] 		= 	"Oop's something went wrong, please refresh the page and try again. Thanks!";
			}else if(!current_user_can('edit_posts')){
				$return['status'] 	= 	false;
				$return['msg'] 		= 	"You do not have permission to edit posts.";
			}else{
				$table_name 	= 	$wpdb->prefix.$tableName;
				$entryData 		= 	$wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id='$entry_id' LIMIT 1"));
				if(!empty($entryData)){
					if($tableName == 'companies_list'){
						$ipdata 		= 	(!empty($entryData->ip_info)) ? json_decode($entryData->ip_info, true) : [];
						$ipinfo_string 	= 	implode(', ', $ipdata);
						$html = '
							<div class="details-popup-content">
								<span class="close-popup">&times;</span>
								<h2 id="popup-title">'.$entryData->title.'</h2>
								<div id="popup-content">
									<form id="popup-companies-list-form" method="POST">
										<input type="hidden" name="entry_id" value="'.$entryData->id.'">
										<div class="outer-main edit-form">
											<div class="row-outer">
												<div class="name">Company Title</div>
												<div class="name-detail">
													<input type="text" name="comp_title" value="'.$entryData->title.'">
												</div>
											</div>
											<div class="row-outer">
												<div class="name">Website Url</div>
												<div class="name-detail">
													<input type="text" name="comp_website" value="'.$entryData->website_url.'">
												</div>
											</div>
											<div class="row-outer">
												<div class="name">Country Name</div>
												<div class="name-detail">
													<input type="text" name="comp_country" value="'.$entryData->country_name.'">
												</div>
											</div>
											<div class="row-outer">
												<div class="name">Company Established On</div>
												<div class="name-detail">
													<input type="text" name="comp_established" value="'.$entryData->comp_established_on.'">
												</div>
											</div>
											<div class="row-outer">
												<div class="name">Employees</div>
												<div class="name-detail">
													<input type="text" name="employees" value="'.$entryData->employees.'">
												</div>
											</div>
											<div class="row-outer">
												<div class="name">Avg. Hourly Rate</div>
												<div class="name-detail">
													<input type="text" name="hourly_rate" value="'.$entryData->hourly_rate.'">
												</div>
											</div>
											<div class="row-outer full">
												<div class="name">Company Email</div>
												<div class="name-detail">
													<input type="text" name="comp_email" value="'.$entryData->comp_email.'">
												</div>
											</div>
											<div class="row-outer full">
												<div class="name">Contact</div>
												<div class="name-detail">
													<input type="text" name="comp_contact" value="'.$entryData->comp_contact.'">
												</div>
											</div>
											<div class="row-outer">
												<div class="name">Services Provided</div>
												<div class="name-detail">
													<textarea placeholder="Services Provided" name="services_provided">'.$entryData->services_provided.'</textarea>
												</div>
											</div>
											<div class="row-outer">
												<div class="name">Key Client</div>
												<div class="name-detail">
													<textarea placeholder="Key Client" name="key_client">'.$entryData->key_client.'</textarea>
												</div>
											</div>
											<div class="row-outer full">
												<div class="name">Description</div>
												<div class="name-detail">
													<textarea placeholder="Description" name="description">'.$entryData->description.'</textarea>
												</div>
											</div>
											<div class="row-outer full btn-submission">
												<div class="name-detail">
													<button class="edit-popup-btn" id="popup-edit-company-list-btn">Save Changes</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						';
					}else if($tableName == 'contact_list'){
						$ipdata 		= 	(!empty($entryData->ip_info)) ? json_decode($entryData->ip_info, true) : [];
						$ipinfo_string 	= 	implode(', ', $ipdata);
						$html = '
							<div class="details-popup-content">
								<span class="close-popup">&times;</span>
								<h2 id="popup-title">'.$entryData->name.'</h2>
								<div id="popup-content">
									<form id="popup-contact-list-form" method="POST">
										<input type="hidden" name="entry_id" value="'.$entryData->id.'">
										<div class="outer-main edit-form">
											<div class="row-outer">
												<div class="name">Name</div>
												<div class="name-detail">
													<input type="text" name="name" value="'.$entryData->name.'">
												</div>
											</div>
											<div class="row-outer">
												<div class="name">Email</div>
												<div class="name-detail">
													<input type="text" name="email" value="'.$entryData->email.'">
												</div>
											</div>
											<div class="row-outer full">
												<div class="name">Phone</div>
												<div class="name-detail">
													<input type="text" name="contact_no" value="'.$entryData->contact_no.'">
												</div>
											</div>
											<div class="row-outer full">
												<div class="name">Description</div>
												<div class="name-detail">
													<textarea placeholder="Description" name="description">'.$entryData->description.'</textarea>
												</div>
											</div>
											<div class="row-outer full btn-submission">
												<div class="name-detail">
												<button class="edit-popup-btn" id="popup-edit-contact-list-btn">Save Changes</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						';
					}else if($tableName == 'proposals_list'){
						$ipdata 		= 	(!empty($entryData->ip_info)) ? json_decode($entryData->ip_info, true) : [];
						$ipinfo_string 	= 	implode(', ', $ipdata);
						$html = '
							<div class="details-popup-content">
								<span class="close-popup">&times;</span>
								<h2 id="popup-title">'.$entryData->name.'</h2>
								<div id="popup-content">
									<form id="popup-proposals-list-form" method="POST">
										<input type="hidden" name="entry_id" value="'.$entryData->id.'">
										<div class="outer-main edit-form">
											<div class="row-outer">
												<div class="name">Name</div>
												<div class="name-detail">
													<input type="text" name="name" value="'.$entryData->name.'">
												</div>
											</div>
											<div class="row-outer">
												<div class="name">Email</div>
												<div class="name-detail">
													<input type="text" name="email" value="'.$entryData->email.'">
												</div>
											</div>
											<div class="row-outer">
												<div class="name">Budget</div>
												<div class="name-detail">
													<input type="text" name="budget" value="'.$entryData->budget.'">
												</div>
											</div>
											<div class="row-outer">
												<div class="name">Phone</div>
												<div class="name-detail">
													<input type="text" name="contact_no" value="'.$entryData->subject.'">
												</div>
											</div>
											<div class="row-outer full">
												<div class="name">Description</div>
												<div class="name-detail">
													<textarea placeholder="Description" name="description">'.$entryData->description.'</textarea>
												</div>
											</div>
											<div class="row-outer full btn-submission">
												<div class="name-detail">
												<button class="edit-popup-btn" id="popup-edit-proposale-list-btn">Save Changes</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						';
					}
					$return['status'] 	= 	true;
					$return['msg'] 		= 	"Process Completed Successfully!";
					$return['html']     = 	$html;
				}else{
					$return['status'] 	= 	false;
					$return['msg'] 		= 	"Oop's something went wrong, please refresh the page and try again. Thanks!";
				}
			}
			echo json_encode($return);
			exit();
		}
		
		//Handle Bulk Delete Action
		public static function proposals_handle_bulk_delete_action() {
			global $wpdb;
			if (isset($_POST['apply_bulk_action']) && isset($_POST['bulk_action']) && $_POST['bulk_action'] === 'delete') {
				if(isset($_POST['selected_proposals']) && !empty($_POST['selected_proposals'])){
					$proposal_ids = array_map('intval', $_POST['selected_proposals']);
					if(!empty($proposal_ids)){
						foreach($proposal_ids as $id){
							$wpdb->delete($wpdb->prefix . 'proposals_list', ['id' => $id], ['%d']);
						}
						// Ensure there is no output before the redirect
                		if (!headers_sent()) {
                    		wp_redirect(add_query_arg('paged', $_GET['paged'], admin_url('admin.php?page=proposals-form-submissions')));
                    		exit();
                		} else {
							echo '<script type="text/javascript">';
							echo 'window.location.href="'. add_query_arg('paged', $_GET['paged'], admin_url('admin.php?page=proposals-form-submissions')) .'";';
							echo '</script>';
							exit();
                		}
					}
				}
			}
		}
		
		//HANDLE ENTRY DELETE PROCESS
		public static function delete_entry_process_cb(){
			global $wpdb;
			$entryid 		= 	(isset($_POST['id']))          ?  intval($_POST['id']) : '';
			$tableName 		= 	(isset($_POST['tableName']))  ?  $_POST['tableName']  : '';
			$return			=	[];
			if(empty($entryid)){
				$return['status'] = false;
				$return['msg'] = "Oops something went wrong, please refresh the page and try again. Thanks!";
			}else if(empty($tableName)){
				$return['status'] = false;
				$return['msg'] = "Oops something went wrong, please refresh the page and try again. Thanks!";
			}else{
				$table_name =  $wpdb->prefix.$tableName;
				$deleted    =  $wpdb->delete($table_name, array('id' => $entryid));
				$return['status'] = true;
				$return['msg'] = "Entry deleted successfully!";
			}
			echo json_encode($return);
			exit();
		}
		
		//HANDLE COMPANY ENTRY PROCESS
		public static function hth_edit_company_entry_process_cb(){
			global $wpdb;
			$entry_id 			= (isset($_POST['entry_id'])) ? $_POST['entry_id'] 			: '';
			$comp_title 		= (isset($_POST['comp_title'])) ? $_POST['comp_title'] 		: '';
			$comp_website 		= (isset($_POST['comp_website'])) ? $_POST['comp_website'] 	: '';
			$comp_country 		= (isset($_POST['comp_country'])) ? $_POST['comp_country'] 	: '';
			$comp_established 	= (isset($_POST['comp_established'])) ? $_POST['comp_established'] : '';
			$employees 			= (isset($_POST['employees'])) ? $_POST['employees'] : '';
			$hourly_rate 		= (isset($_POST['hourly_rate'])) ? $_POST['hourly_rate'] : '';
			$comp_email 		= (isset($_POST['comp_email'])) ? $_POST['comp_email'] : '';
			$comp_contact 		= (isset($_POST['comp_contact'])) ? $_POST['comp_contact'] : '';
			$services_provided 	= (isset($_POST['services_provided'])) ? $_POST['services_provided'] : '';
			$key_client 		= (isset($_POST['key_client'])) ? $_POST['key_client'] : '';
			$description 		= (isset($_POST['description'])) ? $_POST['description'] : '';
			$return				= [];
			if(empty($entry_id)){
				$return['status']   = 	false;
				$return['msg']      = 	'Oops something went wrong, please refresh the page and try again. thanks';
			}else{
				$table_name = $wpdb->prefix.'companies_list';
				$data = [
					'title' 				=> $comp_title,
					'website_url' 			=> $comp_website,
					'country_name' 			=> $comp_country,
					'comp_established_on' 	=> $comp_established,
					'employees' 			=> $employees,
					'hourly_rate' 			=> $hourly_rate,
					'comp_email' 			=> $comp_email,
					'comp_email' 			=> $comp_email,
					'comp_contact' 			=> $comp_contact,
					'services_provided'     => $services_provided,
					'key_client' 			=> $key_client,
					'description' 			=> $description,
				];
				$where = [
					'id' => $entry_id, 
				];
				$updated = $wpdb->update( $table_name, $data, $where );
				if( $updated !== false ){
					$return['status'] 	= 	true;
					$return['msg'] 		= 	'Updated Successfully!';
				}else{
					$return['status'] 	= false;
					$return['msg'] 		= 'Oops something went wrong, please refresh the page and try again. thanks';
				}
			}
			echo json_encode($return);
			exit();
		}
		
		//HANDLE CONTACT US ENTRY EDIT PROCESS
		public static function hth_edit_contactus_entry_process_cb(){
			global $wpdb;
			$entry_id 			= 	(isset($_POST['entry_id'])) ? $_POST['entry_id'] 			: '';
			$name 				= 	(isset($_POST['name'])) ? $_POST['name'] 		: '';
			$email 				= 	(isset($_POST['email'])) ? $_POST['email'] 	: '';
			$contact_no 		= 	(isset($_POST['contact_no'])) ? $_POST['contact_no'] 	: '';
			$description 	    = 	(isset($_POST['description'])) ? $_POST['description'] : '';
			$return				= [];
			if(empty($entry_id)){
				$return['status']   = 	false;
				$return['msg']      = 	'Oops something went wrong, please refresh the page and try again. thanks';
			}else{
				$table_name = $wpdb->prefix.'contact_list';
				$data = [
					'name' 		      => 	$name,
					'email' 	      => 	$email,
					'contact_no'      => 	$contact_no,
					'description' 	  => 	$description,
				];
				$where = [
					'id' => $entry_id, 
				];
				$updated = $wpdb->update( $table_name, $data, $where );
				if( $updated !== false ){
					$return['status'] 	= 	true;
					$return['msg'] 		= 	'Updated Successfully!';
				}else{
					$return['status'] 	= false;
					$return['msg'] 		= 'Oops something went wrong, please refresh the page and try again. thanks';
				}
			}
			echo json_encode($return);
			exit();
		}
		
		//HANDLE PROPOSAL ENTRY EDIT PROCESS
		public static function hth_edit_proposal_entry_process_cb(){
			global $wpdb;
			$entry_id 			= 	(isset($_POST['entry_id'])) 	? $_POST['entry_id'] 	: '';
			$name 				= 	(isset($_POST['name'])) 		? $_POST['name'] 		: '';
			$email 				= 	(isset($_POST['email'])) 		? $_POST['email'] 		: '';
			$budget 			= 	(isset($_POST['budget'])) 		? $_POST['budget'] 		: '';
			$contact_no 	    = 	(isset($_POST['contact_no'])) 	? $_POST['contact_no'] 	: '';
			$description 	    = 	(isset($_POST['description'])) 	? $_POST['description'] : '';
			$return				= [];
			if(empty($entry_id)){
				$return['status']   = 	false;
				$return['msg']      = 	'Oops something went wrong, please refresh the page and try again. thanks';
			}else{
				$table_name = $wpdb->prefix.'proposals_list';
				$data = [
					'name' 		      => 	$name,
					'email' 	      => 	$email,
					'budget'      	  => 	$budget,
					'subject' 	      => 	$contact_no,
					'description' 	  => 	$description,
				];
				$where = [
					'id' => $entry_id, 
				];
				$updated = $wpdb->update( $table_name, $data, $where );
				if( $updated !== false ){
					$return['status'] 	= 	true;
					$return['msg'] 		= 	'Updated Successfully!';
				}else{
					$return['status'] 	= false;
					$return['msg'] 		= 'Oops something went wrong, please refresh the page and try again. thanks';
				}
			}
			echo json_encode($return);
			exit();
		}
    }

    ITFirmsBackend::init();
}