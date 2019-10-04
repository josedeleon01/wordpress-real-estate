<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/18/2016
 * Time: 2:23 PM
 */

/**
 * Get Less to CSS string
 * *******************************************************
 */
if (!function_exists('gf_get_less_to_css')) {
    function gf_get_less_to_css($compress = true)
    {
        $loading_animation = gf_get_option('loading_animation', 'none');
        $css_variable = gf_get_custom_css_variable();
        $custom_css = gf_custom_css();

        if (!class_exists('Less_Parser')) {
            require_once GF_PLUGIN_DIR . 'core/less/Less.php';
        }
        $parser = new Less_Parser(array('compress' => $compress));
        $parser->parse($css_variable);

        // Parse style.less
        $parser->parseFile(trailingslashit(get_template_directory()) . 'assets/less/style.less', trailingslashit(get_template_directory_uri()));

        // Parse loading animation
        if ($loading_animation != 'none' && !empty($loading_animation)) {
            $parser->parseFile(trailingslashit(get_template_directory()) . 'assets/less/loading/' . $loading_animation . '.less');
        }

        $parser->parse($custom_css);
        $css = $parser->getCss();

        return $css;
    }
}

/**
 * Get Less to CSS string RTL
 * *******************************************************
 */
if (!function_exists('gf_get_less_to_css_rtl')) {
    function gf_get_less_to_css_rtl($compress = true)
    {
        $css_variable = gf_get_custom_css_variable();
        if (!class_exists('Less_Parser')) {
            require_once GF_PLUGIN_DIR . 'core/less/Less.php';
        }
        $parser = new Less_Parser(array('compress' => $compress));

        $parser->parse($css_variable);

        // Parse rtl.less
        $parser->parseFile(trailingslashit(get_template_directory()) . 'assets/less/variable.less');
        $parser->parseFile(trailingslashit(get_template_directory()) . 'assets/less/rtl.less', trailingslashit(get_template_directory_uri()));
        $css = $parser->getCss();

        return $css;
    }
}

/**
 * GET CUSTOM CSS
 * *******************************************************
 */
