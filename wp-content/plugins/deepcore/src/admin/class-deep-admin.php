<?php
/**
 * Deep Admin.
 *
 * @package Deep
 */

namespace Deep\Admin;

defined( 'ABSPATH' ) || exit;

use Deep\Deep_Core;

/**
 * Class Deep_Admin.
 */
class Deep_Admin {
	/**
	 * Instance of this class.
	 *
	 * @since   1.1.7
	 * @access  public
	 * @var     Deep_Admin
	 */
	public static $instance;

	/**
	 * Admin directory.
	 *
	 * @var string
	 */
	private static $dir;

	/**
	 * Provides access to a single instance of a module using the singleton pattern.
	 *
	 * @since   1.1.7
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
	 * @since 1.1.7
	 * @access private
	 */
	private function __construct() {
		$this->hooks();
		$this->definition();
        $this->load_dependencies();
	}

	/**
	 * Hooks.
	 *
	 * @since 1.1.9
	 * @access private
	 */
    private function hooks() {
		add_action( 'plugins_loaded', [$this, 'textdomain'] );
	}

	/**
	 * Definition.
	 *
	 * @since 1.1.7
	 * @access private
	 */
	private function definition() {
		self::$dir = trailingslashit( plugin_dir_path( __FILE__ ) );
	}

    /**
	 * Load the dependencies.
	 *
	 * @since 1.1.7
	 * @access private
	 */
    private function load_dependencies() {
		/**
		 * Meta box core
		 */
		require_once self::$dir . 'meta-box/meta-box-core/meta-box.php';

		/**
		 * Meta box config
		 */
		require_once self::$dir . 'meta-box/meta-box-config.php';

		/**
		 * Header builder
		 */
		require_once self::$dir . 'header-builder/webnus-header-builder.php';

		/**
		 * Redux framework
		 */
		require_once self::$dir . 'theme-options/ReduxCore/framework.php';

		/**
		 * Options config
		 */
		require_once self::$dir . 'theme-options/theme-options-config.php';

		/**
         * Navigation
         */
        require_once self::$dir . 'navigation/navigation.php';

		/**
         * Mega menu post type
         */
        require_once self::$dir . 'navigation/mega-menu-post-type.php';

		/**
         * Footer builder post type
         */
        require_once self::$dir . 'footer-builder/footer-builder-post-type.php';

		/**
		 * API performance settings.
		 */
		require_once self::$dir . 'performance/API/class-settings-api.php';

		/**
		 * Performance.
		 */
		require_once self::$dir . 'performance/class-deep-performance.php';

		if ( is_admin() ) {
			/**
			 * Setup wizard
			 */
			require_once self::$dir . 'setup-wizard/class-setup-wizard.php';

			/**
			 * Deep admin
			 */
			require_once self::$dir . 'dashboard/webnus-admin.php';

			/**
			 * Demo importer.
			 */
			require_once self::$dir . 'importer/config/setup.php';

			/**
			 * Messages.
			 */
			require_once self::$dir . 'message/class-deep-message.php';

			/**
             * Plugin Activator.
             */
			if ( ! Deep_Core::is_deep_theme() ) {
				require_once self::$dir . 'plugins/plugin-activator/deeptheme-plugins.php';
			}
		}
	}

	/**
	 * Languages.
	 *
	 * @since 1.1.9
	 * @access public
	 */
	public function textdomain() {
		load_plugin_textdomain( 'deep', false, basename( dirname( __FILE__ ) ) . '/languages/' );
	}
}

Deep_Admin::get_instance();
