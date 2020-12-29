<?php
$postid = isset($post) ? $post->ID : '';
#theme options
$logo_url=it_get_setting('logo_url');
$logo_url_hd=it_get_setting('logo_url_hd');
$logo_width=it_get_setting('logo_width');
$logo_height=it_get_setting('logo_height');
$sticky_logo_url=it_get_setting('sticky_logo_url');
$sticky_logo_url_hd=it_get_setting('sticky_logo_url_hd');
$sticky_logo_width=it_get_setting('sticky_logo_width');
$sticky_logo_height=it_get_setting('sticky_logo_height');
$responsive_header_ad=it_get_setting('responsive_header_ad');
$header_disable=it_get_setting('logobar_disable_global');
$link_url=home_url();
$dimensions = '';
$sticky_dimensions = '';
$logo_disabled = it_component_disabled('logo', $postid, true);
$sticky_logo_disable = it_component_disabled('sticky_logo', $postid);

$cssad = $logo_disabled ? ' solo' : '';
$cssresponsive = $responsive_header_ad ? ' responsive' : '';
$csspadding = !$sticky_logo_disable ? ' no-padding' : '';

#category specific logo
$category_id = it_page_in_category($postid);
if($category_id) {
	$categories = it_get_setting('categories');	 
	foreach($categories as $category) {
		if(is_array($category)) {
			if(array_key_exists('id',$category)) {
				if($category['id'] == $category_id) {
					if(!empty($category['logo'])) $logo_url=$category['logo'];
					if(!empty($category['logohd'])) $logo_url_hd=$category['logohd'];
					if(!empty($category['logowidth'])) $logo_width=$category['logowidth'];
					if(!empty($category['logoheight'])) $logo_height=$category['logoheight'];
					if(!empty($category['stickylogo'])) $sticky_logo_url=$category['stickylogo'];
					if(!empty($category['stickylogohd'])) $sticky_logo_url_hd=$category['stickylogohd'];
					if(!empty($category['stickylogowidth'])) $sticky_logo_width=$category['stickylogowidth'];
					if(!empty($category['stickylogoheight'])) $sticky_logo_height=$category['stickylogoheight'];
					break;
				}
			}
		}
	}
}

if(!empty($logo_width)) $dimensions .= ' width="'.$logo_width.'"';
if(!empty($logo_height)) $dimensions .= ' height="'.$logo_height.'"';
if(!empty($sticky_logo_width)) $sticky_dimensions .= ' width="'.$sticky_logo_width.'"';
if(!empty($sticky_logo_height)) $sticky_dimensions .= ' height="'.$sticky_logo_height.'"';

?>

<?php if(!it_component_disabled('logobar', $postid, true)) { ?>

	<div class="container no-padding">
   
        <div id="header">
            
            <div class="row"> 
            
                <div class="col-md-12"> 
                
                	<div class="container">
            
                        <div id="header-inner" class="clearfix<?php echo $cssad . $csspadding; ?>">
                        
							<?php if(!$logo_disabled) { ?>
                            
                                <div class="logo hidden-xs">
                    
                                    <?php if(it_get_setting('display_logo') && $logo_url!='') { ?>
                                        <a href="<?php echo $link_url; ?>/">
                                            <img id="site-logo" alt="<?php bloginfo('name'); ?>" src="<?php echo $logo_url; ?>"<?php echo $dimensions; ?> />   
                                            <img id="site-logo-hd" alt="<?php bloginfo('name'); ?>" src="<?php echo $logo_url_hd; ?>"<?php echo $dimensions; ?> />  
                                        </a>
                                    <?php } else { ?>     
                                        <h1><a href="<?php echo $link_url; ?>/"><?php bloginfo('name'); ?></a></h1>
                                    <?php } ?>
                                    
                                    <?php if(!it_get_setting('description_disable') && get_bloginfo('description')!=='') { ?>
                                    
                                        <div class="subtitle"><?php bloginfo('description'); ?></div>
                                        
                                    <?php } ?>
                                    
                                </div>
                                
                            <?php } ?>
                            
                            <?php if(!$sticky_logo_disable) { ?>
                            
                                <div class="logo visible-xs">
                    
                                    <?php if(it_get_setting('display_logo') && $sticky_logo_url!='') { ?>
                                        <a href="<?php echo $link_url; ?>/">
                                            <img id="site-logo" alt="<?php bloginfo('name'); ?>" src="<?php echo $sticky_logo_url; ?>"<?php echo $sticky_dimensions; ?> />   
                                            <img id="site-logo-hd" alt="<?php bloginfo('name'); ?>" src="<?php echo $sticky_logo_url_hd; ?>"<?php echo $sticky_dimensions; ?> />  
                                        </a>
                                    <?php } else { ?>     
                                        <h1><a href="<?php echo $link_url; ?>/"><?php bloginfo('name'); ?></a></h1>
                                    <?php } ?>                                
                                    
                                </div>
                                
                            <?php } ?>
                            
                            <?php if(!it_get_setting('header_social_disable')) { ?>
                
                                <div class="header-social clearfix">
                                    
                                    <?php echo it_social_badges('bottom'); ?>
                                
                                </div>
                                
                            <?php } ?>
                            
                            <?php if(it_get_setting('ad_header')!='' && !it_component_disabled('ad_header', $post->ID)) { ?>
                
                                <div class="it-ad<?php echo $cssad . $cssresponsive; ?>" id="it-ad-header">
                                    
                                    <?php echo do_shortcode(it_get_setting('ad_header')); ?> 
                                      
                                </div>
                            
                            <?php } ?> 
                            
                        </div> 
                        
                    </div>
                    
                </div>   
                
            </div> 
        
        </div>
        
    </div>
    
<?php } ?>

<?php wp_reset_query(); ?>