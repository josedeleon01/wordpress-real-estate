<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $lat
 * @var $lng
 * @var $nearby_places_radius
 * @var $nearby_places_rank_by
 * @var $set_map_height
 * @var $nearby_places_distance_in
 * @var $api_key
 * @var $nearby_places_fields
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Plus_Nearby_Places
 */

$css_animation = $animation_duration = $animation_delay = $el_class = $css = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$fields = (array)vc_param_group_parse_atts($nearby_places_fields);

$wrapper_attributes = array();
$wrapper_styles = array();

$wrapper_classes = array(
    'g5plus-nearby-places',
    $this->getExtraClass($el_class),
    $this->getCSSAnimation($css_animation),
);

// animation
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

if (!(defined('G5PLUS_SCRIPT_DEBUG') && G5PLUS_SCRIPT_DEBUG)) {
    $min_suffix = gf_get_option('enable_minifile_css', 0) == 1 ? '.min' : '';
    wp_enqueue_style(GF_PLUGIN_PREFIX . 'nearby-places', plugins_url(GF_PLUGIN_NAME . '/shortcodes/nearby-places/assets/css/nearby-places' . $min_suffix . '.css'), array(), false, 'all');
}
$map_icons_path_marker = GF_PLUGIN_URL . 'assets/images/map-marker-icon.png';
$PlaceArray = $nearby_places_field_type = $nearby_places_field_label = $nearby_places_field_icon = '';
foreach ($fields as $data) {
    $PlaceArray .= "'" . (isset($data['nearby_places_select_field_type']) ? $data['nearby_places_select_field_type'] : '') . "',";
    $nearby_places_field_type .= (isset($data['nearby_places_select_field_type']) ? $data['nearby_places_select_field_type'] : '') . ",";
    $nearby_places_field_label .= (isset($data['nearby_places_field_label']) ? $data['nearby_places_field_label'] : '') . ",";
    if (isset($data['nearby_places_field_icon']) && $data['nearby_places_field_icon'] != '') {
        $icon = wp_get_attachment_image_src($data['nearby_places_field_icon'], 'full');
        $nearby_places_field_icon .= $icon[0] . ",";
    }
}
if (empty($nearby_places_radius)) {
    $nearby_places_radius = '5000';
}
if (empty($set_map_height)) {
    $set_map_height = '475';
}
if (is_ssl()) {
    wp_enqueue_script('google-map', 'https://maps-api-ssl.google.com/maps/api/js?libraries=places&language=' . get_locale() . '&key=' . esc_html($api_key), array('jquery'));
} else {
    wp_enqueue_script('google-map', 'http://maps.googleapis.com/maps/api/js?libraries=places&language=' . get_locale() . '&key=' . esc_html($api_key), array('jquery'));
}
?>
<div class="row <?php echo esc_attr($css_class) ?>" <?php echo implode(' ', $wrapper_attributes); ?>>
    <div class="col-md-7 col-sm-12 col-xs-12 near-location-map" style="height:<?php echo esc_attr($set_map_height); ?>px;">
        <div class="near-location-map" style="width:100%;height:100%;">
            <div id="googleMapNearestPlaces"
                 style="width:100%;height:100%;"></div>
        </div>
    </div>
    <div class="col-md-5 col-sm-12 col-xs-12 nearby-places-detail" id="nearby-places-detail"></div>
