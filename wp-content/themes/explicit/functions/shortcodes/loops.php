<?php
/**
 *
 */
class itLoops {	
	
	public static function grid( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {
			$option = array(
				'name' => __( 'Grid', IT_TEXTDOMAIN ),
				'value' => 'grid',
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
						'name' => __( 'Post Loading', IT_TEXTDOMAIN ),
						'desc' => __( 'How should subsequent pages of posts load', IT_TEXTDOMAIN ),
						'id' => 'loading',
						'default' => 'paged',
						'options' => array(
							'paged' => __('Paged', IT_TEXTDOMAIN ),
							'infinite' => __('Infinite', IT_TEXTDOMAIN ),
							'none' => __('None', IT_TEXTDOMAIN ),
						),
						'type' => 'radio'
					),
					array(
						'name' => __( 'Title', IT_TEXTDOMAIN ),
						'desc' => __( 'Displays to the left of the sort controls.', IT_TEXTDOMAIN ),
						'id' => 'title',
						'type' => 'text'
					),	
					array(
						'name' => __( 'Disable Filter Buttons', IT_TEXTDOMAIN ),
						'desc' => __( 'You can disable individual filter buttons.', IT_TEXTDOMAIN ),
						'id' => 'disabled_filters',
						'options' => array(
							'liked' => __('Liked',IT_TEXTDOMAIN),
							'viewed' => __('Viewed',IT_TEXTDOMAIN),
							'reviewed' => __('Reviewed',IT_TEXTDOMAIN),
							'rated' => __('Rated',IT_TEXTDOMAIN),
							'commented' => __('Commented',IT_TEXTDOMAIN),
							'awarded' => __('Awarded',IT_TEXTDOMAIN),
							'title' => __('Alphabetical',IT_TEXTDOMAIN)
						),
						'type' => 'checkbox'
					),
					array(
						'name' => __( 'Number of Rows', IT_TEXTDOMAIN ),
						'desc' => __( 'The number of total rows of posts to display before pagination or the load more button is displayed. This is also the number of rows that will load when the load more button is clicked.', IT_TEXTDOMAIN ),
						'id' => 'rows',
						'target' => 'recommended_filters_number',
						'type' => 'select'
					),					
					array(
						'name' => __( 'Disable Ads', IT_TEXTDOMAIN ),
						'id' => 'disable_ads',
						'options' => array( 'true' => __( 'Do not display ads within this loop', IT_TEXTDOMAIN ) ),
						'type' => 'checkbox'
					),
				'shortcode_has_atts' => true
				)
			);
			
