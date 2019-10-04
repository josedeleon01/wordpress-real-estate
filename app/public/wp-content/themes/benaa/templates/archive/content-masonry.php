<?php
/**
 * The template for displaying content masonry
 *
 * @package WordPress
 * @subpackage Theme_Name
 * @since Theme_Version 1.0
 */
$size = 'medium-image';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post-grid gf-item-wrap clearfix'); ?>>
	<div class="entry-content-wrap clearfix">
		<?php g5plus_get_post_thumbnail($size,0,false); ?>
		<?php get_template_part('templates/archive/post-meta'); ?>
		<div class="entry-content-inner">
			<div class="entry-info-post clearfix">
				<h4 class="entry-post-title"><a title="<?php the_title(); ?>"
												href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h4>
			</div>
		</div>
	</div>
</article>
