<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       https://websweetstudio.com
 * @since      1.0.0
 *
 * @package    sweetaddons
 * @subpackage sweetaddons/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    sweetaddons
 * @subpackage sweetaddons/includes
 * @author     Aditya Kristyanto <aadiityaak@gmail.com>
 */
class sweetaddons_Maintenance_Mode
{
    public function __construct()
    {
        if (get_option('maintenance_mode')) {
            add_action('wp', array($this, 'check_maintenance_mode'));
        }
    }

    public function check_maintenance_mode()
    {
        if (!current_user_can('manage_options') && !is_admin() && !is_page('myaccount')) {
            wp_die('<h1>Maintenance Mode</h1><p>We are currently performing maintenance. Please check back later.</p>', 'Maintenance Mode');
        }
    }
}

// Inisialisasi class sweetaddons_Maintenance_Mode
$sweetaddons_maintenance_mode = new sweetaddons_Maintenance_Mode();
