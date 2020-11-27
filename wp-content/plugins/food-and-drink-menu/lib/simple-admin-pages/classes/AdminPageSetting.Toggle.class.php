<?php

/**
 * Register, display and save an option with a single checkbox.
 *
 * This setting accepts the following arguments in its constructor function.
 *
 * $args = array(
 *		'id'			=> 'setting_id', 	// Unique id
 *		'title'			=> 'My Setting', 	// Title or label for the setting
 *		'description'	=> 'Description', 	// Help text description
 *		'label'			=> 'Label', 		// Checkbox label text
 *		);
 * );
 *
 * @since 1.0
 * @package Simple Admin Pages
 */

class sapAdminPageSettingToggle_2_0_a_7 extends sapAdminPageSetting_2_0_a_7 {

	public $sanitize_callback = 'sanitize_text_field';

	/**
	 * Display this setting
	 * @since 1.0
	 */
	public function display_setting() {
	
		$input_name = $this->get_input_name();

		?>

		<fieldset>
			<div class="fdm-admin-hide-radios">
				<input type="checkbox" name="<?php echo $input_name; ?>" id="<?php echo $input_name; ?>" value="1"<?php if( $this->value == '1' ) : ?> checked="checked"<?php endif; ?> <?php echo ( $this->disabled ? 'disabled' : ''); ?>>
				<label for="<?php echo $input_name; ?>"><?php echo $this->label; ?></label>
			</div>
			<label class="fdm-admin-switch">
				<input type="checkbox" class="fdm-admin-option-toggle" data-inputname="<?php echo $input_name; ?>" <?php if($this->value == '1') {echo "checked='checked'";} ?> <?php echo ( $this->disabled ? 'disabled' : ''); ?>>
				<span class="fdm-admin-switch-slider round"></span>
			</label>
			<?php $this->display_disabled(); ?>		
		</fieldset>

		<?php

		$this->display_description();

	}

}
