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
 * Renders a job classification text field.
 *
 * @since 0.10.0
 *
 * @param string $name A text field.
 * @return string The sanitized text field.
 */
function render_job_classification_name( $name ) {
	return ( ! $name ) ? __( '(Untitled)', 'hrswp-sqlsrv-db' ) : esc_html( trim( $name ) );
}

/**
 * Renders the job classification range URL element.
 *
 * @since 0.10.0
 *
 * @param string $salary_data_url The URL of a page with a corresponding Salary Data block.
 * @param string $range_url_param The salary range to filter by.
 * @param string $range The salary range to display.
 * @return string The formatted range url HTML element.
 */
function render_job_classification_range_url( $salary_data_url, $range_url_param, $range ) {
	return sprintf(
		'<a href="%1$s?filter=%2$s">%3$s</a>',
		esc_url( $salary_data_url ),
		esc_attr( $range_url_param ),
		render_job_classification_name( $range )
	);
}

/**
 * Renders the job classification salary field.
 *
 * @since 0.10.0
 *
 * @param string $number The salary data to format.
 * @return string The formatted salary data, as currency if a number, or plain text if not.
 */
function render_job_classification_currency( $number ) {
	return ( is_string( $number ) && ! is_numeric( trim( $number ) ) )
		? render_job_classification_name( $number )
		: '$' . esc_html( number_format( (int) $number ) );
}

/**
 * Renders the job classification data as an unordered list.
 *
 * @since 0.10.0
 *
 * @param array  $args Block attributes passed from the block editor.
 * @param object $job_classification_data The job classification data from a successful Sqlsrv query.
 * @return string The job classification data formatted into a list element.
 */
function render_job_classification_list( $args, $job_classification_data ) {
	$list = '<ul class="has-columns has-columns-' . $args['columns'] . '">';
	foreach ( $job_classification_data as $job_classification ) {
		$list .= render_job_classification_list_item( $args['salary_data_url'], $job_classification );
	}
	$list .= '</ul>';
	return $list;
}

/**
 * Renders a single job classification data record as a list item.
 *
 * @since 0.10.0
 *
 * @param string $salary_data_url The URL of a page with a corresponding Salary Data block.
 * @param object $job_classification A single job classification data record.
 * @return string The job classification data formatted into a list item element.
 */
function render_job_classification_list_item( $salary_data_url, $job_classification ) {
	// phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
	$list_item = '<li>
			<strong>' . render_job_classification_name( $job_classification->JobTitle ) . '</strong>
			<span>(' . render_job_classification_name( $job_classification->ClassCode ) . ')</span>
			<ul>
				<li>' . __( 'Range: ', 'hrswp-sqlsrv-db' ) . render_job_classification_range_url( $salary_data_url, $job_classification->SalRangeNum, $job_classification->SalrangeWExceptions ) . '</li>
				<li>' . __( 'Salary Min: ', 'hrswp-sqlsrv-db' ) . render_job_classification_currency( $job_classification->Salary_Min ) . '</li>
				<li>' . __( 'Salary Max: ', 'hrswp-sqlsrv-db' ) . render_job_classification_currency( $job_classification->Salary_Max ) . '</li>
			</ul>
		</li>';
	// phpcs:enable

	return $list_item;
}

/**
 * Renders the job classification data as a table.
 *
 * @since 0.10.0
 *
 * @param array  $args Block attributes passed from the block editor.
 * @param object $job_classification_data The job classification data from a successful Sqlsrv query.
 * @return string The job classification data formatted into a table element.
 */
