<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $layout_style
 * @var $items_lg
 * @var $items_md
 * @var $items_sm
 * @var $items_xs
 * @var $items_mb
 * @var $demo_items
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Plus_View_Demo
 */

$layout_style = $items_lg = $items_md = $items_sm = $items_xs = $items_mb = $demo_items = $css_animation = $animation_duration = $animation_delay = $el_class = $css = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);
$values = (array)vc_param_group_parse_atts($demo_items);

$wrapper_attributes = array();
$wrapper_styles = array();

$wrapper_classes = array(
	'g5plus-view-demo',
	$layout_style,
	$this->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
);
// animation
$animation_style = $this->getStyleAnimation($atts['animation_duration'], $atts['animation_delay']);
if (sizeof($animation_style) > 0) {
	$wrapper_styles = $animation_style;
}
if ($atts['css_animation'] != 'none') {
	$wrapper_classes[] = $this->getCSSAnimation($atts['css_animation']);
	if ($wrapper_styles) {
		$wrapper_attributes[] = 'style="' . implode('; ', $wrapper_styles) . '"';
	}
}

$gf_item_wrap = 'gf-item-wrap';
$wrapper_classes[] = 'row clearfix columns-' . $items_lg . ' columns-md-' . $items_md . ' columns-sm-' . $items_sm . ' columns-xs-' . $items_xs . ' columns-mb-' . $items_mb . '';


$class_to_filter = implode(' ', array_filter($wrapper_classes));
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

if (!(defined('G5PLUS_SCRIPT_DEBUG') && G5PLUS_SCRIPT_DEBUG)) {
	wp_enqueue_style(GF_PLUGIN_PREFIX . 'view-demo', plugins_url(GF_PLUGIN_NAME . '/shortcodes/view-demo/assets/css/view-demo.min.css'), array(), false, 'all');
}

?>
<div class="<?php echo esc_attr($css_class); ?>" <?php echo implode(' ', $wrapper_attributes); ?>>
	<?php
	$demo_items = (array)vc_param_group_parse_atts($demo_items);
	if ($demo_items && count($demo_items) > 0) {
		foreach ($demo_items as $demo) {
			$img = isset($demo['image']) ? wp_get_attachment_url($demo['image']) : '';
			$title = isset($demo['title']) ? $demo['title'] : '';
			
			$link = isset($demo['link']) ? $demo['link'] : '';
			$a_href = $a_title = $a_target = $a_rel = '';
			$link = ('||' === $link) ? '' : $link;
			$link = vc_build_link($link);
			$use_link = false;
			if (strlen($link['url']) > 0) {
				$use_link = true;
				$a_href = $link['url'];
				$a_title = $link['title'];
				if (empty($title)) {
					$title = $a_title;
				}
				$a_target = $link['target'];
				$a_rel = $link['rel'];
			}
			$link_attr = array('');
			if ($use_link) {
				$link_attr[] = 'href="' . esc_url(trim($a_href)) . '"';
				$link_attr[] = 'title="' . esc_html(trim($title)) . '"';
				if (!empty($a_target)) {
					$link_attr[] = 'target="' . esc_attr(trim($a_target)) . '"';
				}
				
				if (!empty($a_rel)) {
					$link_attr[] = 'rel="' . esc_attr(trim($a_rel)) . '"';
				}
			}
			$link_attr = implode(' ', $link_attr);
			$background_style = "background-image: url(" . esc_url($img) . ");";

			$is_new = isset($demo['is_new']) ? $demo['is_new'] : 'false';
			$is_coming_soon = isset($demo['is_coming_soon']) ? $demo['is_coming_soon'] : 'false';
			if ($is_coming_soon === 'true') {
				$use_link = false;
				$is_new = '';
			}
			?>
			<div class="<?php echo esc_attr($gf_item_wrap); ?>">
				<div class="demo-item<?php echo ($is_coming_soon === 'true') ? ' item-comming-soon' : ''; ?>">
					<div class="demo-thumb-wrap">
						<div class="demo-thumb" style="<?php echo esc_html($background_style); ?>">
							<?php if ($use_link): ?>
								<a class="btn btn-lg btn-primary btn-classic btn-shape-round" <?php echo($link_attr); ?> ><?php esc_html_e('PREVIEW', 'benaa-framework'); ?></a>
							<?php endif; ?>
							<?php if ($is_new === 'true'): ?>
								<span class="item-new"><?php esc_html_e('New', 'benaa-framework'); ?></span>
							<?php endif; ?>
							<?php if ($is_coming_soon === 'true') : ?>
								<div class="comming-soon">
									<a class="btn btn-lg btn-primary btn-classic btn-shape-round" ><?php esc_html_e('COMING SOON', 'benaa-framework'); ?></a>
								</div>
							<?php endif; ?>
						</div>
					</div>
					<div class="demo-title">
						<?php if ($use_link): ?>
							<h4><a <?php echo($link_attr); ?> ><?php echo esc_html($title); ?></a></h4>
						<?php else: ?>
							<h4><?php echo esc_html($title); ?></h4>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php }
	} ?>
</div>
