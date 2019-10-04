<?php
return array(
	'base'     => 'g5plus_icon_box',
	'name'     => esc_html__('Icon Box', 'benaa-framework'),
	'icon'     => 'fa fa-diamond',
	'category' => GF_SHORTCODE_CATEGORY,
	'params'   => array_merge(
		array(
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__('Layout Style', 'benaa-framework'),
				'param_name'       => 'layout_style',
				'admin_label'      => true,
				'value'            => array(
					esc_html__('Center', 'benaa-framework') => 'layout-center',
					esc_html__('Left', 'benaa-framework')   => 'layout-left',
					esc_html__('Right', 'benaa-framework')  => 'layout-right',
				),
				'std'              => 'layout-center',
				'description'      => esc_html__('Select Layout Style.', 'benaa-framework'),
				'edit_field_class' => 'vc_col-sm-6 vc_column'
			),
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__('Background shape', 'benaa-framework'),
				'param_name'       => 'background_shape',
				'admin_label'      => true,
				'value'            => array(
					esc_html__('Circle', 'benaa-framework')   => 'shape-circle',
					esc_html__('Outline Circle', 'benaa-framework') => 'shape-outline-circle',
					esc_html__('Bacground white - Outline Circle', 'benaa-framework')  => 'shape-bg-white-outline-circle',
				),
				'std'              => 'layout-center',
				'description'      => esc_html__('Select background shape and style for icon.', 'benaa-framework'),
				'edit_field_class' => 'vc_col-sm-6 vc_column'
			),
			gf_vc_map_add_icon_type(),
			gf_vc_map_add_icon_font(),
			gf_vc_map_add_icon_image(),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Title', 'benaa-framework'),
				'param_name'  => 'title',
				'value'       => '',
			),
			array(
				'type'        => 'textarea',
				'heading'     => esc_html__('Description', 'benaa-framework'),
				'param_name'  => 'description',
				'value'       => '',
				'description' => esc_html__('Provide the description for this element.', 'benaa-framework'),
			),
			
			array(
				'type'       => 'vc_link',
				'heading'    => esc_html__('Link (url)', 'benaa-framework'),
				'param_name' => 'link',
				'value'      => '',
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__('Text Color', 'benaa-framework'),
				'param_name'  => 'color_scheme',
				'value'       => array(
					esc_html__('Dark', 'benaa-framework')  => 'color-dark',
					esc_html__('Light', 'benaa-framework') => 'color-light'
				),
				'std'         => 'color-dark',
				'description' => esc_html__('Select Color Scheme.', 'benaa-framework')
			),
			gf_vc_map_add_extra_class(),
			gf_vc_map_add_css_editor()
		),
		gf_vc_map_animation()
	)
);