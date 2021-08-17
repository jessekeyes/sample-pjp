<?php
/**
 * Template part for displaying single posts.
 *
 * @package pjg
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

  <?php get_template_part( 'partials/module', 'featured-media' ); ?>

  <div class="event-wrapper">

    <div class="event-sidebar dark">

      <?php if ( function_exists( 'sharing_display' ) ) : ?>

      <div class="sharing sharing-event">

        <?php echo sharing_display( '', false ); ?>

      </div>

      <?php endif; ?>

    </div>

    <div class="entry-content">
      <?php the_content(); ?>
    </div><!-- .entry-content -->

  </div>

</article><!-- #post-## -->
