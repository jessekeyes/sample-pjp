<?php
/**
 * Displays an Alert post if present and the user has not closed it this session.
 *
 * @package pjg
 */

// get the most recently published Alert post
$args = array(
    'numberposts' => 1,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'alert',
    'post_status' => 'publish'
);

$alert_posts = wp_get_recent_posts( $args, OBJECT );

if( @$alert_posts[0] ) {
    $alert_post = $alert_posts[0];

    // get the ACFs
    $alert_expiry = get_field( 'alert_expiry', $alert_post->ID );
    $alert_expiry = ( $alert_expiry != '' ) ? strtotime( $alert_expiry ) : strtotime( '+2 years' );

    $alert_color = strtolower( get_field( 'cta_color', $alert_post->ID ) );
    $alert_url = get_field( 'cta_url', $alert_post->ID );
    $alert_text = get_field( 'cta_text', $alert_post->ID );

    $current_time = time();

    // check if expired
    if( $alert_expiry <= $current_time ) {

      // set post status to draft
      $alert_status = array(

        'ID' => $alert_post->ID,
        'post_status' => 'draft'

      );

       wp_update_post( $alert_status );

    } else {

      // render the alert
      include( locate_template( 'partials/content-alert.php' ) );

    }
}
