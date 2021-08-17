<?php

// functions access by ajax for the filter search bar


add_action( 'wp_ajax_nopriv_ajax_filter', 'pjg_ajax_filter' );
add_action( 'wp_ajax_ajax_filter', 'pjg_ajax_filter' );

add_action( 'wp_ajax_nopriv_last_page', 'pjg_last_page' );
add_action( 'wp_ajax_last_page', 'pjg_last_page' );

add_action( 'wp_ajax_nopriv_ajax_dynamic_content_feed', 'pjg_ajax_dynamic_content_feed' );
add_action( 'wp_ajax_ajax_dynamic_content_feed', 'pjg_ajax_dynamic_content_feed' );

add_action( 'wp_ajax_nopriv_ajax_search_load_more', 'pjg_ajax_search_load_more' );
add_action( 'wp_ajax_ajax_search_load_more', 'pjg_ajax_search_load_more' );


function pjg_ajax_filter() {


    $query_vars = parse_str( $_POST[ 'query_vars' ], $the_query );

    // pre_printr( $the_query );

    $is_event = $the_query['post_type'] == 'event';

    $page = ( $_POST[ 'page' ] ) ? $_POST[ 'page' ] : 1;

    $post_type = ( $is_event ) ? 'event' : 'post';

    if( $is_event ) {

      $the_query = pjg_event_recurrence( $the_query );

    }


    // confirm query is valid (returns nothing for null results of events)
    if( !empty( $the_query ) ) {


      $args = array(

        'post_type' => $post_type,
        'paged' => $page,

      );

      if( $is_event ) {

        $args[ 'orderby' ] = 'post__in';
        $args[ 'post__in' ] = $the_query;

      } else {

        $args[ 'meta_key' ] = 'is_sticky';
        $args[ 'orderby' ] = array( 'is_sticky' => 'DESC', 'post_date' => 'DESC' );
        $args[ 'post_status' ] = 'publish';

        $args = array_merge( $the_query, $args );

      }

      $posts = new WP_Query( $args );

      // pre_printr( $posts );


      $GLOBALS['wp_query'] = $posts;

      $is_lastpage = ( $posts->max_num_pages > $page ) ? 0 : 1;

      if( $posts->have_posts() ) {


        echo '<div class="is_lastpage" data-lastpage="' .  $is_lastpage  . '"></div>';

        while ( $posts->have_posts() ) {

            $posts->the_post();


            if( $posts->post_count >= 4 && ( $posts->current_post ) === 3 && $page == 1 ) {

              // add Membership promo here
              get_template_part( 'partials/module', 'membership' );

            }

            get_template_part( 'partials/excerpt' );

        }

      } else {

        get_template_part( 'partials/listing', 'none' );

      }

  } else {


    get_template_part( 'partials/listing', 'none' );

  }

    die();


}

function pjg_last_page() {


  $query_vars = parse_str( $_POST[ 'query_vars' ], $the_query );


}

// get News (posts) and Events based on a category / admin_category
// this is related to ACF Lower Page Modules -> modules_lower -> dynamic_content_feed -> content_feed
function pjg_ajax_dynamic_content_feed() {

    // get a handle to the post that is displaying the dynamic_content_feed
    $post_id = @$_GET['post_id'];
    $post = get_post($post_id);

    if(!$post) {
        die();
    }

    $modules_lower_index = @$_GET['modules_lower_index'];
    $content_feed_index = @$_GET['content_feed_index'];

    // look for the lower page module ACF that matches the indexes provided
    $acf_data = pjg_get_dynamic_content_feed($post_id, $modules_lower_index, $content_feed_index);

    if(!$acf_data) {
        die();
    }

    // determine the feed type
    $feed_type = $acf_data['type'];

    $the_query = array('post_type' => $feed_type);
    $tax_query = array();

    // optional - filter by main category, a single main category to search by
    $category = $acf_data['category'];
    if($category) {
        $tax_query[] = array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => array( $category ) );
    }

    // optional - filter by the admin categories
    $category_admin = @$acf_data['category_admin'];    // this will already be an array
    if($category_admin && count($category_admin) > 0) {
        $tax_query[] = array(
            'taxonomy' => 'administrative',
            'field'    => 'term_id',
            'terms'    => $category_admin,
            'operator' => 'AND');
    }

    // tax_query
    $the_query['tax_query'] = $tax_query; // empty array if no categories selected

    if( $feed_type == 'event' ) {
        // for events, narrow down to just a list of post_ids since event recurrences are complicated
        $event_ids = pjg_event_recurrence( $the_query );

        // now that we have that, remove the tax_query from the main query
        unset($the_query['tax_query']);

        $the_query[ 'orderby' ] = 'post__in';

        if($event_ids && count($event_ids) > 0) {
            $the_query[ 'post__in' ] = $event_ids;
        } else {
            // no events found, if you give post__in an empty array it returns everything
            $the_query[ 'post__in' ] = array(-1);
        }


    } else {
        // for News (posts), add additional filters / sorting rules
        $the_query[ 'meta_key' ] = 'is_sticky';
        $the_query[ 'orderby' ] = array( 'is_sticky' => 'DESC', 'post_date' => 'DESC' );
        $the_query[ 'post_status' ] = 'publish';
    }

    $posts = new WP_Query( $the_query );
    $GLOBALS['wp_query'] = $posts;

    // get some additional ACF data for this post
    $feed_headline = $acf_data['feed_headline'];
    $view_all_copy = $acf_data['view_all_copy'];

    if($posts->have_posts() ) {

        require( locate_template( 'partials/content-feed-' . $feed_type . '.php' ) );

    };

    die();

}


// returns a single Lower Page Module -> Dynamic Content Feed -> Content Feed row
// pass in the dynamic content feed index $modules_lower_index and the content_feed index
function pjg_get_dynamic_content_feed($post_id, $modules_lower_index, $content_feed_index) {

    $acf_data = get_field('modules_lower', $post_id);

    return @$acf_data[$modules_lower_index]['content_feed'][$content_feed_index];

}


// on the search results page, when the user clicks 'load more' this function
// runs which gets the next page of data and returns it as an html snippet
function pjg_ajax_search_load_more() {

    // gather the query and the page to get
    $query = sanitize_text_field( @$_GET['s'] );
    $page = intval( @$_GET['page'] );
    if($page <= 0) {
        $page = 1;
    }

    $page_size = pjg_searchwp_posts_per_page();

    $searchwp = SearchWP::instance();

    // only load the IDs
    add_filter( 'searchwp_load_posts', '__return_false' );

    // get ALL matches
    add_filter( 'searchwp_posts_per_page', '__return_zero', 20 );

    // run the search against SearchWP's default index
    $posts = $searchwp->search( 'default', $query );

    // now use a regular WP_Query to get the subset of posts we are after (one page's worth)
    $args = array(
        'post_type'     => 'any',
        'post_status'   => 'any',
        'post__in'      => $posts,
        'orderby'       => 'post__in',
        'posts_per_page' => $page_size,
        'paged' => $page,
    );

    // set our query to the global query so the template can read it using the loop
    global $wp_query;
    $wp_query = new WP_Query( $args );

    global $search_query;
    // undo WordPress automatic escaping to avoid double escaping
    // $search_query will be escaped again in the partial
    $search_query = stripslashes(@$_GET['s']);

    get_template_part( 'partials/search', 'results' );
    die();
}
