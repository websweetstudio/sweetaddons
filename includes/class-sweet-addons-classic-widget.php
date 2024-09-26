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

class Sweet_Addons_Classic_Widget
{
    public function __construct()
    {
        if (get_option('classic_widget_sweet_addons')) {
            // Disables the block editor from managing widgets in the Gutenberg plugin.
            add_filter('gutenberg_use_widgets_block_editor', '__return_false');
            // Disables the block editor from managing widgets.
            add_filter('use_widgets_block_editor', '__return_false');
        }
    }
}
// Initialize the Sweet_Addons_Classic_Widget class
$sweet_addons_classic_widget = new Sweet_Addons_Classic_Widget();
