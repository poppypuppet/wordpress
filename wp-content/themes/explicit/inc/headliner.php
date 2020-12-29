<?php
#set variables from theme options
$label_disable = it_get_setting('headliner_label_disable');
$label = it_get_setting('headliner_label');
if(empty($label)) $label = __('EXCLUSIVE!', IT_TEXTDOMAIN);
$headliner_category=it_get_setting('headliner_category');
$headliner_tag=it_get_setting('headliner_tag');
$authorship_disable=it_get_setting('headliner_authorship_disable');
$category_disable=it_get_setting('headliner_category_disable');

#setup wp_query args
$args = array('posts_per_page' => 1, 'ignore_sticky_posts' => true);
#setup loop format
$format = array('loop' => 'headliner', 'size' => 'hero', 'authorship' => !$authorship_disable, 'category' => !$category_disable);

if(!empty($headliner_category)) {
	#add category to query args
	$args['cat'] = $headliner_category;	
} else {	
	#add tag to query args
	$args['tag_id'] = $headliner_tag;	
}
?>

<div class="container">
    
    <div class="row" id="headliner">
    
    	<?php do_action('it_before_headliner', it_get_setting('ad_headliner_before'), 'before-headliner'); ?>
    
        <div class="col-md-12">
        
            <div class="headliner-wrapper">
            	
                <?php if(!$label_disable) { ?><div class="headliner-label bar-label bar-label-lg bar-label-dark"><div class="label-text"><?php echo $label; ?></div></div><?php } ?>
                                
                <?php $loop = it_loop($args, $format); echo $loop['content']; ?>
                
            </div>
            
        </div>
        
        <?php do_action('it_after_headliner', it_get_setting('ad_headliner_after'), 'after-headliner'); ?>
    
    </div>
    
</div>

<?php wp_reset_query(); ?>