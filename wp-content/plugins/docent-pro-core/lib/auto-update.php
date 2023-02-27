<?php

add_filter('plugins_api', 'docent_pro_core_plugin_infomation', 20, 3);
function docent_pro_core_plugin_infomation( $res, $action, $args ){

	if( 'plugin_information' !== $action ) {
		return false;
	}

	$plugin_slug = 'docent-pro-core';

	if( $plugin_slug !== $args->slug ) {
		return false;
	}

	if( false == $remote = get_transient( 'docent_pro_core_update_' . $plugin_slug ) ) {
		$remote = wp_remote_get( 'https://demo.themeum.com/wordpress/plugins/docent/update.json', array(
			'timeout' => 10,
			'headers' => array(
				'Accept' => 'application/json'
			) )
		);
		if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
			set_transient( 'docent_pro_core_update_' . $plugin_slug, $remote, 14400); // cache
		}
	}

	if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {

		$remote = json_decode( $remote['body'] );
		$res = new stdClass();

		$res->name = $remote->name;
		$res->slug = $plugin_slug;
		$res->new_version = $remote->new_version;
		$res->requires = $remote->requires;
		$res->author = '<a href="https://www.themeum.com/">Themeum</a>';
		$res->download_link = $remote->package;
		$res->trunk = $remote->package;
		$res->sections = array();
		return $res;

	}
	return false;
}

add_filter( 'site_transient_update_plugins', 'docent_pro_core_plugin_push_update' );
add_filter( 'transient_update_plugins', 'docent_pro_core_plugin_push_update' );

function docent_pro_core_plugin_push_update( $transient ){

	if ( ! is_object( $transient ) )
		return $transient;

	if ( ! isset( $transient->response ) || ! is_array( $transient->response ) )
		$transient->response = array();

	if( false == $remote = get_transient( 'docent_pro_core_upgrade_docent-pro-core' ) ) {

		$remote = wp_remote_get( 'https://demo.themeum.com/wordpress/plugins/docent/update.json', array(
			'timeout' => 10,
			'headers' => array(
				'Accept' => 'application/json'
			) )
		);

		if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
			set_transient( 'docent_pro_core_upgrade_docent-pro-core', $remote, 14400); // 1 hours cache
		}
	}

	if( $remote ) {
		$remote = json_decode( $remote['body'] );
		if( $remote && version_compare( DOCENT_PRO_CORE_VERSION, $remote->new_version, '<' )
			&& version_compare($remote->requires, get_bloginfo('version'), '<' ) ) {
			$res = new stdClass();
			$res->slug = 'docent-pro-core';
			$res->plugin = 'docent-pro-core/docent-pro-core.php';
			$res->new_version = $remote->new_version;
			$res->url = 'https://www.themeum.com/';
			$res->package = $remote->package;
			$res->compatibility = new stdClass();
       		$transient->response[$res->plugin] = $remote;
       	}
	}
	// echo '<pre>';print_r( $transient); exit;
    return $transient;
}

add_action( 'upgrader_process_complete', 'docent_pro_core_after_update', 10, 2 );

function docent_pro_core_after_update( $upgrader_object, $options ) {
	if ( $options['action'] == 'update' && $options['type'] === 'plugin' )  {
		delete_transient( 'docent_pro_core_upgrade_docent-pro-core' );
	}
}
