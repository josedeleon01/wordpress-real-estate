<?php
return array(
	'name' => esc_html__('Space', 'benaa-framework'),
	'base' => 'g5plus_space',
	'class' => '',
	'icon' => 'fa fa-arrows-v',
	'category' => GF_SHORTCODE_CATEGORY,
	'description' => esc_html__('Blank Space', 'benaa-framework'),
	'params' => array(
		array(
			'type' => 'number',
			'class' => '',
			'heading' => __('<i class="fa fa-desktop"></i> Desktop', 'benaa-framework'),
			'description' => esc_html__('Browser Width >= 1200px', 'benaa-framework'),
			'param_name' => 'desktop',
			'admin_label' => true,
			'value' => 90,
			'min' => 1,
			'max' => 500,
			'suffix' => 'px',
			'description' => esc_html__('Enter value in pixels', 'benaa-framework'),
		),
		array(
			'type' => 'number',
			'class' => '',
			'heading' => __('<i class="fa fa-tablet" style="transform: rotate(90deg);"></i> Tablet', 'benaa-framework'),
			'description' => esc_html__('Browser Width >= 992px and < 1200px', 'benaa-framework'),
			'param_name' => 'tablet',
			'admin_label' => true,
			'value' => 70,
			'min' => 1,
			'max' => 500,
			'suffix' => 'px',
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
		array(
			'type' => 'number',
			'class' => '',
			'heading' => __('<i class="fa fa-tablet"></i> Tablet Portrait', 'benaa-framework'),
			'description' => esc_html__('Browser Width >= 768px and < 991px', 'benaa-framework'),
			'param_name' => 'tablet_portrait',
			'admin_label' => true,
			'value' => 60,
			'min' => 1,
			'max' => 500,
			'suffix' => 'px',
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
		array(
			'type' => 'number',
			'class' => '',
			'heading' => __('<i class="fa fa-mobile" style="transform: rotate(90deg);"></i> Mobile Landscape', 'benaa-framework'),
			'description' => esc_html__('Browser Width >= 480px and < 767px', 'benaa-framework'),
			'param_name' => 'mobile_landscape',
			'admin_label' => true,
			'value' => 50,
			'min' => 1,
			'max' => 500,
			'suffix' => 'px',
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
		array(
			'type' => 'number',
			'class' => '',
			'heading' => __('<i class="fa fa-mobile"></i> Mobile', 'benaa-framework'),
			'description' => esc_html__('Browser Width < 480px', 'benaa-framework'),
			'param_name' => 'mobile',
			'admin_label' => true,
			'value' => 40,
			'min' => 1,
			'max' => 500,
			'suffix' => 'px',
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		)
	)
);