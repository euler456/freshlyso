<?php
    if (! defined('ABSPATH')) {
        exit;
    }
    $wl_nls_options = get_option('weblizar_nls_options');
    //$widget_nlf_form_widget = get_option('widget_nlf_form_widget');
    wp_enqueue_style('weblizar-nls-fontawesome', plugin_dir_url(__FILE__).'../css/all.min.css');
    wp_enqueue_style('weblizar-nls-style-1', plugin_dir_url(__FILE__).'css/style-1.css', '', true, $media = 'all');
    wp_enqueue_style('weblizar-nls-font-family', '//fonts.googleapis.com/css?family=' . esc_attr($wl_nls_options['theme_font_family']));
    wp_enqueue_script('jquery');
    wp_enqueue_script('weblizar-nls-main', plugin_dir_url(__FILE__).'/js/main.js');

    require_once 'css/custom-css-1.php';
    
    require_once 'form-include/subscriber-from-settings.php';
    $r_code	= rand(0, 1000);
    ?>
<div id="newsletter_form1" class="newsletter-api-form-theme1">
	<div class="space newsletter_form1">
		<?php
    if ($wl_nls_options['social_icons_onoff']=='on') { ?>
		<div class="newsletter_form1_social-icons">
			<ul class="newsletter_form1_social animated fadeInDownBig">
				<?php for ($i=1; $i<=$wl_nls_options['total_Social_links']; $i++) {
        if ($wl_nls_options['social_icon_'.$i]!='') {
            $social_color = $wl_nls_options['social_icolor_'.$i]; ?>
				<li><a target="<?php if ($wl_nls_options['social_link_tab_'.$i]=='on') {
                echo esc_attr('_blank');
            } ?>"
						href="<?php echo esc_url($wl_nls_options['social_link_'.$i]); ?>"><i
							style="color:<?php echo esc_html($social_color); ?>!important;"
							class="<?php echo esc_attr($wl_nls_options['social_icon_'.$i]); ?> newsletter_form1_icon"></i></a>
				</li>
				<?php
        }
    } ?>
			</ul>
		</div>
		<?php } ?>
		<h2 class="newsletter_form1_section-heading" data-sr="enter top"><?php echo esc_html($wl_nls_options['subscriber_form_title']);?>
		</h2>
		<h4 class="newsletter_form1_section-sub_heading" data-sr="enter top"><?php echo esc_html($wl_nls_options['subscriber_form_sub_title']);?>
		</h4>
		<?php if ($wl_nls_options['subscriber_form_icon'] == null) { ?><span
			class="newsletter_form1_section-icon"><span
				class="<?php echo esc_attr($wl_nls_options['subscriber_form_icon']);?>  icon"></span></span>
		<?php } else { ?>
		<span class="newsletter_form1_section-icon"> .......... <span
				class="<?php echo esc_attr($wl_nls_options['subscriber_form_icon']);?>  newsletter_form1_icon"></span>
			.......... </span>
		<?php } ?>
		<p class="newsletter_form1_section-description"><?php echo esc_html($wl_nls_options['subscriber_form_message']);?>
		</p>

		<?php if ($wl_nls_options['subscribe_select']=='wp_mail') {
        $js = '';
        $js .= 'function validateForm11_'.esc_attr($r_code).'(){';
        $js .= '	var x = document.forms[
						 "subscriber-form_'. esc_attr($r_code).'"][
						 "subscribe_email"
						 ].value;';
        $js .= '	var atpos = x.indexOf("@");';
        $js .= '	var dotpos = x.lastIndexOf(".");';
        $js .= '	var error_msg = ".sub_error_msg_'.esc_attr($r_code).'";';
        $js .= '	if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {';
        $js .= '		jQuery(error_msg).show();';
        $js .= '		jQuery(error_msg).fadeOut(3000);';
        $js .= '		return false;';
        $js .= '	}';
        $js .= '}';
        wp_add_inline_script('weblizar-nls-main', $js); ?>



		<form method="post" action=""
			onsubmit="if(document.getElementById('terms').checked) { return true; } else { return true; }"
			class="subscriber-form"
			name="subscriber-form_<?php echo esc_attr($r_code); ?>">
			<?php $nonce = wp_create_nonce('subscriber_nonce_field'); ?>
			<input type="hidden" name="security"
				value="<?php echo esc_attr($nonce); ?>">
			<div class="form-group" data-sr="enter bottom over 1s and move 110px wait 0.5s">
				<div id="error_email2" class="validation_error error_email"></div>
				<?php if ($wl_nls_options['subscriber_form']=='on') { ?>
				<input type="text" name="f_name" id="f_sub_name" class="form-control subscribe-input-layouts"
					placeholder="<?php if ($wl_nls_options['sub_form_button_f_name']) {
            echo esc_attr($wl_nls_options['sub_form_button_f_name']);
        } else {
            echo esc_attr("First Name");
        }?>" required='required'>
				<input type="text" name="l_name" id="l_sub_name" class="form-control subscribe-input-layouts"
					placeholder="<?php if ($wl_nls_options['sub_form_button_l_name']) {
            echo esc_attr($wl_nls_options['sub_form_button_l_name']);
        } else {
            echo esc_attr("Last Name");
        }?>" required='required'>
				<?php } ?>
				<input type="email" name="subscribe_email" id="edmm-sub-email1"
					class="form-control subscribe-input-layout2" placeholder="<?php if ($wl_nls_options['sub_form_subscribe_title']) {
            echo esc_attr($wl_nls_options['sub_form_subscribe_title']);
        } else {
            echo esc_attr("Email");
        } ?>">
				<!--<input type="hidden" name="email_type" id="edmm-sub-email1"  class="form-control subscribe-input-layout2" value="<?php //echo "wp_mail"?>">
				-->
				<span
					class="sub_error_msg_<?php echo esc_attr($r_code); ?>"
					style="display:none; color: red; width: 100%; float: left; margin-bottom: 10px; font-size: 14px;"><span
						style="color:red; font-size: 14px;"><?php esc_html_e('*', 'NLS_TEXT_DOMAIN'); ?></span><?php esc_html_e("Invalid email address.", "NLS_TEXT_DOMAIN"); ?></span>
				<input type="hidden" name="subscribe_type2" id="subscribe_type2"
					class="form-control subscribe-input-layout2"
					value="<?php echo esc_attr("subscribe-message_".$r_code); ?>">
				<br>

				<?php if ($wl_nls_options['wl_gdpr_select']=='yes') { ?>
				<input type="checkbox" name="terms" id="terms" value="yes"><?php esc_html_e('I Agree with GDPR compliant Terms & Coditions ', 'NLS_TEXT_DOMAIN');?>
				<?php } ?>
				<?php
            /**
             * Creating a nonce field
             */
            ?>
				<div class="form-group-button">
					<button name="submit_subscriber" id="submit" class="subscriber_submit btn" id="submit"
						type="submit">
						<?php if ($wl_nls_options['sub_form_button_text']) {
                echo esc_html($wl_nls_options['sub_form_button_text']);
            } else {
                echo esc_attr("Subscribe");
            } ?>
					</button>
				</div>
			</div>
		</form>
		<div class="newsletter_form_subscribe newsletter_form1_subscribe-message1">
			<?php
    // Session messages
    if (isset($_SESSION['mail_sent'])) {
        echo '<div class="main_div"><p class="subscribe-messages">'.esc_html($_SESSION['mail_sent']).'<span class="close_message">'.esc_html__('X', 'NLS_TEXT_DOMAIN').'</span></p></div>';
        unset($_SESSION['mail_sent']);
    }
        if (isset($_SESSION['mail_sent_msg'])) {
            echo '<div class="main_div"><p class="subscribe-messages">'.esc_html($_SESSION['mail_sent_msg']).'<span class="close_message">'.esc_html__('X', 'NLS_TEXT_DOMAIN').'</span></p></div>';
            unset($_SESSION['mail_sent_msg']);
        }
        if (isset($_SESSION['subscribe_msg'])) {
            echo '<div class="main_div"><p class="subscribe-messages">'.esc_html($_SESSION['subscribe_msg']).'<span class="close_message">'.esc_html__('X', 'NLS_TEXT_DOMAIN').'</span></p></div>';
            unset($_SESSION['subscribe_msg']);
        } ?>
		</div>
		<?php
            $js = '';
        $js .= 'jQuery(".newsletter_form1_subscribe-message1 .subscribe-messages .close_message").click(function() {';
        $js .= '	jQuery(".newsletter_form1_subscribe-message1 .main_div").fadeOut(500);';
        $js .= '	jQuery(".newsletter_form1_subscribe-message1 .subscribe-messages").fadeOut(500);';
        $js .= '	clearTimeout(timer)';
        $js .= '});';
        $js .= 'var timer;';
        $js .= 'jQuery(".newsletter_form1_subscribe-message1 .subscribe-messages").show();';
        $js .= 'jQuery(".newsletter_form1_subscribe-message1 .main_div").show();';
        $js .= 'timer = setTimeout(function() {';
        $js .= '	jQuery(".newsletter_form1_subscribe-message1 .main_div").fadeOut(500);
						jQuery(".newsletter_form1_subscribe-message1 .subscribe-messages").fadeOut(500);
					}, 5000);';
        $js .= '';
        $js .= '';
        $js .= '';
        wp_add_inline_script('weblizar-nls-main', $js); ?>
		<?php
    }  ?>

		<?php if ($wl_nls_options['subscribe_select']=='madmimi' || $wl_nls_options['subscribe_select']=='mailchimp') {
        $js = '';
        $js .= 'function validateForm12_'.esc_attr($r_code).'(){';
        $js .= '	var x = document.forms[
							"php_subscriber-form_'. esc_attr($r_code).'"][
							"subscribe_email"
							].value;';
        $js .= '	var atpos = x.indexOf("@");';
        $js .= '	var dotpos = x.lastIndexOf(".");';
        $js .= '	var error_msg = ".sub_error_msg_'.esc_attr($r_code).'";';
        $js .= '	if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {';
        $js .= '		jQuery(error_msg).show();';
        $js .= '		jQuery(error_msg).fadeOut(3000);';
        $js .= '		return false;';
        $js .= '	}';
        $js .= '}';
        wp_add_inline_script('weblizar-nls-main', $js); ?>
		<div id="error_email2" class="validation_error error_email"></div>
		<form method="post" action=""
			onsubmit="if(document.getElementById('terms').checked) { return true; } else { return true; }"
			class="php_subscriber-form"
			name="php_subscriber-form_<?php echo esc_attr($r_code); ?>">
			<?php $nonce = wp_create_nonce('php_subscriber_nonce_field'); ?>
			<input type="hidden" name="security"
				value="<?php echo esc_attr($nonce); ?>">
			<div class="form-group" data-sr="enter bottom over 1s and move 110px wait 0.5s">
				<div id="error_email2" class="validation_error error_email"></div>
				<?php if ($wl_nls_options['subscriber_form']=='on') { ?>
				<input type="text" name="f_name" id="f_sub_name" class="form-control subscribe-input-layouts"
					placeholder="<?php if ($wl_nls_options['sub_form_button_f_name']) {
            echo esc_attr($wl_nls_options['sub_form_button_f_name']);
        } else {
            echo esc_attr("First Name");
        }?>" required='required'>
				<input type="text" name="l_name" id="l_sub_name" class="form-control subscribe-input-layouts"
					placeholder="<?php if ($wl_nls_options['sub_form_button_l_name']) {
            echo esc_attr($wl_nls_options['sub_form_button_l_name']);
        } else {
            echo esc_attr("Last Name");
        }?>" required='required'>
				<?php } ?>
				<input type="email" name="subscribe_email" id="edmm-sub-email2"
					class="form-control subscribe-input-layout1 s2email"
					placeholder="<?php echo esc_attr($wl_nls_options['sub_form_subscribe_title']); ?>">
				<span
					class="sub_error_msg_<?php echo esc_attr($r_code); ?>"
					style="display:none; color:red; width:100%; float:left; margin-bottom:10px; font-size:14px;"><span
						style="color:red; font-size: 14px;"><?php esc_html_e('*', 'NLS_TEXT_DOMAIN'); ?></span><?php esc_html_e('Invalid email address.', 'NLS_TEXT_DOMAIN'); ?></span>
				<input type="hidden" name="subscribe_type2" id="subscribe_type2"
					class="form-control subscribe-input-layout2"
					value="<?php echo esc_attr("subscribe-message_".$r_code); ?>">

				<?php if ($wl_nls_options['wl_gdpr_select']=='yes') { ?>
				<input type="checkbox" name="terms" id="terms" value="yes"> <?php esc_html_e('I Agree with GDPR compliant Terms & Coditions', 'NLS_TEXT_DOMAIN');?>
				<?php } ?>
				<div class="form-group-button">
					<button name="php_submit_subscriber" class="subscriber_submit sub-submit btn" type="submit"><?php echo esc_html($wl_nls_options['sub_form_button_text']); ?></button>
				</div>
			</div>
		</form>
		<div class="newsletter_form1_subscribe-message2">
			<?php
        if (isset($_SESSION['mail_sent'])) {
            echo '<div style="position:fixed;z-index:99999;background-color:rgba(0,0,0,0.6);top:0;bottom:0;   left:0;right:0;display:none;" class="main_div"><p style="border:#fff solid 2px;border-radius:15px; box-shadow: 1px 1px 10px #fff;  color:#fff; left: 40%;position: absolute;top: 40%;background:#000;padding:40px;font-size:20px;
display:none;" class="subscribe-messages">'.esc_html($_SESSION['mail_sent']).'</p></div>';
            unset($_SESSION['mail_sent']);
        }
        if (isset($_SESSION['mail_sent_msg'])) {
            echo '<div style="position:fixed;z-index:99999;background-color:rgba(0,0,0,0.6);top:0;bottom:0;   left:0;right:0;display:none;" class="main_div"><p style="left: 40%;position: absolute;top: 40%;background:#000;padding:40px;border:#fff solid 2px;border-radius:15px; box-shadow: 1px 1px 10px #fff;  color:#fff;font-size:20px;
display:none;" class="subscribe-messages">'.esc_html($_SESSION['mail_sent_msg']).'</p></div>';
            unset($_SESSION['mail_sent_msg']);
        }
        if (isset($_SESSION['subscribe_msg'])) {
            echo '<div style="position:fixed;z-index:99999;background-color:rgba(0,0,0,0.6);top:0;bottom:0;   left:0;right:0;display:none;" class="main_div"><p style="border:#fff solid 2px;border-radius:15px; box-shadow: 1px 1px 10px #fff;  color:#fff; left: 40%;position: absolute;top: 40%;background:#000;padding:40px;font-size:20px;
display:none;" class="subscribe-messages">'.esc_html($_SESSION['subscribe_msg']).'</p></div>';
            unset($_SESSION['subscribe_msg']);
        }
        // subscription activate logic
        if (isset($_GET['act_code']) && $_GET['email']) {
            $act_code = $_GET['act_code'];
            $email = $_GET['email'];
            //search & match the email & activation code
            global $wpdb;
            $table_name = $wpdb->prefix . 'nls_subscribers';
            $user_search_result = $wpdb->get_row("SELECT * FROM `$table_name` WHERE `email` LIKE '$email' AND `act_code` LIKE '$act_code'");
            if (count($user_search_result)) {
                // check user is already subscribed
                if ($user_search_result->flag == 1) {
                    echo "<h4 class='alert alert-info'>".esc_html($wl_nls_options['sub_form_subscribe_already_confirm_message'])."</h4>";
                } else {
                    // update user subscription active
                    if ($wpdb->query("UPDATE `$table_name` SET `flag` = '1' WHERE `email` = '$email'")) {
                        echo "<h4 class='alert alert-info'>".esc_html($wl_nls_options['sub_form_subscribe_confirm_success_message'])."</h4>";
                    }
                }
            } else {
                echo "<h4 class='alert alert-info'>".esc_html($wl_nls_options['sub_form_invalid_confirmation_message'])."</h4>";
            }
        } ?>
		</div> <?php
            $js = '';
        $js .= 'jQuery(".newsletter_form1_subscribe-message2 .subscribe-messages").show();';
        $js .= 'jQuery(".newsletter_form1_subscribe-message2 .main_div").show();';
        $js .= 'jQuery(".newsletter_form1_subscribe-message2 .main_div").fadeOut(4000);';
        $js .= 'jQuery(".newsletter_form1_subscribe-message2 .subscribe-messages").fadeOut(3000);';

        wp_add_inline_script('weblizar-nls-main', $js); ?>
		<?php
    }	?>
	</div>
</div>