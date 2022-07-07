(function ($) {
	/**
	 * @param $scope The Widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */
	var WidgetAddToCartHandler = function ($scope, $) {
		function wcqi_refresh_quantity_increments() {
			$( 'div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)' ).addClass( 'buttons_added' ).append( '<i class="ti-plus plus hcolorf"></i>' ).prepend( '<i class="ti-minus minus hcolorf"></i>' );
		}

		$( document ).on(
			'updated_wc_div',
			function () {
				wcqi_refresh_quantity_increments();
			}
		);

		$( document ).on(
			'click',
			'.minus',
			function () {
				var $this = $( this ),
				$wrap     = $this.closest( '.quantity.buttons_added' ),
				$input    = $wrap.find( 'input.qty' );
				if ($input.val() <= 1) {
					return;
				}
				var val = parseInt( $input.val() );
				--val;
				$input.attr( 'value', val )
				$input.trigger( 'change' );
			}
		);

		$( document ).on(
			'click',
			'.plus',
			function () {
				var $this = $( this ),
				$wrap     = $this.closest( '.quantity.buttons_added' ),
				$input    = $wrap.find( 'input.qty' );
				var val   = parseInt( $input.val() );
				++val;
				$input.attr( 'value', val )
				$input.trigger( 'change' );
			}
		);

		wcqi_refresh_quantity_increments();
	};

	// Make sure you run this code under Elementor.
	$( window ).on(
		'elementor/frontend/init',
		function () {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/deep-woo-add-to-cart.default', WidgetAddToCartHandler );
			elementorFrontend.hooks.addAction( 'frontend/element_ready/deep-woo-cart-table.default', WidgetAddToCartHandler );
		}
	);
})( jQuery );
