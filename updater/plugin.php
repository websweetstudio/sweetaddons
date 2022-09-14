<?php
/**
 * An example file demonstrating how to add all controls.
 *
 * @package Kirki
 * @category Core
 * @author Ari Stathopoulos (@aristath)
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license https://opensource.org/licenses/MIT
 * @since 3.0.12
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'sweetaddon_updater_test_init' );
function sweetaddon_updater_test_init() {

	// include_once 'updater.php';

	if ( is_admin() ) { // note the use of is_admin() to double check that this is happening in the admin

		$config = array(
			'slug' => plugin_basename( __FILE__ ),
			'proper_folder_name' => 'sweetaddon',
			'api_url' => 'https://api.github.com/repos/websweetxyz/sweetaddon',
			'raw_url' => 'https://raw.github.com/websweetxyz/sweetaddon/master',
			'github_url' => 'https://github.com/websweetxyz/sweetaddon',
			'zip_url' => 'https://github.com/websweetxyz/sweetaddon/archive/master.zip',
			'sslverify' => true,
			'requires' => '1.5.4',
			'tested' => '1.5.2',
			'readme' => 'README.md',
			'access_token' => '',
		);

		new WP_GitHub_Updater( $config );

	}

}