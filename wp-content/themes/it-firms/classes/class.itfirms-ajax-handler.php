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
    }

    ITFirmsAjaxHandler::init();
}