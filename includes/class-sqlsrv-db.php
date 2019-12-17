<?php
/**
 * HRSWP Sqlsrv DB Connector Class: Sqlsrv_DB
 *
 * The HRSWP Sqlsrv DB connector is comprised of the Sqlsrv_DB class, which, when
 * instantiated with valid credentials, opens a connection from WordPress to
 * a Microsoft SQL Server database. The class provides a variety of methods for
 * interacting with the SQL Server database using the `sqlsrv` PHP extension.
 *
 * @package HRSWP_Sqlsrv_DB
 * @since 0.1.0
 */

namespace HRSWP\SQLSRV\Sqlsrv_DB;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * SQL Server Database Access Object.
 *
 * @link https://codex.wordpress.org/Function_Reference/wpdb_Class
 *
 * @since 0.1.0
 */
class Sqlsrv_DB {
	/**
	 * Whether to show SQL/DB errors.
	 *
	 * Default behavior is to show errors if both WP_DEBUG and WP_DEBUG_DISPLAY
	 * evaluated to true.
	 *
	 * @since 0.1.0
	 * @var bool
	 */
	private $show_errors = false;

	/**
	 * Results of the last query made.
	 *
	 * @since 0.1.0
	 * @var array|null
	 */
	private $last_result;

	/**
	 * Count of rows returned by previous query.
	 *
	 * @since 0.1.0
	 * @var int
	 */
	public $num_rows = 0;

	/**
	 * Last query made.
	 *
	 * @since 0.1.0
	 * @var array
	 */
	private $last_query;

	/**
	 * SQL server result, either a resource or a booleen.
	 *
	 * @since 0.1.0
	 * @var mixed
	 */
	protected $result;

	/**
	 * The SQL Server database connection details.
	 *
	 * @since 0.2.0
	 * @var array {
	 *     Array of database connection entries.
	 *
	 *     @type string A reference name for this database.
	 *     @type array {
	 *         The database credentials for the given handle.
	 *
	 *         @type string $mssql_db_name     The name of the database to connect to.
	 *         @type string $mssql_db_user     The Microsoft SQL Server user for the database.
	 *         @type string $mssql_db_password The Microsoft SQL Server user password.
	 *         @type string $mssql_db_host     The Microsoft SQL Server host.
	 *     }
	 * }
	 */
	protected $databases = array();

	/**
	 * The SQL Server database tables.
	 *
	 * @since 0.2.0
	 * @var array {
	 *     Array of table labels and database details.
	 *
	 *     @type string A reference name for this table.
	 *     @type array {
	 *         Database details for each table.
	 *
	 *         @type string $table_name The name of the table in the database.
	 *         @type string $database   The reference name of the database containing the table(s).
	 *     }
	 * }
	 */
	protected $tables = array();

	/**
	 * Database Handle.
	 *
	 * @since 0.1.0
	 * @var string
	 */
	protected $dbh;

	/**
	 * Whether a connection has been made.
	 *
	 * @since 0.1.0
	 * @var bool
	 */
	private $has_connected = false;

	/**
	 * Prepares to make database connections.
	 *
	 * PHP5+ style constructor that sets up the class properties and loads the
	 * database configuration details.
	 *
	 * @since 0.1.0
	 * @since 0.2.0 No longer opens connection on initialization.
	 */
	public function __construct() {
		// Only print errors if debugging is enabled globally.
		if ( WP_DEBUG && WP_DEBUG_DISPLAY ) {
			$this->show_errors = true;
		}

		// Load the SQL Server DB configuration file.
		if ( file_exists( ABSPATH . 'hrswp-sqlsrv-config.php' ) ) {

			// The config file exists in ABSPATH.
			require( ABSPATH . 'hrswp-sqlsrv-config.php' );

		} elseif ( file_exists( dirname( ABSPATH ) . '/hrswp-sqlsrv-config.php' ) ) {

			// The config file exists one level above ABSPATH.
			require( dirname( ABSPATH ) . '/hrswp-sqlsrv-config.php' );

		} else {

			// The config file does not exist.
			$this->print_error( __( 'There does not seem to be a "hrswp-sqlsrv-config.php" file. This is required for the HRSWP Sqlsrv DB plugin to work.', 'hrswp-sqlsrv-db' ) );

		}
	}

