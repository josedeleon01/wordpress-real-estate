<?php
/**
 * The template for displaying options-config
 *
 * @package WordPress
 * @subpackage benaa
 * @since benaa 1.0
 */

if (!function_exists('gf_font_options')) {
	function gf_font_options($options_list)
	{
		$options_list[] = 'benaa_options';
		return $options_list;
	}
	
	add_filter('gsf_options_font', 'gf_font_options');
}
/**
 * Define Theme Options
 * *******************************************************
 */
add_filter('gsf_option_config', 'gf_define_theme_options');
if (!function_exists('gf_define_theme_options')) {
	function gf_define_theme_options($configs)
	{
		$configs[GF_OPTIONS_NAME] = array(
			'layout'      => 'horizontal',
			'page_title'  => esc_html__('Theme Options', 'benaa-framework'),
			'menu_title'  => esc_html__('Theme Options', 'benaa-framework'),
			'option_name' => GF_OPTIONS_NAME,
			'permission'  => 'edit_theme_options',
			'section'     => array(
				
				/**
				 * General
				 */
				gf_get_config_section_general(),
				
				/**
				 * Layout
				 */
				gf_get_config_section_layout(),
				
				/**
				 * Page Title
				 */
				gf_get_config_section_page_title(),
				
				/**
				 * Blog
				 */
				gf_get_config_section_blog(),
				
				/**
				 * Logo
				 */
				gf_get_config_section_logo(),
				
				/**
				 * Top Drawer
				 */
				gf_get_config_section_top_drawer(),
				
				/**
				 * Top Bar
				 */
				gf_get_config_section_top_bar(),
				
				/**
				 * Header
				 */
				gf_get_config_section_header(),
				
				/**
				 * Header Customize
				 */
				gf_get_config_section_header_customize(),
				
				/**
				 * Footer
				 */
				gf_get_config_section_footer(),
				
				/**
				 * Theme Colors
				 */
				gf_get_config_section_theme_colors(),
				
				/**
				 * Font Options
				 */
				gf_get_config_section_font_options(),
				
				/**
				 * Social Profiles
				 */
				gf_get_config_section_social_profiles(),
				
				/**
				 * Resources Options
				 */
				gf_get_config_section_resources_options(),
				
				/**
				 * Custome Css & Scrip
				 */
				gf_get_config_custom_css_script_options(),
				
				/**
				 * Preset Settings
				 */
				
				gf_get_config_preset_setting_options(),
			),
		);
		return $configs;
	}
}

/**
 * Get Config Section General
 * *******************************************************
 */
if (!function_exists('gf_get_config_section_general')) {
	function gf_get_config_section_general()
	{
		$list_post_type = array();
		$post_type_preset = apply_filters('gf_post_type_preset', array());
		foreach ($post_type_preset as $key => $value) {
			$list_post_type[$key] = $value['name'];
		}
		return array(
			'id'     => 'section_general',
			'title'  => esc_html__('General', 'benaa-framework'),
			'icon'   => 'dashicons dashicons-admin-multisite',
			'fields' => array(
				/**
				 * General
				 */
				array(
					'id'     => 'section_general_group_general',
					'title'  => esc_html__('General', 'benaa-framework'),
					'type'   => 'group',
					'fields' => array(
						array(
							'id'     => 'section_general_scroll_option',
							'title'  => esc_html__('Scroll Options', 'benaa-framework'),
							'type'   => 'group',
							'fields' => array(
								array(
									'id'       => 'smooth_scroll',
									'type'     => 'button_set',
									'title'    => esc_html__('Smooth Scroll', 'benaa-framework'),
									'subtitle' => esc_html__('Enable/Disable Smooth Scroll', 'benaa-framework'),
									'desc'     => '',
									'options'  => gf_get_toggle(),
									'default'  => 0
								),
								
								array(
									'id'       => 'custom_scroll',
									'type'     => 'button_set',
									'title'    => esc_html__('Custom Scroll', 'benaa-framework'),
									'subtitle' => esc_html__('Enable/Disable Custom Scroll', 'benaa-framework'),
									'desc'     => '',
									'options'  => gf_get_toggle(),
									'default'  => 0
								),
								
								array(
									'id'       => 'custom_scroll_width',
									'type'     => 'text',
									'title'    => esc_html__('Custom Scroll Width', 'benaa-framework'),
									'subtitle' => esc_html__('This must be numeric (no px) or empty.', 'benaa-framework'),
									'validate' => 'numeric',
									'default'  => '10',
									'required' => array('custom_scroll', '=', 1),
								),
								
								array(
									'id'       => 'custom_scroll_color',
									'type'     => 'color',
									'title'    => esc_html__('Custom Scroll Color', 'benaa-framework'),
									'subtitle' => esc_html__('Set Custom Scroll Color', 'benaa-framework'),
									'default'  => '#19394B',
									'validate' => 'color',
									'required' => array('custom_scroll', '=', 1),
								),
								
								array(
									'id'       => 'custom_scroll_thumb_color',
									'type'     => 'color',
									'title'    => esc_html__('Custom Scroll Thumb Color', 'benaa-framework'),
									'subtitle' => esc_html__('Set Custom Scroll Thumb Color', 'benaa-framework'),
									'default'  => '#1086df',
									'validate' => 'color',
									'required' => array('custom_scroll', '=', 1),
								)
							)
						),
						
						array(
							'id'     => 'section_general_group_search_popup',
							'title'  => esc_html__('Search Popup', 'benaa-framework'),
							'type'   => 'group',
							'fields' => array(
								array(
									'id'      => 'search_popup_type',
									'type'    => 'button_set',
									'title'   => esc_html__('Search Popup Type', 'benaa-framework'),
									'options' => array(
										'standard' => esc_html__('Standard', 'benaa-framework'),
										'ajax'     => esc_html__('Ajax', 'benaa-framework')
									),
									'default' => 'standard'
								),
								array(
									'id'       => 'search_popup_post_type',
									'type'     => 'selectize',
									'title'    => esc_html__('Post Type For Ajax Search', 'benaa-framework'),
									'options'  => array_merge(
										gf_get_search_ajax_popup_post_type(),
										$list_post_type
									),
									'multiple' => true,
									'default'  => array('post'),
									'required' => array('search_popup_type', '=', 'ajax'),
								),
								array(
									'id'         => 'search_popup_result_amount',
									'type'       => 'text',
									'input_type' => 'number',
									'title'      => esc_html__('Amount Of Search Result', 'benaa-framework'),
									'subtitle'   => esc_html__('This must be numeric (no px) or empty (default: 8).', 'benaa-framework'),
									'default'    => 8,
									'required'   => array('search_popup_type', '=', 'ajax'),
								),
							)
						),
						array(
							'id'     => 'section_general_other_option',
							'title'  => esc_html__('Other Options', 'benaa-framework'),
							'type'   => 'group',
							'fields' => array(
								array(
									'id'       => 'back_to_top',
									'type'     => 'button_set',
									'title'    => esc_html__('Back To Top', 'benaa-framework'),
									'subtitle' => esc_html__('Enable/Disable Back to top button', 'benaa-framework'),
									'desc'     => '',
									'options'  => gf_get_toggle(),
									'default'  => 1
								),
								
								array(
									'id'       => 'enable_rtl_mode',
									'type'     => 'button_set',
									'title'    => esc_html__('Enable RTL mode', 'benaa-framework'),
									'subtitle' => esc_html__('Enable/Disable RTL mode', 'benaa-framework'),
									'desc'     => '',
									'options'  => gf_get_toggle(),
									'default'  => 0
								),
								
								array(
									'id'       => 'social_meta_enable',
									'type'     => 'button_set',
									'title'    => esc_html__('Enable Social Meta Tags', 'benaa-framework'),
									'subtitle' => esc_html__('Enable the social meta head tag output.', 'benaa-framework'),
									'desc'     => '',
									'options'  => gf_get_toggle(),
									'default'  => 0
								),
								
								array(
									'id'       => 'menu_transition',
									'type'     => 'button_set',
									'title'    => esc_html__('Menu transition', 'benaa-framework'),
									'subtitle' => esc_html__('Select menu transition', 'benaa-framework'),
									'desc'     => '',
									'options'  => array(
										'none'                  => esc_html__('None', 'benaa-framework'),
										'x-animate-slide-up'    => esc_html__('Slide Up', 'benaa-framework'),
										'x-animate-slide-down'  => esc_html__('Slide Down', 'benaa-framework'),
										'x-animate-slide-left'  => esc_html__('Slide Left', 'benaa-framework'),
										'x-animate-slide-right' => esc_html__('Slide Right', 'benaa-framework'),
										'x-animate-sign-flip'   => esc_html__('Sign Flip', 'benaa-framework'),
									),
									'default'  => 'x-animate-sign-flip'
								),
							)
						),
					)
				),
				/**
				 * Maintenance
				 */
				array(
					'id'             => 'section_general_group_maintenance',
					'title'          => esc_html__('Maintenance', 'benaa-framework'),
					'type'           => 'group',
					'toggle_default' => false,
					'fields'         => array(
						array(
							'id'      => 'maintenance_mode',
							'type'    => 'button_set',
							'title'   => esc_html__('Maintenance Mode', 'benaa-framework'),
							'options' => gf_get_maintenance_mode(),
							'default' => '0'
						),
						array(
							'id'          => 'maintenance_mode_page',
							'title'       => esc_html__('Maintenance Mode Page', 'benaa-framework'),
							'subtitle'    => esc_html__('Select the page that is your maintenance page, if you would like to show a custom page instead of the standard WordPress message. You should use the Holding Page template for this page.', 'benaa-framework'),
							'type'        => 'selectize',
							'allow_clear' => true,
							'placeholder' => esc_html__('Select Page', 'benaa-framework'),
							'data'        => 'page',
							'data_args'   => array(
								'numberposts' => -1
							),
							'edit_link'   => true,
							'default'     => '',
							'required'    => array('maintenance_mode', '=', '2'),
						
						),
					)
				),
				/**
				 * Performance
				 */
				array(
					'id'             => 'section_general_group_performance',
					'title'          => esc_html__('Performance', 'benaa-framework'),
					'type'           => 'group',
					'toggle_default' => false,
					'fields'         => array(
						array(
							'id'       => 'enable_minifile_js',
							'type'     => 'button_set',
							'title'    => esc_html__('Enable Mini File JS', 'benaa-framework'),
							'subtitle' => esc_html__('Turn On this option if you want to use mini file js', 'benaa-framework'),
							'options'  => gf_get_toggle(),
							'default'  => 0
						),
						array(
							'id'       => 'enable_minifile_css',
							'type'     => 'button_set',
							'title'    => esc_html__('Enable Mini File CSS', 'benaa-framework'),
							'subtitle' => esc_html__('Turn On this option if you want to use mini file css', 'benaa-framework'),
							'options'  => gf_get_toggle(),
							'default'  => 0
						),
					
					)
				),
				/**
				 * Page Transition Section
				 * *******************************************************
				 */
				array(
					'id'             => 'section_general_group_page_transition',
					'title'          => esc_html__('Page Transition', 'benaa-framework'),
					'type'           => 'group',
					'toggle_default' => false,
					'fields'         => array(
						array(
							'id'       => 'page_transition',
							'type'     => 'button_set',
							'title'    => esc_html__('Page Transition', 'benaa-framework'),
							'subtitle' => esc_html__('Turn On this option if you want to enable page transition', 'benaa-framework'),
							'options'  => gf_get_toggle(),
							'default'  => 0
						),
						array(
							'id'          => 'loading_animation',
							'type'        => 'selectize',
							'allow_clear' => true,
							'title'       => esc_html__('Loading Animation', 'benaa-framework'),
							'subtitle'    => esc_html__('Select type of pre load animation', 'benaa-framework'),
							'placeholder' => esc_html__('Select Loading', 'benaa-framework'),
							'options'     => gf_get_loading_animation(),
							'default'     => ''
						),
						array(
							'id'       => 'loading_logo',
							'type'     => 'image',
							'title'    => esc_html__('Logo Loading', 'benaa-framework'),
							'required' => array('loading_animation', '!=', ''),
						),
					)
				),
				/**
				 * Custom Favicon
				 * *******************************************************
				 */
				array(
					'id'             => 'section_general_group_custom_favicon',
					'title'          => esc_html__('Custom Favicon', 'benaa-framework'),
					'type'           => 'group',
					'toggle_default' => false,
					'fields'         => array(
						array(
							'id'       => 'custom_favicon',
							'type'     => 'image',
							'title'    => esc_html__('Custom favicon', 'benaa-framework'),
							'subtitle' => esc_html__('Upload a 16px x 16px Png/Gif/ico image that will represent your website favicon', 'benaa-framework'),
						),
						array(
							'id'       => 'custom_ios_title',
							'type'     => 'text',
							'title'    => esc_html__('Custom iOS Bookmark Title', 'benaa-framework'),
							'subtitle' => esc_html__('Enter a custom title for your site for when it is added as an iOS bookmark.', 'benaa-framework'),
							'default'  => ''
						),
						array(
							'id'       => 'custom_ios_icon57',
							'type'     => 'image',
							'title'    => esc_html__('Custom iOS 57x57', 'benaa-framework'),
							'subtitle' => esc_html__('Upload a 57px x 57px Png image that will be your website bookmark on non-retina iOS devices.', 'benaa-framework'),
						),
						array(
							'id'       => 'custom_ios_icon72',
							'type'     => 'image',
							'title'    => esc_html__('Custom iOS 72x72', 'benaa-framework'),
							'subtitle' => esc_html__('Upload a 72px x 72px Png image that will be your website bookmark on non-retina iOS devices.', 'benaa-framework'),
						),
						array(
							'id'       => 'custom_ios_icon114',
							'type'     => 'image',
							'title'    => esc_html__('Custom iOS 114x114', 'benaa-framework'),
							'subtitle' => esc_html__('Upload a 114px x 114px Png image that will be your website bookmark on retina iOS devices.', 'benaa-framework'),
						),
						array(
							'id'       => 'custom_ios_icon144',
							'type'     => 'image',
							'title'    => esc_html__('Custom iOS 144x144', 'benaa-framework'),
							'subtitle' => esc_html__('Upload a 144px x 144px Png image that will be your website bookmark on retina iOS devices.', 'benaa-framework'),
						),
					)
				),
				/**
				 * 404 Setting Section
				 * *******************************************************
				 */
				array(
					'id'             => 'section_general_group_404',
					'title'          => esc_html__('404 Page', 'benaa-framework'),
					'type'           => 'group',
					'toggle_default' => false,
					'fields'         => array(
						array(
							'id'      => '404_sub_title',
							'type'    => 'text',
							'title'   => esc_html__('Sub Title', 'benaa-framework'),
							'default' => "This page not be found"
						),
						array(
							'id'      => '404_description',
							'type'    => 'text',
							'title'   => esc_html__('Description', 'benaa-framework'),
							'default' => "We are really sorry, but the page you requested is missing.. Perhaps searching again can help."
						),
						array(
							'id'      => '404_bg_image',
							'type'    => 'image',
							'url'     => true,
							'title'   => esc_html__('404 Background', 'benaa-framework'),
							'desc'    => '',
							'default' => get_template_directory_uri() . '/assets/images/bg-404.jpg'
						),
						array(
							'id'      => '404_return_text_link',
							'type'    => 'text',
							'title'   => esc_html__('Return Text Link', 'benaa-framework'),
							'default' => "home page"
						),
						array(
							'id'       => '404_return_link',
							'type'     => 'text',
							'title'    => esc_html__('Return Link', 'benaa-framework'),
							'subtitle' => esc_html__('If link null, link default is home page', 'benaa-framework'),
							'default'  => ""
						),
					)
				),
			)
		);
	}
}

