<?php
/**
 * HRSWP Sqlsrv DB Setup: Setup class
 *
 * @package HRSWP_Sqlsrv_DB
 * @since 0.1.0
 */

namespace HRSWP\SQLSRV\Setup;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The HRSWP Sqlsrv DB setup class.
 *
 * @since 0.1.0
 */
class Setup {
	/**
	 * The plugin slug.
	 *
	 * @since 0.1.0
	 * @var string
	 */
	public static $slug = 'hrswp_sqlsrv_db';

	/**
	 * The plugin file basename.
	 *
	 * @since 0.1.0
	 * @var string
	 */
	public static $basename;

	/**
	 * The plugin blocks to register.
	 *
	 * @since 0.5.0
	 * @var array Array of blocks to register in the format 'render-file.php' => 'registered-block-name'.
	 */
	public $blocks = array();

	/**
	 * Instantiates plugin Setup singleton.
	 *
	 * @since 0.1.0
	 *
	 * @param string $file The full path and filename of the instantiating file.
	 * @return Setup An instance of the HRSWP Sqlsrv DB Setup class.
	 */
	public static function get_instance( $file ) {
		static $instance;

		if ( ! isset( $instance ) ) {
			$instance        = new Setup();
			Setup::$basename = $file;

			$instance->includes();
		}

		return $instance;
	}

	/**
	 * An empty constructor to prevent plugin being loaded more than once.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		/* Nothing doing. */
	}

	/**
	 * Activates the plugin.
	 *
	 * @since 0.1.0
	 */
	public static function activate() {
		// Delete legacy option.
		delete_option( 'hrswp_sqlsrv_db_plugin-status' );
	}

	/**
	 * Uninstalls the plugin.
	 *
	 * @since 1.0.0
	 */
	public static function uninstall() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		// Delete plugin options.
		delete_option( 'hrswp_sqlsrv_db_plugin-status' );
	}

	/**
	 * Includes the required files.
	 *
	 * @since 0.1.0
	 *
	 * @access private
	 */
	private function includes() {
		// The Microsoft SQL Server database connection class.
		require __DIR__ . '/class-sqlsrv-db.php';

		// The Microsoft SQL Server query class.
		require __DIR__ . '/class-sqlsrv-query.php';
	}

	/**
	 * Manages the plugin status.
	 *
	 * Checks on the plugin status to watch for updates and activation and calls
	 * additional actions as needed.
	 *
	 * @since 0.1.0
	 */
	public function manage_plugin_status() {
		// @todo Move this to a dependency check method.
		//
		// Check for the HRSWP Sqlsrv configuration file.
		if (
			! file_exists( ABSPATH . 'hrswp-sqlsrv-config.php' ) &&
			! file_exists( dirname( ABSPATH ) . '/hrswp-sqlsrv-config.php' )
		) {
			// Warn if the HRSWP Sqlsrv configuration file can't be found.
			add_action( 'admin_notices', array( $this, 'notice__missing_config_file' ) );
		}
	}

	/**
	 * Displays an error message in the WP Admin area if the plugin config file is missing.
	 *
	 * The HRSWP Sqlsrv DB plugin relies on a 'hrswp-sqlsrv-config.php' file
	 * existing alongside the 'wp-config.php' file to store details for the
	 * external SQL Server databases.
	 *
	 * @since 0.2.0
	 */
	public function notice__missing_config_file() {
		printf(
			'<div class="notice notice-error"><p>%s</p></div>',
			esc_html__( 'ERROR: There doesn\'t seem to be a', 'hrswp-sqlsrv-db' ) . '<code>hrswp-sqlsrv-config.php</code>' . esc_html__( 'file. This is required for the HRSWP Sqlsrv DB plugin to work.', 'hrswp-sqlsrv-db' ),
		);
	}
}
