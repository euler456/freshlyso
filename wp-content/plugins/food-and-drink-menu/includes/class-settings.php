<?php

if ( !defined( 'ABSPATH' ) )
	exit;

/**
 * Class to register all settings in the settings panel
 */
class fdmSettings {

	/**
	 * Default values for settings
	 * @since 2.0.0
	 */
	public $defaults = array();

	/**
	 * Stores the legacy premium settings
	 * @since 2.0.0
	 */
	public $premium_settings = array();

	/**
	 * Stored values for settings
	 * @since 2.0.0
	 */
	public $settings = array();

	/**
	 * Currencies accepted for deposits
	 */
	public $currency_options = array(
		'AUD' => 'Australian Dollar',
		'BRL' => 'Brazilian Real',
		'CAD' => 'Canadian Dollar',
		'CZK' => 'Czech Koruna',
		'DKK' => 'Danish Krone',
		'EUR' => 'Euro',
		'HKD' => 'Hong Kong Dollar',
		'HUF' => 'Hungarian Forint',
		'ILS' => 'Israeli New Sheqel',
		'JPY' => 'Japanese Yen',
		'MYR' => 'Malaysian Ringgit',
		'MXN' => 'Mexican Peso',
		'NOK' => 'Norwegian Krone',
		'NZD' => 'New Zealand Dollar',
		'PHP' => 'Philippine Peso',
		'PLN' => 'Polish Zloty',
		'GBP' => 'Pound Sterling',
		'RUB' => 'Russian Ruble',
		'SGD' => 'Singapore Dollar',
		'SEK' => 'Swedish Krona',
		'CHF' => 'Swiss Franc',
		'TWD' => 'Taiwan New Dollar',
		'THB' => 'Thai Baht',
		'TRY' => 'Turkish Lira',
		'USD' => 'U.S. Dollar',			
	);

	public function __construct() {

		add_action( 'init', array( $this, 'set_defaults' ) );

		// Call when plugin is initialized on every page load
		add_action( 'init', array( $this, 'load_settings_panel' ) );

		// Add filters on the menu style so we can apply the setting option
		add_filter( 'fdm_menu_args', array( $this, 'set_style' ) );
		add_filter( 'fdm_shortcode_menu_atts', array( $this, 'set_style' ) );
		add_filter( 'fdm_shortcode_menu_item_atts', array( $this, 'set_style' ) );

	}

	/**
	 * Set the default values for different settings in the plugin
	 *
	 * @since 1.5
	 */
	public function set_defaults() {

		$this->defaults = array(
			'fdm-pro-style' 						=> 'classic',
			'fdm-sidebar-click-action' 				=> 'onlyselected',
			'fdm-menu-section-image-placement' 		=> 'hidden',
			'fdm-related-items' 					=> 'none',	
			'fdm-currency-symbol-location' 			=> 'before',
			'fdm-currency-symbol' 					=> '',
			'fdm-image-style-columns' 				=> 'four',
			'fdm-item-flag-icon-size' 				=> '32',
			'fdm-price-filtering-type' 				=> 'textbox',
			'time-format' 							=> _x( 'h:i A', 'Default time format for display. Must match formatting rules at http://amsul.ca/pickadate.js/time/#formats', 'food-and-drink-menu' ),
			'date-format' 							=> _x( 'mmmm d, yyyy', 'Default date format for display. Must match formatting rules at http://amsul.ca/pickadate.js/date/#formats', 'food-and-drink-menu' ),

			'fdm-enable-ordering-progress-display' 	=> false,
			'fdm-ordering-order-delete-time'		=> 7,
			'fdm-ordering-reply-to-address'			=> get_option( 'admin_email' ),
			'fdm-ordering-reply-to-name'			=> get_option( 'blogname' ),

			'fdm-details-lightbox'					=> 'lightbox',

			// Payment defaults
			'paypal-email'							=> get_option( 'admin_email' ),
			'ordering-currency'						=> 'USD',
			'ordering-payment-mode'					=> 'live',

			'customer-email-subject' 					=> _x( 'Your order has been accepted', 'The subject for the email sent to the customer when their order is accepted.', 'food-and-drink-menu' ),
			'customer-email-template' 					=> _x( 'Your order with {site_name} has been accepted:

Order Number: {order_number}

Name: {name}
Email: {email}
Phone: {phone}
Note: {note}
Payment Amount: {payment_amount}

Items ordered:

{order_items}

&nbsp;

<em>This message was sent by {site_link} on {current_time}.</em>',
				'Default email sent to the customer when a new order is received. The tags in {brackets} will be replaced by the appropriate content and should be left in place. HTML is allowed, but be aware that many email clients do not handle HTML very well.',
				'food-and-drink-menu'
			),

			'admin-email-subject' 					=> _x( 'New Order Submitted', 'The subject for the email sent to the admin when a new order is received.', 'food-and-drink-menu' ),
			'admin-email-template' 					=> _x( 'A new order has been submitted at {site_name}:

Name: {name}
Email: {email}
Phone: {phone}
Note: {note}
Payment Amount: {payment_amount}

Items ordered:

{order_items}

Click on the following link to accept the order: {accept_link}

&nbsp;

<em>This message was sent by {site_link} on {current_time}.</em>',
				'Default email sent to the admin when a new order is received. The tags in {brackets} will be replaced by the appropriate content and should be left in place. HTML is allowed, but be aware that many email clients do not handle HTML very well.',
				'food-and-drink-menu'
			),
		);

		$this->defaults = apply_filters( 'fdm_defaults', $this->defaults );
	}

	/**
	 * Get the theme supports options for this plugin
	 *
	 * This mimics the core get_theme_support function, except it automatically
	 * looks up this plugin's feature set and searches for features within
	 * those settings.
	 *
	 * @param string $feature The feature support to check
	 * @since 1.5
	 */
	public function get_theme_support( $feature ) {

		$theme_support = get_theme_support( 'food-and-drink-menu' );

		if ( !is_array( $theme_support ) ) {
			return apply_filters( 'fdm_get_theme_support_' . $feature, false, $theme_support );
		}

		$theme_support = $theme_support[0];

		if ( isset( $theme_support[$feature] ) ) {
			return apply_filters( 'fdm_get_theme_support_' . $feature, $theme_support[$feature], $theme_support );
		}

		return apply_filters( 'fdm_get_theme_support_' . $feature, false, $theme_support );
	}

