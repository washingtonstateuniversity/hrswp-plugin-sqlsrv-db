<?php
/**
 * HRSWP Sqlsrv DB Sideload Image: Sideload_Image class
 *
 * @package HRSWP_Sqlsrv_DB
 * @since 0.4.0
 */

namespace HRSWP\SQLSRV\Sideload_Image;
use HRSWP\SQLSRV\Setup;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The HRSWP Image Sideload class.
 *
 * Takes an image in binary data format and handles sideloading it to the WP Uploads folder
 * and creating an attachment for it in the WP media library. Optionally can skip uploading
 * images with the same title value, to prevent creating unneeded duplicates.
 *
 * @since 0.4.0
 */
class Sideload_Image {
	/**
	 * The sideloaded image file info.
	 *
	 * @since 0.4.0
	 *
	 * @var array||WP_Error {
	 *     Array of file information or WP_Error.
	 *
	 *     @type string $mime        The file mime type.
	 *     @type string $ext         The file extention.
	 *     @type string $filename    The sanitized file name with extension (@see sanitize_file_name()).
	 *     @type string $title       The sanitized file title metadata (@see esc_html()).
	 *     @type string $description A sanitized textual description of the image (@see wp_kses()).
	 *     @type string $group_year  The sanitized group year assigned to the image (@see esc_html()).
	 * }
	 */
	protected $fileinfo = array();

	/**
	 * The sideloaded image file attributes.
	 *
	 * @since 0.4.0
	 *
	 * @var array {
	 *     Array of sideloaded file attributes.
	 *
	 *     @type string      $file  Full path to the newly sideloaded file.
	 *     @type string      $url   URL of the sideloaded file.
	 *     @type string      $type  The sideloaded file type.
	 *     @type bool|string $error False if successful, error message string if something fails.
	 * }
	 */
	public $image = array();

	/**
	 * The sideloaded image attachment attributes.
	 *
	 * @since 0.4.0
	 *
	 * @var array {
	 *     Array of sideloaded attachment attributes.
	 *
	 *     @type int    $id        The attachment ID.
	 *     @type string $title     The attachment title.
	 *     @type int    $parent_id The attachment post parent. Default is none (0).
	 * }
	 */
	public $attachment = array();

	/**
	 * Initialize.
	 *
	 * @since 0.3.0
	 *
	 * @param array $props {
	 *     Properties of the image to sideload.
	 *
	 *     @type string $title          The image name.
	 *     @type string $image_contents The binary data string.
	 *     @type string $description    Optional. A textual description of the image.
	 *     @type int    $page_id        Optional. The page ID of the post/page originating the request.
	 *     @type string $group_year     Optional. The group year assigned to the image.
	 *     @type bool   $skip_if_exists Optional. Whether to skip sideloading images that already exist with the same post title. Default false.
	 * }
	 */
	public function __construct( $props ) {
		$defaults = array(
			'title'          => uniqid(),
			'image_contents' => '',
			'description'    => '',
			'group_year'     => '',
			'page_id'        => 0,
			'skip_if_exists' => false,
		);

		$args = wp_parse_args( $props, $defaults );

		if ( $args['skip_if_exists'] ) {
			$existing_attachment = $this->get_attachment_by_title( $args['title'] );

			// If the attachment already exists, populate the class property and exit early.
			if ( false !== $existing_attachment ) {
				$this->attachment = array(
					'id'        => $existing_attachment->ID,
					'title'     => $existing_attachment->post_title,
					'parent_id' => $existing_attachment->post_parent,
				);

				return;
			}
		}

		// Include the required files to access several WP admin functions.
		$this->includes();

		// Define some useful file attributes of the sideloaded file.
		$this->set_file_info( $args['image_contents'], $args['title'], $args['description'], $args['group_year'] );

		// Sideload the file and create the attachment, then populate the default alt text and award group meta.
		$this->sideload_file( $args['image_contents'], $args['page_id'] );
		update_post_meta( $this->attachment['id'], '_wp_attachment_image_alt', $this->fileinfo['description'] );
		update_post_meta( $this->attachment['id'], '_' . Setup\Setup::$slug . '_award_group', $this->fileinfo['group_year'] );
	}

