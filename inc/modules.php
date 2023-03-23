<?php
/**
 * Theme Name:      Meloo
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascalsthemes.com/meloo
 * Author URI:      http://rascalsthemes.com
 * File:            modules.php
 * @package meloo
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/* ==================================================
  Module 1 
================================================== */
if ( ! function_exists( 'meloo_module1' ) ) :
function meloo_module1( $atts = array() ) {

    // The defaults will be overridden if set in $atts 
    $defaults = array( 
        'post_id'       => null,
        'thumb_size'    => 'full',
        'lazy'          => false,
        'ratings'       => true,
        'permalink'     => '#',
        'posts_cats'    => '',
        'title'         => '',
        'date'          => '',
        'author'        => '',
        'posts_classes' => '',
        'classes'       => ''
    );

    // Get Options 
    $meloo_opts = meloo_opts();

    // HTML variable 
    $html = '';

    // If $atts is not array 
    if ( ! is_array( $atts ) ) {
        return false;
    }
    
    // Set default arguments 
    $atts = array_merge( $defaults, $atts );

    // Import variables into the current symbol table from an array 
    extract( $atts, EXTR_PREFIX_SAME, 'module' );

    // Ratings 
    $rating = '';
    if ( $ratings ) {
        // Has Reviews 
        $has_reviews = get_post_meta( $post_id, '_has_reviews', true );
        if ( $has_reviews ) {

            // Rating 
            $rating = get_post_meta( $post_id, '_rating', true ); 
        }
    }

    // Render module 
    $html .= '
        <div class="module module-1 ' . esc_attr( $classes ) . '">
            <article class="module-inner ' . esc_attr( $posts_classes ) . '">
                <a href="' . esc_url( $permalink ) . '" class="module-link">
                    ' . meloo_get_image( $post_id, $thumb_size, 'module-thumb', $lazy ) . '
                </a>
                <div class="module-info-container overlay-gradient-1">
                    <div class="module-info">
                        <div class="post-meta">
                            <div class="post-cats cats-style">' . $meloo_opts->esc( $posts_cats ) . '</div><div class="post-date">' . $meloo_opts->esc( $date ) . '</div>
                        </div>
                        <h3 class="post-title">' . $meloo_opts->esc(  $title ) . '</h3>
                        '. meloo_get_stars_rating( $rating ) .'
                    </div>
                </div>
            </article>
        </div>
    ';

    return $html;
    
}
endif;


/* ==================================================
  Module 2
================================================== */
if ( ! function_exists( 'meloo_module2' ) ) :
function meloo_module2( $atts = array() ) {

    // The defaults will be overridden if set in $atts 
    $defaults = array( 
        'post_id'       => null,
        'thumb_size'    => 'full',
        'lazy'          => false,
        'ratings'       => true,
        'permalink'     => '#',
        'posts_cats'    => '',
        'title'         => '',
        'date'          => '',
        'author'        => '',
        'excerpt'       => '',
        'readmore'      => '',
        'placeholder'   => true,
        'posts_classes' => '',
        'classes'       => ''
    );

    // Get Options 
    $meloo_opts = meloo_opts();

    // HTML variable 
    $html = '';

    // If $atts is not array 
    if ( ! is_array( $atts ) ) {
        return false;
    }
    
    // Set default arguments 
    $atts = array_merge( $defaults, $atts );

    // Import variables into the current symbol table from an array 
    extract( $atts, EXTR_PREFIX_SAME, 'module' );

    // Ratings 
    $rating = '';

    if ( $ratings ) {
        // Has Reviews 
        $has_reviews = get_post_meta( $post_id, '_has_reviews', true );
        if ( $has_reviews ) {
            // Rating 
            $rating = get_post_meta( $post_id, '_rating', true ); 
        }
    }

    $post = get_post($post_id);

    $readmore_label = esc_html__( 'Read Article', 'meloo' );

    if ( $post->post_password ) {
        $readmore_label = esc_html__( 'Unlock Article', 'meloo' );
    }
    if ( ! empty( $readmore ) ) {
        $readmore = ' <a class="readmore frame-button button-l with-hover" href="' . esc_url( $permalink ) . '">
            <div class="button-layer button-layer-shadow">
                ' .  esc_html( $readmore_label ) . '
            </div>
            <div class="button-inner">
                <div class="button-inner-block">
                    <div class="button-hidden-layer">
                        ' .  esc_html( $readmore_label ) . '
                    </div>
                </div>
            </div>
    </a>';
    }
    if ( $placeholder ) {
        $img = meloo_get_image( $post_id, $thumb_size, 'module-thumb', $lazy, $image_id = false );
    } else if ( has_post_thumbnail( $post_id ) ) {
        $img = meloo_get_image( $post_id, $thumb_size, 'module-thumb', $lazy, $image_id = false );
    } else {
        $img = '';
        $classes .= ' no-thumb';
    }

    if ( $excerpt !== '' ) {
        $excerpt = '<div class="module-excerpt">' . $meloo_opts->esc( $excerpt ) . '</div>';
    } else {
        $excerpt = '';
    }

    $post = get_post($post_id);

    if ( $post->post_password ) {
         $excerpt = '<div class="module-excerpt">' . esc_html__( 'This post is protected.', 'meloo'). '</div>';
    }

    // Render module 
    $html .= '
        <div class="module module-2 ' . esc_attr( $classes ) . '">
            <article class="module-inner ' . esc_attr( $posts_classes ) . '">
                <a href="' . esc_url( $permalink ) . '" class="module-link tilt">' . $meloo_opts->esc( $img ) . '</a>
                <div class="module-info-container-wrap">
                    <div class="module-info-container">
                        <div class="module-top-meta">
                            <div class="post-cats cats-style">' . $meloo_opts->esc( $posts_cats ) . '</div><div class="post-date">' . $meloo_opts->esc( $date ) . '</div><div class="post-author">' . $meloo_opts->esc( $author ) . '</div>
                        </div>
                        <h3 class="post-title"><a href="' . esc_url( $permalink ) . '">' . $meloo_opts->esc(  $title ) . '</a></h3>
                    </div>
                    ' . meloo_get_stars_rating( $rating ) . '
                    ' . $meloo_opts->esc( $excerpt ) . '
                    ' . $meloo_opts->esc( $readmore ) . '
                </div>
            </article>
        </div>';

    return $html;
    
}
endif;


