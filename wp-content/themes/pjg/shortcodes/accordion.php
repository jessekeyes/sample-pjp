<?php
/**
 * shortcode that access a filled out ACF for Accordion Menus
 *
 * @package pjg
 */


  function accordion_menu() {


    ob_start();


    if( get_field( 'add_accordion_menu' ) ) :

?>

  <div class="accordion-grid">

    <?php if( have_rows( 'accordion_row' ) ) :

      $i = 0;

      while( have_rows( 'accordion_row' ) ) : the_row(); $i++; ?>

      <div class="accordion-row">

        <div class="accordion-title">

          <?php echo ( get_sub_field( 'title' ) != '' ) ? '<h1 class="accordion-row-title">' . get_sub_field( 'title' ) . '</h1>' : ''; ?>

          <?php echo ( get_sub_field( 'price' ) != '' ) ? '<h3 class="accordion-price">' . get_sub_field( 'price' ) . '</h3>' : ''; ?>

        </div>

        <div class="accordion-open">

          <?php echo get_sub_field( 'open_copy' ); ?>

        </div>

        <div class="accordion-hidden">

          <?php echo get_sub_field( 'hidden_copy' ); ?>

        </div>

        <a href="#" class="accordion-toggle <?php echo 'accordion-row-' . $i; ?>"><span class="arrow"></span>
          <span class="toggle">

            <span class="toggle-word" data-hide="Hide" data-view="View">View</span><?php echo ( get_sub_field( 'view_hide_text' ) != '' ) ? ' ' . get_sub_field( 'view_hide_text' ) : ''; ?>

          </span>

        </a>

      </div>

    <?php endwhile; endif; ?>

  </div>


<?php
    endif;


    return ob_get_clean();


  };

  add_shortcode( 'accordion', 'accordion_menu' );
