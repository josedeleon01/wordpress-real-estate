<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage benaa
 * @since benaa 1.0
 */
$size = 'full';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post-single clearfix'); ?>>
	<?php g5plus_get_post_thumbnail($size, 0, true); ?>
	<div class="entry-post-meta">
			<div class="entry-meta-author">
				<span><?php esc_html_e('By ', 'benaa'); ?></span><?php printf('<a href="%1$s">%2$s</a>', esc_url(get_author_posts_url(get_the_author_meta('ID'))), esc_html(get_the_author())); ?>
			</div>
			<div class="entry-meta-date">
				<i class="fa fa-calendar"></i><?php printf('<a href="%1$s">%2$s</a>', esc_url(get_the_permalink()), esc_html(get_the_time(get_option('date_format')))); ?>
			</div>
			<div class="entry-meta-cat">
				<i class="fa fa-folder-open"></i>
				<?php
				$categories = array();
				$categories = get_the_category(get_the_ID());
				$index = 0;
				if (!empty($categories)):?>
					<ul>
						<?php foreach ($categories as $key):
							$title_cate = $key->name;
							$slug_cate = $key->term_id;
							$link_cate = get_category_link($slug_cate);
							?>
							<?php if ($index < 2): ?>
							<?php if ($index == 0): ?>
								<li class="category-item">
									<a href="<?php echo esc_url($link_cate) ?>"
									   title="<?php echo esc_attr($title_cate) ?>"><?php echo esc_html($title_cate); ?></a>
								</li>
							<?php endif; ?>
							<?php if ($index == 1): ?>
								<li class="category-item">
									<a href="<?php echo esc_url($link_cate) ?>"
									   title="<?php echo esc_attr($title_cate) ?>"><?php echo esc_html($title_cate); ?></a>
								</li>
							<?php endif; ?>
						<?php endif; ?>
							<?php $index++;
						endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
			<?php if (comments_open() || get_comments_number()) : ?>
				<div class="entry-meta-comment">
					<?php comments_popup_link(wp_kses_post(__('<i class="fa fa-comments"></i> 0 comments', 'benaa')), wp_kses_post(__('<i class="fa fa-comments"></i> 1 comment', 'benaa')), wp_kses_post(__('<i class="fa fa-comments"></i> % comments', 'benaa')), '', ''); ?>
				</div>
			<?php endif; ?>
	</div>
	<div class="entry-content-wrap">
		<div class="entry-content clearfix">
			<?php $title_enable = g5plus_get_option('single_title_enable', 0); ?>
			<?php if ($title_enable == 1): ?>
				<h4 class="entry-post-title"><?php the_title(); ?></h4>
			<?php endif; ?>
			<div class="entry-content-inner clearfix">
				<?php
				the_content();
				?>
			</div>
			<?php
			wp_link_pages(array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:', 'benaa') . '</span>',
				'after'       => '</div>',
				'link_before' => '<span class="page-link">',
				'link_after'  => '</span>',
			)); ?>
		</div>
	</div>
</article>
<?php
/**
 * @hooked - g5plus_post_tag - 5
 * @hooked - g5plus_post_nav - 10
 * @hooked - g5plus_post_author_info - 15
 * @hooked - g5plus_post_comment - 20
 * @hooked - g5plus_post_related - 30
 *
 **/
do_action('g5plus_after_single_post');
?>

