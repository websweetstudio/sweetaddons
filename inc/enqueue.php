<?php
function plugins_enqueue_styles() {
  wp_enqueue_style( 'sweetaddon-style', SWEETADDON_URL . 'assets/css/sweetaddon.min.css', array(), '1.0.0', 'all' );
  wp_enqueue_style( 'sweetaddon-custom', SWEETADDON_URL . 'custom/css/custom.css', array(), '1.0.0', 'all' );

  wp_enqueue_script( 'sweetaddon-script', SWEETADDON_URL . 'assets/js/sweetaddon.min.js', array(), '1.0.0', true );
  wp_enqueue_script( 'sweetaddon-custom', SWEETADDON_URL . 'custom/js/custom.js', array(), '1.0.0', true );

  wp_add_inline_style( 'sweetaddon-style', get_theme_mod( 'custom_code_css' ) );
  wp_add_inline_script( 'sweetaddon-script', get_theme_mod( 'custom_code_js' ) );
}
add_action( 'wp_enqueue_scripts', 'plugins_enqueue_styles', 20 );
