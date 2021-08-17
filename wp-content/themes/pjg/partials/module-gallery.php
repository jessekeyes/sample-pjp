<?php
/**
 * partial renders a gallery carousel with modal full screen. This one uses ACF Gallery
 *
 * used with featured media, layout almost the same for inline galleries. But since we use WP's gallery, layout is modified in... TK
 *
 *
 * @package pjg
 */


 $images = get_field( 'feature_gallery' );

$sur_title = ( get_field( 'title_sur' ) ) ? '<h3 class="sur-title">' . get_field( 'title_sur' ) . '</h3>' : '';
?>

<div class="gallery-wrapper">

 <div id='gallery_ft-<?php echo $post->ID; ?>' class='gallery gallery-fm'>

   <div class="image-gradient"></div>

  <?php foreach( $images as $image ):

    if ( isset( $image['height'], $image['width'] ) ) {
			$orientation = ( $image['height'] > $image['width'] ) ? 'portrait' : 'landscape';
		}

    $caption = htmlentities( ( get_field( 'credit', $image['id'] ) ) ?  $image['caption'] . '&nbsp;/&nbsp;<cite>' . get_field( 'credit', $image['id'] ) . '</cite>' :  $image['caption'] );

  ?>

  <figure class="gallery-item" data-caption="<?php echo $caption; ?>">
		<div class="gallery-icon <?php echo $orientation; ?>">

			<a href="<?php echo $image['sizes']['gallery-portrait']; ?>">

					<picture>
						<!--[if IE 9]><video style="display: none;"><![endif]-->
						<source media="(min-width: 1024px)" srcset="<?php echo $image['sizes']['gallery-full'];?>">
						<source media="(min-width: 768px)" srcset="<?php echo $image['sizes']['portrait-tab'];?>">
						<source media="(min-width: 320px)" srcset="<?php echo $image['sizes']['portrait'];?>">
						<!--[if IE 9]></video><![endif]-->
						<img src="<?php echo $image['sizes']['gallery-full'];?>" alt="<?php echo $image['title']; ?>">
					</picture>



      </a>
		</div>
  </figure>

    <?php endforeach; ?>

  <div class="title-wrapper">

    <div class="titles">
      <?php if( !is_single() ) : ?>
      <?php echo $sur_title; ?>
      <?php echo '<h1 class="entry-title">' . get_the_title() . '</h1>'; ?>

      <?php endif; ?>

    </div>


    <div class="gallery-nav"><div class="gallery-index"></div><div class="gallery-caption"></div></div>

  </div>

</div>



<div class="gallery-mobile">

  <div class="gallery-nav"><div class="gallery-index"></div><div class="gallery-caption"></div></div>

</div>

</div><!-- /wrapper -->
