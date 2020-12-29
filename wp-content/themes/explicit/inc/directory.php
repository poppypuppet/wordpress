<?php
#default settings
$sidebar = __('Loop Sidebar',IT_TEXTDOMAIN);
$count = 0;
$loops = array();
$args = array();
$args_common = array();
$loop = 'main loop';
if(empty($title)) $title = __('LATEST',IT_TEXTDOMAIN);
$sidebar_position = it_get_setting('page_sidebar_position');
$csscol1 = '';
$csscol2 = '';
$csscol3 = '';
$cssinnercol = '';
$cols = 1;
$innercols = 2;
$view = 'grid';

#directory layout options
$categories = get_post_meta($post->ID, "_directory_categories", $single = true);
$type = get_post_meta($post->ID, "_directory_type", $single = true);	
$layout = get_post_meta($post->ID, "_directory_layout", $single = true);
if(empty($layout)) $layout = 'wide';
$style = get_post_meta($post->ID, "_directory_style", $single = true);
if(empty($style)) $style = 'widget_a';
$components = get_post_meta($post->ID, "_directory_components", $single = true);
$disabled_filters = get_post_meta($post->ID, "_directory_filters_disable", $single = true);
$sort = get_post_meta($post->ID, "_directory_sort", $single = true);
$reviews = get_post_meta($post->ID, "_directory_reviews", $single = true);
$postsperpage = get_post_meta($post->ID, "_directory_number", $single = true);
	
#page layout options
$sidebar_position_meta = get_post_meta($post->ID, "_sidebar_position", $single = true);
if(!empty($sidebar_position_meta) && $sidebar_position_meta!='') $sidebar_position = $sidebar_position_meta;
$title_meta = get_post_meta($post->ID, "_subtitle", $single = true);
if(!empty($title_meta) && $title_meta!='') $title = $title_meta;
$sidebar_meta = get_post_meta($post->ID, "_custom_sidebar", $single = true);
if(!empty($sidebar_meta) && $sidebar_meta!='') $sidebar = $sidebar_meta;
$disable_title = get_post_meta($post->ID, IT_META_DISABLE_TITLE, $single = true);

#limit to reviews only
if($reviews) $args['meta_query'] = array(array( 'key' => IT_META_DISABLE_REVIEW, 'value' => 'true', 'compare' => '!=' ));

#override postsperpage
if(!empty($postsperpage)) $args['posts_per_page'] = $postsperpage;

#determine css classes
switch($sidebar_position) {
	case 'sidebar-right':
		$csscol2 = 'col-md-8';
		$csscol3 = 'col-md-4';
		$cssinnercol = $layout=='wide' ? 'col-md-6' : 'col-md-4';
		$innercols = $layout=='wide' ? 2 : 3;
		if($type=='merged') {
			$cssinnercol = 'col-md-12';
			$innercols = 1;
			$cols = $layout=='wide' ? 2 : 3;	
		}
	break;
	case 'sidebar-left':
		$csscol1 = 'col-md-4';
		$csscol2 = 'col-md-8';
		$cssinnercol = $layout=='wide' ? 'col-md-6' : 'col-md-4';
		$innercols = $layout=='wide' ? 2 : 3;		
		if($type=='merged') {
			$cssinnercol = 'col-md-12';
			$innercols = 1;
			$cols = $layout=='wide' ? 2 : 3;	
		}
	break;
	case 'full':
		$csscol2 = 'col-md-12';
		$cssinnercol = $layout=='wide' ? 'col-md-4' : 'col-md-3';
		$innercols = $layout=='wide' ? 3 : 4;
		if($type=='merged') {
			$cssinnercol = 'col-md-12';
			$innercols = 1;
			$cols = $layout=='wide' ? 3 : 4;	
		}
	break;	
}
$csssmall = $layout=='wide' ? '' : ' grid-4';
$csscompact = $style=='widget_e' ? '' : ' compact';
$cssnarrow = $layout=='wide' ? '' : ' narrow';
$cssclass = $style=='widget_e' ? ' post-grid' : ' post-blog';
$csswhite = ' white';
		
