<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 6/17/2016
 * Time: 10:18 AM
 */

/**
 * Load stylesheet
 */
if (!function_exists('g5plus_enqueue_styles')) {
    function g5plus_enqueue_styles()
    {
        $cdn_bootstrap_css = g5plus_get_option('cdn_bootstrap_css', '');
        $min_suffix = g5plus_get_option('enable_minifile_css', 0) == 1 ? '.min' : '';

        /*font-awesome*/
        $url_font_awesome = G5PLUS_THEME_URL . 'assets/plugins/fonts-awesome/css/font-awesome.min.css';
        $cdn_font_awesome = g5plus_get_option('cdn_font_awesome', '');
        if ($cdn_font_awesome) {
            $url_font_awesome = $cdn_font_awesome;
        }

        wp_enqueue_style('ere-font-awesome', $url_font_awesome, array(), '4.7.0', 'all');
        wp_enqueue_style('fontawesome-animation', G5PLUS_THEME_URL . 'assets/plugins/fonts-awesome/css/font-awesome-animation.min.css', array());
        // icomoon
        wp_enqueue_style('icomoon', G5PLUS_THEME_URL . 'assets/plugins/icomoon/css/icomoon'.$min_suffix.'.css', array());
        /*bootstrap*/
        $url_bootstrap = G5PLUS_THEME_URL . 'assets/plugins/bootstrap/css/bootstrap.min.css';
        if (!empty($cdn_bootstrap_css)) {
            $url_bootstrap = $cdn_bootstrap_css;
        }
        wp_enqueue_style('bootstrap', $url_bootstrap, array());
		wp_enqueue_script('bootstrap', G5PLUS_THEME_URL . 'assets/plugins/bootstrap/js/bootstrap.min.js', array('jquery'), '3.3.7', true);
        /*owl-carousel*/
        wp_enqueue_style('owl-carousel', G5PLUS_THEME_URL . 'assets/plugins/owl-carousel/assets/owl.carousel.min.css', array(), '2.1.0', 'all');

        /* light gallery */
        wp_enqueue_style('ligh-gallery', G5PLUS_THEME_URL . 'assets/plugins/light-gallery/css/lightgallery.min.css', array());

        /* perffect scrollbar */
        wp_enqueue_style('perffect-scrollbar', G5PLUS_THEME_URL . 'assets/plugins/perfect-scrollbar/css/perfect-scrollbar.min.css', array());

	    $preset_id = g5plus_get_current_preset();
	    /**
	     * Enqueue style.css
	     */
        if (!(defined('G5PLUS_SCRIPT_DEBUG') && G5PLUS_SCRIPT_DEBUG)) {
	        if (!$preset_id || !g5plus_enqueue_preset_style($preset_id, 'style')) {
		        wp_enqueue_style('g5plus-framework-style', G5PLUS_THEME_URL . 'style' . $min_suffix . '.css');
	        }
        } else {
            wp_enqueue_style('g5plus-dev-style-css', admin_url('admin-ajax.php') . '?action=gf_dev_less_to_css'
	            . ($preset_id ? '&amp;preset_id=' . $preset_id : ''), array(), false);
        }
        if (!class_exists('GF_Loader')) {
            wp_enqueue_style('google-fonts', 'http://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i');
        }
    }

    add_action('wp_enqueue_scripts', 'g5plus_enqueue_styles', 11);
}
/**
 * Load script
 */
