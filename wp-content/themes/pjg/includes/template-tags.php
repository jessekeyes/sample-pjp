<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package pjg
 */

if ( ! function_exists( 'the_posts_navigation' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function the_posts_navigation() {
  // Don't print empty markup if there's only one page.
  if ( $GLOBALS[ 'wp_query' ]->max_num_pages < 2 ) {
    return;
  }
  ?>
  <nav class="navigation posts-navigation" role="navigation">
    <h2 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'pjg' ); ?></h2>
    <div class="nav-links">

      <?php if ( get_next_posts_link() ) : ?>
      <div class="nav-previous"><?php next_posts_link( esc_html__( 'Older posts', 'pjg' ) ); ?></div>
      <?php endif; ?>

      <?php if ( get_previous_posts_link() ) : ?>
      <div class="nav-next"><?php previous_posts_link( esc_html__( 'Newer posts', 'pjg' ) ); ?></div>
      <?php endif; ?>

    </div><!-- .nav-links -->
  </nav><!-- .navigation -->
  <?php
}
endif;

if ( ! function_exists( 'the_post_navigation' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function the_post_navigation() {
  // Don't print empty markup if there's nowhere to navigate.
  $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
  $next     = get_adjacent_post( false, '', false );

  if ( ! $next && ! $previous ) {
    return;
  }
  ?>
  <nav class="navigation post-navigation" role="navigation">
    <h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'pjg' ); ?></h2>
    <div class="nav-links">
      <?php
        previous_post_link( '<div class="nav-previous">%link</div>', '%title' );
        next_post_link( '<div class="nav-next">%link</div>', '%title' );
      ?>
    </div><!-- .nav-links -->
  </nav><!-- .navigation -->
  <?php
}
endif;

if ( ! function_exists( 'pjg_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function pjg_posted_on( $post_type = '', $is_feed = false, $is_ajax = false, $is_search_ajax = false ) {


  if ( $post_type != 'event' && is_single() ) {

    $time_string = '<time class="post-date published" datetime="%1$s">%2$s</time>';

  } elseif ( $post_type != 'event' && !is_single() ) {

    $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

  } else {

    $time_string = '<time class="event-date published" datetime="%1$s">%2$s</time>';

  }

  $event_date_start = strtotime( get_post_meta( get_the_ID(), '_event_start_date', true ) );
  $event_date_end = strtotime( get_post_meta( get_the_ID(), '_event_end_date', true ) );

  $event_time_start = ( '00' != date( 'i', strtotime( get_post_meta( get_the_ID(), '_event_start_time', true ) ) ) ) ? date( 'g:ia', strtotime( get_post_meta( get_the_ID(), '_event_start_time', true ) ) ) : date( 'ga', strtotime( get_post_meta( get_the_ID(), '_event_start_time', true ) ) );
  $event_time_end = ( '00' != date( 'i', strtotime( get_post_meta( get_the_ID(), '_event_end_time', true ) ) ) ) ? date( 'g:ia', strtotime( get_post_meta( get_the_ID(), '_event_end_time', true ) ) ) : date( 'ga', strtotime( get_post_meta( get_the_ID(), '_event_end_time', true ) ) );;

  if( $event_date_start === $event_date_end ) {

    $event_date = date( 'F d, Y', $event_date_start );

  } else {

    $event_date = date( 'F d, Y', $event_date_start ) . ' - ' . date( 'F d, Y', $event_date_end );

  };

  $event_time = ( !get_post_meta( get_the_ID(), '_event_all_day', true ) ) ? $event_time_start . ' - ' . $event_time_end : get_option( 'dbem_event_all_day_message', 'All Day' );

  $event_time = '<span class="the-time"> / ' . $event_time . '</span>';

  $event_date = $event_date . $event_time;

  $event_date = ( !get_field( 'date_display', get_the_ID() ) ) ? $event_date : get_field( 'date_display', get_the_ID() ) . $event_time;

  $event_date = ( !get_field( 'tbd', get_the_ID() ) ) ? $event_date : 'Date to be Announced';


  $time_string = ( $post_type != 'event' ) ? sprintf( $time_string, esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date() ) ) : sprintf( $time_string, esc_attr( date( 'c', strtotime( get_post_meta( get_the_ID(), '_event_start_date', true ) ) ) ),  $event_date );


  $posted_on = ( $post_type != 'event' ) ? sprintf( esc_html_x( ' on %s', 'post date', 'pjg' ), $time_string ) : sprintf( esc_html_x( '%s', 'event date', 'pjg' ), $time_string ) ;

  $posted_on = (  $post_type != 'event' && !is_home() && !$is_feed ) ? $posted_on : sprintf( esc_html_x( '%s', 'post date', 'pjg' ), $time_string );

  $posted_on = (   $is_search_ajax && $post_type != 'event' || is_search() && $post_type != 'event' ) ? sprintf( esc_html_x( 'Published on %s', 'post date', 'pjg' ), $time_string ) : $posted_on;

  $perm_start = ( is_archive() && !$is_feed || is_home() || $is_ajax ) ? '<a class="permalink" href="' . get_permalink( get_the_ID() ) . '">' : '';
  $perm_end = ( is_archive() && !$is_feed || is_home() || $is_ajax ) ? '</a>' : '';

  $byline = ( $post_type != 'event' && !is_home() && !$is_feed ) ? sprintf( esc_html_x( 'Posted by %s', 'post author', 'pjg' ), '<span class="author vcard">' . esc_html( get_the_author() ) . '</span>' ) : '';

  echo ( $byline != '' ) ? '<span class="byline"> ' . $byline . '</span>' : '';
  echo '<span class="posted-on">' . $perm_start . $posted_on . $perm_end . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'pjg_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function pjg_entry_footer() {
  // Hide category and tag text for pages.
  if ( 'post' == get_post_type() ) {
    /* translators: used between list items, there is a space after the comma */
    $categories_list = get_the_category_list( esc_html__( ', ', 'pjg' ) );
    if ( $categories_list ) {
      printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'pjg' ) . '</span>', $categories_list ); // WPCS: XSS OK.
    }

    /* translators: used between list items, there is a space after the comma */
    $tags_list = get_the_tag_list( '', esc_html__( ', ', 'pjg' ) );
    if ( $tags_list ) {
      printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'pjg' ) . '</span>', $tags_list ); // WPCS: XSS OK.
    }
  }

  if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
    echo '<span class="comments-link">';
    comments_popup_link( esc_html__( 'Leave a comment', 'pjg' ), esc_html__( '1 Comment', 'pjg' ), esc_html__( '% Comments', 'pjg' ) );
    echo '</span>';
  }

  edit_post_link( esc_html__( 'Edit', 'pjg' ), '<span class="edit-link">', '</span>' );
}
endif;

