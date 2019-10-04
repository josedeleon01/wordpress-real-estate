<?php
/**
 * COMMON FUNCTION FOR PLUGIN FRAMEWORK
 */

/**
 * GET Plugin template
 * *******************************************************
 */
function gf_get_template($slug, $args = array())
{
	if ($args && is_array($args)) {
		extract($args);
	}
	$located = GF_PLUGIN_DIR . $slug . '.php';
	if (!file_exists($located)) {
		_doing_it_wrong(__FUNCTION__, sprintf('<code>%s</code> does not exist.', $slug), '1.0');
		return;
	}
	include($located);
}

/**
 * GET Meta Box Value
 * *******************************************************
 */
if (!function_exists('gf_get_post_meta')) {
	function gf_get_post_meta($key, $post_id = null,$is_single=true)
	{
		return get_post_meta($post_id, GF_METABOX_PREFIX. $key, $is_single);
	}
}

/**
 * GET Meta Box Image Value
 * *******************************************************
 */
if (!function_exists('gf_get_post_meta_image')) {
	function gf_get_post_meta_image($key, $post_id = null)
	{
		$metabox_id = gf_get_post_meta($key, $post_id, true);
		$image_url = '';
		if ($metabox_id !== array() && isset($metabox_id['url'])) {
			$image_url = $metabox_id['url'];
		}
		return $image_url;
	}
}

/**
 * GET theme option value
 * *******************************************************
 */
if (!function_exists('gf_get_option')) {
	function gf_get_option($key, $default = '')
	{
		return isset($GLOBALS[GF_OPTIONS_NAME][$key]) ? $GLOBALS[GF_OPTIONS_NAME][$key] : $default;
	}
}

/**
 * CONVERT hexa color to rgba color
 * *******************************************************
 */
if (!function_exists('gf_hex2rgba')) {
	function gf_hex2rgba($hex, $opacity) {
		if ($opacity > 1) {
			$opacity = $opacity / 100;
		}
		if (strtolower($hex) == 'transparent') {
			return 'transparent';
		}
		$hex = str_replace("#", "", $hex);

		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} elseif(strlen($hex) == 6) {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		else {
			$r = 0;
			$g = 0;
			$b = 0;
			$opacity = 0;
		}
		return sprintf('rgba(%s,%s,%s,%s)', $r, $g, $b, $opacity);
	}
}

/**
 * Load Preset Into Theme Options
 * *******************************************************
 */
if (!function_exists('gf_load_preset_into_theme_options')) {
	function &gf_load_preset_into_theme_options(&$options, $current_preset) {
		$meta_fields = &gf_get_meta_fields();
		foreach ($options as $key => $value) {
			if (isset($meta_fields[$key])) {
				$condition = true;
				foreach ($meta_fields[$key] as $meta_key =>  $meta_value) {
					$condition_value = gf_get_post_meta($meta_key, $current_preset);
					if ($condition_value != $meta_value) {
						$condition = false;
						break;
					}
				}
				if ($condition) {
					$meta_value = gf_get_post_meta($key, $current_preset);
					$options[$key] = $meta_value;
				}
			} else {
				$meta_value = gf_get_post_meta($key, $current_preset);
				if ($meta_value !== '') {
					$options[$key] = $meta_value;
				}
			}
		}
		return $options;
	}
}

/**
 * Get Current Preset ID
 * *******************************************************
 */
