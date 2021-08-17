<?php
/**
 * pjg Body and Post Class filters
 *
 * @package pjg
 */


if ( ! function_exists( 'pjg_body_class' ) ) :
  /**
   * Some extra classes for the body.
   *
   * @param $classes
   *
   * @return $classes
   *
   * @since 0.1.0
   */

  function pjg_body_class( $classes ) {
    global $post;

    $postType = ( get_query_var( 'post_type' ) ) ? get_query_var( 'post_type' ) : 1;

    $youtube = ( !is_archive() && get_field( 'media' ) !== null && get_field( 'media' ) == 'youtube' && get_field( 'feature_youtube' ) != '' ) ? true : false;

    $gallery = ( !is_archive() && get_field( 'media' ) == 'gallery' && get_field( 'feature_gallery' ) !=  '' ) ? true : false;

    $image_featured = ( !is_archive() && get_field( 'media' ) == 'image' && get_field( 'featured_image' ) != '' ) ? true : false;

    $parent_id = wp_get_post_parent_id( $post->ID );

    if( is_page_template( 'page-japanese.php' ) || get_post_meta( $parent_id, '_wp_page_template', true ) == 'page-japanese.php' )
      $classes[] = 'japanese-translated';

    if( is_page_template( 'page-chinese.php' ) || get_post_meta( $parent_id, '_wp_page_template', true ) == 'page-chinese.php' )
      $classes[] = 'chinese-translated';

    if ( is_page() )
      $classes[] = $post->post_type . '-' . $post->post_name;


    if ( ( $image_featured  || $gallery || $youtube || get_field( 'feature_video' ) || get_field( 'homepage_featured_image' ) != '' ) && !is_home() )
      $classes[] = 'featured-media';

    if ( $gallery || get_field( 'feature_video' ) || ( $image_featured && is_page() ) || ( get_field( 'homepage_featured_image' ) !='' ) )
      $classes[] = 'media-top';

    if ( $gallery )
      $classes[] = 'featured-gallery';

    if ( is_page() && $post->post_parent > 0 )
      $classes[] = 'parent-page-' . basename( get_permalink( $post->post_parent ) );

    if ( is_home() || is_search() )
      $classes[] = 'archive';

    return $classes;
  }
endif; // pjg_body_class

add_filter( 'body_class', 'pjg_body_class' );


if ( ! function_exists( 'pjg_post_class' ) ) :
  /**
   * Some extra classes for posts.
   *
   * @param $classes
   *
   * @return $classes
   *
   * @since 0.1.0
   */

  function pjg_post_class( $classes ) {
    global $post;
    $fields = ( function_exists( 'get_fields' ) ) ? get_fields( $post->ID ) : null;

    if ( !empty( $fields[ 'gallery' ] ) || has_post_thumbnail( $post->ID ) )
      $classes[] = 'has-post-img';

    if ( get_field( 'characters') == '' && !empty( $post->post_content ) && !is_single() && !is_front_page() )
      $classes[] = 'the-blue-bar';

    if( get_field( 'show_calendar' ) || get_field( 'price_title' ) != '' || get_field( 'price_copy' ) != '' || is_singular( 'post' ) )
      $classes[] = 'event-sidebar';

      if( !get_field( 'show_calendar' ) && get_field( 'price_title' ) == '' && get_field( 'price_copy' ) == '' && is_singular( 'event' ) ) // no event sidebar, but still need sharing
        $classes[] = 'event-sidebar event-sidebar-share';

    return $classes;
  }
endif; // pjg_post_class

add_filter( 'post_class', 'pjg_post_class' );


if ( ! function_exists( 'pjg_wp_nav_menu_args' ) ) :

  /**
   * Better defaults for wp_nav_menu
   *
   * @param $args (array)
   *
   * @return $args (array)
   *
   * @since 0.1.0
   */

  function pjg_wp_nav_menu_args( $args = '' ) {

    // Always nav, never div
    $args['container'] = 'nav';
    $args['container_class'] = 'navigation-menu';

    if ( 'Social' == $args['menu']->name ) :

      // Except for the social menu, because it's not navigation
      $args['container'] = 'div';

    endif;

    return $args;
  }

endif; // excerpt_length

function add_specific_menu_atts( $atts, $item, $args ) {

  $donate_menu_name = array( 'donate-now' );

  // var_dump( $item );

	if (in_array($item->post_name, $donate_menu_name )) {
	  $atts['class'] = 'custom-dbox-popup';
	}

    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'add_specific_menu_atts', 10, 3 );



// remove tags from posts

function pjg_posts_taxonomy_register(){
    unregister_taxonomy_for_object_type( 'post_tag', 'post' );
}
add_action('init','pjg_posts_taxonomy_register', 100);



