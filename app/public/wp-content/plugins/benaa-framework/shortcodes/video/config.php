<?php
return array(
	'name'     => esc_html__('Video', 'benaa-framework'),
	'base'     => 'g5plus_video',
	'class'    => '',
	'icon'     => 'fa fa-play-circle',
	'category' => GF_SHORTCODE_CATEGORY,
	'params'   =>
		array_merge(
			array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Link', 'benaa-framework' ),
					'param_name' => 'link',
					'value' => '',
					'description' => esc_html__( 'Enter link video', 'benaa-framework' ),
				),
				gf_vc_map_add_extra_class(),
				gf_vc_map_add_css_editor()
			),
			gf_vc_map_animation()
	)
);