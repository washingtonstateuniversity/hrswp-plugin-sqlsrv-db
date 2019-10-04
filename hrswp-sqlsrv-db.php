<?php
/*
Plugin Name: HRSWP Sqlsrv DB
Version: 0.2.0-alpha.1
Description: A WSU HRS WordPress plugin to connect to and query external Microsoft SQL Server databases.
Author: Adam Turner, washingtonstateuniversity
Author URI: https://hrs.wsu.edu/
Plugin URI: https://github.com/washingtonstateuniversity/hrswp-plugin-sqlsrv-db
Text Domain: hrswp-sqlsrv-db
Requires at least: 5.0
Tested up to: 5.2.3
Requires PHP: 7.0
*/
namespace HRSWP\SQLSRV;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Loads the core plugin Setup class.
 *
 * @since 0.1.0
 */
require __DIR__ . '/includes/class-setup.php';

// Starts things up.
add_action( 'plugins_loaded', __NAMESPACE__ . '\load' );

register_activation_hook( __FILE__, array( __NAMESPACE__ . '\Setup\Setup', 'activate' ) );
register_deactivation_hook( __FILE__, array( __NAMESPACE__ . '\Setup\Setup', 'deactivate' ) );
register_uninstall_hook( __FILE__, array( __NAMESPACE__ . '\Setup\Setup', 'uninstall' ) );

/**
 * Creates an instance of the Setup class.
 *
 * @since 0.1.0
 *
 * @return Setup An instance of the Setup class.
 */
function load() {
	$hrswp_sqlsrv_db = Setup\Setup::get_instance( __FILE__ );

	return $hrswp_sqlsrv_db;
}
