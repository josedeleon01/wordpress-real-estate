<?php
/**
 * GET theme option value
 * *******************************************************
 */
if (!function_exists('g5plus_get_option')) {
    function g5plus_get_option($key, $default = '')
    {
        if (function_exists('gf_get_option')) {
            return gf_get_option($key, $default);
        }
        return $default;
    }
}

/**
 * GET Meta Box Value
 * *******************************************************
 */
if (!function_exists('g5plus_get_post_meta')) {
    function g5plus_get_post_meta($key, $post_id = null)
    {
        if (function_exists('gf_get_post_meta')) {
            return gf_get_post_meta($key, $post_id);
        }
        return '';
    }
}

/**
 * GET Meta Box Image Value
 * *******************************************************
 */
if (!function_exists('g5plus_get_post_meta_image')) {
    function g5plus_get_post_meta_image($key, $post_id = null)
    {
        if (function_exists('gf_get_post_meta_image')) {
            return gf_get_post_meta_image($key, $post_id);
        }
        return '';
    }
}

/**
 * GET Current Preset ID
 * *******************************************************
 */
if (!function_exists('g5plus_get_current_preset')) {
    function g5plus_get_current_preset() {
        if (function_exists('gf_get_current_preset')) {
            return gf_get_current_preset();
        }
        return 0;
    }
}

/**
 * Get Preset Dir
 * *******************************************************
 */
if (!function_exists('g5plus_get_preset_dir')) {
    function g5plus_get_preset_dir() {
        return G5PLUS_THEME_DIR . 'assets/preset/';
    }
}

/**
 * Get Preset Url
 * *******************************************************
 */
if (!function_exists('g5plus_get_preset_url')) {
    function g5plus_get_preset_url() {
        return G5PLUS_THEME_URL . 'assets/preset/';
    }
}

/**
 * GET Category Binder
 * *******************************************************
 */
if (!function_exists('g5plus_categories_binder')) {
    function g5plus_categories_binder($categories, $parent,$class= 'search-category-dropdown', $is_anchor = false, $show_count = false) {
        $index = 0;
        $output = '';
        $parent .= '';
        foreach ($categories as $key => $term) {
            $term->parent .= '';
            if (($term->parent !== $parent)) {
                continue;
            }
            if ($index == 0) {
                $output = '<ul>';
                if ($parent == 0) {
                    $output = '<ul class="'. esc_attr($class) .'">';
                }
            }

            $output .= '<li>';
            $output .= sprintf('%s%s%s',
                $is_anchor ? '<a href="' .  get_term_link((int)$term->term_id, 'product_cat') . '" title="' . esc_attr($term->name) . '">' : '<span data-id="' . esc_attr($term->term_id) . '">',
                $show_count ? esc_html($term->name.' (' . $term->count . ')') : esc_html($term->name),
                $is_anchor ? '</a>' : '</span>'
            );
            $output .= g5plus_categories_binder($categories, $term->term_id,$class, $is_anchor,$show_count);
            $output .= '</li>';
            $index++;
        }

        if (!empty($output)) {
            $output .= '</ul>';
        }

        return $output;
    }
}

/**
 * Get template
 * *******************************************************
 */
if (!function_exists('g5plus_get_template')) {
    function g5plus_get_template($slug, $args = array())
    {
        if ($args && is_array($args)) {
            extract($args);
        }
        $located = locate_template(array("templates/{$slug}.php"));

        if (!file_exists($located)) {
            _doing_it_wrong(__FUNCTION__, sprintf('<code>%s</code> does not exist.', $slug), '1.0');
            return;
        }
        include($located);
    }
}

////////////////////////////////////////////////////////////////////
// region Get breadcrumb items
if (!function_exists('g5plus_get_breadcrumb_items')) {
    function g5plus_get_breadcrumb_items() {
        global $wp_query;

        $item = array();
        /* Front page. */
        if (is_front_page()) {
            $item['last'] = esc_html__('Home', 'benaa' );
        }


        /* Link to front page. */
        if (!is_front_page()) {
            $item[] = '<li><a href="' . home_url('/') . '" class="home">' . esc_html__('Home', 'benaa' ) . '</a></li>';
        }

        /* If bbPress is installed and we're on a bbPress page. */
        if (function_exists('is_bbpress') && is_bbpress()) {
            $item = array_merge($item, g5plus_breadcrumb_get_bbpress_items());
        }
        elseif (is_home()) {
            $home_page = get_post($wp_query->get_queried_object_id());
            $item = array_merge($item, g5plus_breadcrumb_get_parents($home_page->post_parent));
            $item['last'] = get_the_title($home_page->ID);
        } /* If viewing a singular post. */
        elseif (is_singular()) {

            $post = $wp_query->get_queried_object();
            $post_id = (int)$wp_query->get_queried_object_id();
            $post_type = $post->post_type;

            $post_type_object = get_post_type_object($post_type);

            if ('post' === $wp_query->post->post_type) {
                $categories = get_the_category($post_id);
                $item = array_merge($item, g5plus_breadcrumb_get_term_parents($categories[0]->term_id, $categories[0]->taxonomy));
            }

            if ('page' !== $wp_query->post->post_type) {

                /* If there's an archive page, add it. */

                if (function_exists('get_post_type_archive_link') && !empty($post_type_object->has_archive))
                    $item[] = '<li><a href="' . get_post_type_archive_link($post_type) . '" title="' . esc_attr($post_type_object->labels->name) . '">' . $post_type_object->labels->name . '</a></li>';

                if (isset($args["singular_{$wp_query->post->post_type}_taxonomy"]) && is_taxonomy_hierarchical($args["singular_{$wp_query->post->post_type}_taxonomy"])) {
                    $terms = wp_get_object_terms($post_id, $args["singular_{$wp_query->post->post_type}_taxonomy"]);
                    $item = array_merge($item, g5plus_breadcrumb_get_term_parents($terms[0], $args["singular_{$wp_query->post->post_type}_taxonomy"]));
                } elseif (isset($args["singular_{$wp_query->post->post_type}_taxonomy"]))
                    $item[] = get_the_term_list($post_id, $args["singular_{$wp_query->post->post_type}_taxonomy"], '', ', ', '');
            }

            if ((is_post_type_hierarchical($wp_query->post->post_type) || 'attachment' === $wp_query->post->post_type) && $parents = g5plus_breadcrumb_get_parents($wp_query->post->post_parent)) {
                $item = array_merge($item, $parents);
            }

            $item['last'] = get_the_title();
        } /* If viewing any type of archive. */
        else if (is_archive()) {

            if (is_category() || is_tag() || is_tax()) {

                $term = $wp_query->get_queried_object();

                if ((is_taxonomy_hierarchical($term->taxonomy) && $term->parent) && $parents = g5plus_breadcrumb_get_term_parents($term->parent, $term->taxonomy))
                    $item = array_merge($item, $parents);

                $item['last'] = $term->name;
            } else if (function_exists('is_post_type_archive') && is_post_type_archive()) {
                $post_type_object = get_post_type_object(get_query_var('post_type'));
                if ($post_type_object) {
                    $item['last'] = $post_type_object->labels->name;
                }
            } else if (is_date()) {

                if (is_day())
                    $item['last'] = esc_html__('Archives for ', 'benaa' ) . get_the_time('F j, Y');

                elseif (is_month())
                    $item['last'] = esc_html__('Archives for ', 'benaa' ) . single_month_title(' ', false);

                elseif (is_year())
                    $item['last'] = esc_html__('Archives for ', 'benaa' ) . get_the_time('Y');
            } else if (is_author())
            {
                $current_author = $wp_query->get_queried_object();
                $item['last'] = esc_html__('Author: ', 'benaa' ) . get_the_author_meta('display_name', $current_author->ID);
            }


        } /* If viewing search results. */
        else if (is_search()) {
            $item['last'] = esc_html__('Search results', 'benaa');
        }


        /* If viewing a 404 error page. */
        else if (is_404())
            $item['last'] = esc_html__('Page Not Found', 'benaa' );


        if (isset($item['last'])) {
            $item['last'] = sprintf('<li><span>%s</span></li>', $item['last']);
        }


        return apply_filters('g5plus_framework_filter_breadcrumb_items', $item);
    }
}

if (!function_exists('g5plus_filter_breadcrumb_items')) {
    function g5plus_filter_breadcrumb_items()
    {
        $item = array();
        $shop_page_id = wc_get_page_id('shop');

        if (get_option('page_on_front') != $shop_page_id) {
            $shop_name = $shop_page_id ? get_the_title($shop_page_id) : '';
            if (!is_shop()) {
                $item[] = '<li><a href="' . get_permalink($shop_page_id) . '">' . $shop_name . '</a></li>';
            } else {
                $item['last'] = $shop_name;
            }
        }

        if (is_tax('product_cat') || is_tax('product_tag')) {
            $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

        } elseif (is_product()) {
            global $post;
            $terms = wc_get_product_terms($post->ID, 'product_cat', array('orderby' => 'parent', 'order' => 'DESC'));
            if ($terms) {
                $current_term = $terms[0];
            }

        }

        if (!empty($current_term)) {
            if (is_taxonomy_hierarchical($current_term->taxonomy)) {
                $item = array_merge($item, g5plus_breadcrumb_get_term_parents($current_term->parent, $current_term->taxonomy));
            }

            if (is_tax('product_cat') || is_tax('product_tag')) {
                $item['last'] = $current_term->name;
            } else {
                $item[] = '<li><a href="' . get_term_link($current_term->term_id, $current_term->taxonomy) . '">' . $current_term->name . '</a></li>';
            }
        }

        if (is_product()) {
            $item['last'] = get_the_title();
        }

        return apply_filters('g5plus_filter_breadcrumb_items', $item);
    }
}

if (!function_exists('g5plus_breadcrumb_get_bbpress_items')) {
    function g5plus_breadcrumb_get_bbpress_items()
    {
        $item = array();
        $shop_page_id = wc_get_page_id('shop');

        if (get_option('page_on_front') != $shop_page_id) {
            $shop_name = $shop_page_id ? get_the_title($shop_page_id) : '';
            if (!is_shop()) {
                $item[] = '<li><a href="' . get_permalink($shop_page_id) . '">' . $shop_name . '</a></li>';
            } else {
                $item['last'] = $shop_name;
            }
        }

        if (is_tax('product_cat') || is_tax('product_tag')) {
            $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

        } elseif (is_product()) {
            global $post;
            $terms = wc_get_product_terms($post->ID, 'product_cat', array('orderby' => 'parent', 'order' => 'DESC'));
            if ($terms) {
                $current_term = $terms[0];
            }

        }

        if (!empty($current_term)) {
            if (is_taxonomy_hierarchical($current_term->taxonomy)) {
                $item = array_merge($item, g5plus_breadcrumb_get_term_parents($current_term->parent, $current_term->taxonomy));
            }

            if (is_tax('product_cat') || is_tax('product_tag')) {
                $item['last'] = $current_term->name;
            } else {
                $item[] = '<li><a href="' . get_term_link($current_term->term_id, $current_term->taxonomy) . '">' . $current_term->name . '</a></li>';
            }
        }

        if (is_product()) {
            $item['last'] = get_the_title();
        }

        return apply_filters('g5plus_filter_breadcrumb_items', $item);
    }
}

if (!function_exists('g5plus_breadcrumb_get_parents')) {
    function g5plus_breadcrumb_get_parents($post_id = '', $separator = '/')
    {
        $parents = array();

        if ($post_id == 0) {
            return $parents;
        }

        while ($post_id) {
            $page = get_post($post_id);
            $parents[] = '<li><a href="' . get_permalink($post_id) . '" title="' . esc_attr(get_the_title($post_id)) . '">' . get_the_title($post_id) . '</a></li>';
            $post_id = $page->post_parent;
        }

        if ($parents) {
            $parents = array_reverse($parents);
        }

        return $parents;
    }
}

if (!function_exists('g5plus_breadcrumb_get_term_parents')) {
    function g5plus_breadcrumb_get_term_parents($parent_id = '', $taxonomy = '', $separator = '/')
    {
        $parents = array();

        if (empty($parent_id) || empty($taxonomy)) {
            return $parents;
        }

        while ($parent_id) {
            $parent = get_term($parent_id, $taxonomy);
            $parents[] = '<li><a href="' . get_term_link($parent, $taxonomy) . '" title="' . esc_attr($parent->name) . '">' . $parent->name . '</a></li>';
            $parent_id = $parent->parent;
        }

        if ($parents) {
            $parents = array_reverse($parents);
        }

        return $parents;
    }
}

// endregion
////////////////////////////////////////////////////////////////////


/**
 * Get image src
 */
if (!function_exists('g5plus_get_image_src')) {
    function g5plus_get_image_src($image_id,$size) {
        $image_src = '';
        $image_sizes = g5plus_get_image_size($size);
        if (isset($image_sizes)) {
            $width = $image_sizes['width'];
            $height = $image_sizes['height'];
            $image_src = matthewruddy_image_resize_id($image_id,$width,$height);
        }else {
            $image_src_arr = wp_get_attachment_image_src( $image_id, $size );
            if ($image_src_arr) {
                $image_src = $image_src_arr[0];
            }
        }
        return $image_src;
    }
}

/**
 * Get post thumbnail
 * *******************************************************
 */
if (!function_exists('g5plus_get_post_thumbnail')) {
    function g5plus_get_post_thumbnail( $size, $noImage = 0, $is_single = false )
    {
        $args = array(
            'size' => $size,
            'noImage'   => $noImage,
            'is_single' => $is_single
        );
        g5plus_get_template('archive/thumbnail',$args);
    }
}

/**
 * Get post image
 * *******************************************************
 */
if (!function_exists('g5plus_get_post_image')) {
    function g5plus_get_post_image($image_id, $size, $gallery = 0, $is_single = false)
    {
        $image_src = '';
        $image_size = g5plus_get_image_size($size);
        if (isset($image_size['width']) && isset($image_size['height'])) {
            $width = $image_size['width'];
            $height = $image_size['height'];
            $image_src = matthewruddy_image_resize_id($image_id,$width,$height);
        }else {
            $image_src_arr = wp_get_attachment_image_src( $image_id, $size );
            if ($image_src_arr) {
                $image_src = $image_src_arr[0];
            }
        }

        if (!empty($image_src)) {
            g5plus_get_image_hover($image_id, $image_src, $size, get_permalink(), the_title_attribute('echo=0'), $gallery, $is_single);
        }
    }
}

/**
 * Get image hover
 * *******************************************************
 */
