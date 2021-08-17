<?php
/**
 * The template for displaying the FRONT PAGE as selected in WP Options
 *
 *
 * @package pjg
 */
$day_schedule = $day_schedule ?: pjg_get_day_schedule();
get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

      <?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'partials/content', 'home' ); ?>

        <div class="grid">

          <div class="row row1">

            <section class="visitor-info item visitor-home">
              <div class="lantern"></div>

              <?php if(is_array($day_schedule)): ?>
              <div class="widget-schedule">
                <p class="surtitle"><?= ucfirst(date('l')) ?>'s <?= ucfirst(pjg_get_season()) ?> Hours</p>
                <h2 class="widget-title"> <?= ( $day_schedule['currenty_closed'] ) ? 'CLOSED' : $day_schedule['public_display_home'] ?></h2>
                <?php if($day_schedule['member_display']): ?>
                  <p class="subtitle">Member Hours: <?= $day_schedule['member_display'] ?></p>
                <?php endif; ?>
                <p class="legal-text"><?= get_field('hour_legal', 'option')?></p>
                <hr class="visitor-hr" />
                <p class="subtitle"><a class="visitor-home-link" href="<?= get_permalink(get_page_by_path('hours-admission') )?>">View All Hours &amp; Ticket Prices</a></p>
                <a class="arrow" href="<?= get_permalink(get_page_by_path('hours-admission') )?>"></a>
              </div>
              <?php endif; ?>
            </section>

            <?php

              $post__in = pjg_event_recurrence( array( 'post_type'=>'event' ) );

              $args = array( 'post_type'=>'event', 'posts_per_page'=>3, 'orderby' => 'post__in', 'post__in' => $post__in );

              $events = new WP_Query( $args );

              if( $events->have_posts() ) :

                $i = 0;

            ?>

            <section class="event-feed item">


              <?php while ( $events->have_posts() ) : $events->the_post(); $i++;

                echo ( $i == 2 ) ? '<div class="event-feed-sub">' : '';

              ?>

                <article class="item-sub item-event item-overlay">

                  <div class="titles">

                    <h4 class="sur-title">Event</h4>
                    <h1 class="entry-title"><?php echo get_the_title(); ?></h1>
                    <div class="entry-meta"><?php pjg_posted_on( 'event' ); ?></div>

                  </div>


                  <a href="<?php echo get_permalink();?>" class="permalink">

                  <?php if( $i == 1 ) {

                      echo pjg_get_featured_image_excerpt( $events->ID, 'not-square' );

                     } else {

                       echo pjg_get_featured_image_excerpt( $events->ID, 'post-tile' );

                     };

                  ?>

                  </a>

                  <div class="image-gradient"></div>
                </article>

              <?php

              echo ( $i == 3 ) ? '</div><!-- /event-feed-sub-->' : '';

            endwhile; wp_reset_postdata() ?>


            </section>


            <?php endif; ?>


          </div>

          <div class="row row3 tablet-events">

          <?php if( $events->have_posts() ) :  $i = 0; ?>

              <?php while ( $events->have_posts() ) : $events->the_post(); $i++;

                if ( $i == 1 ) continue; // skip first result since displayed above

              ?>

                <article class="item item-sub item-event item-overlay">

                  <div class="titles">

                    <h4 class="sur-title">Event</h4>
                    <h1 class="entry-title"><?php echo get_the_title(); ?></h1>
                    <div class="entry-meta"><?php pjg_posted_on( 'event' ); ?></div>

                  </div>


                  <a href="<?php echo get_permalink();?>" class="permalink">

                  <?php

                  if( $i == 2 ) {

                      echo pjg_get_featured_image_excerpt( $events->ID, 'child-two' );

                     } else {

                       echo pjg_get_featured_image_excerpt( $events->ID, 'child-one' );

                     };

                  ?>

                  </a>

                  <div class="image-gradient"></div>
                </article>

              <?php endwhile; wp_reset_postdata() ?>

          <?php endif; ?>

          </div>

          <div class="row home-last">

            <section class="cta-home item">

              <article class="item-overlay tile cta">

                <div class="titles">

                  <?php

                  $image = get_field( 'cta_image' );

                    echo ( get_field( 'cta_sur_title' ) != '' ) ? '<h4 class="sur-title">' . get_field( 'cta_sur_title' ) . '</h4>' : '';
                    echo ( get_field( 'cta_headline' ) != '' ) ? '<h1 class="entry-title">' . get_field( 'cta_headline' ) . '</h1>' : '';
                    echo ( get_field( 'cta_url' ) != '' ) ? '<div class="arrow"></div>' : '';
                  ?>

                </div>

                <?php

                  $cta_url = ( get_field( 'cta_url' ) != '' ) ? '<a class="permalink" href="' . get_field( 'cta_url' ) .'">' . wp_get_attachment_image( $image['id'], 'child-middle' ) . '</a>' : '<span class="permalink">' . wp_get_attachment_image( $image['id'], 'child-middle' ) . '</span>';

                  $cta_url = ( get_field( 'cta_url' ) != '' ) ? autoblank( $cta_url ) : $cta_url;

                  echo $cta_url;

                  ?>


                  <div class="image-gradient"></div>
              </article>


            </section>
            <section class="membership-home item">

              <?php get_template_part( 'partials/module', 'membership' ); ?>

            </section>

          </div>

        </div>


      <?php endwhile; // End of the loop. ?>

    </main><!-- #main -->
  </div><!-- #primary -->

<?php get_footer(); ?>
