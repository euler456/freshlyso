<div <?php echo fdm_format_classes( $this->classes ); ?>>

	<h3 class='fdm-filtering-header'>
		<?php _e('Filtering', 'food-and-drink-menu'); ?>
	</h3>

	<?php if ( ! empty( $this->text_search ) ) : ?>
		<div class='fdm-filtering-section fdm-filtering-text-section'>
			<label class='fdm-filtering-label fdm-filtering-text-label'><?php _e('Search', 'food-and-drink-menu'); ?></label> 
			<input type='text' class='fdm-filtering-text-input' value='' placeholder='<?php _e('Search items...', 'food-and-drink-menu'); ?>' data-search='<?php echo implode(",", $this->text_search); ?>' />
		</div>
	<?php endif; ?>

	<?php if ( $this->enable_price_filtering ) : ?>
		<div class='fdm-filtering-section fdm-filtering-price-section'>
			<label class='fdm-filtering-label fdm-filtering-price-label'><?php _e('Price', 'food-and-drink-menu'); ?></label> 
			<?php if ( $this->price_filtering_type == 'textbox' ) : ?>
				<div class='fdm-filtering-price-input-container'>
					<input type='text' class='fdm-filtering-min-price-input' placeholder='0' />
					<span class='fdm-filtering-price-separator'> - </span> 
					<input type='text' class='fdm-filtering-max-price-input' placeholder='1000' />
				</div>
			<?php endif; ?>
			<?php if ( $this->price_filtering_type == 'slider' ) : ?>
				<div class='fdm-filtering-price-input-container fdm-filtering-price-slider-price-display'>
					<span class='fdm-filtering-min-price-display'>0</span>
					<span class='fdm-filtering-price-separator'> - </span> 
					<span class='fdm-filtering-max-price-display'>1000</span>
					<div id='fdm-filtering-price-slider'></div>
				</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<?php if ( $this->enable_sorting ) : ?>
		<div class='fdm-filtering-section fdm-filtering-sorting-section'>
			<label class='fdm-filtering-label fdm-filtering-sorting-label'><?php _e('Sorting', 'food-and-drink-menu'); ?></label> 
		
			<select class='fdm-filtering-sorting-input' >
				<option value=''></option>
				<?php if ( in_array('name', $this->sorting_types ) ) : ?>
					<option value='name_asc' ><?php _e('Name (A -> Z)', 'food-and-drink-menu'); ?></option>
					<option value='name_desc' ><?php _e('Name (Z -> A)', 'food-and-drink-menu'); ?></option>
				<?php endif; ?>
				<?php if ( in_array('price', $this->sorting_types ) ) : ?>
					<option value='price_asc' ><?php _e('Price (Ascending)', 'food-and-drink-menu'); ?></option>
					<option value='price_desc' ><?php _e('Price (Descending)', 'food-and-drink-menu'); ?></option>
				<?php endif; ?>
				<?php if ( in_array('date_added', $this->sorting_types ) ) : ?>
					<option value='date_asc' ><?php _e('Date Added (Ascending)', 'food-and-drink-menu'); ?></option>
					<option value='date_desc' ><?php _e('Date Added (Descending)', 'food-and-drink-menu'); ?></option>
				<?php endif; ?>
				<?php if ( in_array('name', $this->sorting_types ) ) : ?>
					<option value='section_asc' ><?php _e('Section (Ascending)', 'food-and-drink-menu'); ?></option>
					<option value='section_desc' ><?php _e('Section (Descending)', 'food-and-drink-menu'); ?></option>
				<?php endif; ?>
			</select>

		</div>
	<?php endif; ?>

</div>