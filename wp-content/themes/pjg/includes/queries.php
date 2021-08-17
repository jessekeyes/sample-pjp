<?php
/**
 * pjg Special Queries
 *
 * @package pjg
 */

if ( ! function_exists( 'home_featured_posts' ) ) :
  /**
   * Return X posts.
   *
   * @uses WP_Query
   *
   * @since 0.1.0
   */

  function home_featured_posts() {

    $home_featured_posts_args = array(

    );

    return new WP_Query( $home_featured_posts_args );

  }

endif; //home_featured_posts



// alter queries
add_action( 'pre_get_posts', 'pjg_pre_get_posts' );

function pjg_pre_get_posts( $query ) {

    // skip admin and non-main queries
    if(is_admin() || !$query->is_main_query()) return $query;

    // if is post type event show only the next recurrence of a series.
    if ( is_post_type_archive( 'event' ) ) {

      $events_in = pjg_event_recurrence( $query->query_vars );

      if( !empty( $events_in ) ) {

        $query->set( 'post__in', $events_in );

        $query->set( 'orderby', 'post__in' );

        return $query;

      } else {

        return $query->set( 'no_events', true );

      }

    }

    // if news/post archive
    if ( is_home() ) {

      // set query meta_query
      $query->set( 'meta_key', 'is_sticky' );
      $query->set( 'orderby', array( 'is_sticky' => 'DESC', 'post_date' => 'DESC' ) );

      return $query;

    }


  return $query;

}


// gets a list of event ids (single events, or the next upcoming recurrence for repeating events)
// with event date and sticky ordering applied
function pjg_event_recurrence( $query ) {

  // default search for events from today -> 2 years from now
  $today = date( 'Y-m-d' );
  $startdate = ( is_array( $query ) && $query[ 'query_start_date' ] ) ? $query[ 'query_start_date' ] : $today;
  $enddate = ( is_array( $query ) && $query[ 'query_end_date' ] ) ? $query[ 'query_end_date' ] : date('Y-m-d', strtotime( $today. ' + 2 years')); // upper search limit to limit crazy recurrences

  // run the query to get all recurring events
  $event_args = array(
    'post_type' => 'event',
    'posts_per_page' => -1,     // get all possible results, to parse down
    'post_status' => 'publish',
    'orderby' => 'recurrence_id,event_start_date,event_start_time,event_name',
    'meta_query' => array(
      'relation' => 'AND',
        array( // is recurrecne
          'key'  => '_recurrence_id',
          'value' => 0,
          'compare' => '>',
        ),
        array(
          'key' => '_event_end_date',
          'value' => $startdate,
          'compare' => '>=',
          'type' => 'DATE'
        ),
        array(
          'key' => '_event_start_date',
          'value' => $enddate,
          'compare' => '<=',
          'type' => 'DATE'
        ),
      ),
  );

  // merge with query to make sure query_vars are retained, if present
  if( is_array( $query ) ) {

    $event_args = array_merge( $query, $event_args );

  }

  // set up post object
  $event_recurring_all = new WP_Query( $event_args );
  $event_recurring_all = $event_recurring_all->posts;

  // strip out all but the first instance
  $event_recurring_one = event_recurring_one( $event_recurring_all );

  // get list of ALL recurrences to strip from all events below
  $event_recurring_all = wp_list_pluck( $event_recurring_all, 'ID' );

  // get single events
  $event_args_single = array(
    'post_type' => 'event',
    'posts_per_page' => -1, // get all possible results, to parse down
    'post_status' => 'publish',
    'post__not_in' => $event_recurring_all, // strip out recurrences
    'orderby' => 'event_start_date,event_start_time,event_name',
    'meta_query' => array(
      'relation' => 'AND',
        array(
          'key' => '_event_end_date',
          'value' => $startdate,
          'compare' => '>=',
          'type' => 'DATE'
        ),
        array(
          'key' => '_event_start_date',
          'value' => $enddate,
          'compare' => '<=',
          'type' => 'DATE'
        ),
      ),
  );

  // check for query vars from ajax filter
  if( is_array( $query ) ) {
    $event_args_single = array_merge( $query, $event_args_single );
  }

  // set up object
  $event_single = new WP_Query( $event_args_single );
  $event_single = $event_single->posts;

  // set up object of all single events that returned true
  $event_single_obj = $event_single;

  // merge both objects
  $events_all = array_merge( $event_single_obj, $event_recurring_one );

  // reorder the IDs by the sticky flag
  $events_all_final = sticky_reorder( $events_all );

  // reduce to just the IDs in order
  $events_all_final = wp_list_pluck( $events_all_final, 'ID' );

  return $events_all_final;

}


