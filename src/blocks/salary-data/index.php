<?php
/**
 * Server-side rendering of the `hrswpsqlsrv/salary-data` block.
 *
 * @package HRSWP_Sqlsrv_DB
 * @since 0.2.0
 */

namespace HRSWP\SQLSRV\salary_data;
use HRSWP\SQLSRV\Sqlsrv_Query;
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
				'table' => isset( $attributes['queryTable'] ) ? sanitize_key( $attributes['queryTable'] ) : '',
			),
		),
	);

	if ( '' === $args['dataset'][0]['table'] ) {
		return '<p></p>';
	}

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
					$value = ( is_string( $value ) && ! is_numeric( trim( $value ) ) )
						? $value
						: number_format( (int) $value );
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
			'<div class="hrswp-sqlsrv-block %1$s"><div class="wp-block-columns">%2$s</div></div>',
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

	// The "Nurses" salary data needs supplemental "Years of experience" data inserted.
	if ( strstr( $attributes['queryTable'], 'nurses' ) ) {
		$table_head .= nurses_years_experience_row( $attributes['queryTable'] );
	}

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
				$value = ( is_string( $val ) && ! is_numeric( trim( $val ) ) )
					? $val
					: number_format( (int) $val );

				$table_body .= sprintf(
					'<td data-column="%1$s">%2$s</td>',
					esc_attr( ucfirst( strtolower( $key ) ) ),
					esc_html( $value )
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
 * Generates a years of experience row for the four Nurses tables.
 *
 * The Nurses data from the database is missing a required "years of experience" header row, so
 * we need to add it manually. It is different for all four tables.
 *
 * @since 0.4.0
 *
 * @param string $query_table The name of the table being queried.
 * @return string The formatted HTML table row with the years of experience data.
 */
function nurses_years_experience_row( $query_table ) {
	$experience_row = '<tr><th><abbr title="' . __( 'Years of experience', 'hrswp-sqlsrv-db' ) . '">YRSx</abbr></th>';

	// Nurses Group A, Steps A-M.
	if ( strstr( $query_table, 'nurses-a-am' ) ) {
		foreach ( range( 'A', 'M' ) as $letter ) {
			switch ( $letter ) {
				case 'E':
					$years = '0';
					break;
				case 'G':
					$years = '1';
					break;
				case 'I':
					$years = '2';
					break;
				case 'K':
					$years = '3';
					break;
				case 'L':
					$years = '4';
					break;
				case 'M':
					$years = '5';
					break;
				default:
					$years = '';
					break;
			}

			$experience_row .= "<th>{$years}</th>";
		}
	}

	// Nurses Group A, Steps N-U.
	if ( strstr( $query_table, 'nurses-a-nu' ) ) {
		foreach ( range( 'N', 'U' ) as $letter ) {
			switch ( $letter ) {
				case 'N':
					$years = '6';
					break;
				case 'O':
					$years = '7';
					break;
				case 'P':
					$years = '8';
					break;
				case 'Q':
					$years = '12';
					break;
				case 'R':
					$years = '15';
					break;
				case 'S':
					$years = '18';
					break;
				case 'T':
					$years = '20';
					break;
				case 'U':
					$years = '26';
					break;
				default:
					$years = '';
					break;
			}

			$experience_row .= "<th>{$years}</th>";
		}
	}

	// Nurses Group B, Steps A-M.
	if ( strstr( $query_table, 'nurses-b-am' ) ) {
		foreach ( range( 'A', 'M' ) as $letter ) {
			switch ( $letter ) {
				case 'A':
					$years = '0';
					break;
				case 'C':
					$years = '1';
					break;
				case 'E':
					$years = '2';
					break;
				case 'G':
					$years = '3';
					break;
				case 'I':
					$years = '4';
					break;
				case 'K':
					$years = '5';
					break;
				case 'L':
					$years = '6';
					break;
				case 'M':
					$years = '7';
					break;
				default:
					$years = '';
					break;
			}

			$experience_row .= "<th>{$years}</th>";
		}
	}

	// Nurses Group B, Steps N-U.
	if ( strstr( $query_table, 'nurses-b-nu' ) ) {
		foreach ( range( 'N', 'U' ) as $letter ) {
			switch ( $letter ) {
				case 'N':
					$years = '8';
					break;
				case 'O':
					$years = '9';
					break;
				case 'P':
					$years = '10';
					break;
				case 'Q':
					$years = '12';
					break;
				case 'R':
					$years = '15';
					break;
				case 'S':
					$years = '18';
					break;
				case 'T':
					$years = '20';
					break;
				case 'U':
					$years = '26';
					break;
				default:
					$years = '';
					break;
			}

			$experience_row .= "<th>{$years}</th>";
		}
	}

	$experience_row .= '</tr>';

	return $experience_row;
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
				'isStriped'  => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'queryTable' => array(
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
