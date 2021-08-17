<?php
/**
 * partial renders dynamic feed displays
 *
 * used on most templates, except search
 *
 * these are rendered via an ajax call in pjg.js
 *
 */

echo '<div class="dynamic-content-feed-wrapper item">' . PHP_EOL;

$content_feed_index = 0;  // at most 2 content_feed rows, send the index with the URL so it knows which one it is

foreach(get_sub_field('content_feed') as $feed) {

    // get the relevant variables and munge into a query vars param that goes on a div
    // in the jQuery ready event in pjg.js, this div will get picked up and the ajax call will be fired off

    $ajax_queryvars = "post_id=" . get_the_ID();
    $ajax_queryvars .= "&modules_lower_index=" . $modules_lower_index;
    $ajax_queryvars .= "&content_feed_index=" . $content_feed_index;

    echo '<div class="hidden dynamic-content-feed row-'. $content_feed_index . '" data-ajax-queryvars="' . $ajax_queryvars . '"></div>' . PHP_EOL;

    $content_feed_index++;
}

echo '</div>';
