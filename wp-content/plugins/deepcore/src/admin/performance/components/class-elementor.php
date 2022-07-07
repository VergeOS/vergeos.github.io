<?php
/**
 * Deep Performance.
 *
 * Elementor.
 *
 * @package Deep
 */

namespace Deep\Admin\Performance\Components;

use Deep\Admin\Performance\Settings as Settings;

defined( 'ABSPATH' ) || exit;

/**
 * Class Elementor.
 */
class Elementor {
	/**
	 * Instance of this class.
	 *
	 * @since   2.1.0
	 * @access  public
	 * @var     Elementor
	 */
	public static $instance;

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
	}

	/**
	 * Hooks.
	 *
	 * @since 2.1.0
	 * @access private
	 */
	private function hooks() {
		if ( ! did_action( 'elementor/loaded' ) ) {
			return;
		}
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'elementor_frontend_script' ) );
		add_action( 'elementor/frontend/after_register_styles', array( $this, 'elementor_font_awesome' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'elementor_editor_script' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'elementor_pro_script' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'dequeue_style' ) );
		add_action( 'init', array( $this, 'elementor_google_fonts' ) );
	}

	/**
	 * dequeue style.
	 *
	 * @access public
	 * @since 2.1.0
	 */
	public function dequeue_style() {
		/**
		 * Disable Elementor icons.
		 */
		if ( Settings::is_disabled_icons() ) {
			wp_deregister_style( 'elementor-icons' );
		}

		/**
		 * Disable Elementor animations.
		 */
		if ( Settings::is_disabled_animations() ) {
			wp_deregister_style( 'elementor-animations' );
		}
	}

	/**
	 * Disable Elementor google fonts.
	 *
	 * @since 2.1.0
	 * @access public
	 */
	public function elementor_google_fonts() {
		if ( Settings::is_disabled_google_fonts() ) {
			add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );
		}
	}

	/**
	 * Disable Elementor frontend script.
	 *
	 * @since 2.1.0
	 * @access public
	 */
	public function elementor_frontend_script() {
		if ( Settings::is_disabled_frontend_script() ) {
			wp_deregister_script( 'elementor-frontend' );
			wp_deregister_script( 'elementor-frontend-modules' );
		}
	}

	/**
	 * Disable Elementor font awesome.
	 *
	 * @since 2.1.0
	 * @access public
	 */
	public function elementor_font_awesome() {
		if ( Settings::is_disabled_font_awesome() ) {
			foreach ( array( 'solid', 'regular', 'brands' ) as $style ) {
				wp_deregister_style( 'elementor-icons-fa-' . $style );
			}
		}
	}

	/**
	 * Disable Elementor Pro script.
	 *
	 * @since 2.1.0
	 * @access public
	 */
	public function elementor_pro_script() {
		if ( Settings::is_disabled_elementor_pro_script() && defined( 'ELEMENTOR_PRO_URL' ) ) {
			wp_deregister_script( 'elementor-pro-frontend' );
		}
	}

	/**
	 * Disable Elementor editor script.
	 *
	 * @since 2.1.0
	 * @access public
	 */
	public function elementor_editor_script() {
		if ( Settings::is_disabled_elementor_editor_script() && is_front_page() && ! is_user_logged_in() ) {
			wp_dequeue_script( 'elementor-common-modules' );
			wp_dequeue_script( 'elementor-app-loader' );
			wp_dequeue_script( 'jquery-ui-draggable' );
			wp_dequeue_script( 'backbone-marionette' );
			wp_dequeue_script( 'elementor-dialog' );
			wp_dequeue_script( 'elementor-common' );
			wp_dequeue_script( 'backbone-radio' );
			wp_dequeue_script( 'elementor-app' );
		}
	}
}

Elementor::get_instance();
