<?php
/**
 * HRSWP Sqlsrv DB Query API: MSSQL_Query class
 *
 * @package HRSWP_Sqlsrv_DB
 * @since 0.3.0
 */

namespace HRSWP\SQLSRV\API;
use HRSWP\SQLSRV\Setup;
use HRSWP\SQLSRV\MSSQL_DB;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The HRSWP Sqlsrv DB API class.
 *
 * Registers a HRSWP Sqlsrv DB route with the WP API and sets up endpoints.
 *
 * @link https://codex.wordpress.org/Function_Reference/WP_Query Codex page.
 *
 * @since 0.3.0
 */
class API {
	/**
	 * The API route version.
	 *
	 * @since 0.3.0
	 * @var int
	 */
	private $version;

	/**
	 * The API route namespace.
	 *
	 * @since 0.3.0
	 * @var string
	 */
	private $namespace;

	/**
	 * Initializes the API.
	 *
	 * @since 0.3.0
	 */
	public function __construct() {
		$plugin_slug     = sanitize_title( str_replace( '_', '-', Setup\Setup::$slug ) );
		$this->version   = '1';
		$this->namespace = "{$plugin_slug}/v{$this->version}";

		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Registers the REST API routes.
	 *
	 * @uses register_rest_route()
	 *
	 * @since 0.3.0
	 */
	public function register_routes() {
		// Available tables.
		register_rest_route(
			$this->namespace,
			'/tables',
			array(
				'methods' => 'GET',
				'callback' => array( $this, 'get_tables_list' ),
				'permission_callback' => function () {
					return current_user_can( 'edit_others_posts' );
				}
			)
		);
	}

	/**
	 * Returns a list of the available tables.
	 *
	 * @since 0.3.0
	 *
	 * @return array JSON feed of returned objects.
	 */
	public function get_tables_list() {
		// Initialize the HRSWP Sqlsrv DB connector.
		$msdb      = new MSSQL_DB\MSSQL_DB();
		$db_tables = $msdb->list_tables();

		if ( ! $db_tables ) {
			return null;
		}

		$tables = array();
		foreach ( $db_tables as $db_table ) {
			$tables[] = array(
				'value' => $db_table,
				'label' => ucwords( str_replace( '-', ' ', $db_table ) ),
			);
		}

		return new \WP_REST_Response ( $tables, 200 );
	}
}
