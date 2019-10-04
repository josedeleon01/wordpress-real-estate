<?php
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Plus_Video
 */
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
$wrapper_attributes = array();
$wrapper_styles = array();

$wrapper_classes = array(
    'g5plus-video',
    'lightgallery-video',
    $this->getExtraClass($atts['el_class']),
    $this->getCSSAnimation($atts['css_animation'])
);

$animation_style = $this->getStyleAnimation($atts['animation_duration'], $atts['animation_delay']);
if (sizeof($animation_style) > 0) {
    $wrapper_styles = $animation_style;
}
if ($wrapper_styles) {
    $wrapper_attributes[] = 'style="' . implode('; ', array_filter($wrapper_styles)) . '"';
}

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$class_to_filter .= vc_shortcode_custom_css_class($atts['css'], ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
if (!(defined('G5PLUS_SCRIPT_DEBUG') && G5PLUS_SCRIPT_DEBUG)) {
    $min_suffix = gf_get_option('enable_minifile_css',0) == 1 ? '.min' : '';
    wp_enqueue_style(GF_PLUGIN_PREFIX . 'video', plugins_url(GF_PLUGIN_NAME . '/shortcodes/video/assets/css/video'.$min_suffix.'.css'), array(), false, 'all');
}
?>
<div class="<?php echo esc_attr($css_class); ?>" <?php echo implode(' ', $wrapper_attributes); ?>>
    <a class="view-video" data-src="<?php echo esc_url($atts['link']) ?>" href="javascript:;">
		<img src="<?php echo esc_html(G5PLUS_THEME_URL . 'assets/images/icon-play.png'); ?>" alt="">
	</a>
</div>