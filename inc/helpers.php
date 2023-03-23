<?php
/**
 * Theme Name:      Meloo
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascalsthemes.com/meloo
 * Author URI:      http://rascalsthemes.com
 * File:            helpers.php
 * @package meloo
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/* ==================================================
  Show AD 
================================================== */
if ( ! function_exists( 'meloo_show_ad' ) ) :
function meloo_show_ad( $place = '', $title = '', $custom = '' ) {
    $meloo_opts = meloo_opts();
    if ( ! empty( $place ) ) {
        $ad_type = "ad_{$place}_type";
        $ad_type = $meloo_opts->get_option( $ad_type );
        $place_class = empty( $custom ) ? 'adspot-' . $place : '';
        $output = '';
        if ( $ad_type and ! empty( $ad_type ) ) {

            switch ( $ad_type ) {
                case 'custom':
                    $ad_code = "ad_{$place}_custom";
                    $ad_code = $meloo_opts->get_option( $ad_code );
                    $output .= '<div class="adspot adspot-custom ' . esc_attr( $place_class ) . '" >';
                    if ( ! empty( $title ) ) {
                        $output .=  '<span class="adspot-heading">';
                        $output .= esc_html__( '- Advertisement -', 'meloo' );
                        $output .= '</span>';
                    }
                    $output .= $meloo_opts->esc( $ad_code );
                    $output .= '</div>';
                    break;
                
                 case 'adsense':
                    $ad_code = "ad_{$place}_adsense";
                    $ad_code = $meloo_opts->get_option( $ad_code );
                    $output .= '<div class="adspot adspot-google ' . esc_attr( $place_class ) . '" >';
                    if ( ! empty( $title ) ) {
                        $output .=  '<span class="adspot-heading">';
                        $output .= esc_html__( '- Advertisement -', 'meloo' );
                        $output .= '</span>';
                    }
                    $output .= $meloo_opts->esc( $ad_code );
                    $output .= '</div>';
                    break;
            }

            return $output;

        }
    
    }

    return false;
   
}
endif;


/* ==================================================
   One Page Menu Fix
================================================== */
add_filter('nav_menu_css_class', 'meloo_onepage_fix' , 10 , 2);
function meloo_onepage_fix($classes, $item) {
    global $post;
    $one_page = (int)get_theme_mod( 'one_page_id', 0 );
    if ( isset( $post ) && $one_page === $post->ID ) {
        foreach ( $classes as $key => $class ) {
            if ( $class === 'current-menu-item') {
                unset($classes[$key]);
            }
        }
    }
    return $classes;
}


/* ==================================================
   BG Generator
================================================== */
if ( ! function_exists( 'meloo_get_background' ) ) :
function meloo_get_background( $bg = null ) {
    
    if ( json_decode( $bg ) !== null ) {
        
        $css = '';            
        $data = json_decode( $bg, true );
        
        // Image
        if ( isset( $data['image'] ) ) {
            $image = wp_get_attachment_image_src( $data['image'], 'full' );
            $image = $image[0];
            // If image exists
            if ( $image ) {
                $css .= 'background-image: url( ' . esc_url( $image ) . ');';
            }
        } 

        // Color
        if ( isset( $data['color'] ) ) {
            $css .= 'background-color:' . esc_attr( $data['color'] ) . ';';
        }

        // Position
        if ( isset( $data['position'] ) ) {
            $css .= 'background-position:' . esc_attr( $data['position'] ) . ';';
        }

        // Repeat
        if ( isset( $data['repeat'] ) ) {
            $css .= 'background-repeat:' . esc_attr( $data['repeat'] ) . ';';
        }

        // Attachment
        if ( isset( $data['attachment'] ) ) {
            $css .= 'background-attachment:' . esc_attr( $data['attachment'] ) . ';';
        }

        // Size
        if ( isset( $data['size'] ) ) {
            $css .= 'background-size:' . esc_attr( $data['size'] ) . ';';
        }

        return $css;
    } else {
        return false;
    }
}
endif;


/* ==================================================
   Get stars rating
================================================== */
if ( ! function_exists( 'meloo_get_stars_rating' ) ) :
function meloo_get_stars_rating( $rating = '' ) {
    
    if ( $rating !== '' ) {
        $rating_nr = floatval( $rating );

        $output = '<div class="rating-stars-block">';
        for ( $x=1; $x <= $rating_nr; $x++ ) {
            $output .= '<i class="rating-star"></i>';
        }
        if ( strpos( $rating, '.' ) ) {
            $output .= '<i class="rating-star half"></i>';
            $x++;
        }
        while ( $x <= 5 ) {
            $output .= '<i class="rating-star empty"></i>';
            $x++;
        }
        $output .= '</div>';

        return $output;
    }
}
endif;


/* ==================================================
  KC Content
================================================== */
if ( ! function_exists( 'meloo_get_content' ) ) :
function meloo_get_content($id = null) {

    if ( function_exists( 'kc_do_shortcode' ) ) {
        // Make sure that content has [kc_row]  
        if ( strpos( get_the_content($id), '[kc_row' ) !== false ) {
            echo kc_do_shortcode( get_the_content($id) );
            return;
        } 
    }

    // Display Default WP Content 
    the_content($id); 
}
endif;


/* ==================================================
  Get Filters 
  ver 2.0.0
================================================== */
if ( ! function_exists( 'meloo_get_filters' ) ) :
function meloo_get_filters( $atts ) {
    if ( ! is_array( $atts ) || ! isset( $atts['taxonomies'] ) || empty( $atts['filter_type'] ) ) {
        return false;
    }

    $output = '';
    $multiple_filters = ( $atts['filter_type'] === 'multiple-filters' ? true : false );

    $filter_classes = array(
        'ajax-filters',
        $atts['filter_type'],
        $atts['show_filters'],
        $atts['filter_sel_method']

    );

    $output .= '<div class="' . esc_attr( implode( ' ', $filter_classes )  ) . '">';

    // Only for multiple filters  
    if ( $atts['filter_type'] === 'multiple-filters' ) {
        $output .= '<div class="filter-header">';
        $output .= '<div class="filter-meta">';
        $color_scheme = get_theme_mod( 'color_scheme', 'dark' );
        if ( function_exists( 'meloo_content_loader_small' ) ) {
            $output .= meloo_content_loader_small();
        }
        $output .= '<img class="filter-icon" src="' . esc_url( get_template_directory_uri() ) . '/images/filter-for-' . esc_attr( $color_scheme ) . '-bg.svg" width="24">';
        $output .= '</div>';
        $output .= '<a href="#" class="filter-label">' .  esc_html__('Filter', 'meloo' ) . '</a>';
        $output .= '</div>';
    }
    $output .= '<div class="filters-wrap">';

    foreach ( $atts['taxonomies'] as $key => $tax ) {

         // Hidden filter if label is empty 
        if ( $tax['label'] === '' ) {
            $output .= '<ul class="hidden-filter" data-filter-group="" data-tax-name="' . esc_attr( $tax['tax_name'] ) . '">';
        } else {
            $output .= '<ul data-filter-group="" data-tax-name="' . esc_attr( $tax['tax_name'] ) . '">';
        }

        if ( $multiple_filters === false ) {
        
            $output .= '<li>';
            if ( function_exists( 'meloo_content_loader' ) ) {
                $output .= meloo_content_loader();
            }
            $output .= '</li>';
        }
        $output .= '<li><a href="#" data-category_ids="all" data-category_slugs="all" class="is-active filter-reset"><span>' . esc_html( $tax['label'] ) .'</span></a></li>';

        $term_args = array( 'hide_empty' => '1', 'orderby' => 'name', 'order' => 'ASC' );

        if ( isset($tax['ids']) && $tax['ids'] !== null ) {
            $term_args['include'] = $tax['ids'];
            
        } elseif ( isset($tax['slugs']) && $tax['slugs'] !== null ){
            $slugs_a = explode( ',', $tax['slugs'] );
            $include = get_terms(array(
                'slug'     => $slugs_a, 
                'taxonomy' => $tax['tax_name'],
                'fields'   => 'ids',
            ));
            $term_args['include'] = $include;
        }
        $terms = get_terms( $tax['tax_name'], $term_args );
        if ( $terms ) {
            foreach ( $terms as $term ) {
                $t_query = array(
                    'taxonomy' => $tax['tax_name'],
                    'field' => 'term_id',
                    'terms' => array( $term->term_id )
                );
                if ( meloo_tax_is_empty($atts, $t_query) === false ) {  
                    $output .=  '<li><a href="#" data-category_ids="' . esc_attr( $term->term_id ) . '" data-category_slugs="' . esc_attr( $term->slug ) . '"><span>' . esc_html( $term->name ) . '</span></a></li>';
                }
            }
        }

        $output .= '</ul>';   
    
    }
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}
endif;


