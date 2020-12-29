<?php
$loop = 'trending';
$location = 'trending slider';
$container = 'trending';
$disabled = array('recent', 'reviewed', 'rated', 'awarded', 'title');

#set variables from theme options
$trending_timeperiod = it_get_setting('trending_timeperiod');
$timeperiod_label = it_timeperiod_label($trending_timeperiod);
if(empty($timeperiod_label)) $timeperiod_label = __("THIS WEEK", IT_TEXTDOMAIN);
$sublabel = it_get_setting('trending_sublabel');
$timeperiod_label = ( !empty( $sublabel ) ) ? $sublabel : $timeperiod_label;
$trending_label = it_get_setting("trending_label");
$trending_label = ( !empty( $trending_label ) ) ? $trending_label : __('TRENDING', IT_TEXTDOMAIN);
$numarticles = it_get_setting('trending_number');
if(empty($numarticles)) $numarticles = 10;

#setup wp_query args
$args = array('posts_per_page' => $numarticles, 'order' => 'DESC', 'orderby' => 'meta_value_num', 'meta_key' => IT_META_TOTAL_VIEWS, 'ignore_sticky_posts' => true);

#limits
$limit_cat = it_get_setting('trending_limit_cat');
if(!empty($limit_cat)) $args['category__in'] = $limit_cat;
$limit_tag = it_get_setting('trending_limit_tag');	
if(!empty($limit_tag)) $args['tag__in'] = $limit_tag;	
#excludes
$exclude_cat = it_get_setting('trending_exclude_cat');
if(!empty($exclude_cat)) $args['category__not_in'] = $exclude_cat;
$exclude_tag = it_get_setting('trending_exclude_tag');	
if(!empty($exclude_tag)) $args['tag__not_in'] = $exclude_tag;

#setup loop format
$format = array('loop' => $loop, 'location' => $location, 'nonajax' => true, 'numarticles' => $numarticles, 'metric' => 'viewed');

#setup sortbar args
$sortbarargs = array('title' => $title, 'loop' => $loop, 'location' => $location, 'container' => $loop, 'view' => '', 'cols' => '', 'disabled' => $disabled, 'numarticles' => $numarticles, 'disable_filters' => false, 'disable_title' => true, 'thumbnail' => true, 'rating' => false, 'meta' => false, 'layout' => '', 'cssclass' => 'light', 'timeperiod' => $trending_timeperiod);           
#setup timeperiod
$week = date('W');
$month = date('n');
$year = date('Y');
switch($trending_timeperiod) {
	case 'This Week':
		$args['year'] = $year;
		$args['w'] = $week;
		$trending_timeperiod='';
	break;	
	case 'This Month':
		$args['monthnum'] = $month;
		$args['year'] = $year;
		$trending_timeperiod='';
	break;
	case 'This Year':
		$args['year'] = $year;
		$trending_timeperiod='';
	break;
	case 'all':
		$trending_timeperiod='';
	break;			
}  

$args_encoded = json_encode($args);

?>

<div class="container">
    
    <div class="row" id="trending" data-currentquery='<?php echo $args_encoded; ?>'>
    
    	<?php do_action('it_before_trending', it_get_setting('ad_trending_before'), 'before-trending'); ?>
    
        <div class="col-md-12">
        
            <div class="trending-label bar-label">
           
           		<div class="theme-icon-trending"></div>
                
                <div class="label-text"><?php echo $trending_label; ?>&nbsp;<?php echo $timeperiod_label; ?></div>
                
            </div> 
            
            <?php echo it_get_sortbar($sortbarargs); ?>
                    
            <div class="loading load-sort"><span class="theme-icon-spin2"></span></div>
                
            <div class="trending-content clearfix">
            
                <?php $loop = it_loop($args, $format, $trending_timeperiod); echo $loop['content']; ?>
                
            </div> 
            
        </div>
        
        <?php do_action('it_after_trending', it_get_setting('ad_trending_after'), 'after-trending'); ?>
    
    </div>
    
</div>

<?php wp_reset_query(); ?>