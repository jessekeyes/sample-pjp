<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package pjg
 */

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main the-blue-bar" role="main">

      <?php

          $news_page_id = get_page_id_by_slug( 'news' );
          $news_page = get_post( $news_page_id );
          $news_content = apply_filters( 'the_content', $news_page->post_content );

      ?>


      <div class="archive-title">
        <header class="entry-header">
          <?php
            if( is_home() ) {

              echo '<h1 class="entry-title">' . $news_page->post_title . '</h1>';

            } else {

              echo '<h1 class="entry-title">' . single_term_title( '', false ) . '</h1>';

            }
          ?>
        </header><!-- .page-header -->
      </div>


    <?php if ( have_posts() ) : ?>

      <?php if( is_home() && $news_content != '' ) :  ?>

        <div class="entry-content">

          <?php

              echo $news_content;


           ?>

        </div>

      <?php endif; ?>

      <?php get_template_part( 'partials/module', 'filter' ); ?>

      <?php /* Start the Loop */ ?>
      <div class="wrapper-posts">
        <div class="gutter-sizer"></div>

        <?php

          $page = ( get_query_var('paged')) ? get_query_var('paged') : 1;
          $is_lastpage = ( $wp_query->max_num_pages > $page ) ? 0 : 1;

          echo '<div class="is_lastpage" data-lastpage="' .  $is_lastpage  . '"></div>';

        ?>

      <?php while ( have_posts() ) : the_post();

        if( $wp_query->post_count >= 4 && ( $wp_query->current_post ) === 3 ) {

          // add Membership promo here
          get_template_part( 'partials/module', 'membership' );

        }

      ?>

        <?php
          get_template_part( 'partials/excerpt' );
        ?>

      <?php endwhile; ?>


      </div>



        <?php

            echo '<div class="pagination" style="display:none;"><div class="loader lazy-hide"><div></div><div></div></div></div>';

        ?>

    <?php wp_reset_postdata(); wp_reset_query(); else : ?>


      <?php get_template_part( 'partials/module', 'filter' ); ?>


      <div class="wrapper-posts not-found">

              <?php get_template_part( 'partials/listing', 'none' ); ?>

      </div>

    <?php endif; ?>

    </main><!-- #main -->
  </div><!-- #primary -->
<?php get_footer(); ?>
