<?php
/**
 * Theme Name:      Meloo
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascalsthemes.com/meloo
 * Author URI:      http://rascalsthemes.com
 * File:            header.php
 * @package meloo
 * @since 1.0.0
 */

// Get options
$meloo_opts = meloo_opts();

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>
<?php 
    $page_id = '0';

    if ( isset( $wp_query ) && isset( $post ) ) {
        $page_id = $wp_query->post->ID;
    }
?>
<body <?php body_class() ?> data-page_id="<?php echo esc_attr( $page_id ) ?>" data-wp_title="<?php esc_attr( wp_title( '|', true, 'right' ) ) ?>">


<?php if ( ! is_customize_preview()  ) : ?>
    <?php if ( $meloo_opts->get_option( 'ajaxed' ) && $meloo_opts->get_option( 'ajaxed' ) === 'on' ) {

        if ( get_theme_mod( 'loading_animation', true ) ) {
            $loader_style = get_theme_mod( 'loader_style', 'bars' );

            if ( $loader_style === 'bars' ) {
                echo meloo_wpal_bars_loader();
            } else if ( $loader_style === 'stripes' ) {
                echo meloo_wpal_stripes_loader();
            }
        } else {
            echo '<div id="wpal-loader" class="wpal-loading-simple show-layer"></div>';
        }

    } ?>
<?php endif; ?>

<?php 
    // Get Custom Header
    get_template_part( 'partials/' . esc_html( get_theme_mod( 'header_style', 'header-style1' ) ) );
?>


<?php 
$mobile_color_scheme = get_theme_mod( 'mobile_nav_color_scheme', 'dark' );

?>
<div id="slidebar" class="<?php echo esc_attr( $mobile_color_scheme ) ?>-scheme-el">
    <div class="slidebar-block">
        <div class="slidebar-content">
            <div class="slidebar-close-block">
                <a href="#" id="slidebar-close"></a>
            </div>
            <div class="slidebar-logo-block">
                <div id="slidebar-logo">
                    <?php
                        
                        $logo_path = get_template_directory_uri() . '/images';
                        if ( $mobile_color_scheme === 'dark' ) {
                            $default_logo_img =  $logo_path . '/logo-light.svg';
                        } else {
                            $default_logo_img =  $logo_path . '/logo-dark.svg';
                        }
                        echo '<a href="' . esc_url( home_url('/') ) . '">';
                        if ( get_theme_mod( 'logo_mobile' ) ) {
                            echo '<img src="' . esc_url( get_theme_mod( 'logo_mobile' ) ) . '" class="theme-logo-img" alt="' . esc_attr__( 'Logo Image', 'meloo' ) . '">';
                        } else {
                            echo '<img src="' . esc_url( $default_logo_img ) . '" alt="' . esc_attr__( 'Logo Image', 'meloo' ) . '">';
                        }
                        echo '</a>';
                     ?>
                 </div>
            </div>
            <?php
            // Defaults values for top navigation
            $defaults_main = array(
                'theme_location'  => 'main',
                'menu'            => '',
                'container'       => false,
                'container_class' => '',
                'menu_class'      => 'menu',
                'fallback_cb'     => 'wp_page_menu',
                'depth'           => 3
            ); 
            ?>
            
            <nav id="nav-sidebar">
                <?php wp_nav_menu( $defaults_main ); ?>
            </nav>

        </div>
    </div>
     
</div> <!-- #slidebar -->


<div class="site">
    <div id="ajax-container">
        <?php
        
        // Background 
        $bg = '';
        if ( isset( $wp_query->post->ID ) ) {
            if ( is_page() || is_single() || ( class_exists( 'WooCommerce' ) && is_shop() ) ) {
               
                $content_bg = get_post_meta( $wp_query->post->ID, '_content_bg', true );
                if ( class_exists( 'WooCommerce' ) ) {
                     // Shop id
                    $shop_id = get_option( 'woocommerce_shop_page_id' );
                    if ( is_shop() ) {

                        $content_bg = get_post_meta( $shop_id, '_content_bg', true );
                    }
                }
                if ( function_exists( 'meloo_get_background' ) && meloo_get_background( $content_bg ) ) {
                    $bg = meloo_get_background( $content_bg );
                } 
            }
        }
        ?>
        <div id="ajax-content" style="<?php echo esc_attr( $bg ); ?>">