if (!function_exists('g5plus_get_image_hover')) {
    function g5plus_get_image_hover($image_id, $image_src, $size, $link, $title, $gallery = 0, $is_single = false)
    {
        $image_full_arr = wp_get_attachment_image_src($image_id,'full');
        $image_full_src = $image_src;
        $image_thumb = wp_get_attachment_image_src($image_id);
        $image_thumb_link = '';
        if (sizeof($image_thumb) > 0) {
            $image_thumb_link = $image_thumb['0'];
        }
        if ($image_full_arr) {
            $image_full_src = $image_full_arr[0];
        }
        $width = '';
        $height = '';
        $image_size = g5plus_get_image_size($size);
        if (isset($image_size['width']) && $image_size['height']) {
            $width = $image_size['width'];
            $height = $image_size['height'];
        } else {
            $_wp_additional_image_sizes = get_intermediate_image_sizes();
            if ( in_array( $size, array( 'thumbnail', 'medium', 'large' ) ) ) {
                $width = get_option( $size . '_size_w' );
                $height = get_option( $size . '_size_h' );
            } elseif ( isset( $_wp_additional_image_sizes[ $size ] ) ) {
                $width = $_wp_additional_image_sizes[ $size ]['width'];
                $height = $_wp_additional_image_sizes[ $size ]['height'];
            }
        }
        $args = array(
            'image_src' => $image_src,
            'image_full_src' => $image_full_src,
            'image_thumb_link' => $image_thumb_link,
            'width' => $width,
            'height' => $height,
            'link'      => $link,
            'title'     => $title,
            'galleryId' => $gallery,
            'is_single' => $is_single
        );
        g5plus_get_template('archive/image-hover',$args);
    }
}

/**
 * Get image size
 * *******************************************************
 */
if (!function_exists('g5plus_get_image_size')) {
    function g5plus_get_image_size($size) {
        $image_sizes = apply_filters('g5plus_image_size',array(
            'large-image' => array(
                'width' => 1170,
                'height' => 415
            ),
            'medium-image' => array(
                'width' => 600,
                'height' => 600
            ),
            'small-image' => array(
                'width' => 170,
                'height' => 170
            ),
            'extra-small-image' => array(
                'width' => 110,
                'height' => 80
            )
        ));
        if(isset($image_sizes[$size])){
            return $image_sizes[$size];
        }else{
            return null;
        }
    }
}

/**
 * Get String Limit Words
 * *******************************************************
 */
if (!function_exists('g5plus_string_limit_words')) {
    function g5plus_string_limit_words($string, $word_limit)
    {
        $words = explode(' ', $string, ($word_limit + 1));

        if(count($words) > $word_limit) {
            array_pop($words);
        }

        return implode(' ', $words);
    }
}

/**
 * Render comments
 * *******************************************************
 */
if (!function_exists('g5plus_render_comments')) {
    function g5plus_render_comments($comment, $args, $depth) {
        g5plus_get_template('single/comment',array('comment' => $comment, 'args' => $args, 'depth' => $depth));
    }
}

/**
 * Get Tax meta with key not prefix
 * *******************************************************
 */
if ( !function_exists( 'g5plus_get_tax_meta') ) {
    function g5plus_get_tax_meta($term_id,$key,$multi = false) {
        if(defined('GF_METABOX_PREFIX')){
            if ( function_exists('get_term_meta')){
                return get_term_meta($term_id, GF_METABOX_PREFIX . $key, !$multi );
            }else{
                return get_tax_meta( $term_id, GF_METABOX_PREFIX . $key, !$multi  );
            }
        }else{
            return '';
        }

    }
}

//////////////////////////////////////////////////////////////////
// Get Page Layout Settings
//////////////////////////////////////////////////////////////////
if (!function_exists('g5plus_get_page_layout_settings')) {
    function &g5plus_get_page_layout_settings(){
        $key_page_layout_settings = 'g5plus_page_layout_settings';
        if (isset($GLOBALS[$key_page_layout_settings]) && is_array($GLOBALS[$key_page_layout_settings])) {
            return $GLOBALS[$key_page_layout_settings];
        }
        $GLOBALS[$key_page_layout_settings] = array(
            'layout'                 => g5plus_get_option( 'layout','container' ),
            'sidebar_layout'         => g5plus_get_option( 'sidebar_layout','right' ),
            'sidebar'                => g5plus_get_option( 'sidebar','main-sidebar' ),
            'sidebar_width'          => g5plus_get_option( 'sidebar_width','small' ),
            'sidebar_mobile_enable'  => g5plus_get_option( 'sidebar_mobile_enable',1 ),
            'sidebar_mobile_canvas'  => g5plus_get_option( 'sidebar_mobile_canvas',1 ),
            'padding'                => g5plus_get_option( 'content_padding',array('top' => '70', 'bottom' => '70') ),
            'padding_mobile'         => g5plus_get_option( 'content_padding_mobile',array('top' => '30', 'bottom' => '30') ),
            'remove_content_padding' => 0,
            'has_sidebar' => 1
        );
        return $GLOBALS[$key_page_layout_settings];
    }
}

//////////////////////////////////////////////////////////////////
// Get Post Layout Settings
//////////////////////////////////////////////////////////////////
if (!function_exists('g5plus_get_post_layout_settings')){
    function &g5plus_get_post_layout_settings(){
        $key_post_layout_settings = 'g5plus_post_layout_settings';
        if (isset($GLOBALS[$key_post_layout_settings]) && is_array($GLOBALS[$key_post_layout_settings])) {
            return $GLOBALS[$key_post_layout_settings];
        }

        $GLOBALS[$key_post_layout_settings] = array(
            'layout'      => g5plus_get_option('post_layout','large-image'),
            'columns' => g5plus_get_option('post_column',3),
            'paging'      => g5plus_get_option('post_paging','navigation'),
            'slider'      => false
        );

        return $GLOBALS[$key_post_layout_settings];
    }
}

//////////////////////////////////////////////////////////////////
// Social share
//////////////////////////////////////////////////////////////////
if (!function_exists('g5plus_the_social_share')){
    function g5plus_the_social_share(){
        get_template_part('templates/social-share');
    }
}
/**
 * Get Fonts Awesome Array
 * *******************************************************
 */
