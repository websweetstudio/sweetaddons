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

use Kirki\Util\Helper;



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
		'priority'    => 90,
		'title'       => esc_html__( 'Floating Button', '' ),
		'description' => esc_html__( '', 'sweetaddons' ),
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
	'whatsapp'          => [ esc_html__( 'Whatsapp', 'sweetaddons' ), '' ],
	'scroll_to_top'     => [ esc_html__( 'Scroll to top', 'sweetaddons' ), '' ],
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
		'label'       => esc_html__( 'Enable Whatsapp', 'sweetaddons' ),
		'description' => esc_html__( 'Enable/Disable Whatsapp', 'sweetaddons' ),
		'section'     => 'whatsapp_section',
		'transport'   => 'postMessage',
		'default'     => true,
	]
);

new \Kirki\Field\Checkbox_Switch(
	[
		'settings'    => 'whatsapp_pulse',
		'label'       => esc_html__( 'Enable Pulse', 'sweetaddons' ),
		'description' => esc_html__( 'Enable/Disable Pulse on whatsapp button.', 'sweetaddons' ),
		'section'     => 'whatsapp_section',
		'transport'   => 'postMessage',
		'default'     => true,
	]
);

new \Kirki\Field\Text(
	[
		'settings'    => 'whatsapp_number',
		'label'       => esc_html__( 'Whatsapp Number', 'sweetaddons' ),
		'description' => esc_html__( 'Enter your whatsapp number', 'sweetaddons' ),
		'section'     => 'whatsapp_section',
		'transport'   => 'postMessage',
		'default'     => '',
	]
);

new \Kirki\Field\Text(
	[
		'settings'    => 'whatsapp_text',
		'label'       => esc_html__( 'Whatsapp Text', 'sweetaddons' ),
		'description' => esc_html__( 'Enter your whatsapp text', 'sweetaddons' ),
		'section'     => 'whatsapp_section',
		'transport'   => 'postMessage',
		'default'     => 'Chat Whatsapp',
	]
);

new \Kirki\Field\Select(
	[
		'settings'    => 'whatsapp_position',
		'label'       => esc_html__( 'Position', 'sweetaddons' ),
		'description' => esc_html__( 'Select position', 'sweetaddons' ),
		'section'     => 'whatsapp_section',
		'transport'   => 'postMessage',
		'default'     => 'right',
		'choices'     => [
			'left'  => esc_html__( 'Left', 'sweetaddons' ),
			'right' => esc_html__( 'Right', 'sweetaddons' ),
		],
	]
);

/**
 * Scroll to top control.
 */
new \Kirki\Field\Checkbox_Switch(
	[
		'settings'    => 'scroll_to_top_enable',
		'label'       => esc_html__( 'Enable Scroll to top', 'sweetaddons' ),
		'description' => esc_html__( 'Enable/Disable Scroll to top', 'sweetaddons' ),
		'section'     => 'scroll_to_top_section',
		'transport'   => 'postMessage',
		'default'     => true,
	]
);



/**
 * Script Panel.
 */