if ( ! function_exists( 'the_archive_title' ) ) :
/**
 * Shim for `the_archive_title()`.
 *
 * Display the archive title based on the queried object.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function the_archive_title( $before = '', $after = '' ) {
  if ( is_category() ) {
    $title = sprintf( esc_html__( '%s', 'pjg' ), single_cat_title( '', false ) );
  } elseif ( is_tag() ) {
    $title = sprintf( esc_html__( 'Tag: %s', 'pjg' ), single_tag_title( '', false ) );
  } elseif ( is_author() ) {
    $title = sprintf( esc_html__( 'Author: %s', 'pjg' ), '<span class="vcard">' . get_the_author() . '</span>' );
  } elseif ( is_year() ) {
    $title = sprintf( esc_html__( 'Year: %s', 'pjg' ), get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'pjg' ) ) );
  } elseif ( is_month() ) {
    $title = sprintf( esc_html__( 'Month: %s', 'pjg' ), get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'pjg' ) ) );
  } elseif ( is_day() ) {
    $title = sprintf( esc_html__( 'Day: %s', 'pjg' ), get_the_date( esc_html_x( 'F j, Y', 'daily archives date format', 'pjg' ) ) );
  } elseif ( is_tax( 'post_format' ) ) {
    if ( is_tax( 'post_format', 'post-format-aside' ) ) {
      $title = esc_html_x( 'Asides', 'post format archive title', 'pjg' );
    } elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
      $title = esc_html_x( 'Galleries', 'post format archive title', 'pjg' );
    } elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
      $title = esc_html_x( 'Images', 'post format archive title', 'pjg' );
    } elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
      $title = esc_html_x( 'Videos', 'post format archive title', 'pjg' );
    } elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
      $title = esc_html_x( 'Quotes', 'post format archive title', 'pjg' );
    } elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
      $title = esc_html_x( 'Links', 'post format archive title', 'pjg' );
    } elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
      $title = esc_html_x( 'Statuses', 'post format archive title', 'pjg' );
    } elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
      $title = esc_html_x( 'Audio', 'post format archive title', 'pjg' );
    } elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
      $title = esc_html_x( 'Chats', 'post format archive title', 'pjg' );
    }
  } elseif ( is_post_type_archive() ) {
    $title = sprintf( esc_html__( 'Archives: %s', 'pjg' ), post_type_archive_title( '', false ) );
  } elseif ( is_tax() ) {
    $tax = get_taxonomy( get_queried_object()->taxonomy );
    /* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
    $title = sprintf( esc_html__( '%1$s: %2$s', 'pjg' ), $tax->labels->singular_name, single_term_title( '', false ) );
  } else {
    $title = esc_html__( 'Archives', 'pjg' );
  }

  /**
   * Filter the archive title.
   *
   * @param string $title Archive title to be displayed.
   */
  $title = apply_filters( 'get_the_archive_title', $title );

  if ( ! empty( $title ) ) {
    echo $before . $title . $after;  // WPCS: XSS OK.
  }
}

