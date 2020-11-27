<?php
/*
 * Plugin Name:       Newsletter Subscription Form
 * Description:       Newsletter Subscription Form for WordPress is the ultimate lead generation, customer acquisition and email marketing plugin to grow and engage your mailing list and visitors.
 * Version: 		  1.3.3
 * Author: 			  Weblizar
 * Text Domain: 	  newsletter-subscription-form
 * Domain Path: 	  /options/languages
 * Author URI:        https://weblizar.com/
 * Plugin URI:        https://weblizar.com/plugins/newsletter-subscription-form/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Copyright 2016-19  Weblizar (email : lizarweb@gmail.com, twitter : @weblizar)
 */

/**
 * Default Constants
 */
define('NLS_TEXT_DOMAIN', 'newsletter-subscription-form'); // Your textdomain
define('NLS_PLUGIN_NAME', esc_html__('Newsletter Subscription Form', 'NLS_TEXT_DOMAIN')); // Plugin Name shows up on the admin settings screen.
define("WEBLIZAR_NLS_PLUGIN_URL", plugin_dir_url(__FILE__));
include 'options/option-panel.php';
include 'options/default-options.php';

add_action('plugins_loaded', 'NLS_Language_Translater');
function NLS_Language_Translater()
{
    load_plugin_textdomain('NLS_TEXT_DOMAIN', false, dirname(plugin_basename(__FILE__)).'/languages');
}

/**
 * Function to create table for subscriber
 */
function nls_callback_plugin_subscriber()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'nls_subscribers';
    $charset_collate = $wpdb->get_charset_collate();

    /* Add batch_id column if not exists to students table */
    $col = $wpdb->get_results("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '" . $table_name . "' AND TABLE_NAME = '{$wpdb->prefix}". $table_name ."' AND COLUMN_NAME = 'form_type'");

    //$col = $wpdb->get_results("SELECT form_type FROM ".$table_name);
    $col2 = $wpdb->get_var("SHOW TABLES LIKE '$table_name'");
    if ($col2 && !$col) {
        $sql = $wpdb->query("ALTER TABLE $table_name ADD deact_code VARCHAR(255) NOT NULL");
        $sql .= $wpdb->query("ALTER TABLE $table_name ADD form_type VARCHAR(255) NOT NULL");
    } else {
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
	id int NOT NULL AUTO_INCREMENT,
	f_name VARCHAR(255) NOT NULL,
	l_name VARCHAR(255) NOT NULL,
	terms VARCHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL,
	date timestamp,
	act_code VARCHAR(255) NOT NULL,
	deact_code VARCHAR(255) NOT NULL,
	extra_detail text,
	form_type VARCHAR(255) NOT NULL,
	flag int,
	UNIQUE KEY id (id)
	)$charset_collate;";
    }
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'nls_callback_plugin_subscriber');

/**
 * Function to redirect to maintenance mode page
 */
function nls_template_redirect_enqueue_script()
{
    wp_deregister_script('jquery');
    wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js', false, null);
    wp_enqueue_script('jquery');
    wp_enqueue_style('form-style', plugin_dir_url(__FILE__). 'options/css/form-style.css');
    wp_enqueue_script('form_js', plugin_dir_url(__FILE__).'options/js/form_js.js');
}

