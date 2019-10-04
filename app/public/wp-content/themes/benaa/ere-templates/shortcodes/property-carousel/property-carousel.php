<?php
/**
 * Shortcode attributes
 * @var $atts
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
$property_type = $property_status = $property_feature = $property_city = $property_state = $property_neighborhood =
$property_label = $property_featured = $item_amount = $columns_gap = $image_size = $color_scheme = $include_heading = $heading_sub_title = $heading_title = $el_class = '';
extract(shortcode_atts(array(
	'property_type'         => '',
	'property_status'       => '',
	'property_feature'      => '',
	'property_city'         => '',
	'property_state'        => '',
	'property_neighborhood' => '',
	'property_label'        => '',
	'property_featured'     => '',
	'item_amount'           => '6',
	'columns_gap'           => 'col-gap-0',
	'image_size'            => '340x340',
	'color_scheme'          => 'color-dark',
	'include_heading'       => '',
	'heading_sub_title'     => '',
	'heading_title'         => '',
	'el_class'              => ''
), $atts));

$property_item_class = array('property-item');
$property_content_class = array('property-content');
$property_content_attributes = array();
$wrapper_attributes = array();
$wrapper_classes = array(
	'ere-property-carousel ere-property property-carousel clearfix',
	$color_scheme,
	$el_class
);
if ($columns_gap == 'col-gap-30') {
	$col_gap = 30;
} elseif ($columns_gap == 'col-gap-20') {
	$col_gap = 20;
} elseif ($columns_gap == 'col-gap-10') {
	$col_gap = 10;
} else {
	$col_gap = 0;
}
$property_content_class[] = 'owl-carousel manual';
$owl_responsive_attributes = array();
// Mobile <= 480px
$owl_responsive_attributes[] = '"0" : {"items" : 1, "margin": ' . $col_gap . '}';

// Small devices Tablets ( < 992px)
$owl_responsive_attributes[] = '"768" : {"items" : 2, "margin": ' . $col_gap . '}';

// Medium devices ( > 1199px)
$owl_responsive_attributes[] = '"1200" : {"items" : 3, "margin": ' . $col_gap . '}';

$owl_responsive_attributes[] = '"1820" : {"items" : 4, "margin": ' . $col_gap . '}';

$owl_attributes = array(
	'"dots": false',
	'"nav": true',
	'"responsive": {' . implode(', ', $owl_responsive_attributes) . '}'
);
$property_content_attributes[] = "data-plugin-options='{" . implode(', ', $owl_attributes) . "}'";

$args = array(
	'posts_per_page' => ($item_amount > 0) ? $item_amount : -1,
	'post_type'      => 'property',
	'orderby'        => 'date',
	'order'          => 'DESC',
	'post_status'    => 'publish',
);

if (!empty($property_type) || !empty($property_status) || !empty($property_feature) || !empty($property_city)
	|| !empty($property_state) || !empty($property_neighborhood) || !empty($property_label)
) {
	$args['tax_query'] = array();
	if (!empty($property_type)) {
		$args['tax_query'][] = array(
			'taxonomy' => 'property-type',
			'field'    => 'slug',
			'terms'    => explode(',', $property_type),
			'operator' => 'IN'
		);
	}
	if (!empty($property_status)) {
		$args['tax_query'][] = array(
			'taxonomy' => 'property-status',
			'field'    => 'slug',
			'terms'    => explode(',', $property_status),
			'operator' => 'IN'
		);
	}
	if (!empty($property_feature)) {
		$args['tax_query'][] = array(
			'taxonomy' => 'property-feature',
			'field'    => 'slug',
			'terms'    => explode(',', $property_feature),
			'operator' => 'IN'
		);
	}
	if (!empty($property_city)) {
		$args['tax_query'][] = array(
			'taxonomy' => 'property-city',
			'field'    => 'slug',
			'terms'    => explode(',', $property_city),
			'operator' => 'IN'
		);
	}
	if (!empty($property_state)) {
		$args['tax_query'][] = array(
			'taxonomy' => 'property-state',
			'field'    => 'slug',
			'terms'    => explode(',', $property_state),
			'operator' => 'IN'
		);
	}
	if (!empty($property_neighborhood)) {
		$args['tax_query'][] = array(
			'taxonomy' => 'property-neighborhood',
			'field'    => 'slug',
			'terms'    => explode(',', $property_neighborhood),
			'operator' => 'IN'
		);
	}
	if (!empty($property_label)) {
		$args['tax_query'][] = array(
			'taxonomy' => 'property-label',
			'field'    => 'slug',
			'terms'    => explode(',', $property_label),
			'operator' => 'IN'
		);
	}
}

if ($property_featured == 'true') {
	$args['meta_query'] = array(
		array(
			'key'     => ERE_METABOX_PREFIX . 'property_featured',
			'value'   => true,
			'compare' => '=',
		)
	);
}

$data = new WP_Query($args);
$total_post = $data->found_posts;

$min_suffix = ere_get_option('enable_min_css', 0) == 1 ? '.min' : '';
wp_print_styles(ERE_PLUGIN_PREFIX . 'property-carousel');
wp_print_styles(ERE_PLUGIN_PREFIX . 'property');

$min_suffix_js = ere_get_option('enable_min_js', 0) == 1 ? '.min' : '';
wp_enqueue_script(ERE_PLUGIN_PREFIX . 'owl_carousel', ERE_PLUGIN_URL . 'public/assets/js/ere-carousel' . $min_suffix_js . '.js', array('jquery'), ERE_PLUGIN_VER, true);
?>
<div class="ere-property-wrap">
	<div class="<?php echo join(' ', $wrapper_classes) ?>" <?php echo implode(' ', $wrapper_attributes); ?>>
		<div class="navigation-wrap">
			<?php if ($include_heading) :
				$heading_class = '';
				if (!empty($heading_sub_title)) {
					$heading_class .= ' ere-heading-sub';
				}
				?>
				<div class="container">
					<div class="ere-heading ere-item-wrap mg-bottom-60 sm-mg-bottom-40 <?php echo esc_attr($heading_class); ?>">
						<span></span>
						<?php if (!empty($heading_sub_title)): ?>
							<p><?php echo esc_html($heading_sub_title); ?></p>
						<?php endif; ?>
						<?php if (!empty($heading_title)): ?>
							<h2><?php echo esc_html($heading_title); ?></h2>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<div class="<?php echo join(' ', $property_content_class) ?>"
			 data-callback="owl_callback" <?php echo implode(' ', $property_content_attributes); ?>>
			<?php if ($data->have_posts()) :
				$no_image_src = ERE_PLUGIN_URL . 'public/assets/images/no-image.jpg';
				$default_image = ere_get_option('default_property_image', '');
				if (preg_match('/\d+x\d+/', $image_size)) {
					$image_sizes = explode('x', $image_size);
					$width = $image_sizes[0];
					$height = $image_sizes[1];
					if ($default_image != '') {
						if (is_array($default_image) && $default_image['url'] != '') {
							$resize = ere_image_resize_url($default_image['url'], $width, $height, true);
							if ($resize != null && is_array($resize)) {
								$no_image_src = $resize['url'];
							}
						}
					}
				} else {
					if ($default_image != '') {
						if (is_array($default_image) && $default_image['url'] != '') {
							$no_image_src = $default_image['url'];
						}
					}
				}
				while ($data->have_posts()): $data->the_post();
					$attach_id = get_post_thumbnail_id();
					$image_src = '';
					$item_class = '';
					$width = 340;
					$height = 340;
					if (preg_match('/\d+x\d+/', $image_size)) {
						$image_sizes = explode('x', $image_size);
						$width = $image_sizes[0];
						$height = $image_sizes[1];
						$image_src = ere_image_resize_id($attach_id, $width, $height, true);
					} else {
						if (!in_array($image_size, array('full', 'thumbnail'))) {
							$image_size = 'full';
						}
						$image_src = wp_get_attachment_image_src($attach_id, $image_size);
						if ($image_src && !empty($image_src[0])) {
							$image_src = $image_src[0];
						}
						if (!empty($image_src)) {
							list($width, $height) = getimagesize($image_src);
						}
					}
					$property_meta_data = get_post_custom(get_the_ID());
					
					$price = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_price']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_price'][0] : '';
					$price_short = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_price_short']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_price_short'][0] : '';
					$price_unit = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_price_unit']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_price_unit'][0] : '';
					$price_prefix = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_price_prefix']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_price_prefix'][0] : '';
					$price_postfix = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_price_postfix']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_price_postfix'][0] : '';
					$property_address = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_address']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_address'][0] : '';
					$property_size = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_size']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_size'][0] : '';
					$property_bedrooms = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_bedrooms']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_bedrooms'][0] : '0';
					$property_bathrooms = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_bathrooms']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_bathrooms'][0] : '0';
					$property_garages = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_garage']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_garage'][0] : '0';
					$property_featured = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_featured']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_featured'][0] : '0';
					
					// Get Agent name
					$agent_display_option = isset($property_meta_data[ERE_METABOX_PREFIX . 'agent_display_option']) ? $property_meta_data[ERE_METABOX_PREFIX . 'agent_display_option'][0] : '';
					$property_agent = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_agent']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_agent'][0] : '';
					$agent_name = $agent_link = '';
					
					if ($agent_display_option == 'author_info') {
						global $post;
						$user_id = $post->post_author;
						$user_info = get_userdata($user_id);
						
						if (empty($user_info->first_name) && empty($user_info->last_name)) {
							$agent_name = $user_info->user_login;
						} else {
							$agent_name = $user_info->first_name . ' ' . $user_info->last_name;
						}
						$author_agent_id = get_the_author_meta(ERE_METABOX_PREFIX . 'author_agent_id', $user_id);
						if (empty($author_agent_id)) {
							$agent_link = get_author_posts_url($user_id);
							
						} else {
							$agent_link = get_the_permalink($author_agent_id);
						}
						
					} elseif ($agent_display_option == 'other_info') {
						$agent_name = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_other_contact_name']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_other_contact_name'][0] : '';
					} elseif ($agent_display_option == 'agent_info' && !empty($property_agent)) {
						$agent_name = get_the_title($property_agent);
						$agent_link = get_the_permalink($property_agent);
					}
					
					$property_iterm_type = get_the_terms(get_the_ID(), 'property-type');
					$property_label = get_the_terms(get_the_ID(), 'property-label');
					$property_item_status = get_the_terms(get_the_ID(), 'property-status');
					
					$property_link = get_the_permalink();
					?>
					<div class="<?php echo join(' ', $property_item_class); ?>">
						<div class="property-inner">
							<div class="property-image">
								<img width="<?php echo esc_attr($width) ?>"
									 height="<?php echo esc_attr($height) ?>"
									 src="<?php echo esc_url($image_src) ?>"
									 onerror="this.src = '<?php echo esc_url($no_image_src) ?>';"
									 alt="<?php the_title(); ?>"
									 title="<?php the_title(); ?>">
								<div class="property-action block-center">
									<div class="block-center-inner">
										<?php
										/**
										 * ere_property_action hook.
										 *
										 * @hooked property_social_share - 5
										 * @hooked property_favorite - 10
										 * @hooked property_compare - 15
										 */
										do_action('ere_property_action'); ?>
										<div class="property-element-inline">
											<?php if ($property_iterm_type): ?>
												<div class="property-type-list">
													<i class="fa fa-tag accent-color"></i>
													<?php foreach ($property_iterm_type as $type): ?>
														<a href="<?php echo esc_url(get_term_link($type->slug, 'property-type')); ?>"
														   title="<?php echo esc_attr($type->name); ?>"><span><?php echo esc_attr($type->name); ?> </span></a>
													<?php endforeach; ?>
												</div>
											<?php endif; ?>
										</div>
									</div>
									<a class="property-link" href="<?php echo esc_url($property_link); ?>"
									   title="<?php the_title(); ?>"></a>
								</div>
								<?php if ($property_label || $property_featured): ?>
									<div class="property-label property-featured">
										<?php if ($property_featured): ?>
											<p class="label-item">
                                                <span
														class="property-label-bg"><?php esc_html_e('Featured', 'benaa'); ?>
													<span class="property-arrow"></span></span>
											</p>
										<?php endif; ?>
										<?php if ($property_label): ?>
											<?php foreach ($property_label as $label_item): ?>
												<p class="label-item">
                                                    <span class="property-label-bg"><?php echo esc_attr($label_item->name) ?>
														<span class="property-arrow"></span>
                                                    </span>
												</p>
											<?php endforeach; ?>
										<?php endif; ?>
									</div>
								<?php endif; ?>
								<div class="property-item-content-inner">
									<div class="property-date"><i
												class="fa fa-calendar accent-color"></i>
										<?php
										$get_the_time = get_the_time('U');
										$current_time = current_time('timestamp');
										$human_time_diff = human_time_diff($get_the_time, $current_time);
										printf(_x(' %s ago', '%s = human-readable time difference', 'benaa'), $human_time_diff); ?>
									</div>
									<?php if (!empty($agent_name)): ?>
										<div class="property-agent">
											<?php echo !empty($agent_link) ? ('<a href="' . $agent_link . '" title="' . $agent_name . '">') : ''; ?>
											<i class="fa fa-user accent-color"></i>
											<span><?php echo esc_attr($agent_name) ?></span>
											<?php echo !empty($agent_link) ? ('</a>') : ''; ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<div class="property-item-content">
							<?php if ($property_iterm_type): ?>
								<div class="property-type">
									<i class="fa fa-tag accent-color"></i>
									<?php foreach ($property_iterm_type as $type): ?>
										<a href="<?php echo esc_url(get_term_link($type->slug, 'property-type')); ?>"
										   title="<?php echo esc_attr($type->name); ?>"><span><?php echo esc_attr($type->name); ?> </span></a>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
							<div class="property-heading">
								<h4 class="property-title fs-18"><a
											href="<?php echo esc_url($property_link); ?>"
											title="<?php the_title(); ?>"><?php the_title() ?></a>
								</h4>
							</div>
							<?php if (!empty($property_address)):
								$property_location = get_post_meta(get_the_ID(), ERE_METABOX_PREFIX . 'property_location', true);
								if ($property_location) {
									$google_map_address_url = "http://maps.google.com/?q=" . $property_location['address'];
								} else {
									$google_map_address_url = "http://maps.google.com/?q=" . $property_address;
								} ?>
								<div class="property-location" title="<?php echo esc_attr($property_address) ?>">
									<i class="fa fa-map-marker accent-color"></i>
									<a target="_blank"
									   href="<?php echo esc_url($google_map_address_url); ?>"><span><?php echo esc_attr($property_address) ?></span></a>
								</div>
							<?php endif; ?>
							<div class="property-info">
								<div class="property-info-inner clearfix">
									<?php if (!empty($property_size)): ?>
										<div class="property-area">
											<div class="property-area-inner">
												<i class="icon-assembly-area"></i>
												<span class="property-info-value"><?php
													$measurement_units = ere_get_measurement_units();
													echo esc_attr($property_size . ' ' . $measurement_units) ?>
												</span>
											</div>
										</div>
									<?php endif; ?>
									<?php if (!empty($property_bedrooms)): ?>
										<div class="property-bedrooms">
											<div class="property-bedrooms-inner">
												<i class="icon-bed-1"></i>
												<span class="property-info-value"><?php printf(_n('%s Bedroom', '%s Bedrooms', $property_bedrooms, 'benaa'), $property_bedrooms); ?></span>
											</div>
										</div>
									<?php endif; ?>
									<?php if (!empty($property_bathrooms)): ?>
										<div class="property-bathrooms">
											<div class="property-bathrooms-inner">
												<i class="icon-bathtub-1"></i>
												<span class="property-info-value"><?php printf(_n('%s Bathroom', '%s Bathrooms', $property_bathrooms, 'benaa'), $property_bathrooms); ?></span>
											</div>
										</div>
									<?php endif; ?>
									<?php if (!empty($property_garages)): ?>
										<div class="property-garages">
											<div class="property-garages-inner">
												<i class="icon-car-garage"></i>
												<span class="property-info-value"><?php printf(_n('%s Garage', '%s Garages', $property_garages, 'benaa'), $property_garages); ?></span>
											</div>
										</div>
									<?php endif; ?>
								</div>
							</div>
							<div class="property-status-price">
								<?php if ($property_item_status): ?>
									<div class="property-status">
										<?php foreach ($property_item_status as $status): ?>
											<?php $status_color = get_term_meta($status->term_id, 'property_status_color', true); ?>
											<p class="status-item">
                                        <span class="property-status-bg"><?php echo esc_attr($status->name) ?>
											<span class="property-arrow"></span>
                                        </span>
											</p>
										<?php endforeach; ?>
									</div>
								<?php endif; ?>
								<?php if (!empty($price)): ?>
									<div class="property-price">
                                                <span>
                                                    <?php if (!empty($price_prefix)) {
														echo '<span class="property-price-prefix">' . $price_prefix . ' </span>';
													} ?>
													<?php echo ere_get_format_money($price_short, $price_unit) ?>
													<?php if (!empty($price_postfix)) {
														echo '<span class="property-price-postfix"> / ' . $price_postfix . '</span>';
													} ?>
                                                </span>
										<?php if (empty($price_prefix) && empty($price_postfix) && !empty($property_size)): ?>
											<span class="price-per-unit">
                                                        <?php
														$measurement_units = ere_get_measurement_units();
														echo ere_get_format_money(round($price / $property_size, 2)) . '/' . $measurement_units;
														?>
                                                    </span>
										<?php endif; ?>
									</div>
								<?php elseif (ere_get_option('empty_price_text', '') != ''): ?>
									<div class="property-price">
										<span><?php echo ere_get_option('empty_price_text', '') ?></span>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endwhile;
			else: ?>
				<div class="item-not-found"><?php esc_html_e('No item found', 'benaa'); ?></div>
			<?php endif; ?>
		</div>
		<?php wp_reset_postdata(); ?>
	</div>
</div>

