<?php
/**
 *
 */
class itPortholes {	
	
	public static function portholes( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {
			$option = array(
				'name' => __( 'Portholes', IT_TEXTDOMAIN ),
				'value' => 'portholes',
				'options' => array(					
					array(
						'name' => __( 'Included Categories', IT_TEXTDOMAIN ),
						'id' => 'included_categories',
						'target' => 'cat',
						'type' => 'multidropdown'
					),	
					array(
						'name' => __( 'Included Tags', IT_TEXTDOMAIN ),
						'id' => 'included_tags',
						'target' => 'tag',
						'type' => 'multidropdown'
					),
					array(
						'name' => __( 'Excluded Categories', IT_TEXTDOMAIN ),
						'id' => 'excluded_categories',
						'target' => 'cat',
						'type' => 'multidropdown'
					),	
					array(
						'name' => __( 'Excluded Tags', IT_TEXTDOMAIN ),
						'id' => 'excluded_tags',
						'target' => 'tag',
						'type' => 'multidropdown'
					),
					array(
						'name' => __( 'Number of Posts', IT_TEXTDOMAIN ),
						'desc' => __( 'The total number of posts to display within the slider before it loops back around to the first post', IT_TEXTDOMAIN ),
						'id' => 'postsperpage',
						'target' => 'range_number',
						'type' => 'select'
					),
					array(
						'name' => __( 'Targeted', IT_TEXTDOMAIN ),
						'id' => 'targeted',
						'options' => array( 'true' => __( 'Aware of currently displayed category section', IT_TEXTDOMAIN ) ),
						'type' => 'checkbox'
					),
				'shortcode_has_atts' => true
				)
			);
			
			return $option;
		}
		
		extract(shortcode_atts(array(			
			'included_categories'	=> '',
			'excluded_categories'	=> '',
			'included_tags'			=> '',
			'excluded_tags'			=> '',
			'targeted'				=> '',
			'postsperpage'			=> ''
		), $atts));	
		
		$out = '';
		
		$loop = 'portholes';
		$cols = it_get_setting('portholes_cols');			
		
		#see if this builder is targeted
		$category_id = $targeted ? it_page_in_category($post->ID) : false;
		$category_and = array();
		if(!empty($category_id)) $category_and[] = $category_id; #add current category if targeted
		if(!empty($included_categories)) $category_in = explode(',',$included_categories);
		
		#setup query args
		$args = array('posts_per_page' => $postsperpage, 'ignore_sticky_posts' => true);
		
		#limits
		if(!empty($category_and) || !empty($category_in)) {	
			#build the tax query
			$tax_query = array('relation' => 'AND');		
			if(!empty($category_and)) $tax_query[] = array('taxonomy' => 'category', 'field' => 'id', 'terms' => $category_and);	
			if(!empty($category_in)) $tax_query[] = array('taxonomy' => 'category', 'field' => 'id', 'terms' => $category_in, 'operator' => 'IN');
			$args['tax_query'] = $tax_query;	
		}
		if(!empty($included_tags)) $args['tag__in'] = explode(',',$included_tags);
		#excludes
		if(!empty($excluded_categories)) $args['category__not_in'] = explode(',',$excluded_categories);
		if(!empty($excluded_tags)) $args['tag__not_in'] = explode(',',$excluded_tags);
		
		#setup loop format
		$format = array('loop' => $loop, 'size' => 'portholes');
				
		$loop = it_loop($args, $format);
		
		#put the actions into variables
		ob_start();
		do_action('it_before_portholes', it_get_setting('ad_portholes_before'), 'before-portholes');
		$before = ob_get_contents();
		ob_end_clean();	
		ob_start();
		do_action('it_after_portholes', it_get_setting('ad_portholes_after'), 'after-portholes', true);
		$after = ob_get_contents();
		ob_end_clean();
		
		if(!empty($content)) $out .= '<div class="html-content clearfix">' . do_shortcode(stripslashes($content)) . '</div>'; 
    
		$out .= '<div class="container">';

			$out .= '<div class="row portholes cols-' . $cols . '">';
			
				$out .= $before;
			
				$out .= '<div class="col-md-12">';
				
					$out .= $loop['content'];                
				
				$out .= '</div>';
				
				$out .= $after;
				
			$out .= '</div>';
			
		$out .= '</div>';
				
        wp_reset_query();
				
		return $out;
		
	}
		
	/**
	 *
	 */
	public static function _options( $class ) {
		$shortcode = array();
		
		$class_methods = get_class_methods($class);

		foreach( $class_methods as $method ) {
			if( $method[0] != '_' )
				$shortcode[] = call_user_func(array( &$class, $method ), $atts = 'generator' );
		}

		$options = array(
			'name' => __( 'Portholes', IT_TEXTDOMAIN ),
			'value' => 'portholes',
			'options' => $shortcode
		);

		return $options;
	}

}

?>
