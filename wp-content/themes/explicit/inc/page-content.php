<?php
#default settings (use "Standard Pages" theme options for defaults)
$sidebar = __('Page Sidebar',IT_TEXTDOMAIN);
$layout = 'classic';
$thumbnail = it_get_setting('page_featured_image_size');
$sidebar_position = it_get_setting('page_sidebar_position');
$post_article_title_disable = it_get_setting('post_article_title_disable');
$editor_rating_disable = it_get_setting('review_editor_rating_disable');
$user_rating_disable = it_get_setting('review_user_rating_disable');
$clickable = !it_get_setting('clickable_image_disable');
$disable_view_count = it_component_disabled('views', $post->ID);
$disable_like_count = it_component_disabled('likes', $post->ID);
$disable_comment_count = it_component_disabled('comment_count', $post->ID);
$disable_awards = it_component_disabled('awards', $post->ID);
$disable_authorship = it_component_disabled('authorship', $post->ID);
$disable_comments = it_component_disabled('comments', $post->ID);
$disable_postnav = it_component_disabled('postnav', $post->ID);
$disable_sharing = it_component_disabled('sharing', $post->ID);
$disable_controlbar = it_component_disabled('controlbar', $post->ID, $forcepage = true);
$disable_video = it_component_disabled('video', $post->ID);
$caption = it_get_setting('featured_image_caption');
$disable_authorship_avatar = it_get_setting('post_authorship_avatar_disable');
$sharing_position = it_get_setting('sharing_position');
$template = it_get_template_file();
$details_position = 'none';
$ratings_position = 'none';
$reactions_position = 'none';
$contents_menu = 'none';
$affiliate_position = 'before-content';
$disable_postinfo = true;
$image_can_float = false;
$disabled_menu_items = array();
$article_title = '';
$post_article_title = false;
$disable_main_header = false;
$disable_recommended = false;
$disable_title = false;
$isreview = false;
$full = '';
$pagecss = '';
$item_type = 'http://schema.org/Article';
$item_reviewed = '';
$csscol1 = '';
$csscol2 = '';
$csscol3 = '';
$has_details = it_has_details($post->ID);
$has_rating = it_has_rating($post->ID);

#get just the primary category id
$categoryargs = array('postid' => $post->ID, 'label' => false, 'icon' => false, 'white' => true, 'single' => true, 'wrapper' => false, 'id' => true);	
$category_id = it_get_primary_categories($categoryargs);
$categorycss = ' category-' . $category_id;
#reset args for category display
$categoryargs = array('postid' => $post->ID, 'label' => true, 'icon' => true, 'white' => true, 'single' => true, 'wrapper' => false, 'id' => false);
$category = it_get_primary_categories($categoryargs);

