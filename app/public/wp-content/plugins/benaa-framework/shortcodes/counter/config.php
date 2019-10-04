<?php
return array(
	'name' => esc_html__('Counter', 'benaa-framework'),
	'base' => 'g5plus_counter',
	'class' => '',
	'icon' => 'fa fa-tachometer',
	'category' => GF_SHORTCODE_CATEGORY,
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Title', 'benaa-framework'),
			'param_name' => 'title',
			'value' => '',
			'admin_label' => true,
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Icon library', 'benaa-framework'),
			'value' => array(
				esc_html__('none', 'benaa-framework') => '',
				esc_html__('Icon', 'benaa-framework') => 'icon',
				esc_html__('Image', 'benaa-framework') => 'image',
			),
			'param_name' => 'icon_type',
			'description' => esc_html__('Select icon library.', 'benaa-framework'),
		),
		gf_vc_map_add_icon_font(),
		gf_vc_map_add_icon_image(),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Start', 'benaa-framework'),
			'param_name' => 'start',
			'value' => '',
			'std'=> '0',
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('End', 'benaa-framework'),
			'param_name' => 'end',
			'value' => '',
			'std'=> '1000',
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Decimals', 'benaa-framework'),
			'param_name' => 'decimals',
			'value' => '',
			'std'=> '0',
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Duration', 'benaa-framework'),
			'param_name' => 'duration',
			'value' => '',
			'std'=> '2,5',
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Separator', 'benaa-framework'),
			'param_name' => 'separator',
			'value' => '',
			'std'=> ',',
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Decimal', 'benaa-framework'),
			'param_name' => 'decimal',
			'value' => '',
			'std'=> '.',
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Prefix', 'benaa-framework'),
			'param_name' => 'prefix',
			'value' => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Suffix', 'benaa-framework'),
			'param_name' => 'suffix',
			'value' => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Color Scheme', 'benaa-framework'),
			'param_name' => 'color_scheme',
			'admin_label' => true,
			'value' => array(
				esc_html__('Dark', 'benaa-framework') => 'color-dark',
				esc_html__('Light', 'benaa-framework') => 'color-light'
			),
			'std' => 'color-dark',
			'description' => esc_html__('Select Color Scheme.', 'benaa-framework')
		),
		gf_vc_map_add_extra_class(),
		gf_vc_map_add_css_editor()
	)
);