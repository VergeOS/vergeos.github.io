<?php
/**
 * Deep Message.
 *
 * Receives messages from Deep API.
 *
 * @package Deep
 */

namespace Deep\Admin;

defined( 'ABSPATH' ) || exit;

/**
 * Class Messages.
 */
class Messages {
	/**
	 * Instance of this class.
	 *
	 * @since   4.5.8
	 * @access  public
	 * @var     Messages
	 */
	public static $instance;

    /**
     * Post body
     *
     * @var array
     */
    private static $body;

    /**
     * Status code
     *
     * @var string
     */
    private static $status;

    /**
     * Post content
     *
     * @var string
     */
    private static $content;

    /**
     * Featured image ID
     *
     * @var string
     */
    private static $img_id;

    /**
     * Media API URL
     *
     * @var string
     */
    private static $img_api;

    /**
     * Image URL
     *
     * @var string
     */
    private static $img_url;

    /**
     * Date
     *
     * @var string
     */
    private static $date;

    /**
     * Modified Date
     *
     * @var string
     */
    private static $modified_date;

    /**
     * Current Time
     *
     * @var string
     */
    private static $last_seen;

    /**
	 * Option name.
	 *
	 * @var string
	 */
	private static $option_name = 'deep_notifications';

    /**
	 * Options.
	 *
	 * @var string
	 */
	private static $options = array();

	/**
	 * Provides access to a single instance of a module using the singleton pattern.
	 *
	 * @since   4.5.8
	 * @return  object
	 */
	public static function get_instance() {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 *
	 * @since 4.5.8
	 * @access private
	 */
	private function __construct() {
        $this->get_post_content();
        $this->hooks();
	}

    /**
	 * Hooks.
	 *
	 * @since 4.5.8
	 * @access private
	 */
    private function hooks() {
        add_action( 'deep/dashboard/message', [$this, 'message'] );
        add_action('wp_ajax_close_notification', [$this, 'close_notification']);
    }

    /**
	 * Definition.
	 *
	 * @since 4.5.8
	 * @access private
	 */
	private function definition() {
        if ( ! empty( self::$body['data']['status'] ) && isset( self::$body['data']['status'] ) ) {
            self::$status = self::$body['data']['status'];
        }

        if ( ! empty( self::$body ) && self::$status != '401' ) {
            self::$content          = self::$body['content']['rendered'];
            self::$img_id           = self::$body['featured_media'];
            self::$modified_date    = strtotime(self::$body['modified']);
            self::$last_seen        = strtotime(current_time('mysql'));
            self::$img_api          = 'https://webnus.biz/api/wp-json/wp/v2/media/' . self::$img_id;
            // get image url
            $response = $this->request( self::$img_api );
            $img_url = isset( $response['source_url'] ) ? $response['source_url'] : '';

            if ( self::get_options()['modified_date'] && ( self::get_options()['modified_date'] != self::$modified_date ) ){
                update_option( 'deep_close_notification', '' );
            }
            self::update_options( self::$content, $img_url , self::$last_seen , self::$modified_date );
        }
	}

    /**
	 * Sends request to the API.
	 *
	 * @since 4.5.8
	 * @access public
	 */
    public function request( string $url ) {
        $args = [
            'timeout' => 30,
            'user-agent'  => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36'
        ];

        $response = wp_remote_get( esc_url_raw( $url ), $args );

        if ( is_array( $response ) && ! is_wp_error( $response ) ) {
            $body = json_decode( wp_remote_retrieve_body( $response ), true );
            return $body;
        }
	}

    /**
	 * Get content of the post.
	 *
	 * @since 4.5.8
	 * @access private
	 */
    private function get_post_content() {
        if ( self::check_date() ) {
            $url = 'https://webnus.biz/api/wp-json/wp/v2/posts/4918';

            $body = $this->request( $url );

            self::$body = $body;
            $this->definition();
        }
        self::$options  = self::get_options();
    }

    /**
	 * Display the message in admin.
	 *
	 * @since 4.5.8
	 * @access public
	 */
    public function message() {
        if ( self::check_close_option() ) {
        ?>
        <div class="deep-message">
            <div class="w-box-head"><?php echo esc_html__('Announcement', 'deep'); ?><i class="sl-close"></i></div>
            <div class="deep-message-content">
                <div class="msg-img">
                    <img src="<?php echo esc_url( self::$options['img_url'] ); ?>">
                </div>
                <div class="msg-content">
                    <?php echo wp_kses_post( self::$options['content'] ); ?>
                </div>
            </div>
        </div>
        <script>
            jQuery(document).ready(function(){
                jQuery('.deep-message .w-box-head i').on('click', function(e){
                    e.preventDefault();
                    jQuery.ajax({
                        url: ajaxObject.ajaxUrl,
                        type: 'POST',
                        data: {
                            action: 'close_notification',
                            nonce: ajaxObject.colornonce,
                        },
                        success: function (response) {
                            jQuery(".deep-message").fadeOut(100, function () { jQuery(this).remove(); });
                        },
                    });
                });
            });
        </script>
        <?php
        }
    }

    /**
	 * Get the option.
	 *
	 * @since 4.5.8
	 * @access private
	 */
    private static function get_options() {
        $options = get_option( self::$option_name );

        if (!$options){
            self::update_options( '', '' , '' , '' );
            $options = get_option( self::$option_name );
        }

        return $options;
    }

    /**
	 * Check current date.
	 *
	 * @since 5.0.0
	 * @access private
	 */
    private static function check_date() {
        $current_date   = strtotime(current_time('mysql'));
        $last_seen_date = self::get_options()['last_seen_date'];

        if (!self::get_options()['last_seen_date']) {
            return true;
        }

        if ( $last_seen_date && ( self::check_diff( $current_date , $last_seen_date , 'hours' ) >= 0 ))  return true;
    }

    /**
	 * Check close button
	 *
	 * @since 4.5.8
	 * @access private
	 */
    private static function check_close_option() {
        $close_option = get_option( 'deep_close_notification' );
        if( $close_option != 1 ) return true;
    }

    /**
	 * Check different between two timestamp.
	 *
	 * @since 5.0.0
	 * @access private
	 */
    private static function check_diff($date1, $date2, $type = 'seconds') {
        $diff = abs($date1 - $date2);
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24)  / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));
        $minutes = floor(($diff - $years * 365*60*60*24  - $months*30*60*60*24 - $days*60*60*24  - $hours*60*60)/ 60);
        $seconds = floor(($diff - $years * 365*60*60*24  - $months*30*60*60*24 - $days*60*60*24  - $hours*60*60 - $minutes*60));

        switch ($type) {
            case 'years':
                $output = $years;
                break;
            case 'months':
                $output = $months;
                break;
            case 'days':
                $output = $days;
                break;
            case 'hours':
                $output = $hours;
                break;
            case 'minutes':
                $output = $minutes;
                break;
            case 'seconds':
                $output = $seconds;
                break;
            default:
                $output = $seconds;
                break;
        }

        return $output;
    }

    /**
	 * Close Message
	 *
	 * @since 5.0.0
	 * @access private
	 */
    public function close_notification()
    {
        if(!current_user_can('administrator')) return false;
        update_option('deep_close_notification', 1);
        wp_die();
    }

    /**
	 * Update post data.
	 *
	 * @since 4.5.8
	 * @access private
	 */
    private static function update_options( string $content, string $img_url, string $date, string $modified_date ) {
        update_option( self::$option_name, [
            'content'           => $content,
            'img_url'           => $img_url,
            'last_seen_date'    => $date,
            'modified_date'     => $modified_date
        ]);
    }
}

Messages::get_instance();
