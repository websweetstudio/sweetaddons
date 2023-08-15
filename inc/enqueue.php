<?php
function plugins_enqueue_styles()
{
  wp_enqueue_style('sweetaddons-style', SWEETADDON_URL . 'public/css/sweetaddons.min.css', array(), '1.0.0', 'all');

  wp_enqueue_script('jQuery');
  wp_enqueue_script('lazy-script', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.11/jquery.lazy.min.js', array(), '1.0.0', true);
  wp_enqueue_script('sweetaddons-script', SWEETADDON_URL . 'public/js/sweetaddons.js', array(), '1.0.0', true);

  wp_add_inline_style('sweetaddons-style', get_theme_mod('custom_code_css'));
  wp_add_inline_script('sweetaddons-script', get_theme_mod('custom_code_js'));

  wp_localize_script('sweetaddons-script', 'sweetaddons', array(
    'ajaxurl' => admin_url('admin-ajax.php')
  ));
}
add_action('wp_enqueue_scripts', 'plugins_enqueue_styles', 20);