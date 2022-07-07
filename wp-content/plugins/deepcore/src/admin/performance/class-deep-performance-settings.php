<?php
/**
 * Deep Performance Settings.
 *
 * @package Deep
 */

namespace Deep\Admin\Performance;

defined( 'ABSPATH' ) || exit;

/**
 * Class Settings.
 */
class Settings {
	/**
	 * Instance of this class.
	 *
	 * @since   2.1.0
	 * @access  public
	 * @var     Settings
	 */
	public static $instance;

	/**
	 * Option name.
	 *
	 * @var string
	 */
	private static $option_name = 'deep_performance';

	/**
	 * Settings
	 *
	 * @var array
	 */
	private static $settings = array();

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
		$this->hooks();
		$this->definition();
	}

	/**
	 * Definition.
	 *
	 * @since 2.1.0
	 * @access private
	 */
	private function definition() {
		self::$settings = self::get_settings();
	}

	/**
	 * Hooks.
	 *
	 * @since 2.1.0
	 * @access private
	 */
	private function hooks() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Returns google fonts setting.
	 *
	 * @since 2.1.0
	 * @access public
	 * @return boolean
	 */
	public static function is_disabled_google_fonts() {
		if ( ! empty( self::$settings['googleFonts'] ) ) {
			return true;
		}
	}

	/**
	 * Returns icons setting.
	 *
	 * @since 2.1.0
	 * @access public
	 * @return boolean
	 */
	public static function is_disabled_icons() {
		if ( ! empty( self::$settings['icons'] ) ) {
			return true;
		}
	}

	/**
	 * Returns animations setting.
	 *
	 * @since 2.1.0
	 * @access public
	 * @return boolean
	 */
	public static function is_disabled_animations() {
		if ( ! empty( self::$settings['animations'] ) ) {
			return true;
		}
	}

	/**
	 * Returns wp block library setting.
	 *
	 * @since 2.1.0
	 * @access public
	 * @return boolean
	 */
	public static function is_disabled_block_library() {
		if ( ! empty( self::$settings['wpBlockLibrary'] ) ) {
			return true;
		}
	}

	/**
	 * Returns frontend script setting.
	 *
	 * @since 2.1.0
	 * @access public
	 * @return boolean
	 */
	public static function is_disabled_frontend_script() {
		if ( ! empty( self::$settings['frontendScript'] ) ) {
			return true;
		}
	}

	/**
	 * Returns font awesome setting.
	 *
	 * @since 2.1.0
	 * @access public
	 * @return boolean
	 */
	public static function is_disabled_font_awesome() {
		if ( ! empty( self::$settings['fontAwesome'] ) ) {
			return true;
		}
	}

	/**
	 * Returns Elementor pro script setting.
	 *
	 * @since 2.1.0
	 * @access public
	 * @return boolean
	 */
	public static function is_disabled_elementor_pro_script() {
		if ( ! empty( self::$settings['elProScript'] ) ) {
			return true;
		}
	}

	/**
	 * Returns Elementor editor script setting.
	 *
	 * @since 2.1.0
	 * @access public
	 * @return boolean
	 */
	public static function is_disabled_elementor_editor_script() {
		if ( ! empty( self::$settings['elEditorScript'] ) ) {
			return true;
		}
	}

	/**
	 * Returns query string setting.
	 *
	 * @since 2.1.0
	 * @access public
	 * @return boolean
	 */
	public static function is_disabled_query_strings() {
		if ( ! empty( self::$settings['queryString'] ) ) {
			return true;
		}
	}

	/**
	 * Returns jQuery migrate setting.
	 *
	 * @since 2.1.0
	 * @access public
	 * @return boolean
	 */
	public static function is_disabled_jquery_migrate() {
		if ( ! empty( self::$settings['jQueryMigrate'] ) ) {
			return true;
		}
	}

	/**
	 * Returns emoji setting.
	 *
	 * @since 2.1.0
	 * @access public
	 * @return boolean
	 */
	public static function is_disabled_emoji() {
		if ( ! empty( self::$settings['emoji'] ) ) {
			return true;
		}
	}

	/**
	 * Returns leverage browser caching setting.
	 *
	 * @since 2.1.0
	 * @access public
	 * @return boolean
	 */
	public static function is_leverage_browser_caching() {
		if ( ! empty( self::$settings['leverageBrowserCaching'] ) ) {
			return true;
		}
	}

	/**
	 * Returns minify HTML setting.
	 *
	 * @since 2.1.0
	 * @access public
	 * @return boolean
	 */
	public static function is_minify_html() {
		if ( ! empty( self::$settings['minifyHTML'] ) ) {
			return true;
		}
	}

	/**
	 * Returns GZIP setting.
	 *
	 * @since 2.1.0
	 * @access public
	 * @return boolean
	 */
	public static function is_GZIP() {
		if ( ! empty( self::$settings['gzip'] ) ) {
			return true;
		}
	}

	/**
	 * Returns scripts interaction setting.
	 *
	 * @since 2.1.0
	 * @access public
	 * @return boolean
	 */
	public static function is_scripts_interaction() {
		if ( ! empty( self::$settings['scriptsAction'] ) ) {
			return true;
		}
	}

	/**
	 * Returns lazy load setting.
	 *
	 * @since 2.1.0
	 * @access public
	 * @return boolean
	 */
	public static function is_lazy_load() {
		if ( ! empty( self::$settings['lazyLoad'] ) ) {
			return true;
		}
	}

	/**
	 * Returns Deep performance settings.
	 *
	 * @since 2.1.0
	 * @access private
	 * @return array
	 */
	private static function get_settings() {
		$settings = get_option( self::$option_name );

		return $settings;
	}

	/**
	 * enqueue scripts.
	 *
	 * @since 2.1.0
	 * @access public
	 */
	public function enqueue_scripts() {
		if ( isset( $_GET['page'] ) && $_GET['page'] == 'wn-admin-performance' ) {
			wp_enqueue_script(
				'deep-performance',
				DEEP_URL . 'src/admin/performance/build/index.js',
				array( 'wp-element' ),
				DEEP_VERSION,
				true
			);

			wp_localize_script(
				'deep-performance',
				'deepSettings',
				array(
					'url'   => esc_url_raw( rest_url() ),
					'nonce' => wp_create_nonce( 'wp_rest' ),
				)
			);

			wp_enqueue_style(
				'deep-performance',
				DEEP_URL . 'src/admin/performance/build/index.css',
				array(),
				DEEP_VERSION,
				'all'
			);
		}
	}
}

Settings::get_instance();
