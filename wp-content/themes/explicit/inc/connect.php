<?php
#set variables from theme options
$label = it_get_setting('connect_label');
if(empty($label)) $label = __('SOCIALIZE!', IT_TEXTDOMAIN);

?>

<div class="container">
    
    <div class="row" id="connect">
    
    	<?php do_action('it_before_connect', it_get_setting('ad_connect_before'), 'before-connect'); ?>
    
        <div class="col-md-12">
        
        	<div class="menu-container bar-header full-width clearfix">                  
                
                <div class="bar-label-wrapper">
            
                    <div class="bar-label light has-icon">
                
                        <div class="label-text"><span class="theme-icon-thumbs-up"></span><?php echo $label; ?></div>
                        
                    </div>
                    
                </div> 
                
                <?php if(!it_get_setting('connect_email_disable')) { ?>
                        
                    <?php echo it_email_form(); ?>
                    
                <?php } ?>
                
                <?php if(!it_get_setting('connect_counts_disable')) { ?>
                
                    <div class="connect-counts">
                        
                        <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('connect-widgets')) : else : ?>
                                                                
                            <div class="social-counts">
                            	<div class="social-panel info" title="<?php _e('You need to add a widget to the Connect Widgets widget panel (Social Counts recommended)',IT_TEXTDOMAIN); ?>">                             	
                                    <a href="#"><span class="theme-icon-help-circled"></span><?php _e('CONNECT WIDGETS', IT_TEXTDOMAIN); ?></a>
                                </div>
                            </div>
                        
                        <?php endif; ?>
                    
                    </div>
                    
                <?php } ?>
                
                <?php if(!it_get_setting('connect_social_disable')) { ?>
                
                    <div class="connect-social">
                        
                        <?php echo it_social_badges('top'); ?>
                    
                    </div>
                    
                <?php } ?>
                
            </div>
            
        </div>
        
        <?php do_action('it_after_connect', it_get_setting('ad_connect_after'), 'after-connect'); ?>
    
    </div>
    
</div>