/* ==================================================
  Module 3
================================================== */
if ( ! function_exists( 'meloo_module3' ) ) :
function meloo_module3( $atts = array() ) {

    // The defaults will be overridden if set in $atts 
    $defaults = array( 
        'post_id'       => null,
        'thumb_size'    => 'full',
        'lazy'          => false,
        'ratings'       => true,
        'permalink'     => '#',
        'posts_cats'    => '',
        'title'         => '',
        'date'          => '',
        'author'        => '',
        'excerpt'       => '',
        'readmore'      => '',
        'placeholder'   => true,
        'posts_classes' => '',
        'classes'       => ''
    );

    // Get Options 
    $meloo_opts = meloo_opts();

    // HTML variable 
    $html = '';

    // If $atts is not array 
    if ( ! is_array( $atts ) ) {
        return false;
    }
    
    // Set default arguments 
    $atts = array_merge( $defaults, $atts );

    // Import variables into the current symbol table from an array 
    extract( $atts, EXTR_PREFIX_SAME, 'module' );

    // Ratings 
    $rating = '';
    if ( $ratings ) {
        // Has Reviews 
        $has_reviews = get_post_meta( $post_id, '_has_reviews', true );
        if ( $has_reviews ) {

            // Rating 
            $rating = get_post_meta( $post_id, '_rating', true ); 
        }
    }

    if ( ! empty( $readmore ) ) {
        $readmore = ' <a class="readmore frame-button button-l with-hover" href="' . esc_url( $permalink ) . '">
            <div class="button-layer button-layer-shadow">
                ' . esc_html__( 'Read Article', 'meloo' ) . '
            </div>
            <div class="button-inner">
                <div class="button-inner-block">
                    <div class="button-hidden-layer">
                        ' . esc_html__( 'Read Article', 'meloo' ) . '
                    </div>
                </div>
            </div>
    </a>';
    }
    if ( $placeholder ) {
        $img = meloo_get_image( $post_id, $thumb_size, 'module-thumb', $lazy, $image_id = false );
    } else if ( has_post_thumbnail( $post_id ) ) {
        $img = meloo_get_image( $post_id, $thumb_size, 'module-thumb', $lazy, $image_id = false );
    } else {
        $img = '';
        $classes .= ' no-thumb';
    }

    if ( $excerpt !== '' ) {
        $excerpt = '<div class="module-excerpt">' . $meloo_opts->esc( $excerpt ) . '</div>';
    } else {
        $excerpt = '';
    }

    // Render module 
    $html .= '
        <div class="module module-3 ' . esc_attr( $classes ) . '">
            <article class="module-inner ' . esc_attr( $posts_classes ) . '">
                <a href="' . esc_url( $permalink ) . '" class="module-link">
                    <span class="module-thumb-wrap">
                        ' . meloo_get_image( $post_id, $thumb_size, 'module-thumb', $lazy ) . '
                    </span>
                </a>
                <div class="module-info-container">
                    <div class="module-top-meta">
                        <div class="post-cats cats-style">' . $meloo_opts->esc( $posts_cats ) . '</div><div class="post-date">' . $meloo_opts->esc( $date ) . '</div><div class="post-author">' . $meloo_opts->esc( $author ) . '</div>
                    </div>
                    <h3 class="post-title"><a href="' . esc_url( $permalink ) . '" rel="bookmark" title="' . esc_attr( $title ) . '">' . $meloo_opts->esc(  $title ) . '</a></h3>
                    ' . meloo_get_stars_rating( $rating ) . '
                    ' . $meloo_opts->esc( $excerpt ) . '
                    ' . $meloo_opts->esc( $readmore ) . '
                </div>
                <div class="clear"></div>
            </article>
        </div>
        
        ';
    return $html;
}
endif;


