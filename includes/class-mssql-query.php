<?php
/**
 * HRSWP Sqlsrv DB Query API: MSSQL_Query class
 *
 * @package HRSWP_Sqlsrv_DB
 * @since 0.1.0
 */

namespace HRSWP\SQLSRV\MSSQL_Query;

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
	 * Initiates object properties and sets default values.
	 *
	 * @since 0.1.0
	 */
	public function init() {
		unset( $this->records );
		unset( $this->query );
		$this->query_vars    = array();
		$this->found_records = 0;
	}

	// Additional query methods here.
}