#section-specific settings
if(is_404()) {
	wp_reset_postdata();
	#settings for 404 pages
	$content_title = __('404 Error - Page Not Found', IT_TEXTDOMAIN);
	$title = __('We could not find the page you were looking for. Try searching for it:', IT_TEXTDOMAIN);		
	$disable_controlbar = true;	
	$disable_main_header = true;
	$disable_title = true;
	$disable_recommended = true;
	$disable_sharing = true;
	$disable_authorship = true;
	$layout = 'classic';
} elseif(is_page()) {
	#settings for all standard WordPress pages	
	$title = get_post_meta($post->ID, "_subtitle", $single = true);	
	$page_comments = it_get_setting('page_comments');
	$thumbnail_specific = it_get_setting('page_featured_image_size');	
	$disable_recommended = true;
	$disable_authorship = true;
	$disabled_menu_items[] = 'rating';
	$disabled_menu_items[] = 'overview';
	$layout = 'classic';
	$disable_postnav = true;
	if(!$page_comments) {
		$disable_comments = true;
		$disable_comment_count = true;
		$disabled_menu_items[] = 'comments';
	}
} elseif(is_single()) {
	#settings for single posts
	$layout = it_get_setting('post_layout');
	$subtitle = get_post_meta($post->ID, "_subtitle", $single = true);	
	$sidebar_position_specific = it_get_setting('post_sidebar_position');
	$thumbnail_specific = it_get_setting('post_featured_image_size');	
	$contents_menu = it_get_setting('contents_menu');	
	$article_title = it_get_setting('article_title');	
	$title = $category;
	$disable_postinfo = false;
	$details_position = it_get_setting('review_details_position');
	$details_position = !empty($details_position) ? $details_position : 'top';
	$ratings_position = it_get_setting('review_ratings_position');
	$ratings_position = !empty($ratings_position) ? $ratings_position : 'top';	
	$reactions_position = it_get_setting('reactions_position');
	$reactions_position = !empty($reactions_position) ? $reactions_position : 'bottom';	
	if(!comments_open()) $disabled_menu_items[] = 'comments';
	$affiliate_position = it_get_setting('affiliate_position');	
	$affiliate_position = !empty($affiliate_position) ? $affiliate_position : 'after-content';	
}
#settings for buddypress pages
if(it_buddypress_page()) {	
	$disable_postnav = true;
	$disable_controlbar = true;
	$disable_recommended = true;
	$disable_postinfo = true;
	$disable_authorship = true;
	$layout = 'classic';
	$pagecss = 'bp-page';
	$article_title = '';
	$contents_menu = 'none';
	$reactions_position = 'none';
	$sidebar_position_specific = it_get_setting('bp_layout');
	if(it_get_setting('bp_sidebar_unique')) $sidebar = __('BuddyPress Sidebar',IT_TEXTDOMAIN);	
}
#settings for woocommerce pages
if(it_woocommerce_page()) {	
	$disable_postnav = true;
	$disable_controlbar = true;
	$disable_recommended = true;
	$disable_postinfo = true;
	$disable_authorship = true;
	$layout = 'classic';
	$pagecss = 'woo-page';
	$article_title = '';
	$contents_menu = 'none';
	$reactions_position = 'none';
	$sidebar_position_specific = it_get_setting('woo_layout');
	if(it_get_setting('woo_sidebar_unique')) $sidebar = __('WooCommerce Sidebar',IT_TEXTDOMAIN);	
}
#specific template files
switch($template) {
	case 'template-authors.php':
		$pagecss = 'template-authors';		
		$disable_controlbar = true;	
		$disable_main_header = true;
		$disable_recommended = true;	
		$disable_title = true;	
		$layout = 'classic';	
	break;	
}

#don't use specific settings if they are not set
if(!empty($sidebar_position_specific) && $sidebar_position_specific!='') $sidebar_position = $sidebar_position_specific;
if(!empty($thumbnail_specific) && $thumbnail_specific!='') $thumbnail = $thumbnail_specific;

#page-specific settings
$sidebar_position_meta = get_post_meta($post->ID, "_sidebar_position", $single = true);
if(!empty($sidebar_position_meta) && $sidebar_position_meta!='') $sidebar_position = $sidebar_position_meta;
$layout_meta = get_post_meta($post->ID, "_post_layout", $single = true);
if(!empty($layout_meta) && $layout_meta!='' && !is_404()) $layout = $layout_meta;
$thumbnail_meta = get_post_meta($post->ID, "_featured_image_size", $single = true);
if(!empty($thumbnail_meta) && $thumbnail_meta!='') $thumbnail = $thumbnail_meta;
$sidebar_meta = get_post_meta($post->ID, "_custom_sidebar", $single = true);
if(!empty($sidebar_meta) && $sidebar_meta!='') $sidebar = $sidebar_meta;
$post_type = get_post_meta( $post->ID, IT_META_POST_TYPE, $single = true );
$disable_title_meta = get_post_meta($post->ID, IT_META_DISABLE_TITLE, $single = true);
if(!empty($disable_title_meta) && $disable_title_meta!='') $disable_title = $disable_title_meta;
$article_title_meta = get_post_meta($post->ID, "_article_title", $single = true);
if(!empty($article_title_meta) && $article_title_meta!='') $article_title = $article_title_meta;
$disable_review = get_post_meta($post->ID, IT_META_DISABLE_REVIEW, $single = true);
$video = get_post_meta($post->ID, "_featured_video", $single = true);
$sharing_disable_meta = get_post_meta($post->ID, "_sharing_disable", $single = true);
if(!empty($sharing_disable_meta) && $sharing_disable_meta!='') $disable_sharing = $sharing_disable_meta;
$view_count_disable_meta = get_post_meta($post->ID, "_view_count_disable", $single = true);
if(!empty($view_count_disable_meta) && $view_count_disable_meta!='') $disable_view_count = $view_count_disable_meta;
$like_count_disable_meta = get_post_meta($post->ID, "_like_count_disable", $single = true);
if(!empty($like_count_disable_meta) && $like_count_disable_meta!='') $disable_like_count = $like_count_disable_meta;

