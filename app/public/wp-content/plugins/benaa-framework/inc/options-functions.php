<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 3/18/2016
 * Time: 11:36 AM
 */

/**
 * Get Page Layout
 */
if (!function_exists('gf_get_page_layout_option')) {
    function gf_get_page_layout_option($default = false)
    {
        return apply_filters('gf_page_layout', array(
            'full'      => esc_html__('Full Width', 'benaa-framework'),
            'container' => esc_html__('Container', 'benaa-framework'),
            'container-fluid' => esc_html__('Container Fluid', 'benaa-framework')

        ));
    }
}

//////////////////////////////////////////////////////////////////
// Get Sidebar Layout
//////////////////////////////////////////////////////////////////
if (!function_exists('gf_get_sidebar_layout')) {
    function gf_get_sidebar_layout()
    {
        return apply_filters('gf_sidebar_layout', array(
            'none'  => GF_PLUGIN_URL . 'assets/images/theme-options/sidebar-none.png',
            'left'  => GF_PLUGIN_URL . 'assets/images/theme-options/sidebar-left.png',
            'right' => GF_PLUGIN_URL . 'assets/images/theme-options/sidebar-right.png',
        ));
    }
}

//////////////////////////////////////////////////////////////////
// Get Sidebar Width
//////////////////////////////////////////////////////////////////
if (!function_exists('gf_get_sidebar_width')) {
    function gf_get_sidebar_width($default = false)
    {
        $result = apply_filters('gf_sidebar_width', array(
            'small' => esc_html__('Small (1/4)', 'benaa-framework'),
            'large' => esc_html__('Large (1/3)', 'benaa-framework')
        ));

        if ($default) {
            $result = array(-1 => esc_html__('Default', 'benaa-framework')) + $result;
        }

        return $result;


    }
}
//////////////////////////////////////////////////////////////////
// Get Layout Styles
//////////////////////////////////////////////////////////////////
if (!function_exists('gf_get_layout_style')) {
    function gf_get_layout_style()
    {
        return apply_filters('gf_layout_style', array(
            'wide'  => GF_PLUGIN_URL . 'assets/images/theme-options/layout-wide.png',
            'boxed' => GF_PLUGIN_URL . 'assets/images/theme-options/layout-boxed.png'
        ));
    }
}

//////////////////////////////////////////////////////////////////
// Get Post Layout
//////////////////////////////////////////////////////////////////
if (!function_exists('gf_get_post_layout')) {
    function gf_get_post_layout()
    {
        return apply_filters('gf_post_layout', array(
            'large-image'  => esc_html__('Large Image', 'benaa-framework'),
            'grid'      => esc_html__('Grid', 'benaa-framework'),
            'masonry'      => esc_html__('Masonry', 'benaa-framework'),
        ));
    }
}

//////////////////////////////////////////////////////////////////
// Get Post Columns
//////////////////////////////////////////////////////////////////
if (!function_exists('gf_get_post_columns')) {
    function gf_get_post_columns()
    {
        return apply_filters('gf_post_columns', array(
            2 => '2',
            3 => '3'
        ));
    }
}

//////////////////////////////////////////////////////////////////
// Get Post Paging
//////////////////////////////////////////////////////////////////
if (!function_exists('gf_get_paging_style')) {
    function gf_get_paging_style()
    {
        return apply_filters('gf_paging_style', array(
            'navigation'      => esc_html__('Navigation', 'benaa-framework'),
            'load-more'       => esc_html__('Load More', 'benaa-framework'),
            'infinite-scroll' => esc_html__('Infinite Scroll', 'benaa-framework')
        ));
    }
}

//////////////////////////////////////////////////////////////////
// Get Toggle
//////////////////////////////////////////////////////////////////
if (!function_exists('gf_get_toggle')) {
    function gf_get_toggle($default = false)
    {
        $result = array(
            1 => esc_html__('On', 'benaa-framework'),
            0 => esc_html__('Off', 'benaa-framework')

        );
        if ($default) {
            $result = array(-1 => esc_html__('Default', 'benaa-framework')) + $result;
        }

        return $result;
    }
}

