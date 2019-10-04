<?php
/**
 * @var $properties
 * @var $max_num_pages
 * @var $post_status
 * @var $title
 * @var $property_identity
 * @var $property_status
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!is_user_logged_in()) {
    echo ere_get_template_html('global/access-denied.php', array('type' => 'not_login'));
    return;
}
$my_properties_columns = apply_filters('ere_my_properties_columns', array(
    'detail' => esc_html__('Detail', 'benaa'),
    'date' => esc_html__('Date Posted', 'benaa'),
    'featured' => esc_html__('Featured', 'benaa'),
    'status' => esc_html__('Post Status', 'benaa'),
));
$allow_submit = ere_allow_submit();
if (!$allow_submit) {
    echo ere_get_template_html('global/access-denied.php', array('type' => 'not_permission'));
    return;
}
$request_new_id = isset($_GET['new_id']) ? $_GET['new_id'] : '';
if (!empty($request_new_id)) {
    ere_get_template('property/property-submitted.php', array('property' => get_post($request_new_id), 'action' => 'new'));
}
$request_edit_id = isset($_GET['edit_id']) ? $_GET['edit_id'] : '';
if (!empty($request_edit_id)) {
    ere_get_template('property/property-submitted.php', array('property' => get_post($request_edit_id), 'action' => 'edit'));
}
$my_properties_page_link = ere_get_permalink('my_properties');
$ere_property = new ERE_Property();
$total_properties = $ere_property->get_total_my_properties(array('publish', 'pending', 'expired', 'hidden'));
$post_status_approved = remove_query_arg(array('new_id', 'edit_id'), add_query_arg(array('post_status' => 'publish'), $my_properties_page_link));
$total_approved = $ere_property->get_total_my_properties('publish');
$post_status_pending = remove_query_arg(array('new_id', 'edit_id'), add_query_arg(array('post_status' => 'pending'), $my_properties_page_link));
$total_pending = $ere_property->get_total_my_properties('pending');
$post_status_expired = remove_query_arg(array('new_id', 'edit_id'), add_query_arg(array('post_status' => 'expired'), $my_properties_page_link));
$total_expired = $ere_property->get_total_my_properties('expired');

$post_status_hidden = remove_query_arg(array('new_id', 'edit_id'), add_query_arg(array('post_status' => 'hidden'), $my_properties_page_link));
$total_hidden = $ere_property->get_total_my_properties('hidden');
$width = 340;
$height = 250;
$no_image_src = ERE_PLUGIN_URL . 'public/assets/images/no-image.jpg';
$default_image = ere_get_option('default_property_image', '');
if ($default_image != '') {
    if (is_array($default_image) && $default_image['url'] != '') {
        $resize = ere_image_resize_url($default_image['url'], $width, $height, true);
        if ($resize != null && is_array($resize)) {
            $no_image_src = $resize['url'];
        }
    }
}
$paid_submission_type = ere_get_option('paid_submission_type', 'no');
$ere_profile = new ERE_Profile();
global $current_user;
wp_get_current_user();
$user_id = $current_user->ID;
?>
<div class="row ere-user-dashboard">
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ere-dashboard-sidebar">
        <?php ere_get_template('global/dashboard-menu.php', array('cur_menu' => 'my_properties')); ?>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 ere-dashboard-content">
        <div class="panel panel-default ere-my-properties">
            <div class="panel-heading"><?php esc_html_e('My Properties', 'benaa'); ?></div>
            <div class="panel-body">
                <form method="get" action="<?php echo get_page_link(); ?>" class="ere-my-properties-search">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="sr-only"
                                       for="property_status"><?php esc_html_e('Property Status', 'benaa'); ?></label>
                                <select name="property_status" id="property_status" class="form-control"
                                        title="<?php esc_html_e('Property Status', 'benaa') ?>">
                                    <?php ere_get_property_status_search_slug($property_status); ?>
                                    <option
                                        value="" <?php if (empty($property_status)) echo esc_attr('selected'); ?>>
                                        <?php esc_html_e('All Status', 'benaa') ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="sr-only"
                                       for="property_identity"><?php esc_html_e('Property ID', 'benaa'); ?></label>
                                <input type="text" name="property_identity" id="property_identity"
                                       value="<?php echo esc_attr($property_identity); ?>"
                                       class="form-control"
                                       placeholder="<?php esc_html_e('Property ID', 'benaa'); ?>">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="sr-only"
                                       for="title"><?php esc_html_e('Title', 'benaa'); ?></label>
                                <input type="text" name="title" id="title"
                                       value="<?php echo esc_attr($title); ?>"
                                       class="form-control"
                                       placeholder="<?php esc_html_e('Title', 'benaa'); ?>">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <?php
                                if (!empty($_REQUEST['post_status'])):
                                    $post_status = sanitize_title($_REQUEST['post_status']); ?>
                                    <input type="hidden" name="post_status"
                                           value="<?php echo esc_attr($post_status); ?>"/>
                                <?php endif; ?>
                                <input type="submit" id="search_property" class="btn btn-default display-block"
                                       value="<?php esc_html_e('Search', 'benaa'); ?>">
                            </div>
                        </div>
                    </div>
                </form>
                <ul class="ere-my-properties-filter">
                    <li class="ere-status-all<?php if (is_array($post_status)) echo ' active' ?>"><a
                            href="<?php echo esc_url($my_properties_page_link); ?>"><?php printf(esc_html('All (%s)', 'benaa'), $total_properties); ?></a>
                    </li>
                    <li class="ere-status-publish<?php if ($post_status == 'publish') echo ' active' ?>"><a
                            href="<?php echo esc_url($post_status_approved); ?>">
                            <?php printf(esc_html('Approved (%s)', 'benaa'), $total_approved); ?></a>
                    </li>
                    <li class="ere-status-pending<?php if ($post_status == 'pending') echo ' active' ?>"><a
                            href="<?php echo esc_url($post_status_pending); ?>">
                            <?php printf(esc_html('Pending (%s)', 'benaa'), $total_pending); ?></a>
                    </li>
                    <li class="ere-status-expired<?php if ($post_status == 'expired') echo ' active' ?>"><a
                            href="<?php echo esc_url($post_status_expired); ?>">
                            <?php printf(esc_html('Expired (%s)', 'benaa'), $total_expired); ?></a>
                    </li>
                    <li class="ere-status-hidden<?php if ($post_status == 'hidden') echo ' active' ?>"><a
                            href="<?php echo esc_url($post_status_hidden); ?>">
                            <?php printf(esc_html('Hidden (%s)', 'benaa'), $total_hidden); ?></a>
                    </li>
                </ul>
                <?php if (!$properties) : ?>
                    <div><?php esc_html_e('You don\'t have any properties listed.', 'benaa'); ?></div>
                <?php else : ?>
                    <?php foreach ($properties as $property) : ?>
                        <div class="ere-post-container">
                            <div class="ere-post-thumb">
                                <span class="ere-property-status ere-<?php echo $property->post_status; ?>">
                                    <?php
                                    switch ($property->post_status) {
                                        case 'publish':
                                            esc_html_e('Published', 'benaa');
                                            break;
                                        case 'expired':
                                            esc_html_e('Expired', 'benaa');
                                            break;
                                        case 'pending':
                                            esc_html_e('Pending', 'benaa');
                                            break;
                                        case 'hidden':
                                            esc_html_e('Hidden', 'benaa');
                                            break;
                                        default:
                                            echo $property->post_status;
                                    }?>
                                </span>
                                <?php
								$property_meta_data = get_post_custom($property->ID);

                                $prop_featured = get_post_meta($property->ID, ERE_METABOX_PREFIX . 'property_featured', true);
								$property_types = get_the_terms($property->ID, 'property-type');
								$property_item_status = get_the_terms($property->ID, 'property-status');

								$price = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_price']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_price'][0] : '';
								$price_short = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_price_short']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_price_short'][0] : '';
								$price_unit = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_price_unit']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_price_unit'][0] : '';
								$price_prefix = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_price_prefix']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_price_prefix'][0] : '';
								$price_postfix = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_price_postfix']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_price_postfix'][0] : '';

								$property_size = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_size']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_size'][0] : '';
								$property_bedrooms = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_bedrooms']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_bedrooms'][0] : '0';
								$property_bathrooms = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_bathrooms']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_bathrooms'][0] : '0';
								$property_garages = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_garage']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_garage'][0] : '0';
								
                                if ($prop_featured == 1):?>
                                    <span class="ere-property-featured"><?php esc_html_e('Featured', 'benaa') ?></span>
                                <?php endif;
                                $attach_id = get_post_thumbnail_id($property);
                                $image_src = ere_image_resize_id($attach_id, $width, $height, true);
                                if ($property->post_status == 'publish') : ?>
                                    <a target="_blank" title="<?php echo $property->post_title; ?>"
                                       href="<?php echo get_permalink($property->ID); ?>">
                                        <img width="<?php echo esc_attr($width) ?>"
                                             height="<?php echo esc_attr($height) ?>"
                                             src="<?php echo esc_url($image_src) ?>"
                                             onerror="this.src = '<?php echo esc_url($no_image_src) ?>';"
                                             alt="<?php echo $property->post_title; ?>"
                                             title="<?php echo $property->post_title; ?>">
                                    </a>
                                <?php else : ?>
                                    <img width="<?php echo esc_attr($width) ?>"
                                         height="<?php echo esc_attr($height) ?>"
                                         src="<?php echo esc_url($image_src) ?>"
                                         onerror="this.src = '<?php echo esc_url($no_image_src) ?>';"
                                         alt="<?php echo $property->post_title; ?>"
                                         title="<?php echo $property->post_title; ?>">
                                <?php endif; ?>
								<ul class="ere-dashboard-actions">
									<?php
									$actions = array();
									$payment_status = get_post_meta($property->ID, ERE_METABOX_PREFIX . 'payment_status', true);
									switch ($property->post_status) {
										case 'publish' :
											$prop_featured = get_post_meta($property->ID, ERE_METABOX_PREFIX . 'property_featured', true);
											if ($paid_submission_type == 'per_package') {
												$current_package_key = get_the_author_meta(ERE_METABOX_PREFIX . 'package_key', $user_id);
												$property_package_key = get_post_meta($property->ID, ERE_METABOX_PREFIX . 'package_key', true);
					
												$check_package = $ere_profile->user_package_available($user_id);
												if (!empty($property_package_key) && $current_package_key == $property_package_key) {
													if ($check_package != -1 && $check_package != 0) {
														$actions['edit'] = array('label' =>esc_html('Edit', 'benaa'), 'tooltip' =>esc_html('Edit property', 'benaa'), 'nonce' => false, 'confirm' => '');
													}
													$package_num_featured_listings = get_the_author_meta(ERE_METABOX_PREFIX . 'package_number_featured', $user_id);
													if ($package_num_featured_listings > 0 && ($prop_featured != 1) && ($check_package != -1) && ($check_package != 0)) {
														$actions['mark_featured'] = array('label' =>esc_html('Mark featured', 'benaa'), 'tooltip' =>esc_html('Make this a Featured Property', 'benaa'), 'nonce' => true, 'confirm' => esc_html__('Are you sure you want to mark this property as Featured?', 'benaa'));
													}
												} elseif ($current_package_key != $property_package_key && $check_package == 1) {
													$actions['allow_edit'] = array('label' =>esc_html('Allow Editing', 'benaa'), 'tooltip' =>esc_html('This property listing belongs to an expired Package therefore if you wish to edit it, it will be charged as a new listing from your current Package.', 'benaa'), 'nonce' => true, 'confirm' => esc_html__('Are you sure you want to allow editing this property listing?', 'benaa'));
												}
											} else {
												if ($paid_submission_type != 'no' && $prop_featured != 1) {
													$actions['mark_featured'] = array('label' =>esc_html('Mark featured', 'benaa'), 'tooltip' =>esc_html('Make this a Featured Property', 'benaa'), 'nonce' => true, 'confirm' => esc_html__('Are you sure you want to mark this property as Featured?', 'benaa'));
												}
												$actions['edit'] = array('label' =>esc_html('Edit', 'benaa'), 'tooltip' =>esc_html('Edit Property', 'benaa'), 'nonce' => false, 'confirm' => '');
											}
				
											break;
										case 'expired' :
											if ($paid_submission_type == 'per_package') {
												$check_package = $ere_profile->user_package_available($user_id);
												if ($check_package == 1) {
													$actions['relist_per_package'] = array('label' =>esc_html('Reactivate Listing', 'benaa'), 'tooltip' =>esc_html('Reactivate Listing', 'benaa'), 'nonce' => true, 'confirm' => esc_html__('Are you sure you want to reactivate this property?', 'benaa'));
												}
											}
											if ($paid_submission_type == 'per_listing' && $payment_status == 'paid') {
												$price_per_listing = ere_get_option('price_per_listing', 0);
												if ($price_per_listing <= 0 || $payment_status == 'paid') {
													$actions['relist_per_listing'] = array('label' =>esc_html('Resend this Listing for Approval', 'benaa'), 'tooltip' =>esc_html('Resend this Listing for Approval', 'benaa'), 'nonce' => true, 'confirm' => esc_html__('Are you sure you want to resend this property for approval?', 'benaa'));
												}
											}
											break;
										case 'pending' :
											$actions['edit'] = array('label' =>esc_html('Edit', 'benaa'), 'tooltip' =>esc_html('Edit Property', 'benaa'), 'nonce' => false, 'confirm' => '');
											break;
										case 'hidden' :
											$actions['show'] = array('label' =>esc_html('Show', 'benaa'), 'tooltip' =>esc_html('Show Property', 'benaa'), 'nonce' => true, 'confirm' => esc_html__('Are you sure you want to show this property?', 'benaa'));
											break;
									}
									$actions['delete'] = array('label' =>esc_html('Delete', 'benaa'), 'tooltip' =>esc_html('Delete Property', 'benaa'), 'nonce' => true, 'confirm' => esc_html__('Are you sure you want to delete this property?', 'benaa'));
									if ($property->post_status == 'publish') {
										$actions['hidden'] = array('label' =>esc_html('Hide', 'benaa'), 'tooltip' =>esc_html('Hide Property', 'benaa'), 'nonce' => true, 'confirm' => esc_html__('Are you sure you want to hide this property?', 'benaa'));
									}
		
									if ($paid_submission_type == 'per_listing' && $payment_status != 'paid' && $property->post_status != 'hidden') {
										$price_per_listing = ere_get_option('price_per_listing', 0);
										if ($price_per_listing > 0) {
											$actions['payment_listing'] = array('label' =>esc_html('Pay Now', 'benaa'), 'tooltip' =>esc_html('Pay for this property listing', 'benaa'), 'nonce' => true, 'confirm' => esc_html__('Are you sure you want to pay for this listing?', 'benaa'));
										}
									}
		
									$actions = apply_filters('ere_my_properties_actions', $actions, $property);
									foreach ($actions as $action => $value) {
										$my_properties_page_link = ere_get_permalink('my_properties');
										$action_url = add_query_arg(array('action' => $action, 'property_id' => $property->ID), $my_properties_page_link);
										if ($value['nonce']) {
											$action_url = wp_nonce_url($action_url, 'ere_my_properties_actions');
										}
										?>
										<li>
											<a <?php if (!empty($value['confirm'])): ?> onclick="return confirm('<?php echo esc_html($value['confirm']); ?>')" <?php endif; ?>
													href="<?php echo esc_url($action_url); ?>"
													data-toggle="tooltip"
													data-placement="bottom"
													title="<?php echo esc_html($value['tooltip']); ?>"
													class="btn-action ere-dashboard-action-<?php echo esc_attr($action); ?>"><?php echo esc_html($value['label']); ?></a>
										</li>
										<?php
									}
									?>
								</ul>
                            </div>
                            <div class="ere-post-content">
								<?php if ($property_types): ?>
									<div class="property-type">
										<?php foreach ($property_types as $type): ?>
											<a href="<?php echo esc_url(get_term_link($type->slug, 'property-type')); ?>"
											   title="<?php echo esc_attr($type->name); ?>"><span><?php echo esc_attr($type->name); ?> </span></a>
										<?php endforeach; ?>
									</div>
								<?php endif; ?>
                                <?php if ($property->post_status == 'publish') : ?>
                                    <h4 class="ere-post-title">
                                        <a target="_blank" title="<?php echo $property->post_title; ?>"
                                           href="<?php echo get_permalink($property->ID); ?>"><?php echo $property->post_title; ?></a>
                                    </h4>
                                <?php else : ?>
                                    <h4 class="ere-post-title"><?php echo $property->post_title; ?></h4>
                                <?php endif; ?>
                                <span class="ere-my-property-address"><i class="fa fa-map-marker accent-color"></i>
                                    <?php echo get_post_meta($property->ID, ERE_METABOX_PREFIX . 'property_address', true); ?>
                                    </span>
                                <span class="ere-my-property-total-views"><i class="fa fa-eye accent-color"></i>
                                    <?php
                                    $total_views = $ere_property->get_total_views($property->ID);
                                    printf(_n('%s view', '%s views', $total_views, 'benaa'), ere_get_format_number($total_views));
                                    ?>
                                </span>
                                <span class="ere-my-property-date"><i class="fa fa-calendar accent-color"></i>
                                <?php echo date_i18n(get_option('date_format'), strtotime($property->post_date)); ?>
                                </span>
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
										</div>
									<?php elseif (ere_get_option('empty_price_text', '') != ''): ?>
										<div class="property-price">
											<span><?php echo ere_get_option('empty_price_text', '') ?></span>
										</div>
									<?php endif; ?>
								</div>
                                <?php
                                $listing_expire = ere_get_option('per_listing_expire_days');
                                if ($paid_submission_type == 'per_listing' && $listing_expire == 1) :
                                    $number_expire_days = ere_get_option('number_expire_days');
                                    $property_date = $property->post_date;
                                    $timestamp = strtotime($property_date) + intval($number_expire_days) * 24 * 60 * 60;
                                    $expired_date = date('Y-m-d H:i:s', $timestamp);
                                    $expired_date = new DateTime($expired_date);

                                    $now = new DateTime();
                                    $interval = $now->diff($expired_date);
                                    $days = $interval->days;
                                    $hours = $interval->h;
                                    $invert = $interval->invert;

                                    if ($invert == 0) {
                                        if ($days > 0) {
                                            echo '<span class="ere-my-property-date-expire badge">' . sprintf(esc_html('Expire: %s days %s hours', 'benaa'), $days, $hours) . '</span>';
                                        } else {
                                            echo '<span class="ere-my-property-date-expire badge">' . sprintf(esc_html('Expire: %s hours', 'benaa'), $hours) . '</span>';
                                        }
                                    } else {
                                        $expired_date = date_i18n(get_option('date_format'), $timestamp);
                                        echo '<span class="ere-my-property-date-expire badge badge-expired">' . sprintf(esc_html('Expired: %s', 'benaa'), $expired_date) . '</span>';
                                    }
                                endif;?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php ere_get_template('global/pagination.php', array('max_num_pages' => $max_num_pages)); ?>
            </div>
        </div>
    </div>
</div>
