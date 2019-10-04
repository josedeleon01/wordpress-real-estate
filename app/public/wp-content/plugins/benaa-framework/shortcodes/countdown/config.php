<?php
/**
 * Created by PhpStorm.
 * User: Kaga
 * Date: 20/5/2016
 * Time: 3:57 PM
 */
return array(
	'name' => esc_html__('Countdown', 'benaa-framework'),
	'base' => 'g5plus_countdown',
	'class' => '',
	'icon' => 'fa fa-clock-o',
	'category' => GF_SHORTCODE_CATEGORY,
	'params' => array_merge(
		array(
			array(
				'type' => 'datetimepicker',
				'heading' => esc_html__('Time Off', 'benaa-framework'),
				'param_name' => 'time',
				'admin_label' => true,
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Text Color', 'benaa-framework'),
				'param_name' => 'text_color',
				'admin_label' => true,
				'value' => array(
					esc_html__('Light', 'benaa-framework') => 'color-light',
					esc_html__('Dark', 'benaa-framework') => 'color-dark',),
				'description' => esc_html__('Select Color Scheme.', 'benaa-framework')
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Url Redirect', 'benaa-framework'),
				'param_name' => 'url_redirect',
				'value' => '',
			),
			gf_vc_map_add_extra_class(),
			gf_vc_map_add_css_editor()
		),
		gf_vc_map_animation()
	)
);