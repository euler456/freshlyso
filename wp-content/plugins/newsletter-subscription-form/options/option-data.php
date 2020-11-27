 <?php 
 if ( ! defined( 'ABSPATH' ) ) exit;

require(dirname(__FILE__).'/themes/form-include/mailchimp/MailChimp.php');
use \DrewM\MailChimp\MailChimp;

 $wl_nls_options = weblizar_nls_get_options(); 
	/*
	* Template settings save
	*/
	if(isset($_POST['weblizar_nls_settings_save_template_option']) && isset($_POST['security']))
	{
		if ( ! wp_verify_nonce( $_POST['security'], 'subscriber_settings_save_template_option' ) ) {
		die();}
		if($_POST['weblizar_nls_settings_save_template_option'] == 1) 
		{
				foreach($_POST as  $key => $value)
				{
					$wl_nls_options[$key]=sanitize_text_field($_POST[$key]);	
				}
				
				if($_POST['select_template'])
				{
					echo esc_html($wl_nls_options['select_template']=sanitize_text_field($_POST['select_template']));
				} 
				else
				{ 
					echo esc_html($wl_nls_options['select_template']="select_template1");
				}
				update_option('weblizar_nls_options', stripslashes_deep($wl_nls_options));				
				//nls_page_layout_swap_setting();
				nls_skin_layout_setting();
		}
		if($_POST['weblizar_nls_settings_save_template_option'] == 2) 
		{
			nls_template_setting();
			//nls_page_layout_swap_setting();
		}
		if($_POST['weblizar_nls_settings_save_template_option'] == 3) 
		{
			nls_template_setting();
			nls_skin_layout_setting();
			nls_social_setting();
			nls_subscriber_form_setting();
			nls_subscriber_provider_setting();
			nls_subscriber_list_setting();
		}
	}
	
	/*
	* //Skin Layout Settings
	*/
	if(isset($_POST['weblizar_nls_settings_save_skin-layout_option']) && isset($_POST['security']))
	{	
		if ( ! wp_verify_nonce( $_POST['security'], 'subscriber_nonce_layout_option' ) ) {
		die();}

		if($_POST['weblizar_nls_settings_save_skin-layout_option'] == 1) 
		{	
			foreach($_POST as  $key => $value)
			{
				$wl_nls_options[$key]=sanitize_text_field($_POST[$key]);	
			}
		
			if(isset($_POST['custom_color_enable']))
				{  $wl_nls_options['custom_color_enable'] = sanitize_text_field( $_POST['custom_color_enable'] );
				} else {  $wl_nls_options['custom_color_enable'] = "off";	}
				
			update_option('weblizar_nls_options', stripslashes_deep($wl_nls_options));
			
		}	
		if($_POST['weblizar_nls_settings_save_skin-layout_option'] == 2) 
		{	
			nls_skin_layout_setting();

		}
	}

	/*
	* social media link Settings
	*/
	if(isset($wl_nls_options['total_Social_links'])){ $total_Social_links = $wl_nls_options['total_Social_links']; } else { $total_Social_links = 0; }
	if(isset($_POST['weblizar_nls_settings_save_social_option']) && isset($_POST['security']))
	{	
		if ( ! wp_verify_nonce( $_POST['security'], 'subscriber_settings_save_social_option' ) ) {
		die();}
		if($_POST['weblizar_nls_settings_save_social_option'] == 1) 
		{
			
			foreach($_POST as  $key => $value)
			{
				$wl_nls_options[$key]=sanitize_text_field($_POST[$key]);	
			}
						
			// Social Icons section yes or on
			if(isset($_POST['social_icons_onoff']))
			{  $wl_nls_options['social_icons_onoff'] = sanitize_text_field($_POST['social_icons_onoff']) ;
			} else {  $wl_nls_options['social_icons_onoff'] = "off";	} 			
			
			// social icons bottom section yes or on
			if(isset($_POST['social_icons_bottom_onoff']))
			{  $wl_nls_options['social_icons_bottom_onoff'] = sanitize_text_field($_POST['social_icons_bottom_onoff']) ;
			} else {  $wl_nls_options['social_icons_bottom_onoff'] = "off";	}
			
			$total_Social_links = sanitize_text_field($_POST['total_Social_links']);
			
			$social_icon_list=array();
			for($i=1; $i<= $total_Social_links; $i++)
			{	
				$social_icon   = 'social_icon_'.$i;
				$social_link   = 'social_link_'.$i;
				$social_icolor = 'social_icolor_'.$i;
				$social_icon   = sanitize_text_field($_POST[$social_icon]) ;
				$social_link   = esc_url_raw($_POST[$social_link]);
				$social_icolor = sanitize_hex_color($_POST[$social_icolor]) ;
				$social_icon_list[$i]=array('social_icon'=> $social_icon,'social_link'=> $social_link,'social_icolor'=> $social_icolor);
				
			}
			$wl_nls_options['social_icon_list']= $social_icon_list;
			$wl_nls_options['total_Social_links']= sanitize_text_field($_POST['total_Social_links']);
			if(isset($wl_nls_options['social_icons'])) {
			$wl_nls_options['social_icons']= sanitize_text_field($_POST['social_icons']);
			 }			
			if(isset($wl_nls_options['social_links'])) {
			$wl_nls_options['social_links']= sanitize_text_field($_POST['social_links']);
			 }			
			if(isset($wl_nls_options['social_icolors'])) {
			$wl_nls_options['social_icolors']= sanitize_text_field($_POST['social_icolors']);
			 }			
			update_option('weblizar_nls_options', stripslashes_deep($wl_nls_options));
	}
	if($_POST['weblizar_nls_settings_save_social_option'] == 2) 
	{	
		nls_social_setting();
	}
}  
	
	/*
	*    Subscriber Form Setting
	*/
	if(isset($_POST['weblizar_nls_settings_save_subscriber_option']) && isset($_POST['security']))
	{	
		if ( ! wp_verify_nonce( $_POST['security'], 'nonce_save_subscriber_option' ) ) {
		die();}
		if($_POST['weblizar_nls_settings_save_subscriber_option'] == 1) 
		{	
			foreach($_POST as  $key => $value)
			{
				$wl_nls_options[$key]=sanitize_text_field($_POST[$key]);	
			}	
			if(isset($_POST['subscriber_form']))
			{  $wl_nls_options['subscriber_form'] = sanitize_text_field($_POST['subscriber_form']);
			} else {  $wl_nls_options['subscriber_form'] = "off";	} 
			
			update_option('weblizar_nls_options', stripslashes_deep($wl_nls_options));
			
		}	
		if($_POST['weblizar_nls_settings_save_subscriber_option'] == 2) 
		{	
			nls_subscriber_form_setting();			
		}
	}

	if(isset($_POST['weblizar_nls_settings_save_subscriber_provider_option']) && isset($_POST['security']))
	{	
		if ( ! wp_verify_nonce( $_POST['security'], 'nonce_subscriber_provider_option' ) ) {
		die();}
		if($_POST['weblizar_nls_settings_save_subscriber_provider_option'] == 1 && isset($_POST['madmimi_api_key']))
		{	
			foreach($_POST as  $key => $value)
			{
				$wl_nls_options[$key]=sanitize_text_field($_POST[$key]);	
			}			
			
			if(isset($_POST['confirm_email_subscribe']))
				{  
					$wl_nls_options['confirm_email_subscribe'] = sanitize_text_field($_POST['confirm_email_subscribe']);
				} else { 
					$wl_nls_options['confirm_email_subscribe'] = "off";	
				} 
			update_option('weblizar_nls_options', stripslashes_deep($wl_nls_options));
			
			if(isset($_POST['madmimi_api_key']))
				{
					require(dirname(__FILE__) . '/themes/form-include/madmimi/MadMimi.class.php');
					$adminemailid = stripslashes($_POST['madmimi_username']);
					$adminapi = stripslashes($_POST['madmimi_api_key']);
					$mailer = new MadMimi($adminemailid, $adminapi); 
					$response = $mailer->Lists();
					$response = json_decode($response);
					foreach ($response as $k => $v)
					{
						$listId = $v->id ;
						$listName = $v->name;
						$weblizar_nls_madmimi_list[] = array('id' => $listId, 'name' => $listName);
					}
					update_option("weblizar_nls_madmimi_list", serialize($weblizar_nls_madmimi_list));
				}
		}
		
		elseif($_POST['weblizar_nls_settings_save_subscriber_provider_option'] == 1 && isset($_POST['mailchimp_api_key'])) 
		{	
			foreach($_POST as  $key => $value)
			{
				$wl_nls_options[$key]=sanitize_text_field($_POST[$key]);	
			}			
			
			if(isset($_POST['confirm_email_subscribe']))
			{  
				$wl_nls_options['confirm_email_subscribe'] = sanitize_text_field($_POST['confirm_email_subscribe']);
			} else { 
				$wl_nls_options['confirm_email_subscribe'] = "off";	
			} 
			update_option('weblizar_nls_options', stripslashes_deep($wl_nls_options));
			
			if(isset($_POST['mailchimp_api_key']))
			{
				$mailchimp_key  = stripslashes($_POST['mailchimp_api_key']);
				$apikey = $mailchimp_key;
				$api = new MailChimp($apikey);
				$lists = $api->get('lists');
				foreach($lists['lists'] as $list) {
					$listId = $list['id'];
					$listName = $list['name'];
					$mailchimp_key_list[] = array('id' => $listId, 'name' => $listName);
				}
				foreach($mailchimp_key_list as $List) {
					$alllistid = $List['id'];
					$alllistname = $List['name'];
					$weblizar_nls_mailchimp_list[] = array('id' => $alllistid, 'name' => $alllistname);
				}
				update_option("weblizar_nls_mailchimp_list", serialize($weblizar_nls_mailchimp_list));
			}
		}
		if($_POST['weblizar_nls_settings_save_subscriber_provider_option'] == 2) 
		{	
			nls_subscriber_provider_setting();			
		}		
	}
	
	if(isset($_POST['weblizar_nls_settings_save_subscriber_list_option']))
	{	
		if($_POST['weblizar_nls_settings_save_subscriber_list_option'] == 1) 
		{	
			foreach($_POST as  $key => $value)
			{
				$wl_nls_options[$key]=sanitize_text_field($_POST[$key]);	
			}			
			update_option('weblizar_nls_options', stripslashes_deep($wl_nls_options));
			
		}	
		if($_POST['weblizar_nls_settings_save_subscriber_list_option'] == 2) 
		{	
			nls_subscriber_list_setting();
			
		}
	}
	
