<?php
/**
 * Product Thumbnail
 *
 * @package Deep\Components\WooCommerce\Templates
 *
 * @version 5.5.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
echo '<div class="deep-woo-product-thumbnail">';
echo '<a href="'. get_the_permalink().'">' . woocommerce_get_product_thumbnail() .'</a>';
echo '</div>';