if (!function_exists('gf_custom_css')) {
    function gf_custom_css()
    {
        $custom_css = '';
        $background_image_css = '';

        $body_background_mode = gf_get_option('body_background_mode', 'background');
        $body_background = gf_get_option('body_background', array());

        if ($body_background_mode == 'background') {

            $background_image_url = isset($body_background['background_image_url']) ? $body_background['background_image_url'] : '';
            $background_color = isset($body_background['background_color']) ? $body_background['background_color'] : '';

            if (!empty($background_color)) {
                $background_image_css .= 'background-color:' . $background_color . ';';
            }

            if (!empty($background_image_url)) {
                $background_repeat = isset($body_background['background_repeat']) ? $body_background['background_repeat'] : '';
                $background_position = isset($body_background['background_position']) ? $body_background['background_position'] : '';
                $background_size = isset($body_background['background_size']) ? $body_background['background_size'] : '';
                $background_attachment = isset($body_background['background_attachment']) ? $body_background['background_attachment'] : '';

                $background_image_css .= 'background-image: url("' . $background_image_url . '");';


                if (!empty($background_repeat)) {
                    $background_image_css .= 'background-repeat: ' . $background_repeat . ';';
                }

                if (!empty($background_position)) {
                    $background_image_css .= 'background-position: ' . $background_position . ';';
                }

                if (!empty($background_size)) {
                    $background_image_css .= 'background-size: ' . $background_size . ';';
                }

                if (!empty($background_attachment)) {
                    $background_image_css .= 'background-attachment: ' . $background_attachment . ';';
                }
            }

        }

        if ($body_background_mode == 'pattern') {
            $background_image_url = GF_PLUGIN_URL . 'assets/images/theme-options/' . gf_get_option('body_background_pattern', 'pattern-1.png');
            $background_image_css .= 'background-image: url("' . $background_image_url . '");';
            $background_image_css .= 'background-repeat: repeat;';
            $background_image_css .= 'background-position: center center;';
            $background_image_css .= 'background-size: auto;';
            $background_image_css .= 'background-attachment: scroll;';
        }

        if (!empty($background_image_css)) {
            $custom_css .= 'body{' . $background_image_css . '}';
        }


        $custom_css .= gf_get_option('custom_css', '');

        $custom_scroll = gf_get_option('custom_scroll', 0);
        if ($custom_scroll == 1) {
            $custom_scroll_width = gf_get_option('custom_scroll_width', '10');
            $custom_scroll_color = gf_get_option('custom_scroll_color', '#333');
            $custom_scroll_thumb_color = gf_get_option('custom_scroll_thumb_color', '#1086df');

            $custom_css .= 'body::-webkit-scrollbar {width: ' . $custom_scroll_width . 'px;background-color: ' . $custom_scroll_color . ';}';
            $custom_css .= 'body::-webkit-scrollbar-thumb{background-color: ' . $custom_scroll_thumb_color . ';}';
        }

        $footer_bg_image = gf_get_option('footer_bg_image', array());
        $footer_bg_image = isset($footer_bg_image['url']) ? $footer_bg_image['url'] : '';

        $footer_bg_image_apply_for = gf_get_option('footer_bg_image_apply_for', 'footer.main-footer-wrapper');
        if ($footer_bg_image_apply_for == '') {
            $footer_bg_image_apply_for = 'footer.main-footer-wrapper';
        }

        if (!empty($footer_bg_image)) {
            $footer_bg_css = 'background-image:url(' . $footer_bg_image . ');';
            //$footer_bg_css .= 'background-size: cover;';
            $footer_bg_css .= 'background-position: center center;';
            $footer_bg_css .= 'background-repeat: repeat;';
            $custom_css .= $footer_bg_image_apply_for . ' {' . $footer_bg_css . '}';
        }


        $custom_css = str_replace("\r\n", '', $custom_css);
        $custom_css = str_replace("\n", '', $custom_css);
        $custom_css = str_replace("\t", '', $custom_css);

        return $custom_css;
    }
}

/**
 * GET Header spacing default
 * *******************************************************
 */
if (!function_exists('gf_get_header_spacing_default')) {
    function &gf_get_header_spacing_default($header_layout)
    {
        $header_default = null;
        switch ($header_layout) {
            case 'header-3':
                $header_default = array(
                    'navigation_height'     => '84px',
                    'header_padding_top'    => '0',
                    'header_padding_bottom' => '0',
                    'logo_max_height'       => '121px',
                    'logo_padding_top'      => '0',
                    'logo_padding_bottom'   => '0',
                );
                break;
            case 'header-4':
                $header_default = array(
                    'navigation_height'     => '60px',
                    'header_padding_top'    => '0',
                    'header_padding_bottom' => '0',
                    'logo_max_height'       => '85px',
                    'logo_padding_top'      => '0',
                    'logo_padding_bottom'   => '0',
                );
                break;
                case 'header-5':
                $header_default = array(
                    'navigation_height'     => '60px',
                    'header_padding_top'    => '0',
                    'header_padding_bottom' => '0',
                    'logo_max_height'       => '145px',
                    'logo_padding_top'      => '0',
                    'logo_padding_bottom'   => '0',
                );
                break;
			case 'header-6':
				$header_default = array(
					'navigation_height'     => '60px',
					'header_padding_top'    => '0',
					'header_padding_bottom' => '0',
					'logo_max_height'       => '85px',
					'logo_padding_top'      => '0',
					'logo_padding_bottom'   => '0',
				);
				break;
            default:
                $header_default = array(
                    'navigation_height'     => '84px',
                    'header_padding_top'    => '0',
                    'header_padding_bottom' => '0',
                    'logo_max_height'       => '84px',
                    'logo_padding_top'      => '0',
                    'logo_padding_bottom'   => '0',
                );
        }
        return $header_default;
    }
}

/**
 * Get custome css variable
 * *******************************************************
 */
