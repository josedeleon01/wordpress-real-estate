<?php
return array(
	'base' => 'g5plus_blog',
	'name' => esc_html__('Blog','benaa-framework'),
	'icon' => 'fa fa-file-text',
	'category' => GF_SHORTCODE_CATEGORY,
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Layout', 'benaa-framework'),
			'param_name' => 'layout',
			'value' => array(
				esc_html__('Large Image','benaa-framework') => 'large-image',
				esc_html__('Grid','benaa-framework') => 'grid',
				esc_html__('Masonry', 'benaa-framework' ) => 'masonry',
				esc_html__('Carousel', 'benaa-framework' ) => 'carousel',
			),
			'admin_label' => true,
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Columns', 'benaa-framework'),
			'param_name' => 'columns',
			'value' => array('2' => 2 , '3' => 3),
			'dependency' => array('element' => 'layout', 'value' => array('masonry','grid') ),
		),

		array(
			'type' => 'number',
			'heading' => esc_html__('Number of posts', 'benaa-framework' ),
			'description' => esc_html__('Enter number of posts to display.', 'benaa-framework' ),
			'param_name' => 'max_items',
			'value' => -1,
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Post Paging', 'benaa-framework'),
			'param_name' => 'post_paging',
			'value' => array(
				esc_html__('Show all', 'benaa-framework') => 'all',
				esc_html__('Navigation', 'benaa-framework') => 'navigation',
				esc_html__('Load More', 'benaa-framework') => 'load-more',
				esc_html__('Infinite Scroll', 'benaa-framework') => 'infinite-scroll',
			),
			'std' => 'all',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'dependency' => array('element' => 'max_items','value' => '-1'),
		),

		array(
			"type" => "number",
			"heading" => esc_html__("Posts per page", 'benaa-framework'),
			"param_name" => "posts_per_page",
			"value" => get_option('posts_per_page'),
			"description" => esc_html__('Number of items to show per page', 'benaa-framework'),
			'dependency' => array('element' => 'post_paging','value' => array('navigation', 'load-more', 'infinite-scroll')),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Order by', 'benaa-framework'),
			'param_name' => 'orderby',
			'value' => array(
				esc_html__('Date', 'benaa-framework') => 'date',
				esc_html__('Order by post ID', 'benaa-framework') => 'ID',
				esc_html__('Author', 'benaa-framework') => 'author',
				esc_html__('Title', 'benaa-framework') => 'title',
				esc_html__('Last modified date', 'benaa-framework') => 'modified',
				esc_html__('Post/page parent ID', 'benaa-framework') => 'parent',
				esc_html__('Number of comments', 'benaa-framework') => 'comment_count',
				esc_html__('Menu order/Page Order', 'benaa-framework') => 'menu_order',
				esc_html__('Meta value', 'benaa-framework') => 'meta_value',
				esc_html__('Meta value number', 'benaa-framework') => 'meta_value_num',
				esc_html__('Random order', 'benaa-framework') => 'rand',
			),
			'description' => esc_html__('Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'benaa-framework'),
			'group' => esc_html__('Data Settings', 'benaa-framework'),
			'param_holder_class' => 'vc_grid-data-type-not-ids',
		),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Sorting', 'benaa-framework'),
			'param_name' => 'order',
			'group' => esc_html__('Data Settings', 'benaa-framework'),
			'value' => array(
				esc_html__('Descending', 'benaa-framework') => 'DESC',
				esc_html__('Ascending', 'benaa-framework') => 'ASC',
			),
			'param_holder_class' => 'vc_grid-data-type-not-ids',
			'description' => esc_html__('Select sorting order.', 'benaa-framework'),
		),

		array(
			'type' => 'textfield',
			'heading' => esc_html__('Meta key', 'benaa-framework'),
			'param_name' => 'meta_key',
			'description' => esc_html__('Input meta key for grid ordering.', 'benaa-framework'),
			'group' => esc_html__('Data Settings', 'benaa-framework'),
			'param_holder_class' => 'vc_grid-data-type-not-ids',
			'dependency' => array(
				'element' => 'orderby',
				'value' => array('meta_value', 'meta_value_num'),
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Columns Gap', 'benaa-framework'),
			'param_name' => 'columns_gap',
			'value' => array(
				'30px' => 'col-gap-30',
				'20px' => 'col-gap-20',
				'10px' => 'col-gap-10',
				'0px' => 'col-gap-0'
			),
			'std' => 'col-gap-30',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'dependency' => array('element' => 'layout', 'value' => 'carousel'),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Show pagination control', 'benaa-framework'),
			'param_name' => 'dots',
			'dependency' => array('element' => 'layout', 'value' => 'carousel'),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Show navigation control', 'benaa-framework'),
			'param_name' => 'nav',
			'dependency' => array('element' => 'layout', 'value' => 'carousel'),
			'std' => 'true',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Navigation Position', 'benaa-framework'),
			'param_name' => 'nav_position',
			'value' => array(
				esc_html__('Center','benaa-framework') => 'center',
				esc_html__('Top Right','benaa-framework') => 'top-right',
			),
			'std' => 'top-right',
			'dependency' => array('element' => 'layout', 'value' => 'carousel'),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Auto play', 'benaa-framework'),
			'param_name' => 'autoplay',
			'dependency' => array('element' => 'layout', 'value' => 'carousel'),
			'std' => 'true',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Autoplay Timeout', 'benaa-framework'),
			'param_name' => 'autoplaytimeout',
			'description' => esc_html__('Autoplay interval timeout.', 'benaa-framework'),
			'value' => '',
			'std' => 5000,
			'dependency' => array('element' => 'autoplay', 'value' => 'carousel'),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Items Desktop', 'benaa-framework'),
			'param_name' => 'items_lg',
			'description' => esc_html__('Browser Width > 1199', 'benaa-framework'),
			'value' => array(
				'1' => '',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',
			),
			'std' => '3',
			'group'=> 'Reponsive',
			'dependency' => array('element' => 'layout', 'value' => 'carousel')
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Items Desktop Small', 'benaa-framework'),
			'param_name' => 'items_md',
			'description' => esc_html__('Browser Width < 1199', 'benaa-framework'),
			'value' => array(
				'1' => '',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',
			),
			'std' => '3',
			'group'=> 'Reponsive',
			'dependency' => array('element' => 'layout', 'value' => 'carousel')
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Items Tablet', 'benaa-framework'),
			'param_name' => 'items_sm',
			'description' => esc_html__('Browser Width < 992', 'benaa-framework'),
			'value' => array(
				'1' => '',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',
			),
			'std' => '3',
			'group'=> 'Reponsive',
			'dependency' => array('element' => 'layout', 'value' => 'carousel')
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Items Tablet Small', 'benaa-framework'),
			'param_name' => 'items_xs',
			'description' => esc_html__('Browser Width < 768', 'benaa-framework'),
			'value' => array(
				'1' => '',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',
			),
			'std' => '2',
			'group'=> 'Reponsive',
			'dependency' => array('element' => 'layout', 'value' => 'carousel')
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Items Mobile', 'benaa-framework'),
			'param_name' => 'items_mb',
			'description' => esc_html__('Browser Width < 480', 'benaa-framework'),
			'value' => array(
				'1' => '',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',
			),
			'std' => '1',
			'group'=> 'Reponsive',
			'dependency' => array('element' => 'layout', 'value' => 'carousel')
		),
		gf_vc_map_add_narrow_category(),
		gf_vc_map_add_extra_class()
	)
);