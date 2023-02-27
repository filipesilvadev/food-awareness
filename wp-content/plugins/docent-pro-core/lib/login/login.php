<?php
add_action('init', 'themeum_before_login_init');

function themeum_before_login_init(){

	if ( is_user_logged_in() ) return;

    //Wordpress Default
    require_once( DOCENT_PRO_CORE_PATH  . '/lib/login/wordpress/wordpress.php' );
    
    //Google Login
    require_once( DOCENT_PRO_CORE_PATH  . '/lib/login/google/google.php' );

    //Facebook Login
    require_once( DOCENT_PRO_CORE_PATH  . '/lib/login/facebook/facebook.php' );

    //Twitter Login
   require_once( DOCENT_PRO_CORE_PATH  . '/lib/login/twitter/twitter.php' );
}

# General Registration Login
add_action( 'wp_ajax_nopriv_ajaxregister', 'themeum_ajax_register_new_user' );
function themeum_ajax_register_new_user(){
    check_ajax_referer( 'ajax-register-nonce', 'security' );
    if( !$_POST['username'] ){
    	echo json_encode(array( 'loggedin'=>false, 'message'=> __('Wrong!!! Username field is empty.','docent-pro-core') ));
    	die();
    }elseif( !$_POST['email'] ){
    	echo json_encode(array( 'loggedin'=>false, 'message'=> __('Wrong!!! Email field is empty.','docent-pro-core') ));
    	die();
    }elseif( !$_POST['password'] ){
    	echo json_encode(array( 'loggedin'=>false, 'message'=> __('Wrong!!! Password field is empty.','docent-pro-core') ));
    	die();
    } else {
		if( username_exists( $_POST['username'] ) ){
			echo json_encode(array( 'loggedin'=>false, 'message'=> __('Wrong!!! Username already exits.','docent-pro-core') ));
			die();
		} elseif( strlen($_POST['password']) <= 6 ){
			echo json_encode(array( 'loggedin'=>false, 'message'=> __('Wrong!!! Password must 7 charecter or more.','docent-pro-core') ));
			die();
		} elseif( !is_email($_POST['email']) ){
			echo json_encode(array( 'loggedin'=>false, 'message'=> __('Wrong!!! Email address is not correct.','docent-pro-core') ));
			die();
		} elseif( email_exists($_POST['email']) ){
			echo json_encode(array( 'loggedin'=>false, 'message'=> __('Wrong!!! Email user already exits in this site.','docent-pro-core') ));
			die();
		} else {
			$user_input = array(
				'user_login'    =>  $_POST['username'],
                'display_name'	=>  $_POST['username'],
				'user_email'    =>  $_POST['email'],
				'user_pass'     =>  $_POST['password']
			);
			$user_id = wp_insert_user( $user_input );
			if ( ! is_wp_error( $user_id ) ) {
				echo json_encode(array( 'loggedin'=>true, 'message'=> __('Registration successful you can login now.', 'docent-pro-core') ));
				die();
			}else{
				echo json_encode(array('loggedin'=>false, 'message'=> __('Wrong username or password.', 'docent-pro-core') ));
				die();
			}
		}
    }
}

