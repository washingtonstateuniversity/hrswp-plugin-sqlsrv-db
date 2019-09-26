<?php
/*
Plugin Name: WSUWP HRS Courses
Version: 1.0.0
Description: A plugin to create a Course custom post type for WSU Human Resource Services.
Author: Adam Turner, washingtonstateuniversity
Author URI: https://hrs.wsu.edu/
Plugin URI: https://github.com/washingtonstateuniversity/wsuwp-hrs-courses
Text Domain: wsuwp-hrs-courses
Requires at least: 5.0
Tested up to: 5.2.3
Requires PHP: 7.0
*/
namespace WSUWP\HRS\Courses;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Loads the core plugin class.
 */
require __DIR__ . '/includes/class-wsuwp-hrs-courses.php';

// Starts things up.
add_action( 'plugins_loaded', __NAMESPACE__ . '\load_hrs_courses' );

// Flush rules on activation and clean up on deactivation.
register_activation_hook( __FILE__, array( __NAMESPACE__ . '\Setup\WSUWP_HRS_Courses', 'hrs_courses_activate' ) );
register_deactivation_hook( __FILE__, array( __NAMESPACE__ . '\Setup\WSUWP_HRS_Courses', 'hrs_courses_deactivate' ) );
register_uninstall_hook( __FILE__, array( __NAMESPACE__ . '\Setup\WSUWP_HRS_Courses', 'hrs_courses_uninstall' ) );

/**
 * Creates an instance of the HRS Courses class.
 *
 * @since 0.1.0
 *
 * @return WSUWP_HRS_Courses An instance of the WSUWP_HRS_Courses class.
 */
function load_hrs_courses() {
	$wsuwp_hrs_courses = Setup\WSUWP_HRS_Courses::get_instance( __FILE__ );
}
