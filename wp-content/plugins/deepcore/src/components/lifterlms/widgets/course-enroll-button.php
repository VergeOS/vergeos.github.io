<?php

namespace LifterLMS\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Deep\Components\LifterLMS;

defined('ABSPATH') || exit;

/**
 * Elementor widget for LifterLMS Course Student Counter.
 *
 * @since 5.0.0
 */
class CourseEnrollButton extends Widget_Base {
    /**
     * Retrieve the widget name.
     *
     * @since 5.0.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'llms-course-enroll-button';
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
    public function get_title() {
        return __('LifterLMS Custom Enroll Button', 'deep');
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
    public function get_icon() {
        return 'deep-widget deep-eicon-llms-course-enroll-button';
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
    public function get_categories() {
        return ['Deep_LifterLMS'];
    }

    /**
     * Load depend styles.
     *
     * @since 5.0.0
     *
     * @access public
     */
    public function get_style_depends() {
        return ['deep-llms-enroll-button'];
    }

    /**
     * Register the widget controls.
     *
     * @since 5.0.0
     *
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('General', 'deep'),
            ]
        );

        $this->add_control(
            'access_plan_id',
            [
                'label' => __('Enter the ID of the access plan.', 'deep'),
                'type'  => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'course_enroll_button_text',
            [
                'label'         => __('Label', 'deep'),
                'type'             => Controls_Manager::TEXT,
                'default'         => __('Enroll Course', 'deep'),
                'placeholder'     => __('Type your Label here', 'deep'),
            ]
        );

        $this->end_controls_section();

        //Styling
        $this->start_controls_section(
            'button_style',
            [
                'label' => __('Styling', 'deep'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'btn_text_font',
                'label' => __('Typography', 'deep'),
                'selector' => '{{WRAPPER}} a.deep-llms-course-enroll-button',
            ]
        );

        $this->add_responsive_control(
            'text_align',
            [
                'label'     => __('Alignment', 'deep'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __('Left', 'deep'),
                        'icon'  => 'wn-fa wn-fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'deep'),
                        'icon'  => 'wn-fa wn-fa-align-center',
                    ],
                    'right'  => [
                        'title' => __('Right', 'deep'),
                        'icon'  => 'wn-fa wn-fa-align-right',
                    ],
                ],
                'default'   => 'left',
                'toggle'    => true,
                'selectors' => [
                    '#wrap {{WRAPPER}}' => 'text-align: {{VALUE}}',
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
            ]
        );

        $this->add_control(
            'hr',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );


        $this->start_controls_tabs(
            'wn_style_tabs'
        );

        $this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => __('Normal', 'deep'),
            ]
        );

        $this->add_control(
            'btn_color',
            [
                'label'         =>  esc_html__('Text Color', 'deep'),
                'type'             => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} a.deep-llms-course-enroll-button' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'btn_border_color',
            [
                'label'         =>  esc_html__('Border color', 'deep'),
                'type'             => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} a.deep-llms-course-enroll-button' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_background',
                'label' =>  esc_html__('Background', 'deep'),
                'types' => ['classic', 'gradient',],
                'selector' => '{{WRAPPER}} a.deep-llms-course-enroll-button',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => __('Hover', 'deep'),
            ]
        );

        $this->add_control(
            'btn_color_hover',
            [
                'label'         =>  esc_html__('Text Color', 'deep'),
                'type'             => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} a.deep-llms-course-enroll-button:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'btn_border_color_hover',
            [
                'label'         =>  esc_html__('Border color', 'deep'),
                'type'             => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} a.deep-llms-course-enroll-button:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_background_hover',
                'label' =>  esc_html__('Background Hover', 'deep'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} a.deep-llms-course-enroll-button:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'hr1',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->start_controls_tabs(
            'style_tabs'
        );

        $this->start_controls_tab(
            'style_normal_tab1',
            [
                'label' => __('Normal', 'plugin-name'),
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' =>  esc_html__('Box Shadow', 'deep'),
                'selector' => '{{WRAPPER}} a.deep-llms-course-enroll-button',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'label' => __('Button Border', 'deep'),
                'selector' => '{{WRAPPER}} a.deep-llms-course-enroll-button',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label'         => __('Button Border Radius', 'deep'),
                'type'             => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} a.deep-llms-course-enroll-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'btn_padding',
            [
                'label'     =>  esc_html__('Padding', 'deep'),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'devices'    => ['desktop', 'tablet', 'mobile'],
                'selectors'    => [
                    '{{WRAPPER}} a.deep-llms-course-enroll-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'btn_margin',
            [
                'label'     =>  esc_html__('Margin', 'deep'),
                'type'         => Controls_Manager::DIMENSIONS,
                'devices'    => ['desktop', 'tablet', 'mobile'],
                'size_units' => ['px', 'em', '%'],
                'selectors'    => [
                    '{{WRAPPER}} a.deep-llms-course-enroll-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_hover_tab2',
            [
                'label' => __('Hover', 'plugin-name'),
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow_hover',
                'label' =>  esc_html__('Box Shadow', 'deep'),
                'selector' => '{{WRAPPER}} a.deep-llms-course-enroll-button:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border_hover',
                'label' => __('Button Border', 'deep'),
                'selector' => '{{WRAPPER}} a.deep-llms-course-enroll-button:hover',
            ]
        );

        $this->add_control(
            'button_border_radius_hover',
            [
                'label'         => __('Button Border Radius', 'deep'),
                'type'             => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} a.deep-llms-course-enroll-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'btn_padding_hover',
            [
                'label'     =>  esc_html__('Padding', 'deep'),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'devices'    => ['desktop', 'tablet', 'mobile'],
                'selectors'    => [
                    '{{WRAPPER}} a.deep-llms-course-enroll-button:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'btn_margin_hover',
            [
                'label'     =>  esc_html__('Margin', 'deep'),
                'type'         => Controls_Manager::DIMENSIONS,
                'devices'    => ['desktop', 'tablet', 'mobile'],
                'size_units' => ['px', 'em', '%'],
                'selectors'    => [
                    '{{WRAPPER}} a.deep-llms-course-enroll-button:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

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

        $settings = $this->get_settings_for_display();
        $plan_id  = $settings['access_plan_id'];

        if ( $plan_id ) {
            $plan            = new \LLMS_Access_Plan($plan_id);
            $checkout_url    = $plan->get_checkout_url();
            $enroll_text     = $settings['course_enroll_button_text'] ? $settings['course_enroll_button_text'] : __('Enroll', 'deep');
            ?>
            <div class="deep-llms-course-enroll-button-wrapper ">
                <?php
                    echo '<a href="' . esc_url( $checkout_url ) . '" class="deep-llms-course-enroll-button">' . esc_html( $enroll_text ) . '</a>';
                ?>
            </div>
            <?php
        }
    }
}
