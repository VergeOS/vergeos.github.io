<?php
namespace Elementor;

use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for social sharing.
 *
 * @since 2.1.0
 */
class Webnus_Element_Widgets_Social_Sharing extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @since 2.1.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'deep-social-sharing';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 2.1.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Social Sharing', 'deep' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 2.1.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'deep-widget deep-eicon-socials';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.1.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'webnus' ];
	}

	/**
	 * Load depend styles.
	 *
	 * @since 2.1.0
	 *
	 * @access public
	 */
	public function get_style_depends() {
		return array( 'deep-social-sharing' );
	}

    /**
	 * Get All Social Networks
	 *
     * @since 2.1.0
     *
	 * @return array
	 */
	public function get_social_networks() {

		$social_networks = array(
			'facebook'         => __( 'Facebook', 'deep' ),
			'reddit'           => __( 'Reddit', 'deep' ),
			'whatsapp'         => __( 'WhatsApp', 'deep' ),
			'twitter'          => __( 'Twitter', 'deep' ),
			'linkedin'         => __( 'linkedin', 'deep' ),
			'tumblr'           => __( 'Tumblr', 'deep' ),
			'pinterest'        => __( 'Pinterest', 'deep' ),
			'email'            => __( 'Email', 'deep' ),
			'telegram'         => __( 'Telegram', 'deep' ),
			'vk'               => __( 'VK', 'deep' ),
		);

		return apply_filters( 'deep_get_all_social_networks', $social_networks );
	}

    /**
	 * Get Social Network Share Links
	 *
	 * @param array $args
     *
     * @since 2.1.0
     *
	 * @return array
	 */
	public function get_social_network_share_link_urls( $args ) {

		$url   = urlencode( $args['url'] );
		$title = urlencode( $args['title'] );
		$desc  = urlencode( $args['desc'] );

		$via               = '';
		$hash_tags         = '';
		$phone_number      = '';
		$email_address     = '';

		$text = $title;

		if ( $desc ) {
			$text .= '%20%3A%20';
			$text .= $desc;
		}

		$urls = array(
			'email'            => 'mailto:' . $email_address . '?subject=' . $title . '&body=' . $desc,
			'facebook'         => 'http://www.facebook.com/sharer.php?u=' . $url,
			'linkedin'         => 'https://www.linkedin.com/sharing/share-offsite/?url=' . $url,
			'pinterest'        => 'http://pinterest.com/pin/create/button/?url=' . $url,
			'reddit'           => 'https://reddit.com/submit?url=' . $url . '&title=' . $title,
			'telegram'         => 'https://t.me/share/url?url=' . $url . '&text=' . $text . '&to=' . $phone_number,
			'tumblr'           => 'https://www.tumblr.com/widgets/share/tool?canonicalUrl=' . $url . '&title=' . $title . '&caption=' . $desc . '&tags=' . $hash_tags,
			'twitter'          => 'https://twitter.com/intent/tweet?url=' . $url . '&text=' . $text . '&via=' . $via . '&hashtags=' . $hash_tags,
			'vk'               => 'http://vk.com/share.php?url=' . $url . '&title=' . $title . '&comment=' . $desc,
			'whatsapp'         => 'https://api.whatsapp.com/send?text=' . $text . '%20' . $url,
		);

		return apply_filters( 'deep_get_social_network_share_link_urls', $urls );
	}

    /**
	 * Get Default Social Share Links
	 *
	 * @since 2.1.0
	 *
	 * @access public
	 *
	 * @return array
	 */
	public function get_default_items() {

		return array(
			array(
				'display'        => 'on',
				'social_network' => 'facebook',
				'title'          => 'Facebook',
				'icon'           => 'wn-fab wn-fa-facebook',
				'custom_class'   => '',
			),
			array(
				'display'        => 'on',
				'social_network' => 'twitter',
				'title'          => 'Twitter',
				'icon'           => 'wn-fab wn-fa-twitter',
				'custom_class'   => '',
			),
			array(
				'display'        => 'on',
				'social_network' => 'email',
				'title'          => 'Email',
				'icon'           => 'ti-email',
				'custom_class'   => '',
			),
		);
	}

	/**
	 * Register the widget controls.
	 *
	 * @since 2.1.0
	 *
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'section_content_social_share',
			array(
				'label' => __( 'Social Share', 'deep' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'display',
			array(
				'label'        => __( 'Show/Hide', 'deep' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'on',
				'label_on'     => 'On',
				'label_off'    => 'Off',
				'return_value' => 'on',
			)
		);

		$repeater->add_control(
			'social_network',
			array(
				'label'   => __( 'Social Media', 'deep' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->get_social_networks(),
			)
		);

		$repeater->add_control(
			'title',
			array(
				'label'       => __( 'Title', 'deep' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Social Share Link Title', 'deep' ),
			)
		);

		$repeater->add_control(
			'icon',
			array(
				'label' => __( 'Icon', 'deep' ),
				'type'  => Controls_Manager::ICON,
			)
		);

		$repeater->add_control(
			'custom_class',
			array(
				'label'       => __( 'Custom Class', 'deep' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'ex: css-selector', 'deep' ),
			)
		);

		$this->add_control(
			'social_share_links_list',
			array(
				'label'         => __( 'Social Share', 'deep' ),
				'type'          => Controls_Manager::REPEATER,
				'description'   => '',
				'fields'        => $repeater->get_controls(),
				'title_field'   => '{{{ social_network }}}',
				'default'       => $this->get_default_items(),
				'prevent_empty' => true,
			)
		);

		$this->end_controls_section();

		//Styling
		$this->start_controls_section(
			'box_style',
			[
				'label' => __('Box', 'deep'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'  => 'box_background',
				'label' => __('Background', 'deep'),
				'types' => ['classic'],
				'selector' => '{{WRAPPER}} .deep-social-sharing',
			]
		);

		$this->add_responsive_control(
			'box_padding',
			[
				'label' => __('Padding', 'deep'),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' 	=> ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'{{WRAPPER}} .deep-social-sharing' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'box_margin',
			[
				'label' => __('Margin', 'deep'),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' 	=> ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'{{WRAPPER}} .deep-social-sharing' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'  => 'box_border',
				'label' => __('Border', 'deep'),
				'selector' => '{{WRAPPER}} .deep-social-sharing',
			]
		);

		$this->add_responsive_control(
			'box_border_radius',
			[
				'label' => __('Border Radius', 'deep'),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices'    => ['desktop', 'tablet', 'mobile'],
				'selectors'  => [
					'{{WRAPPER}} .deep-social-sharing' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_box_shadow',
				'label' =>  esc_html__('Box Shadow', 'deep'),
				'selector' => '{{WRAPPER}} .deep-social-sharing',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'list_wrapper_style',
			[
				'label' => __('List Wrapper', 'deep'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'  => 'list_wrapper_background',
				'label' => __('Background', 'deep'),
				'types' => ['classic'],
				'selector' => '{{WRAPPER}} .deep-social-sharing .deep-social-share-links',
			]
		);

		$this->add_responsive_control(
			'list_wrapper_padding',
			[
				'label' => __('Padding', 'deep'),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' 	=> ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'{{WRAPPER}} .deep-social-sharing .deep-social-share-links' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'list_wrapper_margin',
			[
				'label' => __('Margin', 'deep'),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' 	=> ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'{{WRAPPER}} .deep-social-sharing .deep-social-share-links' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'  => 'list_wrapper_border',
				'label' => __('Border', 'deep'),
				'selector' => '{{WRAPPER}} .deep-social-sharing .deep-social-share-links',
			]
		);

		$this->add_responsive_control(
			'list_wrapper_border_radius',
			[
				'label' => __('Border Radius', 'deep'),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices'    => ['desktop', 'tablet', 'mobile'],
				'selectors'  => [
					'{{WRAPPER}} .deep-social-sharing .deep-social-share-links' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'list_wrapper_box_shadow',
				'label' =>  esc_html__('Box Shadow', 'deep'),
				'selector' => '{{WRAPPER}} .deep-social-sharing .deep-social-share-links',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'item_wrapper_style',
			[
				'label' => __('Item Wrapper', 'deep'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'  => 'item_wrapper_background',
				'label' => __('Background', 'deep'),
				'types' => ['classic'],
				'selector' => '{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link ',
			]
		);

		$this->add_responsive_control(
			'item_wrapper_padding',
			[
				'label' => __('Padding', 'deep'),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' 	=> ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_wrapper_margin',
			[
				'label' => __('Margin', 'deep'),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' 	=> ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'  => 'item_wrapper_border',
				'label' => __('Border', 'deep'),
				'selector' => '{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link ',
			]
		);

		$this->add_responsive_control(
			'item_wrapper_border_radius',
			[
				'label' => __('Border Radius', 'deep'),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices'    => ['desktop', 'tablet', 'mobile'],
				'selectors'  => [
					'{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_wrapper_box_shadow',
				'label' =>  esc_html__('Box Shadow', 'deep'),
				'selector' => '{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link ',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'item_style',
			[
				'label' => __( 'Item', 'deep' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'item_style_tabs'
		);

		$this->start_controls_tab(
			'style_item_normal_tab',
			[
				'label' => __( 'Normal', 'deep' ),
			]
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'item_typography',
					'label' 	=> __( 'Typography', 'deep' ),
					'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_2,
					'selector' 	=> '{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a',
				]
			);

			$this->add_control(
				'item_align',
				[
					'label'     => __( 'Text align', 'deep' ),
					'type'      => \Elementor\Controls_Manager::CHOOSE,
					'options'   => [
						'left'   => [
							'title' => __( 'Left', 'deep' ),
							'icon'  => 'fa fa-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'deep' ),
							'icon'  => 'fa fa-align-center',
						],
						'right'  => [
							'title' => __( 'Right', 'deep' ),
							'icon'  => 'fa fa-align-right',
						],
					],
					'toggle'    => true,
					'selectors' => [
						'{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a' => 'text-align: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'item_color',
				[
					'label' 		=> __( 'Color', 'deep' ),
					'type' 			=> \Elementor\Controls_Manager::COLOR,
					'selectors' 	=> [
						'{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'item_background',
					'label' => __( 'Background', 'deep' ),
					'types' => [ 'classic', 'gradient', 'video' ],
					'selector' => '{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a',
				]
			);

			$this->add_responsive_control(
				'item_margin',
				[
					'label' 		=> __( 'Margin', 'deep' ),
					'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
					'selectors' => [
						'{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'item_padding',
				[
					'label' 		=> __( 'Padding', 'deep' ),
					'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
					'selectors' => [
						'{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'item_border',
					'label' => __( 'Border', 'deep' ),
					'selector' => '{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a',
				]
			);

			$this->add_responsive_control(
				'item_border_radius',
				[
					'label' 		=> __( 'Border Radius', 'deep' ),
					'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
					'selectors' => [
						'{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'item_box_shadow',
						'label' => __( 'Box Shadow', 'deep' ),
						'selector' => '{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a',
					]
			);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'style_item_hover_tab',
			[
				'label' => __( 'Hover', 'deep' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'item_typography_hover',
				'label' 	=> __( 'Typography', 'deep' ),
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_2,
				'selector' 	=> '{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a:hover',
			]
		);

		$this->add_control(
			'item_align_hover',
			[
				'label'     => __( 'Text align', 'deep' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'deep' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'deep' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'deep' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a:hover' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'item_color_hover',
			[
				'label' 		=> __( 'Color', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'item_background_hover',
				'label' => __( 'Background', 'deep' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a:hover',
			]
		);

		$this->add_responsive_control(
			'item_margin_hover',
			[
				'label' 		=> __( 'Margin', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_padding_hover',
			[
				'label' 		=> __( 'Padding', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'item_border_hover',
				'label' => __( 'Border', 'deep' ),
				'selector' => '{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a:hover',
			]
		);

		$this->add_responsive_control(
			'item_border_radius_hover',
			[
				'label' 		=> __( 'Border Radius', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'item_box_shadow_hover',
					'label' => __( 'Box Shadow', 'deep' ),
					'selector' => '{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a:hover',
				]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'icon_style',
			[
				'label' => __( 'Icon', 'deep' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'icon_style_tabs'
		);

		$this->start_controls_tab(
			'style_icon_normal_tab',
			[
				'label' => __( 'Normal', 'deep' ),
			]
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'icon_typography',
					'label' 	=> __( 'Typography', 'deep' ),
					'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_2,
					'selector' 	=> '{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a i',
				]
			);

			$this->add_control(
				'icon_align',
				[
					'label'     => __( 'Text align', 'deep' ),
					'type'      => \Elementor\Controls_Manager::CHOOSE,
					'options'   => [
						'left'   => [
							'title' => __( 'Left', 'deep' ),
							'icon'  => 'fa fa-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'deep' ),
							'icon'  => 'fa fa-align-center',
						],
						'right'  => [
							'title' => __( 'Right', 'deep' ),
							'icon'  => 'fa fa-align-right',
						],
					],
					'toggle'    => true,
					'selectors' => [
						'{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a i' => 'text-align: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'icon_color',
				[
					'label' 		=> __( 'Color', 'deep' ),
					'type' 			=> \Elementor\Controls_Manager::COLOR,
					'selectors' 	=> [
						'{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a i' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'icon_background',
					'label' => __( 'Background', 'deep' ),
					'types' => [ 'classic', 'gradient', 'video' ],
					'selector' => '{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a i',
				]
			);

			$this->add_responsive_control(
				'icon_margin',
				[
					'label' 		=> __( 'Margin', 'deep' ),
					'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
					'selectors' => [
						'{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'icon_padding',
				[
					'label' 		=> __( 'Padding', 'deep' ),
					'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
					'selectors' => [
						'{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'icon_border',
					'label' => __( 'Border', 'deep' ),
					'selector' => '{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a i',
				]
			);

			$this->add_responsive_control(
				'icon_border_radius',
				[
					'label' 		=> __( 'Border Radius', 'deep' ),
					'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
					'selectors' => [
						'{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'icon_box_shadow',
						'label' => __( 'Box Shadow', 'deep' ),
						'selector' => '{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a i',
					]
			);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'style_icon_hover_tab',
			[
				'label' => __( 'Hover', 'deep' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'icon_typography_hover',
				'label' 	=> __( 'Typography', 'deep' ),
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_2,
				'selector' 	=> '{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a i:hover',
			]
		);

		$this->add_control(
			'icon_align_hover',
			[
				'label'     => __( 'Text align', 'deep' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'deep' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'deep' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'deep' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a i:hover' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'icon_color_hover',
			[
				'label' 		=> __( 'Color', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a i:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'icon_background_hover',
				'label' => __( 'Background', 'deep' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a i:hover',
			]
		);

		$this->add_responsive_control(
			'icon_margin_hover',
			[
				'label' 		=> __( 'Margin', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a i:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_padding_hover',
			[
				'label' 		=> __( 'Padding', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a i:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'icon_border_hover',
				'label' => __( 'Border', 'deep' ),
				'selector' => '{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a i:hover',
			]
		);

		$this->add_responsive_control(
			'icon_border_radius_hover',
			[
				'label' 		=> __( 'Border Radius', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a i:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'icon_box_shadow_hover',
					'label' => __( 'Box Shadow', 'deep' ),
					'selector' => '{{WRAPPER}} .deep-social-sharing .deep-social-share-links .deep-social-share-link a i:hover',
				]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * @since 2.1.0
	 *
	 * @access protected
	 */
	protected function render() {

        $settings = $this->get_settings_for_display();

        global $post;

        $post_id            = $post->ID;
        $social_share_links = $settings['social_share_links_list'];

        $args = array(
            'url'   => get_permalink( $post_id ),
            'title' => $post->post_title,
            'desc'  => ''
        );

        $share_links = $this->get_social_network_share_link_urls( $args );
        ?>

        <div class="deep-social-sharing">
            <ul class="deep-social-share-links">
                <?php
                if ( $social_share_links ) {
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
                                <a href="' . esc_url( $url ) . '" target="_blank">
                                    <i class="' . esc_attr( $icon ) . '"></i>
                                    ' . esc_html( $title ) . '
                                </a>
                            </li>';
                    }
                }
                ?>

            </ul>
        </div>
        <?php
	}
}