if(!function_exists('g5plus_enqueue_script')){
    function g5plus_enqueue_script(){
        $enable_minifile_js = g5plus_get_option('enable_minifile_js',0);
        $min_suffix = (isset($enable_minifile_js) && $enable_minifile_js == 1) ? '.min' :  '';
        if (is_singular())	wp_enqueue_script('comment-reply');

        /*smooth-scroll*/
        $smooth_scroll = g5plus_get_option('smooth_scroll',0);
        if ( $smooth_scroll) {
            wp_enqueue_script('smooth-scroll', G5PLUS_THEME_URL . 'assets/plugins/smoothscroll/SmoothScroll' . $min_suffix . '.js', array('jquery'), false, true);
        }
        wp_enqueue_script('owl-carousel', G5PLUS_THEME_URL . 'assets/plugins/owl-carousel/owl.carousel.min.js', array('jquery'), '2.1.0', true);
        wp_register_script('hc-sticky',G5PLUS_THEME_URL. 'assets/plugins/hc-sticky/jquery.hc-sticky.min.js',array('jquery'),'1.2.43',true);
        wp_enqueue_script('light-gallery',G5PLUS_THEME_URL. 'assets/plugins/light-gallery/js/lightgallery-all.min.js',array('jquery'),'1.2.18',true);
        wp_enqueue_script('isotope',G5PLUS_THEME_URL. 'assets/plugins/isotope/isotope.pkgd.min.js',array('jquery'),'2.2.0',true);
        wp_enqueue_script('perfect-scrollbar',G5PLUS_THEME_URL. 'assets/plugins/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js',array('jquery'),'0.6.11',true);
        wp_enqueue_script('jquery-waypoints',G5PLUS_THEME_URL. 'assets/plugins/waypoints/jquery.waypoints.min.js',array('jquery'),'4.0.1',true);
        wp_enqueue_script('modernizr',G5PLUS_THEME_URL. 'assets/plugins/modernizr/modernizr.min.js',array('jquery'),'3.5.0',true);
        wp_enqueue_script('dialogfx',G5PLUS_THEME_URL. 'assets/plugins/dialogfx/dialogfx.min.js',array('jquery','modernizr'),'1.0.0',true);

        wp_enqueue_script('infinite-scroll',G5PLUS_THEME_URL. 'assets/plugins/infinite-scroll/infinite-scroll.pkgd.min.js',array('jquery'),'2.0.1',true);
        wp_enqueue_script('one-page-nav',G5PLUS_THEME_URL. 'assets/plugins/jquery.nav/jquery.nav.min.js',array('jquery'),'3.0.0',true);
        wp_enqueue_script('stellar',G5PLUS_THEME_URL. 'assets/plugins/stellar/stellar.min.js',array('jquery'),'0.6.2',true);
        wp_enqueue_script('countdown',G5PLUS_THEME_URL. 'assets/plugins/countdown/countdown.min.js',array('jquery'),'0.6.2',true);
        wp_enqueue_script('waypoints',G5PLUS_THEME_URL. 'assets/plugins/waypoints/jquery.waypoints.min.js',array('jquery'),'4.0.1',true);
        wp_enqueue_script('matchmedia',G5PLUS_THEME_URL. 'assets/plugins/matchmedia/matchmedia.min.js',array('jquery'),'4.0.1',true);


        wp_enqueue_script('g5plus-framework-app', G5PLUS_THEME_URL . 'assets/js/main' . $min_suffix . '.js', array('jquery','owl-carousel','imagesloaded','one-page-nav','stellar','countdown','matchmedia','perfect-scrollbar','infinite-scroll','dialogfx','modernizr','isotope','light-gallery','hc-sticky'), false, true);

        // Localize the script with new data
        $translation_array = array(
            'carousel_next' => esc_html__('Next','benaa'),
            'carousel_prev' => esc_html__('Back','benaa')
        );
        wp_localize_script('g5plus-framework-app', 'g5plus_framework_constant', $translation_array);
        wp_localize_script(
            'g5plus-framework-app',
            'g5plus_app_variable',
            array(
                'ajax_url' => get_site_url() . '/wp-admin/admin-ajax.php',
                'theme_url' => G5PLUS_THEME_URL,
                'site_url' => site_url()
            )
        );
    }
    add_action('wp_enqueue_scripts', 'g5plus_enqueue_script');
}

/**
 * Enqueue Preset Style
 * @preset_type: style, rtl, tta
 * *******************************************************
 */
if (!function_exists('g5plus_enqueue_preset_style')) {
	function g5plus_enqueue_preset_style($preset_id, $preset_type) {
		if (function_exists('gf_enqueue_preset_style')) {
			return gf_enqueue_preset_style($preset_id, $preset_type);
		}
		return false;
	}
}

/**
 * Load file rtl css
 * *******************************************************
 */
if (!function_exists('g5plus_enqueue_styles_rtl')) {
	function g5plus_enqueue_styles_rtl() {
		$preset_id = g5plus_get_current_preset();
		$enable_rtl_mode = g5plus_get_option('enable_rtl_mode', 0);
		/**
		 * Enqueue rtl.css
		 */
		if (is_rtl() || $enable_rtl_mode || isset($_GET['RTL'])) {
			if (!(defined('G5PLUS_SCRIPT_DEBUG') && G5PLUS_SCRIPT_DEBUG)) {
				if (!$preset_id || !g5plus_enqueue_preset_style($preset_id, 'rtl')) {
					wp_enqueue_style('g5plus-framework-rtl', G5PLUS_THEME_URL . 'assets/css/rtl.min.css');
				}
			}
			else {
				wp_enqueue_style( 'g5plus-framework-rtl', admin_url( 'admin-ajax.php' ) . '?action=gf_dev_less_to_css_rtl'
					. ($preset_id ? '&amp;preset_id=' . $preset_id : '') , array(), false );
			}
		}
	}
	add_action('wp_footer','g5plus_enqueue_styles_rtl');
}