/**
 * Get Config Section Layout
 * *******************************************************
 */
if (!function_exists('gf_get_config_section_layout')) {
	function gf_get_config_section_layout()
	{
		return array(
			'id'     => 'section_layout',
			'title'  => esc_html__('Layout', 'benaa-framework'),
			'icon'   => 'dashicons dashicons-editor-table',
			'fields' => array_merge(
				array(
					array(
						'id'     => 'section_layout_group_general',
						'title'  => esc_html__('General', 'benaa-framework'),
						'type'   => 'group',
						'fields' => array(
							array(
								'id'     => 'section_layout_option_general',
								'title'  => esc_html__('Layout Options', 'benaa-framework'),
								'type'   => 'group',
								'fields' => array(
									array(
										'id'       => 'layout_style',
										'type'     => 'image_set',
										'title'    => esc_html__('Layout Style', 'benaa-framework'),
										'subtitle' => esc_html__('Select the layout style', 'benaa-framework'),
										'desc'     => '',
										'options'  => gf_get_layout_style(),
										'default'  => 'wide'
									),
									array(
										'id'       => 'body_background_mode',
										'type'     => 'button_set',
										'title'    => esc_html__('Body Background Mode', 'benaa-framework'),
										'subtitle' => esc_html__('Chose Background Mode', 'benaa-framework'),
										'desc'     => '',
										'options'  => array(
											'background' => esc_html__('Background', 'benaa-framework'),
											'pattern'    => esc_html__('Pattern', 'benaa-framework')
										),
										'default'  => 'background',
										'required' => array('layout_style', '=', 'boxed'),
									),
									array(
										'id'       => 'body_background',
										'type'     => 'background',
										'output'   => array('body'),
										'title'    => esc_html__('Body Background', 'benaa-framework'),
										'subtitle' => esc_html__('Body background (Apply for Boxed layout style).', 'benaa-framework'),
										'required' => array(
											array('layout_style', '=', 'boxed'),
											array('body_background_mode', '=', array('background'))
										),
									),
									array(
										'id'       => 'body_background_pattern',
										'type'     => 'image_set',
										'title'    => esc_html__('Background Pattern', 'benaa-framework'),
										'subtitle' => esc_html__('Body background pattern(Apply for Boxed layout style)', 'benaa-framework'),
										'desc'     => '',
										'height'   => '40px',
										'options'  => array(
											'pattern-1.png' => GF_PLUGIN_URL . 'assets/images/theme-options/pattern-1.png',
											'pattern-2.png' => GF_PLUGIN_URL . 'assets/images/theme-options/pattern-2.png',
											'pattern-3.png' => GF_PLUGIN_URL . 'assets/images/theme-options/pattern-3.png',
											'pattern-4.png' => GF_PLUGIN_URL . 'assets/images/theme-options/pattern-4.png',
											'pattern-5.png' => GF_PLUGIN_URL . 'assets/images/theme-options/pattern-5.png',
											'pattern-6.png' => GF_PLUGIN_URL . 'assets/images/theme-options/pattern-6.png',
											'pattern-7.png' => GF_PLUGIN_URL . 'assets/images/theme-options/pattern-7.png',
											'pattern-8.png' => GF_PLUGIN_URL . 'assets/images/theme-options/pattern-8.png',
										),
										'default'  => 'pattern-1.png',
										'required' => array(
											array('layout_style', '=', 'boxed'),
											array('body_background_mode', '=', array('pattern'))
										),
									),
									gf_get_page_layout('layout'),
									array(
										'id'      => 'sidebar_width',
										'title'   => esc_html__('Sidebar Width', 'benaa-framework'),
										'type'    => 'button_set',
										'options' => gf_get_sidebar_width(),
										'default' => 'large',
									),
									array(
										'id'       => 'sidebar_sticky_enable',
										'type'     => 'button_set',
										'title'    => esc_html__('Sidebar Sticky', 'benaa-framework'),
										'subtitle' => esc_html__('Turn On this option if you want to enable sidebar sticky', 'benaa-framework'),
										'desc'     => '',
										'options'  => gf_get_toggle(),
										'default'  => 1
									),
								)
							),
							array(
								'id'     => 'section_layout_group_main_content',
								'title'  => esc_html__('Main Content', 'benaa-framework'),
								'type'   => 'group',
								'fields' => array(
									gf_get_config_sidebar_layout('sidebar_layout'),
									gf_get_config_sidebar('sidebar', array('sidebar_layout', '!=', 'none')),
									gf_get_content_padding('content_padding', array(), array('top' => 100, 'bottom' => 100))
								)
							),
							
							array(
								'id'     => 'section_layout_group_mobile',
								'title'  => esc_html__('Mobile', 'benaa-framework'),
								'type'   => 'group',
								'fields' => array(
									gf_get_sidebar_mobile_enable('sidebar_mobile_enable', array('sidebar_layout', '!=', 'none'), 1),
									gf_get_sidebar_mobile_canvas('sidebar_mobile_canvas', array(
										array('sidebar_layout', '!=', 'none'),
										array('sidebar_mobile_enable', '=', '1'),
									), 1),
									gf_get_mobile_content_padding('content_padding_mobile')
								)
							),
						)
					),
				),
				gf_get_config_custom_layout()
			)
		);
	}
}

/**
 * Page Title Section
 * *******************************************************
 */
if (!function_exists('gf_get_config_section_page_title')) {
	function gf_get_config_section_page_title()
	{
		return array(
			'id'     => 'section_page_title',
			'title'  => esc_html__('Page Title', 'benaa-framework'),
			'icon'   => 'dashicons dashicons-star-filled',
			'fields' => array_merge(
				array(
					array(
						'id' => 'section_page_title_group_general',
						'title' => esc_html__('General', 'beyot-framework'),
						'type' => 'group',
						'fields' => array(
							gf_get_page_title_enable('page_title_enable'),
							gf_get_page_title_layout_style('page_title_layout_style', array('page_title_enable', '=', 1)),
							gf_get_title_enable('title_enable', array("page_title_enable", '=', '1'),1),
							gf_get_page_sub_title('page_sub_title',array(
								array('page_title_enable', '=', 1),
								array('title_enable', '=', 1),
							)),
							gf_get_page_title_padding('page_title_padding', array('page_title_enable', '=', 1)),
							gf_get_page_title_background_image('page_title_bg_image', array(
								array("page_title_enable", '=', '1'),
								array("page_title_layout_style", '=', 'large')
							), GF_PLUGIN_URL . 'assets/images/theme-options/page-title.jpg'),
							gf_get_page_title_parallax('page_title_parallax', array(
								array('page_title_enable', '=', 1),
								array('page_title_bg_image[id]', '!=', ''),
								array("page_title_layout_style", '=', 'large')
							)),
							gf_get_breadcrumb_enable('breadcrumbs_enable', array('page_title_enable', '=', 1)),
						)
					)
				),
				gf_get_config_custom_page_title()
			)
		);
	}
}

/**
 * Blog Section
 * *******************************************************
 */
if (!function_exists('gf_get_config_section_blog')) {
	function gf_get_config_section_blog()
	{
		return array(
			'id'     => 'section_blog',
			'title'  => esc_html__('Blog Setting', 'benaa-framework'),
			'icon'   => 'dashicons dashicons-media-document',
			'fields' => array_merge(
				array(
					array(
						'id'     => 'blog_start',
						'type'   => 'group',
						'title'  => esc_html__('Blog Options', 'benaa-framework'),
						'fields' => array(
							array(
								'id'       => 'post_layout',
								'type'     => 'select',
								'title'    => esc_html__('Post Layout', 'benaa-framework'),
								'subtitle' => '',
								'desc'     => '',
								'select2'  => array('allowClear' => false),
								'options'  => gf_get_post_layout(),
								'default'  => 'large-image'
							),
							array(
								'id'       => 'post_column',
								'type'     => 'select',
								'title'    => esc_html__('Post Columns', 'benaa-framework'),
								'subtitle' => '',
								'options'  => gf_get_post_columns(),
								'desc'     => '',
								'default'  => 3,
								'select2'  => array('allowClear' => false),
								'required' => array('post_layout', 'in', array('grid', 'masonry')),
							),
							array(
								'id'       => 'post_paging',
								'type'     => 'button_set',
								'title'    => esc_html__('Post Paging', 'benaa-framework'),
								'subtitle' => '',
								'desc'     => '',
								'options'  => gf_get_paging_style(),
								'default'  => 'navigation'
							),
						)
					),
					
					array(
						'id'     => 'single_blog_start',
						'type'   => 'group',
						'title'  => esc_html__('Single Blog Options', 'benaa-framework'),
						'fields' => array(
							array(
								'id'       => 'single_title_enable',
								'type'     => 'button_set',
								'title'    => esc_html__('Post Title', 'benaa-framework'),
								'subtitle' => esc_html__('Turn Off this option if you want to hide title on single blog', 'benaa-framework'),
								'desc'     => '',
								'options'  => gf_get_toggle(),
								'default'  => 0
							),
							array(
								'id'       => 'single_tag_enable',
								'type'     => 'button_set',
								'title'    => esc_html__('Tags', 'benaa-framework'),
								'subtitle' => esc_html__('Turn Off this option if you want to hide tags on single blog', 'benaa-framework'),
								'desc'     => '',
								'options'  => gf_get_toggle(),
								'default'  => 1
							),
							
							array(
								'id'       => 'single_share_enable',
								'type'     => 'button_set',
								'title'    => esc_html__('Share', 'benaa-framework'),
								'subtitle' => esc_html__('Turn Off this option if you want to hide share on single blog', 'benaa-framework'),
								'desc'     => '',
								'options'  => gf_get_toggle(),
								'default'  => 1
							),
							
							array(
								'id'       => 'single_navigation_enable',
								'type'     => 'button_set',
								'title'    => esc_html__('Navigation', 'benaa-framework'),
								'subtitle' => esc_html__('Turn Off this option if you want to hide navigation on single blog', 'benaa-framework'),
								'desc'     => '',
								'options'  => gf_get_toggle(),
								'default'  => 0
							),
							array(
								'id'       => 'single_author_info_enable',
								'type'     => 'button_set',
								'title'    => esc_html__('Author Info', 'benaa-framework'),
								'subtitle' => esc_html__('Turn Off this option if you want to hide author info area on single blog', 'benaa-framework'),
								'desc'     => '',
								'options'  => gf_get_toggle(),
								'default'  => 0
							),
							
							array(
								'id'       => 'single_related_post_enable',
								'type'     => 'button_set',
								'title'    => esc_html__('Related Post', 'benaa-framework'),
								'subtitle' => esc_html__('Turn Off this option if you want to hide related post area on single blog', 'benaa-framework'),
								'desc'     => '',
								'options'  => gf_get_toggle(),
								'default'  => 1
							),
							
							array(
								'id'       => 'single_related_post_total',
								'type'     => 'text',
								'title'    => esc_html__('Related Post Total', 'benaa-framework'),
								'subtitle' => esc_html__('Total record of Related Post. (Input Number Only)', 'benaa-framework'),
								'pattern'  => '[0-9]*',
								'default'  => 6,
								'required' => array('single_related_post_enable', '=', 1),
							),
							
							array(
								'id'       => 'single_related_post_column',
								'type'     => 'select',
								'title'    => esc_html__('Related Post Columns', 'benaa-framework'),
								'default'  => 3,
								'options'  => array(2 => '2', 3 => '3'),
								'select2'  => array('allowClear' => false),
								'required' => array('single_related_post_enable', '=', 1),
							),
							
							array(
								'id'       => 'single_related_post_condition',
								'type'     => 'checkbox_list',
								'title'    => esc_html__('Related Post Condition', 'benaa-framework'),
								'options'  => array(
									'category' => esc_html__('Same Category', 'benaa-framework'),
								),
								'default'  => array(
									'category' => '1',
								),
								'required' => array('single_related_post_enable', '=', 1),
							),
						)
					),
				),
				array()
			)
		);
	}
}

/**
 * Get Config Section logo
 * *******************************************************
 */
