<?php
/**
 * Theme Name:      Meloo
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascalsthemes.com/meloo
 * Author URI:      http://rascalsthemes.com
 * File:            admin-welcome.php
 * @package meloo
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

meloo_admin_page_header();
	
$theme = wp_get_theme(); ?>

<div class="rascals-admin-wrap about-wrap">

    <?php 
    if ( function_exists( 'meloo_admin_notices' ) ) {
        echo meloo_admin_notices();
    }
    ?>

    <div class="rascals-welcome-header">
        <h1><?php esc_html_e( 'Welcome to', 'meloo' ) ?> <?php echo esc_html( $theme->get( 'Name' ) ); ?> <span class="rascals-version">v <?php echo esc_html( $theme->get( 'Version' ) ); ?></span></h1>
        <div class="about-text">
            <?php esc_html_e( 'Thank you for using our theme! We\'re glad that you found what you were looking for. Hope you have as much fun using it as we did creating it. You could have chosen any other theme, but we appreciate that you have stuck with us.' , 'meloo' ); ?> 
        </div>
    </div>
    <hr>
    <div class="feature-section two-col">
    	<div class="col">
    		<h3>Getting started</h3>
    		<p><?php esc_html_e( 'If you are new to WordPress it can be a lot to take in all at once. Thankfully the Internet is an amazing place for learning. Getting started with our theme starts with installing plugins from our' , 'meloo' ); ?> <a href="admin.php?page=admin-plugins"><?php esc_html_e( 'plugins panel' , 'meloo' ); ?></a></p>
    		<p>
    			<a href="admin.php?page=admin-demos"><?php esc_html_e( 'Chose a demo' , 'meloo' ); ?></a> <?php esc_html_e( 'and click install. It is that simple! Everything you see in the Demo of your choice gets installed along with your new WordPress site. We have made this as simple and as complete as possible so that you can be up and running with your new website and all the features you fell in love with in as little time as possible.' , 'meloo' ); ?>

    		</p>
    		
    	</div>
		<div class="col">
			<img src="<?php echo esc_url( get_template_directory_uri() ) ?>/screenshot.png">
		</div>

    </div>
</div>