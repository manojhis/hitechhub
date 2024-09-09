<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package IT_Firms
 */

get_header();
?>
<link rel="stylesheet" href="<?php echo IT_HIPL_THEME_DIR;?>/assets/css/list-page.min.css">
<?php
// Get the current term
$term       =   get_queried_object();
$taxonomy   =   $term->taxonomy;
$term_id    =   $term->term_id;

$term_children = get_terms(
    array(
        'taxonomy'   => 'services',
        'parent' => $term->term_id,
        'depth'      => 1,
        'hide_empty'  => false
    )
);

$term_ids = [];
foreach( $term_children as $term_child ):
    array_push($term_ids, $term_child->term_id);
endforeach ;


if($taxonomy == 'industries'){
    $comp_args = [
        'post_type' 		=> 	'agency',
        'post_status' 		=> 	'publish',
        'posts_per_page'	=>	-1,
        'fields'            => 'ids',
        'meta_query'        =>  [
            'relation' => 'AND',
            [
                'key' 		=> 'industry',
                'value' 	=> $term->term_id,
                'compare' 	=> 'LIKE'
            ],
            
        ],
    ];

    $comapnies      = get_posts($comp_args);
    $countCompanies = (is_array($comapnies) && !empty($comapnies)) ? count($comapnies) : '0';

    $post_args = [
        'post_type' 		=> 	'post',
        'post_status' 		=> 	'publish',
        'posts_per_page'	=>	5,
        'orderby'           =>  'date',
        'order'             =>  'DESC',
        'meta_query'        =>  [
            'relation' => 'AND',
            [
                'key' 		=> 'industry',
                'value' 	=> $term->term_id,
                'compare' 	=> 'LIKE'
            ],
            
        ],
    ];

}else if($taxonomy == 'location'){
    $comp_args = [
        'post_type' 		=> 	'agency',
        'post_status' 		=> 	'publish',
        'posts_per_page'	=>	-1,
        'fields'            => 'ids',
        'meta_query'        =>  [
            'relation' => 'AND',
            [
                'key' 		=> 'location',
                'value' 	=> $term->term_id,
                'compare' 	=> 'LIKE'
            ],
            
        ],
    ];
    $comapnies      = get_posts($comp_args);
    $countCompanies = (is_array($comapnies) && !empty($comapnies)) ? count($comapnies) : '0';

    $post_args = [
        'post_type' 		=> 	'post',
        'post_status' 		=> 	'publish',
        'posts_per_page'	=>	5,
        'orderby'           =>  'date',
        'order'             =>  'DESC',
        'meta_query'        =>  [
            'relation' => 'AND',
            [
                'key' 		=> 'location',
                'value' 	=> $term->term_id,
                'compare' 	=> 'LIKE'
            ],
            
        ],
    ];

}else if($taxonomy == 'services'){
    $comp_args = [
        'post_type' 		=> 	'agency',
        'post_status' 		=> 	'publish',
        'posts_per_page'	=>	-1,
        'fields'            => 'ids',
        'meta_query'        =>  [
            'relation' => 'AND',
            [
                'key' 		=> 'services',
                'value' 	=> $term->term_id,
                'compare' 	=> 'LIKE'
            ],
            
        ],
    ];
    $comapnies      = get_posts($comp_args);
    $countCompanies = (is_array($comapnies) && !empty($comapnies)) ? count($comapnies) : '0';

    $meta_query = [
        'relation' => 'OR',
        [
            'key' 		=> 'services',
            'value' 	=> $term->term_id,
            'compare' 	=> 'LIKE',
        ]
    ];
    foreach($term_ids as $term_id){
        array_push(
            $meta_query, 
            [
                'key'         =>'services',
                'value'     => $term_id,
                'compare'     => 'LIKE'
            ]
        );
    }

    $post_args = [
        'post_type' 		=> 	'post',
        'post_status' 		=> 	'publish',
        'posts_per_page'	=>	10,
        'orderby'           =>  'date',
        'order'             =>  'DESC',
        'meta_query'        =>  $meta_query

    ];

}else{
    $countCompanies     =   '0';
    $post_args          =   [];
}
$paged                  =   (isset($_GET['page']) && !empty($_GET['page'])) ? (int) $_GET['page'] : 1;
if(!empty($post_args)){
    $post_args['paged']     =   $paged;
}
$postsQuery             =   new WP_Query($post_args);
?>  
<style>
    .term-top-big-commerce-development-firms .blog-section section.no-results.not-found form.search-form {
        display: none;
    }
