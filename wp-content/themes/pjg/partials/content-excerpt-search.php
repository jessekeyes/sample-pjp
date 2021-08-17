<?php

  $featured_image = pjg_get_featured_image_excerpt( $post->ID, 'post_tile' );

  $imageclass = ' has_image';

  if( $featured_image == '' ) {

    $imageclass = '';

  }


?>


<article id="post-<?php the_ID(); ?>" <?php post_class( 'item item-search' . $imageclass ); ?>>

  <?php

    $sur_title = '';

    if( 'event' == get_post_type() ) {

      $sur_title = '<h3 class="sur-title">Event</h3>';

    } elseif( 'post' == get_post_type() ) {

      if( has_category( 'photos-videos' ) ) {

        $sur_title = '<h3 class="sur-title">Photos & Videos</h3>';

      } else {

        $sur_title = '<h3 class="sur-title">News</h3>';

      }

    }

    if( $featured_image ) :

  ?>

  <a href="<?php echo get_permalink();?>" class="permalink img">

    <?php echo $featured_image; ?>

  </a>

<?php endif; ?>

  <div class="titles-wrapper">

    <header class="titles entry-header">

      <?php echo $sur_title; ?>

      <?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

      <div class="entry-meta">

        <?php if( get_post_type() == 'event' || get_post_type() == 'post' ) pjg_posted_on( get_post_type(), true, true, true ); ?>

      </div><!-- .entry-meta -->


      <?php echo ( $photo_class != '' ) ? '<div class="arrow"></div>' : ''; ?>

    </header>

    <div class="entry-summary">
      <?php

        $excerpt_trimmed = get_the_excerpt();

        $excerpt_trimmed = '<p>' . wp_trim_words( $excerpt_trimmed, 20, '&nbsp;<a class="read_more" href="'. get_permalink() . '">' . '...' . '</a>' ) . '</p>';

        echo $excerpt_trimmed;

      ?>
    </div><!-- .entry-summary -->

  </div>

</article>
