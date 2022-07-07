<?php
namespace Deep\WooCommerce\Elementor\Widgets;

use Elementor\Plugin;
use Deep\WooCommerce\Elementor\Deep_Product_Widget_Base;
use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce product Review.
 *
 * @since 2.0.0
 */
class Review extends Deep_Product_Widget_Base {

	/**
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $deep_base_selector = '{{WRAPPER}} .deep-woo-reviews';

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
		return 'deep-woo-review';
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
		return __( 'Product Reviews', 'deep' );
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
		return 'deep-widget deep-eicon-product-review';
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
				'label'     => __( 'This widget displays the product reviews.', 'deep' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->end_controls_section();

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
	 * Register Box Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_box_styles() {

		$group_id      = 'review_box_';
		$base_selector = $this->deep_base_selector;
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
		$base_selector = $this->deep_base_selector . ' #reviews #comments .woocommerce-Reviews-title';
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
		$base_selector = $this->deep_base_selector . ' #reviews #comments .comment_container';
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
		$base_selector = $this->deep_base_selector . ' #reviews #comments .comment_container img.avatar';
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
		$base_selector = $this->deep_base_selector . ' #reviews #review_form_wrapper #respond #commentform';

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
		$base_selector = $this->deep_base_selector . ' #reviews #review_form_wrapper #respond';

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
		$base_selector = $this->deep_base_selector . ' #reviews #review_form_wrapper #respond #commentform';

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
		$base_selector = $this->deep_base_selector . ' #reviews #review_form_wrapper #respond #commentform';

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
		$base_selector = $this->deep_base_selector . '  #reviews #review_form_wrapper #respond #commentform';
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
		$base_selector = $this->deep_base_selector;
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
		$base_selector = $this->deep_base_selector;
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
		$base_selector = $this->deep_base_selector;
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
		$base_selector = $this->deep_base_selector;
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
		$base_selector = $this->deep_base_selector;
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
		$base_selector = $this->deep_base_selector;
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
		$base_selector = $this->deep_base_selector;
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
		$base_selector = $this->deep_base_selector;
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

		if ( ! Plugin::$instance->editor->is_edit_mode() ) {

			if ( $this->can_display_product() ) {

				Templates::widget( 'review', array() );
			}
		}
	}
}