			return $option;
		}
		
		extract(shortcode_atts(array(	
			'loading' 				=> '',
			'title'					=> '',
			'rows'					=> 2,
			'disable_ads'			=> '',
			'disabled_filters'		=> '',
			'included_categories'	=> '',
			'excluded_categories'	=> '',
			'included_tags'			=> '',
			'excluded_tags'			=> '',
		), $atts));	
		
		$out = '';
		
		global $wp, $wp_query;
		#get the current query to pass it to the ajax functions through the html data tag
		if(!is_single() && !is_page()) $current_query = $wp->query_vars;
		
		#default settings
		$args = array();
		$rating = it_get_setting('loop_rating_disable');
		$layout = it_get_setting('grid_layout');
		$sidebar_unique = it_get_setting('grid_unique_sidebar');
		$disabled_filters = !empty($disabled_filters) ? explode(',',$disabled_filters) : array();
		$disabled_count = !empty($disabled_filters) ? count($disabled_filters) : 0;
		$disable_filters = $disabled_count > 6 ? true : false;
					
		#determine css classes
		switch($layout) {
			case 'a':
				$csslayout = 'sidebar-right';
				$csscol2 = 'col-md-8';
				$csscol3 = 'col-md-4';
				$cols = 2;
			break;
			case 'b':
				$csslayout = 'sidebar-right';
				$csscol2 = 'col-md-9';
				$csscol3 = 'col-md-3';
				$cols = 3;
			break;
			case 'c':
				$csslayout = 'sidebar-left';
				$csscol1 = 'col-md-4';
				$csscol2 = 'col-md-8';
				$cols = 2;
			break;
			case 'd':
				$csslayout = 'sidebar-left';
				$csscol1 = 'col-md-3';
				$csscol2 = 'col-md-9';
				$cols = 3;
			break;	
			case 'e':
				$csslayout = 'full';
				$csscol2 = 'col-md-12';
				$cols = 3;
			break;	
			case 'f':
				$csslayout = 'full';
				$csscol2 = 'col-md-12';
				$cols = 4;
			break;	
		}
		
		if(empty($rows)) $rows = 1;
		if(empty($cols)) $cols = 4;
		$postsperpage = $rows * $cols;
		$view = 'grid';
		$loop = 'main loop';
		$cssload = ' load-sort';
		$location = '';
		$sidebar = $sidebar_unique ? __('Grid Sidebar',IT_TEXTDOMAIN) : __('Loop Sidebar',IT_TEXTDOMAIN);	
		
		#query args
		$args = array('posts_per_page' => $postsperpage, 'ignore_sticky_posts' => true);
		$ignore_excludes = true;	
		#check and see if we care about excludes and limits
		if(!(is_archive() || is_search())) $ignore_excludes = false;
		if(!$ignore_excludes) {
			#limits
			if(!empty($included_categories)) $current_query['category__in'] = explode(',',$included_categories);
			if(!empty($included_categories)) $args['category__in'] = explode(',',$included_categories);	
			if(!empty($included_tags)) $current_query['tag__in'] = explode(',',$included_tags);	
			if(!empty($included_tags)) $args['tag__in'] = explode(',',$included_tags);
			#excludes
			if(!empty($excluded_categories)) $current_query['category__not_in'] = explode(',',$excluded_categories);
			if(!empty($excluded_categories)) $args['category__not_in'] = explode(',',$excluded_categories);
			if(!empty($excluded_tags)) $current_query['tag__not_in'] = explode(',',$excluded_tags);
			if(!empty($excluded_tags)) $args['tag__not_in'] = explode(',',$excluded_tags);
		}
		if(!isset($csslayout)) $csslayout = '';		
		#setup loop format
		$format = array('loop' => $loop, 'location' => $location, 'view' => $view, 'sort' => 'recent', 'columns' => $cols, 'paged' => 1, 'thumbnail' => true, 'rating' => true, 'icon' => true, 'nonajax' => true, 'meta' => true, 'icon' => true, 'award' => true, 'badge' => true, 'excerpt' => true, 'authorship' => true, 'numarticles' => $postsperpage, 'disable_ads' => $disable_ads, 'layout' => $csslayout, 'large_first' => false);
		
		if(!is_single() && !is_page()) $args = array_merge($args, $current_query);
		$disable_title = empty($disable_title) ? false : $disable_title;
		#setup sortbar
		$sortbarargs = array('title' => $title, 'loop' => $loop, 'location' => $location, 'view' => $view, 'cols' => $cols, 'disabled_filters' => $disabled_filters, 'numarticles' => $postsperpage, 'disable_filters' => $disable_filters, 'disable_title' => $disable_title, 'thumbnail' => true, 'rating' => true, 'meta' => true, 'layout' => $csslayout, 'cssclass' => 'light', 'icon' => true, 'award' => true, 'badge' => true, 'excerpt' => true, 'authorship' => true, 'large_first' => false);

		$args = it_search_args($args);
		$current_query = it_search_args($current_query);
		
		#get correct page number count
		$itposts = new WP_Query($args);
		$numpages = $itposts->max_num_pages;
		wp_reset_postdata();
		
		#setup load more button
		if($loading=='infinite') {
			$loadmoreargs = $format;
			$loadmoreargs['numpages'] = $numpages;
			$cssload = ' load-infinite';
		}
		
		$csspagination = $disable_filters && $disable_title ? ' hidden-filters' : '';
		
		$current_query_encoded = json_encode($current_query);
		
		$loop = it_loop($args, $format);
		
		#put the actions into variables
		ob_start();
		do_action('it_before_grid', it_get_setting('ad_grid_before'), 'before-grid');
		$before = ob_get_contents();
		ob_end_clean();	
		ob_start();
		do_action('it_after_grid', it_get_setting('ad_grid_after'), 'after-grid');
		$after = ob_get_contents();
		ob_end_clean();	
		
		if(!isset($csscol2)) $csscol2 = '';	

		if(!empty($content)) $out .= '<div class="html-content clearfix">' . do_shortcode(stripslashes($content)) . '</div>'; 
            
        $out .= '<div class="container">';
        
			$out .= '<div class="row">';
			
				$out .= $before;
			
				if($csslayout=='sidebar-left') {
				
					$out .= '<div class="' . $csscol1 . '">';
				
						$out .= it_widget_panel($sidebar, $csslayout);
						
					$out .= '</div>';
								
				}
					
				$out .= '<div class="articles gradient post-grid ' . $csslayout . $csspagination . '">';
			
					$out .= "<div class='" . $csscol2 . " post-container' data-currentquery='" . $current_query_encoded . "'>";
					
						$out .= it_archive_title();
					
						$out .= it_get_sortbar($sortbarargs);
						
						if($loading=='paged') {
                                
                            $out .= '<div class="pagination-wrapper">';
                            
                                $out .= it_pagination($numpages, $format, it_get_setting('page_range'));
                                
                            $out .= '</div>';
                            
                        }
						
						$out .= '<div class="content-inner">';
						
							$out .= '<div class="loading load-sort"><span class="theme-icon-spin2"></span></div>';
						
							$out .= '<div class="loop grid row">';
							
								$out .= $loop['content'];
								
							$out .= '</div>';
							
							$out .= '<div class="loading' . $cssload . '"><span class="theme-icon-spin2"></span></div>';
							
						$out .= '</div>';
						
						if($loading=='infinite') {
			
							$out .= it_get_loadmore($loadmoreargs);
							
							$out .= '<div class="last-page">' . __('End of the line!',IT_TEXTDOMAIN) . '</div>';
							
						} elseif($loading=='paged') {
							
							$out .= '<div class="pagination-wrapper mobile">';
					
								$out .= it_pagination($numpages, $format, it_get_setting('page_range_mobile'));
								
							$out .= '</div>';
							
						}
					
					$out .= '</div>';
					
				$out .= '</div>';
					
				if($csslayout=='sidebar-right') {
				
					$out .= '<div class="' . $csscol3 . '">';
				
						$out .= it_widget_panel($sidebar, $csslayout);
						
					$out .= '</div>';
								
				}
				
				$out .= $after;
				
			$out .= '</div>';
			
		$out .= '</div>';
        
        wp_reset_query();
				
		return $out;
		
	}
	
	public static function blog( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {
			$option = array(
				'name' => __( 'Blog', IT_TEXTDOMAIN ),
				'value' => 'blog',
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
						'name' => __( 'Post Loading', IT_TEXTDOMAIN ),
						'desc' => __( 'How should subsequent pages of posts load', IT_TEXTDOMAIN ),
						'id' => 'loading',
						'default' => 'paged',
						'options' => array(
							'paged' => __('Paged', IT_TEXTDOMAIN ),
							'infinite' => __('Infinite', IT_TEXTDOMAIN ),
							'none' => __('None', IT_TEXTDOMAIN ),
						),
						'type' => 'radio'
					),
					array(
						'name' => __( 'Title', IT_TEXTDOMAIN ),
						'desc' => __( 'Displays to the left of the sort controls.', IT_TEXTDOMAIN ),
						'id' => 'title',
						'type' => 'text'
					),	
					array(
						'name' => __( 'Disable Filter Buttons', IT_TEXTDOMAIN ),
						'desc' => __( 'You can disable individual filter buttons.', IT_TEXTDOMAIN ),
						'id' => 'disabled_filters',
						'options' => array(
							'liked' => __('Liked',IT_TEXTDOMAIN),
							'viewed' => __('Viewed',IT_TEXTDOMAIN),
							'reviewed' => __('Reviewed',IT_TEXTDOMAIN),
							'rated' => __('Rated',IT_TEXTDOMAIN),
							'commented' => __('Commented',IT_TEXTDOMAIN),
							'awarded' => __('Awarded',IT_TEXTDOMAIN),
							'title' => __('Alphabetical',IT_TEXTDOMAIN)
						),
						'type' => 'checkbox'
					),
					array(
						'name' => __( 'Posts Per Page', IT_TEXTDOMAIN ),
						'desc' => __( 'The number of total posts to display before pagination or the load more button is displayed. This is also the number of rows that will load when the load more button is clicked.', IT_TEXTDOMAIN ),
						'id' => 'postsperpage',
						'target' => 'range_number',
						'type' => 'select'
					),
					array(
						'name' => __( 'Disable Ads', IT_TEXTDOMAIN ),
						'id' => 'disable_ads',
						'options' => array( 'true' => __( 'Do not display ads within this loop', IT_TEXTDOMAIN ) ),
						'type' => 'checkbox'
					),
					array(
						'name' => __( 'Disable Excerpt', IT_TEXTDOMAIN ),
						'id' => 'disable_excerpt',
						'options' => array( 'true' => __( 'Do not display post excerpts within this loop', IT_TEXTDOMAIN ) ),
						'type' => 'checkbox'
					),
					array(
						'name' => __( 'Disable Authorship', IT_TEXTDOMAIN ),
						'id' => 'disable_authorship',
						'options' => array( 'true' => __( 'Do not display authorship within this loop', IT_TEXTDOMAIN ) ),
						'type' => 'checkbox'
					),
				'shortcode_has_atts' => true
				)
			);
			
			return $option;
		}
		
		extract(shortcode_atts(array(	
			'loading' 				=> '',
			'title'					=> '',
			'postsperpage'			=> 5,
			'disable_ads'			=> '',
			'disabled_filters'		=> '',
			'disable_excerpt'		=> '',
			'disable_authorship'	=> '',
			'included_categories'	=> '',
			'excluded_categories'	=> '',
			'included_tags'			=> '',
			'excluded_tags'			=> '',
		), $atts));	
		
		$out = '';
		
		global $wp, $wp_query;
		#get the current query to pass it to the ajax functions through the html data tag
		if(!is_single() && !is_page()) $current_query = $wp->query_vars;
		
		#default settings
		$args = array();
		$rating = it_get_setting('loop_rating_disable');
		$layout = it_get_setting('list_layout');
		$sidebar_unique = it_get_setting('list_unique_sidebar');
		$disabled_filters = !empty($disabled_filters) ? explode(',',$disabled_filters) : array();
		$disabled_count = !empty($disabled_filters) ? count($disabled_filters) : 0;
		$disable_filters = $disabled_count > 6 ? true : false;
		
		$cols = 1;
		$view = 'list';
		$loop = 'main loop';
		$cssload = ' load-sort';
		$location = '';
		$csslayout = '';
		$csscol1 = '';
		$csscol2 = '';
		$csscol3 = '';
		$sidebar = $sidebar_unique ? __('Blog Sidebar',IT_TEXTDOMAIN) : __('Loop Sidebar',IT_TEXTDOMAIN);		
		
		#determine css classes
		switch($layout) {
			case 'a':
				$csslayout = 'sidebar-right';
				$csscol2 = 'col-md-8';
				$csscol3 = 'col-md-4';
			break;
			case 'b':
				$csslayout = 'sidebar-left';
				$csscol1 = 'col-md-4';
				$csscol2 = 'col-md-8';
			break;
			case 'c':
				$csslayout = 'full';
				$csscol2 = 'col-md-12';
			break;	
		}
		
		#query args
		$args = array('posts_per_page' => $postsperpage);
		
		#check and see if we care about excludes and limits
		if(!(is_archive() || is_search())) $ignore_excludes = false;
		if(!$ignore_excludes) {
			#limits
			if(!empty($included_categories)) $current_query['category__in'] = explode(',',$included_categories);
			if(!empty($included_categories)) $args['category__in'] = explode(',',$included_categories);	
			if(!empty($included_tags)) $current_query['tag__in'] = explode(',',$included_tags);	
			if(!empty($included_tags)) $args['tag__in'] = explode(',',$included_tags);
			#excludes
			if(!empty($excluded_categories)) $current_query['category__not_in'] = explode(',',$excluded_categories);
			if(!empty($excluded_categories)) $args['category__not_in'] = explode(',',$excluded_categories);
			if(!empty($excluded_tags)) $current_query['tag__not_in'] = explode(',',$excluded_tags);
			if(!empty($excluded_tags)) $args['tag__not_in'] = explode(',',$excluded_tags);
		}
		
		#setup loop format
		$format = array('loop' => $loop, 'location' => $location, 'view' => $view, 'sort' => 'recent', 'columns' => $cols, 'paged' => 1, 'thumbnail' => true, 'rating' => true, 'icon' => true, 'nonajax' => true, 'meta' => true, 'icon' => true, 'award' => true, 'badge' => true, 'excerpt' => !$disable_excerpt, 'authorship' => !$disable_authorship, 'numarticles' => $postsperpage, 'disable_ads' => $disable_ads, 'layout' => $csslayout, 'large_first' => false);
		
		if(!is_single() && !is_page()) $args = array_merge($args, $current_query);
		$disable_title = empty($disable_title) ? false : $disable_title;
		#setup sortbar
		$sortbarargs = array('title' => $title, 'loop' => $loop, 'location' => $location, 'view' => $view, 'cols' => $cols, 'disabled_filters' => $disabled_filters, 'numarticles' => $postsperpage, 'disable_filters' => $disable_filters, 'disable_title' => $disable_title, 'thumbnail' => true, 'rating' => true, 'meta' => true, 'layout' => $csslayout, 'cssclass' => 'light', 'icon' => true, 'award' => true, 'badge' => true, 'excerpt' => !$disable_excerpt, 'authorship' => !$disable_authorship, 'large_first' => false);
		
		$args = it_search_args($args);
		$current_query = it_search_args($current_query);
		
		#get correct page number count
		$itposts = new WP_Query($args);
		$numpages = $itposts->max_num_pages;
		wp_reset_postdata();
		
		#setup load more button
		if($loading=='infinite') {
			$loadmoreargs = $format;
			$loadmoreargs['numpages'] = $numpages;
			$cssload = ' load-infinite';
		}
		
		$current_query_encoded = json_encode($current_query);
		
		$loop = it_loop($args, $format);
		
		#put the actions into variables
		ob_start();
		do_action('it_before_list', it_get_setting('ad_list_before'), 'before-list');
		$before = ob_get_contents();
		ob_end_clean();	
		ob_start();
		do_action('it_after_list', it_get_setting('ad_list_after'), 'after-list');
		$after = ob_get_contents();
		ob_end_clean();	
		
		if(!empty($content)) $out .= '<div class="html-content clearfix">' . do_shortcode(stripslashes($content)) . '</div>'; 
            
        $out .= '<div class="container">';
        
			$out .= '<div class="row">';
			
				$out .= $before;
				
				if($layout=='b') {
				
					$out .= '<div class="' . $csscol1 . '">';
				
						$out .= it_widget_panel($sidebar, $csslayout);
						
					$out .= '</div>';
								
				}
				
				$out .= '<div class="articles gradient post-blog ' . $csslayout . '">';
					
					$out .= "<div class='" . $csscol2 . " post-container' data-currentquery='" . $current_query_encoded . "'>";
					
						$out .= it_archive_title();
					
						$out .= it_get_sortbar($sortbarargs);
					
						$out .= '<div class="content-inner">';
					
							$out .= '<div class="loading' . $cssload . '"><span class="theme-icon-spin2"></span></div>';
						
							$out .= '<div class="loop list row">';
							
								$out .= $loop['content'];
								
							$out .= '</div>';
							
							$out .= '<div class="loading load-infinite"><span class="theme-icon-spin2"></span></div>';
							
						$out .= '</div>';
						
						if($loading=='infinite') {
			
							$out .= it_get_loadmore($loadmoreargs);
							
							$out .= '<div class="last-page">' . __('End of the line!',IT_TEXTDOMAIN) . '</div>';
							
						} elseif($loading=='paged') {
							
							$out .= '<div class="pagination-wrapper">';
					
								$out .= it_pagination($numpages, $format, it_get_setting('page_range'));
								
							$out .= '</div>';
							
							$out .= '<div class="pagination-wrapper mobile">';
					
								$out .= it_pagination($numpages, $format, it_get_setting('page_range_mobile'));
								
							$out .= '</div>';
							
						}
						
					$out .= '</div>';
					
				$out .= '</div>';
					
				if($layout=='a') {
				
					$out .= '<div class="' . $csscol3 . '">';
				
						$out .= it_widget_panel($sidebar, $csslayout);
						
					$out .= '</div>';
								
				}
				
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
			'name' => __( 'Loops', IT_TEXTDOMAIN ),
			'desc' => __( 'Choose which type of post loop you wish to use.', IT_TEXTDOMAIN ),
			'value' => 'loops',
			'options' => $shortcode,
			'shortcode_has_types' => true
		);

		return $options;
	}

}

?>
