<?php
/**
 * @package Conveyor
 */

/**
 * 
 * @since  		1.3.0
 * 
 * Render foundation carousel
 * 
 */
function conveyor_render_foundation( $args = array(), $version = '5' )
{
	// Future proofing, set the version of the carousel we wish to render
	// if( $version == '5' ){ // Render here }
	
	conveyor_render_foundation_5( $args );
}

/**
 * 
 * @since  		1.3.0
 * 
 * Render foundation 3 carousel
 * 
 */
function conveyor_render_foundation_5( $args = array() )
{

	$defaults = array(
		'class_link_wrapper'		=> 'flush',
		'class_slideshow_wrapper'	=> 'slideshow-wrapper soft--bottom snap',
		'featured'					=> false,
		'featured_post_meta_key' 	=> '_conveyor_featured',
		'id'						=> 'conveyor_carousel',					// If you want to have multiple carousels, you will want to change the id each time
		'image_size'				=> 'golden-ratio-1024',
		'link_icon'					=> ' <span class="icon icon-right fa fa-arrow-circle-o-right"></span>',
		'link_text'					=> 'More information',
		'order'						=> 'ASC',
		'orderby'					=> 'date',
		'posts_per_page'			=> 5,
		'post_type'					=> 'conveyor_slides',
		'render_captions'			=> true, 								// [ true | false ] - Set to true to render captions when excerpt is not empty
	);

	$r 								= array_merge( $defaults, $args );
	$query_args 					= conveyor_query_arguements( $r );
	$posts 							= get_posts( $query_args );

	if( is_array( $posts ) && count( $posts ) > 0 )
	{
		?>
			<div id="<?php echo $r['id']; ?>" class="<?php echo $r['class_slideshow_wrapper']; ?>" data-ride="carousel">
				<div class="preloader"></div>

				<!-- Wrapper for slides -->
				<ul data-orbit>

					<?php

						$i = 0;

						foreach( $posts as $slide )
						{
							$conveyor_link_value 		= get_post_meta( $slide->ID, '_conveyor_link', true );
							$conveyor_open_new_window 	= get_post_meta( $slide->ID, '_conveyor_open_new_window', true );
							?>
									<li>
									<?php

										echo get_the_post_thumbnail( $slide->ID, $r['image_size'] ); 				

										if( $r['render_captions'] && !empty( $slide->post_excerpt ) )
										{
											?>
												<div class="orbit-caption">
													<section>
														<h1><?php echo $slide->post_title; ?></h1>
														<p><?php echo $slide->post_excerpt; ?></p>
														<p class="<?php echo $r['class_link_wrapper'];?>"><a href="<?php echo get_permalink( $slide->ID );?>" class="btn btn--primary" title="More '<?php echo $slide->post_title; ?>'"><?php echo $r['link_text'];?><?php echo $r['link_icon'];?></a></p>
													</section>
												</div>
											<?php
										}
									?>
								</li>

							<?php
							$i++;
						}
					?>

				</ul>

			</div>
		<?php
	}

	wp_reset_query();
	wp_reset_postdata();
	add_action( 'wp_footer', 'conveyor_render_foundation_scripts' );
}

function conveyor_render_foundation_scripts() {
?>
	<script type="text/javascript">
		if (jQuery('.lt-ie8').length === 0) {

			jQuery(document).foundation('orbit', {
				resume_on_mouseout: true,
				stack_on_small: false,
				bullets: false
			});

		}
	</script>
 <?php
}

?>