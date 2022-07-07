<?php
/**
 * Importer.
 *
 * @package Deep
 */

namespace Deep\Compatibility;

defined( 'ABSPATH' ) || exit;

class Importer {

	/**
	 * Find post ID.
	 *
	 * @since 2.1.0
	 *
	 * @access private
	 */
	private static function find_post_id( string $string, string $start, string $end ) {
		$start = preg_quote( $start, '/' );
		$end   = preg_quote( $end, '/' );

		$format  = '/(%s)(.*?';
		$format .= ')(%s)/';

		$pattern = sprintf( $format, $start, $end );
		preg_match( $pattern, $string, $matches );

		return $matches[2];
	}

	/**
	 * Update page template.
	 *
	 * @since 2.1.0
	 *
	 * @access public
	 */
	public static function update_page_template( $content ) {
		$pattern = '/^.*wp:post_id.*$/m';
		preg_match_all( $pattern, $content, $matches );

		foreach ( $matches[0] as $matche ) {
			$page_id = self::find_post_id( $matche, '<wp:post_id>', '</wp:post_id>' );
			update_post_meta( $page_id, '_wp_page_template', 'Deep Page' );
		}
	}
}
