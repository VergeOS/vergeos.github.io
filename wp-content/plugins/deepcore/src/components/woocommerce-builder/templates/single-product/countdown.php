<?php
/**
 * Single Product Countdown
 *
 * @package Deep\Components\WooCommerce\Templates
 *
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$date_on_sale_to = $product->get_date_on_sale_to();
$date_on_sale_to = $date_on_sale_to->format( 'Y-m-d H:i:s' );
if ( empty( $date_on_sale_to ) ) {

	return;
}
$data_until  = strtotime( $date_on_sale_to );
$data_future = $date_on_sale_to;
$data_done   = $args['done'];

if ( $args['type'] == 'type-4' ) {
	$html = '<div class="countdown-clock" data-future="' . esc_attr( $data_future ) . '" data-done="' . esc_attr( $data_done ) . '"></div>';
} else {
	if ( $args['type'] == 'type-3' ) {
		$label = array(
			'day'     => esc_html__( 'DAYS', 'deep' ),
			'hours'   => esc_html__( 'HRS', 'deep' ),
			'minutes' => esc_html__( 'MIN', 'deep' ),
			'seconds' => esc_html__( 'SEC', 'deep' ),
		);
	} else {
		$label = array(
			'day'     => esc_html__( 'Days', 'deep' ),
			'hours'   => esc_html__( 'Hours', 'deep' ),
			'minutes' => esc_html__( 'Minutes', 'deep' ),
			'seconds' => esc_html__( 'Seconds', 'deep' ),
		);
	}

	$html  = '<div class="countdown-w ctd-' . esc_attr( $args['type'] ) . '" data-until="' . esc_attr( $data_until ) . '" data-done="' . esc_attr( $data_done ) . '" data-respond>';
	$html .= '<div class="days-w block-w"><i class="icon-w li_calendar"></i><div class="count-w"></div><div class="label-w">' . $label['day'] . '</div></div>';
	$html .= '<div class="hours-w block-w"><i class="icon-w wn-icon wn-far wn-fa-clock"></i><div class="count-w"></div><div class="label-w">' . $label['hours'] . '</div></div>';
	$html .= '<div class="minutes-w block-w"><i class="icon-w li_clock"></i><div class="count-w"></div><div class="label-w">' . $label['minutes'] . '</div></div>';
	$html .= '<div class="seconds-w block-w"><i class="icon-w wn-icon wn-fas wn-fa-hourglass-end"></i><div class="count-w"></div><div class="label-w">' . $label['seconds'] . '</div></div>';
	$html .= '</div>';
}

?>
<div class="deep-woo-product-countdown">
	<?php echo $html; ?>
</div>
