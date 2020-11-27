<div class="fdm-order-item-options">
	<ul>
		<?php foreach ( $this->selected_options as $option ) { ?>
			<li><?php echo $this->ordering_options[$option]['name'] . ( $this->ordering_options[$option]['cost'] ? ' (' . fdm_format_price( $this->ordering_options[$option]['cost'] ) . ')' : '' ); ?></li>
		<?php } ?>
	</ul>
	<?php if ( $this->note ) { ?>
		<p>"<?php echo $this->note ?>"</p>
	<?php } ?> 
</div>