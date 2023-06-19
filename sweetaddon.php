<?php

/**
 *
 * @link              dev.websweet.xyz
 * @since             1.2.0
 * @package           Sweetaddon
 *
 * @wordpress-plugin
 * Plugin Name:       Sweet Addon
 * Plugin URI:        websweet.xyz
 * Description:       Plugin for websweet.xyz client.
 * Version:           1.6.5
 * Author:            Aditya Kristyanto
 * Author URI:        dev.websweet.xyz
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sweetaddon
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
define('SWEETADDON_VERSION', '1.6.5');

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
	'inc/shortcode.php',
	'inc/class-sweetaddons.php'
);

foreach ($libs as $lib) {
	require_once plugin_dir_path(__FILE__) . $lib;
}
foreach ($incs as $inc) {
	require_once plugin_dir_path(__FILE__) . $inc;
}