if (!function_exists('g5plus_get_font_awesome')) {
    function &g5plus_get_font_awesome() {
        if (isset($GLOBALS['g5plus_font_awesome']) && is_array($GLOBALS['g5plus_font_awesome'])) {
            return $GLOBALS['g5plus_font_awesome'];
        }
        $GLOBALS['g5plus_font_awesome'] = apply_filters('g5plus_font_awesome', array(
            array('fa fa-500px' => 'fa-500px'), array('fa fa-adjust' => 'fa-adjust'), array('fa fa-adn' => 'fa-adn'), array('fa fa-align-center' => 'fa-align-center'), array('fa fa-align-justify' => 'fa-align-justify'), array('fa fa-align-left' => 'fa-align-left'), array('fa fa-align-right' => 'fa-align-right'), array('fa fa-amazon' => 'fa-amazon'), array('fa fa-ambulance' => 'fa-ambulance'), array('fa fa-anchor' => 'fa-anchor'), array('fa fa-android' => 'fa-android'), array('fa fa-angellist' => 'fa-angellist'), array('fa fa-angle-double-down' => 'fa-angle-double-down'), array('fa fa-angle-double-left' => 'fa-angle-double-left'), array('fa fa-angle-double-right' => 'fa-angle-double-right'), array('fa fa-angle-double-up' => 'fa-angle-double-up'), array('fa fa-angle-down' => 'fa-angle-down'), array('fa fa-angle-left' => 'fa-angle-left'), array('fa fa-angle-right' => 'fa-angle-right'), array('fa fa-angle-up' => 'fa-angle-up'), array('fa fa-apple' => 'fa-apple'), array('fa fa-archive' => 'fa-archive'), array('fa fa-area-chart' => 'fa-area-chart'), array('fa fa-arrow-circle-down' => 'fa-arrow-circle-down'), array('fa fa-arrow-circle-left' => 'fa-arrow-circle-left'), array('fa fa-arrow-circle-o-down' => 'fa-arrow-circle-o-down'), array('fa fa-arrow-circle-o-left' => 'fa-arrow-circle-o-left'), array('fa fa-arrow-circle-o-right' => 'fa-arrow-circle-o-right'), array('fa fa-arrow-circle-o-up' => 'fa-arrow-circle-o-up'), array('fa fa-arrow-circle-right' => 'fa-arrow-circle-right'), array('fa fa-arrow-circle-up' => 'fa-arrow-circle-up'), array('fa fa-arrow-down' => 'fa-arrow-down'), array('fa fa-arrow-left' => 'fa-arrow-left'), array('fa fa-arrow-right' => 'fa-arrow-right'), array('fa fa-arrow-up' => 'fa-arrow-up'), array('fa fa-arrows' => 'fa-arrows'), array('fa fa-arrows-alt' => 'fa-arrows-alt'), array('fa fa-arrows-h' => 'fa-arrows-h'), array('fa fa-arrows-v' => 'fa-arrows-v'), array('fa fa-asterisk' => 'fa-asterisk'), array('fa fa-at' => 'fa-at'), array('fa fa-automobile' => 'fa-automobile'), array('fa fa-backward' => 'fa-backward'), array('fa fa-balance-scale' => 'fa-balance-scale'), array('fa fa-ban' => 'fa-ban'), array('fa fa-bank' => 'fa-bank'), array('fa fa-bar-chart' => 'fa-bar-chart'), array('fa fa-bar-chart-o' => 'fa-bar-chart-o'), array('fa fa-barcode' => 'fa-barcode'), array('fa fa-bars' => 'fa-bars'), array('fa fa-battery-0' => 'fa-battery-0'), array('fa fa-battery-1' => 'fa-battery-1'), array('fa fa-battery-2' => 'fa-battery-2'), array('fa fa-battery-3' => 'fa-battery-3'), array('fa fa-battery-4' => 'fa-battery-4'), array('fa fa-battery-empty' => 'fa-battery-empty'), array('fa fa-battery-full' => 'fa-battery-full'), array('fa fa-battery-half' => 'fa-battery-half'), array('fa fa-battery-quarter' => 'fa-battery-quarter'), array('fa fa-battery-three-quarters' => 'fa-battery-three-quarters'), array('fa fa-bed' => 'fa-bed'), array('fa fa-beer' => 'fa-beer'), array('fa fa-behance' => 'fa-behance'), array('fa fa-behance-square' => 'fa-behance-square'), array('fa fa-bell' => 'fa-bell'), array('fa fa-bell-o' => 'fa-bell-o'), array('fa fa-bell-slash' => 'fa-bell-slash'), array('fa fa-bell-slash-o' => 'fa-bell-slash-o'), array('fa fa-bicycle' => 'fa-bicycle'), array('fa fa-binoculars' => 'fa-binoculars'), array('fa fa-birthday-cake' => 'fa-birthday-cake'), array('fa fa-bitbucket' => 'fa-bitbucket'), array('fa fa-bitbucket-square' => 'fa-bitbucket-square'), array('fa fa-bitcoin' => 'fa-bitcoin'), array('fa fa-black-tie' => 'fa-black-tie'), array('fa fa-bluetooth' => 'fa-bluetooth'), array('fa fa-bluetooth-b' => 'fa-bluetooth-b'), array('fa fa-bold' => 'fa-bold'), array('fa fa-bolt' => 'fa-bolt'), array('fa fa-bomb' => 'fa-bomb'), array('fa fa-book' => 'fa-book'), array('fa fa-bookmark' => 'fa-bookmark'), array('fa fa-bookmark-o' => 'fa-bookmark-o'), array('fa fa-briefcase' => 'fa-briefcase'), array('fa fa-btc' => 'fa-btc'), array('fa fa-bug' => 'fa-bug'), array('fa fa-building' => 'fa-building'), array('fa fa-building-o' => 'fa-building-o'), array('fa fa-bullhorn' => 'fa-bullhorn'), array('fa fa-bullseye' => 'fa-bullseye'), array('fa fa-bus' => 'fa-bus'), array('fa fa-buysellads' => 'fa-buysellads'), array('fa fa-cab' => 'fa-cab'), array('fa fa-calculator' => 'fa-calculator'), array('fa fa-calendar' => 'fa-calendar'), array('fa fa-calendar-check-o' => 'fa-calendar-check-o'), array('fa fa-calendar-minus-o' => 'fa-calendar-minus-o'), array('fa fa-calendar-o' => 'fa-calendar-o'), array('fa fa-calendar-plus-o' => 'fa-calendar-plus-o'), array('fa fa-calendar-times-o' => 'fa-calendar-times-o'), array('fa fa-camera' => 'fa-camera'), array('fa fa-camera-retro' => 'fa-camera-retro'), array('fa fa-car' => 'fa-car'), array('fa fa-caret-down' => 'fa-caret-down'), array('fa fa-caret-left' => 'fa-caret-left'), array('fa fa-caret-right' => 'fa-caret-right'), array('fa fa-caret-square-o-down' => 'fa-caret-square-o-down'), array('fa fa-caret-square-o-left' => 'fa-caret-square-o-left'), array('fa fa-caret-square-o-right' => 'fa-caret-square-o-right'), array('fa fa-caret-square-o-up' => 'fa-caret-square-o-up'), array('fa fa-caret-up' => 'fa-caret-up'), array('fa fa-cart-arrow-down' => 'fa-cart-arrow-down'), array('fa fa-cart-plus' => 'fa-cart-plus'), array('fa fa-cc' => 'fa-cc'), array('fa fa-cc-amex' => 'fa-cc-amex'), array('fa fa-cc-diners-club' => 'fa-cc-diners-club'), array('fa fa-cc-discover' => 'fa-cc-discover'), array('fa fa-cc-jcb' => 'fa-cc-jcb'), array('fa fa-cc-mastercard' => 'fa-cc-mastercard'), array('fa fa-cc-paypal' => 'fa-cc-paypal'), array('fa fa-cc-stripe' => 'fa-cc-stripe'), array('fa fa-cc-visa' => 'fa-cc-visa'), array('fa fa-certificate' => 'fa-certificate'), array('fa fa-chain' => 'fa-chain'), array('fa fa-chain-broken' => 'fa-chain-broken'), array('fa fa-check' => 'fa-check'), array('fa fa-check-circle' => 'fa-check-circle'), array('fa fa-check-circle-o' => 'fa-check-circle-o'), array('fa fa-check-square' => 'fa-check-square'), array('fa fa-check-square-o' => 'fa-check-square-o'), array('fa fa-chevron-circle-down' => 'fa-chevron-circle-down'), array('fa fa-chevron-circle-left' => 'fa-chevron-circle-left'), array('fa fa-chevron-circle-right' => 'fa-chevron-circle-right'), array('fa fa-chevron-circle-up' => 'fa-chevron-circle-up'), array('fa fa-chevron-down' => 'fa-chevron-down'), array('fa fa-chevron-left' => 'fa-chevron-left'), array('fa fa-chevron-right' => 'fa-chevron-right'), array('fa fa-chevron-up' => 'fa-chevron-up'), array('fa fa-child' => 'fa-child'), array('fa fa-chrome' => 'fa-chrome'), array('fa fa-circle' => 'fa-circle'), array('fa fa-circle-o' => 'fa-circle-o'), array('fa fa-circle-o-notch' => 'fa-circle-o-notch'), array('fa fa-circle-thin' => 'fa-circle-thin'), array('fa fa-clipboard' => 'fa-clipboard'), array('fa fa-clock-o' => 'fa-clock-o'), array('fa fa-clone' => 'fa-clone'), array('fa fa-close' => 'fa-close'), array('fa fa-cloud' => 'fa-cloud'), array('fa fa-cloud-download' => 'fa-cloud-download'), array('fa fa-cloud-upload' => 'fa-cloud-upload'), array('fa fa-cny' => 'fa-cny'), array('fa fa-code' => 'fa-code'), array('fa fa-code-fork' => 'fa-code-fork'), array('fa fa-codepen' => 'fa-codepen'), array('fa fa-codiepie' => 'fa-codiepie'), array('fa fa-coffee' => 'fa-coffee'), array('fa fa-cog' => 'fa-cog'), array('fa fa-cogs' => 'fa-cogs'), array('fa fa-columns' => 'fa-columns'), array('fa fa-comment' => 'fa-comment'), array('fa fa-comment-o' => 'fa-comment-o'), array('fa fa-commenting' => 'fa-commenting'), array('fa fa-commenting-o' => 'fa-commenting-o'), array('fa fa-comments' => 'fa-comments'), array('fa fa-comments-o' => 'fa-comments-o'), array('fa fa-compass' => 'fa-compass'), array('fa fa-compress' => 'fa-compress'), array('fa fa-connectdevelop' => 'fa-connectdevelop'), array('fa fa-contao' => 'fa-contao'), array('fa fa-copy' => 'fa-copy'), array('fa fa-copyright' => 'fa-copyright'), array('fa fa-creative-commons' => 'fa-creative-commons'), array('fa fa-credit-card' => 'fa-credit-card'), array('fa fa-credit-card-alt' => 'fa-credit-card-alt'), array('fa fa-crop' => 'fa-crop'), array('fa fa-crosshairs' => 'fa-crosshairs'), array('fa fa-css3' => 'fa-css3'), array('fa fa-cube' => 'fa-cube'), array('fa fa-cubes' => 'fa-cubes'), array('fa fa-cut' => 'fa-cut'), array('fa fa-cutlery' => 'fa-cutlery'), array('fa fa-dashboard' => 'fa-dashboard'), array('fa fa-dashcube' => 'fa-dashcube'), array('fa fa-database' => 'fa-database'), array('fa fa-dedent' => 'fa-dedent'), array('fa fa-delicious' => 'fa-delicious'), array('fa fa-desktop' => 'fa-desktop'), array('fa fa-deviantart' => 'fa-deviantart'), array('fa fa-diamond' => 'fa-diamond'), array('fa fa-digg' => 'fa-digg'), array('fa fa-dollar' => 'fa-dollar'), array('fa fa-dot-circle-o' => 'fa-dot-circle-o'), array('fa fa-download' => 'fa-download'), array('fa fa-dribbble' => 'fa-dribbble'), array('fa fa-dropbox' => 'fa-dropbox'), array('fa fa-drupal' => 'fa-drupal'), array('fa fa-edge' => 'fa-edge'), array('fa fa-edit' => 'fa-edit'), array('fa fa-eject' => 'fa-eject'), array('fa fa-ellipsis-h' => 'fa-ellipsis-h'), array('fa fa-ellipsis-v' => 'fa-ellipsis-v'), array('fa fa-empire' => 'fa-empire'), array('fa fa-envelope' => 'fa-envelope'), array('fa fa-envelope-o' => 'fa-envelope-o'), array('fa fa-envelope-square' => 'fa-envelope-square'), array('fa fa-eraser' => 'fa-eraser'), array('fa fa-eur' => 'fa-eur'), array('fa fa-euro' => 'fa-euro'), array('fa fa-exchange' => 'fa-exchange'), array('fa fa-exclamation' => 'fa-exclamation'), array('fa fa-exclamation-circle' => 'fa-exclamation-circle'), array('fa fa-exclamation-triangle' => 'fa-exclamation-triangle'), array('fa fa-expand' => 'fa-expand'), array('fa fa-expeditedssl' => 'fa-expeditedssl'), array('fa fa-external-link' => 'fa-external-link'), array('fa fa-external-link-square' => 'fa-external-link-square'), array('fa fa-eye' => 'fa-eye'), array('fa fa-eye-slash' => 'fa-eye-slash'), array('fa fa-eyedropper' => 'fa-eyedropper'), array('fa fa-facebook' => 'fa-facebook'), array('fa fa-facebook-f' => 'fa-facebook-f'), array('fa fa-facebook-official' => 'fa-facebook-official'), array('fa fa-facebook-square' => 'fa-facebook-square'), array('fa fa-fast-backward' => 'fa-fast-backward'), array('fa fa-fast-forward' => 'fa-fast-forward'), array('fa fa-fax' => 'fa-fax'), array('fa fa-feed' => 'fa-feed'), array('fa fa-female' => 'fa-female'), array('fa fa-fighter-jet' => 'fa-fighter-jet'), array('fa fa-file' => 'fa-file'), array('fa fa-file-archive-o' => 'fa-file-archive-o'), array('fa fa-file-audio-o' => 'fa-file-audio-o'), array('fa fa-file-code-o' => 'fa-file-code-o'), array('fa fa-file-excel-o' => 'fa-file-excel-o'), array('fa fa-file-image-o' => 'fa-file-image-o'), array('fa fa-file-movie-o' => 'fa-file-movie-o'), array('fa fa-file-o' => 'fa-file-o'), array('fa fa-file-pdf-o' => 'fa-file-pdf-o'), array('fa fa-file-photo-o' => 'fa-file-photo-o'), array('fa fa-file-picture-o' => 'fa-file-picture-o'), array('fa fa-file-powerpoint-o' => 'fa-file-powerpoint-o'), array('fa fa-file-sound-o' => 'fa-file-sound-o'), array('fa fa-file-text' => 'fa-file-text'), array('fa fa-file-text-o' => 'fa-file-text-o'), array('fa fa-file-video-o' => 'fa-file-video-o'), array('fa fa-file-word-o' => 'fa-file-word-o'), array('fa fa-file-zip-o' => 'fa-file-zip-o'), array('fa fa-files-o' => 'fa-files-o'), array('fa fa-film' => 'fa-film'), array('fa fa-filter' => 'fa-filter'), array('fa fa-fire' => 'fa-fire'), array('fa fa-fire-extinguisher' => 'fa-fire-extinguisher'), array('fa fa-firefox' => 'fa-firefox'), array('fa fa-flag' => 'fa-flag'), array('fa fa-flag-checkered' => 'fa-flag-checkered'), array('fa fa-flag-o' => 'fa-flag-o'), array('fa fa-flash' => 'fa-flash'), array('fa fa-flask' => 'fa-flask'), array('fa fa-flickr' => 'fa-flickr'), array('fa fa-floppy-o' => 'fa-floppy-o'), array('fa fa-folder' => 'fa-folder'), array('fa fa-folder-o' => 'fa-folder-o'), array('fa fa-folder-open' => 'fa-folder-open'), array('fa fa-folder-open-o' => 'fa-folder-open-o'), array('fa fa-font' => 'fa-font'), array('fa fa-fonticons' => 'fa-fonticons'), array('fa fa-fort-awesome' => 'fa-fort-awesome'), array('fa fa-forumbee' => 'fa-forumbee'), array('fa fa-forward' => 'fa-forward'), array('fa fa-foursquare' => 'fa-foursquare'), array('fa fa-frown-o' => 'fa-frown-o'), array('fa fa-futbol-o' => 'fa-futbol-o'), array('fa fa-gamepad' => 'fa-gamepad'), array('fa fa-gavel' => 'fa-gavel'), array('fa fa-gbp' => 'fa-gbp'), array('fa fa-ge' => 'fa-ge'), array('fa fa-gear' => 'fa-gear'), array('fa fa-gears' => 'fa-gears'), array('fa fa-genderless' => 'fa-genderless'), array('fa fa-get-pocket' => 'fa-get-pocket'), array('fa fa-gg' => 'fa-gg'), array('fa fa-gg-circle' => 'fa-gg-circle'), array('fa fa-gift' => 'fa-gift'), array('fa fa-git' => 'fa-git'), array('fa fa-git-square' => 'fa-git-square'), array('fa fa-github' => 'fa-github'), array('fa fa-github-alt' => 'fa-github-alt'), array('fa fa-github-square' => 'fa-github-square'), array('fa fa-gittip' => 'fa-gittip'), array('fa fa-glass' => 'fa-glass'), array('fa fa-globe' => 'fa-globe'), array('fa fa-google' => 'fa-google'), array('fa fa-google-plus' => 'fa-google-plus'), array('fa fa-google-plus-square' => 'fa-google-plus-square'), array('fa fa-google-wallet' => 'fa-google-wallet'), array('fa fa-graduation-cap' => 'fa-graduation-cap'), array('fa fa-gratipay' => 'fa-gratipay'), array('fa fa-group' => 'fa-group'), array('fa fa-h-square' => 'fa-h-square'), array('fa fa-hacker-news' => 'fa-hacker-news'), array('fa fa-hand-grab-o' => 'fa-hand-grab-o'), array('fa fa-hand-lizard-o' => 'fa-hand-lizard-o'), array('fa fa-hand-o-down' => 'fa-hand-o-down'), array('fa fa-hand-o-left' => 'fa-hand-o-left'), array('fa fa-hand-o-right' => 'fa-hand-o-right'), array('fa fa-hand-o-up' => 'fa-hand-o-up'), array('fa fa-hand-paper-o' => 'fa-hand-paper-o'), array('fa fa-hand-peace-o' => 'fa-hand-peace-o'), array('fa fa-hand-pointer-o' => 'fa-hand-pointer-o'), array('fa fa-hand-rock-o' => 'fa-hand-rock-o'), array('fa fa-hand-scissors-o' => 'fa-hand-scissors-o'), array('fa fa-hand-spock-o' => 'fa-hand-spock-o'), array('fa fa-hand-stop-o' => 'fa-hand-stop-o'), array('fa fa-hashtag' => 'fa-hashtag'), array('fa fa-hdd-o' => 'fa-hdd-o'), array('fa fa-header' => 'fa-header'), array('fa fa-headphones' => 'fa-headphones'), array('fa fa-heart' => 'fa-heart'), array('fa fa-heart-o' => 'fa-heart-o'), array('fa fa-heartbeat' => 'fa-heartbeat'), array('fa fa-history' => 'fa-history'), array('fa fa-home' => 'fa-home'), array('fa fa-hospital-o' => 'fa-hospital-o'), array('fa fa-hotel' => 'fa-hotel'), array('fa fa-hourglass' => 'fa-hourglass'), array('fa fa-hourglass-1' => 'fa-hourglass-1'), array('fa fa-hourglass-2' => 'fa-hourglass-2'), array('fa fa-hourglass-3' => 'fa-hourglass-3'), array('fa fa-hourglass-end' => 'fa-hourglass-end'), array('fa fa-hourglass-half' => 'fa-hourglass-half'), array('fa fa-hourglass-o' => 'fa-hourglass-o'), array('fa fa-hourglass-start' => 'fa-hourglass-start'), array('fa fa-houzz' => 'fa-houzz'), array('fa fa-html5' => 'fa-html5'), array('fa fa-i-cursor' => 'fa-i-cursor'), array('fa fa-ils' => 'fa-ils'), array('fa fa-image' => 'fa-image'), array('fa fa-inbox' => 'fa-inbox'), array('fa fa-indent' => 'fa-indent'), array('fa fa-industry' => 'fa-industry'), array('fa fa-info' => 'fa-info'), array('fa fa-info-circle' => 'fa-info-circle'), array('fa fa-inr' => 'fa-inr'), array('fa fa-instagram' => 'fa-instagram'), array('fa fa-institution' => 'fa-institution'), array('fa fa-internet-explorer' => 'fa-internet-explorer'), array('fa fa-intersex' => 'fa-intersex'), array('fa fa-ioxhost' => 'fa-ioxhost'), array('fa fa-italic' => 'fa-italic'), array('fa fa-joomla' => 'fa-joomla'), array('fa fa-jpy' => 'fa-jpy'), array('fa fa-jsfiddle' => 'fa-jsfiddle'), array('fa fa-key' => 'fa-key'), array('fa fa-keyboard-o' => 'fa-keyboard-o'), array('fa fa-krw' => 'fa-krw'), array('fa fa-language' => 'fa-language'), array('fa fa-laptop' => 'fa-laptop'), array('fa fa-lastfm' => 'fa-lastfm'), array('fa fa-lastfm-square' => 'fa-lastfm-square'), array('fa fa-leaf' => 'fa-leaf'), array('fa fa-leanpub' => 'fa-leanpub'), array('fa fa-legal' => 'fa-legal'), array('fa fa-lemon-o' => 'fa-lemon-o'), array('fa fa-level-down' => 'fa-level-down'), array('fa fa-level-up' => 'fa-level-up'), array('fa fa-life-bouy' => 'fa-life-bouy'), array('fa fa-life-buoy' => 'fa-life-buoy'), array('fa fa-life-ring' => 'fa-life-ring'), array('fa fa-life-saver' => 'fa-life-saver'), array('fa fa-lightbulb-o' => 'fa-lightbulb-o'), array('fa fa-line-chart' => 'fa-line-chart'), array('fa fa-link' => 'fa-link'), array('fa fa-linkedin' => 'fa-linkedin'), array('fa fa-linkedin-square' => 'fa-linkedin-square'), array('fa fa-linux' => 'fa-linux'), array('fa fa-list' => 'fa-list'), array('fa fa-list-alt' => 'fa-list-alt'), array('fa fa-list-ol' => 'fa-list-ol'), array('fa fa-list-ul' => 'fa-list-ul'), array('fa fa-location-arrow' => 'fa-location-arrow'), array('fa fa-lock' => 'fa-lock'), array('fa fa-long-arrow-down' => 'fa-long-arrow-down'), array('fa fa-long-arrow-left' => 'fa-long-arrow-left'), array('fa fa-long-arrow-right' => 'fa-long-arrow-right'), array('fa fa-long-arrow-up' => 'fa-long-arrow-up'), array('fa fa-magic' => 'fa-magic'), array('fa fa-magnet' => 'fa-magnet'), array('fa fa-mail-forward' => 'fa-mail-forward'), array('fa fa-mail-reply' => 'fa-mail-reply'), array('fa fa-mail-reply-all' => 'fa-mail-reply-all'), array('fa fa-male' => 'fa-male'), array('fa fa-map' => 'fa-map'), array('fa fa-map-marker' => 'fa-map-marker'), array('fa fa-map-o' => 'fa-map-o'), array('fa fa-map-pin' => 'fa-map-pin'), array('fa fa-map-signs' => 'fa-map-signs'), array('fa fa-mars' => 'fa-mars'), array('fa fa-mars-double' => 'fa-mars-double'), array('fa fa-mars-stroke' => 'fa-mars-stroke'), array('fa fa-mars-stroke-h' => 'fa-mars-stroke-h'), array('fa fa-mars-stroke-v' => 'fa-mars-stroke-v'), array('fa fa-maxcdn' => 'fa-maxcdn'), array('fa fa-meanpath' => 'fa-meanpath'), array('fa fa-medium' => 'fa-medium'), array('fa fa-medkit' => 'fa-medkit'), array('fa fa-meh-o' => 'fa-meh-o'), array('fa fa-mercury' => 'fa-mercury'), array('fa fa-microphone' => 'fa-microphone'), array('fa fa-microphone-slash' => 'fa-microphone-slash'), array('fa fa-minus' => 'fa-minus'), array('fa fa-minus-circle' => 'fa-minus-circle'), array('fa fa-minus-square' => 'fa-minus-square'), array('fa fa-minus-square-o' => 'fa-minus-square-o'), array('fa fa-mixcloud' => 'fa-mixcloud'), array('fa fa-mobile' => 'fa-mobile'), array('fa fa-mobile-phone' => 'fa-mobile-phone'), array('fa fa-modx' => 'fa-modx'), array('fa fa-money' => 'fa-money'), array('fa fa-moon-o' => 'fa-moon-o'), array('fa fa-mortar-board' => 'fa-mortar-board'), array('fa fa-motorcycle' => 'fa-motorcycle'), array('fa fa-mouse-pointer' => 'fa-mouse-pointer'), array('fa fa-music' => 'fa-music'), array('fa fa-navicon' => 'fa-navicon'), array('fa fa-neuter' => 'fa-neuter'), array('fa fa-newspaper-o' => 'fa-newspaper-o'), array('fa fa-object-group' => 'fa-object-group'), array('fa fa-object-ungroup' => 'fa-object-ungroup'), array('fa fa-odnoklassniki' => 'fa-odnoklassniki'), array('fa fa-odnoklassniki-square' => 'fa-odnoklassniki-square'), array('fa fa-opencart' => 'fa-opencart'), array('fa fa-openid' => 'fa-openid'), array('fa fa-opera' => 'fa-opera'), array('fa fa-optin-monster' => 'fa-optin-monster'), array('fa fa-outdent' => 'fa-outdent'), array('fa fa-pagelines' => 'fa-pagelines'), array('fa fa-paint-brush' => 'fa-paint-brush'), array('fa fa-paper-plane' => 'fa-paper-plane'), array('fa fa-paper-plane-o' => 'fa-paper-plane-o'), array('fa fa-paperclip' => 'fa-paperclip'), array('fa fa-paragraph' => 'fa-paragraph'), array('fa fa-paste' => 'fa-paste'), array('fa fa-pause' => 'fa-pause'), array('fa fa-pause-circle' => 'fa-pause-circle'), array('fa fa-pause-circle-o' => 'fa-pause-circle-o'), array('fa fa-paw' => 'fa-paw'), array('fa fa-paypal' => 'fa-paypal'), array('fa fa-pencil' => 'fa-pencil'), array('fa fa-pencil-square' => 'fa-pencil-square'), array('fa fa-pencil-square-o' => 'fa-pencil-square-o'), array('fa fa-percent' => 'fa-percent'), array('fa fa-phone' => 'fa-phone'), array('fa fa-phone-square' => 'fa-phone-square'), array('fa fa-photo' => 'fa-photo'), array('fa fa-picture-o' => 'fa-picture-o'), array('fa fa-pie-chart' => 'fa-pie-chart'), array('fa fa-pied-piper' => 'fa-pied-piper'), array('fa fa-pied-piper-alt' => 'fa-pied-piper-alt'), array('fa fa-pinterest' => 'fa-pinterest'), array('fa fa-pinterest-p' => 'fa-pinterest-p'), array('fa fa-pinterest-square' => 'fa-pinterest-square'), array('fa fa-plane' => 'fa-plane'), array('fa fa-play' => 'fa-play'), array('fa fa-play-circle' => 'fa-play-circle'), array('fa fa-play-circle-o' => 'fa-play-circle-o'), array('fa fa-plug' => 'fa-plug'), array('fa fa-plus' => 'fa-plus'), array('fa fa-plus-circle' => 'fa-plus-circle'), array('fa fa-plus-square' => 'fa-plus-square'), array('fa fa-plus-square-o' => 'fa-plus-square-o'), array('fa fa-power-off' => 'fa-power-off'), array('fa fa-print' => 'fa-print'), array('fa fa-product-hunt' => 'fa-product-hunt'), array('fa fa-puzzle-piece' => 'fa-puzzle-piece'), array('fa fa-qq' => 'fa-qq'), array('fa fa-qrcode' => 'fa-qrcode'), array('fa fa-question' => 'fa-question'), array('fa fa-question-circle' => 'fa-question-circle'), array('fa fa-quote-left' => 'fa-quote-left'), array('fa fa-quote-right' => 'fa-quote-right'), array('fa fa-ra' => 'fa-ra'), array('fa fa-random' => 'fa-random'), array('fa fa-rebel' => 'fa-rebel'), array('fa fa-recycle' => 'fa-recycle'), array('fa fa-reddit' => 'fa-reddit'), array('fa fa-reddit-alien' => 'fa-reddit-alien'), array('fa fa-reddit-square' => 'fa-reddit-square'), array('fa fa-refresh' => 'fa-refresh'), array('fa fa-registered' => 'fa-registered'), array('fa fa-remove' => 'fa-remove'), array('fa fa-renren' => 'fa-renren'), array('fa fa-reorder' => 'fa-reorder'), array('fa fa-repeat' => 'fa-repeat'), array('fa fa-reply' => 'fa-reply'), array('fa fa-reply-all' => 'fa-reply-all'), array('fa fa-retweet' => 'fa-retweet'), array('fa fa-rmb' => 'fa-rmb'), array('fa fa-road' => 'fa-road'), array('fa fa-rocket' => 'fa-rocket'), array('fa fa-rotate-left' => 'fa-rotate-left'), array('fa fa-rotate-right' => 'fa-rotate-right'), array('fa fa-rouble' => 'fa-rouble'), array('fa fa-rss' => 'fa-rss'), array('fa fa-rss-square' => 'fa-rss-square'), array('fa fa-rub' => 'fa-rub'), array('fa fa-ruble' => 'fa-ruble'), array('fa fa-rupee' => 'fa-rupee'), array('fa fa-safari' => 'fa-safari'), array('fa fa-save' => 'fa-save'), array('fa fa-scissors' => 'fa-scissors'), array('fa fa-scribd' => 'fa-scribd'), array('fa fa-search' => 'fa-search'), array('fa fa-search-minus' => 'fa-search-minus'), array('fa fa-search-plus' => 'fa-search-plus'), array('fa fa-sellsy' => 'fa-sellsy'), array('fa fa-send' => 'fa-send'), array('fa fa-send-o' => 'fa-send-o'), array('fa fa-server' => 'fa-server'), array('fa fa-share' => 'fa-share'), array('fa fa-share-alt' => 'fa-share-alt'), array('fa fa-share-alt-square' => 'fa-share-alt-square'), array('fa fa-share-square' => 'fa-share-square'), array('fa fa-share-square-o' => 'fa-share-square-o'), array('fa fa-shekel' => 'fa-shekel'), array('fa fa-sheqel' => 'fa-sheqel'), array('fa fa-shield' => 'fa-shield'), array('fa fa-ship' => 'fa-ship'), array('fa fa-shirtsinbulk' => 'fa-shirtsinbulk'), array('fa fa-shopping-bag' => 'fa-shopping-bag'), array('fa fa-shopping-basket' => 'fa-shopping-basket'), array('fa fa-shopping-cart' => 'fa-shopping-cart'), array('fa fa-sign-in' => 'fa-sign-in'), array('fa fa-sign-out' => 'fa-sign-out'), array('fa fa-signal' => 'fa-signal'), array('fa fa-simplybuilt' => 'fa-simplybuilt'), array('fa fa-sitemap' => 'fa-sitemap'), array('fa fa-skyatlas' => 'fa-skyatlas'), array('fa fa-skype' => 'fa-skype'), array('fa fa-slack' => 'fa-slack'), array('fa fa-sliders' => 'fa-sliders'), array('fa fa-slideshare' => 'fa-slideshare'), array('fa fa-smile-o' => 'fa-smile-o'), array('fa fa-soccer-ball-o' => 'fa-soccer-ball-o'), array('fa fa-sort' => 'fa-sort'), array('fa fa-sort-alpha-asc' => 'fa-sort-alpha-asc'), array('fa fa-sort-alpha-desc' => 'fa-sort-alpha-desc'), array('fa fa-sort-amount-asc' => 'fa-sort-amount-asc'), array('fa fa-sort-amount-desc' => 'fa-sort-amount-desc'), array('fa fa-sort-asc' => 'fa-sort-asc'), array('fa fa-sort-desc' => 'fa-sort-desc'), array('fa fa-sort-down' => 'fa-sort-down'), array('fa fa-sort-numeric-asc' => 'fa-sort-numeric-asc'), array('fa fa-sort-numeric-desc' => 'fa-sort-numeric-desc'), array('fa fa-sort-up' => 'fa-sort-up'), array('fa fa-soundcloud' => 'fa-soundcloud'), array('fa fa-space-shuttle' => 'fa-space-shuttle'), array('fa fa-spinner' => 'fa-spinner'), array('fa fa-spoon' => 'fa-spoon'), array('fa fa-spotify' => 'fa-spotify'), array('fa fa-square' => 'fa-square'), array('fa fa-square-o' => 'fa-square-o'), array('fa fa-stack-exchange' => 'fa-stack-exchange'), array('fa fa-stack-overflow' => 'fa-stack-overflow'), array('fa fa-star' => 'fa-star'), array('fa fa-star-half' => 'fa-star-half'), array('fa fa-star-half-empty' => 'fa-star-half-empty'), array('fa fa-star-half-full' => 'fa-star-half-full'), array('fa fa-star-half-o' => 'fa-star-half-o'), array('fa fa-star-o' => 'fa-star-o'), array('fa fa-steam' => 'fa-steam'), array('fa fa-steam-square' => 'fa-steam-square'), array('fa fa-step-backward' => 'fa-step-backward'), array('fa fa-step-forward' => 'fa-step-forward'), array('fa fa-stethoscope' => 'fa-stethoscope'), array('fa fa-sticky-note' => 'fa-sticky-note'), array('fa fa-sticky-note-o' => 'fa-sticky-note-o'), array('fa fa-stop' => 'fa-stop'), array('fa fa-stop-circle' => 'fa-stop-circle'), array('fa fa-stop-circle-o' => 'fa-stop-circle-o'), array('fa fa-street-view' => 'fa-street-view'), array('fa fa-strikethrough' => 'fa-strikethrough'), array('fa fa-stumbleupon' => 'fa-stumbleupon'), array('fa fa-stumbleupon-circle' => 'fa-stumbleupon-circle'), array('fa fa-subscript' => 'fa-subscript'), array('fa fa-subway' => 'fa-subway'), array('fa fa-suitcase' => 'fa-suitcase'), array('fa fa-sun-o' => 'fa-sun-o'), array('fa fa-superscript' => 'fa-superscript'), array('fa fa-support' => 'fa-support'), array('fa fa-table' => 'fa-table'), array('fa fa-tablet' => 'fa-tablet'), array('fa fa-tachometer' => 'fa-tachometer'), array('fa fa-tag' => 'fa-tag'), array('fa fa-tags' => 'fa-tags'), array('fa fa-tasks' => 'fa-tasks'), array('fa fa-taxi' => 'fa-taxi'), array('fa fa-television' => 'fa-television'), array('fa fa-tencent-weibo' => 'fa-tencent-weibo'), array('fa fa-terminal' => 'fa-terminal'), array('fa fa-text-height' => 'fa-text-height'), array('fa fa-text-width' => 'fa-text-width'), array('fa fa-th' => 'fa-th'), array('fa fa-th-large' => 'fa-th-large'), array('fa fa-th-list' => 'fa-th-list'), array('fa fa-thumb-tack' => 'fa-thumb-tack'), array('fa fa-thumbs-down' => 'fa-thumbs-down'), array('fa fa-thumbs-o-down' => 'fa-thumbs-o-down'), array('fa fa-thumbs-o-up' => 'fa-thumbs-o-up'), array('fa fa-thumbs-up' => 'fa-thumbs-up'), array('fa fa-ticket' => 'fa-ticket'), array('fa fa-times' => 'fa-times'), array('fa fa-times-circle' => 'fa-times-circle'), array('fa fa-times-circle-o' => 'fa-times-circle-o'), array('fa fa-tint' => 'fa-tint'), array('fa fa-toggle-down' => 'fa-toggle-down'), array('fa fa-toggle-left' => 'fa-toggle-left'), array('fa fa-toggle-off' => 'fa-toggle-off'), array('fa fa-toggle-on' => 'fa-toggle-on'), array('fa fa-toggle-right' => 'fa-toggle-right'), array('fa fa-toggle-up' => 'fa-toggle-up'), array('fa fa-trademark' => 'fa-trademark'), array('fa fa-train' => 'fa-train'), array('fa fa-transgender' => 'fa-transgender'), array('fa fa-transgender-alt' => 'fa-transgender-alt'), array('fa fa-trash' => 'fa-trash'), array('fa fa-trash-o' => 'fa-trash-o'), array('fa fa-tree' => 'fa-tree'), array('fa fa-trello' => 'fa-trello'), array('fa fa-tripadvisor' => 'fa-tripadvisor'), array('fa fa-trophy' => 'fa-trophy'), array('fa fa-truck' => 'fa-truck'), array('fa fa-try' => 'fa-try'), array('fa fa-tty' => 'fa-tty'), array('fa fa-tumblr' => 'fa-tumblr'), array('fa fa-tumblr-square' => 'fa-tumblr-square'), array('fa fa-turkish-lira' => 'fa-turkish-lira'), array('fa fa-tv' => 'fa-tv'), array('fa fa-twitch' => 'fa-twitch'), array('fa fa-twitter' => 'fa-twitter'), array('fa fa-twitter-square' => 'fa-twitter-square'), array('fa fa-umbrella' => 'fa-umbrella'), array('fa fa-underline' => 'fa-underline'), array('fa fa-undo' => 'fa-undo'), array('fa fa-university' => 'fa-university'), array('fa fa-unlink' => 'fa-unlink'), array('fa fa-unlock' => 'fa-unlock'), array('fa fa-unlock-alt' => 'fa-unlock-alt'), array('fa fa-unsorted' => 'fa-unsorted'), array('fa fa-upload' => 'fa-upload'), array('fa fa-usb' => 'fa-usb'), array('fa fa-usd' => 'fa-usd'), array('fa fa-user' => 'fa-user'), array('fa fa-user-md' => 'fa-user-md'), array('fa fa-user-plus' => 'fa-user-plus'), array('fa fa-user-secret' => 'fa-user-secret'), array('fa fa-user-times' => 'fa-user-times'), array('fa fa-users' => 'fa-users'), array('fa fa-venus' => 'fa-venus'), array('fa fa-venus-double' => 'fa-venus-double'), array('fa fa-venus-mars' => 'fa-venus-mars'), array('fa fa-viacoin' => 'fa-viacoin'), array('fa fa-video-camera' => 'fa-video-camera'), array('fa fa-vimeo' => 'fa-vimeo'), array('fa fa-vimeo-square' => 'fa-vimeo-square'), array('fa fa-vine' => 'fa-vine'), array('fa fa-vk' => 'fa-vk'), array('fa fa-volume-down' => 'fa-volume-down'), array('fa fa-volume-off' => 'fa-volume-off'), array('fa fa-volume-up' => 'fa-volume-up'), array('fa fa-warning' => 'fa-warning'), array('fa fa-wechat' => 'fa-wechat'), array('fa fa-weibo' => 'fa-weibo'), array('fa fa-weixin' => 'fa-weixin'), array('fa fa-whatsapp' => 'fa-whatsapp'), array('fa fa-wheelchair' => 'fa-wheelchair'), array('fa fa-wifi' => 'fa-wifi'), array('fa fa-wikipedia-w' => 'fa-wikipedia-w'), array('fa fa-windows' => 'fa-windows'), array('fa fa-won' => 'fa-won'), array('fa fa-wordpress' => 'fa-wordpress'), array('fa fa-wrench' => 'fa-wrench'), array('fa fa-xing' => 'fa-xing'), array('fa fa-xing-square' => 'fa-xing-square'), array('fa fa-y-combinator' => 'fa-y-combinator'), array('fa fa-y-combinator-square' => 'fa-y-combinator-square'), array('fa fa-yahoo' => 'fa-yahoo'), array('fa fa-yc' => 'fa-yc'), array('fa fa-yc-square' => 'fa-yc-square'), array('fa fa-yelp' => 'fa-yelp'), array('fa fa-yen' => 'fa-yen'), array('fa fa-youtube' => 'fa-youtube'), array('fa fa-youtube-play' => 'fa-youtube-play'), array('fa fa-youtube-square' => 'fa-youtube-square')
        ));

        return $GLOBALS['g5plus_font_awesome'];
    }
}

