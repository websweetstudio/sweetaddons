<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       https://websweetstudio.com
 * @since      1.0.0
 *
 * @package    Sweet_Addons
 * @subpackage Sweet_Addons/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Sweet_Addons
 * @subpackage Sweet_Addons/includes
 * @author     WebsweetStudio <websweetstudio@gmail.com>
 */

 class Sweet_Addons_Remove_Slug_Category {
    public function __construct() {
        add_filter('post_type_link', array($this, 'remove_category_slug'), 10, 2);
        add_action('init', array($this, 'flush_rewrite_rules'));
    }

    public function remove_category_slug($post_link, $post) {
        $remove_slug_category = get_option('remove_slug_category_sweet_addons');

        if ($remove_slug_category && 'post' === $post->post_type && 'publish' === $post->post_status) {
            $categories = get_the_category($post->ID);

            if ($categories) {
                $category_slug = $categories[0]->slug;
                $post_link = str_replace('/category/' . $category_slug, '/', $post_link);
            }
        }

        return $post_link;
    }

    public function flush_rewrite_rules() {
        $remove_slug_category = get_option('remove_slug_category_sweet_addons');

        if ($remove_slug_category) {
            flush_rewrite_rules();
        }
    }
}

// Inisialisasi class Sweet_Addons_Remove_Slug_Category
$Sweet_Addons_Remove_Slug_Category = new Sweet_Addons_Remove_Slug_Category();
