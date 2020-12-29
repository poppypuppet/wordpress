<?php                         
$nav_label = it_get_setting('sub_menu_label');
$nav_label = ( !empty( $nav_label ) ) ? $nav_label : __('NAV', IT_TEXTDOMAIN);
?>

<div class="container">
    
    <div class="row">
    
    	<?php do_action('it_before_utility', it_get_setting('ad_utility_before'), 'before-utility'); ?>
            
        <div class="col-md-12"> 
                    
            <div id="utility-menu" class="menu-container bar-header full-width">  
                
                <div id="utility-menu-full"> 
                
                    <div class="bar-label-wrapper">
                
                        <div class="bar-label">
                    
                            <div class="label-text"><?php echo $nav_label; ?><span class="theme-icon-right-fat"></span></div>
                            
                        </div>
                        
                        <div class="home-button"><a href="<?php echo home_url(); ?>/"><span class="theme-icon-home"></span></a></div>
                        
                    </div>
                
                    <?php 
                    #get the utility menu, stripping out title attributes
                    $menu = preg_replace('/title=\"(.*?)\"/','',wp_nav_menu( array( 'theme_location' => 'utility-menu', 'container' => false, 'fallback_cb' => false, 'echo' => false ) ) );
                    echo '<div class="standard-menu">' . $menu . '</div>';
                    ?>  
                    
                    <br class="clearer" />                            
                
                </div>
                    
                <div id="utility-menu-compact">
                
                    <div class="bar-label-wrapper">
                
                        <div class="bar-label">
                        
                        	<ul>
                        
                                <li>
                        
                                    <a id="utility-menu-selector" class="label-text">
                                    
                                        <span class="theme-icon-list"></span>
                                        
                                        <?php echo $nav_label; ?>
                                        
                                        <span class="theme-icon-down-fat"></span>
                                        
                                    </a>
                                    
                                    <?php echo $menu; ?>
                                
                                </li>
                            
                        	</ul>
                            
                        </div>
                        
                        <div class="home-button"><a href="<?php echo home_url(); ?>/"><span class="theme-icon-home"></span></a></div>
                        
                    </div>
        
                </div>  
                
            </div>
            
        </div>
        
        <?php do_action('it_after_utility', it_get_setting('ad_utility_after'), 'after-utility'); ?>
        
    </div>
    
</div>