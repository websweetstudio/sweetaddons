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
if ( ! class_exists( sweetaddon ) ) {
	return;
}

Kirki::add_config(
	'kirki_demo_config',
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
	'kirki_demo_panel',
	[
		'priority'    => 10,
		'title'       => esc_html__( 'Kirki Demo Panel', sweetaddon ),
		'description' => esc_html__( 'Contains sections for all kirki controls.', sweetaddon ),
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
	'whatsapp'          => [ esc_html__( 'Whatsapp', sweetaddon ), '' ],
	// 'code'            => [ esc_html__( 'Code', sweetaddon ), '' ],
	// 'checkbox'        => [ esc_html__( 'Checkbox', sweetaddon ), '' ],
	// 'color'           => [ esc_html__( 'Color', sweetaddon ), '' ],
	// 'color_advanced'  => [ esc_html__( 'Color — Advanced', sweetaddon ), '' ],
	// 'color_palette'   => [ esc_html__( 'Color Palette', sweetaddon ), '' ],
	// 'custom'          => [ esc_html__( 'Custom', sweetaddon ), '' ],
	// 'dashicons'       => [ esc_html__( 'Dashicons', sweetaddon ), '' ],
	// 'date'            => [ esc_html__( 'Date', sweetaddon ), '' ],
	// 'dimension'       => [ esc_html__( 'Dimension', sweetaddon ), '' ],
	// 'dimensions'      => [ esc_html__( 'Dimensions', sweetaddon ), '' ],
	// 'dropdown-pages'  => [ esc_html__( 'Dropdown Pages', sweetaddon ), '' ],
	// 'editor'          => [ esc_html__( 'Editor', sweetaddon ), '' ],
	// 'fontawesome'     => [ esc_html__( 'Font-Awesome', sweetaddon ), '' ],
	// 'generic'         => [ esc_html__( 'Generic', sweetaddon ), '' ],
	// 'image'           => [ esc_html__( 'Image', sweetaddon ), '' ],
	// 'multicheck'      => [ esc_html__( 'Multicheck', sweetaddon ), '' ],
	// 'multicolor'      => [ esc_html__( 'Multicolor', sweetaddon ), '' ],
	// 'number'          => [ esc_html__( 'Number', sweetaddon ), '' ],
	// 'palette'         => [ esc_html__( 'Palette', sweetaddon ), '' ],
	// 'preset'          => [ esc_html__( 'Preset', sweetaddon ), '' ],
	// 'radio'           => [ esc_html__( 'Radio', sweetaddon ), esc_html__( 'A plain Radio control.', sweetaddon ) ],
	// 'radio-buttonset' => [ esc_html__( 'Radio Buttonset', sweetaddon ), esc_html__( 'Radio-Buttonset controls are essentially radio controls with some fancy styling to make them look cooler.', sweetaddon ) ],
	// 'radio-image'     => [ esc_html__( 'Radio Image', sweetaddon ), esc_html__( 'Radio-Image controls are essentially radio controls with some fancy styles to use images', sweetaddon ) ],
	// 'repeater'        => [ esc_html__( 'Repeater', sweetaddon ), '' ],
	// 'select'          => [ esc_html__( 'Select', sweetaddon ), '' ],
	// 'slider'          => [ esc_html__( 'Slider', sweetaddon ), '' ],
	// 'sortable'        => [ esc_html__( 'Sortable', sweetaddon ), '' ],
	// 'switch'          => [ esc_html__( 'Switch', sweetaddon ), '', 'outer' ],
	// 'toggle'          => [ esc_html__( 'Toggle', sweetaddon ), '', 'outer' ],
	// 'typography'      => [ esc_html__( 'Typography', sweetaddon ), '' ],
	// 'upload'          => [ esc_html__( 'Upload', sweetaddon ), '' ],
];

foreach ( $sections as $section_id => $section ) {
	$section_args = [
		'title'       => $section[0],
		'description' => $section[1],
		'panel'       => 'kirki_demo_panel',
	];
	if ( isset( $section[2] ) ) {
		$section_args['type'] = $section[2];
	}
	new \Kirki\Section( str_replace( '-', '_', $section_id ) . '_section', $section_args );
}

/**
 * Whatsapp control.
 */
new \Kirki\Control\Text(
    'whatsapp_control',
    [
        'label'    => esc_html__( 'Whatsapp', sweetaddon ),
        'section'  => 'whatsapp_section',
        'settings' => 'whatsapp_setting',
        'priority' => 10,
    ]
);


