<?php
/**
 * The template for displaying dashboard
 *
 * @package WordPress
 * @subpackage benaa
 * @since benaa 1.0.1
 */
$pages_settings = gfDashboard()->get_config_pages();
$current_theme = wp_get_theme();
?>
<div class="gf-dashboard wrap">
	<h2 class="screen-reader-text"><?php printf(esc_html__('%s Dashboard', 'benaa-framework'), $current_theme['Name']) ?></h2>
	<div class="gf-message-box">
		<h1 class="welcome"><?php esc_html_e('Welcome to', 'benaa-framework') ?> <span
				class="gf-theme-name"><?php echo esc_html($current_theme['Name']) ?></span> <span
				class="gf-theme-version">v<?php echo esc_html($current_theme['Version']) ?></span></h1>
		<p class="about"><?php printf(esc_html__('%s is now installed and ready to use! Get ready to build something beautiful. Read below for additional information. We hope you enjoy it!', 'benaa-framework'), $current_theme['Name']); ?></p>
	</div>
	<div class="gf-dashboard-tab-wrapper">
		<ul class="gf-dashboard-tab">
			<?php foreach ($pages_settings as $key => $value): ?>
				<?php if (!isset($value['link'])) {
					$value['link'] = "admin.php?page=gf-{$key}";
				} ?>
				<li class="<?php echo (($current_page === $key) ? 'active' : '') ?>">
					<a href="<?php echo admin_url($value['link']) ?>"><?php echo esc_html($value['menu_title']) ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<div class="gf-dashboard-content">
		<div class="<?php echo esc_attr($current_page) ?>">
			<?php gf_get_template("core/dashboard/templates/{$current_page}"); ?>
		</div>
	</div>
</div>

