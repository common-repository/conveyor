<?php
/**
 * @package Conveyor
 */

/**
 * 
 * @since  		1.0.3
 * 
 * Render bootstrap carousel
 * 
 */
function conveyor_render_bootstrap( $args = array(), $version = '3' )
{
	// Future proofing, set the version of the carousel we wish to render
	// if( $version == '3' ){ // Render here }
	
	conveyor_render_bootstrap_3( $args );
}

/**
 * 
 * @since  		1.0.2
 * @updated 	1.0.3
 * 
 * Render bootstrap 3 carousel
 * 
 */
function conveyor_render_bootstrap_3( $args = array() )
{

	$defaults = array(

		'featured'					=> false,
		'featured_post_meta_key' 	=> '_conveyor_featured',
		'id'						=> 'conveyor_carousel',					// If you want to have multiple carousels, you will want to change the id each time
		'image_size'				=> 'golden-ratio-1024',
		'images_as_links'			=> true, 								// [ true | false ] - Set to true to wrap images with links (if _conveyor_link set on post)
		'order'						=> 'ASC',
		'orderby'					=> 'date',
		'posts_per_page'			=> 5,
		'post_type'					=> 'conveyor_slides',
		'render_captions'			=> true, 								// [ true | false ] - Set to true to render captions when excerpt is not empty
		'render_controls'			=> true,								// [ true | false ] - Show the slide left right controls
		'render_indicators'			=> true 								// [ true | false ] - Show the slide indicators
	);

	$r 								= array_merge( $defaults, $args );
	$query_args 					= conveyor_query_arguements( $r );
	$posts 							= get_posts( $query_args );

	if( is_array( $posts ) && count( $posts ) > 0 )
	{
		?>
			<div id="<?php echo $r['id']; ?>" class="carousel slide" data-ride="carousel">
				
				<?php

					if( $r['render_indicators'] )
					{
						?>
						<!-- Indicators -->
						<ol class="carousel-indicators">
							<?php
								for ($i = 0; $i < count( $posts ); $i++) 
								{
									?>
										<li data-target="#<?php echo $r['id']; ?>" data-slide-to="<?php echo $i; ?>"<?php echo ( $i == 0 ) ? ' class="active"' : '';?>></li>
									<?php
								}
							?>
						</ol>
						<?php
					}
				?>

				<!-- Wrapper for slides -->
				<div class="carousel-inner">

					<?php

						$i = 0;

						foreach( $posts as $slide )
						{
							$conveyor_link_value 		= get_post_meta( $slide->ID, '_conveyor_link', true );
							$conveyor_open_new_window 	= get_post_meta( $slide->ID, '_conveyor_open_new_window', true );
							?>
								
								<div class="item<?php echo ( $i == 0 ) ? ' active' : '';?>">
									<?php

										if( $r['images_as_links'] && !empty( $conveyor_link_value  ) )
										{
											?>
												<a href="<?php echo $conveyor_link_value; ?>"<?php echo ( $conveyor_open_new_window == true ) ? ' target="_blank"' : ''; ?>><?php echo get_the_post_thumbnail( $slide->ID, 'full' ); ?></a>
											<?php
										}
										else
										{
											echo get_the_post_thumbnail( $slide->ID, $r['image_size'] ); 
										}

										if( $r['render_captions'] && !empty( $slide->post_excerpt ) )
										{
											?>
												<div class="carousel-caption">
													<h3><?php echo $slide->post_title; ?></h3>
													<p><?php echo $slide->post_excerpt; ?></p>
												</div>
											<?php
										}
									?>
								</div>

							<?php
							$i++;
						}

					?>

				</div>

				<?php
				if( $r['render_controls'] )
				{
					?>
					<!-- Controls -->
					<a class="left carousel-control" href="#<?php echo $r['id']; ?>" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left"></span>
					</a>
					<a class="right carousel-control" href="#<?php echo $r['id']; ?>" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right"></span>
					</a>
					<?php
				}
				?>

			</div>
		<?php
	}

	wp_reset_query();
	wp_reset_postdata();
}

/** Legacy support **/

/**
 * 
 * @since  		1.2.4
 * 
 * Function was spelt wrong previous to this version. 
 * This function will call the old function if anybody is calling it.
 * 
 */
function conveyor_render_boostrap( $args = array(), $version = '3' )
{
	conveyor_render_bootstrap_3( $args, $version );
}

?>