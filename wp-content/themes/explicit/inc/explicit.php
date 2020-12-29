<?php
#set variables from theme options
$label_disable = it_get_setting('explicit_label_disable');
$label = it_get_setting('explicit_label');
if(empty($label)) $label = __('EXPLICIT CONTENT', IT_TEXTDOMAIN);
$explicit_rating_disable = it_get_setting('explicit_rating_disable');
$explicit_title_disable = it_get_setting('explicit_title_disable');

#setup query args
$args = array('posts_per_page' => it_get_setting('explicit_number'));

#limits
$limit_cat = it_get_setting('explicit_limit_cat');
if(!empty($limit_cat)) $args['category__in'] = $limit_cat;
$limit_tag = it_get_setting('explicit_limit_tag');	
if(!empty($limit_tag)) $args['tag__in'] = $limit_tag;	
#excludes
$exclude_cat = it_get_setting('explicit_exclude_cat');
if(!empty($exclude_cat)) $args['category__not_in'] = $exclude_cat;
$exclude_tag = it_get_setting('explicit_exclude_tag');	
if(!empty($exclude_tag)) $args['tag__not_in'] = $exclude_tag;

#setup loop format
$format = array('loop' => 'explicit', 'title' => !$explicit_title_disable, 'rating' => !$explicit_rating_disable, 'size' => 'tall');

?>

<div id="explicit-wrapper">

    <div class="container">
        
        <div class="row" id="explicit">
        
        	<?php do_action('it_before_explicit', it_get_setting('ad_explicit_before'), 'before-explicit'); ?>
        
            <div class="col-md-12">
            
            	<?php if(!$label_disable) { ?><div class="explicit-label bar-label bar-label-lg bar-label-dark"><div class="label-text"><?php echo $label; ?></div></div><?php } ?>
            
                <div class="explicit-content">
                
                    <?php $loop = it_loop($args, $format); echo $loop['content']; ?>
                
                </div>
                
            </div>
            
            <?php do_action('it_after_explicit', it_get_setting('ad_explicit_after'), 'after-explicit'); ?>
            
        </div>
        
    </div>

</div>

<?php wp_reset_query(); ?>