add_action('wp_enqueue_scripts', 'nls_template_redirect_enqueue_script');
function nls_maintenance_mode_template_redirect()
{
    if (isset($_GET['act_code'])) {
        $act_code = $_GET['act_code'];
        $email = $_GET['email'];
        $wl_wnlsp_options = get_option('weblizar_wnlsp_options');
        //search & match the email & activation code
        global $wpdb;
        $table_name = $wpdb->prefix . 'nls_subscribers';
        $user_search_result = $wpdb->get_row("SELECT * FROM `$table_name` WHERE `email` LIKE '$email' AND `act_code` LIKE '$act_code'");
        if (count($user_search_result)) {
            // check user is already subscribed
            if ($user_search_result->flag == 1) {
                get_header();
                echo '<div class="main_div1"><p class="subscribe-messages1">'.esc_html($wl_wnlsp_options['sub_form_subscribe_already_confirm_message']).'<span class="close_message1">'.esc_html__('X', 'NLS_TEXT_DOMAIN').'</span></p></div>';
            } else {
                // update user subscription active
                if ($wpdb->query("UPDATE `$table_name` SET `flag` = '1' WHERE `email` = '$email'")) {
                    get_header();
                    echo '<div class="main_div1"><p class="subscribe-messages1">'.esc_html($wl_wnlsp_options['sub_form_subscribe_confirm_success_message']).'<span class="close_message1">'.esc_html__('X', 'NLS_TEXT_DOMAIN').'</span></p></div>';
                }
                //require_once('wnlsp-options/themes/form-include/confirmation-mail-from.php');
                require_once('options/themes/form-include/confirmation-mail-from.php');
            }
        } else {
            get_header();
            echo '<div class="main_div1"><p class="subscribe-messages1">'.esc_html($wl_wnlsp_options['sub_form_invalid_confirmation_message']).'<span class="close_message1">'.esc_html__('X', 'NLS_TEXT_DOMAIN').'</span></p></div>';
        }
    }
}
add_action('template_redirect', 'nls_maintenance_mode_template_redirect');

function weblizar_nls_activation()
{
    $weblizar_nls_default_settings = weblizar_nls_default_settings();
    $weblizar_nls_saved_theme_settings = get_option('weblizar_nls_options'); // get existing option data
    if ($weblizar_nls_saved_theme_settings) {
        $weblizar_nls_saved_theme_settings = array_merge($weblizar_nls_default_settings, $weblizar_nls_saved_theme_settings);
        update_option('weblizar_nls_options', $weblizar_nls_saved_theme_settings);	// Set existing and new option data
    } else {
        add_option('weblizar_nls_options', $weblizar_nls_default_settings);  // set New option data

        /*mailchimp list display Settings  data post function	**/
        $weblizar_nls_mailchimp_allLists = "";
        add_option("weblizar_nls_mailchimp_key", serialize($weblizar_nls_mailchimp_allLists));

        /*Madmimi display Settings  data post function	**/
        $weblizar_nls_madmimi = "";
        add_option("weblizar_nls_madmimi_list", serialize($weblizar_nls_madmimi));
    }
}

register_activation_hook(__FILE__, 'weblizar_nls_activation');

// Do redirect when Plugin activate

function nls_nht_plugin_activate()
{
    add_option('nls_nht_plugin_do_activation_redirect', true);
}
function nls_nht_plugin_redirect()
{
    if (get_option('nls_nht_plugin_do_activation_redirect', false)) {
        delete_option('nls_nht_plugin_do_activation_redirect');
        if (!isset($_GET['activate-multi'])) {
            wp_redirect("admin.php?page=nls-weblizar");
        }
    }
}
register_activation_hook(__FILE__, 'nls_nht_plugin_activate');
add_action('admin_init', 'nls_nht_plugin_redirect');

// Add settings link on plugin page
function nls_settings_link($links)
{
    $nls_settings_link = '<a href="admin.php?page=nls-weblizar">'.esc_html__('Settings', 'NLS_TEXT_DOMAIN').'</a>';
    $nls_pro_link = '<a style="color: #ea5a21;font-weight: 700;" href="https://weblizar.com/plugins/newsletter-subscription-form-pro/" target="_blank">'.esc_html('Get Premium', 'NLS_TEXT_DOMAIN').'</a>';
    array_unshift($links, $nls_pro_link, $nls_settings_link);
    return $links;
}
$nls_plugin_name = plugin_basename(__FILE__);
add_filter("plugin_action_links_$nls_plugin_name", 'nls_settings_link');