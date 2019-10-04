<?php
return array(
    'base' => 'g5plus_heading',
    'name' => esc_html__('Heading','benaa-framework'),
    'icon' => 'fa fa-header',
    'category' => GF_SHORTCODE_CATEGORY,
    'params' =>array_merge(
        array(
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Layout Style', 'benaa-framework'),
                'param_name' => 'layout_style',
                'admin_label' => true,
                'value' => array(
                    esc_html__('House top', 'benaa-framework') => 'style1',
                    esc_html__('Inline', 'benaa-framework') => 'style2',
                ),
                'std' => 'style1',
                'description' => esc_html__('Select Layout Style.', 'benaa-framework')
            ),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Title', 'benaa-framework'),
				'param_name' => 'title',
				'value' => '',
				'admin_label' => true,
			),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Sub Title', 'benaa-framework'),
                'param_name' => 'sub_title',
                'value' => '',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Text Align', 'benaa-framework' ),
                'param_name' => 'text_align',
                'description' => esc_html__('Select heading alignment.', 'benaa-framework' ),
                'value' => array(
                    esc_html__('Left', 'benaa-framework' ) => 'text-left',
                    esc_html__('Center', 'benaa-framework' ) => 'text-center',
                    esc_html__('Right', 'benaa-framework' ) => 'text-right',
                ),
                'admin_label' => true,
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'layout_style', 'value' => 'style1' )
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Text Color', 'benaa-framework'),
                'param_name' => 'text_color',
                'admin_label' => true,
                'value' => array(
                    esc_html__('Dark', 'benaa-framework') => 'color-dark',
                    esc_html__('Light', 'benaa-framework') => 'color-light'
                ),
                'std' => 'color-dark',
                'description' => esc_html__('Select Color Scheme.', 'benaa-framework'),
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),
            gf_vc_map_add_extra_class(),
			gf_vc_map_add_css_editor()
        ),
        gf_vc_map_animation()
    )
);
