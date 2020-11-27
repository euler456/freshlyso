<?php
$css = '';

if ($wl_nls_options['theme_color_schemes']=='custom_colors') {
    $css .= ' .newsletter-api-form-theme2 {
				border: solid 2px '. esc_attr($wl_nls_options['custom_color_schemes']).' !important;
				padding: 10px;
			}';
    $css .= ' .newsletter-api-form-theme2 .newsletter_form2_social-icons {
					background-color: '. esc_attr($wl_nls_options['custom_color_schemes']).' !important;
			}';

    $css .= ' .newsletter-api-form-theme2 .btn {
				background-color: '.esc_attr($wl_nls_options['custom_color_schemes']).' !important;
				color: #fff;
			}';

    $css .= '.newsletter-api-form-theme2 .btn:hover { 
				background-color: '. esc_attr($wl_nls_options['custom_color_schemes']).' !important; 
				color: #fff;
			}';

    $css .= ' .newsletter-api-form-theme2 .form-control {
			border-color: '. esc_attr($wl_nls_options['custom_color_schemes']) .' !important;	
		}';

    $css .= ' .newsletter-api-form-theme2 footer {
				border-color:'. esc_attr($wl_nls_options['default_color_schemes']) . ' !important;
				color: #fff;
			}';
} else {
    $css .= ' .newsletter-api-form-theme2 {
				border: solid 2px '. esc_attr($wl_nls_options['default_color_schemes']).' !important;
				padding: 10px;
			}';


    $css .= ' .newsletter-api-form-theme2 .newsletter_form2_social-icons {
					background-color: '. esc_attr($wl_nls_options['default_color_schemes']).' !important;
					color: #555;
			}';

    $css .= ' .newsletter-api-form-theme2 .btn {
			background-color: '. esc_attr($wl_nls_options['default_color_schemes']).'!important;
			color: #fff;
		}';


    $css .= '.newsletter-api-form-theme2 footer {
			border-color: '. esc_attr($wl_nls_options['default_color_schemes']).' !important;
			color: #fff;
		}';

    $css .= '.newsletter-api-form-theme2 .btn:hover {
				background-color: '.esc_attr($wl_nls_options['default_color_schemes']).' !important;
				color: #fff;
			}';
    $css .= '.newsletter-api-form-theme2 .form-control {
				border-color: '. esc_attr($wl_nls_options['default_color_schemes']).' !important;
			}';
}
    $css .= '.newsletter-api-form-theme2 .form-control::-webkit-input-placeholder {
				font-family: '.esc_attr($wl_nls_options['theme_font_family']).' !important;
	}';

    $css .= '.newsletter-api-form-theme2 .form-control:-ms-input-placeholder {
			font-family: '.esc_attr($wl_nls_options['theme_font_family']).' !important;
		}';


    $css .= '.newsletter-api-form-theme2 .form-control:-moz-placeholder {
			font-family: '.esc_attr($wl_nls_options['theme_font_family']).' !important;
		}';

    $css .= '.newsletter-api-form-theme2 .form-control::-moz-placeholder {
			font-family: '.esc_attr($wl_nls_options['theme_font_family']).' !important;
		}';

    $css .= ' .newsletter-api-form-theme2 .btn {
				font-family: '. esc_attr($wl_nls_options['theme_font_family']).' !important;
			}';

    $css .= '  .newsletter-api-form-theme2 .form-control {
				font-family: '.esc_attr($wl_nls_options['theme_font_family']).' !important;
			}';

    $css .= '.newsletter-api-form-theme2 .form-control{ font-family: '. esc_attr($wl_nls_options["theme_font_family"])
        .' !important;
			}';
    $css .= ' .newsletter-api-form-theme2 .newsletter_form2_social-icons .newsletter_form2_icon {
			font-size:';
if (isset($wl_nls_options['link_size'])) {
    $css .=  esc_attr($wl_nls_options['link_size']).'px !important;';
} else {
    $css .= ';';
}
    $css .= '}';


    $css .= ' .newsletter-api-form-theme2 input[type="text"],
		.newsletter-api-form-theme2 input[type="email"] {
			font-family: '. esc_attr($wl_nls_options["theme_font_family"]).' !important;
		}';
        
        
    $css .= ' .newsletter-api-form-theme2 .btn:hover {
			background-color: '. esc_attr($wl_nls_options['sub_form_button_hb_color']).' !important;
			color: '.esc_attr($wl_nls_options['sub_form_button_ht_color']).' !important;
		}
		.newsletter-api-form-theme2 .newsletter_form2_section-heading {
			font-family: '. esc_attr($wl_nls_options['theme_font_family']).' !important;
			font-size: '. esc_attr($wl_nls_options['section_heading_size']).' px;
			color: #555 !important;
		}
		.newsletter-api-form-theme2 .newsletter_form2_section-sub_heading {
			font-family: '. esc_attr($wl_nls_options['theme_font_family']).' !important;
			font-size: '. esc_attr($wl_nls_options['section_sub_heading_size']).'px;
			color: #555 !important;
		}
		.newsletter-api-form-theme2 .newsletter_form2_section-description {
			font-family: '. esc_attr($wl_nls_options['theme_font_family']).' !important;
			font-size: '. esc_attr($wl_nls_options['section_description_size']).' px;
			color: #555 !important;
		} 
		.newsletter-api-form-theme2 .newsletter_form2_section-icon .newsletter_form2_icon {
			font-size: '. esc_attr($wl_nls_options['section_icon_size']).'px;
			color: #555;
		}';
    wp_add_inline_style('weblizar-nls-style-2', $css);