#contents menu
$contents_menu_display = false;
$contents_menu_meta = get_post_meta($post->ID, "_contents_menu", $single = true);
if($contents_menu=='optin' && $contents_menu_meta) $contents_menu_display = true;
if(($contents_menu=='both' || ($contents_menu=='reviews' && $disable_review!='true')) && !$contents_menu_meta) $contents_menu_display = true;
if($details_position=='none') $disabled_menu_items[] = 'overview';

#this post is a review
if($post_type=='review' && !$editor_rating_disable) {
	#rich snippets
	$item_type = 'http://schema.org/Review';
	$isreview = true;
} elseif($user_rating_disable) {
	$disabled_menu_items[] = 'rating';
	$ratings_position = 'none';
}
if(($post_type=='article' || $disable_review=='true') && $post_article_title_disable) $article_title = '';

if(empty($sidebar_position)) $sidebar_position = 'sidebar-right';
#determine css classes
switch($sidebar_position) {
	case 'sidebar-right':
		$csscol2 = 'col-md-8';
		$csscol3 = 'col-md-4';
	break;
	case 'sidebar-left':
		$csscol1 = 'col-md-4';
		$csscol2 = 'col-md-8';
	break;
	case 'full':
		$csscol2 = 'col-md-12';
	break;	
}

#special class for full-width featured images
if($thumbnail == '790') $imagecss = ' full-image';

#full width layout needs large full width featured image
if($sidebar_position == 'full' && $thumbnail == '790') $thumbnail = '1130';

$disable_subtitle = empty($title) ? true : false;
$csspostnav = $disable_subtitle ? ' moved' : '';
$cssadminbar = is_admin_bar_showing() ? ' admin-bar' : '';
$cssboxed = $layout=='billboard' ? ' boxed' : '';

#determine featured image floating
if(!$contents_menu_display && (!$has_details || $details_position!='top') && ($ratings_position!='top' || $post_type=='article' || $disable_review=='true' || ($ratings_position=='top' && !$has_rating)) && $reactions_position!='top' && $thumbnail_meta!='none' && $thumbnail_meta!='790') $image_can_float = true;
$imagecss = $image_can_float ? ' floated-image' : '';

#get largest size featured images for overlay backgrounds
$overlay_image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' );
$bg_image = get_post_meta($post->ID, "_bg_image", $single = true);
$billboard_overlay = !empty($bg_image) ? $bg_image : $overlay_image[0];

#get sharing position:
$sharing_position = $disable_sharing ? 'none' : $sharing_position;

