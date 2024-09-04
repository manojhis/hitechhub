<?php
/**
 * HiTech Hub functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package IT_Firms
 */

define( 'IT_HIPL_THEME_DIR', get_stylesheet_directory_uri()); 

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function it_firms_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on HiTech Hub, use a find and replace
		* to change 'it-firms' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'it-firms', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-thumbnails',array('agency')); 

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'it-firms' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'it_firms_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'it_firms_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function it_firms_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'it_firms_content_width', 640 );
}
add_action( 'after_setup_theme', 'it_firms_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function it_firms_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'it-firms' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'it-firms' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'it_firms_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function it_firms_scripts() {
	wp_enqueue_style( 'hitech-hub-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'hitech-hub-style', 'rtl', 'replace' );

	wp_enqueue_script( 'hitech-hub-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'it_firms_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Functions for shortcodes.
 */
require get_template_directory() . '/inc/shortcode-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * include theme Classes
 */
require get_template_directory() . '/classes/class.it-firms.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * include remove functions file
 */
require get_template_directory() . '/inc/remove_functions.php';


add_action('wp_ajax_Insert_Company_Records' ,'Insert_Company_Records');
add_action('wp_ajax_nopriv_Insert_Company_Records','Insert_Company_Records');

function Insert_Company_Records(){
	global $wpdb;
	$return 					=	[];
    $company_title 				= 	(isset($_POST['company_title'])) ? $_POST['company_title'] : '';
    $company_website 			= 	(isset($_POST['company_website'])) ? $_POST['company_website'] : '';
    $company_location 			= 	(isset($_POST['company_location'])) ? $_POST['company_location'] : '';
    $company_established_date 	= 	(isset($_POST['company_established_date'])) ? $_POST['company_established_date'] : '';
    $company_employees 			= 	(isset($_POST['company_employees'])) ? $_POST['company_employees'] : '';
    $email 						= 	(isset($_POST['email'])) ? $_POST['email'] : '';
    $company_contact 			= 	(isset($_POST['company_contact'])) 		? $_POST['company_contact'] : '';
    $company_services 			= 	(isset($_POST['company_services'])) 	? $_POST['company_services'] : '';
    $company_key_client 		= 	(isset($_POST['company_key_client'])) 	? $_POST['company_key_client'] : '';
    $company_description 		= 	(isset($_POST['company_description'])) 	? $_POST['company_description'] : '';
    $company_price 				= 	(isset($_POST['company_price'])) 		? $_POST['company_price'] : '';

    $current_url            	=   (isset($_POST['contact_current_page'])) ? $_POST['contact_current_page'] : '';
    $ip_address             	=   get_ipinfo(); 
    $datetimenow            	=   current_time('Y-m-d H:i:s');
    $data                   	=   json_decode($ip_address, true);
    $visitorTimezone        	=   (!empty($data['timezone'])) ? $data['timezone'] : 'UTC';
    $dateTime               	=   new DateTime('now', new DateTimeZone($visitorTimezone));
    $visiter_time           	=   $dateTime->format('Y-m-d H:i:s');

    $wd_status 					= 	(isset($_POST['wd_status'])) ? $_POST['wd_status'] : '1';
 

    $career_upload_name 		= 	(isset($_FILES['img_logo']['name'])) ? $_FILES['img_logo']['name'] : '';

    if($career_upload_name){
		$contactfilestring 			= 	str_replace(' ', '', $career_upload_name);
		$uploaded_file 				= 	preg_replace("/\([^)]+\)/","",$contactfilestring);
		$uploaded_file_dir 			= 	time().'_'.$uploaded_file;
		$tmp_file_name 				= 	$_FILES['img_logo']['tmp_name'];
        $dbuploadfile = $uploaded_file_dir;
		$upload_dir = wp_upload_dir();
        if($uploaded_file_dir){
            move_uploaded_file($tmp_file_name,$upload_dir['basedir'].'/upload-company-images/'.$uploaded_file_dir);
        }
        $file_url = $upload_dir['baseurl'].'/upload-company-images/'.$uploaded_file_dir;
    }else{
        $file_url = '';
    }
	
	$insertData = [
		'title' 				=> 	$company_title,
		'website_url' 			=> 	$company_website,
		'country_name' 			=> 	$company_location,
		'comp_established_on' 	=> 	$company_established_date,
		'employees' 			=> 	$company_employees,
		'hourly_rate' 			=> 	$company_price,
		'comp_email' 			=> 	$email,
		'comp_contact' 			=> 	$company_contact,
		'comp_logo' 			=> 	$file_url,
		'services_provided' 	=> 	$company_services,
		'key_client' 			=> 	$company_key_client,
		'description' 			=> 	$company_description,
		'ip_info'       		=>  $ip_address,
        'page_url'      		=>  $current_url,
		'wd_status'             =>  $wd_status,
        'create_date'   		=>  $datetimenow,
        'client_time'          	=>  $visiter_time,
	];
	$table_name 	= 	$wpdb->prefix.'companies_list';
	$result 		= 	$wpdb->insert($table_name, $insertData);
	if($result){
		$email_address  =  get_field('email_address_for_frontend_forms', 'option');
        $subject        =  'New Company Record Submitted';
        $message        =  "
            <h3>New Company Information Submitted</h3>
            <p><strong>Company Title:</strong> {$company_title}</p>
            <p><strong>Website Url:</strong> {$company_website}</p>
            <p><strong>Location:</strong> {$company_location}</p>
            <p><strong>Established Date:</strong> {$company_established_date}</p>
            <p><strong>Employees:</strong> {$company_employees}</p>
            <p><strong>Company Email:</strong> {$email}</p>
            <p><strong>Company Contact:</strong> {$company_contact}</p>
            <p><strong>Services Provided:</strong> {$company_services}</p>
            <p><strong>Key Clients:</strong> {$company_key_client}</p>
            <p><strong>Description:</strong> {$company_description}</p>
            <p><strong>Avg. Hourly Rate:</strong> {$company_price}</p>
            <p><strong>Current Page:</strong> {$current_url}</p>
            <p><strong>Submitted On:</strong> {$datetimenow}</p>
            <p><strong>Client Time:</strong> {$visiter_time}</p>
            <p><strong>Logo URL:</strong> <a href='{$file_url}'>{$file_url}</a></p>
        ";

        // Email headers
        $headers = array('Content-Type: text/html; charset=UTF-8');

        // Send the email
        wp_mail($email_address, $subject, $message, $headers);
		
		$return['status'] = 'success';
		$return['message'] = 'Company record submitted successfully!';
	}else{
		$return['status'] = 'failed';
		$return['message'] = 'Error!';
	}
	echo json_encode($return);
    exit();
}

function register_my_menu() {
	register_nav_menu('header-find-services', __('Header Find Services'));
    register_nav_menu('footer-find-services', __('Footer Find Services'));
	register_nav_menu('footer-resources', __('Footer Resources'));
}
add_action('init', 'register_my_menu');


function register_new_menu() {
	register_nav_menu('header-app-development', __('Header Mobile App Development'));
	register_nav_menu('header-web-development', __('Header Web Development'));
}
add_action('after_setup_theme', 'register_new_menu');
// after_setup_theme

class Footer_Walker_Nav_Menu extends Walker_Nav_Menu {
	function start_lvl( &$output, $depth = 0, $args = array() ) {
	  $indent = str_repeat("\t", $depth);
	  $output .= "\n$indent<ul class=\"footer-nav d-flex flex-column\">\n";
	}
  
	function end_lvl( &$output, $depth = 0, $args = array() ) {
	  $indent = str_repeat("\t", $depth);
	  $output .= "$indent</ul>\n";
	}
  
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
	  $indent = ($depth) ? str_repeat("\t", $depth) : '';
	  $output .= $indent . '<li><a class="footer-nav-link" href="' . esc_attr( $item->url ) . '">' . esc_html( $item->title ) . '</a></li>';
	}
  
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
	  $output .= "\n";
	}
}

class Header_Walker_Nav_Menu extends Walker_Nav_Menu {
	function start_lvl( &$output, $depth = 0, $args = array() ) {
	  $indent = str_repeat("\t", $depth);
	  $output .= "\n$indent<ul class=\"nav-list\">\n";
	}
  
	function end_lvl( &$output, $depth = 0, $args = array() ) {
	  $indent = str_repeat("\t", $depth);
	  $output .= "$indent</ul>\n";
	}
  
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
	  $indent = ($depth) ? str_repeat("\t", $depth) : '';
	  $output .= $indent . '<li><a class="menu-item" href="' . esc_attr( $item->url ) . '">' . esc_html( $item->title ) . '</a></li>';
	}
  
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
	  $output .= "\n";
	}
}

