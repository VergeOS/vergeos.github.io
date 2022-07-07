<?php
/**
 * WooCommerce Widget Base.
 *
 * @since 2.0.0
 * @package Deep
 */

namespace Deep\WooCommerce\Elementor;

use Elementor\Plugin;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;

defined( 'ABSPATH' ) || exit;

/**
 * Deep_Widget_Base class
 *
 * @version 2.0.0
 */
abstract class Deep_Widget_Base extends Widget_Base {

	/**
	 * Is Edit Mode
	 *
	 * @return boolean
	 */
	public function is_edit_mode(){

        return
			Plugin::$instance->editor->is_edit_mode()
			||
			( isset( $_POST['action'] ) && 'elementor_ajax' === $_POST['action'] );
    }

	/**
	 * Prepare Args For Register Control
	 *
	 * @param array  $atts
	 * @param array  $args
	 * @param string $css_property_pattern
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function prepare_args( $atts, $args, $css_property_pattern = '' ) {

		/** Default Begin */
		if ( isset( $atts['default'] ) && ! empty( $atts['default'] ) ) {

			$args['default'] = $atts['default'];
		}
		/** Default End */

		/** Condition Begin */
		if ( isset( $atts['condition'] ) && ! empty( $atts['condition'] ) ) {

			$args['condition'] = $atts['condition'];
		}
		/** Condition End */

		/** CSS Selector Begin */
		$selector  = isset($atts['selector']) ? $atts['selector'] : $this->deep_base_selector;
		$selectors = isset($atts['selectors']) ? $atts['selectors'] : '';

		if ( ! empty( $css_property_pattern ) ) {

			$selectors = array(
				$selector => $css_property_pattern,
			);
		}

		if ( ! empty( $selectors ) ) {

			$args['selectors'] = $selectors;
		} else {

			$args['selector'] = $selector;
		}
		/** CSS Selector End */