#setup args
$awardsargs = array('postid' => $post->ID, 'single' => true, 'badge' => false, 'white' => false, 'wrapper' => true);
$likesargs = array('postid' => $post->ID, 'label' => false, 'icon' => true, 'clickable' => true, 'tooltip_hide' => false);
$viewsargs = array('postid' => $post->ID, 'label' => false, 'icon' => true, 'tooltip_hide' => false);
$commentsargs = array('postid' => $post->ID, 'label' => false, 'icon' => true, 'showifempty' => true, 'tooltip_hide' => false, 'anchor_link' => true);
$imageargs = array('postid' => $post->ID, 'size' => 'single-'.$thumbnail, 'width' => 818, 'height' => 450, 'wrapper' => true, 'itemprop' => true, 'link' => $clickable, 'type' => 'normal', 'caption' => $caption);
$videoargs = array('url' => $video, 'video_controls' => 'true', 'parse' => true, 'frame' => true, 'autoplay' => 0, 'type' => 'embed');
$sharingargs = array('title' => get_the_title(), 'description' => it_excerpt(500, false), 'url' => get_permalink(), 'showmore' => true, 'style' => 'single');

?>

<?php do_action('it_before_content_page'); ?>

<?php if($layout=='billboard') { ?>

	<div class="billboard-image" style="background-image:url(<?php echo $billboard_overlay; ?>);"></div>

	<div class="billboard-overlay"></div>

	<div class="container nobg <?php echo $layout ?>">
    
    	<div class="row">
            
			<?php do_action('it_before_billboard_title', it_get_setting('ad_billboard_before'), 'before-billboard'); ?>
            
            <h1 class="main-title">								
                <?php echo get_the_title();?>                                    
            </h1> 
            
            <?php if(!$disable_authorship_avatar) echo '<div class="billboard-avatar">' . it_get_author_avatar(40) . '</div>'; ?>
            
            <?php if(!empty($subtitle)) echo '<div class="billboard-subtitle">' . $subtitle . '</div>'; ?>           
            
            <?php if(!$disable_authorship) echo '<div class="billboard-authorship">' . it_get_authorship('both', true) . '</div>'; ?>
            
            <?php do_action('it_after_billboard_title', it_get_setting('ad_billboard_after'), 'after-billboard'); ?>	

<?php } ?>

