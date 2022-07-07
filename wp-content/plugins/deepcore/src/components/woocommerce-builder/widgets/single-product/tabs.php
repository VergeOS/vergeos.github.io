<?php
namespace Deep\WooCommerce\Elementor\Widgets;

use Deep\WooCommerce\Elementor\Deep_Product_Widget_Base;
use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce product Tabs.
 *
 * @since 2.0.0
 */
class Tabs extends Deep_Product_Widget_Base {

	/**
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $deep_base_selector = '{{WRAPPER}} .deep-woo-tabs';

	/**
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $deep_base_description_selector = '{{WRAPPER}} .deep-woo-tabs #tab-description';

	/**
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $deep_base_attributes_selector = '{{WRAPPER}} .deep-woo-tabs #tab-additional_information';

	/**
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $deep_base_review_selector = '{{WRAPPER}} .deep-woo-tabs #tab-reviews';

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
		return 'deep-woo-tabs';
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
		return __( 'Product Tabs', 'deep' );
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
		return 'deep-widget deep-eicon-product-tabs';
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

		return array( 'deep-woo-tabs' );
	}

	/**
	 * Register the widget controls.
	 *
	 * @since 2.0.0
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => __( 'General', 'deep' ),
			)
		);

		$this->add_control(
			'description',
			array(
				'label'     => __( 'This widget displays the product tabs.', 'deep' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->end_controls_section();

		$this->register_header_tabs_wrapper_styles();
		$this->register_header_tabs_styles();
		$this->register_active_header_tab_styles();
		$this->register_content_tab_styles();
		$this->register_content_tab_header_styles();

		/** Description */
		$this->register_description_styles();

		/** Attribute */
		$this->register_attributes_styles();
		$this->register_attributes_item_styles();
		$this->register_attributes_label_styles();
		$this->register_attributes_value_styles();

		/** Review */
		$this->register_box_styles();
		$this->register_title_styles();
		$this->register_review_item_styles();
		$this->register_review_avatar_styles();
		$this->register_review_form_styles();
		$this->register_form_title_styles();
		$this->register_form_label_styles();
		$this->register_button_styles();
		$this->register_input_styles();

