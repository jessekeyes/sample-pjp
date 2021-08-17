<?php
/**
 * pjg functions and definitions
 *
 * @package pjg
 */

if ( ! function_exists( 'pjg_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function pjg_setup() {

  // Define VERSION if not using wp.scaffold
  if ( !defined( 'VERSION' ) ) :
    define( 'VERSION', time() );
  endif;

  /*
   * Make theme available for translation.
   * Translations can be filed in the /languages/ directory.
   * If you're building a theme based on pjg, use a find and replace
   * to change 'pjg' to the name of your theme in all the template files
   */
  load_theme_textdomain( 'pjg', get_template_directory() . '/languages' );

  // Add default posts and comments RSS feed links to head.
  add_theme_support( 'automatic-feed-links' );

  /*
   * Let WordPress manage the document title.
   * By adding theme support, we declare that this theme does not use a
   * hard-coded <title> tag in the document head, and expect WordPress to
   * provide it for us.
   */
  add_theme_support( 'title-tag' );

  /*
   * Enable support for Post Thumbnails on posts and pages.
   *
   * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
   */
  add_theme_support( 'post-thumbnails' );

  // update defaults
  update_option( 'thumbnail_size_w', 170 );
  update_option( 'thumbnail_size_h', 170 );

  update_option( 'medium_size_w', 376 );
  update_option( 'medium_size_h', 376 );

  update_option( 'large_size_w', 788 );
  update_option( 'large_size_h', 788 );

  // custom designed sizes
  add_image_size( 'gallery', 1200, 600, true ); // need to force crop, will crop smaller tho?

  add_image_size( 'gallery-portrait', 1200, 600  ); // soft version of the above, but css forces height of 800px

  add_image_size( 'gallery-full', 1600, 800, true  ); // hard crop, even portraits

  add_image_size( 'portrait', 357, 400, true  ); // mobily

  add_image_size( 'cta', 600, 600, true ); // generic CTA sq image

  add_image_size( 'portrait-tab', 732, 820, true ); // larger portrait cuz reasons

  add_image_size( 'child-one', 843, 692, true ); // smaller child-tile

  add_image_size( 'child-two', 1049, 692, true ); // larger child-tile

  add_image_size( 'child-middle', 746, 525, true ); // larger child-tile

  add_image_size( 'post-tile', 582, 450, true ); // post/event tiles

  add_image_size( 'not-square', 582, 528, true ); // not a square for reasons

  add_image_size( 'sponsor-logo', 150, 100 ); // softy crop for sponsors


  add_post_type_support( 'attachment:audio', 'thumbnail' );
  add_post_type_support( 'attachment:video', 'thumbnail' );

  // This theme uses wp_nav_menu() in one location.
  register_nav_menus( array(
    'primary' => esc_html__( 'Primary Menu', 'pjg' ),
    'global' => esc_html__( 'Global Menu', 'pjg' ),
    'footer' => esc_html__( 'Footer Menu', 'pjg' ),
  ) );

  /*
   * Switch default core markup for search form, comment form, and comments
   * to output valid HTML5.
   */
  add_theme_support( 'html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
  ) );


 add_post_type_support( 'page', 'excerpt' );

  /*
   * Enable support for Post Formats.
   * See http://codex.wordpress.org/Post_Formats
  //  */
  // add_theme_support( 'post-formats', array(
  //   'aside',
  //   'image',
  //   'video',
  //   'quote',
  //   'link',
  // ) );

  /**
   * Custom image sizes
   */
  //add_image_size( 'hero', 1400, 788, true );

  /**
   * Remove extraneous things
   */
  add_action( 'wp_head', 'remove_widget_action', 1);
  remove_action( 'wp_head', 'rsd_link' );
  remove_action( 'wp_head', 'wlwmanifest_link' );
  remove_action( 'wp_head', 'index_rel_link' );
  remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
  remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
  remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
  remove_action( 'wp_head', 'feed_links_extra', 3 );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
  remove_filter( 'the_content', 'prepend_attachment' );
  remove_theme_support( 'post-formats');

  function remove_widget_action() {
    global $wp_widget_factory;

    remove_action( 'wp_head', array($wp_widget_factory->widgets[ 'WP_Widget_Recent_Comments' ], 'recent_comments_style') );
  }

  function disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
      return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
      return array();
    }
  }
}
endif; // pjg_setup

