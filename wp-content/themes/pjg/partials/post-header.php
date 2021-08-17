<?php // used for event/post single post headers, title, dates, meta data, etc.



global $EM_Event;



$sur_title = pjg_the_excerpt_terms( get_the_ID(), 'category', '<h3 class="sur-title">', ' ', '</h3>' );

$link_url = ( is_singular( 'event') ) ? '/events/' : '/news/';
$link_title = ( is_singular( 'event') ) ? 'Events' : 'News & Photos';



?>

<div class="inner inner-post">

  <?php echo '<a class="link-back" href="' . $link_url . '">View all ' . $link_title . '</a>'; ?>

  <div class="titles">
    <?php echo $sur_title; ?>
    <h1 class="entry-title"> <?php echo get_the_title(); ?> </h1>
  </div>




  <div class="entry-meta">

    <?php pjg_posted_on( $post_type ); ?>

    <?php

      $recurrence_post_text = get_field( 'recurrence_descriptive_text', pjg_recurrence_post_id( $EM_Event->recurrence_id  ) );

      $location_title = '';

      if( $post_type == 'event' ) {

        $location_title = ( get_field( 'location_url' ) != '' ) ? autoblank( '<a href="' . get_field( 'location_url' ) . '">' . $EM_Event->output( '#_LOCATIONNAME' ) .' </a>') : $EM_Event->output( '#_LOCATIONNAME' )  ;

      }

      echo ( $post_type == 'event' && $recurrence_post_text != '' ) ? '<p class="recurrence-description">' . $recurrence_post_text . '</p>' : '';
      echo ( $post_type == 'event' && $location_title != '' ) ? '<p class="event-location">Location: ' . $location_title . '</p>' :'';

    ?>

  </div><!-- .entry-meta -->

</div>