		/** Comments */
		$this->register_comments_wrapper_styles();
		$this->register_comments_count_styles();
		$this->register_comment_thumbnail_styles();
		$this->register_comment_text_container_styles();
		$this->register_comment_text_styles();
		$this->register_comment_author_name_styles();
		$this->register_comment_date_styles();
		$this->register_comment_star_rating_styles();

	}

	/**
	 * Register Header Tabs Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_header_tabs_wrapper_styles() {

		$group_id      = 'header_tabs_wrapper_';
		$base_selector = $this->deep_base_selector . ' ul.tabs';
		$section_label = __( 'Header Tabs Wrapper', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = "$base_selector:hover";

		$default_padding = array(
			'top'      => 0,
			'bottom'   => 0,
			'left'     => 16,
			'right'    => 16,
			'isLinked' => false,
		);

		$default_margin = array(
			'top'      => 0,
			'bottom'   => 0,
			'left'     => -5,
			'right'    => -5,
			'isLinked' => false,
		);

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => array(
				'selector' => "$selector, $base_selector a",
			),
			$group_id . 'hover_typography' => array(
				'selector' => "$hover_selector, $base_selector:hover a",
			),

			$group_id . 'color'            => array(
				'selector' => "$selector, $base_selector a",
			),
			$group_id . 'hover_color'      => array(
				'selector' => "$hover_selector, $base_selector:hover a",
			),

			$group_id . 'padding'          => array(
				'default' => $default_padding,
			),
			$group_id . 'hover_padding'    => array(
				'default' => $default_padding,
			),

			$group_id . 'margin'           => array(
				'default' => $default_margin,
			),
			$group_id . 'hover_margin'     => array(
				'default' => $default_margin,
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
	 * Register Header Tabs Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_header_tabs_styles() {

		$group_id      = 'header_tabs_';
		$base_selector = $this->deep_base_selector . ' ul.tabs li';
		$section_label = __( 'Header Tabs', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = "$base_selector:hover";

		$default_padding = array(
			'top'      => 0,
			'bottom'   => 0,
			'left'     => 16,
			'right'    => 16,
			'isLinked' => false,
		);

		$default_margin = array(
			'top'      => 0,
			'bottom'   => 0,
			'left'     => -5,
			'right'    => -5,
			'isLinked' => false,
		);

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => array(
				'selector' => "$base_selector a",
			),
			$group_id . 'hover_typography' => array(
				'selector' => "$base_selector:hover a",
			),

			$group_id . 'color'            => array(
				'selector' => "$base_selector a",
			),
			$group_id . 'hover_color'      => array(
				'selector' => "$base_selector:hover a",
			),

			$group_id . 'padding'          => array(
				'default' => $default_padding,
			),
			$group_id . 'hover_padding'    => array(
				'default' => $default_padding,
			),

			$group_id . 'margin'           => array(
				'default' => $default_margin,
			),
			$group_id . 'hover_margin'     => array(
				'default' => $default_margin,
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
	 * Register Active Header Tabs Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_active_header_tab_styles() {

		$group_id      = 'active_header_tabs_';
		$base_selector = $this->deep_base_selector . ' ul.tabs li.active';
		$section_label = __( 'Active Header Tab', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = "$base_selector:hover";

		$default_padding = array(
			'top'      => 0,
			'bottom'   => 0,
			'left'     => 16,
			'right'    => 16,
			'isLinked' => false,
		);

		$default_margin = array(
			'top'      => 0,
			'bottom'   => 0,
			'left'     => -5,
			'right'    => -5,
			'isLinked' => false,
		);

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => array(
				'selector' => "$base_selector a",
			),
			$group_id . 'hover_typography' => array(
				'selector' => "$base_selector:hover a",
			),

			$group_id . 'color'            => array(
				'selector' => "$base_selector a",
			),
			$group_id . 'hover_color'      => array(
				'selector' => "$base_selector:hover a",
			),

			$group_id . 'padding'          => array(
				'default' => $default_padding,
			),
			$group_id . 'hover_padding'    => array(
				'default' => $default_padding,
			),

			$group_id . 'margin'           => array(
				'default' => $default_margin,
			),
			$group_id . 'hover_margin'     => array(
				'default' => $default_margin,
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
	 * Register Content Tab Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_content_tab_styles() {

		$group_id      = 'content_tab_';
		$base_selector = $this->deep_base_selector . ' .wc-tab';
		$section_label = __( 'Content Box', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = "$base_selector:hover";

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => false,
			$group_id . 'hover_typography' => false,

			$group_id . 'color'            => false,
			$group_id . 'hover_color'      => false,
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
	 * Register Content Tab Header Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_content_tab_header_styles() {

		$group_id      = 'content_tab_header_';
		$base_selector = $this->deep_base_selector . ' .wc-tab h2';
		$section_label = __( 'Content Header', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = "$base_selector:hover";

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
	 * Register Attributes Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_attributes_styles() {

		$group_id      = 'attributes_';
		$base_selector = $this->deep_base_attributes_selector;
		$section_label = __( 'Attributes Box', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = $base_selector . ':hover';

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => false,
			$group_id . 'hover_typography' => false,

			$group_id . 'color'            => false,
			$group_id . 'hover_color'      => false,
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
	 * Register Attributes Item Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_attributes_item_styles() {

		$group_id      = 'attributes_item_';
		$base_selector = $this->deep_base_attributes_selector . ' .woocommerce-product-attributes-item';
		$section_label = __( 'Attributes Wrapper', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = $base_selector . ':hover';

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
	 * Register Attributes Label Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_attributes_label_styles() {

		$group_id      = 'attributes_label_';
		$base_selector = $this->deep_base_attributes_selector . ' .woocommerce-product-attributes-item__label';
		$section_label = __( 'Attributes Label', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = $base_selector . ':hover';

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
	 * Register Attributes Value Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_attributes_value_styles() {

		$group_id      = 'attributes_value_';
		$base_selector = $this->deep_base_attributes_selector . ' .woocommerce-product-attributes-item__value';
		$section_label = __( 'Attributes Value', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = $base_selector . ':hover';

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => array(
				'selector' => "$selector p",
			),
			$group_id . 'hover_typography' => array(
				'selector' => "$selector:hover p",
			),

			$group_id . 'color'            => array(
				'selector' => "$selector p",
			),
			$group_id . 'hover_color'      => array(
				'selector' => "$selector:hover p",
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
	 * Register Description Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_description_styles() {

		$group_id      = 'description_';
		$base_selector = $this->deep_base_description_selector;
		$section_label = __( 'Description', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = $base_selector . ':hover';

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => array(
				'selector' => "$selector, $selector p",
			),
			$group_id . 'hover_typography' => array(
				'selector' => "$selector:hover, $selector:hover p",
			),

			$group_id . 'color'            => array(
				'selector' => "$selector, $selector p",
			),
			$group_id . 'hover_color'      => array(
				'selector' => "$selector:hover, $selector:hover p",
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
	 * Register Box Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_box_styles() {

		$group_id      = 'review_box_';
		$base_selector = $this->deep_base_review_selector;
		$section_label = __( 'Review Box', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = "$selector:hover";

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => false,
			$group_id . 'hover_typography' => false,

			$group_id . 'color'            => false,
			$group_id . 'hover_color'      => false,
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
	 * Register Title Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_title_styles() {

		$group_id      = 'review_title_';
		$base_selector = $this->deep_base_review_selector . ' #reviews #comments .woocommerce-Reviews-title';
		$section_label = __( 'Review Title', 'deep' );
		$description   = '';

		$selector       = $base_selector;
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
	 * Register Review Item Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_review_item_styles() {

		$group_id      = 'review_item_';
		$base_selector = $this->deep_base_review_selector . ' #reviews #comments .comment_container';
		$section_label = __( 'Review Item', 'deep' );
		$description   = '';

		$selector       = $base_selector;
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
	 * Register Review Avatar Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_review_avatar_styles() {

		$group_id      = 'review_avatar_';
		$base_selector = $this->deep_base_review_selector . ' #reviews #comments .comment_container img.avatar';
		$section_label = __( 'Review Avatar', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = "$selector:hover";

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => false,
			$group_id . 'hover_typography' => false,

			$group_id . 'color'            => false,
			$group_id . 'hover_color'      => false,
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
	 * Register Review Form Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_review_form_styles() {

		$group_id      = 'deep_form_';
		$base_selector = $this->deep_base_review_selector . ' #reviews #review_form_wrapper #respond #commentform';

		$section_label = __( 'Review Form', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = "$base_selector:hover";

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
	 * Register Form Title Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_form_title_styles() {

		$group_id      = 'deep_title_';
		$base_selector = $this->deep_base_review_selector . ' #reviews #review_form_wrapper #respond';

		$section_label = __( 'Review Form Title', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .comment-reply-title';
		$hover_selector = "$base_selector:hover";

		$rewrite_settings_fields = array(
			$group_id . 'margin'        => false,
			$group_id . 'hover_margin'  => false,

			$group_id . 'padding'       => false,
			$group_id . 'hover_padding' => false,
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
	 * Register Form Label Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_form_label_styles() {

		$group_id      = 'deep_label_';
		$base_selector = $this->deep_base_review_selector . ' #reviews #review_form_wrapper #respond #commentform';

		$section_label = __( 'Review Form Label', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' label';
		$hover_selector = "$base_selector:hover";

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
	 * Register Button Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_button_styles() {

		$group_id      = 'deep_button_';
		$base_selector = $this->deep_base_review_selector . ' #reviews #review_form_wrapper #respond #commentform';

		$section_label = __( 'Review Form Button', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .form-submit .submit';
		$hover_selector = "$base_selector:hover";

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
	 * Register Input Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_input_styles() {

		$group_id      = 'deep_input_';
		$base_selector = $this->deep_base_review_selector . '  #reviews #review_form_wrapper #respond #commentform';
		$section_label = __( 'Review Form Input', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' input:not(.submit),'
			. $base_selector . ' select,'
			. $base_selector . ' textarea';
		$hover_selector = $base_selector . ' input:hover,'
			. $base_selector . ' select:hover,'
			. $base_selector . ' textarea:hover';

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
	 * Register Comments Wrapper Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_comments_wrapper_styles() {

		$group_id      = 'deep_tabs_review_comments_wrapper_';
		$base_selector = $this->deep_base_review_selector;
		$section_label = __( 'Comments Wrapper', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' #reviews #comments';
		$hover_selector = $selector . ':hover';

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => false,
			$group_id . 'hover_typography' => false,
			$group_id . 'color'            => false,
			$group_id . 'hover_color'      => false,
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
	 * Register Comments Count Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_comments_count_styles() {

		$group_id      = 'deep_tabs_review_comments_count_';
		$base_selector = $this->deep_base_review_selector;
		$section_label = __( 'Comments Count', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' #reviews #comments h2.woocommerce-Reviews-title';
		$hover_selector = $selector . ':hover';

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
	 * Register Comment User Thumbnail Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_comment_thumbnail_styles() {

		$group_id      = 'deep_tabs_review_comment_thumbnail_';
		$base_selector = $this->deep_base_review_selector;
		$section_label = __( 'Comment Thumbnail', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' #reviews #comments .commentlist li .comment_container img';
		$hover_selector = $selector . ':hover';

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
	 * Register Comment Text Container Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_comment_text_container_styles() {

		$group_id      = 'deep_tabs_review_comment_text_container_';
		$base_selector = $this->deep_base_review_selector;
		$section_label = __( 'Comment Text Container', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' #reviews #comments .commentlist li .comment_container .comment-text';
		$hover_selector = $selector . ':hover';

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
	 * Register Comment Text Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_comment_text_styles() {

		$group_id      = 'deep_tabs_review_comment_text_';
		$base_selector = $this->deep_base_review_selector;
		$section_label = __( 'Comment Text', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' #reviews #comments .commentlist li .comment_container .comment-text .description p';
		$hover_selector = $selector . ':hover';

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
	 * Register Comment Author Name Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_comment_author_name_styles() {

		$group_id      = 'deep_tabs_review_comment_author_name_';
		$base_selector = $this->deep_base_review_selector;
		$section_label = __( 'Comment Author Name', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' #reviews #comments .commentlist li .comment_container .comment-text p.meta strong.woocommerce-review__author';
		$hover_selector = $selector . ':hover';

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
	 * Register Comment Date Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_comment_date_styles() {

		$group_id      = 'deep_tabs_review_comment_date_';
		$base_selector = $this->deep_base_review_selector;
		$section_label = __( 'Comment Date', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' #reviews #comments .commentlist li .comment_container .comment-text p.meta time.woocommerce-review__published-date';
		$hover_selector = $selector . ':hover';

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
	 * Register Comment Star Rating Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_comment_star_rating_styles() {

		$group_id      = 'deep_tabs_review_comment_star_rating_';
		$base_selector = $this->deep_base_review_selector;
		$section_label = __( 'Star Rating', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' #reviews #comments .commentlist li .comment_container .comment-text .star-rating span:before';
		$hover_selector = $selector . ':hover';

		$rewrite_settings_fields = array(
			$group_id . 'typography'          => false,
			$group_id . 'hover_typography'    => false,
			$group_id . 'hover_color'         => false,
			$group_id . 'margin'              => false,
			$group_id . 'hover_margin'        => false,
			$group_id . 'padding'             => false,
			$group_id . 'hover_padding'       => false,
			$group_id . 'background'          => false,
			$group_id . 'hover_background'    => false,
			$group_id . 'border'              => false,
			$group_id . 'hover_border'        => false,
			$group_id . 'border-radius'       => false,
			$group_id . 'hover_border-radius' => false,
			$group_id . 'box_shadow'          => false,
			$group_id . 'hover_box_shadow'    => false,
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
	 * Render the widget output on the frontend.
	 *
	 * @since 2.0.0
	 *
	 * @access protected
	 */
	protected function render() {

		$this->prepare_render();

		if ( $this->can_display_product() ) {

			Templates::widget( 'tabs', array() );
		}

		$this->reset_render();
	}
}
