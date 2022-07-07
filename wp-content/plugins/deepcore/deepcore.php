<?php
/**
 * Plugin Name:     Deep Core
 * Plugin URI:      https://webnus.net/deep-wordpress-theme/
 * Description:     Deep theme core functions.
 * Version:         2.1.2
 * Author:          Webnus
 * Author URI:      https://webnus.net/
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     deep
 * Domain Path:     /languages
 */

namespace Deep;

defined( 'ABSPATH' ) || exit;

require_once ABSPATH . 'wp-admin/includes/plugin.php';

/**
 * Class Deep_Core.
 */
class Deep_Core {
	/**
	 * Instance of this class.
	 *
	 * @since   2.0.0
	 * @access  public
	 * @var     Deep_Core
	 */
	public static $instance;

	/**
	 * Provides access to a single instance of a module using the singleton pattern.
	 *
	 * @since   2.0.0
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
	 * @since 2.0.0
	 * @access private
	 */
	private function __construct() {
		$this->hooks();
		if ( defined( 'DEEPCOREPRO' ) ) {
			return;
		}
		$this->definition();
		$this->load_dependencies();
	}

	/**
	 * Hooks.
	 *
	 * @since 2.0.0
	 * @access private
	 */
    private function hooks() {
		register_activation_hook( __FILE__, [$this, 'activate'] );
		add_action( 'admin_init', [$this, 'activation_redirect'] );
    }

	/**
	 * Definition.
	 *
	 * @since 2.0.0
	 * @access private
	 */
	private function definition() {
		if ( ! defined( 'DEEPCORE' ) ) {
			define( 'DEEPCORE', true );
		}
		if ( ! defined( 'DEEPFREE' ) ) {
			define( 'DEEPFREE', true );
		}
		if ( ! defined( 'DEEP_VERSION' ) ) {
			define( 'DEEP_VERSION', '2.1.2' );
		}
		if ( ! defined( 'DEEP_DIR' ) ) {
			define( 'DEEP_DIR', plugin_dir_path( __FILE__ ) );
		}
		if ( ! defined( 'DEEP_URL' ) ) {
			define( 'DEEP_URL', plugin_dir_url( __FILE__ ) );
		}
		if ( ! defined( 'DEEP_ASSETS_URL' ) ) {
			define( 'DEEP_ASSETS_URL', DEEP_URL . 'assets/dist/' );
		}
		if ( ! defined( 'DEEP_ASSETS_DIR' ) ) {
			define( 'DEEP_ASSETS_DIR', DEEP_DIR . 'assets/dist/' );
		}
		if ( ! defined( 'DEEP_SRC_DIR' ) ) {
			define( 'DEEP_SRC_DIR', DEEP_DIR . 'src/' );
		}
		if ( ! defined( 'DEEP_SVG' ) ) {
			define( 'DEEP_SVG', '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="562 242 76 76" style="enable-background:new 562 242 76 76;" xml:space="preserve"><g id="Rectangle_3"><g><linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="570.627" y1="322.1832" x2="616.2863" y2="246.1934" gradientTransform="matrix(1 0 0 -1 0 560)"><stop  offset="0" style="stop-color:#4400D0"/><stop  offset="0.43" style="stop-color:#6520F4"/><stop  offset="1" style="stop-color:#930AFD"/></linearGradient><path class="st0" d="M599.8,242.7h-30.6h-1.1h-5.6v60.8h5.6h1.1h30.6c13.1,0,23.9-10.4,23.9-23.9s-10.4-23.9-23.9-23.9h-23.9v2.6 v4.5V290h1.9h5.2h17.2c5.6,0,10.1-4.5,10.1-10.1s-4.5-10.1-10.1-10.1h-10.4v6.7h10.4c1.9,0,3.4,1.5,3.4,3.4c0,1.9-1.5,3.4-3.4,3.4 H583v-20.1h17.2c9.3,0,16.8,7.5,16.8,16.8s-7.5,16.8-16.8,16.8h-30.6v-47.4h30.6c16.8,0,30.6,13.8,30.6,30.6s-13.8,30.6-30.6,30.6 h-23.9v6.7h23.9c20.5,0,37.3-16.8,37.3-37.3S620.3,242.7,599.8,242.7z"/></g></g></svg>' );
		}
		if ( ! defined( 'DEEP_COMPONENTS_DIR' ) ) {
			define( 'DEEP_COMPONENTS_DIR', DEEP_DIR . '/src/components/' );
		}
		if ( ! defined( 'DEEP_COMPONENTS_URL' ) ) {
			define( 'DEEP_COMPONENTS_URL', DEEP_URL . '/src/components/' );
		}
	}

    /**
	 * Load the dependencies.
	 *
	 * @since 2.0.0
	 * @access public
	 */
    public function load_dependencies() {
		/**
		 * Admin
		 */
		require_once DEEP_SRC_DIR . 'admin/class-deep-admin.php';

		/**
		 * Front
		 */
		require_once DEEP_SRC_DIR . 'front/class-deep-front.php';

		/**
		 * Components
		 */
		require_once DEEP_SRC_DIR . 'components/class-deep-components.php';
	}

	/**
	 * Deactivate deepcore and add activation option.
	 *
	 * @since 2.0.0
	 * @access public
	 */
	public function activate() {
		if ( is_plugin_active( 'deep-core-pro/deep-core-pro.php' ) ) {
			die( 'You have installed the Deep Core Pro version and you couldn\'t activate the Deep Core free plugin. They will not work together at the same time. If you think there is something wrong please contact our support team.' );
		}
		add_option( 'deep_core_activation_redirect', true );
	}

	/**
	 * Setup wizard redirect.
	 *
	 * @since 2.0.0
	 * @access public
	 */
	public function activation_redirect() {
		if ( get_option( 'deep_core_activation_redirect' ) == true && self::is_deep_theme() ) {
			update_option( 'deep_core_activation_redirect', false );
			if ( current_user_can( 'manage_options' ) && class_exists( 'TGMPA_List_Table' ) ) {
				wp_redirect( admin_url( 'index.php?page=webnus-setup-wizard' ) );
			}
			exit;
		}
	}

	/**
	 * Check if the current theme is Deep.
	 *
	 * @since 2.0.0
	 * @access public
	 * @return boolean
	 */
	public static function is_deep_theme() {
		if ( get_theme_mod( 'deep_theme_install' ) ) {
			return true;
		}
	}
}

Deep_Core::get_instance();
