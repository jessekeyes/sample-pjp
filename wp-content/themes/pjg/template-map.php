<?php
/**
 * The template for displaying a Google Map feature page
 *
 * @package pjg
 */

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <?php while ( have_posts() ) : the_post(); ?>

        <?php if (have_rows('map_markers')): ?>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBOnpVoaETDFFn5n2MNURTM2kZq7Odo3R0"></script>
        <script src="<?php echo get_template_directory_uri() ?>/assets/js/vendor/richmarker.min.js"></script>
        <script>
          function initMap() {

            var markers = [];
            var bounds = new google.maps.LatLngBounds();

            var pjgLatLng = {lat: 45.518620, lng: -122.708431};
            // Create a map object and specify the DOM element for display.
            window.map = new google.maps.Map(document.getElementById('map'), {
              center: pjgLatLng,
              scrollwheel: false,
              zoom: 15
            });

            <?php while(have_rows('map_markers')): the_row(); ?>
            var markerClass = '<?php echo (strtolower(get_sub_field('marker_title')) == 'portland japanese garden') ? 'pjg label' : 'label' ?>';

            markers[<?= get_row_index(); ?>] = new RichMarker({
              map: map,
              position: new google.maps.LatLng({lat: <?= get_sub_field('latitude') ?>, lng: <?= get_sub_field('longitude') ?>}),
              content: '<div class="' + markerClass + '"><?= get_sub_field('marker_title') ?></div>',
              shadow: 'none'
            });
            markers[<?= get_row_index(); ?>].setZIndex(<?= round(100/get_row_index()); ?>);  // set zindex so first markers are higher
            bounds.extend(markers[<?= get_row_index(); ?>].getPosition());

            <?php endwhile; ?>

            // map.fitBounds(bounds);
            map.setCenter(pjgLatLng);
            map.setOptions({
              styles: [{"featureType": "all", "elementType": "geometry.fill", "stylers": [{"weight": "2.00"} ] },
                {"featureType": "all", "elementType": "geometry.stroke", "stylers": [{"color": "#9c9c9c"} ] },
                {"featureType": "all", "elementType": "labels.text", "stylers": [{"visibility": "simplified"}, {"color": "#eb3300"} ] },
                {"featureType": "all", "elementType": "labels.text.fill", "stylers": [{"visibility": "simplified"}, {"color": "#b5bd00"} ] },
                {"featureType": "all", "elementType": "labels.text.stroke", "stylers": [{"visibility": "simplified"}, {"color": "#ffffff"}, {"weight": "1"} ] },
                {"featureType": "administrative.land_parcel", "elementType": "all", "stylers": [{"visibility": "off"} ] },
                {"featureType": "landscape", "elementType": "all", "stylers": [{"color": "#f2f2f2"} ] },
                {"featureType": "landscape.man_made", "elementType": "geometry.fill", "stylers": [{"visibility": "off"} ] },
                {"featureType": "landscape.man_made", "elementType": "geometry.stroke", "stylers": [{"visibility": "off"} ] },
                {"featureType": "poi", "elementType": "all", "stylers": [{"visibility": "off"} ] },
                {"featureType": "poi", "elementType": "labels.text", "stylers": [{"visibility": "off"}, {"color": "#b5bd00"} ] },
                {"featureType": "road", "elementType": "all", "stylers": [{"saturation": -100 }, {"lightness": 45 } ] },
                {"featureType": "road", "elementType": "geometry.fill", "stylers": [{"color": "#424143"}, {"weight": "0.75"} ] },
                {"featureType": "road", "elementType": "labels.text.fill", "stylers": [{"color": "#253746"} ] },
                {"featureType": "road", "elementType": "labels.text.stroke", "stylers": [{"color": "#ffffff"}, {"visibility": "simplified"} ] },
                {"featureType": "road.highway", "elementType": "all", "stylers": [{"visibility": "simplified"} ] },
                {"featureType": "transit", "elementType": "all", "stylers": [{"lightness": "-71"}, {"saturation": "-69"} ] },
                {"featureType": "water", "elementType": "all", "stylers": [{"color": "#46bcec"}, {"visibility": "on"} ] },
                {"featureType": "water", "elementType": "geometry.fill", "stylers": [{"color": "#c8d7d4"} ] },
                {"featureType": "water", "elementType": "labels.text.fill", "stylers": [{"color": "#070707"} ] },
                {"featureType": "water", "elementType": "labels.text.stroke", "stylers": [{"color": "#ffffff"} ] }
            ]
            })
          }

          jQuery(function(){ initMap(); })
        </script>
        <?php endif; ?>
    
        <?php get_template_part( 'partials/content', 'page' ); ?>

      <?php endwhile; // End of the loop. ?>

    </main><!-- #main -->
  </div><!-- #primary -->

<?php get_footer(); ?>
