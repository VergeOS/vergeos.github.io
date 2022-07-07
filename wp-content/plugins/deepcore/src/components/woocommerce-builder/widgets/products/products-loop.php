<?php

namespace Deep\WooCommerce\Elementor\Widgets\Products_Loop;

use Elementor\Repeater;
use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;
use Deep\WooCommerce\Elementor\Deep_Loop_Products_Widget_Base;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce Products Loop.
 *
 * @since 2.0.0
 */
class Products_Loop extends Deep_Loop_Products_Widget_Base {

	/**
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $deep_base_selector = '{{WRAPPER}}';

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
		return 'deep-woo-products-loop';
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
		return __( 'Products Loop', 'deep' );
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
		return 'deep-widget deep-eicon-product-loop';
	}

	/**
	 * Load depend scripts.
	 *
	 * @since 2.0.0
	 *
	 * @access protected
	 */
	public function get_script_depends() {
		return array( 'deep-woo-products-loop' );
	}

	/**
	 * Load depend styles.
	 *
	 * @since 2.0.0
	 *
	 * @access protected
	 */
	public function get_style_depends() {
		return array( 'deep-woo-products-loop','deep-pagination' );
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

		$this->register_query_controls();

		$this->end_controls_section();

		// $this->register_filters_controls();

		$this->register_loop_styles();
		$this->register_result_count_styles();
		$this->register_load_more_button_styles();

		$this->register_title_styles();
		$this->register_rating_styles();
		$this->register_image_styles();
		$this->register_price_styles();
		$this->register_button_styles();
	}