if (!function_exists('gf_get_config_section_logo')) {
	function gf_get_config_section_logo()
	{
		return array(
			'id'     => 'section_logo',
			'title'  => esc_html__('Logo Setting', 'benaa-framework'),
			'icon'   => 'dashicons dashicons-carrot',
			'fields' => array(
				array(
					'id'     => 'section_logo_desktop',
					'type'   => 'group',
					'title'  => esc_html__('Logo Desktop', 'benaa-framework'),
					'fields' => array(
						array(
							'id'       => 'logo',
							'type'     => 'image',
							'url'      => true,
							'title'    => esc_html__('Logo', 'benaa-framework'),
							'subtitle' => esc_html__('Upload your logo here.', 'benaa-framework'),
							'desc'     => '',
							'default'  => ''
						),
						array(
							'id'       => 'logo_retina',
							'type'     => 'image',
							'url'      => true,
							'title'    => esc_html__('Logo Retina', 'benaa-framework'),
							'subtitle' => esc_html__('Upload your logo retina here.', 'benaa-framework'),
							'desc'     => '',
							'default'  => ''
						),
						array(
							'id'       => 'sticky_logo',
							'type'     => 'image',
							'url'      => true,
							'title'    => esc_html__('Sticky Logo', 'benaa-framework'),
							'subtitle' => esc_html__('Upload a sticky version of your logo here', 'benaa-framework'),
							'desc'     => '',
							'default'  => ''
						),
						array(
							'id'       => 'sticky_logo_retina',
							'type'     => 'image',
							'url'      => true,
							'title'    => esc_html__('Sticky Logo Retina', 'benaa-framework'),
							'subtitle' => esc_html__('Upload a sticky version of your logo retina here', 'benaa-framework'),
							'desc'     => '',
							'default'  => ''
						),
						array(
							'id'      => 'logo_max_height',
							'type'    => 'dimension',
							'title'   => esc_html__('Logo Max Height', 'benaa-framework'),
							'desc'    => esc_html__('You can set a max height for the logo here', 'benaa-framework'),
							'units'   => false,
							'width'   => false,
							'default' => array(
								'height' => ''
							)
						),
						array(
							'id'             => 'logo_padding',
							'type'           => 'spacing',
							'mode'           => 'padding',
							'units'          => 'px',
							'units_extended' => 'false',
							'title'          => esc_html__('Logo Top/Bottom Padding', 'benaa-framework'),
							'subtitle'       => esc_html__('This must be numeric (no px). Leave balnk for default.', 'benaa-framework'),
							'desc'           => esc_html__('If you would like to override the default logo top/bottom padding, then you can do so here.', 'benaa-framework'),
							'left'           => false,
							'right'          => false,
							'default'        => array(
								'padding-top'    => '',
								'padding-bottom' => '',
							)
						),
					)
				),
				
				array(
					'id'     => 'section-logo-mobile',
					'type'   => 'group',
					'title'  => esc_html__('Logo Mobile', 'benaa-framework'),
					'fields' => array(
						array(
							'id'       => 'mobile_logo',
							'type'     => 'image',
							'url'      => true,
							'title'    => esc_html__('Mobile Logo', 'benaa-framework'),
							'subtitle' => esc_html__('Upload your logo here.', 'benaa-framework'),
							'desc'     => '',
							'default'  => ''
						),
						array(
							'id'       => 'mobile_logo_retina',
							'type'     => 'image',
							'url'      => true,
							'title'    => esc_html__('Mobile Logo Retina', 'benaa-framework'),
							'subtitle' => esc_html__('Upload your logo retina here.', 'benaa-framework'),
							'desc'     => '',
							'default'  => ''
						),
						array(
							'id'      => 'mobile_logo_max_height',
							'type'    => 'dimension',
							'title'   => esc_html__('Mobile Logo Max Height', 'benaa-framework'),
							'desc'    => esc_html__('You can set a max height for the logo mobile here', 'benaa-framework'),
							'units'   => false,
							'width'   => false,
							'default' => array(
								'height' => ''
							)
						),
						array(
							'id'             => 'mobile_logo_padding',
							'type'           => 'spacing',
							'mode'           => 'padding',
							'units'          => 'px',
							'units_extended' => 'false',
							'title'          => esc_html__('Logo Top/Bottom Padding', 'benaa-framework'),
							'subtitle'       => esc_html__('This must be numeric (no px). Leave balnk for default.', 'benaa-framework'),
							'desc'           => esc_html__('If you would like to override the default logo top/bottom padding, then you can do so here.', 'benaa-framework'),
							'left'           => false,
							'right'          => false,
							'default'        => array(
								'padding-top'    => '',
								'padding-bottom' => '',
							)
						)
					)
				),
			)
		);
	}
}

/**
 * Get Config Section Top Drawer
 * *******************************************************
 */
if (!function_exists('gf_get_config_section_top_drawer')) {
	function gf_get_config_section_top_drawer()
	{
		return array(
			'id'     => 'section_top_drawer',
			'title'  => esc_html__('Top Drawer', 'benaa-framework'),
			'icon'   => 'dashicons dashicons-archive',
			'fields' => array(
				array(
					'id'      => 'top_drawer_type',
					'title'   => esc_html__('Top Drawer Mode', 'benaa-framework'),
					'type'    => 'button_set',
					'options' => gf_get_top_drawer_mode(),
					'default' => 'hide'
				),
				gf_get_config_sidebar('top_drawer_sidebar', array('top_drawer_type', '!=', 'hide')),
				
				array(
					'id'       => 'top_drawer_wrapper_layout',
					'type'     => 'button_set',
					'title'    => esc_html__('Top Drawer Wrapper Layout', 'benaa-framework'),
					'subtitle' => esc_html__('Select top drawer wrapper layout', 'benaa-framework'),
					'desc'     => '',
					'options'  => array(
						'full'            => esc_html__('Full Width', 'benaa-framework'),
						'container'       => esc_html__('Container', 'benaa-framework'),
						'container-fluid' => esc_html__('Container Fluid', 'benaa-framework')
					),
					'default'  => 'container',
					'required' => array('top_drawer_type', '!=', 'hide'),
				),
				
				array(
					'id'       => 'top_drawer_hide_mobile',
					'type'     => 'button_set',
					'title'    => esc_html__('Show/Hide Top Drawer on mobile', 'benaa-framework'),
					'desc'     => '',
					'options'  => array(
						'1' => esc_html__('On', 'benaa-framework'),
						'0' => esc_html__('Off', 'benaa-framework')
					),
					'default'  => '1',
					'required' => array('top_drawer_type', '!=', 'hide'),
				),
				array(
					'id'             => 'top_drawer_padding',
					'type'           => 'spacing',
					'mode'           => 'padding',
					'units'          => 'px',
					'units_extended' => 'false',
					'title'          => esc_html__('Top/Bottom Padding', 'benaa-framework'),
					'subtitle'       => esc_html__('This must be numeric (no px). Leave balnk for default.', 'benaa-framework'),
					'desc'           => esc_html__('If you would like to override the default top drawer top/bottom padding, then you can do so here.', 'benaa-framework'),
					'left'           => false,
					'right'          => false,
					'default'        => array(
						'padding-top'    => '',
						'padding-bottom' => '',
					),
					'required'       => array('top_drawer_type', '!=', 'hide'),
				)
			)
		);
	}
}


/**
 * Get Config Section Top Bar
 * *******************************************************
 */
if (!function_exists('gf_get_config_section_top_bar')) {
	function gf_get_config_section_top_bar()
	{
		return array(
			'id'     => 'section_top_bar',
			'title'  => esc_html__('Top Bar', 'benaa-framework'),
			'icon'   => 'dashicons dashicons-welcome-widgets-menus',
			'fields' => array(
				gf_get_config_group_top_bar('section_header_group_top_bar', esc_html__('Desktop', 'benaa-framework'), 'top_bar'),
				gf_get_config_group_top_bar('section_header_group_top_bar_mobile', esc_html__('Mobile', 'benaa-framework'), 'top_bar_mobile')
			)
		);
	}
}


/**
 * Get Config Section Header
 * *******************************************************
 */
