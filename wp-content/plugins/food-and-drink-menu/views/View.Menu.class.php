<?php

/**
 * Class for any menu view requested on the front end.
 *
 * @since 1.1
 */
class fdmViewMenu extends fdmView {

	/**
	 * Post type to render
	 */
	public $post_type = FDM_MENU_POST_TYPE;

	/**
	 * Groups of Menu Sections to render
	 */
	public $groups = array();

	/**
	 * Default display to show or hide title in shortcode
	 */
	public $show_title = false;

	/**
	 * Default display to show or hide content in shortcode
	 */
	public $show_content = false;

	/**
	 * Title of the menu
	 */
	public $title = '';

	/**
	 * Content displayed above the menu
	 */
	public $content = '';

	/**
	 * Footer displayed below the menu
	 */
	public $footer = '';

	/**
	 * The minimum price of an item in this menu
	 */
	public $min_price = 1000000;

	/**
	 * The maximum price of an item in this menu
	 */
	public $max_price = 0;

	/**
	 * Get the post title and content to display
	 * @since 1.1.5
	 */
	public function get_menu_post() {

		$this->get_this_post();

		if ( $this->show_title || $this->show_content ) {

			if ( $this->show_title ) {
				$this->title = $this->post->post_title;
			}

			if( $this->show_content ) {
				$this->content = do_shortcode( wpautop( $this->post->post_content ) );
			}
		}

		$this->footer = do_shortcode( wpautop( get_post_meta( $this->id, 'fdm_menu_footer_content', true ) ) );
	}

	/**
	 * Define the groups for this menu and attach section ids to them
	 *
	 * @note Groups can represent columns or other groupings of sections
	 * @since 1.1
	 */
	public function get_groups() {

		$cols = array( 'one', 'two' );
		foreach ( $cols as $key => $col_num ) {
			$col = get_post_meta( $this->id, 'fdm_menu_column_' . $col_num, true );
			if ( trim( $col ) == '' ) {
				continue;
			} else {
				$this->groups[$key] = array_filter( explode( ",", $col ) );
			}
		}

		$this->groups = apply_filters( 'fdm_group_data', $this->groups );

	}

	/**
	 * Render the view and enqueue required stylesheets
	 * @since 1.1
	 */
	public function render() {
		global $fdm_controller;

		if ( !isset( $this->id ) ) {
			return;
		}

		$this->get_groups();
		if ( !count( $this->groups ) ) {
			return;
		}

		$this->get_menu_post();

		// Add any dependent stylesheets or javascript
		$this->enqueue_assets();

		// Add css classes to the menu list
		$this->classes = $this->menu_classes();

		$this->c = 0; // Columns count
		$this->s = 0; // Section count

		ob_start();
		$this->add_custom_styling();
		$template = $this->find_template( 'menu' );
		if ( $template ) {
			include( $template );
		}
		$output = ob_get_clean();

		return apply_filters( 'fdm_menu_output', $output, $this );
	}

	/**
	 * Print the filtering area of a menu
	 *
	 * @since 2.0
	 */
	public function print_filtering_options() {
		
		$filtering = new fdmViewFiltering( array( 'menu' => $this ) );

		return $filtering->render();
	}

	/**
	 * Print the filtering area of a menu
	 *
	 * @since 2.0
	 */
	public function print_sidebar() {
		
		$sidebar = new fdmViewSidebar( array('groups' => $this->groups, 'menu' => $this ) );

		return $sidebar->render();
	}

	/**
	 * Print the sidescreen that displays order details
	 *
	 * @since 2.1
	 */
	public function print_order_sidescreen() {

		$sidescreen = new fdmViewOrderingSidescreen( array() );

		return $sidescreen->render();
	}

	/**
	 * Print the order progress section
	 *
	 * @since 2.1
	 */
	public function print_order_popup() {

		$order_popup = new fdmViewOrderingPopup( array() );

		return $order_popup->render();
	}

	/**
	 * Print the order progress section
	 *
	 * @since 2.1
	 */
	public function print_order_progress() {

		$order_progress = new fdmViewOrderingProgress( array() );

		return $order_progress->render();
	}

	/**
	 * Print the sections of a menu group
	 *
	 * @note This just cleans up the template a bit
	 * @since 1.1
	 */
	public function print_group_section( $group ) {

		$output = '';

		foreach ( $group as $section_id ) {

			$section = new fdmViewSection(
				array(
					'id' => $section_id,
					'menu' => $this,
				)
			);

			$output .= $section->render();

			$this->min_price = min( $this->min_price, $section->min_price );
			$this->max_price = max( $this->max_price, $section->max_price );

			$this->s++;

		}

		return $output;
	}

	/**
	 * Get the initial menu css classes
	 * @since 1.1
	 */
	public function menu_classes( $classes = array() ) {
		global $fdm_controller;

		$classes = array_merge(
			$classes,
			array(
				'fdm-menu',
				'fdm-menu-' . $this->id,
				'fdm-menu-' . $fdm_controller->settings->get_setting('fdm-pro-style'),
				'fdm-menu-sidebar-' . $fdm_controller->settings->get_setting('fdm-sidebar'),
				'fdm-columns-' . count( $this->groups ),
				'fdm-layout-' . esc_attr( $this->layout ),
				'clearfix',
			)
		);

		return apply_filters( 'fdm_menu_classes', $classes, $this );
	}

	/**
	 * Get the menu column css classes
	 * @since 1.1
	 */
	public function column_classes( $classes = array() ) {
		$classes = array_merge(
			$classes,
			array(
				'fdm-column',
				'fdm-column-' . $this->c
			)
		);

		// Add a last column class
		if ( $this->c == ( count( $this->groups ) - 1 ) ) {
			$classes[] = 'fdm-column-last';
		}

		// Increment the column counter
		$this->c++;

		return apply_filters( 'fdm_menu_column_classes', $classes, $this );
	}


	public function has_sidebar() {
		global $fdm_controller;

		return $fdm_controller->settings->get_setting( 'fdm-sidebar' );
	}

	public function ordering_enabled() {
		global $fdm_controller;

		return $fdm_controller->settings->get_setting( 'fdm-enable-ordering' );
	}

	public function ordering_display_progress() {
		global $fdm_controller;

		if ( $fdm_controller->settings->get_setting( 'fdm-enable-ordering' ) and
			 $fdm_controller->settings->get_setting( 'fdm-enable-ordering-progress-display' ) and
			 $fdm_controller->orders->get_recent_order_id() ) {

			return true;
		}

		return false;
	}

}