//==============================================================================
// Get list social profiles
//==============================================================================
if (!function_exists('gf_get_social_profiles')) {
    function gf_get_social_profiles()
    {
        return apply_filters('gf_get_social_profiles', array(
            array(
                'id'        => 'twitter_url',
                'type'      => 'text',
                'title'     => esc_html__('Twitter', 'benaa-framework'),
                'subtitle'  => esc_html__('Your Twitter', 'benaa-framework'),
                'default'   => '',
                'icon'      => 'fa fa-twitter',
                'link-type' => 'link',
            ),
            array(
                'id'        => 'facebook_url',
                'type'      => 'text',
                'title'     => esc_html__('Facebook', 'benaa-framework'),
                'subtitle'  => esc_html__('Your facebook page/profile url', 'benaa-framework'),
                'default'   => '',
                'icon'      => 'fa fa-facebook',
                'link-type' => 'link',
            ),
            array(
                'id'        => 'dribbble_url',
                'type'      => 'text',
                'title'     => esc_html__('Dribbble', 'benaa-framework'),
                'subtitle'  => esc_html__('Your Dribbble', 'benaa-framework'),
                'default'   => '',
                'icon'      => 'fa fa-dribbble',
                'link-type' => 'link',
            ),
            array(
                'id'        => 'vimeo_url',
                'type'      => 'text',
                'title'     => esc_html__('Vimeo', 'benaa-framework'),
                'subtitle'  => esc_html__('Your Vimeo', 'benaa-framework'),
                'default'   => '',
                'icon'      => 'fa fa-vimeo',
                'link-type' => 'link',
            ),
            array(
                'id'        => 'tumblr_url',
                'type'      => 'text',
                'title'     => esc_html__('Tumblr', 'benaa-framework'),
                'subtitle'  => esc_html__('Your Tumblr', 'benaa-framework'),
                'default'   => '',
                'icon'      => 'fa fa-tumblr',
                'link-type' => 'link',
            ),
            array(
                'id'        => 'skype_username',
                'type'      => 'text',
                'title'     => esc_html__('Skype', 'benaa-framework'),
                'subtitle'  => esc_html__('Your Skype username', 'benaa-framework'),
                'default'   => '',
                'icon'      => 'fa fa-skype',
                'link-type' => 'link',
            ),
            array(
                'id'        => 'linkedin_url',
                'type'      => 'text',
                'title'     => esc_html__('LinkedIn', 'benaa-framework'),
                'subtitle'  => esc_html__('Your LinkedIn page/profile url', 'benaa-framework'),
                'default'   => '',
                'icon'      => 'fa fa-linkedin',
                'link-type' => 'link',
            ),
            array(
                'id'        => 'googleplus_url',
                'type'      => 'text',
                'title'     => esc_html__('Google+', 'benaa-framework'),
                'subtitle'  => esc_html__('Your Google+ page/profile URL', 'benaa-framework'),
                'default'   => '',
                'icon'      => 'fa fa-google-plus',
                'link-type' => 'link',
            ),
            array(
                'id'        => 'flickr_url',
                'type'      => 'text',
                'title'     => esc_html__('Flickr', 'benaa-framework'),
                'subtitle'  => esc_html__('Your Flickr page url', 'benaa-framework'),
                'default'   => '',
                'icon'      => 'fa fa-flickr',
                'link-type' => 'link',
            ),
            array(
                'id'        => 'youtube_url',
                'type'      => 'text',
                'title'     => esc_html__('YouTube', 'benaa-framework'),
                'subtitle'  => esc_html__('Your YouTube URL', 'benaa-framework'),
                'default'   => '',
                'icon'      => 'fa fa-youtube',
                'link-type' => 'link',
            ),
            array(
                'id'        => 'pinterest_url',
                'type'      => 'text',
                'title'     => esc_html__('Pinterest', 'benaa-framework'),
                'subtitle'  => esc_html__('Your Pinterest', 'benaa-framework'),
                'default'   => '',
                'icon'      => 'fa fa-pinterest',
                'link-type' => 'link',
            ),
            array(
                'id'        => 'foursquare_url',
                'type'      => 'text',
                'title'     => esc_html__('Foursquare', 'benaa-framework'),
                'subtitle'  => esc_html__('Your Foursqaure URL', 'benaa-framework'),
                'default'   => '',
                'icon'      => 'fa fa-foursquare',
                'link-type' => 'link',
            ),
            array(
                'id'        => 'instagram_url',
                'type'      => 'text',
                'title'     => esc_html__('Instagram', 'benaa-framework'),
                'subtitle'  => esc_html__('Your Instagram', 'benaa-framework'),
                'default'   => '',
                'icon'      => 'fa fa-instagram',
                'link-type' => 'link',
            ),
            array(
                'id'        => 'github_url',
                'type'      => 'text',
                'title'     => esc_html__('GitHub', 'benaa-framework'),
                'subtitle'  => esc_html__('Your GitHub URL', 'benaa-framework'),
                'default'   => '',
                'icon'      => 'fa fa-github',
                'link-type' => 'link',
            ),
            array(
                'id'        => 'xing_url',
                'type'      => 'text',
                'title'     => esc_html__('Xing', 'benaa-framework'),
                'subtitle'  => esc_html__('Your Xing URL', 'benaa-framework'),
                'default'   => '',
                'icon'      => 'fa fa-xing',
                'link-type' => 'link',
            ),
            array(
                'id'        => 'behance_url',
                'type'      => 'text',
                'title'     => esc_html__('Behance', 'benaa-framework'),
                'subtitle'  => esc_html__('Your Behance URL', 'benaa-framework'),
                'default'   => '',
                'icon'      => 'fa fa-behance',
                'link-type' => 'link',
            ),
            array(
                'id'        => 'deviantart_url',
                'type'      => 'text',
                'title'     => esc_html__('Deviantart', 'benaa-framework'),
                'subtitle'  => esc_html__('Your Deviantart URL', 'benaa-framework'),
                'default'   => '',
                'icon'      => 'fa fa-deviantart',
                'link-type' => 'link',
            ),
            array(
                'id'        => 'soundcloud_url',
                'type'      => 'text',
                'title'     => esc_html__('SoundCloud', 'benaa-framework'),
                'subtitle'  => esc_html__('Your SoundCloud URL', 'benaa-framework'),
                'default'   => '',
                'icon'      => 'fa fa-soundcloud',
                'link-type' => 'link',
            ),
            array(
                'id'        => 'yelp_url',
                'type'      => 'text',
                'title'     => esc_html__('Yelp', 'benaa-framework'),
                'subtitle'  => esc_html__('Your Yelp URL', 'benaa-framework'),
                'default'   => '',
                'icon'      => 'fa fa-yelp',
                'link-type' => 'link',
            ),
            array(
                'id'        => 'rss_url',
                'type'      => 'text',
                'title'     => esc_html__('RSS Feed', 'benaa-framework'),
                'subtitle'  => esc_html__('Your RSS Feed URL', 'benaa-framework'),
                'default'   => '',
                'icon'      => 'fa fa-rss',
                'link-type' => 'link',
            ),
            array(
                'id'        => 'vk_url',
                'type'      => 'text',
                'title'     => esc_html__('VK', 'benaa-framework'),
                'subtitle'  => esc_html__('Your VK URL', 'benaa-framework'),
                'default'   => '',
                'icon'      => 'fa fa-vk',
                'link-type' => 'link',
            ),
            array(
                'id'        => 'email_address',
                'type'      => 'text',
                'title'     => esc_html__('Email address', 'benaa-framework'),
                'subtitle'  => esc_html__('Your email address', 'benaa-framework'),
                'default'   => '',
                'icon'      => 'fa fa-envelope',
                'link-type' => 'email',
            ),
        ));
    }
}


