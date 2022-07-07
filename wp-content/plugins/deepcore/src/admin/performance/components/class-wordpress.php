<?php
/**
 * Deep Performance.
 *
 * WordPress.
 *
 * @package Deep
 */

namespace Deep\Admin\Performance\Components;

use Deep\Admin\Performance\Settings as Settings;

defined( 'ABSPATH' ) || exit;

/**
 * Class WordPress.
 */
class WordPress {
	/**
	 * Instance of this class.
	 *
	 * @since   2.1.0
	 * @access  public
	 * @var     WordPress
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
		add_action( 'wp_default_scripts', array( $this, 'jquery_migrate' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'dequeue_style' ) );
		add_action( 'init', array( $this, 'query_strings' ) );
		add_action( 'init', array( $this, 'emoji' ) );
	}

	/**
	 * dequeue style.
	 *
	 * @access public
	 * @since 2.1.0
	 */
	public function dequeue_style() {
		/**
		 * Disable wp block library.
		 */
		if ( Settings::is_disabled_block_library() ) {
			wp_dequeue_style( 'wp-block-library' );
		}
	}

	/**
	 * Disable jQuery migrate.
	 *
	 * @since 2.1.0
	 * @access public
	 */
	public function jquery_migrate( $scripts ) {
		if ( Settings::is_disabled_jquery_migrate() && ! is_admin() && ! empty( $scripts->registered['jquery'] ) ) {
			$scripts->registered['jquery']->deps = array_diff(
				$scripts->registered['jquery']->deps,
				array( 'jquery-migrate' )
			);
		}
	}

	/**
	 * Split query strings.
	 *
	 * @since 2.1.0
	 * @access public
	 */
	public function query_strings_split( $src ) {
		$output = preg_split( '/(&ver|\?ver)/', $src );

		return $output[0];
	}

	/**
	 * Disable query strings.
	 *
	 * @since 2.1.0
	 * @access public
	 */
	public function query_strings() {
		if ( Settings::is_disabled_query_strings() && ! is_admin() ) {
			add_filter( 'script_loader_src', array( $this, 'query_strings_split' ), 15 );
			add_filter( 'style_loader_src', array( $this, 'query_strings_split' ), 15 );
		}
	}

	/**
	 * Disable emoji.
	 *
	 * @since 2.1.0
	 * @access public
	 */
	public function emoji() {
		if ( Settings::is_disabled_emoji() ) {
			remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
			remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
			remove_action( 'wp_print_styles', 'print_emoji_styles' );
			remove_action( 'admin_print_styles', 'print_emoji_styles' );
			remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
			remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
			remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		}
	}
}

WordPress::get_instance();
