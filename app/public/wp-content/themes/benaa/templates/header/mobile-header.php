<?php
/**
 * The template for displaying the Header Mobile
 */
$mobile_header_stick = g5plus_get_option('mobile_header_stick', 0);
$header_search_property = g5plus_get_option('header_search_property', 0);

$sticky_class = '';
$sticky_wrapper = array('header-mobile-wrapper');
$sticky_region = array('header-mobile-inner');
if ($mobile_header_stick) {
	$sticky_wrapper[] = 'sticky-wrapper';
	$sticky_region[] = 'sticky-region';
	
	
	$sticky_wrapper[] = 'sticky-wrapper';
	if ($header_search_property) {
		$sticky_class = 'sticky-region';
		$sticky_region[] = '';
	} else {
		$sticky_region[] = 'sticky-region';
	}
}



$mobile_header_layout = g5plus_get_option('mobile_header_layout', 'header-mobile-1');
?>
<div class="<?php echo join(' ', $sticky_wrapper); ?>">
	<div class="<?php echo join(' ', $sticky_region); ?>">
		<div class="container header-mobile-container">
			<div class="header-mobile-container-inner clearfix">
				<?php get_template_part('templates/header/mobile-logo'); ?>
				<div class="toggle-icon-wrapper toggle-mobile-menu"
				     data-drop-type="<?php echo esc_attr(g5plus_get_option('mobile_header_menu_drop', 'menu-drop-fly')); ?>">
					<div class="toggle-icon"><span></span></div>
				</div>
				<?php if (g5plus_get_option('mobile_header_login', 1)): ?>
					<div class="mobile-login">
						<?php
						if (class_exists('ERE_Widget_Login_Menu')) {
							the_widget('ERE_Widget_Login_Menu');
						}
						?>
					</div>
				<?php endif; ?>
				<?php if (g5plus_get_option('mobile_header_search_box', 1) && ($mobile_header_layout !== 'header-mobile-4')): ?>
					<div class="mobile-search-button">
						<?php get_template_part('templates/header/customize-search-button'); ?>
					</div>
				<?php endif; ?>
			</div>
			<?php get_template_part('templates/header/mobile-navigation'); ?>
		</div>
	</div>
	<?php if (($header_search_property) && (class_exists('Essential_Real_Estate'))): ?>
		<div class="ere-search-wrap <?php echo esc_attr($sticky_class); ?>">
			<?php g5plus_get_template('header/mobile-property-search'); ?>
		</div>
	<?php endif; ?>
</div>