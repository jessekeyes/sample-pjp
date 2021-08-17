<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package pjg
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

  <?php get_template_part( 'partials/module', 'featured-media' ); ?>

  <footer class="entry-footer">

  </footer><!-- .entry-footer -->
</article><!-- #post-## -->
