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

use Kirki\Util\Helper;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Do not proceed if Kirki does not exist.
if ( ! class_exists( 'Kirki' ) ) {
	return;
}

Kirki::add_config(
	'sweetaddon_config',
	[
		'option_type' => 'theme_mod',
		'capability'  => 'manage_options',
	]
);

/**
 * Add a panel.
 *
 * @link https://kirki.org/docs/getting-started/panels.html
 */
new \Kirki\Panel(
	'floating_panel',
	[
		'priority'    => 10,
		'title'       => esc_html__( 'Floating Button', 'sweetaddon' ),
		'description' => esc_html__( '', 'sweetaddon' ),
	]
);

/**
 * Add Sections.
 *
 * We'll be doing things a bit differently here, just to demonstrate an example.
 * We're going to define 1 section per control-type just to keep things clean and separate.
 *
 * @link https://kirki.org/docs/getting-started/sections.html
 */
$sections = [
	'whatsapp'          => [ esc_html__( 'Whatsapp', 'sweetaddon' ), '' ],
	'scroll_to_top'     => [ esc_html__( 'Scroll to top', 'sweetaddon' ), '' ],
];

foreach ( $sections as $section_id => $section ) {
	$section_args = [
		'title'       => $section[0],
		'description' => $section[1],
		'panel'       => 'floating_panel',
	];
	if ( isset( $section[2] ) ) {
		$section_args['type'] = $section[2];
	}
	new \Kirki\Section( str_replace( '-', '_', $section_id ) . '_section', $section_args );
}

/**
 * Whatsapp control.
 */
new \Kirki\Field\Checkbox_Switch(
	[
		'settings'    => 'whatsapp_enable',
		'label'       => esc_html__( 'Enable Whatsapp', 'sweetaddon' ),
		'description' => esc_html__( 'Enable/Disable Whatsapp', 'sweetaddon' ),
		'section'     => 'whatsapp_section',
		'transport'   => 'postMessage',
		'default'     => true,
	]
);

new \Kirki\Field\Text(
	[
		'settings'    => 'whatsapp_number',
		'label'       => esc_html__( 'Whatsapp Number', 'sweetaddon' ),
		'description' => esc_html__( 'Enter your whatsapp number', 'sweetaddon' ),
		'section'     => 'whatsapp_section',
		'transport'   => 'postMessage',
		'default'     => '',
	]
);

new \Kirki\Field\Text(
	[
		'settings'    => 'whatsapp_text',
		'label'       => esc_html__( 'Whatsapp Text', 'sweetaddon' ),
		'description' => esc_html__( 'Enter your whatsapp text', 'sweetaddon' ),
		'section'     => 'whatsapp_section',
		'transport'   => 'postMessage',
		'default'     => 'Chat Whatsapp',
	]
);

new \Kirki\Field\Select(
	[
		'settings'    => 'whatsapp_position',
		'label'       => esc_html__( 'Position', 'sweetaddon' ),
		'description' => esc_html__( 'Select position', 'sweetaddon' ),
		'section'     => 'whatsapp_section',
		'transport'   => 'postMessage',
		'default'     => 'right',
		'choices'     => [
			'left'  => esc_html__( 'Left', 'sweetaddon' ),
			'right' => esc_html__( 'Right', 'sweetaddon' ),
		],
	]
);

/**
 * Scroll to top control.
 */
 
new \Kirki\Field\Checkbox_Switch(
	[
		'settings'    => 'scroll_to_top_enable',
		'label'       => esc_html__( 'Enable Scroll to top', 'sweetaddon' ),
		'description' => esc_html__( 'Enable/Disable Scroll to top', 'sweetaddon' ),
		'section'     => 'scroll_to_top_section',
		'transport'   => 'postMessage',
		'default'     => true,
	]
);

new \Kirki\Field\Dashicons(
	[
		'settings'    => 'scroll_to_top_icon',
		'label'       => esc_html__( 'Icon', 'sweetaddon' ),
		'description' => esc_html__( 'Select icon', 'sweetaddon' ),
		'section'     => 'scroll_to_top_section',
		'transport'   => 'postMessage',
		'default'     => 'arrow-up-alt2',
		'choices'     => [
			'arrow-up-alt',
			'arrow-up',
			'arrow-up-alt2',
		]
	]
);