/* ==================================================
  Module 4 
================================================== */
if ( ! function_exists( 'meloo_module4' ) ) :
function meloo_module4( $atts = array() ) {

    // The defaults will be overridden if set in $atts 
    $defaults = array( 
        'post_id'       => null,
        'thumb_size'    => 'full',
        'lazy'          => false,
        'ratings'       => true,
        'permalink'     => '#',
        'posts_cats'    => '',
        'title'         => '',
        'date'          => '',
        'author'        => '',
        'posts_classes' => '',
        'classes'       => ''
    );

    // Get Options 
    $meloo_opts = meloo_opts();

    // HTML variable 
    $html = '';

    // If $atts is not array 
    if ( ! is_array( $atts ) ) {
        return false;
    }
    
    // Set default arguments 
    $atts = array_merge( $defaults, $atts );

    // Import variables into the current symbol table from an array 
    extract( $atts, EXTR_PREFIX_SAME, 'module' );

    // Ratings 
    $rating = '';
    if ( $ratings ) {
        // Has Reviews 
        $has_reviews = get_post_meta( $post_id, '_has_reviews', true );
        if ( $has_reviews ) {

            // Rating 
            $rating = get_post_meta( $post_id, '_rating', true ); 
        }
    }

    // Render module 
    $html .= '
        <div class="module module-4 dark-bg ' . esc_attr( $classes ) . '">
            <article class="module-inner ' . esc_attr( $posts_classes ) . '">
                <a href="' . esc_url( $permalink ) . '" class="module-link">
                    ' . meloo_get_image( $post_id, $thumb_size, 'module-thumb', $lazy ) . '
                </a>
                <div class="module-info-container">
                    <div class="module-info">
                        <div class="post-meta">
                            <div class="post-cats cats-style">' . $meloo_opts->esc( $posts_cats ) . '</div><div class="post-date">' . $meloo_opts->esc( $date ) . '</div></div>
                        <h3 class="post-title">' . $meloo_opts->esc(  $title ) . '</h3>
                        '. meloo_get_stars_rating( $rating ) .'
                    </div>
                </div>
            </article>
        </div>
    ';

    return $html;
    
}
endif;


/* ==================================================
  Module 5
================================================== */
if ( ! function_exists( 'meloo_module5' ) ) :
function meloo_module5( $atts = array() ) {

    // The defaults will be overridden if set in $atts 
    $defaults = array( 
        'post_id'       => null,
        'thumb_size'    => 'full',
        'lazy'          => false,
        'ratings'       => true,
        'permalink'     => '#',
        'posts_cats'    => '',
        'title'         => '',
        'date'          => '',
        'author'        => '',
        'posts_classes' => '',
        'classes'       => ''
    );

    // Get Options 
    $meloo_opts = meloo_opts();

    // HTML variable 
    $html = '';

    // If $atts is not array 
    if ( ! is_array( $atts ) ) {
        return false;
    }
    
    // Set default arguments 
    $atts = array_merge( $defaults, $atts );

    // Import variables into the current symbol table from an array 
    extract( $atts, EXTR_PREFIX_SAME, 'module' );

    // Ratings 
    $rating = '';
    if ( $ratings ) {
        // Has Reviews 
        $has_reviews = get_post_meta( $post_id, '_has_reviews', true );
        if ( $has_reviews ) {

            // Rating 
            $rating = get_post_meta( $post_id, '_rating', true ); 
        }
    }
    $img_args = meloo_get_image_bg( $post_id, $thumb_size, $lazy, $image_id = false );

    // Render module 
    $html .= '
        <div class="module module-5 ' . esc_attr( $classes ) . '">
            <article class="module-inner ' . esc_attr( $posts_classes ) . '">
                <a href="' . esc_url( $permalink ) . '" class="module-link module-thumb ' . esc_attr( $img_args['class'] ) . '" data-src="' . esc_attr( $img_args['lazy_src'] ) . '" style="' . esc_attr( $img_args['src'] ) . '"></a>
                <div class="module-info-container overlay-gradient-1">
                    <div class="module-info">
                        <div class="post-meta">
                            <div class="post-cats cats-style">' . $meloo_opts->esc( $posts_cats ) . '</div><div class="post-date">' . $meloo_opts->esc( $date ) . '</div>
                        </div>
                        <h3 class="post-title">' . $meloo_opts->esc(  $title ) . '</h3>
                        '. meloo_get_stars_rating( $rating ) .'
                    </div>
                </div>
            </article>
        </div>
    ';

    return $html;
    
}
endif;