/* ==================================================
  Check if taxonomy is empty
  ver 1.0.0
================================================== */
if ( ! function_exists( 'meloo_tax_is_empty' ) ) :
function meloo_tax_is_empty( $atts, $t_query ) {

    $query_args = meloo_prepare_wp_query( $atts, 0 );

    $query_args['posts_per_page'] = -1;

    if ( isset( $query_args['tax_query'] ) ) {

        array_push($query_args['tax_query'], $t_query);
        $query_args['tax_query'] = array_unique($query_args['tax_query'], SORT_REGULAR);
        $t_query  = new WP_Query($query_args);
        $count = $t_query->post_count;
        if ( $count === 0 ) {
            return true;
        }
    }
    
    return false;

}
endif;


/* ==================================================
  Prepare Events Filter
  ver 1.0.0
================================================== */
if ( ! function_exists( 'meloo_prepare_events_filter' ) ) :
function meloo_prepare_events_filter( $args ) {

    if ( ! isset( $args ) || ! isset( $args['filter_atts'] ) ) {
        return false;
    }

    $filter_atts = $args['filter_atts'];

    if ( isset( $filter_atts[0] ) ) {
        $filter_atts = $filter_atts[0];
    }

    // Extra parameters 
    $filter_atts['filter_type']       = $args['ajax_filter'];
    $filter_atts['show_filters']      = $args['show_filters'];
    $filter_atts['filter_sel_method'] = $args['filter_sel_method'];
    $filter_atts['event_type_tax']    = 'meloo_event_type';
    $filter_atts['post_type']         = 'meloo_events';
    $filter_atts['sort_order']        = 'events_date';

    // All available filters (taxonomies)  
    $taxes = array(
        'meloo_event_type' => array(
            'tax_name' => 'meloo_event_type',
            'ids'      => 'event_type_ids', 
            'slugs'    => 'event_type_slugs',
            'label'    => 'event_type_label',
        ),
        'meloo_events_cats' => array(
            'tax_name' => 'meloo_events_cats',
            'ids'      => 'category_ids', 
            'slugs'    => 'category_slugs',
            'label'    => 'category_label',
        ),
        'meloo_events_cats2' => array(
            'tax_name' => 'meloo_events_cats2',
            'ids'      => 'category_ids2', 
            'slugs'    => 'category_slugs2',
            'label'    => 'category_label2',
        ),
        'meloo_events_cats3' => array(
            'tax_name' => 'meloo_events_cats3',
            'ids'      => 'category_ids3', 
            'slugs'    => 'category_slugs3',
            'label'    => 'category_label3',
        ),
        
    );

    $filter_atts['taxes'] = $taxes;


    return meloo_prepare_filter_taxonomies($filter_atts);

}

endif;


/* ==================================================
  Prepare Artists Filter
  ver 1.0.0
================================================== */
if ( ! function_exists( 'meloo_prepare_artists_filter' ) ) :
function meloo_prepare_artists_filter( $args ) {

    if ( ! isset( $args ) || ! isset( $args['filter_atts'] ) ) {
        return false;
    }

    $filter_atts = $args['filter_atts'];

    if ( isset( $filter_atts[0] ) ) {
        $filter_atts = $filter_atts[0];
    }

    // Extra parameters 
    $filter_atts['filter_type']       = $args['ajax_filter'];
    $filter_atts['show_filters']      = $args['show_filters'];
    $filter_atts['filter_sel_method'] = $args['filter_sel_method'];
    $filter_atts['post_type']         = 'meloo_artists';

    // All available filters (taxonomies)  
    $taxes = array(
        'meloo_artists_cats' => array(
            'tax_name' => 'meloo_artists_cats',
            'ids'      => 'category_ids', 
            'slugs'    => 'category_slugs',
            'label'    => 'category_label',
        ),
        'meloo_artists_cats2' => array(
            'tax_name' => 'meloo_artists_cats2',
            'ids'      => 'category_ids2', 
            'slugs'    => 'category_slugs2',
            'label'    => 'category_label2',
        ),
        'meloo_artists_cats3' => array(
            'tax_name' => 'meloo_artists_cats3',
            'ids'      => 'category_ids3', 
            'slugs'    => 'category_slugs3',
            'label'    => 'category_label3',
        ),
        'meloo_artists_cats4' => array(
            'tax_name' => 'meloo_artists_cats4',
            'ids'      => 'category_ids4', 
            'slugs'    => 'category_slugs4',
            'label'    => 'category_label4',
        ),
    );

    $filter_atts['taxes'] = $taxes;
    return meloo_prepare_filter_taxonomies($filter_atts);

}

endif;


/* ==================================================
  Prepare Music Filter
  ver 1.0.0
================================================== */
if ( ! function_exists( 'meloo_prepare_music_filter' ) ) :
function meloo_prepare_music_filter( $args ) {

    if ( ! isset( $args ) || ! isset( $args['filter_atts'] ) ) {
        return false;
    }

    $filter_atts = $args['filter_atts'];

    if ( isset( $filter_atts[0] ) ) {
        $filter_atts = $filter_atts[0];
    }

    // Extra parameters 
    $filter_atts['filter_type']       = $args['ajax_filter'];
    $filter_atts['show_filters']      = $args['show_filters'];
    $filter_atts['filter_sel_method'] = $args['filter_sel_method'];
    $filter_atts['post_type']         = 'meloo_music';

    // All available filters (taxonomies)  
    $taxes = array(
        'meloo_music_cats' => array(
            'tax_name' => 'meloo_music_cats',
            'ids'      => 'category_ids', 
            'slugs'    => 'category_slugs',
            'label'    => 'category_label',
        ),
        'meloo_music_cats2' => array(
            'tax_name' => 'meloo_music_cats2',
            'ids'      => 'category_ids2', 
            'slugs'    => 'category_slugs2',
            'label'    => 'category_label2',
        ),
        'meloo_music_cats3' => array(
            'tax_name' => 'meloo_music_cats3',
            'ids'      => 'category_ids3', 
            'slugs'    => 'category_slugs3',
            'label'    => 'category_label3',
        ),
        'meloo_music_cats4' => array(
            'tax_name' => 'meloo_music_cats4',
            'ids'      => 'category_ids4', 
            'slugs'    => 'category_slugs4',
            'label'    => 'category_label4',
        ),
    );

    $filter_atts['taxes'] = $taxes;
    return meloo_prepare_filter_taxonomies($filter_atts);

}

endif;


