<?php
#default settings
$cols=it_get_setting('portholes_cols');
$rows=it_get_setting('portholes_rows');
if(empty($rows)) $rows = 1;
if(empty($cols)) $cols = 6;
$postsperpage = $cols * $rows;
#setup query args
$args = array('posts_per_page' => $postsperpage, 'ignore_sticky_posts' => true);
#limits
$limit_cat = it_get_setting('portholes_limit_cat');
if(!empty($limit_cat)) $args['category__in'] = $limit_cat;
$limit_tag = it_get_setting('portholes_limit_tag');	
if(!empty($limit_tag)) $args['tag__in'] = $limit_tag;	
#excludes
$exclude_cat = it_get_setting('portholes_exclude_cat');
if(!empty($exclude_cat)) $args['category__not_in'] = $exclude_cat;
$exclude_tag = it_get_setting('portholes_exclude_tag');	
if(!empty($exclude_tag)) $args['tag__not_in'] = $exclude_tag;
#setup loop format
$format = array('loop' => 'portholes', 'size' => 'portholes');

?>

<div class="container">

	<div id="portholes" class="row cols-<?php echo $cols; ?>">
    
    	<?php do_action('it_before_portholes', it_get_setting('ad_portholes_before'), 'before-portholes'); ?>
	
		<div class="col-md-12">
		
			<?php $loop = it_loop($args, $format); echo $loop['content']; ?>                
		
		</div>
        
        <?php do_action('it_after_portholes', it_get_setting('ad_portholes_after'), 'after-portholes', true); ?>
		
	</div>
	
</div>