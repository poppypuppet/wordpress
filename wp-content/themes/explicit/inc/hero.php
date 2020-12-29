<?php
#set variables from theme options
$circles_disable=it_get_setting('hero_circles_disable');
$category_disable=it_get_setting('hero_category_disable');
$award_disable=it_get_setting('hero_award_disable');
$rating_disable=it_get_setting('hero_rating_disable');
$meta_disable=it_get_setting('hero_meta_disable');
$authorship_disable=it_get_setting('hero_authorship_disable');
$title_disable=it_get_setting('hero_title_disable');
$video_disable=it_get_setting('hero_video_disable');
$label_disable=it_get_setting('hero_label_disable');
$label = it_get_setting('hero_label');
if(empty($label)) $label = __('FEATURED',IT_TEXTDOMAIN); 
$postsperpage = it_get_setting('hero_number');
if(empty($postsperpage)) $postsperpage = 8;

$csslabel = $label_disable ? ' no-label' : '';
$csscolumn = '';

#layout variables
$size='hero';
$width=723;
$height=500;
#if all "column" components are disabled, change width and size
if($category_disable && $award_disable && $rating_disable && $meta_disable && $authorship_disable) {
	$size='hero-wide';
	$width=837;
	$height=500;
	$csscolumn = ' no-column';	
}

#setup query args
$args = array('posts_per_page' => $postsperpage, 'ignore_sticky_posts' => true);

#limits
$limit_cat = it_get_setting('hero_limit_cat');
if(!empty($limit_cat)) $args['category__in'] = $limit_cat;
$limit_tag = it_get_setting('hero_limit_tag');	
if(!empty($limit_tag)) $args['tag__in'] = $limit_tag;	
#excludes
$exclude_cat = it_get_setting('hero_exclude_cat');
if(!empty($exclude_cat)) $args['category__not_in'] = $exclude_cat;
$exclude_tag = it_get_setting('hero_exclude_tag');	
if(!empty($exclude_tag)) $args['tag__not_in'] = $exclude_tag;

#setup loop format
$format = array('loop' => 'hero', 'size' => $size, 'width' => $width, 'height' => $height, 'rating' => !$rating_disable, 'award' => !$award_disable, 'meta' => !$meta_disable, 'authorship' => !$authorship_disable, 'category' => !$category_disable, 'video_disable' => $video_disable, 'title' => !$title_disable, 'circles' => !$circles_disable);

?>

<div class="container">
	
	<div class="row" id="hero">
    
    	<?php do_action('it_before_hero', it_get_setting('ad_hero_before'), 'before-hero'); ?>
	
		<div class="col-md-12">
		
			<div class="ms-tabs-template ms-tabs-vertical-template">
							
				<div class="master-slider ms-skin-default<?php echo $csslabel . $csscolumn; ?>" id="masterslider">
				
					<?php if(!$label_disable) { ?><div class="hero-label bar-label bar-label-lg bar-label-dark"><div class="label-text"><?php echo $label; ?></div></div><?php } ?>
				
					<?php $loop = it_loop($args, $format); echo $loop['content']; ?>          
						
				</div>
			
			</div>
			
		</div>
        
        <?php do_action('it_after_hero', it_get_setting('ad_hero_after'), 'after-hero'); ?>
	
	</div>
	
</div>