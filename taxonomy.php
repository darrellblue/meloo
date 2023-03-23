<?php
/**
 * Theme Name:      Meloo
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascalsthemes.com/meloo
 * Author URI:      http://rascalsthemes.com
 * File:            taxonomy.php
 * @package meloo
 * @since 1.0.0
 */

get_header();

// Get options
$meloo_opts = meloo_opts();
    
// Copy query 
$temp_post = $post;
$query_temp = $wp_query;

$more = 0;

// Get layout 
$articles_layout = get_theme_mod( 'category_layout', 'narrow' );

// Get loop block 
$block = get_theme_mod( 'category_block', 'term' );

$block_option = '';

switch ($block) {
    case 'block4':
        $block = 'block4';
        $block_option = '4';
        break;
    case 'block5':
        $block = 'block4';
        $block_option = '3';
        break;
    case 'block6':
        $block = 'block4';
        $block_option = '2';
        break;
    case 'block7':
        $block = 'block5';
        $block_option = '2';
        break;
    case 'block8':
        $block = 'block6';
        $block_option = '4';
        break;
    case 'block9':
        $block = 'block6';
        $block_option = '3';
        break;
    case 'block10':
        $block = 'block6';
        $block_option = '2';
        break;
    case 'block11':
        $block = 'block7';
        $block_option = '2';
        break;
}

// If Gallery 
if ( is_tax( 'meloo_gallery_cats' ) )  {
    $block = 'gallery-block1';
    $block_option = '3';
    $articles_layout = 'wide';
}
// Music 
elseif ( is_tax( 'meloo_music_cats' ) )  {
    $block = 'music-block1';
    $block_option = '3';
    $articles_layout = 'wide';

}
// Events 
elseif ( is_tax( 'meloo_events_cats' ) )  {
    $block = 'events-block2';
    $block_option = '3';
    $articles_layout = 'wide';

}
// Videos 
elseif ( is_tax( 'meloo_videos_cats' ) )  {
    $block = 'videos-block1';
    $block_option = '3';
    $articles_layout = 'wide';

}

 // Set classes and variables
 
$sidebar = false;
$content_classes = array(
    'content page-template-simple',
);
$container_classes = array(
    'container'
);
if ( $articles_layout === 'narrow' ) {
    array_push( $content_classes, 'page-layout-' . $articles_layout );
    $container_classes[] = 'small';
} else if ( $articles_layout === 'wide' ) {
    array_push( $content_classes, 'page-layout-' . $articles_layout );
    $container_classes[] = 'wide';
} else if ( $articles_layout === 'left_sidebar' ) {
    $sidebar = true;
    array_push( $content_classes, 'page-layout-' . $articles_layout, 'layout-style-1', 'sidebar-on-left' );
} else if ( $articles_layout === 'right_sidebar' ) {
    $sidebar = true;
    array_push( $content_classes, 'page-layout-' . $articles_layout, 'layout-style-1', 'sidebar-on-right' );
}

?>

<div class="page-header default-image-header">
    <span class="term-name"><?php _e( 'Category', 'meloo' ) ?></span>
    <h1>
        <?php echo single_cat_title( '', false ); ?>
    </h1>
</div>


<div class="<?php echo esc_attr( implode(' ', $content_classes ) ) ?>">


    <div class="<?php echo esc_attr( implode(' ', $container_classes ) ) ?>">

        <div class="main">
            <?php
            
                if ( have_posts() ) : ?>

                    <?php

                        // Render loop block
                        set_query_var( 'block_option', $block_option );
                        get_template_part( 'partials/loop', $block );
                        
                    ?>
                    <div class="clear"></div>
                    <?php 

                    // Pagination  
                    meloo_paging_nav();
                   
                    ?>
                <?php else : ?>
                    <p><?php esc_html_e( 'It seems we can not find what you are looking for.', 'meloo' ); ?></p>

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

// Restore query 
$post = $temp_post;
$wp_query = $query_temp;

// Get footer
get_footer();