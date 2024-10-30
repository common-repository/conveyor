<?php
/**
 * @package Conveyor
 */

/**
 * 
 * @since  		1.0.0
 * 
 * Create a custom taxonomy to add categorise converyor items
 * 
 */
function conveyor_create_conveyor_group_taxonomy() {

	$taxonomy 	= 'conveyor_group';
	$labels 	= array();
	$args 		= array();

	// Set labels for the custom taxonomy
	$labels = array(
		'name'              => _x( 'Groups', 'taxonomy general name' ),
		'singular_name'     => _x( 'Group', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Groups' ),
		'all_items'         => __( 'All Groups' ),
		'parent_item'       => __( 'Parent Group' ),
		'parent_item_colon' => __( 'Parent Group:' ),
		'edit_item'         => __( 'Edit Group' ),
		'update_item'       => __( 'Update Group' ),
		'add_new_item'      => __( 'Add New Group' ),
		'new_item_name'     => __( 'New Group Name' ),
		'menu_name'         => __( 'Groups' )
	);

	// Set the arguements for the custom taxonomy
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => false
	);

	register_taxonomy( $taxonomy, array( 'conveyor_slides' ), $args );
}
add_action( 'init', 'conveyor_create_conveyor_group_taxonomy', 0 );
?>