<?php
/**
 * shortcode that access a filled out ACF
 *
 * @package pjg
 */


  function shortcode_sponsors() {


    ob_start();


    if( get_field( 'add_sponsor_grid' ) ) :

?>

  <div class="sponsor-grid">

    <?php if( have_rows( 'sponsor_row' ) ) : while( have_rows( 'sponsor_row' ) ) : the_row(); ?>

      <div class="sponsor-row">

        <?php echo ( get_sub_field( 'row_title' ) != '' ) ? '<h2 class="sponsor-row-title">' . get_sub_field( 'row_title' ) . '</h2>' : ''; ?>

        <div class="sponsor-row-wrapper">

        <?php if( have_rows( 'sponsor_cell' ) ) : while( have_rows( 'sponsor_cell' ) ) : the_row(); ?>

          <div class="sponsor-cell">

            <?php $logo = get_sub_field( 'logo' ); ?>

            <?php echo ( get_sub_field( 'url' ) != '' ) ? '<a class="sponsor-logo-inline" target="_blank" href="' . get_sub_field( 'url' ) . '">' : ''; ?>

            <img src="<?php echo $logo['url']; ?>" />

            <?php echo ( get_sub_field( 'url' ) != '' ) ? '</a>' : ''; ?>

            <?php echo ( get_sub_field( 'text' ) != '' ) ? '<p>' . get_sub_field( 'text' ) . '</p>' : ''; ?>

          </div>

        <?php endwhile; endif; ?>

        </div>

      </div>

    <?php endwhile; endif; ?>

  </div>


<?php
    endif;


    return ob_get_clean();


  };

  add_shortcode( 'sponsors', 'shortcode_sponsors' );
