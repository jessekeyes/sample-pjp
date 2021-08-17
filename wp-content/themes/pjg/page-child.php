<?php
/**
 *
 * Template Name: Child Tile
 *
 * Child page tiling template
 *
 *
 * @package pjg
 */

// get the child pages, ordered by menu_order then title
$args = array(
  'post_type' => 'page',
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'post_parent' => $post->ID,
  'order' => 'ASC',
  'orderby' => 'menu_order post_title'
);

$children = new WP_Query($args);

// get the inspire tiles ACF
$inspire_tiles = get_field('inspire_tiles', $post->ID);

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

      <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('partials/content', 'page'); ?>
      <?php endwhile; // End of the loop. ?>



    </main><!-- #main -->
</div><!-- #primary -->


      <?php

      if( $children->have_posts() ) :

        echo '<div class="grid">';
      // display the child pages with the inspire tiles interspersed
      // the implementation is very specific about rows with two items each
      // except the second inspire tile row is a row with just one item

      $bIsRowOpen = false; // track if a final closing div tag needs to be spit out

      $item_count = 1;  // how many items have been displayed (child posts and inspire tiles)
      $row_count = 1;   // how many rows have been displayed (does not count the full width row for the second inspire tile)

      while ($children->have_posts()) : $children->the_post();

        // check for starting a row
        //     before odd counts

        if( $item_count % 2 !== 0 ) :

          // add a row class which determines the item split
          if($row_count === 2 ) {
            // items in row2 get a 0.5 / 0.5 split, only the first time
              $rowclass = "row2";
          } elseif($row_count % 3 == 0) {
            // items in row3 get a 0.6 / 0.4 split
            $rowclass = "row3";
          } else {
            // items in row1 get a 0.4 / 0.6 split
            $rowclass = "row1";
          }

          ?>
        <div class="row <?= $rowclass; ?>">
          <?php
          $bIsRowOpen = true;
          $row_count++;
        endif;


        ?>
          <article class="item child-post item-overlay <?= $rowclass; ?>">

            <div class="titles">

              <?php

                // echo ( get_field( 'title_sur' ) != '' ) ? '<h4 class="sur-title">' . get_field( 'title_sur' ) . '</h4>' : '';
                echo '<h1 class="entry-title">' . get_the_title() . '</h1>';
                echo ( get_field( 'characters' ) != '' ) ? '<div class="entry-meta kanji">' . get_field( 'characters' ) . '</div>' : '';
                echo '<div class="arrow"></div>';
              ?>

            </div>

            <a href="<?php echo get_permalink();?>" class="permalink">

            <?php

              if( $rowclass == 'row1') { // if first row and event count

                if( $item_count % 2 == 0 ) {

                  $child_img = 'child-two';

                } else {

                  $child_img = 'child-one';


                }

              } elseif ( $rowclass == 'row2' ) {

                $child_img = 'child-middle';

              } elseif( $rowclass == 'row3' ) {

                if( $item_count % 2 == 0 ) {

                  $child_img = 'child-one';

                } else {

                  $child_img = 'child-two';


                }

              }

                echo pjg_get_featured_image_excerpt( $post->ID, $child_img );

              ?>

            </a>

            <div class="image-gradient"></div>


          </article>
        <?php
        // after the 3rd item, show the first inspire tile, OKAY if blank
        if ($item_count === 3) :  ?>

            <div class="item inspire-tile inspire-tile-1 <?= $rowclass; ?>">
                <?php if (@$inspire_tiles[0]['membership_benefit_promo']):
                  get_template_part('partials/module', 'membership');
                else:
                  ?>

                  <div class="inspiration">

                      <div class="inspiration-copy">

                        <?php echo @$inspire_tiles[0]['inspire_tile_text']; ?>

                      </div>

                  </div>

                  <?php
                endif; ?>
            </div>
        <?php
            $item_count++;

        // after the 6th item show the second inspire tile (5 children plus 1 inspire tile),
        // this one always goes in its own row
        elseif ($item_count === 6) : ?>
            </div><!-- end row -->
            <div class="row full">
              <div class="item inspire-tile inspire-tile-2">
                <?php if (@$inspire_tiles[1]['membership_benefit_promo']):
                  get_template_part('partials/module', 'membership');
                else:
                  ?>

                  <div class="inspiration">

                      <div class="inspiration-copy">

                        <?php echo @$inspire_tiles[1]['inspire_tile_text']; ?>

                      </div>

                  </div>

                  <?php
                endif; ?>

              </div>
          <?php
          $item_count++; $item_count++; // count it twice since it takes up "2" slots
          $row_count++;
        endif;

        // check for ending a row
        //     end row after every even number
        if ( ($item_count % 2 == 0)  ) : ?>
            </div><!-- end row -->
        <?php
          $bIsRowOpen = false;
        endif;

        $item_count++;
      endwhile;  // end $children loop


      // make sure the last row gets closed if it has just one item
      if($bIsRowOpen) : ?>
        </div><!-- end row -->
      <?php endif;  ?>

      <?php
            echo '</div><!-- /grid -->';

          endif; wp_reset_postdata(); ?>
<?php get_footer(); ?>
