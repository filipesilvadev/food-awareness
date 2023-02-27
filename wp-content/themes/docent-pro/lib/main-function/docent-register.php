<?php
/* -------------------------------------------- *
 * Themeum Widget
 * -------------------------------------------- */
if(!function_exists('docent_widdget_init')):

    function docent_widdget_init() {
        
        register_sidebar(array(
                'name'          => esc_html__( 'Sidebar', 'docent-pro' ),
                'id'            => 'sidebar',
                'description'   => esc_html__( 'Widgets in this area will be shown on Sidebar.', 'docent-pro' ),
                'before_title'  => '<h3 class="widget_title">',
                'after_title'   => '</h3>',
                'before_widget' => '<div id="%1$s" class="widget %2$s" >',
                'after_widget'  => '</div>'
            )
        );

        register_sidebar(array(
                'name'          => esc_html__( 'Bottom 1', 'docent-pro' ),
                'id'            => 'bottom1',
                'description'   => esc_html__( 'Widgets in this area will be shown before Bottom 1.' , 'docent-pro'),
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
                'before_widget' => '<div class="bottom-widget"><div id="%1$s" class="widget %2$s" >',
                'after_widget'  => '</div></div>'
            )
        );

        register_sidebar(array(
            'name'          => esc_html__( 'Bottom 2', 'docent-pro' ),
            'id'            => 'bottom2',
            'description'   => esc_html__( 'Widgets in this area will be shown before Bottom 2.' , 'docent-pro'),
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
            'before_widget' => '<div class="bottom-widget"><div id="%1$s" class="widget %2$s" >',
            'after_widget'  => '</div></div>'
            )
        );

        register_sidebar(array(
            'name'          => esc_html__( 'Bottom 3', 'docent-pro' ),
            'id'            => 'bottom3',
            'description'   => esc_html__( 'Widgets in this area will be shown before Bottom 3.' , 'docent-pro'),
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
            'before_widget' => '<div class="bottom-widget"><div id="%1$s" class="widget %2$s" >',
            'after_widget'  => '</div></div>'
            )
        );
        register_sidebar(array(
            'name'          => esc_html__( 'Bottom 4', 'docent-pro' ),
            'id'            => 'bottom4',
            'description'   => esc_html__( 'Widgets in this area will be shown before Bottom 4.' , 'docent-pro'),
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
            'before_widget' => '<div class="bottom-widget"><div id="%1$s" class="widget %2$s" >',
            'after_widget'  => '</div></div>'
            )
        );
    }

    add_action('widgets_init','docent_widdget_init');

endif;

/* -------------------------------------------- *
* Themeum Style
* --------------------------------------------- */
if(!function_exists('docent_style')):

    function docent_style(){

        wp_enqueue_media();
        # CSS
        wp_enqueue_style( 'bootstrap.min', DOCENT_PRO_CSS . 'bootstrap.min.css',false,'all');
        wp_enqueue_style( 'woocommerce-css', DOCENT_PRO_CSS . 'woocommerce.css',false,'all');
        wp_enqueue_style( 'nice-select-css', DOCENT_PRO_CSS . 'nice-select.css',false,'all');
        wp_enqueue_style( 'fontawesome.min', DOCENT_PRO_CSS . 'fontawesome.min.css',false,'all');
        wp_enqueue_style( 'magnific', DOCENT_PRO_CSS . 'magnific-popup.css',false,'all');
        wp_enqueue_style( 'slick', DOCENT_PRO_CSS . 'slick.css',false,'all');
        wp_enqueue_style( 'docent-main', DOCENT_PRO_CSS . 'main.css',false,'all');
        wp_enqueue_style( 'docent-responsive', DOCENT_PRO_CSS . 'responsive.css',false,'all');
        wp_enqueue_style( 'docent-style',get_stylesheet_uri());
        wp_add_inline_style( 'docent-style', docent_css_generator() );

        # JS
        wp_enqueue_script( 'main-tether','https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js',array(),false,true);
        wp_enqueue_script( 'bootstrap',DOCENT_PRO_JS.'bootstrap.min.js',array(),false,true);
        wp_enqueue_script( 'loopcounter',DOCENT_PRO_JS.'loopcounter.js',array(),false,true);
        wp_enqueue_script( 'slick.min',DOCENT_PRO_JS.'slick.min.js',array(),false,true);
        wp_enqueue_script( 'nice-select',DOCENT_PRO_JS.'jquery.nice-select.min.js',array(),false,true);
        wp_enqueue_script( 'magnific-popup',DOCENT_PRO_JS.'jquery.magnific-popup.min.js',array(),false,true);
        wp_enqueue_script( 'jquery.prettySocial',DOCENT_PRO_JS.'jquery.prettySocial.min.js',array(),false,true);
        wp_enqueue_script('docent-main', DOCENT_PRO_JS.'main.js',array(),false,true);

        # For Ajax URL
        global $wp;
        wp_localize_script( 'docent-main', 'ajax_object', array(
            'ajaxurl'           => admin_url( 'admin-ajax.php' ),
            'redirecturl'       => home_url($wp->request),
            'loadingmessage'    => __('Sending user info, please wait...','docent-pro')
        ));
    
        # Single Comments
        if ( is_singular() ) { wp_enqueue_script( 'comment-reply' ); }
        
    }
    add_action('wp_enqueue_scripts','docent_style');

