<?php
/**
 * shortcode to better control blockquotes
 *
 * @package pjg
 */


  function shortcode_blockquote( $atts, $content = null ) {

    $atts = shortcode_atts( array (

  		'credit' => '',
      'align' => 'center'

  	), $atts );

    $credit = ( !empty( $atts['credit'] ) ) ? '<p><cite>' . esc_attr( $atts['credit'] )  . '</cite></p>' : '';

    $align = ' class="align' .  esc_attr( $atts['align'] ) . '"';

    return '<blockquote' . $align . '><p>' . $content . '</p>' . $credit . '</blockquote>';


  };

  add_shortcode( 'blockquote', 'shortcode_blockquote' );