/* ==================================================
  Prepare Gallery Filter
  ver 1.0.0
================================================== */
if ( ! function_exists( 'meloo_prepare_gallery_filter' ) ) :
function meloo_prepare_gallery_filter( $args ) {

    if ( ! isset( $args ) || ! isset( $args['filter_atts'] ) ) {
        return false;
    }

    $filter_atts = $args['filter_atts'];

    if ( isset( $filter_atts[0] ) ) {
        $filter_atts = $filter_atts[0];
    }

    // Extra parameters 
    $filter_atts['filter_type']       = $args['ajax_filter'];
    $filter_atts['show_filters']      = $args['show_filters'];
    $filter_atts['filter_sel_method'] = $args['filter_sel_method'];
    $filter_atts['post_type']         = 'meloo_gallery';

    // All available filters (taxonomies)  
    $taxes = array(
        'meloo_gallery_cats' => array(
            'tax_name' => 'meloo_gallery_cats',
            'ids'      => 'category_ids', 
            'slugs'    => 'category_slugs',
            'label'    => 'category_label',
        ),
        'meloo_gallery_cats2' => array(
            'tax_name' => 'meloo_gallery_cats2',
            'ids'      => 'category_ids2', 
            'slugs'    => 'category_slugs2',
            'label'    => 'category_label2',
        ),
        'meloo_gallery_cats3' => array(
            'tax_name' => 'meloo_gallery_cats3',
            'ids'      => 'category_ids3', 
            'slugs'    => 'category_slugs3',
            'label'    => 'category_label3',
        ),
        'meloo_gallery_cats4' => array(
            'tax_name' => 'meloo_gallery_cats4',
            'ids'      => 'category_ids4', 
            'slugs'    => 'category_slugs4',
            'label'    => 'category_label4',
        ),
    );

    $filter_atts['taxes'] = $taxes;
    return meloo_prepare_filter_taxonomies($filter_atts);

}
endif;


/* ==================================================
  Prepare Videos Filter
  ver 1.0.0
================================================== */
if ( ! function_exists( 'meloo_prepare_videos_filter' ) ) :
function meloo_prepare_videos_filter( $args ) {

   if ( ! isset( $args ) || ! isset( $args['filter_atts'] ) ) {
        return false;
    }

    $filter_atts = $args['filter_atts'];

    if ( isset( $filter_atts[0] ) ) {
        $filter_atts = $filter_atts[0];
    }

    // Extra parameters 
    $filter_atts['filter_type']       = $args['ajax_filter'];
    $filter_atts['show_filters']      = $args['show_filters'];
    $filter_atts['filter_sel_method'] = $args['filter_sel_method'];
    $filter_atts['post_type']         = 'meloo_videos';

    // All available filters (taxonomies)  
    $taxes = array(
        'meloo_videos_cats' => array(
            'tax_name' => 'meloo_videos_cats',
            'ids'      => 'category_ids', 
            'slugs'    => 'category_slugs',
            'label'    => 'category_label',
        ),
        'meloo_videos_cats2' => array(
            'tax_name' => 'meloo_videos_cats2',
            'ids'      => 'category_ids2', 
            'slugs'    => 'category_slugs2',
            'label'    => 'category_label2',
        ),
        'meloo_videos_cats3' => array(
            'tax_name' => 'meloo_videos_cats3',
            'ids'      => 'category_ids3', 
            'slugs'    => 'category_slugs3',
            'label'    => 'category_label3',
        ),
        'meloo_videos_cats4' => array(
            'tax_name' => 'meloo_videos_cats4',
            'ids'      => 'category_ids4', 
            'slugs'    => 'category_slugs4',
            'label'    => 'category_label4',
        ),
    );

    $filter_atts['taxes'] = $taxes;
    return meloo_prepare_filter_taxonomies($filter_atts);

}
endif;


/* ==================================================
  Prepare Posts Filter
  ver 1.0.0
================================================== */
if ( ! function_exists( 'meloo_prepare_posts_filter' ) ) :
function meloo_prepare_posts_filter( $args ) {

   if ( ! isset( $args ) || ! isset( $args['filter_atts'] ) ) {
        return false;
    }

    $filter_atts = $args['filter_atts'];

    if ( isset( $filter_atts[0] ) ) {
        $filter_atts = $filter_atts[0];
    }

    // Extra parameters 
    $filter_atts['filter_type']       = $args['ajax_filter'];
    $filter_atts['show_filters']      = $args['show_filters'];
    $filter_atts['filter_sel_method'] = $args['filter_sel_method'];

    // All available filters (taxonomies)  
    $taxes = array(
        'category' => array(
            'tax_name' => 'category',
            'ids'      => 'category_ids', 
            'slugs'    => 'category_slugs',
            'label'    => 'category_label',
        ),
    );

    $filter_atts['taxes'] = $taxes;
    return meloo_prepare_filter_taxonomies($filter_atts);

}
endif;


/* ==================================================
  Prepare Filter Taxonomies
  ver 1.0.0
================================================== */
if ( ! function_exists( 'meloo_prepare_filter_taxonomies' ) ) :
function meloo_prepare_filter_taxonomies( $atts ) {

    if ( isset( $atts[0] ) ) {
        $atts = $atts[0];
    }

    if ( ! isset( $atts['post_type'] ) ) {
        $atts['post_type'] = 'post';
    }

    $temp_taxes = array();
    $count = 1;
    $label = 'category_label';
    $ids_name = 'category_ids';
    $slugs_name = 'category_slugs';
    $multiple_filters  = ( $atts['filter_type'] === 'multiple-filters' ? true : false );

    // Old taxonomies 
    if ( $multiple_filters === false && ! isset( $atts[$label] ) ) {
        $atts[$label] = esc_html__( 'All', 'meloo' );
    }

    foreach ($atts['taxes'] as $k => $t) {

        // Tax name  
        $temp_taxes[$count]['tax_name'] = $t['tax_name'];

        // IDS  
        if ( isset( $atts[$t['ids']] ) ) {
            $temp_taxes[$count]['ids'] = $atts[$t['ids']];
            unset( $atts[$t['ids']] );
        } else {
            $temp_taxes[$count]['ids'] = '';
        }

        // Slugs  
        if ( isset( $atts[$t['slugs']] ) ) {
            $temp_taxes[$count]['slugs'] = $atts[$t['slugs']];
            unset( $atts[$t['slugs']] );
        } else {
            $temp_taxes[$count]['slugs'] = '';
        }

        // Label  
        if ( isset( $atts[$t['label']] ) ) {
            $temp_taxes[$count]['label'] = $atts[$t['label']];
            unset( $atts[$t['label']] );
        } else {
            $temp_taxes[$count]['label'] = esc_html__( 'All', 'meloo' );
        }

        $count++;

    }
    unset($atts['taxes']);

    // Set order  
    if ( isset( $atts['filters_order'] ) ) {
        $order = array_map( 'intval', explode(',', $atts['filters_order'] ) );
        $sorted_taxes = array();
        if ( is_array( $order ) ) {            
            foreach ( $order as $key => $value ) {
                if ( isset( $temp_taxes[$value] ) ) {
                    $sorted_taxes[] = $temp_taxes[$value];
                }
            }

            $temp_taxes = $sorted_taxes;
        }

        unset( $atts['filters_order'] );
    }

    // Set index  
    foreach ($temp_taxes as $key => $value) {
        $index = $value['tax_name'];
        $atts['taxonomies'][$index] = $value;

        if ( $multiple_filters === false ) {
            break;
        }
    }
 
    return $atts;

}
endif;