if (!function_exists('gf_get_current_preset')) {
	function gf_get_current_preset() {
		global $post;

		$post_type = get_post_type($post);
		$preset_id = 0;
		$list_post_type = apply_filters('gf_post_type_preset', array());
		foreach ($list_post_type as $post_type_name => $post_type_value) {
			if (is_post_type_archive( $post_type_name )
			    || (isset( $post_type_value['category'] ) && is_tax($post_type_value['category']))
			    || (isset( $post_type_value['tag'] ) && is_tax($post_type_value['tag']))) {
				$page_preset = gf_get_option($post_type_name . '_preset');
				if ($page_preset) {
					$preset_id = $page_preset;
				}
			}
			/**
			 * Single Post Type
			 */
			elseif (is_singular($post_type_name)) {
				$page_preset = gf_get_option($post_type_name . '_single_preset');
				if ($page_preset) {
					$preset_id = $page_preset;
				}
			}
			if ($preset_id) {
				break;
			}
		}
		if ($preset_id) {}
		/**
		 * Blog
		 */
		elseif (is_home() || is_category() || is_tag() || is_search() || (is_archive() && $post_type == 'post')) {
			$page_preset = gf_get_option('blog_preset');
			if ($page_preset) {
				$preset_id = $page_preset;
			}
		}
		/**
		 * Blog Single
		 */
		elseif (is_singular('post')) {
			$page_preset = gf_get_option('blog_single_preset');
			if ($page_preset) {
				$preset_id = $page_preset;
			}
		}
		/**
		 * 404 Page
		 */
		elseif (is_404()) {
			$page_preset = gf_get_option('page_404_preset');
			if ($page_preset) {
				$preset_id = $page_preset;
			}
		}


		/**
		 * Single Page
		 */
		if (is_singular()) {
			/**
			 * Get Preset
			 */
			$page_preset = gf_get_post_meta('page_preset', get_the_ID());
			if ($page_preset) {
				$preset_id = $page_preset;
			}

			if (is_singular('gf_preset')) {
				$preset_id = get_the_ID();
			}
		}
		return $preset_id;
	}
}

/**
 * Get Preset Dir
 * *******************************************************
 */
if (!function_exists('gf_get_preset_dir')) {
	function gf_get_preset_dir() {
		return trailingslashit(get_template_directory()) . 'assets/preset/';
	}
}

/**
 * Get Preset Url
 * *******************************************************
 */
if (!function_exists('gf_get_preset_url')) {
	function gf_get_preset_url() {
		return trailingslashit(get_template_directory_uri()) . 'assets/preset/';
	}
}

/**
 * Enqueue Preset Style
 * @preset_type: style, rtl, tta
 * *******************************************************
 */
if (!function_exists('gf_enqueue_preset_style')) {
	function gf_enqueue_preset_style($preset_id, $preset_type) {
		$filename = $preset_id . '.' . $preset_type . '.min.css';
		if (!file_exists(gf_get_preset_dir() . $filename)) {
			gf_generate_less($preset_id);
			if (!file_exists(gf_get_preset_dir() . $filename)) {
				return false;
			}
		}
		wp_enqueue_style('g5plus-framework-' . $preset_type, gf_get_preset_url() . $filename);
		return true;
	}
}

/**
 * Get Fonts Awesome Array
 * *******************************************************
 */
if (!function_exists('gf_get_font_awesome')) {
	function &gf_get_font_awesome() {
		if (function_exists('g5plus_get_font_awesome')) {
			return g5plus_get_font_awesome();
		}
		$fonts = array();
		return $fonts;
	}
}

/**
 * Get Theme Font Icon
 * *******************************************************
 */
if (!function_exists('gf_get_theme_font')) {
	function &gf_get_theme_font() {
		if (function_exists('g5plus_get_theme_font')) {
			return g5plus_get_theme_font();
		}
		$fonts = array();
		return $fonts;
	}
}

/**
 * Get Post Thumbnail
 * *******************************************************
 */
if (!function_exists('gf_get_post_thumbnail')) {
	function gf_get_post_thumbnail($size, $noImage = 0, $is_single = false) {
		if (function_exists('g5plus_get_post_thumbnail')) {
			g5plus_get_post_thumbnail($size, $noImage, $is_single);
		}
	}
}

/**
 * Get Color Fields
 * *******************************************************
 */
