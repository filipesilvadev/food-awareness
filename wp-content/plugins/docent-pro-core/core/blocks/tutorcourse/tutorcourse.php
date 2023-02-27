<?php
defined( 'ABSPATH' ) || exit;

if (! class_exists('Docent_Pro_Core_Tutor_Course')) {
    class Docent_Pro_Core_Tutor_Course{
        protected static $_instance = null;
        public static function instance(){
            if(is_null(self::$_instance)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }
        public function __construct(){
			register_block_type(
                'docent-pro-core/docent-pro-core-tutor-course',
                array(
                    'attributes' => array(
                        //common settings
                        'postTypes' => array(
                            'type' => 'string',
                            'default' => 'courses'
                        ),
                        'selectedCategory' => array (
                            'type' => 'string',
                            'default' => 'All',
                        ),

                        'uniqueId' => array (
                            'type' => 'string',
                        ),
                        'orderBy' => array(
                            'type' => 'string'
                        ),
                        'order' => array(
                            'type' => 'string'
                        ),
                        'disFilter' => array(
                            'type' => 'boolean',
                            'default' => true
                        ),
                        'numbers' => array(
                            'type' => 'number',
                            'default' => 6,
                        ),
                        'columns' => array(
                            'type' => 'string',
                            'default' => '3',
                        ),
                    ),
                    'render_callback' => array( $this, 'Docent_Pro_Core_Tutor_Course_block_callback' ),
                )
            );
        }
    
		public function Docent_Pro_Core_Tutor_Course_block_callback( $att ){
			$columns 		= isset( $att['columns'] ) ? $att['columns'] : '3';
			$order 		    = isset( $att['order'] ) ? $att['order'] : 'desc';
			$orderBy 		= isset( $att['orderBy'] ) ? $att['orderBy'] : 'title';
			$numbers 		= isset( $att['numbers'] ) ? $att['numbers'] : 6;
            $category 		= isset( $att['selectedCategory'] ) ? $att['selectedCategory'] : ['All'];
            $html = '';
            $args = array(
                'post_type' 		=> 'courses',
                'post_status' 		=> 'publish',
                'posts_per_page'    => $numbers,
                'order' 			=> esc_attr($order),
                'orderby' 			=> esc_attr($orderBy),
            ); 
            if( $category != 'All' ){
                $args['tax_query'] =  array(
                    array(
                        'taxonomy' 	=> 'course-category',
                        'field' 	=> 'term_id',
                        'terms'    	=> $category,
                    ),
                );
            }

            $counts = 0;
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) {
                $html .= '<div class="thm-grid-items-'.$columns.' thm-grid-items">';
                while ( $query->have_posts() ) {
                    $query->the_post();
                    $idd = get_the_ID();
                    $id = get_post_thumbnail_id();
                    $src = wp_get_attachment_image_src($id, 'docent-proportfo');

                    $is_wishlisted = tutor_utils()->is_wishlisted($idd);
                    $has_wish_list = '';
                    if ($is_wishlisted){
                        $has_wish_list = 'has-wish-listed';
                    }

                    $html .= '<div class="tutor-course-grid-item">'; 
                        $html .= '<div class="tutor-course-grid-content">';
                            $html .= '<div class="tutor-course-overlay">';   
                                if($src[0]){
                                    $html .= '<img src="' . $src[0] . '" class="img-responsive" />';  
                                }
                                $html .= '<div class="tutor-course-grid-level-wishlist">';
                                    $html .= '<span class="tutor-course-grid-level">'.get_tutor_course_level().'</span>';
                                    $html .= '<span class="tutor-course-grid-wishlist tutor-course-wishlist">';
                                        $html .= '<a href="javascript:;" class="tutor-icon-fav-line tutor-course-wishlist-btn '.$has_wish_list.' " data-course-id="'.$idd.'"></a>';
                                    $html .= '</span>';
                                $html .= '</div>';//tutor-course-grid-level-wishlis
                                $html .= '<div class="tutor-course-grid-enroll"><a href="'.esc_url(get_the_permalink()).'" class="btn btn-classic btn-no-fill">'.__('View Details','docent-pro-core').'</a></div>';
                            $html .= '</div>';//tutor-course-overlay
                            $html .= '<h3 class="tutor-courses-grid-title"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>';
                            $html .= '<div class="tutor-courses-grid-price">';
                                ob_start();
                                //$output .= tutor_course_loop_add_to_cart(false);
                                $html .= tutor_course_price();
                                //$output .= tutor_course_price(false);
                                $html .= ob_get_clean();
                            $html .= '</div>';
                        $html .= '</div>';//tutor-course-grid-content
                    $html .= '</div>';//tutor-course-grid-item
                }
                $html .= '</div>';//thm-grid-items
            }
            wp_reset_postdata();
			return $html;
		}
    }
}
Docent_Pro_Core_Tutor_Course::instance();