/* ==================================================
  Prepare WP Query 
  ver 1.1.0
================================================== */
if ( ! function_exists( 'meloo_prepare_wp_query' ) ) :
function meloo_prepare_wp_query( $atts = '', $paged = '' ) {

    if ( isset( $atts[0] ) ) {
        $atts = $atts[0];
    }

    // The defaults will be overridden if set in $atts 
    $defaults = array( 
        'post_ids'            => '',
        'taxonomies'          => [],
        'tag_slugs'           => '',
        'sort_order'          => 'post_date',
        'limit'               => 8,
        'author_ids'          => '',
        'offset'              => '0',
        'posts_per_page'      => '',
        'post_type'           => 'post',
        'year'                => '',
        'monthnum'            => '',
        'day'                 => '',
        'ignore_sticky_posts' => 1,

    );

    // If $atts is not array 
    if ( ! is_array( $atts ) ) {
        return false;
    }
    
    // Set default arguments 
    $atts = array_merge( $defaults, $atts );

    extract( $atts, EXTR_PREFIX_SAME, 'query_arg' );

    // Make sure that offset is integer 
    $offset = (int)$offset;

    // Init WP query 
    $query_args = array(
        'post_type' => $post_type,
        'ignore_sticky_posts' => $ignore_sticky_posts,
        'post_status' => 'publish',
    );

    // Categories 
    if ( ! empty( $taxonomies ) ) {

        $k = 0;

        foreach ( $taxonomies as $t ) {

            // Skip Event type taxonomy  
            if ( isset( $event_type_tax ) && $t['tax_name'] === $event_type_tax ) {
                continue;
            }

            $tax_terms = [];
            $field_name = 'term_id';

            // IDS or Slugs 

            // Saved 
            if ( ! empty( $t['ids'] ) ) {
                $tax_terms = $t['ids'];
            } else if ( ! empty( $t['slugs'] ) ) {
                $field_name = 'slug';
                $tax_terms = $t['slugs'];
            }

            if ( ! is_array( $tax_terms ) ) {
                $tax_terms = explode( ',', $tax_terms );
            } 

            // From filter 
            if ( isset( $t['filter_ids'] ) && ! empty( $t['filter_ids'] ) ) {
                //$tax_terms = array_unique( array_merge( $tax_terms, $t['filter_ids'] ), SORT_REGULAR );
                $tax_terms = $t['filter_ids'];
            }


            // Simple Category (Blog)  
            if ( $post_type === 'post' && ! empty( $tax_terms ) ) {

                if ( $field_name === 'slug' ) {
                    $cat_slugs_a = $tax_terms;
                    $cat_ids_a = array();
                    foreach ( $cat_slugs_a as $slug ) {
                        if ( $slug[0] === '-'  ) {
                            $str = substr( $slug, 1 );
                            $is_minus = true;
                        } else {
                            $is_minus = false;
                        }
                        if ( get_category_by_slug( $slug ) ) {
                            $cat_obj = get_category_by_slug( $slug );
                            $cat_id = $cat_obj->term_id;
                            if ( $is_minus ) {
                                $cat_id = (-1 * abs( $cat_id ) );
                            }
                            $cat_ids_a[] = $cat_id;
                        }
                    }
                    if ( ! empty( $cat_ids_a ) ) {
                        $tax_terms = implode( ',', $cat_ids_a );
                    }

                 }

                $query_args['cat'] = $tax_terms;
                break;
            }

            if ( ! empty( $tax_terms ) ) {

                // Custom post type category  
                $query_args['tax_query'][$k] = array(
                    'taxonomy' => $t['tax_name'],
                    'field'    => $field_name,
                    'terms'    => $tax_terms,
                );
                
            }      

            $k++;

        }

    }


    if ( ! empty( $tag_slugs ) ) {
        $query_args['tag'] = $tag_slugs;
    }

    if ( ! empty( $author_ids ) ) {
        $query_args['author'] = $author_ids;
    }

    if ( ! empty( $year ) ) {
        $query_args['year'] = $year;
    }

    if ( ! empty( $monthnum ) ) {
        $query_args['monthnum'] = $monthnum;
    }

    if ( ! empty( $day ) ) {
        $query_args['day'] = $day;
    }

    if ( ! empty( $post_ids ) ) {

        $post_ids_a = explode ( ',', $post_ids );

        $post__in = array();
        $post__not_in = array();

        foreach ( $post_ids_a as $post_id ) {
            $post_id = trim( $post_id );

            if ( is_numeric( $post_id ) ) {
                if ( intval( $post_id ) < 0 ) {
                    $post__not_in[] = str_replace('-', '', $post_id);
                } else {
                    $post__in[] = $post_id;
                }
            }
        }

        if ( ! empty( $post__in ) ) {
            $query_args['post__in'] = $post__in;
            $query_args['orderby'] = 'post__in';
        }

        if ( ! empty( $post__not_in ) ) {
            $query_args['post__not_in'] = $post__not_in;
        }
    }

    switch ( $sort_order ) {
        
        case 'menu_order':
            $query_args['orderby'] = 'menu_order';
            $query_args['order'] = 'ASC';
            break;
        case 'oldest_posts':
            $query_args['order'] = 'ASC';
            break;
        case 'highest_rated':
            $query_args['meta_query'] = array(
                'relation' => 'AND',
                'has_review' => array(
                    'key' => '_has_reviews',
                    'value'   => true,
                ),
                'rating' => array(
                    'key' => '_rating',
                    'compare' => 'EXISTS',
                ), 
            );
            $query_args['orderby'] = array( 
                'rating' => 'DESC'
            );
            break;
        case 'rand':
            $query_args['orderby'] = 'rand';
            break;
        case 'title':
            $query_args['orderby'] = 'title';
            $query_args['order'] = 'ASC';
            break;
        case 'comment_count':
            $query_args['orderby'] = 'comment_count';
            $query_args['order'] = 'DESC';
            break;
        case 'rand_today':
            $query_args['orderby'] = 'rand';
            $query_args['year'] = date('Y');
            $query_args['monthnum'] = date('n');
            $query_args['day'] = date('j');
            break;
        case 'rand_week':
            $query_args['orderby'] = 'rand';
            $query_args['date_query'] = array(
                        'column' => 'post_date_gmt',
                        'after' => '1 week ago'
                        );
            break;

    }


    // Limit posts per page 
    if ( empty( $limit ) ) {
        $limit = get_option('posts_per_page');
    }
    $query_args['posts_per_page'] = $limit;

    // Pagination 
    if ( ! empty( $paged ) ) {
        $query_args['paged'] = $paged;
    } else {
        $query_args['paged'] = 1;
    }


    // Event Type 
    if ( isset( $event_type_tax ) ) {

        if ( !isset( $event_type ) ) {
            $event_type = 'future-events';
        }

        if ( $event_type === 'future-events' || $event_type === 'past-events' ) {

            // Set order 
            $order = $event_type === 'future-events' ? $order = 'ASC' : $order = 'DSC';

            if ( ! isset( $query_args['tax_query'] ) ) {
                $query_args['tax_query'] = array();
            }
            $query_args['tax_query']['relation'] = 'AND';

            array_push( $query_args['tax_query'], 
                array(
                   'taxonomy' => $event_type_tax,
                   'field'    => 'slug',
                   'terms'    => $event_type
                )
            );

            $query_args['orderby'] = 'meta_value';
            $query_args['order'] = $order;
            $query_args['meta_key'] = '_event_date_start';
            
        }

        if ( $event_type === 'all' ) {

            // Reset Query 
            $offset = 0;
            unset($query_args['post__in'],$query_args['post__not_in']);

            $future_tax = array(
                'relation' => 'AND',
                array(
                   'taxonomy' => $event_type_tax,
                   'field'    => 'slug',
                   'terms'    => 'future-events'
                )
            );

            $past_tax = array(
                'relation' => 'AND',
                array(
                   'taxonomy' => $event_type_tax,
                   'field'    => 'slug',
                   'terms'    => 'past-events'
                  )
            );

            if ( isset( $query_args['tax_query']  ) ) {
                array_push( $future_tax, $query_args['tax_query']);
                array_push( $past_tax, $query_args['tax_query']);
            }


            $future_events = get_posts( array(
                'post_type' => $post_type,
                'showposts' => -1,
                'tax_query' => $future_tax,
                'orderby' => 'meta_value',
                'meta_key' => '_event_date_start',
                'order' => 'ASC'
            ));

            // Past Events
            $past_events = get_posts(array(
                'post_type' => $post_type,
                'showposts' => -1,
                'tax_query' => $past_tax,
                'orderby' => 'meta_value',
                'meta_key' => '_event_date_start',
                'order' => 'DSC'
            ));

            $future_nr = count( $future_events );
            $past_nr = count( $past_events );

            // echo "Paged: Future events: $future_nr, Past events: $past_nr";

            $mergedposts = array_merge( $future_events, $past_events ); //combine queries

            $postids = array();
            foreach( $mergedposts as $item ) {
                $postids[] = $item->ID; //create a new query only of the post ids
            }
            $uniqueposts = array_unique( $postids ); //remove duplicate post ids

            $query_args['orderby'] = 'post__in';
            $query_args['post__in'] = $uniqueposts;

            // Remove Tax query
            if ( isset( $query_args['tax_query'] ) ) {
                unset($query_args['tax_query']);

            }
        
        }

    }

    // Offset 
    if ( $offset > 0 ) {

        if ( isset( $post__in ) && is_array( $post__in ) ) {
            $query_args['post__in'] = array_slice( $query_args['post__in'], $offset );
        } else {
            $fake_args = $query_args;
            $fake_args['posts_per_page'] = $offset;
            $fake_query = new WP_Query( $fake_args );
            $not_in_main_query = array();
            if ( $fake_query->have_posts() ) {
                while ( $fake_query->have_posts() ) {
                    $fake_query->the_post();
                    $not_in_main_query[] = get_the_ID();
                }
            } 
            // Restore original Post Data 
            wp_reset_postdata();
            
            if ( isset( $post__not_in ) && is_array( $post__not_in ) ) {
                $not_in_main_query = array_merge( $post__not_in, $not_in_main_query );
            }
            $query_args['post__not_in'] = $not_in_main_query;
        }

    }

    return $query_args;

}
endif;


