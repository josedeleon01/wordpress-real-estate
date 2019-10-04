<?php
$dependency_add_icon = array(
    'element' => 'add_icon',
    'value' => 'true',
);
return array(
    'base' => 'g5plus_button',
    'name' => esc_html__('Button','benaa-framework'),
    'icon' => 'fa fa-bold',
    'category' =>  GF_SHORTCODE_CATEGORY,
    'description' => esc_html__('Eye catching button', 'benaa-framework' ),
    'params' =>array_merge(
        array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Text', 'benaa-framework' ),
                'param_name' => 'title',
                'value' => esc_html__('Text on the button', 'benaa-framework' ),
                'admin_label' => true,
            ),
            array(
                'type' => 'vc_link',
                'heading' => esc_html__('URL (Link)', 'benaa-framework' ),
                'param_name' => 'link',
                'description' => esc_html__('Add link to button.', 'benaa-framework' ),
            ),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Style', 'benaa-framework' ),
				'description' => esc_html__('Select button display style.', 'benaa-framework' ),
				'param_name' => 'style',
				'value' => array(
					esc_html__('Classic', 'benaa-framework' ) => 'classic',
					esc_html__('Outline', 'benaa-framework' ) => 'outline',
				),
				'std' => '',
				'admin_label' => true,
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Shape', 'benaa-framework' ),
				'param_name' => 'shape',
				'description' => esc_html__('Select button shape.', 'benaa-framework' ),
				'value' => array(
					esc_html__('Square', 'benaa-framework' ) => 'shape-square',
					esc_html__('Rounded', 'benaa-framework' ) => 'shape-rounded',
					esc_html__('Round', 'benaa-framework' ) => 'shape-round',
				),
				'admin_label' => true,
			),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Color', 'benaa-framework' ),
                'param_name' => 'color',
                'description' => esc_html__('Select button color.', 'benaa-framework' ),
                'value' => array(
                    esc_html__('Primary', 'benaa-framework' ) => 'primary',
                    esc_html__('Gray', 'benaa-framework' ) => 'gray',
                    esc_html__('Dark', 'benaa-framework' ) => 'dark',
                    esc_html__('White', 'benaa-framework' ) => 'white',
                ),
                'std' => 'primary',
                'admin_label' => true,
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Size', 'benaa-framework' ),
                'param_name' => 'size',
                'description' => esc_html__('Select button display size.', 'benaa-framework' ),
                'std' => 'lg',
                'value' => array(
                    esc_html__('Mini','benaa-framework') => 'xs', // 34px
                    esc_html__('Small','benaa-framework') => 'sm', // 40px
                    esc_html__('Normal','benaa-framework') => 'md', // 42px
                    esc_html__('Large','benaa-framework') => 'lg', // 44px
                ),
                'admin_label' => true,
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Alignment', 'benaa-framework' ),
                'param_name' => 'align',
                'description' => esc_html__('Select button alignment.', 'benaa-framework' ),
                'value' => array(
                    esc_html__('Inline', 'benaa-framework' ) => 'inline',
                    esc_html__('Left', 'benaa-framework' ) => 'left',
                    esc_html__('Right', 'benaa-framework' ) => 'right',
                    esc_html__('Center', 'benaa-framework' ) => 'center',
                ),
                'admin_label' => true,
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__('Set full width button?', 'benaa-framework' ),
                'param_name' => 'button_block',
                'dependency' => array(
                    'element' => 'align',
                    'value_not_equal_to' => 'inline',
                ),
                'admin_label' => true,
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__('Add icon?', 'benaa-framework' ),
                'param_name' => 'add_icon',
                'admin_label' => true,
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Icon Alignment', 'benaa-framework' ),
                'description' => esc_html__('Select icon alignment.', 'benaa-framework' ),
                'param_name' => 'icon_align',
                'value' => array(
                    esc_html__('Left', 'benaa-framework' ) => 'left',
                    esc_html__('Right', 'benaa-framework' ) => 'right',
                ),
                'dependency' => $dependency_add_icon,
            ),
            gf_vc_map_add_icon_font($dependency_add_icon),
            gf_vc_map_add_extra_class(),
            gf_vc_map_add_css_editor()
        ),
        gf_vc_map_animation()
    ),
);