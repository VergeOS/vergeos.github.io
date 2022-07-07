<?php
/**
 * Single Product Rating
 *
 * @package Deep\Components\WooCommerce\Templates
 *
 * @version 5.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! wc_review_ratings_enabled() ) {
	return;
}

$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();

if ( $rating_count > 0 ) : ?>

	<div class="deep-woo-product-rating woocommerce-product-rating">
		<?php echo wc_get_rating_html( $average, $rating_count ); // WPCS: XSS ok. ?>
		<?php if ( comments_open() ) : ?>
			<?php //phpcs:disable ?>
			<a href="#reviews" class="woocommerce-review-link" rel="nofollow"><?php printf( _n( '%s Reviews', '%s Reviews', $review_count, 'deep' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?></a>
			<?php // phpcs:enable ?>
		<?php endif ?>
	</div>

<?php endif; ?>
