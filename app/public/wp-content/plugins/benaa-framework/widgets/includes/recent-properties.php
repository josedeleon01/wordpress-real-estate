<?php

class G5Plus_Widget_Recent_Properties extends G5Plus_Widget
{
	public function __construct()
	{
		$this->widget_cssclass = 'widget-recent-properties';
		$this->widget_description = esc_html__("Display recent properties", 'benaa-framework');
		$this->widget_id = 'g5plus-recent-properties';
		$this->widget_name = esc_html__('G5Plus: Recent Properties', 'benaa-framework');
		$this->settings = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => 'Recent Properties',
				'label' => esc_html__('Recent Properties', 'benaa-framework'),
			),
			'number' => array(
				'type'  => 'number',
				'std'   => '4',
				'label' => esc_html__('Number of posts to show', 'benaa-framework'),
			)
		);
		parent::__construct();
	}
	
	function widget($args, $instance)
	{
		extract($args, EXTR_SKIP);
		$title = (!empty($instance['title'])) ? $instance['title'] : '';
		$number = (!empty($instance['number'])) ? absint($instance['number']) : 4;
		
		if (!(function_exists('ere_get_option'))) {
			return;
		}
		
		$query_args = array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'ignore_sticky_posts' => true,
			'post_status'         => 'publish',
			'orderby'             => 'date',
			'order'               => 'DESC',
			'post_type'           => 'property',
		);
		$query_args = array_merge($query_args);
		$r = new WP_Query($query_args);
		if ($r->have_posts()) :
			?>
			<?php echo wp_kses_post($args['before_widget']); ?>
			<?php if ($title) {
			echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
		} ?>
			<div class="g5-recent-properties">
				<?php while ($r->have_posts()) : $r->the_post(); ?>
					<?php
					$property_id = get_the_ID();
					$price = get_post_meta($property_id, ERE_METABOX_PREFIX . 'property_price', true);
					$term = wp_get_post_terms($property_id, 'property-state');
					$status = wp_get_post_terms($property_id, 'property-status');
					?>
					<div class="property-item">
						<div class="clearfix">
							<?php if (function_exists('g5plus_get_post_thumbnail')) {
								g5plus_get_post_thumbnail('extra-small-image');
							}
							if ((!empty($title_post)) || (!empty($status[0]->name))):?>
								<span class="property-status"><?php echo esc_html($status[0]->name); ?></span>
							<?php endif; ?>
							<div class="entry-content-wrap">
								<?php $title_post = get_the_title();
								if (!empty($title_post)):
									if (!empty($term[0]->name)):?>
										<span class="property-state"><?php echo esc_html($term[0]->name); ?></span>
									<?php endif; ?>
									<h6 class="entry-post-title"><a title="<?php the_title(); ?>"
																	href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
									</h6>
									<?php if (!empty($price)): ?>
									<div class="property-price">
										<span><?php echo ere_get_format_money($price) ?></span>
									</div>
								<?php elseif (ere_get_option('empty_price_text', '') != ''): ?>
									<div class="property-price">
										<span><?php echo ere_get_option('empty_price_text', '') ?></span>
									</div>
								<?php endif; ?>
								<?php else: ?>
									<div class="entry-meta-date"><a
												href="<?php echo get_permalink(); ?>"><?php date_i18n(the_time(get_option('date_format'))); ?></a>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
			<?php echo wp_kses_post($args['after_widget']); ?>
			<?php
			// Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata();
		endif;
	}
}