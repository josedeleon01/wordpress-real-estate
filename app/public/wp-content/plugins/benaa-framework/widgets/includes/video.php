<?php
class G5Plus_Widget_Video extends G5Plus_Widget
{
	public function __construct()
	{
		$this->widget_cssclass = 'widget-video';
		$this->widget_description = esc_html__("Display video", 'benaa-framework');
		$this->widget_id = 'g5plus-video';
		$this->widget_name = esc_html__('G5Plus: Video', 'benaa-framework');
		$this->settings = array(
			'link'  => array(
				'type'  => 'text',
				'std'   => '',
				'label' => esc_html__('Enter link video', 'benaa-framework'),
			),
			'title' => array(
				'type'  => 'text',
				'std'   => '',
				'label' => esc_html__('Enter title video', 'benaa-framework'),
			),
			'image' => array(
				'type'  => 'image',
				'std'   => '',
				'label' => esc_html__('Background image video', 'benaa-framework')
			),
			'height' => array(
				'type'  => 'number',
				'std'   => '340',
				'label' => esc_html__('Enter height video', 'benaa-framework'),
			),
		);
		parent::__construct();
	}
	
	function widget($args, $instance)
	{
		if ($this->get_cached_widget($args))
			return;
		extract($args, EXTR_SKIP);
		$link = (!empty($instance['link'])) ? $instance['link'] : '';
		$title = (!empty($instance['title'])) ? $instance['title'] : '';
		$height = (!empty($instance['height'])) ? $instance['height'] : '340';
		$image = empty($instance['image']) ? '' : apply_filters('widget_image', $instance['image']);
		
		echo wp_kses_post($args['before_widget']); ?>
		
		<div class="g5-video" style="background-image: url('<?php echo esc_url($image); ?>');background-size: cover; height:<?php echo esc_attr($height); ?>px">
			<div class="g5-video-inner">
				<a class="view-video" data-src="<?php echo esc_url($link) ?>" href="javascript:;">
					<img src="<?php echo esc_html(G5PLUS_THEME_URL . 'assets/images/icon-play.png'); ?>" alt="">
				</a>
				<h4 class="video-title"><?php echo esc_html($title); ?></h4>
			</div>
		</div>
		<?php
		echo wp_kses_post($args['after_widget']);
	}
}