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
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sweetaddon-activator.php
 */
function activate_sweetaddon() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sweetaddon-activator.php';
	Sweetaddon_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sweetaddon-deactivator.php
 */
function deactivate_sweetaddon() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sweetaddon-deactivator.php';
	Sweetaddon_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sweetaddon' );
register_deactivation_hook( __FILE__, 'deactivate_sweetaddon' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sweetaddon.php';

/**
 * Add aq resize function
 */
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'lib/aq_resize/resizer.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'lib/aq_resize/template-tags.php';

/**
 * Add custom function
 */
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/custom-function.php';

/**
 * Add shortcode function
 * 
 */
require plugin_dir_path( __FILE__ ) . 'includes/shortcode.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sweetaddon() {

	$plugin = new Sweetaddon();
	$plugin->run();

}
run_sweetaddon();