if (!function_exists('gf_get_meta_fields')) {
	function &gf_get_meta_fields() {
		if (isset($GLOBALS['gf_meta_field_setting'])) {
			return $GLOBALS['gf_meta_field_setting'];
		}
		$GLOBALS['gf_meta_field_setting'] = array(
			'accent_color' => array(
				'custom_color_general' => '1'
			),
			'foreground_accent_color' => array(
				'custom_color_general' => '1'
			),
			'text_color' => array(
				'custom_color_general' => '1'
			),
			'border_color' => array(
				'custom_color_general' => '1'
			),
			'heading_color' => array(
				'custom_color_general' => '1'
			),
			'top_drawer_bg_color' => array(
				'custom_color_top_drawer' => '1'
			),
			'top_drawer_text_color' => array(
				'custom_color_top_drawer' => '1'
			),

			'header_bg_color' => array(
				'custom_color_header' => '1'
			),
			'header_text_color' => array(
				'custom_color_header' => '1'
			),
			'header_border_color' => array(
				'custom_color_header' => '1'
			),

			'top_bar_bg_color' => array(
				'custom_color_top_bar' => '1'
			),
			'top_bar_text_color' => array(
				'custom_color_top_bar' => '1'
			),
			'top_bar_border_color' => array(
				'custom_color_top_bar' => '1'
			),

			'navigation_bg_color' => array(
				'custom_color_navigation' => '1'
			),
			'navigation_text_color' => array(
				'custom_color_navigation' => '1'
			),
			'navigation_text_color_hover' => array(
				'custom_color_navigation' => '1'
			),

			'footer_bg_color' => array(
				'custom_color_footer' => '1'
			),
			'footer_text_color' => array(
				'custom_color_footer' => '1'
			),
			'footer_widget_title_color' => array(
				'custom_color_footer' => '1'
			),
			'footer_border_color' => array(
				'custom_color_footer' => '1'
			),

			'bottom_bar_bg_color' => array(
				'custom_color_bottom_bar' => '1'
			),
			'bottom_bar_text_color' => array(
				'custom_color_bottom_bar' => '1'
			),
			'bottom_bar_border_color' => array(
				'custom_color_bottom_bar' => '1'
			),
			'page_title_bg_image' => array(
				'page_title_enable' =>  '1',
				'custom_page_title_bg_image_enable' => '1'
			),
			'logo' => array(
				'custom_logo_enable' => '1'
			),
			'logo_retina' => array(
				'custom_logo_enable' => '1'
			),
			'sticky_logo' => array(
				'custom_logo_enable' => '1'
			),
			'sticky_logo_retina' => array(
				'custom_logo_enable' => '1'
			),
			'mobile_logo' => array(
				'custom_logo_mobile_enable' => '1'
			),
			'mobile_logo_retina' => array(
				'custom_logo_mobile_enable' => '1'
			),
			'footer_bg_image' => array(
				'custom_footer_bg_image_enable' => '1'
			)
		);
		return $GLOBALS['gf_meta_field_setting'];
	}
}

//////////////////////////////////////////////////////////////////
// Get Page Layout Settings
//////////////////////////////////////////////////////////////////
if (!function_exists('gf_get_page_layout_settings')) {
	function &gf_get_page_layout_settings(){
		$key_page_layout_settings = 'g5plus_page_layout_settings';
		if (isset($GLOBALS[$key_page_layout_settings]) && is_array($GLOBALS[$key_page_layout_settings])) {
			return $GLOBALS[$key_page_layout_settings];
		}
		$GLOBALS[$key_page_layout_settings] = array(
			'layout'                 => gf_get_option( 'layout','container' ),
			'sidebar_layout'         => gf_get_option( 'sidebar_layout','right' ),
			'sidebar'                => gf_get_option( 'sidebar','main-sidebar' ),
			'sidebar_width'          => gf_get_option( 'sidebar_width','small' ),
			'sidebar_mobile_enable'  => gf_get_option( 'sidebar_mobile_enable',1 ),
			'sidebar_mobile_canvas'  => gf_get_option( 'sidebar_mobile_canvas',1 ),
			'padding'                => gf_get_option( 'content_padding',array('top' => '70', 'bottom' => '70') ),
			'padding_mobile'         => gf_get_option( 'content_padding_mobile',array('top' => '30', 'bottom' => '30') ),
			'remove_content_padding' => 0,
			'has_sidebar' => 0
		);
		return $GLOBALS[$key_page_layout_settings];
	}
}

