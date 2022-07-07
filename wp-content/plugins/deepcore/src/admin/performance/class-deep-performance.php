<?php
/**
 * Deep Performance.
 *
 * @package Deep
 */

namespace Deep\Admin\Performance;

defined( 'ABSPATH' ) || exit;

/**
 * Class Performance.
 */
class Performance {
	/**
	 * Instance of this class.
	 *
	 * @since   2.1.0
	 * @access  public
	 * @var     Performance
	 */
	public static $instance;

	/**
	 * Performance directory.
	 *
	 * @var string
	 */
	private static $dir;

	/**
	 * Provides access to a single instance of a module using the singleton pattern.
	 *
	 * @since   2.1.0
	 * @return  object
	 */
	public static function get_instance() {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 *
	 * @since 2.1.0
	 * @access private
	 */
	private function __construct() {
		$this->definition();
		$this->load_dependencies();
	}

	/**
	 * Definition.
	 *
	 * @since 2.1.0
	 * @access private
	 */
	private function definition() {
		self::$dir = trailingslashit( plugin_dir_path( __FILE__ ) );
	}

	/**
	 * Load the dependencies.
	 *
	 * @since 2.1.0
	 * @access private
	 */
	private function load_dependencies() {
		/**
		 * Performance settings.
		 */
		require_once self::$dir . 'class-deep-performance-settings.php';

		/**
		 * Elementor.
		 */
		require_once self::$dir . 'components/class-elementor.php';

		/**
		 * WordPress.
		 */
		require_once self::$dir . 'components/class-wordpress.php';

		/**
		 * Leverage browser caching.
		 */
		require_once self::$dir . 'components/class-leverage-browser-caching.php';

		/**
		 * Minify HTML.
		 */
		require_once self::$dir . 'components/class-minify-html.php';

		/**
		 * GZIP Compression.
		 */
		require_once self::$dir . 'components/class-gzip.php';

		/**
		 * Scripts on user interaction.
		 */
		require_once self::$dir . 'components/class-scripts-interaction.php';

		/**
		 * Lazy load.
		 */
		require_once self::$dir . 'components/class-lazy-load.php';
	}
}

Performance::get_instance();
