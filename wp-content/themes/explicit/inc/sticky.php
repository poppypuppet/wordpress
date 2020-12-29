<?php
$postid = isset($post) ? $post->ID : '';
#logo setup
$logo_url=it_get_setting('sticky_logo_url');
$logo_url_hd=it_get_setting('sticky_logo_url_hd');
$logo_width=it_get_setting('logo_width');
$logo_height=it_get_setting('logo_height');
$sticky_logo_url=it_get_setting('sticky_logo_url');
$sticky_logo_url_hd=it_get_setting('sticky_logo_url_hd');
$sticky_logo_width=it_get_setting('sticky_logo_width');
$sticky_logo_height=it_get_setting('sticky_logo_height');
$logo_disable=it_get_setting('logo_disable_global');
$header_disable=it_get_setting('logobar_disable_global');
$sticky_logo_disable=it_component_disabled('sticky_logo', $postid);
$dimensions = '';
#category specific logo
$category_id = it_page_in_category($postid);
if($category_id) {
	$categories = it_get_setting('categories');	 
	foreach($categories as $category) {
		if(is_array($category)) {
			if(array_key_exists('id',$category)) {
				if($category['id'] == $category_id) {
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
#use sticky logo instead of main logo
if(!empty($sticky_logo_url)) $logo_url = $sticky_logo_url;
if(!empty($sticky_logo_url_hd)) $logo_url_hd = $sticky_logo_url_hd;
if(!empty($sticky_logo_width)) $logo_width = $sticky_logo_width;
if(!empty($sticky_logo_height)) $logo_height = $sticky_logo_height;
#set dimension css
if(!empty($logo_width)) $dimensions .= ' width="'.$logo_width.'"';
if(!empty($logo_height)) $dimensions .= ' height="'.$logo_height.'"';
#setup sticky bar css
$cssslide = $logo_disable || $header_disable || $sticky_logo_disable ? '' : 'logo-slide';
$cssadmin = is_admin_bar_showing() ? ' admin-bar' : '';
$cssheader = $header_disable ? ' no-header' : '';
#new articles setup
$disable_new_articles = it_get_setting('new_articles_disable');
$timeperiod = it_get_setting('new_timeperiod');
if(empty($timeperiod)) $timeperiod = 'Today'; 
$prefix = it_get_setting('new_prefix');
if(!empty($prefix)) $prefix .= ' ';
$timeperiod_label = $prefix . it_timeperiod_label($timeperiod);
$number = it_get_setting('new_number');
if(empty($number)) $number = 16;
$label_override = it_get_setting('new_label_override');
if(!empty($label_override)) $timeperiod_label = $label_override;
#setup wp_query args
$args = array('posts_per_page' => $number);
#setup loop format
$format = array('loop' => 'new articles', 'thumbnail' => false, 'rating' => false, 'icon' => true);
#add time period to args
$day = date('j');
$week = date('W');
$month = date('n');
$year = date('Y');
switch($timeperiod) {
	case 'Today':
		$args['day'] = $day;
		$args['monthnum'] = $month;
		$args['year'] = $year;
		$timeperiod='';
	break;
	case 'This Week':
		$args['year'] = $year;
		$args['w'] = $week;
		$timeperiod='';
	break;	
	case 'This Month':
		$args['monthnum'] = $month;
		$args['year'] = $year;
		$timeperiod='';
	break;
	case 'This Year':
		$args['year'] = $year;
		$timeperiod='';
	break;
	case 'all':
		$timeperiod='';
	break;			
}
$idregister = 'sticky-register';
$hrefregister = '';
$hrefaccount = force_ssl_admin() ? str_replace('http://','https://',admin_url( 'profile.php' )) : admin_url( 'profile.php' );
#if buddypress is active the register button should redirect to the register page
#and the account button should redirect to the BuddyPress profile page
if(function_exists('bp_current_component') && !it_get_setting('bp_register_disable')) {
	$idregister = 'sticky-register-bp';
	$hrefregister = 'href="' . home_url() . '/register"';
	$hrefaccount = bp_loggedin_user_domain();
}
#disable login form and use standard WP login page instead
$idlogin = 'sticky-login';
$hreflogin = '';
if(it_get_setting('sticky_force_wp_login')) {
	$idlogin = 'sticky-login-wp';
	$hreflogin = 'href="' . wp_login_url( home_url() ) . '"';
}
#perform the loop function to retrieve post count
$loop = it_loop($args, $format, $timeperiod);
$post_count = $loop['posts'];
if($post_count == 0) $disable_new_articles = true;   
#user has turned off mmenu
$mmenu_disable = it_get_setting('mmenu_disable');
$section_menu_id = $mmenu_disable ? 'section-menu-mobile-ddl' : 'section-menu-mobile';

?>

<?php if (!it_component_disabled('sticky', $postid)) { ?>

	<div class="container no-padding">
   
        <div id="sticky-bar" class="<?php echo $cssslide . $cssadmin . $cssheader; ?>">
            
            <div class="row"> 
            
                <div class="col-md-12"> 
                
                	<div class="container">
                    
                    	<?php if(!$sticky_logo_disable) { ?>
                        
                        	<div class="logo">
        
								<?php if(it_get_setting('display_logo') && $logo_url!='') { ?>
                                    <a href="<?php echo home_url(); ?>/" title="<?php _e('Home',IT_TEXTDOMAIN); ?>">
                                        <img id="site-logo" alt="<?php bloginfo('name'); ?>" src="<?php echo $logo_url; ?>"<?php echo $dimensions; ?> />   
                                        <img id="site-logo-hd" alt="<?php bloginfo('name'); ?>" src="<?php echo $logo_url_hd; ?>"<?php echo $dimensions; ?> />  
                                    </a>
                                <?php } else { ?>     
                                    <h1><a href="<?php echo home_url(); ?>/" title="<?php _e('Home',IT_TEXTDOMAIN); ?>"><?php bloginfo('name'); ?></a></h1>
                                <?php } ?>
                                
                            </div>
                        
                        <?php } ?>
                        
                        <div id="sticky-menus">
                        
                        	<?php if(!it_get_setting('sticky_menu_disable') && has_nav_menu('sticky-menu') && !$mmenu_disable) { ?>
                                    
                                <a id="sticky-menu-selector" href="#sticky-menu"><span class="theme-icon-list"></span></a>
                            
                                <?php 
                                #get the sticky menu, stripping out title attributes
                                $sticky_menu = preg_replace('/title=\"(.*?)\"/','',wp_nav_menu( array( 'theme_location' => 'sticky-menu', 'container' => 'nav', 'container_id' => 'sticky-menu', 'fallback_cb' => 'fallback_pages', 'echo' => false) ) );											
                                echo $sticky_menu; 
                                ?>
                                      
                            <?php } ?>
                            
                            <?php if(!$disable_new_articles) { ?>
                
                                <div id="new-articles">
                                
                                    <div class="selector info-right" title="<?php echo $timeperiod_label; ?>">
                                        
                                        <div class="new-number"><?php echo $post_count; ?></div>
                                        
                                        <div class="new-label"><?php _e('new',IT_TEXTDOMAIN); ?></div> 
                                        
                                        <div class="new-arrow"><span class="theme-icon-down-fat"></span></div> 
                                        
                                    </div>
                                    
                                    <div class="post-container">
                                            
                                        <div class="column">
                                        
                                            <?php echo $loop['content']; wp_reset_query(); ?>
                                        
                                        </div>
                                    
                                    </div>
                               
                                </div>
                                
                            <?php } ?>
                            
                            <div id="section-menu" class="menu-container">
                        
                                <div id="section-menu-full">
                                
                                	<?php 
									$secondary_menu_position = it_get_setting('secondary_menu_position');
									#get the secondary menu, stripping out title attributes
									$the_secondary_menu = preg_replace('/title=\"(.*?)\"/','',wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'container' => false, 'fallback_cb' => '', 'echo' => false ) ) );
									$full_secondary_menu = it_secondary_menu($the_secondary_menu, $secondary_menu_position, $full = true);
									$mobile_secondary_menu = it_secondary_menu($the_secondary_menu, $secondary_menu_position, $full = false);
									
									#Secondary Menu (if before Section menu)
									if($secondary_menu_position=='before') echo $full_secondary_menu;									
									
									#Section Menu
                                    switch(it_get_setting('section_menu_type')) {
										case 'standard':
											#get the section menu, stripping out title attributes
											$section_menu = preg_replace('/title=\"(.*?)\"/','',wp_nav_menu( array( 'theme_location' => 'section-menu', 'container' => false, 'fallback_cb' => 'fallback_categories', 'echo' => false ) ) );
											echo '<div class="standard-menu non-mega-menu">' . $section_menu . '</div>';
										break;
										case 'mega':  
											#get the mega menu
											$mega_menu = it_section_menu();                                      
											echo '<div class="mega-menu">' . $mega_menu . '</div>';
										break;
                                    } 
									
									#Secondary Menu (if after Section menu)
									if($secondary_menu_position=='after') echo $full_secondary_menu;
                                    ?>
                                    
                                </div>
                                
                                <div id="section-menu-compact">
                                
                                    <ul>
                                
                                        <li>
                                
                                            <a id="section-menu-selector" href="#section-menu-mobile">
                                            
                                                <span class="theme-icon-grid"></span>
                                        
                                                <?php echo ( it_get_setting("section_menu_label")!="" ) ? it_get_setting("section_menu_label") : __("SECTIONS", IT_TEXTDOMAIN); ?>
                                                
                                            </a> 
                                            
                                            <div id="<?php echo $section_menu_id; ?>">
                                            
                                            	<div class="standard-menu">
                                            
													<?php 
                                                    #Secondary Menu (if before Section menu)
                                                    if(it_get_setting('secondary_menu_position')=='before') echo $mobile_secondary_menu;
                                        
                                                    #Section Menu
                                                    switch(it_get_setting('section_menu_type')) {
                                                        case 'standard':
                                                            echo $section_menu;
                                                        break;
                                                        case 'mega':
															$mega_menu = it_section_menu(true);
                                                            echo $mega_menu;
                                                        break;
                                                    } 
                                                    
                                                    #Secondary Menu (if after Section menu)
                                                    if(it_get_setting('secondary_menu_position')=='after') echo $mobile_secondary_menu;
                                                    ?>
                                                    
                                                </div>
                                                
                                            </div>
                                            
                                        </li>
                                        
                                    </ul>
                                    
                                </div>  
                                
                            </div>
                            
                            <?php if(!it_get_setting('random_disable')) { ?>
                                
                                <a id="random-article" href="<?php echo it_get_random_article(); ?>" class="info-bottom theme-icon-random" title="<?php _e('Random Article',IT_TEXTDOMAIN); ?>"></a>
                            
                            <?php } ?>
                            
                        </div>
                    
                        <div id="sticky-controls">
                        
                        	<?php if(!it_get_setting('search_disable')) { ?>
                        
                                <div id="menu-search-button">
                                
                                    <span class="theme-icon-search info-bottom" title="<?php _e('Search',IT_TEXTDOMAIN); ?>"></span>
                                    
                                </div>
                            
                                <div id="menu-search" class="info-bottom" title="<?php _e('Type and hit Enter',IT_TEXTDOMAIN); ?>">
                                
                                    <form method="get" id="searchformtop" action="<?php echo home_url(); ?>/">                             
                                        <input type="text" placeholder="<?php _e( 'search', IT_TEXTDOMAIN ); ?>" name="s" id="s" />          
                                    </form>
                                    
                                </div>
                                
                            <?php } ?>
                                            
                            <a id="back-to-top" href="#top" class="info theme-icon-up-open" title="<?php _e('Top',IT_TEXTDOMAIN); ?>" data-placement="bottom"></a>  
                            
                            <?php if(!it_get_setting('sticky_controls_disable')) { ?>             
                            
								<?php if (!is_user_logged_in()) { ?>
                                
                                    <div class="register-wrapper">
                                    
                                        <a id="<?php echo $idregister; ?>" <?php echo $hrefregister; ?> class="info-bottom theme-icon-register sticky-button" title="<?php _e('Register',IT_TEXTDOMAIN); ?>"></a>
                                    
                                        <div class="sticky-form" id="sticky-register-form">
                                    
                                            <div class="loading"><span class="theme-icon-spin2"></span></div>
                                        
                                            <?php echo it_register_form(); ?>
                                        
                                        </div>
                                    
                                    </div>
                                    
                                    <div class="login-wrapper">
                                    
                                        <a id="<?php echo $idlogin; ?>" <?php echo $hreflogin; ?> class="info-bottom theme-icon-login sticky-button" title="<?php _e('Login',IT_TEXTDOMAIN); ?>"></a>
                                        
                                        <div class="sticky-form" id="sticky-login-form">
                                    
                                            <div class="loading"><span class="theme-icon-spin2"></span></div>
                                        
                                            <?php echo it_login_form(); ?>
                                        
                                        </div>
                                    
                                    </div>                               
                                
                                <?php } else { ?>
                                
                                    <a id="sticky-account" class="info theme-icon-cog sticky-button" href="<?php echo $hrefaccount; ?>" title="<?php _e('Account',IT_TEXTDOMAIN); ?>" data-placement="bottom"></a>
                                    
                                    <a id="sticky-logout" class="info theme-icon-logout sticky-button" href="<?php echo wp_logout_url( home_url() ); ?>" title="<?php _e('Logout',IT_TEXTDOMAIN); ?>" data-placement="bottom"></a>
                                
                                <?php } ?>
                                
                                <?php  $register = 'false';
                                if(!empty($_GET)) {
                                    if(array_key_exists('register', $_GET)) $register = $_GET['register']; 
                                }
                                if($register == 'true') { ?>
                                
                                    <div class="sticky-form check-password info" title="<?php _e('click to dismiss',IT_TEXTDOMAIN); ?>" data-placement="bottom">
                                        
                                        <span class="theme-icon-thumbs-up"></span>
                                
                                        <?php _e('Check your email for your password.',IT_TEXTDOMAIN); ?>
                                    
                                    </div>
                                
                                <?php } ?>
                                
                            <?php } ?>
                            
                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
    
        </div>
        
    </div>
    
    <?php if(!$sticky_logo_disable && $header_disable) { ?>
    
    	<div id="sticky-logo-mobile" class="container">
                            
            <div class="logo info-bottom" title="<?php _e('Home',IT_TEXTDOMAIN); ?>">
    
                <?php if(it_get_setting('display_logo') && $logo_url!='') { ?>
                    <a href="<?php echo home_url(); ?>/">
                        <img id="site-logo" alt="<?php bloginfo('name'); ?>" src="<?php echo $logo_url; ?>"<?php echo $dimensions; ?> />   
                        <img id="site-logo-hd" alt="<?php bloginfo('name'); ?>" src="<?php echo $logo_url_hd; ?>"<?php echo $dimensions; ?> />  
                    </a>
                <?php } else { ?>     
                    <h1><a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a></h1>
                <?php } ?>
                
            </div>
            
    	</div>
    
    <?php } ?>

<?php } wp_reset_query();?>