//////////////////////////////////////////////////////////////////
// Get Post Layout Settings
//////////////////////////////////////////////////////////////////
if (!function_exists('gf_get_post_layout_settings')){
	function &gf_get_post_layout_settings(){
		$key_post_layout_settings = 'g5plus_post_layout_settings';
		if (isset($GLOBALS[$key_post_layout_settings]) && is_array($GLOBALS[$key_post_layout_settings])) {
			return $GLOBALS[$key_post_layout_settings];
		}

		$GLOBALS[$key_post_layout_settings] = array(
			'layout'      => gf_get_option('post_layout','large-image'),
			'columns' => gf_get_option('post_column',3),
			'paging'      => gf_get_option('post_paging','navigation'),
			'slider'      => false
		);

		return $GLOBALS[$key_post_layout_settings];
	}
}

/** Get custom User*/
if(!function_exists('gf_get_customer_meta_fields')){
	function gf_get_customer_meta_fields() {
		$show_fields = apply_filters('gf_get_customer_meta_fields',
			array(
				'social-profiles' => array(
					'title' => esc_html__('Social Profiles','benaa-framework'),
					'fields' => array(
						'twitter_url' => array(
							'label' => esc_html__('Twitter','benaa-framework'),
							'description' => esc_html__('Your Twitter','benaa-framework'),
							'type' => 'text',
							'icon' => 'fa fa-twitter'
						),
						'facebook_url' => array(
							'label' => esc_html__('Facebook','benaa-framework'),
							'description' => esc_html__('Your facebook page/profile url','benaa-framework'),
							'type' => 'text',
							'icon' => 'fa fa-facebook'
						),
						'dribbble_url' => array(
							'label' => esc_html__('Dribbble','benaa-framework'),
							'description' => esc_html__('Your Dribbble','benaa-framework'),
							'type' => 'text',
							'icon' => 'fa fa-dribbble'
						),
						'vimeo_url' => array(
							'label' => esc_html__('Vimeo','benaa-framework'),
							'description' => esc_html__('Your Vimeo','benaa-framework'),
							'type' => 'text',
							'icon' => 'fa fa-vimeo-square'
						),
						'tumblr_url' => array(
							'label' => esc_html__('Tumblr','benaa-framework'),
							'description' => esc_html__('Your Tumblr','benaa-framework'),
							'type' => 'text',
							'icon' => 'fa fa-tumblr'
						),
						'skype_username' => array(
							'label' => esc_html__('Skype','benaa-framework'),
							'description' => esc_html__('Your Skype username','benaa-framework'),
							'type' => 'text',
							'icon' => 'fa fa-skype'
						),
						'linkedin_url' => array(
							'label' => esc_html__('LinkedIn','benaa-framework'),
							'description' => esc_html__('Your LinkedIn page/profile url','benaa-framework'),
							'type' => 'text',
							'icon' => 'fa fa-linkedin'
						),
						'googleplus_url' => array(
							'label' => esc_html__('Google+','benaa-framework'),
							'description' => esc_html__('Your Google+ page/profile URL','benaa-framework'),
							'type' => 'text',
							'icon' => 'fa fa-google-plus'
						),
						'flickr_url' => array(
							'label' => esc_html__('Flickr','benaa-framework'),
							'description' => esc_html__('Your Flickr page url','benaa-framework'),
							'type' => 'text',
							'icon' => 'fa fa-flickr'
						),
						'youtube_url' => array(
							'label' => esc_html__('YouTube','benaa-framework'),
							'description' => esc_html__('Your YouTube URL','benaa-framework'),
							'type' => 'text',
							'icon' => 'fa fa-youtube'
						),
						'pinterest_url' => array(
							'label' => esc_html__('Pinterest','benaa-framework'),
							'description' => esc_html__('Your Pinterest','benaa-framework'),
							'type' => 'text',
							'icon' => 'fa fa-pinterest'
						),
						'foursquare_url' => array(
							'label' => esc_html__('Foursquare','benaa-framework'),
							'description' => esc_html__('Your Foursqaure URL','benaa-framework'),
							'type' => 'text',
							'icon' => 'fa fa-foursquare'
						),
						'instagram_url' => array(
							'label' => esc_html__('Instagram','benaa-framework'),
							'description' => esc_html__('Your Instagram','benaa-framework'),
							'type' => 'text',
							'icon' => 'fa fa-instagram'
						),
						'github_url' => array(
							'label' => esc_html__('GitHub','benaa-framework'),
							'description' => esc_html__('Your GitHub URL','benaa-framework'),
							'type' => 'text',
							'icon' => 'fa fa-github'
						),
						'xing_url' => array(
							'label' => esc_html__('Xing','benaa-framework'),
							'description' => esc_html__('Your Xing URL','benaa-framework'),
							'type' => 'text',
							'icon' => 'fa fa-xing'
						),
						'behance_url' => array(
							'label' => esc_html__('Behance','benaa-framework'),
							'description' => esc_html__('Your Behance URL','benaa-framework'),
							'type' => 'text',
							'icon' => 'fa fa-behance'
						),
						'deviantart_url' => array(
							'label' => esc_html__('Deviantart','benaa-framework'),
							'description' => esc_html__('Your Deviantart URL','benaa-framework'),
							'type' => 'text',
							'icon' => 'fa fa-deviantart'
						),
						'soundcloud_url' => array(
							'label' => esc_html__('SoundCloud','benaa-framework'),
							'description' => esc_html__('Your SoundCloud URL','benaa-framework'),
							'type' => 'text',
							'icon' => 'fa fa-soundcloud'
						),
						'yelp_url' => array(
							'label' => esc_html__('Yelp','benaa-framework'),
							'description' => esc_html__('Your Yelp URL','benaa-framework'),
							'type' => 'text',
							'icon' => 'fa fa-yelp'
						),
						'rss_url' => array(
							'label' => esc_html__('RSS Feed','benaa-framework'),
							'description' => esc_html__('Your RSS Feed URL','benaa-framework'),
							'type' => 'text',
							'icon' => 'fa fa-rss'
						)
					)
				),
			)
		);
		return $show_fields;
	}
}
if(!function_exists('gf_add_customer_meta_fields')){
	function gf_add_customer_meta_fields( $user ) {

		$show_fields = gf_get_customer_meta_fields();

		foreach ( $show_fields as $fieldset ) :
			?>
			<h3><?php echo wp_kses_post($fieldset['title']); ?></h3>
			<table class="form-table">
				<?php
				foreach ( $fieldset['fields'] as $key => $field ) :
					?>
					<tr>
						<th><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ); ?></label></th>
						<td>
							<?php if ( ! empty( $field['type'] ) && 'select' == $field['type'] ) : ?>
								<select name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" class="<?php echo ( ! empty( $field['class'] ) ? $field['class'] : '' ); ?>" style="width: 25em;">
									<?php
									$selected = esc_attr( get_user_meta( $user->ID, $key, true ) );
									foreach ( $field['options'] as $option_key => $option_value ) : ?>
										<option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $selected, $option_key, true ); ?>><?php echo esc_attr( $option_value ); ?></option>
									<?php endforeach; ?>
								</select>
							<?php else : ?>
								<input type="text" name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( get_user_meta( $user->ID, $key, true ) ); ?>" class="<?php echo ( ! empty( $field['class'] ) ? $field['class'] : 'regular-text' ); ?>" />
							<?php endif; ?>
							<br/>
							<span class="description"><?php echo wp_kses_post( $field['description'] ); ?></span>
						</td>
					</tr>
					<?php
				endforeach;
				?>
			</table>
			<?php
		endforeach;
	}
}
if(!function_exists('gf_save_customer_meta_fields')){
	function gf_save_customer_meta_fields( $user_id ) {
		$save_fields = gf_get_customer_meta_fields();

		foreach ( $save_fields as $fieldset ) {
			foreach ( $fieldset['fields'] as $key => $field ) {
				if ( isset( $_POST[ $key ] )  ) {
					update_user_meta( $user_id, $key, sanitize_text_field( $_POST[ $key ] ) );
				}
			}
		}
	}
}