/* ==================================================
  Get image BG
================================================== */
if ( ! function_exists( 'meloo_get_image_bg' ) ) :
function meloo_get_image_bg( $post_id, $thumb_size, $lazy = false, $image_id = false ) {

    // Return arguments 
    $args = array(
        'src' => '',
        'lazy_src' => '',
        'class' => ''
    );

    // Lazy effect is disabled in backend 
    if ( is_admin() && $lazy === true ) {
        $lazy = false;
    } 
    
    if ( $image_id === false && has_post_thumbnail( $post_id ) ) {
        $is_image = true;
        $image_id = get_post_thumbnail_id( $post_id );
    } else if ( $image_id !== false && wp_get_attachment_image_src( $image_id ) ) {
        $is_image = true;
    } else {
        $is_image = false;
    }

    // Get theme options 
    $meloo_opts = meloo_opts();

    if ( $is_image ) {
        $img_src = wp_get_attachment_image_src( $image_id, $thumb_size );

        // Image loading "lazyload" 
        if ( ( $lazy === true ) and ( $meloo_opts->get_option( 'lazyload' ) === 'on' ) ) {
            $img_placeholder = meloo_get_placeholder_src( $thumb_size );

            $args['lazy_src'] = $img_src[0];
            $args['src'] = 'background-image:url(' . $img_placeholder . ');';
            $args['class'] = 'lazy';
           
        } else {
            $args['src'] = 'background-image:url(' . $img_src[0] . ');';
        }

    } else {
        $img_src = meloo_get_placeholder_src( $thumb_size );
       $args['src'] = 'background-image:url(' . $img_src . ');';
    }    
    return $args;
}
endif;


/* ==================================================
  Get image
  ver 1.1.0
================================================== */
if ( ! function_exists( 'meloo_get_image' ) ) :
function meloo_get_image( $post_id, $thumb_size, $classes, $lazy = false, $image_id = false, $srcset = true ) {

    // Variables 
    $output = '';
    $srcset = '';

    // Get Options 
    $meloo_opts = meloo_opts();

    // Lazy effect is disabled in backend 
    if ( is_admin() && $lazy === true ) {
        $lazy = false;
    } 
    
    // is image 
    if ( $image_id === false && has_post_thumbnail( $post_id ) ) {
        $is_image = true;
        $image_id = get_post_thumbnail_id( $post_id );
    } else if ( $image_id !== false && wp_get_attachment_image_src( $image_id ) ) {
        $is_image = true;
    } else {
        $is_image = false;
    }

    // Get theme options 
    $meloo_opts = meloo_opts();

    if ( $is_image ) {
        $img_src = wp_get_attachment_image_src( $image_id, $thumb_size );

        // Get SRC Set 
        if ( $srcset ) {
            $srcset = meloo_get_srcset_sizes( $image_id, $thumb_size );
        }

        // Image loading "lazyload" 
        if ( ( $lazy === true ) and ( $meloo_opts->get_option( 'lazyload' ) === 'on' ) ) {
            $img_placeholder = meloo_get_placeholder_src( $thumb_size );

            $output = '<img class="lazy ' . esc_attr( $classes ) . '" src="' . esc_url( $img_placeholder ) . '" data-src="' . esc_attr( $img_src[0] ) . '" width="' . esc_attr( $img_src[1] ) . '" height="' . esc_attr( $img_src[2] ) . '" ' .  $srcset  . ' alt="' . esc_attr__( 'Post Image', 'meloo' ) . '" >';
        } else {
            $output = '<img class="' . esc_attr( $classes ) . '" src="' . esc_url( $img_src[0] ) . '" width="' . esc_attr( $img_src[1] ) . '" height="' . esc_attr( $img_src[2] ) . '" ' .  $meloo_opts->esc( $srcset )  . ' alt="' . esc_attr__( 'Post Image', 'meloo' ) . '" >';
        }

    } else {
        $img_src = meloo_get_placeholder_src( $thumb_size );
        $output = '<img src="' . esc_url( $img_src ) . '" alt="' . esc_attr__( 'Post Image', 'meloo' ) . '" class="' . esc_attr( $classes ) . '">';
    }    

    return $output;
}
endif;


/* ==================================================
   Get placeholder src
   ver 1.1.0
================================================== */
if ( ! function_exists( 'meloo_get_placeholder_src' ) ) :
function meloo_get_placeholder_src( $size ) {
    global $_wp_additional_image_sizes;

    $sizes = array();

    foreach ( get_intermediate_image_sizes() as $_size ) {
        if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
            $sizes[ $_size ]['size'] = $_size;
            $sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
            $sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
            $sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
        } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
            $sizes[ $_size ] = array(
                'size'   => $_size,
                'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
                'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
            );
        }
    }

    if ( ! isset( $sizes[ $size ] ) ) {
        $size = 'content';
    } else if ( $sizes[ $size ]['size'] === 'large' ) {
        $size = 'large';
    } else {
        $w = $sizes[ $size ]['width'];
        $h = $sizes[ $size ]['height'];
        $size = "{$w}x{$h}";
    }

    
    return $img = get_template_directory_uri() . '/images/no-thumb/' . esc_attr( $size ) . '.png';
}
endif;


/* ==================================================
   Get Srcset Sizes
   Returns the srcset and sizes parameters or an empty string
================================================== */
if ( ! function_exists( 'meloo_get_srcset_sizes' ) ) :
function meloo_get_srcset_sizes( $image_id, $thumb_size ) {
    
        $output = '';
        // Check if wp_get_attachment_image_srcset is defined, it was introduced only in WP 4.4 
        if ( function_exists('wp_get_attachment_image_srcset') ) {
            $thumb_srcset = wp_get_attachment_image_srcset( $image_id, $thumb_size );
            $thumb_sizes = wp_get_attachment_image_sizes( $image_id, $thumb_size );
            if ( $thumb_srcset !== false && $thumb_sizes !== false ) {
                $output = ' srcset="' . $thumb_srcset . '" sizes="' . $thumb_sizes . '"';
            }
            
        }

        return $output;
    }
endif;


