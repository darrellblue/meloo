<?php
/**
 * Theme Name:      Meloo
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascalsthemes.com/meloo
 * Author URI:      http://rascalsthemes.com
 * File:            post-related-posts.php
 * @package meloo
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Get options
$meloo_opts = meloo_opts();

/* Related Posts */
$related_posts = get_theme_mod( 'related_posts', '0' );

/* Author Box */
if ( get_theme_mod( 'related_posts', '0' ) === true ) {
	$related_posts = get_post_meta( $wp_query->post->ID, '_related_posts', true );
} 

$rp_display_by = get_post_meta( $wp_query->post->ID, '_rp_display_by', true );
$rp_display_by = ( $rp_display_by === '' ? get_theme_mod( 'rp_display_by', true ) : $rp_display_by );

$rp_show_nav = get_post_meta( $wp_query->post->ID, '_rp_show_nav', true );
$rp_show_nav = ( $rp_show_nav === '' ? get_theme_mod( 'rp_show_nav', true ) : filter_var( $rp_show_nav, FILTER_VALIDATE_BOOLEAN ) );

if ( $related_posts && function_exists( 'meloo_block_rp' ) ) {
	// Display Related Posts 
	echo meloo_block_rp( array(
		'post_id'         => $wp_query->post->ID,
		'display_by'      => $rp_display_by, // tags, categories
		'limit'           => 2,
		'show_navigation' => $rp_show_nav,
		'module'          => 'meloo_module1',
		'thumb_size'      => 'meloo-medium-square-thumb',
		'excerpt'         => false,
		'classes'         => 'small-gap'
		)
	);
}

?>