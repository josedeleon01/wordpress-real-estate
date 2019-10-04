<?php
/**
 * Register Sidebar
 * *******************************************************
 */
if (!function_exists('g5plus_register_sidebar')) {
    function g5plus_register_sidebar()
    {
        $sidebars = array(
            array(
                'id'          => 'main-sidebar',
                'name'        => esc_html__('Main Sidebar', 'benaa'),
                'description' => esc_html__('Add widgets here to appear in your sidebar', 'benaa'),
            ),
	        array(
		        'name'          => esc_html__("Top Drawer",'benaa'),
		        'id'            => 'top_drawer_sidebar',
		        'description'   => esc_html__("Top Drawer",'benaa'),
	        ),
	        array(
		        'name'          => esc_html__("Top Bar Left",'benaa'),
		        'id'            => 'top_bar_left',
		        'description'   => esc_html__("Top Bar Left",'benaa'),
	        ),
	        array(
		        'name'          => esc_html__("Top Bar Right",'benaa'),
		        'id'            => 'top_bar_right',
		        'description'   => esc_html__("Top Bar Right",'benaa'),
	        ),
	        array(
		        'name'          => esc_html__("Footer 1",'benaa'),
		        'id'            => 'footer-1',
		        'description'   => esc_html__("Footer 1",'benaa'),
	        ),
	        array(
		        'name'          => esc_html__("Footer 2",'benaa'),
		        'id'            => 'footer-2',
		        'description'   => esc_html__("Footer 2",'benaa'),
	        ),
	        array(
		        'name'          => esc_html__("Footer 3",'benaa'),
		        'id'            => 'footer-3',
		        'description'   => esc_html__("Footer 3",'benaa'),
	        ),
	        array(
		        'name'          => esc_html__("Footer 4",'benaa'),
		        'id'            => 'footer-4',
		        'description'   => esc_html__("Footer 4",'benaa'),
	        ),
	        array(
		        'name'          => esc_html__("Bottom Bar Left",'benaa'),
		        'id'            => 'bottom_bar_left',
		        'description'   => esc_html__("Bottom Bar Left",'benaa'),
	        ),
	        array(
		        'name'          => esc_html__("Bottom Bar Right",'benaa'),
		        'id'            => 'bottom_bar_right',
		        'description'   => esc_html__("Bottom Bar Right",'benaa'),
	        ),
	        array(
		        'name'          => esc_html__("Canvas Menu",'benaa'),
		        'id'            => 'canvas-menu',
		        'description'   => esc_html__("Canvas Menu Widget Area",'benaa'),
	        ),
        );
        foreach ($sidebars as $sidebar) {
            register_sidebar(array(
                'name'          => $sidebar['name'],
                'id'            => $sidebar['id'],
                'description'   => $sidebar['description'],
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h4 class="widget-title"><span>',
                'after_title'   => '</span></h4>',
            ));
        }
    }

    add_action('widgets_init', 'g5plus_register_sidebar');
}