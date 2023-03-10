<?php

add_action('widgets_init','register_docent_pro_core_image_widget');

function register_docent_pro_core_image_widget()
{
	register_widget('Docent_pro_Core_Image_Widget');
}

class Docent_pro_Core_Image_Widget extends WP_Widget{

	public function __construct() {
		parent::__construct( 'Docent_pro_Core_Image_Widget', esc_html__("Docent Image Ads",'docent-pro-core'), array('description' => esc_html__("This Image Ads Widgets",'docent-pro-core')) );
	}

	/*-------------------------------------------------------
	 *				Front-end display of widget
	 *-------------------------------------------------------*/

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title'] );
		echo $before_widget;
		if ( $title ){
			echo $before_title . $title . $after_title;
		}
		?>
		<div class="single-ads">
			<?php	if($instance['ads_img1'])
			echo '<a href="'.esc_attr($instance['ads_img_link1']).'" target="_blank"><img src="'. esc_url(get_site_url()) . $instance['ads_img1'].'" class="img-responsive" alt="'.esc_html__('Ads','docent-pro-core').'"></a>';
			?>
		</div>
		<?php echo $after_widget;
	}


	/*-------------------------------------------------------
	 *				Sanitize data, save and retrive
	 *-------------------------------------------------------*/

	public function update( $new_instance, $old_instance ) {
		$instance 						= $old_instance;
		$instance['title'] 				= strip_tags( $new_instance['title'] );
		$instance['ads_img_link1'] 		= $new_instance['ads_img_link1'];
		$instance['ads_img1'] 			= $new_instance['ads_img1'];
		$instance['ads_img_link2'] 		= $new_instance['ads_img_link2'];
		return $instance;
	}


	/*-------------------------------------------------------
	 *				Back-End display of widget
	 *-------------------------------------------------------*/
	
	public function form( $instance )
	{

		$defaults = array(  'title' => '',
			'ads_img_link1' => '#',
			'ads_img1' => ''
			);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title : ', 'docent-pro-core' ); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'ads_img_link1' )); ?>"><?php esc_html_e( 'Ads Link', 'docent-pro-core' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('ads_img_link1'));?>" name="<?php echo esc_attr($this->get_field_name('ads_img_link1')); ?>" value="<?php echo esc_attr($instance['ads_img_link1']); ?>">
			

			<label for="<?php echo esc_attr($this->get_field_id( 'ads_img1' )); ?>"><?php esc_html_e( 'Ads Image URL', 'docent-pro-core' ); ?></label>

			<input type="hidden" id="<?php echo esc_attr($this->get_field_id('ads_img1'));?>" name="<?php echo esc_attr($this->get_field_name('ads_img1'));?>" class="<?php echo esc_attr($this->get_field_id('ads_img1'));?>" value="<?php echo esc_attr($instance['ads_img1']); ?>"/>
 			<button id="<?php echo esc_attr($this->get_field_id('ads_img1'));?>" class="custom-upload button" data-url="<?php echo esc_url(get_site_url()); ?>"><?php echo esc_html__('Upload image','docent-pro-core'); ?></button>
 			<img class="<?php echo esc_attr($this->get_field_id('ads_img1'));?>" src="<?php echo esc_url(get_site_url()) . esc_attr($instance['ads_img1']); ?> "/>
		</p>
	
		<?php
	}
}