<?php
/**
 * sweetaddons functions
 *
 * @package sweetaddons
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

add_action( 'wp_footer', 'wp_footer_whatsapp' );
if(! function_exists('wp_footer_whatsapp')){
    /**
     * wp footer whatsapp floating
     */
    function wp_footer_whatsapp() {
        $whatsapp_number        = get_theme_mod( 'whatsapp_number', '08123456789' );
        $whatsapp_text          = get_theme_mod( 'whatsapp_text', 'Chat Whatsapp' );
        $whatsapp_enable        = get_theme_mod( 'whatsapp_enable', true );
        $whatsapp_position      = get_theme_mod( 'whatsapp_position', 'right' );
        $scroll_to_top_enable   = get_theme_mod( 'scroll_to_top_enable', true );
        $scroll_to_top_enable   = $scroll_to_top_enable ? 'scroll-active' : '';
        // replace all except numbers
        $whatsapp_number        = preg_replace('/[^0-9]/', '', $whatsapp_number);
        // replace 0 with 62 if first digit is 0
        if(substr($whatsapp_number, 0, 1) == 0) {
            $whatsapp_number    = substr_replace($whatsapp_number, '62', 0, 1);
        }
        if($whatsapp_enable) {
            ?>
            <div class="whatsapp-floating <?php echo $whatsapp_position.' '.$scroll_to_top_enable; ?> ">
                <a href="https://wa.me/<?php echo $whatsapp_number; ?>" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                    </svg>
                    <span><?php echo $whatsapp_text; ?></span>
                </a>
            </div>
            <?php
        }
    }
}

add_action( 'wp_footer', 'wp_footer_scroll_to_top' );
if(! function_exists('wp_footer_scroll_to_top')){
    /**
     * wp footer scroll to top
     */
    function wp_footer_scroll_to_top() {
        $scroll_to_top_enable = get_theme_mod( 'scroll_to_top_enable', true );
        if($scroll_to_top_enable) {
            ?>
            <div class="scroll-to-top">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/>
                </svg>
            </div>
            <?php
        }
    }
}

add_filter('wp_nav_menu_items','add_cart_into_menu', 10, 2);
if(! function_exists('add_cart_into_menu')){
    /**
     * add cart into menu
     */
    function add_cart_into_menu($items, $args) {
        
        $cart = '';
        $header_ids = false;

        if ( class_exists( 'FLThemeBuilderLayoutData' ) ) {
            // Get the header ID.
            $header_ids = FLThemeBuilderLayoutData::get_current_page_header_ids();
        }
    
        // Disable when beaver builder active.
        if ( class_exists( 'WooCommerce' ) && ! $header_ids ) {
            ob_start();
            if($args->theme_location == 'primary') {
                ?>
                <li class="menu-item menu-item-cart">
                    <a href="<?php echo wc_get_cart_url(); ?>" class="cart-control nav-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-basket" viewBox="0 0 16 16">
                            <path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9H2zM1 7v1h14V7H1zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                        <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                    </a>
                </li>
                <?php
            }
            $cart = ob_get_clean();
        }
        return $items . $cart;
    }
}

add_action( 'wp_footer', 'sweet_addons_woocommerce_cart_offcanvas' );
if(! function_exists('sweet_addons_woocommerce_cart_offcanvas')){
    /**
     * woocommerce cart offcanvas
     */
    function sweet_addons_woocommerce_cart_offcanvas() {
        if ( class_exists( 'WooCommerce' ) ) {
            $cart = WC()->cart;
            ?>
                <div class="offcanvas offcanvas-end" id="offcanvasCart">
                    <div class="offcanvas-header">
                        <a class="close text-danger" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                            </svg>
                        </a>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="list-group rounded-0">
                            <?php foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
                                $_product = $cart_item['data'];
                                if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                                    $product_price = get_theme_mod( 'woocommerce_tax_display_cart' ) == 'excl' ? wc_get_price_excluding_tax( $_product ) : wc_get_price_including_tax( $_product );
                                    ?>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-3 px-1">
                                                <?php echo $_product->get_image(); ?>
                                            </div>
                                            <div class="col">
                                                <?php echo $_product->get_name(); ?><br>
                                                <?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                }
                            } ?>
                        </ul>
                    </div>
                    <div class="offcanvas-footer">
                        <div class="d-flex justify-content-between">
                            <a href="<?php echo wc_get_cart_url(); ?>" class="btn btn-primary rounded-0 w-50 text-center">
                                <?php _e( 'View Cart', 'sweet-addons' ); ?>
                            </a>
                            <a href="<?php echo wc_get_checkout_url(); ?>" class="btn btn-dark rounded-0 w-50 text-center">
                                <?php _e( 'Checkout', 'sweet-addons' ); ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php
        }
    }
}

add_filter( 'woocommerce_add_to_cart_fragments', 'wc_refresh_mini_cart_count');
if(! function_exists('wc_refresh_mini_cart_count')){
    /**
     * woocommerce mini cart count
     */
    function wc_refresh_mini_cart_count( $fragments ) {
        ob_start();
        ?>
        <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        <?php
        $fragments['.cart-count'] = ob_get_clean();
        return $fragments;
    }
}

// run get_theme_mod('header_script')
add_action( 'wp_head', 'sweet_addons_header_script' );
if(! function_exists('sweet_addons_header_script')){
    /**
     * custom code header script
     */
    function sweet_addons_header_script() {
        echo get_theme_mod('header_script');
    }
}