function render_job_classification_table( $args, $job_classification_data ) {
	$table_head = '<thead>
			<tr>
				<th>' . __( 'Job Class', 'hrswp-sqlsrv-db' ) . '</th>
				<th>' . __( 'Job Title', 'hrswp-sqlsrv-db' ) . '</th>
				<th>' . __( 'Range', 'hrswp-sqlsrv-db' ) . '</th>
				<th>' . __( 'Salary Min', 'hrswp-sqlsrv-db' ) . '</th>
				<th>' . __( 'Salary Max', 'hrswp-sqlsrv-db' ) . '</th>
			</tr>
		</thead>';

	$table_body = '<tbody>';
	foreach ( $job_classification_data as $job_classification ) {
		$table_body .= render_job_classification_table_row( $args['salary_data_url'], $job_classification );
	}
	$table_body .= '</tbody>';

	$classname = 'wp-block-table';

	if ( '' !== $args['classname'] ) {
		$classname .= ' ' . $args['classname'];
	}

	return '<figure class="' . $classname . '"><table> ' . $table_head . $table_body . ' </table></figure>';
}

/**
 * Renders a single job classification data record as a table row.
 *
 * @since 0.10.0
 *
 * @param string $salary_data_url The URL of a page with a corresponding Salary Data block.
 * @param object $job_classification A single job classification data record.
 * @return string The job classification data formatted into a list element.
 */
function render_job_classification_table_row( $salary_data_url, $job_classification ) {
	// phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
	$table_row = '<tr>
				<td>' . render_job_classification_name( $job_classification->ClassCode ) . '</td>
				<td>' . render_job_classification_name( $job_classification->JobTitle ) . '</td>
				<td>' . render_job_classification_range_url( $salary_data_url, $job_classification->SalRangeNum, $job_classification->SalrangeWExceptions ) . '</td>
				<td>' . render_job_classification_currency( $job_classification->Salary_Min ) . '</td>
				<td>' . render_job_classification_currency( $job_classification->Salary_Max ) . '</td>
			</tr>';
	// phpcs:enable

	return $table_row;
}

/**
 * Renders the `hrswpsqlsrv/job-classifications` block contents.
 *
 * Displays the job classificaiton data for whichever data source has been selected.
 *
 * @since 0.4.0
 * @since 0.10.0 Reformat for WP block API v2.
 *
 * @param array $attributes The block attributes passed from the block editor.
 * @return string The formatted HTML to display.
 */
function render( $attributes ) {
	$args = array(
		'salary_data_url' => isset( $attributes['salaryDataUrl'] ) ? $attributes['salaryDataUrl'] : '',
		'table'           => isset( $attributes['queryTable'] ) ? sanitize_key( $attributes['queryTable'] ) : '',
		'align'           => isset( $attributes['align'] ) ? $attributes['align'] : '',
		'classname'       => isset( $attributes['className'] ) ? $attributes['className'] : '',
		'display_as_list' => $attributes['displayAsList'],
		'columns'         => $attributes['columns'],
	);

	$query = array(
		'dataset' => array(
			array(
				'table'  => $args['table'],
				'fields' => array(
					'ClassCode',
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

	if ( '' === $args['table'] ) {
		return '<p>' . __( 'Select a job classification data group to display results.', 'hrswp-sqlsrv-db' ) . '</p>';
	}

	$response = new Sqlsrv_Query\Sqlsrv_Query( $query );

	if ( ! $response->records ) {
		return '<p>' . __( 'No data found', 'hrswp-sqlsrv-db' ) . '</p>';
	}

	$job_classification_data = $response->records;

	$output = ( false !== $args['display_as_list'] )
		? render_job_classification_list( $args, $job_classification_data )
		: render_job_classification_table( $args, $job_classification_data );

	$classname = 'wp-block-hrswpsqlsrv-job-classifications';

	if ( '' !== $args['align'] ) {
		$classname .= ' align' . $args['align'];
	}

	return '<div class="' . $classname . '">' . $output . '</div>';
}

/**
 * Registers the `hrswpsqlsrv/job-classifications` block on the server.
 *
 * @since 0.4.0
 * @since 0.10.0 Use `register_block_type_from_metadata`
 */
function register_block_job_classifications() {
	register_block_type_from_metadata(
		__DIR__ . '/block.json',
		array(
			'render_callback' => __NAMESPACE__ . '\render',
		)
	);

	// Start the API for the job classifications block.
	new API\API();
}
// Use later priority to make sure required resources are ready.
add_action( 'init', __NAMESPACE__ . '\register_block_job_classifications', 25 );