add_action( 'after_setup_theme', 'pjg_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function pjg_content_width() {
  $GLOBALS[ 'content_width' ] = apply_filters( 'pjg_content_width', 1280 );
}
add_action( 'after_setup_theme', 'pjg_content_width', 0 );


if ( ! function_exists( 'pjg_scripts_styles' ) ) :
  /**
   * Enqueue scripts and styles.
   *
   * @uses wp_enqueue_script
   * @uses wp_enqueue_style
   *
   * @since 0.1.0
   */

  function pjg_scripts_styles() {

    if ( !is_admin() ) {

      wp_enqueue_script('jquery');

      if( is_archive() || is_page( 'events' ) || is_home() ) {

        // Load the datepicker script (pre-registered in WordPress & with EM plugin
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if ( !is_plugin_active( 'events-manager/events-manager.php' ) ) {

          wp_enqueue_script( 'jquery-ui-datepicker' );

        }

        // You need styling for the datepicker. For simplicity I've linked to Google's hosted jQuery UI CSS.
        wp_register_style( 'jquery-ui', 'https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css' );
        wp_enqueue_style( 'jquery-ui' );

        wp_enqueue_script( 'filter', get_template_directory_uri() . "/assets/js/filter.js", array( 'pjg', 'masonry' ), VERSION, true );

        wp_enqueue_script( 'image_load', get_template_directory_uri() . "/assets/js/vendor/imagesloaded.pkgd.min.js", array( 'masonry', 'jquery' ), VERSION, true );

        wp_enqueue_script( 'masonry', get_template_directory_uri() . "/assets/js/vendor/masonry.pkgd.min.js", array( 'jquery' ), VERSION, true );



      }

      // if sharedaddy used, load pjg.css after it to overrides

      $jetpackMode = ( defined( 'JETPACK_DEV_DEBUG' ) && JETPACK_DEV_DEBUG ) ? array( 'sharedaddy' ) : array( 'jetpack_css' );
      $jetpackMode = ( defined( 'WP_ENV' ) && WP_ENV != 'local' ) ? $jetpackMode : null; // check if local
      $css_placement = ( is_singular( array( 'post', 'event' ) ) ) ? $jetpackMode : null;

      // slick slider for carousels
      wp_enqueue_script( 'slick', get_template_directory_uri() . "/assets/js/vendor/slick.min.js", array( 'jquery' ), VERSION, 'all' );
      wp_enqueue_script( 'slick-lightbox', get_template_directory_uri() . "/assets/js/vendor/slick-lightbox.min.js", array( 'slick' ), VERSION, 'all' );

      wp_enqueue_style( 'pjg-style', get_template_directory_uri() . "/assets/css/pjg.css", $css_placement, VERSION, 'all' );

      wp_enqueue_script( 'pjg-head', get_template_directory_uri() . "/assets/js/head.js", array(), VERSION, false );
      wp_enqueue_script( 'pjg', get_template_directory_uri() . "/assets/js/pjg.js", array( 'jquery' ), VERSION, true );


      // Donorbox
      wp_enqueue_script( 'donorbox', 'https://donorbox.org/install-popup-button.js' );
      wp_add_inline_script( 'donorbox', 'window.DonorBox = { widgetLinkClassName: \'custom-dbox-popup\' };' );

      global $wp_query;

      $wpURLs = array(
        'template_directory_uri' => get_template_directory_uri(),
        'stylesheet_directory_uri' => get_stylesheet_directory_uri(),
        'siteurl' => get_option( 'siteurl' ),
        'wpurl' => get_bloginfo( 'wpurl' ),
        'url' => get_bloginfo( 'url' ),
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'query_vars' => json_encode( $wp_query->query ),
        'posts_per_page' => get_option( 'posts_per_page' ),
      );

      wp_localize_script( 'pjg', 'wpURLs', $wpURLs );

    }
  }

endif; //pjg_scripts_styles

add_action( 'wp_enqueue_scripts', 'pjg_scripts_styles' );

function pjg_defer_attribute($tag, $handle) {
   // add script handles to the array below
   $scripts_to_defer = array('donorbox');

   foreach($scripts_to_defer as $defer_script) {
      if ($defer_script === $handle) {
         return str_replace(' src', ' defer="defer" src', $tag);
      }
   }
   return $tag;
}
add_filter('script_loader_tag', 'pjg_defer_attribute', 10, 2);


