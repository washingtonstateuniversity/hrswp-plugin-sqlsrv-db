<?php
/**
 * Plugin Name: HRSWP Sqlsrv DB
 * Version: 0.11.1
 * Description: A WSU HRS WordPress plugin to connect to and query external Microsoft SQL Server databases.
 * Author: Adam Turner, washingtonstateuniversity
 * Author URI: https://hrs.wsu.edu/
 * Plugin URI: https://github.com/washingtonstateuniversity/hrswp-plugin-sqlsrv-db
 * Update URI: https://api.github.com/repos/washingtonstateuniversity/hrswp-plugin-sqlsrv-db/releases/latest
 * Text Domain: hrswp-sqlsrv-db
 * Requires at least: 5.0
 * Tested up to: 6.1.1
 * Requires PHP: 7.4
 *
 * @package HRSWP_Sqlsrv_DB
 */

namespace HRSWP\SQLSRV;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Activates the plugin.
 *
 * @since 0.11.0
 */
register_activation_hook(
	__FILE__,
	function(): void {
		// Delete legacy option.
		delete_option( 'hrswp_sqlsrv_db_plugin-status' );
	}
);

// Load plugin classes.
require_once dirname( __FILE__ ) . '/includes/classes/class-sqlsrv-db.php';
require_once dirname( __FILE__ ) . '/includes/classes/class-sqlsrv-query.php';

/**
 * Uninstalls the plugin.
 *
 * @since 0.11.0
 */
function uninstall(): void {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	// Delete plugin options.
	delete_option( 'hrswp_sqlsrv_db_plugin-status' );
}
register_uninstall_hook( __FILE__, __NAMESPACE__ . '\uninstall' );

/**
 * Verifies plugin dependencies.
 *
 * @since 0.11.0
 *
 * @return bool True if dependencies are met, false if not.
 */
function verify_plugin_dependencies(): bool {
	// Check for the HRSWP Sqlsrv configuration file.
	if (
		! file_exists( ABSPATH . 'hrswp-sqlsrv-config.php' ) &&
		! file_exists( dirname( ABSPATH ) . '/hrswp-sqlsrv-config.php' )
	) {
		return false;
	}

	return true;
}

add_action(
	'plugins_loaded',
	function(): void {
		if ( ! verify_plugin_dependencies() ) {
			add_action(
				'admin_notices',
				function(): void {
					printf(
						'<div class="notice notice-error"><p>%s</p></div>',
						esc_html__( 'ERROR: There doesn\'t seem to be a', 'hrswp-sqlsrv-db' ) . '<code>hrswp-sqlsrv-config.php</code>' . esc_html__( 'file. This is required for the HRSWP Sqlsrv DB plugin to work.', 'hrswp-sqlsrv-db' )
					);
				}
			);
		}
	}
);