//////////////////////////////////////////////////////////////////
// Get Search Type
//////////////////////////////////////////////////////////////////
if (!function_exists('gf_get_search_type')) {
    function gf_get_search_type()
    {
        return apply_filters('gf_search_type', array(
            'button'           => esc_html__('Button', 'benaa-framework'),
            'box'              => esc_html__('Box', 'benaa-framework'),
        ));
    }
}


/**
 * Get search ajax post type
 * *******************************************************
 */
if (!function_exists('gf_get_search_ajax_popup_post_type')) {
    function gf_get_search_ajax_popup_post_type() {
        $output = array(
            'post'      => esc_html__('Post','benaa-framework'),
            'page'      => esc_html__('Page','benaa-framework'),
        );
        return apply_filters('gf_get_search_popup_ajax_post_type',$output);
    }
}


/**
 * Get maintenance mode
 * *******************************************************
 */
if (!function_exists('gf_get_maintenance_mode')) {
    function gf_get_maintenance_mode() {
        return apply_filters('gf_maintenance_mode',array(
            '2' => esc_html__('On (Custom Page)', 'benaa-framework'),
            '1' => esc_html__('On (Standard)', 'benaa-framework'),
            '0' => esc_html__('Off', 'benaa-framework')
        ));
    }
}


/**
 * Get Loading Animation
 * *******************************************************
 */
