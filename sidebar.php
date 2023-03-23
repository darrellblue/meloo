<?php
/**
 * Theme Name:      Meloo
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascalsthemes.com/meloo
 * Author URI:      http://rascalsthemes.com
 * File:            sidebar.php
 * @package meloo
 * @since 1.0.0
 */
?>

<?php if ( is_active_sidebar( 'primary-sidebar' )  ) : ?>
	<aside class="sidebar">
		<?php dynamic_sidebar( 'primary-sidebar' ); ?>
	</aside>
<?php endif; ?>