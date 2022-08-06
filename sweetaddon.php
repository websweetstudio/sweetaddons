<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              dev.websweet.xyz
 * @since             1.2.0
 * @package           Sweetaddon
 *
 * @wordpress-plugin
 * Plugin Name:       Sweet Addon
 * Plugin URI:        dev.websweet.xyz
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.5.0
 * Author:            Aditya Kristyanto
 * Author URI:        dev.websweet.xyz
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
define( 'SWEETADDON_VERSION', '1.5.0' );

/**
 * Define plugin path url
 */
define( 'SWEETADDON_URL', plugin_dir_url( __FILE__ ) );

/**
 * Add tgmpa function
 */
require_once plugin_dir_path(  __FILE__ ) . 'lib/tgmpa/class-tgm-plugin-activation.php';
require_once plugin_dir_path(  __FILE__ ) . 'inc/websweet-plugin.php';

/**
 * add wp enqueue
 */
require_once plugin_dir_path(  __FILE__ ) . 'inc/enqueue.php';

/**
 * Add customizer function
 */
require_once plugin_dir_path(  __FILE__ ) . 'inc/customizer.php';


/**
 * Add woongkir custom
 */
if ( class_exists( 'WooCommerce' ) ) {
	require_once plugin_dir_path(  __FILE__ ) . 'lib/Woongkir/woongkir.php';
}

/**
 * Add function
 */
require_once plugin_dir_path(  __FILE__ ) . 'inc/function.php';
require_once plugin_dir_path(  __FILE__ ) . 'custom/custom.php';


/**
 * Add shortcode function
 */
require plugin_dir_path( __FILE__ ) . 'inc/shortcode.php';
