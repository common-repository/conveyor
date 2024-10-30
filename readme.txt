=== Conveyor ===
Contributors: mwtsn, mkdo, mkjones
Donate link: 
Tags: content slider, slider, slideshow, carousel
Requires at least: 3.3
Tested up to: 4.0
Stable tag: 1.4.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Gives you a 'slides' custom post type, or use your own post type with an optional 'featured slide' checkbox to render a carousel.

== Description ==

Created by [Make Do](http://makedo.in/), this plugin will give you a custom post type just for carousel slides, or it will let you use your existing post types to generate a carousel (with an optional ‘featured slide’ checkbox that you can add to any post type). 

The plugin comes with a function that you can use to generate a loop to query the slides so you can make your own output, or it will render a Bootstrap 3 compatible carousel right out of the box.

Too complicated for your needs? Try our [Exhibition](http://wordpress.org/plugins/exhibition/) plugin, that allows you to add a gallery of images to any post type, and display them in a carousel.

= Conveyor features =

* Creates a 'Slide' custom post type for you to use with your slider (you can disable this in the options)
* Adds a 'Group' taxonomy to the 'Slide' post type, so you can easily group your slides
* Add links to your slide, using the built in WordPress link chooser 
* Use your own post types as slides
* Comes with a a 'featured slide' meta box (you can enable this on any post type)
* Create your own carousel by using the built in query function
* Optionality render a Bootstrap 3 carousel with customisable options
* Comes with preset 'golden ratio' image sizes for you to use with your slider, so all the images render to the same height

View the FAQ section for usage instructions.

If you are using this plugin in your project [we would love to hear about it](mailto:hello@makedo.in).

== Installation ==

1. Backup your WordPress install
2. Upload the plugin folder to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. The Bootstrap 3 compatible carousel, rendered using the conveyor_render_bootstrap() function
2. The 'slide' custom post type
3. The options screen
4. The 'featured' meta box on an events custom post type

== Frequently asked questions ==

= What functions can I use? =

Two functions are provided by this plugin, these are:

* conveyor_query_arguements()
* conveyor_render_bootstrap()

Both of these functions accept arguments.

= What does the conveyor_query_arguements() function do? =

This function provides arguments for you to filter the slides (or your own post types) creating a custom Loop. You can use it like so:

`get_posts( conveyor_query_arguements( $args ) );`

It accepts the following arguments as an array (or you can leave the $args empty to use the defaults):

`
$defaults = array(
    'featured'                  => false,                           // [ true | false ] - Set to true to return posts that have the featured post custom meta data set to true
    'featured_post_meta_key'    => '_conveyor_featured',            // The custom meta field that identifies the featured post, will also accept an array
    'order'                     => 'ASC',                           // [ ASC | DESC ]
    'orderby'                   => 'date',                          // [ date | menu_order ]
    'posts_per_page'            => 5,                               // Set number of posts to return, -1 will return all
    'post_type'                 => 'conveyor_slides',               // [ post | page | custom post type | array() ]         
    'taxonomy_filter'           => false,                           // [ true | false ] - Set to true to filter by taxonomy
    'taxonomy_key'              => 'conveyor_group',                // The key of the taxonomy we wish to filter by
    'taxonomy_terms'            => 'conveyor-group-1'               // The terms (uses slug), will accept a string or array
);

get_posts( conveyor_query_arguements( $defaults ) );
`

= What does the conveyor_render_bootstrap() function do? =

This function will render a Bootstrap 3 carousel. You can use it like so: 

`conveyor_render_bootstrap( $args );`

It accepts all the same arguments as the conveyor_query_arguements() function, as well as the following arguments as an array (or you can leave the $args empty to use the defaults):

`
$defaults = array(
    'featured'                  => false,                               // [ true | false ] - Set to true to return posts that have the featured post custom meta data set to true
    'featured_post_meta_key'    => '_conveyor_featured',                // The custom meta field that identifies the featured post, will also accept an array
    'id'                        => 'conveyor_carousel',                 // If you want to have multiple carousels, you will want to change the id each time
    'image_size'                => 'golden-ratio-1024',                 // [ thumbnail | medium | large | full | custom ] - the image size you wish to output
    'images_as_links'           => true,                                // [ true | false ] - Set to true to wrap images with links (if _conveyor_link set on post)
    'order'                     => 'ASC',                               // [ ASC | DESC ]
    'orderby'                   => 'date',                              // [ date | menu_order ]
    'posts_per_page'            => 5,                                   // Set number of posts to return, -1 will return all
    'post_type'                 => 'conveyor_slides',                   // [ post | page | custom post type | array() ]
    'render_captions'           => true,                                // [ true | false ] - Set to true to render captions when excerpt is not empty
    'render_controls'           => true,                                // [ true | false ] - Show the slide left right controls
    'render_indicators'         => true                                 // [ true | false ] - Show the slide indicators
);
conveyor_render_bootstrap( $defaults );
`

= The bootstrap carousel isnt working, what do I need to do? =

The plugin will only render the HTML and JavaScript configuration for the carousel, you will need to add Bootstrap CSS and JS to your theme.

= How can I use the meta information stored by the 'Link chooser' meta box? =

The meta keys are:

* '_conveyor_link'
* '_conveyor_open_new_window'

= How can I use the meta information stored by the  'Featured' meta box? =

The meta key is:

* '_conveyor_featured'

= What custom image sizes are created by this plugin? =

The image sizes are:

* 'golden-ratio-2560' - 2560 x 1582
* 'golden-ratio-2048' - 2048 x 1266
* 'golden-ratio-1920' - 1920 x 1186
* 'golden-ratio-1680' - 1680 x 633
* 'golden-ratio-1440' - 1440 x 890
* 'golden-ratio-1280' - 1280 x 791
* 'golden-ratio-1024' - 1024 x 633
* 'golden-ratio-800' - 800 x 494
* 'golden-ratio-640' - 640 x 396

= The custom image sizes dont seem to work, help! =

The image sizes will only take effect on images you have uploaded after this plugin has been installed, however there are other plugins out there (such as [WPThumb](http://wordpress.org/plugins/wp-thumb/)) that will fix this for you.

If it still isnt working, check that you have the 'GD' module installed in your PHP environment. If you havent, you can install it like so:

`apt-get install php5-gd`

= Can I contribute? =

Sure thing, the GitHub repository is right here: (https://github.com/mwtsn/conveyor)

== Changelog ==

= 1.4.2 = 
* Tested with WordPress 4.0

= 1.4.1 = 
* Meta box bug fix

= 1.4.0 =
* Updated default hidden meta boxes

= 1.3.3 =
* Minor ammendments

= 1.3.1 / 1.3.2 = 
* Fixed 'featured' checkbox, saves as string, but checking bool

= 1.3.0 = 
* Added foundation render

= 1.2.5 =   
* Version control issue

= 1.2.4 =   
* Fixed issue with Bootstrap in function names

= 1.2.3 =
Thumbnail naming fix

= 1.2.2 =
* Changed cpt slug

= 1.2.1 =
* Improved documentation

= 1.2.0 =
* Added options screen and featured slide meta box

= 1.1.3 =
* Fixed featured image issue

= 1.1.2 =
* Optimisations

= 1.1.1 =
* Added page-attributes to custom post type

= 1.1.0 =
* Added support for taxonomy queries to filter posts

= 1.0.3 =
* Future proofed the way Bootstrap renders by including $version argument

= 1.0.2 =
* Initial WordPress repository release

== Upgrade notice ==

Prior to version 1.2.4 the function conveyor_render_bootstrap() was called conveyor_render_boostrap(), a legacy function has been added to route the call, so the change shouldn't cause any issues. 