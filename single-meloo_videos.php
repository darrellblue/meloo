<?php
/**
 * Theme Name:      Meloo
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascalsthemes.com/meloo
 * Author URI:      http://rascalsthemes.com
 * File:            single-meloo_videos.php
 * @package meloo
 * @since 1.0.0
 */

get_header();

// Get options
$meloo_opts = meloo_opts();

/* Get layout */
$page_layout = get_post_meta( $wp_query->post->ID, '_page_layout', true );
$page_layout = ( $page_layout !== '' ? $page_layout : 'wide' );

/* Disable header */
$header_layout = get_post_meta( $wp_query->post->ID, '_header_layout', true ); //default,transparent,simple
if ( ! $header_layout ) {
	$disable_header = get_post_meta( $wp_query->post->ID, '_disable_header', true );
	$disable_header = ( $disable_header === '' ? get_theme_mod( 'disable_header', false ) : filter_var( $disable_header, FILTER_VALIDATE_BOOLEAN ) );
} else {
	if ( $header_layout === 'transparent' || $header_layout === 'default' ) {
		$disable_header = false;
	} else {
		$disable_header = true;
	}
}

// Set classes and variables 
$sidebar = false;
$content_classes = array(
	'content page-template-simple',
	'has-navigation'
);
$container_classes = array(
	'container'
);
if ( $page_layout === 'narrow' ) {
	array_push( $content_classes, 'page-layout-' . $page_layout );
	$container_classes[] = 'small';
} else if ( $page_layout === 'wide' ) {
	array_push( $content_classes, 'page-layout-' . $page_layout );
	$container_classes[] = 'wide';
} else if ( $page_layout === 'left_sidebar' ) {
	$sidebar = true;
	array_push( $content_classes, 'page-layout-' . $page_layout, 'layout-style-1', 'sidebar-on-left' );
} else if ( $page_layout === 'right_sidebar' ) {
	$sidebar = true;
	array_push( $content_classes, 'page-layout-' . $page_layout, 'layout-style-1', 'sidebar-on-right' );
} else if ( $page_layout === 'page_builder' && class_exists( 'KingComposer' ) ) {
	unset( $container_classes, $content_classes );
	$content_classes[] = 'content-full';
	$container_classes[] = 'container-full';
}

?>
<?php if ( ! $disable_header ) : ?>
<div class="page-header default-image-header">
	<h1><?php echo get_the_title( $wp_query->post->ID ) ?></h1>
</div>
<?php endif; ?>

<div class="<?php echo esc_attr( implode(' ', $content_classes ) ) ?>">

	<div class="<?php echo esc_attr( implode(' ', $container_classes ) ) ?>">

		<div class="main">

		<?php if ( $header_layout === 'simple_title' ) : ?>

			<!-- Post Header: Simple -->
			<div class="post-header post-simple-header">
				<h1><?php echo get_the_title( $wp_query->post->ID ) ?></h1>
			</div>

		<?php endif ?>

		<?php 
		while ( have_posts() ) {
		 	the_post();

	    	// Render content via Page Builder 
	  		meloo_get_content();
		} 
		?>
		<?php
		// If comments are open or we have at least one comment, load up the comment template.
		if ( get_theme_mod( 'posts_comments', true ) ) {
			echo '<div class="clear"></div>';
			if ( comments_open() || get_comments_number() ) {
				if ( $page_layout === 'page_builder' && class_exists( 'KingComposer' ) ) {
					echo '<div class="container comments-block">';
				}
				$disqus = $meloo_opts->get_option( 'disqus_comments' );
				$disqus_shortname = $meloo_opts->get_option( 'disqus_shortname' );

				if ( ( $disqus && $disqus === 'on' ) && ( $disqus_shortname && $disqus_shortname !== '' ) ) {
					get_template_part( 'inc/disqus' );
					
				} else {
					comments_template();
				}
				if ( $page_layout === 'page_builder' && class_exists( 'KingComposer' ) ) {
					echo '</div>';
				}
			}
		}
		?>
		</div> <!-- .main -->
	
		<?php if ( $sidebar ) : ?>
		<!-- Sidebar -->
	    <div class="sidebar sidebar-block">
	    	<div class="theiaStickySidebar">
				<?php get_sidebar( 'custom' ); ?>
			</div>
	    </div>
	    <!-- /sidebar -->
		<?php endif; ?>

	</div> <!-- .container -->

    <?php 

	// Posts Navigation 
	if ( function_exists( 'meloo_custom_post_nav' ) ) {
		echo meloo_custom_post_nav();
	} else {
		posts_nav_link( ' &#183; ', esc_html_e( 'previous page', 'meloo' ), esc_html_e( 'next page', 'meloo' ) );
	}
	
	?>
</div> <!-- .content -->

<?php 
get_footer();