if (!function_exists('gf_get_custom_css_variable')) {
    function gf_get_custom_css_variable()
    {
        $header_layout = gf_get_option('header_layout', 'header-1');
        $header_spacing_default = &gf_get_header_spacing_default($header_layout);

        $header_responsive_breakpoint = gf_get_option('header_responsive_breakpoint', '991');
        $body_font = gf_get_option('body_font', array('font_family' => 'Poppins'));
        $secondary_font = gf_get_option('secondary_font', array('font_family' => 'Poppins'));
        $h1_font = gf_get_option('h1_font', array('font_family' => 'Poppins'));
        $h2_font = gf_get_option('h2_font', array('font_family' => 'Poppins'));
        $h3_font = gf_get_option('h3_font', array('font_family' => 'Poppins'));
        $h4_font = gf_get_option('h4_font', array('font_family' => 'Poppins'));
        $h5_font = gf_get_option('h5_font', array('font_family' => 'Poppins'));
        $h6_font = gf_get_option('h6_font', array('font_family' => 'Poppins'));

        $logo_max_height = gf_get_option('logo_max_height', array('height' => ''));
        if(!is_array($logo_max_height)) {
            $logo_max_height = array('height' => $logo_max_height);
        }
        $logo_max_height = gf_process_unit_value(isset($logo_max_height['height']) ? $logo_max_height['height'] : '', $header_spacing_default['logo_max_height']);

        $mobile_logo_max_height = gf_get_option('mobile_logo_max_height', array('height' => ''));
        $mobile_logo_max_height = gf_process_unit_value(isset($mobile_logo_max_height['height']) ? $mobile_logo_max_height['height'] : '', '50px');

        $logo_padding = gf_get_option('logo_padding', array('top' => '0', 'bottom' => '0'));
        $logo_padding = gf_process_spacing($logo_padding, array(
            'top'    => $header_spacing_default['logo_padding_top'],
            'bottom' => $header_spacing_default['logo_padding_bottom'],
        ));

        $mobile_logo_padding = gf_get_option('mobile_logo_padding', array('top' => '0', 'bottom' => '0'));
        $mobile_logo_padding = gf_process_spacing($mobile_logo_padding, array(
            'top'    => '0',
            'bottom' => '0',
        ));

        $top_drawer_padding = gf_get_option('top_drawer_padding', array('top' => '0', 'bottom' => '0'));
        $top_drawer_padding = gf_process_spacing($top_drawer_padding, array(
            'top'    => '0',
            'bottom' => '0',
        ));

        $top_bar_padding = gf_get_option('top_bar_padding', array('top' => '10', 'bottom' => '10'));
        $top_bar_padding = gf_process_spacing($top_bar_padding, array(
            'top'    => '0',
            'bottom' => '0',
        ));

        $top_bar_mobile_padding = gf_get_option('top_bar_mobile_padding', array('top' => '0', 'bottom' => '0'));
        $top_bar_mobile_padding = gf_process_spacing($top_bar_mobile_padding, array(
            'top'    => '0',
            'bottom' => '0',
        ));

        $header_padding = gf_get_option('header_padding', array('top' => '', 'bottom' => ''));
        $header_padding = gf_process_spacing($header_padding, array(
            'top'    => $header_spacing_default['header_padding_top'],
            'bottom' => $header_spacing_default['header_padding_bottom'],
        ));
        $navigation_height = gf_get_option('navigation_height', array('height' => ''));
        $navigation_height = gf_process_unit_value(isset($navigation_height['height']) ? $navigation_height['height'] : '', $header_spacing_default['navigation_height']);
		if (($header_layout == 'header-1') && ($header_layout == 'header-2')) {
			$navigation_height = $logo_max_height;
		}
        $navigation_spacing = gf_process_unit_value(gf_get_option('navigation_spacing', '40px'), '40px');
        $header_customize_nav_spacing = gf_process_unit_value(gf_get_option('header_customize_nav_spacing', '40px'), '40px');
        $header_customize_left_spacing = gf_process_unit_value(gf_get_option('header_customize_left_spacing', '40px'), '40px');
        $header_customize_right_spacing = gf_process_unit_value(gf_get_option('header_customize_right_spacing', '40px'), '40px');

        $footer_padding = gf_get_option('footer_padding', array('top' => '60', 'bottom' => '60'));
        $footer_padding = gf_process_spacing($footer_padding, array(
            'top'    => '60',
            'bottom' => '60',
        ));

        $bottom_bar_padding = gf_get_option('bottom_bar_padding', array('top' => '22', 'bottom' => '16'));
        $bottom_bar_padding = gf_process_spacing($bottom_bar_padding, array(
            'top'    => '22',
            'bottom' => '16',
        ));

        $header_float = gf_get_option('header_float', 0);

        /**
         * COLOR VARIABLE
         */
        $accent_color = gf_get_option('accent_color', '#92c800');
        $foreground_accent_color = gf_get_option('foreground_accent_color', '#fff');
        $text_color = gf_get_option('text_color', '#727272');
        $border_color = gf_get_option('border_color', '#ededed');
        $disable_color = gf_get_option('disable_color', '#bababa');
        $heading_color = gf_get_option('heading_color', '#222');
        $background_color = gf_get_option('background_color', '#f6f6f6');
        
        $top_drawer_bg_color = gf_get_option('top_drawer_bg_color', '#222');
        $top_drawer_text_color = gf_get_option('top_drawer_text_color', '#fff');
     
        $top_bar_bg_color = gf_get_option('top_bar_bg_color', '#222');
        $top_bar_text_color = gf_get_option('top_bar_text_color', '#fff');
        $top_bar_border_color = gf_get_option('top_bar_border_color', '#ededed');
	
		$header_bg_color = gf_get_option('header_bg_color', '#fff');
		$header_text_color = gf_get_option('header_text_color', '#222');
		$header_border_color = gf_get_option('header_border_color', '#ededed');

		$navigation_bg_color = gf_get_option('navigation_bg_color', '#fff');
        $navigation_text_color = gf_get_option('navigation_text_color', '#222');
        $navigation_text_color_hover = gf_get_option('navigation_text_color_hover', '#92c800');
        
        $top_bar_mobile_bg_color = gf_get_option('top_bar_mobile_bg_color', '#222');
        $top_bar_mobile_text_color = gf_get_option('top_bar_mobile_text_color', '#fff');
      
        $top_bar_mobile_border_color = gf_get_option('top_bar_mobile_border_color', '#ededed');
        $header_mobile_bg_color = gf_get_option('header_mobile_bg_color', '#fff');
        $header_mobile_text_color = gf_get_option('header_mobile_text_color', '#222');
        $header_mobile_border_color = gf_get_option('header_mobile_border_color', '#ededed');

        $footer_bg_color = gf_get_option('footer_bg_color', '#222');
        $footer_text_color = gf_get_option('footer_text_color', '#bababa');
        $footer_widget_title_color = gf_get_option('footer_widget_title_color', '#fff');
        $footer_border_color = gf_get_option('footer_border_color', '#393939');
        $bottom_bar_bg_color = gf_get_option('bottom_bar_bg_color', '#141414');
        $bottom_bar_text_color = gf_get_option('bottom_bar_text_color', '#bababa');
        $bottom_bar_border_color = gf_get_option('bottom_bar_border_color', '#393939');
        $body_font_size= $body_font["font_size"];
        $body_font_size= str_replace('px','',$body_font_size);
        $body_font_size=$body_font_size.'px';

        return <<<LESS_VARIABLE
			@responsive_breakpoint: {$header_responsive_breakpoint}px;
			@body_font: {$body_font["font_family"]};
			@body_font_size: {$body_font_size};
			@body_font_weight: {$body_font["font_weight"]};
			
			@secondary_font: {$secondary_font["font_family"]};
			@secondary_font_size: {$secondary_font["font_size"]}px;
			@secondary_font_weight: {$secondary_font["font_weight"]};
			
			@h1_font: {$h1_font["font_family"]};
			@h1_font_size: {$h1_font["font_size"]}px;
			@h1_font_weight: {$h1_font["font_weight"]};
			
			@h2_font: {$h2_font["font_family"]};
			@h2_font_size: {$h2_font["font_size"]}px;
			@h2_font_weight: {$h2_font["font_weight"]};
			
			@h3_font: {$h3_font["font_family"]};
			@h3_font_size: {$h3_font["font_size"]}px;
			@h3_font_weight: {$h3_font["font_weight"]};
			
			@h4_font: {$h4_font["font_family"]};
			@h4_font_size: {$h4_font["font_size"]}px;
			@h4_font_weight: {$h4_font["font_weight"]};
			
			@h5_font: {$h5_font["font_family"]};
			@h5_font_size: {$h5_font["font_size"]}px;
			@h5_font_weight: {$h5_font["font_weight"]};
			
			@h6_font: {$h6_font["font_family"]};
			@h6_font_size: {$h6_font["font_size"]}px;
			@h6_font_weight: {$h6_font["font_weight"]};

			@accent_color: {$accent_color};
			@foreground_accent_color: {$foreground_accent_color};
			@text_color: {$text_color};
			@border_color: {$border_color};
			@disable_color: {$disable_color};
			@heading_color: {$heading_color};
			@background_color: {$background_color};
			@top_drawer_bg_color: {$top_drawer_bg_color};
			@top_drawer_text_color: {$top_drawer_text_color};
			@header_bg_color: {$header_bg_color};
			@header_text_color: {$header_text_color};
			@header_border_color: {$header_border_color};
			@top_bar_bg_color: {$top_bar_bg_color};
			@top_bar_text_color: {$top_bar_text_color};
			@top_bar_border_color: {$top_bar_border_color};
			@navigation_bg_color: {$navigation_bg_color};
			@navigation_text_color: {$navigation_text_color};
			@navigation_text_color_hover: {$navigation_text_color_hover};

			@top_bar_mobile_bg_color: {$top_bar_mobile_bg_color};
			@top_bar_mobile_text_color: {$top_bar_mobile_text_color};
			@top_bar_mobile_border_color: {$top_bar_mobile_border_color};
			@header_mobile_bg_color: {$header_mobile_bg_color};
			@header_mobile_text_color: {$header_mobile_text_color};
			@header_mobile_border_color: {$header_mobile_border_color};

			@footer_bg_color: {$footer_bg_color};
			@footer_text_color: {$footer_text_color};
			@footer_widget_title_color: {$footer_widget_title_color};
			@footer_border_color: {$footer_border_color};
			@bottom_bar_bg_color: {$bottom_bar_bg_color};
			@bottom_bar_text_color: {$bottom_bar_text_color};
			@bottom_bar_border_color: {$bottom_bar_border_color};

			@top_drawer_padding_top: {$top_drawer_padding['top']};
			@top_drawer_padding_bottom: {$top_drawer_padding['bottom']};
			@top_bar_padding_top: {$top_bar_padding['top']};
			@top_bar_padding_bottom: {$top_bar_padding['bottom']};
			@top_bar_mobile_padding_top: {$top_bar_mobile_padding['top']};
			@top_bar_mobile_padding_bottom: {$top_bar_mobile_padding['bottom']};
			@header_padding_top: {$header_padding['top']};
			@header_padding_bottom: {$header_padding['bottom']};
			@navigation_height: {$navigation_height};
			@navigation_spacing: {$navigation_spacing};
			@header_customize_nav_spacing: {$header_customize_nav_spacing};
			@header_customize_left_spacing: {$header_customize_left_spacing};
			@header_customize_right_spacing: {$header_customize_right_spacing};

			@footer_padding_top: {$footer_padding['top']};
			@footer_padding_bottom: {$footer_padding['bottom']};
			@bottom_bar_padding_top: {$bottom_bar_padding['top']};
			@bottom_bar_padding_bottom: {$bottom_bar_padding['bottom']};

			@logo_max_height: {$logo_max_height};
			@mobile_logo_max_height: {$mobile_logo_max_height};
			@logo_padding_top: {$logo_padding['top']};
			@logo_padding_bottom: {$logo_padding['bottom']};
			@mobile_logo_padding_top: {$mobile_logo_padding['top']};
			@mobile_logo_padding_bottom: {$mobile_logo_padding['bottom']};

LESS_VARIABLE;
    }
}

