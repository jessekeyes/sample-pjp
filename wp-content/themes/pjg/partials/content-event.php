<?php
/**
 * Template part for displaying single posts.
 *
 * @package pjg
 */
global $EM_Event;

$recurrence_post_id = wp_get_post_parent_id( $post->ID );

// loop the administrative categories this post is tied to
// and look for a page with a matching name
// if exists, set that to the location_cta and stop looping
$admin_categories = wp_get_object_terms($post->ID, 'administrative');
$location_cta = null;

// check if a primary category, provided by yoast is set (source: http://www.joshuawinn.com/using-yoasts-primary-category-in-wordpress-theme/ )
if ( class_exists('WPSEO_Primary_Term') ) {

  $wpseo_primary_term = new WPSEO_Primary_Term( 'administrative', get_the_id() );
	$wpseo_primary_term = $wpseo_primary_term->get_primary_term();

  if( $wpseo_primary_term != null ) {

    $wpseo_primary_term = get_term( $wpseo_primary_term );

    $location_cta = get_page_by_title( $wpseo_primary_term->name );

  }

} elseif( !empty( $admin_categories ) ) { // fallback to first hit

  foreach( $admin_categories as $admin_category ) {

    // Retrieves a post given its title. If more than one post uses the same title, the post with the smallest ID will be returned.
    $location_cta = get_page_by_title( $admin_category->name );

  }

}


?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

  <?php get_template_part( 'partials/module', 'featured-media' ); ?>

  <div class="event-wrapper">

    <?php get_template_part( 'partials/sidebar', 'event' ); ?>

    <div class="entry-content">
      <?php the_content(); ?>
    </div><!-- .entry-content -->

  </div>

  <?php if( $location_cta ) : ?>


  <article class="cta cta-event aligncenter">

    <?php if( has_post_thumbnail( $location_cta->ID ) ) : ?>

    <div class="cta-image">

      <?php echo '<a href="' . get_post_permalink($location_cta->ID) . '">'; ?>

      <?php echo get_the_post_thumbnail($location_cta->ID, 'cta'); ?>

      <?php echo '</a>'; ?>

    </div>

    <?php endif; ?>

    <div class="cta-copy<?php echo ( !has_post_thumbnail( $location_cta->ID ) ) ? ' no-image' : ''; ?>">

      <div class="cta-content">

        <h4 class="location-cta-sur-head sur-title">WHERE IS THIS EVENT HAPPENING?</h4>

        <h1 class="cta-headline"><a href="<?php echo get_post_permalink($location_cta->ID); ?>"><?php echo $location_cta->post_title; ?></a></h1>

        <?php

        $theexcerpt = ( $location_cta->post_excerpt != '' ) ? $location_cta->post_excerpt : $location_cta->post_content;

        $theexcerpt = wp_trim_words( $theexcerpt, 55, '&nbsp;<a class="read_more" href="'. get_permalink() . '">' . '...' . '</a>');

        echo apply_filters( 'the_content', $theexcerpt )

        ?>


        <?php echo '<a class="cta-arrow" href="' . get_post_permalink($location_cta->ID) . '"></a>'; ?>

      </div>


    </div>

  </article>

  <?php endif; ?>

</article><!-- #post-## -->
