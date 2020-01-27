<?php
/**
 * Server-side rendering of the `hrswpsqlsrv/job-classifications` block.
 *
 * @package HRSWP_Sqlsrv_DB
 * @since 0.4.0
 */

namespace HRSWP\SQLSRV\job_classifications;
use HRSWP\SQLSRV\Sqlsrv_Query;
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
		return __( 'Job Class', 'hrswp-sqlsrv-db' );
	}
	if ( 'JobGroupCode' === $data_name ) {
		return __( 'Job Group', 'hrswp-sqlsrv-db' );
	}
	if ( 'JobTitle' === $data_name ) {
		return __( 'Job Title', 'hrswp-sqlsrv-db' );
	}
	if ( 'SalrangeWExceptions' === $data_name ) {
		return __( 'Range', 'hrswp-sqlsrv-db' );
	}
	if ( 'Salary_Min' === $data_name ) {
		return __( 'Salary Min', 'hrswp-sqlsrv-db' );
	}
	if ( 'Salary_Max' === $data_name ) {
		return __( 'Salary Max', 'hrswp-sqlsrv-db' );
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
	$data = new Sqlsrv_Query\Sqlsrv_Query( $args );

	if ( ! $data->records ) {
		return '<p>' . __( 'No data found', 'hrswp-sqlsrv-db' ) . '</p>';
	}

	$data = $data->records;

	$classes    = array();
	$table_body = '';

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

	$classes         = implode( ' ', $classes );
	$salary_data_url = ( isset( $attributes['salaryDataUrl'] ) ) ? $attributes['salaryDataUrl'] : '';

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
							'<a href="%1$s?filter=%2$s">%3$s</a>',
							esc_url( $salary_data_url ),
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
						'<a href="%1$s?filter=%2$s">%3$s</a>',
						esc_url( $salary_data_url ),
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
		'<div class="hrswp-sqlsrv-block %1$s"><table class="wp-block-table"><thead>%2$s</thead><tbody>%3$s</tbody></table></div>',
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
				'align'         => array(
					'type' => 'string',
					'enum' => array( 'left', 'center', 'right', 'wide', 'full' ),
				),
				'columns'       => array(
					'type' => 'number',
				),
				'className'     => array(
					'type' => 'string',
				),
				'isStriped'     => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'salaryDataUrl' => array(
					'type'    => 'string',
					'default' => '',
				),
				'queryTable'    => array(
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
add_action( 'init', __NAMESPACE__ . '\register_block_job_classifications', 25 );
