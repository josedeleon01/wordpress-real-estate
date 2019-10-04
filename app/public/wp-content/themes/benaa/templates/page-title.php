<?php
/**
 * The template for displaying page title
 *
 * @package WordPress
 * @subpackage Theme_Name
 * @since Theme_Version 1.0
 */

$page_title = '';
$page_title_layout_style = g5plus_get_option('page_title_layout_style', 'large');
$page_sub_title = '';
$page_title_enable = 1;
$page_breadcrumbs_enable = 1;
$page_title_bg_image = '';
$page_title_class = array(
	'page-title',
	'page-title-' . $page_title_layout_style
);

$page_title_padding = g5plus_get_option('page_title_padding', array('top' => '120', 'bottom' => '120'));
$page_title_parallax = g5plus_get_option('page_title_parallax', 1);

if (is_home()) {
	if (empty($page_title)) {
		$page_title = esc_html__("Blog", 'benaa');
	}
} elseif (!is_singular() && !is_front_page()) {
	if (!have_posts() && !is_author()) {
		$page_title = esc_html__('Nothing Found', 'benaa');
	} elseif (is_tag()) {
		$page_title = single_tag_title(esc_html__("Tags: ", 'benaa'), false);
	} elseif (is_category() || is_tax()) {
		$page_title = single_cat_title('', false);
	} elseif (is_author()) {
		global $wp_query;
		$current_author = $wp_query->get_queried_object();
		$current_author_meta = get_user_meta($current_author->ID);
		if (empty($current_author->first_name) && empty($current_author->last_name)) {
			$page_title = $current_author->user_login;
		} else {
			$page_title = $current_author->first_name . ' ' . $current_author->last_name;
		}
	} elseif (is_day()) {
		$page_title = sprintf(esc_html__('Daily Archives: %s', 'benaa'), get_the_date());
	} elseif (is_month()) {
		$page_title = sprintf(esc_html__('Monthly Archives: %s', 'benaa'), get_the_date(_x('F Y', 'monthly archives date format', 'benaa')));
	} elseif (is_year()) {
		$page_title = sprintf(esc_html__('Yearly Archives: %s', 'benaa'), get_the_date(_x('Y', 'yearly archives date format', 'benaa')));
	} elseif (is_search()) {
		$page_title = esc_html__('Search Results', 'benaa');
	} elseif (is_tax('post_format', 'post-format-aside')) {
		$page_title = esc_html__('Asides', 'benaa');
	} elseif (is_tax('post_format', 'post-format-gallery')) {
		$page_title = esc_html__('Galleries', 'benaa');
	} elseif (is_tax('post_format', 'post-format-image')) {
		$page_title = esc_html__('Images', 'benaa');
	} elseif (is_tax('post_format', 'post-format-video')) {
		$page_title = esc_html__('Videos', 'benaa');
	} elseif (is_tax('post_format', 'post-format-quote')) {
		$page_title = esc_html__('Quotes', 'benaa');
	} elseif (is_tax('post_format', 'post-format-link')) {
		$page_title = esc_html__('Links', 'benaa');
	} elseif (is_tax('post_format', 'post-format-status')) {
		$page_title = esc_html__('Statuses', 'benaa');
	} elseif (is_tax('post_format', 'post-format-audio')) {
		$page_title = esc_html__('Audios', 'benaa');
	} elseif (is_tax('post_format', 'post-format-chat')) {
		$page_title = esc_html__('Chats', 'benaa');
	}
}

