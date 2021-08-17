<?php
/**
 *  Visitor Info functions.
 *
 * @package WordPress
 * @subpackage Portland Japanese Garden
 */

/**
 * Get the current season, based on dates set in Admin
 * @param  [type] $lookup_timestamp
 * @return string Either 'summer' or 'winter'
 */
function pjg_get_season($lookup_timestamp = null){

  // get dates set by Admin
  $date_summer = get_option('options_date_summer') ?: null;
  $date_winter = get_option('options_date_winter') ?: null;

  // convert to timezone'd dates
  $timezone = new DateTimeZone(date_default_timezone_get());
  // summer
  $date_summer = new DateTime($date_summer);
  $date_summer->setTimezone($timezone);

  // winter
  $date_winter = new DateTime($date_winter);
  $date_winter->setTimezone($timezone);

  // current date
  $current_date = new DateTime('now');
  $current_date->setTimezone($timezone);

  $season = ( ( $current_date >= $date_summer ) && ( $current_date < $date_winter ) ) ? 'summer' : 'winter';

  return $season;
}

/**
 * Lookup the schedule for the given date, or the current day if none is given
 * @param  int $lookup_timestamp a date that can be parsed by strtotime
 * @param  string $season      the season
 * @return array              the hours for the given date and season
 */
function pjg_get_day_schedule($lookup_timestamp = null, $season = null){
  $lookup_timestamp = ($lookup_timestamp) ? "@$lookup_timestamp" : null;

  // convert to timezone'd date
  $lookup_date = new DateTime($lookup_timestamp);
  $timezone = new DateTimeZone(date_default_timezone_get());
  $lookup_date->setTimezone($timezone);

  $lookup_day_of_week = $lookup_date->format('N');
  $lookup_day_of_week--;

  $schedule = pjg_get_week_schedule();

  return $schedule[$lookup_day_of_week];
}

function pjg_get_week_schedule($lookup_timestamp = null, $season = null){
  $lookup_timestamp = ($lookup_timestamp) ? "@$lookup_timestamp" : null;

  // convert to timezone'd date
  $lookup_date = new DateTime($lookup_timestamp);
  $timezone = new DateTimeZone(date_default_timezone_get());
  $lookup_date->setTimezone($timezone);

  $season = $season ?: pjg_get_season($lookup_date->format('U'));
  $current_week = $lookup_date->format('W');
  $week_start_timestamp = date('U', strtotime('monday this week', $lookup_date->format('U')));


  // TODO: Store week schedule in tranisents
  $schedule = array();

  for($i = 0; $i < 7; $i++){
    $loop_timestamp = strtotime("+{$i} days", $week_start_timestamp);
    $loop_day_of_week = strtolower(date('l', $loop_timestamp));

    $the_hours = array(
      'day' => $loop_day_of_week,
      'timestamp' => $loop_timestamp,
      'is_current_day' => (date('w', $loop_timestamp) == $lookup_date->format('w')),
      'open_public' => get_field("{$loop_day_of_week}_{$season}_0_open_public", 'option'),
      'close_public' => get_field("{$loop_day_of_week}_{$season}_0_close_public", 'option'),
      'open_member' => get_field("{$loop_day_of_week}_{$season}_0_open_member", 'option') ?: null,
      'close_member' => get_field("{$loop_day_of_week}_{$season}_0_close_member", 'option') ?: null,
      'currenty_closed' => get_field("{$loop_day_of_week}_closed", 'option') ?: null,
    );

    // set compound dates strings
    $the_hours['public_display'] = "{$the_hours['open_public']} &mdash; {$the_hours['close_public']}";
    $the_hours['public_display_home'] = "{$the_hours['open_public']} - {$the_hours['close_public']}"; // cuz design demands it!
    $the_hours['member_display'] = ($the_hours['open_member'] != "") ? "{$the_hours['open_member']} &mdash; {$the_hours['close_member']}" : null;

    $schedule[$i] = $the_hours;
  }

  return $schedule;
}
