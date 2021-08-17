<?php
/**
 * shortcode that access a filled out ACF
 *
 * @package pjg
 */


  function shortcode_cta_generic( $atts ) { // @TODO only show one?

    $atts = shortcode_atts( array (

      'align' => 'center'

  	), $atts );

    $align = ( esc_attr( $atts['align'] ) == 'center' || esc_attr( $atts['align'] ) == 'right' || esc_attr( $atts['align'] ) == 'left' ) ? ' align' .  esc_attr( $atts['align'] ) . '"' : ' aligncenter';

    $centered = ( esc_attr( $atts['align'] ) !== 'center' ) ? false : true;

    ob_start();


    if( get_field( 'cta_init' ) ) :


      $image = get_field( 'cta_image' );
      $url_output = '';
      $url_output_cta = '';

      if( get_field( 'cta_url' ) ) {

        $url_output = get_field( 'cta_url' );
        $url_output = autoblank( $url_output );

      }

	?>

<?php if( $centered ) : ?>

</div><!-- break out of entry-content -->


<?php endif;
  if( $centered && ( is_singular( 'event' ) || is_singular( 'post' ) ) ) echo '</div><!-- break out of .event-wrapper -->';

$parent_id = wp_get_post_parent_id( $post->ID );

if( $centered && ( is_page_template( 'page-japanese.php' ) || get_post_meta( $parent_id, '_wp_page_template', true ) == 'page-japanese.php' || is_page_template( 'page-chinese.php' ) || get_post_meta( $parent_id, '_wp_page_template', true ) == 'page-chinese.php'  ) ) echo '</div><!-- break out of .international-wrapper -->'; ?>

  <div class="cta<?php echo $align;?>">

    <?php if( get_field( 'cta_image' ) ) : ?>

    <div class="cta-image">

      <?php echo (get_field( 'cta_url' )) ? '<a href="' . $url_output . '">' : '' ?>

      <?php echo wp_get_attachment_image( $image['id'], 'cta' ); ?>

      <?php echo (get_field( 'cta_url' )) ? '</a>' : '' ?>

    </div>

    <?php endif; ?>

    <div class="cta-copy<?php echo ( !get_field( 'cta_image' ) ) ? ' no-image' : ''; ?>">

      <div class="cta-content">

        <?php

          if( get_field( 'cta_url' ) ) {

            echo ( get_field( 'cta_headline' ) ) ? '<h1 class="cta-headline"><a href="' . $url_output . '">' . get_field( 'cta_headline' ) . '</a></h1>' : '' ;

          } else {

            echo ( get_field( 'cta_headline' ) ) ? '<h1 class="cta-headline">' . get_field( 'cta_headline' ) . '</h1>' : '' ;

          }

        ?>

        <?php echo get_field( 'cta_description' ); ?>

        <?php echo ( get_field( 'cta_arrow_text') && get_field( 'cta_url' ) ) ? '<h2 class="cta-text"><a href="' . $url_output . '">' . get_field( 'cta_arrow_text') . '</a></h2>' : ''; ?>

        <?php echo ( get_field( 'cta_url' ) ) ? '<a class="cta-arrow" href="' . $url_output . '"></a>' : ''; ?>

      </div>


    </div>

  </div>

<?php if( $centered && ( is_singular( 'event' ) || is_singular( 'post' ) ) ) echo '<div class="event-wrapper post-cta"><!-- back to .event-wrapper -->'; ?>

<?php if( $centered && ( is_page_template( 'page-japanese.php' ) || get_post_meta( $parent_id, '_wp_page_template', true ) == 'page-japanese.php' || is_page_template( 'page-chinese.php' ) || get_post_meta( $parent_id, '_wp_page_template', true ) == 'page-chinese.php' ) ) echo '<div class="international-wrapper"><!-- break out of .international-wrapper -->'; ?>


<?php if ($centered ) : ?>
<div class="entry-content"><!-- back to the regular schedule -->


  <?php

endif;

  endif;

	return ob_get_clean();


  };

  add_shortcode( 'cta', 'shortcode_cta_generic' );
