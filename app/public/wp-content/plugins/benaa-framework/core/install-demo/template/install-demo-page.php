<?php
$demo_site = array(
	'main' => array(
		'name'  => esc_html__('Main','benaa-framework'),
		'path'  => 'benaa',
		'link'  => 'http://themes.g5plus.net/benaa/'
	),
	'demo2' => array(
		'name'  => esc_html__('Demo2','beyot-framework'),
		'path'  => 'benaa2',
		'link'  => 'http://themes.g5plus.net/benaa2'
	),
);
foreach ($demo_site as $key => $value) {
	$demo_site[$key]['image'] = GF_PLUGIN_URL . 'core/install-demo/data/' . $key . '/preview.jpg';
}

$hide_fix_class = 'hide';
if (isset($_REQUEST['fix-demo-data']) && ($_REQUEST['fix-demo-data'] == '1')) {
$hide_fix_class = '';
}
?>
<div class="g5plus-demo-data-wrapper">
	<h1><?php esc_html_e('G5PLUS - Install Demo Data','benaa-framework') ?></h1>
	<p><?php esc_html_e('Please choose demo to install (take about 3-35 mins)','benaa-framework') ?></p>
	<div class="install-message" data-success="<?php esc_html_e('Install Done','benaa-framework') ?>"></div>
	<div class="g5plus-demo-site-wrapper">
		<div class="demo-site-row">
			<?php foreach ($demo_site as $key => $value): ?>
				<div class="demo-site-col">
					<div class="g5plus-demo-site">
						<div class="g5plus-demo-site-inner">
							<div class="demo-site-thumbnail">
								<div class="centered">
									<img src="<?php echo esc_url($value['image'])?>" alt="<?php echo esc_attr($value['name'])?>"/>
								</div>
							</div>
							<a href="<?php echo esc_url($value['link']); ?>" target="_blank" class="link-demo"><?php esc_html_e('Preview','benaa-framework'); ?></a>
							<div class="progress-bar meter">
								<span style="width: 0%"></span>
							</div>
						</div>
						<h3>
							<span><?php echo esc_html($value['name'])?></span>
							<?php if (isset($_REQUEST['fixdemo'])): ?>
								<button class="fix-button"><?php esc_html_e('Fix Demo Data','benaa-framework') ; ?></button>
							<?php else: ?>
								<button id="install_demo" class="install-button" data-demo="<?php echo esc_attr($key) ?>" data-path="<?php echo esc_attr($value['path']) ?>"><i class="fa fa-spin fa-spinner"></i><?php esc_html_e('Install','benaa-framework'); ?></button>
								<button id="install_setting" class="install-button" data-demo="<?php echo esc_attr($key) ?>" data-path="<?php echo esc_attr($value['path']) ?>"><i class="fa fa-spin fa-spinner"></i><?php esc_html_e('Only Setting','benaa-framework'); ?></button>
							<?php endif;?>
						</h3>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>