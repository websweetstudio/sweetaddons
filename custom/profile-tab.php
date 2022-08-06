<?php
/**
 * Sweetaddon functions
 *
 * @package Sweetaddon
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// You could set the default privacy for custom tab and disable to change the tab privacy settings in admin menu.
/*
* There are values for 'default_privacy' atribute
* 0 - Anyone,
* 1 - Guests only,
* 2 - Members only,
* 3 - Only the owner
*/
// Filter
function um_dokumen_add_tab( $tabs ) {
	$tabs['dokumen'] = array(
		'name' 				=> 'Dokumen',
		'icon' 				=> 'um-icon-document',
		'default_privacy'   => 3,
        'custom'            => true 
	);
	return $tabs;
}
add_filter( 'um_profile_tabs', 'um_dokumen_add_tab', 1000 );

/**
 * Check an ability to view tab
 *
 * @param $tabs
 *
 * @return mixed
 */
function um_dokumen_add_tab_visibility( $tabs ) {
	if ( empty( $tabs['dokumen'] ) ) {
		return $tabs;
	}

	$user_id = um_profile_id();

	// if ( ! user_can( $user_id, '{here some capability which you need to check}' ) ) {
	// 	unset( $tabs['dokumen'] );
	// }

	return $tabs;
}
add_filter( 'um_user_profile_tabs', 'um_dokumen_add_tab_visibility', 2000, 1 );

// Action
function um_profile_content_dokumen_default( $args ) {
    $user_id = um_profile_id();
	$title = isset( $_GET['nama-file'] ) ? $_GET['nama-file'] : '';
	$attachment_id = '';

	function upload_user_file( $file = array() ) {
		require_once( ABSPATH . 'wp-admin/includes/admin.php' );
		  $file_return = wp_handle_upload( $file, array('test_form' => false ) );
		  if( isset( $file_return['error'] ) || isset( $file_return['upload_error_handler'] ) ) {
			  return false;
		  } else {
			  $filename = $file_return['file'];
			  $attachment = array(
				  'post_mime_type' => $file_return['type'],
				  'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
				  'post_content' => '',
				  'post_status' => 'inherit',
				  'guid' => $file_return['url']
			  );
			  $attachment_id = wp_insert_attachment( $attachment, $file_return['url'] );
			  require_once(ABSPATH . 'wp-admin/includes/image.php');
			  $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
			  wp_update_attachment_metadata( $attachment_id, $attachment_data );
			  if( 0 < intval( $attachment_id ) ) {
				return $attachment_id;
			  }
		  }
		  return false;
	}

	if( ! empty( $_FILES ) ) {
		
		// add to post type document
		$post_id = wp_insert_post( array(
			'post_title' => $title,
			'post_content' => '',
			'post_status' => 'private',
			'post_type' => 'document',
			'post_author' => $user_id,
			'post_parent' => 0
		) );
		if( ! empty( $attachment_id ) ) {
			add_post_meta( $post_id, '_wp_attached_file', $attachment_id );
		}

		foreach( $_FILES as $file ) {
			if( is_array( $file ) ) {
			$attachment_id = upload_user_file( $file );
			}
		}
	}


	?>
    <form method="post" action="" enctype="multipart/form-data">
		<div class="mb-3">
			<label for="nama-file" class="form-label">Nama File</label>
			<input name="nama-file" class="form-control" type="text" id="nama-file" placeholder="Nama File">
		</div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Default file input example</label>
            <input name="file-pdf" class="form-control" type="file" id="formFile">
        </div>
        <div class="um-field">
            <button class="btn btn-primary" type="submit">Submit</button>
        </div>
    <?php
}
add_action( 'um_profile_content_dokumen_default', 'um_profile_content_dokumen_default' );