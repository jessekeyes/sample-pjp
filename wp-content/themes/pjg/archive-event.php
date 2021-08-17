<?php
/**
 * The template for displaying event archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package pjg
 */

// since this may not be a real archive, we have to get the query

global $wp_query;

$categories = get_the_category();

$events_in = pjg_event_recurrence( $args_init );


$args['post__in'] = $events_in;
$args['orderby'] = 'post__in';
$args[ 'post_type'] = 'event';

if( empty( $categories ) && !$wp_query->query_vars['no_events'] ) {

  $wp_query = new WP_Query( $args );

}

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main the-blue-bar" role="main">

      <?php

        $event_page_id = get_page_id_by_slug( 'events' );
        $event_page = get_post( $event_page_id );
        $event_content = apply_filters( 'the_content', $event_page->post_content );

      ?>

      <div class="archive-title">
        <header class="entry-header">


            <?php

              if( strtok($_SERVER["REQUEST_URI"],'?') == '/' || ( empty( $categories ) && !$wp_query->query_vars['no_events'] )  ) {

                echo '<h1 class="entry-title">' . $event_page->post_title . '</h1>';

              } else {

                $cat_id = get_queried_object();
                $cat_id = $cat_id->term_id;

                $cat_name = ( $categories[0]->name != '' ) ? $categories[0]->name : get_the_category_by_ID( $cat_id );

                echo '<h1 class="entry-title">' . $cat_name . '</h1>';

              }
            ?>

        </header><!-- .page-header -->
      </div>


    <?php if ( have_posts() ) : ?>

      <?php if( strtok($_SERVER["REQUEST_URI"],'?') == '/events/' && $event_content != '' ) :  ?>

      <div class="entry-content">

        <?php echo $event_content; ?>

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

          /*
           * Include the Post-Format-specific template for the content.
           * If you want to override this in a child theme, then include a file
           * called content-___.php (where ___ is the Post Format name) and that will be used instead.
           */
          get_template_part( 'partials/excerpt' );


        ?>

      <?php endwhile;  ?>


      </div>



      <?php

          echo '<div class="pagination" style="display:none;"><div class="loader lazy-hide"><div></div><div></div></div></div>';

      ?>


    <?php wp_reset_postdata(); wp_reset_query(); else : ?>



            <?php get_template_part( 'partials/module', 'filter' ); ?>


            <?php /* Start the Loop */ ?>
            <div class="wrapper-posts not-found">
              <?php get_template_part( 'partials/listing', 'none' ); ?>

            </div>


    <?php endif; ?>

    </main><!-- #main -->
  </div><!-- #primary -->
<?php get_footer(); ?>