if (!function_exists('gf_get_loading_animation')) {
    function gf_get_loading_animation(){
        return apply_filters('gf_loading_animation', array(
            'chasing-dots'  => esc_html__('Chasing Dots', 'benaa-framework'),
            'circle'        => esc_html__('Circle', 'benaa-framework'),
            'cube'          => esc_html__('Cube', 'benaa-framework'),
            'double-bounce' => esc_html__('Double Bounce', 'benaa-framework'),
            'fading-circle' => esc_html__('Fading Circle', 'benaa-framework'),
            'folding-cube'  => esc_html__('Folding Cube', 'benaa-framework'),
            'pulse'         => esc_html__('Pulse', 'benaa-framework'),
            'three-bounce'  => esc_html__('Three Bounce', 'benaa-framework'),
            'wave'          => esc_html__('Wave', 'benaa-framework'),
        ));
    }
}

/**
 * Get Setting Custom Post type
 * *******************************************************
 */
if (!function_exists('gf_get_custom_post_type_setting')) {
    function gf_get_custom_post_type_setting() {
        $settings = array(
            'blog' => array(
                'title' => esc_html__('Blog','benaa-framework'),
            ),
            'single_blog' => array(
                'title' => esc_html__('Single Blog','benaa-framework'),
                'is_single' => true,
                'post_type' => 'post'
            ),
        );
        $post_type_preset = apply_filters('gf_post_type_preset', array());
        foreach ($post_type_preset as $key => $value) {
            if($key=='property')
            {
                $settings = array_merge( $settings, array(
                    $key            => array(
                        'title'      => esc_html__( 'List Properties', 'benaa-framework' ),
                        'is_archive' => true,
                        'post_type'  => $key
                    ),
                    "single_{$key}" => array(
                        'title'     => esc_html__( 'Single Property', 'benaa-framework' ),
                        'is_single' => true,
                        'post_type' => $key
                    ),
                ) );
            }
            elseif($key=='agent')
            {
                $settings = array_merge( $settings, array(
                    $key            => array(
                        'title'      => esc_html__( 'List Agents', 'benaa-framework' ),
                        'is_archive' => true,
                        'post_type'  => $key
                    ),
                    "single_{$key}" => array(
                        'title'     => esc_html__( 'Single Agent', 'benaa-framework' ),
                        'is_single' => true,
                        'post_type' => $key
                    ),
                ) );
            }
            elseif($key=='invoice')
            {
                $settings = array_merge( $settings, array(
                    "single_{$key}" => array(
                        'title'     => esc_html__( 'Invoice ', 'benaa-framework' ),
                        'is_single' => true,
                        'post_type' => $key
                    ),
                ) );
            }
            else
            {
                $settings = array_merge( $settings, array(
                    $key            => array(
                        'title'      => esc_html__( 'List ', 'benaa-framework' ) . $value['name'],
                        'is_archive' => true,
                        'post_type'  => $key
                    ),
                    "single_{$key}" => array(
                        'title'     => esc_html__( 'Single ', 'benaa-framework' ) . $value['name'],
                        'is_single' => true,
                        'post_type' => $key
                    ),
                ) );
            }
        }
        return apply_filters('gf_custom_post_type_setting',$settings);
    }
}


/**
 * Get Top Drawer Mode
 * *******************************************************
 */
