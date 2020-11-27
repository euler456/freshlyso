<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
//Default Options
function weblizar_nls_default_settings()
{
		global $current_user;
		wp_get_current_user();
		$LoggedInUserEmail1 = $current_user->user_email;
		$LoggedInUsername1 = $current_user->user_login;		
		$wl_nls_options=array(
//Template Settings Options
		'select_template' => 'select_template1',
//Skin Layout Settings
		'theme_color_schemes' => 'default_color',
		'custom_color_schemes' => '#FF2E34',
		'default_color_schemes' => '#eb5054',
		'theme_font_family' => 'Khand',
		'section_heading_size' => '30',
		'section_sub_heading_size' => '18',
		'section_description_size' => '18',
		'section_icon_size' => '30',	
		'sub_section_heading_size' => '20',
		'sub_section_sub_heading_size' => '17',
		'sub_section_description_size' => '15',
		'sub_section_icon_size' => '28',
		'social_link_size' => '14',
		
		//Social Settings
		'social_icons_onoff' =>'on',
		'social_icon_1' =>'fab fa-facebook',
		'social_icon_2' =>'fab fa-google-plus',
		'social_icon_3' =>'fab fa-linkedin',
		'social_icon_4' =>'fab fa-twitter',
		'social_icon_5' =>'fab fa-instagram',
		'social_link_1' =>'Enter Link Here',
		'social_link_2' =>'Enter Link Here',
		'social_link_3' =>'Enter Link Here',
		'social_link_4' =>'Enter Link Here',
		'social_link_5' =>'Enter Link Here',
		'social_icolor_1' => '#3b5998',	
		'social_icolor_2' => '#c92228',
		'social_icolor_3' => '#3b5998',
		'social_icolor_4' => '#00aced',
		'social_icolor_5' => '#3f729b',		
		'social_link_tab_1' =>'off',		
		'social_link_tab_2' =>'off',		
		'social_link_tab_3' =>'off',		
		'social_link_tab_4' =>'off',		
		'social_link_tab_5' =>'off',
		'total_Social_links'=>'5',
		'social_icon_list'=>'',

		//Subscriber Form Settings
		'subscriber_form' =>'on',	
		'subscriber_form_title' =>esc_html__('SUBSCRIBE TO NEWSLETTER', 'NLS_TEXT_DOMAIN' ),
		'subscriber_form_icon' => 'fas fa-envelope',
		'subscriber_form_sub_title' => esc_html__("Subscribe to our mailing list to get updates to your email inbox.",'NLS_TEXT_DOMAIN'),
		'subscriber_form_message' => esc_html__("GET MONTHLY NEWSLETTER", 'NLS_TEXT_DOMAIN' ),
		'sub_form_bg_color' =>'#333333',
		'sub_form_button_text' =>'Subscribe',
        //'subscriber_form_gdpr' =>'on',	
		'wl_gdpr_select' =>'no',
		'sub_form_button_f_name' =>'First Name',
		'sub_form_button_l_name' =>'Last Name',
		'sub_form_subscribe_title' =>'Email',	
		'sub_form_button_ht_color' =>'#333333',
		'sub_form_button_hb_color' =>'#FFFFFF',
		'sub_form_ph_text_color' =>'',
		'user_sets' => '$user_sets_all',		
		'sub_form_subscribe_seuccess_message' =>  esc_html__( 'Thank you! We will be back with the quote.', 'NLS_TEXT_DOMAIN' ),
		'sub_form_subscribe_invalid_message' => esc_html__('You have already subscribed.', 'NLS_TEXT_DOMAIN' ),		
		'subscriber_msg_body' => '',
		'sub_form_subscribe_confirm_success_message' => esc_html__('Thank You!!! Subscription has been confirmed. We will notify when the site is live.', 'NLS_TEXT_DOMAIN' ),	
		'sub_form_subscribe_already_confirm_message' =>  esc_html__('You subscription is already active. We will notify when the site is live.', 'NLS_TEXT_DOMAIN' ),
		'sub_form_invalid_confirmation_message' => esc_html__('Error: Invalid subscription details.', 'NLS_TEXT_DOMAIN' ),
	
//Subscriber Form Option Settings
		'subscribe_select' =>'wp_mail',
		'wp_mail_email_id' =>$LoggedInUserEmail1,
		'php_user_name' =>$LoggedInUsername1,
		'php_user_email_id' =>$LoggedInUserEmail1,
		'confirm_email_subscribe' => 'off',
		'mailchimp_api_key'=> '',
		'mailchimp_list_id'=>'',
		'madmimi_username' =>'',
		'madmimi_api_key' =>'',
		'madmimi_list_option' =>'',
		
//Subscriber List Options Setting
		'subscriber_users_mail_option' =>'all_users',
		'subscriber_mail_subject' =>'',
		'subscriber_mail_message' =>'',
		);
	return apply_filters( 'weblizar_nls_options', $wl_nls_options );
}

