<?php
/**
 * @package Conveyor
 */

/**
 * 
 * @since  		1.0.0
 * @updated 	1.0.1
 * 
 * Custom meta box for linking the slider to internal or external content
 * 
 */
function conveyor_link_chooser_meta_box() {

	// Only add the box to the 'slide' post type
	$screens = array( 'conveyor_slides' );

	foreach ( $screens as $screen ) 
	{
		add_meta_box(
			'conveyor_link_chooser',
			'Link',
			'conveyor_link_chooser_render_meta_box',
			$screen
		);
	}

}
add_action( 'add_meta_boxes', 'conveyor_link_chooser_meta_box' );


/**
 * 
 * @since  		1.0.0
 * @updated 	1.0.1
 * 
 * Render the link chooser meta box
 * 
 */
function conveyor_link_chooser_render_meta_box( $post ) {

	$conveyor_link_value 		= get_post_meta( $post->ID, '_conveyor_link', true );
	$conveyor_open_new_window 	= get_post_meta( $post->ID, '_conveyor_open_new_window', true );

	?>
		<div class="conveyor_link_chooser cf">
			<p class="cf">
				<label class="screen-reader-text" for="conveyor_link_value">Link</label> 
				<input type="text" id="conveyor_link_value" name="conveyor_link_value"<?php echo ( isset( $conveyor_link_value ) ) ? ' value="' . $conveyor_link_value . '"' : '';?>/>
				<input type="submit" class="conveyor_link_btn button button-large" value="Choose link"/>
			</p>
			<p class="cf">
				<input type="checkbox" name="conveyor_open_new_window_value" id="conveyor_open_new_window_value"<?php echo ( $conveyor_open_new_window == true ) ? ' checked="checked"' : '';?>>
				<label for="conveyor_open_new_window_value">Open in new window</label>
			</p>
		</div>
	<?php

	wp_nonce_field( 'submit_conveyor_link', 'conveyor_link_chooser_nonce' ); 
}


/**
 * 
 * @since  		1.0.0
 * 
 * Handle the link chooser meta box post data
 * 
 */
function conveyor_link_chooser_handle_post_data( $post_id )
{
	$nonce_key						= 'conveyor_link_chooser_nonce';
	$nonce_action					= 'submit_conveyor_link';
	$conveyor_link_key  			= '_conveyor_link';
	$conveyor_open_new_window_key 	= '_conveyor_open_new_window';

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

	if( isset( $_POST['conveyor_link_value'] ) )
	{
		$value = esc_url_raw( $_POST['conveyor_link_value'] );
		update_post_meta( $post_id, $conveyor_link_key , $value );
	}
	else
	{
		delete_post_meta( $post_id, $conveyor_link_key);
	}

	if( isset( $_POST['conveyor_open_new_window_value'] ) && $_POST['conveyor_open_new_window_value']  )
	{
		update_post_meta( $post_id, $conveyor_open_new_window_key , true );
	}
	else
	{
		delete_post_meta( $post_id, $conveyor_open_new_window_key);
	}
}
add_action( 'save_post', 'conveyor_link_chooser_handle_post_data' );
?>