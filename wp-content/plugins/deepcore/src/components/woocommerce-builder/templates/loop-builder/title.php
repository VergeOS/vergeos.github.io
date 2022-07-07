<?php
/**
 * Product Title
 *
 * @package Deep\Components\WooCommerce\Templates
 *
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$tag             = $args['tag'];
$title           = $product->get_title();
$link_to_product = 'yes' === $args['link_to_product'];
$link_target     = $args['link_target'];
$title_html      = '<' . $tag . ' class="product_title entry-title">' . $title . '</' . $tag . '>';

if ( $link_to_product ) {

	echo '<a href="' . get_permalink() . '" target="' . $link_target . '">' . $title_html . '</a>';
} else {

	echo $title_html;
}