if (!function_exists('gf_get_config_section_header')) {
	function gf_get_config_section_header()
	{
		return array(
			'id'     => 'section_header',
			'title'  => esc_html__('Header', 'benaa-framework'),
			'icon'   => 'dashicons dashicons-editor-kitchensink',
			'fields' => array(
				array(
					'id'       => 'header_responsive_breakpoint',
					'type'     => 'button_set',
					'title'    => esc_html__('Header responsive breakpoint', 'benaa-framework'),
					'subtitle' => esc_html__('Set header responsive breakpoint', 'benaa-framework'),
					'desc'     => '',
					'options'  => array(
						'1199' => esc_html__('Large Devices: < 1200px', 'benaa-framework'),
						'991'  => esc_html__('Medium Devices: < 992px', 'benaa-framework'),
						'767'  => esc_html__('Tablet Portrait: < 768px', 'benaa-framework'),
					),
					'default'  => '991'
				),
				array(
					'id'     => 'section-header-desktop',
					'type'   => 'group',
					'title'  => esc_html__('Desktop Settings', 'benaa-framework'),
					'fields' => array(
						array(
							'id'      => 'header_layout',
							'type'    => 'image_set',
							'title'   => esc_html__('Header Layout', 'benaa-framework'),
							'desc'    => '',
							'options' => array(
								'header-1' => GF_PLUGIN_URL . 'assets/images/theme-options/header-1.png',
								'header-2' => GF_PLUGIN_URL . 'assets/images/theme-options/header-2.png',
								'header-3' => GF_PLUGIN_URL . 'assets/images/theme-options/header-3.png',
								'header-4' => GF_PLUGIN_URL . 'assets/images/theme-options/header-4.png',
								'header-5' => GF_PLUGIN_URL . 'assets/images/theme-options/header-5.png',
								'header-6' => GF_PLUGIN_URL . 'assets/images/theme-options/header-6.png',
							),
							'default' => 'header-1'
						),
						array(
							'id'      => 'header_container_layout',
							'type'    => 'button_set',
							'title'   => esc_html__('Header container layout', 'benaa-framework'),
							'options' => array(
								'container'       => esc_html__('Container', 'benaa-framework'),
								'container-fluid' => esc_html__('Container Fluid', 'benaa-framework'),
							),
							'default' => 'container'
						),
						array(
							'id'       => 'header_float',
							'type'     => 'button_set',
							'title'    => esc_html__('Header Float', 'benaa-framework'),
							'subtitle' => esc_html__('Enable/Disable Header Float.', 'benaa-framework'),
							'desc'     => '',
							'options'  => gf_get_toggle(),
							'default'  => '0',
						),
						array(
							'id'       => 'header_sticky',
							'type'     => 'button_set',
							'title'    => esc_html__('Show/Hide Header Sticky', 'benaa-framework'),
							'subtitle' => esc_html__('Show Hide header Sticky.', 'benaa-framework'),
							'desc'     => '',
							'options'  => gf_get_toggle(),
							'default'  => '1'
						),
						array(
							'id'       => 'header_search_property',
							'type'     => 'button_set',
							'title'    => esc_html__('Show/Hide Header Search Property', 'benaa-framework'),
							'subtitle' => esc_html__('Show Hide header search property.', 'benaa-framework'),
							'desc'     => '',
							'options'  => gf_get_toggle(),
							'default'  => '0'
						),
						array(
							'id'       => 'header_search_fields',
							'type'     => 'sortable',
							'title'    => esc_html__('Show / Hide / Arrange Search Fields', 'benaa-framework'),
							'desc'     => esc_html__('Drag and drop layout manager, to quickly organize your form search layout.', 'benaa-framework'),
							'required' => array('header_search_property', '=', 1),
							'options'  => array(
								'property_title'        => esc_html__('Title', 'benaa-framework'),
								'property_status'       => esc_html__('Status', 'benaa-framework'),
								'property_city'         => esc_html__('City / Town', 'benaa-framework'),
								'property_type'         => esc_html__('Type', 'benaa-framework'),
								'property_address'      => esc_html__('Address', 'benaa-framework'),
								'property_country'      => esc_html__('Country', 'benaa-framework'),
								'property_state'        => esc_html__('Province / State', 'benaa-framework'),
								'property_neighborhood' => esc_html__('Neighborhood', 'benaa-framework'),
								'property_bedrooms'     => esc_html__('Bedrooms', 'benaa-framework'),
								'property_bathrooms'    => esc_html__('Bathrooms', 'benaa-framework'),
								'property_price'        => esc_html__('Price', 'benaa-framework'),
								'property_size'         => esc_html__('Size', 'benaa-framework'),
								'property_land'         => esc_html__('Land Area', 'benaa-framework'),
								'property_label'        => esc_html__('Label', 'benaa-framework'),
								'property_garage'       => esc_html__('Garage', 'benaa-framework'),
								'property_identity'     => esc_html__('Property ID', 'benaa-framework')
							),
							'default'  => array(
								'property_title', 'property_status', 'property_city'
							)
						),
						array(
							'id'       => 'header_border_bottom',
							'type'     => 'button_set',
							'title'    => esc_html__('Header border bottom', 'benaa-framework'),
							'subtitle' => esc_html__('Set header border bottom', 'benaa-framework'),
							'desc'     => '',
							'options'  => array(
								'none'             => esc_html__('None', 'benaa-framework'),
								'full-border'      => esc_html__('Full Border', 'benaa-framework'),
								'container-border' => esc_html__('Container Border', 'benaa-framework'),
							),
							'default'  => 'none',
						),
						array(
							'id'             => 'header_padding',
							'type'           => 'spacing',
							'mode'           => 'padding',
							'units'          => 'px',
							'units_extended' => 'false',
							'title'          => esc_html__('Header Top/Bottom Padding', 'benaa-framework'),
							'subtitle'       => esc_html__('This must be numeric (no px). Leave balnk for default.', 'benaa-framework'),
							'desc'           => esc_html__('If you would like to override the default header top/bottom padding, then you can do so here.', 'benaa-framework'),
							'left'           => false,
							'right'          => false,
							'default'        => array(
								'padding-top'    => '0',
								'padding-bottom' => '0',
							),
						),
						array(
							'id'      => 'navigation_height',
							'type'    => 'dimension',
							'title'   => esc_html__('Navigation height', 'benaa-framework'),
							'desc'    => esc_html__('Set header navigation height (px). Do not include unit. Empty to default', 'benaa-framework'),
							'units'   => false,
							'width'   => false,
							'default' => array(
								'height' => ''
							),
						),
						array(
							'id'         => 'navigation_spacing',
							'type'       => 'slider',
							'title'      => esc_html__('Navigation Spacing (px)', 'benaa-framework'),
							'default'    => '45',
							'js_options' => array(
								'step' => 1,
								'min'  => 0,
								'max'  => 100
							)
						),
					)
				),
				
				//---------------------------------------------------------------
				array(
					'id'     => 'section-header-mobile',
					'type'   => 'group',
					'title'  => esc_html__('Mobile Settings', 'benaa-framework'),
					'fields' => array(
						array(
							'id'       => 'mobile_header_layout',
							'type'     => 'image_set',
							'title'    => esc_html__('Header Layout', 'benaa-framework'),
							'subtitle' => esc_html__('Select header mobile layout', 'benaa-framework'),
							'desc'     => '',
							'options'  => array(
								'header-mobile-1' => GF_PLUGIN_URL . 'assets/images/theme-options/header-mobile-layout-1.png',
								'header-mobile-2' => GF_PLUGIN_URL . 'assets/images/theme-options/header-mobile-layout-2.png',
								'header-mobile-3' => GF_PLUGIN_URL . 'assets/images/theme-options/header-mobile-layout-3.png',
								'header-mobile-4' => GF_PLUGIN_URL . 'assets/images/theme-options/header-mobile-layout-4.png',
							),
							'default'  => 'header-mobile-1'
						),
						array(
							'id'       => 'mobile_header_menu_drop',
							'type'     => 'button_set',
							'title'    => esc_html__('Menu Drop Type', 'benaa-framework'),
							'subtitle' => esc_html__('Set menu drop type for mobile header', 'benaa-framework'),
							'desc'     => '',
							'options'  => array(
								'menu-drop-fly'      => esc_html__('Fly Menu', 'benaa-framework'),
								'menu-drop-dropdown' => esc_html__('Dropdown Menu', 'benaa-framework'),
							),
							'default'  => 'menu-drop-fly'
						),
						array(
							'id'       => 'mobile_header_stick',
							'type'     => 'button_set',
							'title'    => esc_html__('Stick Mobile Header', 'benaa-framework'),
							'subtitle' => esc_html__('Enable Stick Mobile Header.', 'benaa-framework'),
							'desc'     => '',
							'options'  => array('1' => esc_html__('On', 'benaa-framework'), '0' => esc_html__('Off', 'benaa-framework')),
							'default'  => '0'
						),
						array(
							'id'       => 'mobile_header_search_box',
							'type'     => 'button_set',
							'title'    => esc_html__('Search Box', 'benaa-framework'),
							'subtitle' => esc_html__('Enable Search Box.', 'benaa-framework'),
							'desc'     => '',
							'options'  => array('1' => esc_html__('Show', 'benaa-framework'), '0' => esc_html__('Hide', 'benaa-framework')),
							'default'  => '0'
						),
						array(
							'id'       => 'mobile_header_search_property',
							'type'     => 'button_set',
							'title'    => esc_html__('Show/Hide Header Search Property', 'benaa-framework'),
							'subtitle' => esc_html__('Show Hide header search property.', 'benaa-framework'),
							'desc'     => '',
							'options'  => gf_get_toggle(),
							'default'  => '0'
						),
						array(
							'id'       => 'mobile_header_search_fields',
							'type'     => 'sortable',
							'title'    => esc_html__('Show / Hide / Arrange Search Fields', 'benaa-framework'),
							'desc'     => esc_html__('Drag and drop layout manager, to quickly organize your form search layout.', 'benaa-framework'),
							'required' => array('mobile_header_search_property', '=', 1),
							'options'  => array(
								'property_title'        => esc_html__('Title', 'benaa-framework'),
								'property_status'       => esc_html__('Status', 'benaa-framework'),
								'property_city'         => esc_html__('City / Town', 'benaa-framework'),
								'property_type'         => esc_html__('Type', 'benaa-framework'),
								'property_address'      => esc_html__('Address', 'benaa-framework'),
								'property_country'      => esc_html__('Country', 'benaa-framework'),
								'property_state'        => esc_html__('Province / State', 'benaa-framework'),
								'property_neighborhood' => esc_html__('Neighborhood', 'benaa-framework'),
								'property_bedrooms'     => esc_html__('Bedrooms', 'benaa-framework'),
								'property_bathrooms'    => esc_html__('Bathrooms', 'benaa-framework'),
								'property_price'        => esc_html__('Price', 'benaa-framework'),
								'property_size'         => esc_html__('Size', 'benaa-framework'),
								'property_land'         => esc_html__('Land Area', 'benaa-framework'),
								'property_label'        => esc_html__('Label', 'benaa-framework'),
								'property_garage'       => esc_html__('Garage', 'benaa-framework'),
								'property_identity'     => esc_html__('Property ID', 'benaa-framework')
							),
							'default'  => array(
								'property_title'
							)
						),
						array(
							'id'       => 'mobile_header_login',
							'type'     => 'button_set',
							'title'    => esc_html__('Login & Register', 'benaa-framework'),
							'subtitle' => esc_html__('Enable Login & Register', 'benaa-framework'),
							'desc'     => '',
							'options'  => array('1' => esc_html__('Show', 'benaa-framework'), '0' => esc_html__('Hide', 'benaa-framework')),
							'default'  => '1'
						),
						array(
							'id'      => 'mobile_header_border_bottom',
							'type'    => 'button_set',
							'title'   => esc_html__('Mobile header border bottom', 'benaa-framework'),
							'options' => array(
								'none'             => esc_html__('None', 'benaa-framework'),
								'full-border'      => esc_html__('Full Border', 'benaa-framework'),
								'container-border' => esc_html__('Container Border', 'benaa-framework'),
							),
							'default' => 'none',
						),
					)
				),
			)
		);
	}
}

/**
 * Get Config Section Header Customize
 * *******************************************************
 */
if (!function_exists('gf_get_config_section_header_customize')) {
	function gf_get_config_section_header_customize()
	{
		return array(
			'id'     => 'section_header_customize',
			'title'  => esc_html__('Header Customize', 'benaa-framework'),
			'icon'   => 'dashicons dashicons-editor-kitchensink',
			'fields' => array(
				array(
					'id'       => 'section-header-customize-left',
					'type'     => 'group',
					'title'    => esc_html__('Header Customize Left', 'benaa-framework'),
					'required' => array('header_layout', 'in', 'header-5'),
					'fields'   => array(
						array(
							'id'      => 'header_customize_left',
							'type'    => 'sortable',
							'title'   => 'Header customize left',
							'desc'    => 'Organize how you want the layout to appear on the header left',
							'options' => array(
								'search'      => esc_html__('Search', 'benaa-framework'),
								'sidebar'     => esc_html__('Sidebar', 'benaa-framework'),
								'custom-text' => esc_html__('Custom Text', 'benaa-framework'),
							)
						),
						array(
							'id'          => 'header_customize_left_sidebar',
							'type'        => 'selectize',
							'allow_clear' => true,
							'title'       => esc_html__('Sidebar', 'benaa-framework'),
							'subtitle'    => esc_html__('Choose the sidebar for header right customize', 'benaa-framework'),
							'data'        => 'sidebar',
							'placeholder' => esc_html__('Select Sidebar', 'benaa-framework'),
							'default'     => '',
							'required'    => array('header_customize_left', 'contain', 'sidebar')
						),
						array(
							'id'       => 'header_customize_left_text',
							'type'     => 'ace_editor',
							'mode'     => 'html',
							'theme'    => 'monokai',
							'title'    => esc_html__('Custom Text Content', 'benaa-framework'),
							'subtitle' => esc_html__('Add Content for Custom Text', 'benaa-framework'),
							'desc'     => '',
							'default'  => '',
							'options'  => array('minLines' => 5, 'maxLines' => 60),
							'required' => array('header_customize_left', 'contain', 'custom-text')
						),
						array(
							'id'         => 'header_customize_left_spacing',
							'type'       => 'slider',
							'title'      => esc_html__('Navigation Item Spacing (px)', 'benaa-framework'),
							'default'    => '13',
							'js_options' => array(
								'step' => 1,
								'min'  => 0,
								'max'  => 100
							)
						),
						array(
							'id'       => 'header_customize_left_css_class',
							'type'     => 'text',
							'title'    => esc_html__('Custom CSS Class', 'benaa-framework'),
							'subtitle' => esc_html__('Add custom css class', 'benaa-framework'),
							'default'  => '',
						),
					)
				),
				array(
					'id'       => 'section-header-customize-right',
					'type'     => 'group',
					'title'    => esc_html__('Header Customize Right', 'benaa-framework'),
					'required' => array('header_layout', 'in', array('header-2', 'header-3', 'header-4', 'header-5', 'header-6')),
					'fields'   => array(
						array(
							'id'      => 'header_customize_right',
							'type'    => 'sortable',
							'title'   => 'Header customize right',
							'desc'    => 'Organize how you want the layout to appear on the header right',
							'options' => array(
								'search'      => esc_html__('Search', 'benaa-framework'),
								'sidebar'     => esc_html__('Sidebar', 'benaa-framework'),
								'custom-text' => esc_html__('Custom Text', 'benaa-framework'),
							)
						),
						array(
							'id'          => 'header_customize_right_sidebar',
							'type'        => 'selectize',
							'allow_clear' => true,
							'title'       => esc_html__('Sidebar', 'benaa-framework'),
							'subtitle'    => esc_html__('Choose the sidebar for header right customize', 'benaa-framework'),
							'data'        => 'sidebar',
							'placeholder' => esc_html__('Select Sidebar', 'benaa-framework'),
							'default'     => '',
							'required'    => array('header_customize_right', 'contain', 'sidebar')
						),
						array(
							'id'       => 'header_customize_right_text',
							'type'     => 'ace_editor',
							'mode'     => 'html',
							'theme'    => 'monokai',
							'title'    => esc_html__('Custom Text Content', 'benaa-framework'),
							'subtitle' => esc_html__('Add Content for Custom Text', 'benaa-framework'),
							'desc'     => '',
							'default'  => '',
							'options'  => array('minLines' => 5, 'maxLines' => 60),
							'required' => array('header_customize_right', 'contain', 'custom-text')
						),
						array(
							'id'         => 'header_customize_right_spacing',
							'type'       => 'slider',
							'title'      => esc_html__('Navigation Item Spacing (px)', 'benaa-framework'),
							'default'    => '13',
							'js_options' => array(
								'step' => 1,
								'min'  => 0,
								'max'  => 100
							)
						),
						array(
							'id'       => 'header_customize_right_css_class',
							'type'     => 'text',
							'title'    => esc_html__('Custom CSS Class', 'benaa-framework'),
							'subtitle' => esc_html__('Add custom css class', 'benaa-framework'),
							'default'  => '',
						),
					)
				),
				array(
					'id'       => 'section-header-customize-nav',
					'type'     => 'group',
					'title'    => esc_html__('Header Customize Navigation', 'benaa-framework'),
					'required' => array('header_layout', '!=', array('header-2')),
					'fields'   => array(
						array(
							'id'      => 'header_customize_nav',
							'type'    => 'sortable',
							'title'   => esc_html__('Header customize navigation', 'benaa-framework'),
							'desc'    => esc_html__('Organize how you want the layout to appear on the header navigation', 'benaa-framework'),
							'options' => array(
								'search'      => esc_html__('Search', 'benaa-framework'),
								'sidebar'     => esc_html__('Sidebar', 'benaa-framework'),
								'custom-text' => esc_html__('Custom Text', 'benaa-framework'),
							)
						),
						array(
							'id'          => 'header_customize_nav_sidebar',
							'type'        => 'selectize',
							'allow_clear' => true,
							'title'       => esc_html__('Sidebar', 'benaa-framework'),
							'placeholder' => esc_html__('Select Sidebar', 'benaa-framework'),
							'subtitle'    => esc_html__('Choose the sidebar for header customize navigation', 'benaa-framework'),
							'data'        => 'sidebar',
							'default'     => '',
							'required'    => array('header_customize_nav', 'contain', 'sidebar')
						),
						array(
							'id'       => 'header_customize_nav_text',
							'type'     => 'ace_editor',
							'mode'     => 'html',
							'theme'    => 'monokai',
							'title'    => esc_html__('Custom Text Content', 'benaa-framework'),
							'subtitle' => esc_html__('Add Content for Custom Text', 'benaa-framework'),
							'desc'     => '',
							'default'  => '',
							'options'  => array('minLines' => 5, 'maxLines' => 60),
							'required' => array('header_customize_nav', 'contain', 'custom-text')
						),
						array(
							'id'         => 'header_customize_nav_spacing',
							'type'       => 'slider',
							'title'      => esc_html__('Navigation Item Spacing (px)', 'benaa-framework'),
							'default'    => '13',
							'js_options' => array(
								'step' => 1,
								'min'  => 0,
								'max'  => 100
							)
						),
						array(
							'id'       => 'header_customize_nav_css_class',
							'type'     => 'text',
							'title'    => esc_html__('Custom CSS Class', 'benaa-framework'),
							'subtitle' => esc_html__('Add custom css class', 'benaa-framework'),
							'default'  => '',
						)
					)
				)
			)
		);
	}
}

/**
 * Get Config Section Footer
 * *******************************************************
 */