</style>

    <!-- ---------- Banner Section Start --------- -->
    <section class="banner-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 col-sm-12 col-12">
                    <div class="banner-content">
                        <h1 class="banner-title">
                            <?php
                                $heading = get_term_meta($term->term_id, 'main_heading', true);
                                if(!empty($heading)){
                                    echo esc_html($heading);
                                }else{
                                    echo esc_html($term->name);
                                }
                            ?>
                        </h1>
                        <div class="sub-title">THE BEST OF <?php echo date('M Y'); ?></div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 col-12 text-lg-start text-center">
                <img src="<?php echo IT_HIPL_THEME_DIR; ?>/assets/images/banner-img/banner-form.svg" alt="banner-form">
                </div>
            </div>
        </div>
    </section>
    <!-- ---------- Banner Section End --------- -->

    <!-- Contant Section Start -->
    <section class="content-banner">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <p class="add-read-more show-less-content">
                        <?= get_term_meta($term->term_id, 'description', true) ?>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- Contant Section End -->

    <!-- Blog Section Start -->
    <section class="blog-section">
        <div class="container">
            <div class="row">
				<?php if(get_term_meta($term->term_id, 'sub_heading', true))
				{ ?> 
                <div class="col-sm-12 col-12">
                    <div class="blog-title-container">
                        <div class="blog-section-title">
                            <div class="heading-title"><h2><?= get_term_meta($term->term_id, 'sub_heading', true) ?></h2></div>
                            <div class="blogs-date">Last updated: <?php echo date('M d, Y'); ?></div>
                        </div>
                    </div>
                </div>
				<?php } ?>
                <?php 
                if($postsQuery->have_posts()) : 
                    ?>
					<div class="col-sm-12 col-12">
                        <div class="blogs">
                            <?php
                            /* Start the Loop */
                            while($postsQuery->have_posts()) :
                                $postsQuery->the_post();
                                $post_id        =   get_the_ID(); 
                                $author_id      =   get_post_field( 'post_author', $post_id );
                                $author_info    =   get_userdata( $author_id );
                                $post_date      =   get_the_date( 'F j, Y', $post_id );
                                $post_thumb_id  =   get_post_thumbnail_id($post_id);
                                $attachment_url =   wp_get_attachment_image_url($post_thumb_id, 'full');
                                ?>
                                <div class="blog-item">
                                    <div class="blog-body">
                                        <div class="blog-img">
                                            <?php 
                                            if(!empty($attachment_url)){
                                                ?>
                                                <img src="<?= $attachment_url ?>" alt="blog">
                                                <?php
                                            }else{
                                                ?>
                                                <img src="<?php echo IT_HIPL_THEME_DIR; ?>/assets/images/blog.png" alt="blog">
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="blog-description">
                                            <h3 class="blog-title"><a href="<?= the_permalink() ?>"><?php the_title();?></a></h3>
                                            <div class="description-inner add-read-more show-less-content">
                                                <span><?php the_content(); ?></span>
                                                <a href="<?= the_permalink() ?>" class='read-more' >...read more</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="blog-about-details">
                                        <div class="blog-details">
                                            <div class="blog-details-item">
                                                <div class="icon-img"><img src="<?php echo IT_HIPL_THEME_DIR;?>/assets/images/icon/user.svg" alt="admin"></div>
                                                <div class="icon-title"><?= ucfirst($author_info->display_name) ?></div>
                                            </div>
                                            <div class="blog-details-item">
                                                <div class="icon-img"><img src="<?php echo IT_HIPL_THEME_DIR;?>/assets/images/icon/calendra.svg" alt="calendra"></div>
                                                <div class="icon-title"><?= $post_date ?></div>
                                            </div>
                                            <div class="blog-details-item">
                                                <?php //print_r( get_the_terms(  $post_id, 'services'  ) );  ?>
                                                <div class="icon-img"><img src="<?php echo IT_HIPL_THEME_DIR;?>/assets/images/icon/tag.svg" alt="tag"></div>
                                                <div class="icon-title"><a href="<?= get_term_link( $term->term_id ) ?>"><?= esc_html($term->name) ?></a></div>
                                            </div>
                                        </div>
                                        <a href="<?= the_permalink() ?>" class="themebtn btn btn-theme1">Read More</a>
                                    </div>
                                </div>
                                <?php
                            endwhile;
                            // the_posts_navigation();
                            ?>
                            <div class="col-12">
                                <div class="paginationbar">
                                    <!-- <ul class="pagination justify-content-center">
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <span aria-hidden="true">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 18L9 12L15 6" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link next" href="#" aria-label="Next">
                                                <span aria-hidden="true">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 18L15 12L9 6" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>                                                
                                                </span>
                                            </a>
                                        </li>
                                    </ul> -->
                                    <?php
                                    $big = 999999;
                                    $pagination = paginate_links(array(
                                        // 'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                        // 'format'    => '/pages/%#%',
                                        'base'      => esc_url(add_query_arg('page', '%#%')),
                                        'format'    => '?page=%#%',
                                        'current'   => $paged,
                                        'total'     => $postsQuery->max_num_pages,
                                        'prev_next' => true,
                                        'prev_text' => __('<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 18L9 12L15 6" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'),
                                        'next_text' => __('<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 18L15 12L9 6" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'),
                                        'type' => 'array',
                                    ));
                                    
                                    if ($pagination){
                                        echo '<ul class="pagination justify-content-center">';
                                        foreach ($pagination as $page_link) {
                                            echo '<li class="page-item">' . $page_link . '</li>';
                                        }
                                        echo '</ul>';
                                    }
                                    ?>
                                </div>
                            </div>
					    </div>
					</div> 
                    <?php
                    wp_reset_postdata();
				else :
					get_template_part( 'template-parts/content', 'none' );
				endif;
				?>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
<?php
get_sidebar();
get_footer();
