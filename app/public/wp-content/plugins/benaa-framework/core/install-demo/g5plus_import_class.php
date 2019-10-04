<?php
/**
 * Created by PhpStorm.
 * User: duonglh
 * Date: 8/28/14
 * Time: 3:46 PM
 */

define( 'G5PLUS_LOG_PROCESS_SLIDER', GF_PLUGIN_DIR . 'core' . DIRECTORY_SEPARATOR . 'install-demo' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'log' .DIRECTORY_SEPARATOR . 'log_process_slider.log' );

class GF_Import extends G5_Import {

	var $preStringOption;
	var $results;
	var $getOptions;
	var $saveOptions;
	var $termNames;

	/**
	 * Save Options
	 */
	function saveOptions( $option_file ) {
		global $wpdb;
		if ( ! is_file( $option_file ) ) {
			return false;
		}
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		WP_Filesystem();
		global $wp_filesystem;
		$setting_data = (array)json_decode($wp_filesystem->get_contents( $option_file ), true);

		foreach($setting_data as $key => $value) {
			$s_query = '';
			if (get_option($key) === false) {
				$s_query = $wpdb->prepare("insert into $wpdb->options(`option_name`, `option_value`, `autoload`) values(%s, %s, %s)", $key, base64_decode($value["option_value"]), $value["autoload"]);
			}
			else {
				$s_query = $wpdb->prepare("update $wpdb->options set `option_value` = %s , `autoload` = %s where option_name = %s", base64_decode($value["option_value"]), $value["autoload"], $key);
			}

			$wpdb->query($s_query);
		}


		return true;
	}

	/**
	 * Import Revolution Slider
	 * @param $other_data
	 * @return object|string
	 */
	function import_revslider($other_data) {
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		WP_Filesystem();
		global $wp_filesystem;
		$count_installed = 0;
		if (file_exists(G5PLUS_LOG_PROCESS_SLIDER)) {
			$count_installed = $wp_filesystem->get_contents(G5PLUS_LOG_PROCESS_SLIDER);
		}

		$is_import = false;
		$demo_site = isset($_REQUEST['demo_site']) ? $_REQUEST['demo_site'] : '.';


		if ( $handle = opendir( GF_PLUGIN_DIR . 'core' . DIRECTORY_SEPARATOR . 'install-demo' . DIRECTORY_SEPARATOR . 'data'. DIRECTORY_SEPARATOR . $demo_site . DIRECTORY_SEPARATOR . 'revslider' ) ) {
			$amount = 0;
			while ( false !== ( $entry = readdir( $handle ) ) ) {
				if ( $entry != "." && $entry != ".." ) {
					$amount +=1;
				}
			}
			closedir( $handle );
		}

		if ( $handle = opendir( GF_PLUGIN_DIR . 'core' . DIRECTORY_SEPARATOR . 'install-demo' . DIRECTORY_SEPARATOR . 'data'. DIRECTORY_SEPARATOR . $demo_site . DIRECTORY_SEPARATOR . 'revslider' ) ) {
			$count = 0;
			while ( false !== ( $entry = readdir( $handle ) ) ) {
				if ( $entry != "." && $entry != ".." ) {
					if ($count < $count_installed) {
						$count+=1;
						continue;
					}
					$rev_import_file = GF_PLUGIN_DIR . 'core' . DIRECTORY_SEPARATOR . 'install-demo' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . $demo_site . DIRECTORY_SEPARATOR . 'revslider' . DIRECTORY_SEPARATOR . $entry;
					if ( class_exists( 'RevSlider' ) ) {
						$slider   = new RevSlider();
						$slider->importSliderFromPost( true, true, $rev_import_file );
						$is_import = true;
						$wp_filesystem->put_contents(G5PLUS_LOG_PROCESS_SLIDER, $count_installed + 1, FS_CHMOD_FILE);
						break;
					} else {
						closedir( $handle );
						return 'done';
					}
				}
			}
			closedir( $handle );
		} else {
			return 'done';
		}

		if ($is_import) {
			return (object) array(
				'count' => 	$count_installed + 1,
				'amount' => $amount
			);
		}
		return 'done';
	}

