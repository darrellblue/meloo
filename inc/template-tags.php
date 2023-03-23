<?php
/**
 * Theme Name:      Meloo
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascalsthemes.com/meloo
 * Author URI:      http://rascalsthemes.com
 * File:            template-tags.php
 * @package meloo
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/* ==================================================
  Get Paged
================================================== */
if ( ! function_exists( 'meloo_get_paged' ) ) :
function meloo_get_paged() {
	global $paged;
	return $paged;
}
endif;


/* ==================================================
  Loop Pagination 
================================================== */
if ( ! function_exists( 'meloo_paging_nav' ) ) :
function meloo_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $GLOBALS['wp_query']->max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => esc_html__( '&larr; Prev', 'meloo' ),
		'next_text' => esc_html__( 'Next &rarr;', 'meloo' ),
	) );

	if ( $links ) :

	?>
	<nav class="navigation paging-navigation">
		<div class="pagination loop-pagination">
			<?php 
			echo paginate_links( array(
				'base'     => $pagenum_link,
				'format'   => $format,
				'total'    => $GLOBALS['wp_query']->max_num_pages,
				'current'  => $paged,
				'mid_size' => 1,
				'add_args' => array_map( 'urlencode', $query_args ),
				'prev_text' => esc_html__( '&larr;', 'meloo' ),
				'next_text' => esc_html__( '&rarr;', 'meloo' ),
			) );

			?>
		</div><!-- .pagination -->
	</nav><!-- .navigation -->
	<?php
	endif;
}
endif;


/* ==================================================
  Post Pagination
  Display navigation to next/previous post when applicable. 
================================================== */
if ( ! function_exists( 'meloo_post_nav' ) ) :
function meloo_post_nav() {
	global $post;

	$meloo_opts = meloo_opts();
	
	// Don't print empty markup if there's nowhere to navigate. 
	$previous  = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next      = get_adjacent_post( false, '', false );
	$post_type = get_post_type( $post->ID );

	if ( ! $next && ! $previous ) {
		echo '<nav class="navigation post-navigation empty"></nav>';
		return;
	}

	$next_label = esc_html__( 'Next', 'meloo' );
	$prev_label = esc_html__( 'Previous', 'meloo' );

	$next_link = get_adjacent_post( false,'',false );          
	$prev_link = get_adjacent_post( false,'',true ); 

	$next_post_thumb = '';
	$prev_post_thumb = '';

	if ( $next_link ) {
		if ( has_post_thumbnail( $next_link->ID ) ) {
		 	$next_post_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next_link->ID ), 'large' );
		 	if ( $meloo_opts->get_option( 'lazyload' ) === 'on' ) {
		 		$next_post_thumb = '<span class="post-nav-preview lazy" data-src="' . esc_attr( $next_post_thumb[0] ) . '"></span>';
		 	} else {
		 		$next_post_thumb = '<span class="post-nav-preview" style="background-image:url(' . esc_attr( $next_post_thumb[0] ) . ')"></span>';
		 	}
		 	
		}
	}

	if ( $prev_link ) {
		if ( has_post_thumbnail( $prev_link->ID ) ) {
		 	$prev_post_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $prev_link->ID ), 'large' );
		 	if ( $meloo_opts->get_option( 'lazyload' ) === 'on' ) {
		 		$prev_post_thumb = '<span class="post-nav-preview lazy" data-src="' . esc_attr( $prev_post_thumb[0] ) . '"></span>';
		 	} else {
		 		$prev_post_thumb = '<span class="post-nav-preview" style="background-image:url(' . esc_attr( $prev_post_thumb[0] ) . ')"></span>';
		 	}
		}
	}

	?>
	<?php
	if ( is_attachment() ) :
		echo '<div class="container"><span class="attachment-post-link">';
		previous_post_link( '%link', '<span class="meta-nav">' . esc_html__( 'Published In', 'meloo' ) . '</span>' . esc_html__( '%title', 'meloo' ) );
		echo '</span></div>';
		echo '<nav class="navigation post-navigation empty"></nav>';
	else : ?>
	<nav class="navigation post-navigation">
		<div class="nav-links">
			<?php
				if ( empty( $prev_link ) && $next_link ) {
					echo '<span class="post-nav-inner link-empty"></span>';
					 echo '<span class="post-nav-inner link-full"><a href="' . esc_url( get_permalink( $next_link->ID ) ) . '" class="next-link">' . $next_post_thumb . '<span class="nav-desc"><span class="nav-direction">' .  $meloo_opts->esc( $next_label ) . '</span><span class="nav-title">' . esc_html( get_the_title( $next_link->ID ) ) . '</span></span></a></span>';
				} else if ( $prev_link && empty( $next_link ) ) {
					 echo '<span class="post-nav-inner link-full"><a href="' . esc_url( get_permalink( $prev_link->ID ) ) . '" class="prev-link"><span class="nav-desc"><span class="nav-direction">' . esc_html( $prev_label ) . '</span><span class="nav-title">' . esc_html( get_the_title( $prev_link->ID ) ) . '</span></span>' .  $meloo_opts->esc( $prev_post_thumb ) . '</a></span>';
					echo '<span class="post-nav-inner link-empty"></span>';
				} else if ( $prev_link && $next_link  ) {
					 echo '<span class="post-nav-inner"><a href="' . esc_url( get_permalink( $prev_link->ID ) ) . '" class="prev-link"><span class="nav-desc"><span class="nav-direction">' . esc_html( $prev_label ) . '</span><span class="nav-title">' . esc_html( get_the_title( $prev_link->ID ) ) . '</span></span>' .  $meloo_opts->esc( $prev_post_thumb ) . '</a></span>';
					 echo '<span class="post-nav-inner"><a href="' . esc_url( get_permalink( $next_link->ID ) ) . '" class="next-link">' .  $meloo_opts->esc( $next_post_thumb ) . '<span class="nav-desc"><span class="nav-direction">' . esc_html( $next_label ) . '</span><span class="nav-title">' . esc_html( get_the_title( $next_link->ID ) ) . '</span></span></a></span>';
				}
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php endif; ?>
	<?php
}
endif;


