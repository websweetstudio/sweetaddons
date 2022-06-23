<?php
wp_enqueue_style( 'sweetaddon-style', SWEETADDON_URL . 'assets/css/style.css', array(), '1.0.0', 'all' );
wp_enqueue_style( 'sweetaddon-custom', SWEETADDON_URL . 'assets/css/custom.css', array(), '1.0.0', 'all' );

wp_enqueue_script( 'sweetaddon-script', SWEETADDON_URL . 'assets/js/script.js', array( 'child-understrap-scripts' ), '1.0.0', true );
wp_enqueue_script( 'sweetaddon-custom', SWEETADDON_URL . 'assets/js/custom.js', array( 'child-understrap-scripts' ), '1.0.0', true );
