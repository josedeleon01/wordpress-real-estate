<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Theme_Name
 * @since Theme_Version 1.0
 */
/**
 * @hooked - gf_set_preset_value_to_option - 1
 * @hooked - gf_set_page_layout_setting - 5
 * @hooked - gf_set_post_layout_settings - 10
 **/
do_action('g5plus_header_before');

$header_layout = g5plus_get_option('header_layout', 'header-1');
$header_responsive = g5plus_get_option('header_responsive_breakpoint', '991px');

?>
<!DOCTYPE html>
<!-- Open Html -->
<html <?php language_attributes(); ?>>
<!-- Open Head -->
<head>
    <?php wp_head(); ?>
</head>
<!-- Close Head -->
<body <?php body_class(); ?> data-responsive="<?php echo esc_attr($header_responsive) ?>"
                             data-header="<?php echo esc_attr($header_layout) ?>">
<?php
/**
 * @hooked - g5plus_site_loading - 5
 **/
do_action('g5plus_before_page_wrapper');
?>
<!-- Open Wrapper -->
<div id="wrapper">

    <?php
    /**
     * @hooked - g5plus_before_page_wrapper_content - 10
     * @hooked - g5plus_page_header - 15
     **/
    do_action('g5plus_before_page_wrapper_content');
    ?>

    <!-- Open Wrapper Content -->
    <div id="wrapper-content" class="clearfix ">
        <?php
        /**
         *
         * @hooked - g5plus_output_content_wrapper - 1
         **/
        do_action('g5plus_main_wrapper_content_start');
        ?>