		return apply_filters( 'deep_elementor_widget_prepare_args', $args );
	}

	/**
	 * Register Controls
	 *
	 * @param array $controls
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function deep_register_controls( $controls ) {

		foreach ( $controls as $atts ) {

			$this->deep_register_control( $atts );
		}
	}

	/**
	 * Initialize Array of Controls
	 *
	 * @since 2.0.0
	 *
	 * @access Public
	 *
	 * @param array $controls
	 * @param array $rewrite_controls
	 * @param string $group_id
	 *
	 * @return array
	 */
	public function deep_init_controls( $controls, $rewrite_controls, $group_id, $selector, $hover_type = '' ){

		if( empty( $rewrite_controls ) || !is_array( $rewrite_controls ) ){

			return $controls;
		}

		//Add Custom Controls
		foreach( $rewrite_controls as $r_control_id => $r_control ){

			if( false === $r_control ){

				unset( $controls[ $r_control_id ] );
				continue;
			}

			$find_hover = false !== strpos( $r_control_id, 'hover_');
			if( ($hover_type && !$find_hover) || (!$hover_type && $find_hover) ){

				continue;
			}

			$type = isset( $r_control['type'] ) ? $r_control['type'] : false;
			$name = $group_id . $type;


			if( !$type ){

				continue;
			}

			switch( $type ){

				case 'box_width':
				case 'image_width':
				case 'width':
				case 'height':
				case 'min_width':
				case 'min_height':
				case 'max_width':
				case 'max_height':
				case 'opacity':
				case 'transition':
				case 'font_size':

				case 'css_filter':

				case 'hover_animation':

				case 'float':
				case 'html_tag':
				case 'display':
				case 'switcher':
				case 'show_hide':

				case 'position':
				case 'position_space':

				case 'position_top':
				case 'position_bottom':
				case 'position_right':
				case 'position_left':

				case 'icon_align':
				case 'text_align':
				case 'align':

				case 'table_layout':

					$labels = [
						'box_width' => __('Box Width','deep'),
						'image_width' => __('Image Width','deep'),
						'width' => __('Width','deep'),
						'height' => __('Height','deep'),
						'min_width' => __('Min Width','deep'),
						'min_height' => __('Min Height','deep'),
						'max_width' => __('Max Width','deep'),
						'max_height' => __('Max Height','deep'),
						'opacity' => __('Opacity','deep'),
						'transition' => __('Transition','deep'),
						'font_size' => __('Font Size','deep'),

						'switcher' => __('On/Off','deep'),
						'show_hide' => __('Show/Hide','deep'),

						'css_filter' => __('CSS Filter','deep'),

						'float' => __('Float','deep'),
						'hover_animation' => __('Hover Animation','deep'),
						'html_tag' => __('HTML Tag','deep'),
						'display' => __('Display','deep'),
						'switcher' => __('Switcher','deep'),

						'position' => __( 'Position', 'deep'),
						'position_space' => __( 'Position Space', 'deep'),
						'position_top' => __( 'Position Top', 'deep'),
						'position_bottom' => __( 'Position Bottom', 'deep'),
						'position_right' => __( 'Position Right', 'deep'),
						'position_left' => __( 'Position Left', 'deep'),

						'table_layout' => __( 'Table Layout', 'deep'),
					];

					if( $r_control ){

						$controls[ $r_control_id ] = [
							'name'  => $name,
							'selector' => $selector
						];

						if( isset( $labels[ $type ] ) ){

							$controls[ $r_control_id ]['label'] = $labels[ $type ];
						}
					}

					break;
			}
		}

		//Rewrite Controls
		foreach( $controls as $control_id => $control_args ){

			if( !isset( $rewrite_controls[ $control_id ] ) ){

				continue;
			}

			$settings_field_args = $rewrite_controls[ $control_id ];

			if( is_numeric( $settings_field_args ) || is_bool( $settings_field_args ) ){

				continue;
			} elseif ( is_array( $settings_field_args ) ){

				$control_args = wp_parse_args( $settings_field_args, $control_args );
			} else {

				$control_args['selector'] = $settings_field_args;
			}

			$controls[ $control_id ] = $control_args;
		}

		return $controls;
	}

	/**
	 * Register Share Links Icon Style Controls
	 *
	 * @since 2.0.0
	 *
	 * @access Public
	 *
	 * @return void
	 */
	public function deep_register_styles_controls( $group_id, $section_label, $description, $primary_selector,$primary_hover_selector, $rewrite_settings_fields = [], $condition = [] ){

		$this->start_controls_section(
			$group_id. 'section',
			[
				'label' => $section_label,
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => $condition,
			]
		);

		if( !empty( $description ) ){

			$this->add_control(
				$group_id.'description',
				[
					'label' 	=> $description,
					'type'	 	=> Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
		}

		$tabs = [
			'normal' => __('Normal','deep'),
			'hover' => __('Hover','deep'),
		];

		$this->start_controls_tabs(
			$group_id. 'style_tabs'
		);

		foreach( $tabs as $tab_id => $label ){

			$this->start_controls_tab(
				$group_id . $tab_id . '_tab',
				[
					'label' => $label,
				]
			);

			$type = ( 'hover' === $tab_id ) ? 'hover_' : '';
			$selector_2 = ( 'hover' === $tab_id ) ? $primary_hover_selector : $primary_selector;
			$t_group_id = $group_id . $type;

			$controls = [
				$t_group_id . 'typography' => [
					'name' => $t_group_id . 'typography',
					'type' => 'typography_2',
					'label' => __('Typography','deep'),
					'default' => '',
					'selector' => $selector_2,
					'text_align' => true,
					'text_shadow' => true,
				],
				$t_group_id . 'color' => [
					'name' => $t_group_id . 'color',
					'type' => 'font_color',
					'label' => __('Color','deep'),
					'default' => '',
					'selector' => $selector_2,
				],
				$t_group_id . 'background' => [
					'name' => $t_group_id . 'background',
					'type' => 'background',
					'label' => __('Background','deep'),
					'default' => '',
					'selector' => $selector_2,
				],
				$t_group_id . 'margin' => [
					'name' => $t_group_id . 'margin',
					'type' => 'margin',
					'label' => __('Margin','deep'),
					'default' => '',
					'selector' => $selector_2,
				],
				$t_group_id . 'padding' => [
					'name' => $t_group_id . 'padding',
					'type' => 'padding',
					'label' => __('Padding','deep'),
					'default' => '',
					'selector' => $selector_2,
				],
				$t_group_id . 'border' => [
					'name' => $t_group_id . 'border',
					'type' => 'border',
					'label' => __('Border','deep'),
					'default' => '',
					'selector' => $selector_2,
					'radius' => true,
				],
				$t_group_id . 'box_shadow' => [
					'name' => $t_group_id . 'box_shadow',
					'type' => 'box_shadow',
					'label' => __('Box Shadow','deep'),
					'default' => '',
					'selector' => $selector_2,
				],
			];

			$controls = $this->deep_init_controls(
				$controls,
				$rewrite_settings_fields,
				$t_group_id,
				$selector_2,
				$type
			);


			if( !empty( $condition ) ){

				foreach( $controls as $control_id => $control ){

					if ( !isset( $controls[ $control_id ]['condition'] ) ){

						$controls[ $control_id ]['condition'] = $condition;
					}
				}
			}

			$this->deep_register_controls( $controls );

			$this->end_controls_tab();
		}

		$this->end_controls_tabs();


		$this->end_controls_section();
	}

	/**
	 * Register Control
	 *
	 * @param array $atts
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function deep_register_control( $atts ) {

		$defaults = array(
			'type'      => '',
			// 'label'     => '',
			'selector'  => '',
			'selectors' => '',
			'condition' => '',
		);

		$atts = wp_parse_args( $atts, $defaults );

		$type = $atts['type'];
		if ( empty( $type ) ) {

			return;
		}

		switch ( $type ) {
			case 'typography':
			case 'typography_1':
			case 'typography_2':
			case 'typography_3':
			case 'typography_4':
				$this->typography( $atts );

				break;
			case 'text_shadow':

				$this->text_shadow( $atts );

				break;
			case 'icon_align':
			case 'text_align':
			case 'align':

				$this->align( $atts );

				break;


			case 'font_color':
			case 'color':
				$this->color( $atts );

				break;
			case 'background':
				$this->background( $atts );

				break;
			case 'margin':
				$this->margin( $atts );

				break;
			case 'padding':
				$this->padding( $atts );

				break;
			case 'border':
				$this->border( $atts );

				break;
			case 'border_radius':
				$this->border_radius( $atts );

				break;
			case 'box_shadow':
				$this->box_shadow( $atts );

				break;
			case 'box_width':
			case 'image_width':
			case 'width':
			case 'height':
			case 'min_width':
			case 'min_height':
			case 'max_width':
			case 'max_height':
			case 'opacity':
			case 'transition':
			case 'font_size':

			case 'position_top':
			case 'position_bottom':
			case 'position_left':
			case 'position_right':

				$this->slider( $atts );

				break;
			case 'switcher':
			case 'show_hide':

				$this->switcher( $atts );

				break;

			case 'css_filter':

				$this->css_filter( $atts );

				break;
			case 'hover_animation':

				$this->hover_animation( $atts );

				break;
			case 'position':

				$this->position( $atts );

				break;
			case 'position_space':

				$this->position_space( $atts );

				break;

			case 'html_tag':

				$this->html_tag( $atts );

				break;
			case 'display':

				$this->deep_display( $atts );

				break;
			case 'table_layout':

				$this->table_layout( $atts );

				break;

			case 'float':

				$this->float( $atts );

				break;

		}
	}

	/**
	 * Register Typography Control
	 *
	 * @param array $atts
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function typography( $atts ) {

		$defaults = array(
			'name'  => 'typography',
			'label' => __( 'Typography', 'deep' ),
			'text_align' => true,
			'text_shadow' => true,
		);
		$atts     = wp_parse_args( $atts, $defaults );

		switch ( $atts['type'] ) {

			case 'typography_1':
				$scheme = Typography::TYPOGRAPHY_1;
				break;
			case 'typography_2':
				$scheme = Typography::TYPOGRAPHY_2;
				break;
			case 'typography_3':
				$scheme = Typography::TYPOGRAPHY_3;
				break;
			case 'typography_4':
				$scheme = Typography::TYPOGRAPHY_4;
				break;
			default:
				$scheme = Typography::TYPOGRAPHY_2;
		}

		$args = array(
			'name'   => $atts['name'],
			'label'  => $atts['label'],
			'scheme' => $scheme,
			'text_align' => $atts['text_align'],
			'text_shadow' => $atts['text_shadow'],
		);

		$pattern = '';
		$args    = $this->prepare_args( $atts, $args, $pattern );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			$args
		);

		if( $args['text_align'] ){

			$align_atts = [
				'name' => $atts['name'] . '_text_align',
				'type' => 'text_align',
				'selector' => isset( $args['selector'] ) ? $args['selector'] : $this->deep_base_selector,
				'selectors' => isset( $args['selectors'] ) ? $args['selectors'] : [],
				'condition' => isset( $args['condition'] ) ? $args['condition'] : [],
			];

			$this->deep_register_control( $align_atts );
		}

		if( $args['text_shadow'] ){

			$text_shadow_atts = [
				'name' => $atts['name'] . '_text_shadow',
				'type' => 'text_shadow',
				'selector' => isset( $args['selector'] ) ? $args['selector'] : $this->deep_base_selector,
				'selectors' => isset( $args['selectors'] ) ? $args['selectors'] : [],
				'condition' => isset( $args['condition'] ) ? $args['condition'] : [],
			];

			$this->deep_register_control( $text_shadow_atts );
		}
	}


	/**
	 * Register Text Shadow Control
	 *
	 * @param array $atts
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function text_shadow( $atts ) {

		$defaults = array(
			'name'  => 'text_shadow',
			'label' => __( 'Text Shadow', 'deep' ),
		);
		$atts     = wp_parse_args( $atts, $defaults );

		$args = array(
			'name'  => $atts['name'],
			'label'  => $atts['label'],
		);

		$pattern = '';
		$args = $this->prepare_args( $atts, $args, $pattern );

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			$args
		);
	}

	/**
	 * Register Align Control
	 *
	 * @param array $atts
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function align( $atts ){

		$defaults = array(
			'name'  => 'align',
			'label' => __( 'Align', 'deep' ),
			'default'	=> '',
			'toggle'	=> true,
			'options'	=> [
				'left' => [
					'title' => __( 'Left', 'deep' ),
					'icon'	=> 'eicon-text-align-left',
				],
				'center' => [
					'title' => __( 'Center', 'deep' ),
					'icon'	=> 'eicon-text-align-center',
				],
				'right' => [
					'title' => __( 'Right', 'deep' ),
					'icon'	=> 'eicon-text-align-right',
				],
			],
		);

		if( in_array( $atts['type'], ['icon_align'] )){

			unset( $defaults['options']['center'] );
		}

		$atts     = wp_parse_args( $atts, $defaults );

		$args = array(
			'name'  => $atts['name'],
			'label' => $atts['label'],
			'type'  => Controls_Manager::CHOOSE,
			'toggle' => $atts['toggle'],
			'options' => $atts['options'],
		);

		$pattern = 'text-align: {{VALUE}};';
		$args    = $this->prepare_args( $atts, $args, $pattern );

		$this->add_control(
			$atts['name'],
			$args
		);
	}

	/**
	 * Register Color Control
	 *
	 * @param array $atts
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function color( $atts ) {

		$defaults = array(
			'name'  => 'typography',
			'label' => __( 'Color', 'deep' ),
		);
		$atts     = wp_parse_args( $atts, $defaults );

		$scheme = array(
			'type'  => Color::get_type(),
			'value' => Color::COLOR_1,
		);

		$args = array(
			'label'  => $atts['label'],
			'type'   => Controls_Manager::COLOR,
			'scheme' => $scheme,
		);

		$pattern = '';
		switch ( $atts['type'] ) {

			case 'font_color':
			case 'color':
			default:
				$pattern = 'color: {{VALUE}};fill: {{VALUE}};';
		}
		$args = $this->prepare_args( $atts, $args, $pattern );

		$this->add_control(
			$atts['name'],
			$args
		);
	}

	/**
	 * Register Background Control
	 *
	 * @param array $atts
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function background( $atts ) {

		$defaults = array(
			'name'  => 'background',
			'label' => __( 'Background', 'deep' ),
		);
		$atts     = wp_parse_args( $atts, $defaults );

		$args = array(
			'name'  => $atts['name'],
			'label' => $atts['label'],
			'types' => array(
				'classic',
				'gradient'
			),
		);

		$pattern = '';
		$args    = $this->prepare_args( $atts, $args, $pattern );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			$args
		);
	}

	/**
	 * Register Margin Control
	 *
	 * @param array $atts
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function margin( $atts ) {

		$defaults = array(
			'name'  => 'margin',
			'label' => __( 'Margin', 'deep' ),
		);
		$atts     = wp_parse_args( $atts, $defaults );

		$args = array(
			'name'       => $atts['name'],
			'label'      => $atts['label'],
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array( 'px', 'em', '%' ),
			'devices'    => array( 'desktop', 'tablet', 'mobile' ),
		);

		$pattern = 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};';
		$args    = $this->prepare_args( $atts, $args, $pattern );

		$this->add_responsive_control(
			$atts['name'],
			$args
		);
	}

	/**
	 * Register Padding Control
	 *
	 * @param array $atts
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function padding( $atts ) {

		$defaults = array(
			'name'  => 'padding',
			'label' => __( 'Padding', 'deep' ),
		);
		$atts     = wp_parse_args( $atts, $defaults );

		$args = array(
			'name'       => $atts['name'],
			'label'      => $atts['label'],
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array( 'px', 'em', '%' ),
			'devices'    => array( 'desktop', 'tablet', 'mobile' ),
		);

		$pattern = 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};';
		$args    = $this->prepare_args( $atts, $args, $pattern );

		$this->add_responsive_control(
			$atts['name'],
			$args
		);
	}

	/**
	 * Register Border Control
	 *
	 * @param array $atts
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function border( $atts ) {

		$defaults = array(
			'name'         => 'border',
			'label'        => __( 'Border', 'deep' ),
			'radius'       => true,
			'label_radius' => __( 'Border Radius', 'deep' ),
		);
		$atts     = wp_parse_args( $atts, $defaults );

		$d_args = array(
			'name'       => $atts['name'],
			'label'      => $atts['label'],
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array( 'px', 'em', '%' ),
			'devices'    => array( 'desktop', 'tablet', 'mobile' ),
		);

		$pattern = '';
		$args    = $this->prepare_args( $atts, $d_args, $pattern );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			$args
		);

		if ( $atts['radius'] ) {

			$atts['type']  = 'border_radius';
			$atts['name']  = $atts['name'] . '_radius';
			$atts['label'] = $atts['label_radius'];

			$this->deep_register_control( $atts );
		}
	}

	/**
	 * Register Border Radius Control
	 *
	 * @param array $atts
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function border_radius( $atts ) {

		$defaults = array(
			'name'  => 'border_radius',
			'label' => __( 'Border Radius', 'deep' ),
		);
		$atts     = wp_parse_args( $atts, $defaults );

		$args = array(
			'name'       => $atts['name'],
			'label'      => $atts['label'],
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array( 'px', 'em', '%' ),
			'devices'    => array( 'desktop', 'tablet', 'mobile' ),
		);

		$pattern = 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};';
		$args    = $this->prepare_args( $atts, $args, $pattern );

		$this->add_responsive_control(
			$atts['name'],
			$args
		);
	}


	/**
	 * Register Box Shadow Control
	 *
	 * @param array $atts
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function box_shadow( $atts ) {

		$defaults = array(
			'name'  => 'box_shadow',
			'label' => __( 'Box Shadow', 'deep' ),
		);
		$atts     = wp_parse_args( $atts, $defaults );

		$args = array(
			'name'  => $atts['name'],
			'label' => $atts['label'],
		);

		$pattern = '';
		$args    = $this->prepare_args( $atts, $args, $pattern );

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			$args
		);
	}

	/**
	 * Register Range Slider Control
	 *
	 * @param array $atts
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function slider( $atts ){

		$defaults = array(
			'name'  => 'slider',
			'label' => __( 'Size', 'deep' ),
			'size_units' => [ 'px', '%', 'vw' ],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 1000,
					'step' => 5,
				],
				'%' => [
					'min' => 0,
					'max' => 100,
				],
				'vw' => [
					'min' => 1,
					'max' => 100,
				],
			],
		);
		$atts     = wp_parse_args( $atts, $defaults );

		$args = array(
			'name'  => $atts['name'],
			'label' => $atts['label'],
			'type' => Controls_Manager::SLIDER,
			'size_units' => $atts['size_units'],
			'range' => $atts['range'],
		);

		$pattern = '';
		switch ( $atts['type'] ) {

			case 'box_width':
			case 'image_width':
			case 'width':

				$pattern = 'width: {{SIZE}}{{UNIT}};';

				break;
			case 'max_width':

				$pattern = 'max-width: {{SIZE}}{{UNIT}};';

				break;
			case 'max_height':

				$pattern = 'max-height: {{SIZE}}{{UNIT}};';

				$args['size_units'] = [ 'px', 'vh' ];
				$args['range'] = [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				];

				break;
			case 'min_width':

				$pattern = 'min-width: {{SIZE}}{{UNIT}};';

				break;
			case 'height':

				$pattern = 'height: {{SIZE}}{{UNIT}};';

				$args['size_units'] = [ 'px', 'vh' ];
				$args['range'] = [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				];

				break;
			case 'min_height':

				$pattern = 'min-height: {{SIZE}}{{UNIT}};';

				$args['size_units'] = [ 'px', 'vh' ];
				$args['range'] = [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				];

				break;
			case 'opacity':

				$pattern = 'opacity: {{SIZE}};';

				$args['size_units'] = [ 'px' ];
				$args['range'] = [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				];

				break;
			case 'position_top':
			case 'position_bottom':
			case 'position_right':
			case 'position_left':

				$args['size_units'] = [ 'px', '%' ];
				$args['range'] = [
					'px' => [
						'min' => -1000,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				];

				$default_labels = array(
					'position_top' => __( 'Position Top', 'deep'),
					'position_bottom' => __( 'Position Bottom', 'deep'),
					'position_right' => __( 'Position Right', 'deep'),
					'position_left' => __( 'Position Left', 'deep'),
				);

				if( empty( $args['label'] ) ){

					$args['label'] = $default_labels[ $atts['type'] ];
				}

				$css_k = str_replace( 'position_', '', $atts['type'] );
				$pattern = "{$css_k}: {{SIZE}}{{UNIT}};";

				break;


			case 'transition':

				$pattern = 'transition: {{SIZE}}s;';

				$args['size_units'] = [ '' ];
				$args['range'] = [
					'px' => [
						'max' => 3,
						'step' => 0.01,
					],
				];

				break;


			case 'font_size':
			default:

				$pattern = 'font-size: {{SIZE}}{{UNIT}};';

				$args['size_units'] = ['px'];
				$args['range'] = [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					]
				];

		}
		$args    = $this->prepare_args( $atts, $args, $pattern );

		$this->add_control(
			$atts['name'],
			$args
		);
	}

	/**
	 * Register Switcher Control
	 *
	 * @param array $atts
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function switcher( $atts ){

		$defaults = array(
			'name'  => 'status',
			'label' => __( 'On/Off', 'deep' ),
			'label_on'  => __( 'On', 'deep' ),
			'label_off' => __( 'Off', 'deep' ),
			'return_value' => 'yes',
		);

		$pattern = '';
		switch( $atts['type'] ){

			case 'show_hide':

				$defaults['label'] = __( 'Show/Hide', 'deep' );
				$defaults['label_on'] = __( 'Hide', 'deep' );
				$defaults['label_off'] = __( 'Show', 'deep' );
				$defaults['return_value'] = 'none';

				$pattern = "display: {{VALUE}};";

				break;
		}

		$atts     = wp_parse_args( $atts, $defaults );

		$args = array(
			'name'  => $atts['name'],
			'label' => $atts['label'],
			'type'  => Controls_Manager::SWITCHER,
			'label_on'  => $atts['label_on'],
			'label_off' => $atts['label_off'],
			'return_value' => $atts['return_value'],
			'default' => 'yes',
		);

		$args    = $this->prepare_args( $atts, $args, $pattern );

		$this->add_control(
			$atts['name'],
			$args
		);
	}

	/**
	 * Register Display Control
	 *
	 * @param array $atts
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function deep_display( $atts ){

		$defaults = array(
			'name'  => 'display',
			'label' => __( 'Display', 'deep' ),
			'default' => '',
			'options' => [
				''      => __( 'Default', 'deep' ),
				'inherit'      => __( 'Inherit', 'deep' ),
				'inline'       => __( 'inline', 'deep' ),
				'inline-block' => __( 'inline block', 'deep' ),
				'block'        => __( 'block', 'deep' ),
				'none'         => __( 'none', 'deep' ),
			],
		);

		$atts     = wp_parse_args( $atts, $defaults );

		$args = array(
			'name'  => $atts['name'],
			'label' => $atts['label'],
			'type'    => Controls_Manager::SELECT,
			'default' => $atts['default'],
			'options' => $atts['options'],
			'devices' => [ 'desktop', 'tablet', 'mobile' ],
		);

		$pattern = 'display: {{VALUE}};';
		$args    = $this->prepare_args( $atts, $args, $pattern );

		$this->add_responsive_control(
			$atts['name'],
			$args
		);
	}

	/**
	 * Register Table Layout Control
	 *
	 * @param array $atts
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function table_layout( $atts ){

		$defaults = array(
			'name'  => 'table_layout',
			'label' => __( 'Table Layout', 'deep' ),
		);
		$atts     = wp_parse_args( $atts, $defaults );

		$args = array(
			'name'  => $atts['name'],
			'label' => $atts['label'],
			'type'    => Controls_Manager::SELECT,
			'default' => '',
			'options' => [
				''      => __( 'Default', 'deep' ),
				'fixed'      => __( 'Fixed', 'deep' ),
				'auto'       => __( 'Auto', 'deep' ),
			],
			'devices' => [ 'desktop', 'tablet', 'mobile' ],
		);

		$pattern = 'table-layout: {{VALUE}};';
		$args    = $this->prepare_args( $atts, $args, $pattern );

		$this->add_responsive_control(
			$atts['name'],
			$args
		);
	}

	/**
	 * Register Float Control
	 *
	 * @param array $atts
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function float( $atts ){

		$defaults = array(
			'name'  => 'float',
			'label' => __( 'Float', 'deep' ),
		);
		$atts     = wp_parse_args( $atts, $defaults );

		$args = array(
			'name'  => $atts['name'],
			'label' => $atts['label'],
			'type'    => Controls_Manager::SELECT,
			'default' => '',
			'options' => [
				''      => __( 'Default', 'deep' ),
				'right'      => __( 'Right', 'deep' ),
				'left'       => __( 'Left', 'deep' ),
				'unset' => __( 'Unset', 'deep' ),
			],
			'devices' => [ 'desktop', 'tablet', 'mobile' ],
		);

		$pattern = 'float: {{VALUE}};';
		$args    = $this->prepare_args( $atts, $args, $pattern );

		$this->add_responsive_control(
			$atts['name'],
			$args
		);
	}

	/**
	 * Register HTML Tag Control
	 *
	 * @param array $atts
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function html_tag( $atts ){

		$defaults = array(
			'name'  => 'html_tag',
			'label' => __( 'HTML Tag', 'deep' ),
		);
		$atts     = wp_parse_args( $atts, $defaults );

		$args = array(
			'name'  => $atts['name'],
			'label' => $atts['label'],
			'type'    => Controls_Manager::SELECT,
			'default' => 'h1',
			'options' => [
				'h1'   => __( 'h1', 'deep' ),
				'h2'   => __( 'h2', 'deep' ),
				'h3'   => __( 'h3', 'deep' ),
				'h4'   => __( 'h4', 'deep' ),
				'h5'   => __( 'h5', 'deep' ),
				'h6'   => __( 'h6', 'deep' )
			],
		);

		$pattern = '';
		$args    = $this->prepare_args( $atts, $args, $pattern );

		$this->add_control(
			$atts['name'],
			$args
		);
	}

	/**
	 * Register CSS Filter Control
	 *
	 * @param array $atts
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function css_filter( $atts ) {

		$defaults = array(
			'name'  => 'css_filter',
			'label' => __( 'CSS Filter', 'deep' ),
		);
		$atts     = wp_parse_args( $atts, $defaults );

		$args = array(
			'name'  => $atts['name'],
			'label' => $atts['label'],
		);

		$pattern = '';
		$args    = $this->prepare_args( $atts, $args, $pattern );

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			$args
		);
	}

	/**
	 * Register Hover Animation Control
	 *
	 * @param array $atts
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function hover_animation( $atts ) {

		$defaults = array(
			'name'  => 'hover_animation',
			'label' => __( 'Hover Animation', 'deep' ),
		);
		$atts     = wp_parse_args( $atts, $defaults );

		$args = array(
			'name'  => $atts['name'],
			'label' => $atts['label'],
			'type' => Controls_Manager::HOVER_ANIMATION,
		);

		$pattern = '';
		$args    = $this->prepare_args( $atts, $args, $pattern );

		$this->add_control(
			$atts['name'],
			$args
		);
	}

	/**
	 * Register Position Type Control
	 *
	 * @param array $atts
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function position( $atts ) {

		$defaults = array(
			'name'  => 'position',
			'label' => __( 'Hover Animation', 'deep' ),
		);
		$atts     = wp_parse_args( $atts, $defaults );

		$args = array(
			'name'  => $atts['name'],
			'label' => $atts['label'],
			'type' => Controls_Manager::SELECT,
			'options' => [
				'' => __( 'Default', 'deep' ),
				'relative' => __( 'Relative', 'deep' ),
				'absolute' => __( 'Absolute', 'deep' ),
				'fixed' => __( 'Fixed', 'deep' ),
				'static' => __( 'Static', 'deep' ),
			]
		);

		$pattern = 'position: {{VALUE}};';
		$args    = $this->prepare_args( $atts, $args, $pattern );

		$this->add_control(
			$atts['name'],
			$args
		);
	}

	/**
	 * Register Position Space Control
	 *
	 * @param array $atts
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function position_space( $atts ) {

		$defaults = array(
			'name'  => 'position_space',
			'label' => __( 'Position Space', 'deep' ),
			'positions' => [
				'top' => [],
				'bottom' => [],
				'right' => [],
				'left' => [],
			]
		);
		$atts     = wp_parse_args( $atts, $defaults );

		foreach( (array) $atts['positions'] as $position => $position_args ){

			$group_id = "{$atts['name']}_{$position}";
			$p_atts = [
				'name' => $group_id,
				'type' => 'position_' . $position,
				'selector' => $atts['selector'],
				'label' => '', // Auto Set Default
			];

			$atts = wp_parse_args( $position_args, $p_atts );

			$p_atts = $this->prepare_args( $atts, $p_atts , '' );

			$this->deep_register_control( $p_atts );
		}
	}
}