/* ==================================================
  Get Soundcloud Iframe
  Generate embed Soundcloud iframe based on link
================================================== */
if ( ! function_exists( 'meloo_get_sc_iframe' ) ) :
function meloo_get_sc_iframe( $url = '', $height = '400' ) {

    if ( $url !== '' ) {

        // Get the JSON data of song details with embed code from SoundCloud oEmbed 
        $response = wp_remote_get( 'http://soundcloud.com/oembed?format=js&url=' . esc_attr( $url ) . '&iframe=true', array(
            'timeout' => 120,
            'sslverify' => false,
            'user-agent' => 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0'
        ));

        if ( is_wp_error( $response ) ) {
             // error handling
            $error_message = $response->get_error_message();
            return esc_html__( "Something went wrong:", 'meloo' ) . $error_message;
        }

        $request_output = wp_remote_retrieve_body( $response );
        if ( $request_output === '' ) {
            return esc_html__( "Something went wrong", 'meloo' );
        }
        
        // Clean the Json to decode 
        $decodeiFrame=substr( $request_output, 1, -2 );
        // json decode to convert it as an array 
        $jsonObj = json_decode( $decodeiFrame );

        return str_replace('height="400"', 'height="' . esc_attr( $height ) . '"', $jsonObj->html);
    }
    return false;
}
endif;


/* ==================================================
  Get bandcamp Iframe
  Generate embed Bandcamp iframe based on Wordpress.com shortcode 
================================================== */
if ( ! function_exists( 'meloo_get_bandcamp_iframe' ) ) :
function meloo_get_bandcamp_iframe( $code = '', $height = '400' ) {


    if ( $code !== '' and strpos( $code, '[bandcamp ') !== false )  {

        $defaults = array(
             'width'     => '100%',
             'height'    => '470',
             'album'     => '0',
             'size'      => 'large',
             'bgcol'     => 'ffffff',
             'linkcol'   => '0687f5',
             'tracklist' => 'false',
             'minimal'   => 'true',
             'artwork'   => 'small'
        );

        $code = str_replace( array( '[bandcamp ', ']' ),'', $code );

        $code_a = explode( ' ', $code );
        
        $bandcamp_params = array();
        foreach ( $code_a as $key => $value ) {
            $temp_param_a = explode( '=' , $value );
            $bandcamp_params[ $temp_param_a[0] ] = $temp_param_a[1];
        }

        // Set default arguments
        $bandcamp_params = array_merge( $defaults, $bandcamp_params );

        return '<iframe style="border: 0; width: 100%; max-width:700px" src="https://bandcamp.com/EmbeddedPlayer/album=' . esc_attr( $bandcamp_params['album'] ) . '/size=' . esc_attr( $bandcamp_params['size'] ) . '/bgcol=' . esc_attr( $bandcamp_params['bgcol'] ) . '/artwork=' . esc_attr( $bandcamp_params['artwork'] ) . '/linkcol=' . esc_attr( $bandcamp_params['linkcol'] ) . '/tracklist=' . esc_attr( $bandcamp_params['tracklist'] ) . '/transparent=true/" seamless></iframe>';

    }

    return esc_html__( 'Error: Please enter correct Bandcamp code', 'meloo' );
}
endif;


/* ==================================================
  get Spotify Iframe
  Generate embed Spotify iframe based on link 
================================================== */
if ( ! function_exists( 'meloo_get_spotify_iframe' ) ) :
function meloo_get_spotify_iframe( $url = '', $height = '400' ) {

    if ( $url !== '' ) {
        $url = str_replace( 'https://open.spotify.com/', '', $url );
        $url = stristr( $url, '?', true );
  
        return '<iframe src="https://open.spotify.com/embed/' . esc_attr( $url ) . '" width="100%" height="' . esc_attr( $height ) . '" frameborder="0" allowtransparency="true"></iframe>';

    }

    return false;
}
endif;


/* ==================================================
  Format Number 
================================================== */
if ( ! function_exists( 'meloo_format_number' ) ) :
 function meloo_format_number($num) {

    if ( $num >= 1000000 ) {
        $num = number_format_i18n($num / 1000000, 1) . 'm';
    } elseif ( $num >= 10000 )  {
        $num = number_format_i18n($num / 1000, 1) . 'k';
    } else {
        $num = number_format_i18n($num);
    }
    return $num;
}
endif;


/* ==================================================
  Get taxonomies 
================================================== */
if ( ! function_exists( 'meloo_get_taxonomies' ) ) :
function meloo_get_taxonomies( $atts = array() ) {

    if ( empty( $atts ) ) {
        return false;
    }

    $categories = get_the_terms( $atts['id'], $atts['tax_name'] );
    $output = '';
    if ( ! empty( $categories ) ) {
        $count = 1;
        foreach( $categories as $category ) {
            if ( $atts['link'] ) {
                $output .= '<a class="cat cat-' . esc_attr( $category->term_id ) . '" href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr__( 'View posts from category', 'meloo' ) . '"><span class="cat-inner">' . esc_html( $category->name ) . '</span></a>' . esc_attr ( $atts['separator'] );
            } else {
                $output .= '<span class="cat cat-' . esc_attr( $category->term_id ) . '"><span class="cat-inner">' . esc_html( $category->name ) . '</span></span>' . esc_attr ( $atts['separator'] );
            }
            if ( $atts['limit'] !== -1 && $count === $atts['limit'] ) {
                break;
            }
            $count++;
        } 
        if ( $atts['show_count'] && count( $categories ) > $atts['limit'] ) {

            $counts_nr = '<span class="cats-count">+' . esc_attr( count( $categories ) - $count ) . '</span>';
        } else {
            $counts_nr = '';
        }
        return trim( $output, $atts['separator'] ) . $counts_nr;
    }
    return false;
}
endif;


/* ==================================================
  Show Ajax Loaders
================================================== */
if ( ! function_exists( 'meloo_wpal_bars_loader' ) ) :
function meloo_wpal_bars_loader() {
    $loader_scheme = get_theme_mod( 'loader_color_scheme', 'dark' );
    if ( $loader_scheme === 'dark' ) {
         $loader_img_name = 'light';
    } else {
        $loader_img_name = 'dark';
    }
    $loader_img = get_theme_mod( 'loader_img', esc_url( get_template_directory_uri() ) . '/images/logo-'.esc_attr( $loader_img_name ).'.svg' );
    $loader = '
        <div class="ajax-loader">
            <div class="loader-content">';
                if ( $loader_img && ! empty( $loader_img ) ) {
                    $loader .= '<div class="loader-img"><img src="' . esc_url( $loader_img ) . '" alt="Logo"></div>';
                } 

                $loader .= '<div class="loader-bar">
                    <span class="progress-bar"></span>
                </div>
            </div>
           
        </div>
        <div class="shape-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="shape" width="100%" height="100vh" preserveAspectRatio="none" viewBox="0 0 1440 800">
                <path d="M -30.45,-43.86 -30.45,0 53.8,0 53.8,0 179.5,0 179.5,0 193.3,0 193.3,0 253.1,0 253.1,0 276.1,0 276.1,0 320.6,0 320.6,0 406.5,0 406.5,0 435.6,0 435.6,0 477,0 477,0 527.6,0 527.6,0 553.7,0 553.7,0 592,0 592,0 742.3,0 742.3,0 762.2,0 762.2,0 776,0 776,0 791.3,0 791.3,0 852.7,0 852.7,0 871.1,0 871.1,0 878.7,0 878.7,0 891,0 891,0 923.2,0 923.2,0 940.1,0 940.1,0 976.9,0 976.9,0 1031,0 1031,0 1041,0 1041,0 1176,0 1176,0 1192,0 1192,0 1210,0 1210,0 1225,0 1225,0 1236,0 1236,0 1248,0 1248,0 1273,0 1273,0 1291,0 1291,0 1316,0 1316,0 1337,0 1337,0 1356,0 1356,0 1414,0 1414,0 1432,0 1432,0 1486,0 1486,-43.86 Z" data-spirit-id="M -30.45,-57.86 -30.45,442.6 53.8,443.8 53.8,396.3 179.5,396.3 179.5,654.7 193.3,654.7 193.3,589.1 253.1,589.1 253.1,561.6 276.1,561.6 276.1,531.2 320.6,531.2 320.6,238.6 406.5,238.6 406.5,213.9 435.6,213.9 435.6,246.2 477,246.2 477,289.9 527.6,289.9 527.6,263.3 553.7,263.3 553.7,280.4 592,280.4 592,189.2 742.3,189.2 742.3,259.5 762.2,259.5 762.2,103.7 776,103.7 776,77.11 791.3,77.11 791.3,18.21 852.7,18.21 852.7,86.61 871.1,86.61 871.1,231 878.7,240.5 878.7,320.3 891,320.3 891,434.3 923.2,434.3 923.2,145.5 940.1,145.5 940.1,117 976.9,117 976.9,139.8 1031,139.8 1031,284.2 1041,284.2 1041,242.4 1176,242.4 1176,282.3 1192,282.3 1192,641.4 1210,641.4 1210,692.7 1225,692.7 1225,599.6 1236,599.6 1236,527.4 1248,527.4 1248,500.8 1273,500.8 1273,523.6 1291,523.6 1291,652.8 1316,652.8 1316,533.1 1337,533.1 1337,502.7 1356,502.7 1356,523.6 1414,523.6 1414,491.3 1432,491.3 1432,523.6 1486,523.6 1486,-57.86 Z"></path>
            </svg>
        </div>';

    if( has_filter('meloo_wpal_change_bars_loader') ) {
        $loader = apply_filters( 'meloo_wpal_change_bars_loader', $loader );
    }
    return '<div id="wpal-loader" class="wpal-loading-bars-layer show-layer ' . esc_attr( $loader_scheme  ) . '-scheme-el">' . $loader . '</div>';
}
endif;