/**
 * Get Theme Font Icon
 * *******************************************************
 */
if (!function_exists('g5plus_get_theme_font')) {
    function &g5plus_get_theme_font() {
        if (isset($GLOBALS['g5plus_icomoon']) && is_array($GLOBALS['g5plus_icomoon'])) {
            return $GLOBALS['g5plus_icomoon'];
        }
        $GLOBALS['g5plus_icomoon'] = apply_filters('g5plus_icomoon', array(
			array('icon-car-garage'=>'icon-car-garage'),array('icon-car-in-garage'=>'icon-car-in-garage'),array('icon-bed-1'=>'icon-bed-1'),array('icon-bathtub-1'=>'icon-bathtub-1'),array('icon-design-grid-simple-structure-with-three-areas'=>'icon-design-grid-simple-structure-with-three-areas'),array('icon-assembly-area'=>'icon-assembly-area'),array('icon-building2'=>'icon-building2'),array('icon-bed2'=>'icon-bed2'),array('icon-bathtub'=>'icon-bathtub'),array('icon-house-roof'=>'icon-house-roof'),array('icon-house-roof2'=>'icon-house-roof2'),array('icon-bathtube'=>'icon-bathtube'),array('icon-bed'=>'icon-bed'),array('icon-bath'=>'icon-bath'),array('icon-blueprint'=>'icon-blueprint'),array('icon-garage'=>'icon-garage'),array('icon-room-bed'=>'icon-room-bed'),array('icon-square'=>'icon-square'),array('icon-bedroom'=>'icon-bedroom'),array('icon-envelope-in-black-paper-with-a-white-letter-sheet-inside'=>'icon-envelope-in-black-paper-with-a-white-letter-sheet-inside'),array('icon-next3'=>'icon-next3'),array('icon-back'=>'icon-back'),array('icon-clown'=>'icon-clown'),array('icon-exam'=>'icon-exam'),array('icon-placeholder'=>'icon-placeholder'),array('icon-next32'=>'icon-next32'),array('icon-back2'=>'icon-back2'),array('icon-house'=>'icon-house'),array('icon-fast-food'=>'icon-fast-food'),array('icon-wrench2'=>'icon-wrench2'),array('icon-sunbed'=>'icon-sunbed'),array('icon-building'=>'icon-building'),array('icon-grooming'=>'icon-grooming'),array('icon-gps-fixed-indicator'=>'icon-gps-fixed-indicator'),array('icon-home4'=>'icon-home4'),array('icon-home22'=>'icon-home22'),array('icon-home32'=>'icon-home32'),array('icon-office2'=>'icon-office2'),array('icon-newspaper2'=>'icon-newspaper2'),array('icon-pencil3'=>'icon-pencil3'),array('icon-pencil22'=>'icon-pencil22'),array('icon-quill2'=>'icon-quill2'),array('icon-pen2'=>'icon-pen2'),array('icon-blog2'=>'icon-blog2'),array('icon-eyedropper2'=>'icon-eyedropper2'),array('icon-droplet2'=>'icon-droplet2'),array('icon-paint-format2'=>'icon-paint-format2'),array('icon-image2'=>'icon-image2'),array('icon-images2'=>'icon-images2'),array('icon-camera2'=>'icon-camera2'),array('icon-headphones2'=>'icon-headphones2'),array('icon-music2'=>'icon-music2'),array('icon-play4'=>'icon-play4'),array('icon-film2'=>'icon-film2'),array('icon-video-camera2'=>'icon-video-camera2'),array('icon-dice2'=>'icon-dice2'),array('icon-pacman2'=>'icon-pacman2'),array('icon-spades2'=>'icon-spades2'),array('icon-clubs2'=>'icon-clubs2'),array('icon-diamonds2'=>'icon-diamonds2'),array('icon-bullhorn2'=>'icon-bullhorn2'),array('icon-connection2'=>'icon-connection2'),array('icon-podcast2'=>'icon-podcast2'),array('icon-feed2'=>'icon-feed2'),array('icon-mic2'=>'icon-mic2'),array('icon-book2'=>'icon-book2'),array('icon-books2'=>'icon-books2'),array('icon-library2'=>'icon-library2'),array('icon-file-text3'=>'icon-file-text3'),array('icon-profile2'=>'icon-profile2'),array('icon-file-empty2'=>'icon-file-empty2'),array('icon-files-empty2'=>'icon-files-empty2'),array('icon-file-text22'=>'icon-file-text22'),array('icon-file-picture2'=>'icon-file-picture2'),array('icon-file-music2'=>'icon-file-music2'),array('icon-file-play2'=>'icon-file-play2'),array('icon-file-video2'=>'icon-file-video2'),array('icon-file-zip2'=>'icon-file-zip2'),array('icon-copy2'=>'icon-copy2'),array('icon-paste2'=>'icon-paste2'),array('icon-stack2'=>'icon-stack2'),array('icon-folder2'=>'icon-folder2'),array('icon-folder-open2'=>'icon-folder-open2'),array('icon-folder-plus2'=>'icon-folder-plus2'),array('icon-folder-minus2'=>'icon-folder-minus2'),array('icon-folder-download2'=>'icon-folder-download2'),array('icon-folder-upload2'=>'icon-folder-upload2'),array('icon-price-tag2'=>'icon-price-tag2'),array('icon-price-tags2'=>'icon-price-tags2'),array('icon-barcode2'=>'icon-barcode2'),array('icon-qrcode2'=>'icon-qrcode2'),array('icon-ticket2'=>'icon-ticket2'),array('icon-cart2'=>'icon-cart2'),array('icon-coin-dollar2'=>'icon-coin-dollar2'),array('icon-coin-euro2'=>'icon-coin-euro2'),array('icon-coin-pound2'=>'icon-coin-pound2'),array('icon-coin-yen2'=>'icon-coin-yen2'),array('icon-credit-card2'=>'icon-credit-card2'),array('icon-calculator2'=>'icon-calculator2'),array('icon-lifebuoy2'=>'icon-lifebuoy2'),array('icon-phone2'=>'icon-phone2'),array('icon-phone-hang-up2'=>'icon-phone-hang-up2'),array('icon-address-book2'=>'icon-address-book2'),array('icon-envelop2'=>'icon-envelop2'),array('icon-pushpin2'=>'icon-pushpin2'),array('icon-location3'=>'icon-location3'),array('icon-location22'=>'icon-location22'),array('icon-compass32'=>'icon-compass32'),array('icon-compass22'=>'icon-compass22'),array('icon-map3'=>'icon-map3'),array('icon-map22'=>'icon-map22'),array('icon-history2'=>'icon-history2'),array('icon-clock3'=>'icon-clock3'),array('icon-clock22'=>'icon-clock22'),array('icon-alarm2'=>'icon-alarm2'),array('icon-bell2'=>'icon-bell2'),array('icon-stopwatch2'=>'icon-stopwatch2'),array('icon-calendar22'=>'icon-calendar22'),array('icon-printer2'=>'icon-printer2'),array('icon-keyboard2'=>'icon-keyboard2'),array('icon-display2'=>'icon-display2'),array('icon-laptop2'=>'icon-laptop2'),array('icon-mobile3'=>'icon-mobile3'),array('icon-mobile22'=>'icon-mobile22'),array('icon-tablet2'=>'icon-tablet2'),array('icon-tv2'=>'icon-tv2'),array('icon-drawer3'=>'icon-drawer3'),array('icon-drawer22'=>'icon-drawer22'),array('icon-box-add2'=>'icon-box-add2'),array('icon-box-remove2'=>'icon-box-remove2'),array('icon-download4'=>'icon-download4'),array('icon-upload4'=>'icon-upload4'),array('icon-floppy-disk2'=>'icon-floppy-disk2'),array('icon-drive2'=>'icon-drive2'),array('icon-database2'=>'icon-database2'),array('icon-undo3'=>'icon-undo3'),array('icon-redo3'=>'icon-redo3'),array('icon-undo22'=>'icon-undo22'),array('icon-redo22'=>'icon-redo22'),array('icon-forward4'=>'icon-forward4'),array('icon-reply2'=>'icon-reply2'),array('icon-bubble3'=>'icon-bubble3'),array('icon-bubbles5'=>'icon-bubbles5'),array('icon-bubbles22'=>'icon-bubbles22'),array('icon-bubble22'=>'icon-bubble22'),array('icon-bubbles32'=>'icon-bubbles32'),array('icon-bubbles42'=>'icon-bubbles42'),array('icon-user22'=>'icon-user22'),array('icon-users22'=>'icon-users22'),array('icon-user-plus2'=>'icon-user-plus2'),array('icon-user-minus2'=>'icon-user-minus2'),array('icon-user-check2'=>'icon-user-check2'),array('icon-user-tie2'=>'icon-user-tie2'),array('icon-quotes-left2'=>'icon-quotes-left2'),array('icon-quotes-right2'=>'icon-quotes-right2'),array('icon-hour-glass2'=>'icon-hour-glass2'),array('icon-spinner12'=>'icon-spinner12'),array('icon-spinner22'=>'icon-spinner22'),array('icon-spinner32'=>'icon-spinner32'),array('icon-spinner42'=>'icon-spinner42'),array('icon-spinner52'=>'icon-spinner52'),array('icon-spinner62'=>'icon-spinner62'),array('icon-spinner72'=>'icon-spinner72'),array('icon-spinner82'=>'icon-spinner82'),array('icon-spinner92'=>'icon-spinner92'),array('icon-spinner102'=>'icon-spinner102'),array('icon-spinner112'=>'icon-spinner112'),array('icon-binoculars2'=>'icon-binoculars2'),array('icon-search2'=>'icon-search2'),array('icon-zoom-in2'=>'icon-zoom-in2'),array('icon-zoom-out2'=>'icon-zoom-out2'),array('icon-enlarge3'=>'icon-enlarge3'),array('icon-shrink3'=>'icon-shrink3'),array('icon-enlarge22'=>'icon-enlarge22'),array('icon-shrink22'=>'icon-shrink22'),array('icon-key32'=>'icon-key32'),array('icon-key22'=>'icon-key22'),array('icon-lock22'=>'icon-lock22'),array('icon-unlocked2'=>'icon-unlocked2'),array('icon-wrench22'=>'icon-wrench22'),array('icon-equalizer3'=>'icon-equalizer3'),array('icon-equalizer22'=>'icon-equalizer22'),array('icon-cog2'=>'icon-cog2'),array('icon-cogs2'=>'icon-cogs2'),array('icon-hammer3'=>'icon-hammer3'),array('icon-magic-wand2'=>'icon-magic-wand2'),array('icon-aid-kit2'=>'icon-aid-kit2'),array('icon-bug2'=>'icon-bug2'),array('icon-pie-chart2'=>'icon-pie-chart2'),array('icon-stats-dots2'=>'icon-stats-dots2'),array('icon-stats-bars3'=>'icon-stats-bars3'),array('icon-stats-bars22'=>'icon-stats-bars22'),array('icon-trophy2'=>'icon-trophy2'),array('icon-gift2'=>'icon-gift2'),array('icon-glass3'=>'icon-glass3'),array('icon-glass22'=>'icon-glass22'),array('icon-mug2'=>'icon-mug2'),array('icon-spoon-knife2'=>'icon-spoon-knife2'),array('icon-leaf2'=>'icon-leaf2'),array('icon-rocket2'=>'icon-rocket2'),array('icon-meter3'=>'icon-meter3'),array('icon-meter22'=>'icon-meter22'),array('icon-hammer22'=>'icon-hammer22'),array('icon-fire2'=>'icon-fire2'),array('icon-lab2'=>'icon-lab2'),array('icon-magnet2'=>'icon-magnet2'),array('icon-bin3'=>'icon-bin3'),array('icon-bin22'=>'icon-bin22'),array('icon-briefcase2'=>'icon-briefcase2'),array('icon-airplane2'=>'icon-airplane2'),array('icon-truck2'=>'icon-truck2'),array('icon-road2'=>'icon-road2'),array('icon-accessibility2'=>'icon-accessibility2'),array('icon-target2'=>'icon-target2'),array('icon-shield2'=>'icon-shield2'),array('icon-power2'=>'icon-power2'),array('icon-switch2'=>'icon-switch2'),array('icon-power-cord2'=>'icon-power-cord2'),array('icon-clipboard2'=>'icon-clipboard2'),array('icon-list-numbered2'=>'icon-list-numbered2'),array('icon-list3'=>'icon-list3'),array('icon-list22'=>'icon-list22'),array('icon-tree2'=>'icon-tree2'),array('icon-menu5'=>'icon-menu5'),array('icon-menu22'=>'icon-menu22'),array('icon-menu32'=>'icon-menu32'),array('icon-menu42'=>'icon-menu42'),array('icon-cloud2'=>'icon-cloud2'),array('icon-cloud-download2'=>'icon-cloud-download2'),array('icon-cloud-upload2'=>'icon-cloud-upload2'),array('icon-cloud-check2'=>'icon-cloud-check2'),array('icon-download22'=>'icon-download22'),array('icon-upload22'=>'icon-upload22'),array('icon-download32'=>'icon-download32'),array('icon-upload32'=>'icon-upload32'),array('icon-sphere2'=>'icon-sphere2'),array('icon-earth2'=>'icon-earth2'),array('icon-link2'=>'icon-link2'),array('icon-flag2'=>'icon-flag2'),array('icon-attachment2'=>'icon-attachment2'),array('icon-eye2'=>'icon-eye2'),array('icon-eye-plus2'=>'icon-eye-plus2'),array('icon-eye-minus2'=>'icon-eye-minus2'),array('icon-eye-blocked2'=>'icon-eye-blocked2'),array('icon-bookmark2'=>'icon-bookmark2'),array('icon-bookmarks2'=>'icon-bookmarks2'),array('icon-sun2'=>'icon-sun2'),array('icon-contrast2'=>'icon-contrast2'),array('icon-brightness-contrast2'=>'icon-brightness-contrast2'),array('icon-star-empty2'=>'icon-star-empty2'),array('icon-star-half2'=>'icon-star-half2'),array('icon-star-full2'=>'icon-star-full2'),array('icon-heart2'=>'icon-heart2'),array('icon-heart-broken2'=>'icon-heart-broken2'),array('icon-man2'=>'icon-man2'),array('icon-woman2'=>'icon-woman2'),array('icon-man-woman2'=>'icon-man-woman2'),array('icon-happy3'=>'icon-happy3'),array('icon-happy22'=>'icon-happy22'),array('icon-smile3'=>'icon-smile3'),array('icon-smile22'=>'icon-smile22'),array('icon-tongue3'=>'icon-tongue3'),array('icon-tongue22'=>'icon-tongue22'),array('icon-sad3'=>'icon-sad3'),array('icon-sad22'=>'icon-sad22'),array('icon-wink3'=>'icon-wink3'),array('icon-wink22'=>'icon-wink22'),array('icon-grin3'=>'icon-grin3'),array('icon-grin22'=>'icon-grin22'),array('icon-cool3'=>'icon-cool3'),array('icon-cool22'=>'icon-cool22'),array('icon-angry3'=>'icon-angry3'),array('icon-angry22'=>'icon-angry22'),array('icon-evil3'=>'icon-evil3'),array('icon-evil22'=>'icon-evil22'),array('icon-shocked3'=>'icon-shocked3'),array('icon-shocked22'=>'icon-shocked22'),array('icon-baffled3'=>'icon-baffled3'),array('icon-baffled22'=>'icon-baffled22'),array('icon-confused3'=>'icon-confused3'),array('icon-confused22'=>'icon-confused22'),array('icon-neutral3'=>'icon-neutral3'),array('icon-neutral22'=>'icon-neutral22'),array('icon-hipster3'=>'icon-hipster3'),array('icon-hipster22'=>'icon-hipster22'),array('icon-wondering3'=>'icon-wondering3'),array('icon-wondering22'=>'icon-wondering22'),array('icon-sleepy3'=>'icon-sleepy3'),array('icon-sleepy22'=>'icon-sleepy22'),array('icon-frustrated3'=>'icon-frustrated3'),array('icon-frustrated22'=>'icon-frustrated22'),array('icon-crying3'=>'icon-crying3'),array('icon-crying22'=>'icon-crying22'),array('icon-point-up2'=>'icon-point-up2'),array('icon-point-right2'=>'icon-point-right2'),array('icon-point-down2'=>'icon-point-down2'),array('icon-point-left2'=>'icon-point-left2'),array('icon-warning2'=>'icon-warning2'),array('icon-notification2'=>'icon-notification2'),array('icon-question2'=>'icon-question2'),array('icon-plus2'=>'icon-plus2'),array('icon-minus2'=>'icon-minus2'),array('icon-info2'=>'icon-info2'),array('icon-cancel-circle2'=>'icon-cancel-circle2'),array('icon-blocked2'=>'icon-blocked2'),array('icon-cross2'=>'icon-cross2'),array('icon-checkmark3'=>'icon-checkmark3'),array('icon-checkmark22'=>'icon-checkmark22'),array('icon-spell-check2'=>'icon-spell-check2'),array('icon-enter2'=>'icon-enter2'),array('icon-exit2'=>'icon-exit2'),array('icon-play22'=>'icon-play22'),array('icon-pause3'=>'icon-pause3'),array('icon-stop3'=>'icon-stop3'),array('icon-previous3'=>'icon-previous3'),array('icon-next33'=>'icon-next33'),array('icon-backward3'=>'icon-backward3'),array('icon-forward22'=>'icon-forward22'),array('icon-play32'=>'icon-play32'),array('icon-pause22'=>'icon-pause22'),array('icon-stop22'=>'icon-stop22'),array('icon-backward22'=>'icon-backward22'),array('icon-forward32'=>'icon-forward32'),array('icon-first2'=>'icon-first2'),array('icon-last2'=>'icon-last2'),array('icon-previous22'=>'icon-previous22'),array('icon-next22'=>'icon-next22'),array('icon-eject2'=>'icon-eject2'),array('icon-volume-high2'=>'icon-volume-high2'),array('icon-volume-medium2'=>'icon-volume-medium2'),array('icon-volume-low2'=>'icon-volume-low2'),array('icon-volume-mute3'=>'icon-volume-mute3'),array('icon-volume-mute22'=>'icon-volume-mute22'),array('icon-volume-increase2'=>'icon-volume-increase2'),array('icon-volume-decrease2'=>'icon-volume-decrease2'),array('icon-loop3'=>'icon-loop3'),array('icon-loop22'=>'icon-loop22'),array('icon-infinite2'=>'icon-infinite2'),array('icon-shuffle2'=>'icon-shuffle2'),array('icon-arrow-up-left3'=>'icon-arrow-up-left3'),array('icon-arrow-up3'=>'icon-arrow-up3'),array('icon-arrow-up-right3'=>'icon-arrow-up-right3'),array('icon-arrow-right3'=>'icon-arrow-right3'),array('icon-arrow-down-right3'=>'icon-arrow-down-right3'),array('icon-arrow-down3'=>'icon-arrow-down3'),array('icon-arrow-down-left3'=>'icon-arrow-down-left3'),array('icon-arrow-left3'=>'icon-arrow-left3'),array('icon-arrow-up-left22'=>'icon-arrow-up-left22'),array('icon-arrow-up22'=>'icon-arrow-up22'),array('icon-arrow-up-right22'=>'icon-arrow-up-right22'),array('icon-arrow-right22'=>'icon-arrow-right22'),array('icon-arrow-down-right22'=>'icon-arrow-down-right22'),array('icon-arrow-down22'=>'icon-arrow-down22'),array('icon-arrow-down-left22'=>'icon-arrow-down-left22'),array('icon-arrow-left22'=>'icon-arrow-left22'),array('icon-circle-up2'=>'icon-circle-up2'),array('icon-circle-right2'=>'icon-circle-right2'),array('icon-circle-down2'=>'icon-circle-down2'),array('icon-circle-left2'=>'icon-circle-left2'),array('icon-tab2'=>'icon-tab2'),array('icon-move-up2'=>'icon-move-up2'),array('icon-move-down2'=>'icon-move-down2'),array('icon-sort-alpha-asc2'=>'icon-sort-alpha-asc2'),array('icon-sort-alpha-desc2'=>'icon-sort-alpha-desc2'),array('icon-sort-numeric-asc2'=>'icon-sort-numeric-asc2'),array('icon-sort-numberic-desc2'=>'icon-sort-numberic-desc2'),array('icon-sort-amount-asc2'=>'icon-sort-amount-asc2'),array('icon-sort-amount-desc2'=>'icon-sort-amount-desc2'),array('icon-command2'=>'icon-command2'),array('icon-shift2'=>'icon-shift2'),array('icon-ctrl2'=>'icon-ctrl2'),array('icon-opt2'=>'icon-opt2'),array('icon-checkbox-checked2'=>'icon-checkbox-checked2'),array('icon-checkbox-unchecked2'=>'icon-checkbox-unchecked2'),array('icon-radio-checked3'=>'icon-radio-checked3'),array('icon-radio-checked22'=>'icon-radio-checked22'),array('icon-radio-unchecked2'=>'icon-radio-unchecked2'),array('icon-crop2'=>'icon-crop2'),array('icon-make-group2'=>'icon-make-group2'),array('icon-ungroup2'=>'icon-ungroup2'),array('icon-scissors2'=>'icon-scissors2'),array('icon-filter2'=>'icon-filter2'),array('icon-font2'=>'icon-font2'),array('icon-ligature3'=>'icon-ligature3'),array('icon-ligature22'=>'icon-ligature22'),array('icon-text-height2'=>'icon-text-height2'),array('icon-text-width2'=>'icon-text-width2'),array('icon-font-size2'=>'icon-font-size2'),array('icon-bold2'=>'icon-bold2'),array('icon-underline2'=>'icon-underline2'),array('icon-italic2'=>'icon-italic2'),array('icon-strikethrough2'=>'icon-strikethrough2'),array('icon-omega2'=>'icon-omega2'),array('icon-sigma2'=>'icon-sigma2'),array('icon-page-break2'=>'icon-page-break2'),array('icon-superscript3'=>'icon-superscript3'),array('icon-subscript3'=>'icon-subscript3'),array('icon-superscript22'=>'icon-superscript22'),array('icon-subscript22'=>'icon-subscript22'),array('icon-text-color2'=>'icon-text-color2'),array('icon-pagebreak2'=>'icon-pagebreak2'),array('icon-clear-formatting2'=>'icon-clear-formatting2'),array('icon-table3'=>'icon-table3'),array('icon-table22'=>'icon-table22'),array('icon-insert-template2'=>'icon-insert-template2'),array('icon-pilcrow2'=>'icon-pilcrow2'),array('icon-ltr2'=>'icon-ltr2'),array('icon-rtl2'=>'icon-rtl2'),array('icon-section2'=>'icon-section2'),array('icon-paragraph-left2'=>'icon-paragraph-left2'),array('icon-paragraph-center2'=>'icon-paragraph-center2'),array('icon-paragraph-right2'=>'icon-paragraph-right2'),array('icon-paragraph-justify2'=>'icon-paragraph-justify2'),array('icon-indent-increase2'=>'icon-indent-increase2'),array('icon-indent-decrease2'=>'icon-indent-decrease2'),array('icon-share3'=>'icon-share3'),array('icon-new-tab2'=>'icon-new-tab2'),array('icon-embed3'=>'icon-embed3'),array('icon-embed22'=>'icon-embed22'),array('icon-terminal2'=>'icon-terminal2'),array('icon-share22'=>'icon-share22'),array('icon-mail5'=>'icon-mail5'),array('icon-mail22'=>'icon-mail22'),array('icon-mail32'=>'icon-mail32'),array('icon-mail42'=>'icon-mail42'),array('icon-amazon2'=>'icon-amazon2'),array('icon-google4'=>'icon-google4'),array('icon-google22'=>'icon-google22'),array('icon-google32'=>'icon-google32'),array('icon-google-plus4'=>'icon-google-plus4'),array('icon-google-plus22'=>'icon-google-plus22'),array('icon-google-plus32'=>'icon-google-plus32'),array('icon-hangouts2'=>'icon-hangouts2'),array('icon-google-drive2'=>'icon-google-drive2'),array('icon-facebook3'=>'icon-facebook3'),array('icon-facebook22'=>'icon-facebook22'),array('icon-instagram2'=>'icon-instagram2'),array('icon-whatsapp2'=>'icon-whatsapp2'),array('icon-spotify2'=>'icon-spotify2'),array('icon-telegram2'=>'icon-telegram2'),array('icon-twitter2'=>'icon-twitter2'),array('icon-vine2'=>'icon-vine2'),array('icon-vk2'=>'icon-vk2'),array('icon-renren2'=>'icon-renren2'),array('icon-sina-weibo2'=>'icon-sina-weibo2'),array('icon-rss3'=>'icon-rss3'),array('icon-rss22'=>'icon-rss22'),array('icon-youtube3'=>'icon-youtube3'),array('icon-youtube22'=>'icon-youtube22'),array('icon-twitch2'=>'icon-twitch2'),array('icon-vimeo3'=>'icon-vimeo3'),array('icon-vimeo22'=>'icon-vimeo22'),array('icon-lanyrd2'=>'icon-lanyrd2'),array('icon-flickr5'=>'icon-flickr5'),array('icon-flickr22'=>'icon-flickr22'),array('icon-flickr32'=>'icon-flickr32'),array('icon-flickr42'=>'icon-flickr42'),array('icon-dribbble2'=>'icon-dribbble2'),array('icon-behance3'=>'icon-behance3'),array('icon-behance22'=>'icon-behance22'),array('icon-deviantart2'=>'icon-deviantart2'),array('icon-500px2'=>'icon-500px2'),array('icon-steam3'=>'icon-steam3'),array('icon-steam22'=>'icon-steam22'),array('icon-dropbox2'=>'icon-dropbox2'),array('icon-onedrive2'=>'icon-onedrive2'),array('icon-github2'=>'icon-github2'),array('icon-npm2'=>'icon-npm2'),array('icon-basecamp2'=>'icon-basecamp2'),array('icon-trello2'=>'icon-trello2'),array('icon-wordpress2'=>'icon-wordpress2'),array('icon-joomla2'=>'icon-joomla2'),array('icon-ello2'=>'icon-ello2'),array('icon-blogger3'=>'icon-blogger3'),array('icon-blogger22'=>'icon-blogger22'),array('icon-tumblr3'=>'icon-tumblr3'),array('icon-tumblr22'=>'icon-tumblr22'),array('icon-yahoo3'=>'icon-yahoo3'),array('icon-yahoo22'=>'icon-yahoo22'),array('icon-tux2'=>'icon-tux2'),array('icon-appleinc2'=>'icon-appleinc2'),array('icon-finder2'=>'icon-finder2'),array('icon-android2'=>'icon-android2'),array('icon-windows2'=>'icon-windows2'),array('icon-windows82'=>'icon-windows82'),array('icon-soundcloud3'=>'icon-soundcloud3'),array('icon-soundcloud22'=>'icon-soundcloud22'),array('icon-skype2'=>'icon-skype2'),array('icon-reddit2'=>'icon-reddit2'),array('icon-hackernews2'=>'icon-hackernews2'),array('icon-wikipedia2'=>'icon-wikipedia2'),array('icon-linkedin3'=>'icon-linkedin3'),array('icon-linkedin22'=>'icon-linkedin22'),array('icon-lastfm3'=>'icon-lastfm3'),array('icon-lastfm22'=>'icon-lastfm22'),array('icon-delicious2'=>'icon-delicious2'),array('icon-stumbleupon3'=>'icon-stumbleupon3'),array('icon-stumbleupon22'=>'icon-stumbleupon22'),array('icon-stackoverflow2'=>'icon-stackoverflow2'),array('icon-pinterest3'=>'icon-pinterest3'),array('icon-pinterest22'=>'icon-pinterest22'),array('icon-xing3'=>'icon-xing3'),array('icon-xing22'=>'icon-xing22'),array('icon-flattr2'=>'icon-flattr2'),array('icon-foursquare2'=>'icon-foursquare2'),array('icon-yelp2'=>'icon-yelp2'),array('icon-paypal2'=>'icon-paypal2'),array('icon-chrome2'=>'icon-chrome2'),array('icon-firefox2'=>'icon-firefox2'),array('icon-IE2'=>'icon-IE2'),array('icon-edge2'=>'icon-edge2'),array('icon-safari2'=>'icon-safari2'),array('icon-opera2'=>'icon-opera2'),array('icon-file-pdf2'=>'icon-file-pdf2'),array('icon-file-openoffice2'=>'icon-file-openoffice2'),array('icon-file-word2'=>'icon-file-word2'),array('icon-file-excel2'=>'icon-file-excel2'),array('icon-libreoffice2'=>'icon-libreoffice2'),array('icon-html-five3'=>'icon-html-five3'),array('icon-html-five22'=>'icon-html-five22'),array('icon-css32'=>'icon-css32'),array('icon-git2'=>'icon-git2'),array('icon-codepen2'=>'icon-codepen2'),array('icon-svg2'=>'icon-svg2'),array('icon-IcoMoon2'=>'icon-IcoMoon2'),array('icon-home'=>'icon-home'),array('icon-home2'=>'icon-home2'),array('icon-home3'=>'icon-home3'),array('icon-office'=>'icon-office'),array('icon-newspaper'=>'icon-newspaper'),array('icon-pencil'=>'icon-pencil'),array('icon-pencil2'=>'icon-pencil2'),array('icon-quill'=>'icon-quill'),array('icon-pen'=>'icon-pen'),array('icon-blog'=>'icon-blog'),array('icon-eyedropper'=>'icon-eyedropper'),array('icon-droplet'=>'icon-droplet'),array('icon-paint-format'=>'icon-paint-format'),array('icon-image'=>'icon-image'),array('icon-images'=>'icon-images'),array('icon-camera'=>'icon-camera'),array('icon-headphones'=>'icon-headphones'),array('icon-music'=>'icon-music'),array('icon-play'=>'icon-play'),array('icon-film'=>'icon-film'),array('icon-video-camera'=>'icon-video-camera'),array('icon-dice'=>'icon-dice'),array('icon-pacman'=>'icon-pacman'),array('icon-spades'=>'icon-spades'),array('icon-clubs'=>'icon-clubs'),array('icon-diamonds'=>'icon-diamonds'),array('icon-bullhorn'=>'icon-bullhorn'),array('icon-connection'=>'icon-connection'),array('icon-podcast'=>'icon-podcast'),array('icon-feed'=>'icon-feed'),array('icon-mic'=>'icon-mic'),array('icon-book'=>'icon-book'),array('icon-books'=>'icon-books'),array('icon-library'=>'icon-library'),array('icon-file-text'=>'icon-file-text'),array('icon-profile'=>'icon-profile'),array('icon-file-empty'=>'icon-file-empty'),array('icon-files-empty'=>'icon-files-empty'),array('icon-file-text2'=>'icon-file-text2'),array('icon-file-picture'=>'icon-file-picture'),array('icon-file-music'=>'icon-file-music'),array('icon-file-play'=>'icon-file-play'),array('icon-file-video'=>'icon-file-video'),array('icon-file-zip'=>'icon-file-zip'),array('icon-copy'=>'icon-copy'),array('icon-paste'=>'icon-paste'),array('icon-stack'=>'icon-stack'),array('icon-folder'=>'icon-folder'),array('icon-folder-open'=>'icon-folder-open'),array('icon-folder-plus'=>'icon-folder-plus'),array('icon-folder-minus'=>'icon-folder-minus'),array('icon-folder-download'=>'icon-folder-download'),array('icon-folder-upload'=>'icon-folder-upload'),array('icon-price-tag'=>'icon-price-tag'),array('icon-price-tags'=>'icon-price-tags'),array('icon-barcode'=>'icon-barcode'),array('icon-qrcode'=>'icon-qrcode'),array('icon-ticket'=>'icon-ticket'),array('icon-cart'=>'icon-cart'),array('icon-coin-dollar'=>'icon-coin-dollar'),array('icon-coin-euro'=>'icon-coin-euro'),array('icon-coin-pound'=>'icon-coin-pound'),array('icon-coin-yen'=>'icon-coin-yen'),array('icon-credit-card'=>'icon-credit-card'),array('icon-calculator'=>'icon-calculator'),array('icon-lifebuoy'=>'icon-lifebuoy'),array('icon-phone'=>'icon-phone'),array('icon-phone-hang-up'=>'icon-phone-hang-up'),array('icon-address-book'=>'icon-address-book'),array('icon-envelop'=>'icon-envelop'),array('icon-pushpin'=>'icon-pushpin'),array('icon-location'=>'icon-location'),array('icon-location2'=>'icon-location2'),array('icon-compass'=>'icon-compass'),array('icon-compass2'=>'icon-compass2'),array('icon-map'=>'icon-map'),array('icon-map2'=>'icon-map2'),array('icon-history'=>'icon-history'),array('icon-clock'=>'icon-clock'),array('icon-clock2'=>'icon-clock2'),array('icon-alarm'=>'icon-alarm'),array('icon-bell'=>'icon-bell'),array('icon-stopwatch'=>'icon-stopwatch'),array('icon-calendar'=>'icon-calendar'),array('icon-printer'=>'icon-printer'),array('icon-keyboard'=>'icon-keyboard'),array('icon-display'=>'icon-display'),array('icon-laptop'=>'icon-laptop'),array('icon-mobile'=>'icon-mobile'),array('icon-mobile2'=>'icon-mobile2'),array('icon-tablet'=>'icon-tablet'),array('icon-tv'=>'icon-tv'),array('icon-drawer'=>'icon-drawer'),array('icon-drawer2'=>'icon-drawer2'),array('icon-box-add'=>'icon-box-add'),array('icon-box-remove'=>'icon-box-remove'),array('icon-download'=>'icon-download'),array('icon-upload'=>'icon-upload'),array('icon-floppy-disk'=>'icon-floppy-disk'),array('icon-drive'=>'icon-drive'),array('icon-database'=>'icon-database'),array('icon-undo'=>'icon-undo'),array('icon-redo'=>'icon-redo'),array('icon-undo2'=>'icon-undo2'),array('icon-redo2'=>'icon-redo2'),array('icon-forward'=>'icon-forward'),array('icon-reply'=>'icon-reply'),array('icon-bubble'=>'icon-bubble'),array('icon-bubbles'=>'icon-bubbles'),array('icon-bubbles2'=>'icon-bubbles2'),array('icon-bubble2'=>'icon-bubble2'),array('icon-bubbles3'=>'icon-bubbles3'),array('icon-bubbles4'=>'icon-bubbles4'),array('icon-user'=>'icon-user'),array('icon-users'=>'icon-users'),array('icon-user-plus'=>'icon-user-plus'),array('icon-user-minus'=>'icon-user-minus'),array('icon-user-check'=>'icon-user-check'),array('icon-user-tie'=>'icon-user-tie'),array('icon-quotes-left'=>'icon-quotes-left'),array('icon-quotes-right'=>'icon-quotes-right'),array('icon-hour-glass'=>'icon-hour-glass'),array('icon-spinner'=>'icon-spinner'),array('icon-spinner2'=>'icon-spinner2'),array('icon-spinner3'=>'icon-spinner3'),array('icon-spinner4'=>'icon-spinner4'),array('icon-spinner5'=>'icon-spinner5'),array('icon-spinner6'=>'icon-spinner6'),array('icon-spinner7'=>'icon-spinner7'),array('icon-spinner8'=>'icon-spinner8'),array('icon-spinner9'=>'icon-spinner9'),array('icon-spinner10'=>'icon-spinner10'),array('icon-spinner11'=>'icon-spinner11'),array('icon-binoculars'=>'icon-binoculars'),array('icon-search'=>'icon-search'),array('icon-zoom-in'=>'icon-zoom-in'),array('icon-zoom-out'=>'icon-zoom-out'),array('icon-enlarge'=>'icon-enlarge'),array('icon-shrink'=>'icon-shrink'),array('icon-enlarge2'=>'icon-enlarge2'),array('icon-shrink2'=>'icon-shrink2'),array('icon-key'=>'icon-key'),array('icon-key2'=>'icon-key2'),array('icon-lock'=>'icon-lock'),array('icon-unlocked'=>'icon-unlocked'),array('icon-wrench'=>'icon-wrench'),array('icon-equalizer'=>'icon-equalizer'),array('icon-equalizer2'=>'icon-equalizer2'),array('icon-cog'=>'icon-cog'),array('icon-cogs'=>'icon-cogs'),array('icon-hammer'=>'icon-hammer'),array('icon-magic-wand'=>'icon-magic-wand'),array('icon-aid-kit'=>'icon-aid-kit'),array('icon-bug'=>'icon-bug'),array('icon-pie-chart'=>'icon-pie-chart'),array('icon-stats-dots'=>'icon-stats-dots'),array('icon-stats-bars'=>'icon-stats-bars'),array('icon-stats-bars2'=>'icon-stats-bars2'),array('icon-trophy'=>'icon-trophy'),array('icon-gift'=>'icon-gift'),array('icon-glass'=>'icon-glass'),array('icon-glass2'=>'icon-glass2'),array('icon-mug'=>'icon-mug'),array('icon-spoon-knife'=>'icon-spoon-knife'),array('icon-leaf'=>'icon-leaf'),array('icon-rocket'=>'icon-rocket'),array('icon-meter'=>'icon-meter'),array('icon-meter2'=>'icon-meter2'),array('icon-hammer2'=>'icon-hammer2'),array('icon-fire'=>'icon-fire'),array('icon-lab'=>'icon-lab'),array('icon-magnet'=>'icon-magnet'),array('icon-bin'=>'icon-bin'),array('icon-bin2'=>'icon-bin2'),array('icon-briefcase'=>'icon-briefcase'),array('icon-airplane'=>'icon-airplane'),array('icon-truck'=>'icon-truck'),array('icon-road'=>'icon-road'),array('icon-accessibility'=>'icon-accessibility'),array('icon-target'=>'icon-target'),array('icon-shield'=>'icon-shield'),array('icon-power'=>'icon-power'),array('icon-switch'=>'icon-switch'),array('icon-power-cord'=>'icon-power-cord'),array('icon-clipboard'=>'icon-clipboard'),array('icon-list-numbered'=>'icon-list-numbered'),array('icon-list'=>'icon-list'),array('icon-list2'=>'icon-list2'),array('icon-tree'=>'icon-tree'),array('icon-menu'=>'icon-menu'),array('icon-menu2'=>'icon-menu2'),array('icon-menu3'=>'icon-menu3'),array('icon-menu4'=>'icon-menu4'),array('icon-cloud'=>'icon-cloud'),array('icon-cloud-download'=>'icon-cloud-download'),array('icon-cloud-upload'=>'icon-cloud-upload'),array('icon-cloud-check'=>'icon-cloud-check'),array('icon-download2'=>'icon-download2'),array('icon-upload2'=>'icon-upload2'),array('icon-download3'=>'icon-download3'),array('icon-upload3'=>'icon-upload3'),array('icon-sphere'=>'icon-sphere'),array('icon-earth'=>'icon-earth'),array('icon-link'=>'icon-link'),array('icon-flag'=>'icon-flag'),array('icon-attachment'=>'icon-attachment'),array('icon-eye'=>'icon-eye'),array('icon-eye-plus'=>'icon-eye-plus'),array('icon-eye-minus'=>'icon-eye-minus'),array('icon-eye-blocked'=>'icon-eye-blocked'),array('icon-bookmark'=>'icon-bookmark'),array('icon-bookmarks'=>'icon-bookmarks'),array('icon-sun'=>'icon-sun'),array('icon-contrast'=>'icon-contrast'),array('icon-brightness-contrast'=>'icon-brightness-contrast'),array('icon-star-empty'=>'icon-star-empty'),array('icon-star-half'=>'icon-star-half'),array('icon-star-full'=>'icon-star-full'),array('icon-heart'=>'icon-heart'),array('icon-heart-broken'=>'icon-heart-broken'),array('icon-man'=>'icon-man'),array('icon-woman'=>'icon-woman'),array('icon-man-woman'=>'icon-man-woman'),array('icon-happy'=>'icon-happy'),array('icon-happy2'=>'icon-happy2'),array('icon-smile'=>'icon-smile'),array('icon-smile2'=>'icon-smile2'),array('icon-tongue'=>'icon-tongue'),array('icon-tongue2'=>'icon-tongue2'),array('icon-sad'=>'icon-sad'),array('icon-sad2'=>'icon-sad2'),array('icon-wink'=>'icon-wink'),array('icon-wink2'=>'icon-wink2'),array('icon-grin'=>'icon-grin'),array('icon-grin2'=>'icon-grin2'),array('icon-cool'=>'icon-cool'),array('icon-cool2'=>'icon-cool2'),array('icon-angry'=>'icon-angry'),array('icon-angry2'=>'icon-angry2'),array('icon-evil'=>'icon-evil'),array('icon-evil2'=>'icon-evil2'),array('icon-shocked'=>'icon-shocked'),array('icon-shocked2'=>'icon-shocked2'),array('icon-baffled'=>'icon-baffled'),array('icon-baffled2'=>'icon-baffled2'),array('icon-confused'=>'icon-confused'),array('icon-confused2'=>'icon-confused2'),array('icon-neutral'=>'icon-neutral'),array('icon-neutral2'=>'icon-neutral2'),array('icon-hipster'=>'icon-hipster'),array('icon-hipster2'=>'icon-hipster2'),array('icon-wondering'=>'icon-wondering'),array('icon-wondering2'=>'icon-wondering2'),array('icon-sleepy'=>'icon-sleepy'),array('icon-sleepy2'=>'icon-sleepy2'),array('icon-frustrated'=>'icon-frustrated'),array('icon-frustrated2'=>'icon-frustrated2'),array('icon-crying'=>'icon-crying'),array('icon-crying2'=>'icon-crying2'),array('icon-point-up'=>'icon-point-up'),array('icon-point-right'=>'icon-point-right'),array('icon-point-down'=>'icon-point-down'),array('icon-point-left'=>'icon-point-left'),array('icon-warning'=>'icon-warning'),array('icon-notification'=>'icon-notification'),array('icon-question'=>'icon-question'),array('icon-plus'=>'icon-plus'),array('icon-minus'=>'icon-minus'),array('icon-info'=>'icon-info'),array('icon-cancel-circle'=>'icon-cancel-circle'),array('icon-blocked'=>'icon-blocked'),array('icon-cross'=>'icon-cross'),array('icon-checkmark'=>'icon-checkmark'),array('icon-checkmark2'=>'icon-checkmark2'),array('icon-spell-check'=>'icon-spell-check'),array('icon-enter'=>'icon-enter'),array('icon-exit'=>'icon-exit'),array('icon-play2'=>'icon-play2'),array('icon-pause'=>'icon-pause'),array('icon-stop'=>'icon-stop'),array('icon-previous'=>'icon-previous'),array('icon-next'=>'icon-next'),array('icon-backward'=>'icon-backward'),array('icon-forward2'=>'icon-forward2'),array('icon-play3'=>'icon-play3'),array('icon-pause2'=>'icon-pause2'),array('icon-stop2'=>'icon-stop2'),array('icon-backward2'=>'icon-backward2'),array('icon-forward3'=>'icon-forward3'),array('icon-first'=>'icon-first'),array('icon-last'=>'icon-last'),array('icon-previous2'=>'icon-previous2'),array('icon-next2'=>'icon-next2'),array('icon-eject'=>'icon-eject'),array('icon-volume-high'=>'icon-volume-high'),array('icon-volume-medium'=>'icon-volume-medium'),array('icon-volume-low'=>'icon-volume-low'),array('icon-volume-mute'=>'icon-volume-mute'),array('icon-volume-mute2'=>'icon-volume-mute2'),array('icon-volume-increase'=>'icon-volume-increase'),array('icon-volume-decrease'=>'icon-volume-decrease'),array('icon-loop'=>'icon-loop'),array('icon-loop2'=>'icon-loop2'),array('icon-infinite'=>'icon-infinite'),array('icon-shuffle'=>'icon-shuffle'),array('icon-arrow-up-left'=>'icon-arrow-up-left'),array('icon-arrow-up'=>'icon-arrow-up'),array('icon-arrow-up-right'=>'icon-arrow-up-right'),array('icon-arrow-right'=>'icon-arrow-right'),array('icon-arrow-down-right'=>'icon-arrow-down-right'),array('icon-arrow-down'=>'icon-arrow-down'),array('icon-arrow-down-left'=>'icon-arrow-down-left'),array('icon-arrow-left'=>'icon-arrow-left'),array('icon-arrow-up-left2'=>'icon-arrow-up-left2'),array('icon-arrow-up2'=>'icon-arrow-up2'),array('icon-arrow-up-right2'=>'icon-arrow-up-right2'),array('icon-arrow-right2'=>'icon-arrow-right2'),array('icon-arrow-down-right2'=>'icon-arrow-down-right2'),array('icon-arrow-down2'=>'icon-arrow-down2'),array('icon-arrow-down-left2'=>'icon-arrow-down-left2'),array('icon-arrow-left2'=>'icon-arrow-left2'),array('icon-circle-up'=>'icon-circle-up'),array('icon-circle-right'=>'icon-circle-right'),array('icon-circle-down'=>'icon-circle-down'),array('icon-circle-left'=>'icon-circle-left'),array('icon-tab'=>'icon-tab'),array('icon-move-up'=>'icon-move-up'),array('icon-move-down'=>'icon-move-down'),array('icon-sort-alpha-asc'=>'icon-sort-alpha-asc'),array('icon-sort-alpha-desc'=>'icon-sort-alpha-desc'),array('icon-sort-numeric-asc'=>'icon-sort-numeric-asc'),array('icon-sort-numberic-desc'=>'icon-sort-numberic-desc'),array('icon-sort-amount-asc'=>'icon-sort-amount-asc'),array('icon-sort-amount-desc'=>'icon-sort-amount-desc'),array('icon-command'=>'icon-command'),array('icon-shift'=>'icon-shift'),array('icon-ctrl'=>'icon-ctrl'),array('icon-opt'=>'icon-opt'),array('icon-checkbox-checked'=>'icon-checkbox-checked'),array('icon-checkbox-unchecked'=>'icon-checkbox-unchecked'),array('icon-radio-checked'=>'icon-radio-checked'),array('icon-radio-checked2'=>'icon-radio-checked2'),array('icon-radio-unchecked'=>'icon-radio-unchecked'),array('icon-crop'=>'icon-crop'),array('icon-make-group'=>'icon-make-group'),array('icon-ungroup'=>'icon-ungroup'),array('icon-scissors'=>'icon-scissors'),array('icon-filter'=>'icon-filter'),array('icon-font'=>'icon-font'),array('icon-ligature'=>'icon-ligature'),array('icon-ligature2'=>'icon-ligature2'),array('icon-text-height'=>'icon-text-height'),array('icon-text-width'=>'icon-text-width'),array('icon-font-size'=>'icon-font-size'),array('icon-bold'=>'icon-bold'),array('icon-underline'=>'icon-underline'),array('icon-italic'=>'icon-italic'),array('icon-strikethrough'=>'icon-strikethrough'),array('icon-omega'=>'icon-omega'),array('icon-sigma'=>'icon-sigma'),array('icon-page-break'=>'icon-page-break'),array('icon-superscript'=>'icon-superscript'),array('icon-subscript'=>'icon-subscript'),array('icon-superscript2'=>'icon-superscript2'),array('icon-subscript2'=>'icon-subscript2'),array('icon-text-color'=>'icon-text-color'),array('icon-pagebreak'=>'icon-pagebreak'),array('icon-clear-formatting'=>'icon-clear-formatting'),array('icon-table'=>'icon-table'),array('icon-table2'=>'icon-table2'),array('icon-insert-template'=>'icon-insert-template'),array('icon-pilcrow'=>'icon-pilcrow'),array('icon-ltr'=>'icon-ltr'),array('icon-rtl'=>'icon-rtl'),array('icon-section'=>'icon-section'),array('icon-paragraph-left'=>'icon-paragraph-left'),array('icon-paragraph-center'=>'icon-paragraph-center'),array('icon-paragraph-right'=>'icon-paragraph-right'),array('icon-paragraph-justify'=>'icon-paragraph-justify'),array('icon-indent-increase'=>'icon-indent-increase'),array('icon-indent-decrease'=>'icon-indent-decrease'),array('icon-share'=>'icon-share'),array('icon-new-tab'=>'icon-new-tab'),array('icon-embed'=>'icon-embed'),array('icon-embed2'=>'icon-embed2'),array('icon-terminal'=>'icon-terminal'),array('icon-share2'=>'icon-share2'),array('icon-mail'=>'icon-mail'),array('icon-mail2'=>'icon-mail2'),array('icon-mail3'=>'icon-mail3'),array('icon-mail4'=>'icon-mail4'),array('icon-amazon'=>'icon-amazon'),array('icon-google'=>'icon-google'),array('icon-google2'=>'icon-google2'),array('icon-google3'=>'icon-google3'),array('icon-google-plus'=>'icon-google-plus'),array('icon-google-plus2'=>'icon-google-plus2'),array('icon-google-plus3'=>'icon-google-plus3'),array('icon-hangouts'=>'icon-hangouts'),array('icon-google-drive'=>'icon-google-drive'),array('icon-facebook'=>'icon-facebook'),array('icon-facebook2'=>'icon-facebook2'),array('icon-instagram'=>'icon-instagram'),array('icon-whatsapp'=>'icon-whatsapp'),array('icon-spotify'=>'icon-spotify'),array('icon-telegram'=>'icon-telegram'),array('icon-twitter'=>'icon-twitter'),array('icon-vine'=>'icon-vine'),array('icon-vk'=>'icon-vk'),array('icon-renren'=>'icon-renren'),array('icon-sina-weibo'=>'icon-sina-weibo'),array('icon-rss'=>'icon-rss'),array('icon-rss2'=>'icon-rss2'),array('icon-youtube'=>'icon-youtube'),array('icon-youtube2'=>'icon-youtube2'),array('icon-twitch'=>'icon-twitch'),array('icon-vimeo'=>'icon-vimeo'),array('icon-vimeo2'=>'icon-vimeo2'),array('icon-lanyrd'=>'icon-lanyrd'),array('icon-flickr'=>'icon-flickr'),array('icon-flickr2'=>'icon-flickr2'),array('icon-flickr3'=>'icon-flickr3'),array('icon-flickr4'=>'icon-flickr4'),array('icon-dribbble'=>'icon-dribbble'),array('icon-behance'=>'icon-behance'),array('icon-behance2'=>'icon-behance2'),array('icon-deviantart'=>'icon-deviantart'),array('icon-500px'=>'icon-500px'),array('icon-steam'=>'icon-steam'),array('icon-steam2'=>'icon-steam2'),array('icon-dropbox'=>'icon-dropbox'),array('icon-onedrive'=>'icon-onedrive'),array('icon-github'=>'icon-github'),array('icon-npm'=>'icon-npm'),array('icon-basecamp'=>'icon-basecamp'),array('icon-trello'=>'icon-trello'),array('icon-wordpress'=>'icon-wordpress'),array('icon-joomla'=>'icon-joomla'),array('icon-ello'=>'icon-ello'),array('icon-blogger'=>'icon-blogger'),array('icon-blogger2'=>'icon-blogger2'),array('icon-tumblr'=>'icon-tumblr'),array('icon-tumblr2'=>'icon-tumblr2'),array('icon-yahoo'=>'icon-yahoo'),array('icon-yahoo2'=>'icon-yahoo2'),array('icon-tux'=>'icon-tux'),array('icon-appleinc'=>'icon-appleinc'),array('icon-finder'=>'icon-finder'),array('icon-android'=>'icon-android'),array('icon-windows'=>'icon-windows'),array('icon-windows8'=>'icon-windows8'),array('icon-soundcloud'=>'icon-soundcloud'),array('icon-soundcloud2'=>'icon-soundcloud2'),array('icon-skype'=>'icon-skype'),array('icon-reddit'=>'icon-reddit'),array('icon-hackernews'=>'icon-hackernews'),array('icon-wikipedia'=>'icon-wikipedia'),array('icon-linkedin'=>'icon-linkedin'),array('icon-linkedin2'=>'icon-linkedin2'),array('icon-lastfm'=>'icon-lastfm'),array('icon-lastfm2'=>'icon-lastfm2'),array('icon-delicious'=>'icon-delicious'),array('icon-stumbleupon'=>'icon-stumbleupon'),array('icon-stumbleupon2'=>'icon-stumbleupon2'),array('icon-stackoverflow'=>'icon-stackoverflow'),array('icon-pinterest'=>'icon-pinterest'),array('icon-pinterest2'=>'icon-pinterest2'),array('icon-xing'=>'icon-xing'),array('icon-xing2'=>'icon-xing2'),array('icon-flattr'=>'icon-flattr'),array('icon-foursquare'=>'icon-foursquare'),array('icon-yelp'=>'icon-yelp'),array('icon-paypal'=>'icon-paypal'),array('icon-chrome'=>'icon-chrome'),array('icon-firefox'=>'icon-firefox'),array('icon-IE'=>'icon-IE'),array('icon-edge'=>'icon-edge'),array('icon-safari'=>'icon-safari'),array('icon-opera'=>'icon-opera'),array('icon-file-pdf'=>'icon-file-pdf'),array('icon-file-openoffice'=>'icon-file-openoffice'),array('icon-file-word'=>'icon-file-word'),array('icon-file-excel'=>'icon-file-excel'),array('icon-libreoffice'=>'icon-libreoffice'),array('icon-html-five'=>'icon-html-five'),array('icon-html-five2'=>'icon-html-five2'),array('icon-css3'=>'icon-css3'),array('icon-git'=>'icon-git'),array('icon-codepen'=>'icon-codepen'),array('icon-svg'=>'icon-svg'),array('icon-IcoMoon'=>'icon-IcoMoon'),array('icon-compass3'=>'icon-compass3'),array('icon-user2'=>'icon-user2'),array('icon-users2'=>'icon-users2'),array('icon-star'=>'icon-star'),array('icon-key3'=>'icon-key3'),array('icon-settings'=>'icon-settings'),array('icon-lock2'=>'icon-lock2'),array('icon-calendar2'=>'icon-calendar2'),
        ));
        return $GLOBALS['g5plus_icomoon'];
    }
}

