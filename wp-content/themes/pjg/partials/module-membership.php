<?php
/**
 * partial renders member ship ACF from Options page
 *
 * used on most templates, except search
 *
 *
 * @package pjg
 */



   $membership_url = '<a class="member-cta" href="' . get_field( 'mbp_url', 'option' ) . '"></a>';

   $membership_url = autoblank( $membership_url );

?>
<div class="membership-promo item item-excerpt">

    <div class="bonsai"><?php echo $membership_url; ?></div>


    <div class="description">

      <?php echo get_field( 'mbp_copy ', 'option'); ?>

      <?php echo $membership_url; ?>

    </div>

</div>
