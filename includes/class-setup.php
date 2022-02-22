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

			$instance->setup_hooks();
			$instance->includes();
			$instance->define_blocks();
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
		add_action( 'init', array( $this, 'register_dynamic_blocks' ) );
		add_filter( 'block_categories_all', array( $this, 'add_block_categories' ), 10, 2 );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_scripts' ) );
		add_action( 'enqueue_block_assets', array( $this, 'enqueue_scripts' ) );
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

		// The plugin API class.
		require __DIR__ . '/class-api.php';

		// The plugin Sideload Image class.
		require __DIR__ . '/class-sideload-image.php';
	}

	/**
	 * Defines an array of blocks to register.
	 *
	 * @since 0.5.0
	 */
	private function define_blocks() {
		$this->blocks = array(
			'salary-data'         => 'hrswpsqlsrv/salary-data',
			'job-classifications' => 'hrswpsqlsrv/job-classifications',
			'list-awards'         => 'hrswpsqlsrv/list-awards',
		);
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
	 * Retrieves the block registration file from every dynamic block.
	 *
	 * Block registration is managed on a block-by-block basis in 'blocks' directory
	 * (`src/blocks/{block-name}/index.php`) for dynamic blocks. Each dynamic
	 * block includes an 'index.php' file that handles registration and the render
	 * callback function. Because these are dynamic blocks they don’t use default
	 * block save implementation through the JS client. Instead they use a server
	 * component to render the output. @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/creating-dynamic-blocks/ Documentation on dynamic blocks.
	 *
	 * @since 0.2.0
	 */
	function register_dynamic_blocks() {
		$blocks_dir = dirname( __DIR__ ) . '/build/blocks';
		if ( ! file_exists( $blocks_dir ) ) {
			return;
		}

		foreach ( $this->blocks as $dir => $block_name ) {
			if ( ! file_exists( $blocks_dir . '/' . $dir . '/index.php' ) ) {
				continue;
			}

			require $blocks_dir . '/' . $dir . '/index.php';
		}
	}

	/**
	 * Adds a custom block category for the plugin blocks.
	 *
	 * Callback function for the `block_categories` WP filter hook.
	 *
	 * @since 0.3.0
	 *
	 * @param array $default_categories Array of default block categories.
	 * @return array Array of block categories.
	 */
	public function add_block_categories( $default_categories ) {
		$plugin_categories = array(
			array(
				'slug'  => self::$slug,
				'title' => __( 'HRS External Content', 'hrswp-sqlsrv-db' ),
			),
		);

		return wp_parse_args( $plugin_categories, $default_categories );
	}

	/**
	 * Enqueues the plugin editor scripts.
	 *
	 * @since 0.2.0
	 */
	public function enqueue_editor_scripts() {
		$plugin = get_option( self::$slug . '_plugin-status' );

		wp_enqueue_script(
			self::$slug . '-script',
			plugins_url( 'build/index.js', self::$basename ),
			array(
				'wp-blocks',
				'wp-block-editor',
				'wp-components',
				'wp-element',
				'wp-i18n',
				'wp-data',
				'wp-api-fetch',
				'wp-url',
				'wp-server-side-render',
			),
			$plugin['version']
		);

		wp_enqueue_style(
			self::$slug . 'editor-style',
			plugins_url( 'build/editor.css', self::$basename ),
			array(),
			$plugin['version']
		);
	}

	/**
	 * Enqueues the plugin frontend scripts.
	 *
	 * @since 0.3.0
	 */
	public function enqueue_scripts() {
		$has_block = false;
		foreach ( $this->blocks as $type ) {
			if ( false !== has_block( $type ) ) {
				$has_block = true;
				continue;
			}
		}

		if ( $has_block ) {
			$plugin = get_option( self::$slug . '_plugin-status' );

			wp_enqueue_style(
				self::$slug . '-style',
				plugins_url( 'build/style.css', self::$basename ),
				array(),
				$plugin['version']
			);
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
		$message = sprintf(
			/* translators: %s: hrswp-sqlsrv-config.php */
			__( 'ERROR: There doesn\'t seem to be a %s file. This is required for the HRSWP Sqlsrv DB plugin to work.', 'hrswp-sqlsrv-db' ),
			'<code>hrswp-sqlsrv-config.php</code>'
		);

		printf( '<div class="notice notice-error"><p>%s</p></div>', $message );
	}
}
