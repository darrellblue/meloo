<?php
/**
 * Theme Name:      Meloo
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascalsthemes.com/meloo
 * Author URI:      http://rascalsthemes.com
 * File:            post-sharing.php
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

// Has Reviews 
$has_reviews = get_post_meta( $wp_query->post->ID, '_has_reviews', true );

if ( $has_reviews ) {
    
    // Rating 
    $rating = get_post_meta( $wp_query->post->ID, '_rating', true );
}

?>

<div class="post-meta-top">
    <div class="post-header-cats cats-style">
    	<?php if ( function_exists( 'meloo_get_taxonomies' ) ) {
            $tax_args = array(
                'id'         => $wp_query->post->ID,
                'tax_name'   => 'category',
                'separator'  => ' / ',
                'link'       => true,
                'limit'      => 200,
                'show_count' => true
            );
            echo meloo_get_taxonomies( $tax_args );
        } ?>
    </div><span class="date"><?php echo get_the_time( $date_format, $wp_query->post->ID ); ?></span>
</div>
<h1><?php echo get_the_title( $wp_query->post->ID ) ?></h1>
<?php 
    if ( $has_reviews ) { 
        if ( function_exists( 'meloo_get_stars_rating' ) ) {
            echo meloo_get_stars_rating( $rating );
        }
    }
?>