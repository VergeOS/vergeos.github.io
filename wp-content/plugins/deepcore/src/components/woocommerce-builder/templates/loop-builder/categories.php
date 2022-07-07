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
$separator = isset( $args['separator'] ) ? $args['separator'] : '|';
$separator = ! empty( $separator ) ? '<span class="separator">' . $separator . '</span>' : '';
echo get_the_term_list( $product->get_id(), 'product_cat', '<div class="deep-woo-product-cats">', $separator, '</div>' );
