<?php
/**
 * The template part for displaying an excerpt within the loop
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package pjg
 */

 $photo_class = '';

 if( in_category( 'photos-videos' ) && 'post' == get_post_type() ) {

   $photo_class = ' item-overlay';

 };

?>

<article style="opacity:0;" id="post-<?php the_ID(); ?>" <?php post_class( 'item item-excerpt' . $photo_class ); ?>>

  <div style="position: relative;">

  <?php

    $featured_image = ( $photo_class == '' ) ? pjg_get_featured_image_excerpt( $post->ID, 'post-tile' ) : pjg_get_featured_image_excerpt( $post->ID, 'not-square' );

    $sur_title = pjg_the_excerpt_terms( get_the_ID(), 'category', '<h3 class="sur-title">', ' ', '</h3>' );

    if( $featured_image ) :

  ?>

  <a href="<?php echo get_permalink();?>" class="permalink img">

    <?php echo $featured_image; ?>

  </a>

  <?php endif; ?>

  <header class="titles entry-header">

    <?php echo $sur_title; ?>

    <?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

    <div class="entry-meta">
      <?php pjg_posted_on( get_post_type(), true, true ); ?>

      <?php if( 'event' == get_post_type() ) :

        $recurrence_post_text = get_field( 'recurrence_descriptive_text', pjg_recurrence_post_id( $EM_Event->recurrence_id  ) );
        echo ( $post_type == 'event' && $recurrence_post_text != '' ) ? '<p class="recurrence-description">' . $recurrence_post_text . '</p>' : '';

        endif; ?>


    </div><!-- .entry-meta -->

    <?php echo ( $photo_class != '' ) ? '<div class="arrow"></div>' : ''; ?>

  </header>

  <?php if( 'post' == get_post_type() && $photo_class == '' ) : ?>

    <div class="entry-summary">
      <?php the_excerpt(); ?>
    </div><!-- .entry-summary -->

  <?php endif; ?>

  <?php echo ( $photo_class != '' ) ? '<div class="image-gradient"></div>' : '';?>
</div>
</article>
