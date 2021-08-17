<?php
/**
 * partial that manages the featured media display logic.
 *
 * except for homepage diff module
 *
 *
 * @package pjg
 */


$video_loop = ( is_front_page() && get_field( 'looping_video_mp4' ) !='' && get_field( 'homepage_featured_image' ) !='' ) ? get_field( 'looping_video_mp4' ) : false;

$youtube = ( get_field( 'media' ) == 'youtube' && get_field( 'feature_youtube' ) != '' ) ? get_field( 'feature_youtube' ) : false;

$gallery = ( get_field( 'media' ) == 'gallery' && get_field( 'feature_gallery' ) != '' ) ? get_field( 'feature_gallery' ) : false;

$image_featured = ( get_field( 'media') == 'image' && get_field( 'featured_image' ) !=''  ) ? get_field( 'featured_image' ) : false;

$homepage_image_featured = ( is_front_page() && get_field( 'homepage_featured_image' ) !='' ) ? get_field( 'homepage_featured_image' ) : false;

$image_featured_portrait = ( get_field( 'featured_image_mobile' ) ) ? get_field( 'featured_image_mobile' ) : false;

$sur_title = ( get_field( 'title_sur' ) ) ? '<h3 class="sur-title">' . get_field( 'title_sur' ) . '</h3>' : '';

$post_type = ( is_singular( 'event' ) ) ? 'event' : '';

?>


<header class="entry-header">

<?php if( is_single() ) : ?>

  <?php get_template_part( 'partials/post', 'header' ); ?>

<?php endif; ?>

<?php

if( $video_loop ) {

  get_template_part( 'partials/module', 'homepage-featured-video' );


// youtube trumps all
} elseif( $youtube ) {

get_template_part( 'partials/module', 'featured-youtube' );

} elseif( $gallery ) {

  get_template_part( 'partials/module', 'gallery' );

} elseif( $homepage_image_featured ) {

  get_template_part( 'partials/module', 'homepage-featured-image' );


} elseif( $image_featured ) {

  get_template_part( 'partials/module', 'featured-image' );


} elseif( !is_single() ) { // default just the title

  echo '<div class="inner">';
  echo $sur_title;
  echo '<h1 class="entry-title">' . get_the_title() . '</h1>';
  echo '</div>';


};

?>


</header><!-- .entry-header -->

<!-- map markers -->
<?php if(have_rows('map_markers')): ?>
  <div id="map"></div>
<?php endif; ?>
