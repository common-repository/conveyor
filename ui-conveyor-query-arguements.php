<?php
/**
 * @package Conveyor
 */

/**
 * 
 * @since  		1.0.2
 * @updated 	1.1.0
 * 
 * Return loop query args
 *
 * @param 		array 		$args 		argumens to define filter	
 * @return 		array 		arguments to filter wp_query
 * 
 */
function conveyor_query_arguements( $args = array() ) 
{
	$defaults = array(

		'featured'					=> false, 							// [ true | false ] - Set to true to return posts that have the featured post custom meta data set to true
		'featured_post_meta_key' 	=> '_conveyor_featured',			// The custom meta field that identifies the featured post, will also accept an array
		'order'						=> 'ASC',							// [ ASC | DESC ]
		'orderby'					=> 'date', 							// [ date | menu_order ]
		'posts_per_page'			=> 5,								// Set number of posts to return, -1 will return all
		'post_type'					=> 'conveyor_slides',				// [ post | page | custom post type | array() ]			
		'taxonomy_filter'			=> false,							// [ true | false ] - Set to true to filter by taxonomy
		'taxonomy_key'				=> 'conveyor_group',				// The key of the taxonomy we wish to filter by
		'taxonomy_terms'			=> 'conveyor-group-1'				// The terms (uses slug), will accept a string or array
	);

	$return_args					= array();
	$r 								= array_merge( $defaults, $args );
	$meta_query_args				= array(
										'relation' 		=> 'AND',
										array(
											'key' 		=> '_thumbnail_id'
										)
									);
	$tax_query_args 				= null;

	if( $r['featured'] )
	{
		if( is_array( $r['featured_post_meta_key'] ) )
		{
			foreach( $r['featured_post_meta_key'] as $featured_post_meta_key )
			{
				$query = array(
					'key' 		=> $featured_post_meta_key,
		 			'value' 	=> 'true',
		 			'compare' 	=> '='
				);

				array_push( $meta_query_args, $query );
			}
		}
		elseif( is_string( $r['featured_post_meta_key'] ) )
		{
			$query = array(
				'key' 		=> $r['featured_post_meta_key'],
	 			'value' 	=> 'true',
	 			'compare' 	=> '='
			);

			array_push( $meta_query_args, $query );
		}
	}

	if( $r['taxonomy_filter'] )
	{
		$tax_query_args = array(
			'taxonomy' 	=> $r['taxonomy_key'],
			'field' 	=> 'slug',
			'terms' 	=> $r['taxonomy_terms']
		);
	}

	$return_args = 	array(
						'post_type'			=> $r['post_type'],
						'orderby'			=> $r['orderby'],
						'order'				=> $r['order'],
						'posts_per_page'	=> $r['posts_per_page'],
						'meta_query' 		=> $meta_query_args,
						'tax_query' 		=> array( $tax_query_args )
					);

	return $return_args;
}
?>