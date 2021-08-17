<?php
/**
 * partial renders event sidebar meta stuff
 *
 * call from content-event
 *
 *
 * @package pjg
 */

 global $EM_Event;

 ?>

 <div class="sidebar-event dark">

   <?php if( get_field( 'price_title' ) != '' || get_field( 'price_copy' ) != '' || get_field( 'show_calendar' ) ) : ?>

   <div class="event-widget">

   <?php

    echo ( get_field( 'price_title' ) != '' ) ? '<h4 class="price-title">' . get_field( 'price_title' ) . '</h4>' : '';
    echo ( get_field( 'price_copy' ) != '' ) ? '<div class="price-copy">' . apply_filters( 'the_content', get_field( 'price_copy' ) ) . '</div>' : '';

    if( get_field( 'show_calendar' ) ) :

      // rebuild google calendar url to fix multi-day all day issue

        if($EM_Event->event_all_day){
          $dateStart	= get_gmt_from_date(date('Y-m-d H:i:s', $EM_Event->start), 'Ymd');
          $dateEnd	= get_gmt_from_date(date('Y-m-d H:i:s', $EM_Event->end + 60*60*24), 'Ymd');
        }else{
          $dateStart	= get_gmt_from_date(date('Y-m-d H:i:s', $EM_Event->start), 'Ymd\THis\Z');
          $dateEnd = get_gmt_from_date(date('Y-m-d H:i:s', $EM_Event->end), 'Ymd\THis\Z');
        }
        //build url
        $gcal_url = 'http://www.google.com/calendar/event?action=TEMPLATE&text=event_name&dates=start_date/end_date&details=post_content&location=location_name&trp=false&sprop=event_url&sprop=name:blog_name';
        $gcal_url = str_replace('event_name', urlencode($EM_Event->event_name), $gcal_url);
        $gcal_url = str_replace('start_date', urlencode($dateStart), $gcal_url);
        $gcal_url = str_replace('end_date', urlencode($dateEnd), $gcal_url);
        $gcal_url = str_replace('location_name', urlencode($EM_Event->output('#_LOCATIONFULLLINE')), $gcal_url);
        $gcal_url = str_replace('blog_name', urlencode(get_bloginfo()), $gcal_url);
        $gcal_url = str_replace('event_url', urlencode($EM_Event->get_permalink()), $gcal_url);
        //calculate URL length so we know how much we can work with to make a description.
        if( !empty($EM_Event->post_excerpt) ){
          $gcal_url_description = $EM_Event->post_excerpt;
        }else{
          $matches = explode('<!--more', $EM_Event->post_content);
          $gcal_url_description = wp_kses_data($matches[0]);
        }
        $gcal_url_length = strlen($gcal_url) - 9;
        if( strlen($gcal_url_description) + $gcal_url_length > 1350 ){
          $gcal_url_description = substr($gcal_url_description, 0, 1380 - $gcal_url_length - 3 ).'...';
        }
        $gcal_url = str_replace('post_content', urlencode($gcal_url_description), $gcal_url);
        //get the final url

  ?>

    <a class="calendar-add" href="#">Add to my calendar</a>

    <div class="calendar-drawer">

      <a class="add-cal" href="<?php echo $EM_Event->output( '#_EVENTICALURL' ); ?>">Outlook</a>

      <a class="add-cal" target="_blank" href="<?php echo $gcal_url; ?>">Google</a>

      <a class="add-cal" href="<?php echo $EM_Event->output( '#_EVENTICALURL' ); ?>">Apple</a>

    </div>

  <?php endif; ?>

  </div>

  <?php endif; ?>

  <?php if ( function_exists( 'sharing_display' ) ) : ?>

  <div class="sharing sharing-event">

    <?php echo sharing_display( '', false ); ?>

  </div>

  <?php endif; ?>

 </div>
