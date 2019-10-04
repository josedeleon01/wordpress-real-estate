<?php
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Plus_Space
 */
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
$min_suffix_js = gf_get_option('enable_minifile_js', 0) == 1 ? '.min' : '';
wp_enqueue_script(GF_PLUGIN_PREFIX . 'space-js', plugins_url(GF_PLUGIN_NAME . '/shortcodes/space/assets/js/space' . $min_suffix_js . '.js'), array(), false, true);
if($atts["mobile"] == "" && $atts["tablet"] == "")
    $atts["mobile"] =  $atts["tablet"] =  $atts["desktop"];
$sid = uniqid();
?>
<div class="g5plus-space space-<?php echo esc_attr($sid); ?>" data-id="<?php echo esc_attr($sid); ?>" data-tablet="<?php echo esc_attr($atts["tablet"]); ?>" data-tablet-portrait="<?php echo esc_attr($atts["tablet_portrait"]); ?>" data-mobile="<?php echo esc_attr($atts["mobile"]); ?>" data-mobile-landscape="<?php echo esc_attr($atts["mobile_landscape"]); ?>" style="clear: both; display: block; height: <?php echo esc_attr($atts["desktop"]); ?>px"></div>