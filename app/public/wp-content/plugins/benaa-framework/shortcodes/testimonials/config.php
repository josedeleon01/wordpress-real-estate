<?php
/**
 * Created by PhpStorm.
 * User: Kaga
 * Date: 15/9/2016
 * Time: 10:52 AM
 */
return array(
	'name' => esc_html__( 'Testimonials', 'benaa-framework' ),
	'base' => 'g5plus_testimonials',
	'icon' => 'fa fa-user',
	'category' => GF_SHORTCODE_CATEGORY,
	'params' =>array_merge(
		array(
			array(
				'type' => 'param_group',
				'heading' => esc_html__( 'Testimonials', 'benaa-framework' ),
				'param_name' => 'values',
				'value' => urlencode( json_encode( array(
					array(
						'label' => esc_html__( 'Author', 'benaa-framework' ),
						'value' => '',
					),
				) ) ),
				'params' => array(
					array(
						'type' => 'attach_image',
						'heading' => esc_html__('Avatar:', 'benaa-framework'),
						'param_name' => 'avatar',
						'value' => '',
						'description' => esc_html__('Choose the author picture.', 'benaa-framework'),
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__('Author Name', 'benaa-framework'),
						'param_name' => 'author',
						'admin_label' => true,
						'description' => esc_html__('Enter Author information.', 'benaa-framework'),
					),
					array(
						'type' => 'textarea',
						'heading' => esc_html__('Quote from author', 'benaa-framework'),
						'param_name' => 'quote',
						'value' => ''
					),
				),
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
			array(
				'type' => 'checkbox',
				'heading' => esc_html__('Show navigation control', 'benaa-framework'),
				'param_name' => 'nav',
				'edit_field_class' => 'vc_col-sm-6 vc_column'
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__('Show pagination control', 'benaa-framework'),
				'param_name' => 'dots',
				'std' => 'true',
				'edit_field_class' => 'vc_col-sm-6 vc_column'
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__('Auto play', 'benaa-framework'),
				'param_name' => 'autoplay',
				'std' => 'true',
				'edit_field_class' => 'vc_col-sm-6 vc_column'
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Autoplay speed', 'benaa-framework'),
				'param_name' => 'autoplayspeed',
				'description' => esc_html__('Autoplay speed.', 'benaa-framework'),
				'value' => '',
				'std' => 5000,
				'dependency' => array('element' => 'autoplay', 'value' => 'true'),
				'edit_field_class' => 'vc_col-sm-6 vc_column'
			),
			gf_vc_map_add_extra_class(),
			gf_vc_map_add_css_editor()
		),
		gf_vc_map_animation()
	)
);
