<div class='fdm-ordering-popup-background fdm-hidden'></div>
<div <?php echo fdm_format_classes( $this->classes ); ?>>
	<div class='fdm-ordering-popup-close'>x</div>
	<div class='fdm-ordering-popup-inside'>
		<h3 id='fdm-ordering-popup-header'>
			<?php _e( 'Order Item Details', 'food-and-drink-menu' ); ?>
		</h3>
		<div id='fdm-ordering-popup-options'></div>
		<div id='fdm-ordering-popup-note'>
			<h5><?php _e( 'Item Note', 'food-and-drink-menu' ); ?></h5>
			<textarea name='fdm-ordering-popup-note'></textarea>
		</div>
		<div id='fdm-ordering-popup-submit'>
			<button><?php _e( 'Confirm Details', 'food-and-drink-menu'); ?></button>
		</div>
	</div>
</div>