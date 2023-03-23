<?php
/**
 * Template Name: Blog
 *
 * @package meloo
 * @since 1.0.0
 */

get_header(); 

// Get panel options 
$meloo_opts = meloo_opts();
	
// Copy query 
$temp_post = $post;
$query_temp = $wp_query;

$more = 0;

// Set color scheme 
$color_scheme = get_theme_mod( 'color_scheme', 'dark' );

// Get layout 
$articles_layout = get_post_meta( $wp_query->post->ID, '_articles_layout', true );
$articles_layout = ( $articles_layout !== '' ? $articles_layout : 'narrow' );

// Pagination 
$pagination = get_post_meta( $wp_query->post->ID, '_pagination', true );
$pagination = ( ! empty( $pagination ) ? $pagination : 'next_prev' );

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

// Page Builder 
$is_page_builder = false;
$page_builder = get_post_meta( $wp_query->post->ID, '_page_builder', true );
if ( class_exists( 'KingComposer' ) and $page_builder === 'on' ) {
	if ( $paged === 1 ) {
		$is_page_builder = true;
	}
} 

// Get loop block 
$block = get_post_meta( $wp_query->post->ID, '_block', true );
$block = ( $block !== '' ? $block : 'block3' );
$block_option = '';

switch ($block) {
	case 'block4':
		$block = 'block4';
		$block_option = '4';
		break;
	case 'block5':
		$block = 'block4';
		$block_option = '3';
		break;
	case 'block6':
		$block = 'block4';
		$block_option = '2';
		break;
	case 'block7':
		$block = 'block5';
		$block_option = '2';
		break;
	case 'block8':
		$block = 'block6';
		$block_option = '4';
		break;
	case 'block9':
		$block = 'block6';
		$block_option = '3';
		break;
	case 'block10':
		$block = 'block6';
		$block_option = '2';
		break;
	case 'block11':
		$block = 'block7';
		$block_option = '2';
		break;
}

// Filter
$filter_args = array(
	'filter_atts'       => get_post_meta( $wp_query->post->ID, '_filter_atts', false ), 
	'ajax_filter'       => false,
	'show_filters'      => '',
	'filter_sel_method' => ''
);

// Queries  
$filters_query = meloo_prepare_posts_filter( $filter_args );
$query_args = meloo_prepare_wp_query( $filters_query, $paged );

// Set classes and variables
$sidebar = false;
$content_classes = array(
	'content'
);
$container_classes = array(
	'container'
);
if ( $articles_layout === 'narrow' ) {
	array_push( $content_classes, 'page-layout-' . $articles_layout );
	$container_classes[] = 'small';
} else if ( $articles_layout === 'wide' ) {
	array_push( $content_classes, 'page-layout-' . $articles_layout );
	$container_classes[] = 'wide';
} else if ( $articles_layout === 'left_sidebar' ) {
	$sidebar = true;
	array_push( $content_classes, 'page-layout-' . $articles_layout, 'layout-style-1', 'sidebar-on-left' );
} else if ( $articles_layout === 'right_sidebar' ) {
	$sidebar = true;
	array_push( $content_classes, 'page-layout-' . $articles_layout, 'layout-style-1', 'sidebar-on-right' );
}
?>

<?php if ( $is_page_builder === true ) : ?>

<?php 
// Remove gradient class 
$content_classes[] = 'page-builder-top';
?>
<div class="content-full">
	<div class="container-full">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php 
		    	// Render content via Page Builder 
		  		meloo_get_content();
			?>
		<?php endwhile; ?>
	</div>
</div>
<?php rewind_posts(); ?>
<?php else : ?>

<div class="page-header default-image-header">
	<h1><?php echo get_the_title( $wp_query->post->ID ) ?></h1>
</div>

<?php endif; ?>

<div class="<?php echo esc_attr( implode(' ', $content_classes ) ) ?>">
	
	<div class="<?php echo esc_attr( implode(' ', $container_classes ) ) ?>">

		<div class="main">
			<?php 
				$ajax_opts = array(
					'action' => 'meloo_load_more'
				);
			 ?>
			<div class="ajax-grid-block" data-loading='false' data-paged='2' data-opts='<?php echo json_encode( $ajax_opts ); ?>' data-filter='<?php  echo json_encode( $filters_query );?>'>
				<?php
			
	            $wp_query = new WP_Query();
				$wp_query->query( $query_args );

				// Show pagination? 
				if ( $paged === intval( $wp_query->max_num_pages ) ) {
        			$ajax_paged_visible = false;
    			} else {
    				$ajax_paged_visible = true;
    			}

				if ( have_posts() ) : ?>

					<?php

						 // Render loop block
						set_query_var( 'block_option', $block_option );
						get_template_part( 'partials/loop', $block );
						
					?>
					<div class="clear"></div>
	    			<?php 

		    			// Pagination 

	    				// Prev/Next 
		    			if ( $pagination === 'next_prev' ) {
		    				meloo_paging_nav();

		    			// Ajax 
		    			} else if ( $pagination === 'load_more' || 'infinite' ) {
		    				if ( $ajax_paged_visible ) {
		    					if ( function_exists( 'meloo_content_loader' ) ) {
	                        		echo meloo_content_loader();
	                        	}

			    				$pagination_class = $pagination === 'infinite' ? 'infinite-load' : 'btn load-more';
			    				echo "<a class='" . esc_attr( $pagination_class ) . "'>";
			    				if ( $pagination === 'load_more' ) {
			    					_e( 'Load More', 'meloo' );
			    				}
			    				echo "</a>";
		    				}
		    			}
		    			
		    			?>
					<?php else : ?>
					<p><?php esc_html_e( 'It seems we can not find what you are looking for.', 'meloo' ); ?></p>

				<?php endif; // have_posts() ?>
			</div>
		</div>  <!-- .main -->
		<?php 
		// Restore query 
		$post = $temp_post;
		$wp_query = $query_temp;
		?>
        <?php if ( $sidebar ) : ?>
            <div class="sidebar sidebar-block">
                <div class="theiaStickySidebar">
                    <?php get_sidebar( 'custom' ); ?>
                </div>
            </div>
        <?php endif; ?>
    </div> <!-- .container -->
</div> <!-- .content -->

<?php

// Get footer
get_footer();