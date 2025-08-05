<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://websweetstudio.com
 * @since      1.0.0
 *
 * @package    Sweet_Addons
 * @subpackage Sweet_Addons/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Sweet_Addons
 * @subpackage Sweet_Addons/includes
 * @author     WebsweetStudio <websweetstudio@gmail.com>
 */

 class Sweet_Addons_Hide_Admin_Notice {
    public function __construct() {
        add_action('admin_notices', array($this, 'hide_admin_notice'));
    }

    public function hide_admin_notice() {
        $hide_admin_notice_value = get_option('hide_admin_notice');
        
        if ($hide_admin_notice_value) {
            global $wp_filter;
            remove_all_actions('admin_notices');
            echo '<style>.notice { display: none !important; }</style>';
        }
    }
}

// Initialize the Sweet_Addons_Hide_Admin_Notice class
$hide_admin_notice = new Sweet_Addons_Hide_Admin_Notice();