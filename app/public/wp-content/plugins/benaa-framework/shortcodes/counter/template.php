<?php
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this WPBakeryShortCode_Vc_Pie
 */
$atts = vc_map_get_attributes($this->getShortcode(), $atts);

$wrapper_classes = array(
    'g5plus-counter',
    $atts['color_scheme'],
    $this->getExtraClass($atts['el_class']),
);

if (!(defined('G5PLUS_SCRIPT_DEBUG') && G5PLUS_SCRIPT_DEBUG)) {
    $min_suffix = gf_get_option('enable_minifile_css',0) == 1 ? '.min' : '';
    wp_enqueue_style(GF_PLUGIN_PREFIX . 'counter', plugins_url(GF_PLUGIN_NAME . '/shortcodes/counter/assets/css/counter'.$min_suffix.'.css'), array(), false, 'all');
}
$min_suffix_js = gf_get_option('enable_minifile_js', 0) == 1 ? '.min' : '';
wp_enqueue_script(GF_PLUGIN_PREFIX . 'counter-js', plugins_url(GF_PLUGIN_NAME . '/shortcodes/counter/assets/js/countUp' . $min_suffix_js . '.js'), array(), false, true);
$class_to_filter = implode(' ',$wrapper_classes);
$class_to_filter .= vc_shortcode_custom_css_class($atts['css'], ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
?>
<div class="<?php echo esc_attr($css_class) ?>">
    <?php if ($atts['icon_type'] == 'image'):?>
        <?php if (!empty($atts['icon_image'])) : ?>
            <span class="icon-image">
            <?php
            $icon_image_id = preg_replace('/[^\d]/', '', $atts['icon_image']);
            $icon_image_src = wp_get_attachment_image_src($icon_image_id, 'full');
            if (!empty($icon_image_src[0])) {
                $icon_image_src = $icon_image_src[0];
            }
            ?>
                <img src="<?php echo  esc_url($icon_image_src) ?>" alt="<?php echo the_title_attribute(array('post' => $icon_image_id, 'echo' => false)) ?>" />
            </span>
        <?php endif; ?>
    <?php elseif ($atts['icon_type'] == 'icon'): ?>
        <span class="icon">
            <i class="<?php echo esc_attr($atts['icon_font']) ?>" ></i>
        </span>
    <?php endif; ?>
	<div class="counter-inner">
		<span class="counterup p-font" data-start="<?php echo esc_attr($atts['start']) ?>" data-end="<?php echo esc_attr($atts['end']) ?>" data-decimals="<?php echo esc_attr($atts['decimals']) ?>" data-duration="<?php echo esc_attr($atts['duration']) ?>"  data-separator="<?php echo esc_attr($atts['separator']) ?>" data-decimal="<?php echo esc_attr($atts['decimal']) ?>" data-prefix="<?php echo esc_attr($atts['prefix']) ?>" data-suffix="<?php echo esc_attr($atts['suffix']) ?>"><?php echo wp_kses_post($atts['end']) ?></span>
		<?php if($atts['title']!=''): ?>
			<p><?php echo wp_kses_post($atts['title']) ?></p>
		<?php endif; ?>
	</div>
</div>