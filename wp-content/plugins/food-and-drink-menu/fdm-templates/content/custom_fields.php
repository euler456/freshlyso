<div class="fdm-item-custom-fields">
	<h4><?php _e('Custom Fields', 'food-and-drink-menu'); ?></h4>
	<?php foreach ($this->custom_fields as $field) { ?>
		<?php if ( $fdm_controller->settings->get_setting( 'hide-blank-custom-fields' ) and ! $field->value ) { continue; } ?>
		<div class='fdm-item-custom-fields-each'>
			<div class='fdm-item-custom-field-label'><?php echo $field->name; ?></div>
			<div class='fdm-menu-item-custom-field-value'>
				<?php 
					if ($field->type == 'select') :
						$field_values = explode(",", $field->values);
						foreach ($field_values as $value) {
							if ( sanitize_title( $value ) == $field->value ) {echo $value;}
						}
					elseif ($field->type == 'checkbox') :
						$field_values = explode(",", $field->values);
						$print_value = '';
						foreach ($field_values as $value) {
							if ( is_array( $field->value ) and in_array( sanitize_title( $value ), $field->value ) ) {$print_value .= $value . ", ";}
						}
						$print_value = trim($print_value, ", "); 
						echo $print_value;
					else :
						echo $field->value;
					endif; 
				?>
			</div>
		</div>	
	<?php } ?>
</div>