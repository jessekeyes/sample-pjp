<?php

// image logic

$image = get_field( 'featured_image' );
$image_mobile_set = get_field( 'featured_image_mobile' );

$image_mobile = ( $image_mobile_set ) ? $image_mobile_set['sizes']['portrait'] : $image['sizes']['portrait'];
$image_tab = ( $image_mobile_set ) ? $image_mobile_set['sizes']['portrait-tab'] : $image['sizes']['portrait-tab'];

$sur_title = ( get_field( 'title_sur' ) ) ? '<h3 class="sur-title">' . get_field( 'title_sur' ) . '</h3>' : '';

// pre_printr( $image );
$caption = $image['caption'];

$credit = ( get_field( 'credit',  $image['id'] ) && $caption != ''  ) ? ' / <cite>' . get_field( 'credit',  $image['id'] ) . '</cite>' : '';

$credit = ( get_field( 'credit',  $image['id'] ) && $caption == '' ) ? '<cite>' . get_field( 'credit',  $image['id'] ) . '</cite>' : $credit;

?>

<div class="featured-image">
<div class="image-gradient"></div>


  <picture>
    <!--[if IE 9]><video style="display: none;"><![endif]-->
    <source media="(min-width: 1024px)" srcset="<?php echo $image['sizes']['gallery-full'];?>">
    <source media="(min-width: 768px)" srcset="<?php echo $image_tab; ?>">
    <source media="(min-width: 320px)" srcset="<?php echo $image_mobile;?>">
    <!--[if IE 9]></video><![endif]-->
    <img src="<?php echo $image['sizes']['gallery-full'];?>" alt="<?php echo $image['title']; ?>">
  </picture>

  <div class="title-wrapper">

    <?php if( !is_single() ) : ?>

    <div class="titles">
      <?php echo $sur_title; ?>
      <?php echo '<h1 class="entry-title">' . get_the_title() . '</h1>'; ?>

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