	/**
	 * Handles database option destruction.
	 *
	 * This PHP5-style destructor runs when the database object is destroyed.
	 *
	 * @since 0.1.0
	 * @return true
	 */
	public function __destruct() {
		return true;
	}

	/**
	 * Adds the connection details for a database as a dataset.
	 *
	 * @since 0.2.0
	 *
	 * @param string $database_handle      Required. A reference name for accessing this
	 *                                     database, between 1 and 20 characters in length.
	 *                                     Allowed characters: Lowercase alphanumeric characters,
	 *                                     dashes and underscores, @see sanitize_key().
	 * @param array  $config {
	 *     Required. Array of SQL Server database connection details.
	 *
	 *     @type string $mssql_db_name     The name of the database to connect to.
	 *     @type string $mssql_db_user     The Microsoft SQL Server user for the database.
	 *     @type string $mssql_db_password The Microsoft SQL Server user password.
	 *     @type string $mssql_db_host     The Microsoft SQL Server host.
	 * }
	 */
	private function add_database( $database_handle, $config = array() ) {
		if ( empty( $database_handle ) || 20 < strlen( $database_handle ) ) {
			$this->print_error( __( 'There is a problem with one of the datasets in "hrswp-sqlsrv-config.php."', 'hrswp-sqlsrv-db' ) );
			return;
		}

		// Sanitize database handle.
		$database_handle = sanitize_key( $database_handle );

		$this->databases[ $database_handle ] = $config;
	}

	/**
	 * Associates tables with databases and reference handles for selection.
	 *
	 * @since 0.2.0
	 *
	 * @param string $database_handle Required. The reference name of the database containing the table(s).
	 * @param array  $tables {
	 *     Required. Array of SQL Server database table labels and table names.
	 *
	 *     @type array {
	 *         Each table should be defined in an array with a label and the database name.
	 *
	 *         @type string $label      Required. A reference name for referring to this table.
	 *                                  Allowed characters: Lowercase alphanumeric characters,
	 *                                  dashes and underscores, @see sanitize_key().
	 *         @type string $table_name Required. The name of the table in the database.
	 *     }
	 * }
	 */
	private function set_table_names( $database_handle, $tables = array() ) {
		if ( ! array_key_exists( $database_handle, $this->databases ) ) {
			$this->print_error(
				sprintf(
					/* translators: %s: the database identifier */
					__( 'Problem in Sqlsrv_DB->add_tables. The database slug %s does not exist.', 'hrswp-sqlsrv-db' ),
					esc_html( $database_handle )
				)
			);
			return;
		}

		foreach ( $tables as $table ) {
			// Sanitize the table label.
			$label = sanitize_key( $table['label'] );

			$this->tables[ $label ] = array(
				'table_name' => $table['table_name'],
				'database'   => $database_handle,
			);
		}
	}

	/**
	 * Retrieve the database name by a given field.
	 *
	 * @since 0.2.0
	 *
	 * @param string $field The field the retrieve the database name by. Accepts 'table'.
	 * @param string $value A value for $field. A table from the desired database.
	 * @return string|false The database label on success, false on failure.
	 */
	public function get_database_label_by( $field, $value ) {
		if ( 'table' === $field ) {
			foreach ( $this->tables as $table ) {
				if ( in_array( $value, $table, true ) ) {
					return $table['database'];
				}
			}
		}

		return false;
	}

	/**
	 * Retrieves a database table name for use in an SQL query.
	 *
	 * @since 0.2.0
	 *
	 * @param string $table_label Required. The label for the table name to be retrieved.
	 * @return string|false The database table name for use in an SQL query or false on failure.
	 */
	public function get_table_name( $table_label ) {
		$table = $this->tables[ $table_label ]['table_name'];

		if ( ! $table ) {
			return false;
		}

		return $table;
	}

	/**
	 * Retrieves a list of table labels.
	 *
	 * @since 0.3.0
	 *
	 * @return string[]|false Array of registered table labels or false on failure.
	 */
	public function list_tables() {
		if ( ! $this->tables ) {
			return false;
		}

		$tables = array();
		foreach ( $this->tables as $table => $props ) {
			$tables[] = $table;
		}

		return $tables;
	}

