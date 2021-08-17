<?php
/**
 * Registeres visitor info shortcode.
 * @package pjg
 */
function pjg_visitor_info_shortcode() {
  // prevent displaying the template, load into output buffer
  ob_start();
  get_template_part('partials/shortcode-visitor-info' );

  // return the template output
  return ob_get_clean();
}
add_shortcode( 'visitor-info', 'pjg_visitor_info_shortcode' );
