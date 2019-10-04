<?php
/**
 * The template for displaying widget-area-box.php
 *
 * @package WordPress
 * @subpackage emo
 * @since emo 1.0
 */
$nonce =  wp_create_nonce('gf-delete-widget-area-nonce');
?>
<script type="text/html" id="gf-add-widget-template">
	<div id="gf-add-widget" class="widgets-holder-wrap">
		<input type="hidden" name="gf-widget-areas-nonce" value="<?php echo esc_attr($nonce) ?>" />
		<div class="sidebar-name">
			<h3><?php esc_html_e('Create Widget Area', 'benaa-framework'); ?></h3>
		</div>
		<div class="sidebar-description">
			<form id="addWidgetAreaForm" action="" method="post">
				<div class="widget-content">
					<input id="gf-add-widget-input" name="gf-add-widget-input" type="text" class="regular-text" title="<?php echo esc_attr(esc_html__('Name','benaa-framework')); ?>" placeholder="<?php echo esc_attr(esc_html__('Name','benaa-framework')); ?>" />
				</div>
				<div class="widget-control-actions">
					<input class="addWidgetArea-button button-primary" type="submit" value="<?php echo esc_attr(esc_html__('Create Widget Area', 'benaa-framework')); ?>" />
				</div>
			</form>
		</div>
	</div>
</script>
