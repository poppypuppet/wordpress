<?php
#default settings
$col1 = __('Widgets Column 1',IT_TEXTDOMAIN);
$col2 = __('Widgets Column 2',IT_TEXTDOMAIN);
$col3 = __('Widgets Column 3',IT_TEXTDOMAIN);
$class = 'widgets';
$widgets_layout = it_get_setting('widgets_layout');
$layout = it_widgets_layout($widgets_layout);
?>
    
<div class="container">
    
    <div class="row" id="widgets">
    
    	<?php do_action('it_before_widgets', it_get_setting('ad_widgets_before'), 'before-widgets'); ?>
    
    	<?php if(!empty($layout['col1'])) { 
		
			$csssize = $layout['col1'] < 6 ? ' narrow' : ''; ?>
        
            <div class="widget-panel left col-md-<?php echo $layout['col1']; ?><?php echo $csssize; ?>">
            
                <?php it_widget_panel($col1, $class); ?>
                
            </div>
        
        <?php } ?>
                    
        <?php if(!empty($layout['col2'])) { 
		
			$csssize = $layout['col2'] < 6 ? ' narrow' : ''; ?>
        
            <div class="widget-panel mid col-md-<?php echo $layout['col2']; ?><?php echo $csssize; ?>">
            
                <?php it_widget_panel($col2, $class); ?>
                
            </div>
        
        <?php } ?>
                    
        <?php if(!empty($layout['col3'])) { 
		
			$csssize = $layout['col3'] < 6 ? ' narrow' : ''; ?>
        
            <div class="widget-panel right col-md-<?php echo $layout['col3']; ?><?php echo $csssize; ?>">
            
                <?php it_widget_panel($col3, $class); ?>
                
            </div>
        
        <?php } ?>
        
        <?php do_action('it_after_widgets', it_get_setting('ad_widgets_after'), 'after-widgets'); ?>
        
    </div>
    
</div>