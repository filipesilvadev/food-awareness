<?php

add_action('widgets_init','register_docent_pro_widget_link');

function register_docent_pro_widget_link()
{
	register_widget('Docent_Pro_Core_Widget_link_Footer');
}

class Docent_Pro_Core_Widget_link_Footer extends WP_Widget{

	public function __construct() {
		parent::__construct( 'Docent_Pro_Core_Widget_link_Footer', esc_html__("Docent Custom Link Widgets",'docent-pro-core'), array('description' => esc_html__("This Custom Link Widgets",'docent-pro-core')) );
	}

/*-------------------------------------------------------
 *				Front-end display of widget
*-------------------------------------------------------*/

	public function widget( $args, $instance ) {
		extract( $args );

		//Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );

		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		?>	
			<ul class="docent-custom-link-widget">

				<?php if( isset($instance['about_me_url']) && $instance['about_me_url'] ) { ?>
                    <li><a href="<?php echo esc_url( $instance['about_me_url'] ); ?>">
                    <img class="icon-blue" src="<?php echo DOCENT_PRO_CORE_URL .'assets/img/avatar-icon-blue.svg' ?>" alt="">
                    <img class="icon-white" src="<?php echo DOCENT_PRO_CORE_URL .'assets/img/avatar-icon-white.svg' ?>" alt="">                    <?php esc_html_e('About Me', 'docent-pro-core') ?></a></li>
                <?php } ?>
                
                <?php if( isset($instance['courses_url']) && $instance['courses_url'] ) { ?>
                    <li><a href="<?php echo esc_url( $instance['courses_url'] ); ?>">
                    <img class="icon-blue" src="<?php echo DOCENT_PRO_CORE_URL .'assets/img/mortarboard-icon-blue.svg' ?>" alt="">
                    <img class="icon-white" src="<?php echo DOCENT_PRO_CORE_URL .'assets/img/mortarboard-icon-white.svg' ?>" alt="">
                    <?php esc_html_e('Course', 'docent-pro-core') ?></a></li>
				<?php } ?>	

				<?php if( isset($instance['contact_me_url']) && $instance['contact_me_url'] ) { ?>
                    <li><a href="<?php echo esc_url( $instance['contact_me_url'] ); ?>">
                    <img class="icon-blue" src="<?php echo DOCENT_PRO_CORE_URL .'assets/img/contact-icon-blue.svg' ?>" alt="">
                    <img class="icon-white" src="<?php echo DOCENT_PRO_CORE_URL .'assets/img/contact-icon-white.svg' ?>" alt="">
                    <?php esc_html_e('Contact Me', 'docent-pro-core') ?></a></li>
				<?php } ?>	
									
			</ul>

		<?php

		echo $after_widget;
	}


	/*-------------------------------------------------------
	 *				Sanitize data, save and retrive
	 *-------------------------------------------------------*/

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		//Strip tags from title and name to remove HTML 
		$instance['title'] 				= strip_tags( $new_instance['title'] );
		$instance['about_me_url'] 		= $new_instance['about_me_url'];
		$instance['courses_url'] 		= $new_instance['courses_url'];
		$instance['contact_me_url'] 		= $new_instance['contact_me_url'];

		return $instance;
	}


	/*-------------------------------------------------------
	 *				Back-End display of widget
	 *-------------------------------------------------------*/
	
	public function form( $instance )
	{

		$defaults = array(  'title' 			=> '',
							'about_me_url' 		=> '',
							'courses_url' 		=> '',
							'contact_me_url' 	=> '',
			);

		$instance = wp_parse_args( (array) $instance, $defaults );
	   ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e('Title :', 'docent-pro-core'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_html( $instance['title'] ); ?>" style="width:100%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'about_me_url' ); ?>"><?php esc_html_e('About Me URL: ', 'docent-pro-core'); ?></label>
			<input id="<?php echo $this->get_field_id( 'about_me_url' ); ?>" name="<?php echo $this->get_field_name( 'about_me_url' ); ?>" value="<?php echo esc_url( $instance['about_me_url'] ); ?>" style="width:100%;" />
		</p>		

		<p>
			<label for="<?php echo $this->get_field_id( 'courses_url' ); ?>"><?php esc_html_e('Courses URL: ', 'docent-pro-core'); ?></label>
			<input id="<?php echo $this->get_field_id( 'courses_url' ); ?>" name="<?php echo $this->get_field_name( 'courses_url' ); ?>" value="<?php echo esc_url( $instance['courses_url'] ); ?>" style="width:100%;" />
		</p>			

		<p>
			<label for="<?php echo $this->get_field_id( 'contact_me_url' ); ?>"><?php esc_html_e('Contact Me URL: ', 'docent-pro-core'); ?></label>
			<input id="<?php echo $this->get_field_id( 'contact_me_url' ); ?>" name="<?php echo $this->get_field_name( 'contact_me_url' ); ?>" value="<?php echo esc_url( $instance['contact_me_url'] ); ?>" style="width:100%;" />
		</p>		
		
	<?php
	}
}