if ( ! function_exists( 'pjg_admin_scripts_styles' ) ) :
  /**
   * Enqueue admin scripts and styles.
   *
   * @uses wp_enqueue_script
   * @uses wp_enqueue_style
   *
   * @since 0.1.0
   */

  function pjg_admin_scripts_styles() {

    wp_enqueue_script( 'pjg-admin', get_template_directory_uri() . "/assets/js/admin.js", array(), VERSION, true );

    wp_enqueue_style( 'pjg-admin', get_template_directory_uri() . "/assets/css/admin.css", array(), VERSION );
  }
endif; // pjg_admin_scripts_styles

add_action( 'admin_enqueue_scripts', 'pjg_admin_scripts_styles' );


if ( ! function_exists( 'pjg_editor_styles' ) ) :
  /**
   * Add Editor styles.
   *
   * @uses add_editor_style
   *
   * @since 0.1.0
   */

  function pjg_editor_styles() {

    add_editor_style( get_template_directory_uri() . "/assets/css/editor.css" );

  }
endif; // pjg_editor_styles

add_action( 'admin_init', 'pjg_editor_styles' );

// Change default Posts to News as labels only
function pjg_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'News';
    $submenu['edit.php'][5][0] = 'News';
    $submenu['edit.php'][10][0] = 'Add News';
    // $submenu['edit.php'][16][0] = 'News Tags';
}
function pjg_change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'News';
    $labels->singular_name = 'News';
    $labels->add_new = 'Add News';
    $labels->add_new_item = 'Add News';
    $labels->edit_item = 'Edit News';
    $labels->new_item = 'News';
    $labels->view_item = 'View News';
    $labels->search_items = 'Search News';
    $labels->not_found = 'No News found';
    $labels->not_found_in_trash = 'No News found in Trash';
    $labels->all_items = 'All News';
    $labels->menu_name = 'News';
    $labels->name_admin_bar = 'News';
}

add_action( 'admin_menu', 'pjg_change_post_label' );
add_action( 'init', 'pjg_change_post_object' );

// ACF options page
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page( array( 'page_title' => 'PJG Options', 'menu_slug' => 'pjg_options' ) );

}

// dev environment is protected by basic auth, but SearchWP needs to know that for indexing to work
if( defined( 'BASIC_AUTH_USERNAME' ) && defined( 'BASIC_AUTH_PASSWORD' ) ) {
    function pjg_searchwp_basic_auth_creds() {

        $credentials = array(
            'username' => BASIC_AUTH_USERNAME, // the HTTP BASIC AUTH username
            'password' => BASIC_AUTH_PASSWORD  // the HTTP BASIC AUTH password
        );

        return $credentials;
    }

    add_filter('searchwp_basic_auth_creds', 'pjg_searchwp_basic_auth_creds');
}



// fix the google calendar location link, instead of #_LOCATION, switch it to #_LOCATIONFULLLINE
add_filter( 'em_event_output_placeholder','pjg_em_event_output_placeholder', 1, 3 );
function pjg_em_event_output_placeholder($replace, $EM_Location, $result) {

    if ( $result == '#_EVENTGCALLINK' || $result == '#_EVENTGCALURL' ) {
        // swap the value of the location in the URL
        $replace = str_replace( urlencode($EM_Location->output('#_LOCATION')),
                                urlencode($EM_Location->output('#_LOCATIONFULLLINE')), $replace);
    }
    return $replace;
}