<div class="container<?php echo $cssboxed ?>">

    <div id="page-content" class="single-page <?php echo $pagecss . ' ' . $sidebar_position . $imagecss . $categorycss ?>" data-location="single-page" data-postid="<?php echo $post->ID; ?>">
    
    	<?php if(!$disable_main_header) { ?>
        
        	<?php do_action('it_before_controlbar', it_get_setting('ad_controlbar_before'), 'before-controlbar'); ?>
        
            <div class="row main-header">
            
                <div class="col-md-12">
                
                    <?php if(!$disable_controlbar) { ?>
                    
                        <div class="bar-header full-width clearfix page-controls">
                        
                            <?php if(!$disable_subtitle) { ?>
                    
                                <div class="bar-label-wrapper">
                                
                                    <div class="bar-label">
                                    
                                        <div class="label-text">
                                        
                                            <?php echo $title; ?>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            
                            <?php } ?>
                            
                            <div class="bar-controls<?php echo $csspostnav; ?>">
                                
                                <?php if(!$disable_like_count) echo '<div class="control-box">' . it_get_likes($likesargs) . '</div>'; ?>
                                
                                <?php if(!$disable_view_count) echo '<div class="control-box no-link">' . it_get_views($viewsargs) . '</div>'; ?>
                                
                                <?php if(!$disable_comment_count) echo '<div class="control-box">' . it_get_comments($commentsargs) . '</div>'; ?>
                                
                                <?php if(!$disable_awards) echo it_get_awards($awardsargs); ?>
                                
                                <?php if(!$disable_postnav) echo '<div class="control-box">' . it_get_postnav() . '</div>'; ?>
                                
                                <?php if($sharing_position=='control_bar') echo '<div class="share-wrapper' . $cssadminbar . '">' . it_get_sharing($sharingargs) . '</div>'; ?>
                                
                            </div>
                            
                        </div>
                        
                    <?php } ?>
                    
                    <?php if($layout!='billboard') { ?>
                    
                        <?php do_action('it_before_standard_title', it_get_setting('ad_title_before'), 'before-title'); ?>
                                        
                        <?php if(!$disable_title) { ?>
                        
                            <h1 class="main-title">	
                            							
                                <?php echo $content_title = empty($content_title) ? get_the_title() : $content_title; ?>  
                                                                  
                            </h1>
                            
                        <?php } ?>
                        
                        <?php if(!$disable_authorship) echo it_get_authorship('both', true); ?>
                        
                        <?php do_action('it_after_standard_title', it_get_setting('ad_title_after'), 'after-title'); ?>
                        
                    <?php } ?>
            
                </div>
            
            </div>
            
            <?php do_action('it_after_controlbar', it_get_setting('ad_controlbar_after'), 'after-controlbar'); ?>
            
        <?php } ?>
            
        <div class="row">
        
        	<?php if($sidebar_position=='sidebar-left') { ?>
            
            	<div class="<?php echo $csscol1; ?>">
            
               		<?php echo it_widget_panel($sidebar, $sidebar_position); ?>
                    
                </div>
                            
            <?php } ?>
            
            <div id="main-content" class="<?php echo $csscol2; ?>">
                              
				<?php if (is_404()) : ?>
                
                	<h1 class="main-title"><?php echo $content_title; ?></h1>
        
                    <h4><span class="theme-icon-attention"></span><?php echo $title; ?></h4>
                           
                    <div class="form-404">    
                        <form method="get" class="form-search" action="<?php echo home_url(); ?>/">                             
                            <input class="search-query form-control" name="s" id="s" type="text" placeholder="<?php _e('keyword(s)',IT_TEXTDOMAIN); ?>">                                      
                        </form> 
                    </div>            
                
                <?php elseif($template=='template-authors.php') : ?>
                
                	<h1 class="main-title"><?php echo get_the_title(); ?></h1>
                        
                    <?php echo it_get_content($article_title); ?>
                    
					<?php echo it_get_author_loop(); #get authors and display loop ?>                    
                    
                <?php elseif (have_posts()) : ?>
            
					<?php while (have_posts()) : the_post(); ?>
                    
                        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="<?php echo $item_type; ?>">
                        
                        	<?php do_action('it_before_single_main', it_get_setting('ad_main_before'), 'before-main'); ?>
                            
                            <?php if($sharing_position=='above_image') echo '<div class="share-wrapper non-control-bar">' . it_get_sharing($sharingargs) . '</div>'; ?>
                        
                            <div class="image-container">
                                
                                <?php #featured video
                                if(!$disable_video) {                                    
                                    do_action('it_before_featured_video', it_get_setting('ad_video_before'), 'before-video');									
                                    if(!empty($video)) echo it_video($videoargs); 									
                                    do_action('it_after_featured_video', it_get_setting('ad_video_after'), 'after-video');                                    
                                }                                
                                #featured image
                                if($thumbnail!='none' && has_post_thumbnail()) {                                 
                                    do_action('it_before_featured_image', it_get_setting('ad_image_before'), 'before-image');                                        
                                    echo it_featured_image($imageargs);                               
                                    do_action('it_after_featured_image', it_get_setting('ad_image_after'), 'after-image');                                    
                                } ?>
                                
                            </div>                            
                            
                            <?php #contents menu
                            if($contents_menu_display) {                                
                                do_action('it_before_contents_menu', it_get_setting('ad_contents_menu_before'), 'before-contents-menu');								
                                echo it_get_contents_menu(get_the_ID(), $disabled_menu_items);								
                                do_action('it_after_contents_menu', it_get_setting('ad_contents_menu_after'), 'after-contents-menu');                                
                            }
                            #details
                            if($details_position=='top') {                                
                                do_action('it_before_details', it_get_setting('ad_details_before'), 'before-details');								
                                echo it_get_details(get_the_ID(), $overlay_image[0], $isreview); 								
                                do_action('it_after_details', it_get_setting('ad_details_after'), 'after-details');                                
                            }
                            #rating criteria
                            if($ratings_position=='top') {                                
                                do_action('it_before_criteria', it_get_setting('ad_criteria_before'), 'before-criteria');								
                                echo it_get_criteria(get_the_ID(), $overlay_image[0]);								
                                do_action('it_after_criteria', it_get_setting('ad_criteria_after'), 'after-criteria');                                
                            }
                            #reactions
                            if($reactions_position=='top') {                                
                                do_action('it_before_reactions', it_get_setting('ad_reactions_before'), 'before-reactions');								
                                echo it_get_reactions(get_the_ID());								
                                do_action('it_after_reactions', it_get_setting('ad_reactions_after'), 'after-reactions');                                
                            }
							
							if($sharing_position=='above_content') echo '<div class="share-wrapper non-control-bar">' . it_get_sharing($sharingargs) . '</div>';
                            
                            #content
                            do_action('it_before_content', it_get_setting('ad_content_before'), 'before-content');
							
							if($affiliate_position=='before-content') echo it_get_affiliate_code(get_the_ID());                                
                            echo it_get_content($article_title);							
                            do_action('it_after_content', it_get_setting('ad_content_after'), 'after-content');
							
							if($affiliate_position=='after-content') echo it_get_affiliate_code(get_the_ID());
                            
                            #details
                            if($details_position=='bottom') {                                
                                do_action('it_before_details', it_get_setting('ad_details_before'), 'before-details');								
                                echo it_get_details(get_the_ID(), $overlay_image[0], $isreview); 								
                                do_action('it_after_details', it_get_setting('ad_details_after'), 'after-details');                                 
                            }
                            #rating criteria  
                            if($ratings_position=='bottom') {                                
                                do_action('it_before_criteria', it_get_setting('ad_criteria_before'), 'before-criteria');								
                                echo it_get_criteria(get_the_ID(), $overlay_image[0]);								
                                do_action('it_after_criteria', it_get_setting('ad_criteria_after'), 'after-criteria');                                
                            }
                            #reactions
                            if($reactions_position=='bottom') {                                
                                do_action('it_before_reactions', it_get_setting('ad_reactions_before'), 'before-reactions');								
                                echo it_get_reactions(get_the_ID());								
                                do_action('it_after_reactions', it_get_setting('ad_reactions_after'), 'after-reactions');                                 
                            }
                            #post info
                            if(!$disable_postinfo) {                                
                                do_action('it_before_postinfo', it_get_setting('ad_postinfo_before'), 'before-postinfo');
                                echo it_get_post_info(get_the_ID());
                                do_action('it_after_postinfo', it_get_setting('ad_postinfo_after'), 'after-postinfo');                                
                            }
							
							if($sharing_position=='below_content') echo '<div class="share-wrapper non-control-bar">' . it_get_sharing($sharingargs) . '</div>';
							
                            #recommended
                            if(!$disable_recommended){                                
                                do_action('it_before_recommended', it_get_setting('ad_recommended_before'), 'before-recommended');
                                echo it_get_recommended(get_the_ID());
                                do_action('it_after_recommended', it_get_setting('ad_recommended_after'), 'after-recommended');                                
                            }
                            #comments
                            if(!$disable_comments && comments_open()) {                                
                                do_action('it_before_comments', it_get_setting('ad_comments_before'), 'before-comments');
                                comments_template();
                                do_action('it_after_comments', it_get_setting('ad_comments_after'), 'after-comments');                                
                            } ?> 
                            
                            <?php do_action('it_after_single_main', it_get_setting('ad_main_after'), 'after-main'); ?>                             
                            
                        </div>
                    
                    <?php endwhile; ?> 
                
                <?php endif; ?> 
                
                <?php wp_reset_query(); ?>
                    
            </div>  
            
            <?php if($sidebar_position=='sidebar-right') { ?>
            
            	<div class="<?php echo $csscol3; ?>">
            
               		<?php echo it_widget_panel($sidebar, $sidebar_position); ?>
                    
                </div>
                            
            <?php } ?>
        
        </div>
        
    </div>
    
</div>

<?php if($layout=='billboard') { ?>

	</div>
    
</div>

<?php } ?>

<?php do_action('it_after_content_page'); ?>

<?php wp_reset_query(); ?>