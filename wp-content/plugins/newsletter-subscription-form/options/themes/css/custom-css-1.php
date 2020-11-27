<?php
$css = '';
$css .= '
.newsletter-api-form-theme1 .newsletter_form1 {
	background-color: '. esc_attr($wl_nls_options['sub_form_bg_color']).' !important;
}';
    if ($wl_nls_options["sub_form_bg_color"]=="#333333") {
        $css .= '
		::-webkit-input-placeholder { /* Chrome */
		  color: #fff;
		}
		:-ms-input-placeholder { /* IE 10+ */
		  color: #fff;
		}
		::-moz-placeholder { /* Firefox 19+ */
		  color: #fff;
		  opacity: 1;
		}
		:-moz-placeholder { /* Firefox 4 - 18 */
		  color: #fff;
		  opacity: 1;
		}';
    }
if ($wl_nls_options['theme_color_schemes']=='custom_colors') {
    $css .= ' 
.newsletter-api-form-theme1 .newsletter_form1_social-icons {
	background-color: '. esc_attr($wl_nls_options['custom_color_schemes']).' !important;
	float: left;
	width: 100%;
	margin: 10px auto;
}
.newsletter-api-form-theme1 .subscriber_submit {
	background-color: '. esc_attr($wl_nls_options['custom_color_schemes']).' !important;
	color: #fff;
}
.newsletter-api-form-theme1 .subscriber_submit:hover {
	background-color: '. esc_attr($wl_nls_options['custom_color_schemes']).' !important;
	color: #fff;
}
.newsletter-api-form-theme1 .newsletter_form1 .form-control {
	border-color: '. esc_attr($wl_nls_options['custom_color_schemes']).' !important;
}
<?php } else { ?>
.newsletter-api-form-theme1 .newsletter_form1_social-icons {
	background-color: '. esc_attr($wl_nls_options['default_color_schemes']).' !important;
	float: left;
	width: 100%;
	margin: 10px auto;
}
.newsletter-api-form-theme1 .subscriber_submit {
	background-color: '. esc_attr($wl_nls_options['default_color_schemes']).' !important;
	color: #fff;
	}
.newsletter-api-form-theme1 .subscriber_submit:hover {
	background-color: '. esc_attr($wl_nls_options['default_color_schemes']).' !important;
	color: #fff;
	}
.newsletter-api-form-theme1 .newsletter_form1 .form-control {
	border-color: '. esc_attr($wl_nls_options['default_color_schemes']).' !important;
}';
}

 $css .= '

.newsletter-api-form-theme1 .newsletter_form1 .form-control::-webkit-input-placeholder {
  font-family: '. esc_attr($wl_nls_options['theme_font_family']).' important;
}

.newsletter-api-form-theme1 .newsletter_form1 .form-control:-ms-input-placeholder {
  font-family: '. esc_attr($wl_nls_options['theme_font_family']).' important;
}

.newsletter-api-form-theme1 .newsletter_form1 .form-control:-moz-placeholder {
  font-family: '. esc_attr($wl_nls_options['theme_font_family']).' important;
}

.newsletter-api-form-theme1 .newsletter_form1 .form-control::-moz-placeholder {
  font-family: '. esc_attr($wl_nls_options['theme_font_family']).' important;
}
.newsletter-api-form-theme1 .newsletter_form1 .btn {
	font-family : '. esc_attr($wl_nls_options['theme_font_family']).' important;
}
.newsletter-api-form-theme1 .newsletter_form1 .form-control {
	font-family : '. esc_attr($wl_nls_options['theme_font_family']).' important;
}

.newsletter-api-form-theme1 .newsletter_form1 .form-control {
	font-family : '. esc_attr($wl_nls_options['theme_font_family']).' important;
}

.newsletter-api-form-theme1 .newsletter_form1_social-icons .newsletter_form1_icon{ 
	font-size: ';
    if (isset($wl_nls_options['link_size'])) {
        $css .= $wl_nls_options['link_size'];
    }
    $css .= ' px !important; }';

    $css .= '
.newsletter-api-form-theme1 .newsletter_form1 .subscriber_submit:hover { 
background-color:'. esc_attr($wl_nls_options['sub_form_button_hb_color']).' !important;
color:'. esc_attr($wl_nls_options['sub_form_button_ht_color']).' !important;
}
.newsletter-api-form-theme1 .newsletter_form1_section-heading{
	font-family : '. esc_attr($wl_nls_options['theme_font_family']).' important;
	font-size:'. esc_attr($wl_nls_options['section_heading_size']).'px;
}
.newsletter-api-form-theme1 .newsletter_form1_section-sub_heading{
	font-family : '. esc_attr($wl_nls_options['theme_font_family']).' important;
	font-size:'. esc_attr($wl_nls_options['section_sub_heading_size']).'px;
}
.newsletter-api-form-theme1 .newsletter_form1_section-description{
	font-family : '. esc_attr($wl_nls_options['theme_font_family']).' important;
	font-size:'. esc_attr($wl_nls_options['section_description_size']).'px;
}
.newsletter-api-form-theme1 .newsletter_form1_section-icon .newsletter_form1_icon{
	font-size:'. esc_attr($wl_nls_options['section_icon_size']).'px ;
}
.newsletter-api-form-theme1 input[type="text"],.newsletter-api-form-theme1 input[type="email"]{
	font-family : '. esc_attr($wl_nls_options['theme_font_family']).' important;
	    box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);
}
.newsletter-api-form-theme1 .subscriber_submit{
	width: 40%;
}
.widget_nlf_form_widget .newsletter-api-form-theme1 .subscriber_submit{
	width: 80%;
}';

wp_add_inline_style('weblizar-nls-style-2', $css);
