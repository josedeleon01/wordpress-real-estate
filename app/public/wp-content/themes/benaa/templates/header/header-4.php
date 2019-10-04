<?php
$header_class = array('header-wrapper', 'clearfix');
$header_above_inner = array('header-above-inner', 'clearfix');
$header_nav_class = array('header-nav-wrapper', 'clearfix');
$header_container_layout = g5plus_get_option('header_container_layout', 'container');
$header_border_bottom = g5plus_get_option('header_border_bottom', 'none');
$header_nav_border_bottom = g5plus_get_option('header_nav_border_bottom', 'none');

$header_float = g5plus_get_option('header_float', 0);
$header_sticky = g5plus_get_option('header_sticky', 0);
$header_search_property = g5plus_get_option('header_search_property', 0);

if ($header_border_bottom != 'none') {
	$header_above_inner[] = $header_border_bottom;
}

if ($header_nav_border_bottom != 'none') {
	$header_nav_class[] = $header_nav_border_bottom;
}

if ($header_float) {
	$header_class[] = 'float-header';
}

$sticky_class = '';
$sticky_wrapper = array();
$sticky_region_class = array();
if ($header_sticky) {
	$sticky_wrapper[] = 'sticky-wrapper';
	if ($header_search_property) {
		$sticky_class = 'sticky-region';
		$sticky_region_class[] = '';
	} else {
		$sticky_region_class[] = 'sticky-region';
	}
}

/**
 * Get page custom menu
 */
$page_menu = g5plus_get_option('page_menu', '');
?>

<div class="<?php echo join(' ', $header_class); ?>">
	<div class="<?php echo join(' ', $header_above_inner); ?>">
		<div class="<?php echo esc_attr($header_container_layout); ?> container-inner clearfix">
			<?php get_template_part('templates/header/logo'); ?>
			<?php g5plus_get_template('header/header-customize', array('customize_location' => 'right')); ?>
		</div>
	</div>
	<div class="<?php echo join(' ', $sticky_wrapper); ?>">
		<div class="<?php echo join(' ', $header_nav_class); ?> <?php echo join(' ', $sticky_region_class); ?>">
			<div class="<?php echo esc_attr($header_container_layout); ?> container-inner clearfix">
				<?php get_template_part('templates/header/logo'); ?>
				<?php if (has_nav_menu('primary') || $page_menu): ?>
					<nav class="<?php echo esc_attr($header_container_layout); ?> primary-menu clearfix">
						<?php
						$arg_menu = array(
							'menu_id'        => 'main-menu',
							'container'      => '',
							'theme_location' => 'primary',
							'menu_class'     => 'main-menu'
						);
						wp_nav_menu($arg_menu);
						g5plus_get_template('header/header-customize', array('customize_location' => 'nav'));
						?>
					</nav>
				<?php else: ?>
					<div class="no-menu"><?php printf(wp_kses_post(__('Please assign a menu to the <b>Primary Menu</b> in Appearance > <a title="Menus" href="%s">Menus</a>', 'benaa')), admin_url('nav-menus.php')); ?></div>
				<?php endif; ?>
			</div>
			<?php if (($header_search_property) && (class_exists('Essential_Real_Estate'))): ?>
				<div class="ere-search-wrap <?php echo esc_attr($sticky_class); ?>">
					<?php g5plus_get_template('header/property-search'); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
