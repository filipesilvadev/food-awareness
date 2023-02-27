<?php

function pmpro_eu_dkk_format( $pmpro_currencies ) {
 
	$pmpro_currencies['DKK'] = array(
		'name'                => __( 'Real Brazil', 'paid-memberships-pro' ),
		'decimals'            => '3',
		'thousands_separator' => '&nbsp;',
		'decimal_separator'   => ',',
		'symbol'              => 'R$ ',
		'position'            => 'left',
	);
 
	return $pmpro_currencies;
 
}
add_filter( 'pmpro_currencies', 'pmpro_eu_dkk_format' );




define( 'DOCENT_PRO_CSS', get_template_directory_uri().'/css/' );
define( 'DOCENT_PRO_JS', get_template_directory_uri().'/js/' );
define( 'DOCENT_PRO_DIR', get_template_directory() );
define( 'DOCENT_PRO_URI', trailingslashit(get_template_directory_uri()) );

/* -------------------------------------------- *
 * Guttenberg for Themeum Themes
 * -------------------------------------------- */
add_theme_support( 'align-wide' );
add_theme_support( 'wp-block-styles' );

/* -------------------------------------------- *
 * Include TGM Plugins
 * -------------------------------------------- */
get_template_part('lib/class-tgm-plugin-activation');

/* -------------------------------------------- *
 * Register Navigation
 * -------------------------------------------- */
register_nav_menus( array(
	'primary' 	=> esc_html__( 'Primary Menu', 'docent-pro' )
	) 
);

//Membership Pro Sign Up Shortcode
get_template_part('lib/shortcode/pmpro/pmpro-advanced-levels-shortcode');


/* -------------------------------------------- *
 * Docent Coustm Login
 * -------------------------------------------- */
function docent_custom_login() {
    return 'login-popup';

}
add_filter( 'tutor_enroll_required_login_class', 'docent_custom_login');

/* -------------------------------------------- *
* Navwalker
* -------------------------------------------- */

get_template_part('lib/menu/mobile-navwalker');

/* -------------------------------------------- *
 * Themeum Register
 * -------------------------------------------- */
get_template_part('lib/main-function/docent-register');

/* -------------------------------------------- *
 * Themeum Core
 * -------------------------------------------- */
get_template_part('lib/main-function/docent-core');

/* -------------------------------------------- *
 * Customizer
 * -------------------------------------------- */
get_template_part('lib/customizer/libs/googlefonts');
get_template_part('lib/customizer/customizer');

/* -------------------------------------------- *
*  Widgets
* -------------------------------------------- */
get_template_part('lib/widgets/about-widget');
get_template_part('lib/widgets/social-share');


/* -------------------------------------------- *
 * Custom Excerpt Length
 * -------------------------------------------- */
if(!function_exists('docent_excerpt_max_charlength')):
	function docent_excerpt_max_charlength($charlength) {
		$excerpt = get_the_excerpt();
		$charlength++;

		if ( mb_strlen( $excerpt ) > $charlength ) {
			$subex = mb_substr( $excerpt, 0, $charlength - 5 );
			$exwords = explode( ' ', $subex );
			$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
			if ( $excut < 0 ) {
				return mb_substr( $subex, 0, $excut );
			} else {
				return $subex;
			}
		} else {
			return $excerpt;
		}
	}
endif;


/*------------------------------------------- *
*			Woocommerce Support
*-------------------------------------------- */
add_action( 'after_setup_theme', 'wpeducon_woocommerce_support' );
function wpeducon_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

/* -------------------------------------------- *
* Custom body class
* -------------------------------------------- */
add_filter( 'body_class', 'docent_body_class' );
function docent_body_class( $classes ) {
    $docent_pro_layout = get_theme_mod( 'boxfull_en', 'fullwidth' );
    $classes[] = $docent_pro_layout.'-bg'.' body-content';
	return $classes;
}

/* ------------------------------------------- *
* Logout Redirect Home
* ------------------------------------------- */
add_action( 'wp_logout', 'docent_auto_redirect_external_after_logout');
function docent_auto_redirect_external_after_logout(){
  wp_redirect( home_url('/') );
  exit();
}

/* ------------------------------------------- *
* Add a pingback url auto-discovery header for 
* single posts, pages, or attachments
* ------------------------------------------- */
function docent_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'docent_pingback_header' );

 
/* -------------------------------------------
 * 				SVG image upload
 * ------------------------------------------- */
function docent_pro_mime_types( $mimes ){
$mimes['svg'] = 'image/svg+xml';
$mimes['svgz'] = 'image/svg+xml';
return $mimes;
}
add_filter('upload_mimes', 'docent_pro_mime_types');


