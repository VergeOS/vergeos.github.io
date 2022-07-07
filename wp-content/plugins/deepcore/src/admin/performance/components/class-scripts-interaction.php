<?php
/**
 * Deep Performance.
 *
 * Loads scripts on user interaction.
 *
 * @package Deep
 */

namespace Deep\Admin\Performance\Components;

use Deep\Admin\Performance\Settings as Settings;

defined( 'ABSPATH' ) || exit;

/**
 * Class Scripts_interaction.
 */
class Scripts_interaction {
	/**
	 * Instance of this class.
	 *
	 * @since   2.1.0
	 * @access  public
	 * @var     Scripts_interaction
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
		if ( ! Settings::is_scripts_interaction() || is_user_logged_in() ) {
			return;
		}
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_print_scripts', array( $this, 'scripts' ) );
		add_action( 'wp_print_footer_scripts', array( $this, 'scripts' ) );
	}

	/**
	 * enqueue scripts.
	 *
	 * @since 2.1.0
	 * @access public
	 */
	public function enqueue_scripts() {
		wp_enqueue_script(
			'after-page-load',
			DEEP_URL . 'src/admin/performance/src/after-page-load.js',
			array( 'jquery' ),
			DEEP_VERSION,
			null,
			true
		);
	}

	/**
	 * Gets scripts list.
	 *
	 * @since 2.1.0
	 * @access public
	 */
	public function scripts() {
		global $wp_scripts;

		$scripts = array();

		foreach ( $wp_scripts->queue as $handle ) {
			if ( $handle == 'after-page-load' ) {
				continue;
			}
			$scripts[] = $wp_scripts->registered[ $handle ]->src;

			wp_deregister_script( $handle );
			wp_dequeue_script( $handle );
		}

		wp_localize_script(
			'after-page-load',
			'deep_enq_scripts',
			$scripts
		);
	}
}

Scripts_interaction::get_instance();
