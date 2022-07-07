<?php
/**
 * Deep Header Builder Compatibility.
 *
 * @package Deep
 */

namespace Deep\Compatibility;

defined( 'ABSPATH' ) || exit;

class HeaderBuilder {

	/**
	 * Header builder content.
	 *
	 * @since 2.1.0
	 *
	 * @access public
	 */
	public static function header_content() {
		require_once 'header-content.php';
	}
}

add_action( 'wp_body_open', array( 'Deep\Compatibility\HeaderBuilder', 'header_content' ) );
