<?php
/**
 * partial renders loop for Lower Page Modules (LPM)
 *
 * used on most templates, except search
 *
 *
 * @package pjg
 */

if( is_home() ) {

  $page_id = get_page_id_by_slug( 'news' );

} elseif( is_post_type_archive( 'event' ) ) {

  $page_id = get_page_id_by_slug( 'events' );

} else {

  $page_id = '';

}


if( have_rows( 'modules_lower', $page_id  ) ) :

 ?>


 <div class="lower-modules">

    <?php
    // loop through the rows of data

    // keep track of the index of the modules_lower being rendered (used by dynamic_content_feed)
    $modules_lower_index = 0;

    while ( have_rows( 'modules_lower', $page_id ) ) : the_row();

      if( get_row_layout() == 'inspire' ):

        get_template_part( 'partials/module', 'inspire' );

      elseif( get_row_layout() == 'instagram_feed' ):

        get_template_part( 'partials/module', 'instagram' );

      elseif( get_row_layout() == 'membership' ):

        get_template_part( 'partials/module', 'membership' );

      elseif( get_row_layout() == 'dynamic_content_feed' ):

        // use include instead of get_template_part so $modules_lower_index is available
        include( locate_template( 'partials/module-feed.php' ) );

      endif;

      $modules_lower_index++;

    endwhile;

   ?>

 </div>


 <?php endif; ?>