if ( ! function_exists( 'meloo_wpal_stripes_loader' ) ) :
function meloo_wpal_stripes_loader() {
    $loader_scheme = get_theme_mod( 'loader_color_scheme', 'dark' );
   if ( $loader_scheme === 'dark' ) {
        $loader_img_name = 'light';
    } else {
        $loader_img_name = 'dark';
    }
    $loader_img = get_theme_mod( 'loader_img', esc_url( get_template_directory_uri() ) . '/images/logo-'.esc_attr( $loader_img_name ).'.svg' );
    $loader = '
        <div class="page-trans">
            <div class="page-loader-content">';

                if ( $loader_img && ! empty( $loader_img ) ) {
                    $loader .= '<div class="loader-img"><img src="' . esc_url( $loader_img ) . '" alt="Logo"></div>';
                } 

                $loader .= '<div class="loader-bar">
                    <span class="progress-bar"></span>
                </div>

            </div>
            <div class="page-trans-stripes">
                <div class="page-trans-stripe page-trans-stripe-0"></div>
                <div class="page-trans-stripe page-trans-stripe-1"></div>
                <div class="page-trans-stripe page-trans-stripe-2"></div>
                <div class="page-trans-stripe page-trans-stripe-3"></div>
                <div class="page-trans-stripe page-trans-stripe-4"></div>
                <div class="page-trans-stripe page-trans-stripe-5"></div>
            </div>
        </div>';

    if( has_filter('meloo_wpal_change_stripes_loader') ) {
        $loader = apply_filters( 'meloo_wpal_change_stripes_loader', $loader );
    }
    return '<div id="wpal-loader" class="wpal-loading-stripes-layer show-layer ' . esc_attr( $loader_scheme  ) . '-scheme-el">' . $loader . '</div>';
}
endif;


/* ==================================================
  Content Loader 
================================================== */
if ( ! function_exists( 'meloo_content_loader' ) ) :
function meloo_content_loader( $color = '' ) {

    $color_scheme = get_theme_mod( 'color_scheme', 'dark' );

    if ( $color === '' ) {
        if ( $color_scheme === 'dark' ) {
            $color = '#fff';
        } else {
            $color = '#1a1a1a';
        }
    }

    $loader = '<div class="content-ajax-loader"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="24px" height="30px" viewBox="0 0 24 30" style="enable-background:new 0 0 50 50;" xml:space="preserve">
    <rect x="0" y="0" width="4" height="10" fill="' . esc_attr( $color ) . '">
      <animateTransform attributeType="xml"
        attributeName="transform" type="translate"
        values="0 0; 0 20; 0 0"
        begin="0" dur="0.6s" repeatCount="indefinite" />
    </rect>
    <rect x="10" y="0" width="4" height="10" fill="' . esc_attr( $color ) . '">
      <animateTransform attributeType="xml"
        attributeName="transform" type="translate"
        values="0 0; 0 20; 0 0"
        begin="0.2s" dur="0.6s" repeatCount="indefinite" />
    </rect>
    <rect x="20" y="0" width="4" height="10" fill="' . esc_attr( $color ) . '">
      <animateTransform attributeType="xml"
        attributeName="transform" type="translate"
        values="0 0; 0 20; 0 0"
        begin="0.4s" dur="0.6s" repeatCount="indefinite" />
    </rect>
  </svg></div>';
    if ( has_filter('meloo_change_content_loader') ) {
        $loader = apply_filters( 'meloo_change_content_loader', $loader );
    }
    return  $loader;
}
endif;


/* ==================================================
  Content Loader Small
================================================== */
if ( ! function_exists( 'meloo_content_loader_small' ) ) :
function meloo_content_loader_small( $color = '' ) {

    $color_scheme = get_theme_mod( 'color_scheme', 'dark' );

    if ( $color === '' ) {
        if ( $color_scheme === 'dark' ) {
            $color = '#fff';
        } else {
            $color = '#1a1a1a';
        }
    }

    $loader = '<div class="content-ajax-loader"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="24px" height="30px" viewBox="0 0 24 30" style="enable-background:new 0 0 50 50;" xml:space="preserve">
    <rect x="0" y="0" width="10" height="1" fill="' . esc_attr( $color ) . '">
      <animateTransform attributeType="xml"
        attributeName="transform" type="translate"
        values="0 0; 20 0; 0 0"
        begin="0" dur="0.6s" repeatCount="indefinite" />
    </rect>
    <rect x="0" y="7" width="10" height="1" fill="' . esc_attr( $color ) . '">
      <animateTransform attributeType="xml"
        attributeName="transform" type="translate"
        values="0 0; 20 0; 0 0"
        begin="0.2s" dur="0.6s" repeatCount="indefinite" />
    </rect>
  </svg></div>';
    if ( has_filter('meloo_change_content_loader_small') ) {
        $loader = apply_filters( 'meloo_change_content_loader_small', $loader );
    }
    return  $loader;
}
endif;

/* ==================================================
  Comments List 
================================================== */
if ( ! function_exists( 'meloo_comments' ) ) :
function meloo_comments( $comment, $atts, $depth ) {

    $meloo_opts = meloo_opts();

    $GLOBALS['comment'] = $comment; 

    // Date format
    $date_format = 'd/m/y';

    if ( $meloo_opts->get_option( 'custom_comment_date' ) ) {
        $date_format = $meloo_opts->get_option( 'custom_comment_date' );
    }
    ?>

    <!-- Comment -->
    <li id="li-comment-<?php comment_ID() ?>" <?php comment_class( 'theme_comment' ); ?>>
        <article id="comment-<?php comment_ID(); ?>">
            <div class="avatar-wrap">
                <?php echo get_avatar( $comment, '100' ); ?>
            </div>
            <div class="comment-meta">
                <h5 class="author"><?php comment_author_link(); ?></h5>
                <p class="date"><?php comment_date( $date_format ); ?> <span class="reply"><?php comment_reply_link( array_merge( $atts, array( 'reply_text' => '<span class="icon icon-reply-all"></span>', 'depth' => $depth, 'max_depth' => $atts['max_depth'] ) ) ); ?></span></p>
            </div>
            <div class="comment-body">
                <?php comment_text(); ?>
                <?php if ( $comment->comment_approved === '0' ) : ?>
                <p class="message info"><?php esc_html_e( 'Your comment is awaiting moderation.', 'meloo' ); ?></p>
                <?php endif; ?> 
            </div>
        </article>
<?php 
}
endif;