/**
 * Extend get terms with post type parameter.
 *
 * @global $wpdb
 * @param string $clauses
 * @param string $taxonomy
 * @param array $args
 * @return string
 */
function pjg_terms_clauses( $clauses, $taxonomy, $args ) {

	if ( isset( $args['post_type'] ) && ! empty( $args['post_type'] ) && $args['fields'] !== 'count' ) {
		global $wpdb;

		$post_types = array();

		if ( is_array( $args['post_type'] ) ) {
			foreach ( $args['post_type'] as $cpt ) {
				$post_types[] = "'" . $cpt . "'";
			}
		} else {
			$post_types[] = "'" . $args['post_type'] . "'";
		}

		if ( ! empty( $post_types ) ) {
			$clauses['fields'] = 'DISTINCT ' . str_replace( 'tt.*', 'tt.term_taxonomy_id, tt.taxonomy, tt.description, tt.parent', $clauses['fields'] ) . ', COUNT(p.post_type) AS count';
			$clauses['join'] .= ' LEFT JOIN ' . $wpdb->term_relationships . ' AS r ON r.term_taxonomy_id = tt.term_taxonomy_id LEFT JOIN ' . $wpdb->posts . ' AS p ON p.ID = r.object_id';
			$clauses['where'] .= ' AND p.post_status = "publish" AND (p.post_type IN (' . implode( ',', $post_types ) . ') OR p.post_type IS NULL)';
			$clauses['orderby'] = 'GROUP BY t.term_id ' . $clauses['orderby'];
		}
	}
	return $clauses;
}

add_filter( 'terms_clauses', 'pjg_terms_clauses', 10, 3 );


add_filter('the_content', 'autoblank');
add_filter('comment_text', 'autoblank');
add_filter('acf_the_content', 'autoblank');

function autoblank( $text ) {

  $home_url = get_bloginfo( 'url' );

  $return = str_replace('href=', 'target="_blank" href=', $text );

  $return = str_replace('target="_blank" href="/', 'href="/', $return );

  $return = str_replace('target="_blank" href="' . $home_url, 'href="' . $home_url, $return );

  $return = str_replace('target="_blank" href="#', 'href="#', $return );
  $return = str_replace(' target = "_blank">', '>', $return );

  return $return;

}



remove_filter( 'image_send_to_editor', 'image_add_caption');
add_filter( 'image_send_to_editor', 'pjg_image_add_caption', 100, 8);

function pjg_image_add_caption( $html, $id, $caption, $title, $align, $url, $size, $alt = '' ) {

	/**
	 * Filters the caption text.
	 *
	 * Note: If the caption text is empty, the caption shortcode will not be appended
	 * to the image HTML when inserted into the editor.
	 *
	 * Passing an empty value also prevents the {@see 'image_add_caption_shortcode'}
	 * Filters from being evaluated at the end of image_add_caption().
	 *
	 * @since 4.1.0
	 *
	 * @param string $caption The original caption text.
	 * @param int    $id      The attachment ID.
	 */
	$caption = apply_filters( 'image_add_caption_text', $caption, $id );

  /**
   * Filters whether to disable captions.
   *
   * Prevents image captions from being appended to image HTML when inserted into the editor.
   *
   * @since 2.6.0
   *
   * @param bool $bool Whether to disable appending captions. Returning true to the filter
   *                   will disable captions. Default empty string.
   */

  $credit = ( !empty( get_field( 'credit', $id ) ) ) ? '<cite>' . get_field( 'credit', $id ) . '</cite>' : '';


  if ( apply_filters( 'disable_captions', '' ) )
    return $html;

  $sep = ( !empty( get_field( 'credit', $id ) ) && $caption != '' ) ? ' / ' : '';

  $id = ( 0 < (int) $id ) ? 'attachment_' . $id : '';

  if ( ! preg_match( '/width=["\']([0-9]+)/', $html, $matches ) )
    return $html;

  $width = $matches[1];

  $html = str_replace( array("\r\n", "\r"), "\n", $html);
  $html = preg_replace_callback( '/<[a-zA-Z0-9]+(?: [^<>]+>)*/', '_cleanup_image_add_caption', $html );

  // Convert any remaining line breaks to <br>.
  $html = preg_replace( '/[ \n\t]*\n[ \t]*/', '<br />', $html );

  $html = preg_replace( '/(class=["\'][^\'"]*)align(none|left|right|center)\s?/', '$1', $html );
  if ( empty($align) )
    $align = 'none';

  $shcode = '[caption id="' . $id . '" align="align' . $align	. '" width="' . $width . '"]' . $html . $sep . $credit . '[/caption]';

  /**
   * Filters the image HTML markup including the caption shortcode.
   *
   * @since 2.6.0
   *
   * @param string $shcode The image HTML markup with caption shortcode.
   * @param string $html   The image HTML markup.
   */
  return apply_filters( 'image_add_caption_shortcode', $shcode, $html );
}