/**
 * get the_post_thumbnail()
 * *******************************************************
 */
if (!function_exists('g5plus_the_post_thumbnail()')) {
    function g5plus_the_post_thumbnail($size = 'post-thumbnail', $attr = '') {
        the_post_thumbnail($size, $attr);
    }
}

/*Custom Place Input Comment Form*/
if(!function_exists('g5plus_reorder_comment_fields')){
    function g5plus_reorder_comment_fields($comment_fields){
        $comment_fields_reorder = $comment_fields;
        if(isset($comment_fields_reorder['comment'])){
            unset($comment_fields_reorder['comment']);
        }
        $comment_fields_reorder['comment'] = $comment_fields['comment'];
        return $comment_fields_reorder;
    }
    add_filter('comment_form_fields','g5plus_reorder_comment_fields');
}


/*Custom Categories Count*/
if (!function_exists('g5plus_add_span_cat_count')) {
    function g5plus_add_span_cat_count($links)
    {
        $links = str_replace('</a> (', '<span class="count">(', $links);
        $links = str_replace(')', ')</span></a>', $links);
        return $links;
    }

    add_filter('wp_list_categories', 'g5plus_add_span_cat_count');
    add_filter('get_archives_link', 'g5plus_add_span_cat_count');
}

if (!function_exists('g5plus_archive_count_span')) {
    function g5plus_archive_count_span($links) {
        $links = str_replace('</a>&nbsp;(', ' <span class="count">(', $links);
        $links = str_replace(')', ')</span></a>', $links);
        return $links;
    }
    add_filter('get_archives_link', 'g5plus_archive_count_span');
}