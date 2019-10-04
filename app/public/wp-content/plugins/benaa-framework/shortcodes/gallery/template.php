<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $layout_style
 * @var $hover_effect
 * @var $images
 * @var $columns
 * @var $image_size
 * @var $dots
 * @var $nav
 * @var $autoplay
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $css
 * @var $el_class
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Plus_Gallery
 */
$layout_style = $hover_effect = $images = $columns = $image_size = $dots = $nav
	= $autoplay = $css_animation = $animation_duration = $animation_delay = $css = $el_class = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);

extract($atts);

$images = explode(',', $images);

$wrapper_attributes = array();
$wrapper_styles = array();

$owl_attributes = array();
$wrapper_classes = array(
	'g5plus-gallery',
	$layout_style,
	'clearfix',
	'text-center',
	$this->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation)
);

$gallery_item_class = array('gf-gallery-item');
$owl_attribute = array();
$owl_class = array();

if ($layout_style == 'gallery-carousel') {
	$owl_class[] = 'owl-carousel';
	$owl_attributes = array(
		'"dots": ' . ($dots ? 'true' : 'false'),
		'"nav": ' . ($nav ? 'true' : 'false'),
		'"autoplay": ' . ($autoplay ? 'true' : 'false'),
		'"responsive": {
					"0" : {"items" : ' . $items_mb . '},
					"481" : {"items" : ' . $items_xs . '},
		 			"768" : {"items" : ' . $items_sm . '},
		 			"768" : {"items" : ' . $items_md . '},
		   			"1200" : {"items" : ' . $columns . '}
		   }'
	);
	$owl_attribute[] = "data-plugin-options='{" . implode(', ', $owl_attributes) . "}'";
} else {
	$wrapper_classes[] = 'row';
	$wrapper_classes[] = 'columns-' . $columns;
	$wrapper_classes[] = 'columns-md-' . $items_md;
	$wrapper_classes[] = 'columns-sm-' . $items_sm;
	$wrapper_classes[] = 'columns-xs-' . $items_xs;
	$wrapper_classes[] = 'columns-mb-' . $items_mb;
	$gallery_item_class[] = 'gf-item-wrap';
	$gallery_item_class[] = 'mg-bottom-30';
}
$animation_style = $this->getStyleAnimation($animation_duration, $animation_delay);
if (sizeof($animation_style) > 0) {
	$wrapper_styles = $animation_style;
}
if ($wrapper_styles) {
	$wrapper_attributes[] = 'style="' . implode('; ', $wrapper_styles) . '"';
}

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

$gallery_id = rand();
if (!(defined('G5PLUS_SCRIPT_DEBUG') && G5PLUS_SCRIPT_DEBUG)) {
	$min_suffix = gf_get_option('enable_minifile_css', 0) == 1 ? '.min' : '';
	wp_enqueue_style(GF_PLUGIN_PREFIX . 'gallery', plugins_url(GF_PLUGIN_NAME . '/shortcodes/gallery/assets/css/gallery' . $min_suffix . '.css'), array(), false, 'all');
}
?>
<div class="<?php echo esc_attr($css_class); ?>" <?php echo implode(' ', $wrapper_attributes); ?>>
	<?php if ($layout_style == 'gallery-carousel'): ?>
	<div class="<?php echo implode(' ', $owl_class) ?>" <?php echo implode(' ', $owl_attribute) ?>>
		<?php endif; ?>
		<?php foreach ($images as $image_id):
			$attach_id = preg_replace('/[^\d]/', '', $image_id);
			$image_src = g5plus_get_image_src($attach_id, 'full', 'full');
			$image_full = wp_get_attachment_image_src($attach_id, 'full');
			if (sizeof($image_full) > 0) {
				$image_full = $image_full[0];
			}
			$image_thumb = wp_get_attachment_image_src($attach_id);
			$image_thumb_link = '';
			if (sizeof($image_thumb) > 0) {
				$image_thumb_link = $image_thumb['0'];
			} ?>
			<div class="<?php echo join(' ', $gallery_item_class); ?>">
				<div class="gf-gallery-inner <?php echo esc_attr($hover_effect) ?>">
					<a href="<?php echo esc_url($image_full) ?>"
					   data-thumb-src="<?php echo esc_url($image_thumb_link); ?>" data-rel="lightGallery"
					   data-gallery-id="<?php echo esc_html($gallery_id) ?>">
						<i class="fa fa-search"></i>
					</a>
					<div class="effect-content">
						<img src="<?php echo esc_url($image_src) ?>" alt="<?php the_title(); ?>"
							 title="<?php the_title(); ?>">
					</div>
				</div>
			</div>
		<?php endforeach; ?>
		<?php if ($layout_style == 'gallery-carousel'): ?>
	</div>
<?php endif; ?>
</div>