	/**
	 * Connects to a database server and selects a database.
	 *
	 * Uses the `sqlsrv` PHP extension to open a connection to a Microsoft SQL
	 * Server database.
	 *
	 * @link http://php.net/manual/en/intro.sqlsrv.php
	 *
	 * @since 0.1.0
	 *
	 * @param string $database Required. The label corresponding to the database to connect to.
	 * @return bool True with a successful connection, false on failure.
	 */
	public function mssql_db_connect( $database ) {
		if ( ! $this->databases[ $database ] ) {
			$this->print_error( __( 'Invalid database label provided to "mssql_db_connect"', 'hrswp-sqlsrv-db' ) );
			return false;
		}

		// Set the MS SQL Server-style query parameters.
		$params = array(
			'Database' => $this->databases[ $database ]['mssql_db_name'],
			'Uid'      => $this->databases[ $database ]['mssql_db_user'],
			'PWD'      => $this->databases[ $database ]['mssql_db_password'],
		);

		// Open a MS SQL connection using ODBC.
		if ( $this->show_errors ) {
			$this->dbh = sqlsrv_connect( $this->databases[ $database ]['mssql_db_host'], $params );
		} else {
			$this->dbh = @sqlsrv_connect( $this->databases[ $database ]['mssql_db_host'], $params ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
		}

		// Check for a successful connection. Return false on error.
		if ( ! $this->dbh ) {
			$this->print_error();
			return false;
		} elseif ( $this->dbh ) {
			$this->has_connected = true;
			return true;
		}

		return false;
	}

	/**
	 * Escapes certain LIKE special characters to prep for MS SQL Parameterized Query.
	 *
	 * Use this only before a MS SQL parameterized query. This function is not
	 * sufficient to create SQL-safe output on its own.
	 *
	 * Example:
	 *
	 *     $find = 'only 42% of the universe';
	 *     $like = $msdb->esc_like( $find );
	 *     $sql  = $msdb->get_results( "SELECT * FROM table WHERE content LIKE '%' + ? + '%' ", array( $like ) );
	 *
	 * @since 0.1.0
	 *
	 * @param string $text The raw text to be escaped.
	 * @return string Text in the form of a LIKE phrase. The output is not SQL safe on its own.
	 */
	public function esc_like( $text ) {
		$text = str_replace( '[', '[[]', $text );
		$text = str_replace( '%', '[%]', $text );
		$text = str_replace( '_', '[_]', $text );
		$text = addcslashes( $text, '_%\\' );

		return $this->add_placeholder_escape( $text );
	}

	/**
	 * Attempts to escape special characters in a string.
	 *
	 * For now only escapes quotation marks.
	 *
	 * @todo Consider switching to PDO for better built-in escaping.
	 *
	 * @since 0.1.0
	 *
	 * @param string $string String to escape.
	 * @return string Escaped string.
	 */
	private function mssql_escape_string( $string ) {
		// MS SQL syntax requires single quotes to be escaped.
		$escaped = str_replace( "'", "''", $string );
		$escaped = addslashes( $escaped );

		return $this->add_placeholder_escape( $escaped );
	}

	/**
	 * Escapes content by reference for insertion into the database.
	 *
	 * @uses msdb::mssql_escape_string()
	 *
	 * @since 0.1.0
	 *
	 * @param string $string String to escape.
	 */
	public function escape_by_ref( &$string ) {
		if ( ! is_float( $string ) ) {
			$string = $this->mssql_escape_string( $string );
		}
	}

	/**
	 * Generates and returns a placeholder escape string for use in queries returned by ::prepare().
	 *
	 * @see wpdb::placeholder_escape()
	 *
	 * @since 0.1.0
	 *
	 * @return string String to escape placeholders.
	 */
	public function placeholder_escape() {
		static $placeholder;

		if ( ! $placeholder ) {
			// If ext/hash is not present, compat.php's hash_hmac() does not support sha256.
			$algo = function_exists( 'hash' ) ? 'sha256' : 'sha1';
			// Old WP installs may not have AUTH_SALT defined.
			$salt        = defined( 'AUTH_SALT' ) && AUTH_SALT ? AUTH_SALT : (string) wp_rand();
			$placeholder = '{' . hash_hmac( $algo, uniqid( $salt, true ), $salt ) . '}';
		}

		/*
		 * Add the filter to remove the placeholder escaper. Uses priority 0, so that anything
		 * else attached to this filter will recieve the query with the placeholder string removed.
		 */
		if ( ! has_filter( 'query', array( $this, 'remove_placeholder_escape' ) ) ) {
			add_filter( 'query', array( $this, 'remove_placeholder_escape' ), 0 );
		}

		return $placeholder;
	}

	/**
	 * Adds a placeholder escape string, to escape anything that resembles a printf() placeholder.
	 *
	 * @since 0.1.0
	 *
	 * @param string $query The query to escape.
	 * @return string The query with the placeholder escape string inserted as needed.
	 */
	public function add_placeholder_escape( $query ) {
		/*
		 * To prevent returning anything that even vaguely resembles a placeholder,
		 * we clobber every % we can find.
		 */
		return str_replace( '%', $this->placeholder_escape(), $query );
	}

	/**
	 * Removes the placeholder escape strings from a query.
	 *
	 * @since 0.1.0
	 *
	 * @param string $query The query to remove the placeholder from.
	 * @return string The query with the placeholder removed as needed.
	 */
	public function remove_placeholder_escape( $query ) {
		return str_replace( $this->placeholder_escape(), '%', $query );
	}

	/**
	 * Prepares a SQL Server query for safe execution.
	 *
	 * Essentially duplicates the $wpdb::prepare() method. Uses sprintf()-like
	 * syntax and allows the following placeholders in the query string:
	 *   %d (integer)
	 *   %f (float)
	 *   %s (string)
	 *
	 * All placeholders **must** be left unquoted in the query string and a
	 * corresponding argument **must** be passed for each placeholder.
	 *
	 * Numbered or formatted query strings (such as %1$2 or %5s) will not have
	 * quotes added by this function. They should be passed with appropriate
	 * quotation marks aruond them for your usage.
	 *
	 * Literal percentage signs (%) in the query string must be written as `%%`.
	 * Percentage wildcards (such as those used in LIKE syntax) must be passed
	 * via a substitution argument containing the complete LIKE string; they
	 * cannot be inserted directly in the query string, see {@see esc_like()}.
	 *
	 * Examples:
	 *     $msdb->prepare( "SELECT * FROM table WHERE column = %s OR field LIKE %s", array( 'foo', '%bar' ) )
	 *
	 * @link https://secure.php.net/sprintf Description of syntax.
	 *
	 * @since 0.1.0
	 *
	 * @param string      $query Query statement with sprintf()-like placeholders.
	 * @param array|mixed $args  The array of variables to substitute into the query's placeholders
	 *                           if being called with an array of arguments, or the first variable
	 *                           to substitute into the query's placeholders if being called with
	 *                           individual arguments.
	 * @return string|void Sanitized query string, or void if there is no query to prepare.
	 */
	public function prepare( $query, $args ) {
		if ( is_null( $query ) ) {
			return;
		}

		// This is not meant to be foolproof, but it will catch obviously incorrect usage.
		if ( strpos( $query, '%' ) === false ) {
			$this->print_error( 'The query argument of %s must have a placeholder.', 'hrswp-sqlsrv-db' );
		}

		$args = func_get_args(); // phpcs:ignore PHPCompatibility.FunctionUse.ArgumentFunctionsReportCurrentValue
		array_shift( $args );

		// If $args was passed as an array (as in vsprintf), move them up.
		$passed_as_array = false;
		if ( is_array( $args[0] ) && count( $args ) === 1 ) {
			$passed_as_array = true;
			$args            = $args[0];
		}

		foreach ( $args as $arg ) {
			if ( ! is_scalar( $arg ) && ! is_null( $arg ) ) {
				$this->print_error( sprintf( 'Unsupported value type (%s)', gettype( $arg ) ) );
			}
		}

		/*
		 * Specify the formatting allowed in a placeholder. The following are allowed:
		 *
		 * - Sign specifier. eg, $+d
		 * - Numbered placeholders. eg, %1$s
		 * - Padding specifier, including custom padding characters. eg, %05s, %'#5s
		 * - Alignment specifier. eg, %05-s
		 * - Precision specifier. eg, %.2f
		 */
		$allowed_format = '(?:[1-9][0-9]*[$])?[-+0-9]*(?: |0|\'.)?[-+0-9]*(?:\.[0-9]+)?';

		/*
		 * If a %s placeholder already has quotes around it, removing the existing quotes
		 * and re-inserting them ensures the quotes are consistent.
		 *
		 * For backwards compatibility, this is only applied to %s, and not to placeholders
		 * like %1$s, which are frequently used in the middle of longer strings, or as table
		 * name placeholders.
		 */
		$query = str_replace( "'%s'", '%s', $query ); // Strip any existing single quotes.
		$query = str_replace( '"%s"', '%s', $query ); // Strip any existing double quotes.

		$query = preg_replace( "/(?<!%)(%($allowed_format)?f)/", '%\\2F', $query ); // Force floats to be locale unaware.
		$query = preg_replace( "/%(?:%|$|(?!($allowed_format)?[sdF]))/", '%%\\1', $query ); // Escape any unescaped percents.

		// Count the number of valid placeholders in the query.
		$placeholders = preg_match_all( "/(^|[^%]|(%%)+)%($allowed_format)?[sdF]/", $query, $matches );

		if ( count( $args ) !== $placeholders ) {
			if ( 1 === $placeholders && $passed_as_array ) {
				// If the passed query only expected one argument, but the wrong number of arguments were sent as an array, bail.
				$this->print_error( 'The query only expected one placeholder, but an array of multiple placeholders was sent.', 'hrswp-sqlsrv-db' );
				return;
			} else {
				/*
				 * If we don't have the right number of placeholders, but they were passed as individual arguments,
				 * or we were expecting multiple arguments in an array, throw a warning.
				 */
				$this->print_error(
					sprintf(
						/* translators: 1: number of placeholders, 2: number of arguments passed */
						__( 'The query does not contain the correct number of placeholders (%1$d) for the number of arguments passed (%2$d).', 'hrswp-sqlsrv-db' ),
						$placeholders,
						count( $args )
					)
				);
			}
		}

		array_walk( $args, array( $this, 'escape_by_ref' ) );
		$query = vsprintf( $query, $args );

		return $this->add_placeholder_escape( $query );
	}

	/**
	 * Performs a MS SQL Server database query, using the current DB connection.
	 *
	 * For the time being only handles SELECT queries.
	 * More complex than it needs to be for now, in order to allow for easily
	 * adapting this to allow for INSERT and DELETE queries in the future.
	 *
	 * @todo Check on the type of query, {@see /wp-includes/wp-db.php}.
	 * @todo Include some filtering and checking first.
	 *
	 * @since 0.1.0
	 *
	 * @param string $query A database query.
	 * @param array  $param Optional. Arguments for a parameterized query.
	 * @return int|bool Number of rows selected for select queries. Booleen
	 *                  false on error.
	 */
	public function query( $query, $param = array() ) {
		if ( ! $this->has_connected ) {
			// Stop execution if there is no connection present.
			return false;
		}

		// Clear out any preexisting query statements.
		$this->flush();

		// Keep track of the last query for debug.
		$this->last_query = $query;

		// Run the query, without or with parameters.
		if ( ! $param ) {
			$this->do_query( $query );
		} else {
			$this->do_query( $query, $param );
		}

		// Catch errors.
		if ( false === $this->result ) {
			$this->print_error();
			return false;
		}

		$num_rows = 0;
		if ( is_resource( $this->result ) ) {
			// phpcs:ignore WordPress.CodeAnalysis.AssignmentInCondition
			while ( $row = sqlsrv_fetch_object( $this->result ) ) {
				$this->last_result[ $num_rows ] = $row;
				$num_rows++;
			}

			// Log the number of rows returned and return them.
			$this->num_rows = $num_rows;
			$return_val     = $num_rows;

		}

		return $return_val;
	}

	/**
	 * Internal function performs an sqlsrv_query() call.
	 *
	 * @see HRS_MSDB::query()
	 * @link http://php.net/manual/en/function.sqlsrv-query.php
	 *
	 * @since 0.1.0
	 *
	 * @param string $query The query to run.
	 * @param array  $param  Optional. Arguments for a parameterized query.
	 */
	private function do_query( $query, $param = array() ) {
		if ( ! empty( $this->dbh ) ) {
			if ( ! $param ) {
				$this->result = sqlsrv_query( $this->dbh, $query );
			} else {
				$this->result = sqlsrv_query( $this->dbh, $query, $param );
			}
		}
	}

	/**
	 * Retrieves an entire SQL result from the database (many rows).
	 *
	 * Executes a given SLQ query and returns the full result.
	 *
	 * @since 0.1.0
	 *
	 * @param string $query  An SQL query.
	 * @param array  $param  Optional. Arguments for a parameterized sqlsrv query.
	 * @param string $output Optional. Any of ARRAY_A, ARRAY_N, or OBJECT constants.
	 *                       All return an arrow of rows indexed from 0 by SQL result row number.
	 *                       Each row is an associative array (column => value, ...), a numerically
	 *                       indexed array (0 => value, ...), or an object ( ->column = value ), respectively.
	 * @return array|object|null The database query results.
	 */
	public function get_results( $query = null, $param = array(), $output = OBJECT ) {
		// Perform a query with the provided SQL statement and optional parameters.
		if ( $query && $param ) {
			$this->query( $query, $param );
		} elseif ( $query && ! $param ) {
			$this->query( $query );
		} else {
			return null;
		}

		// Return the query results.
		if ( OBJECT === $output ) {
			// Return an integer-keyed array of row objects.
			return $this->last_result;
		} elseif ( OBJECT === strtoupper( $output ) ) {
			// Return an integer-keyed array of row objects.
			return $this->last_result;
		}

		return null;
	}

	/**
	 * Remove cached query results.
	 *
	 * @since 0.1.0
	 */
	public function flush() {
		// Unset properties.
		$this->last_result = array();
		$this->last_query  = null;
		$this->num_rows    = 0;

		// If a resource statement is still saved, clear it.
		if ( is_resource( $this->result ) ) {
			sqlsrv_free_stmt( $this->result );
		}
	}

	/**
	 * Closes the current database connection.
	 *
	 * @since 0.1.0
	 *
	 * @return bool True if the connection was successfully closed, false if it
	 *              wasn't or if the connection doesn't exist.
	 */
	public function close() {
		if ( ! $this->dbh ) {
			return false;
		}

		$closed = sqlsrv_close( $this->dbh );

		if ( $closed ) {
			// If successfully closed, unset the class properties as well.
			$this->dbh           = null;
			$this->has_connected = false;
		}

		return $closed;
	}

	/**
	 * Cleans up request resources and closes.
	 *
	 * This is only a wrapper for HRS_MSDB::flush() and HRS_MSDB::clean().
	 *
	 * @since 0.1.0
	 */
	public function clean() {
		// Clean up.
		$this->flush();

		// Then close the connection.
		$this->close();
	}

	/**
	 * Prints an SQL/DB error.
	 *
	 * @since 0.1.0
	 *
	 * @param string $str The error to display.
	 * @return false|void False if showing of errors is disabled.
	 */
	public function print_error( $str = '' ) {
		if ( ! $str ) {
			$str = sqlsrv_errors();
		}

		if ( ! $this->show_errors ) {
			return false;
		}

		// Display errors.
		if ( is_array( $str ) ) {
			foreach ( $str as $err ) {
				printf(
					'<div id="error"><p class="wpdberror"><strong>%s</strong> [SQLSTATE %s]<br /><code>Code %s %s</code></p></div>',
					esc_html__( 'WP HRS_MSDB error:', 'hrswp-sqlsrv-db' ),
					esc_html( $err['SQLSTATE'] ),
					esc_html( $err['code'] ),
					esc_html( $err['message'] )
				);
			}
		} else {
			printf(
				'<div id="error"><p class="wpdberror"><strong>%s</strong> <code>%s</code></p></div>',
				esc_html__( 'WP HRS_MSDB error:', 'hrswp-sqlsrv-db' ),
				esc_html( $str )
			);
		}

	}

}
