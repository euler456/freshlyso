<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'fdmOrderNotification' ) ) {
/**
 * Class for any order notification that needs to go out from the plugin
 *
 * @since 2.1.0
 */
class fdmOrderNotification {

	/**
	 * The order this notification is being sent for
	 * @since 2.1.0
	 */
	public $order;

	/**
	 * Recipient email
	 * @since 2.1.0
	 */
	public $to_email;

	/**
	 * From email
	 * @since 2.1.0
	 */
	public $from_email;

	/**
	 * From name
	 * @since 2.1.0
	 */
	public $from_name;

	/**
	 * Email subject
	 * @since 2.1.0
	 */
	public $subject;

	/**
	 * Email message body
	 * @since 2.1.0
	 */
	public $message;

	/**
	 * Email headers
	 * @since 2.1.0
	 */
	public $headers;

	public function __construct( $order, $args ) {
		
		$this->order = $order;

		// Parse the values passed
		$this->parse_args( $args );
	}

	/**
	 * Prepare and validate notification data
	 *
	 * @return boolean if the data is valid and ready for transport
	 * @since 2.1.0
	 */
	public function prepare_notification() {

		$this->set_to_email();
		$this->set_from_email();
		$this->set_subject();
		$this->set_headers();
		$this->set_message();

		// Return false if we're missing any of the required information
		if ( 	empty( $this->to_email) ||
				empty( $this->from_email) ||
				empty( $this->from_name) ||
				empty( $this->subject) ||
				empty( $this->headers) ||
				empty( $this->message) ) {
			return false;
		}

		return true;
	}

	public function set_to_email() {
		global $fdm_controller;

		if ( $this->target == 'user' ) {
			$to_email = empty( $this->order->email ) ? null : $this->order->email;

		} else {
			$to_email = $fdm_controller->settings->get_setting( 'fdm-ordering-notification-email' );
		}

		$this->to_email = apply_filters( 'fdm_notification_email_to_email', $to_email, $this );
	}

	public function set_from_email() {
		global $fdm_controller;

		if ( $this->target == 'user' ) {
			$from_email = $fdm_controller->settings->get_setting( 'fdm-ordering-reply-to-address' );
			$from_name = $fdm_controller->settings->get_setting( 'fdm-ordering-reply-to-name' );
		} else {
			$from_email = $this->order->email;
			$from_name = $this->order->name;
		}

		$this->from_email = apply_filters( 'fdm_notification_email_from_email', $from_email, $this );
		$this->from_name = apply_filters( 'fdm_notification_email_from_name', $from_name, $this );

	}

	public function set_subject() {
		global $fdm_controller;

		if ( $this->target == 'user' ) {
			$subject = $fdm_controller->settings->get_setting( 'customer-email-subject' );
		}
		else {
			$subject = $fdm_controller->settings->get_setting( 'admin-email-subject' );
		}

		$this->subject = apply_filters( 'fdm_notification_email_subject', $subject, $this );
	}

	public function set_headers( $headers = null ) {

		global $fdm_controller;

		$from_email = apply_filters( 'fdm_notification_email_header_from_email', $fdm_controller->settings->get_setting( 'fdm-ordering-reply-to-address' ) );

		$headers = "From: " . stripslashes_deep( html_entity_decode( $fdm_controller->settings->get_setting( 'fdm-ordering-reply-to-name' ), ENT_COMPAT, 'UTF-8' ) ) . " <" . $from_email . ">\r\n";
		$headers .= "Reply-To: =?utf-8?Q?" . quoted_printable_encode( $this->from_name ) . "?= <" . $this->from_email . ">\r\n";
		$headers .= "Content-Type: text/html; charset=utf-8\r\n";

		$this->headers = apply_filters( 'fdm_notification_email_headers', $headers, $this );
	}

	public function set_message() {
		global $fdm_controller;

		if ( $this->target == 'user' ) {
			$this->message = wpautop( $this->process_template( $fdm_controller->settings->get_setting( 'customer-email-template' ) ) );
		}
		else {
			$this->message = wpautop( $this->process_template( $fdm_controller->settings->get_setting( 'admin-email-template' ) ) );
		}
	}

	/**
	 * Send notification
	 * @since 0.0.1
	 */
	public function send_notification() {

		return wp_mail( $this->to_email, $this->subject, $this->message, $this->headers, apply_filters( 'fdm_notification_email_attachments', array(), $this ) );
	}

	/**
	 * Parse the arguments passed in the construction and assign them to
	 * internal variables.
	 * @since 2.1
	 */
	public function parse_args( $args ) {

		foreach ( $args as $key => $val ) {
			switch ( $key ) {

				case 'id' :
					$this->{$key} = esc_attr( $val );

				default :
					$this->{$key} = $val;

			}
		}
	}

	/**
	 * Process a template and insert booking details
	 * @since 2.1.0
	 */
	public function process_template( $message ) {
		global $fdm_controller;

		$accept_order_url = add_query_arg(
			array(
				'fdm_action' 	=> 'update_status', 
				'status' 		=> 'fdm_order_accepted',
				'order_id' 		=> $this->order->id
			),
			$this->order->permalink
		);

		$order_items_HTML = '';
		$counter = 1;
		foreach ( $this->order->get_order_items() as $order_item ) {
			$menu_item = get_post( $order_item->id );

			$ordering_options = get_post_meta( $menu_item->ID, '_fdm_ordering_options', true );
			if ( ! is_array( $ordering_options ) ) { $ordering_options = array(); }

			$selected_options = is_array( $order_item->selected_options ) ? $order_item->selected_options : array();

			$order_items_HTML .= $counter . '. ' . $menu_item->post_title . ' (' . $menu_item->ID . ') <br/>';
			if ( ! empty( $order_item->selected_price ) ) { $order_items_HTML .= 'Selected Price: ' . $order_item->selected_price . ' <br />'; }
			foreach ( $selected_options as $selected_option ) { $order_items_HTML .= '    - ' . $ordering_options[ $selected_option ]['name'] . "<br/>"; }
			if ( isset( $order_item->note ) and $order_item->note != '' ) { $order_items_HTML .= __( 'Note: ', 'food-and-drink-menu' ) . $order_item->note; }
			$order_items_HTML .= '<br/>';
			$counter++;
		}


		$template_tags = array(
			'{order_number}'	=> $this->order->ID,
			'{email}'			=> $this->order->email,
			'{name}'			=> $this->order->name,
			'{note}'			=> $this->order->note,
			'{phone}'			=> $this->order->phone,
			'{payment_amount}'	=> $this->order->payment_amount,
			'{order_items}'		=> $order_items_HTML,
			'{accept_link}'		=> '<a href="' . esc_attr( $accept_order_url ) . '">' . __( 'Accept Order', 'food-and-drink-menu' ) . '</a>',
			'{site_name}'		=> get_bloginfo( 'name' ),
			'{site_link}'		=> '<a href="' . home_url( '/' ) . '">' . get_bloginfo( 'name' ) . '</a>',
			'{current_time}'	=> date_i18n( get_option( 'date_format' ), current_time( 'timestamp' ) ) . ' ' . date_i18n( get_option( 'time_format' ), current_time( 'timestamp' ) ),
		);

		$template_tags = apply_filters( 'fdm_notification_template_tags', $template_tags, $this );

		return str_replace( array_keys( $template_tags ), array_values( $template_tags ), $message );
	}

}
}

?>