if (!function_exists('gf_get_config_section_footer')) {
	function gf_get_config_section_footer()
	{
		return array(
			'id'     => 'section_footer',
			'title'  => esc_html__('Footer', 'benaa-framework'),
			'icon'   => 'dashicons dashicons-networking',
			'fields' => array(
				array(
					'id'          => 'set_footer_custom',
					'type'        => 'selectize',
					'allow_clear' => true,
					'title'       => esc_html__('Custom Footer', 'benaa-framework'),
					'placeholder' => esc_html__('Select Custom Footer', 'benaa-framework'),
					'desc'        => esc_html__('Select one to apply to the page footer', 'benaa-framework'),
					'data'        => 'post',
					'default'     => '',
					'data_args'   => array(
						'post_type'      => 'gf_footer',
						'posts_per_page' => -1,
						'post_status'    => 'publish'
					),
				),
				array(
					'id'       => 'footer_show_hide',
					'type'     => 'button_set',
					'title'    => esc_html__('Show/Hide Footer', 'benaa-framework'),
					'options'  => gf_get_toggle(),
					'required' => array('set_footer_custom', '=', ''),
					'default'  => 1
				),
				array(
					'id'       => 'section_footer_group_general',
					'type'     => 'group',
					'title'    => esc_html__('General', 'benaa-framework'),
					'required' => array(
						array(
							array('set_footer_custom', '!=', ''),
							array('footer_show_hide', '=', '1')
						)
					),
					'fields'   => array(
						array(
							'id'       => 'footer_container_layout',
							'type'     => 'button_set',
							'title'    => esc_html__('Footer Container Layout', 'benaa-framework'),
							'subtitle' => esc_html__('Select Footer Container Layout', 'benaa-framework'),
							'desc'     => '',
							'options'  => array(
								'full'            => esc_html__('Full Width', 'benaa-framework'),
								'container-fluid' => esc_html__('Container Fluid', 'benaa-framework'),
								'container'       => esc_html__('Container', 'benaa-framework')
							),
							'default'  => 'container'
						),
						array(
							'id'       => 'footer_parallax',
							'type'     => 'button_set',
							'title'    => esc_html__('Footer Parallax', 'benaa-framework'),
							'subtitle' => esc_html__('Enable Footer Parallax', 'benaa-framework'),
							'desc'     => '',
							'options'  => array(
								'1' => esc_html__('Enable', 'benaa-framework'),
								'0' => esc_html__('Disable', 'benaa-framework')
							),
							'default'  => '0'
						),
						array(
							'id'       => 'footer_bg_image',
							'type'     => 'image',
							'url'      => true,
							'title'    => esc_html__('Background image', 'benaa-framework'),
							'subtitle' => esc_html__('Upload footer background image here', 'benaa-framework'),
							'desc'     => '',
							'default'  => '',
						),
						array(
							'id'       => 'footer_bg_image_apply_for',
							'type'     => 'button_set',
							'title'    => esc_html__('Footer Image apply for', 'benaa-framework'),
							'subtitle' => esc_html__('Select region apply for footer image', 'benaa-framework'),
							'desc'     => '',
							'options'  => array(
								'footer.main-footer-wrapper' => esc_html__('Footer Wrapper', 'benaa-framework'),
								'footer .main-footer'        => esc_html__('Main Footer', 'benaa-framework'),
							),
							'default'  => 'footer.main-footer-wrapper',
							'required' => array('footer_bg_image', '!=', ''),
						),
						array(
							'id'      => 'footer_css_class',
							'type'    => 'text',
							'title'   => esc_html__('Css class', 'benaa-framework'),
							'desc'    => '',
							'default' => '',
						)
					)
				),
				
				//--------------------------------------------------------------------------------
				array(
					'id'       => 'section-footer-main-settings',
					'type'     => 'group',
					'title'    => esc_html__('Main Footer', 'benaa-framework'),
					'required' => array(
						array('set_footer_custom', '=', ''),
						array('footer_show_hide', '=', '1')
					),
					'fields'   => array(
						//--------------------------------------------------------------------------------
						array(
							'id'       => 'section-footer-above-settings',
							'type'     => 'group',
							'title'    => esc_html__('Above Footer', 'benaa-framework'),
							'required' => array('footer_show_hide', '=', '1'),
							'fields'   => array(
								array(
									'id'          => 'set_footer_above_custom',
									'type'        => 'selectize',
									'allow_clear' => true,
									'placeholder' => esc_html__('Select Above Footer', 'benaa-framework'),
									'title'       => esc_html__('Set Above Footer', 'benaa-framework'),
									'data'        => 'post',
									'default'     => '',
									'data_args'   => array(
										'post_type'      => 'gf_footer',
										'posts_per_page' => -1,
										'post_status'    => 'publish'
									)
								),
							)
						),
						array(
							'id'       => 'footer_layout',
							'type'     => 'image_set',
							'title'    => esc_html__('Layout', 'benaa-framework'),
							'subtitle' => esc_html__('Select the footer column layout.', 'benaa-framework'),
							'desc'     => '',
							'options'  => array(
								'footer-1' => GF_PLUGIN_URL . 'assets/images/theme-options/footer-layout-1.jpg',
								'footer-2' => GF_PLUGIN_URL . 'assets/images/theme-options/footer-layout-2.jpg',
								'footer-3' => GF_PLUGIN_URL . 'assets/images/theme-options/footer-layout-3.jpg',
								'footer-4' => GF_PLUGIN_URL . 'assets/images/theme-options/footer-layout-4.jpg',
								'footer-5' => GF_PLUGIN_URL . 'assets/images/theme-options/footer-layout-5.jpg',
								'footer-6' => GF_PLUGIN_URL . 'assets/images/theme-options/footer-layout-6.jpg',
								'footer-7' => GF_PLUGIN_URL . 'assets/images/theme-options/footer-layout-7.jpg',
								'footer-8' => GF_PLUGIN_URL . 'assets/images/theme-options/footer-layout-8.jpg',
								'footer-9' => GF_PLUGIN_URL . 'assets/images/theme-options/footer-layout-9.jpg',
							),
							'default'  => 'footer-1',
							'required' => array('footer_show_hide', '=', 1)
						),
						
						array(
							'id'          => 'footer_sidebar_1',
							'type'        => 'selectize',
							'allow_clear' => true,
							'title'       => esc_html__('Sidebar 1', 'benaa-framework'),
							'subtitle'    => esc_html__('Choose the default footer sidebar 1', 'benaa-framework'),
							'data'        => 'sidebar',
							'placeholder' => esc_html__('Select Sidebar', 'benaa-framework'),
							'desc'        => '',
							'default'     => 'footer-1',
							'required'    => array('footer_show_hide', '=', 1)
						),
						
						array(
							'id'          => 'footer_sidebar_2',
							'type'        => 'selectize',
							'allow_clear' => true,
							'title'       => esc_html__('Sidebar 2', 'benaa-framework'),
							'subtitle'    => esc_html__('Choose the default footer sidebar 2', 'benaa-framework'),
							'data'        => 'sidebar',
							'placeholder' => esc_html__('Select Sidebar', 'benaa-framework'),
							'desc'        => '',
							'default'     => 'footer-2',
							'required'    => array(
								array('footer_layout', '!=', 'footer-9'),
								array('footer_show_hide', '=', 1)
							)
						),
						
						array(
							'id'          => 'footer_sidebar_3',
							'type'        => 'selectize',
							'allow_clear' => true,
							'title'       => esc_html__('Sidebar 3', 'benaa-framework'),
							'subtitle'    => esc_html__('Choose the default footer sidebar 3', 'benaa-framework'),
							'data'        => 'sidebar',
							'placeholder' => esc_html__('Select Sidebar', 'benaa-framework'),
							'desc'        => '',
							'default'     => 'footer-3',
							'required'    => array(
								array('footer_layout', 'in', array('footer-1', 'footer-2', 'footer-3', 'footer-5', 'footer-8')),
								array('footer_show_hide', '=', 1)
							)
						),
						
						array(
							'id'          => 'footer_sidebar_4',
							'type'        => 'selectize',
							'allow_clear' => true,
							'title'       => esc_html__('Sidebar 4', 'benaa-framework'),
							'subtitle'    => esc_html__('Choose the default footer sidebar 4', 'benaa-framework'),
							'data'        => 'sidebar',
							'placeholder' => esc_html__('Select Sidebar', 'benaa-framework'),
							'desc'        => '',
							'default'     => 'footer-4',
							'required'    => array(
								array('footer_layout', '=', 'footer-1'),
								array('footer_show_hide', '=', 1)
							)
						),
						
						array(
							'id'       => 'collapse_footer',
							'type'     => 'button_set',
							'title'    => esc_html__('Collapse footer on mobile device', 'benaa-framework'),
							'subtitle' => esc_html__('Enable collapse footer', 'benaa-framework'),
							'desc'     => '',
							'options'  => array(
								'1' => esc_html__('On', 'benaa-framework'),
								'0' => esc_html__('Off', 'benaa-framework')
							),
							'default'  => '0',
							'required' => array('footer_show_hide', '=', 1)
						),
						array(
							'id'             => 'footer_padding',
							'type'           => 'spacing',
							'mode'           => 'padding',
							'units'          => 'px',
							'units_extended' => 'false',
							'title'          => esc_html__('Footer Top/Bottom Padding', 'benaa-framework'),
							'subtitle'       => esc_html__('This must be numeric (no px)', 'benaa-framework'),
							'desc'           => esc_html__('If you would like to override the default footer top/bottom padding, then you can do so here.', 'benaa-framework'),
							'left'           => false,
							'right'          => false,
							'default'        => array(
								'padding-top'    => '60',
								'padding-bottom' => '60',
							),
							'required'       => array('footer_show_hide', '=', 1)
						),
						array(
							'id'       => 'footer_border_top',
							'type'     => 'button_set',
							'title'    => esc_html__('Footer border top', 'benaa-framework'),
							'options'  => array(
								'none'             => esc_html__('None', 'benaa-framework'),
								'full-border'      => esc_html__('Full Border', 'benaa-framework'),
								'container-border' => esc_html__('Container Border', 'benaa-framework'),
							),
							'default'  => 'none',
							'required' => array('footer_show_hide', '=', 1)
						),
					)
				),
				
				//--------------------------------------------------------------------------------
				array(
					'id'       => 'section-footer-bottom-settings',
					'type'     => 'group',
					'title'    => esc_html__('Bottom Bar Settings', 'benaa-framework'),
					'required' => array('set_footer_custom', '=', ''),
					'fields'   => array(
						array(
							'id'      => 'bottom_bar_visible',
							'type'    => 'button_set',
							'title'   => esc_html__('Show/Hide Bottom Bar', 'benaa-framework'),
							'options' => gf_get_toggle(),
							'default' => 1
						),
						array(
							'id'       => 'bottom_bar_layout',
							'type'     => 'image_set',
							'title'    => esc_html__('Bottom bar Layout', 'benaa-framework'),
							'subtitle' => esc_html__('Select the bottom bar column layout.', 'benaa-framework'),
							'desc'     => '',
							'options'  => array(
								'bottom-bar-1' => GF_PLUGIN_URL . 'assets/images/theme-options/bottom-bar-layout-1.jpg',
								'bottom-bar-2' => GF_PLUGIN_URL . 'assets/images/theme-options/bottom-bar-layout-2.jpg',
								'bottom-bar-3' => GF_PLUGIN_URL . 'assets/images/theme-options/bottom-bar-layout-3.jpg',
								'bottom-bar-4' => GF_PLUGIN_URL . 'assets/images/theme-options/bottom-bar-layout-4.jpg',
							),
							'default'  => 'bottom-bar-1',
							'required' => array('bottom_bar_visible', '=', 1)
						),
						
						array(
							'id'          => 'bottom_bar_left_sidebar',
							'type'        => 'selectize',
							'allow_clear' => true,
							'title'       => esc_html__('Bottom Left Sidebar', 'benaa-framework'),
							'subtitle'    => esc_html__('Choose the default bottom left sidebar', 'benaa-framework'),
							'data'        => 'sidebar',
							'placeholder' => esc_html__('Select Sidebar', 'benaa-framework'),
							'desc'        => '',
							'default'     => 'bottom_bar_left',
							'required'    => array('bottom_bar_visible', '=', 1)
						),
						array(
							'id'          => 'bottom_bar_right_sidebar',
							'type'        => 'selectize',
							'allow_clear' => true,
							'title'       => esc_html__('Bottom Right Sidebar', 'benaa-framework'),
							'subtitle'    => esc_html__('Choose the default bottom right sidebar', 'benaa-framework'),
							'data'        => 'sidebar',
							'placeholder' => esc_html__('Select Sidebar', 'benaa-framework'),
							'desc'        => '',
							'default'     => 'bottom_bar_right',
							'required'    => array(
								array('bottom_bar_layout', '!=', 'bottom-bar-4'),
								array('bottom_bar_visible', '=', 1)
							),
						),
						array(
							'id'             => 'bottom_bar_padding',
							'type'           => 'spacing',
							'mode'           => 'padding',
							'units'          => 'px',
							'units_extended' => 'false',
							'title'          => esc_html__('Bottom Bar Top/Bottom Padding', 'benaa-framework'),
							'subtitle'       => esc_html__('This must be numeric (no px). Leave balnk for default.', 'benaa-framework'),
							'desc'           => esc_html__('If you would like to override the default bottom bar top/bottom padding, then you can do so here.', 'benaa-framework'),
							'left'           => false,
							'right'          => false,
							'default'        => array(
								'padding-top'    => '22',
								'padding-bottom' => '16',
							),
							'required'       => array('bottom_bar_visible', '=', 1)
						),
						array(
							'id'       => 'bottom_bar_border_top',
							'type'     => 'button_set',
							'title'    => esc_html__('Bottom bar border top', 'benaa-framework'),
							'options'  => array(
								'none'             => esc_html__('None', 'benaa-framework'),
								'full-border'      => esc_html__('Full Border', 'benaa-framework'),
								'container-border' => esc_html__('Container Border', 'benaa-framework'),
							),
							'default'  => 'none',
							'required' => array('bottom_bar_visible', '=', 1)
						)
					)
				),
			)
		);
	}
}

