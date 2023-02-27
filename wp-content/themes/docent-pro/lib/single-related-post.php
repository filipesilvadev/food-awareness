<?php 
    global $post;
    $cat_list = [];
    $cat_items = wp_get_post_terms(get_the_ID(), 'course-category', array("fields" => "all"));
    foreach ( $cat_items as $cat_item ) {           
        $cat_list[] = $cat_item->term_id;
    } 
    $tag_list = [];
    $tag_items = wp_get_post_terms(get_the_ID(), 'course-tag', array("fields" => "all"));
    foreach ( $tag_items as $tag_item ) {
        $tag_list[] = $tag_item->term_id;
    } 
    $course_args = array(
        'post_type' 		=> 'courses',
        'post_status' 		=> 'publish',
        'post__not_in' => array($post->ID),
    ); 
    $course_args['posts_per_page'] = 20;
    $course_args['tax_query'] = array (
        'relation' => 'OR',
        array(
            'taxonomy' => 'course-category',
            'field' => 'term_id',
            'terms' => $cat_list,
        ),
        array(
            'taxonomy' => 'course-tag',
            'field' => 'term_id',
            'terms' => $tag_list,
        )
    );
    $related_posts = get_posts($course_args);
    
    $docent_pro_html = '';
    $docent_pro_html .= '<div class="docent-related-course">';
        $docent_pro_html .= '<h3 class="course-related-title text-center">'.__('Similar Courses','docent-pro').'</h3>';
        $docent_pro_html .= '<div class="docent-related-course-items">';
            foreach ($related_posts as $related_post){ 
                setup_postdata($related_post);
                $src = wp_get_attachment_image_src(get_post_thumbnail_id($related_post->ID), 'docent-proportfo');

                $is_wishlisted = tutor_utils()->is_wishlisted($related_post->ID);
                $has_wish_list = '';
                if ($is_wishlisted){
                    $has_wish_list = 'has-wish-listed';
                }
                $docent_pro_html .= '<div class="tutor-course-grid-item">'; 
                    $docent_pro_html .= '<div class="tutor-course-grid-content">';
                        $docent_pro_html .= '<div class="tutor-course-overlay">';   
                            $docent_pro_html .= '<img src="' . esc_url($src[0]) . '" class="img-responsive" />';  
                            $docent_pro_html .= '<div class="tutor-course-grid-level-wishlist">';
                                $docent_pro_html .= '<span class="tutor-course-grid-level">'.get_tutor_course_level($related_post->ID).'</span>';
                                $docent_pro_html .= '<span class="tutor-course-grid-wishlist tutor-course-wishlist">';
                                    $docent_pro_html .= '<a href="javascript:;" class="tutor-icon-fav-line tutor-course-wishlist-btn '.esc_attr($has_wish_list).' " data-course-id="'.$related_post->ID.'"></a>';
                                $docent_pro_html .= '</span>';
                            $docent_pro_html .= '</div>';//tutor-course-grid-level-wishlis
                            $docent_pro_html .= '<div class="tutor-course-grid-enroll"><a href="'.esc_url(get_the_permalink($related_post->ID)).'" class="btn btn-classic btn-no-fill">'.__('View Details','docent-pro').'</a></div>';
                        $docent_pro_html .= '</div>';//tutor-course-overlay
                        $docent_pro_html .= '<h3 class="tutor-courses-grid-title"><a href="'.esc_url(get_the_permalink($related_post->ID)).'">'.get_the_title($related_post->ID).'</a></h3>';
                        $docent_pro_html .= '<div class="tutor-courses-grid-price">';
                            $price = apply_filters('get_tutor_course_price', null, $related_post->ID);
                            ob_start();
                                if($price == !null){
                                    $docent_pro_html .= $price;
                                }else{
                                    $docent_pro_html .= '<span class="woocommerce-Price-amount amount">Free</span>';
                                }
                            $docent_pro_html .= ob_get_clean();
                        $docent_pro_html .= '</div>';
                    $docent_pro_html .= '</div>';//tutor-course-grid-content
                $docent_pro_html .= '</div>';//tutor-course-grid-item
            }
        $docent_pro_html .= '</div>';//thm-grid-items
        wp_reset_query();
    $docent_pro_html .= '</div>';//thm-grid-items
    echo $docent_pro_html;
?>