// Options API
function weblizar_nls_get_options() {
    // Options API Settings
    return wp_parse_args( get_option( 'weblizar_nls_options', array() ), weblizar_nls_default_settings() );    
}

//free Template Options Setting
function nls_template_setting(){ 	
	$wl_nls_options = get_option('weblizar_nls_options');	
	$wl_nls_options['select_template']= 'select_template1';	
	
update_option('weblizar_nls_options', $wl_nls_options);
}
//Skin Layout Settings
function nls_skin_layout_setting(){
	$wl_nls_options = get_option('weblizar_nls_options');
	$wl_nls_options['theme_color_schemes']= 'default_color';
	$wl_nls_options['custom_color_schemes']= '#FF2E34';
	$wl_nls_options['default_color_schemes']= '#eb5054';
	$wl_nls_options['theme_font_family']= 'Khand';
	$wl_nls_options['section_heading_size']= '30';
	$wl_nls_options['section_sub_heading_size']= '18';
	$wl_nls_options['section_description_size']= '18';
	$wl_nls_options['section_icon_size']= '30';
	$wl_nls_options['social_link_size']= '14';
	
update_option('weblizar_nls_options', $wl_nls_options);
}

//Social Options Setting
function nls_social_setting(){
	$wl_nls_options = get_option('weblizar_nls_options');
	$wl_nls_options['social_icons_bottom_onoff']= 'on';
	$wl_nls_options['social_icon_1']= 'fab fa-facebook';	
	$wl_nls_options['social_icon_2']= 'fab fa-google-plus';
	$wl_nls_options['social_icon_3']= 'fab fa-linkedin';
	$wl_nls_options['social_icon_4']= 'fab fa-twitter';
	$wl_nls_options['social_icon_5']= 'fab fa-instagram';
	$wl_nls_options['social_icolor_1']= '#3b5998';	
	$wl_nls_options['social_icolor_2']= '#c92228';
	$wl_nls_options['social_icolor_3']= '#3b5998';
	$wl_nls_options['social_icolor_4']= '#00aced';	
	$wl_nls_options['social_icolor_5']= '#3f729b';
	$wl_nls_options['social_link_tab_1']= 'off';
	$wl_nls_options['social_link_tab_2']= 'off';
	$wl_nls_options['social_link_tab_3']= 'off';
	$wl_nls_options['social_link_tab_4']= 'off';
	$wl_nls_options['social_link_tab_5']= 'off';
	$wl_nls_options['social_link_1']= 'Enter Link Here';
	$wl_nls_options['social_link_2']= 'Enter Link Here';
	$wl_nls_options['social_link_3']= 'Enter Link Here';
	$wl_nls_options['social_link_4']= 'Enter Link Here';
	$wl_nls_options['social_link_5']= 'Enter Link Here';
	$wl_nls_options['social_icons_onoff']= 'on';
	$wl_nls_options['total_Social_links']='5';	
	$wl_nls_options['social_icon_list']='';

update_option('weblizar_nls_options', $wl_nls_options);
}
//Subscriber Form Options Setting
function nls_subscriber_form_setting(){	
	$wl_nls_options = get_option('weblizar_nls_options');
	$wl_nls_options['subscriber_form']= 'on';
	//$wl_nls_options['subscriber_form_gdpr']= 'on';
	$wl_nls_options['subscriber_form_title']=esc_html__('SUBSCRIBE TO NEWSLETTER', 'NLS_TEXT_DOMAIN' );
	$wl_nls_options['subscriber_form_icon']= 'fas fa-envelope';
	$wl_nls_options['subscriber_form_sub_title']= esc_html__('Subscribe to our mailing list to get updates to your email inbox.', 'NLS_TEXT_DOMAIN' );
	$wl_nls_options['subscriber_form_message']= esc_html__("GET MONTHLY NEWSLETTER", 'NLS_TEXT_DOMAIN' ); 
	$wl_nls_options['sub_form_button_ht_color']= '#333333';
	$wl_nls_options['sub_form_button_hb_color']= '#FFFFFF';
	$wl_nls_options['wl_gdpr_select']= 'no';
	$wl_nls_options['sub_form_button_f_name']= 'First Name';
	$wl_nls_options['sub_form_button_l_name']= 'Last Name';
	$wl_nls_options['sub_form_button_text']= 'Subscribe';
	$wl_nls_options['sub_form_subscribe_title']= 'Email';
	$wl_nls_options['sub_form_subscribe_seuccess_message']=  esc_html__( 'Thank you! We will be back with the quote.', 'NLS_TEXT_DOMAIN' );
	$wl_nls_options['sub_form_subscribe_invalid_message']= esc_html__('You have already subscribed.', 'NLS_TEXT_DOMAIN' );		
	$wl_nls_options['subscriber_msg_body']= '';
	$wl_nls_options['sub_form_subscribe_confirm_success_message']= esc_html__('Thank You!!! Subscription has been confirmed. We will notify when the site is live.', 'NLS_TEXT_DOMAIN' );		
	$wl_nls_options['sub_form_subscribe_already_confirm_message']=  esc_html__('You subscription is already active. We will notify when the site is live.', 'NLS_TEXT_DOMAIN' );
	$wl_nls_options['sub_form_invalid_confirmation_message']= esc_html__('Error: Invalid subscription details.', 'NLS_TEXT_DOMAIN' );
	
update_option('weblizar_nls_options', $wl_nls_options);
}	
//Subscriber Form Provider Options Setting
function nls_subscriber_provider_setting(){	
	global $current_user;
		wp_get_current_user();
		$LoggedInUserEmail1 = $current_user->user_email;
		$LoggedInUsername1 = $current_user->user_login;
	$wl_nls_options = get_option('weblizar_nls_options');		
	$wl_nls_options['subscribe_select']= 'wp_mail';
	$wl_nls_options['wp_mail_email_id']= $LoggedInUserEmail1;
	$wl_nls_options['php_user_name']=$LoggedInUsername1;		
	$wl_nls_options['php_user_email_id']= $LoggedInUserEmail1;
	$wl_nls_options['confirm_email_subscribe']= 'off';
	$wl_nls_options['mailchimp_api_key'] = '';
	$wl_nls_options['mailchimp_list_id'] = '';
	$wl_nls_options['madmimi_username'] = '';
	$wl_nls_options['madmimi_api_key'] = '';
	$wl_nls_options['madmimi_list_option'] = '';
update_option('weblizar_nls_options', $wl_nls_options);
}
//Subscriber List Options Setting
function nls_subscriber_list_setting(){	
	$wl_nls_options = get_option('weblizar_nls_options');	
	$wl_nls_options['user_sets']= '$user_sets_all';
	$wl_rcsm_options['subscriber_users_mail_option']= 'all_users';
	$wl_rcsm_options['subscriber_mail_subject']= '';
	$wl_rcsm_options['subscriber_mail_message']= '';
	
update_option('weblizar_nls_options', $wl_nls_options);
}