endif;


# Control JS
function docent_customize_control_js() {
    wp_enqueue_script( 'thmc-customizer', DOCENT_PRO_URI.'lib/customizer/assets/js/customizer.js', array('jquery', 'jquery-ui-datepicker'), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'docent_customize_control_js' );

# Enqueue Block Editor
add_action('enqueue_block_editor_assets', 'docent_action_enqueue_block_editor_assets');
function docent_action_enqueue_block_editor_assets() {
    wp_enqueue_style( 'bootstrap-grid.min', DOCENT_PRO_CSS . 'bootstrap-grid.min.css',false,'all');
    wp_enqueue_style( 'docent-style', get_stylesheet_uri() );
    wp_enqueue_style( 'docent-gutenberg-editor-styles', get_template_directory_uri() . '/css/style-editor.css', null, 'all' );
    wp_add_inline_style( 'docent-style', docent_css_backend_generator() );
}

/* -------------------------------------------- *
* Backend Style for Metabox
* -------------------------------------------- */
if(!function_exists('docent_admin_style')):
    function docent_admin_style(){
        wp_enqueue_media();
        # JS
        wp_register_script('thmpostmeta', get_template_directory_uri() .'/js/admin/post-meta.js');
        wp_enqueue_script('docent-widget-js', get_template_directory_uri().'/js/widget-js.js', array('jquery'));
        wp_enqueue_script('thmpostmeta');
    }
    add_action('admin_enqueue_scripts','docent_admin_style');

endif;

/* -------------------------------------------- *
* TGM for Plugin activation
* -------------------------------------------- */
add_action( 'tgmpa_register', 'docent_plugins_include');

if(!function_exists('docent_plugins_include')):
    function docent_plugins_include(){
        $plugins = array(
            array(
                'name'                  => esc_html__( 'Qubely', 'docent-pro' ),
                'slug'                  => 'qubely',
                'required'              => true,
                'version'               => '',
                'force_activation'      => false,
                'force_deactivation'    => false,
                'external_url'          => esc_url('https://downloads.wordpress.org/plugin/qubely.zip'),
            ),
            array(
                'name'                  => esc_html__( 'Tutor – Ultimate WordPress LMS plugin', 'docent-pro' ),
                'slug'                  => 'tutor',
                'required'              => true,
                'version'               => '',
                'force_activation'      => false,
                'force_deactivation'    => false,
                'external_url'          => esc_url('https://downloads.wordpress.org/plugin/tutor.zip'),
            ),
            array(
                'name'                  => 'Docent Pro Demo Importer',
                'slug'                  => 'docent-pro-demo-importer',
                'source'                => get_template_directory_uri() . '/lib/plugins/docent-pro-demo-importer.zip',
                'required'              => false,
                'version'               => '1.0.2',
                'force_activation'      => false,
                'force_deactivation'    => false,
                'external_url'          => '',
            ),
            array(
                'name'                  => esc_html__( 'Docent Pro Core', 'docent-pro' ),
                'slug'                  => 'docent-pro-core',
                'source'                => get_template_directory_uri() . '/lib/plugins/docent-pro-core.zip',
                'required'              => true,
                'version'               => '1.0.5',
                'force_activation'      => false,
                'force_deactivation'    => false,
                'external_url'          => '',
            ),
           
            array(
                'name'                  => esc_html__( 'MailChimp for WordPress', 'docent-pro' ),
                'slug'                  => 'mailchimp-for-wp',
                'required'              => false,
            ),
            array(
                'name'                  => 'WooCommerce',
                'slug'                  => 'woocommerce',
                'required'              => false,
                'version'               => '',
                'force_activation'      => false,
                'force_deactivation'    => false,
                'external_url'          => 'https://downloads.wordpress.org/plugin/woocommerce.3.1.1.zip', 
            ),     
            array(
                'name'                  => 'Paid Memberships Pro',
                'slug'                  => 'paid-memberships-pro',
                'required'              => false,
                'version'               => '',
                'force_activation'      => false,
                'force_deactivation'    => false,
                'external_url'          => 'https://downloads.wordpress.org/plugin/paid-memberships-pro.zip', 
            ),     
        );

        $config = array(
            'domain'            => 'docent-pro',
            'default_path'      => '',
            'menu'              => 'install-required-plugins',
            'has_notices'       => true,
            'dismissable'       => true, 
            'dismiss_msg'       => '', 
            'is_automatic'      => false,
            'message'           => ''
        );

        tgmpa( $plugins, $config );
    }

endif;