// gallery stuff

// force if attachment found, to show image instead
function pjg_imagelink_setup() {
	$image_set = get_option( 'image_default_link_type' );

	if ( $image_set == 'post' ) {
		update_option('image_default_link_type', 'file');
	}
}
add_action('admin_init', 'pjg_imagelink_setup', 10);




add_filter( 'post_gallery', 'pjg_gallery_style', 10, 2 );


function pjg_gallery_style( $output, $attr ) {

  $html5 = current_theme_supports( 'html5', 'gallery' );
	$atts = shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post ? $post->ID : 0,
		'itemtag'    => $html5 ? 'figure'     : 'dl',
		'icontag'    => $html5 ? 'div'        : 'dt',
		'captiontag' => $html5 ? 'figcaption' : 'dd',
		'columns'    => 3,
		'size'       => 'gallery',
		'include'    => '',
		'exclude'    => '',
		'link'       => ''
	), $attr, 'gallery' );

	$id = intval( $atts['id'] );

	if ( ! empty( $atts['include'] ) ) {
		$_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( ! empty( $atts['exclude'] ) ) {
		$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
	} else {
		$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
	}

	if ( empty( $attachments ) ) {
		return '';
	}

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment ) {
			$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
		}
		return $output;
	}

	$itemtag = tag_escape( $atts['itemtag'] );
	$captiontag = tag_escape( $atts['captiontag'] );
	$icontag = tag_escape( $atts['icontag'] );
	$valid_tags = wp_kses_allowed_html( 'post' );
	if ( ! isset( $valid_tags[ $itemtag ] ) ) {
		$itemtag = 'dl';
	}
	if ( ! isset( $valid_tags[ $captiontag ] ) ) {
		$captiontag = 'dd';
	}
	if ( ! isset( $valid_tags[ $icontag ] ) ) {
		$icontag = 'dt';
	}

	$columns = intval( $atts['columns'] );
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$gallery_style = '';

	/**
	 * Filters whether to print default gallery styles.
	 *
	 * @since 3.1.0
	 *
	 * @param bool $print Whether to print default gallery styles.
	 *                    Defaults to false if the theme supports HTML5 galleries.
	 *                    Otherwise, defaults to true.
	 */
	if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
		$gallery_style = "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				float: {$float};
				margin-top: 10px;
				text-align: center;
				width: {$itemwidth}%;
			}
			#{$selector} img {
				border: 2px solid #cfcfcf;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
			/* see gallery_shortcode() in wp-includes/media.php */
		</style>\n\t\t";
	}

	$size_class = sanitize_html_class( $atts['size'] );
	$gallery_div = "<div class='gallery-wrapper'><div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";

	/**
	 * Filters the default gallery shortcode CSS styles.
	 *
	 * @since 2.5.0
	 *
	 * @param string $gallery_style Default CSS styles and opening HTML div container
	 *                              for the gallery shortcode output.
	 */
	$output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {



    $image_meta  = wp_get_attachment_metadata( $id );
		$orientation = '';
		if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
			$orientation = ( $image_meta['height'] >= $image_meta['width'] ) ? 'portrait' : 'landscape';
		}

    $gallery_image = wp_get_attachment_image_src( $id, 'gallery' );
    $gallery_image_mobile = wp_get_attachment_image_src( $id, 'portrait' );

    if( $orientation == 'portrait' ) {

      $gallery_image = wp_get_attachment_image_src( $id, 'gallery-portrait' );

    }


    $image_output = '<a href="'. $gallery_image[0] . '"><picture>
      <!--[if IE 9]><video style="display: none;"><![endif]-->
      <source media="(min-width: 768px)" srcset="' . $gallery_image[0] . '">
      <source media="(min-width: 320px)" srcset="' . $gallery_image_mobile[0] . '">
      <!--[if IE 9]></video><![endif]-->
      <img src="' . $gallery_image[0] . '" alt="' . $image_meta['caption'] . '">
    </picture></a>';



    $credit_output = ( get_field( 'credit', $id ) ) ? ' / <cite>' .  get_field( 'credit', $id  ) . '</cite>' : "";
    $caption_output = "data-caption=\"" . htmlspecialchars( wptexturize($attachment->post_excerpt) ) . htmlspecialchars( $credit_output ) . "\"";



		$output .= "<{$itemtag} class='gallery-item' {$caption_output}>";
		$output .= "
			<{$icontag} class='gallery-icon {$orientation}'>
				$image_output
			</{$icontag}>";


		$output .= "</{$itemtag}>";
		if ( ! $html5 && $columns > 0 && ++$i % $columns == 0 ) {
			$output .= '<br style="clear: both" />';
		}
	}

	if ( ! $html5 && $columns > 0 && $i % $columns !== 0 ) {
		$output .= "
			<br style='clear: both' />";
	}

  //PJG custom gallery nav

  $output .= "
      <div class=\"gallery-nav\"><div class=\"gallery-index\"></div><div class=\"gallery-caption\"></div></div>";

	$output .= "
		</div></div>\n";

	return $output;
}



