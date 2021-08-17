<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package pjg
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

  <?php get_template_part( 'partials/module', 'featured-media' ); ?>

  <?php

    $sidebar_links = pjg_get_international_sidebar_links(get_the_ID());

    if( $sidebar_links && count($sidebar_links) > 0) :

  ?>


  <div class="international-wrapper">

    <div class="sidebar-international-wrapper">

    <?php
      require( locate_template( 'partials/sidebar-international.php' ) );

      wp_reset_query();

    ?>

    </div>

  <?php endif; ?>

    <div class="entry-content">

      <?php if( get_field( 'characters' )  && !$sidebar_links ) : ?>

        <div class="kanji">

          <?php echo get_field( 'characters' ); ?>

        </div>

      <?php endif; ?>

      <?php if( is_page( 'parking' ) ) : // Parking widget ?>



          <div class="parking-widget">

            <iframe src="https://www.portlandoregon.gov/transportation/widgets/washington_park.cfm" width="200" height="250" scrolling="no"></iframe>

          </div>

      <?php endif; ?>


      <?php the_content(); ?>
    </div><!-- .entry-content -->

  <?php echo ( $sidebar_links ) ? '</div><!-- /.international-wrapper -->' : ''; ?>

  <footer class="entry-footer">
    <?php
    if( wp_get_post_parent_id( get_the_ID() ) && !$sidebar_links ) {


      get_template_part('partials/module-page-navigation');


    }
    ?>
  </footer><!-- .entry-footer -->
</article><!-- #post-## -->