	/**
	 * Register Query controls.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_query_controls() {

		$templates = $this->get_loop_templates( 'loop_product' );
		$this->add_control(
			'template_id',
			array(
				'type'    => Controls_Manager::SELECT2,
				'label'   => __( 'Template', 'deep' ),
				'default' => 0,
				'options' => $templates,
			)
		);

		$default_atts = $this->get_default_query_attributes();

		$this->add_control(
			'limit',
			array(
				'type'    => Controls_Manager::NUMBER,
				'label'   => __( 'Limit', 'deep' ),
				'min'     => -1,
				'max'     => 10000,
				'step'    => 1,
				'default' => $default_atts['limit'],
			)
		);

		$this->add_control(
			'columns',
			array(
				'type'    => Controls_Manager::NUMBER,
				'label'   => __( 'Columns', 'deep' ),
				'default' => $default_atts['columns'],
			)
		);

		$this->add_control(
			'paginate',
			array(
				'label'        => __( 'Pagination', 'deep' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => __( 'Show', 'deep' ),
				'label_off'    => __( 'Hide', 'deep' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'load_more_button',
			array(
				'label'        => __( 'Load More Button', 'deep' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => __( 'Show', 'deep' ),
				'label_off'    => __( 'Hide', 'deep' ),
				'return_value' => 'yes',
				'selectors'    => array(
					'{{WRAPPER}} .woocommerce-pagination' => 'display:none;',
					'{{WRAPPER}} .deep-woo-loadmore-wrapper' => 'display:block;',
				),
				'condition'    => array(
					'paginate' => 'yes',
				),
			)
		);

		$this->add_control(
			'loadmore_text',
			array(
				'label'     => __( 'Load More Button Text', 'deep' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Load More', 'deep' ),
				'condition' => array(
					'paginate'         => 'yes',
					'load_more_button' => 'yes',
				),
			)
		);

		$this->add_control(
			'result_count',
			array(
				'label'        => __( 'Result Count', 'deep' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Show', 'deep' ),
				'label_off'    => __( 'Hide', 'deep' ),
				'return_value' => 'yes',
				'condition'    => array(
					'paginate' => 'yes',
				),
			)
		);

		$this->add_control(
			'catalog_ordering',
			array(
				'label'        => __( 'Order By Form', 'deep' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Show', 'deep' ),
				'label_off'    => __( 'Hide', 'deep' ),
				'return_value' => 'yes',
				'condition'    => array(
					'paginate' => 'yes',
				),
			)
		);

		$this->add_control(
			'orderby',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => __( 'Order By', 'deep' ),
				'default' => $default_atts['orderby'],
				'options' => array(
					'id'         => __( 'ID', 'deep' ),
					'title'      => __( 'Title', 'deep' ),
					'date'       => __( 'Date', 'deep' ),
					'rand'       => __( 'Random', 'deep' ),
					'price'      => __( 'Price', 'deep' ),
					'popularity' => __( 'Popularity', 'deep' ),
					'rating'     => __( 'Rating', 'deep' ),
				),
			)
		);

		$this->add_control(
			'order',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => __( 'Order', 'deep' ),
				'default' => $default_atts['order'],
				'options' => array(
					'ASC'  => __( 'ASC', 'deep' ),
					'DESC' => __( 'DESC', 'deep' ),
				),
			)
		);

		$this->add_control(
			'ids',
			array(
				'type'        => Controls_Manager::TEXT,
				'label'       => __( 'Product IDs', 'deep' ),
				'default'     => $default_atts['ids'],
				'options'     => array(
					'ASC'  => __( 'ASC', 'deep' ),
					'DESC' => __( 'DESC', 'deep' ),
				),
				'placeholder' => __( 'ex: 1,2,3,4', 'deep' ),
			)
		);

		$this->add_control(
			'skus',
			array(
				'type'        => Controls_Manager::TEXT,
				'label'       => __( 'SKUs', 'deep' ),
				'default'     => $default_atts['skus'],
				'placeholder' => __( 'ex: 1,2,3,4', 'deep' ),
			)
		);

		$this->add_control(
			'cat_operator',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => __( 'Category Operator', 'deep' ),
				'default' => $default_atts['cat_operator'],
				'options' => array(
					'IN'     => __( 'Include', 'deep' ),
					'NOT IN' => __( 'Exclude', 'deep' ),
				),
			)
		);

		$product_cats = $this->get_terms_for_select( 'product_cat' );
		$this->add_control(
			'category',
			array(
				'type'     => Controls_Manager::SELECT2,
				'multiple' => true,
				'label'    => __( 'Categories', 'deep' ),
				'default'  => (array) $default_atts['category'],
				'options'  => $product_cats,
			)
		);

		$this->add_control(
			'tag_operator',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => __( 'Tag Operator', 'deep' ),
				'default' => $default_atts['tag_operator'],
				'options' => array(
					'IN'     => __( 'Include', 'deep' ),
					'NOT IN' => __( 'Exclude', 'deep' ),
				),
			)
		);

		$product_tags = $this->get_terms_for_select( 'product_tag' );
		$this->add_control(
			'tag',
			array(
				'type'     => Controls_Manager::SELECT2,
				'multiple' => true,
				'label'    => __( 'Tags', 'deep' ),
				'default'  => (array) $default_atts['tag'],
				'options'  => $product_tags,
			)
		);

	}

	/**
	 * Register Filters controls.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_filters_controls() {

		if ( 'deep_woo_pages' == get_post_type() || is_shop() || is_archive() ) {
			$this->start_controls_section(
				'section_filters',
				array(
					'label' => __( 'Filters', 'deep' ),
				)
			);
			$this->add_control(
				'filters_area',
				array(
					'label'        => __( 'Filters', 'deep' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => __( 'Show', 'deep' ),
					'label_off'    => __( 'Hide', 'deep' ),
					'return_value' => 'yes',
				)
			);

			$filters = new Repeater();
			$filters->add_control(
				'filter_repeater_select',
				array(
					'label'   => esc_html__( 'Component', 'deep' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'cats',
					'options' => array(
						'Layered_Nav_Filters'	=> esc_html__( 'Active filters', 'deep' ),
						'Product_Search'		=> esc_html__( 'Search', 'deep' ),
						'Layered_Nav'			=> esc_html__( 'Filter product by attribute', 'deep' ),
						'Rating_Filter'			=> esc_html__( 'Filter product by rating', 'deep' ),
						'Price_Filter'			=> esc_html__( 'Filter product by price', 'deep' ),
						'Product_Categories'	=> esc_html__( 'Product categories', 'deep' ),
						'Product_Tag_Cloud'		=> esc_html__( 'Product tags', 'deep' ),
					),
				)
			);
			$filters->add_control(
				'Product_Categories_Title',
				array(
					'label'     => __( 'Title', 'deep' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => 'Categories',
					'condition' => array(
						'filter_repeater_select' => 'Product_Categories',
					),
				)
			);

			$filters->add_control(
				'Product_Categories_Orderby',
				array(
					'type'    => Controls_Manager::SELECT,
					'label'   => __( 'Order by', 'deep' ),
					'default' => 'name',
					'options' => array(
						'order'	=> __( 'Category Order', 'deep' ),
						'name'	=> __( 'Name', 'deep' ),
					),
					'condition' => array(
						'filter_repeater_select' => 'Product_Categories',
					),
				)
			);
			$filters->add_control(
				'Product_Categories_Dropdown',
				array(
					'label'        => __( 'Show as dropdown', 'deep' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => __( 'Show', 'deep' ),
					'label_off'    => __( 'Hide', 'deep' ),
					'return_value' => 'yes',
					'condition'	=> array(
						'filter_repeater_select' => 'Product_Categories',
					),
				)
			);

			$filters->add_control(
				'Product_Categories_Count',
				array(
					'label'        => __( 'Show product counts', 'deep' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => __( 'Show', 'deep' ),
					'label_off'    => __( 'Hide', 'deep' ),
					'return_value' => 'yes',
					'condition'	=> array(
						'filter_repeater_select' => 'Product_Categories',
					),
				)
			);
			$filters->add_control(
				'Product_Categories_Hierarchical',
				array(
					'label'        => __( 'Show hierarchy', 'deep' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => __( 'Show', 'deep' ),
					'label_off'    => __( 'Hide', 'deep' ),
					'return_value' => 'yes',
					'condition'	=> array(
						'filter_repeater_select' => 'Product_Categories',
					),
				)
			);
			// 'max_depth'			=> '',
			$filters->add_control(
				'Product_Categories_Show_Children_Only',
				array(
					'label'        => __( 'Show Children Only', 'deep' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => __( 'Show', 'deep' ),
					'label_off'    => __( 'Hide', 'deep' ),
					'return_value' => 'yes',
					'condition'	=> array(
						'filter_repeater_select' => 'Product_Categories',
					),
				)
			);
			$filters->add_control(
				'Product_Categories_Hide_Empty',
				array(
					'label'        => __( 'Hide Empty', 'deep' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => __( 'Show', 'deep' ),
					'label_off'    => __( 'Hide', 'deep' ),
					'return_value' => 'yes',
					'condition'	=> array(
						'filter_repeater_select' => 'Product_Categories',
					),
				)
			);
			$filters->add_control(
				'Product_Categories_Max_Depth',
				array(
					'label'        => __( 'Max Depth', 'deep' ),
					'type'         => Controls_Manager::NUMBER,
					'condition'	=> array(
						'filter_repeater_select' => 'Product_Categories',
					),
				)
			);

			$filters->add_control(
				'Product_Tag_Cloud_Title',
				array(
					'label'     => __( 'Title', 'deep' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => 'Tags',
					'condition' => array(
						'filter_repeater_select' => 'Product_Tag_Cloud',
					),
				)
			);
			$filters->add_control(
				'Layered_Nav_Title',
				array(
					'label'     => __( 'Title', 'deep' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => 'Attribute',
					'condition' => array(
						'filter_repeater_select' => 'Layered_Nav',
					),
				)
			);
			$filters->add_control(
				'attribute',
				array(
					'label'     => esc_html__( 'Attribute', 'deep' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '0',
					'options'   => $this->attributes(),
					'condition' => array(
						'filter_repeater_select' => 'Layered_Nav',
					),
				)
			);
			$filters->add_control(
				'attribute_display_type',
				array(
					'label'     => esc_html__( 'Display type', 'deep' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'list',
					'options'   => array(
						'dropdown' => __( 'Dropdown', 'deep' ),
						'list'     => __( 'List', 'deep' ),
					),
					'condition' => array(
						'filter_repeater_select' => 'Layered_Nav',
					),
				)
			);
			$filters->add_control(
				'attribute_query_type',
				array(
					'label'     => esc_html__( 'Query type', 'deep' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'and',
					'options'   => array(
						'and' => __( 'AND', 'deep' ),
						'or'  => __( 'OR', 'deep' ),
					),
					'condition' => array(
						'filter_repeater_select' => 'Layered_Nav',
					),
				)
			);
			$filters->add_control(
				'Price_Filter_Title',
				array(
					'label'     => __( 'Title', 'deep' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => 'Price',
					'condition' => array(
						'filter_repeater_select' => 'Price_Filter',
					),
				)
			);
			$filters->add_control(
				'Product_Search_Title',
				array(
					'label'     => __( 'Title', 'deep' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => 'Search',
					'condition' => array(
						'filter_repeater_select' => 'Product_Search',
					),
				)
			);
			$filters->add_control(
				'Rating_Filter_Title',
				array(
					'label'     => __( 'Title', 'deep' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => 'Rating',
					'condition' => array(
						'filter_repeater_select' => 'Rating_Filter',
					),
				)
			);
			$filters->add_control(
				'Layered_Nav_Filters_Title',
				array(
					'label'     => __( 'Title', 'deep' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => 'Active Filters',
					'condition' => array(
						'filter_repeater_select' => 'Layered_Nav_Filters',
					),
				)
			);
			$this->add_control(
				'filter_repeaters',
				array(
					'label'       => __( 'Filters', 'deep' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $filters->get_controls(),
					'title_field' => '{{{ filter_repeater_select }}}',
					'default'     => array(
						array(
							'filter_repeater_select' => 'Layered_Nav_Filters',
						),
						array(
							'filter_repeater_select' => 'Product_Search',
						),
						array(
							'filter_repeater_select' => 'Layered_Nav',
						),
						array(
							'filter_repeater_select' => 'Rating_Filter',
						),
						array(
							'filter_repeater_select' => 'Price_Filter',
						),
						array(
							'filter_repeater_select' => 'Product_Categories',
						),
						array(
							'filter_repeater_select' => 'Product_Tag_Cloud',
						),
					),
					'condition' => array(
						'filters_area' => 'yes'
					)
				)
			);

			$this->end_controls_section();
		}
	}

	/**
	 * Register loop Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_loop_styles() {

		$group_id      = 'loop_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Items', 'deep' );
		$description   = '';

		$selector       = "$base_selector ul li";
		$hover_selector = $selector . ':hover';

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => false,
			$group_id . 'hover_typography' => false,

			$group_id . 'color'            => false,
			$group_id . 'hover_color'      => false,

			$group_id . 'margin'           => false,
			$group_id . 'hover_margin'     => false,

			$group_id . 'min_height'       => array(
				'type' => 'min_height',
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
	 * Register Result Count Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_result_count_styles() {

		$group_id      = 'loop_result_count_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Result Count', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .woocommerce-result-count';
		$hover_selector = $base_selector . ' .woocommerce-result-count:hover';

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => array(
				'text_align' => false,
			),
			$group_id . 'hover_typography' => array(
				'text_align' => false,
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
	 * Attributes.
	 *
	 * @since 2.0.0
	 *
	 * @access protected
	 */
	public function attributes() {
		$attrs = array( '0' => __( 'Select a attribute' ) );
		foreach ( wc_get_attribute_taxonomies() as $value ) {
			$attrs[ strtolower($value->attribute_name) ] = $value->attribute_label;
		}
		return $attrs;
	}

