<?php
/**
 *  Register Sidebars.
 *
 * @package WordPress
 * @subpackage pjg Music News
 */


/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function pjg_widgets_init() {
  register_sidebar( array(
    'name'          => esc_html__( 'Sidebar', 'pjg' ),
    'id'            => 'sidebar-1',
    'description'   => '',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h1 class="widget-title">',
    'after_title'   => '</h1>',
  ) );
}
add_action( 'widgets_init', 'pjg_widgets_init' );
