<?php
/**
 * The template for displaying post meta
 *
 * @package WordPress
 * @subpackage Benaa
 * @since Benaa 1.0
 */
?>
<div class="entry-post-meta">
	<div class="entry-meta-author">
		<span><?php esc_html_e('By ', 'benaa'); ?></span><?php printf('<a href="%1$s">%2$s</a>', esc_url(get_author_posts_url(get_the_author_meta('ID'))), esc_html(get_the_author())); ?>
	</div>
	<div class="entry-meta-date">
		<?php printf('<a href="%1$s">%2$s</a>', esc_url(get_the_permalink()), esc_html(get_the_time(get_option('date_format')))); ?>
	</div>
</div>