/**
 * Get Config Section Theme Colors
 * *******************************************************
 */
if (!function_exists('gf_get_config_section_theme_colors')) {
	function gf_get_config_section_theme_colors()
	{
		return array(
			'id'       => 'section_theme_colors',
			'title'    => esc_html__('Theme Colors', 'benaa-framework'),
			'subtitle' => esc_html__('If you change value in this section, you must "Save & Generate CSS"', 'benaa-framework'),
			'icon'     => 'dashicons dashicons-art',
			'fields'   => array(
				array(
					'id'     => 'section-theme-color-general',
					'type'   => 'group',
					'title'  => esc_html__('General', 'benaa-framework'),
					'fields' => array(
						array(
							'id'       => 'accent_color',
							'type'     => 'color',
							'alpha'    => true,
							'title'    => esc_html__('Accent Color', 'benaa-framework'),
							'default'  => '#92c800',
							'validate' => 'color',
						),
						array(
							'id'       => 'foreground_accent_color',
							'type'     => 'color',
							'title'    => esc_html__('Foreground Accent Color', 'benaa-framework'),
							'default'  => '#fff',
							'validate' => 'color',
							'alpha'    => true,
						),
						array(
							'id'       => 'text_color',
							'type'     => 'color',
							'title'    => esc_html__('Text Color', 'benaa-framework'),
							'default'  => '#727272',
							'validate' => 'color',
							'alpha'    => true,
						),
						array(
							'id'       => 'heading_color',
							'type'     => 'color',
							'title'    => esc_html__('Heading Color', 'benaa-framework'),
							'default'  => '#222',
							'validate' => 'color',
							'alpha'    => true,
						),
						array(
							'id'       => 'border_color',
							'type'     => 'color',
							'title'    => esc_html__('Border Color', 'benaa-framework'),
							'default'  => '#ededed',
							'validate' => 'color',
							'alpha'    => true,
						),
						array(
							'id'       => 'disable_color',
							'type'     => 'color',
							'title'    => esc_html__('Disable Color', 'benaa-framework'),
							'default'  => '#bababa',
							'validate' => 'color',
							'alpha'    => true,
						),
						array(
							'id'       => 'background_color',
							'type'     => 'color',
							'title'    => esc_html__('Background Color', 'benaa-framework'),
							'default'  => '#f6f6f6',
							'validate' => 'color',
							'alpha'    => true,
						),
					)
				),
				//--------------------------------------------------------------------
				array(
					'id'     => 'section-theme-color-top-drawer',
					'type'   => 'group',
					'title'  => esc_html__('Top Drawer', 'benaa-framework'),
					'fields' => array(
						array(
							'id'       => 'top_drawer_bg_color',
							'type'     => 'color',
							'title'    => esc_html__('Top drawer background color', 'benaa-framework'),
							'default'  => '#222',
							'validate' => 'color',
							'alpha'    => true,
						),
						
						array(
							'id'       => 'top_drawer_text_color',
							'type'     => 'color',
							'title'    => esc_html__('Top drawer text color', 'benaa-framework'),
							'default'  => '#ffffff',
							'validate' => 'color',
							'alpha'    => true,
						),
					)
				),
				
				//--------------------------------------------------------------------
				array(
					'id'     => 'section-theme-color-top-bar',
					'type'   => 'group',
					'title'  => esc_html__('Top Bar', 'benaa-framework'),
					'fields' => array(
						array(
							'id'       => 'top_bar_bg_color',
							'type'     => 'color',
							'title'    => esc_html__('Top bar background color', 'benaa-framework'),
							'default'  => '#222',
							'validate' => 'color',
							'alpha'    => true,
						),
						array(
							'id'       => 'top_bar_text_color',
							'type'     => 'color',
							'title'    => esc_html__('Top bar text color', 'benaa-framework'),
							'default'  => '#fff',
							'validate' => 'color',
							'alpha'    => true,
						),
						array(
							'id'       => 'top_bar_border_color',
							'type'     => 'color',
							'title'    => esc_html__('Top bar border color', 'benaa-framework'),
							'default'  => '#ededed',
							'validate' => 'color',
							'alpha'    => true,
						),
					)
				),
				
				//--------------------------------------------------------------------
				array(
					'id'     => 'section-theme-color-header-color',
					'type'   => 'group',
					'title'  => esc_html__('Header', 'benaa-framework'),
					'fields' => array(
						array(
							'id'       => 'header_bg_color',
							'type'     => 'color',
							'title'    => esc_html__('Header background color', 'benaa-framework'),
							'default'  => '#fff',
							'validate' => 'color',
							'alpha'    => true,
						),
						array(
							'id'       => 'header_text_color',
							'type'     => 'color',
							'title'    => esc_html__('Header text color', 'benaa-framework'),
							'default'  => '#222',
							'validate' => 'color',
							'alpha'    => true,
						),
						array(
							'id'       => 'header_border_color',
							'type'     => 'color',
							'title'    => esc_html__('Header border color', 'benaa-framework'),
							'default'  => '#ededed',
							'validate' => 'color',
							'alpha'    => true,
						),
					)
				),
				
				//--------------------------------------------------------------------
				array(
					'id'     => 'section-theme-color-navigation-color',
					'type'   => 'group',
					'title'  => esc_html__('Navigation', 'benaa-framework'),
					'fields' => array(
						array(
							'id'       => 'navigation_bg_color',
							'type'     => 'color',
							'title'    => esc_html__('Navigation background color', 'benaa-framework'),
							'default'  => '#fff',
							'validate' => 'color',
							'alpha'    => true,
						),
						array(
							'id'       => 'navigation_text_color',
							'type'     => 'color',
							'title'    => esc_html__('Navigation text color', 'benaa-framework'),
							'default'  => '#222',
							'validate' => 'color',
							'alpha'    => true,
						),
						array(
							'id'       => 'navigation_text_color_hover',
							'type'     => 'color',
							'title'    => esc_html__('Navigation text hover color', 'benaa-framework'),
							'default'  => '#92c800',
							'validate' => 'color',
							'alpha'    => true,
						),
						array(
							'id'       => 'nav_border_color',
							'type'     => 'color',
							'title'    => esc_html__('Navigation border color', 'benaa-framework'),
							'default'  => '#ededed',
							'validate' => 'color',
							'alpha'    => true,
							'required' => array('header_layout', 'in', array('header-2')),
						),
					)
				),
				
				//--------------------------------------------------------------------
				array(
					'id'     => 'section-theme-color-header-mobile',
					'type'   => 'group',
					'title'  => esc_html__('Header Mobile Color', 'benaa-framework'),
					'fields' => array(
						array(
							'id'       => 'top_bar_mobile_bg_color',
							'type'     => 'color',
							'title'    => esc_html__('Top bar background color', 'benaa-framework'),
							'default'  => '#222',
							'validate' => 'color',
							'alpha'    => true,
						),
						array(
							'id'       => 'top_bar_mobile_text_color',
							'type'     => 'color',
							'title'    => esc_html__('Top bar text color', 'benaa-framework'),
							'default'  => '#fff',
							'validate' => 'color',
							'alpha'    => true,
						),
						array(
							'id'       => 'top_bar_mobile_border_color',
							'type'     => 'color',
							'title'    => esc_html__('Top bar border bottom color', 'benaa-framework'),
							'default'  => '#ededed',
							'validate' => 'color',
							'alpha'    => true,
						),
						array(
							'id'       => 'header_mobile_bg_color',
							'type'     => 'color',
							'title'    => esc_html__('Header background color', 'benaa-framework'),
							'default'  => '#fff',
							'validate' => 'color',
							'alpha'    => true,
						),
						array(
							'id'       => 'header_mobile_text_color',
							'type'     => 'color',
							'title'    => esc_html__('Header text color', 'benaa-framework'),
							'default'  => '#222',
							'validate' => 'color',
							'alpha'    => true,
						),
						array(
							'id'       => 'header_mobile_border_color',
							'type'     => 'color',
							'title'    => esc_html__('Header border bottom color', 'benaa-framework'),
							'default'  => '#ededed',
							'validate' => 'color',
							'alpha'    => true,
						),
					)
				),
				
				//--------------------------------------------------------------------
				array(
					'id'     => 'section-theme-color-footer-color',
					'type'   => 'group',
					'title'  => esc_html__('Footer', 'benaa-framework'),
					'fields' => array(
						array(
							'id'       => 'footer_bg_color',
							'type'     => 'color',
							'title'    => esc_html__('Footer background color', 'benaa-framework'),
							'default'  => '#222',
							'validate' => 'color',
							'alpha'    => true,
						),
						array(
							'id'       => 'footer_text_color',
							'type'     => 'color',
							'title'    => esc_html__('Footer text color', 'benaa-framework'),
							'default'  => '#bababa',
							'validate' => 'color',
							'alpha'    => true,
						),
						array(
							'id'       => 'footer_widget_title_color',
							'type'     => 'color',
							'title'    => esc_html__('Footer widget title color', 'benaa-framework'),
							'default'  => '#fff',
							'validate' => 'color',
							'alpha'    => true,
						),
						array(
							'id'       => 'footer_border_color',
							'type'     => 'color',
							'title'    => esc_html__('Footer border color', 'benaa-framework'),
							'default'  => '#393939',
							'validate' => 'color',
							'alpha'    => true,
						)
					)
				),
				
				array(
					'id'     => 'section-theme-color-bottom-bar-color',
					'type'   => 'group',
					'title'  => esc_html__('Bottom Bar', 'benaa-framework'),
					'fields' => array(
						array(
							'id'       => 'bottom_bar_bg_color',
							'type'     => 'color',
							'title'    => esc_html__('Bottom bar background color', 'benaa-framework'),
							'default'  => '#141414',
							'validate' => 'color',
							'alpha'    => true,
						),
						array(
							'id'       => 'bottom_bar_text_color',
							'type'     => 'color',
							'title'    => esc_html__('Bottom bar text color', 'benaa-framework'),
							'default'  => '#bababa',
							'validate' => 'color',
							'alpha'    => true,
						),
						array(
							'id'       => 'bottom_bar_border_color',
							'type'     => 'color',
							'title'    => esc_html__('Bottom bar border color', 'benaa-framework'),
							'default'  => '#393939',
							'validate' => 'color',
							'alpha'    => true,
						),
					)
				)
			)
		);
	}
}
/**
 * Get Config Section Font Options
 * *******************************************************
 */

if (!function_exists('gf_get_config_section_font_options')) {
	function gf_get_config_section_font_options()
	{
		return array(
			'id'       => 'section_custom_font',
			'title'    => esc_html__('Font Options', 'benaa-framework'),
			'subtitle' => esc_html__('If you change value in this section, you must "Save & Generate CSS"', 'benaa-framework'),
			'icon'     => 'dashicons dashicons-editor-textcolor',
			'fields'   => array(
				array(
					'id'          => 'body_font',
					'type'        => 'font',
					'title'       => esc_html__('Body Font', 'benaa-framework'),
					'subtitle'    => esc_html__('Specify the body font properties.', 'benaa-framework'),
					'font_size'   => true,
					'font_weight' => true,
					'default'     => array(
						'font_family' => "'Poppins'",
						'font_weight' => '400',
						'font_size'   => '14'
					),
				),
				array(
					'id'          => 'secondary_font',
					'type'        => 'font',
					'title'       => esc_html__('Secondary Font', 'benaa-framework'),
					'subtitle'    => esc_html__('Specify the Secondary font properties.', 'benaa-framework'),
					'font_size'   => true,
					'font_weight' => true,
					'default'     => array(
						'font_family' => "'Poppins'",
						'font_weight' => '400',
						'font_size'   => '14'
					),
				),
				
				array(
					'id'          => 'h1_font',
					'type'        => 'font',
					'title'       => esc_html__('H1 Font', 'benaa-framework'),
					'subtitle'    => esc_html__('Specify the H1 font properties.', 'benaa-framework'),
					'font_size'   => true,
					'font_weight' => true,
					'default'     => array(
						'font_family' => "'Poppins'",
						'font_weight' => '700',
						'font_size'   => '64',
					),
				),
				array(
					'id'          => 'h2_font',
					'type'        => 'font',
					'title'       => esc_html__('H2 Font', 'benaa-framework'),
					'subtitle'    => esc_html__('Specify the H2 font properties.', 'benaa-framework'),
					'font_size'   => true,
					'font_weight' => true,
					'default'     => array(
						'font_family' => "'Poppins'",
						'font_weight' => '700',
						'font_size'   => '48',
					),
				),
				array(
					'id'          => 'h3_font',
					'type'        => 'font',
					'title'       => esc_html__('H3 Font', 'benaa-framework'),
					'subtitle'    => esc_html__('Specify the H3 font properties.', 'benaa-framework'),
					'font_size'   => true,
					'font_weight' => true,
					'default'     => array(
						'font_size'   => '32',
						'font_family' => "'Poppins'",
						'font_weight' => '700',
					),
				),
				array(
					'id'          => 'h4_font',
					'type'        => 'font',
					'title'       => esc_html__('H4 Font', 'benaa-framework'),
					'subtitle'    => esc_html__('Specify the H4 font properties.', 'benaa-framework'),
					'font_size'   => true,
					'font_weight' => true,
					'default'     => array(
						'font_size'   => '21',
						'font_family' => "'Poppins'",
						'font_weight' => '700',
					),
				),
				array(
					'id'          => 'h5_font',
					'type'        => 'font',
					'title'       => esc_html__('H5 Font', 'benaa-framework'),
					'subtitle'    => esc_html__('Specify the H5 font properties.', 'benaa-framework'),
					'font_size'   => true,
					'font_weight' => true,
					'default'     => array(
						'font_size'   => '18',
						'font_family' => "'Poppins'",
						'font_weight' => '700',
					),
				),
				array(
					'id'          => 'h6_font',
					'type'        => 'font',
					'title'       => esc_html__('H6 Font', 'benaa-framework'),
					'subtitle'    => esc_html__('Specify the H6 font properties.', 'benaa-framework'),
					'font_size'   => true,
					'font_weight' => true,
					'default'     => array(
						'font_size'   => '16',
						'font_family' => "'Poppins'",
						'font_weight' => '700',
					),
				),
			)
		);
	}
}