/* ----------------------------------------------------------------------
	POST NAVIGATION WITH CUSTOM ORDER
	Display navigation to next/previous post with custom order for special CP.
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'meloo_custom_post_nav' ) ) :
function meloo_custom_post_nav() {
	global $post;

	$meloo_opts = meloo_opts();

	if ( isset( $post ) ) {
		$backup = $post;
	}

	$output = '';
	$post_type = get_post_type($post->ID);
	$id = $post->ID;
	$count = 0;
	$prev_id = '';
	$next_id = '';
	$posts = array();
	$next_label = esc_html__( 'Next Post', 'meloo' );
	$prev_label = esc_html__( 'Prev Post', 'meloo' );


	if ( $post_type === 'meloo_gallery' || $post_type === 'meloo_music' || $post_type === 'meloo_artists' || $post_type === 'meloo_events' || $post_type = 'meloo_videos'  ) {

		// Music
		if ( $post_type === 'meloo_music' ) {
			
			$args = array(
				'post_type' => 'meloo_music',
				'showposts'=> '-1'
			);
		
			$args['orderby'] = 'menu_order';
			$args['order'] = 'ASC';

			$next_label = esc_html__( 'Next Release', 'meloo' );
			$prev_label = esc_html__( 'Prev Release', 'meloo' );
		}

		// Artist
		if ( $post_type === 'meloo_artists' ) {
			
			$args = array(
				'post_type' => 'meloo_artists',
				'showposts'=> '-1'
			);
		
			$args['orderby'] = 'menu_order';
			$args['order'] = 'ASC';

			$next_label = esc_html__( 'Next Artist', 'meloo' );
			$prev_label = esc_html__( 'Prev Artist', 'meloo' );
		}

		// Gallery
		if ( $post_type === 'meloo_gallery' ) {
			
			$args = array(
				'post_type' => 'meloo_gallery',
				'showposts'=> '-1'
			);

			$next_label = esc_html__( 'Next Album', 'meloo' );
			$prev_label = esc_html__( 'Prev Album', 'meloo' );
		}

		// Videos
		if ( $post_type === 'meloo_videos' ) {
			
			$args = array(
				'post_type' => 'meloo_videos',
				'showposts'=> '-1'
			);
		
			$args['orderby'] = 'menu_order';
			$args['order'] = 'ASC';

			$next_label = esc_html__( 'Next Video', 'meloo' );
			$prev_label = esc_html__( 'Prev Video', 'meloo' );
		}

		// Events
		if ( $post_type === 'meloo_events' ) {
			if ( is_object_in_term( $post->ID, 'meloo_event_type', 'future-events' ) ) {
				$event_type = 'future-events';
			} else {
				$event_type = 'past-events';
			}
			$order = $event_type === 'future-events' ? $order = 'ASC' : $order = 'DSC';
			$args = array(
				'post_type' => 'meloo_events',
				'tax_query' => 
					array(
						array(
						'taxonomy' => 'meloo_event_type',
						'field' => 'slug',
						'terms' => $event_type
						)
					),
				'showposts'=> '-1',
				'orderby' => 'meta_value',
				'meta_key' => '_event_date_start',
				'order' => $order
			);

			$next_label = esc_html__( 'Next Event', 'meloo' );
			$prev_label = esc_html__( 'Prev Event', 'meloo' );
		}

		// Nav loop
		$nav_query = new WP_Query();
		$nav_query->query( $args );
		if ( $nav_query->have_posts() )	{
			while ( $nav_query->have_posts() ) {
				$nav_query->the_post();
				$posts[] = get_the_id();
				if ( $count === 1 ) break;
				if ( $id === get_the_id() ) $count++;
			}
			$current = array_search( $id, $posts );

			$next_post_thumb = '';
			$prev_post_thumb = '';

			// Check IDs
			if ( isset( $posts[$current+1] ) ) {
				$next_id = $posts[$current+1];
				if ( has_post_thumbnail( $next_id ) ) {
					$next_post_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next_id ), 'large' );
				 	if ( $meloo_opts->get_option( 'lazyload' ) === 'on' ) {
				 		$next_post_thumb = '<span class="post-nav-preview lazy" data-src="' . esc_attr( $next_post_thumb[0] ) . '"></span>';
				 	} else {
				 		$next_post_thumb = '<span class="post-nav-preview" style="background-image:url(' . esc_attr( $next_post_thumb[0] ) . ')"></span>';
				 	}
				}
			}
			if ( isset( $posts[$current-1] ) ) {
				$prev_id = $posts[$current-1];
				if ( has_post_thumbnail( $prev_id ) ) {
				 	$prev_post_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $prev_id ), 'large' );
				 	if ( $meloo_opts->get_option( 'lazyload' ) === 'on' ) {
				 		$prev_post_thumb = '<span class="post-nav-preview lazy" data-src="' . esc_attr( $prev_post_thumb[0] ) . '"></span>';
				 	} else {
				 		$prev_post_thumb = '<span class="post-nav-preview" style="background-image:url(' . esc_attr( $prev_post_thumb[0] ) . ')"></span>';
				 	}
				}

			}

			// Display nav
			$output .= '
			<nav class="navigation post-navigation">
			<div class="nav-links">';
	
				if ( empty( $prev_id ) && $next_id) {
					$output .= '<span class="post-nav-inner link-empty"></span>';
					$output .= '<span class="post-nav-inner link-full"><a href="' . esc_url( get_permalink( $next_id ) ) . '" class="next-link">' . $next_post_thumb . '<span class="nav-desc"><span class="nav-direction">' .  $meloo_opts->esc( $next_label ) . '</span><span class="nav-title">' . esc_html( get_the_title( $next_id ) ) . '</span></span></a></span>';
				} else if ( $prev_id && empty( $next_id) ) {
					 $output .= '<span class="post-nav-inner link-full"><a href="' . esc_url( get_permalink( $prev_id ) ) . '" class="prev-link"><span class="nav-desc"><span class="nav-direction">' . esc_html( $prev_label ) . '</span><span class="nav-title">' . esc_html( get_the_title( $prev_id ) ) . '</span></span>' .  $meloo_opts->esc( $prev_post_thumb ) . '</a></span>';
					$output .= '<span class="post-nav-inner link-empty"></span>';
				} else if ( $prev_id && $next_id ) {
					 $output .= '<span class="post-nav-inner"><a href="' . esc_url( get_permalink( $prev_id ) ) . '" class="prev-link"><span class="nav-desc"><span class="nav-direction">' . esc_html( $prev_label ) . '</span><span class="nav-title">' . esc_html( get_the_title( $prev_id ) ) . '</span></span>' .  $meloo_opts->esc( $prev_post_thumb ) . '</a></span>';
					 $output .= '<span class="post-nav-inner"><a href="' . esc_url( get_permalink( $next_id ) ) . '" class="next-link">' .  $meloo_opts->esc( $next_post_thumb ) . '<span class="nav-desc"><span class="nav-direction">' . esc_html( $next_label ) . '</span><span class="nav-title">' . esc_html( get_the_title( $next_id ) ) . '</span></span></a></span>';
				}
		
			$output .= '</div></nav>';
		}

		if ( isset( $post ) ) {
			$post = $backup;
		}
		
		return $output;
	} else {
		return false;
	}
}
endif;


/* ==================================================
  Custom Pagination Limit 
================================================== */
function meloo_set_post_limit( $query ) {

  	if ( $query->is_main_query() && ! is_admin() ) {
  		if ( is_category() ) {
			$query->set( 'posts_per_page', get_theme_mod( 'category_limit', 9 ) );
		} elseif ( is_tag() ) {
			$query->set( 'posts_per_page', get_theme_mod( 'tag_limit', 9 ) );
		} elseif ( is_author() ) {
			$query->set( 'posts_per_page', get_theme_mod( 'author_limit', 9 ) );
		} elseif ( is_archive() ) {
			$query->set( 'posts_per_page', get_theme_mod( 'archive_limit', 9 ) );
		} elseif ( is_search() ) {
			$query->set( 'posts_per_page', get_theme_mod( 'search_limit', 9 ) );
		}
  	}
}
add_action( 'pre_get_posts', 'meloo_set_post_limit' );