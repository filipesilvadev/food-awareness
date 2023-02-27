<?php

/* -------------------------------------------- *
 * Docent Pro Supports
 * -------------------------------------------- */
if(!function_exists('docent_pro_setup')): 

    function docent_pro_setup(){
        load_theme_textdomain( 'docent-pro', get_template_directory() . '/languages' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_image_size( 'docent-large', 1140, 570, true );
        add_image_size( 'docent-blog', 700, 870, true );
        add_image_size( 'docent-medium', 362, 300, true );
        add_theme_support( 'post-formats', array( 'audio','gallery','image','link','quote','video' ) );
        add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form' ) );
        add_theme_support( 'automatic-feed-links' );

        # Enable Custom Background.
        add_theme_support( 'custom-background' );

        # Enable Logo 
        add_theme_support( 'custom-logo' );

        # Add support for Block Styles.
        add_theme_support( 'wp-block-styles' );

        # Add support for full and wide align images.
        add_theme_support( 'align-wide' );

        # Add support for editor styles.
        add_theme_support( 'editor-styles' );

        # Enqueue editor styles.
        add_editor_style( 'style-editor.css' );

        # Add support for font size.
        add_theme_support( 'editor-font-sizes', array(
            array(
                'name' => __( 'small', 'docent-pro' ),
                'shortName' => __( 'S', 'docent-pro' ),
                'size' => 16,
                'slug' => 'small'
            ),
            array(
                'name' => __( 'regular', 'docent-pro' ),
                'shortName' => __( 'M', 'docent-pro' ),
                'size' => 22,
                'slug' => 'regular'
            ),
            array(
                'name' => __( 'large', 'docent-pro' ),
                'shortName' => __( 'L', 'docent-pro' ),
                'size' => 28,
                'slug' => 'large'
            ),
            array(
                'name' => __( 'larger', 'docent-pro' ),
                'shortName' => __( 'XL', 'docent-pro' ),
                'size' => 38,
                'slug' => 'larger'
            )
        ) );


        if ( ! isset( $content_width ) ){
            $content_width = 660;
        }
    }
    add_action('after_setup_theme','docent_pro_setup');

endif;



/* -------------------------------------------- *
* Docent Pro Pagination
* -------------------------------------------- */
if(!function_exists('docent_pro_pagination')):
    function docent_pro_pagination( $page_numb , $max_page ){
        $docent_pro_output = '';
        $big = 999999999;
        $docent_pro_output .= '<div class="docent-pagination" data-preview="fas fa-angle-left" data-nextview="fas fa-angle-right">';
        $docent_pro_output .= paginate_links( array(
            'base'          => esc_url_raw(str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) )),
            'format'        => '?paged=%#%',
            'current'       => $page_numb,
            'prev_text'     => '<i class="fas fa-angle-left"></i>',
            'next_text'     => '<i class="fas fa-angle-right"></i>',
            'total'         => $max_page,
            'type'          => 'list',
        ) );
        $docent_pro_output .= '</div>';
        return $docent_pro_output;
    }

endif;

/* -------------------------------------------- *
 * Docent Pro Comment
 * -------------------------------------------- */
if(!function_exists('docent_comment')):

    function docent_comment($comment, $docent_pro_args, $depth){
        // $GLOBALS['comment'] = $comment;
        switch ( $comment->comment_type ) :
            case 'pingback' :
            case 'trackback' :
        ?>
        <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
        <?php
            break;
            default :
            // global $post;
        ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
            <div id="comment-<?php comment_ID(); ?>" class="comment-body">
                <div class="comment-avartar pull-left">
                    <?php echo get_avatar( $comment, $docent_pro_args['avatar_size'] ); ?>
                </div>
                <div class="comment-context">
                    <div class="comment-head">
                        <?php echo '<span class="comment-author">' . get_the_author() . '</span>'; ?>
                        <span class="comment-date"><i class="far fa-calendar" aria-hidden="true"></i> <?php echo esc_attr(get_comment_date()); ?></span>
                        <?php edit_comment_link( esc_html__( 'Edit', 'docent-pro' ), '<span class="edit-link">', '</span>' ); ?>
                    </div>
                    <?php if ( '0' == $comment->comment_approved ) : ?>
                        <p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'docent-pro' ); ?></p>
                    <?php endif; ?>
                    <span class="comment-reply">
                        <?php comment_reply_link( array_merge( $docent_pro_args, array( 'reply_text' => '<i class="fas fa-reply"></i> '.esc_html__( 'Reply', 'docent-pro' ), 'after' => '', 'depth' => $depth, 'max_depth' => $docent_pro_args['max_depth'] ) ) ); ?>
                    </span>
                </div>
                <div class="comment-content">
                    <?php comment_text(); ?>
                </div>
            </div>
        <?php
            break;
        endswitch;
    }

endif;

/* -------------------------------------------- *
 * Coming Soon Page Settings
 * -------------------------------------------- */
