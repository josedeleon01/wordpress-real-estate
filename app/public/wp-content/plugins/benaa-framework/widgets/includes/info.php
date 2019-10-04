<?php
//==============================================================================
// LOGO WIDGET
//==============================================================================
if (!class_exists('G5plus_Widget_Info')) {
	class G5plus_Widget_Info extends G5plus_Widget
	{
		public function __construct()
		{
			$this->widget_cssclass = 'widget-info';
			$this->widget_description = esc_html__("Info widget", 'benaa-framework');
			$this->widget_id = 'g5plus_info';
			$this->widget_name = esc_html__('G5plus - Info', 'benaa-framework');
			$this->settings = array(
				'types' => array(
					'type'    => 'multi-select',
					'label'   => esc_html__('Select info type', 'benaa-framework'),
					'std'     => '',
					'options' => array(
						'address' => esc_html__('Address', 'benaa-framework'),
						'phone'  => esc_html__('Phone', 'benaa-framework'),
						'email'  => esc_html__('Email', 'benaa-framework'),
						'time'  => esc_html__('Time', 'benaa-framework')
					)
				),
				'address_1' => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__('Label Address', 'benaa-framework')
				),
				'address_2' => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__('Address', 'benaa-framework')
				),
				'phone_1' => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__('Label Phone', 'benaa-framework')
				),
				'phone_2' => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__('Phone', 'benaa-framework')
				),
				'email_1' => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__('Label Email', 'benaa-framework')
				),
				'email_2' => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__('Email', 'benaa-framework')
				),
				'time_1' => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__('Label Time', 'benaa-framework')
				),
				'time_2' => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__('Time', 'benaa-framework')
				),
			);
			parent::__construct();
		}
		
		function widget($args, $instance)
		{
			if ( $this->get_cached_widget( $args ) )
				return;
			extract( $args, EXTR_SKIP );
			$types   = (!empty($instance['types'])) ? $instance['types'] : '';
			$address_1   = (!empty($instance['address_1'])) ? $instance['address_1'] : '';
			$address_2   = (!empty($instance['address_2'])) ? $instance['address_2'] : '';
			$phone_1   = (!empty($instance['phone_1'])) ? $instance['phone_1'] : '';
			$phone_2   = (!empty($instance['phone_2'])) ? $instance['phone_2'] : '';
			$email_1   = (!empty($instance['email_1'])) ? $instance['email_1'] : '';
			$email_2   = (!empty($instance['email_2'])) ? $instance['email_2'] : '';
			$time_1   = (!empty($instance['time_1'])) ? $instance['time_1'] : '';
			$time_2   = (!empty($instance['time_2'])) ? $instance['time_2'] : '';
			ob_start();
			echo wp_kses_post($args['before_widget']);
			echo '<div class="row">';
			
			$arr_types = explode(",",$types);
			if(isset($arr_types)) {
				foreach ($arr_types as $arr_type) {
					if ( strpos( $arr_type, 'phone' ) !== false && ! empty( $phone_1 ) && ! empty( $phone_2 ) ) { ?>
						<div class="col-md-4 info-item">
							<span class="fa fa-phone text-color-accent"></span>
							<span>
                                <b><?php echo esc_attr($phone_1); ?></b>
                                <span><?php echo esc_attr($phone_2); ?></span>                                    
                            </span>
						</div>
					<?php }
					if ( strpos( $arr_type, 'address' ) !== false && ! empty( $address_1 ) && ! empty( $address_2 ) ) { ?>
						<div class="col-md-4 info-item">
							<span class="fa fa-map-marker text-color-accent"></span>
							<span>
                                <b><?php echo esc_attr($address_1); ?></b>
                                <span><?php echo esc_attr($address_2); ?></span>                                    
                            </span>
						</div>
					<?php }
					if ( strpos( $arr_type, 'email' ) !== false && ! empty( $email_1 ) && ! empty( $email_2 ) ) { ?>
						<div class="col-md-4 info-item">
							<span class="fa fa-envelope text-color-accent"></span>
							<span>
                                <b><?php echo esc_attr($email_1); ?></b>
                                <span><?php echo esc_attr($email_2); ?></span>                                    
                            </span>
						</div>
					<?php }
					if ( strpos( $arr_type, 'time' ) !== false && ! empty( $time_1 ) && ! empty( $time_2 ) ) { ?>
						<div class="col-md-4 info-item">
							<span class="fa fa-clock-o text-color-accent"></span>
							<span>
                                <b><?php echo esc_attr($time_1); ?></b>
                                <span><?php echo esc_attr($time_2); ?></span>
                            </span>
						</div>
					<?php }
				}
			}
			echo '</div>';
			echo wp_kses_post($args['after_widget']);
			$content =  ob_get_clean();
			echo wp_kses_post($content);
			$this->cache_widget( $args, $content );
		}
	}
}