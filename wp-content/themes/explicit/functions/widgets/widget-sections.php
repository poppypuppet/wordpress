<?php
class it_sections extends WP_Widget {
	function it_sections() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Sections', 'description' => __( 'Displays selected categories represented by their corresponding icons in a tabbed format.',IT_TEXTDOMAIN) );
		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'it_sections' );
		/* Create the widget. */
		parent::__construct( 'it_sections', 'Sections', $widget_ops, $control_ops );
	}	
	function widget( $args, $instance ) {		
		
		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );			
		$numarticles = $instance['numarticles'];
		$thumbnail = $instance['thumbnail'];
		$rating = $instance['rating'];
		$icon = $instance['icon'];
		$award = $instance['award'];
		$meta = $instance['meta'];
		$badge = $instance['badge'];
		$authorship = $instance['authorship'];
		$excerpt = $instance['excerpt'];
		$layout = $instance['layout'];
		$first = $instance['first'];
		$link='';
		
		#create semantic variables		
		$disable_title = empty($title) ? true : false;	
		
		#setup the query            
        $args=array('posts_per_page' => $numarticles, 'order' => 'DESC', 'ignore_sticky_posts' => true);	
		
		$sections = it_get_setting('widgets_section_categories');
		if(!empty($sections)) {
			$args['cat'] = $sections[0];	
			$link = get_category_link( $sections[0] );
		}
				
		$csscompact = $layout=='widget_e' ? '' : ' compact';
		$cssclass = $layout=='widget_e' ? ' post-grid' : ' post-blog';
		
		#setup loop format
		$format = array('loop' => 'sections', 'location' => $layout, 'thumbnail' => $thumbnail, 'rating' => $rating, 'meta' => $meta, 'award' => $award, 'icon' => $icon, 'badge' => $badge, 'excerpt' => $excerpt, 'authorship' => $authorship, 'nonajax' => true, 'numarticles' => $numarticles, 'columns' => 1, 'view' => 'list', 'sort' => 'recent', 'large_first' => $first, 'size' => 'portholes');	
				
		$disabled_filters = array();
		
		#setup sortbar		
		$sortbarargs = array('type' => 'sections', 'title' => $title, 'loop' => 'sections', 'location' => $layout, 'cols' => 1, 'class' => '', 'disabled_filters' => $disabled_filters, 'numarticles' => $numarticles, 'disable_filters' => false, 'disable_title' => $disable_title, 'prefix' => false, 'view' => 'list', 'thumbnail' => $thumbnail, 'rating' => $rating, 'meta' => $meta, 'award' => $award, 'badge' => $badge, 'excerpt' => $excerpt, 'authorship' => $authorship, 'icon' => $icon, 'cssclass' => 'light', 'large_first' => $first, 'theme_icon' => 'grid', 'layout' => '');		
		
		#fetch the loop
		$loop = it_loop($args, $format); 
		    
        #Before widget (defined by themes)
        echo $before_widget;
		
		echo '<div class="articles post-container gradient widgets-sections floated no-color' . $cssclass . $csscompact . ' ' . $layout . '">';
		
			if(!empty($sections)) {

				#display the sortbar
				echo it_get_sortbar($sortbarargs);
				
				echo '<div class="content-inner">';
				
					echo '<div class="loading load-sort"><span class="theme-icon-spin2"></span></div>';	
					
					echo '<div class="loop list row">';
						
						echo $loop['content'];
						
						echo '<div class="col-md-12"><a class="styled more-link" href="' . esc_url($link) . '">' . __('View All',IT_TEXTDOMAIN) . '<span class="theme-icon-right-fat"></span></a></div>';
						
					echo '</div>';
					
				echo '</div>';
				
			} else {
				
				echo __('You need to choose at least one Section Widget Category in Theme Options >> Page Builder Setup >> Widgets',IT_TEXTDOMAIN);
				
			}
			
		echo '</div>';
		
		wp_reset_query();			
        
		# After widget (defined by themes)
        echo $after_widget; ?>		
		
	<?php
	}
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );			
		$instance['numarticles'] = strip_tags( $new_instance['numarticles'] );		
		$instance['thumbnail'] = isset( $new_instance['thumbnail'] );
		$instance['rating'] = isset( $new_instance['rating'] );
		$instance['icon'] = isset( $new_instance['icon'] );	
		$instance['award'] = isset( $new_instance['award'] );	
		$instance['meta'] = isset( $new_instance['meta'] );	
		$instance['badge'] = isset( $new_instance['badge'] );	
		$instance['authorship'] = isset( $new_instance['authorship'] );	
		$instance['excerpt'] = isset( $new_instance['excerpt'] );
		$instance['layout'] = strip_tags( $new_instance['layout'] );
		$instance['first'] = isset( $new_instance['first'] );		
		
		return $instance;
		
	}
	function form( $instance ) {	

		#set up some default widget settings.
		$defaults = array( 'title' => __('MOST RECENT', IT_TEXTDOMAIN), 'numarticles' => 4, 'thumbnail' => true, 'rating' => true, 'icon' => true, 'badge' => true, 'authorship' => true, 'excerpt' => true, 'award' => true, 'meta' => true, 'layout' => 'widget_a', 'first' => false );		
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>	
        
        <p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:',IT_TEXTDOMAIN); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:160px" />
		</p>
        
        <p>                
			<?php _e( 'Display',IT_TEXTDOMAIN); ?>
			<input id="<?php echo $this->get_field_id( 'numarticles' ); ?>" name="<?php echo $this->get_field_name( 'numarticles' ); ?>" value="<?php echo $instance['numarticles']; ?>" style="width:30px" />  
			<?php _e( 'articles in each tab',IT_TEXTDOMAIN); ?>
		</p>
        
        <div style="float:left;margin-right:10px;width:117px;">
		
			<p><?php _e( 'Categories:',IT_TEXTDOMAIN); ?></p>	
                               
            <p style="font-size:12px;font-style:italic;color:#999;"><?php _e( 'Categories are selected in Theme Options >> Page Builder Setup >> Widgets >> "Selected Widget Categories".', IT_TEXTDOMAIN); ?></p>
                          
        </div>
        
        <div style="float:left;width:117px;">
        
        	<p><?php _e( 'Show:',IT_TEXTDOMAIN); ?></p>
        
        	<input class="checkbox" type="checkbox" <?php checked(isset( $instance['thumbnail']) ? $instance['thumbnail'] : 0  ); ?> id="<?php echo $this->get_field_id( 'thumbnail' ); ?>" name="<?php echo $this->get_field_name( 'thumbnail' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'thumbnail' ); ?>"><?php _e( 'Thumbnail',IT_TEXTDOMAIN); ?></label><br />
        
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['rating']) ? $instance['rating'] : 0  ); ?> id="<?php echo $this->get_field_id( 'rating' ); ?>" name="<?php echo $this->get_field_name( 'rating' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'rating' ); ?>"><?php _e( 'Rating',IT_TEXTDOMAIN); ?></label> <br />
        
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['icon']) ? $instance['icon'] : 0  ); ?> id="<?php echo $this->get_field_id( 'icon' ); ?>" name="<?php echo $this->get_field_name( 'icon' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'icon' ); ?>"><?php _e( 'Category Icon',IT_TEXTDOMAIN); ?></label><br />
        
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['award']) ? $instance['award'] : 0  ); ?> id="<?php echo $this->get_field_id( 'award' ); ?>" name="<?php echo $this->get_field_name( 'award' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'award' ); ?>"><?php _e( 'Award',IT_TEXTDOMAIN); ?></label><br />             
		
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['badge']) ? $instance['badge'] : 0  ); ?> id="<?php echo $this->get_field_id( 'badge' ); ?>" name="<?php echo $this->get_field_name( 'badge' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'badge' ); ?>"><?php _e( 'Badges',IT_TEXTDOMAIN); ?></label><br />             
		
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['authorship']) ? $instance['authorship'] : 0  ); ?> id="<?php echo $this->get_field_id( 'authorship' ); ?>" name="<?php echo $this->get_field_name( 'authorship' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'authorship' ); ?>"><?php _e( 'Authorship',IT_TEXTDOMAIN); ?></label><br />             
		
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['excerpt']) ? $instance['excerpt'] : 0  ); ?> id="<?php echo $this->get_field_id( 'excerpt' ); ?>" name="<?php echo $this->get_field_name( 'excerpt' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'excerpt' ); ?>"><?php _e( 'Excerpt',IT_TEXTDOMAIN); ?></label> <br />            
		
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['meta']) ? $instance['meta'] : 0  ); ?> id="<?php echo $this->get_field_id( 'meta' ); ?>" name="<?php echo $this->get_field_name( 'meta' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'meta' ); ?>"><?php _e( 'Meta',IT_TEXTDOMAIN); ?></label>  
        
        </div>
        
        <div style="clear:both;">&nbsp;</div>  
        
        <p style="font-size:10px;font-style:italic;color:#999;"><?php _e('Note: Not all components apply to all layouts.',IT_TEXTDOMAIN); ?></p>	
        
        <p><?php _e( 'Layout:',IT_TEXTDOMAIN); ?></p>	
                 
        <div style="position:relative;border:1px solid #DDD;background:#F7F7F7;height:120px;width:100px;padding:10px 6px 0px 6px;float:left;margin-right:10px;margin-bottom:10px;border-radius:5px;">
            <div style="float:left;margin-top:85px;margin-left:20px;position:absolute;">
            	<input class="radio" type="radio" <?php if($instance['layout']=='widget_a') { ?>checked <?php } ?>name="<?php echo $this->get_field_name( 'layout' ); ?>" value="widget_a" id="<?php echo $this->get_field_id( 'layout' ); ?>_widget_a" />  
            </div>
            <div style="float:left;">
            	<label for="<?php echo $this->get_field_id( 'layout' ); ?>_widget_a"><img src="<?php echo THEME_ADMIN_ASSETS_URI . '/images/post_layout_a.png' ?>" /></label>
            </div>
        </div>
          
        <div style="position:relative;border:1px solid #DDD;background:#F7F7F7;height:120px;width:100px;padding:10px 6px 0px 6px;margin-bottom:10px;margin-right:10px;float:left;border-radius:5px;">
            <div style="float:left;margin-top:85px;margin-left:20px;position:absolute;">
        		<input class="radio" type="radio" <?php if($instance['layout']=='widget_b') { ?>checked <?php } ?>name="<?php echo $this->get_field_name( 'layout' ); ?>" value="widget_b" id="<?php echo $this->get_field_id( 'layout' ); ?>_widget_b" /> 
        	</div>
            <div style="float:left;">               
        		<label for="<?php echo $this->get_field_id( 'layout' ); ?>_widget_b"><img src="<?php echo THEME_ADMIN_ASSETS_URI . '/images/post_layout_b.png' ?>" /></label>  
        	</div>
        </div>
        
        <div style="position:relative;border:1px solid #DDD;background:#F7F7F7;height:120px;width:100px;padding:10px 6px 0px 6px;float:left;margin-right:10px;margin-bottom:10px;border-radius:5px;">
            <div style="float:left;margin-top:85px;margin-left:20px;position:absolute;">
            	<input class="radio" type="radio" <?php if($instance['layout']=='widget_c') { ?>checked <?php } ?>name="<?php echo $this->get_field_name( 'layout' ); ?>" value="widget_c" id="<?php echo $this->get_field_id( 'layout' ); ?>_widget_c" />  
            </div>
            <div style="float:left;">
            	<label for="<?php echo $this->get_field_id( 'layout' ); ?>_widget_c"><img src="<?php echo THEME_ADMIN_ASSETS_URI . '/images/post_layout_c.png' ?>" /></label>
            </div>
        </div>
          
        <div style="position:relative;border:1px solid #DDD;background:#F7F7F7;height:120px;width:100px;padding:10px 6px 0px 6px;margin-bottom:10px;margin-right:10px;float:left;border-radius:5px;">
            <div style="float:left;margin-top:85px;margin-left:20px;position:absolute;">
        		<input class="radio" type="radio" <?php if($instance['layout']=='widget_d') { ?>checked <?php } ?>name="<?php echo $this->get_field_name( 'layout' ); ?>" value="widget_d" id="<?php echo $this->get_field_id( 'layout' ); ?>_widget_d" /> 
        	</div>
            <div style="float:left;">               
        		<label for="<?php echo $this->get_field_id( 'layout' ); ?>_widget_d"><img src="<?php echo THEME_ADMIN_ASSETS_URI . '/images/post_layout_d.png' ?>" /></label>  
        	</div>
        </div>   
        
        <div style="position:relative;border:1px solid #DDD;background:#F7F7F7;height:120px;width:100px;padding:10px 6px 0px 6px;float:left;border-radius:5px;">
            <div style="float:left;margin-top:85px;margin-left:20px;position:absolute;">
            	<input class="radio" type="radio" <?php if($instance['layout']=='widget_e') { ?>checked <?php } ?>name="<?php echo $this->get_field_name( 'layout' ); ?>" value="widget_e" id="<?php echo $this->get_field_id( 'layout' ); ?>_widget_e" />  
            </div>
            <div style="float:left;">
            	<label for="<?php echo $this->get_field_id( 'layout' ); ?>_widget_e"><img src="<?php echo THEME_ADMIN_ASSETS_URI . '/images/post_layout_e.png' ?>" /></label>
            </div>
        </div> 
        
        <div style="clear:both;">&nbsp;</div> 
        
        <p>
        <input class="checkbox" type="checkbox" <?php checked(isset( $instance['first']) ? $instance['first'] : 0  ); ?> id="<?php echo $this->get_field_id( 'first' ); ?>" name="<?php echo $this->get_field_name( 'first' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'first' ); ?>"><?php _e( 'Large First Post (layout D only)',IT_TEXTDOMAIN); ?></label>
        </p>
        
        <p style="font-size:10px;font-style:italic;color:#999;"><?php _e('Tip: Layout E not recommended in widest widget column.',IT_TEXTDOMAIN); ?></p>
		
		<?php
	}
}
?>