function display_read_time($post_id) {
            $content = get_post_field( 'post_content', $post_id );
            $count_words = str_word_count( strip_tags( $content ) );        
            return '<span class="rt-suffix">' . ceil( $count_words / 250 ) . ' min</span>';
}

function get_ipinfo(){
	$IP_address = $_SERVER['REMOTE_ADDR'];
    $url = "http://ipinfo.io/".$IP_address."/json";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $user_ip_info = json_decode($response, true);
    unset($user_ip_info['readme']);
    return $response;
}

function add_file_types_to_uploads($file_types){
$new_filetypes = array();
$new_filetypes['svg'] = 'image/svg+xml';
$file_types = array_merge($file_types, $new_filetypes );
return $file_types;
}
add_filter('upload_mimes', 'add_file_types_to_uploads');

remove_action('wp_head', 'print_emoji_detection_script', 7); 
remove_action('wp_print_styles', 'print_emoji_styles');
function remove_rank_math_toc_block_style() {
    wp_dequeue_style( 'rank-math-toc-block-style' );
}
add_action( 'wp_enqueue_scripts', 'remove_rank_math_toc_block_style', 100 );
add_action( 'wp_enqueue_scripts', function() {
    wp_dequeue_style( 'classic-theme-styles' );
}, 20 );
function wps_deregister_styles() {
    wp_dequeue_style( 'global-styles' );
}
add_action( 'wp_enqueue_scripts', 'wps_deregister_styles', 100 );

