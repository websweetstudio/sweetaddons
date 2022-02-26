<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              sweet.web.id/about
 * @since             1.0.0
 * @package           Sweetaddon
 *
 * @wordpress-plugin
 * Plugin Name:       Sweet Addon
 * Plugin URI:        websweet.xyz/sweetaddon
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Aditya Kristyanto
 * Author URI:        sweet.web.id/about
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sweetaddon
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SWEETADDON_VERSION', '1.0.0' );


/**
 * Add aq resize function
 */
require_once plugin_dir_path(  __FILE__ ) . 'lib/aq_resize/resizer.php';

/**
 * Add custom function
 */
require_once plugin_dir_path(  __FILE__ ) . 'includes/custom-function.php';

/**
 * Add shortcode function
 * 
 */
require plugin_dir_path( __FILE__ ) . 'includes/shortcode.php';