$page_title_enable = g5plus_get_option('page_title_enable', 1);
$title_enable = g5plus_get_option('title_enable', 1);
$page_title = g5plus_get_option('page_title', $page_title);
$page_sub_title = g5plus_get_option('page_sub_title', $page_sub_title);
$page_breadcrumbs_enable = g5plus_get_option('breadcrumbs_enable', 1);
$page_title_bg_image = g5plus_get_option('page_title_bg_image', '');
$page_title_bg_image = isset($page_title_bg_image['url']) ? $page_title_bg_image['url'] : '';
if (is_singular()) {
	if (!$page_title) {
		$page_title = get_the_title(get_the_ID());
	}
	$custom_page_title_visible = g5plus_get_post_meta('custom_page_title_visible', get_the_ID());
	if (($custom_page_title_visible !== '-1') && ($custom_page_title_visible !== '')) {
		$page_title_enable = $custom_page_title_visible;
	}
	
	$custom_breadcrumbs_visible = g5plus_get_post_meta('custom_breadcrumbs_visible', get_the_ID());
	if (($custom_breadcrumbs_visible !== '-1') && ($custom_breadcrumbs_visible !== '')) {
		$page_breadcrumbs_enable = $custom_breadcrumbs_visible;
	}
	$is_custom_page_title = g5plus_get_post_meta('is_custom_page_title', get_the_ID());
	if ($is_custom_page_title) {
		$page_title = g5plus_get_post_meta('custom_page_title', get_the_ID());
		$page_sub_title = g5plus_get_post_meta('custom_page_sub_title', get_the_ID());
	}
	$is_custom_page_title_bg = g5plus_get_post_meta('is_custom_page_title_bg', get_the_ID());
	if ($is_custom_page_title_bg) {
		$page_title_bg_image = g5plus_get_post_meta_image('custom_page_title_bg_image', get_the_ID());
	}
	$post_type = get_post_type(get_the_ID());
	if ($post_type === 'property' && function_exists('ere_get_option')) {
		$page_title = get_the_title(get_the_ID());
		$custom_property_single_header_type = ere_get_option('custom_property_single_header_type', 'map');
		if ($custom_property_single_header_type === 'image' || (isset($_GET['single-layout']) && $_GET['single-layout'] === 'image')) {
			$page_title_class[] = 'property-single-page-title';
			$page_breadcrumbs_enable = false;
			$page_sub_title = '';
		} elseif ($custom_property_single_header_type === 'map' || (isset($_GET['single-layout']) && $_GET['single-layout'] === 'map')) {
			$page_title_class[] = 'property-single-map';
			$page_breadcrumbs_enable = false;
			$page_sub_title = '';
			$page_title_padding = array('top' => '0', 'bottom' => '0');
		}
	} else {
		$page_title_class[] = 'page-title-' . $page_title_layout_style;
	}
} elseif (is_category() || is_tax()) {
	$cat = get_queried_object();
	if ($cat && property_exists($cat, 'term_id')) {
		$custom_page_title_enable = g5plus_get_tax_meta($cat->term_id, 'page_title_enable');
		if ($custom_page_title_enable != '' && $custom_page_title_enable != -1) {
			$page_title_enable = $custom_page_title_enable;
		}
		
		$bg_image = g5plus_get_tax_meta($cat->term_id, 'page_title_bg_image');
		if (isset($bg_image['url'])) {
			$page_title_bg_image = $bg_image['url'];
		}
	}
}

if (!$page_title_enable) return;

if (is_post_type_archive() && !$page_title) {
	$post_type = get_post_type_object(get_post_type());
	if ($post_type) {
		$page_title = $post_type->label;
	}
}
$page_title = apply_filters('g5plus_page_title', $page_title);
$page_sub_title = apply_filters('g5plus_sub_page_title', $page_sub_title);


// region Custom Styles

$custom_styles = array();
$page_title_bg_styles = array();
$page_title_bg_class = array();
if (isset($page_title_padding['top']) && !empty($page_title_padding['top']) && ($page_title_padding['top'] != 'px')) {
	$custom_styles[] = "padding-top:" . $page_title_padding['top'] . "px";
} else {

}
if (isset($page_title_padding['bottom']) && !empty($page_title_padding['bottom']) && ($page_title_padding['bottom'] != 'px')) {
	$custom_styles[] = "padding-bottom:" . $page_title_padding['bottom'] . "px";
}


