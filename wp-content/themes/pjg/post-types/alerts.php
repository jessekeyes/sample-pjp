<?php // ALERTS Register Custom Post Type


function post_type_alerts() {

	$labels = array(
		'name'                  => _x( 'Alerts', 'Post Type General Name', 'pjg' ),
		'singular_name'         => _x( 'Alert', 'Post Type Singular Name', 'pjg' ),
		'menu_name'             => __( 'Alerts', 'pjg' ),
		'name_admin_bar'        => __( 'Alerts', 'pjg' ),
		'archives'              => __( 'Alert Archives', 'pjg' ),
		'attributes'            => __( 'Alert Attributes', 'pjg' ),
		'parent_item_colon'     => __( 'Parent Item:', 'pjg' ),
		'all_items'             => __( 'All Alerts', 'pjg' ),
		'add_new_item'          => __( 'Add New Alert', 'pjg' ),
		'add_new'               => __( 'Add New', 'pjg' ),
		'new_item'              => __( 'New Alert', 'pjg' ),
		'edit_item'             => __( 'Edit Alert', 'pjg' ),
		'update_item'           => __( 'Update Alert', 'pjg' ),
		'view_item'             => __( 'View Alert', 'pjg' ),
		'view_items'            => __( 'View Alerts', 'pjg' ),
		'search_items'          => __( 'Search Alerts', 'pjg' ),
		'not_found'             => __( 'Not found', 'pjg' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'pjg' ),
		'featured_image'        => __( 'Featured Image', 'pjg' ),
		'set_featured_image'    => __( 'Set featured image', 'pjg' ),
		'remove_featured_image' => __( 'Remove featured image', 'pjg' ),
		'use_featured_image'    => __( 'Use as featured image', 'pjg' ),
		'insert_into_item'      => __( 'Insert into item', 'pjg' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'pjg' ),
		'items_list'            => __( 'Items list', 'pjg' ),
		'items_list_navigation' => __( 'Items list navigation', 'pjg' ),
		'filter_items_list'     => __( 'Filter items list', 'pjg' ),
	);
	$args = array(
		'label'                 => __( 'Alert', 'pjg' ),
		'description'           => __( 'Special Announcements or Alerts', 'pjg' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-warning',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'rewrite'               => false,
		'capability_type'       => 'page',
	);
	register_post_type( 'alert', $args );

}
add_action( 'init', 'post_type_alerts', 0 );
