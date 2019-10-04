<?php
/**
 * G5Plus Theme Framework includes
 *
 * The $g5plus_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link http://g5plus.net
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once G5PLUS_THEME_DIR . 'core/class-tgm-plugin-activation.php';
if (!function_exists('g5plus_register_required_plugins')) {
	function g5plus_register_required_plugins() {
		/*
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(
			array(
				'name'               => 'Benaa Framework', // The plugin name
				'slug'               => 'benaa-framework', // The plugin slug (typically the folder name)
				'source'             => get_template_directory() .  '/inc/plugins/benaa-framework-v1.1.zip', // The plugin source
				'required'           => true, // If false, the plugin is only 'recommended' instead of required
				'version'            => '1.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'               => 'Essential Real Estate', // The plugin name
				'slug'               => 'essential-real-estate', // The plugin slug (typically the folder name)
				'required'           => true, // If false, the plugin is only 'recommended' instead of required
			),
			array(
				'name'               => 'Visual Composer', // The plugin name
				'slug'               => 'js_composer', // The plugin slug (typically the folder name)
				'source'             => get_template_directory() .  '/inc/plugins/js_composer-v5.4.7.zip', // The plugin source
				'required'           => true, // If false, the plugin is only 'recommended' instead of required
				'version' => '5.4.7', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'               => 'Envato Market', // The plugin name
				'slug'               => 'envato-market', // The plugin slug (typically the folder name)
				'source'             => get_template_directory() .  '/inc/plugins/envato-market.zip', // The plugin source
				'required'           => true, // If false, the plugin is only 'recommended' instead of required
				'version'            => '1.0.0-RC2', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'               => 'WordPress Social Login', // The plugin name
				'slug'               => 'wordpress-social-login', // The plugin slug (typically the folder name)
				'required'           => true, // If false, the plugin is only 'recommended' instead of required
			),
			array(
				'name'               => 'WP Mail SMTP', // The plugin name
				'slug'               => 'wp-mail-smtp', // The plugin slug (typically the folder name)
				'required'           => true, // If false, the plugin is only 'recommended' instead of required
			),
			array(
				'name'               => 'Contact Form 7', // The plugin name
				'slug'               => 'contact-form-7', // The plugin slug (typically the folder name)
				'required'           => true, // If false, the plugin is only 'recommended' instead of required
			),
			array(
				'name'               => 'MailChimp for WordPress', // The plugin name
				'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name)
				'required'           => true, // If false, the plugin is only 'recommended' instead of required
			),
		);

		/*
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */

		// Change this to your theme text domain, used for internationalising strings
		$config = array(
			'domain'       => 'benaa',
			'id'           => 'g5plus_theme_framework',// Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to pre-packaged plugins.
			'menu'         => 'install-required-plugins', // Menu slug.
			'parent_slug'  => 'themes.php',            // Parent menu slug.
			'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
			'strings'      => array(
				'page_title'                      => esc_html__( 'Install Required Plugins', 'benaa' ),
				'menu_title'                      => esc_html__( 'Install Plugins', 'benaa' ),
				'installing'                      => esc_html__( 'Installing Plugin: %s', 'benaa' ), // %s = plugin name.
				'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'benaa' ),
				'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'benaa' ), // %1$s = plugin name(s).
				'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'benaa' ), // %1$s = plugin name(s).
				'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'benaa' ), // %1$s = plugin name(s).
				'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'benaa' ), // %1$s = plugin name(s).
				'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'benaa' ), // %1$s = plugin name(s).
				'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'benaa' ), // %1$s = plugin name(s).
				'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'benaa' ), // %1$s = plugin name(s).
				'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'benaa' ), // %1$s = plugin name(s).
				'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'benaa' ),
				'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'benaa' ),
				'return'                          => esc_html__( 'Return to Required Plugins Installer', 'benaa' ),
				'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'benaa' ),
				'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'benaa' ), // %s = dashboard link.
				'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
			)
		);
		tgmpa( $plugins, $config );
	}
	add_action( 'tgmpa_register', 'g5plus_register_required_plugins' );
}