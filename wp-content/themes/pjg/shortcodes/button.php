<?php
/**
 * shortcode for button classes
 *
 * @package pjg
 */


  function shortcode_button( $atts, $content = null ) {

    $a = shortcode_atts( array (

  		'url' => '',
      'class' => ''

  	), $atts );

    $url_output = '<a class="button ' . $a['class'] . '" href="' . $a['url'] . '">' . $content . '</a>';

    return autoblank( $url_output );


  };

  add_shortcode( 'button', 'shortcode_button' );
