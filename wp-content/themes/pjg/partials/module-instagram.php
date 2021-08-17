<?php
/**
 * partial renders instagram plugin shortcode
 *
 * used on most templates, except search
 *
 *
 * @package pjg
 */

 ?>


 <div class="instagram-wrapper item">

   <div class="instagram-bug">

     <div class="instagram-title-wrapper">

       <h4 class="instagram-title"><?php echo get_sub_field( 'instagram_title' ); ?></h4>

     </div>

     <div class="instagram-icon-wrapper">

       <div class="instagram-icon"></div>

     </div>

   </div>

   <div class="instagram-feed">

     <?php echo apply_filters( 'the_content', get_sub_field( 'instagram_shortcode' ) ); ?>

   </div>


 </div>
