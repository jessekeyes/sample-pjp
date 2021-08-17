<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package pjg
 */

?><!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9]><html class="no-js lt-ie10" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta http-equiv="X-UA-Compatible" content="IE=10;IE=9;IE=8;IE=7;IE=EDGE,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

  <meta name="apple-mobile-web-app-title" content="Portland Japanese Garden" />

  <?php wp_head(); ?>

  <?php if( is_404() ) {

    $class404 = 'page featured-media media-top';


  }

  ?>
</head>

<body <?php body_class( $class404 ); ?>>
<div id="page" class="hfeed site">
  <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'pjg' ); ?></a>



  <header id="masthead" class="site-header" role="banner">
    <!-- Alert  -->
    <?php get_template_part('partials/header', 'alert'); ?>
    <div class="container">

      <div class="site-branding">
        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
      </div><!-- .site-branding -->

      <nav id="site-navigation" class="main-navigation" role="navigation">
        <div class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">Explore</div>
        <?php wp_nav_menu( array( 'theme_location' => 'global', 'menu_id' => 'global-menu' ) ); ?>
        <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
      </nav><!-- #site-navigation -->

    </div><!-- /container -->

    <div class="nav-overlay hidden">

      <!-- Visit Submenu -->
      <?php get_template_part('partials/header', 'visitor-info'); ?>

      <ul id="search-header" class="sub-menu">
        <li><?php get_search_form(); ?></li>
      </ul>

    </div>

  </header><!-- #masthead -->

  <div id="content" class="site-content">