/**
 * Generate less to css
 * *******************************************************
 */
if (!function_exists('gf_generate_less')) {
    function gf_generate_less($preset_id = 0)
    {
        $dir_css = array(
            'style' => trailingslashit(get_template_directory()),
            'other'   => trailingslashit(get_template_directory()) . 'assets/css/',
        );
        $options = $GLOBALS[GF_OPTIONS_NAME];
        if ($preset_id) {
            gf_load_preset_into_theme_options($GLOBALS[GF_OPTIONS_NAME], $preset_id);
            $preset_dir = gf_get_preset_dir();

            $dir_css['style'] = $preset_dir . $preset_id . '.';
            $dir_css['other'] = $preset_dir . $preset_id . '.';
        }
        try {
            if (!defined('FS_METHOD')) {
                define('FS_METHOD', 'direct');
            }

            require_once(ABSPATH . 'wp-admin/includes/file.php');
            WP_Filesystem();
            global $wp_filesystem;

            //////////////////////////////////////////////////////////////////
            // Gen File Style
            //////////////////////////////////////////////////////////////////

            $css = gf_get_less_to_css(true);
            if (!$wp_filesystem->put_contents($dir_css['style'] . "style.min.css", $css, FS_CHMOD_FILE)) {
                if ($preset_id) {
                    $GLOBALS[GF_OPTIONS_NAME] = $options;
                }
                return array(
                    'status'  => 'error',
                    'message' => esc_html__('Could not save file', 'benaa-framework')
                );
            }

            if (!$preset_id) {
                $theme_info = $wp_filesystem->get_contents(trailingslashit(get_template_directory()) . "theme-info.txt");

                $css = gf_get_less_to_css(false);
                $css = $theme_info . "\n" . $css;
                $css = str_replace("\r\n", "\n", $css);

                if (!$wp_filesystem->put_contents($dir_css['style'] . 'style.css', $css, FS_CHMOD_FILE)) {
                    if ($preset_id) {
                        $GLOBALS[GF_OPTIONS_NAME] = $options;
                    }
                    return array(
                        'status'  => 'error',
                        'message' => esc_html__('Could not save file', 'benaa-framework')
                    );
                }
            }

            //////////////////////////////////////////////////////////////////
            // Gen File RTL
            //////////////////////////////////////////////////////////////////
            $css = gf_get_less_to_css_rtl(true);
            if (!$wp_filesystem->put_contents($dir_css['other'] . "rtl.min.css", $css, FS_CHMOD_FILE)) {
                if ($preset_id) {
                    $GLOBALS[GF_OPTIONS_NAME] = $options;
                }
                return array(
                    'status'  => 'error',
                    'message' => esc_html__('Could not save file', 'benaa-framework')
                );
            }

            if ($preset_id) {
                $GLOBALS[GF_OPTIONS_NAME] = $options;
            }
            return array(
                'status'  => 'success',
                'message' => ''
            );

        } catch (Exception $e) {
            $error_message = $e->getMessage();
            if ($preset_id) {
                $GLOBALS[GF_OPTIONS_NAME] = $options;
            }
            return array(
                'status'  => 'error',
                'message' => $error_message
            );
        }
    }
}


