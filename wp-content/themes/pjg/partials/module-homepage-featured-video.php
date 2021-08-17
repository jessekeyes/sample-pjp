<?php

// image logic

$image = get_field( 'homepage_featured_image' );
$image_mobile_set = get_field( 'homepage_featured_image_mobile' );

$image_mobile = ( $image_mobile_set ) ? $image_mobile_set['sizes']['portrait'] : $image['sizes']['portrait'];
$image_tab = ( $image_mobile_set ) ? $image_mobile_set['sizes']['portrait-tab'] : $image['sizes']['portrait-tab'];

$display_title = ( get_field( 'display_title' ) ) ? '<h1 class="entry-title">' . get_field( 'display_title' ) . '</h1>' : '';

// pre_printr( $image );
$caption = $image['caption'];

$credit = ( get_field( 'credit',  $image['id'] ) && $caption != ''  ) ? ' / <cite>' . get_field( 'credit',  $image['id'] ) . '</cite>' : '';

$credit = ( get_field( 'credit',  $image['id'] ) && $caption == '' ) ? '<cite>' . get_field( 'credit',  $image['id'] ) . '</cite>' : $credit;

?>

<div class="featured-image">
<div class="image-gradient"></div>



  <?php if( get_field( 'characters' ) ) : ?>

    <div class="kanji">

      <?php echo get_field( 'characters' ); ?>

    </div>

  <?php endif; ?>

  <div class="media-loop">
    <?php

      if ( get_field( 'looping_video_mp4' ) ) :
    ?>
    <picture>
      <!--[if IE 9]><video style="display: none;"><![endif]-->
      <source media="(min-width: 1024px)" srcset="<?php echo $image['sizes']['gallery-full'];?>">
      <source media="(min-width: 768px)" srcset="<?php echo $image_tab; ?>">
      <source media="(min-width: 320px)" srcset="<?php echo $image_mobile;?>">
      <!--[if IE 9]></video><![endif]-->
      <img class="poster mobile" src="<?php echo $image['sizes']['gallery-full'];?>" alt="<?php echo $image['title']; ?>">
    </picture>
    <video id="loop" preload="none" loop="loop" muted="muted" autoplay="" volume="0" poster="<?= $image['sizes']['gallery-full'];?>">
      <source src="<?= get_field( 'looping_video_mp4' );?>" type="video/mp4">
      <img src="<?= $image['sizes']['gallery-full'];?>" class="poster">
    </video>
    <?php else : ?>
      <img src="<?= $image['sizes']['gallery-full'];?>" class="poster">
    <?php endif; ?>
  </div>

  <div class="title-wrapper">

    <?php if( !is_single() ) : ?>

    <div class="titles">
      <?php echo $display_title; ?>
      <div class="entry-content">

        <?php if( get_field( 'characters' ) ) : ?>

          <div class="kanji">

            <?php echo get_field( 'characters' ); ?>

          </div>

        <?php endif; ?>

        <?php the_content(); ?>

        <?php if( get_field( 'homepage_url' ) ) {

          $homepage_url = '<a class="arrow white" href="' . get_field( 'homepage_url' ) . '"></a>';

          $homepage_url = autoblank( $homepage_url );

          echo $homepage_url;

        };

        ?>

      </div>

    </div>

    <?php endif; ?>

    <div class="caption">

      <?php echo $caption . $credit; ?>

    </div>

  </div>


</div>

<div class="caption caption-mobile">

  <?php echo $caption . $credit; ?>

</div>
