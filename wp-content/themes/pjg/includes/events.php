<?php // Special Events Manager plugin functions

global $EM_Event; // to use plugins class

function pjg_events_taxonomy_register(){
    register_taxonomy_for_object_type( 'category', EM_POST_TYPE_EVENT );
        register_taxonomy_for_object_type( 'category', 'event-recurring' );
    // remove default category
    unregister_taxonomy_for_object_type( EM_TAXONOMY_CATEGORY, EM_POST_TYPE_EVENT );
    unregister_taxonomy_for_object_type( EM_TAXONOMY_CATEGORY, 'event-recurring' );
}
add_action('init','pjg_events_taxonomy_register', 100);


// Event utility functions

// function to find post ID with recurrence ID
function pjg_recurrence_post_id( $recurrence_id ) {

  // query wp_em_events table in DB to find
  global $wpdb;
  $results = $wpdb->get_var( 'SELECT post_id FROM wp_em_events WHERE event_id = ' . $recurrence_id );

  return $results;



}

// function find recurrence_id with post ID
function pjg_recurrence_id( $post_id ) {

  global $wpdb;
  $results = $wpdb->get_results( 'SELECT recurrence_id FROM wp_em_events WHERE post_id = ' . $post_id );

  return $results;



}

// rewrite the /events Page to the /events archive slug

add_action('init', function () {
  // die();

     add_rewrite_rule('events/?$','/', 'top');
     flush_rewrite_rules();

}, 1000);
