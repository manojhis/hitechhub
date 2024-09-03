<?php
/**
 * IT Firms functions and definitions
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
		* If you're building a theme based on IT Firms, use a find and replace
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
	wp_enqueue_style( 'it-firms-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'it-firms-style', 'rtl', 'replace' );

	wp_enqueue_script( 'it-firms-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

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
    $company_description 		= 	(isset($_POST['contact_message'])) 	? $_POST['contact_message'] : '';
    $company_price 				= 	(isset($_POST['company_price'])) 		? $_POST['company_price'] : '';

    $current_url            	=   (isset($_POST['contact_current_page'])) ? $_POST['contact_current_page'] : '';
    $ip_address             	=   get_ipinfo(); 
    $datetimenow            	=   current_time('Y-m-d H:i:s');
    $data                   	=   json_decode($ip_address, true);
    $visitorTimezone        	=   $data['timezone'];
    $dateTime               	=   new DateTime('now', new DateTimeZone($visitorTimezone));
    $visiter_time           	=   $dateTime->format('Y-m-d H:i:s');
 

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
        'create_date'   		=>  $datetimenow,
        'client_time'          	=>  $visiter_time,
	];
	$table_name 	= 	$wpdb->prefix.'companies_list';
	$result 		= 	$wpdb->insert($table_name, $insertData);
	if($result){
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