<?php
/**
 * Theme Name:      Meloo
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascalsthemes.com/meloo
 * Author URI:      http://rascalsthemes.com
 * File:            header-style1.php
 * @package meloo
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Get options
$meloo_opts = meloo_opts();
    
// Helpers

// Color Scheme
$header_color_scheme =  get_theme_mod( 'header_color_scheme', 'dark' );

// Defaults values for social icons
$header_social_defaults = array(
    array(
        'social_type' => 'facebook',
        'social_link'  => '#',
    ),
    array(
        'social_type' => 'twitter',
        'social_link'  => '#',
    ),
    array(
        'social_type' => 'soundcloud',
        'social_link'  => '#',
    ),
    array(
        'social_type' => 'mixcloud',
        'social_link'  => '#',
    ),
    array(
        'social_type' => 'spotify',
        'social_link'  => '#',
    )
);


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

if ( class_exists( 'MelooToolkitSuperMenu' ) ) {
    $defaults_main['walker'] = new MelooToolkitSuperMenu();
}
?>
<div id="header-wrap">
    <div id="header" class="header header-transparent <?php echo esc_attr(  $header_color_scheme ) ?>-scheme-el">

        <!-- Search --> 
        <div id="search-block">
            <?php get_search_form(); ?>
        </div>
        <!-- /search -->

        <!-- Social --> 
        <div id="social-block">
            <h6 class="social-title trans-10 show-fx">Follow Me</h6>
            <div class="social-icons trans-10 show-fx delay-01">
                <?php
                if ( function_exists( 'meloo_social_buttons' ) ) {
                    echo meloo_social_buttons( get_theme_mod( 'header_social_buttons', $header_social_defaults ) );
                }
                ?>
            </div>
            
        </div>
        <!-- /share icons -->

        <!-- Nav Block --> 
        <div class="nav-block">
            <div class="nav-container">

                <!-- Logo -->
                <div id="site-logo" class="header-logo">
                    <?php

                    $logo_path = get_template_directory_uri() . '/images';
                    
                    if ( $header_color_scheme === 'dark' ) {
                        $default_logo_img =  $logo_path . '/logo-light.svg';
                        $default_logo_hero = $logo_path . '/logo-light.svg';
                    } else {
                        $default_logo_img =  $logo_path . '/logo-dark.svg';
                        $default_logo_hero = $logo_path . '/logo-light.svg';
                    }

                    if ( get_theme_mod( 'logo_hero' ) ) {
                        $has_hero_logo = 'has-logo-hero';
                    } else {
                        $has_hero_logo = '';
                    }

                    echo '<a href="' . esc_url( home_url('/') ) . '" class="theme-logo ' . esc_attr( $has_hero_logo ) . '">';
                    if ( get_theme_mod( 'logo' ) ) {
                        echo '<img src="' . esc_url( get_theme_mod( 'logo' ) ) . '" class="theme-logo-img" alt="' . esc_attr__( 'Logo Image', 'meloo' ) . '">';
                    } else {
                        echo '<img src="' . esc_url( $default_logo_img ) . '" class="theme-logo-img" alt="' . esc_attr__( 'Logo Image', 'meloo' ) . '">';
                    }
                    if ( get_theme_mod( 'logo_hero' ) ) {
                        echo '<img src="' . esc_url( get_theme_mod( 'logo_hero' ) ) . '" class="theme-logo-hero-img" alt="' . esc_attr__( 'Logo Image', 'meloo' ) . '">';
                    }

                    echo '</a>';
                    ?>
                </div>
                
                <!-- Icon nav -->
                <div id="icon-nav">
                    <ul>
                        <li class="responsive-trigger-wrap"><a href="#" class="circle-btn responsive-trigger">
                            <svg class="circle-svg" width="40" height="40" viewBox="0 0 50 50">
                                <circle class="circle" cx="25" cy="25" r="23" stroke="#fff" stroke-width="1" fill="none"></circle>
                            </svg>
                            <span class="icon"></span>
                            </a>
                        </li>
                        <?php if ( $meloo_opts->get_option('scamp_player') === 'on' && function_exists( 'meloo_toolkit' ) && meloo_toolkit( 'scamp_player' ) ) : ?>
                        <li class="player-trigger-wrap"><a href="#show-player" class="nav-player-btn circle-btn">
                            <svg class="circle-svg" width="40" height="40" viewBox="0 0 50 50">
                                <circle class="circle" cx="25" cy="25" r="23" stroke="#fff" stroke-width="1" fill="none"></circle>
                                <circle class="circle-bg" cx="25" cy="25" r="23" stroke="#fff" stroke-width="1" fill="none"></circle>
                            </svg>
                            <span class="pe-7s-musiclist"></span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <!-- Cart -->
                        <?php if ( get_theme_mod( 'cart_button', false ) ) : ?>
                            <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                                <?php 
                                    $count = WC()->cart->get_cart_contents_count();
                                    $wc_link = wc_get_cart_url();
                                ?>
                                <li class="shop-trigger-wrap"><a href="<?php echo esc_url( $wc_link ) ?>" class="cart-link circle-btn">
                                    <svg class="circle-svg" width="40" height="40" viewBox="0 0 50 50">
                                        <circle class="circle" cx="25" cy="25" r="23" stroke="#fff" stroke-width="1" fill="none"></circle>
                                    </svg>
                                    <span class="pe-7s-cart"></span>
                                    <span class='shop-items-count'><i><?php echo esc_attr( $count ) ?></i></span></a>
                                </li>
                            <?php endif ?>
                        <?php endif ?>
                        <?php if ( get_theme_mod( 'search_button', true ) ) : ?>
                        <li class="search-trigger-wrap"><a href="#" id="nav-search" class="circle-btn">
                            <svg class="circle-svg" width="40" height="40" viewBox="0 0 50 50">
                                <circle class="circle" cx="25" cy="25" r="23" stroke="#fff" stroke-width="1" fill="none"></circle>
                            </svg>
                            <span class="pe-7s-search"></span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if ( function_exists( 'meloo_toolkit' ) && meloo_toolkit() ) : ?>
                        <li class="social-trigger-wrap"><a href="#" id="nav-social" class="circle-btn">
                            <svg class="circle-svg" width="40" height="40" viewBox="0 0 50 50">
                                <circle class="circle" cx="25" cy="25" r="23" stroke="#fff" stroke-width="1" fill="none"></circle>
                            </svg>
                            <span class="pe-7s-share"></span>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <!-- Main navs -->
                <?php if ( has_nav_menu( 'main' ) ) : ?>
                    <nav id="nav-main" class="nav-horizontal">
                        <?php wp_nav_menu( $defaults_main ); ?>
                    </nav>
                <?php endif; ?>
                
            </div>
        </div>
    </div>
</div>