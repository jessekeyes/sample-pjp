<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package pjg
 */

 get_header(); ?>

   <div id="primary" class="content-area">
     <main id="main" class="site-main" role="main">

       <?php
        $missing_404 = new WP_Query( array( 'pagename' => 'page-not-found' ) ); 

          while ( $missing_404->have_posts() ) : $missing_404->the_post();
            get_template_part( 'partials/content', 'page' );
          endwhile;
      ?>

     </main><!-- #main -->
   </div><!-- #primary -->

 <?php get_footer(); ?>