/* ==================================================
  Tag Cloud Filter 
================================================== */
if ( ! function_exists( 'meloo_tag_cloud_filter' ) ) :
function meloo_tag_cloud_filter( $atts = array() ) {
   $atts['smallest'] = 13;
   $atts['largest'] = 13;
   $atts['unit'] = 'px';
   return $atts;
}
add_filter( 'widget_tag_cloud_args', 'meloo_tag_cloud_filter', 90 );
endif;


/* ==================================================
  Contact Form 7 Custom Loader 
================================================== */
if ( ! function_exists( 'meloo_wpcf7_ajax_loader' ) ) :
function meloo_wpcf7_ajax_loader () {
    return  get_template_directory_uri() . '/images/loader-dark.svg';
}
add_filter( 'wpcf7_ajax_loader', 'meloo_wpcf7_ajax_loader' );
endif;


/* ==================================================
  WP Title
  Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view. 
================================================== */
if ( ! function_exists( 'meloo_wp_title' ) ) :
function meloo_wp_title( $title, $sep ) {
    global $paged, $page;

    if ( is_feed() ) {
        return $title;
    }

    // Add the site name.
    $title .= get_bloginfo( 'name', 'display' );

    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) ) {
        $title = "$title $sep $site_description";
    }

    // Add a page number if necessary.
    if ( $paged >= 2 || $page >= 2 ) {
        $title = esc_html( "$title $sep " . sprintf( esc_html__( 'Page %s', 'meloo' ), max( $paged, $page ) ) );
    }

    return $title;
}
add_filter( 'wp_title', 'meloo_wp_title', 10, 2 );
endif;


/* ==================================================
  Social Buttons
  Display social buttons 
================================================== */
if ( ! function_exists( 'meloo_social_buttons' ) ) :
function meloo_social_buttons( $buttons ) {
    
    if ( isset( $buttons ) && is_array( $buttons ) && ! empty( $buttons ) ) {
        $html = '';

        foreach ( $buttons as $button ) {

            $html .= '<a href="' . esc_url( $button['social_link'] ) . '" class="circle-btn">
                <svg class="circle-svg" width="50" height="50" viewBox="0 0 50 50">
                    <circle class="circle" cx="25" cy="25" r="23" stroke="#fff" stroke-width="1" fill="none"></circle>
                </svg>
                <span class="icon icon-' . esc_attr( $button['social_type'] ) . '"></span>
            </a>';
        }
        return $html;
    }

}
endif;


/* ==================================================
  Add Body Classes 
================================================== */
if ( ! function_exists( 'meloo_body_class' ) ) :
function meloo_body_class( $classes ) {
    
    global $wp_query, $post, $paged;
    
    // Get theme options 
    $meloo_opts = meloo_opts();

    $color_scheme = get_theme_mod( 'color_scheme', 'dark' );
    $color_scheme .= '-scheme';

    $classes[] = $color_scheme;

    // Hero Disabled
    if ( isset( $wp_query->post->ID ) ) {
        $post_template = get_post_meta( $wp_query->post->ID, '_post_template', true );
        $header_layout = get_post_meta( $wp_query->post->ID, '_header_layout', true );
        $hero_disabled_a = array( 'simple', 'simple_title', 'left_sidebar', 'right_sidebar' );
        if ( 
            ( in_array( $header_layout, $hero_disabled_a ) ) or
            ( in_array( $post_template, $hero_disabled_a ) ) ) {
            $classes[] = 'hero-disabled';
        } 
    }
    if ( 
        ( class_exists( 'WooCommerce' ) && is_product() ) or 
        ( is_author() ) or 
        ( is_404() )
    ) {
        $classes[] = 'hero-disabled';
    }
    

    // WPAJAX
    if ( ! is_customize_preview() && $meloo_opts->get_option( 'ajaxed' ) && $meloo_opts->get_option( 'ajaxed' ) === 'on' ) {
        $classes[] = 'WPAjaxLoader';
    }

    // Sticky Sidebar
    if ( get_theme_mod( 'sticky_sidebar', true ) === 1 ) {
        $classes[] = 'sticky-sidebars';
    }
    
    // Lazyload
    if ( $meloo_opts->get_option( 'lazyload' ) === 'on' ) {
        $classes[] = 'lazyload';
    }

    return $classes;
     
}
add_filter( 'body_class', 'meloo_body_class' );
endif;


/* ==================================================
  Facebook Share Options 
================================================== */
if ( ! function_exists( 'meloo_share_options' ) ) :
function meloo_share_options() {
    global $wp_query; 

    if ( is_single() || is_page() ) { 

        $is_fb_sharing = get_post_meta( $wp_query->post->ID, '_fb_sharing', true );

        if ( isset( $is_fb_sharing  ) && $is_fb_sharing === true ) {
            
            // Video 
            $share_video = get_post_meta( $wp_query->post->ID, '_share_video', true );
            if ( isset( $share_video ) && $share_video !== '' ) {
                echo '<meta property="og:url" content="' . esc_attr( $share_video ) . '"/>' . "\n";     
            } else {
                echo '<meta property="og:url" content="' . esc_url( get_permalink( $wp_query->post->ID ) ) . '"/>' . "\n";
            }
            
            // Title 
            $share_title = get_post_meta( $wp_query->post->ID, '_share_title', true );
            if ( isset( $share_title ) && $share_title !== '' ) {
                 echo "\n" .'<meta property="og:title" content="' . esc_attr( $share_title ) . '"/>' . "\n";     
            } else {
                // Site name 
                echo "\n" .'<meta property="og:title" content="' . esc_attr( get_bloginfo('name') ) . '"/>' . "\n";     
            }

            // Description 
            $share_description = get_post_meta( $wp_query->post->ID, '_share_description', true );
            if ( isset( $share_description ) && $share_description !== '' ) {
                 echo "\n" .'<meta property="og:description" content="' . esc_attr( $share_description ) . '"/>' . "\n";     
            }

            // Image 
            $share_image = get_post_meta( $wp_query->post->ID, 'share_image', true );
            if ( isset( $share_image ) ) {
                $image_attributes = wp_get_attachment_image_src( $share_image, 'full' );
                if ( $image_attributes ) {
                    echo "\n" .'<meta property="og:image" content="' . esc_attr( $image_attributes[0] ) . '"/>' . "\n";
                }
            }
        }

    }
}
add_action( 'wp_head', 'meloo_share_options' ); 
endif;


/* ==================================================
  WPML Language Selector 
================================================== */
if ( ! function_exists( 'meloo_languages_list' ) ) :
function meloo_languages_list( $id = '', $display ){
    if ( function_exists( 'icl_get_languages' ) ) {

        $languages = icl_get_languages( 'skip_missing=0&orderby=code' );
        if ( ! empty( $languages ) ) {
            if ( $id !== '' ) {
                echo '<div id="' . esc_attr($id) . '" class="lang-selector"><ul>';
            } else {
                 echo '<div class="lang-selector"><ul>';
            }
            foreach($languages as $l){
                echo '<li>';

                if ( $display === 'flags' ||  $display === 'language_codes_flags'  ) {
                    if ( $l['country_flag_url'] ) {
                        if ( ! $l[ 'active' ] ) {
                            echo '<a href="'. esc_url( $l['url'] ) . '">';
                        }
                        echo '<img src="'.esc_url($l['country_flag_url']).'" height="12" alt="'.esc_attr($l['language_code']).'" width="18" />';
                        if ( ! $l['active'] ) {
                            echo '</a>';
                         }
                     }

                }

                if ( $display !== 'flags' ) {
                    if ( ! $l[ 'active' ] ) {
                        echo '<a href="'. esc_url( $l['url'] ) . '">';
                    }
                    echo esc_attr( $l['language_code'] );

                    if ( ! $l['active'] ) {
                        echo '</a>';
                    }
                    echo '</li>';
                }
            }
            echo '</ul></div>';
        }
    }
}
endif;