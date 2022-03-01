<?php
wp_enqueue_style( 'sweetaddon-style', plugin_dir_url( __FILE__ ) . 'assets/css/style.css', array(), '1.0.0', 'all' );
wp_enqueue_script( 'sweetaddon-script', plugin_dir_url( __FILE__ ) . 'assets/js/script.js', array( 'jquery' ), '1.0.0', true );