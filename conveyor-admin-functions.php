<?php
/**
 * @package Conveyor
 */

/*
Description:  Functions for the admin side of the plugin

/////////  DEV STRUCTURE

1 - Create conveyor custom post type
2 - Create conveyor group custom taxonomy
3 - Enqueue scripts
4 - Link chooser custom meta box
5 - Link chooser form

*/

//// 1 //// Create custom post type

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
	register_post_type( 'conveyor_slides', $args );

}
add_action( 'init', 'conveyor_create_post_type' );




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
}
add_action( 'after_setup_theme', 'conveyor_register_post_thumbnails' );






//// 2 //// Create conveyor group custom taxonomy

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


//// 3 //// Enqueue scripts

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

	if ( $hook == 'post-new.php' || $hook == 'post.php' ) 
	{
		if ( 'conveyor_slides' === $post->post_type ) 
		{
			// Tiny MCE editor styles for the link box
			wp_enqueue_style( 'editor-buttons-css', site_url() .'/' . WPINC . '/css/editor.min.css' );

			// Custom styles
			wp_enqueue_style( 'conveyor_admin_styles', plugins_url( 'assets/css/styles.css' , __FILE__ ) );
			
			// WordPress popup styles
			wp_enqueue_style( 'wp-jquery-ui-dialog' );
			wp_enqueue_style( 'thickbox' );

			// WordPress popup scripts
			wp_enqueue_script( 'wplink' );
			wp_enqueue_script( 'wpdialogs-popup' );

			// Custom scripts
			wp_enqueue_script( 'conveyor_admin_scripts', plugins_url( 'assets/js/scripts.min.js' , __FILE__ ), array( 'wpdialogs-popup' ), '1.0', true );
		}
	}
}
add_action( 'admin_enqueue_scripts', 'converyor_enqueue_scripts' );


//// 4 //// Link chooser custom meta box

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


//// 5 //// Link chooser form

/**
 * 
 * @since  		1.0.1
 * 
 * The link chooser form
 * 
 */
function conveyor_link_dialog() 
{
	global $pagenow, $post;

	if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' ) 
	{
		if ( 'conveyor_slides' === $post->post_type ) 
		{
			?>
			<form id="wp-link" tabindex="-1" style="display:none">
			<?php wp_nonce_field( 'internal-linking', '_ajax_linking_nonce', false ); ?>
			<div id="link-selector">
				<div id="link-options">
					<p class="howto"><?php _e( 'Enter the destination URL' ); ?></p>
					<div>
						<label><span><?php _e( 'URL' ); ?></span><input id="url-field" type="text" tabindex="10" name="href" /></label>
					</div>
					<div>
						<label><span><?php _e( 'Title' ); ?></span><input id="link-title-field" type="text" tabindex="20" name="linktitle" /></label>
					</div>
					<div class="link-target">
						<label><input type="checkbox" id="link-target-checkbox" tabindex="30" /> <?php _e( 'Open link in a new window/tab' ); ?></label>
					</div>
				</div>
				<?php $show_internal = '1' == get_user_setting( 'wplink', '0' ); ?>
				<p class="howto toggle-arrow <?php if ( $show_internal ) echo 'toggle-arrow-active'; ?>" id="internal-toggle"><?php _e( 'Or link to existing content' ); ?></p>
				<div id="search-panel"<?php if ( ! $show_internal ) echo ' style="display:none"'; ?>>
					<div class="link-search-wrapper">
						<label>
							<span><?php _e( 'Search' ); ?></span>
							<input type="text" id="search-field" class="link-search-field" tabindex="60" autocomplete="off" />
							<img class="waiting" src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" alt="" />
					</label>
					</div>
					<div id="search-results" class="query-results">
						<ul></ul>
						<div class="river-waiting">
							<img class="waiting" src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" alt="" />
						</div>
					</div>
					<div id="most-recent-results" class="query-results">
						<div class="query-notice"><em><?php _e( 'No search term specified. Showing recent items.' ); ?></em></div>
						<ul></ul>
						<div class="river-waiting">
							<img class="waiting" src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" alt="" />
						</div>
					</div>
				</div>
			</div>
			<div class="submitbox">
				<div id="wp-link-cancel">
					<a class="submitdelete deletion" href="#"><?php _e( 'Cancel' ); ?></a>
				</div>
				<div id="wp-link-update">
					<?php submit_button( __('Update'), 'primary', 'wp-link-submit', false, array('tabindex' => 100)); ?>
				</div>
			</div>
			</form>
			<script type="text/javascript"></script>
			<?php
		}
	}
}
add_action( 'admin_footer', 'conveyor_link_dialog', 99 );
?>