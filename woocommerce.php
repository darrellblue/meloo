<?php
/**
 * Theme Name:    Meloo
 * Theme Author:  Mariusz Rek - Rascals Themes
 * Theme URI:     http://rascalsthemes.com/meloo
 * Author URI:    http://rascalsthemes.com
 * File:          woocommerce.php
 * @package meloo
 * @since 1.0.0
 */

get_header();

// Get theme options
$meloo_opts = meloo_opts();

// Backup Main Query 
$temp_post = $post;
$query_temp = $wp_query;

// Shop id 
$shop_id = get_option( 'woocommerce_shop_page_id' );

// Disable header 
$disable_header = false;

// Get layout 
$page_layout = get_post_meta( $shop_id, '_page_layout', true );
$page_layout = ( $page_layout !== '' ? $page_layout : 'wide' );

// Is product 
if ( is_product() ) {
    $page_layout = 'wide';
}

// Set classes and variables 
$is_page_builder = false;
$sidebar = false;
$content_classes = array(
    'content'
);
$container_classes = array(
    'container'
);
if ( $page_layout === 'narrow' ) {
    array_push( $content_classes, 'page-layout-' . $page_layout );
    $container_classes[] = 'small';
} else if ( $page_layout === 'wide' ) {
    array_push( $content_classes, 'page-layout-' . $page_layout );
    $container_classes[] = 'wide';
} else if ( $page_layout === 'left_sidebar' ) {
    $sidebar = true;
    array_push( $content_classes, 'page-layout-' . $page_layout, 'layout-style-1', 'sidebar-on-left' );
} else if ( $page_layout === 'right_sidebar' ) {
    $sidebar = true;
    array_push( $content_classes, 'page-layout-' . $page_layout, 'layout-style-1', 'sidebar-on-right' );
} 

// Remove default page title 
add_filter('woocommerce_show_page_title', 'meloo_override_page_title');
if ( ! function_exists( 'meloo_override_page_title' ) ) {
    function meloo_override_page_title() {
        return false;
    }
}

if ( $page_layout === 'page_builder' && class_exists( 'KingComposer' ) ) {
    $is_page_builder = true;
    $disable_header = get_post_meta( $shop_id, '_disable_header', true );
    $disable_header = ( $disable_header === '' ? false : filter_var( $disable_header, FILTER_VALIDATE_BOOLEAN ) );
}
?>

<?php if ( is_shop() ) : ?>

    <?php if ( ! $disable_header ) : ?>
        <div class="page-header default-image-header">
            <h1><?php echo get_the_title( $shop_id ) ?></h1>
        </div>
    <?php endif; ?>

    <?php if ( $is_page_builder === true ) : ?>

        <?php 

        $content_classes[] = 'page-builder-top';
        ?>
        <div class="content-full">
            <div class="container-full">
               <?php echo kc_do_shortcode( get_post_field( 'post_content_filtered', $shop_id ) );  ?>
            </div>
        </div>

    <?php endif; ?>

<?php endif; ?>

<div class="<?php echo esc_attr( implode(' ', $content_classes ) ) ?>">
    <div class="<?php echo esc_attr( implode(' ', $container_classes ) ) ?>">
        <div class="main">
            <?php if ( is_singular( 'product' ) ) : ?>
                <?php 
                  while ( have_posts() ) :
                    the_post();
                    wc_get_template_part( 'content', 'single-product' );
                  endwhile;
                ?>
            <?php else : ?>
                <?php if ( woocommerce_product_loop() ) : ?>

                    <?php do_action( 'woocommerce_before_shop_loop' ); ?>

                    <?php woocommerce_product_loop_start(); ?>

                    <?php if ( wc_get_loop_prop( 'total' ) ) : ?>
                        <?php while ( have_posts() ) : ?>
                            <?php the_post(); ?>
                            <?php wc_get_template_part( 'content', 'product' ); ?>
                        <?php endwhile; ?>
                    <?php endif; ?>

                    <?php woocommerce_product_loop_end(); ?>

                    <?php do_action( 'woocommerce_after_shop_loop' ); ?>

                <?php else : ?>

                    <?php do_action( 'woocommerce_no_products_found' ); ?>

                <?php endif;?>
            <?php endif;?>    
        </div>
        <?php if ( $sidebar ) : ?>
        <div class="sidebar sidebar-block">
            <div class="theiaStickySidebar">
                <?php get_sidebar( 'shop' ); ?>
            </div>
        </div>
        <?php endif; ?>
    </div> <!-- .container -->
</div> <!-- .content -->

<?php

// Restore query 
$post = $temp_post;
$wp_query = $query_temp;

// Get footer
get_footer();