<?php
/**
 * Theme Name:      Meloo
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascalsthemes.com/meloo
 * Author URI:      http://rascalsthemes.com
 * File:            sidebar-custom.php
 * @package meloo
 * @since 1.0.0
 */

// Get options
$meloo_opts = meloo_opts();

// Get custom sidebar
$custom_sidebar = get_post_meta( $wp_query->post->ID, '_custom_sidebar', true );
?>
	
<aside class="sidebar">
    <?php if ( $custom_sidebar === '' || $custom_sidebar === '_default' ) : ?>
        <?php if ( is_active_sidebar( 'primary-sidebar' )  ) : ?>
            <?php dynamic_sidebar( 'primary-sidebar' ); ?>
        <?php endif; ?>
    <?php else : ?>
        <?php if ( is_active_sidebar( $custom_sidebar )  ) : ?>
            <?php dynamic_sidebar( $custom_sidebar ) ?> 
        <?php endif; ?>
    <?php endif; ?>
</aside>