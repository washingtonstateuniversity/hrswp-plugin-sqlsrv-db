<?php
/**
 * Server-side rendering of the `hrswpsqlsrv/salary-data` block.
 *
 * @package HRSWP_Sqlsrv_DB
 * @since 0.2.0
 */

namespace HRSWP\SQLSRV\salary_data;
use HRSWP\SQLSRV\MSSQL_Query;
use HRSWP\SQLSRV\API;

/**
 * Renders the `hrswpsqlsrv/salary-data` dynamic block contents.
 *
 * Displays a data of salary data for whichever data source has been selected.
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
		return '<p>' . __( 'No data found', 'hrswp-sqlsrv-db' ) . '</p>';
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
	if ( isset( $attributes['columns'] ) && 0 < $attributes['columns'] ) {
		$classes[] = "has-{$attributes['columns']}-columns";
	}
	if ( isset( $attributes['isSearchable'] ) && $attributes['isSearchable'] ) {
		$classes[] = 'searchable';

		if ( isset( $attributes['searchKey'] ) ) {
			$search_form = sprintf(
				'
<div class="hrswp-sqlsrv-block search-form js-search-form">
	<label for="search_table_input">
		%1$s: <input type="search" name="search_table_input" id="search_table_input" data-search-column="%2$d">
	</label>
	<div class="wp-block-button is-style-small">
		<button id="js-search-form-reset" class="wp-block-button__link" type="button">Reset</button>
	</div>
</div>
				',
				__( 'Search', 'hrswp-sqlsrv-db' ),
				esc_attr( absint( $attributes['searchKey'] ) )
			);
		}
	}

	$classes = implode( ' ', $classes );

	// List layout output.
	if ( false !== strpos( $classes, 'is-style-list' ) ) {
		$output = '';
		foreach ( $data as $item ) {
			if ( isset( $item->RANGE ) ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
				$title = 'Range ' . $item->RANGE; // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			}
			$list = '';
			foreach ( $item as $key => $value ) {
				if ( 'RANGE' !== $key ) {
					$list .= sprintf(
						'<li>Step %1$s: %2$s</li>',
						esc_html( $key ),
						esc_html( number_format( $value ) )
					);
				}
			}

			$output .= sprintf(
				'<div class="wp-block-column"><h2>%1$s</h2><ul>%2$s</ul></div>',
				esc_html( $title ),
				$list
			);
		}

		return sprintf(
			'<div class="hrswp-sqlsrv-block wp-block-columns %1$s">%2$s</div>',
			esc_attr( $classes ),
			$output
		);
	}

	// Table layout output.
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
		'%1$s<table class="hrswp-sqlsrv-block wp-block-table %2$s"><thead>%3$s</thead><tbody>%4$s</tbody></table>',
		$search_form,
		esc_attr( $classes ),
		$table_head,
		$table_body
	);
}

/**
 * Registers the `hrswpsqlsrv/salary-data` on the server.
 *
 * @since 0.2.0
 */
function register_block_salary_data() {
	register_block_type(
		'hrswpsqlsrv/salary-data',
		array(
			'attributes'      => array(
				'align'        => array(
					'type' => 'string',
					'enum' => array( 'left', 'center', 'right', 'wide', 'full' ),
				),
				'columns'      => array(
					'type' => 'number',
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

	// Start the API for the salary data block table group list.
	new API\API();
}
// Use later priority to make sure required resources are ready.
add_action( 'init', __NAMESPACE__ . '\register_block_salary_data', 25 );
