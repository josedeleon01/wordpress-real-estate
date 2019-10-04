<?php
/**
 *    Plugin Name: Benaa Framework
 *    Plugin URI: http://g5plus.net
 *    Description: The Benaa Framework plugin.
 *    Version: 1.1
 *    Author: G5Theme
 *    Author URI: http://g5plus.net
 *
 *    Text Domain: benaa-framework
 *    Domain Path: /languages/
 *
 * @package Benaa Framework
 * @category Core
 * @author g5plus
 *
 **/
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!class_exists('GF_Loader')) {
    class GF_Loader
    {
        public function __construct()
        {
            $this->define_constants();
            $this->load_textdomain();
            $this->includes();

            add_action('admin_enqueue_scripts', array(&$this, 'enqueue_admin_resources'));
            add_action('wp_enqueue_scripts', array(&$this, 'enqueue_frontend_resources'),100);
            add_action('admin_enqueue_scripts',array($this,'dequeue_style'),100);

            add_action( 'plugins_loaded',array(&$this, 'include_vc_shortcode') );

            add_action('wp_ajax_popup_icon', array(&$this,'popup_icon'));
            add_action('wp_loaded',array(&$this,'set_global_theme_options'));
            add_action( 'wp_footer', array($this,'enqueue_custom_script') );
        }

        //==============================================================================
        // Define constant
        //==============================================================================
        private function define_constants()
        {
            $plugin_dir_name = dirname(__FILE__);
            $plugin_dir_name = str_replace('\\', '/', $plugin_dir_name);
            $plugin_dir_name = explode('/', $plugin_dir_name);
            $plugin_dir_name = end($plugin_dir_name);

            if (!defined('GF_PLUGIN_NAME')) {
                define('GF_PLUGIN_NAME', $plugin_dir_name);
            }

            if (!defined('GF_PLUGIN_DIR')) {
                define('GF_PLUGIN_DIR', plugin_dir_path(__FILE__));
            }
            if (!defined('GF_PLUGIN_URL')) {
                define('GF_PLUGIN_URL', trailingslashit(plugins_url(GF_PLUGIN_NAME)));
            }

            if (!defined('GF_PLUGIN_PREFIX')) {
                define('GF_PLUGIN_PREFIX', 'g5plus_framework_');
            }

            if (!defined('GF_METABOX_PREFIX')) {
                define('GF_METABOX_PREFIX', 'g5plus_framework_');
            }

            if (!defined('GF_OPTIONS_NAME')) {
                define('GF_OPTIONS_NAME', 'benaa_options');
            }
        }
        //==============================================================================
        // Load Textdomain
        //==============================================================================
        public function load_textdomain() {
            $mofile = GF_PLUGIN_DIR . 'languages/' . 'benaa-framework-' . get_locale() .'.mo';

            if (file_exists($mofile)) {
                load_textdomain('benaa-framework', $mofile );
            }
        }
        //==============================================================================
        // Include library for plugin
        //==============================================================================
        private function includes()
        {
            // dashboard
            include_once GF_PLUGIN_DIR . 'core/dashboard/class-gf-dashboard.php';
            // Dynamic Widget Areas
            include_once GF_PLUGIN_DIR . 'core/widget-areas/widget-areas.php';
            /**
             * custom post type
             */
            include_once GF_PLUGIN_DIR . 'cpt/cpt.php';

            /**
             * Include less library
             */
            include_once GF_PLUGIN_DIR . 'core/less/Less.php';

            /**
             * Include less functions
             */
            include_once GF_PLUGIN_DIR . 'inc/less-functions.php';

            /**
             * Include functions
             */
            include_once GF_PLUGIN_DIR . 'inc/functions.php';
            /**
             * Custom Widget CSS
             */
            include_once GF_PLUGIN_DIR . 'core/widget-custom-class.php';

            /**
             * Include Action
             */
            include_once GF_PLUGIN_DIR . 'inc/action.php';

            /**
             * Include Filters
             */
            include_once GF_PLUGIN_DIR . 'inc/filter.php';

            /**
             * Include Post Type
             */
            include_once GF_PLUGIN_DIR . 'inc/post-type.php';
            /**
             * Include install demo data
             */
            include_once GF_PLUGIN_DIR . 'core/install-demo/install-demo.php';
            /**
             * Include theme-options
             */
            include_once GF_PLUGIN_DIR . 'inc/options-functions.php';
            include_once GF_PLUGIN_DIR . 'inc/options-config.php';

            /**
             * Include MetaBox
             * *******************************************************
             */
            include_once GF_PLUGIN_DIR . 'inc/meta-boxes.php';


            /**
             * Include XMENU
             */
            include_once GF_PLUGIN_DIR . 'core/xmenu/xmenu.php';



            /**
             * Include widget
             */
            include_once GF_PLUGIN_DIR . 'widgets/widgets.php';

        }

        //////////////////////////////////////////////////////////////////
        // Dequeue Style
        //////////////////////////////////////////////////////////////////
        public function dequeue_style(){
            $screen         = get_current_screen();
            $screen_id      = $screen ? $screen->id : '';
            $screen_ids   = array(
                'widgets',
                'toplevel_page__options'
            );

            if ( in_array( $screen_id, $screen_ids ) ) {
                wp_dequeue_style('jquery-ui-overcast');
                wp_deregister_script('select2');
            }
        }

        //==============================================================================
        // Enqueue admin resources
        //==============================================================================
        public function enqueue_admin_resources()
        {
            add_thickbox();
            // select2
            $min_suffix = gf_get_option('enable_minifile_js') ? '.min' : '';
            wp_enqueue_style('rwmb-select2',plugins_url(GF_PLUGIN_NAME. '/assets/plugins/select2/css/select2.min.css'),array(),'4.0.2','all');
            wp_enqueue_script('rwmb-select2',plugins_url(GF_PLUGIN_NAME . '/assets/plugins/select2/js/select2'. $min_suffix .'.js'),array('jquery'),'4.0.2',true);
            // datetimepicker
            wp_enqueue_style('rwmb-datetimepicker',plugins_url(GF_PLUGIN_NAME. '/assets/plugins/datetimepicker/css/datetimepicker.min.css'),array(),false,'all');

            wp_enqueue_style(GF_PLUGIN_PREFIX . 'admin', plugins_url(GF_PLUGIN_NAME . '/assets/css/admin.min.css'), array(), false, 'all');
            wp_enqueue_script(GF_PLUGIN_PREFIX.'media',plugins_url(GF_PLUGIN_NAME . '/assets/js/g5plus-media-init'. $min_suffix .'.js'),array(),false,true);
            wp_enqueue_script(GF_PLUGIN_PREFIX.'popup-icon',plugins_url(GF_PLUGIN_NAME . '/assets/js/popup-icon'. $min_suffix .'.js'),array(),false,true);
            wp_localize_script(GF_PLUGIN_PREFIX . 'popup-icon', 'g5plus_framework_meta', array(
                'ajax_url' => admin_url('admin-ajax.php')
            ));
        }

        //==============================================================================
        // Enqueue frontend resources
        //==============================================================================
        public function enqueue_frontend_resources()
        {
            $min_suffix = gf_get_option('enable_minifile_js') ? '.min' : '';
            wp_enqueue_style(GF_PLUGIN_PREFIX . 'frontend', plugins_url(GF_PLUGIN_NAME . '/assets/css/frontend'.$min_suffix.'.css'), array(), false, 'all');
        }

        public function enqueue_custom_script(){
            $custom_js = gf_get_option('custom_js', '');
            if ( $custom_js ) {
                echo sprintf('<script type="text/javascript">%s</script>',$custom_js);
            }
        }

        public function include_vc_shortcode(){
            /**
             * Include shortcodes
             */
            if (class_exists('Vc_Manager')) {
                include_once GF_PLUGIN_DIR . 'shortcodes/shortcodes.php';
            }
        }
        public function set_global_theme_options() {
            if (!isset($GLOBALS[GF_OPTIONS_NAME])) {
                $GLOBALS[GF_OPTIONS_NAME] = get_option(GF_OPTIONS_NAME);
                if (!is_array($GLOBALS[GF_OPTIONS_NAME])) {
                    $GLOBALS[GF_OPTIONS_NAME] = array();
                }
            }
        }
        public function popup_icon(){
            $font_awesome = &gf_get_font_awesome();
            $font_theme_icon = &gf_get_theme_font();
            ob_start();
            ?>
            <div id="g5plus-framework-popup-icon-wrapper">
                <div class="popup-icon-wrapper">
                    <div class="popup-content">
                        <div class="popup-search-icon">
                            <input placeholder="Search" type="text" id="txtSearch">
                            <div class="preview">
                                <span></span> <a id="iconPreview" href="javascript:"><i class="fa fa-home"></i></a>
                            </div>
                            <div style="clear: both;"></div>
                        </div>
                        <div class="list-icon">
                            <h3><?php esc_html_e('Font Icomoon','benaa-framework') ?></h3>
                            <ul id="group-1">
                                <?php foreach ($font_theme_icon as $icon) {
                                    $arrkey=array_keys($icon);
                                    ?>
                                    <li><a title="<?php echo esc_attr($arrkey[0]); ?>" href="javascript:"><i class="<?php echo esc_attr($arrkey[0]); ?>"></i></a></li>
                                    <?php

                                } ?>
                            </ul>
                            <br>
                            <h3><?php esc_html_e('Font Awesome','benaa-framework') ?></h3>
                            <ul id="group-2">
                                <?php foreach ($font_awesome as $icon) {
                                    $arrkey=array_keys($icon);
                                    ?>
                                    <li><a title="<?php echo esc_attr($arrkey[0]); ?>" href="javascript:"><i class="<?php echo esc_attr($arrkey[0]); ?>"></i></a></li>
                                    <?php

                                } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="popup-bottom">
                        <a id="btnSave" href="javascript:" class="button button-primary"><?php esc_html_e('Insert Icon','benaa-framework') ?></a>
                    </div>
                </div>
            </div>
            <?php
            die();

        }
    }


    /**
     * Instantiate the G5PLUS FRAMEWORK loader class.
     */
    $gf_loader = new GF_Loader();
}
if (!class_exists('GSF_SmartFramework')) {
    add_filter('gsf_plugin_url', 'gf_plugin_url', 1);
    function gf_plugin_url()
    {
        return GF_PLUGIN_URL . 'inc/smart-framework/';
    }
    require_once GF_PLUGIN_DIR . 'inc/smart-framework/smart-framework.php';
}