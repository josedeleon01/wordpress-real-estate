<?php
/**
 * Theme Setup
 * *******************************************************
 */
if (!function_exists('g5plus_theme_setup')) {
    function g5plus_theme_setup()
    {
        if (!isset($content_width)) {
            $content_width = 1170;
        }

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');
        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => esc_html__('Primary Menu', 'benaa'),
            'mobile'  => esc_html__('Mobile Menu', 'benaa'),
        ));

        // Enable support for Post Formats.
        add_theme_support('post-formats', array('gallery', 'video', 'audio', 'quote', 'link'));


        global $wp_version;

	    add_theme_support("title-tag");
        if (version_compare($wp_version, '3.4', '>=')) {
            add_theme_support("custom-header");
            add_theme_support("custom-background");
        }

        // Enable support for HTML5 markup.
        add_theme_support('html5', array(
            'comment-list',
            'search-form',
            'comment-form',
            'gallery',
        ));

        $language_path = get_template_directory() . '/languages';
        load_theme_textdomain('benaa', $language_path);

        add_editor_style(array('/assets/css/editor-style.css'));
    }

    add_action('after_setup_theme', 'g5plus_theme_setup');
}