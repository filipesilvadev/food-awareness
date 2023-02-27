<?php
/*
 * Plugin Name:       Docent Pro Core 
 * Plugin URI:        https://www.themeum.com/
 * Description:       Docent Core Plugin
 * Version: 		  1.0.5
 * Author:            Themeum.com
 * Author URI:        https://themeum.com/
 * Text Domain:       docent-pro-core 
 * Requires at least: 5.0
 * Tested up to: 	  5.9
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) || exit;

define('DOCENT_PRO_CORE_VERSION', '1.0.5');
define( 'DOCENT_PRO_CORE_URL', plugin_dir_url(__FILE__) );
define( 'DOCENT_PRO_CORE_PATH', plugin_dir_path(__FILE__) );

// Language Load
add_action( 'init', 'docent_pro_core_language_load');
function docent_pro_core_language_load(){
    load_plugin_textdomain( 'docent-pro-core', false,  basename(dirname(__FILE__)).'/languages/' );
}

require_once DOCENT_PRO_CORE_PATH . 'core/Functions.php';
function docent_pro_core(){
    return new Docent_Pro_Core_Functions();
    //add_action( 'rest_api_init', array($this, 'register_api_hook'));
}

/* -------------------------------------------
*              login system
* -------------------------------------------- */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
//require_once( ABSPATH . "wp-includes/pluggable.php" );
require_once( DOCENT_PRO_CORE_PATH . '/lib/login/login.php' );


require_once DOCENT_PRO_CORE_PATH . 'core/Base.php';

# Metabox Include
include_once( 'meta_box.php' );
include_once( 'meta-box/meta-box.php' );

//widget
require_once('widgets/blog-posts.php');
require_once('widgets/image_widget.php');
require_once('widgets/themeum_about_widget.php');
require_once('widgets/themeum_social_share.php');
require_once('widgets/docent-pro-widget-link.php');


# wp load login modal
function load_login_modal() {
    include_once( 'lib/login-modal.php' );
}
add_action( 'wp_footer', 'load_login_modal' );
require_once( 'lib/auto-update.php');
 

# Add CSS for Frontend
add_action( 'wp_enqueue_scripts', 'docent_pro_core_style' );
if(!function_exists('docent_pro_core_style')):
    function docent_pro_core_style(){
        # CSS
        wp_enqueue_style('docent-pro-core-css',plugins_url('assets/css/core.css',__FILE__));
        # JS
        wp_enqueue_script('custom',plugins_url('assets/js/custom.js',__FILE__), array('jquery'));
    }
endif;

function docent_pro_core_load_admin_assets() {
    wp_enqueue_script( 'docent-pro-core-admin', plugins_url('assets/js/admin.js', __FILE__), array('jquery') );
}
add_action( 'admin_enqueue_scripts', 'docent_pro_core_load_admin_assets' );

if ( ! function_exists( 'docent_pro_core_rest_fields' ) ) {
    function docent_pro_core_rest_fields() {
        $post_types = get_post_types();
        register_rest_field( $post_types, 'post_excerpt_docent_pro_core',
            array(
                'get_callback' => 'docent_pro_core_post_excerpt',
                'update_callback' => null,
                'schema' => array(
                    'description' => __( 'Post excerpt' ),
                    'type' => 'string',
                ),
            )
        );
        register_rest_field( 'portfolio', 'docent_pro_core_portfolio_cat_single',
            array(
                'get_callback' => 'docent_pro_core_catlist',
                'update_callback' => null,
                'schema' => array(
                    'description' => __( 'cat List' ),
                    'type' => 'string',
                ),
            )
        );
        register_rest_field( 'courses', 'docent_pro_core_price_item',
            array(
                'get_callback' => 'docent_pro_core_price',
                'update_callback' => null,
                'schema' => array(
                    'description' => __( 'Course Price' ),
                    'type' => 'string',
                ),
            )
        );
        register_rest_field( 'portfolio', 'docent_pro_core_portfolio_cat',
            array(
                'get_callback' => 'docent_pro_core_portfolio_catlist',
                'update_callback' => null,
                'schema' => array(
                    'description' => __( 'cat List' ),
                    'type' => 'string',
                ),
            )
        );
        register_rest_field( $post_types, 'docent_pro_core_image_urls',
        array(
            'get_callback' => 'docent_pro_core_featured_image_urls',
            'update_callback' => null,
            'schema' => array(
                'description' => __( 'Different sized featured images' ),
                'type' => 'array',
            ),
        )
    );
    }
}
add_action( 'rest_api_init', 'docent_pro_core_rest_fields' );