/* ==================================================
  Module Search
================================================== */
if ( ! function_exists( 'meloo_module_search' ) ) :
function meloo_module_search( $atts = array() ) {

    // The defaults will be overridden if set in $atts 
    $defaults = array( 
        'post_id'       => null,
        'thumb_size'    => 'full',
        'lazy'          => false,
        'ratings'       => true,
        'permalink'     => '#',
        'title'         => '',
        'date'          => '',
        'readmore'      => '',
        'placeholder'   => true,
        'posts_classes' => '',
        'classes'       => ''
    );

    // Get Options 
    $meloo_opts = meloo_opts();

    // HTML variable 
    $html = '';

    // If $atts is not array 
    if ( ! is_array( $atts ) ) {
        return false;
    }
    
    // Set default arguments 
    $atts = array_merge( $defaults, $atts );

    // Import variables into the current symbol table from an array 
    extract( $atts, EXTR_PREFIX_SAME, 'module' );

    if ( ! empty( $readmore ) ) {
        $readmore = ' <a class="readmore frame-button button-l with-hover" href="' . esc_url( $permalink ) . '">
            <div class="button-layer button-layer-shadow">
                ' . esc_html__( 'Read Article', 'meloo' ) . '
            </div>
            <div class="button-inner">
                <div class="button-inner-block">
                    <div class="button-hidden-layer">
                        ' . esc_html__( 'Read Article', 'meloo' ) . '
                    </div>
                </div>
            </div>
    </a>';
    }
    if ( $placeholder ) {
        $img = meloo_get_image( $post_id, $thumb_size, 'module-thumb', $lazy, $image_id = false );
    } else if ( has_post_thumbnail( $post_id ) ) {
        $img = meloo_get_image( $post_id, $thumb_size, 'module-thumb', $lazy, $image_id = false );
    } else {
        $img = '';
        $classes .= ' no-thumb';
    }

    // Get post type info
    $pt = get_post_type( $post_id );
    $from = esc_html__( 'Blog', 'meloo' );
    $taxonomy = '';

    switch ( $pt ) {

        case 'post':
            $from = esc_html__( 'Blog', 'meloo' );
            $taxonomy = 'category';
            break;
        case 'meloo_events':
            $from = esc_html__( 'Event', 'meloo' );
            $taxonomy = 'meloo_event_categories';
            break;
        
        case 'meloo_portfolio':
            $from = esc_html__( 'Release', 'meloo' );
            $taxonomy = 'meloo_portfolio_cats';
            break;
        case 'page':
            $from = esc_html__( 'Page', 'meloo' );
            $taxonomy = '';
            break;
    }
     
    // Render module 
    $html .= '
        <div class="module module-search ' . esc_attr( $classes ) . '">
            <article class="module-inner ' . esc_attr( $posts_classes ) . '">
                <a href="' . esc_url( $permalink ) . '" class="module-link tilt">' . $meloo_opts->esc( $img ) . '</a>
                <div class="module-info-container-wrap">
                    <div class="module-info-container">
                        <div class="module-top-meta">
                            <div class="post-from">' . $meloo_opts->esc( $from ) . '</div><div class="post-date">' . $meloo_opts->esc( $date ) . '</div>
                        </div>
                        <h3 class="post-title"><a href="' . esc_url( $permalink ) . '">' . $meloo_opts->esc(  $title ) . '</a></h3>
                    </div>
                    ' . $meloo_opts->esc( $readmore ) . '
                </div>
            </article>
        </div>';

    return $html;
    
}
endif;


/* ==================================================
  Music Module 1 
================================================== */
if ( ! function_exists( 'meloo_music_module1' ) ) :
function meloo_music_module1( $atts = array() ) {

    // The defaults will be overridden if set in $atts 
    $defaults = array( 
        'post_id'       => null,
        'thumb_size'    => 'full',
        'show_tracks'   => '',
        'lazy'          => false,
        'permalink'     => '#',
        'title'         => '',
        'posts_classes' => '',
        'classes'       => ''
    );

    // Get Options 
    $meloo_opts = meloo_opts();

    // HTML variable 
    $html = '';

    // If $atts is not array 
    if ( ! is_array( $atts ) ) {
        return false;
    }
    
    // Set default arguments 
    $atts = array_merge( $defaults, $atts );

    // Import variables into the current symbol table from an array 
    extract( $atts, EXTR_PREFIX_SAME, 'module' );
    
    if ( ! $post_id ) {
        return;
    }
    $track_id = get_post_meta( $post_id, '_track_id', true );
    $tracks_ids = get_post_meta( $post_id, '_tracks_ids', true );
    $artists = get_post_meta( $post_id, '_artists', true );
    $badge = get_post_meta( $post_id, '_badge', true );

    // Render module 
    $html .= '
        <div class="module module-music-1 anim-zoom ' . esc_attr( $classes ) . '">
            <article class="module-inner ' . esc_attr( $posts_classes ) . '">
                <div class="module-thumb-block fx-trigger">
                    <a href="' . esc_url( $permalink ) . '" class="module-link overlay-dark"></a>
                        ' . meloo_get_image( $post_id, $thumb_size, 'module-thumb', $lazy ) . '
                        <div class="module-info-container">
                            <div class="module-info">
                                <h3 class="post-title text-fx-word">' . $meloo_opts->esc( $title ) . '</h3>
                                <div class="post-meta">
                                    <div class="post-artists text-fx-word">' . $meloo_opts->esc( $artists ) . '</div>
                                </div>
                            </div>
                        </div>';
                        if ( !empty( $badge ) ) {
                            $html .='<span class="badge ' . esc_attr( $badge ) . '">' . esc_html( $badge ) . '</span>';
                        }
                        if ( ! empty( $show_tracks ) && $track_id !== 'none' && function_exists( 'sp_hidden_tracklist' ) ) {
                            $uid = 'tracklist-id-'. rand(10000 , 99999);
                            $html .= '<a href="#" data-id="' . esc_attr( $uid ) . '" class="thumb-icon trans-40 sp-play-list">
                                        <svg class="circle-svg" width="60" height="60" viewBox="0 0 50 50">
                                            <circle class="circle" cx="25" cy="25" r="23" stroke="#fff" stroke-width="1" fill="none"></circle>
                                            </svg>
                                            <span class="pe-7s-play"></span>
                                    </a>';
                            $html .= sp_hidden_tracklist( array(
                                 'id'           => $track_id,
                                 'ids'          => $tracks_ids,
                                 'tracklist_id' => esc_attr( $uid ),
                                 'ctrl'         => '',
                                 'vis'          => 'none'
                            ) );
                        }
            $html .= '</div>
            </article>
        </div>
    ';

    return $html;
    
}
endif;


