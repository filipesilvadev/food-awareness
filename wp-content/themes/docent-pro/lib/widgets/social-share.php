<?php

add_action('widgets_init','register_docent_social_share_widget');

function register_docent_social_share_widget(){
	register_widget('docent_social_share_Widget');
}

class docent_social_share_Widget extends WP_Widget{

	public function __construct() {
		parent::__construct( 'docent_social_share_Widget', esc_html__("Docent Social Share Widgets",'docent-pro'), array('description' => esc_html__("This Social Share Widgets",'docent-pro')) );
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
			<ul class="themeum-social-share">
				<?php if( isset($instance['facebook_url']) && $instance['facebook_url'] ) { ?>
					<li><a class="facebook" href="<?php echo esc_url( $instance['facebook_url'] ); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
				<?php } ?>

				<?php if( isset($instance['instagram_url']) && $instance['instagram_url'] ) { ?>
					<li><a class="instagram" href="<?php echo esc_url( $instance['instagram_url'] ); ?>" target="_blank"><i class="fab fa-instagram"></i></a></li>
				<?php } ?>	
				
				<?php if( isset($instance['twitter_url']) && $instance['twitter_url'] ) { ?>
					<li><a class="twitter" href="<?php echo esc_url( $instance['twitter_url'] ); ?>" target="_blank" ><i class="fab fa-twitter"></i></a></li>
				<?php } ?>				

				<?php if( isset($instance['gplus_url']) && $instance['gplus_url'] ) { ?>
					<li><a class="g-plus" href="<?php echo esc_url( $instance['gplus_url'] ); ?>" target="_blank"><i class="fab fa-google-plus"></i></a></li>
				<?php } ?>				

				<?php if( isset($instance['linkedin_url']) && $instance['linkedin_url'] ) { ?>
					<li><a class="linkedin" href="<?php echo esc_url( $instance['linkedin_url'] ); ?>" target="_blank"><i class="fab fa-linkedin"></i></a></li>
				<?php } ?>					

				<?php if( isset($instance['rss_url']) && $instance['rss_url'] ) { ?>
					<li><a class="rss" href="<?php echo esc_url( $instance['rss_url'] ); ?>" target="_blank"><i class="fas fa-rss"></i></a></li>
				<?php } ?>			

				<?php if( isset($instance['pinterest_url']) && $instance['pinterest_url'] ) { ?>
					<li><a class="pinterest" href="<?php echo esc_url( $instance['pinterest_url'] ); ?>" target="_blank"><i class="fab fa-pinterest"></i></a></li>
				<?php } ?>				

				<?php if( isset($instance['youtube_url']) && $instance['youtube_url'] ) { ?>
					<li><a class="youtube" href="<?php echo esc_url( $instance['youtube_url'] ); ?>" target="_blank"><i class="fab fa-youtube-play"></i></a></li>
				<?php } ?>												

				<?php if( isset($instance['vimeo_url']) && $instance['vimeo_url'] ) { ?>
					<li><a class="vimeo" href="<?php echo esc_url( $instance['vimeo_url'] ); ?>" target="_blank"><i class="fab fa-vimeo"></i></a></li>
				<?php } ?>				

				<?php if( isset($instance['dribble_url']) && $instance['dribble_url'] ) { ?>
					<li><a class="dribble" href="<?php echo esc_url( $instance['dribble_url'] ); ?>" target="_blank"><i class="fab fa-whatsapp"></i></a></li>
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
		$instance['facebook_url'] 		= $new_instance['facebook_url'];
		$instance['twitter_url'] 		= $new_instance['twitter_url'];
		$instance['gplus_url'] 			= $new_instance['gplus_url'];
		$instance['linkedin_url'] 		= $new_instance['linkedin_url'];
		$instance['rss_url'] 			= $new_instance['rss_url'];
		$instance['pinterest_url'] 		= $new_instance['pinterest_url'];
		$instance['youtube_url'] 		= $new_instance['youtube_url'];
		$instance['instagram_url'] 		= $new_instance['instagram_url'];
		$instance['vimeo_url'] 			= $new_instance['vimeo_url'];
		$instance['dribble_url'] 		= $new_instance['dribble_url'];

		return $instance;
	}


	/*-------------------------------------------------------
	 *				Back-End display of widget
	 *-------------------------------------------------------*/
	
	public function form( $instance )
	{

		$defaults = array(  'title' 			=> '',
							'facebook_url' 		=> '',
							'twitter_url' 		=> '',
							'gplus_url' 		=> '',
							'linkedin_url' 		=> '',
							'rss_url' 			=> '',
							'pinterest_url' 	=> '',
							'youtube_url' 		=> '',
							'instagram_url' 	=> '',
							'vimeo_url' 		=> '',
							'dribble_url' 		=> ''
			);

		$instance = wp_parse_args( (array) $instance, $defaults );
	   ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e('Title :', 'docent-pro'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_html( $instance['title'] ); ?>" style="width:100%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'facebook_url' ); ?>"><?php esc_html_e('Facebook URL: ', 'docent-pro'); ?></label>
			<input id="<?php echo $this->get_field_id( 'facebook_url' ); ?>" name="<?php echo $this->get_field_name( 'facebook_url' ); ?>" value="<?php echo esc_url( $instance['facebook_url'] ); ?>" style="width:100%;" />
		</p>		

		<p>
			<label for="<?php echo $this->get_field_id( 'twitter_url' ); ?>"><?php esc_html_e('Twitter URL: ', 'docent-pro'); ?></label>
			<input id="<?php echo $this->get_field_id( 'twitter_url' ); ?>" name="<?php echo $this->get_field_name( 'twitter_url' ); ?>" value="<?php echo esc_url( $instance['twitter_url'] ); ?>" style="width:100%;" />
		</p>		

		<p>
			<label for="<?php echo $this->get_field_id( 'gplus_url' ); ?>"><?php esc_html_e('Google Plus URL: ', 'docent-pro'); ?></label>
			<input id="<?php echo $this->get_field_id( 'gplus_url' ); ?>" name="<?php echo $this->get_field_name( 'gplus_url' ); ?>" value="<?php echo esc_url( $instance['gplus_url'] ); ?>" style="width:100%;" />
		</p>		

		<p>
			<label for="<?php echo $this->get_field_id( 'linkedin_url' ); ?>"><?php esc_html_e('Linkedin URL: ', 'docent-pro'); ?></label>
			<input id="<?php echo $this->get_field_id( 'linkedin_url' ); ?>" name="<?php echo $this->get_field_name( 'linkedin_url' ); ?>" value="<?php echo esc_url( $instance['linkedin_url'] ); ?>" style="width:100%;" />
		</p>			

		<p>
			<label for="<?php echo $this->get_field_id( 'rss_url' ); ?>"><?php esc_html_e('RSS URL: ', 'docent-pro'); ?></label>
			<input id="<?php echo $this->get_field_id( 'rss_url' ); ?>" name="<?php echo $this->get_field_name( 'rss_url' ); ?>" value="<?php echo esc_url( $instance['rss_url'] ); ?>" style="width:100%;" />
		</p>		

		<p>
			<label for="<?php echo $this->get_field_id( 'pinterest_url' ); ?>"><?php esc_html_e('Pinterest URL: ', 'docent-pro'); ?></label>
			<input id="<?php echo $this->get_field_id( 'pinterest_url' ); ?>" name="<?php echo $this->get_field_name( 'pinterest_url' ); ?>" value="<?php echo esc_url( $instance['pinterest_url'] ); ?>" style="width:100%;" />
		</p>		

		<p>
			<label for="<?php echo $this->get_field_id( 'youtube_url' ); ?>"><?php esc_html_e('Youtube URL: ', 'docent-pro'); ?></label>
			<input id="<?php echo $this->get_field_id( 'youtube_url' ); ?>" name="<?php echo $this->get_field_name( 'youtube_url' ); ?>" value="<?php echo esc_url( $instance['youtube_url'] ); ?>" style="width:100%;" />
		</p>			

		<p>
			<label for="<?php echo $this->get_field_id( 'instagram_url' ); ?>"><?php esc_html_e('Instagram URL: ', 'docent-pro'); ?></label>
			<input id="<?php echo $this->get_field_id( 'instagram_url' ); ?>" name="<?php echo $this->get_field_name( 'instagram_url' ); ?>" value="<?php echo esc_url( $instance['instagram_url'] ); ?>" style="width:100%;" />
		</p>		

		<p>
			<label for="<?php echo $this->get_field_id( 'vimeo_url' ); ?>"><?php esc_html_e('Vimeo URL: ', 'docent-pro'); ?></label>
			<input id="<?php echo $this->get_field_id( 'vimeo_url' ); ?>" name="<?php echo $this->get_field_name( 'vimeo_url' ); ?>" value="<?php echo esc_url( $instance['vimeo_url'] ); ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'dribble_url' ); ?>"><?php esc_html_e('Dribble URL: ', 'docent-pro'); ?></label>
			<input id="<?php echo $this->get_field_id( 'dribble_url' ); ?>" name="<?php echo $this->get_field_name( 'dribble_url' ); ?>" value="<?php echo esc_url( $instance['dribble_url'] ); ?>" style="width:100%;" />
		</p>
		
	<?php
	}
}