	/**
	 * Loop Options.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function loop_options() {

		$settings = $this->get_settings_for_display();

		if ( $settings['result_count'] != 'yes' ) {
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		}

		if ( $settings['catalog_ordering'] != 'yes' ) {
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
		}

		if ( isset( $settings['filters_area'] ) && $settings['filters_area'] == 'yes' ) {
			add_action( "woocommerce_shortcode_before_{$this->get_name()}_loop", array( $this, 'filters_area' ), 30 );
		}
	}

	/**
	 * Register Title Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_title_styles() {

		$group_id      = 'product_title_';
		$base_selector = $this->deep_base_selector . ' ul li';
		$section_label = __( 'Product Title', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .woocommerce-loop-product__title';
		$hover_selector = $base_selector . ' .woocommerce-loop-product__title:hover';

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => array(
				'selector' => "$selector, $selector a",
			),
			$group_id . 'hover_typography' => array(
				'selector' => "$selector:hover, $selector:hover a",
			),

			$group_id . 'color'            => array(
				'selector' => "$selector, $selector a",
			),
			$group_id . 'hover_color'      => array(
				'selector' => "$selector:hover, $selector:hover a",
			),

			$group_id . 'min_width'        => array(
				'type' => 'min_width',
			),
			$group_id . 'hover_min_width'  => array(
				'type' => 'min_width',
			),
		);

		$condition = array(
			array(
				$group_id . 'template_id' => '0',
			),
		);

		$this->deep_register_styles_controls(
			$group_id,
			$section_label,
			$description,
			$selector,
			$hover_selector,
			$rewrite_settings_fields,
			$condition
		);
	}

	/**
	 * Register Image Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_image_styles() {

		$group_id      = 'product_thumbnail_';
		$base_selector = $this->deep_base_selector . ' ul li';
		$section_label = __( 'Thumbnail', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' a img';
		$hover_selector = "$selector:hover";

		$rewrite_settings_fields = array(
			$group_id . 'typography'        => false,
			$group_id . 'hover_typography'  => false,

			$group_id . 'color'             => false,
			$group_id . 'hover_color'       => false,

			$group_id . 'align'             => array(
				'type' => 'align',
			),
			$group_id . 'hover_align'       => array(
				'type' => 'align',
			),

			$group_id . 'image_width'       => array(
				'type' => 'image_width',
			),
			$group_id . 'hover_image_width' => array(
				'type' => 'image_width',
			),

			$group_id . 'max_width'         => array(
				'type' => 'max_width',
			),
			$group_id . 'hover_max_width'   => array(
				'type' => 'max_width',
			),

			$group_id . 'max_height'        => array(
				'type' => 'max_height',
			),
			$group_id . 'hover_max_height'  => array(
				'type' => 'max_height',
			),

			$group_id . 'opacity'           => array(
				'type' => 'opacity',
			),
			$group_id . 'hover_opacity'     => array(
				'type' => 'opacity',
			),

			$group_id . 'css_filter'        => array(
				'type' => 'css_filter',
			),
			$group_id . 'hover_css_filter'  => array(
				'type' => 'css_filter',
			),

			$group_id . 'hover_transition'  => array(
				'type' => 'transition',
			),

			$group_id . 'hover_animation'   => array(
				'type' => 'hover_animation',
			),

		);

		$condition = array(
			array(
				$group_id . 'template_id' => '0',
			),
		);

		$this->deep_register_styles_controls(
			$group_id,
			$section_label,
			$description,
			$selector,
			$hover_selector,
			$rewrite_settings_fields,
			$condition
		);
	}

	/**
	 * Register Price Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_price_styles() {

		$group_id      = 'price_';
		$base_selector = $this->deep_base_selector . ' ul li';
		$section_label = __( 'Price', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .price';
		$hover_selector = $selector . ':hover';

		$rewrite_settings_fields = array();

		$condition = array(
			array(
				$group_id . 'template_id' => '0',
			),
		);

		$this->deep_register_styles_controls(
			$group_id,
			$section_label,
			$description,
			$selector,
			$hover_selector,
			$rewrite_settings_fields,
			$condition
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
		$base_selector = $this->deep_base_selector . ' ul li';
		$section_label = __( 'Button', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .button';
		$hover_selector = "$selector button:hover";

		$rewrite_settings_fields = array();

		$condition = array(
			array(
				$group_id . 'template_id' => '0',
			),
		);

		$this->deep_register_styles_controls(
			$group_id,
			$section_label,
			$description,
			$selector,
			$hover_selector,
			$rewrite_settings_fields,
			$condition
		);
	}

	/**
	 * Register Rating Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_rating_styles() {

		$group_id      = 'rating';
		$base_selector = $this->deep_base_selector . ' ul li';
		$section_label = __( 'Rating', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .star-rating';
		$hover_selector = "$base_selector .star-rating:hover";

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => false,
			$group_id . 'hover_typography' => false,
		);

		$condition = array(
			array(
				$group_id . 'template_id' => '0',
			),
		);

		$this->deep_register_styles_controls(
			$group_id,
			$section_label,
			$description,
			$selector,
			$hover_selector,
			$rewrite_settings_fields,
			$condition
		);
	}

	/**
	 * Register Load More Button Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_load_more_button_styles() {

		$group_id      = 'load_more_button_';
		$base_selector = $this->deep_base_selector . ' .deep-woo-loadmore-wrapper';
		$section_label = __( 'Load More button', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .deep-woo-loadmore';
		$hover_selector = $base_selector . ' .deep-woo-loadmore:hover';

		$rewrite_settings_fields = [
			$group_id . 'typography' => [
				'selector' => "$base_selector, $selector"
			],
			$group_id . 'hover_typography' => [
				'selector' => "$base_selector, $selector"
			],

			$group_id . 'margin' => [
				'selector' => "$base_selector, $selector"
			],
			$group_id . 'hover_margin' => [
				'selector' => "$base_selector, $selector"
			],
		];

		$condition = [
			'load_more_button' => 'yes',
		];

		$this->deep_register_styles_controls(
			$group_id,
			$section_label,
			$description,
			$selector,
			$hover_selector,
			$rewrite_settings_fields,
			$condition
		);
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function render() {

		$widget_name      = $this->get_name();
		$settings         = $this->get_settings_for_display();
		$deep_template_id = $this->get_template_id( $widget_name, $settings );

		$atts = $this->get_default_query_attributes();
		$atts = $this->parse_attributes( $atts, $settings );
		$widget = '';

		$this->loop_options();

		$args = array(
			'template_id' => $deep_template_id,
		);
		$this->prepare_loop( $args );

		$shortcode = new \WC_Shortcode_Products( $atts, $widget_name );

		/**
		 * OutPut
		 */
		echo '<div class="deep-woo-products-loop-wrapper">';