if (!function_exists('gf_get_top_drawer_mode')) {
    function gf_get_top_drawer_mode() {
        return apply_filters('gf_top_drawer_mode',array(
            'hide' => esc_html__('Hide', 'benaa-framework'),
            'toggle' => esc_html__('Toggle', 'benaa-framework'),
            'show' => esc_html__('Show', 'benaa-framework')
        ));
    }
}


/**
 * Get Top Bar Layout
 * *******************************************************
 */
if (!function_exists('gf_get_top_bar_layout')) {
    function gf_get_top_bar_layout() {
        return apply_filters('gf_top_bar_layout',array(
            'top-bar-1' => GF_PLUGIN_URL . 'assets/images/theme-options/top-bar-layout-1.jpg',
            'top-bar-2' => GF_PLUGIN_URL . 'assets/images/theme-options/top-bar-layout-2.jpg',
            'top-bar-3' => GF_PLUGIN_URL . 'assets/images/theme-options/top-bar-layout-3.jpg',
            'top-bar-4' => GF_PLUGIN_URL . 'assets/images/theme-options/top-bar-layout-4.jpg',
        ));
    }
}

/**
 * Get Border Layout
 * *******************************************************
 */
if (!function_exists('gf_get_border_layout')) {
    function gf_get_border_layout(){
        return apply_filters('gf_border_layout',array(
            'none' => esc_html__('None', 'benaa-framework'),
            'full' => esc_html__('Full', 'benaa-framework'),
            'container' => esc_html__('Container', 'benaa-framework')
        ));
    }
}

//////////////////////////////////////////////////////////////////
// Get Sidebar mobile Enable
//////////////////////////////////////////////////////////////////
if (!function_exists('gf_get_sidebar_mobile_enable')) {
    function gf_get_sidebar_mobile_enable( $id, $required = array(), $default = 1 ) {
        return array(
            'id'       => $id,
            'type'     => 'button_set',
            'title'    => esc_html__( 'Sidebar Mobile', 'benaa-framework' ),
            'subtitle' => esc_html__( 'Turn Off this option if you want to disable sidebar on mobile', 'benaa-framework' ),
            'desc'     => '',
            'options'  => gf_get_toggle(),
            'default'  => $default,
            'required' => $required,
        );
    }
}

//////////////////////////////////////////////////////////////////
// Get Sidebar mobile Canvas
//////////////////////////////////////////////////////////////////
if (!function_exists('gf_get_sidebar_mobile_canvas')) {
    function gf_get_sidebar_mobile_canvas( $id, $required = array(), $default = 1 ) {
        return array(
            'id'       => $id,
            'type'     => 'button_set',
            'title'    => esc_html__( 'Canvas Sidebar Mobile', 'benaa-framework' ),
            'subtitle' => esc_html__( 'Turn Off this option if you want to disable canvas sidebar on mobile', 'benaa-framework' ),
            'desc'     => '',
            'options'  => gf_get_toggle(),
            'default'  => $default,
            'required' => $required,
        );
    }
}

//////////////////////////////////////////////////////////////////
// Get Content Padding
//////////////////////////////////////////////////////////////////
if (!function_exists('gf_get_content_padding')) {
    function gf_get_content_padding( $id, $required = array(), $default = 1 ) {
        return array(
            'id' => $id,
            'title' => esc_html__('Content Padding', 'benaa-framework'),
            'subtitle' => esc_html__('Top/Bottom Padding', 'benaa-framework'),
            'type' => 'spacing',
            'left'     => false,
            'right'    => false,
            'default'  => $default,
            'required' => $required
        );
    }
}

//////////////////////////////////////////////////////////////////
// Get Mobile Content Padding
//////////////////////////////////////////////////////////////////
if (!function_exists('gf_get_mobile_content_padding')) {
    function gf_get_mobile_content_padding( $id, $required = array(), $default = 1 ) {
        return array(
            'id' => $id,
            'title' => esc_html__('Content Padding Mobile', 'benaa-framework'),
            'subtitle' => esc_html__('Top/Bottom Padding', 'benaa-framework'),
            'type' => 'spacing',
            'left'     => false,
            'right'    => false,
            'default'  => $default,
            'required' => $required
        );
    }
}