	/**
	 * Includes the required files.
	 *
	 * @since 0.4.0
	 *
	 * @access private
	 */
	private function includes() {
		// The WordPress Filesystem API: Top-level functionality.
		require_once( ABSPATH . 'wp-admin/includes/file.php' );

		// All of the WordPress administration image manipulation functions.
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
	}

	/**
	 * Sets the file mime type, extension, and filename from a binary data string.
	 *
	 * Uses finfo to determine the file mime type and then checks that against the WordPress
	 * allowed mime types before fetching the appropriate file extension from the same list.
	 *
	 * @since 0.4.0
	 *
	 * @param string $image_contents The binary data string.
	 * @param string $title          The image name.
	 * @param string $description    A textual description of the image.
	 * @param string $group_year     The sanitized group year assigned to the image (@see esc_html()).
	 * @return array The file mime type and extension.
	 */
	private function set_file_info( $image_contents, $title, $description, $group_year ) {
		// Determine the mime type using the php finfo class.
		$finfo   = new \finfo( FILEINFO_MIME_TYPE );
		$mime    = $finfo->buffer( $image_contents );
		$allowed = get_allowed_mime_types();

		// Check that the sideloaded image file is an allowed type.
		if ( ! in_array( $mime, $allowed, true ) ) {
			return new \WP_Error( 'disallowed_file_type', __( 'Sorry, this file type is not permitted for security reasons.', 'hrswp-sqlsrv-db' ) );
		}

		// Retrieve the file extension from the WP allowed mime types array.
		$ext = array_search( $mime, $allowed, true );

		// Use only the first extension when multiple variants exist.
		if ( false !== strpos( $ext, '|' ) ) {
			$ext = explode( '|', $ext )[0];
		}

		$this->fileinfo = array(
			'mime'        => $mime,
			'ext'         => $ext,
			'filename'    => sanitize_file_name( strtolower( $title . '.' . $ext ) ),
			'title'       => esc_html( $title ),
			'description' => wp_kses( $description, 'user_description' ),
			'group_year'  => esc_html( $group_year ),
		);

		return $this->fileinfo;
	}

	/**
	 * Sideloads a binary image file into the WP Uploads directory and creates an attachment.
	 *
	 * @since 0.4.0
	 *
	 * @param string $image_contents The binary data string.
	 * @param int    $page_id        Optional. The page ID of the post/page originating the request.
	 * @return int The attachment ID of the newly sideloaded image.
	 */
	private function sideload_file( $image_contents, $page_id = 0 ) {
		// Sideload the file into the Uploads directory in the appropriate directory.
		$this->image = wp_upload_bits( $this->fileinfo['filename'], null, $image_contents, gmdate( 'Y/m' ) );

		$attachment = array(
			'post_mime_type' => $this->fileinfo['mime'],
			'post_title'     => $this->fileinfo['title'],
			'post_content'   => $this->fileinfo['description'],
			'post_status'    => 'inherit',
			'guid'           => $this->image['url'],
		);

		// Insert the attachment.
		$attachment_id = wp_insert_attachment( $attachment, $this->image['file'], absint( $page_id ) );

		if ( 0 === $attachment_id ) {
			return new \WP_Error( 'insert_attachment_error', __( 'There was a problem inserting a new attachment.', 'hrswp-sqlsrv-db' ) );
		}

		// Generate the attachment metadata and update the database.
		$metadata = wp_generate_attachment_metadata( $attachment_id, $this->image['file'] );
		wp_update_attachment_metadata( $attachment_id, $metadata );

		$this->attachment = array(
			'id'        => $attachment_id,
			'title'     => $attachment['post_title'],
			'parent_id' => absint( $page_id ),
		);

		return $attachment_id;
	}

	/**
	 * Retrieves an attachment by its post title value.
	 *
	 * If multiple posts match the query only the first is returned.
	 *
	 * @since 0.4.0
	 *
	 * @param string $title The attachment post title.
	 * @return WP_Post|false The attachment post object if it exists, false if not.
	 */
	private function get_attachment_by_title( $title ) {
		// Set up the query args.
		$args = array(
			'name'        => sanitize_title( $title ),
			'post_type'   => 'attachment',
			'post_status' => 'inherit',
		);

		$attachment = new \WP_Query( $args );

		if ( ! $attachment->have_posts() ) {
			return false;
		}

		return $attachment->posts[0];
	}
}
