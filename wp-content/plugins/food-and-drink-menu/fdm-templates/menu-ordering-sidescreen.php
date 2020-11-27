<?php 
	global $fdm_controller;

?>
<div id='fdm-ordering-sidescreen-tab' class='fdm-hidden'><span class='dashicons dashicons-cart'></span><span id='fdm-ordering-sidescreen-tab-count'></span></div>
<div <?php echo fdm_format_classes( $this->classes ); ?>>
	
	<h3 id='fdm-ordering-sidescreen-header'>
		<div id='fdm-ordering-sidescreen-close'><span class='dashicons dashicons-arrow-right-alt'></span></div>
		<?php _e( 'Order Summary', 'food-and-drink-menu' ); ?>
	</h3>

	<div id='fdm-ordering-sidescreen-items'>
		<?php 
			$cart_items = $fdm_controller->cart->get_cart_items();
			foreach ( $cart_items as $cart_item ) {
				$item = new fdmViewItem( (array) $cart_item );
				$item->load_item();

				echo $item->cart_render();
			}
		?>
	</div>

	<div id='fdm-ordering-sidescreen-quantity'>
		<div id='fdm-ordering-sidescreen-quantity-items'>
			<span id='fdm-ordering-sidescreen-quantity-number'>0</span> <span id='fdm-ordering-sidescreen-quantity-text'><?php _e( 'Item(s) in Your Cart', 'food-and-drink-menu' ); ?></span>
		</div>
		<div class='fdm-clear-cart-button'><?php _e( 'Clear', 'food-and-drink-menu' ); ?></div>
	</div>
	<div id='fdm-ordering-sidescreen-total'>
		<div id='fdm-ordering-sidescreen-total-label'><?php _e( 'Total', 'food-and-drink-menu' ); ?></div>
		<div id='fdm-ordering-sidescreen-total-value-container'>
			<?php
				echo $fdm_controller->settings->get_setting( 'fdm-currency-symbol-location' ) == 'before' ? $fdm_controller->settings->get_setting( 'fdm-currency-symbol' ) : '';
				echo '<span id="fdm-ordering-sidescreen-total-value">0</span>';
				echo $fdm_controller->settings->get_setting( 'fdm-currency-symbol-location' ) == 'after' ? $fdm_controller->settings->get_setting( 'fdm-currency-symbol' ) : '' ;
			?>
		</div>
	</div>
	
	<?php $required_fields = is_array( $fdm_controller->settings->get_setting( 'fdm-ordering-required-fields' ) ) ? $fdm_controller->settings->get_setting( 'fdm-ordering-required-fields' ) : array(); ?>
	<div id='fdm-ordering-contact-details'>
		<h3 id='fdm-ordering-sidescreen-contact-header'><?php _e( 'Check Out', 'food-and-drink-menu' ); ?></h3>
		<div class='fdm-ordering-contact-item'>
			<div class='fdm-ordering-contact-label <?php echo in_array( 'name', $required_fields )  ? 'fdm-ordering-required' : ''; ?>'><?php _e( 'Name:', 'food-and-drink-menu' ); ?></div>
			<div class='fdm-ordering-contact-field'><input type='text' name='fdm_ordering_name' <?php echo in_array( 'name', $required_fields )  ? 'required' : ''; ?> /></div>
		</div>
		<div class='fdm-ordering-contact-item'>
			<div class='fdm-ordering-contact-label <?php echo in_array( 'email', $required_fields )  ? 'fdm-ordering-required' : ''; ?>'><?php _e( 'Email:', 'food-and-drink-menu' ); ?></div>
			<div class='fdm-ordering-contact-field'><input type='email' name='fdm_ordering_email' <?php echo in_array( 'email', $required_fields )  ? 'required' : ''; ?> /></div>
		</div>
		<div class='fdm-ordering-contact-item'>
			<div class='fdm-ordering-contact-label <?php echo in_array( 'phone', $required_fields )  ? 'fdm-ordering-required' : ''; ?>'><?php _e( 'Phone:', 'food-and-drink-menu' ); ?></div>
			<div class='fdm-ordering-contact-field'><input type='tel' name='fdm_ordering_phone' <?php echo in_array( 'phone', $required_fields )  ? 'required' : ''; ?> /></div>
		</div>
		<div class='fdm-ordering-contact-item'>
			<div class='fdm-ordering-contact-label'><?php _e( 'Order Note:', 'food-and-drink-menu' ); ?></div>
			<div class='fdm-ordering-contact-field'><textarea name='fdm_ordering_note' ></textarea></div>
		</div>
	</div>

	<?php if ( $fdm_controller->settings->get_setting( 'enable-payment' ) and $fdm_controller->settings->get_setting( 'payment-optional' ) ) { ?>
		<div id='fdm-order-payment-toggle'>
			<div class='fdm-order-payment-toggle-option'>
				<input type='radio' name='fdm-payment-type-toggle' class='fdm-payment-type-toggle' value='pay-in-store' checked /><?php _e( 'Pay in Store', 'food-and-drink-menu' ); ?>
			</div>
			<div class='fdm-order-payment-toggle-option'>
				<input type='radio' name='fdm-payment-type-toggle' class='fdm-payment-type-toggle' value='pay-online' /><?php _e( 'Pay Online', 'food-and-drink-menu' ); ?>
			</div>
		</div>
	<?php } ?>

	<?php if ( ! $fdm_controller->settings->get_setting( 'enable-payment' ) or $fdm_controller->settings->get_setting( 'payment-optional' ) ) { ?>
		<div id='fdm-order-submit'>
			<button id='fdm-order-submit-button' data-permalink='<?php echo get_permalink(); ?>'><?php _e( 'Submit Order', 'food-and-drink-menu' ); ?></button>
		</div>
	<?php } ?>

	<?php if ( $fdm_controller->settings->get_setting( 'enable-payment' ) ) { ?>
		<div id='fdm-order-payment-form-div' class='<?php echo $fdm_controller->settings->get_setting( 'payment-optional' ) ? 'fdm-hidden' : ''; ?>'>
			<?php  if ( $fdm_controller->settings->get_setting( 'ordering-payment-gateway' ) == 'paypal' ) { ?>
				<?php $form_action = $fdm_controller->settings->get_setting( 'ordering-payment-mode' ) == 'test' ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr'; ?>
				<form action='<?php echo $form_action; ?>' method='post' class='standard-form' id='paypal-payment-form'>
					<input type='hidden' name='item_name_1' value='<?php echo substr(get_bloginfo('name'), 0, 100); ?> Order Payment' />
					<input type='hidden' name='custom' value='' />
					<input type='hidden' name='quantity_1' value='1' />
					<input type='hidden' name='amount_1' id='fdm-ordering-sidescreen-paypal-total' value='0' />
					<input type='hidden' name='cmd' value='_cart' />
					<input type='hidden' name='upload' value='1' />
					<input type='hidden' name='business' value='<?php echo $fdm_controller->settings->get_setting( 'paypal-email' ); ?>' />
					<input type='hidden' name='currency_code' value='<?php echo $fdm_controller->settings->get_setting( 'ordering-currency' ); ?>' />
					<input type='hidden' name='return' value='<?php echo get_permalink(); ?>' />
					<input type='hidden' name='notify_url' value='<?php echo get_site_url(); ?>' />			
					<input type='submit' id='paypal-submit' class='submit-button' data-permalink='<?php echo get_permalink(); ?>' value='Pay via PayPal' />
				</form>
			<?php } else { ?>
				<div class='payment-errors'></div>

				<form action='#' method='POST' id='stripe-payment-form'>
					<div class='form-row'>
						<label><?php _e('Card Number', 'food-and-drink-menu'); ?></label>
						<input type='text' size='20' autocomplete='off' data-stripe='card_number'/>
					</div>
					<div class='form-row'>
						<label><?php _e('CVC', 'food-and-drink-menu'); ?></label>
						<input type='text' size='4' autocomplete='off' data-stripe='card_cvc'/>
					</div>
					<div class='form-row'>
						<label><?php _e('Expiration (MM/YYYY)', 'food-and-drink-menu'); ?></label>
						<input type='text' size='2' data-stripe='exp_month'/>
						<span> / </span>
						<input type='text' size='4' data-stripe='exp_year'/>
					</div>
					<input type='hidden' name='action' value='fdm_stripe_booking_payment'/>
					<input type='hidden' name='currency' value='<?php echo $fdm_controller->settings->get_setting( 'ordering-currency' ); ?>' data-stripe='currency' />
					<input type='hidden' name='payment_amount' id='fdm-ordering-sidescreen-stripe-total' value='0' />
					<button type='submit' id='stripe-submit' data-permalink='<?php echo get_permalink(); ?>' ><?php _e( 'Pay Now', 'food-and-drink-menu'); ?></button>
				</form>
			<?php } ?>
		</div>
	<?php } ?>

</div>