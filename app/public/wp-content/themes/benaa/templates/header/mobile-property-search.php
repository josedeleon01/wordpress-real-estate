<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('Essential_Real_Estate')) {
	return;
}
$price_is_slider = $area_is_slider = $land_area_is_slider = 'false';

$status_default = ere_get_property_status_default_value();
$request_status = isset($_GET['status']) ? $_GET['status'] : $status_default;
$request_city = isset($_GET['city']) ? $_GET['city'] : '';
$request_title = isset($_GET['title']) ? $_GET['title'] : '';
$request_address = isset($_GET['address']) ? $_GET['address'] : '';
$request_type = isset($_GET['type']) ? $_GET['type'] : '';
$request_bathrooms = isset($_GET['bathrooms']) ? $_GET['bathrooms'] : '';
$request_bedrooms = isset($_GET['bedrooms']) ? $_GET['bedrooms'] : '';
$request_min_area = isset($_GET['min-area']) ? $_GET['min-area'] : '';
$request_max_area = isset($_GET['max-area']) ? $_GET['max-area'] : '';
$request_min_price = isset($_GET['min-price']) ? $_GET['min-price'] : '';
$request_max_price = isset($_GET['max-price']) ? $_GET['max-price'] : '';
$request_state = isset($_GET['state']) ? $_GET['state'] : '';
$request_country = isset($_GET['country']) ? $_GET['country'] : '';
$request_neighborhood = isset($_GET['neighborhood']) ? $_GET['neighborhood'] : '';
$request_label = isset($_GET['label']) ? $_GET['label'] : '';
$request_property_identity = isset($_GET['property_identity']) ? $_GET['property_identity'] : '';
$request_garage = isset($_GET['garage']) ? $_GET['garage'] : '';
$request_min_land_area = isset($_GET['min-land-area']) ? $_GET['min-land-area'] : '';
$request_max_land_area = isset($_GET['max-land-area']) ? $_GET['max-land-area'] : '';
$request_features = isset($_GET['other_features']) ? $_GET['other_features'] : '';
if (!empty($request_features)) {
	$request_features = explode(';', $request_features);
}
$request_advanced_search = isset($_GET['advanced']) ? $_GET['advanced'] : '0';
$request_features_search = isset($_GET['features-search']) ? $_GET['features-search'] : '0';

$wrapper_classes = array(
	'ere-search-properties clearfix',
	'style-mini-line',
	'color-dark',
);

$ere_search = new ERE_Search();
$min_suffix = ere_get_option('enable_min_css', 0) == 1 ? '.min' : '';
$min_suffix_js = ere_get_option('enable_min_js', 0) == 1 ? '.min' : '';
wp_enqueue_script(ERE_PLUGIN_PREFIX . 'search_js', ERE_PLUGIN_URL . 'public/templates/shortcodes/property-search/assets/js/property-search' . $min_suffix_js . '.js', array('jquery'), ERE_PLUGIN_VER, true);
wp_localize_script(ERE_PLUGIN_PREFIX . 'search_js', 'ere_search_vars',
	array(
		'ajax_url'        => ERE_AJAX_URL,
		'price_is_slider' => $price_is_slider,
	)
);
wp_print_styles(ERE_PLUGIN_PREFIX . 'property-search');
$geo_location = ere_get_option('geo_location');
/* Class col style for form*/
$css_class_field = 'col-lg-3 col-md-3 col-sm-3 col-xs-6';
$css_class_half_field = 'col-lg-3 col-md-3 col-sm-3 col-xs-6';

