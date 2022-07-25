<?php
function plugins_enqueue_styles() {
  wp_enqueue_style( 'sweetaddon-style', SWEETADDON_URL . 'assets/css/style.css', array(), '1.0.0', 'all' );
  wp_enqueue_style( 'sweetaddon-custom', SWEETADDON_URL . 'custom/css/custom.css', array(), '1.0.0', 'all' );

  wp_enqueue_script( 'sweetaddon-script', SWEETADDON_URL . 'assets/js/script.js', array(), '1.0.0', true );
  wp_enqueue_script( 'sweetaddon-custom', SWEETADDON_URL . 'custom/js/custom.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'plugins_enqueue_styles', 20 );
