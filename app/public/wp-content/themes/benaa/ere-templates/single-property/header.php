<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
global $post;
$property_meta_data = get_post_custom(get_the_ID());
$property_identity = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_identity']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_identity'][0] : '';
$property_size = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_size']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_size'][0] : '';
$property_bedrooms = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_bedrooms']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_bedrooms'][0] : '0';
$property_bathrooms = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_bathrooms']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_bathrooms'][0] : '0';

$property_title = get_the_title();
$property_address = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_address']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_address'][0] : '';
$property_status = get_the_terms(get_the_ID(), 'property-status');
$property_price = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_price']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_price'][0] : '';
$property_price_short = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_price_short']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_price_short'][0] : '';
$property_price_unit = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_price_unit']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_price_unit'][0] : '';

$property_price_prefix = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_price_prefix']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_price_prefix'][0] : '';
$property_price_postfix = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_price_postfix']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_price_postfix'][0] : '';

?>
<div class="property-info-header property-info-action mg-bottom-50 sm-mg-bottom-30">
	<div class="property-main-info">
		<?php
		$property_status = get_the_terms(get_the_ID(), 'property-status');
		if ($property_status) : ?>
			<div class="property-status">
				<?php foreach ($property_status as $status) : ?>
					<span><?php echo esc_attr($status->name); ?></span>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<?php if (!empty($property_address)):
			$property_location = get_post_meta(get_the_ID(), ERE_METABOX_PREFIX . 'property_location', true);
			if ($property_location) {
				$google_map_address_url = "http://maps.google.com/?q=" . $property_location['address'];
			} else {
				$google_map_address_url = "http://maps.google.com/?q=" . $property_address;
			}
			?>
			<div class="property-location" title="<?php echo esc_attr($property_address) ?>">
				<i class="fa fa-map-marker accent-color"></i>
				<a target="_blank"
				   href="<?php echo esc_url($google_map_address_url); ?>"><span><?php echo esc_attr($property_address) ?></span></a>
			</div>
		<?php endif; ?>
		<div class="property-heading">
			<?php if (!empty($property_title)): ?>
				<h4><?php the_title(); ?></h4>
			<?php endif; ?>
		</div>
	</div>
	<div class="property-bottom-info">
		<div class="property-info">
			<div class="property-id">
				<span class="fa fa-barcode accent-color"></span>
				<div class="content-property-info">
					<p class="property-info-value"><?php
						if (!empty($property_identity)) {
							echo esc_html($property_identity);
						} else {
							echo get_the_ID();
						}
						?></p>
					<p class="property-info-title"><?php esc_html_e('Property ID', 'benaa'); ?></p>
				</div>
			</div>
			<?php if (!empty($property_size)): ?>
				<div class="property-area">
					<span class="fa fa-arrows accent-color"></span>
					<div class="content-property-info">
						<p class="property-info-value"><?php
							echo esc_attr($property_size) ?>
							<span><?php
								$measurement_units = ere_get_measurement_units();
								echo esc_html($measurement_units); ?></span>
						</p>
						<p class="property-info-title"><?php esc_html_e('Size', 'benaa'); ?></p>
					</div>
				</div>
			<?php endif; ?>
			<?php if (!empty($property_bedrooms)): ?>
				<div class="property-bedrooms">
					<span class="fa fa-hotel accent-color"></span>
					<div class="content-property-info">
						<p class="property-info-value"><?php echo esc_attr($property_bedrooms) ?></p>
						<p class="property-info-title"><?php
							printf(_n('Bedroom', 'Bedrooms', $property_bedrooms, 'benaa'), $property_bedrooms);
							?></p>
					</div>
				</div>
			<?php endif; ?>
			<?php if (!empty($property_bathrooms)): ?>
				<div class="property-bathrooms">
					<span class="fa fa-bath accent-color"></span>
					<div class="content-property-info">
						<p class="property-info-value"><?php echo esc_attr($property_bathrooms) ?></p>
						<p class="property-info-title"><?php
							printf(_n('Bathroom', 'Bathrooms', $property_bathrooms, 'benaa'), $property_bathrooms);
							?></p>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<div class="property-price-action">
			<?php if (!empty($property_price)): ?>
				<span class="property-price">
						<?php if (!empty($property_price_prefix)) {
							echo '<span class="property-price-prefix">' . $property_price_prefix . ' </span>';
						} ?>
						<?php
						echo ere_get_format_money($property_price_short, $property_price_unit);
						?>
						<?php if (!empty($property_price_postfix)) {
							echo '<span class="property-price-postfix"> / ' . $property_price_postfix . '</span>';
						} ?>
					</span>
			<?php elseif (ere_get_option('empty_price_text', '') != ''): ?>
				<span class="property-price"><?php echo ere_get_option('empty_price_text', '') ?></span>
			<?php endif; ?>
			<div class="property-action">
				<div class="property-action-inner clearfix">
					<?php
					if (ere_get_option('enable_social_share', '1') == '1') {
						ere_get_template('global/social-share.php');
					}
					if (ere_get_option('enable_favorite_property', '1') == '1') {
						ere_get_template('property/favorite.php');
					}
					if (ere_get_option('enable_compare_properties', '1') == '1'):?>
						<a class="compare-property" href="javascript:void(0)"
						   data-property-id="<?php the_ID() ?>" data-toggle="tooltip"
						   title="<?php esc_html_e('Compare', 'benaa') ?>">
							<i class="fa fa-plus"></i>
						</a>
					<?php endif;
					if (ere_get_option('enable_print_property', '1') == '1'):?>
						<a href="javascript:void(0)" id="property-print"
						   data-ajax-url="<?php echo ERE_AJAX_URL; ?>" data-toggle="tooltip"
						   data-original-title="<?php esc_html_e('Print', 'benaa'); ?>"
						   data-property-id="<?php echo esc_attr(get_the_ID()); ?>"><i class="fa fa-print"></i></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>