	/**
	 * Get a setting's value or fallback to a default if one exists
	 * @since 2.0.0
	 */
	public function get_setting( $setting ) {

		if ( empty( $this->settings ) ) {
			$this->settings = get_option( 'food-and-drink-menu-settings' );
		}

		if ( !empty( $this->settings[ $setting ] ) ) {
			return apply_filters( 'fdm-setting-' . $setting, $this->settings[ $setting ] );
		}

		if ( empty( $this->premium_settings ) ) {
			$this->premium_settings = get_option( 'food-and-drink-menu-extra-settings' );
		}

		if ( !empty( $this->premium_settings[ $setting ] ) ) {
			return apply_filters( 'fdm-setting-' . $setting, $this->premium_settings[ $setting ] );
		}

		if ( !empty( $this->defaults[ $setting ] ) ) {
			return apply_filters( 'fdm-setting-' . $setting, $this->defaults[ $setting ] );
		}

		return apply_filters( 'fdm-setting-' . $setting, null );
	}

	/**
	 * Set a setting to a particular value
	 * @since 2.0.5
	 */
	public function set_setting( $setting, $value ) {

		if ( empty( $this->settings ) ) {
			$this->settings = get_option( 'food-and-drink-menu-settings' );
		}

		if ( $setting ) {
			$this->settings[ $setting ] = $setting_value;
		}
	}

	/**
	 * Save all settings, to be used with set_setting
	 * @since 2.0.5
	 */
	public function save_settings() {
		
		update_option( 'food-and-drink-menu-settings', $this->settings );
	}

