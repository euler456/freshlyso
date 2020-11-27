<div class="fdm-item-price-wrapper" data-min_price='<?php echo $this->min_price; ?>' data-max_price='<?php echo $this->max_price; ?>'>
	<?php foreach( $this->prices as $price ) : ?>
		<div class="fdm-item-price"><?php echo $price; ?></div>
	<?php endforeach; ?>
</div>
