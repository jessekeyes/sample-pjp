<?php // INSPIRE & INITIATE Register Custom Post Type

function post_type_inspire() {

	$labels = array(
		'name'                  => _x( 'Inspirations', 'Post Type General Name', 'pjg' ),
		'singular_name'         => _x( 'Inspiration', 'Post Type Singular Name', 'pjg' ),
		'menu_name'             => __( 'Inspire & Initiate', 'pjg' ),
		'name_admin_bar'        => __( 'Inspiration', 'pjg' ),
		'archives'              => __( 'Inspiration Archives', 'pjg' ),
		'attributes'            => __( 'Inspiration Attributes', 'pjg' ),
		'parent_item_colon'     => __( 'Parent Inspiration:', 'pjg' ),
		'all_items'             => __( 'Inspiration Items', 'pjg' ),
		'add_new_item'          => __( 'Add New Inspiration', 'pjg' ),
		'add_new'               => __( 'Add Inspiration', 'pjg' ),
		'new_item'              => __( 'New Inspiration', 'pjg' ),
		'edit_item'             => __( 'Edit Inspiration', 'pjg' ),
		'update_item'           => __( 'Update Inspiration', 'pjg' ),
		'view_item'             => __( 'View Inspiration', 'pjg' ),
		'view_items'            => __( 'View Inspirations', 'pjg' ),
		'search_items'          => __( 'Search Inspirations', 'pjg' ),
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
		'label'                 => __( 'Inspiration', 'pjg' ),
		'description'           => __( 'Motivation content through out the site', 'pjg' ),
		'labels'                => $labels,
		'supports'              => array( ),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-smiley',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'rewrite'               => false,
		'capability_type'       => 'page',
	);
	register_post_type( 'inspire', $args );

}
add_action( 'init', 'post_type_inspire', 0 );
