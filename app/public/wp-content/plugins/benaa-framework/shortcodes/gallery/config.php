<?php
return array(
    'name' => esc_html__('Gallery', 'benaa-framework'),
    'base' => 'g5plus_gallery',
    'class' => '',
    'icon' => 'vc_general vc_element-icon icon-wpb-images-stack',
    'category' => GF_SHORTCODE_CATEGORY,
    'params' =>
        array_merge(
            array(
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Layout style', 'benaa-framework'),
                    'param_name' => 'layout_style',
                    'std' => 'gallery-grid',
                    'value' => array(
                        esc_html__('Grid', 'benaa-framework') => 'gallery-grid',
                        esc_html__('Masonry', 'benaa-framework') => 'gallery-masonry',
                        esc_html__('Carousel', 'benaa-framework') => 'gallery-carousel',
                    )
                ), array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Hover effect', 'benaa-framework'),
                    'param_name' => 'hover_effect',
                    'std' => 'default-effect',
                    'value' => array(
                        esc_html__('Default', 'benaa-framework') => 'default-effect',
                        esc_html__('Layla', 'benaa-framework') => 'layla-effect',
                        esc_html__('Bubba', 'benaa-framework') => 'bubba-effect',
                        esc_html__('Jazz', 'benaa-framework') => 'jazz-effect',
                    )
                ),
                array(
                    'type' => 'attach_images',
                    'heading' => esc_html__('Images', 'benaa-framework'),
                    'param_name' => 'images',
                    'value' => '',
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Columns', 'benaa-framework'),
                    'param_name' => 'columns',
                    'value' => array('2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6),
                    'std' => 3,
                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                ),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__('Show pagination control', 'benaa-framework'),
					'param_name' => 'dots',
					'dependency' => array('element' => 'layout_style', 'value' => 'gallery-carousel'),
					'edit_field_class' => 'vc_col-sm-4 vc_column'
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__('Show navigation control', 'benaa-framework'),
					'param_name' => 'nav',
					'dependency' => array('element' => 'layout_style', 'value' => 'gallery-carousel'),
					'std' => 'true',
					'edit_field_class' => 'vc_col-sm-4 vc_column'
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__('Auto play', 'benaa-framework'),
					'param_name' => 'autoplay',
					'dependency' => array('element' => 'layout_style', 'value' => 'gallery-carousel'),
					'std' => 'true',
					'edit_field_class' => 'vc_col-sm-4 vc_column'
				),
            ),
            gf_vc_map_animation(),
            gf_vc_map_responsive(),
            array(
                gf_vc_map_add_extra_class(),
                gf_vc_map_add_css_editor()
            )
        )
);