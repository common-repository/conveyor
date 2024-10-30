<?php
/**
 * @package Conveyor
 */

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