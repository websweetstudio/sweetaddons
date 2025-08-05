<?php

/**
 * Fired during plugin activation
 *
 * @link       https://websweetstudio.com
 * @since      1.0.0
 *
 * @package    Sweetaddons
 * @subpackage Sweetaddons/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Sweetaddons
 * @subpackage Sweetaddons/includes
 * @author     WebsweetStudio <websweetstudio@gmail.com>
 */
class Sweetaddons_Activator
{

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate()
	{
		// Mengarahkan pengguna ke halaman custom_admin_options saat plugin diaktifkan
		// wp_redirect(admin_url('options-general.php?page=custom_admin_options'));
		// exit;
	}
}
