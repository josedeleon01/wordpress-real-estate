<?php
return array(
	'name' => esc_html__('Google Map', 'benaa-framework'),
	'base' => 'g5plus_goole_map',
	'icon' => 'fa fa-map-marker',
	'category' => GF_SHORTCODE_CATEGORY,
	'params' =>array_merge(
		array(
			array(
				'type' => 'param_group',
				'heading' => esc_html__( 'Markers', 'benaa-framework' ),
				'param_name' => 'markers',
				'value' => urlencode( json_encode( array(
					array(
						'label' => esc_html__( 'Title', 'benaa-framework' ),
						'value' => '',
					),
				) ) ),
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__('Latitude ', 'benaa-framework'),
						'param_name' => 'lat',
						'value' => '',
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__('Longitude ', 'benaa-framework'),
						'param_name' => 'lng',
						'value' => '',
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__('Title', 'benaa-framework'),
						'param_name' => 'title',
						'admin_label' => true,
						'value' => '',
					),
					array(
						'type' => 'textarea',
						'heading' => esc_html__('Description', 'benaa-framework'),
						'param_name' => 'description',
						'value' => ''
					),
					array(
						'type' => 'attach_image',
						'heading' => esc_html__( 'Marker Icon', 'benaa-framework' ),
						'param_name' => 'icon',
						'value' => '',
						'description' => esc_html__( 'Select an image from media library.', 'benaa-framework' ),
					),
					array(
						'type' => 'textfield',
						'param_name' => 'property_id',
						'value' => '',
						'description' => esc_html__( 'Property Id', 'benaa-framework' ),
					),
				),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('API Key', 'benaa-framework'),
				'param_name' => 'api_key',
				'std' => 'AIzaSyAwey_47Cen4qJOjwHQ_sK1igwKPd74J18',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Map height (px or %)', 'benaa-framework'),
				'param_name' => 'map_height',
				'edit_field_class' => 'vc_col-sm-6',
				'std' => '540px',
			),
			gf_vc_map_add_extra_class(),
			gf_vc_map_add_css_editor()
		),
		gf_vc_map_animation()
	)
);