apply_filters( 'get_the_archive_title', $title );


endif;

if ( ! function_exists( 'the_archive_description' ) ) :
/**
 * Shim for `the_archive_description()`.
 *
 * Display category, tag, or term description.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_archive_description( $before = '', $after = '' ) {
  $description = apply_filters( 'get_the_archive_description', term_description() );

  if ( ! empty( $description ) ) {
    /**
     * Filter the archive description.
     *
     * @see term_description()
     *
     * @param string $description Archive description to be displayed.
     */
    echo $before . $description . $after;  // WPCS: XSS OK.
  }
}
endif;


/**
 * A utility template tag to return terms for display on an excerpt
 * Uses same parameters as `the_terms`
 */
function pjg_the_excerpt_terms( $id=0, $taxonomy='', $before='', $sep=', ', $after='' ){
  $has_photos = false;

  // gather terms
  $terms = get_the_terms($id, $taxonomy);

  $terms_sort = array();

  // add cat order ACF to another array
  foreach( $terms as $the_term ){

    $term_order = get_field( 'category_order', 'category_' . $the_term->term_id );

    $terms_sort[] = array( 'term_id' => $the_term->term_id, 'term_order' => $term_order );

  }

  //sort by order

  usort($terms_sort, function($a, $b) {

    if ($a['term_order'] == $b['term_order']) {
      return;
    } else {
      return ($b['term_order'] < $a['term_order']);
    }

  });


  // now, get all the terms according to these IDs,
  $term_IDs = wp_list_pluck( $terms_sort, 'term_id' );

  $args = array( 'taxonomy' => $taxonomy, 'include' =>  $term_IDs, 'orderby'=>'include' );

  $terms = get_terms( $args );

  if ( is_wp_error( $terms ) )
    return $terms;

  if ( empty( $terms ) )
    return false;

  // is 'photos' one of the categories?
  foreach( $terms as $the_term ){
    if( 'photos' == $the_term->slug ) $has_photos = true;
  }

  if( $has_photos && ( is_page( 'events') || is_home() || is_archive() ) ) {
    // if $has_photos, filter out all other terms
    $terms = array_filter($terms, function($term){
      return ( 'photos' == $term->slug );
    });
  }elseif( is_page( 'events') || is_home() || is_archive() ){
    // limit the amount of terms to 3 on archives only
    $terms = array_slice($terms, 0, 3);
  }

  $links = array();

  foreach ( $terms as $term ) {
    $link = get_term_link( $term, $taxonomy );
    if ( is_wp_error( $link ) ) {
      return $link;
    }
    $links[] = '<span class="category ' . $term->slug . '">' . $term->name . '</span>';
  };

  $terms_display = apply_filters( 'the_terms', $links, $taxonomy, '', '' );
  //
  return $before . join( $sep, $terms_display ) . $after;

}


// function to build out an return excerpt-ready image

function pjg_get_featured_image_excerpt( $post_id, $size ) {

  $attachment_id = 0;

  $attachments = get_attached_media( 'image', $post_id );

  // special cases based on thumbnail size
  $special_sizes = array( 'child-one', 'child-two', 'child-middle' );


  // if they have a proper featured image, use that
  if( has_post_thumbnail( $post_id ) ) {

    $attachment_id = get_post_thumbnail_id( $post_id );

    // check if using ACF featured image
  } elseif( get_field( 'media', $post_id ) == 'image' && get_field( 'featured_image', $post_id ) != '' ) {

    $image = get_field( 'featured_image', $post_id );

    $attachment_id = $image['id'];

    // else see if there's an image used in a featured gallery, use the first one
  } elseif( get_field( 'media', $post_id ) == 'gallery' && get_field( 'feature_gallery', $post_id ) != '' ) {

    $images = get_field( 'feature_gallery', $post_id );

    $attachment_id = $images[0]['ID'];

    // return print_r( $images );

    // else look for first attached image to post (not the most reliable)
  } elseif( !empty( $attachments ) ) {

    $attachments = array_values( $attachments );

    $attachment_id = $attachments[0]->ID;

  } else {

    // fail and return no image

    return false;

  }


  // check special cases
  if( in_array( $size, $special_sizes ) ) {

    $image = wp_get_attachment_image_src( $attachment_id, $size );

    ob_start();

    ?>

    <picture>
      <!--[if IE 9]><video style="display: none;"><![endif]-->
      <source media="(min-width: 768px)" srcset="<?php echo $image[0] ; ?>">
      <!--[if IE 9]></video><![endif]-->
      <?php echo wp_get_attachment_image( $attachment_id, 'post-tile' ); ?>
    </picture>

    <?php

    // return the template output
    return ob_get_clean();

  } else {

    // set up image output and return
    return wp_get_attachment_image( $attachment_id, $size );

  }





}
