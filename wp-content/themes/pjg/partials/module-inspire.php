<?php
/**
 * partial renders inspire LPM
 *
 * used on most templates, except search
 *
 *
 * @package pjg
 */
?>

<?php

  // gather random inspiration post

  $args = array( 'posts_per_page' => 1, 'orderby' => 'rand', 'post_type' => 'inspire', 'post_status' => 'publish' );

  $inspire = new WP_Query( $args );

  if( $inspire->have_posts() ) :


 ?>


<div class="inspiration item">

  <?php while( $inspire->have_posts() ) : $inspire->the_post(); ?>

    <?php echo ( get_field( 'inspire_sur_title' ) != '' ) ? '<div class="inspiration_sur_title">' . get_field( 'inspire_sur_title' ) . '</div>' : '' ;?>

    <div class="inspiration-copy">

      <?php echo get_field( 'inspiration_copy' ); ?>

    </div>

  <?php endwhile; wp_reset_query(); ?>

</div>


<?php endif; ?>
