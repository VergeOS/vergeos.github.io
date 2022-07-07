<?php
/**
 * Single Product Sharing
 *
 * @package Deep\Components\WooCommerce\Templates
 *
 * @version 2.0.0
 */

use Deep\Components\WooCommerce\Helper\Social_Sharing;

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! is_a( $product, '\WC_Product' ) ) {
	return;
}

$product_id         = $product->get_id();
$btn_style          = $args['button_style'];
$social_share_links = $args['social_share_links_list'];

$args = array(
	'url'   => get_permalink( $product_id ),
	'title' => $product->get_name(),
	'desc'  => $product->get_description(),
);

$share_links = Social_Sharing::get_instance()->get_social_network_share_link_urls( $args );

switch ( $btn_style ) {
	case 'text':
		$btn_html = __( 'Share', 'deep' );
		break;
	case 'icon':
		$btn_html = '<i class="wn-fas wn-fa-share-alt"></i>';
		break;
	default:
		$btn_html = '';
}
?>
<div class="deep-woo-sharing">
	<div class="deep-woo-sharing-box">
		<a href="#deep-social-share-links-<?php echo esc_attr( $product_id ); ?>" data-target="#deep-social-share-links-<?php echo esc_attr( $product_id ); ?>" class="deep-btn-social-share-links"><?php echo $btn_html; ?></a>
		<div id="deep-social-share-links-<?php echo esc_attr( $product_id ); ?>" class="deep-social-share-links">
			<ul>
				<?php
				foreach ( $social_share_links as $social_share_link ) {

					$display = isset( $social_share_link['display'] ) && 'on' === $social_share_link['display'] ? true : false;
					if ( ! $display ) {

						continue;
					}

					$title          = isset( $social_share_link['title'] ) ? $social_share_link['title'] : '';
					$icon           = isset( $social_share_link['icon'] ) ? $social_share_link['icon'] : '';
					$custom_class   = isset( $social_share_link['custom_class'] ) ? $social_share_link['custom_class'] : '';
					$social_network = isset( $social_share_link['social_network'] ) ? $social_share_link['social_network'] : 'facebook';
					$url            = isset( $share_links[ $social_network ] ) ? $share_links[ $social_network ] : '#';

					echo '<li class="deep-social-share-link ' . esc_attr( $custom_class ) . '">
                            <a href="' . $url . '">
                                <i class="' . esc_attr( $icon ) . '"></i>
                                ' . esc_html( $title ) . '
                            </a>
                        </li>';
				}
				?>

			</ul>
		</div>
	</div>
</div>
