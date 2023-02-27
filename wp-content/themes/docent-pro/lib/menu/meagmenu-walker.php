<?php
/*
 * Front-end Megamenu Class
 */

class Megamenu_Walker extends Walker_Nav_menu{

	private $megamenuId;
	private $docent_columnId;

	function start_lvl( &$docent_pro_output, $depth = 0, $docent_pro_args = array() ) {

        $indent = str_repeat("\t", $depth);

        if($this->megamenuId == 1){
        	$docent_pro_output .= "\n$indent<ul role=\"menu\" class=\"sub-menu megamenu megacol-".$this->columnId."\">\n";
        }else{
        	$docent_pro_output .= "\n$indent<ul role=\"menu\" class=\"sub-menu\">\n";
        }
    }	

	function start_el(&$docent_pro_output, $item, $depth = 0, $docent_pro_args = array(), $id = 0)
	{
		global $wp_query;

		$megamenu = 0;
		$docent_column = 1;

		if($depth == 1){            
			$docent_column = get_post_meta( $item->menu_item_parent, '_menu_item_column', true );
			$megamenu = get_post_meta( $item->menu_item_parent, '_menu_item_megamenu', true );
		}

		$this->megamenuId	 = get_post_meta( $item->ID, '_menu_item_megamenu', true );
		$this->columnId		 = get_post_meta( $item->ID, '_menu_item_column', true );


		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = join(' ', $classes);

		$class_megamenu = ( $item->megamenu )? ' has-megasub': '';

		if ( $megamenu == 1 ) {
			$class_megamenu .= ' mega-child';
		} else {
			$class_megamenu .= ' has-menu-child';
		}
		
		$postid = get_post($item->object_id,ARRAY_A);
		$slug = $postid['post_name'];

		if (is_singular('album') &&  $slug == 'albums') {
			$class_names = 'class="'.esc_attr( $class_names ) . $class_megamenu.' active"';
		}else if (is_singular('gallery') &&  $slug == 'gallery') {
			$class_names = 'class="'.esc_attr( $class_names ) . $class_megamenu.' active"';
		}else if(is_singular('event') || is_singular('album') || is_singular('gallery')){
			$class_names = 'class="'.esc_attr( $class_names ) . $class_megamenu.'"';
		}else{
			if(in_array('current-menu-parent', $classes)) { $class_names .= ' active'; }
			// if(in_array('current_page_parent', $classes)) { $class_names .= ' active'; }
			if(in_array('current-menu-item', $classes)) { $class_names .= ' active'; }
			$class_names = 'class="'.esc_attr( $class_names ) . $class_megamenu.'"';
		}

		$docent_pro_output .= $indent . '<li ' . $value . $class_names.'>';

		//$attributes  = ! empty( $item->title ) 		? ' title="'  . esc_attr( $item->title 		) .'"' : '';
       	$attributes = ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
       	$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
       	$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

       	$description  = ! empty( $item->description ) ? '<div class="custom-output">'.esc_attr( $item->description ).'</div>' : '';

       	$item_output = $docent_pro_args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $docent_pro_args->link_before .apply_filters( 'docent_pro_the_title', $item->title, $item->ID );            
        $item_output .= $docent_pro_args->link_after;
        //$item_output .= $docent_pro_args->link_after.' <span class="subtitle">'.esc_attr($item->attr_title).'</span>';
        $item_output .= '</a>'.do_shortcode($description);
        $item_output .= $docent_pro_args->after;

        $docent_pro_output .= apply_filters( 'docent_pro_walker_nav_menu_start_el', $item_output, $item, $depth, $docent_pro_args );
	}
}