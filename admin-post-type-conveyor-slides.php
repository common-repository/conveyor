<?php
/**
 * @package Conveyor
 */

/**
 *
 * @since 		1.0.0
 * @updated 	1.1.1
 *
 * Creates a custom post type for the carousel
 *
 */
function conveyor_create_post_type() {

	$labels 	= array();
	$args 		= array();

	// Set labels for the custom post type
	$labels = array(
		'name'               => _x( 'Slides', 'post type general name' ),
		'singular_name'      => _x( 'Slide', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'slide' ),
		'add_new_item'       => __( 'Add New Slide' ),
		'edit_item'          => __( 'Edit Slide' ),
		'new_item'           => __( 'New Slide' ),
		'all_items'          => __( 'All Slides' ),
		'view_item'          => __( 'View Slide' ),
		'search_items'       => __( 'Search Slides' ),
		'not_found'          => __( 'No slides found' ),
		'not_found_in_trash' => __( 'No slides found in the Trash' ),
		'parent_item_colon'  => '',
		'menu_name'          => 'Slides'
	);

	// Set the arguements for the custom post type
	$args = array(
		'rewrite' 				=> array( 'slug' => 'slides' ),
		'labels'				=> $labels,
		'description'			=> 'Slides',
		'public'				=> true,
		'exclude_from_search'	=> true,
		'menu_position'			=> 10,
		'menu_icon'				=> 'dashicons-format-gallery',
		'supports'				=> array(
									'title',
									'author',
									'thumbnail',
									'excerpt',
									'custom-fields',
									'revisions',
									'page-attributes'
									)
	);

	// Register the custom post type
	if( get_option('_conveyor_show_slides_cpt') == 'show' )
	{
		register_post_type( 'conveyor_slides', $args );
	}

}
add_action( 'init', 'conveyor_create_post_type' );

/**
 *
 * @since 		1.4.0
 * @updated 	1.4.1
 *
 * Hide meta boxes by default
 *
 */
function conveyor_change_default_hidden( $hidden, $screen ) {
	if ( 'conveyor_slides' == $screen->id ) {
		$hidden[] 	= 'postcustom';
		$hidden[] 	= 'trackbacksdiv';
		$hidden[] 	= 'commentstatusdiv';
		$hidden[] 	= 'commentsdiv';
		$hidden[] 	= 'slugdiv';
		$hidden[] 	= 'authordiv';
		$hidden[] 	= 'revisionsdiv';
		$hidden[]	= 'pageparentdiv';
	}
	return $hidden;
}
add_filter( 'default_hidden_meta_boxes', 'conveyor_change_default_hidden', 10, 2 );


/**
 *
 * @since 		1.1.3
 *
 * Register post thumbnails
 *
 */
function conveyor_register_post_thumbnails()
{
	$post_thumbnails = get_theme_support( 'post-thumbnails' );
	$new_post_thumbnails = array();

	if( is_array( $post_thumbnails ) )
	{
		if( is_array( $post_thumbnails[0] ) )
		{
			foreach( $post_thumbnails[0] as $value )
			{
				array_push( $new_post_thumbnails, $value );
			}
		}
	}

	array_push( $new_post_thumbnails, 'conveyor_slides' );

	// Add support for post thumbnails to the theme
	add_theme_support( 'post-thumbnails', $new_post_thumbnails );

	//Add custom image sizes
	if( !in_array( 'golden-ratio-2560', get_intermediate_image_sizes() ) )
	{
		add_image_size( 'golden-ratio-2560', 2560, 1582, true );
	}

	if( !in_array( 'golden-ratio-2048', get_intermediate_image_sizes() ) )
	{
		add_image_size( 'golden-ratio-2048', 2048, 1266, true );
	}

	if( !in_array( 'golden-ratio-1920', get_intermediate_image_sizes() ) )
	{
		add_image_size( 'golden-ratio-1920', 1920, 1186, true );
	}
	
	if( !in_array( 'golden-ratio-1680', get_intermediate_image_sizes() ) )
	{
		add_image_size( 'golden-ratio-1680', 1680, 633, true );
	}

	if( !in_array( 'golden-ratio-1440', get_intermediate_image_sizes() ) )
	{
		add_image_size( 'golden-ratio-1440', 1440, 890, true );
	}

	if( !in_array( 'golden-ratio-1280', get_intermediate_image_sizes() ) )
	{
		add_image_size( 'golden-ratio-1280', 1280, 791, true );
	}
	
	if( !in_array( 'golden-ratio-1024', get_intermediate_image_sizes() ) )
	{
		add_image_size( 'golden-ratio-1024', 1024, 633, true );
	}

	if( !in_array( 'golden-ratio-800', get_intermediate_image_sizes() ) )
	{
		add_image_size( 'golden-ratio-800', 800, 494, true );
	}

	if( !in_array( 'golden-ratio-640', get_intermediate_image_sizes() ) )
	{
		add_image_size( 'golden-ratio-640', 640, 396, true );
	}
}
add_action( 'after_setup_theme', 'conveyor_register_post_thumbnails' );
?>