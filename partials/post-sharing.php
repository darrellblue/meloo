<?php
/**
 * Theme Name:      Meloo
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascalsthemes.com/meloo
 * Author URI:      http://rascalsthemes.com
 * File:            post-sharing.php
 * @package meloo
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Get options
$meloo_opts = meloo_opts();

if ( get_query_var( 'is_sharing' ) ) : ?>

<div class="share-block sticky-block">
    <a class="share-button share-button-facebook" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo esc_url( get_permalink( $post->ID ) ); ?>" title="<?php echo esc_attr__( 'Share on Facebook', 'meloo' ) ?>">
        <span class="icon icon-facebook"></span>
    </a>
	<a class="share-button share-button-twitter" target="_blank" href="http://twitter.com/share?url=<?php echo esc_url( get_permalink( $post->ID ) ); ?>" title="<?php echo esc_attr__( 'Share on Twitter', 'meloo' ) ?>">
        <span class="icon icon-twitter"></span>
    </a>
</div>

<?php endif; ?>