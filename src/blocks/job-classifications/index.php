<?php
/**
 * Server-side rendering of the `hrswpsqlsrv/job-classifications` block.
 *
 * @package HRSWP_Sqlsrv_DB
 * @since 0.4.0
 */

namespace HRSWP\SQLSRV\job_classifications;
use HRSWP\SQLSRV\MSSQL_Query;
use HRSWP\SQLSRV\API;

/**
 * Generates reader-friendly data type names.
 *
 * @since 0.4.0
 *
 * @param string $data_name The database column name.
 * @return string The reader-friendly column name for display.
 */
function filter_data_name( $data_name ) {
	if ( 'ClassCode' === $data_name ) {
		return __( 'Job Class' );
	}
	if ( 'JobGroupCode' === $data_name ) {
		return __( 'Job Group' );
	}
	if ( 'JobTitle' === $data_name ) {
		return __( 'Job Title' );
	}
	if ( 'SalrangeWExceptions' === $data_name ) {
		return __( 'Range' );
	}
	if ( 'Salary_Min' === $data_name ) {
		return __( 'Salary Min' );
	}
	if ( 'Salary_Max' === $data_name ) {
		return __( 'Salary Max' );
	}

	return $data_name;
}

/**
 * Renders the `hrswpsqlsrv/job-classifications` dynamic block contents.
 *
 * Displays the job classificaiton data for whichever data source has been selected.
 *
 * @since 0.4.0
 *
 * @param array $attributes The block attributes passed from `register_block_type`.
 * @return string The formatted HTML to display.
 */
function render( $attributes ) {
	$args = array(
		'dataset' => array(
			array(
				'table'  => sanitize_key( $attributes['queryTable'] ),
				'fields' => array(
					'ClassCode',
					'JobGroupCode',
					'JobTitle',
					'SalRangeNum',
					'SalrangeWExceptions',
					'Salary_Min',
					'Salary_Max',
				),
			),
		),
		'orderby' => 'JobTitle',
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
				__( 'Search' ),
				esc_attr( absint( $attributes['searchKey'] ) )
			);
		}
	}

	$classes = implode( ' ', $classes );

	// List layout output.
	if ( false !== strpos( $classes, 'is-style-list' ) ) {
		$list = '';
		foreach ( $data as $row ) {
			$list_item = '';
			foreach ( $row as $key => $value ) {
				// Build the display value.
				switch ( strtolower( $key ) ) {
					case 'jobtitle':
						$title   = esc_html( $value );
						$display = 'no_display_value';
						break;
					case 'salrangenum':
						$display = 'no_display_value';
						break;
					case 'salrangewexceptions':
						$display = sprintf(
							'<a href="/testing-external-content-shortcodes/salary-grid-table/?filter=%1$s">%2$s</a>',
							esc_attr( $row->SalRangeNum ), // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
							esc_html( $value )
						);
						break;
					case 'salary_min':
					case 'salary_max':
						$display = '$' . esc_html( number_format( $value ) );
						break;
					default:
						$display = esc_html( $value );
						break;
				}

				if ( 'no_display_value' !== $display ) {
					$list_item .= sprintf(
						'<li data-column="%1$s">%2$s: %3$s</li>',
						esc_attr( filter_data_name( $key ) ),
						esc_html( filter_data_name( $key ) ),
						$display
					);
				}
			}

			$list .= sprintf(
				'<div class="wp-block-column"><h2>%1$s</h2><ul>%2$s</ul></div>',
				esc_html( $title ),
				$list_item
			);

		}

		return sprintf(
			'<div class="hrswp-sqlsrv-block wp-block-columns %1$s">%2$s</div>',
			esc_attr( $classes ),
			$list
		);
	}

	// Table layout output.
	$table_head = '<tr>';
	foreach ( $data[0] as $key => $value ) {
		if ( 'salrangenum' !== strtolower( $key ) ) {
			$key         = filter_data_name( $key );
			$table_head .= "<th>{$key}</th>";
		}
	}
	$table_head .= '</tr>';

	foreach ( $data as $row ) {
		$table_body .= '<tr>';

		foreach ( $row as $key => $value ) {
			// Build the display value.
			switch ( strtolower( $key ) ) {
				case 'salrangenum':
					$display = 'no_display_value';
					break;
				case 'salrangewexceptions':
					$display = sprintf(
						'<a href="/testing-external-content-shortcodes/salary-grid-table/?filter=%1$s">%2$s</a>',
						esc_attr( $row->SalRangeNum ), // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
						esc_html( $value )
					);
					break;
				case 'salary_min':
				case 'salary_max':
					$display = '$' . esc_html( number_format( $value ) );
					break;
				default:
					$display = esc_html( $value );
					break;
			}

			if ( 'no_display_value' !== $display ) {
				$table_body .= sprintf(
					'<td data-column="%1$s">%2$s</td>',
					esc_attr( filter_data_name( $key ) ),
					$display
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
 * Registers the `hrswpsqlsrv/job-classifications` block on the server.
 *
 * @since 0.4.0
 */
function register_block_job_classifications() {
	register_block_type(
		'hrswpsqlsrv/job-classifications',
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

	// Start the API for the job classifications block.
	$api = new API\API();
}
// Use later priority to make sure required resources are ready.
add_action( 'init', __NAMESPACE__ . '\register_block_job_classifications', 25 );
