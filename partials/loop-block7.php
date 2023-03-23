<?php
/**
 * Theme Name:      Meloo
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascalsthemes.com/meloo
 * Author URI:      http://rascalsthemes.com
 * File:            loop-block7.php
 * @package meloo
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Get options
$meloo_opts = meloo_opts();

// Date Format 
$date_format = get_option( 'date_format' );

// Module classes 
$classes = array(
   	'post-grid-module',
	'small-module',
);

// Set color scheme 
$color_scheme = get_theme_mod( 'color_scheme', 'dark' );
$classes[] = $color_scheme . '-scheme-el';

// Module Opts 
$module_opts = array(
	'module'     => 'meloo_module4',
	'excerpt'    => '',
	'thumb_size' => 'meloo-large-square-thumb',
	'excerpt'    => true,
	'readmore'   => 'yes',
	'classes'    => implode( ' ', $classes )
);
?>

<div data-module-opts='<?php echo json_encode( $module_opts ) ?>' class="ajax-grid flex-grid flex-2 flex-tablet-2 flex-mobile-2 flex-mobile-portrait-1 flex-gap-medium flex-anim flex-anim-fadeup posts-container">

<?php
// Start Loop 
while ( have_posts() ) {

	the_post();

	$index = $wp_query->current_post + 1;

	$separator = ' ';
	$thumb_size = 'meloo-large-square-thumb';
	$module = 'meloo_module4'; 

	// Module classes
	$classes = array(
	    'post-grid-module',
	);
	$classes[] = $color_scheme . '-scheme-el';
	
	$max_pages = $wp_query->max_num_pages+1;

	// Get arguments only for the first post
	if ( $index == 1 or ( ( $max_pages % 2 == 0 ) && ( $index == $max_pages ) ) ) {
		$thumb_size = 'meloo-content-thumb';
		$module     = 'meloo_module2';
		$classes[]  = 'post-list-module';
		$separator  = '';
	}

	// Get taxonomies
	if ( function_exists( 'meloo_get_taxonomies' ) ) {
	    $tax_args = array(
			'id'         => $wp_query->post->ID,
			'tax_name'   => 'category',
			'separator'  => $separator,
			'link'       => true,
			'limit'      => 2,
			'show_count' => true
	    );
	    $cats_html = meloo_get_taxonomies( $tax_args );
	} else {
	    $cats_html = '';
	}

	// Excerpt 
	if ( has_excerpt() ) {
	    $excerpt = wp_trim_words( get_the_excerpt(), 20, ' ...' );
	} else {
	    $excerpt = wp_trim_words( strip_shortcodes( get_the_content() ), 20, ' ...' ); 
	}

	// Module arguments 
	if ( function_exists( $module ) ) {

		if ( $module == 'meloo_module2' ) {
			echo '<div class="flex-item-fw">';
		} else {
			echo '<div class="flex-item">';
			$classes[] = 'post-grid-module';
			$classes[] = 'small-module';
			$excerpt = false;
		} 
		
	    $meloo_opts->e_esc( $module( array(
			'post_id'       => $wp_query->post->ID,
			'thumb_size'    => $thumb_size,
			'lazy'          => true,
			'title'         => get_the_title(),
			'permalink'     => get_permalink(),
			'author'        => get_the_author_meta( 'display_name', $wp_query->post->post_author ),
			'date'          => get_the_time( $date_format ),
			'posts_cats'    => $cats_html,
			'classes'       => implode(' ', $classes ),
			'posts_classes' => implode( ' ', get_post_class( '', $wp_query->post->ID ) ),
			'excerpt'       => $excerpt,
			'readmore'      => 'yes'
	    ) ) );
	    echo '</div>';
		
	}
}
?>
</div>