<?php

/**
 *
 * @link              dev.websweetstudio.com
 * @since             1.2.0
 * @package           sweetaddons
 *
 * @wordpress-plugin
 * Plugin Name:       Sweet Addons
 * Plugin URI:        websweetstudio.com
 * Description:       Plugin for websweetstudio.com client.
 * Version:           1.6.8
 * Author:            Aditya Kristyanto
 * Author URI:        websweetstudio.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sweetaddons
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('SWEETADDON_VERSION', '1.6.8');

/**
 * Define plugin path url
 */
define('SWEETADDON_URL', plugin_dir_url(__FILE__));
define('SWEETADDON_PLUGIN_DIR_URL', plugin_dir_url(__FILE__));

/**
 * Add function
 */
// require_once plugin_dir_path(  __FILE__ ) . 'custom/custom.php';


$libs = array(
	'lib/tgmpa/class-tgm-plugin-activation.php',
);
$incs = array(
	'inc/websweet-plugin.php',
	'inc/enqueue.php',
	'inc/customizer.php',
	'inc/function.php',
	'inc/class-sweetaddons.php',
	'inc/shortcode.php',
);

foreach ($libs as $lib) {
	require_once plugin_dir_path(__FILE__) . $lib;
}
foreach ($incs as $inc) {
	require_once plugin_dir_path(__FILE__) . $inc;
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sweetaddons()
{

	$plugin = new Sweetaddons();
	$plugin->run();
}
run_sweetaddons();