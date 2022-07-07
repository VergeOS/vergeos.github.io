<?php
function whb_lifterlms_search( $atts, $uniqid, $once_run_flag ) {
	extract(
		WHB_Helper::component_atts(
			array(
				'text'          => 'Search For The Courses, Software or Skills You Want to Learn...',
				'search_button' => 'text',
				'extra_class'   => '',
			),
			$atts
		)
	);

	if ( is_plugin_active( 'lifterlms/lifterlms.php' ) ) {
		// styles
		if ( $once_run_flag ) :

			$dynamic_style  = '';
			$dynamic_style .= whb_styling_tab_output( $atts, 'Button', '#wrap #webnus-header-builder [data-id=whb-lifterlms-search-' . esc_attr( $uniqid ) . '] .whb-lifterlms-search-btn input#searchsubmit', '#wrap #webnus-header-builder [data-id=whb-lifterlms-search-' . esc_attr( $uniqid ) . ']:hover .whb-lifterlms-search-btn input#searchsubmit' );
			$dynamic_style .= whb_styling_tab_output( $atts, 'Input', '#wrap #webnus-header-builder [data-id=whb-lifterlms-search-' . esc_attr( $uniqid ) . '] .whb-lifterlms-search-input input' );
			$dynamic_style .= whb_styling_tab_output( $atts, 'Box', '#wrap #webnus-header-builder [data-id=whb-lifterlms-search-' . esc_attr( $uniqid ) . '].whb-lifterlms-search-wrap' );

			if ( $dynamic_style ) :
				WHB_Helper::set_dynamic_styles( $dynamic_style );
			endif;
		endif;

		$search_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="20.396" height="20.396" viewBox="0 0 20.396 20.396"> <path d="M20.4,19.5l-6.355-6.355A7.981,7.981,0,0,0,2.336,2.31a7.981,7.981,0,0,0,10.837,11.7l6.355,6.355ZM7.985,14.713a6.756,6.756,0,1,1,6.756-6.756A6.764,6.764,0,0,1,7.985,14.713Z" transform="translate(0 0.028)"/></svg> ';

		// extra class
		$extra_class = $extra_class ? ' ' . $extra_class : '';
		$url         = get_home_url();
		$text        = $text ? $text : '';
		$button      = $search_button ? $search_button : '';
		$button_type = '';

		if ( 'icon' === $button ) {
			$button_type = $search_icon;
		} elseif ( 'text' === $button ) {
			$button_type = '<input type="submit" id="searchsubmit" value="' . esc_html__( 'Search', 'deep' ) . '">';
		}

		$out = '
			<div class="whb-element whb-element-wrap whb-lifterlms-search-wrap' . esc_attr( $extra_class ) . '" data-id="whb-lifterlms-search-' . esc_attr( $uniqid ) . '">
			<form role="search" action="' . $url . '" method="get" _lpchecked="1">
				<div class="whb-lifterlms-search-input">
					<input name="s" type="text" placeholder="' . esc_html( $text ) . '">
				</div>
				<input type="hidden" name="post_type" value="course">
				<div class="whb-lifterlms-search-btn">
					' . $button_type . '
				</div>
			</form>
			</div>';

		return $out;
	}
}

WHB_Helper::add_element( 'lifterlms-search-form', 'whb_lifterlms_search' );