$image_src = $property_status = $price = $property_address = '';
if (in_array('property-single-page-title', $page_title_class)) {
	if (class_exists('Essential_Real_Estate')) {
		$attach_id = get_post_thumbnail_id();
		$image_src = ere_image_resize_id($attach_id, 1920, 204, true);
		if (!empty($image_src)) {
			$page_title_bg_image = $image_src;
		}
		
		$property_status = get_the_terms(get_the_ID(), 'property-status');
		$property_price = get_post_meta(get_the_ID(), ERE_METABOX_PREFIX . 'property_price', true);
		$property_price_short = get_post_meta(get_the_ID(), ERE_METABOX_PREFIX . 'property_price_short', true);
		$property_price_unit = get_post_meta(get_the_ID(), ERE_METABOX_PREFIX . 'property_price_unit', true);
		
		$property_price_prefix = get_post_meta(get_the_ID(), ERE_METABOX_PREFIX . 'property_price_prefix', true);
		$property_price_postfix = get_post_meta(get_the_ID(), ERE_METABOX_PREFIX . 'property_price_postfix', true);
		$property_address = get_post_meta(get_the_ID(), ERE_METABOX_PREFIX . 'property_address', true);
		
		$property_identity = get_post_meta(get_the_ID(), ERE_METABOX_PREFIX . 'property_identity', true);
		$property_size = get_post_meta(get_the_ID(), ERE_METABOX_PREFIX . 'property_size', true);
		$property_bedrooms = get_post_meta(get_the_ID(), ERE_METABOX_PREFIX . 'property_bedrooms', true);
		$property_bathrooms = get_post_meta(get_the_ID(), ERE_METABOX_PREFIX . 'property_bathrooms', true);
		
	}
}

if ((!empty($page_title_bg_image)) && ($page_title_layout_style != 'small')) {
	$page_title_bg_styles[] = 'style="background-image: url(' . $page_title_bg_image . ')"';
	$page_title_class[] = 'page-title-background';
	$page_title_bg_class[] = 'page-title-background';
	
	if ($page_title_parallax) {
		$page_title_bg_class[] = 'page-title-parallax';
	}
}

$post_type = get_post_type(get_the_ID());
if (is_singular() && ($page_title_layout_style == 'small') && ($post_type == 'property') && function_exists('ere_get_option')) {
	$page_title_bg_styles[] = 'style="background-image: url(' . $page_title_bg_image . ')"';
	$page_title_class[] = 'page-title-background';
	$page_title_bg_class[] = 'page-title-background';
	
	if ($page_title_parallax) {
		$page_title_bg_class[] = 'page-title-parallax';
	}
}
$custom_style = '';
if ($custom_styles) {
	$custom_style = 'style="' . join(';', $custom_styles) . '"';
}
if (!empty($page_title_bg_image) && $page_title_parallax) {
	$page_title_bg_styles[] = ' data-stellar-background-ratio="0.5"';
}

// endregion
?>
<section class="<?php echo join(' ', $page_title_class); ?>" <?php echo wp_kses_post($custom_style); ?>>
	<?php if (!in_array('property-single-map', $page_title_class)): ?>
		<div class="<?php echo join(' ', $page_title_bg_class); ?>" <?php echo join(' ', $page_title_bg_styles); ?>></div>
		<div class="container">
			<div class="page-title-inner">
				<?php if (($page_breadcrumbs_enable) && ($page_title_layout_style == 'small')) {
					get_template_part('templates/breadcrumb');
				} ?>
				<?php if (in_array('property-single-page-title', $page_title_class)): ?>
					<div class="property-info-header property-info-action">
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
							<?php if ($title_enable): ?>
								<div class="property-heading">
									<h4><?php echo esc_html($page_title) ?></h4>
								</div>
								<?php if (!empty($page_sub_title)): ?>
									<p><?php echo esc_html($page_sub_title) ?></p>
								<?php endif; ?>
							<?php endif; ?>
						
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
											   data-property-id="<?php echo esc_attr(get_the_ID()); ?>"><i
														class="fa fa-print"></i></a>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php else: ?>
					<?php if ($title_enable): ?>
						<?php if ((!empty($page_title)) || (!empty($page_sub_title))): ?>
							<div class="page-title-main-info">
								<?php if (!empty($page_title)): ?>
									<h4><?php echo esc_html($page_title) ?></h4>
								<?php endif; ?>
								<?php if (!empty($page_sub_title)): ?>
									<p><?php echo esc_html($page_sub_title) ?></p>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
				<?php if (($page_breadcrumbs_enable) && ($page_title_layout_style == 'large')) {
					get_template_part('templates/breadcrumb');
				} ?>
			</div>
		</div>
	<?php else: ?>
		<?php
		$google_map = '[ere_property_map map_style="property" property_id="' . get_the_ID() . '" map_height="450px"]';
		echo do_shortcode($google_map);
		?>
	<?php endif; ?>
</section>