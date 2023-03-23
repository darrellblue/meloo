<?php
/**
 * Theme Name:      Meloo
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascalsthemes.com/meloo
 * Author URI:      http://rascalsthemes.com
 * File:            post-featured.php
 * @package meloo
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Get options
$meloo_opts = meloo_opts();

// Featured Content 
$featured_content = get_post_meta( $wp_query->post->ID, '_featured_content', true );
if ( has_post_thumbnail( $post->ID ) && $featured_content === false ) {
	$featured_content = 'image';
} 

// Featured Link 
$media_link = get_post_meta( $wp_query->post->ID, '_media_link', true );

// Source name 
$source_name = get_post_meta( $wp_query->post->ID, '_source_name', true );

?>
<?php 
// Start block
if ( $featured_content !== false && $featured_content !== 'none' ) : ?>
	<div class="featured-block">
<?php endif; ?>

<?php 
// Image
if ( $featured_content === 'image' && has_post_thumbnail( $post->ID ) ) : ?>
	<?php 
	if ( function_exists( 'meloo_get_image' ) ) {
		echo meloo_get_image( $id, 'full', '', $lazy = true, $image_id = false );
	}
	 ?>

<?php 
// Youtube
elseif ( $featured_content === 'youtube' && $media_link !== '' ) : ?>
	<?php 

	if ( preg_match( "/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $media_link, $matches ) ) :
	 ?>
        <div class="youtube media" id="<?php echo esc_attr( $matches[1] ) ?>"></div>
	<?php endif; ?>

<?php 
// Vimeo
elseif ( $featured_content === 'vimeo' && $media_link !== '' ) : ?>
	<?php 

	if ( preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $media_link, $matches  ) ) : ?>
        <div class="vimeo media" id="<?php echo esc_attr( $matches[5] ) ?>"></div>
	<?php endif; ?>

<?php 
// Soundcloud
elseif ( $featured_content === 'soundcloud' && $media_link !== '' ) : ?>
    <div class="soundcloud media">
        <?php 

        if ( function_exists( 'meloo_get_sc_iframe' ) ) {
        	echo meloo_get_sc_iframe( $media_link );
        } 
        ?>
	</div>
<?php 

// Spotify
elseif ( $featured_content === 'spotify' && $media_link !== '' ) : ?>
    <div class="spotify media">
        <?php 
        if ( function_exists( 'meloo_get_spotify_iframe' ) ) {
        	echo meloo_get_spotify_iframe( $media_link );
        } 
        ?>
	</div>

<?php 

// Bandcamp
elseif ( $featured_content === 'bandcamp' ) : ?>
	
	<?php 
	$bandcamp_code = get_post_meta( $wp_query->post->ID, '_bandcamp_code', true );
	if ( $bandcamp_code !== '' ) : ?>
	    <div class="bandcamp media">
	        <?php 
	        	echo get_post_meta( $wp_query->post->ID, '_bandcamp_code', true )
	        ?>
		</div>
	<?php endif; ?>

<?php

// Custom ID
elseif ( $featured_content === 'tracks' ) : ?>
	<?php 
		// Tracks 
		$track_id = get_post_meta( $wp_query->post->ID, '_track_id', true );
		$tracks_ids = get_post_meta( $wp_query->post->ID, '_tracks_ids', true );
		
		if ( $track_id !== '' && function_exists( 'meloo_toolkit' ) && meloo_toolkit( 'scamp_player' ) ) :
	 ?>
    <div class="scamp-player media">
        <?php 
        if ( function_exists( 'sp_tracklist' ) ) {

        	// Get list settings 
			$fixed_height = get_post_meta( $wp_query->post->ID, '_fixed_height', true );
			$fixed_height = ( $fixed_height === '0' ? '' : $fixed_height );
			$show_covers  = get_post_meta( $wp_query->post->ID, '_show_covers', true );
			$show_ad      = get_post_meta( $wp_query->post->ID, '_show_ad', true );
			$limit        = get_post_meta( $wp_query->post->ID, '_limit', true );
			$size         = get_post_meta( $wp_query->post->ID, '_size', true );
			$size         = ( $size === '' ? 'medium' : $size );

	        echo sp_tracklist( array(
				'id'           => $track_id,
				'ids'          => $tracks_ids,
				'covers'       => $show_covers,
				'buttons'      => 'yes',
				'fixed_height' => $fixed_height, // 306
				'size'         => $size, // medium,large,xlarge
				'limit'        => $limit, // -1 - display all tracks
				'show_ad'      => $show_ad,
				'classes'      => '',
				'css'          => ''
	        ) );
	    };
        ?>
	</div>
	<?php endif; ?>
<?php endif; ?>

<?php 
// End block
if ( $featured_content !== false && $featured_content !== 'none' ) : ?>
	<?php 
	// Display source metabox 
	if ( $source_name !== '' ) {
		echo '<span class="source-name">' . wp_kses_post( $source_name ) . '</span>';
	}
	?>
</div>
<?php endif; ?>