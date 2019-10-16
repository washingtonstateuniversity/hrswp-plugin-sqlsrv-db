<?php
/**
 * Server-side rendering of the `hrswpsqlsrv/salary-grid` block.
 *
 * @package HRSWP_Sqlsrv_DB
 * @since 0.2.0
 */

namespace HRSWP\SQLSRV\salary_grid;
use HRSWP\SQLSRV\MSSQL_Query;
use HRSWP\SQLSRV\API;

/**
 * Renders the `hrswpsqlsrv/salary-grid` dynamic block contents.
 *
 * Displays a grid of salary data for whichever data source has been selected.
 *
 * @param array $attributes The block attributes passed from `register_block_type`.
 *
 * @return string The formatted HTML to display.
 */
function render( $attributes ) {
	$args = array(
		'dataset' => array(
			array(
				'table' => sanitize_key( $attributes['queryTable'] ),
			),
		),
	);
	$data = new MSSQL_Query\MSSQL_Query( $args );
	$data = $data->records;

	if ( ! $data ) {
		return '<p>' . __( 'No data found' ) . '</p>';
	}

	// @todo Add options in block editor for:
	//   - Class: searchable [toggle control]
	//   - Class: striped    [toggle control]
	//   - Class: default||is-style-table || is-style-list [style options]
	$classes = array();
	if ( isset( $attributes['align'] ) ) {
		$classes[] = 'align' . $attributes['align'];
	}
	if ( isset( $attributes['className'] ) ) {
		$classes[] = $attributes['className'];
	}
	$classes = implode( ' ', $classes );

	$table_head = '<tr>';
	foreach ( $data[0] as $key => $value ) {
		if ( 2 > strlen( $key ) ) {
			$key = "Step {$key}";
		}
		$key = ucwords( strtolower( $key ) );
		$table_head .= "<th>{$key}</th>";
	}
	$table_head .= '</tr>';
	$table_body = '';

	return sprintf(
		/* translators: 1: The table head section, 2: The table body section filled with numbers. */
		__( '<table class="tablepress striped searchable %1$s"><thead>%2$s</thead><tbody>%3$s</tbody></table>', 'hrs-wsu-edu' ),
		esc_attr( $classes ),
		$table_head,
		$table_body,
	);


	/*
	 *
	 *
	 * *** START THE OLD WAY ***
	 *
	 *
	 */
	$table_head = '<tr><th>Range</th>';
	foreach ( range( 'A', 'M' ) as $letter ) {
		/* translators: A letter of the alphabet. */
		$table_head .= sprintf( __( '<th>Step<br> %s</th>', 'hrs-wsu-edu' ), esc_html( $letter ) );
	}
	$table_head .= '</tr>';

	$table_body = '';

	foreach ( $data as $row ) {
		$table_body .= '<tr>';

		// Build the row output including a `data-title` attribute for the range column.
		foreach ( $row as $key => $val ) {
			if ( 'range' === strtolower( $key ) ) {
				$table_body .= sprintf(
					/* translators: 1: The table column title, 2: The range step number. */
					__( '<td data-column="%1$s" id="%2$s">%2$s</td>', 'hrs-wsu-edu' ),
					esc_attr( ucfirst( strtolower( $key ) ) ),
					esc_html( $val )
				);
			} else {
				$table_body .= sprintf(
					/* translators: 1: The table column title, 2: The salary number with a comma in the thousands place. */
					__( '<td data-column="%1$s">%2$s</td>', 'hrs-wsu-edu' ),
					esc_attr( ucfirst( strtolower( $key ) ) ),
					esc_html( number_format( $val ) )
				);
			}
		}

		$table_body .= '</tr>';
	}

	return sprintf(
		/* translators: 1: The table head section, 2: The table body section filled with numbers. */
		__( '<table class="tablepress striped searchable"><thead>%1$s</thead><tbody>%2$s</tbody></table>', 'hrs-wsu-edu' ), // phpcs:ignore WordPress.Security.EscapeOutput
		$table_head, // phpcs:ignore WordPress.Security.EscapeOutput
		$table_body, // phpcs:ignore WordPress.Security.EscapeOutput
	);
	/*
	 *
	 *
	 * *** END THE OLD WAY ***
	 *
	 *
	 */
}

/**
 * Registers the `hrswpsqlsrv/salary-grid` on the server.
 *
 * @since 0.2.0
 */
function register_block_salary_grid() {
	register_block_type(
		'hrswpsqlsrv/salary-grid',
		array(
			'attributes'      => array(
				'align'     => array(
					'type' => 'string',
					'enum' => array( 'left', 'center', 'right', 'wide', 'full' ),
				),
				'className' => array(
					'type' => 'string',
				),
				'queryTable' => array(
					'type' => 'string',
				),
			),
			'render_callback' => __NAMESPACE__ . '\render',
		)
	);

	// Start the API for the salary grid block table group list.
	$api = new API\API();
}
// Use later priority to make sure required resources are ready.
add_action( 'init', __NAMESPACE__ . '\register_block_salary_grid', 25 );