</div>
<script>
    (function ($) {
        "use strict";
        var G5PlusGoogleMap = {
            init: function () {
                G5PlusGoogleMap.settingMap();
            },
            settingMap: function () {
                var map, lat = "<?php echo esc_attr($lat); ?>", lng = "<?php echo esc_attr($lng); ?>", infowindow, i;
                var bounds = new google.maps.LatLngBounds();
                var map_icons_path_marker = '<?php echo esc_attr($map_icons_path_marker); ?>';
                var PlaceArray = [<?php printf(esc_html__('%s', 'benaa-framework'), $PlaceArray); ?>];
                var PlacePlaceArray = '<?php echo esc_js($nearby_places_field_type); ?>'.split(',');
                var PlaceLabelArray = '<?php echo esc_js($nearby_places_field_label); ?>'.split(',');
                var PlaceIconArray = '<?php echo esc_js($nearby_places_field_icon); ?>'.split(',');
                var distance_in = '<?php echo esc_attr($nearby_places_distance_in); ?>';
                var Place_Counter = 0;
                var rank_by = '<?php echo esc_attr($nearby_places_rank_by); ?>';
                var PlaceDetail = [];
                for (var n = 0; n < PlacePlaceArray.length; n++) {
                    PlaceDetail[PlacePlaceArray[n]] = [PlaceLabelArray[n], PlaceIconArray[n]];
                }
                function initialize() {
                    "use strict";
                    var pyrmont = new google.maps.LatLng(lat, lng);
                    infowindow = new google.maps.InfoWindow();
                    map = new google.maps.Map(document.getElementById('googleMapNearestPlaces'), {
                        center: pyrmont,
                        icon: map_icons_path_marker,
                        scrollwheel: false,
                        fullscreenControl: true

                    });
                    var marker = new google.maps.Marker({
                        position: pyrmont,
                        icon: map_icons_path_marker
                    });
                    marker.setMap(map);
                    var request = '';
                    if (rank_by == 'distance') {
                        request = {
                            location: pyrmont,
                            types: PlaceArray,
                            rankBy: google.maps.places.RankBy.DISTANCE
                        };
                    } else {
                        request = {
                            location: pyrmont,
                            radius: '<?php echo esc_attr($nearby_places_radius); ?>',
                            types: PlaceArray
                        };
                    }

                    var service = new google.maps.places.PlacesService(map);
                    service.nearbySearch(request, callback);
                }

                function callback(results, status) {
                    "use strict";
                    if (status == google.maps.places.PlacesServiceStatus.OK) {
                        for (var i = 0; i < results.length; i++) {
                            createMarker(results[i]);
                        }
                        setScroll();
                    }
                    else {
                        $('.nearby-places-detail').append('<p>No result!</p>');
                    }
                }

                function createMarker(place) {
                    "use strict";

                    var PlaceType = "";
                    jQuery.each(place.types, function (key, value) {
                        if (jQuery.inArray(value, PlaceArray) != -1) {
                            PlaceType = value;
                        }
                    });
                    if (PlaceType == "") {
                        return;
                    }
                    PlaceArray = jQuery.grep(PlaceArray, function (value) {
                        return value != PlaceType;
                    });
                    Place_Counter++;
                    var Distance = distance(place.geometry.location.lat(), place.geometry.location.lng());
                    var place_label = PlaceDetail[PlaceType][0];
                    var place_icon = PlaceDetail[PlaceType][1];

                    jQuery("#nearby-places-detail").append("<div class='near-location-info'><ul><li class='right'>" + place_label + "</li><li class='left'><span>" + Distance + " " + distance_in + "</span></li></ul><span>" + place.name + "</span></div>");
                    var marker = new google.maps.Marker({
                        map: map,
                        position: place.geometry.location,
                        icon: place_icon
                    });
                    google.maps.event.addListener(marker, 'click', function () {
                        infowindow.setContent('<strong>' + place_label + '</strong>' + '</br>' + place.name);
                        infowindow.open(map, this);
                    });
                    bounds.extend(marker.position);
                    //now fit the map to the newly inclusive bounds
                    map.fitBounds(bounds);
                }

                google.maps.event.addDomListener(window, 'load', initialize);
                function distance(latitude, longitude) {
                    var lat1 = lat;
                    var lng1 = lng;
                    var lat2 = latitude;
                    var lng2 = longitude;
                    var radlat1 = Math.PI * lat1 / 180;
                    var radlat2 = Math.PI * lat2 / 180;
                    var theta = lng1 - lng2;
                    var radtheta = Math.PI * theta / 180;
                    var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
                    dist = Math.acos(dist);
                    dist = dist * 180 / Math.PI;
                    dist = dist * 60 * 1.1515;
                    if (distance_in == "km") {
                        dist = dist * 1.609344;
                    } else if (distance_in == "m") {
                        dist = dist * 1.609344 * 1000;
                    }
                    return Math.round(dist * 100) / 100;
                }

                function setScroll() {
                    var $this = $('#nearby-places-detail');
                    var map_height = $('#googleMapNearestPlaces');
                    var height = $this.height();
                    if (height >= map_height.height()) {
                        $this.css('position', 'relative');
                        $this.css('max-height', +map_height.height());
                        $this.css('overflow-y', 'scroll');
                        $this.css('overflow-x', 'hidden');
                        $this.perfectScrollbar({
                            wheelSpeed: 0.5,
                            suppressScrollX: true
                        });
                    }
                }
            }
        };
        $(document).ready(G5PlusGoogleMap.init);
    })
    (jQuery);
</script>