/**
 * Get Config Section Social Profiles
 * *******************************************************
 */
if (!function_exists('gf_get_config_section_social_profiles')) {
	function gf_get_config_section_social_profiles()
	{
		return array(
			'id'     => 'section_social_profiles',
			'title'  => esc_html__('Social Profiles', 'benaa-framework'),
			'icon'   => 'dashicons dashicons-rss',
			'fields' => array_merge(
				array(
					array(
						'id'     => 'section_social_profiles_general',
						'type'   => 'group',
						'title'  => esc_html__('General', 'benaa-framework'),
						'fields' => gf_get_social_profiles()
					)
				),
				array(
					array(
						'id'     => 'section_social_profiles_share_option',
						'type'   => 'group',
						'title'  => esc_html__('Blog Share Option', 'benaa-framework'),
						'fields' => array(
							array(
								'title'        => esc_html__('Social Share', 'benaa-framework'),
								'id'           => 'social_sharing',
								'type'         => 'checkbox_list',
								'subtitle'     => esc_html__('Show the social sharing in single blog', 'benaa-framework'),
								'options'      => array(
									'facebook'  => 'Facebook',
									'twitter'   => 'Twitter',
									'google'    => 'Google',
									'linkedin'  => 'Linkedin',
									'tumblr'    => 'Tumblr',
									'pinterest' => 'Pinterest'
								),
								'default'      => array(
									'facebook', 'twitter', 'google'
								),
								'value_inline' => false
							)
						)
					)
				)
			)
		);
	}
}

/**
 * Get Config Section Resources Options
 * *******************************************************
 */
if (!function_exists('gf_get_config_section_resources_options')) {
	function gf_get_config_section_resources_options()
	{
		return array(
			'id'     => 'section_resources_options',
			'title'  => esc_html__('Resources Options', 'benaa-framework'),
			'icon'   => 'dashicons dashicons-screenoptions',
			'fields' => array(
				array(
					'id'     => 'section_resources_options_general',
					'type'   => 'group',
					'title'  => esc_html__('General', 'benaa-framework'),
					'fields' => array(
						array(
							'id'       => 'cdn_bootstrap_js',
							'type'     => 'text',
							'title'    => esc_html__('CDN Bootstrap Script', 'benaa-framework'),
							'subtitle' => esc_html__('Url CDN Bootstrap Script', 'benaa-framework'),
							'desc'     => '',
							'default'  => '',
						),
						array(
							'id'       => 'cdn_bootstrap_css',
							'type'     => 'text',
							'title'    => esc_html__('CDN Bootstrap Stylesheet', 'benaa-framework'),
							'subtitle' => esc_html__('Url CDN Bootstrap Stylesheet', 'benaa-framework'),
							'desc'     => '',
							'default'  => '',
						),
						array(
							'id'       => 'cdn_font_awesome',
							'type'     => 'text',
							'title'    => esc_html__('CDN Font Awesome', 'benaa-framework'),
							'subtitle' => esc_html__('Url CDN Font Awesome', 'benaa-framework'),
							'desc'     => '',
							'default'  => '',
						),
					)
				)
			)
		);
	}
}

/**
 * Get Config Section Custom CSS & Script
 * *******************************************************
 */
if (!function_exists('gf_get_config_custom_css_script_options')) {
	function gf_get_config_custom_css_script_options()
	{
		return array(
			'id'     => 'section_custom_css_script',
			'title'  => esc_html__('Custom CSS & Script', 'benaa-framework'),
			'icon'   => 'dashicons dashicons-welcome-write-blog',
			'fields' => array(
				array(
					'id'       => 'custom_css',
					'type'     => 'ace_editor',
					'mode'     => 'css',
					'title'    => esc_html__('Custom CSS', 'benaa-framework'),
					'subtitle' => esc_html__('Add some CSS to your theme by adding it to this textarea. Please do not include any style tags.', 'benaa-framework'),
					'desc'     => '',
					'default'  => '',
					'theme'    => 'solarized_dark',
					'options'  => array('minLines' => 20, 'maxLines' => 60)
				),
				array(
					'id'       => 'custom_js',
					'type'     => 'ace_editor',
					'mode'     => 'javascript',
					'theme'    => 'chrome',
					'title'    => esc_html__('Custom JS', 'benaa-framework'),
					'subtitle' => esc_html__('Add some custom JavaScript to your theme by adding it to this textarea. Please do not include any script tags.', 'benaa-framework'),
					'desc'     => '',
					'default'  => '',
					'options'  => array('minLines' => 20, 'maxLines' => 60)
				),
			)
		);
	}
}

/**
 * Get Config Section Preset Settings
 * *******************************************************
 */
if (!function_exists('gf_get_config_preset_setting_options')) {
	function gf_get_config_preset_setting_options()
	{
		$post_type_preset = apply_filters('gf_post_type_preset', array());
		$post_type_preset_list = array();
		foreach ($post_type_preset as $key => $value) {
			if ($key == 'property') {
				$post_type_preset_list[] = array(
					'id'     => 'divide_preset_setting_' . $key . '_general',
					'title'  => $value['name'],
					'type'   => 'group',
					'fields' => array(
						array(
							'id'          => $key . '_preset',
							'type'        => 'selectize',
							'allow_clear' => true,
							'data'        => 'post',
							'title'       => esc_html__('List Properties Preset', 'benaa-framework'),
							'placeholder' => esc_html__('Select Preset...', 'benaa-framework'),
							'default'     => '',
							'data_args'   => array(
								'post_type'      => 'gf_preset',
								'posts_per_page' => -1
							)
						),
						array(
							'id'          => $key . '_single_preset',
							'type'        => 'selectize',
							'allow_clear' => true,
							'data'        => 'post',
							'title'       => esc_html__('Single Property Preset', 'benaa-framework'),
							'placeholder' => esc_html__('Select Preset...', 'benaa-framework'),
							'default'     => '',
							'data_args'   => array(
								'post_type'      => 'gf_preset',
								'posts_per_page' => -1
							)
						)
					)
				);
			} elseif ($key == 'agent') {
				$post_type_preset_list[] = array(
					'id'     => 'divide_preset_setting_' . $key . '_general',
					'title'  => $value['name'],
					'type'   => 'group',
					'fields' => array(
						array(
							'id'          => $key . '_preset',
							'type'        => 'selectize',
							'allow_clear' => true,
							'data'        => 'post',
							'title'       => esc_html__('List Agents Preset', 'benaa-framework'),
							'placeholder' => esc_html__('Select Preset...', 'benaa-framework'),
							'default'     => '',
							'data_args'   => array(
								'post_type'      => 'gf_preset',
								'posts_per_page' => -1
							)
						),
						array(
							'id'          => $key . '_single_preset',
							'type'        => 'selectize',
							'allow_clear' => true,
							'data'        => 'post',
							'title'       => esc_html__('Single Agent Preset', 'benaa-framework'),
							'placeholder' => esc_html__('Select Preset...', 'benaa-framework'),
							'default'     => '',
							'data_args'   => array(
								'post_type'      => 'gf_preset',
								'posts_per_page' => -1
							)
						)
					)
				);
			} elseif ($key == 'invoice') {
				$post_type_preset_list[] = array(
					'id'     => 'divide_preset_setting_' . $key . '_general',
					'title'  => $value['name'],
					'type'   => 'group',
					'fields' => array(
						array(
							'id'          => $key . '_single_preset',
							'type'        => 'selectize',
							'allow_clear' => true,
							'data'        => 'post',
							'title'       => esc_html__('Invoice Preset', 'benaa-framework'),
							'placeholder' => esc_html__('Select Preset...', 'benaa-framework'),
							'default'     => '',
							'data_args'   => array(
								'post_type'      => 'gf_preset',
								'posts_per_page' => -1
							)
						)
					)
				);
			} else {
				$post_type_preset_list[] = array(
					'id'     => 'divide_preset_setting_' . $key . '_general',
					'title'  => $value['name'],
					'type'   => 'group',
					'fields' => array(
						array(
							'id'          => $key . '_preset',
							'type'        => 'selectize',
							'allow_clear' => true,
							'data'        => 'post',
							'title'       => esc_html__('List ', 'benaa-framework') . $value['name'] . esc_html__(' Preset', 'benaa-framework'),
							'placeholder' => esc_html__('Select Preset...', 'benaa-framework'),
							'default'     => '',
							'data_args'   => array(
								'post_type'      => 'gf_preset',
								'posts_per_page' => -1
							)
						),
						array(
							'id'          => $key . '_single_preset',
							'type'        => 'selectize',
							'allow_clear' => true,
							'data'        => 'post',
							'title'       => $value['name'] . esc_html__(' Single Preset', 'benaa-framework'),
							'placeholder' => esc_html__('Select Preset...', 'benaa-framework'),
							'default'     => '',
							'data_args'   => array(
								'post_type'      => 'gf_preset',
								'posts_per_page' => -1
							)
						)
					)
				);
			}
		}
		return array(
			'id'     => 'section_preset_setting',
			'title'  => esc_html__('Preset Settings', 'benaa-framework'),
			'icon'   => 'dashicons dashicons-admin-generic',
			'fields' => array_merge(
				array(
					array(
						'id'     => 'divide_preset_setting_blog',
						'title'  => esc_html__('Blog', 'benaa-framework'),
						'type'   => 'group',
						'fields' => array(
							array(
								'id'          => 'blog_preset',
								'type'        => 'selectize',
								'allow_clear' => true,
								'data'        => 'post',
								'title'       => esc_html__('Blog Preset', 'benaa-framework'),
								'placeholder' => esc_html__('Select Preset...', 'benaa-framework'),
								'default'     => '',
								'data_args'   => array(
									'post_type'      => 'gf_preset',
									'posts_per_page' => -1
								)
							),
							array(
								'id'          => 'blog_single_preset',
								'type'        => 'selectize',
								'allow_clear' => true,
								'data'        => 'post',
								'title'       => esc_html__('Blog Single Preset', 'benaa-framework'),
								'placeholder' => esc_html__('Select Preset...', 'benaa-framework'),
								'default'     => '',
								'data_args'   => array(
									'post_type'      => 'gf_preset',
									'posts_per_page' => -1
								
								)
							),
						)
					)
				),
				$post_type_preset_list,
				array(
					array(
						'id'     => 'divide_preset_setting_404',
						'title'  => esc_html__('404', 'benaa-framework'),
						'type'   => 'group',
						'fields' => array(
							array(
								'id'          => 'page_404_preset',
								'type'        => 'selectize',
								'allow_clear' => true,
								'data'        => 'post',
								'title'       => esc_html__('404 Page Preset', 'benaa-framework'),
								'placeholder' => esc_html__('Select Preset...', 'benaa-framework'),
								'default'     => '',
								'data_args'   => array(
									'post_type'      => 'gf_preset',
									'posts_per_page' => -1
								)
							)
						)
					)
				)
			)
		);
	}
}

/**
 * Get Config Custom Layout
 * *******************************************************
 */
if (!function_exists('gf_get_config_custom_layout')) {
	function gf_get_config_custom_layout()
	{
		$settings = gf_get_custom_post_type_setting();
		$options = array();
		foreach ($settings as $key => $value) {
			$fields = array(
				array(
					'id'       => "custom_{$key}_layout_enable",
					'type'     => 'button_set',
					'title'    => esc_html__('Custom Layout', 'benaa-framework'),
					'subtitle' => sprintf(esc_html__('Turn on this option if you want to enable custom layout on %s', 'benaa-framework'), $value['title']),
					'options'  => gf_get_toggle(),
					'default'  => 0
				),
				gf_get_page_layout($key . '_layout', array('custom_' . $key . '_layout_enable', '=', 1)),
				gf_get_config_sidebar_layout("{$key}_sidebar_layout", array("custom_{$key}_layout_enable", '=', 1)),
				gf_get_config_sidebar("{$key}_sidebar", array(
					array("custom_{$key}_layout_enable", '=', 1),
					array("{$key}_sidebar_layout", '!=', 'none')
				)),
				gf_get_sidebar_mobile_enable("{$key}_sidebar_mobile_enable", array(
					array("custom_{$key}_layout_enable", '=', 1),
					array("{$key}_sidebar_layout", '!=', 'none')
				), 1),
				gf_get_sidebar_mobile_canvas("{$key}_sidebar_mobile_canvas", array(
					array("custom_{$key}_layout_enable", '=', 1),
					array("{$key}_sidebar_layout", '!=', 'none')
				), 1),
				gf_get_content_padding("{$key}_content_padding", array("custom_{$key}_layout_enable", '=', 1)),
				gf_get_mobile_content_padding("{$key}_content_padding_mobile", array("custom_{$key}_layout_enable", '=', 1))
			
			);
			$options[] = array(
				'id'     => "section_layout_group_{$key}",
				'title'  => $value['title'],
				'type'   => 'group',
				//'toggle_default' => false,
				'fields' => $fields
			);
		}
		return $options;
	}
}

/**
 * Get Config Custom Page Title
 * *******************************************************
 */