/* ==================================================
  Music Module 2
================================================== */
if ( ! function_exists( 'meloo_music_module2' ) ) :
function meloo_music_module2( $atts = array() ) {

    // The defaults will be overridden if set in $atts 
    $defaults = array( 
        'post_id'       => null,
        'thumb_size'    => 'full',
        'show_tracks'   => '',
        'lazy'          => false,
        'permalink'     => '#',
        'title'         => '',
        'posts_classes' => '',
        'classes'       => ''
    );

    // Get Options 
    $meloo_opts = meloo_opts();

    // HTML variable 
    $html = '';

    // If $atts is not array 
    if ( ! is_array( $atts ) ) {
        return false;
    }
    
    // Set default arguments 
    $atts = array_merge( $defaults, $atts );

    // Import variables into the current symbol table from an array 
    extract( $atts, EXTR_PREFIX_SAME, 'module' );
    
    if ( ! $post_id ) {
        return;
    }
    $track_id = get_post_meta( $post_id, '_track_id', true );
    $tracks_ids = get_post_meta( $post_id, '_tracks_ids', true );
    $artists = get_post_meta( $post_id, '_artists', true );
    $badge = get_post_meta( $post_id, '_badge', true );

    // Render module 
    $html .= '
        <div class="module module-music-2 ' . esc_attr( $classes ) . '">
            <article class="module-inner ' . esc_attr( $posts_classes ) . '">
                <div class="module-thumb-block">
                    <a href="' . esc_url( $permalink ) . '" class="module-link overlay-dark"></a>
                    ' . meloo_get_image( $post_id, $thumb_size, 'module-thumb', $lazy );
                    if ( !empty( $badge ) ) {
                        $html .='<span class="badge ' . esc_attr( $badge ) . '">' . esc_html( $badge ) . '</span>';
                    }
                    if ( ! empty( $show_tracks ) && $track_id !== 'none' && function_exists( 'sp_hidden_tracklist' ) ) {
                        $uid = 'tracklist-id-'. rand(10000 , 99999);
                        $html .= '<a href="#" data-id="' . esc_attr( $uid ) . '" class="thumb-icon trans-40 sp-play-list">
                                    <svg class="circle-svg" width="60" height="60" viewBox="0 0 50 50">
                                        <circle class="circle" cx="25" cy="25" r="23" stroke="#fff" stroke-width="1" fill="none"></circle>
                                        </svg>
                                        <span class="pe-7s-play"></span>
                                </a>';
                        $html .= sp_hidden_tracklist( array(
                             'id'           => $track_id,
                             'ids'          => $tracks_ids,
                             'tracklist_id' => esc_attr( $uid ),
                             'ctrl'         => '',
                             'vis'          => 'none'
                        ) );
                    }
                    $html .= '
                </div>
                <div class="module-info-container">
                    <div class="module-info">
                        <div class="post-meta">
                            <div class="post-artists">' . $meloo_opts->esc( $artists ) . '</div>
                        </div>
                        <h3 class="post-title"><a href="' . esc_url( $permalink ) . '">' . $meloo_opts->esc(  $title ) . '</a></h3>
                    </div>
                </div>
            </article>';
            if ( ! empty( $show_tracks ) && $track_id !== 'none' && function_exists( 'sp_hidden_tracklist' ) ) {
                $uid = 'tracklist-id-'. rand(10000 , 99999);
                $html .= sp_hidden_tracklist( array(
                     'id'           => $track_id,
                     'ids'          => $tracks_ids,
                     'tracklist_id' => esc_attr( $uid ),
                     'ctrl'         => '',
                     'vis'          => 'none'
                ) );
            }
        $html .= '</div>';

    return $html;
    
}
endif;


