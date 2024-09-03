<?php 
/* Template Name: Press Release */

get_header();
?>
<!-- Banner Section Start -->
<section class="banner-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-12 col-12">
                <div class="banner-content">
                    <h1 class="banner-title"><?php the_title(); ?></h1>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Section End -->

<!-- Press Relese Card Section Start -->
<?php
$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
$args = [
    'post_type'         =>  'press-release', 
    'post_status'       =>  'publish', 
    'posts_per_page'    =>  6,
    'paged'             =>  $paged,
    'orderby'           =>  'date',
    'order'             =>  'DESC',
];
$query = new WP_Query( $args ); ?> 
<section class="interview-section section-spacing">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-12">
                <div class="interview-card-group horizontal-card"><?php 
                if($query->have_posts()) :
                    while($query->have_posts()) : $query->the_post(); 
                        $post_id = get_the_ID();
                        $post_thumb_id = get_post_thumbnail_id($post_id);
                        $attachment_url = wp_get_attachment_image_url($post_thumb_id, 'large');?>
                    <div class="interview-card">
                        <div class="interview-banner"><img src="<?php echo $attachment_url; ?>" alt="press relese"></div>
                        <div class="content-body">
                            <h2><a href="<?php the_permalink(); ?>" class="title"><?php echo get_the_title(); ?></a></h2>
                            <p><?php echo substr(strip_tags(get_the_content()), 0, 200).'...'; ?></p>
                            <a href="<?php the_permalink(); ?>" class="vist-btn">Read Full Interview 
                                <span>
                                    <svg width="23" height="16" viewBox="0 0 23 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 8L22 8" stroke="#17313B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M15 1L22 8L15 15" stroke="#17313B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div><?php
                    endwhile;
                wp_reset_postdata();
                else :
                    echo '<p>' . __( 'No posts found.', 'text-domain' ) . '</p>';  
                endif; ?>     
                </div>
            </div>
            <?php 
            if($query->have_posts()){ ?>
            <div class="col-sm-12 col-12">
                <div class="paginationbar">
                    <?php
                    $big = 999999999;
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
            </div> <?php
            }
            ?>
		</div>
    </div>
</section>
<!-- Press Relese Card Section End -->
<?php
get_footer(); 