new \Kirki\Panel(
	'script_panel',
	[
		'priority'    => 110,
		'title'       => esc_html__( 'Custom Script', 'sweetaddons' ),
		'description' => esc_html__( '', 'sweetaddons' ),
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
	'header_script' => [ esc_html__( 'Header Script', 'sweetaddons' ), '' ],
	'footer_script' => [ esc_html__( 'Footer Script', 'sweetaddons' ), '' ],
];

foreach ( $sections as $section_id => $section ) {
	$section_args = [
		'title'       => $section[0],
		'description' => $section[1],
		'panel'       => 'script_panel',
	];
	if ( isset( $section[2] ) ) {
		$section_args['type'] = $section[2];
	}
	new \Kirki\Section( str_replace( '-', '_', $section_id ) . '_section', $section_args );
}

/**
 * Code control.
 *
 * @link https://kirki.org/docs/controls/code.html
 */
new \Kirki\Field\Code(
	[
		'settings'    => 'header_script',
		'label'       => esc_html__( 'Header Script', 'sweetaddons' ),
		'description' => esc_html__( '', 'sweetaddons' ),
		'section'     => 'header_script_section',
		'default'     => '',
		'choices'     => [
			'language' => 'html',
		],
	]
);

/**
 * Code control.
 *
 * @link https://kirki.org/docs/controls/code.html
 */
new \Kirki\Field\Code(
	[
		'settings'    => 'footer_script',
		'label'       => esc_html__( 'Footer Script', 'sweetaddons' ),
		'description' => esc_html__( '', 'sweetaddons' ),
		'section'     => 'footer_script_section',
		'default'     => '',
		'choices'     => [
			'language' => 'html',
		],
	]
);

// add action after the theme is set up.
add_action( 'after_setup_theme', function () {

	// replace primary color with custom color.
	new \Kirki\Field\Color(
		[
			'settings'    => 'body_color',
			'label'       => esc_html__( 'Primary Color', 'sweetaddons' ),
			'description' => esc_html__( '', 'sweetaddons' ),
			'section'     => 'colors',
			'default'     => '#777777',
			'output'      => [
				[ 'element' => 'body', 'property' => 'color' ],
			],
		]
	);

	// replace link color with custom color.
	new \Kirki\Field\Color(
		[
			'settings'    => 'link_color',
			'label'       => esc_html__( 'Link Color', 'sweetaddons' ),
			'description' => esc_html__( '', 'sweetaddons' ),
			'section'     => 'colors',
			'default'     => '#333333',
			'output'      => [
				[ 'element' => 'a', 'property' => 'color' ],
			],
		]
	);
	
	if ( class_exists( 'WooCommerce' ) ) {
		// replace woocommerce color with custom color.
		new \Kirki\Field\Color(
			[
				'settings'    => 'woocommerce_color',
				'label'       => esc_html__( 'WooCommerce Color', 'sweetaddons' ),
				'description' => esc_html__( '', 'sweetaddons' ),
				'section'     => 'colors',
				'default'     => '#333333',
				'output'      => [
					[ 'element' => '.woocommerce div.product span.price, .woocommerce ul.products li.product .price', 'property' => 'color' ],
					[ 'element' => '.woocommerce div.product p.price', 'property' => 'color' ],
					[ 'element' => '.woocommerce .single_add_to_cart_button', 'property' => 'background-color'],
					[ 'element' => '.woocommerce .single_add_to_cart_button', 'property' => 'border-color'],
					[ 'element' => '.woocommerce span.onsale',  'property' => 'background-color']
				],
			],
		);
	}
});

/**
 * Add a panel.
 *
 * @link https://kirki.org/docs/getting-started/panels.html
 */
new \Kirki\Panel(
	'developer_panel',
	[
		'priority'    => 90,
		'title'       => esc_html__( 'Developer Option', '' ),
		'description' => esc_html__( '', 'sweetaddons' ),
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
	'plugin_update'          => [ esc_html__( 'Plugin Update', 'sweetaddons' ), '' ],
	'spam_protect'          => [ esc_html__( 'Spam Protect', 'sweetaddons' ), '' ],
];

foreach ( $sections as $section_id => $section ) {
	$section_args = [
		'title'       => $section[0],
		'description' => $section[1],
		'panel'       => 'developer_panel',
	];
	if ( isset( $section[2] ) ) {
		$section_args['type'] = $section[2];
	}
	new \Kirki\Section( str_replace( '-', '_', $section_id ) . '_section', $section_args );
}

/**
 * Code Control.
 * Plugin Update
 */
new \Kirki\Field\Select(
	[
		'settings'    => 'plugin_update',
		'label'       => esc_html__( 'Developer Mode', 'sweetaddons' ),
		'description' => esc_html__( 'Select position', 'sweetaddons' ),
		'section'     => 'plugin_update_section',
		'transport'   => 'postMessage',
		'default'     => '0',
		'choices'     => [
			'1'  => esc_html__( 'True', 'sweetaddons' ),
			'0' => esc_html__( 'False', 'sweetaddons' ),
		],
	]
);

/**
 * Code Control.
 * Plugin Update
 */
new \Kirki\Field\Select(
	[
		'settings'    => 'disable_comment',
		'label'       => esc_html__( 'Disable Comment', 'sweetaddons' ),
		'description' => esc_html__( 'Disable comment ', 'sweetaddons' ),
		'section'     => 'spam_protect_section',
		'transport'   => 'postMessage',
		'default'     => '1',
		'choices'     => [
			'1'  => esc_html__( 'True', 'sweetaddons' ),
			'0' => esc_html__( 'False', 'sweetaddons' ),
		],
	]
);