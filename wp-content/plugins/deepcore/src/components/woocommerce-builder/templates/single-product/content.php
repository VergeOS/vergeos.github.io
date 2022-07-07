<?php
/**
 * Single Product Content
 *
 * @package Deep\Components\WooCommerce\Templates
 *
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="deep-woo-product-content">
	<?php
		$content = the_content();
		echo do_shortcode( $content );
	?>
</div>
