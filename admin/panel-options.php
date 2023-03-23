<?php
/**
 * Theme Name:      Meloo
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascalsthemes.com/meloo
 * Author URI:      http://rascalsthemes.com
 * File:            panel-options.php
 * @package meloo
 * @since 1.0.0
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


$ad_desc = esc_html__( 'Paste your custom AD code. Below below are all available codes that can be used to display ads, there are two options:', 'meloo' ) .
'<br><br><strong>' . esc_html__( '1. Show the same ad on every device:', 'meloo' ) . '</strong><br>
<pre>&#x3C;div class="show-on-all-devices">
    Your AD Code - This ad will show on all devices
&#x3C;/div></pre>
<strong>' . esc_html__( '2. Show different ads depending on the device:', 'meloo' ) . '</strong><br>
<pre>&#x3C;div class="show-on-desktop">
    Your AD Code - This ad will show only on desktops
&#x3C;/div>
&#x3C;div class="show-on-tablet">
    Your AD Code - This ad will show only on tablets
&#x3C;/div>
&#x3C;div class="show-on-phone">
    Your AD Code - This ad will show only on phones
&#x3C;/div>
</pre>';


/* Options array */
$meloo_main_options = array( 


	/* ==================================================
	  Adwords
	================================================== */
	array( 
		'type' => 'open',
		'tab_name' => esc_html__( 'ADS', 'meloo' ),
		'tab_id' => 'ad',
		'icon' => 'bullhorn'
	),

		/* Header
		 -------------------------------- */
		array( 
			'type' => 'sub_open',
			'sub_tab_name' => esc_html__( 'Header', 'meloo' ),
			'sub_tab_id' => 'sub-ad-header'
		),

			// AD Code Type
			array(
				'name' => esc_html__( 'AD Code Type', 'meloo' ),
				'id' => 'ad_header_type',
				'type' => 'select',
				'std' => '',
				'options' => array( 
					array( 'name' => esc_html__( '- Select -', 'meloo' ), 'value' => ''),
					array( 'name' => esc_html__( 'Custom AD Code', 'meloo' ), 'value' => 'custom'),
					array( 'name' => esc_html__( 'Google AdSense Code', 'meloo' ), 'value' => 'adsense')
				),
				'desc' => esc_html__( 'Select type of AD that you want to show.', 'meloo' ),
			),

			// Custom
			array(
				'name' => esc_html__( 'Custom Code', 'meloo' ),
				'id' => 'ad_header_custom',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '',
				'height' => '240',
				'dependency' => array(
			        "element" => 'ad_header_type',
			        "value" => array( 'custom' )
			    ),
			    'desc' => $ad_desc
			),

			// AdSense
			array(
				'name' => esc_html__( 'AdSense Code', 'meloo' ),
				'id' => 'ad_header_adsense',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '',
				'height' => '120',
				'desc' => esc_html__( 'Paste your AdSense code here. ', 'meloo' ),
				'dependency' => array(
			        "element" => 'ad_header_type',
			        "value" => array( 'adsense' )
			    )
			),

			
		array( 
			'type' => 'sub_close'
		),


		/* Footer
		 -------------------------------- */
		array( 
			'type' => 'sub_open',
			'sub_tab_name' => esc_html__( 'Footer', 'meloo' ),
			'sub_tab_id' => 'sub-ad-footer'
		),

			// AD Code Type
			array(
				'name' => esc_html__( 'AD Code Type', 'meloo' ),
				'id' => 'ad_footer_type',
				'type' => 'select',
				'std' => '',
				'options' => array( 
					array( 'name' => esc_html__( '- Select -', 'meloo' ), 'value' => ''),
					array( 'name' => esc_html__( 'Custom AD Code', 'meloo' ), 'value' => 'custom'),
					array( 'name' => esc_html__( 'Google AdSense Code', 'meloo' ), 'value' => 'adsense')
				),
				'desc' => esc_html__( 'Select type of AD that you want to show.', 'meloo' ),
			),

			// Custom
			array(
				'name' => esc_html__( 'Custom Code', 'meloo' ),
				'id' => 'ad_footer_custom',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '',
				'height' => '240',
				'dependency' => array(
			        "element" => 'ad_footer_type',
			        "value" => array( 'custom' )
			    ),
			    'desc' => $ad_desc
			),

			// AdSense
			array(
				'name' => esc_html__( 'AdSense Code', 'meloo' ),
				'id' => 'ad_footer_adsense',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '',
				'height' => '240',
				'desc' => esc_html__( 'Paste your AdSense code here. ', 'meloo' ),
				'dependency' => array(
			        "element" => 'ad_footer_type',
			        "value" => array( 'adsense' )
			    )
			),

			
		array( 
			'type' => 'sub_close'
		),


		/* Article Top
		 -------------------------------- */
		array( 
			'type' => 'sub_open',
			'sub_tab_name' => esc_html__( 'Article Top', 'meloo' ),
			'sub_tab_id' => 'sub-ad-article-top'
		),

			// AD Code Type
			array(
				'name' => esc_html__( 'AD Code Type', 'meloo' ),
				'id' => 'ad_article_top_type',
				'type' => 'select',
				'std' => '',
				'options' => array( 
					array( 'name' => esc_html__( '- Select -', 'meloo' ), 'value' => ''),
					array( 'name' => esc_html__( 'Custom AD Code', 'meloo' ), 'value' => 'custom'),
					array( 'name' => esc_html__( 'Google AdSense Code', 'meloo' ), 'value' => 'adsense')
				),
				'desc' => esc_html__( 'Select type of AD that you want to show.', 'meloo' ),
			),

			// Custom
			array(
				'name' => esc_html__( 'Custom Code', 'meloo' ),
				'id' => 'ad_article_top_custom',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '',
				'height' => '240',
				'dependency' => array(
			        "element" => 'ad_article_top_type',
			        "value" => array( 'custom' )
			    ),
			    'desc' => $ad_desc
			),

			// AdSense
			array(
				'name' => esc_html__( 'AdSense Code', 'meloo' ),
				'id' => 'ad_article_top_adsense',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '',
				'height' => '240',
				'desc' => esc_html__( 'Paste your AdSense code here. ', 'meloo' ),
				'dependency' => array(
			        "element" => 'ad_article_top_type',
			        "value" => array( 'adsense' )
			    )
			),

			
		array( 
			'type' => 'sub_close'
		),


		/* Article Bottom
		 -------------------------------- */
		array( 
			'type' => 'sub_open',
			'sub_tab_name' => esc_html__( 'Article Bottom', 'meloo' ),
			'sub_tab_id' => 'sub-ad-article-bottom'
		),

			// AD Code Type
			array(
				'name' => esc_html__( 'AD Code Type', 'meloo' ),
				'id' => 'ad_article_bottom_type',
				'type' => 'select',
				'std' => '',
				'options' => array( 
					array( 'name' => esc_html__( '- Select -', 'meloo' ), 'value' => ''),
					array( 'name' => esc_html__( 'Custom AD Code', 'meloo' ), 'value' => 'custom'),
					array( 'name' => esc_html__( 'Google AdSense Code', 'meloo' ), 'value' => 'adsense')
				),
				'desc' => esc_html__( 'Select type of AD that you want to show.', 'meloo' ),
			),

			// Custom
			array(
				'name' => esc_html__( 'Custom Code', 'meloo' ),
				'id' => 'ad_article_bottom_custom',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '',
				'height' => '240',
				'dependency' => array(
			        "element" => 'ad_article_bottom_type',
			        "value" => array( 'custom' )
			    ),
			    'desc' => $ad_desc
			),

			// AdSense
			array(
				'name' => esc_html__( 'AdSense Code', 'meloo' ),
				'id' => 'ad_article_bottom_adsense',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '',
				'height' => '240',
				'desc' => esc_html__( 'Paste your AdSense code here. ', 'meloo' ),
				'dependency' => array(
			        "element" => 'ad_article_bottom_type',
			        "value" => array( 'adsense' )
			    )
			),

			
		array( 
			'type' => 'sub_close'
		),


		/* Sidebar
		 -------------------------------- */
		array( 
			'type' => 'sub_open',
			'sub_tab_name' => esc_html__( 'Sidebar', 'meloo' ),
			'sub_tab_id' => 'sub-ad-sidebar'
		),

			// AD Code Type
			array(
				'name' => esc_html__( 'AD Code Type', 'meloo' ),
				'id' => 'ad_sidebar_type',
				'type' => 'select',
				'std' => '',
				'options' => array( 
					array( 'name' => esc_html__( '- Select -', 'meloo' ), 'value' => ''),
					array( 'name' => esc_html__( 'Custom AD Code', 'meloo' ), 'value' => 'custom'),
					array( 'name' => esc_html__( 'Google AdSense Code', 'meloo' ), 'value' => 'adsense')
				),
				'desc' => esc_html__( 'Select type of AD that you want to show.', 'meloo' ),
			),

			// Custom
			array(
				'name' => esc_html__( 'Custom Code', 'meloo' ),
				'id' => 'ad_sidebar_custom',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '',
				'height' => '240',
				'dependency' => array(
			        "element" => 'ad_sidebar_type',
			        "value" => array( 'custom' )
			    ),
			    'desc' => $ad_desc
			),

			// AdSense
			array(
				'name' => esc_html__( 'AdSense Code', 'meloo' ),
				'id' => 'ad_sidebar_adsense',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '',
				'height' => '240',
				'desc' => esc_html__( 'Paste your AdSense code here. ', 'meloo' ),
				'dependency' => array(
			        "element" => 'ad_sidebar_type',
			        "value" => array( 'adsense' )
			    )
			),

			
		array( 
			'type' => 'sub_close'
		),


		/* Tracklist Inline
		 -------------------------------- */
		array( 
			'type' => 'sub_open',
			'sub_tab_name' => esc_html__( 'Tracklist Inline', 'meloo' ),
			'sub_tab_id' => 'sub-ad-tracklist'
		),

			// AD Code Type
			array(
				'name' => esc_html__( 'AD Code Type', 'meloo' ),
				'id' => 'ad_tracklist_type',
				'type' => 'select',
				'std' => '',
				'options' => array( 
					array( 'name' => esc_html__( '- Select -', 'meloo' ), 'value' => '' ),
					array( 'name' => esc_html__( 'Custom AD Code', 'meloo' ), 'value' => 'custom' ),
					array( 'name' => esc_html__( 'Google AdSense Code', 'meloo' ), 'value' => 'adsense' )
				),
				'desc' => esc_html__( 'Select type of AD that you want to show.', 'meloo' ),
			),

			// Custom
			array(
				'name' => esc_html__( 'Custom Code', 'meloo' ),
				'id' => 'ad_tracklist_custom',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '',
				'height' => '240',
				'dependency' => array(
			        "element" => 'ad_tracklist_type',
			        "value" => array( 'custom' )
			    ),
			    'desc' => $ad_desc
			),

			// AdSense
			array(
				'name' => esc_html__( 'AdSense Code', 'meloo' ),
				'id' => 'ad_tracklist_adsense',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '',
				'height' => '240',
				'desc' => esc_html__( 'Paste your AdSense code here. ', 'meloo' ),
				'dependency' => array(
			        "element" => 'ad_tracklist_type',
			        "value" => array( 'adsense' )
			    )
			),

			
		array( 
			'type' => 'sub_close'
		),
		

		/* Custom 1
		 -------------------------------- */
		array( 
			'type' => 'sub_open',
			'sub_tab_name' => esc_html__( 'Custom 1', 'meloo' ),
			'sub_tab_id' => 'sub-ad-custom1'
		),

			// AD Code Type
			array(
				'name' => esc_html__( 'AD Code Type', 'meloo' ),
				'id' => 'ad_custom1_type',
				'type' => 'select',
				'std' => '',
				'options' => array( 
					array( 'name' => esc_html__( '- Select -', 'meloo' ), 'value' => '' ),
					array( 'name' => esc_html__( 'Custom AD Code', 'meloo' ), 'value' => 'custom' ),
					array( 'name' => esc_html__( 'Google AdSense Code', 'meloo' ), 'value' => 'adsense' )
				),
				'desc' => esc_html__( 'Select type of AD that you want to show.', 'meloo' ),
			),

			// Custom
			array(
				'name' => esc_html__( 'Custom Code', 'meloo' ),
				'id' => 'ad_custom1_custom',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '',
				'height' => '240',
				'dependency' => array(
			        "element" => 'ad_custom1_type',
			        "value" => array( 'custom' )
			    ),
			    'desc' => $ad_desc
			),

			// AdSense
			array(
				'name' => esc_html__( 'AdSense Code', 'meloo' ),
				'id' => 'ad_custom1_adsense',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '',
				'height' => '240',
				'desc' => esc_html__( 'Paste your AdSense code here. ', 'meloo' ),
				'dependency' => array(
			        "element" => 'ad_custom1_type',
			        "value" => array( 'adsense' )
			    )
			),

			
		array( 
			'type' => 'sub_close'
		),

		/* Custom 2
		 -------------------------------- */
		array( 
			'type' => 'sub_open',
			'sub_tab_name' => esc_html__( 'Custom 2', 'meloo' ),
			'sub_tab_id' => 'sub-ad-custom2'
		),

			// AD Code Type
			array(
				'name' => esc_html__( 'AD Code Type', 'meloo' ),
				'id' => 'ad_custom2_type',
				'type' => 'select',
				'std' => '',
				'options' => array( 
					array( 'name' => esc_html__( '- Select -', 'meloo' ), 'value' => '' ),
					array( 'name' => esc_html__( 'Custom AD Code', 'meloo' ), 'value' => 'custom' ),
					array( 'name' => esc_html__( 'Google AdSense Code', 'meloo' ), 'value' => 'adsense' )
				),
				'desc' => esc_html__( 'Select type of AD that you want to show.', 'meloo' ),
			),

			// Custom
			array(
				'name' => esc_html__( 'Custom Code', 'meloo' ),
				'id' => 'ad_custom2_custom',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '',
				'height' => '240',
				'dependency' => array(
			        "element" => 'ad_custom2_type',
			        "value" => array( 'custom' )
			    ),
			    'desc' => $ad_desc
			),

			// AdSense
			array(
				'name' => esc_html__( 'AdSense Code', 'meloo' ),
				'id' => 'ad_custom2_adsense',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '',
				'height' => '240',
				'desc' => esc_html__( 'Paste your AdSense code here. ', 'meloo' ),
				'dependency' => array(
			        "element" => 'ad_custom2_type',
			        "value" => array( 'adsense' )
			    )
			),

			
		array( 
			'type' => 'sub_close'
		),

		/* Custom 3
		 -------------------------------- */
		array( 
			'type' => 'sub_open',
			'sub_tab_name' => esc_html__( 'Custom 3', 'meloo' ),
			'sub_tab_id' => 'sub-ad-custom3'
		),

			// AD Code Type
			array(
				'name' => esc_html__( 'AD Code Type', 'meloo' ),
				'id' => 'ad_custom3_type',
				'type' => 'select',
				'std' => '',
				'options' => array( 
					array( 'name' => esc_html__( '- Select -', 'meloo' ), 'value' => '' ),
					array( 'name' => esc_html__( 'Custom AD Code', 'meloo' ), 'value' => 'custom' ),
					array( 'name' => esc_html__( 'Google AdSense Code', 'meloo' ), 'value' => 'adsense' )
				),
				'desc' => esc_html__( 'Select type of AD that you want to show.', 'meloo' ),
			),

			// Custom
			array(
				'name' => esc_html__( 'Custom Code', 'meloo' ),
				'id' => 'ad_custom3_custom',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '',
				'height' => '240',
				'dependency' => array(
			        "element" => 'ad_custom3_type',
			        "value" => array( 'custom' )
			    ),
			    'desc' => $ad_desc
			),

			// AdSense
			array(
				'name' => esc_html__( 'AdSense Code', 'meloo' ),
				'id' => 'ad_custom3_adsense',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '',
				'height' => '240',
				'desc' => esc_html__( 'Paste your AdSense code here. ', 'meloo' ),
				'dependency' => array(
			        "element" => 'ad_custom3_type',
			        "value" => array( 'adsense' )
			    )
			),

			
		array( 
			'type' => 'sub_close'
		),
	
	array( 
		'type' => 'close'
	),


	/* ==================================================
	  Fonts 
	================================================== */
	array( 
		'type' => 'open',
		'tab_name' => esc_html__( 'Fonts', 'meloo' ),
		'tab_id' => 'fonts',
		'icon' => 'font'
	),

		/* Google Fonts
		 -------------------------------- */
		array(
			'type' => 'sub_open',
			'sub_tab_name' => esc_html__( 'Google Web Fonts', 'meloo' ),
			'sub_tab_id' => 'sub-google-fonts',
		),
			array(
				'name' => esc_html__( 'Google Fonts', 'meloo' ),
				'id' => 'use_google_fonts',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'on',
				'desc' => esc_html__( 'When this option is enabled, the text elements will be automatically replaced with the Google Web Fonts.', 'meloo' ),
			),
			array(
				'name' => esc_html__( 'Google Font Code', 'meloo' ),
				'id' => 'google_fonts',
				'type' => 'textarea',
				'std' => esc_html__( 'Barlow+Condensed:400,500,600,700,800,900|Roboto:300,300i,400,400i,500,500i,700,700i,900,900i|Space+Mono:400,400i&amp;subset=latin-ext', 'meloo' ),
				'tinymce' => 'false',
				'height' => '50',
				'desc' => esc_html__( 'Add Google Fonts family.', 'meloo' ),
				'dependency' => array(
			        "element" => 'use_google_fonts',
			        "value" => array( 'on' )
			    )
			),
		array(
			'type' => 'sub_close'
		),
		

	array( 
		'type' => 'close'
	),


	/* ==================================================
	  Sections 
	================================================== */
	array( 
		'type' => 'open',
		'tab_name' => esc_html__( 'Sections', 'meloo' ),
		'tab_id' => 'plugins',
		'icon' => 'th-large'
	),	

		/* Music Player
		 -------------------------------- */
		array(
			'type' => 'sub_open',
			'sub_tab_name' => esc_html__( 'Music', 'meloo' ),
			'sub_tab_id' => 'sub-sections-music',
		),

			// Enable Scamp Player
			array(
				'name' => esc_html__( 'Music Player', 'meloo' ),
				'id' => 'scamp_player',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'on',
				'desc' => esc_html__( 'Enable music player. NOTE: Meloo Plugin must be instaled and activated.', 'meloo' ),
			),

			// Autoplay
			array(
				'name' => esc_html__( 'Autoplay', 'meloo' ),
				'id' => 'player_autoplay',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'off',
				'desc' => esc_html__( 'Autoplay tracklist. NOTE: Autoplay does not work on mobile devices.', 'meloo' ),
				'dependency' => array(
			        "element" => 'scamp_player',
			        "value" => array( 'on' )
			    )
			),

			// Load first track
			array(
				'name' => esc_html__( 'Load First Track', 'meloo' ),
				'id' => 'load_first_track',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'off',
				'desc' => esc_html__( 'Load first track from tracklist after load list.', 'meloo' ),
				'dependency' => array(
			        "element" => 'scamp_player',
			        "value" => array( 'on' )
			    )
			),

			// Open Player after click on tracklist
			array(
				'name' => esc_html__( 'Open Player After Click', 'meloo' ),
				'id' => 'open_player',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'off',
				'desc' => esc_html__( 'Open player after click on content track.', 'meloo' ),
				'dependency' => array(
			        "element" => 'scamp_player',
			        "value" => array( 'on' )
			    )
			),

			// Startup Tracklist
			array( 
				'name' => esc_html__( 'Startup Tracklist', 'meloo' ),
				'id' => 'startup_tracklist',
				'type' => 'posts',
				'post_type' => 'meloo_tracks',
				'std' => 'none',
				'options' => array(
				   	array( 'name' => '', 'value' => 'none' ),
				),
				'desc' => esc_html__( 'Select startup tracklist.', 'meloo' ),
				'dependency' => array(
			        "element" => 'scamp_player',
			        "value" => array( 'on' )
			    )
			),

			// Show Player
			array(
				'name' => esc_html__( 'Show Player on Startup', 'meloo' ),
				'id' => 'show_player',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'off',
				'desc' => esc_html__( 'Show player on startup. NOTE: Player will not be visible when option "Open Player After Click" is enabled.', 'meloo' ),
				'dependency' => array(
			        "element" => 'scamp_player',
			        "value" => array( 'on' )
			    )
			),

			// Show Tracklist
			array(
				'name' => esc_html__( 'Show Tracklist on Startup', 'meloo' ),
				'id' => 'show_tracklist',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'off',
				'desc' => esc_html__( 'Show playlist on startup.', 'meloo' ),
				'dependency' => array(
			        "element" => 'scamp_player',
			        "value" => array( 'on' )
			    )
			),

			// Base64
			array(
				'name' => esc_html__( 'Encode Tracks URLS (Base64)', 'meloo' ),
				'id' => 'player_base64',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'off',
				'desc' => esc_html__( 'Set this to on when you would like to use the base64 PHP function, to hide the MP3 URL.', 'meloo' ),
				'dependency' => array(
			        "element" => 'scamp_player',
			        "value" => array( 'on' )
			    )
			),

			// Random Tracks
			array(
				'name' => esc_html__( 'Random Play', 'meloo' ),
				'id' => 'player_random',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'off',
				'desc' => esc_html__( 'Random play tracks.', 'meloo' ),
				'dependency' => array(
			        "element" => 'scamp_player',
			        "value" => array( 'on' )
			    )
			),

			// Loop Tracks
			array(
				'name' => esc_html__( 'Loop Tracklist', 'meloo' ),
				'id' => 'player_loop',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'off',
				'desc' => esc_html__( 'Loop tracklist.', 'meloo' ),
				'dependency' => array(
			        "element" => 'scamp_player',
			        "value" => array( 'on' )
			    )
			),

			// Titlebar
			array(
				'name' => esc_html__( 'Change Titlebar', 'meloo' ),
				'id' => 'player_titlebar',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'off',
				'desc' => esc_html__( 'Replace browser titlebar on track title.', 'meloo' ),
				'dependency' => array(
			        "element" => 'scamp_player',
			        "value" => array( 'on' )
			    )
			),

			// Player Skin
			array( 
				'name' => esc_html__( 'Player Skin', 'meloo' ),
				'id' => 'player_skin',
				'type' => 'select',
				'std' => 'dark',
				'desc' => esc_html__( 'Select player skin.', 'meloo' ),
				'options' => array( 
					array( 'name' => 'Dark', 'value' => 'dark'),
					array( 'name' => 'Light', 'value' => 'light')
				),
				'dependency' => array(
			        "element" => 'scamp_player',
			        "value" => array( 'on' )
			    )
			),

			// Soundcloud 
			array(
				'name' => esc_html__( 'Soundcloud', 'meloo' ),
				'id' => 'soundcloud',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'on',
				'desc' => esc_html__( 'Soundcloud Playback', 'meloo' ),
				'dependency' => array(
			        "element" => 'scamp_player',
			        "value" => array( 'on' )
			    )
			),

			// Soundcloud Client ID
			array(
				'name' => esc_html__( 'Soundcloud Client ID', 'meloo' ),
				'id' => 'soundcloud_id',
				'type' => 'text',
				'std' => '',
				'desc' => esc_html__( 'Add your Soundcloud ID', 'meloo' ),
				'dependency' => array(
			        "element" => 'soundcloud',
			        "value" => array( 'on' )
			    )
			),

			// Shoutcast Radio
			array(
				'name' => esc_html__( 'Shoutcast Radio', 'meloo' ),
				'id' => 'shoutcast',
				'type' => 'switch_button',
				'std' => 'on',
				'desc' => esc_html__( 'Shoutcast support.', 'meloo' ),
				'dependency' => array(
			        "element" => 'scamp_player',
			        "value" => array( 'on' )
			    )
			),

			// Shoutcast Refresh Time
			array(
				'name' => esc_html__( 'Shoutcast Refresh Time (ms)', 'meloo' ),
				'id' => 'shoutcast_interval',
				'type' => 'text',
				'std' => '20000',
				'desc' => esc_html__( 'Enter refresh time in ms. (20000 = 20s)', 'meloo' ),
				'dependency' => array(
			        "element" => 'shoutcast',
			        "value" => array( 'on' )
			    )
			),

			// Startup Volume
			array( 
				'name' => esc_html__( 'Startup Volume', 'meloo' ),
				'id' => 'player_volume',
				'type' => 'range',
				'plugins' => array( 'range' ),
				'min' => 0,
				'max' => 100,
				'unit' => '',
				'std' => '70',
				'desc' => esc_html__( 'Set startup volume.', 'meloo' ),
				'dependency' => array(
			        "element" => 'scamp_player',
			        "value" => array( 'on' )
			    )
			),
			
		array(
			'type' => 'sub_close'
		),


		/* Comments
		 -------------------------------- */
		array(
			'type' => 'sub_open',
			'sub_tab_name' => esc_html__( 'Comments', 'meloo' ),
			'sub_tab_id' => 'sub-sections-comments'
		),

			// Custom Comments Date
			array(
				'name' => esc_html__( 'Comment Date Format', 'meloo' ),
				'id' => 'custom_comment_date',
				'type' => 'text',
				'std' => 'F j, Y (H:i)',
				'desc' => esc_html__( 'Enter your custom comment date.', 'meloo' )
			),

			array(
				'name' => esc_html__( 'DISQUS Comments', 'meloo' ),
				'id' => 'disqus_comments',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'off',
				'desc' => esc_html__( 'Enable DISQUS comments. Replace default Wordpress comments.', 'meloo' ),
			),

			// Disqus ID
			array(
				'name' => esc_html__( 'DISQUS Shortname', 'meloo' ),
				'id' => 'disqus_shortname',
				'type' => 'text',
				'std' => '',
				'desc' => esc_html__( 'Enter DISQUS Website\'s Shortname.', 'meloo' ),
				'dependency' => array(
					'element' => 'disqus_comments',
					'value' => array( 'on' )
				)
			),

		array(
			'type' => 'sub_close'
		),


		/* Permalinks
		 -------------------------------------------------------- */
		array(
			'type' => 'sub_open',
			'sub_tab_name' => esc_html__( 'Permalinks', 'meloo' ),
			'sub_tab_id' => 'sub-section-permalinks',
		),	

			// Artists
			array(
				'name' => esc_html__( 'Artists Slug', 'meloo' ),
				'id' => 'artists_slug',
				'type' => 'text',
				'std' => 'artists',
				'desc' => esc_html__( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'meloo' )
			),
			array(
				'name' => esc_html__( 'Artists Filter 1 Slug', 'meloo' ),
				'id' => 'artists_cat_slug',
				'type' => 'text',
				'std' => 'artists-category',
				'desc' => esc_html__( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'meloo' )
			),
			array(
				'name' => esc_html__( 'Artists Filter 2 Slug', 'meloo' ),
				'id' => 'artists_cat_slug2',
				'type' => 'text',
				'std' => 'artists-category-2',
				'desc' => esc_html__( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'meloo' )
			),
			array(
				'name' => esc_html__( 'Artists Filter 3 Slug', 'meloo' ),
				'id' => 'artists_cat_slug3',
				'type' => 'text',
				'std' => 'artists-category-3',
				'desc' => esc_html__( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'meloo' )
			),
			array(
				'name' => esc_html__( 'Artists Filter 4 Slug', 'meloo' ),
				'id' => 'artists_cat_slug4',
				'type' => 'text',
				'std' => 'artists-category-4',
				'desc' => esc_html__( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'meloo' )
			),

			// Music
			array(
				'name' => esc_html__( 'Music Slug', 'meloo' ),
				'id' => 'music_slug',
				'type' => 'text',
				'std' => 'music',
				'desc' => esc_html__( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'meloo' )
			),
			array(
				'name' => esc_html__( 'Music Filter 1 Slug', 'meloo' ),
				'id' => 'music_cat_slug',
				'type' => 'text',
				'std' => 'music-category',
				'desc' => esc_html__( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'meloo' )
			),
			array(
				'name' => esc_html__( 'Music Filter 2 Slug', 'meloo' ),
				'id' => 'music_cat_slug2',
				'type' => 'text',
				'std' => 'music-category-2',
				'desc' => esc_html__( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'meloo' )
			),
			array(
				'name' => esc_html__( 'Music Filter 3 Slug', 'meloo' ),
				'id' => 'music_cat_slug3',
				'type' => 'text',
				'std' => 'music-category-3',
				'desc' => esc_html__( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'meloo' )
			),
			array(
				'name' => esc_html__( 'Music Filter 4 Slug', 'meloo' ),
				'id' => 'music_cat_slug4',
				'type' => 'text',
				'std' => 'music-category-4',
				'desc' => esc_html__( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'meloo' )
			),

			// Events
			array(
				'name' => esc_html__( 'Events Slug', 'meloo' ),
				'id' => 'events_slug',
				'type' => 'text',
				'std' => 'events',
				'desc' => esc_html__( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'meloo' )
			),
			array(
				'name' => esc_html__( 'Events Filter 1 Slug', 'meloo' ),
				'id' => 'events_cat_slug',
				'type' => 'text',
				'std' => 'event-category',
				'desc' => esc_html__( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'meloo' )
			),
			array(
				'name' => esc_html__( 'Events Filter 2 Slug', 'meloo' ),
				'id' => 'events_cat_slug2',
				'type' => 'text',
				'std' => 'event-category-2',
				'desc' => esc_html__( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'meloo' )
			),
			array(
				'name' => esc_html__( 'Events Filter 3 Slug', 'meloo' ),
				'id' => 'events_cat_slug3',
				'type' => 'text',
				'std' => 'event-category-3',
				'desc' => esc_html__( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'meloo' )
			),


			// Gallery
			array(
				'name' => esc_html__( 'Gallery Slug', 'meloo' ),
				'id' => 'gallery_slug',
				'type' => 'text',
				'std' => 'gallery',
				'desc' => esc_html__( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'meloo' )
			),
			array(
				'name' => esc_html__( 'Gallery Filter 1 Slug', 'meloo' ),
				'id' => 'gallery_cat_slug',
				'type' => 'text',
				'std' => 'gallery-category',
				'desc' => esc_html__( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'meloo' )
			),
			array(
				'name' => esc_html__( 'Gallery Filter 2 Slug', 'meloo' ),
				'id' => 'gallery_cat_slug2',
				'type' => 'text',
				'std' => 'gallery-category-2',
				'desc' => esc_html__( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'meloo' )
			),
			array(
				'name' => esc_html__( 'Gallery Filter 3 Slug', 'meloo' ),
				'id' => 'gallery_cat_slug3',
				'type' => 'text',
				'std' => 'gallery-category-3',
				'desc' => esc_html__( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'meloo' )
			),
			array(
				'name' => esc_html__( 'Gallery Filter 4 Slug', 'meloo' ),
				'id' => 'gallery_cat_slug4',
				'type' => 'text',
				'std' => 'gallery-category-4',
				'desc' => esc_html__( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'meloo' )
			),

			// Videos
			array(
				'name' => esc_html__( 'Video Slug', 'meloo' ),
				'id' => 'videos_slug',
				'type' => 'text',
				'std' => 'video',
				'desc' => esc_html__( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'meloo' )
			),
			array(
				'name' => esc_html__( 'Videos Filter 1 Slug', 'meloo' ),
				'id' => 'gallery_cat_slug',
				'type' => 'text',
				'std' => 'gallery-category',
				'desc' => esc_html__( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'meloo' )
			),
			array(
				'name' => esc_html__( 'Videos Filter 2 Slug', 'meloo' ),
				'id' => 'gallery_cat_slug2',
				'type' => 'text',
				'std' => 'gallery-category-2',
				'desc' => esc_html__( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'meloo' )
			),
			array(
				'name' => esc_html__( 'Videos Filter 3 Slug', 'meloo' ),
				'id' => 'gallery_cat_slug3',
				'type' => 'text',
				'std' => 'gallery-category-3',
				'desc' => esc_html__( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'meloo' )
			),
			array(
				'name' => esc_html__( 'Videos Filter 4 Slug', 'meloo' ),
				'id' => 'gallery_cat_slug4',
				'type' => 'text',
				'std' => 'gallery-category-4',
				'desc' => esc_html__( 'Enter post slug name. No special characters. No spaces. IMPORTANT: When you change post slug name, you have to go to: WordPress Settings > Permalinks and save settings.', 'meloo' )
			),

		array(
			'type' => 'sub_close'
		),
		

	array( 
		'type' => 'close'
	),


	/* ==================================================
	  Sidebars 
	================================================== */
	array(
		'type' => 'open',
		'tab_name' => esc_html__( 'Sidebars', 'meloo' ),
		'tab_id' => 'sidebars',
		'icon' => 'bars'
	),
		array(
			'type' => 'sub_open',
			'sub_tab_name' => esc_html__( 'Sidebars', 'meloo' ),
			'sub_tab_id' => 'sub-sidebars'
		),


			array(
				'name'       => esc_html__( 'Sidebars', 'meloo' ),
				'sortable'   => false,
				'array_name' => 'custom_sidebars',
				'id'         => array(
				 	array( 'name' => 'name', 'id' => 'sidebar', 'label' => 'Name:', 'type' => 'text' )
				 ),
				'type'        => 'sortable_list',
				'button_text' => esc_html__( 'Add Sidebar', 'meloo' ),
				'desc'        => esc_html__( 'Add your custom sidebars.', 'meloo' )
			),

		array(
			'type' => 'sub_close'
		),
	array(
		'type' => 'close'
	),


	/* ==================================================
	  Advanced 
	================================================== */
	array( 
		'type' => 'open',
		'tab_name' => esc_html__( 'Advanced', 'meloo' ),
		'tab_id' => 'advanced',
		'icon' => 'wrench'
	),

		/* AJAX
		 -------------------------------- */
		array(
			'type' => 'sub_open',
			'sub_tab_name' => esc_html__( 'Ajax', 'meloo' ),
			'sub_tab_id' => 'sub-ajax'
		),

			// Ajax
			array( 
				'name' => esc_html__( 'Ajax Load', 'meloo' ),
				'id' => 'ajaxed',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'on',
				'desc' => esc_html__( 'Enable if you want ajax loading.', 'meloo' ),
			),

			// Ajax Async
			array(
				'name' => esc_html__( 'Asynchronous', 'meloo' ),
				'id' => 'ajax_async',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'on',
				'desc' => esc_html__( 'Asynchronous AJAX.', 'meloo' ),
				'dependency' => array(
			        "element" => 'ajaxed',
			        "value" => array( 'on' )
			    )
			),

			// Ajax Cache
			array(
				'name' => esc_html__( 'Ajax Cache', 'meloo' ),
				'id' => 'ajax_cache',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'off',
				'desc' => esc_html__( 'AJAX Cache.', 'meloo' ),
				'dependency' => array(
			        "element" => 'ajaxed',
			        "value" => array( 'on' )
			    )
			),

			// Ajax Elements
			array( 
				'name' => esc_html__( 'AJAX Filter', 'meloo' ),
				'id' => 'ajax_elements',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '',
				'height' => '120',
				'desc' => esc_html__( 'Add selectors (Note: divide links with linebreaks (Enter)). These elements will not be processed by AJAX.', 'meloo' ),
				'dependency' => array(
			        "element" => 'ajaxed',
			        "value" => array( 'on' )
			    )
			),

			// Ajax reload scripts
			array( 
				'name' => esc_html__( 'AJAX Reload Scripts', 'meloo' ),
				'id' => 'ajax_reload_scripts',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '',
				'height' => '120',
				'desc' => esc_html__( 'Add strings for reloaded scripts (Note: divide links with linebreaks (Enter)). These scripts will be reloaded after page loaded by AJAX.', 'meloo' ),
				'dependency' => array(
			        "element" => 'ajaxed',
			        "value" => array( 'on' )
			    )
			),

			// Ajax reload containers
			array( 
				'name' => esc_html__( 'AJAX Reload Containers', 'meloo' ),
				'id' => 'ajax_reload_containers',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '',
				'height' => '120',
				'desc' => esc_html__( 'Add strings for reloaded containers (Note: divide links with linebreaks (Enter)). These containers will be reloaded after page loaded by AJAX.', 'meloo' ),
				'dependency' => array(
			        "element" => 'ajaxed',
			        "value" => array( 'on' )
			    )
			),

			// Ajax exclude links
			array( 
				'name' => esc_html__( 'AJAX Exclude Links', 'meloo' ),
				'id' => 'ajax_exclude_links',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '',
				'height' => '120',
				'desc' => esc_html__( 'Add links that should be excluded from AJAX loader (Note: divide links with linebreaks (Enter)). These pages will not be loaded by AJAX.', 'meloo' ),
				'dependency' => array(
			        "element" => 'ajaxed',
			        "value" => array( 'on' )
			    )
			),

			// Ajax events
			array( 
				'name' => esc_html__( 'AJAX Events', 'meloo' ),
				'id' => 'ajax_events',
				'type' => 'textarea',
				'tinymce' => 'false',
				'std' => '',
				'height' => '120',
				'desc' => esc_html__( 'Add Javascript events (Note: divide links with linebreaks (Enter)). These events will be removed after page page by AJAX.', 'meloo' ),
				'dependency' => array(
			        "element" => 'ajaxed',
			        "value" => array( 'on' )
			    )
			),
		array(
			'type' => 'sub_close'
		),


		/* Optimize
		 -------------------------------- */
		array(
			'type' => 'sub_open',
			'sub_tab_name' => esc_html__( 'Optimize', 'meloo' ),
			'sub_tab_id' => 'sub-optimize'
		),

			// Combine JS files
			array( 
				'name' => esc_html__( 'Combine JS Plugin Files', 'meloo' ),
				'id' => 'combine_js',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'off',
				'desc' => esc_html__( 'Compress and combine Javascript files into one file located in theme plugin. ', 'meloo' ),
			),


		array(
			'type' => 'sub_close'
		),



		/* Plugins
		 -------------------------------- */
		array(
			'type' => 'sub_open',
			'sub_tab_name' => esc_html__( 'Plugins', 'meloo' ),
			'sub_tab_id' => 'sub-plugins'
		),

			// Retina Displays
			array( 
				'name' => esc_html__( 'Retina Displays', 'meloo' ),
				'id' => 'retina',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'off',
				'desc' => esc_html__( 'To make this work you need to specify the width and the height of the image directly and provide the same image twice the size withe the @2x selector added at the end of the image name. For instance if you want your "logo.png" file to be retina compatible just include it in the markup with specified width and height ( the width and height of the original image in pixels ) and create a "logo@2x.png" file in the same directory that is twice the resolution.', 'meloo' ),
			),

			// Lazy Loading
			array( 
				'name' => esc_html__( 'Image Loading (LazyLoad)', 'meloo' ),
				'id' => 'lazyload',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'on',
				'desc' => esc_html__( 'Disable or enable loading animation effect. The effect animation allows you to animate your theme images as you scroll, from top to the bottom. It applies even on the next and prev operations creating an effect of loading images to the right or to the left.', 'meloo' ),
			),

			// Facebook JSSDK
			array( 
				'name' => esc_html__( 'Facebook JSSDK', 'meloo' ),
				'id' => 'fbsdk',
				'type' => 'switch_button',
				'plugins' => array( 'switch_button' ),
				'std' => 'on',
				'desc' => esc_html__( 'Connect site with Facebook JS SDK. This is necessary to display widgets from Facebook.', 'meloo' ),
			),
		array(
			'type' => 'sub_close'
		),
		

		/* Import/Export
		 -------------------------------- */
		array( 
			'type' => 'sub_open',
			'sub_tab_name' => esc_html__( 'Import/Export', 'meloo' ),
			'sub_tab_id' => 'sub-import'
		),
			array( 
				'type' => 'export'
			),
			array( 
				'type' => 'import'
			),
		array( 
			'type' => 'sub_close'
		),

	array( 
		'type' => 'close'
	),


	/* ==================================================
	    Hidden fields
	 ================================================== */
	array( 
		'type' => 'hidden_field',
		'id' => 'theme_name',
		'value' => 'meloo'
	),
	
);


/* ==================================================
  Init Panel 
================================================== */

/* Class arguments */
$args = array(
	'menu_name' => esc_html__( 'Theme Panel', 'meloo' ), 
	'option_name' => 'meloo_panel_opts',
	'menu_icon' => '',
);

/* Add class instance */
$main_panel = new RascalsThemePanel( $args, $meloo_main_options );


/* ==================================================
  Get Theme Options 
================================================== */
function meloo_opts(){
   global $main_panel;
   return $main_panel;
}