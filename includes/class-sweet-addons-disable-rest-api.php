<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       https://websweetstudio.com
 * @since      1.0.0
 *
 * @package    Sweet_Addons
 * @subpackage Sweet_Addons/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Sweet_Addons
 * @subpackage Sweet_Addons/includes
 * @author     WebsweetStudio <websweetstudio@gmail.com>
 */

class Sweet_Addons_Disable_Rest_Api
{
    public function __construct()
    {
        if (get_option('disable_rest_api')) {
            add_filter('rest_authentication_errors', array($this, 'disable_rest_api'), 99);
            add_filter('rest_enabled', '__return_false');
            add_filter('rest_jsonp_enabled', '__return_false');
            // add_action('init', array($this, 'block_rest_api'), 1);
        }
    }

    public function disable_rest_api($access)
    {
        return new WP_Error('rest_disabled', __('The REST API is disabled on this site.'), array('status' => rest_authorization_required_code()));
    }

    public function block_rest_api()
    {
        global $wp_rewrite;
        $wp_rewrite->set_permalink_structure('/%postname%/%category%/');
    }
}

// Inisialisasi class Sweet_Addons_Disable_Rest_Api
$sweet_disable_rest_api = new Sweet_Addons_Disable_Rest_Api();