if (!function_exists('gf_dev_less_to_css')) {
    function gf_dev_less_to_css()
    {
        /**
         * Make sure we set the correct MIME type
         */
        header('Content-Type: text/css');

        $preset_id = isset($_GET['preset_id']) ? $_GET['preset_id'] : 0;
        if ($preset_id) {
            gf_load_preset_into_theme_options($GLOBALS[GF_OPTIONS_NAME], $preset_id);
        }

        /**
         * Render Style CSS
         */
        echo gf_get_less_to_css();
        /**
         * Render Shortcodes CSS
         */
        $path_scan = GF_PLUGIN_DIR . 'shortcodes/';
        $path_to_assets = '/assets/css/';
        $root_files = scandir($path_scan);
        $css_variable = gf_get_custom_css_variable();

        if (!class_exists('Less_Parser')) {
            require_once GF_PLUGIN_DIR . 'core/less/Less.php';
        }

        foreach ($root_files as $entry) {
            if (($entry === '.') || ($entry === '..')) {
                continue;
            }
            if (is_dir($path_scan . $entry)) {
                /**
                 * Process assets/file
                 */
                if (file_exists("$path_scan$entry$path_to_assets")) {
                    $less_arr = scandir("$path_scan$entry$path_to_assets");
                    foreach ($less_arr as $less_file) {
                        if (($less_file === '.') || ($less_file === '..')) {
                            continue;
                        }
                        if (is_dir("$path_scan$entry$path_to_assets$less_file")) {
                            continue;
                        }
                        $less_file_exp = explode('.', $less_file);
                        $file_ex = array_pop($less_file_exp);
                        if ('less' === $file_ex) {
                            $parser = new Less_Parser(array('compress' => true));
                            $parser->parse($css_variable);
                            $parser->parseFile(G5PLUS_THEME_DIR . 'assets/less/variable.less');
                            $parser->parseFile("$path_scan$entry$path_to_assets$less_file");
                            echo $parser->getCss();
                        }
                    }
                }
            }
        }
        die();

    }

    add_action('wp_ajax_gf_dev_less_to_css', 'gf_dev_less_to_css');
    add_action('wp_ajax_nopriv_gf_dev_less_to_css', 'gf_dev_less_to_css');
}
if (!function_exists('gf_dev_less_to_css_rtl')) {
    function gf_dev_less_to_css_rtl()
    {
        /**
         * Make sure we set the correct MIME type
         */
        header('Content-Type: text/css');

        $preset_id = isset($_GET['preset_id']) ? $_GET['preset_id'] : 0;
        if ($preset_id) {
            gf_load_preset_into_theme_options($GLOBALS[GF_OPTIONS_NAME], $preset_id);
        }

        echo gf_get_less_to_css_rtl();
        die();
    }
    add_action('wp_ajax_gf_dev_less_to_css_rtl', 'gf_dev_less_to_css_rtl');
    add_action('wp_ajax_nopriv_gf_dev_less_to_css_rtl', 'gf_dev_less_to_css_rtl');
}

