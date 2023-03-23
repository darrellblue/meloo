<?php
/**
 * Theme Name:      Meloo
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascalsthemes.com/meloo
 * Author URI:      http://rascalsthemes.com
 * File:            single.php
 * @package meloo
 * @since 1.0.0
 */

get_header();

// Get options
$meloo_opts = meloo_opts();
	
// Variables
$temp_post = $post;
$query_temp = $wp_query;

// Sidebar 
$sidebar = false;

// Hero header 
$hero_header = false;

// Post Template 
$post_template = get_post_meta( $wp_query->post->ID, '_post_template', true );
$post_template = ( $post_template === false ? 'simple' : $post_template );

// Post Sharing 
$post_sharing = get_theme_mod( 'share_buttons', '0' );

// Default Classes 
$content_classes = array(
	'content',
	'has-navigation'
);
$container_classes = array(
	'container'
);
$post_block_classes = array(
	'single-post-block',
);
if ( $post_sharing ) {
	$post_block_classes[] = 'has-share-block';
}

// Set classes and variables for selected template 
if ( $post_template === 'simple' ) {
	array_push( $content_classes, 'post-template-' . $post_template, 'featured-extended' );
	$container_classes[] = 'small';
}
else if ( $post_template === 'left_sidebar' ) {
	$sidebar = true;
	array_push( $content_classes, 'post-template-' . $post_template, 'layout-style-1', 'sidebar-on-left' );
}
else if ( $post_template === 'right_sidebar' ) {
	$sidebar = true;
	array_push( $content_classes, 'post-template-' . $post_template, 'layout-style-1', 'sidebar-on-right' );
}
else if ( $post_template === 'hero_center' ) {
	array_push( $content_classes, 'post-template-' . $post_template, 'hero-header' );
	$container_classes[] = 'small';
	$hero_header = true;
}
else if ( $post_template === 'hero_left_sidebar' ) {
	$sidebar = true;
	$hero_header = true;
	array_push( $content_classes, 'post-template-' . $post_template, 'hero-header', 'layout-style-1', 'sidebar-on-left' );
}
else if ( $post_template === 'hero_right_sidebar' ) {
	$sidebar = true;
	$hero_header = true;
	array_push( $content_classes, 'post-template-' . $post_template, 'hero-header', 'layout-style-1', 'sidebar-on-right' );
}

?>


<?php 
if ( $hero_header ) :

	$img_src = '';
	$hero_image = get_post_meta( $wp_query->post->ID, '_hero_image', true );
	$hero_margin = get_post_meta( $wp_query->post->ID, '_hero_margin', true );
	$hero_margin = ( $hero_margin === '' ? '250' : $hero_margin );
	if ( $hero_image !== '' ) {
		$img_src = wp_get_attachment_image_src( $hero_image, 'full' );
        $img_src = $img_src[0];
	} else if ( has_post_thumbnail( $wp_query->post->ID ) ) {
		$img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $wp_query->post->ID ), 'full' );
        $img_src = $img_src[0];
	}
	$hero_position = get_post_meta( $wp_query->post->ID, '_hero_bg_position', true );
	$hero_position = ( $hero_position === '' ? 'center' : $hero_position );
	
	?>
	
	<div class="post-header post-hero-header hero <?php echo esc_attr( $post_template ) ?>" style="padding-top:<?php echo esc_attr( $hero_margin ) ?>px" >
	<?php

	/* Hero image - Lazy load */
	if ( $meloo_opts->get_option( 'lazyload' ) === 'on' ) : ?>
    	<div class="hero-image lazy" data-src="<?php echo esc_attr( $img_src ); ?>" style="background-position-y:<?php echo esc_attr( $hero_position )?>;"></div>
	<?php else : ?>
		<div class="hero-image" style="background-image:url(<?php echo esc_attr( $img_src ); ?>);"></div>
	<?php endif; ?>

    	<div class="container <?php if ( $post_template === 'hero_center' ) { echo 'small'; }; ?>">
    	<?php
	    	// Get Post Title 
			get_template_part( 'partials/post', 'title' ); ?>
		</div>
		<div class="overlay overlay-color"></div>
		<div class="overlay overlay-gradient-2"></div>
	</div>

<?php endif ?>


<div class="<?php echo esc_attr( implode(' ', $content_classes ) ) ?>">

	<div class="<?php echo esc_attr( implode(' ', $container_classes ) ) ?>">
		<div class="main">

			<?php if ( ! $hero_header ) : ?>

				<!-- Post Header: Simple -->
				<div class="post-header post-simple-header <?php echo esc_attr( $post_template ) ?>">
					<?php 

						// Post Title 
						get_template_part( 'partials/post', 'title' ); ?>
				</div>

			<?php endif ?>

			<?php while ( have_posts() ) : the_post(); ?>
				
				<?php 

				// Featured Content 
				get_template_part( 'partials/post', 'featured' ); ?>

				<?php 
			        // AD Spot 
			        if ( function_exists('meloo_show_ad') ) {
			            echo meloo_show_ad( 'article_top' );
			        }
		    	?>
				
		        <!-- Single post block -->
				<div class="<?php echo esc_attr( implode(' ', $post_block_classes ) ) ?>"> 
						
					<?php 

					 // Sharing 
				 	set_query_var( 'is_sharing', $post_sharing );
					get_template_part( 'partials/post', 'sharing' ); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post' ); ?>>

						<!-- Content Block -->
						<?php

				    	// Render content via Page Builder 
				  		meloo_get_content();

			       		wp_link_pages( array(
				            'before'    => '<div class="page-links">' . esc_html__( 'Jump to Page', 'meloo' ),
				            'after'     => '</div>',
				        ) );

						// Tags
						the_tags( '<div class="meta-tags">', ' ', '</div>' );
		
				        // AD Spot
				        if ( function_exists('meloo_show_ad') ) {
				            echo meloo_show_ad( 'article_bottom' );
				        }
				  
						// Author Box
						get_template_part( 'partials/post', 'author' ); ?>

					</article>

				</div> <!-- .single post block -->
			

			<?php endwhile; ?>
			
			<?php 

			// Related Posts
			get_template_part( 'partials/post', 'related-posts' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				$disqus = $meloo_opts->get_option( 'disqus_comments' );
				$disqus_shortname = $meloo_opts->get_option( 'disqus_shortname' );

				if ( ( $disqus && $disqus === 'on' ) && ( $disqus_shortname && $disqus_shortname !== '' ) ) {
					get_template_part( 'inc/disqus' );
					
				} else {
					comments_template();
				}
			}
			
			?>
			<!-- /comments -->
		</div> 
		<!-- /main -->
	
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
	if ( function_exists( 'meloo_post_nav' ) ) {
		meloo_post_nav();
	} else {
		posts_nav_link( ' &#183; ', esc_html_e( 'previous page', 'meloo' ), esc_html_e( 'next page', 'meloo' ) );
	}
	
	?>
   
</div> <!-- .content -->

<?php
// Get orginal query
$post = $temp_post;
$wp_query = $query_temp;

// Get footer
get_footer(); ?>