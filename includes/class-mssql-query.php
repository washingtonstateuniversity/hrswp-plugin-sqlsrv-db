<?php
/**
 * HRSWP Sqlsrv DB Query API: MSSQL_Query class
 *
 * @package HRSWP_Sqlsrv_DB
 * @since 0.1.0
 */

namespace HRSWP\SQLSRV\MSSQL_Query;
use HRSWP\SQLSRV\MSSQL_DB;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The HRSWP Sqlsrv DB Query class.
 *
 * Very similar in concept, but not complexity, to the core WP_Query class.
 *
 * @link https://codex.wordpress.org/Function_Reference/WP_Query Codex page.
 *
 * @since 0.1.0
 */
class MSSQL_Query {
	/**
	 * Query vars set by the user
	 *
	 * @since 0.1.0
	 * @var array
	 */
	public $query;

	/**
	 * Query vars after parsing
	 *
	 * @since 0.1.0
	 * @var array
	 */
	public $query_vars = array();

	/**
	 * The SQL query statement.
	 *
	 * @since 0.2.0
	 * @var string
	 */
	public $request;

	/**
	 * List of records.
	 *
	 * @since 0.1.0
	 * @var array
	 */
	public $records;

	/**
	 * The number of found records for the current query.
	 *
	 * @since 0.1.0
	 * @var int
	 */
	public $found_records = 0;

	/**
	 * Sets up the HRSWP Sqlsrv DB query.
	 *
	 * @since 0.2.0
	 *
	 * @param string|array $query Query string or array of query vars.
	 */
	public function __construct( $query = '' ) {
		if ( ! empty( $query ) ) {
			$this->query( $query );
		}
	}

	/**
	 * Sets up and runs the HRSWP Sqlsrv DB query.
	 *
	 * @since 0.2.0
	 *
	 * @param string|array $query Query string or array of query vars.
	 * @return object[]|int[] Array of database objects or IDs.
	 */
	public function query( $query ) {
		$this->init();
		$this->query_vars = wp_parse_args( $query );
		$this->query      = $this->query_vars;
		return $this->get_records();
	}

	/**
	 * Initiates object properties and sets default values.
	 *
	 * @since 0.1.0
	 */
	public function init() {
		unset( $this->query );
		unset( $this->records );
		unset( $this->request );
		$this->query_vars    = array();
		$this->found_records = 0;
	}

	/**
	 * Parses a query string.
	 *
	 * @since 0.2.0
	 *
	 * @param string|array $query {
	 *     Required. Array or string of HRSWP Sqlsrv Query parameters.
	 *
	 *     @type array[] $dataset {
	 *         One or more tables and (optional) fields to run query parameters on.
	 *
	 *         @type array ...$0 {
	 *             A table and field definintion.
	 *
	 *             @type string          $table  Required. The handle of the table to query.
	 *             @type string|string[] $fields Optional. The field(s) to return from the given
	 *                                                     table. A single field (string) or multiple
	 *                                                     fields (array). Default is all fields (*).
	 *     }
	 *     @type string          $order   Designates ascending or descending order of returned
	 *                                    records. Default 'DESC'. Accepts 'ASC', 'DESC'.
	 *     @type string|string[] $orderby Sort retrieved records by parameter. One or more options
	 *                                    may be passed. Accepts any passed `$field` value or 'rand'.
	 *                                    Default none.
	 *     @type string          $groupby Group retrieved records by parameter. Default none.
	 * }
	 */
	public function parse_query( $query = '' ) {
		// The query is usually defined in the constructor call, but just in case.
		if ( ! empty( $query ) ) {
			$this->init();
			$this->query_vars = wp_parse_args( $query );
			$this->query      = $this->query_vars;
		} elseif ( ! isset( $this->query ) ) {
			$this->query = $this->query_vars;
		}

		// Shorthand the query vars for easier reference.
		$qv = &$this->query_vars;

		// Parse datasets.
		if ( ! isset( $qv['dataset'] ) ) {
			$qv['dataset'] = '';
		} else {
			$qv['dataset'] = array_map( array( $this, 'parse_dataset' ), $qv['dataset'] );
		}

		if ( ! isset( $qv['orderby'] ) ) {
			$qv['orderby'] = '';
		} elseif ( ! is_array( $qv['orderby'] ) ) {
			$qv['orderby'] = explode( ' ', $qv['orderby'] );
		}
	}