// run get_theme_mod('footer_script')
add_action( 'wp_footer', 'sweet_addons_footer_script' );
if(! function_exists('sweet_addons_footer_script')){
    /**
     * custom code footer script
     */
    function sweet_addons_footer_script() {
        echo get_theme_mod('footer_script');
    }
}

add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );
if(! function_exists('filter_plugin_updates')){
    /**
     * filter plugin updates
     */
    function filter_plugin_updates( $value ) {
        if(get_theme_mod('plugin_update') == '1'){
            unset( $value->response['bb-plugin/fl-builder.php'] );
            unset( $value->response['bb-theme-builder/bb-theme-builder.php'] );
        }
        return $value;
    }
}

// add woocommerce share buttons
add_action( 'woocommerce_share', 'sweet_addons_woocommerce_share' );
if(! function_exists('sweet_addons_woocommerce_share')){
    /**
     * woocommerce share buttons
     */
    function sweet_addons_woocommerce_share() {
        if ( class_exists( 'WooCommerce' ) ) {
            $url = urlencode( get_permalink() );
            $title = urlencode( get_the_title() );
            $twitter_url = 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url.'&amp;via='.get_bloginfo( 'name' );
            $facebook_url = 'https://www.facebook.com/sharer/sharer.php?u='.$url;
            $linkedin_url = 'https://www.linkedin.com/shareArticle?mini=true&url='.$url.'&amp;title='.$title;
            $pinterest_url = 'https://pinterest.com/pin/create/button/?url='.$url.'&amp;media='.wp_get_attachment_url( get_post_thumbnail_id() ).'&amp;description='.$title;
            $whatsapp_url = 'whatsapp://send?text='.$title.' '.$url;

            ?>
            <div class="social-share pt-3">
                Share:
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="<?php echo $twitter_url; ?>" target="_blank" class="social-share-twitter">
                            <i class="fa fa-twitter"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="<?php echo $facebook_url; ?>" target="_blank" class="social-share-facebook">
                            <i class="fa fa-facebook"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="<?php echo $linkedin_url; ?>" target="_blank" class="social-share-linkedin">
                            <i class="fa fa-linkedin"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="<?php echo $pinterest_url; ?>" target="_blank" class="social-share-pinterest">
                            <i class="fa fa-pinterest"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="<?php echo $whatsapp_url; ?>" target="_blank" class="social-share-whatsapp">
                            <i class="fa fa-whatsapp"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <?php
        }
    }
}

add_action('init', 'sweet_addons_disable_comments');
if(! function_exists('sweet_addons_disable_comments')){
    function sweet_addons_disable_comments() {
        $scroll_to_top_enable = get_theme_mod( 'scroll_to_top_enable', 1 );
        if($scroll_to_top_enable == 1){
            // Remove comment support from post types
            $post_types = get_post_types();
            foreach ($post_types as $post_type) {
                if (post_type_supports($post_type, 'comments')) {
                    remove_post_type_support($post_type, 'comments');
                    remove_post_type_support($post_type, 'trackbacks');
                }
            }
            
            // Close comments on existing posts
            $comments_query = new WP_Query(array('post_type' => 'any', 'posts_per_page' => -1));
            while ($comments_query->have_posts()) {
                $comments_query->the_post();
                if (comments_open()) {
                    comments_open(false);
                    pings_open(false);
                    update_post_meta(get_the_ID(), '_close_comments_for_old_posts', 'yes');
                }
            }
            
            // Hide existing comments
            add_filter('comments_open', '__return_false', 20, 2);
            add_filter('pings_open', '__return_false', 20, 2);
            add_filter('comments_array', '__return_empty_array', 10, 2);
            
            // Disable comment-related REST API endpoints
            add_filter('rest_endpoints', function ($endpoints) {
                if (isset($endpoints['/wp/v2/comments'])) {
                    unset($endpoints['/wp/v2/comments']);
                }
                if (isset($endpoints['/wp/v2/comments/(?P<id>[\d]+)'])) {
                    unset($endpoints['/wp/v2/comments/(?P<id>[\d]+)']);
                }
                return $endpoints;
            });
            
            // Remove comment-related links from REST API
            add_filter('rest_comment_collection_params', function ($params) {
                unset($params['status']);
                return $params;
            });
            add_filter('rest_comment_query', function ($args) {
                unset($args['status']);
                return $args;
            });
            
            // Remove comment-reply script for front-end
            add_action('wp_enqueue_scripts', function () {
                wp_dequeue_script('comment-reply');
            });
            
            // Remove comment-reply link from the header
            add_action('wp_head', function () {
                if (is_singular() && comments_open()) {
                    wp_deregister_script('comment-reply');
                }
            }, 1);
            
            // Remove comment-related widgets
            add_action('widgets_init', function () {
                unregister_widget('WP_Widget_Recent_Comments');
                unregister_widget('WP_Widget_Recent_Comments_Custom');
                unregister_widget('WP_Widget_Comments');
                unregister_widget('WP_Widget_Comments_Custom');
                unregister_widget('WP_Widget_Pages');
                unregister_widget('WP_Widget_Calendar');
            });
            
            // Remove comments menu from admin menu
            add_action('admin_menu', function () {
                remove_menu_page('edit-comments.php');
            });
            
            // Remove comments meta box from post and page editor
            add_action('admin_init', function () {
                remove_meta_box('commentsdiv', 'post', 'normal');
                remove_meta_box('commentsdiv', 'page', 'normal');
            });
            
            // Remove comments column from posts and pages list
            add_filter('manage_posts_columns', function ($columns) {
                unset($columns['comments']);
                return $columns;
            });
            add_filter('manage_pages_columns', function ($columns) {
                unset($columns['comments']);
                return $columns;
            });
        }
    }
}