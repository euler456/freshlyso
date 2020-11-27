<?php

/**
 * Register, display and save a section on a custom admin menu
 *
 * @since 1.0
 * @package Simple Admin Pages
 */

class sapAdminPageSection_2_0_a_7 {

	// Page defaults
	public $id; // unique id for this section
	public $title; // optional title to display above this section
	public $description; // optional description of the section
	public $settings = array(); // Array of settings to display in this option set
	public $disabled = false; // whether a setting should be disabled

	// Array to store errors
	public $errors = array();

	/**
	 * Initialize the section
	 * @since 1.0
	 */
	public function __construct( $args ) {

		// Parse the values passed
		$this->parse_args( $args );

		// Set an error if there is no id for this section
		if ( !isset( $this->id ) ) {
			$this->set_error(
				array(
					'type'		=> 'missing_data',
					'data'		=> 'id'
				)
			);
		}

	}

	/**
	 * Parse the arguments passed in the construction and assign them to
	 * internal variables.
	 * @since 1.0
	 */
	private function parse_args( $args ) {
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
	 * Add a setting to this section
	 * @since 1.0
	 */
	public function add_setting( $setting ) {
		if ( !$setting ) {
			return;
		}

		if ( $this->disabled ) {
			$setting->disabled = true;
		}
		
		$this->settings[ $setting->id ] = $setting;
	}

	/**
	 * Display the description for this section
	 * @since 1.0
	 */
	public function display_section() {

		if ( !count( $this->settings ) ) {
			return;
		}

		if ( !empty( $this->description ) ) :
		?>

			<p class="description"><?php echo $this->description; ?></p>

		<?php
		endif;

		if ( $this->disabled and isset($this->disabled_image) ) {

		?>

			<?php echo ( isset($this->purchase_link ) ? "<div class='fdm-premium-options-table-overlay'>" : '' ); ?>
				<div class="section-disabled">
					<img src="<?php echo get_home_url(); ?>/wp-content/plugins/food-and-drink-menu/assets/img/options-asset-lock.png" alt="Upgrade to Five-Star Restaurant Menu Premium">
					<p>Access this section by by upgrading to premium</p>
					<a href="https://www.fivestarplugins.com/plugins/five-star-restaurant-menu/" class="fdm-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
				</div>
			<?php echo ( isset($this->purchase_link ) ? "</div>" : '' ); ?>

		<?php

		}
	}

	/**
	 * Add the settings section to the page in WordPress
	 * @since 1.0
	 */
	public function add_settings_section() {
		add_settings_section( $this->id, $this->title, array( $this, 'display_section' ), $this->get_page_slug() );
	}

	/**
	 * Determine the page slug to use when calling add_settings_section.
	 *
	 * Tabs should use their own ID and settings that are attached to tabs
	 * should use that tab's ID.
	 * @since 2.0
	 */
	public function get_page_slug() {
		if ( isset( $this->is_tab ) && $this->is_tab === true ) {
			return $this->id;
		} elseif ( isset( $this->tab ) ) {
			return $this->tab;
		} else {
			return $this->page;
		}
	}

	/**
	 * Set an error
	 * @since 1.0
	 */
	public function set_error( $error ) {
		$this->errors[] = array_merge(
			$error,
			array(
				'class'		=> get_class( $this ),
				'id'		=> $this->id,
				'backtrace'	=> debug_backtrace()
			)
		);
	}

}
