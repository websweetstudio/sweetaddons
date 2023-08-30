<?php
//[sweet-thumbnail size="full" ratio="1-1" class="rounded" link="true"]
add_shortcode( 'sweet-thumbnail', 'sweet_thumbnail_shortcode' );
function sweet_thumbnail_shortcode( $atts ) {
    ob_start();
    $atts = shortcode_atts(
        array(
            'size' => 'full',
            'ratio' => '1x1',
            'class' => 'rounded',
            'link' => 'true',
        ),
        $atts,
        'sweet-thumbnail'
    );
    $size = isset( $atts['size'] ) ? $atts['size'] : 'full';
    $ratio = isset( $atts['ratio'] ) ? $atts['ratio'] : '1x1';
    $class = isset( $atts['class'] ) ? $atts['class'] : 'rounded';
    $link = isset( $atts['link'] ) && $atts['link'] == true ? 'href="'.get_the_permalink().'"' : '';
    $image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), $size );
    $image_url = $image_url[0];

    ?>
    <div class="sweet-thumbnail-container">
        <a class="sweet-thumbnail <?php echo esc_attr( $class ).' ratio ratio-'.$ratio; ?>" <?php echo $link; ?>>
            <img class="rounded" src="<?php echo $image_url; ?>" alt="<?php echo get_the_title(); ?>">
        </a>
    </div>
    <?php
    return ob_get_clean();
}

//[excerpt count="150"]
add_shortcode('excerpt', 'vd_getexcerpt');
function vd_getexcerpt($atts){
    ob_start();
	global $post;
    $atribut = shortcode_atts( array(
        'count'	=> '150', /// count character
    ), $atts );

    $count		= $atribut['count'];
    $excerpt	= get_the_content();
    $excerpt 	= strip_tags($excerpt);
    $excerpt 	= substr($excerpt, 0, $count);
    $excerpt 	= substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt 	= ''.$excerpt.'...';

    echo $excerpt;

	return ob_get_clean();
}