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
 * Renders a salary data text field.
 *
 * @since 0.10.0
 *
 * @param string $name A text field.
 * @return string The sanitized text field.
 */
function render_salary_data_name( $name ) {
	return ( ! $name ) ? __( '(Untitled)', 'hrswp-sqlsrv-db' ) : esc_html( trim( $name ) );
}

/**
 * Renders the salary data salary field.
 *
 * @since 0.10.0
 *
 * @param string $number The salary data to format.
 * @return string The formatted salary data, as currency if a number, or plain text if not.
 */
function render_salary_data_currency( $number ) {
	return ( is_string( $number ) && ! is_numeric( trim( $number ) ) )
		? render_salary_data_name( $number )
		: '$' . esc_html( number_format( (int) $number ) );
}

/**
 * Renders the salary data as a table.
 *
 * @since 0.10.0
 *
 * @param array  $args Block attributes passed from the block editor.
 * @param object $salary_data The salary data from a successful Sqlsrv query.
 * @return string The salary data formatted into a table element.
 */
function render_salary_data_table( $args, $salary_data ) {
	$table_head = '<thead><tr>';
	foreach ( $salary_data[0] as $key => $value ) {
		if ( 2 > strlen( $key ) ) {
			$key = "Step {$key}";
		}
		$key         = ucwords( strtolower( $key ) );
		$table_head .= "<th>{$key}</th>";
	}
	$table_head .= '</tr>';

	// The "Nurses" salary data needs supplemental "Years of experience" data inserted.
	if ( strstr( $args['table'], 'nurses' ) ) {
		$table_head .= render_nurses_years_experience_row( $args['table'] );
	}
	$table_head .= '</thead>';

	$table_body = '<tbody>';
	foreach ( $salary_data as $salary ) {
		$table_body .= render_salary_data_row( $salary );
	}
	$table_body .= '</tbody>';

	$classname = 'wp-block-table';

	if ( '' !== $args['classname'] ) {
		$classname .= ' ' . $args['classname'];
	}

	return '<figure class="' . $classname . '"><table> ' . $table_head . $table_body . ' </table></figure>';
}

/**
 * Renders a single salary data record as a table row.
 *
 * @since 0.10.0
 *
 * @param object $salary A single salary data record.
 * @return string The salary data formatted into a list element.
 */
function render_salary_data_row( $salary ) {
	$table_row = '<tr>';
	foreach ( $salary as $key => $value ) {
		if ( 'range' === strtolower( $key ) ) {
			$table_row .= '<td>' . render_salary_data_name( $value ) . '</td>';
		} else {
			$table_row .= '<td>' . render_salary_data_currency( $value ) . '</td>';
		}
	}
	$table_row .= '</tr>';

	return $table_row;
}

/**
 * Renders a years of experience row for the four Nurses tables.
 *
 * The Nurses data from the database is missing a required "years of experience" header row, so
 * we need to add it manually. It is different for all four tables.
 *
 * @since 0.4.0
 *
 * @param string $table The name of the table being queried.
 * @return string The formatted HTML table row with the years of experience data.
 */
function render_nurses_years_experience_row( $table ) {
	$experience_row = '<tr><th><abbr title="' . __( 'Years of experience', 'hrswp-sqlsrv-db' ) . '">YRSx</abbr></th>';

	// Nurses Group A, Steps A-M.
	if ( strstr( $table, 'nurses-a-am' ) ) {
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
	if ( strstr( $table, 'nurses-a-nu' ) ) {
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
	if ( strstr( $table, 'nurses-b-am' ) ) {
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
	if ( strstr( $table, 'nurses-b-nu' ) ) {
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
 * Renders the `hrswpsqlsrv/salary-data` dynamic block contents.
 *
 * Displays a data of salary data for whichever data source has been selected.
 *
 * @since 0.4.0
 * @since 0.10.0 Reformat for WP block API v2.
 *
 * @param array $attributes The block attributes passed from `register_block_type`.
 * @return string The formatted HTML to display.
 */
function render( $attributes ) {
	$args = array(
		'table'     => isset( $attributes['queryTable'] ) ? sanitize_key( $attributes['queryTable'] ) : '',
		'align'     => isset( $attributes['align'] ) ? $attributes['align'] : '',
		'classname' => isset( $attributes['className'] ) ? $attributes['className'] : '',
	);

	if ( '' === $args['table'] ) {
		return '<p>' . __( 'Select a job classification data group to display results.', 'hrswp-sqlsrv-db' ) . '</p>';
	}

	$query = array(
		'dataset' => array(
			array(
				'table' => $args['table'],
			),
		),
	);

	$response = new Sqlsrv_Query\Sqlsrv_Query( $query );

	if ( ! $response->records ) {
		return '<p>' . __( 'No data found', 'hrswp-sqlsrv-db' ) . '</p>';
	}

	$salary_data = $response->records;

	$output = render_salary_data_table( $args, $salary_data );

	$classname = 'wp-block-hrswpsqlsrv-salary-data';

	if ( '' !== $args['align'] ) {
		$classname .= ' align' . $args['align'];
	}

	return '<div class="' . $classname . '">' . $output . '</div>';
}

/**
 * Registers the `hrswpsqlsrv/salary-data` on the server.
 *
 * @since 0.2.0
 * @since 0.10.0 Use `register_block_type_from_metadata`
 */
function register_block_salary_data() {
	register_block_type_from_metadata(
		__DIR__ . '/block.json',
		array(
			'render_callback' => __NAMESPACE__ . '\render',
		)
	);

	// Start the API for the salary data block table group list.
	new API\API();
}
// Use later priority to make sure required resources are ready.
add_action( 'init', __NAMESPACE__ . '\register_block_salary_data', 25 );
