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

class sweetaddons_Remove_Slug_Category
{
    public function __construct()
    {
        if (get_option('remove_slug_category')) {
            add_filter('user_trailingslashit', array($this, 'remove_category'), 100, 2);
        }
    }

    function remove_category($string, $type)
    {
        if ($type != 'single' && $type == 'category' && (strpos($string, 'category') !== false)) {
            $url_without_category = str_replace("/category/", "/", $string);
            return trailingslashit($url_without_category);
        }
        return $string;
    }
}
// Initialize the sweetaddons_Standar_Editor class
$sweetaddons__remove_slug_sategory = new sweetaddons_Remove_Slug_Category();
