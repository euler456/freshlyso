<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'fdmCartManager' ) ) {
/**
 * Class to handle the plugin's ordering cart
 *
 * @since 2.1.0
 */
class fdmCartManager {

	private $cart_items = array();

	public function __construct() {
		
		$this->load_cart_from_cookie();
	}

	public function load_cart_from_cookie() {
		
		$fdm_cart_items = isset( $_COOKIE['fdm_cart'] ) ? unserialize( $_COOKIE['fdm_cart'] ) : array();

		if ( ! is_array( $fdm_cart_items ) ) { return; }

		foreach ( $fdm_cart_items as $fdm_cart_item ) {
			$this->cart_items[ $fdm_cart_item->item_identifier ] = $fdm_cart_item;
		}
	}

	public function get_cart_items() {
	
		return $this->cart_items;
	}

	public function add_item( $item = array() ) {
		
		if ( ! isset( $item['id'] ) or ! is_numeric( $item['id'] ) ) { return false; }
		if ( ! isset( $item['item_identifier'] ) ) { return false; }

		if ( empty( $item['selected_price'] ) ) {

			$prices 		= (array) get_post_meta( $item['id'], 'fdm_item_price' );
			$price_discount = get_post_meta( $item['id'], 'fdm_item_price_discount', true );

			$item['selected_price'] = $price_discount ? $price_discount : reset( $prices );
		}

		$this->cart_items[ $item['item_identifier'] ] = new fdmCartItem( $item );

		$this->update_cookie();
	}

	public function update_item( $item = array() ) {
		
		if ( ! isset( $item['item_identifier'] ) ) { return false; }

		$this->cart_items[ $item_identifier ]->update( $item );

		$this->update_cookie();
	}

	public function update_item_quanity( $item_id, $qty ) {
		
		$qty = intval( $qty );
		$qty = ( $qty > 0 && $qty < 10001 ) ? $qty : 1;

		foreach ( $this->cart_items as $key => $value ) {

			if ( $item_id == $value->id ) {
				
				$this->cart_items[$key]->quantity = $qty;
				$this->update_cookie();
				
				return;
			}
		}
	}

	public function delete_item( $item_identifier ) {
		
		unset( $this->cart_items[ $item_identifier ] );

		$this->update_cookie();
	}

	public function update_cookie() {
		
		setcookie( 'fdm_cart', serialize( $this->cart_items ), time() + 4*3600, '/' );
	}

	public function clear_cart() {
		
		if ( isset( $_COOKIE['fdm_cart'] ) ) { unset( $_COOKIE['fdm_cart'] ); }

		setcookie( 'fdm_cart', serialize( $this->cart_items ), time() - 1, '/' );
	}
}
} // endif