/* ==================================================
  Music Module 3
================================================== */
if ( ! function_exists( 'meloo_music_module3' ) ) :
function meloo_music_module3( $atts = array() ) {

    // The defaults will be overridden if set in $atts 
    $defaults = array( 
        'post_id'       => null,
        'thumb_size'    => 'full',
        'show_tracks'   => '',
        'lazy'          => false,
        'permalink'     => '#',
        'title'         => '',
        'posts_classes' => '',
        'classes'       => ''
    );

    // Get Options 
    $meloo_opts = meloo_opts();

    // HTML variable 
    $html = '';

    // If $atts is not array 
    if ( ! is_array( $atts ) ) {
        return false;
    }
    
    // Set default arguments 
    $atts = array_merge( $defaults, $atts );

    // Import variables into the current symbol table from an array 
    extract( $atts, EXTR_PREFIX_SAME, 'module' );
    
    if ( ! $post_id ) {
        return;
    }
    $track_id = get_post_meta( $post_id, '_track_id', true );
    $tracks_ids = get_post_meta( $post_id, '_tracks_ids', true );
    $artists = get_post_meta( $post_id, '_artists', true );
    $badge = get_post_meta( $post_id, '_badge', true );

    $img_args = meloo_get_image_bg( $post_id, $thumb_size, $lazy, $image_id = false );

    // Render module 
    $html .= '
        <div class="module module-music-3 ' . esc_attr( $classes ) . '">
            <article class="module-inner ' . esc_attr( $posts_classes ) . '">
                <div class="module-thumb-block fx-trigger">
                    <a href="' . esc_url( $permalink ) . '" class="module-link"></a>
                     <div class="module-thumb ' . esc_attr( $img_args['class'] ) . '" data-src="' . esc_attr( $img_args['lazy_src'] ) . '" style="' . esc_attr( $img_args['src'] ) . '"></div>
                    <div class="overlay-dark"></div>
                    <div class="module-info-container">
                        <div class="module-info">
                            <h3 class="post-title text-fx-word">' . $meloo_opts->esc( $title ) . '</h3>
                            <div class="post-meta">
                                <div class="post-artists text-fx-word">' . $meloo_opts->esc( $artists ) . '</div>
                            </div>
                        </div>
                    </div>';
                    if ( !empty( $badge ) ) {
                        $html .='<span class="badge ' . esc_attr( $badge ) . '">' . esc_html( $badge ) . '</span>';
                    }
                    if ( ! empty( $show_tracks ) && $track_id !== 'none' && function_exists( 'sp_hidden_tracklist' ) ) {
                        $uid = 'tracklist-id-'. rand(10000 , 99999);
                        $html .= '<a href="#" data-id="' . esc_attr( $uid ) . '" class="thumb-icon trans-40 sp-play-list">
                                    <svg class="circle-svg" width="60" height="60" viewBox="0 0 50 50">
                                        <circle class="circle" cx="25" cy="25" r="23" stroke="#fff" stroke-width="1" fill="none"></circle>
                                        </svg>
                                        <span class="pe-7s-play"></span>
                                </a>';
                        $html .= sp_hidden_tracklist( array(
                             'id'           => $track_id,
                             'ids'          => $tracks_ids,
                             'tracklist_id' => esc_attr( $uid ),
                             'ctrl'         => '',
                             'vis'          => 'none'
                        ) );
                    }
            $html .= '</div>
            </article>
        </div>
    ';

    return $html;
    
}
endif;


/* ==================================================
  Event Module 1 (List)
================================================== */
if ( ! function_exists( 'meloo_event_module1' ) ) :
function meloo_event_module1( $atts = array() ) {

    // The defaults will be overridden if set in $atts 
    $defaults = array( 
        'post_id'       => null,
        'permalink'     => '#',
        'title'         => '',
        'posts_classes' => '',
        'classes'       => ''
    );

    // Get Options 
    $meloo_opts = meloo_opts();

    // HTML variable 
    $html = '';

    // If $atts is not array 
    if ( ! is_array( $atts ) ) {
        return false;
    }
    
    // Set default arguments 
    $atts = array_merge( $defaults, $atts );

    // Import variables into the current symbol table from an array 
    extract( $atts, EXTR_PREFIX_SAME, 'module' );
    
    if ( ! $post_id ) {
        return;
    }
    
    // Event Date 
    $event_time_start = get_post_meta( $post_id, '_event_time_start', true );
    $event_date_start = get_post_meta( $post_id, '_event_date_start', true );
    $event_date_start = strtotime( $event_date_start );
    $event_date_end = strtotime( get_post_meta( $post_id, '_event_date_end', true ) );

    // Event data 
    $city = get_post_meta( $post_id, '_city', true );
    $place = get_post_meta( $post_id, '_place', true );
    $address = get_post_meta( $post_id, '_address', true );
    $ticket_status = get_post_meta( $post_id, '_ticket_status', true );
    if ( $ticket_status === 'available' ) {
        $ticket_link = get_post_meta( $post_id, '_ticket_link', true );
        $new_window = get_post_meta( $post_id, '_ticket_nw', true );
        if ( $new_window === 'yes' ) {
           $new_window = 'target="_blank"';
        } else {
            $new_window = '';
        }
    }

    // Render module 
    $html .= '
        <div class="module module-event-1 ' . esc_attr( $classes ) . '">
            <article class="module-inner ' . esc_attr( $posts_classes ) . '">
                <div class="left-event-block">
                    <div class="date-event">
                        <div class="day-event">' . date_i18n( 'd', $event_date_start ) . '</div>
                        <div class="month-year-event">
                            <div class="month-event">' . date_i18n( 'F', $event_date_start ) . '</div>
                            <div class="year-event">' . date_i18n( 'Y', $event_date_start ) . '</div>
                        </div>
                    </div>
                    <div class="location-event">
                        <a href="' . esc_url( $permalink ) . '" class="link-layer"></a>
                        <div class="event-name">' . $meloo_opts->esc( $title ) . '</div>
                        <div class="city-name">' . $meloo_opts->esc( $place ) . ' - ' . $meloo_opts->esc( $city ) . '</div>
                    </div>
                </div>
                <div class="right-event-block">';

                    if ( $ticket_status === 'available' ) {
                        $html .= '<a href="' . esc_url( $ticket_link ) . '" class="line-link" ' . $meloo_opts->esc( $new_window ) . '>';
                    } else {
                        $html .= '<a class="ticket-status ticket-status-' . esc_attr( $ticket_status ) . '">';
                    }

                        switch ($ticket_status) {
                            case 'available':
                                $html .= esc_html__( 'Buy Tickets', 'meloo' );  
                                break;
                            case 'free':
                                $html .= esc_html__( 'Free', 'meloo' ); 
                                break;
                            case 'cancelled':
                                $html .= esc_html__( 'Cancelled', 'meloo' ); 
                                break;
                            case 'sold':
                                $html .= esc_html__( 'Sold Out', 'meloo' ); 
                                break;
                        }


                    $html .= '</a>';


                $html .= '</div>
            </article>
        </div>
    ';

    return $html;
}
endif;


