<?php
/**
 * Class Dashboard
 *
 * @package WordPress
 * @subpackage benaa
 * @since benaa 1.0.1
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
include_once GF_PLUGIN_DIR . 'core/dashboard/inc/class-gf-dashboard-support.php';
include_once GF_PLUGIN_DIR . 'core/dashboard/inc/class-gf-dashboard-system-status.php';
if (!class_exists('GF_Dashboard')) {
	class GF_Dashboard
	{
		/**
		 * The instance of this object
		 *
		 * @var null|object
		 */
		private static $instance;

		/**
		 * Init GF_Dashboard
		 *
		 * @return GF_Dashboard|null|object
		 */
		public static function init()
		{
			if (self::$instance == NULL) {
				self::$instance = new self();
				self::$instance->afterInit();
			}
			return self::$instance;
		}


		public function afterInit() {
			// Auto Loader Class
			add_action('admin_menu', array($this, 'register_menu'));
			add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_styles'));
			add_action( 'admin_bar_menu', array( $this, 'register_admin_bar_menu' ), 81 );
		}

		public function register_menu()
		{
			$current_theme = wp_get_theme();
			$current_theme_name = $current_theme->get('Name');

			$pages = $this->get_config_pages();
			$parent_slug = '';
			$index = 0;
			foreach ($pages as $key => $value) {
				$function_binder = isset($value['function_binder']) ? $value['function_binder'] : '';
				if ($index === 0) {
					$parent_slug = "gf-{$key}";
					add_menu_page(
						sprintf(esc_html__('%s Dashboard', 'benaa-framework'), $current_theme_name),
						$current_theme_name,
						'manage_options',
						$parent_slug,
						$function_binder,
						'dashicons-admin-home',
						2
					);
				}
				if ($value['type'] == 'page') {
					add_submenu_page(
						$parent_slug,
						$value['page_title'],
						$value['menu_title'],
						'manage_options',
						"gf-{$key}",
						$function_binder
					);
				}
				if ($value['type'] == 'link') {
					if($key!='install-demo')
					{
						add_submenu_page(
							$parent_slug,
							$value['page_title'],
							$value['menu_title'],
							'manage_options',
							$value['link']
						);
					}
				}
				$index++;
			}
		}

		public function register_admin_bar_menu($wp_admin_bar){
			$current_theme = wp_get_theme();
			$current_theme_name = $current_theme->get('Name');

			$pages = $this->get_config_pages();
			$parent_slug = '';
			$index = 0;
			foreach ($pages as $key => $value) {
				$href = isset($value['link']) ? admin_url($value['link']) :  admin_url("admin.php?page=gf-{$key}");
				if ($index === 0) {
					$parent_slug = "gf-parent-{$key}";
					$wp_admin_bar->add_node(array(
						'id' => $parent_slug,
						'title' => sprintf('<span class="ab-icon"></span><span class="ab-label">%s</span>',$current_theme_name),
						//'href' => menu_page_url("gf-{$key}",false),
						'href' => $href
					));

					$wp_admin_bar->add_node(array(
						'id' => "gf-{$key}",
						'title' => $value['menu_title'],
						'href' => $href,
						'parent' => $parent_slug
					));

				} else {
					$wp_admin_bar->add_node(array(
						'id' => "gf-{$key}",
						'title' => $value['menu_title'],
						'href' => $href,
						'parent' => $parent_slug
					));
				}
				$index++;
			}
		}

		public function get_config_pages()
		{
			if (!class_exists('Essential_Real_Estate')) {
				return array(
					'system-status' => array(
						'page_title' => esc_html__('System Status', 'benaa-framework'),
						'menu_title' => esc_html__('System Status', 'benaa-framework'),
						'type' => 'page',
						'function_binder' => array($this->system_status(),'binder_page')
					),
					'support' => array(
						'page_title' => esc_html__('Support', 'benaa-framework'),
						'menu_title' => esc_html__('Support', 'benaa-framework'),
						'type' => 'page',
						'function_binder' => array($this->support(),'binder_page')
					),
					'install-demo' => array(
						'page_title' => esc_html__('Install Demo', 'benaa-framework'),
						'menu_title' => esc_html__('Install Demo', 'benaa-framework'),
						'type' => 'link',
						'link' => 'admin.php?page=gf_install_demo'
					),
					'theme-options' => array(
						'page_title' => esc_html__('Theme Options', 'benaa-framework'),
						'menu_title' => esc_html__('Theme Options', 'benaa-framework'),
						'type' => 'link',
						'link' => 'themes.php?page=benaa_options'
					),
					'preset-options' => array(
						'page_title' => esc_html__('Preset Options', 'benaa-framework'),
						'menu_title' => esc_html__('Preset Options', 'benaa-framework'),
						'type' => 'link',
						'link' => 'edit.php?post_type=gf_preset'
					),
					'custom_footer' => array(
						'page_title' => esc_html__('Custom Footer', 'benaa-framework'),
						'menu_title' => esc_html__('Custom Footer', 'benaa-framework'),
						'type' => 'link',
						'link' => 'edit.php?post_type=gf_footer'
					),
				);
			}
			else
			{
				return array(
					'system-status' => array(
						'page_title' => esc_html__('System Status', 'benaa-framework'),
						'menu_title' => esc_html__('System Status', 'benaa-framework'),
						'type' => 'page',
						'function_binder' => array($this->system_status(),'binder_page')
					),
					'support' => array(
						'page_title' => esc_html__('Support', 'benaa-framework'),
						'menu_title' => esc_html__('Support', 'benaa-framework'),
						'type' => 'page',
						'function_binder' => array($this->support(),'binder_page')
					),
					'install-demo' => array(
						'page_title' => esc_html__('Install Demo', 'benaa-framework'),
						'menu_title' => esc_html__('Install Demo', 'benaa-framework'),
						'type' => 'link',
						'link' => 'admin.php?page=gf_install_demo'
					),
					'theme-options' => array(
						'page_title' => esc_html__('Theme Options', 'benaa-framework'),
						'menu_title' => esc_html__('Theme Options', 'benaa-framework'),
						'type' => 'link',
						'link' => 'themes.php?page=benaa_options'
					),
					'ere-options' => array(
						'page_title' => esc_html__('Real Estate Options', 'benaa-framework'),
						'menu_title' => esc_html__('Real Estate Options', 'benaa-framework'),
						'type' => 'link',
						'link' => 'themes.php?page=ere_options'
					),
					'preset-options' => array(
						'page_title' => esc_html__('Preset Options', 'benaa-framework'),
						'menu_title' => esc_html__('Preset Options', 'benaa-framework'),
						'type' => 'link',
						'link' => 'edit.php?post_type=gf_preset'
					),
					'custom_footer' => array(
						'page_title' => esc_html__('Custom Footer', 'benaa-framework'),
						'menu_title' => esc_html__('Custom Footer', 'benaa-framework'),
						'type' => 'link',
						'link' => 'edit.php?post_type=gf_footer'
					),
				);
			}
		}

		/**
		 * System Status Object
		 *
		 * @return GF_Dashboard_System_Status|null|object
		 */
		public function system_status() {
			return GF_Dashboard_System_Status::init();
		}

		/**
		 * Support Object
		 *
		 * @return GF_Dashboard_Support|null|object
		 */
		public function support() {
			return GF_Dashboard_Support::init();
		}

		public function admin_enqueue_styles() {
			if (!$this->is_dashboard_page()) return;
			wp_enqueue_style(GF_PLUGIN_PREFIX.'dashboard',GF_PLUGIN_URL.'core/dashboard/assets/css/dashboard.css');
		}


		/**
		 * Check is dashboard page
		 *
		 * @param string $page
		 * @return bool
		 */
		public function is_dashboard_page($page = '') {
			global $pagenow;
			if ($pagenow === 'admin.php' && !empty($_GET['page'])) {
				$current_page = $_GET['page'];
				$current_page = preg_replace('/gf-/','',$current_page);
				if ($page) {
					return $current_page === $page;
				} else {
					$pages = $this->get_config_pages();
					return array_key_exists($current_page,$pages);
				}
			}
			return false;
		}
	}

	function gfDashboard() {
		return GF_Dashboard::init();
	}

	gfDashboard();
}