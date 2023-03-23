<?php
/**
 * Theme Name:      Meloo
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascalsthemes.com/meloo
 * Author URI:      http://rascalsthemes.com
 * File:            search.php
 * @package meloo
 * @since 1.0.0
 */

get_header();

// Get options
$meloo_opts = meloo_opts();

// Get layout 
$articles_layout = get_theme_mod( 'search_layout', 'narrow' );

// Get loop block 
$block = 'search';

// Set classes and variables
$sidebar = false;
$content_classes = array(
    'content',
    'is-hero'
);
$container_classes = array(
    'container'
);
if ( $articles_layout === 'narrow' ) {
    array_push( $content_classes, 'page-layout-' . $articles_layout, 'gradient-bg' );
    $container_classes[] = 'small';
} else if ( $articles_layout === 'wide' ) {
    array_push( $content_classes, 'page-layout-' . $articles_layout, 'gradient-bg' );
    $container_classes[] = 'wide';
} else if ( $articles_layout === 'left_sidebar' ) {
    $sidebar = true;
    array_push( $content_classes, 'page-layout-' . $articles_layout, 'gradient-bg', 'layout-style-1', 'sidebar-on-left' );
} else if ( $articles_layout === 'right_sidebar' ) {
    $sidebar = true;
    array_push( $content_classes, 'page-layout-' . $articles_layout, 'gradient-bg', 'layout-style-1', 'sidebar-on-right' );
}

?>

<div class="page-header default-image-header">
    <span class="term-name"><?php _e( 'Search', 'meloo' ) ?></span>
    <h1><?php echo get_search_query() ?></h1>
</div>

<div class="<?php echo esc_attr( implode(' ', $content_classes ) ) ?>">
    <div class="<?php echo esc_attr( implode(' ', $container_classes ) ) ?>">

        <div class="main">
            <?php if ( have_posts() ) : ?>
                <?php

                // Render loop block
                get_template_part( 'partials/loop', $block );
                    
                ?>
                <div class="clear"></div>
                <?php 

                // Pagination  
                meloo_paging_nav();
               
                ?>
            <?php else : ?>
                <div class="search-404">
                    <h6 class="big-text"><?php esc_html_e( 'Oops...', 'meloo' ) ?></h6>
                    <h4 class="no-margin"><?php esc_html_e( 'It seems we can not find what you are looking for.', 'meloo' ); ?></h4>
                    <p><?php esc_html_e( 'How about trying our search', 'meloo' ) ?></p>
                    <p id="search-404-form">
                        <?php get_search_form(); ?>
                    </p>
                </div>

            <?php endif; // have_posts() ?>
        </div>  <!-- .main -->

        <?php if ( $sidebar ) : ?>
            <div class="sidebar sidebar-block">
                <div class="theiaStickySidebar">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div> <!-- .container -->
</div> <!-- .content -->

<?php

// Get footer
get_footer();