	/**
	 * Load the admin settings page
	 * @since 1.1
	 * @sa https://github.com/NateWr/simple-admin-pages
	 */
	public function load_settings_panel() {
		global $fdm_controller;

		require_once( FDM_PLUGIN_DIR . '/lib/simple-admin-pages/simple-admin-pages.php');

		// Insantiate the Simple Admin Library so that we can add a settings page
		$sap = sap_initialize_library(
			array(
				'version'		=> '2.0.a.7', // Version of the library
				'lib_url'		=> FDM_PLUGIN_URL . '/lib/simple-admin-pages/', // URL path to sap library
			)
		);

		// Create a page for the options under the Settings (options) menu
		$sap->add_page(
			'submenu', 				// Admin menu which this page should be added to
			array(					// Array of key/value pairs matching the AdminPage class constructor variables
				'id'			=> 'food-and-drink-menu-settings',
				'title'			=> __( 'Settings', 'food-and-drink-menu' ),
				'menu_title'	=> __( 'Settings', 'food-and-drink-menu' ),
				'description'	=> '',
				'capability'	=> 'manage_options',
				'parent_menu'	=> 'edit.php?post_type=fdm-menu',
				'default_tab'	=> 'fdm-basic-settings'
			)
		);

		// Create a tab for basic settings
		$sap->add_section(
			'food-and-drink-menu-settings',	// Page to add this section to
			array(								// Array of key/value pairs matching the AdminPageSection class constructor variables
				'id'			=> 'fdm-basic-settings',
				'title'			=> __( 'Basic', 'food-and-drink-menu' ),
				'is_tab'		=> true
			)
		);

		// Create a section to choose a default style
		$sap->add_section(
			'food-and-drink-menu-settings',	// Page to add this section to
			array(								// Array of key/value pairs matching the AdminPageSection class constructor variables
				'id'			=> 'fdm-style-settings',
				'title'			=> __( 'Style', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose what style you would like to use for your menu.', 'food-and-drink-menu' ),
				'tab'			=> 'fdm-basic-settings'
			)
		);

		$options = array();
		foreach( $fdm_controller->styles as $style ) {
			$options[$style->id] = $style->label;
		}
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-style-settings',
			'select',
			array(
				'id'			=> 'fdm-style',
				'title'			=> __( 'Menu Formatting', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the formatting for your menus.', 'food-and-drink-menu' ),
				'blank_option'	=> false,
				'options'		=> $options
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-style-settings',
			'toggle',
			array(
				'id'			=> 'fdm-sidebar',
				'title'			=> __( 'Enable Sidebar', 'food-and-drink-menu' ),
				'description'	=> __( 'Display a sidebar for your menu that allows visitors to choose what section they want to view.', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-style-settings',
			'select',
			array(
				'id'			=> 'fdm-sidebar-click-action',
				'title'			=> __( 'Sidebar Click Action', 'food-and-drink-menu' ),
				'description'	=> __( '(Only applicable if the sidebar is enabled.) Choose what happens when you click a section in the menu sidebar. Only Selected will display only the chosen section, with no scrolling feature. Scroll displays all the sections and then scrolls to the chosen one.', 'food-and-drink-menu' ),
				'blank_option'	=> false,
				'options'		=> array(
					'onlyselected' 	=> 'Only Selected',
					'scroll' 	=> 'Scroll',
				)
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-style-settings',
			'select',
			array(
				'id'			=> 'fdm-menu-section-image-placement',
				'title'			=> __( 'Section Images', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the location, if any, for your section images relative to the title.', 'food-and-drink-menu' ),
				'blank_option'	=> false,
				'options'		=> array(
					'hidden' 		=> 'Hidden',
					'background' 	=> 'Background',
					'above' 		=> 'Above',
					'below' 		=> 'Below'
				)
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-style-settings',
			'toggle',
			array(
				'id'			=> 'fdm-display-section-descriptions',
				'title'			=> __( 'Display Section Descriptions', 'food-and-drink-menu' ),
				'description'	=> __( 'Enable this if you want to display the section descriptions in the main menu area.', 'food-and-drink-menu' ),
			)
		);

		// Create a section to enable/disable specific features
		$sap->add_section(
			'food-and-drink-menu-settings',	// Page to add this section to
			array(								// Array of key/value pairs matching the AdminPageSection class constructor variables
				'id'			=> 'fdm-enable-settings',
				'title'			=> __( 'Functionality', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose what features of the menu items you wish to enable or disable.', 'food-and-drink-menu' ),
				'tab'			=> 'fdm-basic-settings'
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-enable-settings',
			'toggle',
			array(
				'id'			=> 'fdm-disable-price',
				'title'			=> __( 'Disable Price', 'food-and-drink-menu' ),
				'description'	=> __( 'Disable all pricing options for menu items.', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-enable-settings',
			'radio',
			array(
				'id'			=> 'fdm-details-lightbox',
				'title'			=> __( 'Product Details', 'food-and-drink-menu' ),
				'description'	=> __( 'Should visitors be able to click on menu items to view more details about them (custom fields, related items, etc.)? If so, should that display in a lightbox or redirect to the permalink page?', 'food-and-drink-menu' ),
				'options'		=> array(
					'disabled'		=> 'Disabled',
					'lightbox'		=> 'Lightbox',
					'permalink'		=> 'Permalink Page'
				)
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-enable-settings',
			'text',
			array(
				'id'			=> 'fdm-currency-symbol',
				'title'			=> __( 'Currency Symbol', 'food-and-drink-menu' ),
				'description'	=> __( 'The symbol added either before or after menu prices.', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-enable-settings',
			'select',
			array(
				'id'			=> 'fdm-currency-symbol-location',
				'title'			=> __( 'Currency Symbol Location', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose whether the currency symbol be displayed before or after the price.', 'food-and-drink-menu' ),
				'blank_option'	=> false,
				'options'		=> array(
					'before' 	=> 'Before',
					'after' 	=> 'After'
				)
			)
		);

		// Create a section for advanced options
		// $sap->add_section(
		// 	'food-and-drink-menu-settings',	// Page to add this section to
		// 	array(								// Array of key/value pairs matching the AdminPageSection class constructor variables
		// 		'id'			=> 'fdm-advanced-settings',
		// 		'title'			=> __( 'Advanced Options', 'food-and-drink-menu' )
		// 	)
		// );
		// $sap->add_setting(
		// 	'food-and-drink-menu-settings',
		// 	'fdm-advanced-settings',
		// 	'text',
		// 	array(
		// 		'id'			=> 'fdm-item-thumb-width',
		// 		'title'			=> __( 'Menu Item Photo Width', 'food-and-drink-menu' ),
		// 		'description'	=> sprintf(
		// 			esc_html__( 'The width in pixels of menu item thumbnails. Leave this field empty to preserve the default (600x600). After changing this setting, you may need to %sregenerate your thumbnails%s.', 'food-and-drink-menu' ),
		// 			'<a href="http://doc.themeofthecrop.com/plugins/food-and-drink-menu/user/faq#image-sizes">',
		// 			'</a>'
		// 		),
		// 	)
		// );
		// $sap->add_setting(
		// 	'food-and-drink-menu-settings',
		// 	'fdm-advanced-settings',
		// 	'text',
		// 	array(
		// 		'id'			=> 'fdm-item-thumb-height',
		// 		'title'			=> __( 'Menu Item Photo Height', 'food-and-drink-menu' ),
		// 		'description'	=> sprintf(
		// 			esc_html__( 'The height in pixels of menu item thumbnails. Leave this field empty to preserve the default (600x600). After changing this setting, you may need to %sregenerate your thumbnails%s.', 'food-and-drink-menu' ),
		// 			'<a href="http://doc.themeofthecrop.com/plugins/food-and-drink-menu/user/faq#image-sizes">',
		// 			'</a>'
		// 		),
		// 	)
		// );

		if ( ! $fdm_controller->permissions->check_permission('styling') ) {
			$styling_permissions = array(
				'disabled'		=> true,
				'disabled_image'=> 'https://www.etoilewebdesign.com/wp-content/uploads/2018/06/Logo-White-Filled40-px.png',
				'purchase_link'	=> 'https://www.etoilewebdesign.com/plugins/ultimate-product-catalog/'
			);
		}
		else { $styling_permissions = array(); }

		// Create a tab for styling settings
		$sap->add_section(
			'food-and-drink-menu-settings',	// Page to add this section to
			array(								// Array of key/value pairs matching the AdminPageSection class constructor variables
				'id'			=> 'fdm-styling-settings-tab',
				'title'			=> __( 'Styling', 'food-and-drink-menu' ),
				'is_tab'		=> true
			)
		);
		// Create a section for styling options
		$sap->add_section(
			'food-and-drink-menu-settings',	// Page to add this section to
			array_merge( 
				array(								// Array of key/value pairs matching the AdminPageSection class constructor variables
					'id'			=> 'fdm-styling-settings',
					'title'			=> __( 'Styling Options', 'food-and-drink-menu' ),
					'description'	=> __( 'Choose what filtering, if any, of the menu items you wish to enable.', 'food-and-drink-menu' ),
					'tab'			=> 'fdm-styling-settings-tab'
				),
				$styling_permissions
			)
		);
		$style_options = array();
		foreach( $fdm_controller->prostyles as $prostyle ) {
			$style_options[$prostyle->id] = $prostyle->label;
		}
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'select',
			array(
				'id'			=> 'fdm-pro-style',
				'title'			=> __( 'Menu Style', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the style for your menus.', 'food-and-drink-menu' ),
				'blank_option'	=> false,
				'options'		=> $style_options
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'radio',
			array(
				'id'			=> 'fdm-image-style-columns',
				'title'			=> __( 'Image Style Columns', 'food-and-drink-menu' ),
				'description'	=> __( '(Only applicable if Image Style is selected above.) Choose how many columns you want to display in the Image Style layout.', 'food-and-drink-menu' ),
				'options'		=> array(
					'three'		=> '3',
					'four'		=> '4',
					'five'		=> '5'
				)
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'select',
			array(
				'id'			=> 'fdm-item-flag-icon-size',
				'title'			=> __( 'Menu Item Flag icon size', 'food-and-drink-menu-pro' ),
				'description'	=> __( 'The size in pixels of menu item flag icons (if enabled).', 'food-and-drink-menu-pro' ),
				'options'		=> array(
					'32' => __( '32x32 (default)', 'food-and-drink-menu-pro' ),
					'64' => __( '64x64', 'food-and-drink-menu-pro' )
				)
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'text',
			array(
				'id'			=> 'fdm-styling-section-title-font-family',
				'title'			=> __( 'Section Title Font Family', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the font family for the section titles. (Please note that the font family must already be loaded on the site. This does not load it.)', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'text',
			array(
				'id'			=> 'fdm-styling-section-title-font-size',
				'title'			=> __( 'Section Title Font Size', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the font size for the section titles. Include the unit (e.g. 20px or 2em).', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'colorpicker',
			array(
				'id'			=> 'fdm-styling-section-title-color',
				'title'			=> __( 'Section Title Color', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the color for the section titles', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'text',
			array(
				'id'			=> 'fdm-styling-item-name-font-family',
				'title'			=> __( 'Item Name Font Family', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the font family for the names of the menu items. (Please note that the font family must already be loaded on the site. This does not load it.)', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'text',
			array(
				'id'			=> 'fdm-styling-item-name-font-size',
				'title'			=> __( 'Item Name Font Size', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the font size for the names of the menu items. Include the unit (e.g. 18px or 1.3em).', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'colorpicker',
			array(
				'id'			=> 'fdm-styling-item-name-color',
				'title'			=> __( 'Item Name Color', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the color for the names of the menu items', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'text',
			array(
				'id'			=> 'fdm-styling-item-description-font-family',
				'title'			=> __( 'Item Description Font Family', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the font family for the descriptions of the menu items. (Please note that the font family must already be loaded on the site. This does not load it.)', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'text',
			array(
				'id'			=> 'fdm-styling-item-description-font-size',
				'title'			=> __( 'Item Description Font Size', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the font size for the descriptions of the menu items. Include the unit (e.g. 12px or 1em).', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'colorpicker',
			array(
				'id'			=> 'fdm-styling-item-description-color',
				'title'			=> __( 'Item Description Color', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the color for the descriptions of the menu items', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'text',
			array(
				'id'			=> 'fdm-styling-item-price-font-size',
				'title'			=> __( 'Item Price Font Size', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the font size for the prices of the menu items. Include the unit (e.g. 12px or 1em).', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'colorpicker',
			array(
				'id'			=> 'fdm-styling-item-price-color',
				'title'			=> __( 'Item Price Color', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the color for the prices of the menu items', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'text',
			array(
				'id'			=> 'fdm-styling-image-width',
				'title'			=> __( 'Item Image Width', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the width of the menu item images. Include the unit (e.g. 20% or 200px). Default is 33%.', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'text',
			array(
				'id'			=> 'fdm-styling-image-border-size',
				'title'			=> __( 'Item Image Border Size', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the size of the border around menu item images. It is automatically in pixels, so no need to set the unit (e.g. just put 1 or 3, etc.).', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'colorpicker',
			array(
				'id'			=> 'fdm-styling-image-border-color',
				'title'			=> __( 'Item Image Border Color', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the color for the border around the menu item images', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'text',
			array(
				'id'			=> 'fdm-styling-separating-line-size',
				'title'			=> __( 'Separating Line Size', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the size of the line that separates different menu sections. It is automatically in pixels, so no need to set the unit (e.g. just put 1 or 3, etc.).', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'colorpicker',
			array(
				'id'			=> 'fdm-styling-separating-line-color',
				'title'			=> __( 'Separating Line Color', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the color for the line that separates different menu sections', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'text',
			array(
				'id'			=> 'fdm-styling-filtering-font-family',
				'title'			=> __( 'Filtering Font Family', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the font family for the filtering area. (Please note that the font family must already be loaded on the site. This does not load it.)', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'text',
			array(
				'id'			=> 'fdm-styling-filtering-title-font-size',
				'title'			=> __( 'Filtering Title Font Size', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the font size for the filtering area title. Include the unit (e.g. 20px or 2em).', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'colorpicker',
			array(
				'id'			=> 'fdm-styling-filtering-title-color',
				'title'			=> __( 'Filtering Title Color', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the color for the filtering area title', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'text',
			array(
				'id'			=> 'fdm-styling-filtering-labels-font-size',
				'title'			=> __( 'Filtering Labels Font Size', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the font size for the filtering area labels. Include the unit (e.g. 14px or 1.2em).', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'colorpicker',
			array(
				'id'			=> 'fdm-styling-filtering-labels-color',
				'title'			=> __( 'Filtering Labels Color', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the color for the filtering area labels', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'text',
			array(
				'id'			=> 'fdm-styling-sidebar-font-family',
				'title'			=> __( 'Sidebar Font Family', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the font family for the menu sidebar. (Please note that the font family must already be loaded on the site. This does not load it.)', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'text',
			array(
				'id'			=> 'fdm-styling-sidebar-title-font-size',
				'title'			=> __( 'Sidebar Titles Font Size', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the font size for the section titles in the menu sidebar. Include the unit (e.g. 20px or 2em).', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'colorpicker',
			array(
				'id'			=> 'fdm-styling-sidebar-title-color',
				'title'			=> __( 'Sidebar Titles Color', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the color for the section titles in the menu sidebar', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'text',
			array(
				'id'			=> 'fdm-styling-sidebar-description-font-size',
				'title'			=> __( 'Sidebar Descriptions Font Size', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the font size for the section descriptions in the menu sidebar. Include the unit (e.g. 14px or 1em).', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'colorpicker',
			array(
				'id'			=> 'fdm-styling-sidebar-description-color',
				'title'			=> __( 'Sidebar Descriptions Color', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the color for the section descriptions in the menu sidebar', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'colorpicker',
			array(
				'id'			=> 'fdm-styling-item-icon-color',
				'title'			=> __( 'Item Icon Color', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the color for the item icons', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'colorpicker',
			array(
				'id'			=> 'fdm-styling-add-to-cart-background-color',
				'title'			=> __( 'Add to Cart Button Background Color', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the background color for the add-to-cart button', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'colorpicker',
			array(
				'id'			=> 'fdm-styling-add-to-cart-text-color',
				'title'			=> __( 'Add to Cart Button Text Hover Color', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the text color for the add-to-cart button when you hover over it', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'colorpicker',
			array(
				'id'			=> 'fdm-styling-shopping-cart-accent-color',
				'title'			=> __( 'Shopping Cart Accent Color', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose an accent color for the shopping cart pane. This will apply to elements like the heading and the clear button.', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'colorpicker',
			array(
				'id'			=> 'fdm-styling-order-progress-color',
				'title'			=> __( 'Order Progress Bar Fill Color', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the fill color for the order progress bar.', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-styling-settings',
			'colorpicker',
			array(
				'id'			=> 'fdm-styling-order-progress-border-color',
				'title'			=> __( 'Order Progress Bar Border Color', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the border color for the order progress bar.', 'food-and-drink-menu' )
			)
		);

		// Create a tab for premium settings
		$sap->add_section(
			'food-and-drink-menu-settings',	// Page to add this section to
			array(								// Array of key/value pairs matching the AdminPageSection class constructor variables
				'id'			=> 'fdm-advanced-settings',
				'title'			=> __( 'Advanced', 'food-and-drink-menu' ),
				'is_tab'		=> true
			)
		);

		if ( ! $fdm_controller->permissions->check_permission('filtering') ) {
			$filtering_permissions = array(
				'disabled'		=> true,
				'disabled_image'=> 'https://www.etoilewebdesign.com/wp-content/uploads/2018/06/Logo-White-Filled40-px.png',
				'purchase_link'	=> 'https://www.etoilewebdesign.com/plugins/ultimate-product-catalog/'
			);
		}
		else { $filtering_permissions = array(); }

		// Create a section to enable/disable filtering features
		$sap->add_section(
			'food-and-drink-menu-settings',	// Page to add this section to
			array_merge( 
				array(								// Array of key/value pairs matching the AdminPageSection class constructor variables
					'id'			=> 'fdm-filtering-settings',
					'title'			=> __( 'Filtering', 'food-and-drink-menu' ),
					'description'	=> __( 'Choose what filtering, if any, of the menu items you wish to enable.', 'food-and-drink-menu' ),
					'tab'			=> 'fdm-advanced-settings'
				),
				$filtering_permissions
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-filtering-settings',
			'checkbox',
			array(
				'id'			=> 'fdm-text-search',
				'title'			=> __( 'Menu Item Search', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose what menu items features, if any, should be searchable.', 'food-and-drink-menu' ),
				'options'		=> array(
					'name' 			=> 'Name',
					'description' 	=> 'Description'
				)
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-filtering-settings',
			'toggle',
			array(
				'id'			=> 'fdm-enable-price-filtering',
				'title'			=> __( 'Price Filtering', 'food-and-drink-menu' ),
				'description'	=> __( 'Allow visitors to search menu items in a specific price range. <strong>Please be aware that, since the additional price fields are just text fields, into which you can input whatever combination of text/numbers/etc. that you want, you need to make sure you have formatted your additional prices to have only one number in them, to ensure they display correctly in the price filter/slider.</strong>', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-filtering-settings',
			'select',
			array(
				'id'			=> 'fdm-price-filtering-type',
				'title'			=> __( 'Price Filtering Control', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose the type of control available to visitors if price filtering is enabled.', 'food-and-drink-menu' ),
				'blank_option'	=> false,
				'options'		=> array(
					'textbox' 	=> 'Text Boxes',
					'slider' 	=> 'Slider'
				)
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-filtering-settings',
			'toggle',
			array(
				'id'			=> 'fdm-enable-sorting',
				'title'			=> __( 'Menu Item Sorting', 'food-and-drink-menu' ),
				'description'	=> __( 'Allow visitors to sort menu items by name, price, date added, etc. to find items they may be interested in.', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-filtering-settings',
			'checkbox',
			array(
				'id'			=> 'fdm-item-sorting',
				'title'			=> __( 'Sortable Items', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose what menu items features, if any, should be sortable.', 'food-and-drink-menu' ),
				'options'		=> array(
					'name' 			=> 'Name',
					'price' 		=> 'Price',
					'date_added'	=> 'Date Added'
				)
			)
		);

		if ( ! $fdm_controller->permissions->check_permission('flags') ) {
			$flags_permissions = array(
				'disabled'		=> true,
				'disabled_image'=> 'https://www.etoilewebdesign.com/wp-content/uploads/2018/06/Logo-White-Filled40-px.png',
				'purchase_link'	=> 'https://www.etoilewebdesign.com/plugins/ultimate-product-catalog/'
			);
		}
		else { $flags_permissions = array(); }
		
		$sap->add_section(
			'food-and-drink-menu-settings',	// Page to add this section to
			array_merge( 
				array(								// Array of key/value pairs matching the AdminPageSection class constructor variables
					'id'			=> 'fdm-advanced-enable-settings',
					'title'			=> __( 'Functionality', 'food-and-drink-menu' ),
					'description'	=> __( 'Choose what features of the menu items you wish to enable or disable.', 'food-and-drink-menu' ),
					'tab'			=> 'fdm-advanced-settings'
				),
				$flags_permissions
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-advanced-enable-settings',
			'radio',
			array(
				'id'			=> 'fdm-related-items',
				'title'			=> __( 'Related Items', 'food-and-drink-menu' ),
				'description'	=> __( 'Should related items be displayed when viewing a particular item.', 'food-and-drink-menu' ),
				'options'		=> array(
					'none'			=> 'None',
					'automatic'		=> 'Automatic',
					'manual'		=> 'Manual'
				)
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-advanced-enable-settings',
			'toggle',
			array(
				'id'			=> 'fdm-disable-menu-item-flags',
				'title'			=> __( 'Disable Menu Item Flags', 'food-and-drink-menu-pro' ),
				'description'	=> __( 'Disable the flags which can be assigned to menu items.', 'food-and-drink-menu-pro' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-advanced-enable-settings',
			'toggle',
			array(
				'id'			=> 'fdm-disable-specials',
				'title'			=> __( 'Disable Menu Item Specials', 'food-and-drink-menu-pro' ),
				'description'	=> __( 'Disable the specials options for menu items.', 'food-and-drink-menu-pro' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-advanced-enable-settings',
			'toggle',
			array(
				'id'			=> 'fdm-disable-price-discounted',
				'title'			=> __( 'Disable Discounted Price', 'food-and-drink-menu-pro' ),
				'description'	=> __( 'Disable discounted pricing options for menu items.', 'food-and-drink-menu-pro' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-advanced-enable-settings',
			'toggle',
			array(
				'id'			=> 'fdm-disable-src',
				'title'			=> __( 'Disable Source', 'food-and-drink-menu-pro' ),
				'description'	=> __( 'Disable all source options in menus.', 'food-and-drink-menu-pro' )
			)
		);

		// Adds in a section to handle the source map options
		$sap->add_section(
			'food-and-drink-menu-settings',
			array(
				'id'    => 'fdm-google-map',
				'title' => __( 'Google Map', 'food-and-drink-menu-pro' ),
				'tab'	=> 'fdm-advanced-settings'
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-google-map',
			'toggle',
			array(
				'id'			=> 'fdm-disable-src-map',
				'title'			=> __( 'Disable Source Map', 'food-and-drink-menu-pro' ),
				'description'	=> __( 'Disable the source map.', 'food-and-drink-menu-pro' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-google-map',
			'text',
			array(
				'id'          => 'fdm-google-map-api-key',
				'title'       => __( 'Google Maps API Key', 'food-and-drink-menu-pro' ),
				'description' => sprintf(
					__( 'Google requires an API key to use their maps. %sGet an API key%s. A full walk-through is available in the %sdocumentation%s.', 'food-and-drink-menu-pro' ),
					'<a href="https://developers.google.com/maps/documentation/javascript/get-api-key">',
					'</a>',
					'<a href="http://doc.fivestarplugins.com/plugins/food-and-drink-menu/user/pro/google-map-api-key">',
					'</a>'
				),
			)
		);

		if ( ! $fdm_controller->permissions->check_permission('ordering') ) {
			$ordering_permissions = array(
				'disabled'		=> true,
				'disabled_image'=> 'https://www.etoilewebdesign.com/wp-content/uploads/2018/06/Logo-White-Filled40-px.png',
				'purchase_link'	=> 'https://www.etoilewebdesign.com/plugins/ultimate-product-catalog/'
			);
		}
		else { $ordering_permissions = array(); }

		// Create a tab for ordering settings
		$sap->add_section(
			'food-and-drink-menu-settings',	// Page to add this section to
			array(								// Array of key/value pairs matching the AdminPageSection class constructor variables
				'id'			=> 'fdm-ordering-settings',
				'title'			=> __( 'Ordering', 'food-and-drink-menu' ),
				'is_tab'		=> true
			)
		);

		$sap->add_section(
			'food-and-drink-menu-settings',	// Page to add this section to
			array_merge( 
				array(								// Array of key/value pairs matching the AdminPageSection class constructor variables
					'id'			=> 'fdm-basic-ordering-settings',
					'title'			=> __( 'Basic', 'food-and-drink-menu' ),
					'description'	=> __( 'Enable and set up ordering', 'food-and-drink-menu' ),
					'tab'			=> 'fdm-ordering-settings'
				)
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-basic-ordering-settings',
			'toggle',
			array(
				'id'			=> 'fdm-enable-ordering',
				'title'			=> __( 'Enable Ordering', 'food-and-drink-menu' ),
				'description'	=> __( 'Allow visitors to add menu items to a cart, which is then emailed to the site administrator.', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-basic-ordering-settings',
			'text',
			array(
				'id'			=> 'fdm-ordering-order-delete-time',
				'title'			=> __( 'Delete Orders Delay Days', 'food-and-drink-menu' ),
				'description'	=> __( 'How many days after an order is created should it be deleted from the database?', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-basic-ordering-settings',
			'checkbox',
			array(
				'id'			=> 'fdm-ordering-required-fields',
				'title'			=> __( 'Required Fields', 'food-and-drink-menu' ),
				'description'	=> __( 'Choose which ordering information fields, if any, should be required.', 'food-and-drink-menu' ),
				'options'		=> array(
					'name' 			=> 'Name',
					'phone' 		=> 'Phone',
					'email'			=> 'Email'
				)
			)
		);

		// $sap->add_setting(
		// 	'food-and-drink-menu-settings',
		// 	'fdm-basic-ordering-settings',
		// 	'text',
		// 	array(
		// 		'id'			=> 'fdm-ordering-redirect-page',
		// 		'title'			=> __( 'Redirect Page', 'food-and-drink-menu' ),
		// 		'description'	=> __( 'Specify the URL of a page you would like your customer to be redirected to after they place an order. (This is not mandatory. Not entering anything here will just leave it so that it stays on the menu page after an order is placed.)', 'food-and-drink-menu' )
		// 	)
		// );

		// Translateable strings for scheduler components
		$scheduler_strings = array(
			'add_rule'			=> __( 'Add new scheduling rule', 'food-and-drink-menu' ),
			'weekly'			=> _x( 'Weekly', 'Format of a scheduling rule', 'food-and-drink-menu' ),
			'monthly'			=> _x( 'Monthly', 'Format of a scheduling rule', 'food-and-drink-menu' ),
			'date'				=> _x( 'Date', 'Format of a scheduling rule', 'food-and-drink-menu' ),
			'weekdays'			=> _x( 'Days of the week', 'Label for selecting days of the week in a scheduling rule', 'food-and-drink-menu' ),
			'month_weeks'		=> _x( 'Weeks of the month', 'Label for selecting weeks of the month in a scheduling rule', 'food-and-drink-menu' ),
			'date_label'		=> _x( 'Date', 'Label to select a date for a scheduling rule', 'food-and-drink-menu' ),
			'time_label'		=> _x( 'Time', 'Label to select a time slot for a scheduling rule', 'food-and-drink-menu' ),
			'allday'			=> _x( 'All day', 'Label to set a scheduling rule to last all day', 'food-and-drink-menu' ),
			'start'				=> _x( 'Start', 'Label for the starting time of a scheduling rule', 'food-and-drink-menu' ),
			'end'				=> _x( 'End', 'Label for the ending time of a scheduling rule', 'food-and-drink-menu' ),
			'set_time_prompt'	=> _x( 'All day long. Want to %sset a time slot%s?', 'Prompt displayed when a scheduling rule is set without any time restrictions', 'food-and-drink-menu' ),
			'toggle'			=> _x( 'Open and close this rule', 'Toggle a scheduling rule open and closed', 'food-and-drink-menu' ),
			'delete'			=> _x( 'Delete rule', 'Delete a scheduling rule', 'food-and-drink-menu' ),
			'delete_schedule'	=> __( 'Delete scheduling rule', 'food-and-drink-menu' ),
			'never'				=> _x( 'Never', 'Brief default description of a scheduling rule when no weekdays or weeks are included in the rule', 'food-and-drink-menu' ),
			'weekly_always'		=> _x( 'Every day', 'Brief default description of a scheduling rule when all the weekdays/weeks are included in the rule', 'food-and-drink-menu' ),
			'monthly_weekdays'	=> _x( '%s on the %s week of the month', 'Brief default description of a scheduling rule when some weekdays are included on only some weeks of the month. %s should be left alone and will be replaced by a comma-separated list of days and weeks in the following format: M, T, W on the first, second week of the month', 'food-and-drink-menu' ),
			'monthly_weeks'		=> _x( '%s week of the month', 'Brief default description of a scheduling rule when some weeks of the month are included but all or no weekdays are selected. %s should be left alone and will be replaced by a comma-separated list of weeks in the following format: First, second week of the month', 'food-and-drink-menu' ),
			'all_day'			=> _x( 'All day', 'Brief default description of a scheduling rule when no times are set', 'food-and-drink-menu' ),
			'before'			=> _x( 'Ends at', 'Brief default description of a scheduling rule when an end time is set but no start time. If the end time is 6pm, it will read: Ends at 6pm', 'food-and-drink-menu' ),
			'after'				=> _x( 'Starts at', 'Brief default description of a scheduling rule when a start time is set but no end time. If the start time is 6pm, it will read: Starts at 6pm', 'food-and-drink-menu' ),
			'separator'			=> _x( '&mdash;', 'Separator between times of a scheduling rule', 'food-and-drink-menu' ),
		);

		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-basic-ordering-settings',
			'scheduler',
			array(
				'id'			=> 'schedule-open',
				'title'			=> __( 'Schedule', 'food-and-drink-menu' ),
				'description'	=> __( 'Define the weekly schedule times during which you accept orders.', 'food-and-drink-menu' ),
				'weekdays'		=> array(
					'monday'		=> _x( 'Mo', 'Monday abbreviation', 'food-and-drink-menu' ),
					'tuesday'		=> _x( 'Tu', 'Tuesday abbreviation', 'food-and-drink-menu' ),
					'wednesday'		=> _x( 'We', 'Wednesday abbreviation', 'food-and-drink-menu' ),
					'thursday'		=> _x( 'Th', 'Thursday abbreviation', 'food-and-drink-menu' ),
					'friday'		=> _x( 'Fr', 'Friday abbreviation', 'food-and-drink-menu' ),
					'saturday'		=> _x( 'Sa', 'Saturday abbreviation', 'food-and-drink-menu' ),
					'sunday'		=> _x( 'Su', 'Sunday abbreviation', 'food-and-drink-menu' )
				),
				'time_format'	=> $this->get_setting( 'time-format' ),
				'date_format'	=> $this->get_setting( 'date-format' ),
				'disable_weeks'	=> true,
				'disable_date'	=> true,
				'strings' => $scheduler_strings,
			)
		);

		$scheduler_strings['all_day'] = _x( 'Closed all day', 'Brief default description of a scheduling exception when no times are set', 'food-and-drink-menu' );
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-basic-ordering-settings',
			'scheduler',
			array(
				'id'				=> 'schedule-closed',
				'title'				=> __( 'Exceptions', 'food-and-drink-menu' ),
				'description'		=> __( "Define special opening hours for holidays, events or other needs. Leave the time empty if you're closed all day.", 'food-and-drink-menu' ),
				'time_format'		=> esc_attr( $this->get_setting( 'time-format' ) ),
				'date_format'		=> esc_attr( $this->get_setting( 'date-format' ) ),
				'disable_weekdays'	=> true,
				'disable_weeks'		=> true,
				'strings' => $scheduler_strings,
			)
		);

		// Create a section to handle premium ordering options
		$sap->add_section(
			'food-and-drink-menu-settings',	// Page to add this section to
			array_merge( 
				array(								// Array of key/value pairs matching the AdminPageSection class constructor variables
					'id'			=> 'fdm-advanced-ordering-settings',
					'title'			=> __( 'Advanced', 'food-and-drink-menu' ),
					'description'	=> __( 'Choose what advanced features should be enabled.', 'food-and-drink-menu' ),
					'tab'			=> 'fdm-ordering-settings'
				),
				$ordering_permissions
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-advanced-ordering-settings',
			'toggle',
			array(
				'id'			=> 'fdm-enable-ordering-options',
				'title'			=> __( 'Enable Advanced Ordering Options', 'food-and-drink-menu' ),
				'description'	=> __( 'Allow ordering options (ex. lettuce, tomato, cheese, bacon for a burger or toppings for a pizza) as well as notes for individual items.', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-advanced-ordering-settings',
			'toggle',
			array(
				'id'			=> 'fdm-enable-ordering-progress-display',
				'title'			=> __( 'Enable Order Progress Display', 'food-and-drink-menu' ),
				'description'	=> __( 'Display the status of a visitor\'s order on the menu page after they place an order. ', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-advanced-ordering-settings',
			'toggle',
			array(
				'id'			=> 'fdm-ordering-additional-prices',
				'title'			=> __( 'Include Additional Prices', 'food-and-drink-menu' ),
				'description'	=> __( 'Enabling this will include any additional prices you have set for a menu item in the ordering functionality. <strong>Please be aware that, since the additional price fields are just text fields, into which you can input whatever combination of text/numbers/etc. that you want, you need to make sure you have formatted your additional prices to have only one number in them and in such a way that they will make sense for your ordering cart.</strong>', 'food-and-drink-menu' )
			)
		);

		// Create a section to handle ordering notifications
		$sap->add_section(
			'food-and-drink-menu-settings',	// Page to add this section to
			array_merge( 
				array(								// Array of key/value pairs matching the AdminPageSection class constructor variables
					'id'			=> 'fdm-ordering-notifications-settings',
					'title'			=> __( 'Notifications', 'food-and-drink-menu' ),
					'description'	=> __( 'Choose settings for the order notifications.', 'food-and-drink-menu' ),
					'tab'			=> 'fdm-ordering-settings'
				)
			)
		);

		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-ordering-notifications-settings',
			'warningtip',
			array(
				'id'			=> 'fdm-notifications-reminder',
				'title'			=> __( 'REMINDER:', 'food-and-drink-menu' ),
				'placeholder'	=> __( 'Five-Star Restaurant Menu uses the default WordPress mailing functions. If you\'d like to customize how your emails are sent, you can do so by editing your settings or using a plugin such as <a target="_blank" href="https://wordpress.org/plugins/wp-mail-smtp/">WP Mail SMTP</a>.' )
			)
		);

		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-ordering-notifications-settings',
			'text',
			array(
				'id'			=> 'fdm-ordering-notification-email',
				'title'			=> __( 'Order Email Address', 'food-and-drink-menu' ),
				'description'	=> __( 'What email address should orders be sent to?', 'food-and-drink-menu' )
			)
		);

		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-ordering-notifications-settings',
			'text',
			array(
				'id'			=> 'fdm-ordering-reply-to-name',
				'title'			=> __( 'Reply-To Name', 'food-and-drink-menu' ),
				'description'	=> __( 'The name which should appear in the Reply-To field of a user notification email', 'food-and-drink-menu' ),
				'placeholder'	=> $this->defaults['fdm-ordering-reply-to-name'],
			)
		);

		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-ordering-notifications-settings',
			'text',
			array(
				'id'			=> 'fdm-ordering-reply-to-address',
				'title'			=> __( 'Reply-To Email Address', 'food-and-drink-menu' ),
				'description'	=> __( 'The email address which should appear in the Reply-To field of a user notification email.', 'food-and-drink-menu' ),
				'placeholder'	=> $this->defaults['fdm-ordering-reply-to-address'],
			)
		);

		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-ordering-notifications-settings',
			'text',
			array(
				'id'			=> 'customer-email-subject',
				'title'			=> __( 'Customer Notification Subject', 'food-and-drink-menu' ),
				'description'	=> __( 'The email subject for customer notifications.', 'food-and-drink-menu' ),
				'placeholder'	=> $this->defaults['customer-email-subject'],
			)
		);

		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-ordering-notifications-settings',
			'editor',
			array(
				'id'			=> 'customer-email-template',
				'title'			=> __( 'Customer Notification Email', 'food-and-drink-menu' ),
				'description'	=> __( 'Enter the email your customer should receive once their order is accepted.', 'food-and-drink-menu' ),
				'default'		=> $this->defaults['customer-email-template'],
			)
		);

		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-ordering-notifications-settings',
			'text',
			array(
				'id'			=> 'admin-email-subject',
				'title'			=> __( 'Admin Notification Subject', 'food-and-drink-menu' ),
				'description'	=> __( 'The email subject for admin notifications.', 'food-and-drink-menu' ),
				'placeholder'	=> $this->defaults['admin-email-subject'],
			)
		);

		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-ordering-notifications-settings',
			'editor',
			array(
				'id'			=> 'admin-email-template',
				'title'			=> __( 'Admin Notification Email', 'food-and-drink-menu' ),
				'description'	=> __( 'Enter the email an admin should receive when an order is made.', 'food-and-drink-menu' ),
				'default'		=> $this->defaults['admin-email-template'],
			)
		);

		// Create a section to handle ordering payments
		$sap->add_section(
			'food-and-drink-menu-settings',	// Page to add this section to
			array_merge( 
				array(								// Array of key/value pairs matching the AdminPageSection class constructor variables
					'id'			=> 'fdm-ordering-payments-settings',
					'title'			=> __( 'Payment', 'food-and-drink-menu' ),
					'description'	=> __( 'Settings for handling order payments.', 'food-and-drink-menu' ),
					'tab'			=> 'fdm-ordering-settings'
				),
				$ordering_permissions
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-ordering-payments-settings',
			'toggle',
			array(
				'id'			=> 'enable-payment',
				'title'			=> __( 'Enable Payment', 'food-and-drink-menu' ),
				'description'			=> __( 'Let customers pay for their order when they submit it online.', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-ordering-payments-settings',
			'toggle',
			array(
				'id'			=> 'payment-optional',
				'title'			=> __( 'Pay-In-Store Option', 'food-and-drink-menu' ),
				'description'			=> __( 'Give customers the option of paying for their order in person.', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-ordering-payments-settings',
			'radio',
			array(
				'id'			=> 'ordering-payment-gateway',
				'title'			=> __( 'Payment Gateway', 'food-and-drink-menu' ),
				'description'	=> __( 'Which payment gateway should be used to accept payments.', 'food-and-drink-menu' ),
				'options'		=> array(
					'paypal'		=> 'PayPal',
					'stripe'		=> 'Stripe'
				)
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-ordering-payments-settings',
			'select',
			array(
				'id'            => 'ordering-currency',
				'title'         => __( 'Currency', 'food-and-drink-menu' ),
				'description'   => __( 'Select the currency you accept for your payments.', 'food-and-drink-menu' ),
				'blank_option'	=> false,
				'options'       => $this->currency_options
			)
		);

		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-ordering-payments-settings',
			'radio',
			array(
				'id'			=> 'ordering-payment-mode',
				'title'			=> __( 'Test/Live Mode', 'food-and-drink-menu' ),
				'description'	=> __( 'Should the system use test or live mode? Test mode should only be used for testing, no payments will actually be processed while turned on.', 'food-and-drink-menu' ),
				'options'		=> array(
					'test'			=> 'Test',
					'live'			=> 'Live'
				)
			)
		);

		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-ordering-payments-settings',
			'text',
			array(
				'id'            => 'paypal-email',
				'title'         => __( 'PayPal Email Address', 'food-and-drink-menu' ),
				'description'   => __( 'The email address you\'ll be using to accept payments, if you\'re using Paypal for payments.', 'food-and-drink-menu' ),
				'placeholder'	=> $this->defaults['paypal-email']
			)
		);

		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-ordering-payments-settings',
			'text',
			array(
				'id'            => 'stripe-live-secret',
				'title'         => __( 'Stripe Live Secret', 'food-and-drink-menu' ),
				'description'   => __( 'The live secret that you have set up for your Stripe account, if you\'re using Stripe for payments.', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-ordering-payments-settings',
			'text',
			array(
				'id'            => 'stripe-live-publishable',
				'title'         => __( 'Stripe Live Publishable', 'food-and-drink-menu' ),
				'description'   => __( 'The live publishable that you have set up for your Stripe account, if you\'re using Stripe for payments.', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-ordering-payments-settings',
			'text',
			array(
				'id'            => 'stripe-test-secret',
				'title'         => __( 'Stripe Test Secret', 'food-and-drink-menu' ),
				'description'   => __( 'The test secret that you have set up for your Stripe account, if you\'re using Stripe for payments. Only needed for testing payments.', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-ordering-payments-settings',
			'text',
			array(
				'id'            => 'stripe-test-publishable',
				'title'         => __( 'Stripe Test Publishable', 'food-and-drink-menu' ),
				'description'   => __( 'The test publishable that you have set up for your Stripe account, if you\'re using Stripe for payments. Only needed for testing payments.', 'food-and-drink-menu' )
			)
		);

		if ( ! $fdm_controller->permissions->check_permission('custom_fields') ) {
			$custom_field_permissions = array(
				'disabled'		=> true,
				'disabled_image'=> 'https://www.etoilewebdesign.com/wp-content/uploads/2018/06/Logo-White-Filled40-px.png',
				'purchase_link'	=> 'https://www.etoilewebdesign.com/plugins/ultimate-product-catalog/'
			);
		}
		else { $custom_field_permissions = array(); }


		// Create a tab for custom field settings
		$sap->add_section(
			'food-and-drink-menu-settings',	// Page to add this section to
			array(								// Array of key/value pairs matching the AdminPageSection class constructor variables
				'id'			=> 'fdm-custom-fields-settings',
				'title'			=> __( 'Custom Fields', 'food-and-drink-menu' ),
				'is_tab'		=> true
			)
		);

		// Create a section for the custom fields
		$sap->add_section(
			'food-and-drink-menu-settings',	// Page to add this section to
			array_merge( 
				array(								// Array of key/value pairs matching the AdminPageSection class constructor variables
					'id'			=> 'fdm-custom-fields-settings-section',
					'title'			=> __( 'Custom Fields', 'food-and-drink-menu' ),
					'description'	=> __( 'Create custom fields for your menu.', 'food-and-drink-menu' ),
					'tab'			=> 'fdm-custom-fields-settings',
				),
				$custom_field_permissions
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-custom-fields-settings-section',
			'toggle',
			array(
				'id'			=> 'hide-blank-custom-fields',
				'title'			=> __( 'Hide Blank Custom Fields', 'food-and-drink-menu' ),
				'description'			=> __( 'Hide custom fields that don\'t have a value.', 'food-and-drink-menu' )
			)
		);
		$sap->add_setting(
			'food-and-drink-menu-settings',
			'fdm-custom-fields-settings-section',
			'infinite_table',
			array(
				'id'			=> 'fdm-custom-fields',
				'title'			=> __( 'Custom Fields', 'food-and-drink-menu' ),
				'add_label'		=> __( 'Add Field', 'food-and-drink-menu' ),
				'description'	=> __( 'Use this table to create custom fields that can be filled in for each menu item. This information is displayed when a specific item is viewed, either on it\'s own page or via the lightbox if you have that option enabled.<br /> Looking to add nutritional information? <span class="fdm-custom-fields-add-nutrional-information">Add it in one click</span>.', 'food-and-drink-menu' ),
				'fields'		=> array(
					'name' => array(
						'type' 		=> 'text',
						'label' 	=> 'Name',
						'required' 	=> true
					),
					'slug' => array(
						'type' 		=> 'text',
						'label' 	=> 'Slug',
						'required' 	=> true
					),
					'type' => array(
						'type' 		=> 'select',
						'label'		=> 'Type',
						'required'	=> true,
						'options' 	=> array(
							'section' 	=> 'Section',
							'text' 		=> 'Short Text',
							'textarea' 	=> 'Long Text',
							'select'	=> 'Dropdown',
							'checkbox'	=> 'Checkboxes'
						)
					),
					'values' => array(
						'type'		=> 'text',
						'label'		=> 'Values',
						'required'	=> false
					)
				)
			)
		);

		// Create filter so addons can modify the settings page or add new pages
		$sap = apply_filters( 'fdm_settings_page', $sap );

		// Backwards compatibility when the sap library went to version 2
		$sap->port_data(2);

		// Register all admin pages and settings with WordPress
		$sap->add_admin_menus();
	}

	/**
	 * Set the style of a menu or menu item before rendering
	 * @since 1.1
	 */
	public function set_style( $args ) {
		global $fdm_controller;

		if ( !$fdm_controller->settings->get_setting('fdm-style') ) {
			$args['style'] = 'base';
		} else {
			$args['style'] = $fdm_controller->settings->get_setting('fdm-style');
		}

		return $args;
	}

}