function sticky_reorder( $obj ) {


  // pull out all is_sticky posts from our fixed list into their own thang
  $obj_sticky = array_filter( $obj, function ($e) { return $e->is_sticky == 1; } );

  // pull out non-stickies
  $obj_reg = array_filter( $obj, function ($e) { return $e->is_sticky == 0; } );

  // sort both by date
  $obj_sticky = sort_posts( $obj_sticky, '_event_start_date', $order = 'ASC', false );
  $obj_reg = sort_posts( $obj_reg, '_event_start_date', $order = 'ASC', false );

  $obj_final = array_merge( $obj_sticky, $obj_reg );

  return $obj_final;


}


function event_recurring_one( $events ) {

  $i = 0;

  foreach( $events as $event ) {

    if( $i == 0 || $i != $event->_recurrence_id ) {

      // skip first result and then...
      $i = $event->_recurrence_id;

    } elseif( $i == $event->_recurrence_id ) {

      // mark item for removal through array_filter
      $event->_recurrence_id = 0;

    }

  }

  $events = array_filter( $events, function( $evt ) {

    return $evt->_recurrence_id != 0;

  } );

  return $events;

}

// original source: https://gist.github.com/bradyvercher/1576900
// WordPress: Sort an array of post objects by any property, remove duplicates, and use post ids as the key in the returned array.


function sort_posts( $posts, $orderby, $order = 'ASC', $unique = true ) {
	if ( ! is_array( $posts ) ) {
		return false;
	}

	usort( $posts, array( new Sort_Posts( $orderby, $order ), 'sort' ) );

	// use post ids as the array keys
	if ( $unique && count( $posts ) ) {
		$posts = array_combine( wp_list_pluck( $posts, 'ID' ), $posts );
	}

	return $posts;
}
class Sort_Posts {
	var $order, $orderby;

	function __construct( $orderby, $order ) {
		$this->orderby = $orderby;
		$this->order = ( 'desc' == strtolower( $order ) ) ? 'DESC' : 'ASC';
	}

	function sort( $a, $b ) {
		if ( $a->{$this->orderby} == $b->{$this->orderby} ) {
			return 0;
		}

		if ( $a->{$this->orderby} < $b->{$this->orderby} ) {
			return ( 'ASC' == $this->order ) ? -1 : 1;
		} else {
			return ( 'ASC' == $this->order ) ? 1 : -1;
		}
	}
}



// SEARCH WP HOOKS

// search pagination - how many rows to show per page
function pjg_searchwp_posts_per_page( $posts_per_page = 10, $engine = 'default', $terms = null, $page = null ) {
    return 10;
}

add_filter( 'searchwp_posts_per_page', 'pjg_searchwp_posts_per_page', 10, 4 );


// tell search wp what to include,
// 1) all published pages and posts
// 2) all single events, and only the next recurrence of recurring events (using pjg_event_recurrence())
function pjg_searchwp_include_only( $ids, $engine, $terms ) {

    // show all pages / posts that are published
    $args = array(
        'post_type' => array('post', 'page'),
        'posts_per_page' => -1, // get all possible results, to parse down
        'post_status' => 'publish',
    );

    $posts_and_pages = new WP_Query( $args );
    $posts_and_page_ids = wp_list_pluck( $posts_and_pages->get_posts(), 'ID' );

    // use the helper method to get events with the first recurrent visible only
    $event_ids = pjg_event_recurrence(null);

    return array_merge($posts_and_page_ids, $event_ids);
}

add_filter( 'searchwp_include', 'pjg_searchwp_include_only', 10, 3 );