if ( ! function_exists( 'pjg_video_params' ) ) :
  /**
   * modify the video output
   */

	function pjg_video_params( $html, $url, $args ) {

    //generate random id for each
    $randomID = uniqid('video');

    /* Force https */
    $html = str_replace('http://', '//', $html);

    /* Modify video parameters. */
    if ( strstr( $html, 'youtube.com/embed/' ) ) {
        $html = str_replace( '?feature=oembed', '?html5=1&feature=oembed&enablejsapi=1&controls=1&showinfo=0&rel=0&autohide=1&wmode=opaque', $html );
    } elseif ( strstr( $html, 'vimeo.com/video/' ) ) {
        $html = str_replace( '" width', '?api=1&player_id='.$randomID.'&badge=0&byline=0&title=0&portrait=0" width', $html );
    }

    //add id to iframe
    $html = str_replace( '<iframe', '<iframe id="'. $randomID .'"', $html );


    return '<p class="video">'.$html.'</p>';
  }

endif;
add_filter( 'embed_oembed_html', 'pjg_video_params', 10, 3 );


/**
 * Include custom archive & pages template rules
 * @param  string $template template location
 * @return string           new template location
 */
function pjg_custom_template_include( $template ) {
  global $post;

  // getting here and nearby attractions
  if ( is_page( array('parking', 'nearby-attractions') ) ){
    $redirected_template = locate_template( array('template-map.php') );

    if ( '' != $redirected_template ) {
      return $redirected_template;
    }

  }

  return $template;
}
add_filter( 'template_include', 'pjg_custom_template_include', 99 );


/**
 * Filter get_the_terms lists to reorder taxonomy terms by category_order
 * @param  $terms
 * @param  $post_id
 * @param  $taxonomy
 * @return $terms  an Array of terms
 */
function pjg_filter_get_the_terms($terms, $post_id, $taxonomy ){
  // skip admin and non-category requests
  if( is_admin() or 'category' != $taxonomy) return $terms;

  // otherwise, setup re-ordering
  $args = array();
  $args['meta_key'] = 'category_order';
  $args['orderby'] = 'category_order';

  // fetch terms
  $terms = wp_get_object_terms($post_id, $taxonomy, $args);

  return $terms;
}
add_filter('get_the_terms', 'pjg_filter_get_the_terms', 10, 3);

/**
 * Filter category link html and add custom classes
 * @param  string $links array of <a> tags
 * @return Array filtered array of <a> tags
 */
function pjg_filter_term_links($links){

  foreach($links as $k => $link){
    // $link looks like:
    // <a href="http://localhost:8081/category/art-in-the-garden/" rel="tag">Art in the Garden</a>

    $matches = array();
    // find slug
    preg_match("/href=\".*\/category\/(.*)\/\"/", $link, $matches);
    // add slug and 'category' as class
    $links[$k] = str_replace('rel="tag"', "class=\"category {$matches[1]}\" rel=\"tag\"", $link);
  }

  return $links;
}
add_filter( 'term_links-category', 'pjg_filter_term_links', 10);


// add the Category Order ACF to the edit table.


// adds the column
function pjg_add_category_columns( $columns ){

    $columns['order'] = 'Order';
    return $columns;

}
add_filter( 'manage_edit-category_columns', 'pjg_add_category_columns' );


// adds the content per row
function pjg_add_cat_order( $content, $column_name, $term_id ){

    switch ( $column_name ) {
        case 'order':

            $content = get_field( 'category_order', 'category_' . $term_id );

            break;
        default:
            break;
    }
    return $content;
}
add_filter('manage_category_custom_column', 'pjg_add_cat_order',10,3);


function pjg_excerpt_more( $more ) {

  global $post;

  return ' <a class="read_more" href="'. get_permalink($post->ID) . '">' . '...' . '</a>';

}
add_filter('excerpt_more','pjg_excerpt_more');


// filter to force email sharing even if akismet isn't being used -- jetpack
add_filter( 'sharing_services_email', '__return_true' );
