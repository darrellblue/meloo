<?php
/**
 * Theme Name:      Meloo
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascalsthemes.com/meloo
 * Author URI:      http://rascalsthemes.com
 * File:            ajax.php
 * @package meloo
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/* ==================================================
  Posts Slider 
================================================== */
if ( ! function_exists( 'meloo_posts_slider_ajax' ) ) :
function meloo_posts_slider_ajax() {

    $meloo_opts = meloo_opts();

    $nonce  = $_POST['ajax_nonce'];
    $obj    = $_POST['obj'];
    $output = '';

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
        die( 'Busted!' );
    }
    if ( ! isset( $obj ) ) {
        die();
    }

    // Date format
    $date_format = get_option( 'date_format' );

    // Thumb Size
    $thumb_size = $obj['thumb_size'];

    // Module
    $module = $obj['module'];

    // Pagenum
    $obj['pagenum'] = isset( $obj['pagenum'] ) ? absint( $obj['pagenum'] ) : 1;

    // Begin Loop
    $args = array(
        'post_type'   => $obj['cpt'],
        'post_status' => 'publish',
        'order'       => 'ASC',
        'orderby'     => $obj['orderby']
    );

    // Loop Arguments 

    // Tag in 
    if ( isset( $obj['tag__in'] ) && $obj['tag__in'] !== '' ) {
        $obj['tag__in'] = explode( ",", $obj['tag__in'] );
        $args['tag__in'] = $obj['tag__in'];
    }

    // Posts not in 
    if ( isset( $obj['post__not_in'] ) && $obj['post__not_in'] !== '' ) {
        $obj['post__not_in'] = explode( ",", $obj['post__not_in'] );
        $args['post__not_in'] = $obj['post__not_in'];
    }

    // Ignore sticky posts 
    if ( isset( $obj['ignore_sticky_posts'] ) && $obj['ignore_sticky_posts'] !== '' ) {
        $args['ignore_sticky_posts'] = $obj['ignore_sticky_posts'];
    }

    // Category in 
    if ( isset( $obj['category__in'] ) && $obj['category__in'] !== '' ) {
        $obj['category__in'] = explode( ",", $obj['category__in'] );
        $args['category__in'] = $obj['category__in'];
    }

    // Filter by taxonomies 
    if ( isset( $obj['cats'] ) && $obj['cats'] !== '' ) {
        $cat_id = explode( ",", $obj['cats'] );
        $args['tax_query'] = array(
            array(
                'taxonomy' => $obj['tax'],
                'field'    => 'term_id',
                'terms'    => $cat_id,
            )
        );
    }

    // Posts count
    $temp_args = $args;
    $temp_args['showposts'] = -1;
    $temp_query_count = new WP_Query();
    $temp_query_count->query( $temp_args );
    if ( $temp_query_count->post_count <= ( $obj['limit'] * $obj['pagenum'] ) ) {
        $posts_nr = 'finished';
    } else {
        $posts_nr = '';
    }

    // Args
    $args['offset'] = $obj['pagenum'] > 1 ? $obj['limit'] * ( $obj['pagenum'] - 1 ) : 0;
    $args['showposts'] = $obj['limit'];
    
    $ajax_query = new WP_Query();
    $ajax_query->query( $args );

    // Begin Loop
    if ( $ajax_query->have_posts() ) {
        
        while ( $ajax_query->have_posts() ) {
            $ajax_query->the_post();
            if ( function_exists( 'meloo_get_taxonomies' ) ) {
                $cat_separator = '';
                $cat_link = false;

                if ( $module !== 'meloo_module1' ) {
                    $cat_separator = '';
                    $cat_link = true;
                }
                $tax_args = array(
                    'id'         => $ajax_query->post->ID,
                    'tax_name'   => 'category',
                    'separator'  => $cat_separator,
                    'link'       => $cat_link,
                    'limit'      => 2,
                    'show_count' => true

                );
                $cats_html = meloo_get_taxonomies( $tax_args );
            } else {
                $cats_html = '';
            }

            // Excerpt
            if ( isset( $obj['excerpt'] ) && $obj['excerpt'] === 'true' ) {
                if ( has_excerpt() ) {
                    $excerpt = wp_trim_words( get_the_excerpt(), 30, '' );
                } else {
                    $excerpt = wp_trim_words( strip_shortcodes( get_the_content() ), 30, '' ); 
                }
            } 

            $classes = array(
                'flex-col-1-' . esc_attr( $obj['limit'] ),
                'ajax-item',
                'small-module',
                $posts_nr
            );

            if ( function_exists( $module ) ) {

                $module_args = array( 
                    'post_id'     => $ajax_query->post->ID,
                    'thumb_size'  => $thumb_size,
                    'lazy'        => false,
                    'title'       => get_the_title(),
                    'permalink'   => get_permalink(),
                    'author'      =>  get_the_author_meta( 'display_name', $ajax_query->post->post_author ),
                    'date'        => get_the_time( $date_format ),
                    'posts_cats'  => $cats_html,
                    'excerpt'     => $excerpt,
                    'show_tracks' => 'yes',
                    'classes'     => implode(' ', $classes )
                );
                $output .= $module( $module_args );

            }
        } 
       
        $meloo_opts->e_esc( $output );

        die();
        return;
    } // end have_posts

    echo 'no_results';

    die();
    return;
    
}
add_action('wp_ajax_nopriv_meloo_posts_slider_ajax', 'meloo_posts_slider_ajax');
add_action('wp_ajax_meloo_posts_slider_ajax', 'meloo_posts_slider_ajax');
endif;