	/**
	 * Standardize a 'dataset' query variable into a query-ready format.
	 *
	 * @since 0.2.0
	 *
	 * @param array $dataset {
	 *     Required. The database table and fields to parse.
	 *
	 *     @type string          $table  Required. The handle of the table to query.
	 *     @type string|string[] $fields Optional. The field(s) to return from the given
	 *                                   table. A single field (string) or multiple
	 *                                   fields (array). Default is all fields (*).
	 * @return array The parsed dataset.
	 */
	private function parse_dataset( $dataset ) {
		$dataset['table'] = ( isset( $dataset['table'] ) ) ? trim( $dataset['table'] ) : '';

		if ( ! isset( $dataset['fields'] ) ) {
			$dataset['fields'] = array( '*' );
		} elseif ( ! is_array( $dataset['fields'] ) ) {
			$dataset['fields'] = array( $dataset['fields'] );
		}

		return $dataset;
	}

	/**
	 * Parses an 'order' query variable into ASC or DESC.
	 *
	 * @since 0.2.0
	 *
	 * @param string $order The 'order' query variable.
	 * @return string The sanitized 'order' query variable.
	 */
	private function parse_order( $order ) {
		if ( ! is_string( $order ) || empty( $order ) ) {
			return 'DESC';
		}

		if ( 'ASC' === strtoupper( $order ) ) {
			return 'ASC';
		} else {
			return 'DESC';
		}
	}

	/**
	 * Retrieves an array of records based on query variables.
	 *
	 * @since 0.2.0
	 *
	 * @return object[]|int[] Array of database objects or IDs.
	 */
	public function get_records() {
		// Initialize the HRSWP Sqlsrv DB connector.
		$msdb = new MSSQL_DB\MSSQL_DB();

		$this->parse_query();

		// Shorthand the query vars for easier reference.
		$q = &$this->query_vars;

		// Begin by clearing the SQL statement variables.
		$field_table_array = array();
		$fields            = '';
		$tables            = '';
		$join              = '';
		$where             = '';
		$limits            = '';
		$groupby           = '';

		// Build field => table array and tables array from query vars.
		foreach ( $q['dataset'] as $dataset ) {
			$table = $msdb->get_table_name( $dataset['table'] );
			foreach ( $dataset['fields'] as $field ) {
				$field_table_array[ $field ] = $table;
			}
		}
		// Create field clauses out of field => table array.
		$fields_array = array();
		$tables_array = array();
		foreach ( $field_table_array as $field => $table ) {
			$fields_array[] = "{$table}.{$field}";
			$tables_array[] = $table;
		}
		$fields = implode( ', ', $fields_array );
		$tables = implode( ', ', array_unique( $tables_array ) );

		// Build the order and orderby statement clauses.
		$rand = ( isset( $q['orderby'] ) && 'rand' === $q['orderby'] );
		if ( ! isset( $q['order'] ) ) {
			$q['order'] = $rand ? '' : 'DESC';
		} else {
			$q['order'] = $rand ? '' : $this->parse_order( $q['order'] );
		}

		if ( empty( $q['orderby'] ) || false === $q['orderby'] || 'none' === $q['orderby'] ) {
			$orderby = '';
		} else {
			$orderby_array = array();
			// The `parse_query()` method casts any value of the 'orderby' query var to an array.
			foreach ( $q['orderby'] as $_orderby ) {
				$orderby = addslashes_gpc( urldecode( $_orderby ) );

				if ( ! array_key_exists( $orderby, $field_table_array ) ) {
					continue;
				} else {
					$orderby_clause = "{$field_table_array[ $orderby ]}.{$orderby}";
				}

				$orderby_array[] = $orderby_clause;
			}
			$orderby = implode( ', ', $orderby_array );
		}

		// Build the groupby statement clause.
		if ( empty( $q['groupby'] ) || false === $q['groupby'] || 'none' === $q['groupby'] ) {
			$groupby = '';
		} else {
			$groupby = addslashes_gpc( urldecode( $q['groupby'] ) );
			$groupby = "{$field_table_array[ $groupby ]}.{$groupby}";
		}

		if ( ! empty( $groupby ) ) {
			$groupby = 'GROUP BY ' . $groupby;
		}
		if ( ! empty( $orderby ) ) {
			$orderby = 'ORDER BY ' . $orderby;
		}

		$this->request = $msdb->prepare(
			'SELECT %s FROM %s %s WHERE 1=1 %s %s %s',
			array(
				$fields,
				$tables,
				$join,
				$where,
				$groupby,
				$orderby,
			)
		);

		// Select database based on table from query.
		$database = $msdb->get_database_label_by( 'table', $tables_array[0] );

		// Connect to the database.
		if ( $msdb->mssql_db_connect( $database ) ) {
			// Make the request.
			$this->records = $msdb->get_results( $this->request );

			// Disconnect from the database and clean up.
			$msdb->clean();

			$this->found_records = count( $this->records );
		}

		if ( ! $this->records ) {
			$this->found_records = 0;
			$this->records       = array();
		}

		return $this->records;
	}
}
