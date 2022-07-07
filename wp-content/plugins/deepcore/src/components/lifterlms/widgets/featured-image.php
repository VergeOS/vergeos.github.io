<?php

namespace LifterLMS\Elementor\Widgets;

use Elementor\Plugin;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Deep\Components\LifterLMS;

defined('ABSPATH') || exit;

/**
 * Elementor widget for LifterLMS Course Featured Image.
 *
 * @since 5.0.0
 */
class FeaturedImage extends Widget_Base
{
	/**
	 * Retrieve the widget name.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name()
	{
		return 'llms-course-featured-image';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title()
	{
		return __('LifterLMS Course Featured Image', 'deep');
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon()
	{
		return 'deep-widget deep-eicon-llms-course-featured-image';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories()
	{
		return ['Deep_LifterLMS'];
	}

	/**
	 * Load depend scripts.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public function get_script_depends() {
		return array( 'deep-magnific-popup', 'deep-video-ply-btn' );
	}

	/**
	 * Load depend styles.
	 *
	 * @since 5.0.0
	 *
	 * @access protected
	 */
	public function get_style_depends() {
		return array( 'deep-llms-course-featured-image', 'deep-magnific-popup' );
	}

	/**
	 * Register the widget controls.
	 *
	 * @since 5.0.0
	 *
	 * @access protected
	 */
	protected function register_controls()
	{
		$this->start_controls_section(
			'section_content',
			[
				'label' => __('General', 'deep'),
			]
		);

		$this->add_control(
			'display_video',
			[
				'label' => __( 'Display featured video if it\'s available', 'deep' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'deep' ),
				'label_off' => __( 'No', 'deep' ),
			]
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
				'selector' => '{{WRAPPER}} .deep-llms-course-featured-image',
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
					'{{WRAPPER}} .deep-llms-course-featured-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .deep-llms-course-featured-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'  => 'box_border',
				'label' => __('Border', 'deep'),
				'selector' => '{{WRAPPER}} .deep-llms-course-featured-image',
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
					'{{WRAPPER}} .deep-llms-course-featured-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_box_shadow',
				'label' =>  esc_html__('Box Shadow', 'deep'),
				'selector' => '{{WRAPPER}} .deep-llms-course-featured-image',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'image_style',
			[
				'label' => __('Featured Image', 'deep'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'  => 'image_background',
				'label' => __('Background', 'deep'),
				'types' => ['classic'],
				'selector' => '{{WRAPPER}} .deep-llms-course-featured-image img',
			]
		);

		$this->add_responsive_control(
			'image_padding',
			[
				'label' => __('Padding', 'deep'),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' 	=> ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'{{WRAPPER}} .deep-llms-course-featured-image img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_margin',
			[
				'label' => __('Margin', 'deep'),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' 	=> ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'{{WRAPPER}} .deep-llms-course-featured-image img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'  => 'image_border',
				'label' => __('Border', 'deep'),
				'selector' => '{{WRAPPER}} .deep-llms-course-featured-image img',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => __('Border Radius', 'deep'),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices'    => ['desktop', 'tablet', 'mobile'],
				'selectors'  => [
					'{{WRAPPER}} .deep-llms-course-featured-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_box_shadow',
				'label' =>  esc_html__('Box Shadow', 'deep'),
				'selector' => '{{WRAPPER}} .deep-llms-course-featured-image img',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * @since 5.0.0
	 *
	 * @access protected
	 */
	protected function render() {

		global $post;

		$id = '';

		// This only for the preview in the editor mode
		if ( Plugin::$instance->editor->is_edit_mode() ) {
			$id = LifterLMS::get_course();
		}

		$post_id   		  = $post->ID;
		$video_url 		  = LifterLMS::get_featured_video_url( $post_id );
		$settings		  = $this->get_settings_for_display();
		$thumbnail 		  = get_the_post_thumbnail_url( $id );
		$display_video    = $settings['display_video'] ? true : false;

		if ( $thumbnail ) {
			?>
			<div class="deep-llms-course-featured-image">
				<img src="<?php echo esc_url( $thumbnail ); ?>" alt="Course Featured Image">

				<?php if ( $display_video && $video_url ) :?>
					<a href="<?php echo esc_url( $video_url ); ?>" class="llms-video-link wn-popup-video video-play-btn video-play-btn">
						<div class="llms-video">
						<svg xmlns="http://www.w3.org/2000/svg" width="19.116" height="21.849" viewBox="0 0 19.116 21.849">
							<path d="M18.11,9.162,3.089.283A2.037,2.037,0,0,0,0,2.045V19.8a2.046,2.046,0,0,0,3.089,1.762l15.02-8.876A2.046,2.046,0,0,0,18.11,9.162Z" transform="translate(0 -0.002)" fill="#fff"/>
						</svg>

						</div>
					</a>
				<?php endif; ?>
			</div>
			<?php
		}
	}
}
