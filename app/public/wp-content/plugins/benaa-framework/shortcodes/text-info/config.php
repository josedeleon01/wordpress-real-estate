<?php
/**
 * Created by PhpStorm.
 * User: Kaga
 * Date: 15/9/2016
 * Time: 10:52 AM
 */
return array(
	'name' => esc_html__( 'Text Info', 'benaa-framework' ),
	'base' => 'g5plus_text_info',
	'icon' => 'fa fa-th-list',
	'category' => GF_SHORTCODE_CATEGORY,
	'params' =>array_merge(
		array(
			array(
				'type' => 'param_group',
				'heading' => esc_html__( 'Text Info', 'benaa-framework' ),
				'param_name' => 'values',
				'value' => urlencode( json_encode( array(
					array(
						'label' => esc_html__( 'Key', 'benaa-framework' ),
						'value' => '',
					),
				) ) ),
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__('Key', 'benaa-framework'),
						'param_name' => 'key',
						'admin_label' => true,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__('Value', 'benaa-framework'),
						'param_name' => 'value',
						'value' => ''
					),
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Columns', 'benaa-framework'),
				'param_name' => 'column',
				'admin_label' => true,
				'value' => array(
					esc_html__('1', 'benaa-framework') => 'text-info-1-column',
					esc_html__('2', 'benaa-framework') => 'text-info-2-column'
				),
				'std' => 'color-dark',
				'description' => esc_html__('Select Color Scheme.', 'benaa-framework')
			),
			gf_vc_map_add_extra_class(),
			gf_vc_map_add_css_editor()
		),
		gf_vc_map_animation()
	)
);
