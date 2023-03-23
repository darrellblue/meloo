<?php
/**
 * Theme Name:      Meloo
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascalsthemes.com/meloo
 * Author URI:      http://rascalsthemes.com
 * File:            single-meloo_gallery.php
 * @package meloo
 * @since 1.0.0
 */

get_header();

// Get options
$meloo_opts = meloo_opts();

wp_reset_postdata();

// Copy Query 
$temp_post = $post;
$query_temp = $wp_query;

// Get layout 
$page_layout = get_post_meta( $wp_query->post->ID, '_page_layout', true );
$page_layout = ( $page_layout !== '' ? $page_layout : 'wide' );

// Thumb size 
$thumb_size = 'meloo_content_thumb';

// Page Builder 
$is_page_builder = false;
$page_builder = get_post_meta( $wp_query->post->ID, '_page_builder', true );
if ( class_exists( 'KingComposer' ) and $page_builder === 'on' ) {
	$is_page_builder = true;
} 

// Disable header 
$header_layout = get_post_meta( $wp_query->post->ID, '_header_layout', true ); //default,transparent,simple
$header_layout = ( $header_layout !== false ? $header_layout : 'default' );

if ( $header_layout === 'transparent' || $header_layout === 'default' ) {
	$disable_header = false;
} else {
	$disable_header = true;
}

// Album ID 
$album_id = get_the_id();

// Images 
$images_ids = get_post_meta(  $wp_query->post->ID, '_images', true ); 

// Images in row 
$images_in_row = get_post_meta(  $wp_query->post->ID, '_images_in_row', true ); 
$images_in_row = ( $images_in_row !== '' ? $images_in_row : '4' );

 // Taxonomies 
if ( function_exists( 'meloo_get_taxonomies' ) ) {
    $tax_args = array(
        'id' => $wp_query->post->ID,
        'tax_name' => 'meloo_gallery_cats',
        'separator' => '',
        'link' => true,
        'limit' => 1,
        'show_count' => false
    );
    $posts_cats = meloo_get_taxonomies( $tax_args );
} else {
    $posts_cats = '';
}

// Set classes and variables
$sidebar = false;
$content_classes = array(
	'content',
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
}

// Fullwidth 
$fullwidth = get_post_meta(  $wp_query->post->ID, '_fullwidth', true );
if ( $fullwidth ) {
	$container_classes[] = $fullwidth;
}

// Images number
if ( $images_ids || $images_ids !== '' ) {
    $images_number = explode( '|', $images_ids );
    $images_number = count( $images_number );
} else {
    $images_number = '0';
}


?>
<?php if ( ! $disable_header ) : ?>
<div class="page-header default-image-header">
	<h1><?php echo get_the_title( $wp_query->post->ID ) ?></h1>
	<h4><span class="gallery-cats"><?php $meloo_opts->e_esc( $posts_cats ) ?></span><span class="gallery-images-number"><?php echo esc_html( $images_number ) ?> <?php _e( 'Photos', 'meloo' ) ?></span></h4>
</div>
<?php endif; ?>

<?php if ( $is_page_builder === true ) : ?>
	<?php $content_classes[] = 'page-builder-top'; ?>
	<div class="content-full">
		<div class="container-full">
			<?php 
			while ( have_posts() ) {
			 	the_post();

		    	// Render content via Page Builder 
		  		meloo_get_content();
			} 
			?>
		</div>
	</div>
	<?php rewind_posts(); ?>
	
<?php endif; ?>

<div class="<?php echo esc_attr( implode(' ', $content_classes ) ) ?>">

	<div class="<?php echo esc_attr( implode(' ', $container_classes ) ) ?>">

		<?php if ( $header_layout === 'simple_title' ) : ?>
			<div class="post-header page-header post-simple-header">
				<h1><?php echo get_the_title( $wp_query->post->ID ) ?></h1>
				<h4><span class="gallery-cats"><?php $meloo_opts->e_esc( $posts_cats ) ?></span><span class="gallery-images-number"><?php echo esc_html( $images_number ) ?> <?php _e( 'Photos', 'meloo' ) ?></span></h4>
			</div>

		<?php endif ?>

		<div class="main">

		<?php if ( $images_ids || $images_ids !== '' ) :

			$ids = explode( '|', $images_ids ); 
           	$gallery_loop_args = array(
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'post__in'       => $ids,
				'orderby'        => 'post__in',
				'post_status'    => 'any',
				'showposts'      => -1
			);

			$wp_query = new WP_Query();
			$wp_query->query( $gallery_loop_args );
			?>
		
			<div class="gallery-images-grid flex-grid flex-<?php echo esc_attr( $images_in_row ) ?> flex-tablet-2 flex-mobile-2 flex-mobile-portrait-1 flex-gap-medium flex-anim flex-anim-fadeup posts-container">

				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post(); ?>
						
						<?php 
						$image_att = wp_get_attachment_image_src( get_the_id(), $thumb_size );
						if ( ! $image_att[0] ) { 
							continue;
						}

						// Get image meta 
						$image = get_post_meta( $album_id, '_gallery_ids_' . get_the_id(), true );

						// Add default values 
						$defaults = array(
							'title'       => '',
							'custom_link' => '',
							'thumb_icon'  => 'view'
				         );

						if ( isset( $image ) && is_array( $image ) ) {
							$image = array_merge( $defaults, $image );
						} else {
							$image = $defaults;
						}

						// Add image src to array 
						$image['src'] = $image_att[0];
						if ( $image[ 'custom_link' ] !== '' ) {
							$link = $image[ 'custom_link' ];
						} else {
							$link = wp_get_attachment_image_src( get_the_id(), 'full' );
							$link = $link[0];
						}

						?>

						<div class="flex-item">
               
	                        <article <?php post_class( 'article' ); ?>>
	                            <a href="<?php echo esc_attr( $link ) ?>" class="<?php if ( $image[ 'custom_link' ] !== '' ) { echo esc_attr( 'iframe-link'); } ?> g-item" title="<?php echo esc_attr( $image['title'] ); ?>">
	                            	<?php echo meloo_get_image( false, $thumb_size, '', true, get_the_id() ) ?>
	                            </a>
	                        </article>
	                        
	                    </div>

					<?php endwhile; // End Loop ?>

				<?php endif; ?>
			</div>
			<div class="clear"></div>
		<?php endif; ?>
		<?php
		   // Get orginal query
			$post     = $temp_post;
			$wp_query = $query_temp;
		?>		
		<?php
		// If comments are open or we have at least one comment, load up the comment template.
		if ( get_theme_mod( 'posts_comments', true ) ) {
			echo '<div class="clear"></div>';
			if ( comments_open() || get_comments_number() ) {
				if ( $is_page_builder && class_exists( 'KingComposer' ) ) {
					echo '<div class="container comments-block">';
				}
				$disqus = $meloo_opts->get_option( 'disqus_comments' );
				$disqus_shortname = $meloo_opts->get_option( 'disqus_shortname' );

				if ( ( $disqus && $disqus === 'on' ) && ( $disqus_shortname && $disqus_shortname !== '' ) ) {
					get_template_part( 'inc/disqus' );
					
				} else {
					comments_template();
				}
				if ( $is_page_builder && class_exists( 'KingComposer' ) ) {
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