function mg_news_pagination_rewrite() {
	add_rewrite_rule(get_option('category_base').'/page/?([0-9]{1,})/?$', 'index.php?pagename='.get_option('category_base').'&paged=$matches[1]', 'top');
}
add_action('init', 'mg_news_pagination_rewrite');


add_action( 'acf/save_post', 'set_post_default_category', 100 );

function set_post_default_category( $post_id ) {
	$service_ids = $_POST['acf']['field_667c04ea34330'];
	$location_ids = $_POST['acf']['field_667c04fd34331'];
	$industries_ids = $_POST['acf']['field_667bf4863d122'];

	wp_set_post_terms( $post_id, $service_ids, 'services', false );
	wp_set_post_terms( $post_id, $location_ids, 'location', false );
	wp_set_post_terms( $post_id, $industries_ids, 'industries', false );
}


function enqueue_datatables_admin_assets($hook) {
    // Ensure this is only for your custom admin page
    if ($hook != 'toplevel_page_leads-admin-page' && $hook != 'leads_page_contact-form-submissions' && $hook != 'leads_page_proposals-form-submissions' ) {
        return;
    }

    // Enqueue DataTables CSS
    wp_enqueue_style('datatables-css', 'https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css');

	wp_enqueue_style('custom-admin', get_template_directory_uri() . '/assets/css/custom-admin.css');

    // Enqueue DataTables JS (No jQuery required)
    wp_enqueue_script('datatables-js', 'https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js', array(), null, true);

    // Enqueue a custom script to initialize DataTables
    wp_enqueue_script('custom-datatables-init', get_template_directory_uri() . '/js/custom-datatables-init.js', array('datatables-js'), null, true);
}
add_action('admin_enqueue_scripts', 'enqueue_datatables_admin_assets');

