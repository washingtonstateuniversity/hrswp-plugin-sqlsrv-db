<?php
/**
 * Server-side rendering of the `hrswpsqlsrv/list-awards` block.
 *
 * @package HRSWP_Sqlsrv_DB
 * @since 0.4.0
 */

namespace HRSWP\SQLSRV\list_awards;
use HRSWP\SQLSRV\Setup;
use HRSWP\SQLSRV\Sqlsrv_Query;
use HRSWP\SQLSRV\API;
use HRSWP\SQLSRV\Sideload_Image;

/**
 * Renders the `hrswpsqlsrv/list-awards` dynamic block contents.
 *
 * Displays the employee recognition awards data for whichever data source has been selected.
 *
 * @since 0.4.0
 *
 * @param array $attributes The block attributes passed from `register_block_type`.
 * @return string The formatted HTML to display.
 */
function render( $attributes ) {
	$classes = array();

	if ( isset( $attributes['align'] ) ) {
		$classes[] = 'align' . $attributes['align'];
	}
	if ( isset( $attributes['className'] ) ) {
		$classes[] = $attributes['className'];
	}
	if ( isset( $attributes['columns'] ) && 0 < $attributes['columns'] ) {
		$classes[] = "has-{$attributes['columns']}-columns";
	}
	if ( isset( $attributes['imageCrop'] ) && true === $attributes['imageCrop'] ) {
		$classes[] = 'is-cropped';
	}

	$classes = implode( ' ', $classes );

	// Save the data to the WP database for faster repeat access. Only run in the admin area.
	if ( is_admin() ) {
		$args = array(
			'dataset' => array(
				array(
					'table'  => 'awards',
					'fields' => array(
						'BinaryFile',
						'GroupDescription',
						'GroupName',
						'GroupYear',
					),
				),
			),
			'orderby' => 'GroupYear',
		);

		$awards = new Sqlsrv_Query\Sqlsrv_Query( $args );

		if ( ! $awards->records ) {
			return '<p>' . __( 'No data found', 'hrswp-sqlsrv-db' ) . '</p>';
		}

		$awards = $awards->records;
		foreach ( $awards as $award ) {
			// phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			$image_props = array(
				'title'          => $award->GroupName,
				'image_contents' => $award->BinaryFile,
				'group_year'     => $award->GroupYear,
				'page_id'        => get_the_ID(),
				'description'    => $award->GroupDescription,
				'skip_if_exists' => true,
			);
			// phpcs:enable

			$image = new Sideload_Image\Sideload_Image( $image_props );

			if ( is_wp_error( $image ) ) {
				return $image;
			}
		}
	}

	// Get the saved attachments.
	$attachments = get_children(
		array(
			'post_parent'    => get_the_ID(),
			'post_type'      => 'attachment',
			'posts_per_page' => -1,
			'orderby'        => 'meta_value_num',
			'meta_key'       => '_' . Setup\Setup::$slug . '_award_group',
			'order'          => 'ASC',
		)
	);

	$groups = array_values(
		array_unique(
			array_map( __NAMESPACE__ . '\get_group', $attachments )
		)
	);

	$display = '';
	foreach ( $groups as $group ) {
		$group_display = '';

		foreach ( $attachments as $attachment ) {
			$award_group = get_post_meta( $attachment->ID, '_' . Setup\Setup::$slug . '_award_group' );
			$award_group = ( '-1' === $award_group[0] ) ? 'All' : $award_group[0];

			if ( $award_group === $group ) {
				$group_display .= sprintf(
					'<div class="award-item"><figure class="wp-block-image size-small">%1$s</figure><p class="award-title">%2$s</p><p class="award-description">%3$s</p><p class="award-meta">%4$s Years</p></div>',
					wp_get_attachment_image( $attachment->ID, 'small' ),
					esc_html( $attachment->post_title ),
					$attachment->post_content,
					$award_group
				);
			}
		}

		$display .= sprintf(
			'<h2>%2$s Years</h2><div class="%1$s-year-group awards-list">%3$s</a></div>',
			strtolower( esc_attr( $group ) ),
			esc_html( $group ),
			$group_display
		);
	}

	return sprintf(
		'<div class="hrswp-sqlsrv-block %1$s">%2$s</div>',
		esc_attr( $classes ),
		$display
	);
}

/**
 * Retrieves a group name for a given attachment.
 *
 * @since 0.4.0
 *
 * @param WP_Post $attachment An attachment WP_Post object.
 * @return string The '_hrswp_sqlsrv_db_award_group' meta data value.
 */
function get_group( $attachment ) {
	$group = get_post_meta( $attachment->ID, '_' . Setup\Setup::$slug . '_award_group' );

	if ( '-1' !== $group[0] ) {
		return implode( '', $group );
	} else {
		return 'All';
	}
}

/**
 * Registers the `hrswpsqlsrv/list-awards` block on the server.
 *
 * @since 0.4.0
 */
function register_block_list_awards() {
	register_block_type(
		'hrswpsqlsrv/list-awards',
		array(
			'attributes'      => array(
				'align'      => array(
					'type' => 'string',
					'enum' => array( 'left', 'center', 'right', 'wide', 'full' ),
				),
				'columns'    => array(
					'type'    => 'number',
					'default' => 3,
				),
				'className'  => array(
					'type' => 'string',
				),
				'imageCrop'  => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'queryTable' => array(
					'type' => 'string',
				),
			),
			'render_callback' => __NAMESPACE__ . '\render',
		)
	);

	// Start the API for the job classifications block.
	new API\API();
}
// Use later priority to make sure required resources are ready.
add_action( 'init', __NAMESPACE__ . '\register_block_list_awards', 25 );