/*================================================
COMMENTS FORM
================================================== */
if (!function_exists('g5plus_comment_form')) {
	function g5plus_comment_form() {
		$commenter = gf_wp_get_current_commenter();
		$req = get_option('require_name_email');
		$aria_req = ($req ? " aria-required='true'" : '');
		$html5 = current_theme_supports('html5', 'comment-form') ? 'html5' : 'xhtml';;
		$fields = array(
			'author' => '<div class="form-group input-name">' .
				'<label>'. esc_html__('Your Name','benaa-framework').'</label>'.
				'<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" placeholder="'.esc_html__('Put your full Name','benaa-framework').'" ' . $aria_req . '>' .
				'</div>',
			'email' => '<div class="form-group input-email">' .
				'<label>'. esc_html__('Email','benaa-framework').'</label>'.
				'<input id="email" name="email" ' . ($html5 ? 'type="email"' : 'type="text"') . ' value="' . esc_attr($commenter['comment_author_email']) . '" placeholder="'.esc_html__('Email Address','benaa-framework').'" ' . $aria_req . '>' .
				'</div>',
			'phone'   => '<div class="form-group input-phone">'.
				'<label>'. esc_html__('Phone','benaa-framework').'</label>'.
				'<input id="phone" name="phone" ' . ( $html5 ? 'type="text"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_phone'] ) . '" placeholder="'.esc_html__('Your Phone Number','benaa-framework').'" />'.
				'</div>'
		);
		$fields = apply_filters('g5plus_comment_fields',$fields);
		$comment_form_args = array(
			'comment_field' => '<div class="form-group">' .
				'<label>'. esc_html__('Message','benaa-framework').'</label>'.
				'<textarea rows="6" id="comment" name="comment" placeholder="'.esc_html__('Your text here ...','benaa-framework') .'" '. $aria_req .'></textarea>' .
				'</div>',
			'fields' => $fields,
			'comment_notes_before' => '',
			'comment_notes_after' => '',
			'id_submit' => 'btnComment',
			'class_submit' => 'button-comment',
			'title_reply' => esc_html__('Leave a Comment', 'benaa-framework'),
			'title_reply_to' => esc_html__('Leave a Comment to %s', 'benaa-framework'),
			'cancel_reply_link' => esc_html__('Cancel reply', 'benaa-framework'),
			'label_submit' => esc_html__('Send Message', 'benaa-framework')
		);

		comment_form($comment_form_args);
	}
}
/*=======================*/
function gf_wp_get_current_commenter(){
	$comment_author = '';
	if ( isset($_COOKIE['comment_author_'.COOKIEHASH]) )
		$comment_author = $_COOKIE['comment_author_'.COOKIEHASH];

	$comment_author_email = '';
	if ( isset($_COOKIE['comment_author_email_'.COOKIEHASH]) )
		$comment_author_email = $_COOKIE['comment_author_email_'.COOKIEHASH];

	$comment_author_phone = '';
	if ( isset($_COOKIE['comment_author_phone'.COOKIEHASH]) )
		$comment_author_phone = $_COOKIE['comment_author_phone'.COOKIEHASH];
	apply_filters( 'wp_get_current_commenter', compact('comment_author', 'comment_author_email', 'comment_author_phone') );
}
add_filter('gf_post_type_preset', 'gf_post_type_preset_apply');
function gf_post_type_preset_apply($post_types) {
	$post_types['property'] = array(
		'name' => esc_html__('Property','benaa-framework')
	);
	$post_types['agent'] = array(
		'name' => esc_html__('Agent','benaa-framework')
	);
	$post_types['invoice'] = array(
		'name' => esc_html__('Invoice','benaa-framework')
	);
	return $post_types;
}
add_filter('ere_register_option_property_page', 'gf_property_page_option');
function gf_property_page_option()
{
	return array(
		'id'     => 'ere_property_page_option',
		'title'  => esc_html__('Property Page', 'benaa-framework'),
		'icon'   => 'dashicons-welcome-widgets-menus',
		'fields' => array(
			array(
				'id' => 'ere_property_archive',
				'title' => esc_html__('Archive Property', 'benaa-framework'),
				'type' => 'group',
				'fields' => array(
					array(
						'id' => 'enable_archive_search_form',
						'title' => esc_html__('Enable Search Form', 'benaa-framework'),
						'type' => 'button_set',
						'options' => array(
							'1' => esc_html__('Enabled', 'benaa-framework'),
							'0' => esc_html__('Disabled', 'benaa-framework'),
						),
						'default' => '0',
					),
					array(
						'id' => 'hide_archive_search_fields',
						'type' => 'checkbox_list',
						'title' => esc_html__('Hide Advanced Search Fields', 'benaa-framework'),
						'subtitle' => esc_html__('Choose which fields you want to hide on advanced search page?', 'benaa-framework'),
						'options' => array(
							'property_status' => esc_html__('Status', 'benaa-framework'),
							'property_type' => esc_html__('Type', 'benaa-framework'),
							'property_title' => esc_html__('Title', 'benaa-framework'),
							'property_address' => esc_html__('Address', 'benaa-framework'),
							'property_country' => esc_html__('Country', 'benaa-framework'),
							'property_state' => esc_html__('Province / State', 'benaa-framework'),
							'property_city' => esc_html__('City', 'benaa-framework'),
							'property_neighborhood' => esc_html__('Neighborhood', 'benaa-framework'),
							'property_bedrooms' => esc_html__('Bedrooms', 'benaa-framework'),
							'property_bathrooms' => esc_html__('Bathrooms', 'benaa-framework'),
							'property_price' => esc_html__('Sale or Rent Price', 'benaa-framework'),
							'property_size' => esc_html__('Size', 'benaa-framework'),
							'property_land' => esc_html__('Land Area', 'benaa-framework'),
							'property_labels' => esc_html__('Label', 'benaa-framework'),
							'property_garage' => esc_html__('Garage', 'benaa-framework'),
							'property_identity' => esc_html__('Property ID', 'benaa-framework'),
							'property_feature' => esc_html__('Other Features', 'benaa-framework'),
						),
						'value_inline' => false,
						'default' => array(
							'property_country','property_state','property_neighborhood','property_labels'
						),
						'required' => array('enable_archive_search_form', '=', array('1'))
					),
					array(
						'id' => 'archive_search_price_field_layout',
						'title' => esc_html__('Property Price Field Layout', 'benaa-framework'),
						'type' => 'button_set',
						'options' => array(
							'0' => esc_html__('Dropdown', 'benaa-framework'),
							'1' => esc_html__('Slider', 'benaa-framework'),
						),
						'default' => '0',
						'required' => array('enable_archive_search_form', '=', array('1'))
					),
					array(
						'id' => 'archive_search_size_field_layout',
						'title' => esc_html__('Property Size Field Layout', 'benaa-framework'),
						'type' => 'button_set',
						'options' => array(
							'0' => esc_html__('Dropdown', 'benaa-framework'),
							'1' => esc_html__('Slider', 'benaa-framework'),
						),
						'default' => '0',
						'required' => array('enable_archive_search_form', '=', array('1'))
					),
					array(
						'id' => 'archive_search_land_field_layout',
						'title' => esc_html__('Property Land Area Field Layout', 'benaa-framework'),
						'type' => 'button_set',
						'options' => array(
							'0' => esc_html__('Dropdown', 'benaa-framework'),
							'1' => esc_html__('Slider', 'benaa-framework'),
						),
						'default' => '0',
						'required' => array('enable_archive_search_form', '=', array('1'))
					),
					array(
						'id' => 'section_archive_page_option',
						'title' => esc_html__('Page Options', 'benaa-framework'),
						'type' => 'group',
						'fields' => array(
							array(
								'id' => 'archive_property_layout_style',
								'type' => 'button_set',
								'title' => esc_html__('Layout Style', 'benaa-framework'),
								'default' => 'property-grid',
								'options' => array(
									'property-grid' => esc_html__('Grid', 'benaa-framework'),
									'property-list' => esc_html__('List', 'benaa-framework')
								)
							),
							array(
								'id' => 'archive_property_items_amount',
								'type' => 'text',
								'title' => esc_html__('Items Amount', 'benaa-framework'),
								'default' => 15,
								'pattern' => '[0-9]*',
							),
							array(
								'type' => 'text',
								'title' => esc_html__('Image Size', 'benaa-framework'),
								'subtitle' => esc_html__('Enter image size ("thumbnail" or "full"). Alternatively enter size in pixels (Example : 330x180 (Not Include Unit, Space)).', 'benaa-framework'),
								'id' => 'archive_property_image_size',
								'default' => '330x180',
							),
							array(
								'type' => 'select',
								'title' => esc_html__('Columns', 'benaa-framework'),
								'id' => 'archive_property_columns',
								'options' => array(
									'2' => '2',
									'3' => '3',
									'4' => '4',
									'5' => '5',
									'6' => '6'
								),
								'default' => '3',
								'required' => array('archive_property_layout_style', '=', array('property-grid'))
							),
							array(
								'type' => 'select',
								'title' => esc_html__('Columns Gap', 'benaa-framework'),
								'id' => 'archive_property_columns_gap',
								'options' => array(
									'col-gap-0' => '0px',
									'col-gap-10' => '10px',
									'col-gap-20' => '20px',
									'col-gap-30' => '30px',
								),
								'default' => 'col-gap-30',
								'required' => array('archive_property_layout_style', '=', array('property-grid'))
							),

							/* Responsive */
							array(
								'type' => 'select',
								'title' => esc_html__('Items Desktop Small', 'benaa-framework'),
								'id' => 'archive_property_items_md',
								'subtitle' => esc_html__('Browser Width < 1199', 'benaa-framework'),
								'options' => array(
									'2' => '2',
									'3' => '3',
									'4' => '4',
									'5' => '5',
									'6' => '6',
								),
								'default' => '3',
								'required' => array('archive_property_layout_style', 'in', array('property-grid'))
							),
							array(
								'type' => 'select',
								'title' => esc_html__('Items Tablet', 'benaa-framework'),
								'id' => 'archive_property_items_sm',
								'subtitle' => esc_html__('Browser Width < 992', 'benaa-framework'),
								'options' => array(
									'2' => '2',
									'3' => '3',
									'4' => '4',
									'5' => '5',
									'6' => '6',
								),
								'default' => '2',
								'required' => array('archive_property_layout_style', 'in', array('property-grid'))
							),
							array(
								'type' => 'select',
								'title' => esc_html__('Items Tablet Small', 'benaa-framework'),
								'id' => 'archive_property_items_xs',
								'subtitle' => esc_html__('Browser Width < 768', 'benaa-framework'),
								'options' => array(
									'1' => '1',
									'2' => '2',
									'3' => '3',
									'4' => '4',
									'5' => '5',
									'6' => '6',
								),
								'default' => '1',
								'required' => array('archive_property_layout_style', 'in', array('property-grid'))
							),
							array(
								'type' => 'select',
								'title' => esc_html__('Items Mobile', 'benaa-framework'),
								'id' => 'archive_property_items_mb',
								'subtitle' => esc_html__('Browser Width < 480', 'benaa-framework'),
								'options' => array(
									'1' => '1',
									'2' => '2',
									'3' => '3',
									'4' => '4',
									'5' => '5',
									'6' => '6',
								),
								'default' => '1',
								'required' => array('archive_property_layout_style', 'in', array('property-grid'))
							)
						)
					),
				)
			),
			array(
				'id' => 'ere_property_single',
				'title' => esc_html__('Single Property', 'benaa-framework'),
				'type' => 'group',
				'fields' => array(
					array(
						'id' => 'custom_property_single_header_type',
						'type' => 'button_set',
						'title' => esc_html__('Header Display Type', 'benaa-framework'),
						'options' => array(
							'image' => esc_html__('Header Image', 'benaa-framework'),
							'map' => esc_html__('Header Map', 'benaa-framework')
						),
						'default' => 'map',
					),
					array(
						'id' => 'hide_contact_information_if_not_login',
						'title' => esc_html__('Hide Contact Information if user not login', 'benaa-framework'),
						'type' => 'button_set',
						'options' => array(
							'1' => esc_html__('Yes', 'benaa-framework'),
							'0' => esc_html__('No', 'benaa-framework'),
						),
						'default' => '0',
					),
					array(
						'id' => 'enable_comments_property',
						'title' => esc_html__('Enable Comments Property', 'benaa-framework'),
						'type' => 'button_set',
						'options' => array(
							'1' => esc_html__('Yes', 'benaa-framework'),
							'0' => esc_html__('No', 'benaa-framework'),
						),
						'default' => '1',
					)
				)
			)
		)
	);
}