function admincustom_css() {
	?>
	<style type='text/css'>
	@import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Oswald:wght@200..700&display=swap');
.itfirms-contact-list-page .dataTables_length select{
    width: 60px;
    height: 30px;
    line-height: 20px;
}
.itfirms-contact-list-page table th{
    background: #930043;
    color: #fff !important;
    /* text-transform: uppercase; */
    font-family: "Montserrat", sans-serif;
    font-size: 14px !important;
    padding: 10px 15px !important;
    border-bottom: none !important;
    border-right: solid 1px hsl(0deg 0% 89.02% / 31%);
    font-weight: 500 !important;
    background-repeat: no-repeat;
	white-space:nowrap;
    background-position: center right;
}
.itfirms-contact-list-page table td{
   padding: 5px 10px !important;
    border-right: solid 1px #E3E3E3;
    font-family: "Montserrat", sans-serif;
    font-size: 14px !important;
    vertical-align: middle;
    color: #000;
    text-align: center;
    font-weight: 500;
}
.itfirms-contact-list-page table tbody tr.even{
    background-color: #F5F5F5;
}

.itfirms-contact-list-page table{
    border: none !important;
}

.itfirms-contact-list-page  div#contact-list_filter ,
.itfirms-contact-list-page  .dataTables_wrapper .dataTables_filter{
    margin: 0 0 13px;
}
.itfirms-contact-list-page h1.wp-heading-inline {
    font-size: 25px;
    line-height: 35px;
    font-family: "Montserrat", sans-serif;
    font-weight: 600;
}
#wpbody-content .wrap .dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #930043 !important;
    color: #fff !important;
    border: none !important;
    border-radius: 5px !important;
    font-weight: 500;
}
.action_btn .dashicons {
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 100%;
    padding: 5px;
    color: #fff;
    background: #930043 !important;
}

.action_btn {
    display: flex;
    gap: 5px;
}

.action_btn .dashicons-visibility {
    background: #1b87fe;
    border-color: #1b87fe;}
.action_btn .dashicons-edit {
    background: #2acd46;
    border-color: #2acd46;
}
.action_btn .dashicons-trash {
    background: #ff4655;
    border-color: #ff4655;
}
.contact-popup .contact-popup-content,
.proposal-popup .proposal-popup-content,
.details-popup .details-popup-content{
    padding: 0;
    overflow: hidden;
}
.view-details-popup {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
	padding:15px;
    overflow: auto;
    background: #0000008c;
    z-index: 9999;
}
.view-details-popup .details-popup-content{
	padding:0;
}
.view-details-popup .details-popup-content h2#popup-title{
    color: #fff;
    background: #930043;
    margin: 0;
    padding: 20px;
    font-size: 20px;
    line-height: 21px;
    font-family: "Montserrat", sans-serif;
}
.responsive_table {
    width: 100%;
    overflow: hidden;
    overflow-x: auto;
}
.view-details-popup .details-popup-content span.close-popup{
    color: #fff;
    font-size: 27px;
    top: 18px;
    right: 20px;
}
.view-details-popup .details-popup-content div#popup-content {
    padding: 20px 20px 30px;
    max-height: 70vh;
    overflow: hidden;
    overflow-y: auto;
}
.view-details-popup .details-popup-content div#popup-content::-webkit-scrollbar {
  width: 4px;
}
		.companies-admin-page {
    position: relative;
}
.custom-admin-loader {
    position: absolute;
    width: 100%;
    left: 0;
    height: 100%;
    background: #00000063;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}
		.custom-admin-loader img {
    width: 100px;
    height: auto;
}
/* Track */
.view-details-popup .details-popup-content div#popup-content::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
/* Handle */
.view-details-popup .details-popup-content div#popup-content::-webkit-scrollbar-thumb {
  background: #ddd; 
}
.contact-popup .contact-popup-content div#popup-content input:not([type="submit"]),
.proposal-popup .proposal-popup-content div#popup-content input:not([type="submit"]),
.details-popup .details-popup-content div#popup-content input:not([type="submit"]),
.proposal-popup .proposal-popup-content div#popup-content select{
    border-radius: 0px;
    border: none;
    box-shadow: none !important;
    padding: 13px 50px 13px 15px;
    background-color: rgb(0 0 0 / 6%) !important;
    font-size: 14px;
    font-weight: 400;
    line-height: 17px;
    width: 100%;
}
.contact-popup .contact-popup-content div#popup-content input[type="submit"],
.details-popup .details-popup-content div#popup-content input[type="submit"],
.proposal-popup .proposal-popup-content div#popup-content input[type="submit"] {
    border-radius: 0px;
    border-width: 1px;
    padding: 9px 30px;
    font-size: 14px;
    font-weight: 500;
    white-space: nowrap;
    line-height: 18px;
    text-align: center;
    box-shadow: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    text-transform: uppercase;
    background: #930043;
    color: #fff;
    border: none;
    cursor: pointer;
}

