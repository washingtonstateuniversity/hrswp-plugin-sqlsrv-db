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
	 * Instantiates plugin Setup singleton.
	 *
	 * @since 0.1.0
	 *
	 * @return Setup An instance of the HRSWP Sqlsrv DB Setup class.
	 */
	public static function get_instance( $file ) {
		static $instance;

		if ( ! isset( $instance ) ) {
			$instance        = new Setup();
			Setup::$basename = $file;

			$instance->setup_hooks();
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
		/**
		 * Track activation with an option because the activation hook fires
		 * before the plugin is actually set up, which prevents taking certain
		 * actions in this method.
		 *
		 * @link https://stackoverflow.com/questions/7738953/is-there-a-way-to-determine-if-a-wordpress-plugin-is-just-installed/13927297#13927297
		 */
		$options = get_option( self::$slug . '_plugin-status' );
		if ( ! $options ) {
			add_option(
				self::$slug . '_plugin-status',
				array(
					'status'  => 'activated',
					'version' => '0.0.0',
				)
			);
		} else {
			$options['status'] = 'activated';
			update_option( self::$slug . '_plugin-status', $options );
		}
	}

	/**
	 * Deactivates the plugin.
	 *
	 * @since 0.1.0
	 */
	public static function deactivate() {
		// Set plugin status to 'deactivated'.
		$options           = get_option( self::$slug . '_plugin-status' );
		$options['status'] = 'deactivated';

		update_option( self::$slug . '_plugin-status', $options );
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
		delete_option( self::$slug . '_plugin-status' );
	}

	/**
	 * Loads the WP API actions and hooks.
	 *
	 * @since 0.1.0
	 *
	 * @access private
	 */
	private function setup_hooks() {
		add_action( 'admin_init', array( $this, 'manage_plugin_status' ) );
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
		require __DIR__ . '/class-mssql-db.php';
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
		if ( ! is_admin() || ! function_exists( 'get_plugin_data' ) ) {
			return;
		}

		$status = get_option( self::$slug . '_plugin-status' );
		$plugin = get_plugin_data( self::$basename );

		// Exit early if either version number is missing.
		if ( ! isset( $status['version'] ) || ! isset( $plugin['Version'] ) ) {
			return;
		}

		// Update the version if just activated or the versions don't match.
		if ( 'activated' === $status['status'] || $status['version'] !== $plugin['Version'] ) {
			$status = array(
				'status'  => 'active',
				'version' => $plugin['Version'],
			);

			update_option( self::$slug . '_plugin-status', $status );
		}
	}
}
