<?php

// template for dynamic content feed, news post type
// will show either 1 event or 3 events, but will only show 3 if there are 4 or more posts
// this gets included by pjg_ajax_dynamic_content_feed() so any variable in there is fair game

$count_class = 'single';
if($posts->found_posts >= 4) {
    $count_class = 'multiple';
}
?>

<div class="dynamic-content-feed-rows <?= $feed_type; ?> multiple">

    <div class="dynamic-content-feed-header show">
        <div class="headline"><?= $feed_headline; ?>

          <?php
          // only show the view all events link if in multiple mode
          if( $count_class == 'multiple' ) { $view_all_link = ( $category ) ? get_category_link($category) : '/news/'; ?>
              / <span class="view-all"><a href="<?= $view_all_link; ?>"><?= ($view_all_copy) ? $view_all_copy : 'View All News'; ?></a></span>
          <?php } ?>

        </div>
    </div>
    <?php

$displayed = 0;
while ($posts->have_posts()) : $posts->the_post();

    $post = get_post();
    ?>

    <div class="dynamic-content-feed-row <?= $feed_type; ?> multiple">

      <div class="entry-media">
        <a href="<?php the_permalink(); ?>">
          <?php echo pjg_get_featured_image_excerpt( $events->ID, 'post-tile' ); ?>
        </a>

      </div>

      <?php // if( $count_class == 'single' ) { echo '<div class="single-wrapper">'; }

        $lang_class = ( in_category( array( 'bilingual-newsletter' ) ) ) ? ' font-robotolight' : '';

      ?>

      <div class="entry-header-wrapper">

        <div class="entry-title<?= $lang_class; ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>

        <div class="entry-summary"><?= $excerpt_trimmed; ?></div>

      </div>


    </div>

    <?php
    $displayed++;

    // in single mode, show just the one
    // if($count_class == 'single') {
    //     break;
    // } else {
        // stop after the 3rd one
        if($displayed >= 3) {
            break;
        }
    // }

endwhile;

echo '</div>';
