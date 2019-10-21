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

	if ( ! $data->records ) {
		return '<p>' . __( 'No data found' ) . '</p>';
	}

	$data = $data->records;

	$classes     = array();
	$search_form = '';
	$table_body  = '';

	if ( isset( $attributes['align'] ) ) {
		$classes[] = 'align' . $attributes['align'];
	}
	if ( isset( $attributes['className'] ) ) {
		$classes[] = $attributes['className'];
	}
	if ( isset( $attributes['isStriped'] ) && $attributes['isStriped'] ) {
		$classes[] = 'is-style-stripes';
	}
	if ( isset( $attributes['isSearchable'] ) && $attributes['isSearchable'] ) {
		$classes[] = 'searchable';

		if ( isset( $attributes['searchKey'] ) ) {
			$search_form = sprintf(
				'
<div class="js-search-form">
	<label for="search_table_input">
		%1$s: <input type="search" name="search_table_input" id="search_table_input" data-search-column="%2$d">
	</label>
	<div class="wp-block-button is-style-small">
		<button id="js-search-form-reset" class="wp-block-button__link" type="button">Reset</button>
	</div>
</div>
				',
				__( 'Search' ),
				esc_attr( absint( $attributes['searchKey'] ) )
			);
		}
	}

	$classes = implode( ' ', $classes );

	$table_head = '<tr>';
	foreach ( $data[0] as $key => $value ) {
		if ( 2 > strlen( $key ) ) {
			$key = "Step {$key}";
		}
		$key         = ucwords( strtolower( $key ) );
		$table_head .= "<th>{$key}</th>";
	}
	$table_head .= '</tr>';

	foreach ( $data as $row ) {
		$table_body .= '<tr>';

		// Build the row output including a `data-title` attribute for the range column.
		foreach ( $row as $key => $val ) {
			if ( 'range' === strtolower( $key ) ) {
				$table_body .= sprintf(
					'<td data-column="%1$s" id="%2$s">%2$s</td>',
					esc_attr( ucfirst( strtolower( $key ) ) ),
					esc_html( $val )
				);
			} else {
				$table_body .= sprintf(
					'<td data-column="%1$s">%2$s</td>',
					esc_attr( ucfirst( strtolower( $key ) ) ),
					esc_html( number_format( $val ) )
				);
			}
		}

		$table_body .= '</tr>';
	}

	return sprintf(
		'%1$s<table class="wp-block-table %2$s"><thead>%3$s</thead><tbody>%4$s</tbody></table>',
		$search_form,
		esc_attr( $classes ),
		$table_head,
		$table_body
	);
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
				'align'        => array(
					'type' => 'string',
					'enum' => array( 'left', 'center', 'right', 'wide', 'full' ),
				),
				'className'    => array(
					'type' => 'string',
				),
				'isSearchable' => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'isStriped'    => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'searchKey'    => array(
					'type' => 'string',
				),
				'queryTable'   => array(
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
