<?php
/**
 * The template for displaying footer
 *
 * @package WordPress
 * @subpackage Theme_Name
 * @since Theme_Version 1.0
 */
$preset_id = g5plus_get_current_preset();
if (!$preset_id && is_404()) {
	return;
}

$set_footer_custom = g5plus_get_option('set_footer_custom', 0);
$set_footer_above_custom = g5plus_get_option('set_footer_above_custom', 0);
$footer_container_layout = g5plus_get_option('footer_container_layout','container');

/**
 * If Set custom footer
 */
if ($set_footer_custom):
	global $post;
	$post = get_post($set_footer_custom);
	setup_postdata( $post );
	?>
	<div class="<?php echo esc_attr($footer_container_layout); ?>">
		<?php the_content(); ?>
	</div>
	<?php
	wp_reset_postdata();
	return;
endif;

/**
 * Not set custom footer
 */
$footer_layout = g5plus_get_option('footer_layout','footer-1');
$footer_border_top = g5plus_get_option('footer_border_top','none');


$footer_matrix = array(
	'footer-1' => array('col-md-3 col-sm-6', 'col-md-3 col-sm-6', 'col-md-3 col-sm-6', 'col-md-3 col-sm-6'),
	'footer-2' => array('col-md-6 col-sm-12', 'col-md-3 col-sm-6', 'col-md-3 col-sm-6'),
	'footer-3' => array('col-md-3 col-sm-6', 'col-md-3 col-sm-6', 'col-md-6 col-sm-12'),
	'footer-4' => array('col-md-6 col-sm-12', 'col-md-6 col-sm-12'),
	'footer-5' => array('col-md-4 col-sm-12', 'col-md-4 col-sm-12', 'col-md-4 col-sm-12'),
	'footer-6' => array('col-md-8 col-sm-12', 'col-md-4 col-sm-12'),
	'footer-7' => array('col-md-4 col-sm-12', 'col-md-8 col-sm-12'),
	'footer-8' => array('col-md-3 col-sm-12', 'col-md-6 col-sm-12', 'col-md-3 col-sm-12'),
	'footer-9' => array('col-sm-12'),
);
$footer_sidebar = array();
for ($i = 0; $i < count($footer_matrix[$footer_layout]); $i++) {
	$footer_sidebar[$i] = g5plus_get_option('footer_sidebar_' . ($i + 1), 'footer-' . ($i + 1));
}
$footer_class = array('main-footer');

if ($footer_border_top !== 'none') {
	$footer_class[] = esc_attr($footer_border_top);
}

$exists_main_footer = 0;
for ($i = 0; $i < count($footer_sidebar); $i++) {
	if(is_active_sidebar($footer_sidebar[$i])) {
		$exists_main_footer = 1;
		break;
	}
}
$footer_show_hide = g5plus_get_option('footer_show_hide', 1);
?>
<?php if ($footer_show_hide && ($exists_main_footer || $set_footer_above_custom)): ?>
	<?php get_template_part('templates/footer/above-footer'); ?>
	<div class="<?php echo join(' ', $footer_class); ?>">
		<div class="<?php echo esc_attr($footer_container_layout); ?>">
			<div class="footer-inner">
				<div class="row">
					<?php for ($i = 0; $i < count($footer_sidebar); $i++): ?>
						<?php if(is_active_sidebar($footer_sidebar[$i])): ?>
							<div class="sidebar <?php echo esc_attr($footer_matrix[$footer_layout][$i]); ?>">
								<?php dynamic_sidebar($footer_sidebar[$i]); ?>
							</div>
						<?php endif;?>
					<?php endfor; ?>
				</div>
			</div>
		</div>
	</div>
<?php endif;?>
<?php get_template_part('templates/footer/bottom-bar'); ?>