<?php
/**
 * Theme Name:      Meloo
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascalsthemes.com/meloo
 * Author URI:      http://rascalsthemes.com
 * File:            post-author.php
 * @package meloo
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Get options
$meloo_opts = meloo_opts();

/* Author Box */
$author_box = get_theme_mod( 'author_box', '0' );
if ( get_theme_mod( 'author_box', '0' ) === true ) {
	$author_box = get_post_meta( $wp_query->post->ID, '_author_box', true );
} 

$author_id = get_the_author_meta( 'ID' );
if ( $author_box ) : ?>

<div class="author-block">
	<a href="<?php echo esc_url( get_author_posts_url( $author_id, get_the_author_meta( 'user_nicename' ) ) ) ?>">
		<?php echo get_avatar( get_the_author_meta( 'email', $author_id ), '96' ); ?>
	</a>
	<div class="author-desc">
		<div class="author-name">
			<a href="<?php echo esc_url( get_author_posts_url( $author_id, get_the_author_meta( 'user_nicename' ) ) ) ?>">
				<?php echo get_the_author_meta( 'display_name', $author_id ) ?>
			</a>
		</div>
		<div class="desc">
			<?php echo get_the_author_meta( 'description', $author_id ); ?>
		</div>
	</div>
</div>
<?php endif; ?>