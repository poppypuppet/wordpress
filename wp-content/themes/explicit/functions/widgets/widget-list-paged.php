<?php
class it_list_paged extends WP_Widget {
	function it_list_paged() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Paged Blog', 'description' => __( 'Displays paginated articles with several available filtering options.',IT_TEXTDOMAIN) );
		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'it_list_paged' );
		/* Create the widget. */
		parent::__construct( 'it_list_paged', 'Paged Blog', $widget_ops, $control_ops );
	}	
	function widget( $args, $instance ) {
		
		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );	
		$selected_category = $instance['category'];
		$selected_tag = $instance['tag'];
		$disable_recent = $instance['disable_recent'];
		$disable_liked = $instance['disable_liked'];
		$disable_viewed = $instance['disable_viewed'];
		$disable_reviewed = $instance['disable_reviewed'];
		$disable_rated = $instance['disable_rated'];
		$disable_commented = $instance['disable_commented'];
		$disable_awarded = $instance['disable_awarded'];
		$disable_alphabetical = $instance['disable_alphabetical'];
		$disable_filters = $instance['disable_filters'];
		$numarticles = $instance['numarticles'];
		$thumbnail = $instance['thumbnail'];
		$rating = $instance['rating'];
		$icon = $instance['icon'];
		$award = $instance['award'];
		$meta = $instance['meta'];
		$badge = $instance['badge'];
		$authorship = $instance['authorship'];
		$excerpt = $instance['excerpt'];
		$sticky = $instance['sticky'];
		$layout = $instance['layout'];
		$first = $instance['first'];
		
		#create semantic variables		
		$disable_title = empty($title) ? true : false;
		$disable_recent = ( $disable_recent ) ? 'recent' : '';
		$disable_liked = ( $disable_liked ) ? 'liked' : '';
		$disable_viewed = ( $disable_viewed ) ? 'viewed' : '';
		$disable_reviewed = ( $disable_reviewed ) ? 'reviewed' : '';
		$disable_rated = ( $disable_rated ) ? 'rated' : '';
		$disable_commented = ( $disable_commented ) ? 'commented' : '';
		$disable_awarded = ( $disable_awarded ) ? 'awarded' : '';
		$disable_alphabetical = ( $disable_alphabetical ) ? 'title' : '';
		
		#clear out unselected values
		if($selected_category=='All Categories') $selected_category = '';		
		if($selected_tag=='All Tags') $selected_tag = '';	
		
		#setup the query            
        $args=array('posts_per_page' => $numarticles, 'order' => 'DESC', 'cat' => $selected_category, 'tag_id' => $selected_tag);
		
		#include sticky posts
		if(!$sticky) $args['ignore_sticky_posts'] = true;
		
		$csscompact = $layout=='widget_e' ? '' : ' compact';
		$cssclass = $layout=='widget_e' ? ' post-grid' : ' post-blog';
		
		#setup loop format
		$format = array('loop' => 'main loop', 'location' => $layout, 'thumbnail' => $thumbnail, 'rating' => $rating, 'meta' => $meta, 'award' => $award, 'icon' => $icon, 'badge' => $badge, 'excerpt' => $excerpt, 'authorship' => $authorship, 'nonajax' => true, 'numarticles' => $numarticles, 'columns' => 1, 'view' => 'list', 'sort' => 'recent', 'large_first' => $first, 'size' => 'portholes', 'layout' => '');	
		
		$disabled_filters = array($disable_recent, $disable_liked, $disable_viewed, $disable_reviewed, $disable_rated, $disable_commented, $disable_awarded, $disable_alphabetical);
		
		#adjust args for default filter
		$setup_filters = it_setup_filters($disabled_filters, $args, $format);
		$default_metric = $setup_filters['default_metric'];
		$default_label = $setup_filters['default_label'];
		$args = $setup_filters['args'];
		$format = $setup_filters['format'];
		
		$sortbarargs = array('title' => $title, 'loop' => 'main loop', 'location' => $layout, 'cols' => 1, 'class' => '', 'disabled_filters' => $disabled_filters, 'numarticles' => $numarticles, 'disable_filters' => $disable_filters, 'disable_title' => $disable_title, 'view' => 'list', 'thumbnail' => $thumbnail, 'rating' => $rating, 'meta' => $meta, 'award' => $award, 'badge' => $badge, 'excerpt' => $excerpt, 'authorship' => $authorship, 'icon' => $icon, 'cssclass' => 'light', 'large_first' => $first, 'layout' => '');		
					
		#encode current query for ajax purposes
		$current_query = array();
		if(!empty($selected_category)) $current_query['category__in'] = array($selected_category);
		if(!empty($selected_tag)) $current_query['tag__in'] = array($selected_tag);
		$current_query_encoded = json_encode($current_query);
		
		#get correct page number count
		$itposts = new WP_Query($args);
		$numpages = $itposts->max_num_pages;
		wp_reset_postdata();
		
		#fetch the loop
		$loop = it_loop($args, $format); 
		    
        #Before widget (defined by themes)
        echo $before_widget;
		
		echo "<div id='widgets-list' class='post-container articles gradient" . $cssclass . $csscompact . " " . $layout . "' data-currentquery='" . $current_query_encoded . "'>";

			#display the sortbar
			if(!($disable_filters && $disable_title)) echo it_get_sortbar($sortbarargs);
			
			echo '<div class="content-inner">';
			
				echo '<div class="loading load-sort"><span class="theme-icon-spin2"></span></div>';	
				
				echo '<div class="loop list row">';
					
					echo $loop['content'];
					
				echo '</div>';
				
			echo '</div>';
						
			echo '<div class="pagination-wrapper">';
			
				echo it_pagination($numpages, $format, it_get_setting('page_range'));
				
			echo '</div>';
			
			echo '<div class="pagination-wrapper mobile">';
			
				echo it_pagination($numpages, $format, it_get_setting('page_range_mobile'));
				
			echo '</div>';
			
		echo '</div>';
		
		wp_reset_query();			
        
		# After widget (defined by themes)
        echo $after_widget; ?>		
		
	<?php
	}
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['category'] = strip_tags( $new_instance['category'] );
		$instance['tag'] = strip_tags( $new_instance['tag'] );
		$instance['disable_recent'] = isset( $new_instance['disable_recent'] );
		$instance['disable_liked'] = isset( $new_instance['disable_liked'] );
		$instance['disable_viewed'] = isset( $new_instance['disable_viewed'] );
		$instance['disable_reviewed'] = isset( $new_instance['disable_reviewed'] );
		$instance['disable_rated'] = isset( $new_instance['disable_rated'] );
		$instance['disable_commented'] = isset( $new_instance['disable_commented'] );
		$instance['disable_awarded'] = isset( $new_instance['disable_awarded'] );
		$instance['disable_alphabetical'] = isset( $new_instance['disable_alphabetical'] );	
		$instance['disable_filters'] = isset( $new_instance['disable_filters'] );	
		$instance['numarticles'] = strip_tags( $new_instance['numarticles'] );		
		$instance['thumbnail'] = isset( $new_instance['thumbnail'] );
		$instance['rating'] = isset( $new_instance['rating'] );
		$instance['icon'] = isset( $new_instance['icon'] );	
		$instance['award'] = isset( $new_instance['award'] );	
		$instance['meta'] = isset( $new_instance['meta'] );	
		$instance['badge'] = isset( $new_instance['badge'] );	
		$instance['authorship'] = isset( $new_instance['authorship'] );	
		$instance['excerpt'] = isset( $new_instance['excerpt'] );
		$instance['sticky'] = isset( $new_instance['sticky'] );	
		$instance['layout'] = strip_tags( $new_instance['layout'] );
		$instance['first'] = isset( $new_instance['first'] );		
		
		return $instance;
		
	}
	function form( $instance ) {	

		#set up some default widget settings.
		$defaults = array( 'title' => __('MOST RECENT', IT_TEXTDOMAIN), 'disable_recent' => false, 'category' => 'All Categories', 'tag' => 'All Tags', 'disable_liked' => false, 'disable_viewed' => false, 'disable_reviewed' => false, 'disable_rated' => false, 'disable_commented' => false, 'disable_awarded' => false, 'disable_alphabetical' => false, 'numarticles' => 4, 'thumbnail' => true, 'rating' => true, 'icon' => true, 'badge' => true, 'authorship' => true, 'excerpt' => true, 'sticky' => false, 'award' => true, 'meta' => true, 'layout' => 'widget_a', 'first' => false );		
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>	
        
        <p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:',IT_TEXTDOMAIN); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:160px" />
		</p>
        
        <p>
			<?php _e( 'Category:',IT_TEXTDOMAIN); ?>
			<select name="<?php echo $this->get_field_name( 'category' ); ?>">
				<option<?php if($instance['category']=='All Categories') { ?> selected<?php } ?> value="All Categories"><?php _e( 'All Categories', IT_TEXTDOMAIN ); ?></option>
				<?php 
				$catargs = array('orderby' => 'name', 'order' => 'ASC', 'hide_empty' => 0);
				$categories = get_categories($catargs);
				foreach($categories as $category){ ?>
                	<option<?php if($instance['category']==$category->term_id) { ?> selected<?php } ?> value="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></option>
				<?php } ?>
			</select>
		</p>
        
         <p>
			<?php _e( 'Tag:',IT_TEXTDOMAIN); ?>
			<select name="<?php echo $this->get_field_name( 'tag' ); ?>">
				<option<?php if($instance['tag']=='All Tags') { ?> selected<?php } ?> value="All Tags"><?php _e( 'All Tags', IT_TEXTDOMAIN ); ?></option>
				<?php 
				$tagargs = array('orderby' => 'name', 'order' => 'ASC', 'hide_empty' => 0);
				$tags = get_tags($tagargs);
				foreach($tags as $tag){ ?>
                	<option<?php if($instance['tag']==$tag->term_id) { ?> selected<?php } ?> value="<?php echo $tag->term_id; ?>"><?php echo $tag->name; ?></option>
				<?php } ?>
			</select>
		</p>
        
        <p>
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['sticky']) ? $instance['sticky'] : 0  ); ?> id="<?php echo $this->get_field_id( 'sticky' ); ?>" name="<?php echo $this->get_field_name( 'sticky' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'sticky' ); ?>"><?php _e( '"Sticky Post" Aware',IT_TEXTDOMAIN); ?></label>             
		</p>
        
        <p>                
			<?php _e( 'Display',IT_TEXTDOMAIN); ?>
			<input id="<?php echo $this->get_field_id( 'numarticles' ); ?>" name="<?php echo $this->get_field_name( 'numarticles' ); ?>" value="<?php echo $instance['numarticles']; ?>" style="width:30px" />  
			<?php _e( 'articles per page',IT_TEXTDOMAIN); ?>
		</p>
        
        <div style="float:left;margin-right:10px;width:117px;">
		
			<p><?php _e( 'Disable Filters:',IT_TEXTDOMAIN); ?></p>	
                               
            <input class="checkbox" type="checkbox" <?php checked(isset( $instance['disable_recent']) ? $instance['disable_recent'] : 0  ); ?> name="<?php echo $this->get_field_name('disable_recent'); ?>" id="<?php echo $this->get_field_id('disable_recent'); ?>" />
            <label for="<?php echo $this->get_field_id('disable_recent'); ?>"><?php _e('Recent',IT_TEXTDOMAIN); ?></label><br />
                          
            <input class="checkbox" type="checkbox" <?php checked(isset( $instance['disable_liked']) ? $instance['disable_liked'] : 0  ); ?> name="<?php echo $this->get_field_name('disable_liked'); ?>" id="<?php echo $this->get_field_id('disable_liked'); ?>" />
            <label for="<?php echo $this->get_field_id('disable_liked'); ?>"><?php _e('Liked',IT_TEXTDOMAIN); ?></label><br />
                          
            <input class="checkbox" type="checkbox" <?php checked(isset( $instance['disable_viewed']) ? $instance['disable_viewed'] : 0  ); ?> name="<?php echo $this->get_field_name('disable_viewed'); ?>" id="<?php echo $this->get_field_id('disable_viewed'); ?>" />
            <label for="<?php echo $this->get_field_id('disable_viewed'); ?>"><?php _e('Viewed',IT_TEXTDOMAIN); ?></label><br />
                          
            <input class="checkbox" type="checkbox" <?php checked(isset( $instance['disable_reviewed']) ? $instance['disable_reviewed'] : 0  ); ?> name="<?php echo $this->get_field_name('disable_reviewed'); ?>" id="<?php echo $this->get_field_id('disable_reviewed'); ?>" />
            <label for="<?php echo $this->get_field_id('disable_reviewed'); ?>"><?php _e('Reviewed',IT_TEXTDOMAIN); ?></label><br />
                           
            <input class="checkbox" type="checkbox" <?php checked(isset( $instance['disable_rated']) ? $instance['disable_rated'] : 0  ); ?> name="<?php echo $this->get_field_name('disable_rated'); ?>" id="<?php echo $this->get_field_id('disable_rated'); ?>" />
            <label for="<?php echo $this->get_field_id('disable_rated'); ?>"><?php _e('Rated',IT_TEXTDOMAIN); ?></label><br />
                           
            <input class="checkbox" type="checkbox" <?php checked(isset( $instance['disable_commented']) ? $instance['disable_commented'] : 0  ); ?> name="<?php echo $this->get_field_name('disable_commented'); ?>" id="<?php echo $this->get_field_id('disable_commented'); ?>" />
            <label for="<?php echo $this->get_field_id('disable_commented'); ?>"><?php _e('Commented',IT_TEXTDOMAIN); ?></label><br />
                           
            <input class="checkbox" type="checkbox" <?php checked(isset( $instance['disable_awarded']) ? $instance['disable_awarded'] : 0  ); ?> name="<?php echo $this->get_field_name('disable_awarded'); ?>" id="<?php echo $this->get_field_id('disable_awarded'); ?>" />
            <label for="<?php echo $this->get_field_id('disable_awarded'); ?>"><?php _e('Awarded',IT_TEXTDOMAIN); ?></label><br />
            
            <input class="checkbox" type="checkbox" <?php checked(isset( $instance['disable_alphabetical']) ? $instance['disable_alphabetical'] : 0  ); ?> name="<?php echo $this->get_field_name('disable_alphabetical'); ?>" id="<?php echo $this->get_field_id('disable_alphabetical'); ?>" />
            <label for="<?php echo $this->get_field_id('disable_alphabetical'); ?>"><?php _e('Alphabetical',IT_TEXTDOMAIN); ?></label>
                          
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
        
        <input class="checkbox" type="checkbox" <?php checked(isset( $instance['disable_filters']) ? $instance['disable_filters'] : 0  ); ?> id="<?php echo $this->get_field_id( 'disable_filters' ); ?>" name="<?php echo $this->get_field_name( 'disable_filters' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'disable_filters' ); ?>"><?php _e( 'Completely Disable Filtering',IT_TEXTDOMAIN); ?></label>
        
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