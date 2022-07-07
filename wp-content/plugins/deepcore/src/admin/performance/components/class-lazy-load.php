<?php
/**
 * Deep Performance.
 *
 * Lazy load img tag.
 *
 * @package Deep
 */

namespace Deep\Admin\Performance\Components;

use Deep\Admin\Performance\Settings as Settings;

defined( 'ABSPATH' ) || exit;

/**
 * Class Lazy_Load.
 */
class Lazy_Load {
	/**
	 * Instance of this class.
	 *
	 * @since   2.1.0
	 * @access  public
	 * @var     Lazy_Load
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
		if ( ! Settings::is_lazy_load() ) {
			return;
		}
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * enqueue scripts.
	 *
	 * @since 2.1.0
	 * @access public
	 */
	public function enqueue_scripts() {
		wp_enqueue_script(
			'deep-lozad',
			DEEP_URL . 'src/admin/performance/src/lozad.js',
			array(),
			DEEP_VERSION,
			null,
			true
		);

		wp_enqueue_script(
			'deep-lazy-load',
			DEEP_URL . 'src/admin/performance/src/lazy-load.js',
			array( 'jquery' ),
			DEEP_VERSION,
			null,
			true
		);
	}
}

Lazy_Load::get_instance();
