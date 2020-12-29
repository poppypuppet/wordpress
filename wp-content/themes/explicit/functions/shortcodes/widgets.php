<?php
/**
 *
 */
class itWidgets {	
	
	public static function widgets( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {
			$option = array();
			
			return $option;
		}
		
		extract(shortcode_atts(array(), $atts));	
		
		$out = '';
		
		$col1 = __('Widgets Column 1',IT_TEXTDOMAIN);
		$col2 = __('Widgets Column 2',IT_TEXTDOMAIN);
		$col3 = __('Widgets Column 3',IT_TEXTDOMAIN);
		$class = 'widgets';	
		$widgets_layout = it_get_setting('widgets_layout');
		$layout = it_widgets_layout($widgets_layout);
		
		#put the actions into variables
		ob_start();
		do_action('it_before_widgets', it_get_setting('ad_widgets_before'), 'before-widgets');
		$before = ob_get_contents();
		ob_end_clean();	
		ob_start();
		do_action('it_after_widgets', it_get_setting('ad_widgets_after'), 'after-widgets');
		$after = ob_get_contents();
		ob_end_clean();
		
		if(!empty($content)) $out .= '<div class="html-content clearfix">' . do_shortcode(stripslashes($content)) . '</div>'; 	
		
		$out .= '<div class="container">';
    
			$out .= '<div class="row" id="widgets">';
			
				$out .= $before;
			
				if(!empty($layout['col1'])) { 
				
					$csssize = $layout['col1'] < 6 ? ' narrow' : '';
				
					$out .= '<div class="widget-panel left col-md-' . $layout['col1'] .  $csssize . '">';
					
						$out .= it_widget_panel($col1, $class);
						
					$out .= '</div>';
				
				}
							
				if(!empty($layout['col2'])) { 
				
					$csssize = $layout['col2'] < 6 ? ' narrow' : '';
				
					$out .= '<div class="widget-panel mid col-md-' . $layout['col2'] . $csssize . '">';
					
						$out .= it_widget_panel($col2, $class);
						
					$out .= '</div>';
				
				}
							
				if(!empty($layout['col3'])) { 
				
					$csssize = $layout['col3'] < 6 ? ' narrow' : '';
				
					$out .= '<div class="widget-panel right col-md-' . $layout['col3'] . $csssize . '">';
					
						$out .= it_widget_panel($col3, $class);
						
					$out .= '</div>';
				
				}
				
				$out .= $after;
				
			$out .= '</div>';
			
		$out .= '</div>';
				
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
			'name' => __( 'Widgets', IT_TEXTDOMAIN ),
			'value' => 'widgets',
			'options' => $shortcode
		);

		return $options;
	}

}

?>