// gets posts that belong in the international templates side bar based on the following:
// a) If it has child pages and no parent - all of the page's child pages - AND ITSELF.
// b) If it is a child page, it displays all sibling pages AND the parent page.
// c) If it is a grandchild page, it displays grandparent, parent and aunt/uncle pages
//
// returns an array of arrays with keys title, link, and active
function pjg_get_international_sidebar_links( $page_id ) {

    $links = [];

    // lookup parent / grandparent ids
    $parent_id = wp_get_post_parent_id( $page_id );
    $grand_parent_id = wp_get_post_parent_id( $parent_id );

    // if is international template, or parent or grandparent is
    $showsidebar = ( is_page_template( 'page-japanese.php' ) || is_page_template( 'page-chinese.php' ) || get_post_meta( $parent_id, '_wp_page_template', true ) == 'page-japanese.php' || get_post_meta( $parent_id, '_wp_page_template', true ) == 'page-chinese.php' || get_post_meta( $grand_parent_id, '_wp_page_template', true ) == 'page-japanese.php' || get_post_meta( $grand_parent_id, '_wp_page_template', true ) == 'page-chinese.php'  ) ? true : false;

    if($grand_parent_id || $parent_id && $showsidebar ) {

        // this is for cases b) and c) in the comments

        $id_to_use = $parent_id;
        // if grandparent is set, use it
        if($grand_parent_id) {
            $id_to_use = $grand_parent_id;
        }

        // display parent / grandparent page and all its children (the parent + siblings, or grandparent + aunts/uncles)

        // start with the parent
        $row = array('title' => get_the_title($id_to_use), 'link' => get_the_permalink($id_to_use), 'active' => false);
        $links[] = $row;

        // get the children
        $args = array(
            'post_type' => 'page',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'post_parent' => $id_to_use,
            'order' => 'ASC',
            'orderby' => 'menu_order post_title'
        );

        $children = new WP_Query($args);
        if( $children->have_posts() ) {
            while ($children->have_posts()) {
                $children->the_post();

                $row = array('title' => get_the_title(), 'link' => get_the_permalink(), 'active' => false);

                // mark the current page active if found
                if(get_the_ID() == $page_id) {
                    $row['active'] = true;
                }

                $links[] = $row;
            }
        }

    } elseif( $showsidebar ) {

        // case a) in the comments
        // show this page (marked active), plus this page's children
        $row = array('title' => get_the_title($page_id), 'link' => get_the_permalink($page_id), 'active' => true);
        $links[] = $row;

        // get the children
        $args = array(
            'post_type' => 'page',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'post_parent' => $page_id,
            'order' => 'ASC',
            'orderby' => 'menu_order post_title'
        );

        $children = new WP_Query($args);
        if( $children->have_posts() ) {
            while ($children->have_posts()) {
                $children->the_post();
                $row = array('title' => get_the_title(), 'link' => get_the_permalink(), 'active' => false);
                $links[] = $row;
            }
        } else {
            // this page is not a child page (top level), but also has no children
            // clear the links array so nothing shows up
            $links = array();
        }

    }

    return $links;

}


/**
 * Custom Post Types.
 */

$post_types = glob( get_template_directory() . '/post-types/*.php', GLOB_NOSORT );

foreach ( $post_types as $post_type ) :

  require $post_type;

endforeach;


/**
 * Custom Taxonomies.
 */

$taxonomies = glob( get_template_directory() . '/taxonomies/*.php', GLOB_NOSORT );

foreach ( $taxonomies as $taxonomy ) :

  require $taxonomy;

endforeach;


/**
 * Custom Widgets.
 */

$widgets = glob( get_template_directory() . '/widgets/*.php', GLOB_NOSORT );

foreach ( $widgets as $widget ) :

  require $widget;

endforeach;


/**
 * Custom Shortcodes.
 */

$shortcodes = glob( get_template_directory() . '/shortcodes/*.php', GLOB_NOSORT );

foreach ( $shortcodes as $shortcode ) :

  require $shortcode;

endforeach;


/**
 * Jetpack functions and filters
 */
require get_template_directory() . '/includes/jetpack.php';

/**
 * Custom Event Functions
 */
require get_template_directory() . '/includes/events.php';


/**
 * Custom Ajax Functions
 */
require get_template_directory() . '/includes/ajax.php';


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/includes/template-tags.php';


/**
 * Custom Queries.
 */
require get_template_directory() . '/includes/queries.php';


/**
 * Custom filters.
 */
require get_template_directory() . '/includes/filters.php';


/**
 * Custom Sidebars.
 */
require get_template_directory() . '/includes/sidebars.php';


/**
 * Utility functions.
 */
require get_template_directory() . '/includes/utilities.php';


/**
 * Visitor Info Utility Functions
 */
require get_template_directory() . '/includes/visitor-info.php';

/**
 * Gravity Forms Functions
 */
require get_template_directory() . '/includes/gravity-forms.php';