if ( get_theme_mod( 'comingsoon_en', false ) ) {
    if(!function_exists('docent_page_template_redirect')):
        function docent_page_template_redirect()
        {
            if( is_page() || is_home() || is_category() || is_single() )
            {
                if( !is_super_admin( get_current_user_id() ) ){
                    get_template_part( 'coming','soon');
                    exit();
                }
            }
        }
        add_action( 'template_redirect', 'docent_page_template_redirect' );
    endif;

    if(!function_exists('docent_cooming_soon_wp_title')):
        function docent_cooming_soon_wp_title(){
            return 'Coming Soon';
        }
        add_filter( 'wp_title', 'docent_cooming_soon_wp_title' );
    endif;
}

/* -------------------------------------------- *
 * CSS Generator Frontend
 * -------------------------------------------- */
if(!function_exists('docent_css_generator')){
    function docent_css_generator(){
        $docent_pro_output = '';
        $preset = get_theme_mod( 'preset', '1' );
        if( $preset ){
            if( get_theme_mod( 'custom_preset_en', true ) ) {
                // CSS Color
                $major_color = get_theme_mod( 'major_color', '#1b52d8' );
                if ($major_color) {
                    $docent_pro_output .= '
                    a,
                    .widget ul li a:hover,
                    .header-cat-menu div i.fa-qrcode, 
                    body.woocommerce-account .woocommerce-MyAccount-navigation ul li:hover a,
                    body.woocommerce-account .woocommerce-MyAccount-navigation ul li.is-active a,
                    .tutor-courses-grid-price span.woocommerce-Price-amount.amount,
                    .blog-post-review-pre p.prev, 
                    .tutor-course-topics-contents .tutor-course-title h4 i,
                    .header-cat-menu ul li a:hover,
                    .docent-post .content-item-title a:hover, .docent-post .content-item-title a:hover, 
                    .blog-post-review-next p.next,
                    .blog-post-review-pre:hover i,
                    #bottom-wrap .docent-social-share a:hover,
                    .bottom-widget .mc4wp-form-fields button,
                    .article-details h3.article-title a:hover,
                    .rticle-introtext a.blog-btn-wrap,
                    .section-content-second .article-details h3.article-title a:hover,
                    .blog-post-review-next:hover i,
                    .bottom-widget .docent-mailchimp i.fa.fa-long-arrow-right,
                    .docent-custom-link-widget li a i,
                    .blog-navigation ul li.active a, 
                    .blog-navigation ul li a:hover,
                    .blog-content-wrapper span.post-category a, 
                    .blog-content-wrapper span.post-category,
                    .blog-content-wrapper .thm-profile-content i,
                    #footer-wrap a:hover,
                    .docent-pagination .page-numbers li a:hover,
                    .docent-pagination .page-numbers li span.current,
                    .docent-pagination .page-numbers li a.next.page-numbers:hover, 
                    .docent-pagination .page-numbers li a.prev:hover,
                    .docent-pagination span.fa-angle-left, 
                    .docent-pagination .next.page-numbers i.fa.fa-angle-right, 
                    .docent-pagination .page-numbers i.fa.fa-angle-left,
                    .tutor-courses-grid-price .price,
                    .docent-post.hentry .blog-post-meta, 
                    .docent-post.hentry .blog-post-meta li a, 
                    .blog-post-meta li span,
                    #sidebar .widget_categories ul li a:hover,
                    .page-numbers li span:hover, 
                    .page-numbers li a.page-numbers:hover,
                    .docent-pagination .page-numbers li a.page-numbers:hover,
                    .btn.btn-border-docent,
                    .docent-widgets a:hover,
                    #mobile-menu ul li a:hover,
                    #mobile-menu ul li.active>a,
                    .page-numbers li span:hover, 
                    .social-share-wrap ul li a:hover,
                    .docent-post .blog-post-meta li i,
                    .docent-post .blog-post-meta li a,
                    .bottom-widget .widget ul li a:hover,
                    .page-numbers li a.page-numbers:hover, 
                    .main-menu-wrap .navbar-toggle:hover,
                    .docent-pagination .page-numbers li a,
                    .docent-post .blog-post-meta li a:hover,
                    .docent-post .content-item-title a:hover,
                    .docent-post .content-item-title a:hover,
                    .bottom-widget .mc4wp-form-fields button,
                    #sidebar .widget_categories ul li a:hover, 
                    .article-details h3.article-title a:hover,  
                    #bottom-wrap .docent-social-share a:hover, 
                    .docent-pagination .page-numbers li a:hover,  
                    .docent-pagination .page-numbers li span.current, 
                    .entry-summary .wrap-btn-style a.btn-style:hover,
                    .widget-blog-posts-section .entry-title  a:hover,
                    .entry-header h2.entry-title.blog-entry-title a:hover, 
                    .header-solid .common-menu-wrap .nav>li.active>a:after,
                    .section-content-second .article-details h3.article-title a:hover, 
                    .docent-pagination .page-numbers li a.next.page-numbers:hover, .docent-pagination .page-numbers li a.prev:hover,
                    .tutor-course-wishlist-btn.has-wish-listed, 
                    .tutor-course-grid-content ins span.woocommerce-Price-amount.amount, 
                    .tutor-courses-grid-price ins span, 
                    .postblock-intro .postblock-date, 
                    .docent-pagination .page-numbers li a.page-numbers:hover, 
                    .tutor-courses-grid-title a:hover, 
                    .tutor-course-benefits-content .tutor-custom-list-style li:before, 
                    .tutor-course-grid-enroll .btn-no-fill:hover, 
                    .tutor-topics-in-single-lesson .tutor-topics-title h3, 
                    .tutor-tabs-btn-group a, 
                    .tutor-tabs-btn-group a i, 
                    .docent-arrow.slick-arrow:hover, 
                    .tutor-next-previous-pagination-wrap a, 
                    ul.wp-block-archives li a, .wp-block-categories li a, .wp-block-latest-posts li a { color: '. esc_attr($major_color) .'; }';
                }

                // CSS Background Color
                if ($major_color) {
                    $docent_pro_output .= '
                    .info-wrapper a.white, 
                    #sidebar h3.widget_title:before, 
                    .single_add_to_cart_button, 
                    .tutor-course-enrolled-review-wrap .write-course-review-link-btn, 
                    .docent-course-cart-price .course-complete-button:hover, 
                    .tutor-progress-bar .tutor-progress-filled, 
                    .tutor-lesson-sidebar-hide-bar, 
                    .tutor-single-page-top-bar, 
                    .tutor-course-tags a:hover, 
                    .docent-custom-link-widget li:hover a, 
                    .tutor-course-grid-level, 
                    .tutor-course-overlay:after, 
                    .docent-login-remember input:checked + span,
                    .call-to-action a.btn:hover,
                    .docent-signin-popup-body button.register_button,
                    form#login .btn-fill,
                    .docent-error-wrapper a.btn.btn-secondary,
                    .call-to-action a.btn.btn2,
                    .blog-content-wrapper a.blog-button.btn.btn-success,
                    .wpmm_mobile_menu_btn,
                    #sidebar h3.widget_title:before,
                    .docent-widgets span.blog-cat:before,
                    .single_related:hover .overlay-content,
                    .order-view .label-info,
                    .footer-mailchamp .mc4wp-form-fields input[type=submit],
                    .error-log input[type=submit],
                    .widget .tagcloud a:hover,
                    .wpmm_mobile_menu_btn:hover,
                    .wpmm-gridcontrol-left:hover, 
                    .wpmm-gridcontrol-right:hover,
                    .form-submit input[type=submit],
                    .header-top .social-share ul li a:hover,
                    .single_related:hover .overlay-content,.page-numbers li .current:before, 
                    progress::-webkit-progress-value
                    { background: '. esc_attr($major_color) .'; }';
                } 

                // CSS Border
                if ($major_color) {
                    $docent_pro_output .= '
                    input:focus,
                    .docent-course-details, 
                    .docent-custom-link-widget li:hover a, 
                    form#login .btn-fill,
                    .footer-mailchamp .mc4wp-form-fields input[type="email"]:focus,
                    .tutor-course-archive-filters-wrap .nice-select:after,
                    keygen:focus,
                    .docent-signin-popup-body button.register_button,
                    .error-log input[type=submit],
                    .comments-area .comment-form input[type=text]:focus,
                    .comments-area textarea:focus,
                    .title-content-wrap .qubely-block-text-title code,
                    .blog-comments-section .form-submit .submit,
                    .error-log input[type=submit],
                    .footer-mailchamp .mc4wp-form-fields input[type=submit],
                    select:focus,
                    .wpcf7-submit,
                    .call-to-action a.btn,
                    textarea:focus,
                    .blog-arrows a:hover,
                    .btn.btn-border-docent,
                    .wpcf7-form input:focus,
                    .btn.btn-border-white:hover,
                    .wpmm-gridcontrol-left:hover, 
                    .wpmm-gridcontrol-right:hover,
                    .common-menu-wrap .nav>li.current>a,
                    .docent-latest-post-content .entry-title a:hover,
                    .header-solid .common-menu-wrap .nav>li.current>a,
                    .latest-review-single-layout2 .latest-post-title a:hover,
                    .info-wrapper a.white:hover, .bottom-widget .mc4wp-form input[type="email"]:focus
                    { border-color: '. esc_attr($major_color) .'; }';
                }

                // CSS Background Color & Border
                if ($major_color) {
                    $docent_pro_output .= '    
                    .wpcf7-submit:hover,
                    .post-meta-info-list-in a:hover,
                    .mc4wp-form-fields .send-arrow button,
                    .comingsoon .mc4wp-form-fields input[type=submit] {   
                        background-color: '. esc_attr($major_color) .'; border-color: '. esc_attr($major_color) .'; 
                    }';
                }

                // tutor lms root colors
                if ($major_color) {
                    $docent_pro_output .= ":root {
                        --tutor-color-primary: ". esc_attr( $major_color ) .";
                        --tutor-color-primary-hover: ". esc_attr( $major_color ) .";
                        --tutor-color-primary-rgb: ". esc_attr( docent_pro_hex2rgb( $major_color ) ) .";
                        --tutor-color-primary-hover-rgb: ". esc_attr( docent_pro_hex2rgb( $major_color ) ) .";
                    }";
                }

            }

            // Custom Color
            if( get_theme_mod( 'custom_preset_en', true ) ) {
                $hover_color = get_theme_mod( 'hover_color', '#1b52d8' );
                if( $hover_color ){
                    $docent_pro_output .= '
                    a:hover,
                    .footer-copyright a:hover,
                    .widget.widget_rss ul li a,
                    .entry-summary .wrap-btn-style a.btn-style:hover{ color: '.esc_attr( $hover_color ) .'; }';
                    
                    $docent_pro_output .= '.error-page-inner a.btn.btn-primary.btn-lg:hover,
                    input[type=button]:hover,
                    .blog-comments-section .form-submit .submit:hover, 
                    .widget.widget_search #searchform .btn-search:hover,
                     .order-view .label-info:hover
                     { background-color: '.esc_attr( $hover_color ) .'; }';

                    $docent_pro_output .= '.bottom-widget .mc4wp-form input[type="email"]:focus, 
                    .blog-comments-section .form-submit .submit:hover
                    { border-color: '.esc_attr( $hover_color ) .'; }';
                }
            }
        }

        $bstyle = $mstyle = $h1style = $h2style = $h3style = $h4style = $h5style = '';
        //body
        if ( get_theme_mod( 'body_font_size', '14' ) ) { $bstyle .= 'font-size:'.get_theme_mod( 'body_font_size', '14' ).'px;'; }
        if ( get_theme_mod( 'body_google_font', 'Taviraj' ) ) { $bstyle .= 'font-family:'.get_theme_mod( 'body_google_font', 'Taviraj' ).';'; }
        if ( get_theme_mod( 'body_font_weight', '400' ) ) { $bstyle .= 'font-weight: '.get_theme_mod( 'body_font_weight', '400' ).';'; }
        if ( get_theme_mod('body_font_height', '27') ) { $bstyle .= 'line-height: '.get_theme_mod('body_font_height', '27').'px;'; }
        if ( get_theme_mod('body_font_color', '#535967') ) { $bstyle .= 'color: '.get_theme_mod('', '#535967').';'; }
        
        //menu
        $mstyle = '';
        if ( get_theme_mod( 'menu_font_size', '14' ) ) { $mstyle .= 'font-size:'.get_theme_mod( 'menu_font_size', '14' ).'px;'; }
        if ( get_theme_mod( 'menu_google_font', 'Montserrat' ) ) { $mstyle .= 'font-family:'.get_theme_mod( 'menu_google_font', 'Montserrat' ).';'; }
        if ( get_theme_mod( 'menu_font_weight', '700' ) ) { $mstyle .= 'font-weight: '.get_theme_mod( 'menu_font_weight', '700' ).';'; }
        if ( get_theme_mod('menu_font_height', '54') ) { $mstyle .= 'line-height: '.get_theme_mod('menu_font_height', '54').'px;'; }
        if ( get_theme_mod('menu_font_color', '#1f2949') ) { $mstyle .= 'color: '.get_theme_mod('menu_font_color', '#1f2949').';'; }

        //heading1
        $h1style = '';
        if ( get_theme_mod( 'h1_font_size', '46' ) ) { $h1style .= 'font-size:'.get_theme_mod( 'h1_font_size', '46' ).'px;'; }
        if ( get_theme_mod( 'h1_google_font', 'Montserrat' ) ) { $h1style .= 'font-family:'.get_theme_mod( 'h1_google_font', 'Montserrat' ).';'; }
        if ( get_theme_mod( 'h1_font_weight', '700' ) ) { $h1style .= 'font-weight: '.get_theme_mod( 'h1_font_weight', '700' ).';'; }
        if ( get_theme_mod('h1_font_height', '42') ) { $h1style .= 'line-height: '.get_theme_mod('h1_font_height', '42').'px;'; }
        if ( get_theme_mod('h1_font_color', '#1f2949') ) { $h1style .= 'color: '.get_theme_mod('h1_font_color', '#1f2949').';'; }
        
        # heading2
        $h2style = '';
        if ( get_theme_mod( 'h2_font_size', '30' ) ) { $h2style .= 'font-size:'.get_theme_mod( 'h2_font_size', '30' ).'px;'; }
        if ( get_theme_mod( 'h2_google_font', 'Montserrat' ) ) { $h2style .= 'font-family:'.get_theme_mod( 'h2_google_font', 'Montserrat' ).';'; }
        if ( get_theme_mod( 'h2_font_weight', '600' ) ) { $h2style .= 'font-weight: '.get_theme_mod( 'h2_font_weight', '600' ).';'; }
        if ( get_theme_mod('h2_font_height', '36') ) { $h2style .= 'line-height: '.get_theme_mod('h2_font_height', '36').'px;'; }
        if ( get_theme_mod('h2_font_color', '#1f2949') ) { $h2style .= 'color: '.get_theme_mod('h2_font_color', '#1f2949').';'; }
        
        //heading3
        $h3style = '';
        if ( get_theme_mod( 'h3_font_size', '24' ) ) { $h3style .= 'font-size:'.get_theme_mod( 'h3_font_size', '24' ).'px;'; }
        if ( get_theme_mod( 'h3_google_font', 'Montserrat' ) ) { $h3style .= 'font-family:'.get_theme_mod( 'h3_google_font', 'Montserrat' ).';'; }
        if ( get_theme_mod( 'h3_font_weight', '400' ) ) { $h3style .= 'font-weight: '.get_theme_mod( 'h3_font_weight', '400' ).';'; }
        if ( get_theme_mod('h3_font_height', '28') ) { $h3style .= 'line-height: '.get_theme_mod('h3_font_height', '28').'px;'; }
        if ( get_theme_mod('h3_font_color', '#1f2949') ) { $h3style .= 'color: '.get_theme_mod('h3_font_color', '#1f2949').';'; }
        
        //heading4
        $h4style = '';
        if ( get_theme_mod( 'h4_font_size', '18' ) ) { $h4style .= 'font-size:'.get_theme_mod( 'h4_font_size', '18' ).'px;'; }
        if ( get_theme_mod( 'h4_google_font', 'Montserrat' ) ) { $h4style .= 'font-family:'.get_theme_mod( 'h4_google_font', 'Montserrat' ).';'; }
        if ( get_theme_mod( 'h4_font_weight', '600' ) ) { $h4style .= 'font-weight: '.get_theme_mod( 'h4_font_weight', '600' ).';'; }
        if ( get_theme_mod('h4_font_height', '26') ) { $h4style .= 'line-height: '.get_theme_mod('h4_font_height', '26').'px;'; }
        if ( get_theme_mod('h4_font_color', '#1f2949') ) { $h4style .= 'color: '.get_theme_mod('h4_font_color', '#1f2949').';'; }
        
        //heading5
        $h5style = '';
        if ( get_theme_mod( 'h5_font_size', '14' ) ) { $h5style .= 'font-size:'.get_theme_mod( 'h5_font_size', '14' ).'px;'; }
        if ( get_theme_mod( 'h5_google_font', 'Montserrat' ) ) { $h5style .= 'font-family:'.get_theme_mod( 'h5_google_font', 'Montserrat' ).';'; }
        if ( get_theme_mod( 'h5_font_weight', '600' ) ) { $h5style .= 'font-weight: '.get_theme_mod( 'h5_font_weight', '600' ).';'; }
        if ( get_theme_mod('h5_font_height', '26') ) { $h5style .= 'line-height: '.get_theme_mod('h5_font_height', '26').'px;'; }
        if ( get_theme_mod('h5_font_color', '#1f2949') ) { $h5style .= 'color: '.get_theme_mod('h5_font_color', '#1f2949').';'; }
        

        $docent_pro_output .= 'body {'.$bstyle.'}';
        $docent_pro_output .= '.common-menu-wrap .nav>li>a {'.$mstyle.'}';
        $docent_pro_output .= 'h1 {'.$h1style.'}';
        $docent_pro_output .= 'h2 {'.$h2style.'}';
        $docent_pro_output .= 'h3 {'.$h3style.'}';
        $docent_pro_output .= 'h4 {'.$h4style.'}';
        $docent_pro_output .= 'h5 {'.$h5style.'}';

        $docent_pro_output .= '.single_add_to_cart_button, .course-complete-button, .docent-single-container .woocommerce-message .wc-forward, .tutor-course-enrolled-review-wrap .write-course-review-link-btn, .header-cat-menu ul li a, .header_profile_menu ul li a, .blog-date-wrapper time, .docent-pagination .page-numbers li a, .footer-mailchamp, #footer-wrap,.common-menu-wrap .nav>li>ul li a {font-family:'.get_theme_mod( 'menu_google_font', 'Montserrat' ).'}';

        //Header
        $header_bgc = get_post_meta( get_the_ID() , 'docent_header_color', true );

        if($header_bgc){
            $docent_pro_output .= '#wp-megamenu-primary>.wpmm-nav-wrap ul.wp-megamenu>li>a{ color: '. $header_bgc .'; }';
        }


        $docent_pro_headerlayout = get_theme_mod( 'head_style', 'white' );

        $docent_pro_output .= '.site-header{ margin-bottom: '. (int) esc_attr( get_theme_mod( 'header_margin_bottom', '0' ) ) .'px; }';

        //sticky Header
        if ( get_theme_mod( 'header_fixed', false ) ){
            $docent_pro_output .= '.site-header.sticky.header-transparent .main-menu-wrap{ margin-top: 0;}';
            if ( get_theme_mod( 'sticky_header_color', '#768d94' ) ){
                $sticybg = get_theme_mod( 'sticky_header_color', '#768d94');
                $docent_pro_output .= '.site-header.sticky{ background-color: '.esc_attr($sticybg).';}';
            }
        }

        //logo
        $docent_pro_output .= '.docent-navbar-header .docent-navbar-brand img{width:'.esc_attr(get_theme_mod( 'logo_width', 90)).'px; max-width:none;}';
        if (get_theme_mod( 'logo_height' )) {
            $docent_pro_output .= '.docent-navbar-header .docent-navbar-brand img{height:'.esc_attr(get_theme_mod( 'logo_height' )).'px;}';
        }

        // sub header
        $docent_pro_output .= '.subtitle-cover h2{font-size:'.esc_attr(get_theme_mod( 'sub_header_title_size', '34' )).'px;color:'.esc_attr(get_theme_mod( 'sub_header_title_color', '#1b52d8' )).';}';
        $docent_pro_output .= '.breadcrumb>li+li:before, .subtitle-cover .breadcrumb, .subtitle-cover .breadcrumb>.active{color:'.esc_attr(get_theme_mod( 'breadcrumb_text_color', '#000' )).';}';

        $docent_pro_output .= '
        .site-header .primary-menu{
            padding:'.esc_attr(get_theme_mod( 'header_padding_top', '13' )).'px 0 '.esc_attr(get_theme_mod( 'header_padding_bottom', '13' )).'px; 
        }';

        $docent_pro_output .= '
        .subtitle-cover{
            padding:'.esc_attr(get_theme_mod( 'sub_header_padding_top', '80' )).'px 0 '.esc_attr(get_theme_mod( 'sub_header_padding_bottom', '70' )).'px; 
        }';

        //body
        if (get_theme_mod( 'body_bg_img')) {
            $docent_pro_output .= 'body{ background-image: url("'.esc_attr( get_theme_mod( 'body_bg_img' ) ) .'");background-size: '.esc_attr( get_theme_mod( 'body_bg_size', 'cover' ) ) .';    background-position: '.esc_attr( get_theme_mod( 'body_bg_position', 'left top' ) ) .';background-repeat: '.esc_attr( get_theme_mod( 'body_bg_repeat', 'no-repeat' ) ) .';background-attachment: '.esc_attr( get_theme_mod( 'body_bg_attachment', 'fixed' ) ) .'; }';
        }
        $docent_pro_output .= 'body{ background-color: '.esc_attr( get_theme_mod( 'body_bg_color', '#fff' ) ) .'; }';

        // Button color setting...
        $docent_pro_output .= 'input[type=submit],
                    .btn.btn-border-docent:hover,.btn.btn-border-white:hover{ background-color: '.esc_attr( get_theme_mod( 'button_bg_color', '#1b52d8' ) ) .'; border-color: '.esc_attr( get_theme_mod( 'button_bg_color', '#1b52d8' ) ) .'; color: '.esc_attr( get_theme_mod( 'button_text_color', '#fff' ) ) .' !important; border-radius: '.esc_attr(get_theme_mod( 'button_radius', 4 )).'px; }';
        $docent_pro_output .= '.docent-login-register a.docent-dashboard, .docent-widgets span.blog-cat:before{ background-color: '.esc_attr( get_theme_mod( 'button_bg_color', '#1b52d8' ) ) .'; }';

        // Background hover color
        if ( get_theme_mod( 'button_hover_bg_color', '#1b52d8' ) ) {
            $docent_pro_output .= 'input[type=submit]:hover{ background-color: '.esc_attr( get_theme_mod( 'button_hover_bg_color', '#1b52d8' ) ) .'; border-color: '.esc_attr( get_theme_mod( 'button_hover_bg_color', '#1b52d8' ) ) .'; color: '.esc_attr( get_theme_mod( 'button_hover_text_color', '#fff' ) ) .' !important; }';

            $docent_pro_output .= '.docent-login-register a.docent-dashboard:hover{ background-color: '.esc_attr( get_theme_mod( 'button_hover_bg_color', '#1b52d8' ) ) .'; }';
        }

        //menu color
        if ( get_theme_mod( 'navbar_text_color', '#1f2949' ) ) {
            $docent_pro_output .= '.primary-menu .common-menu-wrap .nav>li>a,  
            .header-cat-menu div a, 
            .docent-search{ color: '.esc_attr( get_theme_mod( 'navbar_text_color', '#1f2949' ) ) .'; }';
        }

        $docent_pro_output .= '.primary-menu .common-menu-wrap .nav>li>a:hover,  
        .docent-search-wrap a.docent-search:hover, 
        .header-common-menu a.docent-search.search-open-icon:hover, 
        .common-menu .docent-search.search-close-icon:hover{ color: '.esc_attr( get_theme_mod( 'navbar_hover_text_color', '#1b52d8' ) ) .'; }';





        $docent_pro_output .= '.common-menu-wrap .nav>li.current-menu-item > a, 
        .common-menu-wrap .sub-menu > li.current-menu-item > a, 
        .common-menu-wrap .nav>li.current-menu-parent > a{ color: '.esc_attr( get_theme_mod( 'navbar_active_text_color', '#1b52d8' ) ) .'; }';

        //submenu color
        $docent_pro_output .= '.common-menu-wrap .nav>li ul, .header-cat-menu ul{ background-color: '.esc_attr( get_theme_mod( 'sub_menu_bg', '#f8f8f8' ) ) .'; }';

        $docent_pro_output .= '.common-menu-wrap .nav>li>ul li a, 
        .header-cat-menu ul li a, 
        .common-menu-wrap .nav > li > ul li.mega-child > a, .header_profile_menu ul li a{ color: '.esc_attr( get_theme_mod( 'sub_menu_text_color', '#535967' ) ) .'; border-color: '.esc_attr( get_theme_mod( 'sub_menu_border', '#eef0f2' ) ) .'; }';

        $docent_pro_output .= '.common-menu-wrap .nav>li>ul li a:hover, 
        .common-menu-wrap .nav>li>ul li a:hover, .header_profile_menu ul li a:hover,
        .common-menu-wrap .sub-menu li.active.mega-child a:hover{ color: '.esc_attr( get_theme_mod( 'sub_menu_text_color_hover', '#1b52d8' ) ) .';}';

        $docent_pro_output .= '.common-menu-wrap .nav>li > ul::after{ border-color: transparent transparent '.esc_attr( get_theme_mod( 'sub_menu_bg', '#f8f8f8' ) ) .' transparent; }';



        # Mailchamp 
        $docent_pro_output .= '.footer-mailchamp{ background-color: '.esc_attr( get_theme_mod( 'mc_bg_color', '#fbfbfc' ) ) .'; }';
        $docent_pro_output .= '.footer-mailchamp .newslatter{ padding-top: '. (int) esc_attr( get_theme_mod( 'mc_padding_top', '70' ) ) .'px; }';
        $docent_pro_output .= '.footer-mailchamp .newslatter{ padding-bottom: '. (int) esc_attr( get_theme_mod( 'mc_padding_bottom', '0' ) ) .'px; }';

        //bottom
        $docent_pro_output .= '#bottom-wrap{ background-color: '.esc_attr( get_theme_mod( 'bottom_color', '#fbfbfc' ) ) .'; }';
        $docent_pro_output .= '#bottom-wrap,.bottom-widget .widget h3.widget-title{ color: '.esc_attr( get_theme_mod( 'bottom_title_color', '#fff' ) ) .'; }';
        $docent_pro_output .= '#bottom-wrap a, #menu-footer-menu li a{ color: '.esc_attr( get_theme_mod( 'bottom_link_color', '#a8a9c4' ) ) .'; }';
        $docent_pro_output .= '#bottom-wrap .docent-widgets .latest-widget-date, #bottom-wrap .bottom-widget ul li, div.about-desc, .bottom-widget .textwidget p{ color: '.esc_attr( get_theme_mod( 'bottom_text_color', '#a8a9c4' ) ) .'; }';
        $docent_pro_output .= '#bottom-wrap a:hover{ color: '.esc_attr( get_theme_mod( 'bottom_hover_color', '#fff' ) ) .'; }';
        $docent_pro_output .= '#bottom-wrap{ padding-top: '. (int) esc_attr( get_theme_mod( 'bottom_padding_top', '60' ) ) .'px; }';
        $docent_pro_output .= '#bottom-wrap{ padding-bottom: '. (int) esc_attr( get_theme_mod( 'bottom_padding_bottom', '0' ) ) .'px; }';


        //footer
        $docent_pro_output .= '.menu-footer-menu a{ color: '.esc_attr( get_theme_mod( 'copyright_link_color', '#fff' ) ) .'; }';
        $docent_pro_output .= '#footer-wrap{ background-color: '.esc_attr( get_theme_mod( 'copyright_bg_color', '#fbfbfc' ) ) .'; }';
        $docent_pro_output .= '#footer-wrap{ padding-top: '. (int) esc_attr( get_theme_mod( 'copyright_padding_top', '30' ) ) .'px; }';
        $docent_pro_output .= '.menu-footer-menu a:hover{ color: '.esc_attr( get_theme_mod( 'copyright_hover_color', '#1b52d8' ) ) .'; }';
        $docent_pro_output .= '#footer-wrap{ padding-bottom: '. (int) esc_attr( get_theme_mod( 'copyright_padding_bottom', '20' ) ) .'px; }';
        $docent_pro_output .= '#footer-wrap a, #footer-wrap .text-right { color: '.esc_attr( get_theme_mod( 'copyright_text_color', '#fff' ) ) .'; }';


        # 404 page.
        $docent_pro_output .= ".docent-error{
            width: 100%;
            height: 100%;
            min-height: 100%;
            background-color: #fff;
            background-size: cover;
        }";

        $coming_soon_bg = get_theme_mod('coming_soon_bg', get_template_directory_uri().'/images/coming-soon-bg.svg');

        # 404 page.
        $docent_pro_output .= ".coming-soon-main-wrap{
            width: 100%;
            height: 100%;
            min-height: 100%;
            background-image: url(".esc_url($coming_soon_bg).");
            background-size: cover;
            background-repeat: no-repeat;
            background-color: #202D56;
        }";

        return $docent_pro_output;
    }
}

/* -------------------------------------------- *
 * CSS Generator Backend
 * -------------------------------------------- */
if(!function_exists('docent_css_backend_generator')){
    function docent_css_backend_generator(){
        $docent_pro_backend_output = '';

        $bstyle = $mstyle = $h1style = $h2style = $h3style = $h4style = $h5style = '';
        //body
        if ( get_theme_mod( 'body_font_size', '14' ) ) { $bstyle .= 'font-size:'.get_theme_mod( 'body_font_size', '14' ).'px;'; }
        if ( get_theme_mod( 'body_google_font', 'Taviraj' ) ) { $bstyle .= 'font-family:'.get_theme_mod( 'body_google_font', 'Taviraj' ).';'; }
        if ( get_theme_mod( 'body_font_weight', '400' ) ) { $bstyle .= 'font-weight: '.get_theme_mod( 'body_font_weight', '400' ).';'; }
        if ( get_theme_mod('body_font_height', '27') ) { $bstyle .= 'line-height: '.get_theme_mod('body_font_height', '27').'px;'; }
        if ( get_theme_mod('body_font_color', '#535967') ) { $bstyle .= 'color: '.get_theme_mod('', '#535967').';'; }
        
        //heading1
        $h1style = '';
        if ( get_theme_mod( 'h1_font_size', '46' ) ) { $h1style .= 'font-size:'.get_theme_mod( 'h1_font_size', '46' ).'px;'; }
        if ( get_theme_mod( 'h1_google_font', 'Montserrat' ) ) { $h1style .= 'font-family:'.get_theme_mod( 'h1_google_font', 'Montserrat' ).';'; }
        if ( get_theme_mod( 'h1_font_weight', '700' ) ) { $h1style .= 'font-weight: '.get_theme_mod( 'h1_font_weight', '700' ).';'; }
        if ( get_theme_mod('h1_font_height', '42') ) { $h1style .= 'line-height: '.get_theme_mod('h1_font_height', '42').'px;'; }
        if ( get_theme_mod('h1_font_color', '#1f2949') ) { $h1style .= 'color: '.get_theme_mod('h1_font_color', '#1f2949').';'; }
        
        # heading2
        $h2style = '';
        if ( get_theme_mod( 'h2_font_size', '30' ) ) { $h2style .= 'font-size:'.get_theme_mod( 'h2_font_size', '30' ).'px;'; }
        if ( get_theme_mod( 'h2_google_font', 'Montserrat' ) ) { $h2style .= 'font-family:'.get_theme_mod( 'h2_google_font', 'Montserrat' ).';'; }
        if ( get_theme_mod( 'h2_font_weight', '600' ) ) { $h2style .= 'font-weight: '.get_theme_mod( 'h2_font_weight', '600' ).';'; }
        if ( get_theme_mod('h2_font_height', '36') ) { $h2style .= 'line-height: '.get_theme_mod('h2_font_height', '36').'px;'; }
        if ( get_theme_mod('h2_font_color', '#1f2949') ) { $h2style .= 'color: '.get_theme_mod('h2_font_color', '#1f2949').';'; }
        
        //heading3
        $h3style = '';
        if ( get_theme_mod( 'h3_font_size', '24' ) ) { $h3style .= 'font-size:'.get_theme_mod( 'h3_font_size', '24' ).'px;'; }
        if ( get_theme_mod( 'h3_google_font', 'Montserrat' ) ) { $h3style .= 'font-family:'.get_theme_mod( 'h3_google_font', 'Montserrat' ).';'; }
        if ( get_theme_mod( 'h3_font_weight', '400' ) ) { $h3style .= 'font-weight: '.get_theme_mod( 'h3_font_weight', '400' ).';'; }
        if ( get_theme_mod('h3_font_height', '28') ) { $h3style .= 'line-height: '.get_theme_mod('h3_font_height', '28').'px;'; }
        if ( get_theme_mod('h3_font_color', '#1f2949') ) { $h3style .= 'color: '.get_theme_mod('h3_font_color', '#1f2949').';'; }
        
        //heading4
        $h4style = '';
        if ( get_theme_mod( 'h4_font_size', '18' ) ) { $h4style .= 'font-size:'.get_theme_mod( 'h4_font_size', '18' ).'px;'; }
        if ( get_theme_mod( 'h4_google_font', 'Montserrat' ) ) { $h4style .= 'font-family:'.get_theme_mod( 'h4_google_font', 'Montserrat' ).';'; }
        if ( get_theme_mod( 'h4_font_weight', '600' ) ) { $h4style .= 'font-weight: '.get_theme_mod( 'h4_font_weight', '600' ).';'; }
        if ( get_theme_mod('h4_font_height', '26') ) { $h4style .= 'line-height: '.get_theme_mod('h4_font_height', '26').'px;'; }
        if ( get_theme_mod('h4_font_color', '#1f2949') ) { $h4style .= 'color: '.get_theme_mod('h4_font_color', '#1f2949').';'; }
        
        //heading5
        $h5style = '';
        if ( get_theme_mod( 'h5_font_size', '14' ) ) { $h5style .= 'font-size:'.get_theme_mod( 'h5_font_size', '14' ).'px;'; }
        if ( get_theme_mod( 'h5_google_font', 'Montserrat' ) ) { $h5style .= 'font-family:'.get_theme_mod( 'h5_google_font', 'Montserrat' ).';'; }
        if ( get_theme_mod( 'h5_font_weight', '600' ) ) { $h5style .= 'font-weight: '.get_theme_mod( 'h5_font_weight', '600' ).';'; }
        if ( get_theme_mod('h5_font_height', '26') ) { $h5style .= 'line-height: '.get_theme_mod('h5_font_height', '26').'px;'; }
        if ( get_theme_mod('h5_font_color', '#1f2949') ) { $h5style .= 'color: '.get_theme_mod('h5_font_color', '#1f2949').';'; }
        

        $docent_pro_backend_output .= '.editor-block-list__block, .editor-post-title__block .editor-post-title__input{'.$bstyle.'}';
        $docent_pro_backend_output .= '.edit-post-visual-editor .editor-block-list__block h1{'.$h1style.'}';
        $docent_pro_backend_output .= '.edit-post-visual-editor .editor-block-list__block h2{'.$h2style.'}';
        $docent_pro_backend_output .= '.edit-post-visual-editor .editor-block-list__block h3{'.$h3style.'}';
        $docent_pro_backend_output .= '.edit-post-visual-editor .editor-block-list__block h4{'.$h4style.'}';
        $docent_pro_backend_output .= '.edit-post-visual-editor .editor-block-list__block h5{'.$h5style.'}';

        return $docent_pro_backend_output;
    }
}