//==============================================================================
// HELPER
//==============================================================================

/**
 * Process spacing variable
 * *******************************************************
 */
if (!function_exists('gf_process_spacing')) {
    function gf_process_spacing($spacing, $default)
    {
        if ($spacing['top'] === '' || $spacing['top'] === 'px') {
            $spacing['top'] = $default['top'];
        }
        if ($spacing['bottom'] === '' || $spacing['bottom'] === 'px') {
            $spacing['bottom'] = $default['bottom'];
        }

        $spacing['top'] = str_replace('px', '', $spacing['top']);
        if (!is_numeric($spacing['top'])) {
            $spacing['top'] = 0;
        }
        $spacing['top'] .= 'px';

        $spacing['bottom'] = str_replace('px', '', $spacing['bottom']);
        if (!is_numeric($spacing['bottom'])) {
            $spacing['bottom'] = 0;
        }
        $spacing['bottom'] .= 'px';

        return $spacing;
    }
}

/**
 * Process unit px value variable
 * *******************************************************
 */
if (!function_exists('gf_process_unit_value')) {
    function gf_process_unit_value($value, $default)
    {
        if ($value === '' || $value === 'px') {
            $value = $default;
        }
        $value = str_replace('px', '', $value);
        if (!is_numeric($value)) {
            $value = 0;
        }
        $value .= 'px';

        return $value;
    }
}