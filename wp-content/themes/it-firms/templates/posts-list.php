<?php 
/*
* Template Name: Posts List Page
*/
if(!defined('ABSPATH')){
    exit();
}
get_header();

$comp_args = [
    'post_type' 		=> 	'add-company',
    'post_status' 		=> 	'publish',
    'posts_per_page'	=>	-1,
    'fields'            => 'ids',
];
$comapnies          =   get_posts($comp_args);
$countCompanies     =   (is_array($comapnies) && !empty($comapnies)) ? count($comapnies) : '0';
?>
<!-- Banner Section Start -->
<section class="banner-section">
    <div class="inner-top-banner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-8 col-lg-8 col-12">
                <div class="banner-content">
                    <h1 class="banner-title">Top Mobile App Development Companies & Best Mobile Application Developers in India 2024</h1>
                    <div class="sub-title d-inline-block text-theme1">THE BEST OF <?php echo date('M Y'); ?></div>
                </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-12 text-lg-start text-center">
                    <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/banner-img/banner-form.png" alt="form">
                </div>
            </div>
        </div>
    </div>
    <div class="content-banner">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p class="add-read-more show-less-content">Creating a mobile app can be confusing, with many challenges. You may feel lost and unsure where to go next to achieve your dream app. We've been your guide on this journey, mapping out the best paths and uncovering the most skilled developers for both iOS and Android spaces. So, hop on board with us and discover the development team to help you chart your app's journey to success</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Section End -->

<!-- Blog Section Start -->
<section class="blog-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="blog-section-title d-flex align-items-center justify-content-between flex-wrap">
                    <div class="heading-title"><h2>list of the best mobile app developers</h2></div>
                    <div class="blogs-date text-theme1 fw-semibold"><?= number_format($countCompanies) ?> Companies | Last updated: <?php echo date('M d, Y'); ?></div>
                </div>
            </div>
            <div class="col-12">
                <div class="blogs">
                    <?php
                    $paged  = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $args   = [
                        'post_type'         =>  'post', 
                        'post_status'       =>  'publish', 
                        'posts_per_page'    =>  10,
                        'paged'             =>  $paged,
                        'orderby'           =>  'date',
                        'order'             =>  'DESC',
                    ];
                    $query = new WP_Query( $args );
                    if($query->have_posts()) :
                        while($query->have_posts()) : 
                            $query->the_post();
                            $postID         =   get_the_ID();
                            $post_thumb_id  =   get_post_thumbnail_id($post_id);
                            $attachment_url =   wp_get_attachment_image_url($post_thumb_id);
                            $author_id      =   get_post_field( 'post_author', $post_id );
                            $author_info    =   get_userdata( $author_id );
                            $post_date      =   get_the_date( 'F j, Y', $post_id );
                            ?>
                            <div class="blog-item">
                                <div class="blog-body">
                                    <div class="blog-img">
                                        <img src="<?= $attachment_url ?>" alt="blog">
                                    </div>
                                    <div class="blog-description">
                                        <a href="javascript:;"><h3 class="blog-title"><?= ucfirst(get_the_title()) ?></h3></a>
                                        <p><?= substr(strip_tags(get_the_content()), 0, 200).'...' ?></p>
                                    </div>
                                </div>
                                <div class="blog-about-details">
                                    <div class="blog-details">
                                        <div class="blog-details-item">
                                            <div class="icon-img"><img src="<?= get_stylesheet_directory_uri() ?>/assets/images/icon/user.svg" alt="admin"></div>
                                            <div class="icon-title">Published By : <?= ucfirst($author_info->display_name) ?></div>
                                        </div>
                                        <div class="blog-details-item">
                                            <div class="icon-img"><img src="<?= get_stylesheet_directory_uri() ?>/assets/images/icon/calendra.svg" alt="calendra"></div>
                                            <div class="icon-title"><?= $post_date ?></div>
                                        </div>
                                        <div class="blog-details-item">
                                            <div class="icon-img"><img src="<?= get_stylesheet_directory_uri() ?>/assets/images/icon/tag.svg" alt="tag"></div>
                                            <div class="icon-title text-theme2">Top App Development Firms</div>
                                        </div>
                                    </div>
                                    <a href="<?= the_permalink() ?>" class="themebtn btn btn-theme1">Read More</a>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        ?>
                        <div class="col-12 paginationbar m-0">
                            <?php 
                            $big        = 999999999;
                            $pagination = paginate_links(array(
                                'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                                'format'    => '?paged=%#%',
                                'current'   => max(1, get_query_var('paged')),
                                'total'     => $query->max_num_pages,
                                'prev_next' => true,
                                'prev_text' => __('<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 18L9 12L15 6" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'),
                                'next_text' => __('<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 18L15 12L9 6" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'),
                                'type'      => 'array',
                            ));
                            if($pagination){
                                echo '<ul class="pagination justify-content-center">';
                                foreach($pagination as $page_link){
                                    echo '<li class="page-item">' . $page_link . '</li>';
                                }
                                echo '</ul>';
                            }
                            ?>
                        </div>
                        <?php
                        wp_reset_postdata();
                        else :
                            echo '<p>' . __( 'No posts found.', 'text-domain' ) . '</p>';
                
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Section End -->
<?php
get_footer();