if (!function_exists('gf_get_config_custom_page_title')) {
	function gf_get_config_custom_page_title()
	{
		$settings = gf_get_custom_post_type_setting();
		$options = array();
		foreach ($settings as $key => $value) {
			$fields = array(
				array(
					'id'       => "custom_{$key}_title_enable",
					'type'     => 'button_set',
					'title'    => esc_html__('Custom Page Title', 'benaa-framework'),
					'subtitle' => sprintf(esc_html__('Turn on this option if you want to enable custom page title on %s', 'benaa-framework'), $value['title']),
					'options'  => gf_get_toggle(),
					'default'  => 0
				),
				
				gf_get_page_title_enable( "{$key}_title_enable", array("custom_{$key}_title_enable",'=','1'), 1 ),
				gf_get_page_title_layout_style("{$key}_title_layout_style", array(
					array("custom_{$key}_title_enable", '=', '1'),
					array("{$key}_title_enable", '=', '1'),
				), 'large'),
				gf_get_title_enable( "{$key}_enable", array(
					array("custom_{$key}_title_enable", '=', '1'),
					array("{$key}_title_enable", '=', '1'),
				),1),
				gf_get_page_title( "{$key}_title", array(
					array("custom_{$key}_title_enable", '=', '1'),
					array("{$key}_title_enable", '=', '1'),
					array("{$key}_enable", '=', '1'),
				),''),
				gf_get_page_sub_title("{$key}_sub_title",  array(
					array("custom_{$key}_title_enable", '=', '1'),
					array("{$key}_title_enable", '=', '1'),
					array("{$key}_enable", '=', '1'),
				),''),
				gf_get_page_title_padding("{$key}_title_padding", array(
					array("custom_{$key}_title_enable", '=', '1'),
					array("{$key}_title_enable", '=', '1')
				)),
				gf_get_page_title_background_image("{$key}_title_bg_image", array(
					array("custom_{$key}_title_enable", '=', '1'),
					array("{$key}_title_enable", '=', '1'),
					array("{$key}_title_layout_style", '=', 'large')
				), GF_PLUGIN_URL . 'assets/images/theme-options/page-title.jpg'),
				gf_get_page_title_parallax("{$key}_title_parallax", array(
					array("custom_{$key}_title_enable", '=', '1'),
					array("{$key}_title_enable", '=', '1'),
					array("{$key}_title_layout_style", '=', 'large'),
					array("{$key}_title_bg_image[id]", '!=', ''),
				), 0),
                gf_get_breadcrumb_enable( "{$key}_breadcrumb_enable", array(
					array("custom_{$key}_title_enable",'=','1'),
					array("{$key}_title_enable",'=','1')
				) )
				
				
			);
			
			$options[] = array(
				'id'     => "section_page_title_group_{$key}",
				'title'  => $value['title'],
				'type'   => 'group',
				//'toggle_default' => false,
				'fields' => $fields
			);
		}
		return $options;
	}
}

/**
 * Get Config Sidebar Layout
 * *******************************************************
 */
if (!function_exists('gf_get_config_sidebar_layout')) {
	function gf_get_config_sidebar_layout($id, $required = array(), $default = 'right')
	{
		return array(
			'id'       => $id,
			'title'    => esc_html__('Sidebar Layout', 'benaa-framework'),
			'type'     => 'image_set',
			'options'  => gf_get_sidebar_layout(),
			'default'  => $default,
			'required' => $required
		);
	}
}

/**
 * Get Config Sidebar
 * *******************************************************
 */
if (!function_exists('gf_get_config_sidebar')) {
	function gf_get_config_sidebar($id, $required = array(), $title = '', $default = 'main')
	{
		if (empty($title)) {
			$title = esc_html__('Sidebar', 'benaa-framework');
		}
		return array(
			'id'          => $id,
			'title'       => $title,
			'type'        => 'selectize',
			'allow_clear' => true,
			'placeholder' => esc_html__('Select Sidebar', 'benaa-framework'),
			'data'        => 'sidebar',
			'default'     => $default,
			'required'    => $required
		);
	}
}

/**
 * Get Config Border Bottom
 * *******************************************************
 */
if (!function_exists('gf_get_config_border_bottom')) {
	function gf_get_config_border_bottom($id, $required = array(), $default = 'none')
	{
		return array(
			'id'          => $id,
			'type'        => 'selectize',
			'allow_clear' => true,
			'title'       => esc_html__('Border Bottom', 'benaa-framework'),
			'options'     => gf_get_border_layout(),
			'default'     => $default,
			'required'    => $required
		);
	}
}

// Get Page Layout
if (!function_exists('gf_get_page_layout')) {
	function gf_get_page_layout($id, $required = array(), $default = 'container')
	{
		return array(
			'id'       => $id,
			'type'     => 'button_set',
			'title'    => esc_html__('Layout', 'benaa-framework'),
			'subtitle' => esc_html__('Select Page Layout', 'benaa-framework'),
			'desc'     => '',
			'options'  => gf_get_page_layout_option(),
			'default'  => $default,
			'required' => $required,
		);
	}
}

/**
 * Get Config Top Bar
 * *******************************************************
 */
if (!function_exists('gf_get_config_group_top_bar')) {
	function gf_get_config_group_top_bar($id, $title, $prefixId, $required = array())
	{
		return array(
			'id'             => $id,
			'title'          => $title,
			'type'           => 'group',
			'toggle_default' => true,
			'required'       => $required,
			'fields'         => array(
				array(
					'id'       => "{$prefixId}_enable",
					'title'    => esc_html__('Top Bar Enable', 'benaa-framework'),
					'subtitle' => esc_html__('Turn On this option if you want to enable top bar', 'benaa-framework'),
					'options'  => gf_get_toggle(),
					'type'     => 'button_set',
					'default'  => 1
				),
				array(
					'id'       => "{$prefixId}_layout",
					'title'    => esc_html__('Layout', 'benaa-framework'),
					'type'     => 'image_set',
					'options'  => gf_get_top_bar_layout(),
					'default'  => 'top-bar-1',
					'required' => array("{$prefixId}_enable", '=', '1')
				),
				gf_get_config_sidebar("{$prefixId}_left_sidebar", array("{$prefixId}_enable", '=', '1'), esc_html__('Top Bar Left', 'benaa-framework'), 'top_bar_left'),
				gf_get_config_sidebar("{$prefixId}_right_sidebar", array(array("{$prefixId}_enable", '=', '1'), array("{$prefixId}_layout", '!=', 'top-bar-4')), esc_html__('Top Bar Right', 'benaa-framework'), 'top_bar_right'),
				array(
					'id'       => "{$prefixId}_padding",
					'title'    => esc_html__('Padding', 'benaa-framework'),
					'subtitle' => esc_html__('Top/Bottom Padding', 'benaa-framework'),
					'desc'     => esc_html__('If you would like to override the default top bar top/bottom padding, then you can do so here.', 'benaa-framework'),
					'type'     => 'spacing',
					'left'     => false,
					'right'    => false,
					'default'  => array(
						'top'    => '10',
						'bottom' => '10'
					),
					'required' => array("{$prefixId}_enable", '=', '1'),
				),
				gf_get_config_border_bottom("{$prefixId}_border", array("{$prefixId}_enable", '=', '1'))
			)
		);
	}
}

/**
 * Get Page title Enabel
 * *******************************************************
 */
if (!function_exists('gf_get_page_title_enable')) {
	function gf_get_page_title_enable($id, $required = array(), $default = 1)
	{
		return array(
			'id'       => $id,
			'type'     => 'button_set',
			'title'    => esc_html__('Page Title Enable', 'benaa-framework'),
			'subtitle' => esc_html__('Enable/Disable Page Title', 'benaa-framework'),
			'desc'     => '',
			'options'  => gf_get_toggle(),
			'default'  => $default,
			'required' => $required,
		);
	}
}

/**
 * Get Page Title
 * *******************************************************
 */
if (!function_exists('gf_get_title_enable')) {
	function gf_get_title_enable($id, $required = array(), $default = 1)
	{
		return array(
			'id'       => $id,
			'type'     => 'button_set',
			'title'    => esc_html__('Title Enable', 'benaa-framework'),
			'subtitle' => esc_html__('Enable/Disable Title and Sub Title', 'benaa-framework'),
			'desc'     => '',
			'options'  => gf_get_toggle(),
			'default'  => $default,
			'required' => $required,
		);
	}
}

/**
 * Get Page Title
 * *******************************************************
 */
if (!function_exists('gf_get_page_title')) {
	function gf_get_page_title( $id, $required = array(), $default=null ) {
		return array(
			'id'       => $id,
			'type'     => 'text',
			'title'    => esc_html__( 'Title', 'beyot-framework' ),
			'subtitle' => '',
			'desc'     => '',
			'default'  => $default,
			'required' => $required,
		);
	}
}

/**
 * Get Page subtitle
 * *******************************************************
 */
if (!function_exists('gf_get_page_sub_title')) {
	function gf_get_page_sub_title($id, $required = array(), $default = null)
	{
		return array(
			'id'       => $id,
			'type'     => 'text',
			'title'    => esc_html__('Sub Title', 'benaa-framework'),
			'subtitle' => '',
			'desc'     => '',
			'default'  => $default,
			'required' => $required,
		);
	}
}

/**
 * Get Page Title
 * *******************************************************
 */
if (!function_exists('gf_get_page_title_layout_style')) {
	function gf_get_page_title_layout_style($id, $required = array(), $default = 'large')
	{
		return array(
			'id'       => $id,
			'type'     => 'button_set',
			'title'    => esc_html__('Page Title Layout Style', 'benaa-framework'),
			'subtitle' => esc_html__('Select the layout style', 'benaa-framework'),
			'desc'     => '',
			'options'  => array(
				'small' => esc_html__('Small', 'benaa-framework'),
				'large' => esc_html__('Large', 'benaa-framework')
			),
			'default'  => $default,
			'required' => $required,
		);
	}
}

/**
 * Get Page title padding
 * *******************************************************
 */
if (!function_exists('gf_get_page_title_padding')) {
	function gf_get_page_title_padding(
		$id, $required = array(), $default = array(
		'top'    => '70',
		'bottom' => '70'
	)
	)
	{
		return array(
			'id'             => $id,
			'type'           => 'spacing',
			'mode'           => 'padding',
			'units'          => 'px',
			'units_extended' => 'false',
			'title'          => esc_html__('Padding', 'benaa-framework'),
			'subtitle'       => esc_html__('Set page title top/bottom padding.', 'benaa-framework'),
			'desc'           => '',
			'left'           => false,
			'right'          => false,
			'default'        => $default,
			'required'       => $required,
		);
	}
}

/**
 * Get Page title background image
 * *******************************************************
 */
if (!function_exists('gf_get_page_title_background_image')) {
	function gf_get_page_title_background_image($id, $required = array(), $default = array())
	{
		return array(
			'id'       => $id,
			'type'     => 'image',
			'url'      => true,
			'title'    => esc_html__('Background Image', 'benaa-framework'),
			'subtitle' => esc_html__('Upload page title background.', 'benaa-framework'),
			'desc'     => '',
			'default'  => $default,
			'required' => $required,
		);
	}
}

/**
 * Get Page title background overlay
 * *******************************************************
 */
if (!function_exists('gf_get_page_title_background_overlay')) {
	function gf_get_page_title_background_overlay($id, $required = array(), $default = 1)
	{
		return array(
			'id'       => $id,
			'type'     => 'button_set',
			'title'    => esc_html__('Page Title Background Overlay', 'benaa-framework'),
			'subtitle' => esc_html__('Enable/Disable Breadcrumbs In Pages Title', 'benaa-framework'),
			'desc'     => '',
			'options'  => gf_get_toggle(),
			'default'  => $default,
			'required' => $required
		);
	}
}

/**
 * Get Page title parallax
 * *******************************************************
 */
if (!function_exists('gf_get_page_title_parallax')) {
	function gf_get_page_title_parallax($id, $required = array(), $default = 1)
	{
		return array(
			'id'       => $id,
			'type'     => 'button_set',
			'title'    => esc_html__('Page Title Parallax', 'benaa-framework'),
			'subtitle' => esc_html__('Enable Page Title Parallax', 'benaa-framework'),
			'desc'     => '',
			'options'  => gf_get_toggle(),
			'default'  => $default,
			'required' => $required,
		);
	}
}

/**
 * Get Breadcrumb Enable
 * *******************************************************
 */
if (!function_exists('gf_get_breadcrumb_enable')) {
	function gf_get_breadcrumb_enable($id, $required = array(), $default = 1)
	{
		return array(
			'id'       => $id,
			'type'     => 'button_set',
			'title'    => esc_html__('Breadcrumbs Enable', 'benaa-framework'),
			'subtitle' => esc_html__('Enable/Disable Breadcrumbs In Pages Title', 'benaa-framework'),
			'desc'     => '',
			'options'  => gf_get_toggle(),
			'default'  => $default,
			'required' => $required
		);
	}
}
if (!function_exists('gf_get_header_bar')) {
	function gf_get_header_bar()
	{
		$current_preset = isset($_POST['gf_select_preset']) ? $_POST['gf_select_preset'] : '';
		
		$args = array(
			'posts_per_page' => 1000,
			'post_type'      => 'gf_preset'
		);
		$presets = get_posts($args);
		?>
		<form class="load-preset-form" action="" method="post">
			<select name="gf_select_preset" id="gf_select_preset">
				<option
						value="" <?php echo($current_preset == '' ? 'selected' : ''); ?>><?php esc_html_e('--[Select Preset]--', 'benaa-framework'); ?></option>
				<?php foreach ($presets as $post) : ?>
					<option
							value="<?php echo esc_attr($post->ID) ?>" <?php echo($current_preset == $post->ID ? 'selected' : ''); ?>><?php echo esc_html($post->post_title) ?></option>
				<?php endforeach; ?>
				<?php wp_reset_postdata(); ?>
			</select>
			<button id="gf_choose_preset" type="submit"
					class="button"><?php esc_html_e('Load Preset', 'benaa-framework'); ?></button>
		</form>
		<?php
	}
	
	add_action('gsf/' . GF_OPTIONS_NAME . '-theme-option-form/before', 'gf_get_header_bar');
}