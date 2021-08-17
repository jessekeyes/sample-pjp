<?php

// filter the Gravity Forms button type
add_filter( 'gform_submit_button', 'form_submit_button', 10, 2 );

function form_submit_button( $button, $form ) {

  // return "<button class='button' id='gform_submit_button_{$form['id']}'><span>Submit</span></button>";

  $output = '<div class="submit-form"><hr class="rule-loading">';

  // $output .= '<div class="hidden">' . $button . '</div>';

  $output .= '<button class="button load-more-action gform-submit-action" id="gform_submit_button_' . $form['id'] . '"><span>'. $form['button']['text'] . '</span></button>';


  $output .= '<hr class="rule-loading"></div>';

  return $output;

  // return pre_printr( $form );

}
