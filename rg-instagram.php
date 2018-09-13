<?php 
/*
    Plugin Name: RoveGroup Instagram Feed
    Plugin URI: https://therovegroup.com/igfeed
    Description: Responsive instagram feed, customizable and easy to use.
    Version: 0.1.0
    Author: The Rove Group
    Author URI: https://therovegroup.com/
	Text Domain: rg-instagram
	License: GPLv3
	License URI: http://www.gnu.org/licenses/gpl.html
*/

// define a versioin number
define( 'RGINSTV', '0.1.0' );

if ( ! defined( 'ABSPATH' ) ) exit; // bail out, they shouldn't access this way
//Admin Functions
require_once( plugin_dir_path( __FILE__ ) . 'rg-instagram-admin.php' );
//Shortcode Functions
require_once( plugin_dir_path( __FILE__ ) . 'inc/shortcodes.php' );
//Core Functions
require_once( plugin_dir_path( __FILE__ ) . 'inc/functions.php' );


//enque top stuff
add_action( 'wp_enqueue_scripts', 'rg_ig_enqueue_top' );

//Custom stuff for the header
add_action( 'wp_head', 'rg_ig_header_stuff' );

//Custom footer
add_action( 'wp_footer', 'rg_ig_footer_stuff' );

// activate / uninstall plugin
register_activation_hook( __FILE__, 'rg_ig_activate' );
register_uninstall_hook( __FILE__, 'rg_ig_uninstall' );

?>