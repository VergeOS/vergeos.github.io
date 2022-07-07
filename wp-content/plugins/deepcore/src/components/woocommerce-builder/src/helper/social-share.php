<?php
/**
 * WooCommerce Social_Sharing.
 *
 * @since 2.0.0
 * @package Deep
 */

namespace Deep\Components\WooCommerce\Helper;

defined( 'ABSPATH' ) || exit;

/**
 * Class Social_Sharing
 */
class Social_Sharing {

	/**
	 * Instance of this class.
	 *
	 * @access  public
	 * @var     Social_Sharing
	 */
	public static $instance;

	/**
	 * Provides access to a single instance of a module using the singleton pattern.
	 *
	 * @return  object
	 */
	public static function get_instance() {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Get All Social Networks
	 *
	 * @return array
	 */
	public function get_social_networks() {

		$social_networks = array(
			'facebook'         => __( 'Facebook', 'deep' ),
			'reddit'           => __( 'Reddit', 'deep' ),
			'whatsapp'         => __( 'WhatsApp', 'deep' ),
			'twitter'          => __( 'Twitter', 'deep' ),
			'linkedin'         => __( 'linkedin', 'deep' ),
			'tumblr'           => __( 'Tumblr', 'deep' ),
			'pinterest'        => __( 'Pinterest', 'deep' ),
			'email'            => __( 'Email', 'deep' ),
			'telegram'         => __( 'Telegram', 'deep' ),
			'vk'               => __( 'VK', 'deep' ),
		);

		return apply_filters( 'deep_get_all_social_networks', $social_networks );
	}

	/**
	 * Get Social Network Share Links
	 *
	 * @param array $args
	 * @return array
	 */
	public function get_social_network_share_link_urls( $args ) {

		$url   = urlencode( $args['url'] );
		$title = urlencode( $args['title'] );
		$desc  = urlencode( $args['desc'] );

		$via               = '';
		$hash_tags         = '';
		$phone_number      = '';
		$email_address     = '';

		$text = $title;

		if ( $desc ) {
			$text .= '%20%3A%20';
			$text .= $desc;
		}

		$urls = array(
			'email'            => 'mailto:' . $email_address . '?subject=' . $title . '&body=' . $desc,
			'facebook'         => 'http://www.facebook.com/sharer.php?u=' . $url,
			'linkedin'         => 'https://www.linkedin.com/sharing/share-offsite/?url=' . $url,
			'pinterest'        => 'http://pinterest.com/pin/create/button/?url=' . $url,
			'reddit'           => 'https://reddit.com/submit?url=' . $url . '&title=' . $title,
			'telegram'         => 'https://t.me/share/url?url=' . $url . '&text=' . $text . '&to=' . $phone_number,
			'tumblr'           => 'https://www.tumblr.com/widgets/share/tool?canonicalUrl=' . $url . '&title=' . $title . '&caption=' . $desc . '&tags=' . $hash_tags,
			'twitter'          => 'https://twitter.com/intent/tweet?url=' . $url . '&text=' . $text . '&via=' . $via . '&hashtags=' . $hash_tags,
			'vk'               => 'http://vk.com/share.php?url=' . $url . '&title=' . $title . '&comment=' . $desc,
			'whatsapp'         => 'https://api.whatsapp.com/send?text=' . $text . '%20' . $url,
		);

		return apply_filters( 'deep_get_social_network_share_link_urls', $urls );
	}
}
