<?php
if (! defined('ABSPATH')) {
    exit;
}
require(dirname(__FILE__).'/themes/form-include/mailchimp/MailChimp.php');
use \DrewM\MailChimp\MailChimp;

$wl_nls_options = weblizar_nls_get_options();?>
<!-- Call the option setting -->
<div class="col-xs-8 tab-content" id="spa_general">
	<!-- plugin dashboard Main class div setting -->

	<div class="tab-pane block ui-tabs-panel active" id="templates-option">
		<!-- plugin template selection setting -->
		<div class="row">
			<div class="col-md-9 option">
				<div class="tab-content">
					<div id="weblizar-template" class="tab-pane fade in active">
						<!-- plugin template free theme layout selection setting -->
						<form method="post" id="weblizar_nls_template_option">
							<?php $nonce = wp_create_nonce('subscriber_settings_save_template_option'); ?>
							<input type="hidden" name="security"
								value="<?php echo esc_attr($nonce); ?>">
							<div class="activation col-md-12 form-group">
								<ul class="instruction_points theme_msg_heading">
									<li><?php esc_html_e('Use Shortcode = [nls_form] to show subscriber form at post and page.', 'NLS_TEXT_DOMAIN'); ?>
									</li>
									<li><?php esc_html_e('Use Shortcode with Theme = [nls_theme1] to show subscriber form with theme 1 at post and page for theme 2 use [nls_theme2].', 'NLS_TEXT_DOMAIN'); ?>
									</li>
									<li><?php esc_html_e('You can also use Newsletter Widget menu at widget section.', 'NLS_TEXT_DOMAIN'); ?>
									</li>
								</ul>
							</div>
							<div class="col-md-12 form-group">
								<ul class="instruction_points theme_msg_heading">
									<li><?php esc_html_e('Activate ( Theme Switch ): ', 'NLS_TEXT_DOMAIN');?><span
											class="theme_msg"><?php esc_html_e('First select any below theme, then click on activate button.', 'NLS_TEXT_DOMAIN');?></span>
									</li>
									<li><?php esc_html_e('Restore Defaults : ', 'NLS_TEXT_DOMAIN');?><span
											class="theme_msg"><?php esc_html_e('Restored the default data of only theme and layout section', 'NLS_TEXT_DOMAIN');?></span>
									</li>
									<li><?php esc_html_e('Restored all settings : ', 'NLS_TEXT_DOMAIN');?><span
											class="theme_msg"><?php esc_html_e('Restored the default data of all sections. excluding the subscribers data table', 'NLS_TEXT_DOMAIN');?></span>
									</li>
								</ul>
							</div>
							<div class="activation col-md-12 form-group">
								<div class="col-md-12 restored">
									<input type="hidden" value="1" id="weblizar_nls_settings_save_template_option"
										name="weblizar_nls_settings_save_template_option" />
									<input class="button left" type="button" name="reset"
										value="<?php esc_attr_e('Restore Defaults', 'NLS_TEXT_DOMAIN');?>"
										onclick="weblizar_nls_option_data_reset('template_option');">
									<input class="button theme_activate button-primary left" name="theme_activate"
										type="button"
										value="<?php esc_html_e('Activate', 'NLS_TEXT_DOMAIN');?>"
										id="theme-activation">
									<input class="button right all-restored" type="button" name="restored"
										value="<?php esc_html_e('Restored all settings', 'NLS_TEXT_DOMAIN');?>"
										onclick="weblizar_nls_option_data_restored('template_option');">
								</div>
							</div>
							<input type="hidden" class="form-control" name="select_template" id="select_template"
								value="<?php echo esc_attr($wl_nls_options['select_template']); ?>"
								readonly />
							<div class="template-selection col-md-12 form-group">
								<?php for ($i=1; $i<=2; $i++) {
    $nls_demo_temp = "http://demo.weblizar.com/newsletter-subscription-form-pro/template-".$i ; ?>
								<div class="col-md-12 col-sm-6 op_tem site_template <?php if ($wl_nls_options['select_template']=='select_template'.$i) {
        echo esc_attr('active');
    } ?>" id="select_template<?php echo esc_attr($i)?>"
									onclick="pretheme()">
									<div class="col-md-12 selected_template <?php if ($wl_nls_options['select_template']=='select_template'.$i) {
        echo esc_attr('active');
    } ?>">
										<div class="row op_show" data-orient="top">
											<div class="op_weblizar-pics-activated">
												<span class="image-shop-scroll"
													style="background-image: url('<?php echo plugin_dir_url(__FILE__).'images/screen-shot'.$i.'.png'; ?>"></span>
											</div>
										</div>
										<h4 class="op_name"><?php esc_html_e('Theme ', 'NLS_TEXT_DOMAIN'); ?><?php echo esc_attr($i); ?>&nbsp;&nbsp;<a
												target="_blank" class="nls_temp_demo"
												href="<?php echo esc_attr($nls_demo_temp); ?>">
												<?php esc_html_e('View Demo ', 'NLS_TEXT_DOMAIN'); ?></a>
										</h4>
										<?php if ($wl_nls_options['select_template']=='select_template'.$i) { ?>
										<span class="op_name1 green"><span class="activate"> <?php esc_html_e('Activated', 'NLS_TEXT_DOMAIN'); ?></span>
										</span>
										<?php } else {  ?>
										<span class="op_name1 green"><span class="activate"> <?php esc_html_e('Activated', 'NLS_TEXT_DOMAIN'); ?></span>
											<?php } ?>
									</div>
								</div>
								<?php
} ?>

								<?php for ($i=3; $i<=6; $i++) {
        $nls_demo_temp = "http://demo.weblizar.com/newsletter-subscription-form-pro/template-".$i ; ?>
								<div class="col-md-12 col-sm-6 op_tem site_template"
									id="select_template<?php echo esc_attr($i)?>"
									onclick="protheme()">
									<div class="selected_template">
										<div class="row op_show" data-orient="top">
											<div class="op_weblizar-pics">
												<span class="image-shop-scroll"
													style="background-image: url('<?php echo plugin_dir_url(__FILE__).'images/screen-shot'.$i.'.png'; ?>"></span>
											</div>
										</div>
										<h4 class="op_name"><?php  echo esc_html__('Theme', 'NLS_TEXT_DOMAIN') . esc_html($i); ?>&nbsp;&nbsp;<a
												class="nls_temp_demo" target="_blank"
												href="<?php echo esc_url($nls_demo_temp); ?>"><?php esc_html_e('View Demo', 'NLS_TEXT_DOMAIN'); ?></a>
										</h4>
									</div>
								</div>
								<?php
    } ?>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="update_pro_button"><a target="_blank"
						href="https://weblizar.com/plugins/newsletter-subscription-form-pro/"><?php esc_html_e('Buy Now $7', 'NLS_TEXT_DOMAIN'); ?></a>
				</div>
				<div class="update_pro_image">
					<img class="nls_getpro"
						src="<?php echo plugin_dir_url(__FILE__).'images/nls.jpg'; ?>">
				</div>
				<div class="update_pro_button"><a target="_blank"
						href="https://weblizar.com/plugins/newsletter-subscription-form-pro/"><?php esc_html_e('Buy Now $7', 'NLS_TEXT_DOMAIN'); ?></a>
				</div>
			</div>
		</div>
	</div>
	<div class="tab-pane col-md-12 block ui-tabs-panel deactive" id="skin-layout-settings">
		<!-- plugin General selection setting -->
		<div class="row">
			<div class="col-md-9 option">
				<div class="tab-content">
					<div id="skin-layout" class="tab-pane fade in active">
						<!-- Appearance selection setting -->
						<form method="post" id="weblizar_nls_skin-layout_option">
							<?php $nonce = wp_create_nonce('subscriber_nonce_layout_option'); ?>
							<input type="hidden" name="security"
								value="<?php echo esc_attr($nonce); ?>">
							<div class="col-md-12 form-group">
								<div class="row">
									<div class="col-md-6 no-pad">
										<div class="col-sm-12">
											<label><?php esc_html_e('Theme Color Schemes', 'NLS_TEXT_DOMAIN'); ?></label>
											<label><a href="javascript:void(0)" data-toggle="tooltip"
													data-placement="right"
													title="<?php esc_attr_e('Select color Schemes for page theme layout.', 'NLS_TEXT_DOMAIN'); ?>"><i
														class="fas fa-info-circle tt-icon"></i></a></label><br>
											<?php $theme_color_schemes =$wl_nls_options['theme_color_schemes'];?>
											<select id="theme_color_schemes" name="theme_color_schemes"
												class="form-control">
												<option value="custom_colors" <?php echo selected($theme_color_schemes, 'custom_colors'); ?>
													><?php esc_html_e('Custom Color', 'NLS_TEXT_DOMAIN'); ?>
												</option>
												<option value="default_color" <?php echo selected($theme_color_schemes, 'default_color'); ?>
													><?php esc_html_e('Default Color', 'NLS_TEXT_DOMAIN'); ?>
												</option>
											</select>
										</div>
									</div>
									<div class="col-md-6 no-pad custom_color-option <?php if ($wl_nls_options['theme_color_schemes']=='default_color') {
        echo esc_attr("active");
    } ?>" id="default_color">
										<div class="col-sm-12">
											<?php $default_color_schemes =$wl_nls_options['default_color_schemes'];?>
											<label><?php esc_html_e('Default Color', 'NLS_TEXT_DOMAIN'); ?></label>
											<label><a href="javascript:void(0)" data-toggle="tooltip"
													data-placement="right"
													title="<?php esc_attr_e('Select default color for you theme.', 'NLS_TEXT_DOMAIN'); ?>"><i
														class="fas fa-info-circle tt-icon"></i></a></label><br>
											<select id="default_color_schemes" name="default_color_schemes"
												class="form-control">
												<option value="#eb5054" <?php echo selected($default_color_schemes, '#eb5054'); ?>
													><?php esc_html_e('Default', 'NLS_TEXT_DOMAIN'); ?>
												</option>
												<option value="#136597" <?php echo selected($default_color_schemes, '#136597'); ?>
													><?php esc_html_e('Blue', 'NLS_TEXT_DOMAIN'); ?>
												</option>
												<option value="#1ABC9c" <?php echo selected($default_color_schemes, '#1ABC9c'); ?>
													><?php esc_html_e('Green', 'NLS_TEXT_DOMAIN'); ?>
												</option>
												<option value="#f8504b" <?php echo selected($default_color_schemes, '#f8504b'); ?>
													><?php esc_html_e('Red', 'NLS_TEXT_DOMAIN'); ?>
												</option>
												<option value="#d63861" <?php echo selected($default_color_schemes, '#d63861'); ?>
													><?php esc_html_e('Pink', 'NLS_TEXT_DOMAIN'); ?>
												</option>
												<option value="#FFA500" <?php echo selected($default_color_schemes, '#FFA500'); ?>
													><?php esc_html_e('Orange', 'NLS_TEXT_DOMAIN'); ?>
												</option>
												<option value="#5c4b51" <?php echo selected($default_color_schemes, '#5c4b51'); ?>
													><?php esc_html_e('Brown', 'NLS_TEXT_DOMAIN'); ?>
												</option>
												<option value="#9370DB" <?php echo selected($default_color_schemes, '#9370DB'); ?>
													><?php esc_html_e('Purple', 'NLS_TEXT_DOMAIN'); ?>
												</option>
												<option value="#0ac2d2" <?php echo selected($default_color_schemes, '#0ac2d2'); ?>
													><?php esc_html_e('Sky-Blue', 'NLS_TEXT_DOMAIN'); ?>
												</option>
												<option value="#f17d8a" <?php echo selected($default_color_schemes, '#f17d8a'); ?>
													><?php esc_html_e('Litered', 'NLS_TEXT_DOMAIN'); ?>
												</option>
											</select>
										</div>
									</div>
									<div class="col-md-6 custom_color-option <?php if ($wl_nls_options['theme_color_schemes']=='custom_colors') {
        echo esc_attr("active");
    } ?>" id="custom_colors">
										<label><?php esc_html_e('Custom Color', 'NLS_TEXT_DOMAIN');?></label>
										<label><a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
												title="<?php esc_attr_e('Enable Custom color Schemes and set your color Schemes using color picker.', 'NLS_TEXT_DOMAIN'); ?>"><i
													class="fas fa-info-circle tt-icon"></i></a></label></br>
										<div class="col-md-6 no-pad">
											<input class="color no-sliders" name="custom_color_schemes"
												id="custom_color_schemes"
												value="<?php echo esc_attr($wl_nls_options['custom_color_schemes']); ?>"
												type="text">
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12 form-group">
								<div class="col-sm-12">
									<h3><?php esc_html_e('All Section Settings', 'NLS_TEXT_DOMAIN');?>
										<label><a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
												title="<?php esc_attr_e('Settings for all service, team, testimonials and others section', 'NLS_TEXT_DOMAIN'); ?>"><i
													class="fas fa-info-circle tt-icon"></i></a></label>
									</h3>
								</div>
								<div class="row">
									<div class="col-md-6">
										<label>&nbsp;&nbsp;&nbsp;<?php esc_html_e('Template Font Family', 'NLS_TEXT_DOMAIN');?></label>
									</div>
									<div class="col-md-6">
										<?php $theme_font = $wl_nls_options['theme_font_family']; ?>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="theme_font_family"
											id="theme_font_family" class="form-group">
											<optgroup label="Default Fonts">
												<option value="Arial" <?php selected($theme_font, 'Arial'); ?>><?php esc_html_e('Arial', 'NLS_TEXT_DOMAIN');?>
												</option>
												<option value="Arial Black" <?php selected($theme_font, 'Arial Black'); ?>>
													<?php esc_html_e('Arial Black', 'NLS_TEXT_DOMAIN');?>
												</option>
												<option value="Courier New" <?php selected($theme_font, 'Courier New'); ?>><?php esc_html_e('Courier New ', 'NLS_TEXT_DOMAIN');?>
												</option>
												<option value="cursive" <?php selected($theme_font, 'cursive'); ?>>
													<?php esc_html_e('Cursive', 'NLS_TEXT_DOMAIN');?>
												</option>
												<option value="fantasy" <?php selected($theme_font, 'fantasy'); ?>>
													<?php esc_html_e('Fantasy', 'NLS_TEXT_DOMAIN');?>
												</option>
												<option value="Georgia" <?php selected($theme_font, 'Georgia'); ?>>
													<?php esc_html_e('Georgia', 'NLS_TEXT_DOMAIN');?>
												</option>
												<option value="Grande" <?php selected($theme_font, 'Grande'); ?>>
													<?php esc_html_e('Grande', 'NLS_TEXT_DOMAIN');?>
												</option>
												<option value="Helvetica Neue" <?php selected($theme_font, 'Helvetica Neue'); ?>>
													<?php esc_html_e('Helvetica Neue', 'NLS_TEXT_DOMAIN');?>
												</option>
												<option value="Impact" <?php selected($theme_font, 'Impact'); ?>>
													<?php esc_html_e('Impact', 'NLS_TEXT_DOMAIN');?>
												</option>
												<option value="Lucida" <?php selected($theme_font, 'Lucida'); ?>>
													<?php esc_html_e('Lucida', 'NLS_TEXT_DOMAIN');?>
												</option>
												<option value="Lucida Console" <?php selected($theme_font, 'Lucida Console'); ?>><?php esc_html_e('Lucida Console ', 'NLS_TEXT_DOMAIN');?>
												</option>
												<option value="monospace" <?php selected($theme_font, 'monospace'); ?>>
													<?php esc_html_e('Monospace', 'NLS_TEXT_DOMAIN');?>
												</option>
												<option value="Open Sans" <?php selected($theme_font, 'Open Sans'); ?>><?php esc_html_e('Open Sans', 'NLS_TEXT_DOMAIN');?>
												</option>
												<option value="Palatino" <?php selected($theme_font, 'Palatino'); ?>>
													<?php esc_html_e('Palatino', 'NLS_TEXT_DOMAIN');?>
												</option>
												<option value="sans" <?php selected($theme_font, 'sans'); ?>>
													<?php esc_html_e('Sans', 'NLS_TEXT_DOMAIN');?>
												</option>
												<option value="sans-serif" <?php selected($theme_font, 'sans-serif'); ?>>
													<?php esc_html_e('Sans-Serif', 'NLS_TEXT_DOMAIN');?>
												</option>
												<option value="Tahoma" <?php selected($theme_font, 'Tahoma'); ?>>
													<?php esc_html_e('Tahoma', 'NLS_TEXT_DOMAIN');?>
												</option>
												<option value="Times New Roman" <?php selected($theme_font, 'Times New Roman'); ?>>
													<?php esc_html_e('Times New Roman', 'NLS_TEXT_DOMAIN');?>
												</option>
												<option value="Trebuchet MS" <?php selected($theme_font, 'Trebuchet MS'); ?>>
													<?php esc_html_e('Trebuchet MS', 'NLS_TEXT_DOMAIN');?>
												</option>
												<option value="Verdana" <?php selected($theme_font, 'Verdana'); ?>>
													<?php esc_html_e('Verdana', 'NLS_TEXT_DOMAIN');?>
												</option>
											</optgroup>
											<optgroup label="Google Fonts">
												<?php
                                                        // fetch the Google font list
                                                        $google_api_url = 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyCAHXAMhfSjtL-CCGH0P58KPLPLJAwgdGA';
                                                       $response_font_api = wp_remote_retrieve_body(wp_remote_get($google_api_url, array('sslverify' => false )));
                                                       if (!is_wp_error($response_font_api)) {
                                                           $fonts_list = json_decode($response_font_api, true);
                                                           // that's it
                                                            
                                                           if (isset($fonts_list['items'])) {
                                                               $g_fonts = $fonts_list['items'];
                                                               foreach ($g_fonts as $g_font) {
                                                                   $font_name = $g_font['family']; ?>
												<option
													value="<?php echo esc_attr($font_name); ?>"
													<?php selected($theme_font, $font_name); ?>><?php echo esc_attr($font_name); ?>
												</option><?php
                                                               }
                                                           } else {
                                                               echo "<option disabled>".esc_html__("Error to fetch Google fonts.", 'NLS_TEXT_DOMAIN')."</option>";
                                                               echo "<option disabled>".esc_html__("Google font will not available in offline mode.", 'NLS_TEXT_DOMAIN')."</option>";
                                                           }
                                                       }
                                                    ?>
											</optgroup>
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="row section_setting">
											<div class="col-md-6">
												<strong><?php esc_html_e('Headings Font Size ( H2 )', 'NLS_TEXT_DOMAIN');?></strong>
											</div>
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-4 mb--2">
														<input name="section_heading_size" id="section_heading_size"
															class="form-control"
															value="<?php echo esc_attr($wl_nls_options['section_heading_size']); ?>"
															type="text">
													</div>
													<div class="col-md-2 style_sp">
														<span class="style_vl"><?php esc_html_e('PX', 'NLS_TEXT_DOMAIN');?></span>
													</div>
												</div>
											</div>
										</div>
										<div class="row section_setting">
											<div class="col-md-6">
												<strong><?php esc_html_e('Icon Size', 'NLS_TEXT_DOMAIN');?></strong>
											</div>
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-4">
														<input name="section_icon_size" id="section_icon_size"
															class="form-control"
															value="<?php echo esc_attr($wl_nls_options['section_icon_size']); ?>"
															type="text">
													</div>
													<div class="col-md-2 style_sp">
														<span class="style_vl"><?php esc_html_e('PX', 'NLS_TEXT_DOMAIN');?></span>
													</div>
												</div>
											</div>
										</div>
										<div class="row section_setting">
											<div class="col-md-6">
												<strong><?php esc_html_e('Sub Headings Font Size ( H4 )', 'NLS_TEXT_DOMAIN');?></strong>
											</div>
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-4">
														<input name="section_sub_heading_size"
															id="section_sub_heading_size" class="form-control"
															value="<?php echo esc_attr($wl_nls_options['section_sub_heading_size']); ?>"
															type="text">
													</div>
													<div class="col-md-2 style_sp">
														<span class="style_vl"><?php esc_html_e('PX', 'NLS_TEXT_DOMAIN');?></span>
													</div>
												</div>
											</div>
										</div>
										<div class="row section_setting">
											<div class="col-md-6">
												<strong><?php esc_html_e('description Font Size ( P )', 'NLS_TEXT_DOMAIN');?></strong>
											</div>
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-4">
														<input name="section_description_size"
															id="section_description_size" class="form-control"
															value="<?php echo esc_attr($wl_nls_options['section_description_size']); ?>"
															type="text">
													</div>
													<div class="col-md-2 style_sp">
														<span class="style_vl"><?php esc_html_e('PX', 'NLS_TEXT_DOMAIN');?></span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="restore">
								<input type="hidden" value="1" id="weblizar_nls_settings_save_skin-layout_option"
									name="weblizar_nls_settings_save_skin-layout_option" />
								<input class="button left" type="button" name="reset"
									value="<?php esc_attr_e('Restore Defaults', 'NLS_TEXT_DOMAIN');?>"
									onclick="weblizar_nls_option_data_reset('skin-layout_option');">
								<input class="button button-primary left" type="button"
									value="<?php esc_attr_e('Save Options', 'NLS_TEXT_DOMAIN');?>"
									onclick="weblizar_nls_option_data_save('skin-layout_option')">
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="update_pro_button"><a target="_blank"
						href="https://weblizar.com/plugins/newsletter-subscription-form-pro/"><?php esc_html_e('Buy Now $7', 'NLS_TEXT_DOMAIN'); ?></a>
				</div>
				<div class="update_pro_image">
					<img class="nls_getpro"
						src="<?php echo plugin_dir_url(__FILE__).'images/nls.jpg'; ?>">
				</div>
				<div class="update_pro_button"><a target="_blank"
						href="https://weblizar.com/plugins/newsletter-subscription-form-pro/"><?php esc_html_e('Buy Now $7', 'NLS_TEXT_DOMAIN'); ?></a>
				</div>
			</div>
		</div>
	</div>
	<div class="tab-pane col-md-12 block ui-tabs-panel deactive" id="social-option">
		<!-- Social Media setting -->
		<div class="row">
			<div class="col-md-9 option">
				<div class="tab-content">
					<div id="page-social" class="tab-pane fade in active">
						<!-- Social link and icon setting -->
						<form action="post" id="weblizar_nls_social_option">
							<?php $nonce = wp_create_nonce('subscriber_settings_save_social_option'); ?>
							<input type="hidden" name="security"
								value="<?php echo esc_attr($nonce); ?>">
							<div class="col-md-12 form-group">
								<div class="row">
									<div class="col-md-6 form-group"><br>
										<label><?php esc_html_e('Social Icons', 'NLS_TEXT_DOMAIN');?></label>
										<label><a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
												title="<?php esc_attr_e('Social Icons on Header On/OFF', 'NLS_TEXT_DOMAIN'); ?>"><i
													class="fas fa-info-circle tt-icon"></i></a></label>
									</div>
									<div class="col-md-6"><br>
										<label class="checkbox-inline">
											<input data-toggle="toggle" data-offstyle="off" type="checkbox" <?php if ($wl_nls_options['social_icons_onoff']=='on') {
                                                        echo esc_attr("checked='unchecked'");
                                                    } ?> id="social_icons_onoff"
											name="social_icons_onoff" >
										</label>
									</div>
								</div>
							</div>
							<div class="social-option <?php if ($wl_nls_options['social_icons_onoff']=='on') {
                                                        echo esc_attr("active");
                                                    } ?>" id="nls_social">
								<div id="nls_social_fields">
									<?php
                            if (isset($wl_nls_options['total_Social_links'])) {
                                for ($i=1;$i<=$wl_nls_options['total_Social_links']; $i++) {	?>
									<div class="col-md-12 form-group"
										id="nls_social-<?php echo esc_attr($i);?>">
										<div class="row">
											<div class="col-md-6">
												<label><?php esc_html_e('Social Icon', 'NLS_TEXT_DOMAIN');?><?php echo esc_html__(' ', 'NLS_TEXT_DOMAIN').esc_html($i); ?></label>
												<input class="form-control" type="text"
													name="social_icon_<?php echo esc_attr($i);?>"
													id="social_icon_<?php echo esc_attr($i);?>"
													value="<?php echo esc_attr($wl_nls_options['social_icon_'.$i]); ?>">
												<label><?php esc_html_e('Get more font-awesome icon ', 'NLS_TEXT_DOMAIN'); ?><a
														href="http://fontawesome.io/icons/" target="_blank"><?php esc_html_e('click here', 'NLS_TEXT_DOMAIN'); ?></a></label>
											</div>
											<div class="col-md-6">
												<label><?php esc_html_e('Color', 'NLS_TEXT_DOMAIN');?><?php echo esc_html__(' ', 'NLS_TEXT_DOMAIN').esc_html($i); ?></label>
												<input class="color no-sliders" type="text"
													name="social_icolor_<?php echo esc_attr($i);?>"
													id="social_icolor_<?php echo esc_attr($i);?>"
													value="<?php echo esc_attr($wl_nls_options['social_icolor_'.$i]); ?>">
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<label><?php esc_html_e('Link', 'NLS_TEXT_DOMAIN');?><?php echo esc_html__(' ', 'NLS_TEXT_DOMAIN').esc_html($i); ?></label>
												<input class="form-control" type="text"
													name="social_link_<?php echo esc_attr($i);?>"
													id="social_link_<?php echo esc_attr($i);?>"
													value="<?php echo esc_attr($wl_nls_options['social_link_'.$i]); ?>">
											</div>
											<div class="col-md-6">
												<label><?php esc_html_e('Open As New Tab  ', 'NLS_TEXT_DOMAIN');?></label><br>
												<input data-toggle="toggle" data-offstyle="off" type="checkbox" <?php if ($wl_nls_options['social_link_tab_'.$i]=='on') {
                                    echo esc_attr("checked='unchecked'");
                                } ?> id="social_link_tab_<?php echo esc_attr($i);?>"
												name="social_link_tab_<?php echo esc_attr($i);?>"
												>

											</div>
										</div>
									</div>
									<?php }
                            } ?>
								</div>
							</div>
							<input type="hidden" type="text" id="total_Social_links" name="total_Social_links"
								value="<?php echo esc_attr($wl_nls_options['total_Social_links']); ?>" />
							<div class="restore">
								<input type="hidden" value="1" id="weblizar_nls_settings_save_social_option"
									name="weblizar_nls_settings_save_social_option" />
								<input class="button left" type="button" name="reset"
									value="<?php esc_attr_e('Restore Defaults', 'NLS_TEXT_DOMAIN');?>"
									onclick="weblizar_nls_option_data_reset('social_option');">
								<input class="button button-primary left" type="button"
									value="<?php esc_attr_e('Save Options', 'NLS_TEXT_DOMAIN');?>"
									onclick="weblizar_nls_option_data_save('social_option')">
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="update_pro_button"><a target="_blank"
						href="https://weblizar.com/plugins/newsletter-subscription-form-pro/"><?php esc_html_e('Buy Now $7', 'NLS_TEXT_DOMAIN'); ?></a>
				</div>
				<div class="update_pro_image">
					<img class="nls_getpro"
						src="<?php echo plugin_dir_url(__FILE__).'images/nls.jpg'; ?>">
				</div>
				<div class="update_pro_button"><a target="_blank"
						href="https://weblizar.com/plugins/newsletter-subscription-form-pro/"><?php esc_html_e('Buy Now $7', 'NLS_TEXT_DOMAIN'); ?></a>
				</div>
			</div>
		</div>
	</div>
	<!-- Subscriber Form option setting -->
	<div class="tab-pane col-md-12 block ui-tabs-panel deactive" id="subscriber-settings">
		<!-- Subscriber Form general settings -->
		<div class="row">
			<div class="col-md-9 option">
				<div class="tab-content">
					<form action="post" id="weblizar_nls_subscriber_option">
						<?php $nonce = wp_create_nonce('nonce_save_subscriber_option'); ?>
						<input type="hidden" name="security"
							value="<?php echo esc_attr($nonce); ?>">
						<div class="col-md-12 form-group">
							<h4><?php esc_html_e('Subscriber Section Settings', 'NLS_TEXT_DOMAIN'); ?>
							</h4>
						</div>
						<div class="col-md-12 form-group">
							<div class="row">
								<div class="col-md-4">
									<label><?php esc_html_e('Title', 'NLS_TEXT_DOMAIN'); ?></label>
									<label><a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
											title="<?php esc_attr_e('Type here subscriber form Heading', 'NLS_TEXT_DOMAIN'); ?>"><i
												class="fas fa-info-circle tt-icon"></i></a></label>
								</div>
								<div class="col-md-8">
									<input class="form-control" type="text" name="subscriber_form_title"
										id="subscriber_form_title"
										value="<?php echo esc_attr($wl_nls_options['subscriber_form_title']); ?>">
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<label><?php esc_html_e('Font Awesome Icons', 'NLS_TEXT_DOMAIN'); ?></label>
									<label><a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
											title="<?php esc_attr_e('Type here subscriber form Sub Heading', 'NLS_TEXT_DOMAIN'); ?>"><i
												class="fas fa-info-circle tt-icon"></i></a></label>
								</div>
								<div class="col-md-4">
									<input class="form-control" type="text" name="subscriber_form_icon"
										id="subscriber_form_icon"
										value="<?php echo esc_attr($wl_nls_options['subscriber_form_icon']); ?>">
								</div>
								<div class="col-md-4">
									<label><?php esc_html_e('Get more font-awesome icon', 'NLS_TEXT_DOMAIN'); ?>
										<a href="http://fontawesome.io/icons/" target="_blank"><?php esc_html_e('click here', 'NLS_TEXT_DOMAIN'); ?></a></label>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<label><?php esc_html_e('Sub Title', 'NLS_TEXT_DOMAIN'); ?></label>
									<label><a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
											title="<?php esc_attr_e('Type here subscriber form Sub Heading', 'NLS_TEXT_DOMAIN'); ?>"><i
												class="fas fa-info-circle tt-icon"></i></a></label>
								</div>
								<div class="col-md-8">
									<input class="form-control" type="text" name="subscriber_form_sub_title"
										id="subscriber_form_sub_title"
										value="<?php echo esc_attr($wl_nls_options['subscriber_form_sub_title']); ?>">
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<label><?php esc_html_e('Message', 'NLS_TEXT_DOMAIN'); ?></label>
									<label><a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
											title="<?php esc_attr_e('Type here subscriber form  Message', 'NLS_TEXT_DOMAIN'); ?>"><i
												class="fas fa-info-circle tt-icon"></i></a></label>
								</div>
								<div class="col-md-8">
									<textarea class="form-control" rows="8" cols="8" id="subscriber_form_message"
										name="subscriber_form_message"><?php if ($wl_nls_options['subscriber_form_message']!='') {
                                echo esc_attr($wl_nls_options['subscriber_form_message']);
                            } ?></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-12 form-group">
							<h4><?php esc_html_e('Subscriber Form Settings', 'NLS_TEXT_DOMAIN'); ?>
								<label><a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
										title="<?php esc_attr_e('Type here subscriber form  Setting', 'NLS_TEXT_DOMAIN'); ?>"><i
											class="fas fa-info-circle tt-icon"></i></a></label>
								<br />
							</h4>

							<!-- <div class="subscriber-option-gdpr id="nls_subscriber"> -->
							<div class="col-md-12 checkbox">
								<div class="row">
									<div class="col-md-6">
										<label><?php esc_html_e('GDPR-compliant Enable/Disable', 'NLS_TEXT_DOMAIN');?></label>
									</div>
									<div class="col-md-6">
										<input type="radio" name="wl_gdpr_select" id="wl_gdpr_select" value="yes"
											<?php if ($wl_nls_options['wl_gdpr_select'] == 'yes') {
                                echo esc_attr("checked");
                            } ?>><?php esc_html_e(' Yes', 'NLS_TEXT_DOMAIN'); ?>
										<input type="radio" name="wl_gdpr_select" id="wl_gdpr_select" value="no" <?php if ($wl_nls_options['wl_gdpr_select'] == 'no') {
                                echo esc_attr("checked");
                            } ?>><?php esc_html_e(' No', 'NLS_TEXT_DOMAIN'); ?>
									</div>
								</div>
							</div>
							<br />
							<!-- </div> -->
							<div class="col-md-12 checkbox">
								<div class="row">
									<div class="col-md-6">
										<label><?php esc_html_e('Show First and Last Name', 'NLS_TEXT_DOMAIN');?>
										</label>
										<label><a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
												title="<?php esc_attr_e('Enable to enter first and last name to user in form ', 'NLS_TEXT_DOMAIN'); ?>"><i
													class="fas fa-info-circle tt-icon"></i></a></label>
									</div>
									<div class="col-md-6">
										<input data-toggle="toggle" data-offstyle="off" type="checkbox" <?php if ($wl_nls_options['subscriber_form']=='on') {
                                echo esc_attr("checked='unchecked'");
                            } ?> id="subscriber_form" name="subscriber_form" >
									</div>
								</div>
							</div>
							<div class="subscriber-option <?php if ($wl_nls_options['subscriber_form'] == 'on') {
                                echo esc_attr("active");
                            } ?>" id="nls_subscriber">
								<div class="col-md-12 checkbox">
									<div class="row">
										<div class="col-md-6">
											<label><?php esc_html_e('First Name Placeholder ', 'NLS_TEXT_DOMAIN');?></label>
										</div>
										<div class="col-md-6">
											<input type="text" class="form-control" name="sub_form_button_f_name"
												id="sub_form_button_f_name"
												value="<?php echo esc_attr($wl_nls_options['sub_form_button_f_name']); ?>"
												size="20">
										</div>
									</div>
								</div>
								<div class="col-md-12 checkbox">
									<div class="row">
										<div class="col-md-6">
											<label><?php esc_html_e('Last Name Placeholder ', 'NLS_TEXT_DOMAIN');?></label>
										</div>
										<div class="col-md-6">
											<input type="text" class="form-control" name="sub_form_button_l_name"
												id="sub_form_button_l_name"
												value="<?php echo esc_attr($wl_nls_options['sub_form_button_l_name']); ?>"
												size="20">
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12 checkbox">
								<div class="row">
									<div class="col-md-6">
										<label><?php esc_html_e('Button Text', 'NLS_TEXT_DOMAIN');?></label>
									</div>
									<div class="col-md-6">
										<input type="text" class="form-control" name="sub_form_button_text"
											id="sub_form_button_text"
											value="<?php echo esc_attr($wl_nls_options['sub_form_button_text']); ?>"
											size="20">
									</div>
								</div>
							</div>
							<div class="col-md-12 checkbox">
								<div class="row">
									<div class="col-md-6">
										<label><?php esc_html_e('Email Placeholder ', 'NLS_TEXT_DOMAIN');?></label>
									</div>
									<div class="col-md-6">
										<input type="text" class="form-control" name="sub_form_subscribe_title"
											id="sub_form_subscribe_title"
											value="<?php echo esc_attr($wl_nls_options['sub_form_subscribe_title']); ?>"
											size="20">
									</div>
								</div>
							</div>
							<div class="col-md-12 checkbox">
								<div class="row">
									<div class="col-md-6">
										<label><?php esc_html_e('Button Hover Text Color', 'NLS_TEXT_DOMAIN');?></label>
									</div>
									<div class="col-md-6">
										<input type="text" class="color no-sliders" name="sub_form_button_ht_color"
											id="color"
											value="<?php echo esc_attr($wl_nls_options['sub_form_button_ht_color']); ?>" />
									</div>
								</div>
							</div>
							<div class="col-md-12 checkbox">
								<div class="row">
									<div class="col-md-6">
										<label><?php esc_html_e('Button Hover Background Color', 'NLS_TEXT_DOMAIN');?></label>
									</div>
									<div class="col-md-6">
										<div class="color-picker" style="position: relative;">
											<input type="text" class="color no-sliders" name="sub_form_button_hb_color"
												id="color"
												value="<?php echo esc_attr($wl_nls_options['sub_form_button_hb_color']); ?>" />
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-4">
										<label><?php esc_html_e('Subscribe Success Message', 'NLS_TEXT_DOMAIN');?></label>
										<label><a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
												title="<?php esc_attr_e("Add a text message for Subscribed Success Message", "NLS_TEXT_DOMAIN");?>"><i
													class="fas fa-info-circle tt-icon"></i></a></label>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control"
											name="sub_form_subscribe_seuccess_message"
											id="sub_form_subscribe_seuccess_message"
											value="<?php echo esc_attr($wl_nls_options['sub_form_subscribe_seuccess_message']); ?>">
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-4">
										<label><?php esc_html_e('Subscribe Invalid Message', 'NLS_TEXT_DOMAIN');?></label>
										<label><a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
												title="<?php esc_attr_e("Add a text for Invalid Email Id Message", "NLS_TEXT_DOMAIN");?>"><i
													class="fas fa-info-circle tt-icon"></i></a></label>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control"
											name="sub_form_subscribe_invalid_message"
											id="sub_form_subscribe_invalid_message"
											value="<?php echo esc_attr($wl_nls_options['sub_form_subscribe_invalid_message']); ?>">
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-4">
										<label><?php esc_html_e('Subscribe After Confirmation Success Message', 'NLS_TEXT_DOMAIN');?></label>
										<label><a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
												title="<?php esc_attr_e("Add a text for a confirmation message.", "NLS_TEXT_DOMAIN");?>"><i
													class="fas fa-info-circle tt-icon"></i></a></label>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control"
											name="sub_form_subscribe_confirm_success_message"
											id="sub_form_subscribe_confirm_success_message"
											value="<?php echo esc_attr($wl_nls_options['sub_form_subscribe_confirm_success_message']); ?>">
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-4">
										<label><?php esc_html_e('Already Subscribed Information Message', 'NLS_TEXT_DOMAIN');?></label>
										<label><a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
												title="<?php esc_attr_e("Add a text for a already subscribed message.", "NLS_TEXT_DOMAIN");?>"><i
													class="fas fa-info-circle tt-icon"></i></a></label>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control"
											name="sub_form_subscribe_already_confirm_message"
											id="sub_form_subscribe_already_confirm_message"
											value="<?php echo esc_attr($wl_nls_options['sub_form_subscribe_already_confirm_message']); ?>">
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-4">
										<label><?php esc_html_e('Invaid Details send Error Message', 'NLS_TEXT_DOMAIN');?></label>
										<label><a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
												title="<?php esc_attr_e("Add a text for a error message about showing of the Invalid details sent by subscribed users", "NLS_TEXT_DOMAIN");?>"><i
													class="fas fa-info-circle tt-icon"></i></a></label>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control"
											name="sub_form_invalid_confirmation_message"
											id="sub_form_invalid_confirmation_message"
											value="<?php echo esc_attr($wl_nls_options['sub_form_invalid_confirmation_message']); ?>">
									</div>
								</div>
							</div>
						</div>
						<div class="restore">
							<input type="hidden" value="1" id="weblizar_nls_settings_save_subscriber_option"
								name="weblizar_nls_settings_save_subscriber_option" />
							<input class="button left" type="button" name="reset"
								value="<?php esc_attr_e('Restore Defaults', 'NLS_TEXT_DOMAIN');?>"
								onclick="weblizar_nls_option_data_reset('subscriber_option');">
							<input class="button button-primary left" type="button"
								value="<?php esc_attr_e('Save Options', 'NLS_TEXT_DOMAIN');?>"
								onclick="weblizar_nls_option_data_save('subscriber_option')">
						</div>
					</form>
				</div>
			</div>
			<div class="col-md-3">
				<div class="update_pro_button"><a target="_blank"
						href="https://weblizar.com/plugins/newsletter-subscription-form-pro/"><?php esc_html_e('Buy Now $7', 'NLS_TEXT_DOMAIN'); ?></a>
				</div>
				<div class="update_pro_image">
					<img class="nls_getpro"
						src="<?php echo plugin_dir_url(__FILE__).'images/nls.jpg'; ?>">
				</div>
				<div class="update_pro_button"><a target="_blank"
						href="https://weblizar.com/plugins/newsletter-subscription-form-pro/"><?php esc_html_e('Buy Now $7', 'NLS_TEXT_DOMAIN'); ?></a>
				</div>
			</div>
		</div>
	</div>
	<!-- Subscriber Form provider option setting -->
	<div class="tab-pane col-md-12 block ui-tabs-panel deactive" id="subscriber-provider-option">
		<div class="row">
			<div class="col-md-9 option">
				<div class="tab-content">
					<form action="post" id="weblizar_nls_subscriber_provider_option">
						<?php $nonce = wp_create_nonce('nonce_subscriber_provider_option'); ?>
						<input type="hidden" name="security"
							value="<?php echo esc_attr($nonce); ?>">
						<div class="col-md-12 form-group">
							<div class="row">
								<div class="col-md-6 no-pad">
									<label><?php esc_html_e('Enable Email Based Subscriptions', 'NLS_TEXT_DOMAIN');?></label>
									<label><a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
											title="<?php esc_attr_e("Enable the email confirmation system for valid subscribers.", "NLS_TEXT_DOMAIN");?>"><i
												class="fas fa-info-circle tt-icon"></i></a> </label>
								</div>
								<div class="col-md-6 info">
									<input data-toggle="toggle" data-offstyle="off" type="checkbox" <?php if ($wl_nls_options['confirm_email_subscribe'] == 'on') {
                                echo esc_attr("checked='unchecked'");
                            } ?> id="confirm_email_subscribe" name="confirm_email_subscribe" >

								</div>
							</div>
						</div>
						<div class="form_deactivate-option <?php if ($wl_nls_options['confirm_email_subscribe'] == 'off') {
                                echo esc_attr("active");
                            } ?>" id="deactivated_confirm_email_subscribe">
							<div class="col-md-12 form-group">
								<ul class="instruction_points">
									<li><?php esc_html_e('If Email Subscription is Enable: You have option "Wp Mail"  to mail the subscribers and confirm its subscription through email.', 'NLS_TEXT_DOMAIN');?>
									</li>
									<li style="list-style: none;">&nbsp;</li>
									<li><?php esc_html_e('If email subscription option is disable: Email confirmation process not required. Users/Visitors will be added at subscriber list as active subscriber.', 'NLS_TEXT_DOMAIN');?>
									</li>
								</ul>
							</div>
						</div>
						<div class="form_select-option <?php if ($wl_nls_options['confirm_email_subscribe'] == 'on') {
                                echo esc_attr("active");
                            } ?>" id="confirm_email_subscribe">
							<div class="col-md-12 form-group">
								<div class="row">
									<div class="col-md-6"><br>
										<label><?php esc_html_e('Select Email Carrier Type', 'NLS_TEXT_DOMAIN');?>
										</label>
										<label><a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
												title="<?php esc_attr_e("Select a email carrier type to send subscriber mails", "NLS_TEXT_DOMAIN");?>"><i
													class="fas fa-info-circle tt-icon"></i></a></label>
									</div>
									<div class="col-md-6 no-pad">
										<?php $subscribe_select =$wl_nls_options['subscribe_select'];?>
										<select name="subscribe_select" id="subscribe_select" class="form-control">
											<option value="wp_mail" <?php echo selected($subscribe_select, 'wp_mail'); ?>><?php esc_html_e('WP Mail', 'NLS_TEXT_DOMAIN');?>
											</option>
											<option value="madmimi" <?php selected($subscribe_select, 'madmimi'); ?>><?php esc_html_e('Mad Mimi', 'NLS_TEXT_DOMAIN');?>
											</option>
											<option value="mailchimp" <?php selected($subscribe_select, 'mailchimp'); ?>><?php esc_html_e('MailChimp', 'NLS_TEXT_DOMAIN');?>
											</option>
										</select>
										<ul class="instruction_points theme_msg_heading">
											<li><?php esc_html_e('WordPress Guideline: PHP Mailer Library Removed due to not supported by WordPress.org 4.7.2.', 'NLS_TEXT_DOMAIN'); ?>
											</li>

										</ul>
									</div>
								</div>
							</div>
							<div class="col-md-12 form-group subscribe-option <?php if ($subscribe_select=='wp_mail') {
                                echo esc_attr("active");
                            }?>" id="wp_mail">
								<div class="row">
									<div class="col-md-6 no-pad"><br>
										<label><?php esc_html_e('WP Mail Subscriber', 'NLS_TEXT_DOMAIN');?></label>
									</div>
									<div class="col-md-6">
										<label><?php esc_html_e('Mail ID', 'NLS_TEXT_DOMAIN');?></label>
										<label><a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
												title="<?php esc_attr_e("Add Sender Email Id. By default User mail id has added", "NLS_TEXT_DOMAIN");?>"><i
													class="fas fa-info-circle tt-icon"></i></a></label>
										<input type="text" class="form-control" name="wp_mail_email_id"
											id="wp_mail_email_id"
											value="<?php echo esc_attr($wl_nls_options['wp_mail_email_id']); ?>" />
									</div>
								</div>
							</div>

							<div class="col-md-12 form-group subscribe-option <?php if ($subscribe_select=='madmimi') {
                                echo esc_attr("active");
                            }?>" id="madmimi">
								<label><?php esc_html_e('Mad Mimi Settings', 'NLS_TEXT_DOMAIN');?></label><br /><br />
								<div class="col-md-12 no-pad">
									<div class="row">
										<div class="col-md-6">
											<label><?php esc_html_e('Username or Email : ', 'NLS_TEXT_DOMAIN')?></label>
											<label><a href="javascript:void(0)" data-toggle="tooltip"
													data-placement="right"
													title="<?php esc_attr_e("Enter your Madmimi username or email which are using in madmimi.", "NLS_TEXT_DOMAIN");?>"><i
														class="fas fa-info-circle tt-icon"></i></a></label>
										</div>
										<div class="col-md-6">
											<input type="text" placeholder="Enter Username or Email"
												class="form-control" name="madmimi_username" id="madmimi_username"
												value="<?php echo esc_attr($wl_nls_options['madmimi_username']); ?>" />
										</div>
									</div>
								</div>
								<div class="col-md-12 no-pad">
									<div class="row">
										<div class="col-md-6">
											<label><?php esc_html_e('Api Key', 'NLS_TEXT_DOMAIN')?></label>
											<!-- Meta Description tooltip ---->
											<label><a href="javascript:void(0)" data-toggle="tooltip"
													data-placement="right"
													title="<?php esc_attr_e("Enter madmimi api key.", "NLS_TEXT_DOMAIN");?>"><i
														class="fas fa-info-circle tt-icon"></i></a></label>
										</div>
										<div class="col-md-6">
											<input type="text" class="form-control" name="madmimi_api_key"
												id="madmimi_api_key" placeholder="Enter Api Key"
												value="<?php echo esc_attr($wl_nls_options['madmimi_api_key']) ?>" />
										</div>
									</div>
								</div>
								<?php
                        if ($wl_nls_options['madmimi_username'] == "" && $wl_nls_options['madmimi_api_key'] == "") {
                            ?>
								<div class="alert alert-error" id="madmini_alert1"><?php echo "</br><p>".esc_html__("API key and UserId field blank")." </p>"; ?>
								</div>
								<?php
                        } elseif ($wl_nls_options['madmimi_username'] != "" && $wl_nls_options['madmimi_api_key'] == "") {
                            ?>
								<div class="alert alert-error" id="madmini_alert1"><?php echo "</br><p>".esc_html__("API Key field is blank", 'NLS_TEXT_DOMAIN')."</p>"; ?>
								</div>
								<?php
                        } elseif ($wl_nls_options['madmimi_username'] == "" && $wl_nls_options['madmimi_api_key'] != "") {
                            ?>
								<div class="alert alert-error" id="madmini_alert1"><?php echo "</br><p>".esc_html__("UserId field is blank", 'NLS_TEXT_DOMAIN')."</p>"; ?>
								</div>
								<?php
                        } elseif ($wl_nls_options['madmimi_username'] != "" && $wl_nls_options['madmimi_api_key'] != "") {
                            ?>
								<div class="col-md-12 no-pad">
									<div class="col-md-6">
										<label><?php esc_html_e('List', 'NLS_TEXT_DOMAIN')?></label>
										<!-- Meta Description tooltip ---->
										<label><a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
												title="<?php esc_attr_e("Select Your List Option.", "NLS_TEXT_DOMAIN"); ?>"><i
													class="fas fa-info-circle tt-icon"></i></a></label>
										<?php
                                    $madmimi_list =$wl_nls_options['madmimi_list_option'];
                            $nls_madmimi_list = unserialize(get_option('weblizar_nls_madmimi_list'));
                            if ($wl_nls_options['madmimi_username'] != "" && $wl_nls_options['madmimi_api_key'] != "" && $nls_madmimi_list == "") { ?>
										<div class="alert alert-error" id="madmini_alert1"><?php echo "<p style='text-align:center!important;'>".esc_html__("List is Empty !!!", 'NLS_TEXT_DOMAIN')."</p><span>".esc_html__("API Connection Error (API key and UserId might be wrong)", 'NLS_TEXT_DOMAIN')."</br>".esc_html__("if not then craete a audience list in your madmimi account.", 'NLS_TEXT_DOMAIN')."</span>";  ?>
										</div>
										<?php
                            } elseif ($wl_nls_options['madmimi_username'] != "" && $wl_nls_options['madmimi_api_key'] != "" && $nls_madmimi_list != "") {?>
										<select id="madmimi_list_option" name="madmimi_list_option"
											class="form-control">
											<?php
                                    foreach ($nls_madmimi_list as $List) { ?>
											<option
												value="<?php echo esc_attr($List['id']); ?>"
												<?php echo selected($madmimi_list, $List['id']); ?>
												>
												<?php esc_html_e(ucfirst($List['name']), 'NLS_TEXT_DOMAIN'); ?>
											</option>
											<?php
                                    }
                                    ?>
											<br>
										</select>
										<?php } ?>
									</div>
								</div>
								<?php
                        }	?>
								<div class="col-md-12 no-pad">
									<div class="col-md-6"></br>
										<label><?php esc_html_e('You can find all other Madmimi configuration settings ', 'NLS_TEXT_DOMAIN');?><a
												href="https://weblizar.com/how-to-use-mad-mimi-api/"
												target="_new"><?php esc_html_e('HERE', 'NLS_TEXT_DOMAIN');?></label></a>
									</div>
								</div>
							</div>
							<div class="col-md-12 form-group subscribe-option <?php if ($subscribe_select=='mailchimp') {
                            echo esc_attr("active");
                        }?>" id="mailchimp">
								<label><?php esc_html_e('MailChimp Settings', 'NLS_TEXT_DOMAIN');?></label><br /><br />
								<div class="col-md-12 no-pad">
									<div class="col-md-6">
										<label><?php esc_html_e('API Key : ', 'NLS_TEXT_DOMAIN')?></label>
										<label><a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
												title="<?php esc_attr_e("Enter your Api key.", "NLS_TEXT_DOMAIN");?>"><i
													class="fas fa-info-circle tt-icon"></i></a></label>
										<span><a href='http://admin.mailchimp.com/account/api-key-popup'
												target='_new'><?php esc_html_e("Get your Api key", "NLS_TEXT_DOMAIN")?></a></span>
										<input type="text" class="form-control" name="mailchimp_api_key"
											id="mailchimp_api_key"
											value="<?php echo esc_attr($wl_nls_options['mailchimp_api_key']); ?>" />
									</div>
								</div>
								<?php
                        if ($wl_nls_options['mailchimp_api_key'] == "") {
                            ?>
								<div class="col-md-12 no-pad">
									<div class="col-md-6">
										<div class="alert alert-error" id="madmini_alert1"><?php echo "</br><p>".esc_htmL__("API Key field is blank", 'NLS_TEXT_DOMAIN')."</p>"; ?>
										</div>
									</div>
								</div>
								<?php
                        } elseif ($wl_nls_options['mailchimp_api_key'] != "") {
                            ?>
								<div class="col-md-12 no-pad">
									<div class="col-md-6">
										<?php
                                $mailchimp_key  = stripslashes($wl_nls_options['mailchimp_api_key']);
                            $apikey = $mailchimp_key;
                            $api = new MailChimp($apikey);
                            $lists = $api->get('lists');
                            if ($lists == false) {
                                ?>
										<div class="alert alert-error" id="madmini_alert1"><?php echo "</br><p>".esc_htmL__("API Connection Error : Please add valid API Key !!", 'NLS_TEXT_DOMAIN')."</p>"; ?>
										</div>
										<?php
                            } else {
                                if (isset($lists)) {
                                    $lists = $lists['lists'];
                                    foreach ($lists as $list) {
                                        $listId = $list['id'];
                                        $listName = $list['name'];
                                        $mailchimp_key_list[] = array('id' => $listId, 'name' => $listName);
                                    }
                                    if (isset($mailchimp_key_list)) {
                                        foreach ($mailchimp_key_list as $List) {
                                            $alllistid = $List['id'];
                                            $alllistname = $List['name'];
                                            $weblizar_nls_mailchimp_list[] = array('id' => $alllistid, 'name' => $alllistname);
                                        }
                                        update_option("weblizar_nls_mailchimp_list", serialize($weblizar_nls_mailchimp_list));
                                    }
                                }

                                $mailchimp_list = $wl_nls_options['mailchimp_list_id'];
                                $weblizar_nls_mailchimp_list = unserialize(get_option('weblizar_nls_mailchimp_list')); ?>
										<?php

                                if ($wl_nls_options['mailchimp_api_key'] != "" && $weblizar_nls_mailchimp_list == "") {
                                    ?>

										<div class="alert alert-error" id="madmini_alert1"><?php echo "</br><p>".esc_html__("OOPs !! Your MailChimp list is empty. ", 'NLS_TEXT_DOMAIN')."</br><span style='font-size:12px;'>".esc_html__("Please create a list in your mailchimp cccount( Lists are where you store your contacts (subscribers))", 'NLS_TEXT_DOMAIN')."</span></p>"; ?>
										</div>
										<?php
                                } elseif ($wl_nls_options['mailchimp_api_key'] != "" && $weblizar_nls_mailchimp_list != "") { ?>
										<label><?php esc_html_e('List : ', 'NLS_TEXT_DOMAIN')?></label>
										<label><a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
												title="<?php esc_attr_e("Select you mailchimp list.", "NLS_TEXT_DOMAIN");?>"><i
													class="fas fa-info-circle tt-icon"></i></a></label>
										<select id="mailchimp_list_id" name="mailchimp_list_id" class="form-control"
											style="display:<?php if ($wl_nls_options['mailchimp_api_key']=="") {
                                    echo esc_attr("none");
                                }?>">
											<?php foreach ($weblizar_nls_mailchimp_list as $mail_list) { ?>
											<option
												value="<?php echo esc_attr($mail_list['id']); ?>"
												<?php echo selected($mailchimp_list, $mail_list['id']); ?>>
												<?php echo esc_html($mail_list['name']); ?>
											</option>
											<?php } ?>
										</select>
										<?php }
                            } ?>
									</div>
								</div>
								<?php
                        }	?>
								<div class="col-md-12 no-pad">
									<div class="col-md-6"></br>
										<label><?php esc_html_e('You can find all Mailchimp configuration settings ', 'NLS_TEXT_DOMAIN');?><a
												href="https://weblizar.com/how-to-integrate-with-mailchimp-account"
												target="_new"><?php esc_html_e('HERE', 'NLS_TEXT_DOMAIN');?></a></label>
									</div>
								</div>
							</div>
						</div>
						<div class="restore">
							<input type="hidden" value="1" id="weblizar_nls_settings_save_subscriber_provider_option"
								name="weblizar_nls_settings_save_subscriber_provider_option" />
							<input class="button left" type="button" name="reset"
								value="<?php esc_attr_e('Restore Defaults', 'NLS_TEXT_DOMAIN');?>"
								onclick="weblizar_nls_option_data_reset('subscriber_provider_option');">
							<input class="button button-primary left" type="button"
								value="<?php esc_attr_e('Save Options', 'NLS_TEXT_DOMAIN');?>"
								onclick="weblizar_nls_option_data_save('subscriber_provider_option')">
						</div>
					</form>
				</div>
			</div>
			<div class="col-md-3">
				<div class="update_pro_button"><a target="_blank"
						href="https://weblizar.com/plugins/newsletter-subscription-form-pro/"><?php esc_html_e('Buy Now $7', 'NLS_TEXT_DOMAIN'); ?></a>
				</div>
				<div class="update_pro_image">
					<img class="nls_getpro"
						src="<?php echo plugin_dir_url(__FILE__).'images/nls.jpg'; ?>">
				</div>
				<div class="update_pro_button"><a target="_blank"
						href="https://weblizar.com/plugins/newsletter-subscription-form-pro/"><?php esc_html_e('Buy Now $7', 'NLS_TEXT_DOMAIN'); ?></a>
				</div>
			</div>
		</div>
	</div>
	<!-- Get the Subscriber Form database output setting -->
	<div class="tab-pane col-md-12 block ui-tabs-panel deactive" id="subscriber-list-option">
		<div class="row">
			<div class="col-md-9 option">
				<div class="tab-content">
					<form action="post" id="weblizar_nls_subscribe_form">
						<?php $nonce = wp_create_nonce('subscribers_options_settings'); ?>
						<input type="hidden" name="security"
							value="<?php echo esc_attr($nonce); ?>">
						<div class="col-md-12 form-group">
							<label style="margin:20px;"><?php esc_html_e('Manual E-Mail To Subscribers', 'NLS_TEXT_DOMAIN');?></label>
							<label><a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
									title="<?php esc_attr_e("This section used for mail to subscriber user", "NLS_TEXT_DOMAIN");?>"><i
										class="fas fa-info-circle tt-icon"></i></a></label>
							<?php $sub_mail_option =$wl_nls_options['subscriber_users_mail_option'];?>
						</div>

						<div class="col-md-12 form-group">
							<div class="row">
								<div class="col-md-6">
									<span><?php esc_html_e('Select options', 'NLS_TEXT_DOMAIN'); ?></span>
									<label><a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
											title="<?php esc_attr_e("Below selection option have some types of user list (Active users , Pending users, Already mailed users)", "NLS_TEXT_DOMAIN");?>"><i
												class="fas fa-info-circle tt-icon"></i></a> </label>
								</div>
								<div class="col-md-6">
									<div class="col-sm-12 no-pad" id="weblizar_nls_layout_switch">
										<select id="subscriber_users_mail_option" name="subscriber_users_mail_option"
											class="form-control">
											<option value="all_users" <?php echo selected($sub_mail_option, 'all_users'); ?>
												><?php esc_html_e('All Users', 'NLS_TEXT_DOMAIN'); ?>
											</option>
											<option value="selected_users" <?php echo selected($sub_mail_option, 'selected_users'); ?>
												><?php esc_html_e('Selected Users', 'NLS_TEXT_DOMAIN'); ?>
											</option>
											<option value="pending_users" <?php echo selected($sub_mail_option, 'pending_users'); ?>
												><?php esc_html_e('Pending Users', 'NLS_TEXT_DOMAIN'); ?>
											</option>
											<option value="active_users" <?php echo selected($sub_mail_option, 'active_users'); ?>
												><?php esc_html_e('Active Users', 'NLS_TEXT_DOMAIN'); ?>
											</option>
											<option value="already_mailed_users" <?php echo selected($sub_mail_option, 'already_mailed_users'); ?>
												><?php esc_html_e('Mail Received Users', 'NLS_TEXT_DOMAIN'); ?>
											</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="col-sm-12 no-pad">
										<span><?php esc_html_e('Subject', 'NLS_TEXT_DOMAIN');?></span>
										<label><a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
												title="<?php esc_attr_e("Add a Subject for sending mail.", "NLS_TEXT_DOMAIN");?>"><i
													class="fas fa-info-circle tt-icon"></i></a></label>
									</div>
								</div>
								<div class="col-md-6">
									<input class="form-control" type="text" name="subscriber_mail_subject"
										id="subscriber_mail_subject"
										value="<?php echo esc_attr($wl_nls_options['subscriber_mail_subject']); ?>">
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<span><?php esc_html_e('Message', 'NLS_TEXT_DOMAIN');?></span>
									<label><a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
											title="<?php esc_attr_e("Add a Message to send subscriber users", "NLS_TEXT_DOMAIN");?>"><i
												class="fas fa-info-circle tt-icon"></i></a></label>
									<textarea class="form-control" rows="8" cols="8" id="subscriber_mail_message"
										name="subscriber_mail_message"
										placeholder="<?php esc_attr_e('Add a Message to send subscriber Users', 'NLS_TEXT_DOMAIN');?>"><?php if ($wl_nls_options['subscriber_mail_message']!='') {
                            echo esc_attr($wl_nls_options['subscriber_mail_message']);
                        } ?></textarea>
									<input type="hidden" value="1" id="weblizar_nls_submit_subscriber"
										name="weblizar_nls_submit_subscriber" />
									<input class="subscriber_submit btn" id="submit_subscriber" name="submit_subscriber"
										type="button"
										value="<?php esc_attr_e('Send', 'NLS_TEXT_DOMAIN');?>">
								</div>
							</div>
						</div>
						<div class="col-md-12 form-group">
							<div class="subscribers-settings-wrap settings-content">
								<div class="row" style="background-color: #0098FF;color: #fff">
									<div class="col-md-6"><br>
										<label><?php esc_html_e('Manage Subscribed User Data-Table', 'NLS_TEXT_DOMAIN');?></label>
									</div>
									<div class="col-md-6 o_buttons">
										<div style="float: right;" class="col-sm-12 form-group">
											<?php
                                        global $wpdb;
                                        $table_name = $table_name = $wpdb->prefix . "nls_subscribers";
                                        $user_sets_all = $wpdb->get_results("SELECT * FROM $table_name");
                                        if ($user_sets = $user_sets_all) {
                                            if (count($user_sets) > 0) { ?>
											<input class="button button5 red" name="remove_subs" type="button"
												value="<?php esc_attr_e('Remove Selected Subscriber', 'NLS_TEXT_DOMAIN');?>"
												id="remove-sub">
											<input class="button button4 red" type="button" name="remove-all-subs"
												value="<?php esc_attr_e('Removed All Users', 'NLS_TEXT_DOMAIN');?>"
												id="remove-all-subs">
											<?php }
                                        } ?>
										</div>
									</div>
								</div><br><br>
								<div class="modal fade" id="appearance_removed_option" role="dialog">
									<div class="modal-dialog">
										<!-- Modal content-->
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close"
													data-dismiss="modal">&times;</button>
												<h2 class="modal-title"><?php esc_html_e('Data Delete SuccessFully', 'NLS_TEXT_DOMAIN');?>
												</h2>
											</div>
											<div class="modal-body">
												<p><?php esc_html_e('Your Selected Data Removed SuccessFully', 'NLS_TEXT_DOMAIN');?>
												</p>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default"
													data-dismiss="modal"><?php esc_html_e('Close', 'NLS_TEXT_DOMAIN');?></button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
                            global $wpdb;
                            $table_name            = $table_name = $wpdb->prefix . "nls_subscribers";
                            $user_sets_unsubscribe = $wpdb->get_results("SELECT * FROM $table_name WHERE flag = '0' ");
                            $user_sets_subscribe   = $wpdb->get_results("SELECT * FROM $table_name WHERE flag = '1' ");
                            $user_sets_all         = $wpdb->get_results("SELECT * FROM $table_name");
                            ?>
							<table class="wp-list-table widefat fixed posts" id="dataTables-example"
								data-wp-lists="list:post">
								<thead>
									<tr>
										<th scope="col" id="sub_cbx" class="manage-column column-title sortable asc"
											style=""></th>
										<th scope="col" id="sub_cbx" class="manage-column column-title sortable asc"
											style="">
											<span><?php esc_html_e('First Name', 'NLS_TEXT_DOMAIN'); ?></span>
										</th>
										<th scope="col" id="sub_cbx" class="manage-column column-title sortable asc"
											style="">
											<span><?php esc_html_e('Last Name', 'NLS_TEXT_DOMAIN'); ?></span>
										</th>
										<th scope="col" id="sub_cbx" class="manage-column column-title sortable asc"
											style="">
											<span><?php esc_html_e('Agree GDPR Compliant', 'NLS_TEXT_DOMAIN'); ?></span>
										</th>
										<th scope="col" id="sub_email" class="manage-column column-title sortable asc"
											style="">
											<span><?php esc_html_e('Email', 'NLS_TEXT_DOMAIN'); ?></span>
										</th>
										<th scope="col" id="sub_date" class="manage-column column-shortcode" style="">
											<span><?php esc_html_e('Date', 'NLS_TEXT_DOMAIN'); ?></span>
										</th>
										<th scope="col" id="act_code" class="manage-column column-shortcode" style="">
											<span><?php esc_html_e('Subscription Status', 'NLS_TEXT_DOMAIN'); ?></span>
										</th>
									</tr>
								</thead>
								<tbody>
									<?php
                                    if ($user_sets = $user_sets_all) {
                                        if (count($user_sets) > 0) {
                                            foreach ($user_sets as $user_set) { ?>
									<tr style="background-color: #f9f6f6;" class="all_users">
										<td class="check-column"><?php echo '<input type="checkbox" name="rem[]" class="select_subs" value="'.esc_js(esc_html($user_set->id)).'">'; ?>
										</td>
										<td class="shortcode column-shortcode"><?php echo esc_html($user_set->f_name); ?>
										</td>
										<td class="shortcode column-shortcode"><?php echo esc_html($user_set->l_name); ?>
										</td>
										<td class="shortcode column-shortcode"><?php echo esc_html($user_set->terms); ?>
										</td>
										<td class="shortcode column-shortcode"><?php echo esc_html($user_set->email); ?>
										</td>
										<td class="shortcode column-shortcode"><?php echo esc_html($user_set->date); ?>
										</td>
										<td class="shortcode column-shortcode"><?php if ($user_set->flag == '1') {
                                                echo esc_attr('Active');
                                            } elseif ($user_set->flag == '2') {
                                                echo esc_html('Mail Send', 'NLS_TEXT_DOMAIN');
                                            } else {
                                                echo esc_html('Pending', 'NLS_TEXT_DOMAIN');
                                            }?>
										</td>
									</tr>
									<?php
                                            }
                                        } else { ?>
									<tr>
										<td colspan="2">
											<div class="edmm-noresult"><?php esc_html_e('No Subscribers Found.', 'NLS_TEXT_DOMAIN');?>
											</div>
										</td>
									</tr>
									<?php
                                        }
                                    } ?>
								</tbody>
							</table>
						</div>
				</div>
				<div class="restore">
					<input type="hidden" value="1" id="weblizar_nls_settings_save_subscribe_form"
						name="weblizar_nls_settings_save_subscribe_form" />
					<input class="button left" type="button" name="reset"
						value="<?php esc_attr_e('Restore Defaults', 'NLS_TEXT_DOMAIN');?>"
						onclick="weblizar_nls_option_data_reset('subscribe_form');">
					<input class="button button-primary left" type="button"
						value="<?php esc_attr_e('Save Options', 'NLS_TEXT_DOMAIN');?>"
						onclick="weblizar_nls_option_data_save('subscribe_form')">
				</div>
				</form>
			</div>

			<div class="col-md-3"><br>
				<div class="update_pro_button"><a target="_blank"
						href="https://weblizar.com/plugins/newsletter-subscription-form-pro/"><?php esc_html_e('Buy Now $7', 'NLS_TEXT_DOMAIN'); ?></a>
				</div>
				<div class="update_pro_image">
					<img class="nls_getpro"
						src="<?php echo plugin_dir_url(__FILE__).'images/nls.jpg'; ?>">
				</div>
				<div class="update_pro_button"><a target="_blank"
						href="https://weblizar.com/plugins/newsletter-subscription-form-pro/"><?php esc_html_e('Buy Now $7', 'NLS_TEXT_DOMAIN'); ?></a>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

</div>