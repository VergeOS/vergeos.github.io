<?php
namespace Deep\WooCommerce\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Deep\Components\WooCommerce\Templates;
use Deep\Components\WooCommerce\Helper\Social_Sharing;
use Deep\WooCommerce\Elementor\Deep_Product_Widget_Base;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce product Sharing.
 *
 * @since 2.0.0
 */
class Sharing extends Deep_Product_Widget_Base {

	/**
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $deep_base_selector = '{{WRAPPER}} .deep-woo-sharing';
	/**
	 * Retrieve the widget name.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'deep-woo-sharing';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Product Sharing', 'deep' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'deep-widget deep-eicon-product-sharing';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'Deep_Single_Product' );
	}

	/**
	 * Retrieve the list of styles the widget depended on.
	 *
	 * Used to set styles dependencies required to run the widget.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return array Widget styles dependencies.
	 */
	public function get_style_depends() {
		return array( 'deep-woo-sharing' );
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return array Widget styles dependencies.
	 */
	public function get_script_depends() {
		return array( 'deep-woo-sharing' );
	}

	/**
	 * Register the widget controls.
	 *
	 * @since 2.0.0
	 *
	 * @access protected
	 */
	protected function register_controls() {

		/** Content Tab Begin */
		$this->general_controls();
		$this->social_share_links_controls();
		/** Content Tab End */

		/** Style Tab Begin */
		$this->share_link_style_controls();
		$this->share_links_box_style_controls();
		$this->share_links_icon_style_controls();
		$this->share_links_style_controls();
		/** Style Tab End */
	}

	/**
	 * Register General Controls
	 *
	 * @since 2.0.0
	 *
	 * @access Public
	 *
	 * @return void
	 */
	public function general_controls() {

		$this->start_controls_section(
			'section_content',
			array(
				'label' => __( 'General', 'deep' ),
			)
		);

		$this->add_control(
			'button_style',
			array(
				'label'   => __( 'Button Type', 'deep' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'icon' => __( 'Icon', 'deep' ),
					'text' => __( 'Text', 'deep' ),
				),
				'default' => 'text',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Share Link Style Controls
	 *
	 * @since 2.0.0
	 *
	 * @access Public
	 *
	 * @return void
	 */
	public function share_link_style_controls() {

		$group_id      = 'share_link_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Share Link', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .deep-woo-sharing-box .deep-btn-social-share-links';
		$hover_selector = "$selector:hover";

		$rewrite_settings_fields = array();

		$this->deep_register_styles_controls(
			$group_id,
			$section_label,
			$description,
			$selector,
			$hover_selector,
			$rewrite_settings_fields
		);
	}

	/**
	 * Register Share Links Box Style Controls
	 *
	 * @since 2.0.0
	 *
	 * @access Public
	 *
	 * @return void
	 */
	public function share_links_box_style_controls() {

		$group_id      = 'share_links_box_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Social Share Links Box', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .deep-woo-sharing-box .deep-social-share-links';
		$hover_selector = "$selector:hover";

		$rewrite_settings_fields = array();

		$this->deep_register_styles_controls(
			$group_id,
			$section_label,
			$description,
			$selector,
			$hover_selector,
			$rewrite_settings_fields
		);
	}

	/**
	 * Register Share Links Style Controls
	 *
	 * @since 2.0.0
	 *
	 * @access Public
	 *
	 * @return void
	 */
	public function share_links_style_controls() {

		$group_id      = 'share_links_item_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Social Share Links', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .deep-woo-sharing-box .deep-social-share-links .deep-social-share-link';
		$hover_selector = "$selector:hover";

		$padding_default = array(
			'top'      => 5,
			'bottom'   => 5,
			'left'     => 10,
			'right'    => 10,
			'isLinked' => true,
		);

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => array(
				'selector' => "$selector a",
			),
			$group_id . 'hover_typography' => array(
				'selector' => "$selector:hover a",
			),

			$group_id . 'color'            => array(
				'selector' => "$selector a",
			),
			$group_id . 'hover_color'      => array(
				'selector' => "$selector:hover a",
			),

			$group_id . 'padding'          => array(
				'default' => $padding_default,
			),
			$group_id . 'hover_padding'    => array(
				'default' => $padding_default,
			),
		);

		$this->deep_register_styles_controls(
			$group_id,
			$section_label,
			$description,
			$selector,
			$hover_selector,
			$rewrite_settings_fields
		);
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
	public function share_links_icon_style_controls() {

		$group_id      = 'share_links_item_icon_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Social Share Links Icon', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .deep-woo-sharing-box .deep-social-share-links .deep-social-share-link i::before';
		$hover_selector = $base_selector . ' .deep-woo-sharing-box .deep-social-share-links .deep-social-share-link:hover i::before';

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => false,
			$group_id . 'hover_typography' => false,

			$group_id . 'font_size'        => array(
				'type' => 'font_size',
			),
			$group_id . 'hover_font_size'  => array(
				'type' => 'font_size',
			),
		);

		$this->deep_register_styles_controls(
			$group_id,
			$section_label,
			$description,
			$selector,
			$hover_selector,
			$rewrite_settings_fields
		);
	}

	/**
	 * Social Share Links Controls
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function social_share_links_controls() {

		$this->start_controls_section(
			'section_content_social_share_links',
			array(
				'label' => __( 'Social Share Links', 'deep' ),
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
				'options' => Social_Sharing::get_instance()->get_social_networks(),
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
				'label'         => __( 'Social Share Links List', 'deep' ),
				'type'          => Controls_Manager::REPEATER,
				'description'   => '',
				'fields'        => $repeater->get_controls(),
				'title_field'   => '{{{ title }}}',
				'default'       => $this->get_social_share_links_list_default(),
				'prevent_empty' => true,
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Get Default Social Share Links
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return array
	 */
	public function get_social_share_links_list_default() {

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
	 * Render the widget output on the frontend.
	 *
	 * @since 2.0.0
	 *
	 * @access protected
	 *
	 * @return void
	 */
	protected function render() {

		$settings = $this->get_settings();

		if ( $this->can_display_product() ) {

			Templates::widget( 'sharing', $settings );
		}
	}
}
