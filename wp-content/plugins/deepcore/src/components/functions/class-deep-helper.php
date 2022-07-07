<?php
/**
 * Deep Helper.
 *
 * @package Deep
 */

namespace Deep\Components;

defined( 'ABSPATH' ) || exit;

/**
 * Class Helper.
 */
class Helper {

	/**
	 * Instance of this class.
	 *
	 * @since  2.0.0
	 * @access public
	 * @var    Helper
	 */
	public static $instance;

	/**
	 * Provides access to a single instance of a module using the singleton pattern.
	 *
	 * @since  2.0.0
	 * @return object
	 */
	public static function instance() {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 *
	 * @since  2.0.0
	 * @access private
	 */
	private function __construct() {
	}

	/**
	 * Insert post.
	 *
	 * @since  2.0.0
	 * @access public
	 */
	public static function insert_post( string $post_type, string $name, string $tag ) {
		$post = get_page_by_title( $name, ARRAY_A, $post_type );
		if ( ! empty( $post ) ) {
			return;
		}
		$post_id = wp_insert_post(
			array(
				'post_title'  => $name,
				'post_status' => 'publish',
				'post_type'   => $post_type,
				'post_author' => 1,
				'tags_input'  => array( $tag ),
			)
		);

		return $post_id;
	}
}
