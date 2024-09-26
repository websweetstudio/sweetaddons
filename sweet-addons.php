<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://websweetstudio.com
 * @since             1.0.6
 * @package           Sweet_Addons
 *
 * @wordpress-plugin
 * Plugin Name:       Sweet Addons
 * Plugin URI:        https://websweetstudio.com
 * Description:       Addon plugin for WebsweetStudio Client
 * Version:           1.1.6
 * Author:            WebsweetStudio
 * Author URI:        https://websweetstudio.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sweet-addons
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
define('SWEET_ADDONS_VERSION', '1.1.6');
define('PLUGIN_DIR', plugin_dir_path(__DIR__));
define('PLUGIN_FILE', plugin_basename(__FILE__));
define('PLUGIN_BASE_NAME', plugin_basename(__DIR__));
define('SWEET_ADDONS_PLUGIN_DIR_URL', plugin_dir_url(__FILE__));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sweet-addons-activator.php
 */
function activate_sweet_addons()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-sweet-addons-activator.php';
    Sweet_Addons_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sweet-addons-deactivator.php
 */
function deactivate_sweet_addons()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-sweet-addons-deactivator.php';
    Sweet_Addons_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_sweet_addons');
register_deactivation_hook(__FILE__, 'deactivate_sweet_addons');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-sweet-addons.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sweet_addons()
{

    $plugin = new Sweet_Addons();
    $plugin->run();
}
run_sweet_addons();
