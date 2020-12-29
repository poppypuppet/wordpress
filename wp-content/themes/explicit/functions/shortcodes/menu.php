<?php
/**
 *
 */
class itMenu {	
	
	public static function menu( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {
			$option = array(
				'name' => __( 'Utility Menu', IT_TEXTDOMAIN ),
				'value' => 'menu',
				'options' => array(
					array(
						'name' => __( 'Title', IT_TEXTDOMAIN ),
						'desc' => __( 'Displays to the left of the menu.', IT_TEXTDOMAIN ),
						'id' => 'title',
						'type' => 'text'
					),
					array(
						'name' => __( 'Icon', IT_TEXTDOMAIN ),
						'desc' => __( 'Displays to the left of the title', IT_TEXTDOMAIN ),
						'id' => 'icon',
						'target' => 'icons',
						'type' => 'select'
					),
				'shortcode_has_atts' => true
				)
			);
			
			return $option;
		}
		
		extract(shortcode_atts(array(	
			'title'					=> '',
			'icon'					=> ''
		), $atts));	
		
		$out = '';
		
		#get the utility menu, stripping out title attributes
		$menu = preg_replace('/title=\"(.*?)\"/','',wp_nav_menu( array( 'theme_location' => 'utility-menu', 'container' => false, 'fallback_cb' => false, 'echo' => false ) ) );
		
		#put the actions into variables
		ob_start();
		do_action('it_before_utility', it_get_setting('ad_utility_before'), 'before-utility');
		$before = ob_get_contents();
		ob_end_clean();	
		ob_start();
		do_action('it_after_utility', it_get_setting('ad_utility_after'), 'after-utility');
		$after = ob_get_contents();
		ob_end_clean();	
		
		if(!empty($content)) $out .= '<div class="html-content clearfix">' . do_shortcode(stripslashes($content)) . '</div>'; 
		
		$out .= '<div class="container">';
    
			$out .= '<div class="row">';
			
				$out .= $before;
					
				$out .= '<div class="col-md-12"> ';
							
					$out .= '<div class="menu-container bar-header full-width utility-menu">'; 
						
						$out .= '<div class="utility-menu-full">'; 
						
							$out .= '<div class="bar-label-wrapper">';
						
								$out .= '<div class="bar-label">';
							
									$out .= '<div class="label-text">' . $title . '<span class="theme-icon-' . $icon . '"></span></div>';
									
								$out .= '</div>';
								
								$out .= '<div class="home-button"><a href="' . home_url() . '/"><span class="theme-icon-home"></span></a></div>';
								
							$out .= '</div>';
						
							$out .= '<div class="standard-menu">' . $menu . '</div>';
							
							$out .= '<br class="clearer" /> ';                           
						
						$out .= '</div>';
							
						$out .= '<div class="utility-menu-compact">';
						
							$out .= '<div class="bar-label-wrapper">';
						
								$out .= '<div class="bar-label">';
								
									$out .= '<ul>';
								
										$out .= '<li>';
								
											$out .= '<a class="utility-menu-selector label-text">';
											
												$out .= '<span class="theme-icon-list"></span>';
												
												$out .= $title;
												
												$out .= '<span class="theme-icon-down-fat"></span>';
												
											$out .= '</a>';
											
											$out .= $menu;
										
										$out .= '</li>';
									
									$out .= '</ul>';
									
								$out .= '</div>';
								
								$out .= '<div class="home-button"><a href="' . home_url() . '/"><span class="theme-icon-home"></span></a></div>';
								
							$out .= '</div>';
				
						$out .= '</div>';  
						
					$out .= '</div>';
					
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
			'name' => __( 'Utility Menu', IT_TEXTDOMAIN ),
			'value' => 'menu',
			'options' => $shortcode
		);

		return $options;
	}

}

?>
