<?php
/**
 * @package Conveyor
 */

/**
 * 
 * @since  		1.0.1
 * 
 * Add scripts and styles to the admin boxes
 * 
 */
function converyor_enqueue_scripts( $hook ) 
{
	global $post;

	if ( $hook == 'post-new.php' || $hook == 'post.php' || $hook == 'settings_page_conveyor-settings' ) 
	{
		// Custom styles
		wp_enqueue_style( 'conveyor_admin_styles', plugins_url( 'assets/css/styles.css' , __FILE__ ) );
		
		// Custom scripts
		wp_enqueue_script( 'conveyor_admin_scripts', plugins_url( 'assets/js/scripts.min.js' , __FILE__ ), array( 'wpdialogs-popup' ), '1.0', true );

		if ( is_object( $post ) && 'conveyor_slides' === $post->post_type ) 
		{
			// Tiny MCE editor styles for the link box
			wp_enqueue_style( 'editor-buttons-css', site_url() .'/' . WPINC . '/css/editor.min.css' );

			// WordPress popup styles
			wp_enqueue_style( 'wp-jquery-ui-dialog' );
			wp_enqueue_style( 'thickbox' );

			// WordPress popup scripts
			wp_enqueue_script( 'wplink' );
			wp_enqueue_script( 'wpdialogs-popup' );
		}
	}
}
add_action( 'admin_enqueue_scripts', 'converyor_enqueue_scripts' );
?>