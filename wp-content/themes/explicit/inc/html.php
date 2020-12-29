<?php                         
$content = it_get_setting('html_content');
?>

<div class="container">
    
    <div class="row">
    
    	<?php do_action('it_before_html', it_get_setting('ad_html_before'), 'before-html'); ?>
            
        <div class="col-md-12"> 
                    
            <div id="html_content">  
            
            	<?php echo do_shortcode(stripslashes($content)); ?>                 
               
            </div>
            
        </div>
        
        <?php do_action('it_after_html', it_get_setting('ad_html_after'), 'after-html'); ?>
        
    </div>
    
</div>