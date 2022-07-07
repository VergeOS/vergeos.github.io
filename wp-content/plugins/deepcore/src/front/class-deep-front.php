<?php
/**
 * Deep Front.
 *
 * @package Deep
 */

namespace Deep\Front;

defined( 'ABSPATH' ) || exit;

/**
 * Class Deep_Front.
 */
class Deep_Front {
	/**
	 * Instance of this class.
	 *
	 * @since   4.4.0
	 * @access  public
	 * @var     Deep_Front
	 */
	public static $instance;

	/**
	 * Front directory.
	 *
	 * @var string
	 */
	private static $dir;

	/**
	 * Provides access to a single instance of a module using the singleton pattern.
	 *
	 * @since   4.4.0
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
	 * @since 4.4.0
	 * @access private
	 */
	private function __construct() {
		$this->definition();
        $this->load_dependencies();
	}

	/**
	 * Definition.
	 *
	 * @since 4.4.0
	 * @access private
	 */
	private function definition() {
		self::$dir = trailingslashit( plugin_dir_path( __FILE__ ) );
	}

    /**
	 * Load the dependencies.
	 *
	 * @since 4.4.0
	 * @access private
	 */
    private function load_dependencies() {
		if ( is_admin() ) {
			return;
		}

		/**
		 * Preloader Class.
		 */
		if ( self::deep_options()['enable_preloader'] == '1' ) {
			require_once self::$dir . 'class-deep-preloader.php';
		}

		/**
		 * Assets Class.
		 */
		require_once self::$dir . 'class-deep-assets.php';

		/**
		 * Templates
		 */
		require_once DEEP_SRC_DIR . 'templates/single-templates/single-templates.php';
	}

	/**
	 * Deep Options.
	 *
	 * @since 4.4.0
	 * @access public
	 */
	public static function deep_options() {
		$deep_options = get_option( 'deep_options' );

		return $deep_options;
	}
}

Deep_Front::get_instance();