.itfirms-contact-list-page table td img {
    width: 42px;
    height: auto;
}
.row-outer {
    display: flex;
    gap: 10px;
    font-size: 14px;
}
.row-outer .name {
    width: 22%;
    position: relative;
    font-weight: 600;
}

.row-outer * {
    padding: 10px 5px;
}

.row-outer .name:after {
    content: ":";
    position: absolute;
    right:-5px;
    top: 8px;
}
.row-outer .name-detail {
    width: 78%;
    border-bottom: solid 1px #ddd;
}
.outer-main.edit-form {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    row-gap: 15px;
}
.outer-main.edit-form  .name {
    margin: 0 0 3px;
}
.outer-main.edit-form .name-detail {
    border: none;
}
.outer-main.edit-form .row-outer {
    flex-wrap: wrap;
    display: block;
    width: 100%;
    gap: 0;
}
.outer-main.edit-form .name-detail input, .outer-main.edit-form .name-detail select, .outer-main.edit-form .name-detail textarea {
    font-size: 14px;
    line-height: 16px;
    padding: 12px 15px;
    border: 1px solid rgb(209 209 209) !important;
    resize: none;
    border-radius: 0px;
    color: #444;
    box-shadow: none !important;
    max-width: 100% !important;
    outline: none !important;
}
.outer-main.edit-form .name-detail input:focus,
.outer-main.edit-form .name-detail select:focus,
.outer-main.edit-form .name-detail textarea:focus{
    border-color: #930043 !important;
}
.outer-main.edit-form .name-detail textarea{   
	height:80px;
	resize:none;
}
.outer-main.edit-form .row-outer > * {
    width: 100%;
    padding: 0;
}

.outer-main.edit-form .row-outer .name::after {
    display: none;
}

.outer-main.edit-form .row-outer .name-detail input,.outer-main.edit-form .row-outer .name-detail select,.outer-main.edit-form .row-outer .name-detail textarea {
    width: 100%;
}
.row-outer.full {
    grid-column: 1 / -1;
}
.btn-submission .name-detail {
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
}
.btn-submission .name-detail button.edit-popup-btn {
    border-width: 1px;
    padding: 13px 30px;
    font-size: 14px;
    font-weight: 500;
    line-height: 18px;
    text-align: center;
    box-shadow: none;
    text-transform: uppercase;
    background: #930043;
    color: #fff;
    border: none;
    cursor: pointer;
    border-radius: 30px;
}
	</style>
	<?php
}
add_action( 'admin_head', 'admincustom_css' );