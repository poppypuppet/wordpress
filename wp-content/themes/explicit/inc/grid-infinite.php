<?php
global $wp, $wp_query;
#get the current query to pass it to the ajax functions through the html data tag
if(!is_single() && !is_page()) $current_query = $wp->query_vars;

#default settings
$args = array();
$layout = it_get_setting('infinitegrid_layout');
$rows = it_get_setting('infinitegrid_rows');
$sidebar_unique = it_get_setting('infinitegrid_unique_sidebar');
$title = it_get_setting('infinitegrid_title');
$disable_title = it_get_setting('infinitegrid_title_disable');
$disable_filters = it_get_setting('infinitegrid_filters_disable');
$disable_filterbar = $disable_title && $disable_filters ? true : false;
$disable_loadmore = it_get_setting('infinitegrid_loadmore_disable');
$disable_ads = it_get_setting('infinitegrid_ads_disable');

#determine css classes
switch($layout) {
	case 'a':
		$csslayout = 'sidebar-right';
		$csscol2 = 'col-md-8';
		$csscol3 = 'col-md-4';
		$cols = 2;
	break;
	case 'b':
		$csslayout = 'sidebar-right';
		$csscol2 = 'col-md-9';
		$csscol3 = 'col-md-3';
		$cols = 3;
	break;
	case 'c':
		$csslayout = 'sidebar-left';
		$csscol1 = 'col-md-4';
		$csscol2 = 'col-md-8';
		$cols = 2;
	break;
	case 'd':
		$csslayout = 'sidebar-left';
		$csscol1 = 'col-md-3';
		$csscol2 = 'col-md-9';
		$cols = 3;
	break;	
	case 'e':
		$csslayout = 'full';
		$csscol2 = 'col-md-12';
		$cols = 3;
	break;	
	case 'f':
		$csslayout = 'full';
		$csscol2 = 'col-md-12';
		$cols = 4;
	break;	
}

if(empty($rows)) $rows = 1;
if(empty($cols)) $cols = 4;
if(empty($title)) $title = __('ALL STORIES',IT_TEXTDOMAIN);
$postsperpage = $rows * $cols;
$view = 'grid';
$loop = 'main loop';
$location = '';
$container = 'infinite-grid-container';
$sidebar = $sidebar_unique ? __('Infinite Grid Sidebar',IT_TEXTDOMAIN) : __('Loop Sidebar',IT_TEXTDOMAIN);

#check and see if we care about excludes and limits
if(!(is_archive() || is_search())) $ignore_excludes = false;
if(!$ignore_excludes) {
	#limits
	$limit_cat = it_get_setting('infinitegrid_limit_cat');
	if(!empty($limit_cat)) $current_query['category__in'] = $limit_cat;
	$limit_tag = it_get_setting('infinitegrid_limit_tag');	
	if(!empty($limit_tag)) $current_query['tag__in'] = $limit_tag;	
	#excludes
	$exclude_cat = it_get_setting('infinitegrid_exclude_cat');
	if(!empty($exclude_cat)) $current_query['category__not_in'] = $exclude_cat;
	$exclude_tag = it_get_setting('infinitegrid_exclude_tag');	
	if(!empty($exclude_tag)) $current_query['tag__not_in'] = $exclude_tag;
}

#query args
$args = array('posts_per_page' => $postsperpage, 'ignore_sticky_posts' => true);

#setup loop format
$format = array('loop' => $loop, 'location' => $location, 'view' => $view, 'sort' => 'recent', 'columns' => $cols, 'paged' => 1, 'container' => $container, 'thumbnail' => true, 'rating' => true, 'icon' => true, 'nonajax' => true, 'meta' => true, 'icon' => true, 'award' => true, 'badge' => true, 'excerpt' => true, 'authorship' => true, 'numarticles' => $postsperpage, 'disable_ads' => $disable_ads, 'layout' => $csslayout, 'large_first' => false);

if(!is_single() && !is_page()) $args = array_merge($args, $current_query);

#setup sortbar
$disabled = ( is_array( it_get_setting("loop_filter_disable") ) ) ? it_get_setting("loop_filter_disable") : array();

$sortbarargs = array('title' => $title, 'loop' => $loop, 'location' => $location, 'container' => $container, 'view' => $view, 'cols' => $cols, 'disabled' => $disabled, 'numarticles' => $postsperpage, 'disable_filters' => $disable_filters, 'disable_title' => $disable_title, 'thumbnail' => true, 'rating' => true, 'meta' => true, 'layout' => $csslayout, 'cssclass' => 'light', 'icon' => true, 'award' => true, 'badge' => true, 'excerpt' => true, 'authorship' => true, 'large_first' => false);

$args = it_search_args($args);
$current_query = it_search_args($current_query);

#get correct page number count
$itposts = new WP_Query($args);
$numpages = $itposts->max_num_pages;
wp_reset_postdata();

#setup load more button
$loadmoreargs = $format;
$loadmoreargs['numpages'] = $numpages;

?>

<?php $current_query_encoded = json_encode($current_query); ?>

<div class="container">
        
    <div class="row">
    
        <?php do_action('it_before_infinitegrid', it_get_setting('ad_infinitegrid_before'), 'before-infinitegrid'); ?>
    
        <?php if($csslayout=='sidebar-left') { ?>
        
            <div class="<?php echo $csscol1; ?>">
        
                <?php it_widget_panel($sidebar, $csslayout); ?>
                
            </div>
                        
        <?php } ?>
            
        <div id="infinite-grid" class="articles gradient post-grid">
    
            <div id="infinite-grid-container" class="<?php echo $csscol2; ?>" data-currentquery='<?php echo $current_query_encoded; ?>'>
            
            	<?php echo it_archive_title(); ?>
            
            	<?php echo it_get_sortbar($sortbarargs); ?>
                
                <div class="content-inner">
                
                	<div class="loading load-sort"><span class="theme-icon-spin2"></span></div>
                
                    <div class="loop grid row">
                    
                        <?php $loop = it_loop($args, $format); echo $loop['content']; ?>
                        
                    </div>
                    
                    <div class="loading load-infinite"><span class="theme-icon-spin2"></span></div>
                    
                </div>
                
                <?php if(!$disable_loadmore) echo it_get_loadmore($loadmoreargs); ?>
                
                <div class="last-page"><?php _e('End of the line!',IT_TEXTDOMAIN); ?></div>
            
            </div>
            
        </div>
            
		<?php if($csslayout=='sidebar-right') { ?>
        
            <div class="<?php echo $csscol3; ?>">
        
                <?php it_widget_panel($sidebar, $csslayout); ?>
                
            </div>
                        
        <?php } ?>
        
        <?php do_action('it_after_infinitegrid', it_get_setting('ad_infinitegrid_after'), 'after-infinitegrid', true); ?>
        
    </div>
    
</div>

<?php wp_reset_query(); ?>