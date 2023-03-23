<?php
/**
 * Theme Name:      Meloo
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascalsthemes.com/meloo
 * Author URI:      http://rascalsthemes.com
 * File:            admin-plugins.php
 * @package meloo
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ==================================================
  Plugins 
================================================== */


/* King Composer License
 -------------------------------- */
define( 'KC_LICENSE', 'l483kg4m-jxbv-ju7k-or7h-yhgd-q3jl1ec3fqyi' );
if ( false === ( get_transient( 'kc_pdk' ) ) ) {
	delete_option ('kc_tkl_pdk');
	set_transient( 'kc_pdk', true, 12 * HOUR_IN_SECONDS ); // 12 * HOUR_IN_SECONDS
}


/* TGMPA Activation Class
 -------------------------------- */
require_once( 'classes/class-tgm-plugin-activation.php' );

add_action( 'tgmpa_register', 'meloo_register_required_plugins', 1 );

function meloo_register_required_plugins() {

	$plugins = array(
 		
 		/**
		 * Pre-packaged Plugins
		*/
		array(  	
			'name'                  => esc_html__( 'Meloo Toolkit', 'meloo' ), // The plugin name
			'slug'                  => 'meloo-toolkit', // The plugin slug (typically the folder name)
			'source'                => get_template_directory() . '/admin/plugins/meloo-toolkit.zip', // The plugin source
			'required'              => true, // If false, the plugin is only 'recommended' instead of required
			'version'               => '1.1.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'          => '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'                  => esc_html__( 'KC Pro! - Frontend Page Builder', 'meloo' ), // The plugin name
			'slug'                  => 'kc_pro', // The plugin slug (typically the folder name)
			'source'                => get_template_directory() . '/admin/plugins/kc_pro.zip', // The plugin source
			'required'              => false, // If false, the plugin is only 'recommended' instead of required
			'version'               => '1.9.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'          => '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'               => esc_html__( 'Slider Revolution', 'meloo' ), // The plugin name
			'slug'               => 'revslider', // The plugin slug (typically the folder name)
			'source'             => get_template_directory() . '/admin/plugins/revslider.zip', // The plugin source
			'required'           => false, // If false, the plugin is only 'recommended' instead of required
			'version'            => '6.2.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'       => '', // If set, overrides default API URL and points to an external URL
		),


		/**
		 * WordPress.org Plugins
		 */
		array(
			'name'               => esc_html__( 'King Composer', 'meloo' ), // The plugin name
			'slug'               => 'kingcomposer', // The plugin slug (typically the folder name)
			'required'           => true, // If false, the plugin is only 'recommended' instead of required
		),
		array(
			'name'               => esc_html__( 'Kirki - Theme Customizer', 'meloo' ), // The plugin name
			'slug'               => 'kirki', // The plugin slug (typically the folder name)
			'required'           => false, // If false, the plugin is only 'recommended' instead of required
		),
		array(
			'name'               => esc_html__( 'Contact Form 7', 'meloo' ), // The plugin name
			'slug'               => 'contact-form-7', // The plugin slug (typically the folder name)
			'required'           => false, // If false, the plugin is only 'recommended' instead of required
		),
		array(
			'name'               => esc_html__( 'MailChimp for WordPress', 'meloo' ), // The plugin name
			'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name)
			'required'           => false, // If false, the plugin is only 'recommended' instead of required
		),
 		array(
			'name'               => esc_html__( 'Safe SVG - Support for SVG files', 'meloo' ), // The plugin name
			'slug'               => 'safe-svg', // The plugin slug (typically the folder name)
			'required'           => false, // If false, the plugin is only 'recommended' instead of required
		),
		array(
			'name'               => esc_html__( 'WooCommerce', 'meloo' ), // The plugin name
			'slug'               => 'woocommerce', // The plugin slug (typically the folder name)
			'required'           => false, // If false, the plugin is only 'recommended' instead of required
		)
		
   );
 
	// Change this to your theme text domain, used for internationalising strings
	$theme_text_domain = 'meloo';
 
	$config = array(
		'id'           => 'rascals_plugins',
		'domain'       => 'meloo',           // Text domain - likely want to be the same as your theme.
		'default_path' => '',                           // Default absolute path to pre-packaged plugins
		'parent_slug'  => 'admin-page',
		'menu'         => 'admin-plugins',
		'has_notices'  => true,                         // Show admin notices or not
		'is_automatic' => false,            // Automatically activate plugins after installation or not
		'message'      => '',               // Message to output right before the plugins table
		'strings' => array(
			'page_title' => esc_html__( 'Install Theme Plugins', 'meloo' ),
			'menu_title' => esc_html__( 'Plugins', 'meloo' ),
			'desc' => esc_html__( 'Install the included plugins with bottom panel. All the plugins are well tested to work with the theme and we keep them up to date. The themes comes packed with the following plugins:', 'meloo' ),
		),
	);
 
	tgmpa( $plugins, $config );
 
}
