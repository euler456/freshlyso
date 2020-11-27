<?php

/**
 * Plugin Name: Checkout Pick Up Field for WooCommerce
 * Description: Customize WooCommerce checkout field(date, time slot).
 * Author:      viktord
 * Version:     1.0.0
 * Author URI:  https://codecanyon.net/user/viktord
 * WC requires at least: 3.0.0
 * WC tested up to: 3.7.0
 */


if (!defined('ABSPATH')) exit;

/**
 * Add the plugin config menu
 */

add_action('admin_init', 'pick_up_checkout_plugin_register_settings');

function pick_up_checkout_plugin_register_settings()
{
    add_option('pick_up_checkout_plugin_is_optional', 'true');
    register_setting('pick_up_checkout_plugin_options_group', 'pick_up_checkout_plugin_is_optional');
}

add_action('admin_menu', 'pick_up_checkout_plugin_menu');

function pick_up_checkout_plugin_menu()
{
    add_options_page('Pick Up Checkout Plugin Options', 'Pick Up Checkout', 'manage_options', 'pick_up_checkout_plugin', 'pick_up_checkout_plugin_options');
}

function pick_up_checkout_plugin_options()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    ?>
    <div>

        <p>Pick Up Checkout:</p>

        <form method="post" action="options.php">

            <?php settings_fields('pick_up_checkout_plugin_options_group'); ?>

            <table>
                <tr valign="top">
                    <th scope="row"><label for="pick_up_checkout_plugin_is_optional">Is optional fields</label></th>
                    <td><input name="pick_up_checkout_plugin_is_optional" type="checkbox"
                               id="pick_up_checkout_plugin_is_optional"
                               value="true" <?php checked('true', get_option('pick_up_checkout_plugin_is_optional', 'true')); ?> />
                    </td>
                </tr>
            </table>


            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

/**
 * Add the field to the checkout
 */
add_action('woocommerce_after_order_notes', 'pick_up_checkout_field');

function pick_up_checkout_field($checkout)
{

    echo '<div id="pick_up_checkout_field"><h2>' . __('Order Pick Up') . '</h2>';

    woocommerce_form_field('order_pick_up_date', array(
        'type' => 'date',
        'class' => array('order_pick_up_date-class form-row-wide'),
        'label' => __('Order Pick Up Date'),
        'required' => get_option('pick_up_checkout_plugin_is_optional', 'true') !== 'true',
    ), $checkout->get_value('order_pick_up_date'));

    woocommerce_form_field('order_pick_up_time', array(
        'type' => 'select',
        'class' => array('order_pick_up_time-class form-row-wide'),
        'label' => __('Pick Up Time Slots'),
        'required' => get_option('pick_up_checkout_plugin_is_optional', 'true') !== 'true',
        'options' => array(
            '' => __(''),
            '9AMto12AM' => __('9 to 12 AM'),
            '12AMto3PM' => __('12 AM to 3 PM'),
            '4PMto7PM' => __('4 to 7 PM')
        ),
        'default' => '',
    ), $checkout->get_value('order_pick_up_time'));

    echo '</div>';

}

/**
 * Process the checkout
 */
add_action('woocommerce_checkout_process', 'pick_up_checkout_field_process');

function pick_up_checkout_field_process()
{
    if (get_option('pick_up_checkout_plugin_is_optional', 'true') === 'true') {
        return;
    }
    // Check if set, if its not set add an error.
    if (!$_POST['order_pick_up_date'])
        wc_add_notice(__('Please enter something into Order Pick Up Date field.'), 'error');

    if (!$_POST['order_pick_up_time'])
        wc_add_notice(__('Please enter something into Pick Up Time Slots field.'), 'error');
}

/**
 * Update the order meta with field value
 */
add_action('woocommerce_checkout_update_order_meta', 'pick_up_checkout_field_update_order_meta');

function pick_up_checkout_field_update_order_meta($order_id)
{
    if (!empty($_POST['order_pick_up_date'])) {
        update_post_meta($order_id, 'order_pick_up_date', sanitize_text_field($_POST['order_pick_up_date']));
    }
    if (!empty($_POST['order_pick_up_time'])) {
        update_post_meta($order_id, 'order_pick_up_time', sanitize_text_field($_POST['order_pick_up_time']));
    }
}

/**
 * Display field value on the order edit page
 */
add_action('woocommerce_admin_order_data_after_billing_address', 'pick_up_checkout_field_display_admin_order_meta', 10, 1);

function pick_up_checkout_field_display_admin_order_meta($order)
{
    echo '<p><strong>' . __('Order Pick Up Date') . ':</strong> ' . get_post_meta($order->id, 'order_pick_up_date', true) . '</p>';
    echo '<p><strong>' . __('Pick Up Time Slots') . ':</strong> ' . get_post_meta($order->id, 'order_pick_up_time', true) . '</p>';
}

/**
 * Display field value on the order and thankyou page
 */

add_action('woocommerce_thankyou', 'pick_up_checkout_view_order_and_thankyou_page', 20);
add_action('woocommerce_view_order', 'pick_up_checkout_view_order_and_thankyou_page', 20);

function pick_up_checkout_view_order_and_thankyou_page($order_id)
{
    echo '<p><strong>' . __('Order Pick Up Date') . ':</strong> ' . get_post_meta($order_id, 'order_pick_up_date', true) . '</p>';
    echo '<p><strong>' . __('Pick Up Time Slots') . ':</strong> ' . get_post_meta($order_id, 'order_pick_up_time', true) . '</p>';
}

/**
 * Utils
 */

function pick_up_checkout_log($message)
{
    $plugin_log = plugin_dir_path(__FILE__) . '/debug.log';
    $message = $message . PHP_EOL;
    error_log($message, 3, $plugin_log);
}