#turn options into arrays
$categories = unserialize($categories) ? unserialize($categories) : array();
$disabled_filters = unserialize($disabled_filters) ? unserialize($disabled_filters) : array();
$components = unserialize($components) ? unserialize($components) : array();

#determine components
$thumbnail = in_array('thumbnail',$components) ? true : false;
$rating = in_array('rating',$components) ? true : false;
$meta = in_array('meta',$components) ? true : false;
$award = in_array('award',$components) ? true : false;
$icon = in_array('icon',$components) ? true : false;
$badge = in_array('badge',$components) ? true : false;
$excerpt = in_array('excerpt',$components) ? true : false;
$authorship = in_array('authorship',$components) ? true : false;

$disabled_count = !empty($disabled_filters) ? count($disabled_filters) : 0;
$disable_filters = $disabled_count > 6 ? true : false;

#setup loop format
$format = array('loop' => $loop, 'location' => $style, 'thumbnail' => $thumbnail, 'rating' => $rating, 'meta' => $meta, 'award' => $award, 'icon' => $icon, 'badge' => $badge, 'excerpt' => $excerpt, 'authorship' => $authorship, 'nonajax' => true, 'numarticles' => $postsperpage, 'columns' => $cols, 'view' => $view, 'sort' => $sort, 'size' => 'portholes', 'large_first' => false, 'layout' => '');

#setup sortbar
$sortbarargs = array('loop' => $loop, 'location' => $style, 'title' => $title, 'theme_icon' => '', 'cols' => $cols, 'disabled_filters' => $disabled_filters, 'numarticles' => $postsperpage, 'disable_filters' => $disable_filters, 'disable_title' => $disable_title, 'view' => $view, 'thumbnail' => $thumbnail, 'rating' => $rating, 'meta' => $meta, 'award' => $award, 'badge' => $badge, 'excerpt' => $excerpt, 'authorship' => $authorship, 'icon' => $icon, 'cssclass' => 'light', 'large_first' => false, 'default' => $sort, 'layout' => '');

#don't want any specific sorting added to common args
$args_common = $args;

#setup default sorting (same for all loops on the page)
switch($sort) {
	case 'recent':	
		break;
	case 'title':
		$args['orderby'] = 'title';
		$args['order'] = 'ASC';
		break;
	case 'liked':
		$args['orderby'] = 'meta_value_num';
		$args['meta_key'] = IT_META_TOTAL_LIKES;
		break;
	case 'viewed':
		$args['orderby'] = 'meta_value_num';
		$args['meta_key'] = IT_META_TOTAL_VIEWS;	
		break;
	case 'users':
		$args['orderby'] = 'meta_value_num';
		$args['meta_key'] = IT_META_TOTAL_USER_SCORE_NORMALIZED;
		break;
	case 'reviewed':
		$args['orderby'] = 'meta_value_num';
		$args['meta_key'] = IT_META_TOTAL_SCORE_NORMALIZED;
		break;
	case 'commented':
		$args['orderby'] = 'comment_count';	
		break;
	case 'awarded':
		$args['orderby'] = 'date';
		$args['order'] = 'DESC';
		$meta_query = $args['meta_query'];
		$new_meta_query = array( array( 'key' => IT_META_AWARDS, 'value' => array(''), 'compare' => 'NOT IN') );
		if(!empty($meta_query)) {
			$meta_query = array_merge($meta_query, $new_meta_query);
		} else {
			$meta_query = $new_meta_query;
		}
		$args['meta_query'] = $meta_query;	
		break;
}
			
