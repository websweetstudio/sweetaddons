<?php
/**
 * WordPress Image Resizer
 *
 * @version  2014-11-14
 * @author   Frank Bueltge <frank@bueltge.de>
 */

if ( ! function_exists( 'wp_img_resizer_src' ) ) {

	/**
	 * Retrieve an image to represent an url on the fly
	 *
	 * @param  array $args Array with
	 *                     url    => path to the image
	 *                     width  => Optional, Width of image result, Use on default the settings values
	 *                     height => Optional, Height of image
	 *                     crop   => Optional, Whether to crop image or resize. | default is FALSE
	 *                     retina => Optional boolean for creating images that are double the width and height. | default is FALSE
	 *                     single => Optional, true for single url on return $image, false for Array | default is TRUE
	 *
	 * @return array|string $image Array with url, width, height
	 */
	function wp_img_resizer_src( $args = array() ) {

		// conditions to cancel the function
		if ( empty( $args[ 'url' ] ) ) {
			return new WP_Error( 'no_image_url', __( 'No image URL has been entered.' ), $args[ 'url' ] );
		}

		if ( FALSE === strpos( $args[ 'url' ], home_url() ) ) {
			return new WP_Error( 'wrong_url', __( 'Image is not on the home url.' ), $args[ 'url' ] );
		}

		// set defaults
		$defaults = array(
			'url'    => FALSE,
			'width'  => FALSE,
			'height' => NULL,
			'crop'   => NULL,
			'retina' => FALSE,
			'single' => TRUE
		);

		// set a filter for custom settings via plugin
		$args = wp_parse_args(
			$args,
			apply_filters( 'wp_img_resizer_args', $defaults )
		);

		// Allow for different retina sizes
		$args[ 'retina' ] = $args[ 'retina' ] ? ( $args[ 'retina' ] === TRUE ? 2 : $args[ 'retina' ] ) : 1;

		// validate inputs, set to integer
		$args[ 'width' ]  = intval( $args[ 'width' ] * $args[ 'retina' ] );
		$args[ 'height' ] = intval( $args[ 'height' ] * $args[ 'retina' ] );

		// set var for original image
		$original = array(
			'width',
			'height'
		);

		// set var for the noun, the result of new image
		$noun = array(
			'width',
			'height',
			'url',
			'file',
			'path'
		);

		/**
		 * define upload path & dir
		 *
		 * wp_upload_dir -- On success, the returned array will have many indices:
		 * 'path'    - base directory and sub directory or full path to upload directory.
		 * 'url'     - base url and sub directory or absolute URL to upload directory.
		 * 'subdir'  - sub directory if uploads use year/month folders option is on.
		 * 'basedir' - path without subdir.
		 * 'baseurl' - URL path without subdir.
		 * 'error'   - set to false.
		 */
		$upload_info = wp_upload_dir();
		$upload_dir  = $upload_info[ 'basedir' ];
		$upload_url  = $upload_info[ 'baseurl' ];

		// check if image url is local
		if ( FALSE === strpos( $args[ 'url' ], home_url() ) ) {
			return new WP_Error( 'wrong_url', __( 'Image is not on the home url.' ), $args[ 'url' ] );
		}

		// define path of image
		$rel_path = str_replace( $upload_url, '', $args[ 'url' ] );
		$img_path = $upload_dir . $rel_path;

		// check if img path exists, and is an image indeed
		if ( ! file_exists( $img_path ) || ! getimagesize( $img_path ) ) {
			return FALSE;
		}

		// get image info
		$info = pathinfo( $img_path );
		$ext  = $info[ 'extension' ];
		list( $original[ 'width' ], $original[ 'height' ] ) = getimagesize( $img_path );

		// get image size after cropping
		$dimensions       = image_resize_dimensions(
			$original[ 'width' ], $original[ 'height' ],
			$args[ 'width' ], $args[ 'height' ], $args[ 'crop' ]
		);
		$noun[ 'weight' ] = $dimensions[ 4 ];
		$noun[ 'height' ] = $dimensions[ 5 ];

		// use this to check if cropped image already exists, so we can return that instead
		$suffix         = "{$noun['weight']}x{$noun['height']}";
		$noun[ 'path' ] = str_replace( '.' . $ext, '', $rel_path );
		$noun[ 'file' ] = "{$upload_dir}{$noun['path']}-{$suffix}.{$ext}";

		// if orig size is smaller
		if ( $args[ 'width' ] >= $original[ 'width' ] ) {

			if ( ! $noun[ 'height' ] ) {
				// can't resize, so return original url
				$noun[ 'url' ]    = $args[ 'url' ];
				$noun[ 'weight' ] = $original[ 'width' ];
				$noun[ 'height' ] = $original[ 'height' ];

			} else {
				//else check if cache exists
				if ( file_exists( $noun[ 'file' ] ) && getimagesize( $noun[ 'file' ] ) ) {
					$noun[ 'url' ] = "{$upload_url}{$noun['path']}-{$suffix}.{$ext}";
				} else { // else resize and return the new resized image url
					$image = wp_get_image_editor( $img_path );
					if ( ! is_wp_error( $image ) ) {
						$image->resize( $args[ 'width' ], $args[ 'height' ], $args[ 'crop' ] );
						//$resized_img_path = WP_Image_Editor::resize( $img_path, $args['width'], $args['height'], $args['crop'] );
					}

					$resized_rel_path = str_replace( $upload_dir, '', $img_path );
					$noun[ 'url' ]    = $upload_url . $resized_rel_path;
				}

			}

		} else if (
			file_exists( $noun[ 'file' ] ) && getimagesize( $noun[ 'file' ] )
		) { // else check if cache exists
			$noun[ 'url' ] = "{$upload_url}{$noun['path']}-{$suffix}.{$ext}";
		} else { // else, we resize the image and return the new resized image url
			$image = wp_get_image_editor( $img_path );
			if ( ! is_wp_error( $image ) ) {
				$image->resize( $args[ 'width' ], $args[ 'height' ], $args[ 'crop' ] );
				//$resized_img_path = WP_Image_Editor::resize( $img_path, $args['width'], $args['height'], $args['crop'] );
			}

			$resized_rel_path = str_replace( $upload_dir, '', $img_path );
			$noun[ 'url' ]    = $upload_url . $resized_rel_path;
		}

		// return the output
		if ( $args[ 'single' ] ) {
			//str return
			$image = $noun[ 'url' ];
		} else {
			//array return
			$image = array(
				0 => $noun[ 'url' ],
				1 => $noun[ 'weight' ],
				2 => $noun[ 'height' ]
			);
		}

		return $image;
	} // end function

} // end if function exists

