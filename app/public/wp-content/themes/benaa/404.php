<?php
get_header();

$sub_title_404 = g5plus_get_option('404_sub_title', esc_html__('This page not be found', 'benaa'));
$description = g5plus_get_option('404_description', esc_html__('We are really sorry, but the page you requested is missing. Perhaps searching again can help.', 'benaa'));
$bg_image_404 = g5plus_get_option('404_bg_image', array());
$return_text_link = g5plus_get_option('404_return_text_link', esc_html__('home page', 'benaa'));
$return_link = g5plus_get_option('404_return_link');
$bg_image_404 = isset($bg_image_404['url']) ? $bg_image_404['url'] : '';
$style = '';
$bg_404_css = array();
$bg_image = 'bg404-img';
if (!empty($bg_image_404)) {
	$bg_image = '';
	$bg_404_css[] = 'background-image:url(' . $bg_image_404 . ');';
	$bg_404_css[] = 'background-image: linear-gradient(to bottom, rgba(0,0,0,0.2) 0%,rgba(0,0,0,0.2) 100%), url(' . $bg_image_404 . ');';
	$bg_404_css[] = 'background-size: cover;';
	$bg_404_css[] = 'background-position: top center;';
	$bg_404_css[] = 'background-repeat: repeat;';
	$style = 'style="' . join(' ', $bg_404_css) . '"';
}
?>
	<div class="page404 <?php echo esc_attr($bg_image); ?>" <?php echo wp_kses_post($style); ?>>
		<div class="page404-content container">
			<div class="description"><?php echo wp_kses_post($description); ?>
				<?php if (empty($return_link)): ?>
					<span class="return-text"><?php esc_html_e('Or back to ', 'benaa') ?></span>
					<a href="<?php echo esc_url(home_url('/')) ?>">
						<?php echo wp_kses_post($return_text_link); ?>
					</a>
				<?php else: ?>
					<span class="return-text"><?php esc_html_e('Or back to ', 'benaa') ?></span>
					<a href="<?php echo esc_url($return_link) ?>">
						<?php echo wp_kses_post($return_text_link); ?>
					</a>
				<?php endif; ?>
			</div>
			<h2 class="title">4<span>0</span>4</h2>
			<h3 class="subtitle"><?php echo wp_kses_post($sub_title_404); ?></h3>
			<div class="search-form-wrapper">
				<div class="search-form">
					<?php get_search_form() ?>
				</div>
			</div>
		</div>
	</div>
<?php
get_footer();