	/**
	 * Update Missing Id
	 */
	function update_missing_id() {
		global $wpdb;

		$site_url = site_url();

		$demo_path = isset($_REQUEST['demo_path']) ? $_REQUEST['demo_path'] : '';

		// update menu_url
		$sql_query = $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key = '_menu_item_url'", G5PLUS_SITE_DEMO_URL . $demo_path ,$site_url );
		$wpdb->query($sql_query);

		// update xmenu config
		$sql_query = $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key = '_menu_item_xmenu_config'", G5PLUS_SITE_DEMO_URL . $demo_path ,$site_url );
		$wpdb->query($sql_query);

		//update post content
		$sql_query = $wpdb->prepare("UPDATE $wpdb->posts SET post_content = replace(post_content, %s, %s)", G5PLUS_SITE_DEMO_URL . $demo_path , $site_url);
		$wpdb->query($sql_query);

		// update postmeta - meta_value
		$sql_query = $wpdb->prepare("UPDATE $wpdb->postmeta SET meta_value = replace(meta_value, %s, %s) WHERE meta_key = '_wpb_shortcodes_custom_css'", G5PLUS_SITE_DEMO_URL . $demo_path , $site_url);
		$wpdb->query($sql_query);

		$sql_query = $wpdb->prepare("UPDATE $wpdb->posts SET post_content = replace(post_content, %s, %s)", urlencode(G5PLUS_SITE_DEMO_URL) . urlencode($demo_path)  , urlencode($site_url));
		$wpdb->query($sql_query);

		// updage guid in posts
		$sql_query = $wpdb->prepare("UPDATE $wpdb->posts SET guid = replace(guid, %s, %s)", G5PLUS_SITE_DEMO_URL . $demo_path , $site_url);
		$wpdb->query($sql_query);

		$sql_query = $wpdb->prepare("UPDATE $wpdb->posts SET guid = replace(guid, %s, %s)", 'http://demo2.woothemes.com/woocommerce', $site_url);
		$wpdb->query($sql_query);

		// Update COUNT term_taxonomy
		$sql_query = "UPDATE $wpdb->term_taxonomy tt SET count = (SELECT count(p.ID) FROM $wpdb->term_relationships tr LEFT JOIN wp_posts p ON (p.ID = tr.object_id AND p.post_status = 'publish') WHERE tr.term_taxonomy_id = tt.term_taxonomy_id)";
		$wpdb->query($sql_query);

		// Update MailChimp
		$rows = $wpdb->get_results($wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type = %s and post_status = 'publish'", 'mc4wp-form' ) );
		if (count($rows) > 0) {
			update_option('mc4wp_default_form_id', $rows[0]->ID);
		}


		require_once(ABSPATH . 'wp-admin/includes/file.php');
		WP_Filesystem();
		global $wp_filesystem;

		$posts_id = json_decode( $wp_filesystem->get_contents( PROCESS_POSTS ), true );
		$terms_id = json_decode( $wp_filesystem->get_contents( PROCESS_TERM ), true );

		$options_changed_id = (array)json_decode($wp_filesystem->get_contents( CHANGE_DATA_FILE), true);

		// Update Options Page/Post ID
		if (isset($options_changed_id['posts']) && is_array($options_changed_id['posts'])) {
			foreach ($options_changed_id['posts'] as $key => $value) {
				update_option($key, isset($posts_id[$value]) ? $posts_id[$value] : $value);
			}
		}

		$arr_cate = array('tax_meta_');
		if (isset($options_changed_id['tax-meta-class']) && is_array($options_changed_id['tax-meta-class'])) {
			foreach ($options_changed_id['tax-meta-class'] as $key => $value ) {
				foreach ($arr_cate as $cate_prefix) {
					if (strrpos($key, $cate_prefix) === 0) {
						$key = preg_replace_callback(
							'|' . $cate_prefix . '([0-9]+)|',
							function($aMatches) use($cate_prefix, $terms_id) {
								$new_term_id = isset($terms_id[($aMatches[1])]) ? $terms_id[($aMatches[1])] : $aMatches[1];
								return $cate_prefix . $new_term_id;
							},
							$key
						);
						update_option($key, unserialize($value));
						break;
					}
				}
			}
		}

		$table_name = $wpdb->prefix . "termmeta";
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
			if (isset($options_changed_id['termmeta']) && is_array($options_changed_id['termmeta'])) {
				foreach ($options_changed_id['termmeta'] as $value ) {
					if (function_exists('add_term_meta')) {
						$term_id = $value['term_id'];
						if (isset($terms_id[$term_id])) {
							$term_id = $terms_id[$term_id];
						}
						if (in_array($value['meta_key'], array('g5plus_archive_product_banner_image', 'g5plus_page_title_bg_image'))) {
							if (isset($value['meta_value']['id']) && isset($posts_id[$value['meta_value']['id']])) {
								$value['meta_value']['id'] = $posts_id[$value['meta_value']['id']];
							}
							if (isset($value['meta_value']['url'])) {
								$value['meta_value']['url'] = str_replace(G5PLUS_SITE_DEMO_URL . $demo_path , $site_url, $value['meta_value']['url']);
							}
						}

						add_term_meta($term_id, $value['meta_key'], $value['meta_value']);
					}
				}
			}
		}

		if (function_exists('add_woocommerce_term_meta')) {
			// Update Woocommer Meta Term
			if (isset($options_changed_id['woocommerce_termmeta']) && is_array($options_changed_id['woocommerce_termmeta'])) {
				foreach ($options_changed_id['woocommerce_termmeta'] as $key => $value ) {
					$new_term_id = isset($terms_id[$key]) ? $terms_id[$key] : $key;
					$meta_value = isset($posts_id[$value]) ? $posts_id[$value] : $value;
					add_woocommerce_term_meta($new_term_id, 'thumbnail_id', $meta_value);
				}
			}
		}

		// Change nav_menu_location
		$data = get_option('theme_mods_' . G5PLUS_THEME_MOD_NAME);

		if (isset($data['nav_menu_locations'])) {
			foreach ($data['nav_menu_locations'] as $key => $value) {
				$data['nav_menu_locations'][$key] = isset($terms_id[$value]) ? $terms_id[$value] : $value;
			}
		}
		update_option('theme_mods_' . get_option("stylesheet"), $data);

		// Change theme_mod
		$data['sidebars_widgets'] = array(
			'time' => time(),
			'data' => get_option('sidebars_widgets')
		);

		if (is_child_theme()) {
			update_option('theme_mods_' . get_template(), $data);
		}
		else {
			update_option('theme_mods_' . get_option("stylesheet") . '-child', $data);
		}

		unset($data);

		// Change nav_menu ID in widget
		$rows = $wpdb->get_results($wpdb->prepare( "SELECT option_name FROM $wpdb->options WHERE option_name like %s", 'widget_%' ) );
		foreach ($rows as $row) {
			if ($row->option_name == 'widget_nav_menu') {
				$data = get_option($row->option_name);
				if (isset($data) && is_array($data)) {
					foreach ($data as $key => $value) {
						if (is_array($value) && isset($value['nav_menu'])) {
							$data[$key]['nav_menu'] = isset($terms_id[$value['nav_menu']]) ? $terms_id[$value['nav_menu']] : $value['nav_menu'];
						}
					}
				}
				update_option($row->option_name, $data);
			}
		}


		// Update Menu Id on Preset
		$rows = $wpdb->get_results($wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type = %s and post_status = %s", 'gf_preset', 'publish' ) );
		foreach ($rows as $row) {
			$menu_id = get_post_meta($row->ID, GF_METABOX_PREFIX . 'page_menu', true);
			if ($menu_id && isset($terms_id[$menu_id])) {
				update_post_meta($row->ID, GF_METABOX_PREFIX . 'page_menu', $terms_id[$menu_id]);
			}

			$menu_id = get_post_meta($row->ID, GF_METABOX_PREFIX . 'page_menu_mobile', true);
			if ($menu_id && isset($terms_id[$menu_id])) {
				update_post_meta($row->ID, GF_METABOX_PREFIX . 'page_menu_mobile', $terms_id[$menu_id]);
			}
		}

		if (function_exists('rev_slider_shortcode')) {
			if (isset($options_changed_id['wp_revslider_navigations']) && is_array($options_changed_id['wp_revslider_navigations'])) {
				$table_name = $wpdb->prefix . "revslider_navigations";
				if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
					foreach ($options_changed_id['wp_revslider_navigations'] as $nav_items ) {
						$sql_query = $wpdb->prepare( "INSERT INTO $table_name (id, name, handle, css, markup, settings) VALUES (%d, %s, %s, %s, %s, %s)",
							$nav_items['id'],
							$nav_items['name'],
							$nav_items['handle'],
							$nav_items['css'],
							$nav_items['markup'],
							$nav_items['settings']
						);
						$wpdb->query($sql_query);
					}
				}
			}
		}
	}

	function import_setting( $file ) {
		add_filter( 'import_post_meta_key', array( $this, 'is_valid_meta_key' ) );
		add_filter( 'http_request_timeout', array( &$this, 'bump_request_timeout' ) );

		require_once(ABSPATH . 'wp-admin/includes/file.php');
		WP_Filesystem();
		global $wp_filesystem;

		$this->import_start( $file );

		$this->get_author_mapping();

		wp_suspend_cache_invalidation( true );
		$this->process_categories();
		$this->process_tags();
		$this->process_terms();

		$this->process_posts(true);

		wp_suspend_cache_invalidation( false );

		// update incorrect/missing information in the DB
		$this->backfill_parents();
		$this->backfill_attachment_urls();
		$this->remap_featured_images();
		$this->import_end();

		return true;
	}
} 