if ( ! function_exists( 'wp_img_resizer' ) ) {

	/**
	 * Get an HTML img element representing an image url
	 *
	 * @param Array|string $args Array with
	 *                           url    => path to the image
	 *                           width  => Optional, the width of image | default is the settings of WP
	 *                           height => Optional
	 *                           crop   => Optional, Whether to crop image or resize. | default is FALSE
	 *                           retina => Optional boolean for creating images that are double the width and height. | default is FALSE
	 *                           single => Optional, true for single url on return $image, false for Array | default is TRUE
	 *                           echo   => Optional, true for echo the html, false for an return | default is true
	 * @param Array|string $attr Array for attributes of html in img-tag
	 *                           src    =>
	 *                           class  =>
	 *                           alt    =>
	 *                           title  =>
	 *
	 * @return string $image Array with url, width, height
	 */
	function wp_img_resizer( $args = '', $attr = '' ) {

		// conditions to cancel the function
		if ( empty( $args[ 'url' ] ) ) {
			return new WP_Error( 'no_image_url', __( 'No image URL has been entered.' ), $args[ 'url' ] );
		}

		if ( FALSE === strpos( $args[ 'url' ], home_url() ) ) {
			return new WP_Error( 'wrong_url', __( 'Image is not on the home url.' ), $args[ 'url' ] );
		}

		// set to get an array
		if ( ! isset( $args[ 'single' ] ) ) {
			$args[ 'single' ] = FALSE;
		}
		// set for an default echo if img tag
		if ( ! isset( $args[ 'echo' ] ) ) {
			$args[ 'echo' ] = TRUE;
		}

		$image = wp_img_resizer_src( $args );

		if ( ! $image ) {
			return FALSE;
		}

		list( $image[ 0 ], $image[ 1 ], $image[ 2 ] ) = $image;
		$hwstring = image_hwstring( $image[ 1 ], $image[ 2 ] );

		// set defaults
		$default_attr = array(
			'src'   => $image[ 0 ],
			'class' => "attachment-{$image[1]}x{$image[2]}",
			'alt'   => trim(
				strip_tags(
					get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', TRUE )
				)
			), // Use Alt field first
			'title' => trim( strip_tags( get_the_title() ) ),
		);

		if ( empty( $default_attr[ 'alt' ] ) ) {
			$default_attr[ 'alt' ] = trim( strip_tags( get_the_excerpt() ) );
		} // If not, Use the Caption
		if ( empty( $default_attr[ 'alt' ] ) ) {
			$default_attr[ 'alt' ] = trim( strip_tags( get_the_title() ) );
		} // Finally, use the title

		$attr = wp_parse_args( $attr, $default_attr );
		$attr = array_map( 'esc_attr', $attr );
		// build img-Tag with attributes
		$html = rtrim( '<img ' . $hwstring );
		foreach ( $attr as $name => $value ) {
			$html .= ' ' . $name . '=' . '"' . $value . '"';
		}
		$html .= ' />';

		if ( $args[ 'echo' ] ) {
			echo $html;
		}
		
		return $html;
	}

} // end if function exists


if ( ! function_exists( 'aq_resize' ) ) {

    /**
     * Aqua Resizer
     *
     * @param string $url    - (required) must be uploaded using wp media uploader
     * @param int    $width  - (required)
     * @param int    $height - (optional)
     * @param bool   $crop   - (optional) default to soft crop
     * @param bool   $retina - (optional) default to no double of width and height
     * @param bool   $single - (optional) returns an array if false
     *
     * @return array|string|WP_Error
     */
    function aq_resize( $url, $width = NULL, $height = NULL, $crop = NULL, $retina = FALSE, $single = TRUE ) {
        
        // get error message
        if ( empty( $url ) )
            return new WP_Error( 'no_image_url', __( 'No image URL has been entered.' ), $url );
        
        // use settings of WordPress
        if ( empty( $width ) )
            $width = get_option( 'thumbnail_size_w' );
        
        $args = array(
            'url'    => $url,
            'width'  => $width,
            'height' => $height,
            'crop'   => $crop,
            'retina' => $retina,
            'single' => $single
        );
        
        return wp_img_resizer_src( $args );
    }
    
} // end if function_exists