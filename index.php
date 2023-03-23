<?php
/**
 * Theme Name: 		Meloo
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascalsthemes.com/meloo
 * Author URI: 		http://rascalsthemes.com
 * File:			index.php
 * @package meloo
 * @since 1.0.0
 */

get_header();

// Get options
$meloo_opts = meloo_opts();
   	
// Copy query 
$temp_post = $post;
$query_temp = $wp_query;

// Sidebar
$sidebar = true;

// Thumb Size 
$thumb_size = 'meloo-content-thumb';

// Pagination 
if ( function_exists( 'meloo_get_paged' ) ) {
	$paged = meloo_get_paged();
}
if ( get_query_var( 'paged' ) ) { 
	$paged = get_query_var( 'paged' ); 
} elseif ( get_query_var( 'page' ) ) { 
	$paged = get_query_var( 'page' ); 
} else { 
	$paged = 1; 
}

// Date format 
$date_format = get_option( 'date_format' );

?>
<div class="page-header default-image-header">
	<h1><?php esc_html_e( 'Recent Articles', 'meloo') ?></h1>
</div>

<div class="content is-hero layout-style-1 sidebar-on-right blog-list blog-list-index">
	<div class="container">
		<div class="main">
			<?php
			$args = array(
				'paged'               => $paged,
				'ignore_sticky_posts' => false
            );
            $wp_query = new WP_Query();
			$wp_query->query($args);

			if ( have_posts() ) : ?>

				<?php

				/* Block 3
				 -------------------------------- */
				get_template_part( 'partials/loop', 'block' );
					
				?>

			<div class="clear"></div>
    		<?php meloo_paging_nav(); ?>
			<?php else : ?>
				<p><?php esc_html_e( 'It seems we can not find what you are looking for.', 'meloo' ); ?></p>
			<?php endif; // have_posts() ?>
				
		</div>  <!-- .main -->

        <?php if ( $sidebar ) : ?>
            <div class="sidebar sidebar-block">
                <div class="theiaStickySidebar">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div> <!-- .container -->
</div> <!-- .content -->

<?php

// Restore query 
$post = $temp_post;
$wp_query = $query_temp;

// Get footer
get_footer();