/* ==================================================
  Load More 
================================================== */
if ( ! function_exists( 'meloo_load_more' ) ) :
function meloo_load_more() {

    $meloo_opts = meloo_opts();

    $nonce       = $_POST['ajax_nonce'];
    $opts        = $_POST['opts'];
    $module_opts = $_POST['module_opts'];
    $filter      = $_POST['filter'];
    $output      = '';

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
        die( 'Busted!' );
    }
    if ( ! isset( $opts ) && ! isset( $module_opts ) ) {
        die();
    }

    // Date format
    $date_format = get_option( 'date_format' );

    // Begin Loop
    $args = meloo_prepare_wp_query( $filter, $opts['paged'] );

    $ajax_query = new WP_Query();
    $ajax_query->query( $args );

    // Check if this is the last page 
    $last_page = '';
    if ( intval( $args['paged'] ) === intval( $ajax_query->max_num_pages ) ) {
        $last_page = 'last-page';
    } 

    // Begin Loop
    if ( $ajax_query->have_posts() ) {
        
        while ( $ajax_query->have_posts() ) {
            $ajax_query->the_post();
            if ( function_exists( 'meloo_get_taxonomies' ) ) {
                $cat_separator = '';
                $cat_link = false;
                $tax_args = array(
                    'id'         => $ajax_query->post->ID,
                    'tax_name'   => 'category',
                    'separator'  => '',
                    'link'       => $cat_link,
                    'limit'      => 2,
                    'show_count' => true

                );
                $cats_html = meloo_get_taxonomies( $tax_args );
            } else {
                $cats_html = '';
            }

            // Excerpt
            if ( isset( $module_opts['excerpt'] ) && $module_opts['excerpt'] === 'true' ) {
                if ( has_excerpt() ) {
                    $excerpt = wp_trim_words( get_the_excerpt(), 30, '' );
                } else {
                    $excerpt = wp_trim_words( strip_shortcodes( get_the_content() ), 30, '' ); 
                }
            } 

            if ( function_exists( $module_opts['module'] ) ) {
                $output .= '<div class="flex-item ' . esc_attr( $last_page ) . '">';
                $module_args = array(
                    'post_id'       => $ajax_query->post->ID,
                    'thumb_size'    => $module_opts['thumb_size'],
                    'lazy'          => false,
                    'title'         => get_the_title(),
                    'permalink'     => get_permalink(),
                    'author'        =>  get_the_author_meta( 'display_name', $ajax_query->post->post_author ),
                    'date'          => get_the_time( $date_format ),
                    'posts_cats'    => $cats_html,
                    'excerpt'       => $excerpt,
                    'readmore'      => $module_opts['readmore'],
                    'classes'       => $module_opts['classes'],
                    'posts_classes' => implode( ' ', get_post_class( '', $ajax_query->post->ID ) ),
                );

                // Custom modules settings 
                if ( $module_opts['module'] === 'meloo_music_module1' 
                    || $module_opts['module'] === 'meloo_music_module2' ) {
                    $module_args['show_tracks'] = $module_opts['show_tracks'];
                }
                if ( $module_opts['module'] === 'meloo_video_module1'  ) {
                    $module_args['ca'] = $module_opts['ca'];
                    
                }
                $output .= $module_opts['module']( $module_args );
                $output .= '</div>';
            }
  
        } 
        $meloo_opts->e_esc( $output );

        die();
        return;
    } // end have_posts

    echo 'no_results';

    die();
    return;
    
}
add_action('wp_ajax_nopriv_meloo_load_more', 'meloo_load_more');
add_action('wp_ajax_meloo_load_more', 'meloo_load_more');
endif;