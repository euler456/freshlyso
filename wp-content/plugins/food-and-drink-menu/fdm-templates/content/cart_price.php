<div class="fdm-cart-item-price-wrapper">
	<?php if ( $this->order_price ) : ?>
		<?php $cart_price = fdm_calculate_cart_price ( $this ); ?>
		<div class="fdm-cart-item-price" data-price="<?php echo $cart_price; ?>"><?php echo fdm_format_price( $cart_price ); ?></div>
	<?php endif; ?>
</div>
