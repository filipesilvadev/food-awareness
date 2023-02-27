<?php
/*
 * Plugin Name:       Docent Pro Demo Importer 
 * Plugin URI:        https://www.themeum.com/
 * Description:       Demo Importer Plugin for Docent Pro Theme
 * Version: 		  1.0.2
 * Author:            Themeum.com
 * Author URI:        https://themeum.com/
 * Text Domain:       merlin-wp 
 * Requires at least: 5.0
 * Tested up to: 	  5.9
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) || exit;

define( 'DOCENT_PRO_DEMO_IMPORTER_URL', plugin_dir_url(__FILE__) );
define( 'DOCENT_PRO_DEMO_IMPORTER_PATH', plugin_dir_path(__FILE__) );



/* -------------------------------------------
*   Require file
* -------------------------------------------- */
function docent_pro_demo_import_require_file(){
	require_once DOCENT_PRO_DEMO_IMPORTER_PATH. '/merlin/vendor/autoload.php';
	require_once DOCENT_PRO_DEMO_IMPORTER_PATH. '/merlin/class-merlin.php';
	require_once DOCENT_PRO_DEMO_IMPORTER_PATH. '/merlin-config.php';
}
add_action('init', 'docent_pro_demo_import_require_file');


/* -------------------------------------------
*   Docent Pro Demo Content
* -------------------------------------------- */
function docent_pro_local_import_files() {
	return array(
		array(
			'import_file_name'             => 'Demo Import',
			'local_import_file'            => DOCENT_PRO_DEMO_IMPORTER_PATH. 'merlin/demo/content.xml',
			'local_import_widget_file'     => DOCENT_PRO_DEMO_IMPORTER_PATH. 'merlin/demo/widgets.wie',
			'local_import_customizer_file' => DOCENT_PRO_DEMO_IMPORTER_PATH. 'merlin/demo/customizer_data.dat',
			'import_notice'                => __( 'Import Edumax Demo Data', 'merlin-wp' ),
			'preview_url'                  => 'https://www.themeum.com/product/docent/',
		),
	);
}
add_filter( 'merlin_import_files', 'docent_pro_local_import_files' ); 


/* -------------------------------------------
*   Setup Menu after import complete
* -------------------------------------------- */
function docent_pro_merlin_after_import_setup() {

	$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
	set_theme_mod( 'nav_menu_locations', array(
			'primary'  => $main_menu->term_id,
		)
	);

	// Assign front page and posts page (blog page).
	$front_page_id = get_page_by_title( 'Home' );
	$blog_page_id  = get_page_by_title( 'Blog' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
	update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'merlin_after_all_import', 'docent_pro_merlin_after_import_setup' );


