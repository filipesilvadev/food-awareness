<?php
defined( 'ABSPATH' ) || exit;

if (! class_exists('Docent_Pro_Core_Posts')) {

    class Docent_Pro_Core_Posts{
		
        protected static $_instance = null;
        public static function instance(){
            if(is_null(self::$_instance)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function __construct(){
			register_block_type(
                'docent-pro-core/docent-pro-core-posts',
                    array(
                        'attributes' => array(
                            //common settings
                            'uniqueId' => array (
                                'type' => 'string',
                            ),
                            'selectedCategory' => array (
                                'type' => 'string',
                                'default' => 'all',
                            ),
                            'orderby' => array(
                                'type' => 'string',
                                'default' => 'asc',
                            ),
                            'order' => array(
                                'type' => 'string'
                            ),
                            'blogStyle' => array(
                                'type' => 'string',
                                'default' => 'style1',
                            ),
                            'numbers' => array(
                                'type' => 'number',
                                'default' => 3,
                            ),
                            'columns' => array(
                                'type' => 'string',
                                'default' => 3,
                            ),
                        ),
                        'render_callback' => array( $this, 'docent_pro_core_post_block_callback' ),
                )
            );
        }
    
		public function docent_pro_core_post_block_callback( $att ){
			$columns 		= isset( $att['columns'] ) ? $att['columns'] : 3;
			$numbers 		= isset( $att['numbers'] ) ? $att['numbers'] : 3;
			$orderby 		= isset( $att['orderby'] ) ? $att['orderby'] : 'ASC';
			$selectedCategory = isset( $att['selectedCategory'] ) ? $att['selectedCategory'] : 'all';
			$args = array(
				'post_type' 		=> 'post',
				'posts_per_page' 	=> esc_attr($numbers),
				'order' 			=> esc_attr($orderby),
				'status' 			=> 'publish',
			);
		
			if( $selectedCategory != 'all' ){
				$args['tax_query'] =  array(
					array(
						'taxonomy' 	=> 'category',
						'field'    	=> 'id',
						'terms'    	=> esc_attr($selectedCategory),
					),
				);
			}
			$query = new WP_Query( $args );
			# The Loop. 
			$html = '';
			if ( $query->have_posts() ) {
                $html .= '<div class="thm-grid-items-'.$columns.' thm-grid-items">';
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        $id = get_post_thumbnail_id();
                        $src = wp_get_attachment_image_src($id, 'docent-blog');
                        $html .= '<div class="postblock-content-wrap">'; 
                            $html .= '<div class="postblock-content-img">';
                                $html .= '<a class="blog-permalink" href="'.get_the_permalink().'"></a>';
                                $html .= '<a href="'.esc_url(get_the_permalink()).'">';
                                    $html .= '<img src="' . $src[0] . '" class="img-responsive" />';
                                $html .= '</a>';
                            $html .= '</div>';
                            $html .= '<div class="postblock-intro">'; 
                                $the_date = get_the_date();
                                $html .= '<time class="postblock-date">'. date_i18n("d M, Y", strtotime($the_date)) .'</time>';
                                $html .= '<h3 class="postblock-title"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>';
                            $html .= '</div>';
                        $html .= '</div>';
                    }
				$html .= '</div>';
				wp_reset_postdata();
			} 
			return $html;
		}
    }
}
Docent_Pro_Core_Posts::instance();