$css_class_header_field = 'col-lg-10 col-md-10 col-sm-10 col-xs-9';
$css_class_header_half_field = 'col-lg-10 col-md-10 col-sm-10 col-xs-9';
$field_number = 0;
$header_search_fields = $search_fields = array();
?>
<div class="<?php echo join(' ', $wrapper_classes) ?>">
	<div class="form-search-wrap container">
		<div class="form-search-inner">
			<div class="ere-search-content">
				<?php $advanced_search = ere_get_permalink('advanced_search'); ?>
				<div data-href="<?php echo esc_url($advanced_search) ?>" class="search-properties-form">
					<div class="form-search">
						<div class="header-search">
							<div class="row">
								<?php
								$header_search_fields = g5plus_get_option('mobile_header_search_fields', array('property_title', 'property_city', 'property_type', 'property_status', 'property_address', 'property_country', 'property_state', 'property_neighborhood', 'property_bedrooms', 'property_bathrooms', 'property_price', 'property_size', 'property_land', 'property_label', 'property_garage', 'property_identity'));
								if ($header_search_fields):
									foreach ($header_search_fields as $field):
										switch ($field) {
											case 'property_title':
												?>
												<div class="<?php echo esc_attr($css_class_header_field); ?> form-group">
													<input type="text" class="ere-location form-control search-field"
														   data-default-value=""
														   value="<?php echo esc_attr($request_title); ?>"
														   name="title"
														   placeholder="<?php esc_html_e('Enter keyword', 'benaa') ?>">
												</div>
												<?php
												break;
											case 'property_city':
												ere_get_template('property/search-fields/property_city.php', array(
													'css_class_field' => $css_class_header_field,
													'request_city'    => $request_city
												));
												break;
											case 'property_type':
												ere_get_template('property/search-fields/property_type.php', array(
													'css_class_field' => $css_class_header_field,
													'request_type'    => $request_type
												));
												break;
											case 'property_status':
												ere_get_template('property/search-fields/property_status.php', array(
													'css_class_field' => $css_class_header_field,
													'request_status'  => $request_status
												));
												break;
											case 'property_address':
												ere_get_template('property/search-fields/property_address.php', array(
													'css_class_field'  => $css_class_header_field,
													'request_address' => $request_address
												));
												break;
											case 'property_bedrooms':
												ere_get_template('property/search-fields/property_bedrooms.php', array(
													'css_class_field'  => $css_class_header_field,
													'request_bedrooms' => $request_bedrooms
												));
												break;
											case 'property_bathrooms':
												ere_get_template('property/search-fields/property_bathrooms.php', array(
													'css_class_field'   => $css_class_header_field,
													'request_bathrooms' => $request_bathrooms
												));
												break;
											case 'property_land':
												ere_get_template('property/search-fields/property_land.php', array(
													'css_class_field'       => $css_class_header_field,
													'css_class_half_field'  => $css_class_header_half_field,
													'request_min_land_area' => $request_min_land_area,
													'request_max_land_area' => $request_max_land_area,
													'land_area_is_slider'   => $land_area_is_slider
												));
												break;
											case 'property_price':
												ere_get_template('property/search-fields/property_price.php', array(
													'css_class_field'  => $css_class_header_field,
													'css_class_half_field' => $css_class_header_half_field,
													'request_min_price'    => $request_min_price,
													'request_max_price'    => $request_max_price,
													'request_status'       => $request_status,
													'price_is_slider'      => 'true'
												));
												break;
											case 'property_country':
												ere_get_template('property/search-fields/property_country.php', array(
													'css_class_field' => $css_class_header_field,
													'request_country' => $request_country
												));
												break;
											case 'property_state':
												ere_get_template('property/search-fields/property_state.php', array(
													'css_class_field' => $css_class_header_field,
													'request_state'   => $request_state
												));
												break;
											case 'property_neighborhood':
												ere_get_template('property/search-fields/property_neighborhood.php', array(
													'css_class_field'      => $css_class_header_field,
													'request_neighborhood' => $request_neighborhood
												));
												break;
											case 'property_label':
												ere_get_template('property/search-fields/property_label.php', array(
													'css_class_field' => $css_class_header_field,
													'request_label'   => $request_label
												));
												break;
											case 'property_size':
												ere_get_template('property/search-fields/property_size.php', array(
													'css_class_field'      => $css_class_header_field,
													'css_class_half_field' => $css_class_header_half_field,
													'request_min_area'     => $request_min_area,
													'request_max_area'     => $request_max_area,
													'area_is_slider'       => $area_is_slider
												));
												break;
											case 'property_garage':
												ere_get_template('property/search-fields/property_garage.php', array(
													'css_class_field' => $css_class_header_field,
													'request_garage'  => $request_garage
												));
												break;
											case 'property_identity':
												ere_get_template('property/search-fields/property_identity.php', array(
													'css_class_field'           => $css_class_header_field,
													'request_property_identity' => $request_property_identity
												));
												break;
										}
									
									endforeach;
								endif;
								?>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3 form-group submit-search-form pull-right">
									<div class="advanced-wrap clearfix">
										<div class="enable-other-advanced">
											<a href="javascript:void(0)" class="btn-other-advanced"><i
														class="fa fa-gear"></i></a>
										</div>
									</div>
									<button type="button" class="ere-advanced-search-btn"><i class="fa fa-search"></i>
										<?php esc_html_e('Search', 'benaa') ?>
									</button>
								</div>
							</div>
						</div>
						<div class="advanced-search col-xs-12">
							<div class="row">
								<?php
								$search_fields = ere_get_option('search_fields', array('property_title', 'property_city', 'property_type', 'property_status', 'property_address', 'property_country', 'property_state', 'property_neighborhood', 'property_bedrooms', 'property_bathrooms', 'property_price', 'property_size', 'property_land', 'property_label', 'property_garage', 'property_identity', 'property_feature'));
								$search_fields = array_diff($search_fields,$header_search_fields);
								if ($search_fields): foreach ($search_fields as $field) {
									switch ($field) {
										case 'property_title':
											ere_get_template('property/search-fields/property_title.php', array(
												'css_class_field' => $css_class_field,
												'request_title'   => $request_title
											));
											break;
										case 'property_city':
											ere_get_template('property/search-fields/property_city.php', array(
												'css_class_field' => $css_class_field,
												'request_city'    => $request_city
											));
											break;
										case 'property_type':
											ere_get_template('property/search-fields/property_type.php', array(
												'css_class_field' => $css_class_field,
												'request_type'    => $request_type
											));
											break;
										case 'property_status':
											ere_get_template('property/search-fields/property_status.php', array(
												'css_class_field' => $css_class_field,
												'request_status'  => $request_status
											));
											break;
										case 'property_address':
											ere_get_template('property/search-fields/property_address.php', array(
												'css_class_field' => $css_class_field,
												'request_address' => $request_address
											));
											break;
										case 'property_bedrooms':
											ere_get_template('property/search-fields/property_bedrooms.php', array(
												'css_class_field'  => $css_class_field,
												'request_bedrooms' => $request_bedrooms
											));
											break;
										case 'property_bathrooms':
											ere_get_template('property/search-fields/property_bathrooms.php', array(
												'css_class_field'   => $css_class_field,
												'request_bathrooms' => $request_bathrooms
											));
											break;
										case 'property_land':
											ere_get_template('property/search-fields/property_land.php', array(
												'css_class_field'       => $css_class_field,
												'css_class_half_field'  => $css_class_half_field,
												'request_min_land_area' => $request_min_land_area,
												'request_max_land_area' => $request_max_land_area,
												'land_area_is_slider'   => $land_area_is_slider
											));
											break;
										case 'property_price':
											ere_get_template('property/search-fields/property_price.php', array(
												'css_class_field'      => $css_class_field,
												'css_class_half_field' => $css_class_half_field,
												'request_min_price'    => $request_min_price,
												'request_max_price'    => $request_max_price,
												'request_status'       => $request_status,
												'price_is_slider'      => 'true'
											));
											break;
										case 'property_country':
											ere_get_template('property/search-fields/property_country.php', array(
												'css_class_field' => $css_class_field,
												'request_country' => $request_country
											));
											break;
										case 'property_state':
											ere_get_template('property/search-fields/property_state.php', array(
												'css_class_field' => $css_class_field,
												'request_state'   => $request_state
											));
											break;
										case 'property_neighborhood':
											ere_get_template('property/search-fields/property_neighborhood.php', array(
												'css_class_field'      => $css_class_field,
												'request_neighborhood' => $request_neighborhood
											));
											break;
										case 'property_label':
											ere_get_template('property/search-fields/property_label.php', array(
												'css_class_field' => $css_class_field,
												'request_label'   => $request_label
											));
											break;
										case 'property_size':
											ere_get_template('property/search-fields/property_size.php', array(
												'css_class_field'      => $css_class_field,
												'css_class_half_field' => $css_class_half_field,
												'request_min_area'     => $request_min_area,
												'request_max_area'     => $request_max_area,
												'area_is_slider'       => $area_is_slider
											));
											break;
										case 'property_garage':
											ere_get_template('property/search-fields/property_garage.php', array(
												'css_class_field' => $css_class_field,
												'request_garage'  => $request_garage
											));
											break;
										case 'property_identity':
											ere_get_template('property/search-fields/property_identity.php', array(
												'css_class_field'           => $css_class_field,
												'request_property_identity' => $request_property_identity
											));
											break;
										case 'property_feature':
											ere_get_template('property/search-fields/property_feature.php', array(
												'css_class_field'         => $css_class_field,
												'request_features_search' => $request_features_search,
												'request_features'        => $request_features,
											));
											break;
									}
								}
								endif;
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>