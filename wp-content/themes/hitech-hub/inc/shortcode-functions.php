<?php 

function recommended_articles(){ ?>
	<section class="latest-news section-spacing">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="section-heading">
                        <div class="title-heading">
                            <h2 class="title"><?php echo get_sub_field('label');?></h2>
                            <p><?php echo get_sub_field('description');?></p>                       
                        </div>
                        <a href="/blogs" class="btn btn-theme1">View All Blogs</a>
                    </div>
                    <div class="news-card-group">
                        <?php
                        $current_post_id = get_the_ID();
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        $args = [
                            'post_type'         =>  'blog', 
                            'post_status'       =>  'publish', 
                            'posts_per_page'    =>  2,
                            'paged'             =>  $paged,
                            'orderby'           =>  'date',
                            'order'             =>  'DESC',
                            'post__not_in'      =>  [$current_post_id],
                            
                        ];
                        $query = new WP_Query( $args );
                        if($query->have_posts()) :
                            while($query->have_posts()) : $query->the_post();
                                $postID         =   get_the_ID();
                                $post_thumb_id  =   get_post_thumbnail_id($post_id);
                                $attachment_url =   wp_get_attachment_image_url($post_thumb_id);
						        $mycontent = get_the_content();
						        $word = str_word_count(strip_tags($mycontent));
        						$m = floor($word / 100);
        						$s = floor($word % 200 / (200 / 60));
        						$total_time = $m . '.' . ($m == 1 ? '' : '') .$s. ' Min' . ($s == 1 ? '' : '');
                            ?>
                                <div class="news-card">
                                    <div class="sub-title"><?php echo display_read_time($post_id);?> Read</div>
                                    <h3 class="news-title"><a href="<?= the_permalink() ?>"><?= get_the_title() ?></a></h3>
                                    <a href="<?= the_permalink() ?>" class="vist-btn">Read More 
                                        <span>
                                            <svg width="23" height="16" viewBox="0 0 23 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 8L22 8" stroke="#17313B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M15 1L22 8L15 15" stroke="#17313B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                                <?php
                            endwhile;
                            wp_reset_postdata();                        
                        endif; ?>    
                    </div>
                </div>
            </div>
        </div>
    </section><?php
}
add_shortcode('recommended-articles', 'recommended_articles');