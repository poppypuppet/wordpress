<?php
$loop = 'top ten';
$location = 'trending slider';
$container = 'top-ten';
$numarticles = 10;

#set variables from theme options
$topten_timeperiod = it_get_setting('topten_timeperiod');
$timeperiod_label = it_timeperiod_label($topten_timeperiod);
if(empty($timeperiod_label)) $timeperiod_label = __('THIS MONTH', IT_TEXTDOMAIN);
$sublabel = it_get_setting('topten_sublabel');
$timeperiod_label = ( !empty( $sublabel ) ) ? $sublabel : $timeperiod_label;
$topten_label = it_get_setting("topten_label");
$topten_label = ( !empty( $topten_label ) ) ? $topten_label : __('TOP TEN', IT_TEXTDOMAIN);

#setup wp_query args
$args = array('posts_per_page' => $numarticles, 'order' => 'DESC', 'ignore_sticky_posts' => true);

#limits
$limit_cat = it_get_setting('topten_limit_cat');
if(!empty($limit_cat)) $args['category__in'] = $limit_cat;
$limit_tag = it_get_setting('topten_limit_tag');	
if(!empty($limit_tag)) $args['tag__in'] = $limit_tag;	
#excludes
$exclude_cat = it_get_setting('topten_exclude_cat');
if(!empty($exclude_cat)) $args['category__not_in'] = $exclude_cat;
$exclude_tag = it_get_setting('topten_exclude_tag');	
if(!empty($exclude_tag)) $args['tag__not_in'] = $exclude_tag;

#setup loop format
$format = array('loop' => $loop);

#get array of disabled filters
$disabled = ( is_array( it_get_setting("topten_disable_filter") ) ) ? it_get_setting("topten_disable_filter") : array();
$disabled[] = 'recent';
$disabled[] = 'awarded';
$disabled[] = 'title';

#adjust args for default filter
$setup_filters = it_setup_filters($disabled, $args, $format);
$default_metric = $setup_filters['default_metric'];
$default_label = $setup_filters['default_label'];
$args = $setup_filters['args'];
$format = $setup_filters['format'];

#setup sortbar args
$sortbarargs = array('title' => $title, 'loop' => $loop, 'location' => $location, 'container' => $container, 'view' => '', 'cols' => '', 'disabled' => $disabled, 'numarticles' => $numarticles, 'disable_filters' => false, 'disable_title' => true, 'thumbnail' => true, 'rating' => false, 'meta' => false, 'layout' => '', 'cssclass' => 'dark', 'timeperiod' => $topten_timeperiod);

$week = date('W');
$month = date('n');
$year = date('Y');
switch($topten_timeperiod) {
	case 'This Week':
		$args['year'] = $year;
		$args['w'] = $week;
		$topten_timeperiod='';
	break;	
	case 'This Month':
		$args['monthnum'] = $month;
		$args['year'] = $year;
		$topten_timeperiod='';
	break;
	case 'This Year':
		$args['year'] = $year;
		$topten_timeperiod='';
	break;
	case 'all':
		$topten_timeperiod='';
	break;			
}
?>

<div id="top-ten-wrapper">

    <div class="container">
        
        <div class="row" id="top-ten">
        
        	<?php do_action('it_before_topten', it_get_setting('ad_topten_before'), 'before-topten'); ?>
        
            <div class="col-md-12">
            
            	<div class="top-ten-header">
                
                    <div class="top-ten-label bar-label bar-label-lg bar-label-dark">
               
                        <div class="theme-icon-up"></div>
                        <div class="theme-icon-down"></div>
                        
                        <div class="label-text"><?php echo $topten_label; ?>&nbsp;<?php echo $timeperiod_label; ?></div>
                        
                    </div>      
                        
                    <?php echo it_get_sortbar($sortbarargs); ?>
                    
                </div>
                   
                <div class="loading load-sort"><span class="theme-icon-spin2"></span></div>
                
                <div class="top-ten-content loop">  
                
                    <?php $loop = it_loop($args, $format, $topten_timeperiod); echo $loop['content']; ?>
                    
                </div> 
                
            </div>
        
        </div>
        
        <?php do_action('it_after_topten', it_get_setting('ad_topten_after'), 'after-topten'); ?>
        
    </div>
    
</div>

<?php wp_reset_query(); ?>