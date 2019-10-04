<?php
return array(
	'name'     => esc_html__('View Demo', 'benaa'),
	'base'     => 'g5plus_view_demo',
	'icon'     => 'fa fa-eye',
	'category' => GF_SHORTCODE_CATEGORY,
	'params'   => array_merge(
		array(
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__('Layout Style', 'benaa'),
				'param_name'  => 'layout_style',
				'value'       => array(
					esc_html__('Rectangle', 'benaa')     => 'view-demo-rectangle',
					esc_html__('Square', 'benaa') => 'view-demo-square',
				),
				'admin_label' => true,
			),
			array(
				'type'       => 'param_group',
				'heading'    => esc_html__('Demo Items', 'benaa'),
				'param_name' => 'demo_items',
				'params'     => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Title demo', 'benaa'),
						'param_name'  => 'title',
						'value'       => '',
						'admin_label' => true,
					),
					array(
						'type'        => 'attach_image',
						'heading'     => esc_html__('Images', 'benaa'),
						'param_name'  => 'image',
						'value'       => ''
					),
				
					array(
						'type' => 'checkbox',
						'heading' => esc_html__('Mark as Coming Soon', 'april-framework'),
						'param_name' => 'is_coming_soon',
						'std' => 'false',
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type' => 'vc_link',
						'heading' => esc_html__('URL (Link)', 'april-framework'),
						'param_name' => 'link',
						'dependency' => array('element' => 'is_coming_soon', 'value_not_equal_to' => 'true')
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__('Mark as New Item', 'april-framework'),
						'param_name' => 'is_new',
						'std' => '',
						'dependency' => array('element' => 'is_coming_soon', 'value_not_equal_to' => 'true'),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					)
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Large Devices', 'benaa'),
				'param_name' => 'items_lg',
				'description' => esc_html__('Browser Width >= 992px and < 1200px', 'benaa'),
				'value' => array(esc_html__('Default', 'benaa') => -1, '1' => 1, '2' => 2, '3' => 3),
				'std' => -1,
				'group' => esc_html__('Responsive', 'benaa')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Tablet landscape', 'benaa'),
				'param_name' => 'items_md',
				'description' => esc_html__('Browser Width >= 992px and < 1200px', 'benaa'),
				'value' => array(esc_html__('Default', 'benaa') => -1, '1' => 1, '2' => 2, '3' => 3),
				'std' => -1,
				'group' => esc_html__('Responsive', 'benaa')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Tablet portrait', 'benaa'),
				'param_name' => 'items_sm',
				'description' => esc_html__('Browser Width >= 768px and < 991px', 'benaa'),
				'value' => array(esc_html__('Default', 'benaa') => -1, '1' => 1, '2' => 2, '3' => 3),
				'std' => -1,
				'group' => esc_html__('Responsive', 'benaa')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Mobile landscape', 'benaa'),
				'param_name' => 'items_xs',
				'description' => esc_html__('Browser Width >= 480px and < 767px', 'benaa'),
				'value' => array(esc_html__('Default', 'benaa') => -1, '1' => 1, '2' => 2, '3' => 3),
				'std' => -1,
				'group' => esc_html__('Responsive', 'benaa')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Mobile portrait', 'benaa'),
				'param_name' => 'items_mb',
				'description' => esc_html__('Browser Width < 480px', 'benaa'),
				'value' => array(esc_html__('Default', 'benaa') => -1, '1' => 1, '2' => 2, '3' => 3),
				'std' => -1,
				'group' => esc_html__('Responsive', 'benaa')
			),
			gf_vc_map_add_extra_class(),
			gf_vc_map_add_css_editor()
		),
		gf_vc_map_animation()
	)
);