#setup loop(s)
if($type=='merged') {
	$catid = 0;	
	$args['category__in'] = $categories;
	$args_common['category__in'] = $categories;		
	$format['container'] = 'directory-' . $catid;
	$sortbarargs['container'] = 'directory-' . $catid;		
	$itposts = new WP_Query( $args );
	$numpages = $itposts->max_num_pages;
	$loops[0] = array('args' => $args, 'args_common' => $args_common, 'catid' => $catid, 'sortbarargs' => $sortbarargs, 'format' => $format, 'numpages' => $numpages);		
} else {
	foreach($categories as $catid) {
		$category_icon = it_get_category_icon($catid, $csswhite);
		$name = get_cat_name($catid);
		$args['cat'] = $catid;
		$args_common['cat'] = $catid;
		$format['container'] = 'directory-' . $catid;
		$sortbarargs['container'] = 'directory-' . $catid;	
		$sortbarargs['title'] = $name;
		$sortbarargs['category_icon'] = $category_icon;		
		$itposts = new WP_Query( $args );
		$numpages = $itposts->max_num_pages;		
		$loops[$catid] = array('args' => $args, 'args_common' => $args_common, 'catid' => $catid, 'sortbarargs' => $sortbarargs, 'format' => $format, 'numpages' => $numpages);
	}		
}

?>

<div class="container">
        
    <div class="row">
    
        <?php do_action('it_before_directory', it_get_setting('ad_directory_before'), 'before-directory'); ?>

        <?php if($sidebar_position=='sidebar-left') { ?>
        
            <div class="<?php echo $csscol1; ?>">
        
                <?php echo it_widget_panel($sidebar, $sidebar_position); ?>
                
            </div>
                        
        <?php } ?>
        
        <div id="page-content" class="articles gradient directory <?php echo $style . $csscompact . $cssclass; ?>">
            
            <div class="<?php echo $csscol2 . $cssnarrow . $csssmall; ?>">
            
                <h1 class="main-title"><?php echo get_the_title(); ?></h1>
                        
                <?php echo it_get_content(''); ?>
                
                <div class="row">
            
					<?php foreach($loops as $this_loop) { $count++; ?> 
                    
                        <?php $args_encoded = json_encode($this_loop['args_common']); ?>
                    
                        <div id="directory-<?php echo $this_loop['catid']; ?>" class="<?php echo $cssinnercol; ?> post-container" data-currentquery='<?php echo $args_encoded; ?>'>
                    
                            <?php echo it_get_sortbar($this_loop['sortbarargs']); ?> 
                        
                            <div class="content-inner clearfix">
                            
                                <div class="loading load-sort"><span class="theme-icon-spin2"></span></div>
                                
                                <div class="loop <?php echo $view; ?> row">                            
                                    
                                    <?php $loop = it_loop($this_loop['args'], $this_loop['format']); echo $loop['content']; ?>
                                    
                                </div>            
                        
                                <div class="pagination-wrapper">
                                
                                    <?php echo it_pagination($this_loop['numpages'], $this_loop['format'], it_get_setting('page_range')); ?>
                                    
                                </div>                    
                                
                                <div class="pagination-wrapper mobile">
                                
                                    <?php echo it_pagination($this_loop['numpages'], $this_loop['format'], it_get_setting('page_range_mobile')); ?>
                                    
                                </div>   
                                                     
                            </div>
                            
                        </div>
                        
                        <?php if($count % $innercols == 0) echo '</div><div class="row">'; // start a new row ?>
                    
                    <?php } ?>
                    
                </div>
                    
            </div>  
            
        </div>        
             
		<?php if($sidebar_position=='sidebar-right') { ?>
        
            <div class="<?php echo $csscol3; ?>">
        
                <?php echo it_widget_panel($sidebar, $sidebar_position); ?>
                
            </div>
                        
        <?php } ?>
        
        <?php do_action('it_after_directory', it_get_setting('ad_directory_after'), 'after-directory'); ?>
        
    </div>
    
</div>

<?php wp_reset_query(); ?>