/* -------------------------------------------
* 			Product Subscriptions
* -------------------------------------------- */
function wc_subscriptions_custom_price_string( $pricestring ) {
    $pricestring = str_replace( 'with a 1-day free trial and a', '<br><span class="trial">1-day free trial and</span>', $pricestring );
    $pricestring = str_replace( 'with a 2-day free trial and a', '<br><span class="trial">2-day free trial and</span>', $pricestring );
    $pricestring = str_replace( 'with a 3-day free trial and a', '<br><span class="trial">3-day free trial and</span>', $pricestring );
    $pricestring = str_replace( 'with a 4-day free trial and a', '<br><span class="trial">4-day free trial and</span>', $pricestring );
    $pricestring = str_replace( 'with a 5-day free trial and a', '<br><span class="trial">5-day free trial and</span>', $pricestring );
    $pricestring = str_replace( 'with a 6-day free trial and a', '<br><span class="trial">6-day free trial and</span>', $pricestring );
    $pricestring = str_replace( 'with a 7-day free trial and a', '<br><span class="trial">7-day free trial and</span>', $pricestring );
    $pricestring = str_replace( 'with a 8-day free trial and a', '<br><span class="trial">8-day free trial and</span>', $pricestring );
    $pricestring = str_replace( 'with a 9-day free trial and a', '<br><span class="trial">9-day free trial and</span>', $pricestring );
    $pricestring = str_replace( 'with a 10-day free trial and a', '<br><span class="trial">10-day free trial and</span>', $pricestring );
    $pricestring = str_replace( 'with a 1-week free trial and a', '<br><span class="trial">1-week free trial and</span>', $pricestring );
    $pricestring = str_replace( 'with a 2-week free trial and a', '<br><span class="trial">2-week free trial and</span>', $pricestring );
    $pricestring = str_replace( 'with a 3-week free trial and a', '<br><span class="trial">3-week free trial and</span>', $pricestring );
    $pricestring = str_replace( 'with 1 month free trial and a', '<br><span class="trial">with 1 month free trial and</span>', $pricestring );
    $pricestring = str_replace( 'with 1 year free trial and a', '<br><span class="trial">with 1 year free trial and</span>', $pricestring );
    $pricestring = str_replace( 'sign-up fee', '<span class="trial">signup fee</span>', $pricestring );

    return $pricestring;
}
add_filter( 'woocommerce_subscriptions_product_price_string', 'wc_subscriptions_custom_price_string' );
add_filter( 'woocommerce_subscription_price_string', 'wc_subscriptions_custom_price_string' );




/* -------------------------------------------
*             License for docent Theme
* -------------------------------------------- */
require_once( DOCENT_PRO_DIR . '/updater/update.php' );

$thm_theme_data = wp_get_theme();
$args = array(
    'product_title'      => $thm_theme_data->get( 'Name' ),
    'product_slug'       => 'docent-pro',
    'product_basename'   => 'docent-pro',
    'product_type'       => 'theme',
    'current_version'    => $thm_theme_data->get( 'Version' ),
    'menu_title'         => 'License',
    'parent_menu'        => 'docent-options',
    'menu_capability'    => 'manage_options',
    'license_option_key' => 'docent pro_license_info',
    'updater_url'        => get_template_directory_uri() . '/updater/',
    'header_content'     => '<img src="'. get_template_directory_uri() . '/images/logo.svg' .'" style="width:auto;height:50px"/>',
);

new \ThemeumUpdater\Update( $args );

/* -------------------------------------------
*        		Licence Code
* ------------------------------------------- */

if ( is_user_logged_in() && user_can( get_current_user_id(), 'manage_options' ) ) {
    add_action( 'admin_menu', 'docent_options_menu' );

    if ( ! function_exists( 'docent_options_menu' ) ) {
        function docent_options_menu() {
            global $submenu;
            $personalblog_option_page = add_menu_page( 'Docent Options', 'Docent Options', 'manage_options', 'docent-options', 'docent_option_callback' );
            add_action( 'load-' . $personalblog_option_page, 'docent_option_page_check' );

            add_submenu_page( 'docent-options', 'Options', 'Options', 'manage_options', 'docent-options', 'docent_option_callback' );
            $submenu['docent-options'][] = array( 'Documentation', 'manage_options' , 'https://docs.themeum.com/themes/docent/' );
            $submenu['docent-options'][] = array( 'Support', 'manage_options' , 'https://www.themeum.com/support/' );
        }
    }
}

function docent_option_callback(){}
function docent_option_page_check(){
    global $current_screen;
    if ($current_screen->id === 'toplevel_page_docent-options'){
        wp_redirect(admin_url('customize.php'));
    }
}

// Tutor Function

if ( ! function_exists('get_tutor_course_duration_context_docent')) {
    function get_tutor_course_duration_context_docent( $course_id = 0 ) {
        if ( ! $course_id ) {
            $course_id = get_the_ID();
        }
        if ( ! $course_id ) {
            return '';
        }
        $duration        = get_post_meta( $course_id, '_course_duration', true );
        $durationHours   = tutor_utils()->avalue_dot( 'hours', $duration );
        $durationMinutes = tutor_utils()->avalue_dot( 'minutes', $duration );
        $durationSeconds = tutor_utils()->avalue_dot( 'seconds', $duration );

        if ( $duration ) {
            $output = '';
            if ( $durationHours > 0 ) {
                $output .= $durationHours . "h ";
            }

            if ( $durationMinutes > 0 ) {
                $output .= $durationMinutes . "m ";
            }

            if ( $durationSeconds > 0 ) {
                $output .= $durationSeconds  . "s ";
            }

            return $output;
        }

        return false;
    }
}

/**
 * Convert Hex to RGB
 * 
 * @return string
 * 
 * @since 1.2.0
 */
if ( ! function_exists('docent_pro_hex2rgb')) {
    function docent_pro_hex2rgb( string $color ) {

        $default = '0, 0, 0';

        if ( $color === '' ) {
            return '';
        }

        if ( strpos( $color, 'var(--' ) === 0 ) {
            return preg_replace( '/[^A-Za-z0-9_)(\-,.]/', '', $color );
        }

        // convert hex to rgb
        if ($color[0] == '#' ) {
            $color = substr( $color, 1 );
        } else {
            return $default;
        }

        //Check if color has 6 or 3 characters and get values
        if ( strlen( $color ) == 6 ) {
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
            $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
            return $default;
        }

        $rgb =  array_map('hexdec', $hex);

        return implode(", ", $rgb);
    }
}