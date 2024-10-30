<?php
/**
 * @package Conveyor
 */

/**
 * 
 * @since  		1.2.0
 * 
 * Custom meta box for featured slides
 * 
 */
function conveyor_featured_meta_box() {

	// Only add the box to the selected post types
	$screens 		= array();
	$post_types 	= get_post_types( array('public' => true) );

	foreach( $post_types as $post_type)
	{
		if( get_option('_conveyor_show_featured_slide_on_' . $post_type ) === 'show' )
		{
			array_push( $screens, $post_type );
		}
	}

	foreach ( $screens as $screen ) 
	{
		add_meta_box(
			'conveyor_featured',
			'Featured',
			'conveyor_featured_render_meta_box',
			$screen,
			'side'
		);
	}

}
add_action( 'add_meta_boxes', 'conveyor_featured_meta_box' );



/**
 * 
 * @since  		1.2.0
 * 
 * Render the featured meta box
 * 
 */
function conveyor_featured_render_meta_box( $post ) {

	$conveyor_featured 		= get_post_meta( $post->ID, '_conveyor_featured', true );

	?>
		<div class="conveyor_featured cf">
			<p>
				<div class="row cf">
					<div class="label__container">
						<strong>
							<label class="label-inline" for="conveyor_featured">Featured slide</label>
						</strong>
					</div>
					<div class="input__container">
							<input type="checkbox" id="conveyor_featured" name="conveyor_featured" value="true"<?php echo ( $conveyor_featured == 'true') ? ' checked' : '';?>/>
					</div>
				</div>
			</p>
		</div> 

	<?php


	wp_nonce_field( 'submit_conveyor_featured', 'conveyor_featured_nonce' ); 
}


/**
 * 
 * @since  		1.2.0
 * 
 * Handle the featured meta box post data
 * 
 */
function conveyor_featured_handle_post_data( $post_id )
{
	$nonce_key							= 'conveyor_featured_nonce';
	$nonce_action						= 'submit_conveyor_featured';

	// If it is just a revision don't worry about it
	if ( wp_is_post_revision( $post_id ) )
		return $post_id;

	// Check it's not an auto save routine
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;

	// Verify the nonce to defend against XSS
	if ( !isset( $_POST[$nonce_key] ) || !wp_verify_nonce( $_POST[$nonce_key], $nonce_action ) )
		return $post_id;

	// Check that the current user has permission to edit the post
	if ( !current_user_can( 'edit_post', $post_id ) )
		return $post_id;

	$conveyor_featured 		= isset( $_POST['conveyor_featured'] ) 	? 'true' : 'false';

	update_post_meta( $post_id, '_conveyor_featured', 		$conveyor_featured );

}
add_action( 'save_post', 'conveyor_featured_handle_post_data' );
?>