			do_action( 'deep_woo_before_product_loop' );

			echo $shortcode->get_content();
			$this->loadmore( $settings );
			$this->reset_loop( $args );

			do_action( 'deep_woo_after_product_loop' );

		echo '</div>';

	}

	/**
	 * Filters Area
	 *
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return HTML
	 */
	public function filters_area() {

		$settings = $this->get_settings_for_display();
		$filters  = $settings['filter_repeaters'];

		if ( ! is_shop() || ! is_archive() || 'yes' != $settings['filters_area'] ) {
			return;
		}

		echo '<span class="deep-woo-sidebar-toggle">';
		echo '<i class="deep-woo-sidebar-toggle-icon pe-7s-filter"></i>';
		echo __( 'Filter', 'deep' );
		echo '</span>';
		echo '<div class="deep-woo-sidebar">';
			echo '<div class="filters-header">';
			echo '<span>' . __( 'Filters', 'deep' ) . '</span>';
			echo '<i class="deep-woo-sidebar-toggle ti-download"></i>';
			echo '</div>';
			foreach ( $filters as $value ) {

				$value['Product_Categories_Dropdown'] = 'yes' == $value['Product_Categories_Dropdown'] ? true : false;
				$value['Product_Categories_Count'] = 'yes' == $value['Product_Categories_Count'] ? true : false;
				$value['Product_Categories_Hierarchical'] = 'yes' == $value['Product_Categories_Hierarchical'] ? true : false;
				$value['Product_Categories_Show_Children_Only'] = 'yes' == $value['Product_Categories_Show_Children_Only'] ? true : false;
				$value['Product_Categories_Hide_Empty'] = 'yes' == $value['Product_Categories_Hide_Empty'] ? true : false;

				switch ( $value['filter_repeater_select'] ) {
					case 'Layered_Nav_Filters':
						the_widget(
							'WC_Widget_Layered_Nav_Filters',
							array(
								'title' => $value['Layered_Nav_Filters_Title']
							)
						);
					break;

					case 'Product_Search':
						the_widget(
							'WC_Widget_Product_Search',
							array(
								'title' => $value['Product_Search_Title']
							)
						);
					break;

					case 'Layered_Nav':
						the_widget(
							'Deep_Widget_Layered_Nav',
							array(
								'title'			=> $value['Layered_Nav_Title'],
								'attribute'		=> $value['attribute'],
								'display_type'	=> $value['attribute_display_type'],
								'query_type'	=> $value['attribute_query_type'],
							)
						);
					break;

					case 'Rating_Filter':
						echo get_the_widget(
							'WC_Widget_Rating_Filter',
							array(
								'title' => $value['Rating_Filter_Title']
							)
						);
					break;

					case 'Price_Filter':
						the_widget(
							'WC_Widget_Price_Filter',
							array(
								'title' => $value['Price_Filter_Title']
							)
						);
					break;

					case 'Product_Categories':
						the_widget(
							'WC_Widget_Product_Categories',
							array(
								'title'				=> $value['Product_Categories_Title'],
								'orderby'			=> $value['Product_Categories_Orderby'],
								'dropdown'			=> $value['Product_Categories_Dropdown'],
								'count'				=> $value['Product_Categories_Count'],
								'hierarchical' 		=> $value['Product_Categories_Hierarchical'],
								'show_children_only'=> $value['Product_Categories_Show_Children_Only'],
								'hide_empty'		=> $value['Product_Categories_Hide_Empty'],
								'max_depth'			=> $value['Product_Categories_Max_Depth'],
							)
						);
					break;

					case 'Product_Tag_Cloud':
						the_widget(
							'WC_Widget_Product_Tag_Cloud',
							array(
								'title' => $value['Product_Tag_Cloud_Title']
							)
						);
					break;
				}
			}
		echo '</div>';
	}


	/**
	 * Load More Button
	 *
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return HTML
	 */
	public function loadmore( $settings ) {

		if ( ! empty( $settings['loadmore_text'] ) && 'yes' == $settings['load_more_button'] ) {

			echo '<div class="deep-woo-loadmore-wrapper">';
			echo '<a href="#" class="deep-woo-loadmore">' . $settings['loadmore_text'] . '</a>';
			echo '</div>';
		}
	}

	/**
	 * Get Terms For Select Box
	 *
	 * @param string $taxonomy
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array
	 */
	public function get_terms_for_select( $taxonomy ) {

		$terms = get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
			)
		);

		$options = array();

		foreach ( $terms as $term ) {

			$key   = $term->term_taxonomy_id;
			$title = sprintf(
				'%s ( %d )',
				$term->name,
				$term->count
			);

			$options[ $key ] = $title;
		}

		return $options;
	}

	/**
	 * Get Default Query Args and Attributes
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array
	 */
	public function get_default_query_attributes() {

		$current_obj = get_queried_object();
		$atts = array(
			'limit'          => '12',
			'columns'        => '3',
			'rows'           => '',
			'orderby'        => '',
			'order'          => '',
			'ids'            => '',
			'skus'           => '',
			'category'       => isset( $current_obj->term_id ) ? $current_obj->term_id : '',
			'cat_operator'   => 'IN',
			'attribute'      => '',
			'terms'          => '',
			'terms_operator' => 'IN',
			'tag'            => '',
			'tag_operator'   => 'IN',
			'visibility'     => 'visible',
			'class'          => '',
			'page'           => 1,
			'paginate'       => false,
			'cache'          => true,
		);

		return $atts;
	}

	/**
	 * Returns the tags slug
	 *
	 * @since 2.1.1
	 *
	 * @access public
	 *
	 * @return array
	 */
	public function get_tag_slug( $IDs ) {

		$slugs = array();

		if ( $IDs ) {
			foreach ( $IDs as $id ) {
				$tag = get_term_by( 'id', $id, 'product_tag' );
				if ( isset( $tag->slug ) ) {
					$slugs[] = $tag->slug;
				}
			}
		}

		if ( $slugs ) {
			return implode( ',', $slugs );
		}

		return '';
	}

	/**
	 * Add Attributes from Settings
	 *
	 * @param array $atts
	 * @param array $settings
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array
	 */
	public function parse_attributes( $atts, $settings ) {

		$atts['limit']        = isset( $settings['limit'] ) ? (int) $settings['limit'] : '';
		$atts['columns']      = isset( $settings['columns'] ) ? (int) $settings['columns'] : '';
		$atts['paginate']     = 'yes' == $settings['paginate'] ? true : false;
		$atts['orderby']      = isset( $settings['orderby'] ) ? $settings['orderby'] : '';
		$atts['order']        = isset( $settings['order'] ) ? $settings['order'] : '';
		$atts['ids']          = isset( $settings['ids'] ) ? $settings['ids'] : '';
		$atts['skus']         = isset( $settings['skus'] ) ? $settings['skus'] : '';
		$atts['category']     = isset( $settings['category'] ) ? implode( ',', (array) $settings['category'] ) : '';
		$atts['cat_operator'] = isset( $settings['cat_operator'] ) ? $settings['cat_operator'] : 'IN';
		$atts['tag']          = isset( $settings['tag'] ) ? $this->get_tag_slug( $settings['tag'] ) : '';
		$atts['tag_operator'] = isset( $settings['tag_operator'] ) ? $settings['tag_operator'] : 'IN';

		return $atts;
	}

}

