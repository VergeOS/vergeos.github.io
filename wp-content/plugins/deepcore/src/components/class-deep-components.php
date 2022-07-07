<?php
/**
 * Deep Components.
 *
 * @package Deep
 */

namespace Deep;

defined( 'ABSPATH' ) || exit;

/**
 * Class Components.
 */
class Components {
	/**
	 * Instance of this class.
	 *
	 * @since   1.1.9
	 * @access  public
	 * @var     Components
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
	 * @since   1.1.9
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
	 * @since 1.1.9
	 * @access private
	 */
	private function __construct() {
		$this->hooks();
		$this->definition();
	}

	/**
	 * Hooks.
	 *
	 * @since 1.1.9
	 * @access private
	 */
    private function hooks() {
        add_action( 'plugins_loaded', [$this, 'load_dependencies'] );
    }

	/**
	 * Definition.
	 *
	 * @since 1.1.9
	 * @access private
	 */
	private function definition() {
		self::$dir = trailingslashit( plugin_dir_path( __FILE__ ) );
	}

    /**
	 * Load the dependencies.
	 *
	 * @since 1.1.9
	 * @access public
	 */
    public function load_dependencies() {
        /**
         * WP Plugin
         */
        require_once ABSPATH . 'wp-admin/includes/plugin.php';

        /**
         * Helper
         */
        require_once self::$dir . 'functions/class-deep-helper.php';

        /**
         * Breadcrumbs
         */
        require_once self::$dir . 'helper-classes/breadcrumbs.php';

        /**
         * Category field
         */
        require_once self::$dir . 'helper-classes/cat-field.php';

        /**
         * Show IDs
         */
        require_once self::$dir . 'helper-classes/show-ids.php';

        /**
         * Get image
         */
        require_once self::$dir . 'helper-classes/get-the-image.php';

        /**
         * Blog helper
         */
        require_once self::$dir . 'helper-classes/deep-blog-helper.php';

        /**
         * Like
         */
        require_once self::$dir . 'helper-classes/wn-like.php';

        /**
         * Dynamic CSS
         */
        require_once self::$dir . 'dynamicfiles/dyncss.php';

        /**
         * Helper functions
         */
        require_once self::$dir . 'functions/functions-helper.php';

        /**
         * General functions
         */
        require_once self::$dir . 'functions/functions-general.php';

        /**
         * Content functions
         */
        require_once self::$dir . 'functions/functions-content.php';

        /**
         * WooCommerce Builder
         */
        if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
            require_once self::$dir . 'woocommerce-builder/src/woocommerce.php';
        }

        /**
         * Widgets
         */
        require_once self::$dir . 'widgets/widgets-init.php';

        /**
         * Webnus core
         */
        require_once self::$dir . 'webnus-core/webnus-core.php';

        /**
         * Lifterlms
         */
        if ( is_plugin_active( 'lifterlms/lifterlms.php' ) ) {
            require_once self::$dir . 'lifterlms/class-lifterlms.php';
        }

        /**
         * Elementor
         */
        require_once self::$dir . 'elementor/elementor-integration.php';

        /**
         * Themes Compatibility
         */
        require_once self::$dir . 'compatibility/themes-compatibility.php';
	}
}

Components::get_instance();