/* ==================================================
  Event Module 2
================================================== */
if ( ! function_exists( 'meloo_event_module2' ) ) :
function meloo_event_module2( $atts = array() ) {

    // The defaults will be overridden if set in $atts 
    $defaults = array( 
        'post_id'       => null,
        'permalink'     => '#',
        'thumb_size'    => 'large',
        'lazy'          => false,
        'title'         => '',
        'posts_classes' => '',
        'classes'       => ''
    );

    // Get Options 
    $meloo_opts = meloo_opts();

    // HTML variable 
    $html = '';

    // If $atts is not array 
    if ( ! is_array( $atts ) ) {
        return false;
    }
    
    // Set default arguments 
    $atts = array_merge( $defaults, $atts );

    // Import variables into the current symbol table from an array 
    extract( $atts, EXTR_PREFIX_SAME, 'module' );

    // Event Date 
    $event_time_start = get_post_meta( $post_id, '_event_time_start', true );
    $event_date_start = get_post_meta( $post_id, '_event_date_start', true );
    $event_date_start = strtotime( $event_date_start );
    $event_date_end = strtotime( get_post_meta( $post_id, '_event_date_end', true ) );

    // Event data 
    $city = get_post_meta( $post_id, '_city', true );
    $place = get_post_meta( $post_id, '_place', true );
    $address = get_post_meta( $post_id, '_address', true );
    $ticket_status = get_post_meta( $post_id, '_ticket_status', true );
    if ( $ticket_status === 'available' ) {
        $ticket_link = get_post_meta( $post_id, '_ticket_link', true );
        $new_window = get_post_meta( $post_id, '_ticket_nw', true );
        if ( $new_window === 'on' ) {
           $new_window = 'target="_blank"';
        } else {
            $new_window = '';
        }
    }

    // Ticket Button 
    $ticket_button = '';
    if ( $ticket_status === 'availablee' ) {
        $ticket_button = ' <a class="readmore frame-button button-l with-hover" href="' . esc_url( $ticket_link ) . '" ' . $meloo_opts->esc( $new_window ) . '>
            <div class="button-layer button-layer-shadow">
                ' . esc_html__( 'Buy Tickets', 'meloo' ) . '
            </div>
            <div class="button-inner">
                <div class="button-inner-block">
                    <div class="button-hidden-layer">
                        ' . esc_html__( 'Buy Tickets', 'meloo' ) . '
                    </div>
                </div>
            </div>
    </a>';
    }

    $img = meloo_get_image( $post_id, $thumb_size, 'module-thumb', $lazy, $image_id = false );
   
    // Render module 
    $html .= '
        <div class="module module-event-2 ' . esc_attr( $classes ) . '">
            <article class="module-inner ' . esc_attr( $posts_classes ) . '">
                <a href="' . esc_url( $permalink ) . '" class="module-link"></a>
                ' . $meloo_opts->esc( $img ) . '
                <div class="module-info-container-wrap">
                    <div class="module-info-container">
                        <div class="date-event">
                            <div class="day-event">' . date_i18n( 'd', $event_date_start ) . '</div>
                            <div class="month-year-event">
                                <div class="month-event">' . date_i18n( 'F', $event_date_start ) . '</div>
                                <div class="year-event">' . date_i18n( 'Y', $event_date_start ) . '</div>
                            </div>
                        </div>
                        <div class="location-event">
                            <h2 class="event-name"><a href="' . esc_url( $permalink ) . '">' . $meloo_opts->esc( $title ) . '</a></h2>
                            <div class="city-name">' . $meloo_opts->esc( $place ) . ' - ' . $meloo_opts->esc( $city ) . '</div>
                        </div>
                    </div>
                    ' . $meloo_opts->esc( $ticket_button ) . '
                </div>
            </article>
        </div>';

    return $html;
    
}
endif;


