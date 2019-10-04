<?php
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Plus_Google_Map
 */
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
$wrapper_attributes = array();
$wrapper_styles = array();
$wrapper_classes = array(
	'g5plus-google-map',
	$this->getExtraClass($atts['el_class']),
	$this->getCSSAnimation($atts['css_animation'])
);
if ($atts['map_height'] != '') {
	$wrapper_styles[] = "height: {$atts['map_height']}";
}
// animation
$animation_style = $this->getStyleAnimation($atts['animation_duration'], $atts['animation_delay']);
if (sizeof($animation_style) > 0) {
	$wrapper_styles[] = $animation_style;
}
if ($wrapper_styles) {
	$wrapper_attributes[] = 'style="' . implode('; ', array_filter($wrapper_styles)) . '"';
}
$class_to_filter = implode(' ', array_filter($wrapper_classes));
$class_to_filter .= vc_shortcode_custom_css_class($atts['css'], ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
$googlemap_api_key = $atts['api_key'];
if (is_ssl()) {
	wp_enqueue_script('google-map', 'https://maps-api-ssl.google.com/maps/api/js?libraries=places&language=' . get_locale() . '&key=' . esc_html($googlemap_api_key), array('jquery'));
} else {
	wp_enqueue_script('google-map', 'http://maps.googleapis.com/maps/api/js?libraries=places&language=' . get_locale() . '&key=' . esc_html($googlemap_api_key), array('jquery'));
}
$map_id = 'map-' . uniqid();
$map_point_data = array();
?>
<div id="<?php echo esc_attr($map_id); ?>"
	 class="<?php echo esc_attr($css_class) ?>" <?php echo implode(' ', $wrapper_attributes); ?>>
</div>
<script>
	jQuery(document).ready(function () {
		var bounds = new google.maps.LatLngBounds();
		var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
		var isDraggable = w > 1024 ? true : false;
		var mapOptions = {
			mapTypeId: 'roadmap',
			draggable: isDraggable,
			scrollwheel: false,
			fullscreenControl: true
		};
		var map = new google.maps.Map(document.getElementById("<?php echo esc_attr($map_id) ?>"), mapOptions);
		var markers = [
			<?php
			$markers = (array)vc_param_group_parse_atts($atts['markers']);
			$list_marker = '';
			foreach ($markers as $data) {
				$title = isset($data['title']) ? $data['title'] : '';
				$description = isset($data['description']) ? $data['description'] : '';
				$lat = isset($data['lat']) ? $data['lat'] : '';
				$lng = isset($data['lng']) ? $data['lng'] : '';
				$icon = isset($data['icon']) ? $data['icon'] : '';
				$icon_url = '';
				if ($icon != '') {
					$icon = wp_get_attachment_image_src($icon, 'full');
					$icon_url = $icon[0];
				}
				$list_marker .= '["' . $title . '","' . $description . '", ' . $lat . ',' . $lng . ',"' . $icon_url . '"],';
			}
			$list_marker = substr($list_marker, 0, -1);
			echo wp_kses_post($list_marker);?>];
		var infoWindow = new google.maps.InfoWindow(), marker, i;
		for (i = 0; i < markers.length; i++) {
			var position = new google.maps.LatLng(markers[i][2], markers[i][3]);
			bounds.extend(position);
			marker = new google.maps.Marker({
				position: position,
				map: map,
				title: markers[i][0],
				icon: markers[i][4],
				animation: google.maps.Animation.DROP
			});
			google.maps.event.addListener(marker, 'click', (function (marker, i) {
				return function () {
					infoWindow.setContent('<h6>' + markers[i][0] + '</h6><div>' + markers[i][1] + '</div>');
					infoWindow.open(map, marker);
					if (marker.getAnimation() !== null) {
						marker.setAnimation(null);
					} else {
						marker.setAnimation(google.maps.Animation.BOUNCE);
					}
				};
			})(marker, i));
			map.fitBounds(bounds);
		}
		var boundsListener = google.maps.event.addListener((map), 'idle', function (event) {
			this.setZoom(map.getZoom() - 1);
			if (this.getZoom() > 15) {
				this.setZoom(15);
			}
			google.maps.event.removeListener(boundsListener);
		});
	});
</script>
