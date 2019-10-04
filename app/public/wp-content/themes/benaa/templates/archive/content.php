<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage Theme_Name
 * @since Theme_Version 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if (is_sticky() && is_home() && !is_paged()) : ?>
			<span class="sticky-post"><?php esc_html_e('Featured', 'benaa'); ?></span>
		<?php endif; ?>
		
		<?php the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
	</header><!-- .entry-header -->
	
	<?php echo 'excerpt'; ?>
	
	<?php echo 'post_thumbnail';?>
	
	<div class="entry-content">
		<?php
		the_content(sprintf(
			esc_html__('Continue reading %s', 'benaa'),
			the_title('<span class="screen-reader-text">', '</span>', false)
		));
		
		wp_link_pages(array(
			'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:', 'benaa') . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . esc_html__('Page', 'benaa') . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		));
		?>
	</div><!-- .entry-content -->
	
	<footer class="entry-footer">
		<?php echo 'entry_meta';?>
		<?php
		edit_post_link(
			sprintf(
				__('Edit<span class="screen-reader-text"> "%s"</span>', 'benaa'),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