/*
* Subscriber Form Data save setting 
*/
if(isset($_POST['weblizar_nls_settings_save_subscribe_form']) && isset($_POST['security'])) {
	if ( ! wp_verify_nonce( $_POST['security'], 'subscribers_options_settings' ) ) {
		die();}
	if($_POST['weblizar_nls_settings_save_subscribe_form'] == 1) {
		foreach($_POST as  $key => $value) {
			$wl_nls_options[$key]=sanitize_text_field($_POST[$key]);	
		}
		update_option('weblizar_nls_options', stripslashes_deep($wl_nls_options));
	}	
	if($_POST['weblizar_nls_settings_save_subscribe_form'] == 2) {
		nls_subscriber_list_setting();		
	}
}
	
	
/**
 * Subscriber Form Mailed to Subscribers Users as selected action and Subscriber Form Data Removed setting 
 */	
if(isset($_POST['weblizar_nls_submit_subscriber'])){
	global $wpdb;
	$table_name = $table_name = $wpdb->prefix . "nls_subscribers";	
	if($_POST['weblizar_nls_submit_subscriber'] == 1) {						
		$email_check =$wpdb->get_results( "SELECT * FROM $table_name WHERE id !=0" );
	}elseif ($_POST['weblizar_nls_submit_subscriber'] == 2){								
		$z=0;
		if(is_array($_POST['rem'])){ 
			foreach($_POST['rem'] as $subscribe_id){
				if($subscribe_id!=''){
					$email_check = $wpdb->get_results( "SELECT * FROM $table_name WHERE id = $subscribe_id" );										
				}
				$z++; 
			}
		}		
	}elseif ($_POST['weblizar_nls_submit_subscriber'] == 3){
		$email_check =$wpdb->get_results( "SELECT * FROM $table_name WHERE flag = '0'" );		
	}elseif ($_POST['weblizar_nls_submit_subscriber'] == 4){
		$email_check =$wpdb->get_results( "SELECT * FROM $table_name WHERE flag = '1'" );		
	}elseif ($_POST['weblizar_nls_submit_subscriber'] == 5){
		$email_check =$wpdb->get_results( "SELECT * FROM $table_name WHERE flag = '2'" );		
	}elseif($_POST['weblizar_nls_submit_subscriber'] == 6) {						
		global $wpdb;
		$table_name =  $wpdb->prefix . "nls_subscribers";
		$j=0;
			if (is_array($_POST['rem'])) { 
				foreach($_POST['rem'] as $subscribe_ids) {
					if($subscribe_ids!=''){
					$wpdb->delete( $table_name, array( 'id' => $subscribe_ids ), array( '%d' ) );
				}
				$j++; 
			}
		}		
	}elseif($_POST['weblizar_nls_submit_subscriber'] == 7) {
		global $wpdb;
		$table_name =  $wpdb->prefix . "nls_subscribers";
		$wpdb->query( $wpdb->prepare( "DELETE FROM $table_name WHERE flag != %d", 30 ) );
	}
	if($_POST['weblizar_nls_submit_subscriber'] == 8) {						
	global $wpdb;	
	$results = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix . "csmm_subscribers WHERE flag = '1'");
	echo "Name, Email, Date, Subscription Status, Activate-code\r\n";
	if (count($results))  {
		foreach($results as $row) {
			if($row->flag == '1') {
				$flags='Subscribed';
			} else {
				$flags='Pending';
			}
			echo esc_html($row->f_name ." ".$row->l_name .", ".$row->email .", ".$row->date .", ".$flags.",".$row->act_code ."\r\n");
		}
	}
	$filename = $file."_".date("Y-m-d_H-i",time());
	header("Content-type: application/vnd.ms-excel");
	header("Content-disposition: csv" . date("Y-m-d") . ".csv");
	header( "Content-disposition: filename=".$filename.".csv");
	print $results;
	exit;
}
	if(isset($email_check)){		
		foreach($email_check as $all_emails){
			$subscriber_email = $all_emails->email;
			$f_name = $all_emails->f_name;
			$l_name = $all_emails->l_name;
			$flag_act = $all_emails->flag;
			$current_time = current_time( 'Y-m-d h:i:s' );
			$adminemail = $wl_nls_options['wp_mail_email_id'];						 
			$plugin_url = site_url();             
			$headers = 'Content-type: text/html'."\r\n"."From:$plugin_url <$adminemail>"."\r\n".'Reply-To: '.$adminemail . "\r\n".'X-Mailer: PHP/' . phpversion();			
			$subject = sanitize_text_field( $_POST['subscriber_mail_subject'] ) .': Confirmation Subscription';
			$message = 'Hi '.$f_name.' '.$l_name.', <br/>';
			global $current_user;
			wp_get_current_user();
			$plugin_site_url = site_url();  
			$message .= sanitize_text_field($_POST['subscriber_mail_message']);
			$wp_mails= wp_mail( $subscriber_email, $subject, $message, $headers);
		}							
	}				
}
?>