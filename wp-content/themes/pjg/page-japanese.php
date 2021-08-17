<?php
/**
 *
 * Template Name: Japanese Section
 *
 * Japanese language template
 *
 *
 * @package pjg
 */

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
      <?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'partials/content', 'page' ); ?>

      <?php endwhile; // End of the loop. ?>

    </main><!-- #main -->
  </div><!-- #primary -->

<?php get_footer(); ?>
