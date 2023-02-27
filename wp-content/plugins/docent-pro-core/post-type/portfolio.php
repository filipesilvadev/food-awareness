<?php
function docent_pro_core_post_type_portfolio(){

    $labels = array(
            'name'                  => _x( 'Portfolio', 'Portfolio', 'docent-pro-core' ),
            'singular_name'         => _x( 'Portfolio', 'Portfolio', 'docent-pro-core' ),
            'menu_name'             => __( 'Portfolio', 'docent-pro-core' ),
            'parent_item_colon'     => __( 'Parent Portfolio:', 'docent-pro-core' ),
            'all_items'             => __( 'All Portfolio', 'docent-pro-core' ),
            'view_item'             => __( 'View Portfolio', 'docent-pro-core' ),
            'add_new_item'          => __( 'Add New Portfolio', 'docent-pro-core' ),
            'add_new'               => __( 'New Portfolio', 'docent-pro-core' ),
            'edit_item'             => __( 'Edit Portfolio', 'docent-pro-core' ),
            'update_item'           => __( 'Update Portfolio', 'docent-pro-core' ),
            'search_items'          => __( 'Search Portfolio', 'docent-pro-core' ),
            'not_found'             => __( 'No article found', 'docent-pro-core' ),
            'not_found_in_trash'    => __( 'No article found in Trash', 'docent-pro-core' )
        );

    $args = array(
            'labels'                => $labels,
            'public'                => true,
            'publicly_queryable'    => true,
            'show_in_menu'          => true,
            'show_in_admin_bar'     => true,
            'can_export'            => true,
            'has_archive'           => false,
            'hierarchical'          => false,
            'menu_icon'             => 'dashicons-format-gallery',
            'menu_position'         => null,
            'show_in_rest'          => true,
            'supports'              => array( 'title','editor','thumbnail','comments')
        );

    register_post_type('portfolio',$args);
}
add_action('init','docent_pro_core_post_type_portfolio');



/*--------------------------------------------------------------
 *          View Message When Updated portfolio
 *-------------------------------------------------------------*/
function docent_pro_core_update_message_portfolio(){
    global $post, $post_ID;

    $message['portfolio'] = array(
        0   => '',
        1   => sprintf( __('Portfolio updated. <a href="%s">View Portfolio</a>', 'docent-pro-core' ), esc_url( get_permalink($post_ID) ) ),
        2   => __('Custom field updated.', 'docent-pro-core' ),
        3   => __('Custom field deleted.', 'docent-pro-core' ),
        4   => __('Portfolio updated.', 'docent-pro-core' ),
        5   => isset($_GET['revision']) ? sprintf( __('Portfolio restored to revision from %s', 'docent-pro-core' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        6   => sprintf( __('Portfolio published. <a href="%s">View Portfolio</a>', 'docent-pro-core' ), esc_url( get_permalink($post_ID) ) ),
        7   => __('Portfolio saved.', 'docent-pro-core' ),
        8   => sprintf( __('Portfolio submitted. <a target="_blank" href="%s">Preview Portfolio</a>', 'docent-pro-core' ), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
        9   => sprintf( __('Portfolio scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Portfolio</a>', 'docent-pro-core' ), date_i18n( __( 'M j, Y @ G:i','docent-pro-core'), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
        10  => sprintf( __('Portfolio draft updated. <a target="_blank" href="%s">Preview Portfolio</a>', 'docent-pro-core' ), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
        );

return $message;
}
add_filter( 'post_updated_messages', 'docent_pro_core_update_message_portfolio' );



/*--------------------------------------------------------------
 *          Register Custom Taxonomies
 *-------------------------------------------------------------*/
function docent_pro_core_create_portfolio_taxonomy(){
    $labels = array(    'name'              => _x( 'Categories', 'taxonomy general name','docent-pro-core'),
                        'singular_name'     => _x( 'Category', 'taxonomy singular name','docent-pro-core' ),
                        'search_items'      => __( 'Search Category','docent-pro-core'),
                        'all_items'         => __( 'All Category','docent-pro-core'),
                        'parent_item'       => __( 'Parent Category','docent-pro-core'),
                        'parent_item_colon' => __( 'Parent Category:','docent-pro-core'),
                        'edit_item'         => __( 'Edit Category','docent-pro-core'),
                        'update_item'       => __( 'Update Category','docent-pro-core'),
                        'add_new_item'      => __( 'Add New Category','docent-pro-core'),
                        'new_item_name'     => __( 'New Category Name','docent-pro-core'),
                        'menu_name'         => __( 'Category','docent-pro-core')
        );
    $args = array(  'hierarchical'      => true,
                    'labels'            => $labels,
                    'show_ui'           => true,
                    'show_admin_column' => true,
                    'query_var'         => true,
                    'show_in_rest'          => true,
        );
    register_taxonomy('portfolio-cat',array( 'portfolio' ),$args);
}

add_action('init','docent_pro_core_create_portfolio_taxonomy');


/**
 * Register Portfolio Tag Taxonomies
 *
 * @return void
 */


function docent_pro_core_register_portfolio_tag_taxonomy(){
    $labels = array(
        'name'                  => _x( 'Portfolio Tags', 'taxonomy general name', 'docent-pro-core' ),
        'singular_name'         => _x( 'Portfolio Tag', 'taxonomy singular name', 'docent-pro-core' ),
        'search_items'          => __( 'Search Portfolio Tag', 'docent-pro-core' ),
        'all_items'             => __( 'All Portfolio Tag', 'docent-pro-core' ),
        'parent_item'           => __( 'Portfolio Parent Tag', 'docent-pro-core' ),
        'parent_item_colon'     => __( 'Portfolio Parent Tag:', 'docent-pro-core' ),
        'edit_item'             => __( 'Edit Portfolio Tag', 'docent-pro-core' ),
        'update_item'           => __( 'Update Portfolio Tag', 'docent-pro-core' ),
        'add_new_item'          => __( 'Add New Portfolio Tag', 'docent-pro-core' ),
        'new_item_name'         => __( 'New Portfolio Tag Name', 'docent-pro-core' ),
        'menu_name'             => __( 'Portfolio Tag', 'docent-pro-core' )
    );

    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_in_nav_menus'     => true,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
        'show_in_rest'          => true,
    );
    register_taxonomy( 'portfolio-tag', array( 'portfolio' ), $args );
}
add_action('init','docent_pro_core_register_portfolio_tag_taxonomy');