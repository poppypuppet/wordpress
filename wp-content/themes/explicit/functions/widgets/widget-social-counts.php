<?php
class it_social_counts extends WP_Widget {
	function it_social_counts() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Social Counts', 'description' => __( 'Displays social counts for the most popular social networks.',IT_TEXTDOMAIN) );
		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'it_social_counts' );
		/* Create the widget. */
		parent::__construct( 'it_social_counts', 'Social Counts', $widget_ops, $control_ops );
	}	
	function widget( $args, $instance ) {

		extract( $args );

		/* User-selected settings. */
	
		$twitter = $instance['twitter'];
		$facebook = $instance['facebook'];
		$gplus = $instance['gplus'];
		$youtube = $instance['youtube'];
		$pinterest = $instance['pinterest'];
		
		#At the time of development the Pinterest API is not yet available
		$pinterest = false;
		    
        #Before widget (defined by themes)
        echo $before_widget;
		        
        #HTML output
		?>
        
        <div class="social-counts">
        
			<?php if($twitter) { ?>
                        
                <div class="social-panel">	
                
                    <span class="theme-icon-twitter"></span>
                    
                    <?php $followers = it_twitter_count(it_get_setting('twitter_username')); ?>
                    
                    <a target="_blank" href="https://twitter.com/<?php echo it_get_setting('twitter_username'); ?>" class="info styled" title="<?php _e('Twitter Followers', IT_TEXTDOMAIN); ?>"><?php echo $followers; ?></a>
                
                </div>
                
            <?php } ?>
            
            <?php if($facebook) { ?>
            
                <div class="social-panel">	
                
                    <span class="theme-icon-facebook"></span>
                    
                    <?php $likes = it_facebook_count(it_get_setting('facebook_url')); ?>
                    
                    <a target="_blank" href="<?php echo it_get_setting('facebook_url'); ?>" class="info styled" title="<?php _e('Facebook Fans', IT_TEXTDOMAIN); ?>"><?php echo $likes; ?></a>
                
                </div>
                
            <?php } ?>
            
            <?php if($gplus) { ?>
            
                <div class="social-panel">	
                
                    <span class="theme-icon-googleplus"></span>
                    
                    <?php $gplus = it_gplus_count(it_get_setting('googleplus_profile_url')); ?>
                    
                    <a target="_blank" href="<?php echo it_get_setting('googleplus_profile_url'); ?>" class="info styled" title="<?php _e("Google+ Followers", IT_TEXTDOMAIN); ?>"><?php echo $gplus; ?></a>
                
                </div>
                
            <?php } ?>
            
            <?php if($pinterest) { ?>
            
                <div class="social-panel">	
                
                    <span class="theme-icon-pinterest"></span>
                    
                    <?php $count = it_pinterest_count(it_get_setting('pinterest_url')); ?>
                    
                    <a target="_blank" href="<?php echo $url; ?>" class="info styled" data-placement="bottom" title="<?php _e("Pinterest Followers", IT_TEXTDOMAIN); ?>"><?php echo $count; ?></a>
                
                </div>
                
            <?php } ?>
                        
        </div>
					
        <?php 		
		wp_reset_query();	
		
		# After widget (defined by themes)
        echo $after_widget; ?>		
		
	<?php
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['twitter'] = isset( $new_instance['twitter'] );
		$instance['facebook'] = isset( $new_instance['facebook'] );
		$instance['gplus'] = isset( $new_instance['gplus'] );		
		$instance['youtube'] = isset( $new_instance['youtube'] );
		$instance['pinterest'] = isset( $new_instance['pinterest'] );

		return $instance;
	}
	function form( $instance ) {	

		/* Set up some default widget settings. */
		$defaults = array( 'twitter' => true, 'facebook' => true, 'gplus' => true, 'youtube' => false, 'pinterest' => false );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['twitter']) ? $instance['twitter'] : 0  ); ?> id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'Display Twitter follower count', IT_TEXTDOMAIN); ?> </label>
		</p>
        
        <p>
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['facebook']) ? $instance['facebook'] : 0  ); ?> id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e( 'Display Facebook fan count', IT_TEXTDOMAIN); ?> </label>
		</p>
        
        <p>
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['gplus']) ? $instance['gplus'] : 0  ); ?> id="<?php echo $this->get_field_id( 'gplus' ); ?>" name="<?php echo $this->get_field_name( 'gplus' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'gplus' ); ?>"><?php _e( 'Display Google +1 count', IT_TEXTDOMAIN); ?> </label>
		</p>
        
        <p>
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['youtube']) ? $instance['youtube'] : 0  ); ?> id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e( 'Display Youtube subscriber count', IT_TEXTDOMAIN); ?> </label>
		</p>
        
        <!--<p>
			<input class="checkbox" type="checkbox" <?php checked(isset( $instance['pinterest']) ? $instance['pinterest'] : 0  ); ?> id="<?php echo $this->get_field_id( 'pinterest' ); ?>" name="<?php echo $this->get_field_name( 'pinterest' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'pinterest' ); ?>"><?php _e( 'Display Pinterest follower count', IT_TEXTDOMAIN); ?> </label>
		</p>-->
		
		<?php
	}
}
?>