<?php
// Register Custom Taxonomy Admin categories

function taxonomy_admin() {

	$labels = array(
		'name'                       => _x( 'Admin Categories', 'Taxonomy General Name', 'pjg' ),
		'singular_name'              => _x( 'Admin Category', 'Taxonomy Singular Name', 'pjg' ),
		'menu_name'                  => __( 'Admin Categories', 'pjg' ),
		'all_items'                  => __( 'All Items', 'pjg' ),
		'parent_item'                => __( 'Parent Item', 'pjg' ),
		'parent_item_colon'          => __( 'Parent Item:', 'pjg' ),
		'new_item_name'              => __( 'New Item Name', 'pjg' ),
		'add_new_item'               => __( 'Add New Item', 'pjg' ),
		'edit_item'                  => __( 'Edit Item', 'pjg' ),
		'update_item'                => __( 'Update Item', 'pjg' ),
		'view_item'                  => __( 'View Item', 'pjg' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'pjg' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'pjg' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'pjg' ),
		'popular_items'              => __( 'Popular Items', 'pjg' ),
		'search_items'               => __( 'Search Items', 'pjg' ),
		'not_found'                  => __( 'Not Found', 'pjg' ),
		'no_terms'                   => __( 'No items', 'pjg' ),
		'items_list'                 => __( 'Items list', 'pjg' ),
		'items_list_navigation'      => __( 'Items list navigation', 'pjg' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'administrative', array( 'post', EM_POST_TYPE_EVENT, 'event-recurring' ), $args );

}
add_action( 'init', 'taxonomy_admin', 0 );
