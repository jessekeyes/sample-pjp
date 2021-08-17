<?php

// image logic

$image = get_field( 'featured_image' ); // fallbacks
$image_mobile = get_field( 'featured_image_mobile' );// fallbacks
$youtube = get_field( 'feature_youtube' );
$youtube = apply_filters('the_content', $youtube );


$sur_title = ( get_field( 'title_sur' ) ) ? '<h3 class="sur-title">' . get_field( 'title_sur' ) . '</h3>' : '';



?>

<div class="featured-youtube">


<?php

  if( !is_single() ) {

    echo '<div class="titles">';
    echo $sur_title;
    echo '<h1 class="entry-title">' . get_the_title() . '</h1>';
    echo '</div>';

  }

?>


<?php echo $youtube; // @TODO add mobile fallbacks ?>


</div>
