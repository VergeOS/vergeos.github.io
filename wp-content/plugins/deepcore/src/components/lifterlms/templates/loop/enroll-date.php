<?php
/**
 * LifterLMS Loop Enrollment Date
 *
 * @package LifterLMS/Templates
 *
 * @since   3.14.0
 * @version 3.14.0
 */

defined( 'ABSPATH' ) || exit;

$student = llms_get_student();
if ( ! $student ) {
	return;
}

?>
<div class="llms-meta llms-enroll-date">
	<p>
        <?php esc_html_e( 'Enrolled:', 'deep' ); ?>
        <span><?php echo wp_kses_post( $student->get_enrollment_date( get_the_ID() ) ); ?></span>
	</p>
</div>
