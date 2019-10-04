<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $time
 * @var $text_color
 * @var $url_redirect
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Plus_Countdown
 */
$time = $text_color = $url_redirect = $css_animation = $animation_duration = $animation_delay = $el_class = $css = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_attributes = array();
$wrapper_styles = array();

$wrapper_classes = array(
	'g5plus-countdown',
	$text_color,
	$this->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
);

// animation
$animation_style = $this->getStyleAnimation($animation_duration, $animation_delay);
if (sizeof($animation_style) > 0) {
	$wrapper_styles = $animation_style;
}
if ($wrapper_styles) {
	$wrapper_attributes[] = 'style="' . implode('; ', array_filter($wrapper_styles) ) . '"';
}

$value_color = '#6e6e6e';
$bg_color = 'transparent';

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

$min_suffix_js = gf_get_option('enable_minifile_js', 0) == 1 ? '.min' : '';
wp_enqueue_script(GF_PLUGIN_PREFIX . 'plugin-knob-countdown', plugins_url(GF_PLUGIN_NAME . '/shortcodes/countdown/assets/js/knob' . $min_suffix_js . '.js'), array(), false, 'all');
wp_enqueue_script(GF_PLUGIN_PREFIX . 'countdown-js', plugins_url(GF_PLUGIN_NAME . '/shortcodes/countdown/assets/js/countdown' . $min_suffix_js . '.js'), array(), false, 'all');

if (!(defined('G5PLUS_SCRIPT_DEBUG') && G5PLUS_SCRIPT_DEBUG)) {
	wp_enqueue_style(GF_PLUGIN_PREFIX . 'countdown', plugins_url(GF_PLUGIN_NAME . '/shortcodes/countdown/assets/css/countdown' . $min_suffix_js . '.css'), array(), false, 'all');
}

if (!empty($time)) {
	$time = mysql2date('Y/m/d H:i:s', $time);
	?>
	
	<div class="<?php echo esc_attr($css_class) ?>" data-url-redirect="<?php echo esc_attr($url_redirect) ?>"
		 data-date-end="<?php echo esc_attr($time); ?>" <?php echo implode(' ', $wrapper_attributes); ?>>
		<div class="countdown-section">
			<input data-min="1" data-max="30" type="text" value="0" data-thickness=".04" data-readOnly="true"
				   data-bgColor="<?php echo esc_attr($bg_color) ?>" data-width="226" data-height="226"
				   data-fgColor="<?php echo esc_attr($value_color) ?>" class="days" id="days">
			<h6 class="countdown-period"><?php esc_html_e('Day', 'benaa'); ?></h6>
		</div>
		<div class="countdown-section">
			<input data-min="0" data-max="23" type="text" value="0" data-thickness=".04"
				   data-readOnly="true" data-bgColor="<?php echo esc_attr($bg_color) ?>" data-width="226" data-height="226"
				   data-fgColor="<?php echo esc_attr($value_color) ?>" class="hours" id="hours">
			<h6 class="countdown-period"><?php esc_html_e('Hour', 'benaa'); ?></h6>
		</div>
		<div class="countdown-section">
			<input data-min="0" data-max="59" type="text" value="0" data-thickness=".04"
				   data-readOnly="true" data-bgColor="<?php echo esc_attr($bg_color) ?>" data-width="226" data-height="226"
				   data-fgColor="<?php echo esc_attr($value_color) ?>" class="minutes" id="minutes">
			<h6 class="countdown-period"><?php esc_html_e('Minute', 'benaa'); ?></h6>
		</div>
		<div class="countdown-section">
			<input data-min="0" data-max="59" type="text" value="0" data-thickness=".04"
				   data-readOnly="true"  data-bgColor="<?php echo esc_attr($bg_color) ?>" data-width="226" data-height="226"
				   data-fgColor="<?php echo esc_attr($value_color) ?>" class="seconds" id="seconds">
			<h6 class="countdown-period"><?php esc_html_e('Second', 'benaa'); ?></h6>
		</div>
	</div>
	<?php
}