<?php
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Plus_Clients
 */
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_attributes = array();
$wrapper_styles = array();

$wrapper_classes = array(
	'g5plus-clients',
	$this->getExtraClass($atts['el_class']),
	$this->getCSSAnimation($atts['css_animation']),
);

$gf_item_wrap = '';
$bordered = '';

if ($atts['bordered']) {
	$bordered = 'bordered';
}

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

if ($atts['is_slider']) {
	$wrapper_classes[] = 'owl-carousel';
	
	if ($atts['nav']) {
		$wrapper_classes[] = 'owl-nav-' . $atts['nav_position'];
	}
	
	$owl_responsive_attributes = array();
// Mobile <= 480px
	$owl_responsive_attributes[] = '"0" : {"items" : ' . $atts['items_mb'] . '}';

// Extra small devices ( < 768px)
	$owl_responsive_attributes[] = '"481" : {"items" : ' . $atts['items_xs'] . '}';

// Small devices Tablets ( < 992px)
	$owl_responsive_attributes[] = '"768" : {"items" : ' . $atts['items_sm'] . '}';

// Medium devices ( < 1199px)
	$owl_responsive_attributes[] = '"992" : {"items" : ' . $atts['items_md'] . '}';

// Medium devices ( > 1199px)
	$owl_responsive_attributes[] = '"1200" : {"items" : ' . $atts['items_lg'] . '}';
	
	$owl_attributes = array(
		'"autoHeight": true',
		'"dots": ' . ($atts['dots'] ? 'true' : 'false'),
		'"nav": ' . ($atts['nav'] ? 'true' : 'false'),
		'"responsive": {' . implode(', ', $owl_responsive_attributes) . '}',
		'"autoplay": ' . ($atts['autoplay'] ? 'true' : 'false'),
		'"autoplaySpeed":' . $atts['autoplaytimeout'],
	);
	$wrapper_attributes[] = "data-plugin-options='{" . implode(', ', $owl_attributes) . "}'";
} else {
	
	$gf_item_wrap = 'gf-item-wrap';
	
	$columns_md = 'columns-md-4';
	$columns_sm = 'columns-sm-3';
	$columns_xs = 'columns-xs-2';
	
	if ($atts['items'] == 3) {
		$columns_md = 'columns-md-3';
	}
	if ($atts['items'] == 2) {
		$columns_md = 'columns-md-2';
		$columns_sm = 'columns-sm-2';
	}
	if ($atts['items'] == 1) {
		$columns_md = '';
		$columns_sm = '';
		$columns_xs = '';
	}
	$wrapper_classes[] = 'row partner-columns columns-' . esc_attr($atts['items']) . ' ' . $columns_md . ' ' . $columns_sm . ' ' . $columns_xs . ' col-mb-12';
}

$class_to_filter = implode(' ', array_filter($wrapper_classes));

$class_to_filter .= vc_shortcode_custom_css_class($atts['css'], ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

if (!(defined('G5PLUS_SCRIPT_DEBUG') && G5PLUS_SCRIPT_DEBUG)) {
	wp_enqueue_style(GF_PLUGIN_PREFIX . 'clients', plugins_url(GF_PLUGIN_NAME . '/shortcodes/clients/assets/css/clients.min.css'), array(), false, 'all');
}

$i = 0;
?>
<div class="<?php echo esc_attr($css_class) ?>" <?php echo implode(' ', $wrapper_attributes); ?>>
	<?php
	$values = (array)vc_param_group_parse_atts($atts['clients']);
	foreach ($values as $data) {
		$clients_img = isset($data['images']) ? $data['images'] : '';
		$link = isset($data['link']) ? $data['link'] : '';
		$link = ($link == '||') ? '' : $link;
		$link_arr = vc_build_link($link);
		$a_title = '';
		$a_target = '_blank';
		$a_href = '#';
		if (strlen($link_arr['url']) > 0) {
			$a_href = $link_arr['url'];
			$a_title = $link_arr['title'];
			$a_target = strlen($link_arr['target']) > 0 ? $link_arr['target'] : '_blank';
		}
		?>
		<div class='clients-item <?php echo esc_attr($gf_item_wrap) ?>'
			 style="opacity: <?php echo esc_attr($atts['opacity'] / 100) ?>;">
			<div class="clients-item-inner <?php echo esc_attr($bordered) ?>">
				<?php if ($link != ''): ?>
				<a title="<?php echo esc_attr($a_title); ?>" target="<?php echo trim(esc_attr($a_target)); ?>"
				   href="<?php echo esc_url($a_href) ?>">
					<?php endif; ?>
					<?php $img_id = preg_replace('/[^\d]/', '', $clients_img);
					$img = wpb_getImageBySize(array('attach_id' => $img_id));
					$img_array = $img['p_img_large']; ?>
					<img src="<?php echo esc_url($img_array[0]) ?>" alt="<?php echo esc_attr($a_title); ?>">
					<?php if ($link != ''): ?>
				</a>
			<?php endif; ?>
			</div>
		</div>
		<?php
	}
	?>
</div>