<?php
/**
 * @package Conveyor
 */

/**
 * 
 * @since  		1.2.0
 * 
 * Register the options page
 * 
 */
function conveyor_add_options_page() {

	add_options_page( 'Conveyor', 'Conveyor', 'manage_options', 'conveyor-settings', 'conveyor_render_options_page' );

	add_action( 'admin_init', 'conveyor_register_settings' );
}
add_action('admin_menu', 'conveyor_add_options_page');




/**
 * 
 * @since  		1.2.0
 * 
 * Register the options settings
 * 
 */
function conveyor_register_settings() {

	$post_types = get_post_types( array('public' => true) );

	register_setting( 'conveyor_group', '_conveyor_show_slides_cpt' );

	foreach( $post_types as $post_type)
	{
		register_setting( 'conveyor_group', '_conveyor_show_featured_slide_on_' . $post_type );
	}

}

/**
 * 
 * @since  		1.2.0
 * 
 * Render the options page
 * 
 */
function conveyor_render_options_page()
{	
	$post_types 		= get_post_types( array('public' => true) );
	sort( $post_types );

	foreach( $post_types as $post_type)
	{
		if($post_type == 'conveyor_slides')
		{
			if( get_option('_conveyor_show_featured_slide_on_' . $post_type ) === false )
			{
				add_option( '_conveyor_show_featured_slide_on_' . $post_type, 'show' );
			}
		}
	}

	if( get_option('_conveyor_show_slides_cpt') === false)
	{
		add_option( '_conveyor_show_slides_cpt', 'show' );
	}

	?>
		<div class="wrap conveyor_options">
			<h2>Conveyor</h2>
			<form method="post" action="options.php">
			<?php 
				settings_fields( 'conveyor_group' );
				do_settings_sections( 'conveyor_group' );
			?>
			<table class="form-table">

				<tr valign="top">
					<th scope="row"><label for="conveyor_show_slides_cpt">Show the 'Slides' post type</label></th>
					<td><input type="checkbox" value="show" id="conveyor_show_slides_cpt" name="_conveyor_show_slides_cpt"<?php echo ( get_option('_conveyor_show_slides_cpt') == 'show' ) ? ' checked' : '';?>></td>
				</tr>
				<tr valign="top">
					<th scope="row">Show 'Featured Slide' custom meta on post type</th>
					<td>
						<?php
							foreach( $post_types as $post_type)
							{
								?>
									<span class="inline">
										<input type="checkbox" value="show" id="conveyor_show_featured_slide_on_<?php echo $post_type;?>" name="_conveyor_show_featured_slide_on_<?php echo $post_type;?>"<?php echo ( get_option('_conveyor_show_featured_slide_on_' . $post_type ) == 'show' ) ? ' checked' : '';?>>
										<label for="conveyor_show_featured_slide_on_<?php echo $post_type;?>">
										<?php
											
											$obj = get_post_type_object( $post_type );
											echo $obj->labels->singular_name;
										?>
										</label>
									</span>
								<?php
							}
						?>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
			</form>
		</div>
	<?php
}

/**
 * Add "Settings" action on installed plugin list
 */
function conveyor_add_plugin_actions( $links ) {
	array_unshift( $links, '<a href="options-general.php?page=conveyor-settings">Settings</a>');
	return $links;
}
add_action( 'plugin_action_links_conveyor/index.php', 'conveyor_add_plugin_actions' );

/**
 * Add links on installed plugin list
 */
function conveyor_add_plugin_links( $links, $file ) 
{
	if( $file == 'conveyor/index.php' ) {
		$rate_url = 'http://wordpress.org/support/view/plugin-reviews/conveyor?rate=5#postform';
		$links[] = '<a href="' . $rate_url . '" target="_blank" title="Rate and Review this Plugin on WordPress.org">Rate this plugin</a>';
	}
	
	return $links;
}
add_filter( 'plugin_row_meta', 'conveyor_add_plugin_links' , 10, 2);
?>