/* ==================================================
  Gallery Module 1 
================================================== */
if ( ! function_exists( 'meloo_gallery_module1' ) ) :
function meloo_gallery_module1( $atts = array() ) {

    // The defaults will be overridden if set in $atts 
    $defaults = array( 
        'post_id'       => null,
        'thumb_size'    => 'full',
        'lazy'          => false,
        'permalink'     => '#',
        'posts_cats'    => '',
        'title'         => '',
        'date'          => '',
        'author'        => '',
        'posts_classes' => '',
        'classes'       => ''
    );

    // Get Options 
    $meloo_opts = meloo_opts();

    // HTML variable 
    $html = '';

    // If $atts is not array 
    if ( ! is_array( $atts ) ) {
        return false;
    }
    
    // Set default arguments 
    $atts = array_merge( $defaults, $atts );

    // Import variables into the current symbol table from an array 
    extract( $atts, EXTR_PREFIX_SAME, 'module' );

    // Images number 
    $images_ids = get_post_meta( $post_id, '_images', true ); 

    if ( $images_ids || $images_ids !== '' ) {
        $images_number = explode( '|', $images_ids );
        $images_number = count( $images_number );
    } else {
        $images_number = '0';
    }

    if ( function_exists( 'meloo_get_taxonomies' ) ) {
        $tax_args = array(
            'id' => $post_id,
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

    // Render module 
    $html .= '
        <div class="module module-gallery-1 dark-bg ' . esc_attr( $classes ) . '">
            <article class="module-inner ' . esc_attr( $posts_classes ) . '">
                <a href="' . esc_url( $permalink ) . '" class="module-link">
                    ' . meloo_get_image( $post_id, $thumb_size, 'module-thumb', $lazy ) . '
                </a>
                <div class="module-info-container overlay-gradient-1">
                    <div class="module-info">
                        <div class="post-meta">
                            <div class="post-cats cats-style">' . $meloo_opts->esc( $posts_cats ) . '</div><div class="images-number">' . $meloo_opts->esc( $images_number ) . ' ' .  esc_html__('Photos', 'meloo') .'</div>
                        </div>
                        <h3 class="post-title">' . $meloo_opts->esc(  $title ) . '</h3>
                    </div>
                </div>
            </article>
        </div>
    ';

    return $html;
    
}
endif;


/* ==================================================
  Video Module 1 
================================================== */
if ( ! function_exists( 'meloo_video_module1' ) ) :
function meloo_video_module1( $atts = array() ) {

    // The defaults will be overridden if set in $atts 
    $defaults = array( 
        'post_id'       => null,
        'thumb_size'    => 'full',
        'lazy'          => false,
        'ca'            => 'open_in_player',
        'permalink'     => '#',
        'title'         => '',
        'posts_classes' => '',
        'classes'       => ''
    );

    // Get Options 
    $meloo_opts = meloo_opts();

    // HTML variable 
    $html = '';

    // If $atts is not array 
    if ( ! is_array( $atts ) ) {
        return false;
    }
    
    // Set default arguments 
    $atts = array_merge( $defaults, $atts );

    // Import variables into the current symbol table from an array 
    extract( $atts, EXTR_PREFIX_SAME, 'module' );

    $url = get_post_meta( $post_id, '_video_url', true );

    if (strpos( $url, 'youtube') > 0) {
        $type = 'youtube';
    } elseif (strpos($url, 'youtu.be') > 0) {
        $type = 'youtube';
    } elseif (strpos($url, 'vimeo') > 0) {
        $type = 'vimeo';
    } else {
        $type = 'unknown';
    }

    if ( $type !== 'unknown' ) {

        $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $thumb_size );

        if ( isset( $img_src ) && $img_src[0] !== '' ) {
            $img_src = $img_src[0];
        } else {
            $img_src = '';
        }

        if ( $ca === 'open_in_lightbox' ) {
            $href = $url;
            $video_classes = 'iframebox';
        } else if ( $ca === 'open_on_page' ) {
            $href = $permalink;
            $video_classes = 'permalink';
        } else {
            $href = '#';
            $video_classes = '';
        }

        // Render module 
        $html .= '
            <div class="module module-video-1 dark-bg ' . esc_attr( $classes ) . '">
                <article class="module-inner ' . esc_attr( $posts_classes ) . '">';

                    if ( $type === 'youtube' ) {
                        preg_match( "/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches );
                        $html .= '<a href="' . esc_url( $href ) . '" class="youtube media ' . esc_attr( $video_classes ) . '" id="' . esc_attr( $matches[1] ) . '" data-cover="' . esc_attr( $img_src ) . '" data-params="related=0" data-ca="' . esc_attr( $ca ) . '"></a>';
                    } elseif ( $type === 'vimeo' ) {
                        preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $url, $matches  );
                        $html .= '<a href="' . esc_url( $href ) . '" class="vimeo media ' . esc_attr( $video_classes ) . '" id="' . esc_attr( $matches[5] ) . '" data-cover="' . esc_attr( $img_src ) . '" data-params="portrait=0" data-ca="' . esc_attr( $ca ) . '"></a>';
                    }
                $html .= '</article>
            </div>
        ';
        }
    return $html;
    
}
endif;


/* ==================================================
  Artist Module 1
================================================== */
if ( ! function_exists( 'meloo_artist_module1' ) ) :
function meloo_artist_module1( $atts = array() ) {

    // The defaults will be overridden if set in $atts 
    $defaults = array( 
        'post_id'       => null,
        'permalink'     => '#',
        'thumb_size'    => 'large',
        'lazy'          => false,
        'title'         => '',
        'posts_classes' => '',
        'classes'       => ''
    );

    // Get Options 
    $meloo_opts = meloo_opts();

    // HTML variable 
    $html = '';

    // If $atts is not array 
    if ( ! is_array( $atts ) ) {
        return false;
    }
    
    // Set default arguments 
    $atts = array_merge( $defaults, $atts );

    // Import variables into the current symbol table from an array 
    extract( $atts, EXTR_PREFIX_SAME, 'module' );

    $img = meloo_get_image( $post_id, $thumb_size, 'module-thumb', $lazy, $image_id = false );
   
    // Render module 
    $html .= '
        <div class="module module-artist-1 ' . esc_attr( $classes ) . '">
            <article class="module-inner ' . esc_attr( $posts_classes ) . '">
                <a href="' . esc_url( $permalink ) . '" class="module-link"></a>
                ' . $meloo_opts->esc( $img ) . '
                <div class="module-info-container-wrap">
                    <div class="module-info-container">
                        <h2 class="artist-name"><a href="' . esc_url( $permalink ) . '">' . $meloo_opts->esc( $title ) . '</a></h2>
                    </div>
                </div>
            </article>
        </div>';

    return $html;
    
}
endif;