<?php 
if(!defined('ABSPATH')){
    exit();
}
/**
 * CLASS ITFirmsRewriteTaxonomy
 */
if (!class_exists('ITFirmsRewriteTaxonomy', false)) {
    class ITFirmsRewriteTaxonomy {
        public static function init() {

            //industries
            add_filter('request', [__CLASS__, 'ic_change_term_request'], 1, 1);
            add_filter('term_link', [__CLASS__, 'ic_term_permalink'], 10, 3);
            add_action('template_redirect', [__CLASS__, 'ic_old_term_redirect']);

            //location..
            add_filter('request', [__CLASS__, 'location_change_term_request'], 1, 1);
            add_filter('term_link', [__CLASS__, 'location_term_permalink'], 10, 3);
            add_action('template_redirect', [__CLASS__, 'location_old_term_redirect']);

            //Services
            add_filter('request', [__CLASS__, 'services_change_term_request'], 1, 1);
            add_filter('term_link', [__CLASS__, 'services_term_permalink'], 10, 3);
            add_action('template_redirect', [__CLASS__, 'services_old_term_redirect']);
        }

        public static function ic_change_term_request($query){
            $tax_name = 'industries'; 
	
           
            if( isset($query['attachment']) && $query['attachment'] ) :
                $include_children = true;
                $name = $query['attachment'];
            else:
                $include_children = false;
                $name = (isset($query['name'])) ? $query['name'] : '';
            endif;
            
            
            $term = get_term_by('slug', $name, $tax_name); 
            
            if(isset($name) && $term && !is_wp_error($term)):
                if($include_children){
                    unset($query['attachment']);
                    $parent = $term->parent;
                    while( $parent ) {
                        $parent_term    =   get_term( $parent, $tax_name);
                        $name           =   $parent_term->slug . '/' . $name;
                        $parent         =   $parent_term->parent;
                    }
                } else {
                    unset($query['name']);
                }
                
                switch( $tax_name ):
                    case 'category':{
                        $query['category_name'] = $name; // for categories
                        break;
                    }
                    case 'post_tag':{
                        $query['tag'] = $name; // for post tags
                        break;
                    }
                    default:{
                        $query[$tax_name] = $name; // for another taxonomies
                        break;
                    }
                endswitch;

            endif;
            
            return $query;
        }

        public static function ic_term_permalink($url, $term, $taxonomy){
            $taxonomy_name = 'industries'; // your taxonomy name here
            $taxonomy_slug = 'industries'; // the taxonomy slug can be different with the taxonomy name (like 'post_tag' and 'tag' )

            // exit the function if taxonomy slug is not in URL
            if ( strpos($url, $taxonomy_slug) === FALSE || $taxonomy != $taxonomy_name ) return $url;
            
            $url = str_replace('/' . $taxonomy_slug, '', $url);
            
            return $url;
        }

        public static function ic_old_term_redirect(){
            $taxonomy_name = 'industries';
            $taxonomy_slug = 'industries';
            
            // exit the redirect function if taxonomy slug is not in URL
            if( strpos( $_SERVER['REQUEST_URI'], $taxonomy_slug ) === FALSE)
                return;

            if( ( is_category() && $taxonomy_name=='category' ) || ( is_tag() && $taxonomy_name=='post_tag' ) || is_tax( $taxonomy_name ) ) :

                    wp_redirect( site_url( str_replace($taxonomy_slug, '', $_SERVER['REQUEST_URI']) ), 301 );
                exit();
                
            endif;
        }

        //location..
        public static function location_change_term_request($query){
            $tax_name = 'location'; 
    
           
            if( isset($query['attachment']) && $query['attachment'] ) :
                $include_children = true;
                $name = $query['attachment'];
            else:
                $include_children = false;
                $name = isset($query['name']) ? $query['name'] : '';
            endif;
            
            
            $term = get_term_by('slug', $name, $tax_name); 
            
            if(isset($name) && $term && !is_wp_error($term)):
                if($include_children){
                    unset($query['attachment']);
                    $parent = $term->parent;
                    while( $parent ) {
                        $parent_term    =   get_term( $parent, $tax_name);
                        $name           =   $parent_term->slug . '/' . $name;
                        $parent         =   $parent_term->parent;
                    }
                } else {
                    unset($query['name']);
                }
                
                switch( $tax_name ):
                    case 'category':{
                        $query['category_name'] = $name; // for categories
                        break;
                    }
                    case 'post_tag':{
                        $query['tag'] = $name; // for post tags
                        break;
                    }
                    default:{
                        $query[$tax_name] = $name; // for another taxonomies
                        break;
                    }
                endswitch;

            endif;
            
            return $query;
        }

        public static function location_term_permalink($url, $term, $taxonomy){
            $taxonomy_name = 'location'; // your taxonomy name here
            $taxonomy_slug = 'location'; // the taxonomy slug can be different with the taxonomy name (like 'post_tag' and 'tag' )

            // exit the function if taxonomy slug is not in URL
            if ( strpos($url, $taxonomy_slug) === FALSE || $taxonomy != $taxonomy_name ) return $url;
            
            $url = str_replace('/' . $taxonomy_slug, '', $url);
            
            return $url;
        }

        public static function location_old_term_redirect(){
            $taxonomy_name = 'location';
            $taxonomy_slug = 'location';
            
            // exit the redirect function if taxonomy slug is not in URL
            if( strpos( $_SERVER['REQUEST_URI'], $taxonomy_slug ) === FALSE)
                return;

            if( ( is_category() && $taxonomy_name=='category' ) || ( is_tag() && $taxonomy_name=='post_tag' ) || is_tax( $taxonomy_name ) ) :

                    wp_redirect( site_url( str_replace($taxonomy_slug, '', $_SERVER['REQUEST_URI']) ), 301 );
                exit();
                
            endif;
        }

        //Services..
        public static function services_change_term_request($query){
            $tax_name = 'services'; 
    
           
            if( isset($query['attachment']) && $query['attachment'] ) :
                $include_children = true;
                $name = $query['attachment'];
            else:
                $include_children = false;
                $name = isset($query['name']) ? $query['name'] : '';
            endif;
            
            
            $term = get_term_by('slug', $name, $tax_name); 
            
            if(isset($name) && $term && !is_wp_error($term)):
                if($include_children){
                    unset($query['attachment']);
                    $parent = $term->parent;
                    while( $parent ) {
                        $parent_term    =   get_term( $parent, $tax_name);
                        $name           =   $parent_term->slug . '/' . $name;
                        $parent         =   $parent_term->parent;
                    }
                } else {
                    unset($query['name']);
                }
                
                switch( $tax_name ):
                    case 'category':{
                        $query['category_name'] = $name; // for categories
                        break;
                    }
                    case 'post_tag':{
                        $query['tag'] = $name; // for post tags
                        break;
                    }
                    default:{
                        $query[$tax_name] = $name; // for another taxonomies
                        break;
                    }
                endswitch;

            endif;
            
            return $query;
        }

        public static function services_term_permalink($url, $term, $taxonomy){
            $taxonomy_name = 'services'; // your taxonomy name here
            $taxonomy_slug = 'services'; // the taxonomy slug can be different with the taxonomy name (like 'post_tag' and 'tag' )

            // exit the function if taxonomy slug is not in URL
            if ( strpos($url, $taxonomy_slug) === FALSE || $taxonomy != $taxonomy_name ) return $url;
            
            $url = str_replace('/' . $taxonomy_slug, '', $url);
            
            return $url;
        }

        public static function services_old_term_redirect(){
            $taxonomy_name = 'services';
            $taxonomy_slug = 'services';
            
            // exit the redirect function if taxonomy slug is not in URL
            if( strpos( $_SERVER['REQUEST_URI'], $taxonomy_slug ) === FALSE)
                return;

            if( ( is_category() && $taxonomy_name=='category' ) || ( is_tag() && $taxonomy_name=='post_tag' ) || is_tax( $taxonomy_name ) ) :

                    wp_redirect( site_url( str_replace($taxonomy_slug, '', $_SERVER['REQUEST_URI']) ), 301 );
                exit();
                
            endif;
        }
    }

    ITFirmsRewriteTaxonomy::init();
}