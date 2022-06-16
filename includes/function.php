<?php
// wp add post type project
add_action( 'init', 'create_post_type_project' );
function create_post_type_project() {
    $labels = array(
        'name' => __( 'Projects' ),
        'singular_name' => __( 'Project' ),
        'add_new' => __('Add New'),
        'add_new_item' => __('Add New Project'),
        'edit_item' => __('Edit Project'),
        'new_item' => __('New Project'),
        'view_item' => __('View Project'),
        'search_items' => __('Search Project'),
        'not_found' =>  __('No project found'),
        'not_found_in_trash' => __('No project found in Trash'), 
        'parent_item_colon' => ''
    );
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'show_ui' => true, 
        'query_var' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'taxonomies'  => array( 'jenis-website' ),
        // Uncomment the following line to change the slug; 
        // You must also save your permalink structure to prevent 404 errors
        'rewrite' => array( 'slug' => 'projects' ),
        'has_archive' => true,
        'supports' => array('title','editor','thumbnail'),
        
    );
    register_post_type( 'projects' , $args );
}

// add post type Demo
function create_post_type_demo() {
    register_post_type( 'demo',
        array(
            'labels' => array(
                'name' => __( 'Pilihan Desain' ),
                'singular_name' => __( 'Pilihan Desain' )
            ),
            'public' => true,
            'has_archive' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'pilihan-desain'),
            'supports' => array('title', 'editor', 'thumbnail'),
            'taxonomies' => array('jenis-website')
        )
    );
}
add_action( 'init', 'create_post_type_demo' );

add_filter( 'rwmb_meta_boxes', 'your_prefix_register_meta_boxes' );

function your_prefix_register_meta_boxes( $meta_boxes ) {
    $prefix = '';

    $meta_boxes[] = [
        'title'      => esc_html__( 'Detail Demo', 'sweetaddon' ),
        'id'         => 'detail_demo',
        'post_types' => ['demo'],
        'context'    => 'normal',
        'fields'     => [
            [
                'type' => 'url',
                'name' => esc_html__( 'Url Live Preview', 'sweetaddon' ),
                'id'   => $prefix . 'url_live_preview',
            ],
        ],
    ];

    return $meta_boxes;
}

function jenis_website_taxonomy() {
    register_taxonomy(
        'jenis-website',
        'demo',
        array(
            'label' => __( 'Jenis Website' ),
            'rewrite' => array( 'slug' => 'jenis-website' ),
            'hierarchical' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
        )
    );
}
add_action( 'init', 'jenis_website_taxonomy' );

// add metabox url_live_preview in post type demo in admin column
add_filter( 'manage_demo_posts_columns', 'set_custom_edit_demo_columns' );
add_action( 'manage_demo_posts_custom_column', 'custom_demo_column', 10, 2 );

function set_custom_edit_demo_columns($columns) {
    $columns['url_live_preview'] = 'Url Live Preview';
    return $columns;
}

function custom_demo_column( $column, $post_id ) {
    switch ( $column ) {
        case 'url_live_preview':
            $url_live_preview = get_post_meta( $post_id, 'url_live_preview', true );
            echo $url_live_preview;
            break;
    }
}

// wp footer whatsapp floating
// https://wa.me/6287715567339
function wp_footer_whatsapp() {
    ?>
    <div class="whatsapp-floating">
        <a class="whatsapp" target="_blank" href="https://api.whatsapp.com/send?phone=6287715567339&text=Hallo%2C%20Saya%20tertarik%20untuk%20membuat%20website%20%F0%9F%99%82" target="_blank">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
            </svg>
            Chat Whatsapp
        </a>
    </div>
    <?php
}
add_action( 'wp_footer', 'wp_footer_whatsapp' );