if ( ! function_exists( 'docent_pro_core_post_excerpt' ) ) {
    function docent_pro_core_post_excerpt( $post_id, $post = null ) {
        $post_content = apply_filters( 'the_content', get_post_field( 'post_content', $post_id ) );
        return apply_filters( 'the_excerpt', wp_trim_words( $post_content, 55 ) );
    }
}

if ( ! function_exists( 'docent_pro_core_catlist' ) ) {
    function docent_pro_core_catlist( $object ) {
        return get_the_term_list( $object['id'], 'portfolio-cat' );
    }
}

if ( ! function_exists( 'docent_pro_core_price' ) ) {
    function docent_pro_core_price( $object ) {
        //return tutor_course_loop_price( $object['id'], 'courses' );
        //$ssss = $price_html;
        //$ssss = tutor_course_loop_price();
        //return  $price_html;
    }
}

if ( ! function_exists( 'docent_pro_core_portfolio_catlist' ) ) {
    function docent_pro_core_portfolio_catlist( $object ) {
        return get_terms( 'portfolio-cat' );
    }
}

if ( ! function_exists( 'docent_pro_core_featured_image_urls' ) ) {
    function docent_pro_core_featured_image_urls( $object, $field_name, $request ) {
        $image = wp_get_attachment_image_src( $object['featured_media'], 'full', false );
        return array(
            'full' => is_array( $image ) ? $image : '',
            'portrait' => is_array( $image ) ? wp_get_attachment_image_src( $object['featured_media'], 'docent-pro-core-portrait', false ) : '',
            'thumbnail' => is_array( $image ) ? wp_get_attachment_image_src( $object['featured_media'], 'docent-pro-core-thumbnail', false ) : '',
        );
    }
}

if ( ! function_exists( 'docent_pro_core_blog_posts_image_sizes' ) ) {
    function docent_pro_core_blog_posts_image_sizes() {
        add_image_size( 'docent-pro-core-portrait', 700, 870, true );
        add_image_size( 'docent-pro-core-thumbnail', 140, 100, true );
    }
    add_action( 'after_setup_theme', 'docent_pro_core_blog_posts_image_sizes' );
}

/* -------------------------------------------
* 			Course Search.
* ------------------------------------------- */
function course_search_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'class' 		=> '',
        'placeholder' 	=> __('Search Course...', 'docent-pro')
    ), $atts));
    ob_start();
    $action = function_exists('tutor_utils') ? tutor_utils()->course_archive_page_url() : site_url('/'); ?>
    
    <form action="<?php echo esc_url(home_url( '/' )); ?>" class="<?php echo esc_attr($class); ?> search_form_shortcode" role="search" action="<?php echo esc_url($action); ?>" method="get">
      	<div class="search-wrap">
	        <div class="search pull-right docent-top-search">
	          	<div class="sp_search_input">
	            	<input type="text" name="s" value="<?php echo get_search_query(); ?>" class="form-control" placeholder="<?php echo esc_attr($placeholder); ?>"/>
	        		<input type="hidden" name="post_type" value="course" />
	          	</div>
	        </div>
      	</div>
    </form>

    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode('course_search', 'course_search_shortcode');


//Register api hook
function register_api_hook(){
    register_rest_route( 
        'tutor/v1', 'category', array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => 'get_tutor_courses_category',
                'permission_callback' => '__return_true',
            ),
        )    
    );
    register_rest_route( 
        'tutor/v1', 'course', array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => 'get_tutor_course',
                'permission_callback' => '__return_true',
            ),
        )    
    );
    register_rest_route( 
        'tutor/v1', 'price', array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => 'get_tutor_price',
                'permission_callback' => '__return_true',
            ),
        )    
    );
}	
add_action('rest_api_init','register_api_hook');

function get_tutor_courses_category($data) {
    $list = wp_list_categories(
        array(
            'taxonomy' => 'course-category',
            'title_li' => ''
        )
    );
    return $list;
}
function get_tutor_course() {
    return 'it is working course';
}
function get_tutor_price() {
    //return rest_ensure_response( 'Hello World! This is my first REST price' );
    $posts = get_posts( array(
        'numberposts'		=> 3,
        'post_type'		=> 'courses',
      ) );
     
      if ( empty( $posts ) ) {
        return null;
      }
      $aa = [];
      foreach ($posts as $post) {
        $aa[] = get_permalink($post->ID);
        $aa[] = get_permalink($post->ID);
        $aa[] = get_the_title($post->ID);
        $aa[] = get_tutor_course_level($post->ID);
        ob_start();
        $aa[] = tutor_course_price();
        $aa[] = ob_get_clean();
        print_r($post);
      }
      return $aa;
      //return $posts[0]->post_title;
}
