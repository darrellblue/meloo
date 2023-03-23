<?php
/**
 * Theme Name:      Meloo
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascalsthemes.com/meloo
 * Author URI:      http://rascalsthemes.com
 * File:            searchform.php
 * @package meloo
 * @since 1.0.0
 */
?>
<form method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' )); ?>">
	<fieldset>
		<span class="search-input-wrap">
			<input type="text" placeholder="<?php esc_attr_e( 'Search...', 'meloo' ) ?>" value="<?php echo get_search_query(); ?>" name="s" id="s" />
		</span>
		<button type="submit" id="searchsubmit"><i class="icon icon-search"></i></button>
	</fieldset>

</form>