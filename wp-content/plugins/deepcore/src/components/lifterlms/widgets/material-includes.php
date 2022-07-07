<?php
namespace LifterLMS\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for course material includes.
 *
 * @since 2.1.0
 */
class MaterialIncludes extends Widget_Base {
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
		return 'deep-llms-material-includes';
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
		return __( 'Material Includes', 'deep' );
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
		return 'deep-widget deep-eicon-material-includes';
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
		return [ 'Deep_LifterLMS' ];
	}

	/**
	 * Load depend styles.
	 *
	 * @since 2.1.0
	 *
	 * @access public
	 */
	public function get_style_depends() {
		return array( 'deep-llms-course-material' );
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
			'section_content',
			array(
				'label' => __( 'Content', 'deep' ),
			)
		);

		$this->add_control(
			'description',
			[
				'label' 	=> __( 'In order to add Material Includes, open your course in edit mode, and at the bottom of the page, from \'Deep Course Options\' add the new items.', 'deep' ),
				'type'	 	=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

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

        $material_includes = rwmb_meta( 'course_material_includes' );

        if ( isset( $material_includes ) && ! empty( $material_includes[0]['title'] ) ) {
            echo '<ul class="deep-course-material">';
                foreach ( $material_includes as $value ) {
                    echo '<li>';
                    esc_html_e( $value['title'] );
                    echo '</li>';
                }
            echo '</ul>';
        }
	}
}
