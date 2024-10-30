<?php
/**
 * @package Conveyor
 * @version 1.4.2
 */

/*
Plugin Name:  Conveyor
Plugin URI:   http://makedo.in/products/
Description:  Gives you a 'slides' custom post type, or use your own post type with an optional 'featured slide' checkbox to render a carousel.
Author:       Make Do
Version:      1.4.2
Author URI:   http://makedo.in/
Licence:      GPLv2 or later
License URI:  http://www.gnu.org/licenses/gpl-2.0.html


/////////  VERSION HISTORY

1.0.0			First development version
1.0.1 			Implemented link chooser
1.0.2 			Added Bootstrap Render
1.0.3 			Added Boostrap Version Picker
1.1.0 			Added support for taxonomies
1.1.1 			Added page-attributes to custom post type
1.1.2 			Changed Post Submission
1.1.3 			Fixed featured image
1.2.0			Added options screen and featured slide meta box
1.2.1			Improved documentation
1.2.2			Changed cpt slug
1.2.3 			Bug fix in name
1.2.4 			Fixed issue with Bootstrap in function names
1.2.5 			Version control issue
1.3.0			Added foundation render
1.3.1 / 1.3.2 	Fixed 'featured' checkbox, saves as string, but checking bool
1.3.3 			Minor ammendments
1.4.0			Updated default hidden meta boxes
1.4.1 			Meta box bug fix


/////////  DEV STRUCTURE

1  - Create conveyor custom post type
2  - Create conveyor group custom taxonomy
3  - Enqueue scripts
4  - Link chooser custom meta box
5  - Link chooser form
6  - Loop query arguments
7  - Bootstrap slideshow render
8  - Options
9  - Featured slide meta box
10 - Foundation slideshow render

*/

// 1  - Create conveyor custom post type
require_once 'admin-post-type-conveyor-slides.php';

// 2  - Create conveyor group custom taxonomy
require_once 'admin-taxonomy-conveyor-group.php';

// 3  - Enqueue scripts
require_once 'admin-scripts.php';

// 4  - Link chooser custom meta box
require_once 'admin-meta-box-conveyor-link-chooser.php';

// 5  - Link chooser form
require_once 'helper-conveyor-link-dialog.php';

// 6  - Loop query arguments
require_once 'ui-conveyor-query-arguements.php';

// 7  - Bootstrap slideshow render
require_once 'ui-conveyor-render-boostrap.php';

// 8  - Options
require_once 'admin-options.php';

// 9  - Featured slide meta box
require_once 'admin-meta-box-conveyor-featured.php';

// 10 - Foundation slideshow render
require_once 'ui-conveyor-render-foundation.php';

?>