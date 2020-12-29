<?php global $post; ?>
<style type="text/css">
	<?php 	
	#TEMPLATE COLORS - do these before accent colors so hovers apply correctly
	$c = it_get_setting('color_header');
	if(!empty($c)) echo '#header,#sticky-logo-mobile {background:'.$c.'}';	
	$c = it_get_setting('color_header_icons');
	if(!empty($c)) echo '.header-social a {color:'.$c.'}';
	$c = it_get_setting('color_menu');
	$c_rgb = is_array(hex2rgb($c)) ? implode(',', hex2rgb($c)) : '';
	if(!empty($c)) echo '#sticky-bar, .mega-wrapper .term-list, .menu-container .standard-menu ul li ul {background:rgba('.$c_rgb.', 0.92)}';
	$c = it_get_setting('color_menu_border');
	if(!empty($c)) echo '#sticky-bar {border-top-color:'.$c.'}';
	$c = it_get_setting('color_menu_text');
	if(!empty($c)) echo '#section-menu a {color:'.$c.'}';
	$c = it_get_setting('color_menu_icons');
	if(!empty($c)) echo '#sticky-controls a, #random-article, #menu-search-button span, #sticky-menu-selector span, #new-articles .selector .new-number, #new-articles .selector .theme-icon-down-fat, #new-articles .selector .new-label {color:'.$c.'}';
	$c = it_get_setting('color_other');
	if(!empty($c)) echo '.explicit-wrapper, .top-ten-wrapper {background:'.$c.'}';
	$c = it_get_setting('color_footer');
	if(!empty($c)) echo '#footer-wrapper {background:'.$c.'}';
	$c = it_get_setting('color_footer_text');
	if(!empty($c)) echo '#footer, #footer a, #footer #widgets-topten .top-ten-title, #footer .compact-panel .article-title, #footer.widgets .header h3, #footer.widgets .bar-label, #footer.widgets .no-color .bar-label, #footer.widgets .social-counts a, #footer .widgets .header-icon, #footer .widgets .bar-label .label-text > span, #footer #widgets-topten .top-ten-number {color:'.$c.'}';
	$c = it_get_setting('color_footer_icons');
	if(!empty($c)) echo '#footer .sort-buttons a, #footer .sort-buttons span.page-numbers {color:'.$c.'}';
	
	#MAIN ACCENT COLOR 
	$accent = it_get_setting('color_accent');
	if(empty($accent)) $accent = '#FF2654';
	$accent_rgb = implode(",", hex2rgb($accent));
	?>		
	a:hover,#sticky-menu-selector:hover,#sticky-controls a:hover,#sticky-controls a.active,#menu-search-button.active span,#menu-search-button.hover span,#random-article:hover,.bar-header a:hover,.utility-menu a:hover,.bar-selected .selector-icon,.sort-buttons a:hover,.sort-buttons a.active,.sort-buttons li.active a,.sortbar.dark .sort-buttons a:hover,.sortbar.dark .sort-buttons a.active,.loop h3 a:hover,.post-blog.articles.gradient .article-panel.active h3 a,.post-blog.articles.gradient .sticky-post .theme-icon-pin,.active .load-more,.active .load-more > span,.headliner-panel.active .headliner-info a.title,.trending-panel.active .trending-number .metric,.trending-panel.active .trending-title,.top-ten-panel.active .top-ten-number,.top-ten-panel.active .top-ten-title,.compact-panel.active .article-title,.border-panel.active .article-title,.widgets .more-link:hover,.widgets .more-link:hover span,.trending-bar.active .title,.active .trending-meta,.widgets .loop .more-link:hover,#widgets-topten .active .top-ten-title,#widgets-topten .active .top-ten-number,.widgets .it-widget-tabs .sort-buttons a.active,.widgets .it-widget-tabs .ui-tabs-active a,.connect-counts .social-counts .social-panel span,.connect-counts .social-counts a:hover,.social-counts .social-panel span,.social-counts a:hover,.widgets #wp-calendar a:hover,#footer a:hover,#footer.widgets #wp-calendar a:hover,#footer .sort-buttons a.active,#footer .top-ten-panel.active .top-ten-number,#footer .top-ten-panel.active .top-ten-title,#footer .compact-panel.active .article-title,#footer.widgets .header .more-link:hover,#footer.widgets .header .more-link:hover span,#footer .social-counts .social-panel span,#footer .social-counts a:hover,#footer.widgets .it-widget-tabs .sort-buttons a.active,#footer.widgets .it-widget-tabs .ui-tabs-active a,#footer.widgets .more-link:hover,#footer.widgets .more-link:hover span,#footer #widgets-topten .active .top-ten-title,#footer #widgets-topten .active .top-ten-number,.reaction.clickable.active,.reaction.selected,.reaction.selected .theme-icon-check,.sticky-post .theme-icon-pin,.contents-menu .sort-buttons a:hover,.the-content a:not(.styled),.postinfo .category-list a:hover,.postinfo .post-tags a,#recommended .sort-buttons a:hover,#recommended .sort-buttons a.active,#comments a.reply-link,#comments span.current,#comments .pagination a:hover,h2.author-name a:hover,.template-authors .author-profile-fields a:hover,.pagination>span.page-number{color:<?php echo $accent; ?>;}
	.the-content a:hover{color:#000;}	
	.sticky-form .sticky-submit,#new-articles .selector.active,#new-articles .post-container a:hover,.article-panel.active .category-icon-wrapper,.article-panel.active .user_rating,.porthole-color,.hero-label,.headliner-label,.active .headliner-readmore .readmore,.trending-color,.postinfo .post-tags a:hover{background:<?php echo $accent; ?>;}	
	.bar-label,.sort-sections a.active,.trending-color{background-color:<?php echo $accent; ?>;}	
	.pagination a:hover,.pagination .active,.pagination a:active,.pagination a.active:hover,/*begin bootstrap compat*/.pagination>.active>a,.pagination>.active>span,.pagination>.active>a:hover,.pagination>.active>span:hover,.pagination>.active>a:focus,.pagination>.active>span:focus,/*end bootstrap compat*/.hover-text.active,.hover-text.active a,.woocommerce .woocommerce-breadcrumb a:hover,.pagination a span.page-number:hover,.utility-menu a:hover{color:<?php echo $accent; ?> !important;}	
	.meter-wrapper .meter,.large-meter .meter-wrapper .meter {border-color:<?php echo $accent; ?>;}	
	.ms-tabs-template .ms-thumb{border-left-color:rgba(<?php echo $accent_rgb; ?>,.5);}
	.ms-tabs-template .ms-thumb-frame-selected .ms-thumb{border-left-color:rgba(<?php echo $accent_rgb; ?>,1);}
	.ms-tabs-template .ms-thumb-frame.ms-thumb-frame-selected .circle-image{opacity:1;}	
	.border-panel {border-left-color:<?php echo $accent; ?>;}	
	.details-box-wrapper,.total-wrapper,#comments .comment-rating-inner{border-top-color:<?php echo $accent; ?>;}
	.porthole{border-bottom-color:<?php echo $accent; ?>}	
	.articles.gradient .article-panel.active .layer-gradient {
	background: -moz-linear-gradient(top,  rgba(0,0,0,0) 45%, rgba(<?php echo $accent_rgb; ?>,1) 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(45%,rgba(0,0,0,0)), color-stop(100%,rgba(<?php echo $accent_rgb; ?>,1)));
	background: -webkit-linear-gradient(top,  rgba(0,0,0,0) 45%,rgba(<?php echo $accent_rgb; ?>,1) 100%);
	background: -o-linear-gradient(top,  rgba(0,0,0,0) 45%,rgba(<?php echo $accent_rgb; ?>,1) 100%);
	background: -ms-linear-gradient(top,  rgba(0,0,0,0) 45%,rgba(<?php echo $accent_rgb; ?>,1) 100%);
	background: linear-gradient(to bottom,  rgba(0,0,0,0) 45%,rgba(<?php echo $accent_rgb; ?>,1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00000000', endColorstr='<?php echo $accent; ?>',GradientType=0 );}	
	.headliner-panel.active .image-gradient {
	background: -moz-linear-gradient(left,  rgba(<?php echo $accent_rgb; ?>,0) 1%, rgba(<?php echo $accent_rgb; ?>,0) 15%, rgba(<?php echo $accent_rgb; ?>,0.8) 100%); 
	background: -webkit-gradient(linear, left top, right top, color-stop(1%,rgba(<?php echo $accent_rgb; ?>,0)), color-stop(15%,rgba(<?php echo $accent_rgb; ?>,0)), color-stop(100%,rgba(<?php echo $accent_rgb; ?>,0.8)));
	background: -webkit-linear-gradient(left,  rgba(<?php echo $accent_rgb; ?>,0) 1%,rgba(<?php echo $accent_rgb; ?>,0) 15%,rgba(<?php echo $accent_rgb; ?>,0.8) 100%);
	background: -o-linear-gradient(left,  rgba(<?php echo $accent_rgb; ?>,0) 1%,rgba(<?php echo $accent_rgb; ?>,0) 15%,rgba(<?php echo $accent_rgb; ?>,0.8) 100%);
	background: -ms-linear-gradient(left,  rgba(<?php echo $accent_rgb; ?>,0) 1%,rgba(<?php echo $accent_rgb; ?>,0) 15%,rgba(<?php echo $accent_rgb; ?>,0.8) 100%);
	background: linear-gradient(to right,  rgba(<?php echo $accent_rgb; ?>,0) 1%,rgba(<?php echo $accent_rgb; ?>,0) 15%,rgba(<?php echo $accent_rgb; ?>,0.8) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00000000', endColorstr='<?php echo $accent; ?>',GradientType=1 );}	
	.explicit-panel.active .explicit-gradient {
	background: -moz-linear-gradient(top,  rgba(<?php echo $accent_rgb; ?>,0) 0%, rgba(<?php echo $accent_rgb; ?>,1) 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(<?php echo $accent_rgb; ?>,0)), color-stop(100%,rgba(<?php echo $accent_rgb; ?>,1)));
	background: -webkit-linear-gradient(top,  rgba(<?php echo $accent_rgb; ?>,0) 0%,rgba(<?php echo $accent_rgb; ?>,1) 100%);
	background: -o-linear-gradient(top,  rgba(<?php echo $accent_rgb; ?>,0) 0%,rgba(<?php echo $accent_rgb; ?>,1) 100%);
	background: -ms-linear-gradient(top,  rgba(<?php echo $accent_rgb; ?>,0) 0%,rgba(<?php echo $accent_rgb; ?>,1) 100%);
	background: linear-gradient(to bottom,  rgba(<?php echo $accent_rgb; ?>,0) 0%,rgba(<?php echo $accent_rgb; ?>,1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00000000', endColorstr='<?php echo $accent; ?>',GradientType=0 );}	
	.articles.gradient .article-panel.active .editor_rating.stars_wrapper, .overlay-panel.active .overlay-layer {background:rgba(<?php echo $accent_rgb; ?>,.8);}
	<?php
	#MAIN TEXT COLOR
	$color = it_get_setting('color_main_text');
	if(!empty($color)) {
	?>
		.container.boxed,.section-subtitle,#rating-anchor.ratings .rating-label,#rating-anchor.ratings .rating-value-wrapper,.reaction.clickable,.the-content a:not(.styled),.articles .excerpt,.ratings.stars-wrapper .rating-value .stars span:before,.container.boxed .compact-panel .article-title,.post-blog.articles.gradient h3 a,.articles .award-wrapper,h1.main-title{color:<?php echo $color; ?>;}
	<?php }
	
	#FONTS
	$f = it_get_setting('font_section_menu');	    
	if(!empty($f) && $f!='spacer') echo '#section-menu a, #section-menu .mega-wrapper .term-list a {font-family:'.$f.';}';
	$f = it_get_setting('font_section_menu_size');	    
	if(!empty($f)) echo '#section-menu a, #section-menu .mega-wrapper .term-list a {font-size:'.$f.'px;line-height:'.$f.'px;}';
	$f = it_get_setting('font_slideout_menu');	    
	if(!empty($f) && $f!='spacer') echo '.mm-menu a {font-family:'.$f.';}';
	$f = it_get_setting('font_slideout_menu_size');	    
	if(!empty($f)) echo '.mm-menu a {font-size:'.$f.'px;line-height:'.$f.'px;}';
	$f = it_get_setting('font_utility_menu');	    
	if(!empty($f) && $f!='spacer') echo '.utility-menu a, .contents-menu .sort-buttons a, #recommended .sort-buttons a {font-family:'.$f.';}';
	$f = it_get_setting('font_utility_menu_size');	    
	if(!empty($f)) echo '.utility-menu a {font-size:'.$f.'px;line-height:'.$f.'px;}';				
	$f = it_get_setting('font_section_headers');	    
	if(!empty($f) && $f!='spacer') echo '.bar-label .label-text, .widgets .header h3, .widgets .no-color .bar-label, .details-box .detail-label, .section-subtitle, .reaction-text {font-family:'.$f.';} ';			
	$f = it_get_setting('font_links');	    
	if(!empty($f) && $f!='spacer') echo '.explicit-info h3, .ms-tabs-template .ms-thumb-frame h3, .top-ten-title, .trending-title, .porthole-info h3, .articles h3 a, .overlay-panel .article-title, .trending-bar .title, .compact-panel .article-title, #new-articles .post-container a {font-family:'.$f.';} ';
	$f = it_get_setting('font_titles');	    
	if(!empty($f) && $f!='spacer') echo '.post-blog.articles.gradient h3 a, .ms-layer.ms-caption-title h2 a, h1.main-title {font-family:'.$f.'!important;} ';
	$f = it_get_setting('font_titles_size');	    
	if(!empty($f)) echo '.post-blog.articles.gradient h3 a, .ms-layer.ms-caption-title h2 a {font-size:'.$f.'px !important;line-height:'.$f.'px;}';
	$f = it_get_setting('font_titles_single_size');	    
	if(!empty($f)) echo 'h1.main-title {font-size:'.$f.'px;line-height:'.$f.'px;}';
	$f = it_get_setting('font_hero_size');	    
	if(!empty($f)) echo '.ms-layer.ms-caption-title h2 a {font-size:'.$f.'px;line-height:'.$f.'px;}';
	$f = it_get_setting('font_headliner');	    
	if(!empty($f) && $f!='spacer') echo '.headliner-info a.title, .billboard h1.main-title {font-family:'.$f.' !important;} ';
	$f = it_get_setting('font_headliner_size');	    
	if(!empty($f)) echo '.headliner-info a.title {font-size:'.$f.'px;line-height:'.$f.'px;}';
	$f = it_get_setting('font_awards');	    
	if(!empty($f) && $f!='spacer') echo '.award-wrapper {font-family:'.$f.';} ';
	$f = it_get_setting('font_awards_size');	    
	if(!empty($f)) echo '.award-wrapper {font-size:'.$f.'px;line-height:'.$f.'px;}';
	$f = it_get_setting('font_numbers');	    
	if(!empty($f) && $f!='spacer') echo '#new-articles .selector .new-number, .pagination a, a.like-button, .metric, .connect-counts .social-counts a, .trending-number .metric, .top-ten-number, .trending-bar .trending-meta .metric, .widgets .social-counts a, .share-wrapper .addthis_20x20_style .addthis_counter.addthis_bubble_style.addthis_native_counter a.addthis_button_expanded, .reaction-percentage, #comments span.current, #comments span.dots, .rating .number, .rating .letter, .rating .percentage, #comments .comment-rating .rating-wrapper, .ratings .rating-criteria, #respond .ratings .rating-wrapper {font-family:'.$f.';} ';
	$f = it_get_setting('font_section_titles');	    
	if(!empty($f) && $f!='spacer') echo '.section-title {font-family:'.$f.';} ';
	$f = it_get_setting('font_section_titles_size');	    
	if(!empty($f)) echo '.section-title {font-size:'.$f.'px;line-height:'.$f.'px;}';
	$f = it_get_setting('font_text');	    
	if(!empty($f) && $f!='spacer') echo '.the-content, #main-content p, .articles .excerpt, .procon-box .procon, .details-box .detail-content, .ratings .bottomline {font-family:'.$f.';} ';
	$f = it_get_setting('font_text_size');	    
	if(!empty($f)) echo '.the-content, .articles .excerpt, .procon-box .procon, .post-blog.articles.compact .excerpt, .details-box .detail-content, .ratings .bottomline, .author-bio {font-size:'.$f.'px;}';
	$f = it_get_setting('font_serif');	    
	if(!empty($f) && $f!='spacer') echo '#header .subtitle, #new-articles .selector .new-label, .porthole-circle .rating-wrapper .full-review, .authorship, .authorship a, .postnav-button .article-label, .billboard-subtitle, .postinfo a.author-name, #comments .comment-author, .author-link a {font-family:'.$f.';} ';
	
	#BOXED BACKGROUND 
	$bg_boxed = it_get_setting('color_boxed');
	if(empty($bg_boxed) || strlen($bg_boxed)!=7) $bg_boxed = '#F3F3FB';
	$bg_boxed_bg = it_get_setting('color_boxed_bg');
	if(empty($bg_boxed_bg) || strlen($bg_boxed_bg)!=7) $bg_boxed_bg = '#D2D2D8';
	$template = it_get_template_file();
	if(it_boxed_page()) {
		echo '.after-header > .container, .container.boxed, .ratings .rating-label, .ratings.stars-wrapper .rating-value-wrapper {background:' . $bg_boxed . ';}';
		echo 'body.it-background {background-color:' . $bg_boxed_bg . ' !important;}';
	} else {
		#this will apply when boxed layout is turned off when viewing a single post with the billboard layout
		$bg_boxed_bg = $bg_boxed;	
	}
	#BILLBOARD BACKGROUND
	$bg_billboard = it_get_setting('color_billboard_bg');
	if(empty($bg_billboard) || strlen($bg_billboard)!=7) $bg_billboard = $bg_boxed_bg;
	#need only hex code for ie
	$ie_billboard = str_replace('#','',$bg_billboard);		
	#override the main site background with the billboard background
	if(is_single()) echo 'body.it-background {background-color:' . $bg_billboard . ' !important;}';				
	
	#GET PAGE SPECIFIC BACKGROUNDS
	if(is_single() || is_page()) { 		
		$bg_color = get_post_meta($post->ID, "_bg_color", $single = true);
				if(!empty($bg_color) && $bg_color!='#') $bg_billboard = $bg_color;
		$bg_color_override = get_post_meta($post->ID, "_bg_color_override", $single = true);
		$bg_image = get_post_meta($post->ID, "_bg_image", $single = true);
		$bg_position = get_post_meta($post->ID, "_bg_position", $single = true);
		$bg_repeat = get_post_meta($post->ID, "_bg_repeat", $single = true);
		$bg_attachment = get_post_meta($post->ID, "_bg_attachment", $single = true);
		$bg_overlay = get_post_meta($post->ID, "_bg_overlay", $single = true);
		$layout = is_single() ? it_get_setting('post_layout') : 'classic';
		$layout_meta = get_post_meta($post->ID, "_post_layout", $single = true);
		if(!empty($layout_meta) && $layout_meta!='') $layout = $layout_meta;		
	}
	#GET CATEGORY SPECIFIC BACKGROUNDS - overwrites page-specific if any
	$category_id = it_page_in_category($post->ID);
	if($category_id) {
		$categories = it_get_setting('categories');	 
		foreach($categories as $category) {
			if(is_array($category)) {
				if(array_key_exists('id',$category)) {
					if($category['id'] == $category_id) {
						if(!empty($category['bg_color'])) {
							$bg_color=$category['bg_color'];
							$bg_color_override='';
						}
						if(!empty($category['bg_image'])) $bg_image=$category['bg_image'];
						if(!empty($category['bg_position'])) $bg_position=$category['bg_position'];
						if(!empty($category['bg_repeat'])) $bg_repeat=$category['bg_repeat'];
						if(!empty($category['bg_attachment'])) $bg_attachment=$category['bg_attachment'];
						break;
					}
				}
			}
		}		
	}
	#APPLY BACKGROUNDS
	if(is_single() || is_page() || $category_id) {
		if($bg_color) { ?>
			body.it-background {background-color:<?php echo $bg_color; ?> !important;}
		<?php } ?>
		<?php if($bg_color_override) { ?>
			body.it-background {background-image:none !important;}
		<?php } ?>
		<?php if($bg_image) { ?>
			body.it-background {background-image:url(<?php echo $bg_image; ?>) !important;}
		<?php } ?>
		<?php if($bg_position) { ?>
			body.it-background {background-position:top <?php echo $bg_position; ?> !important;}
		<?php } ?>
		<?php if($bg_repeat) { ?>
			body.it-background {background-repeat:<?php echo $bg_repeat; ?> !important;}
		<?php } ?>
		<?php if($bg_attachment) { ?>
			body.it-background {background-attachment:<?php echo $bg_attachment; ?> !important;}
		<?php } ?>	
		<?php if($layout=='billboard') { ?>
			body.it-background {background-image:none !important;}
			.container.boxed {background:<?php echo $bg_boxed ?>;}
		<?php } 
	}
	#display this after the page specific in case this post has a unique background color assigned 
	$billboard_rgb = implode(",", hex2rgb($bg_billboard)); ?>	
	.billboard-overlay {
	background: -moz-linear-gradient(top,  rgba(<?php echo $billboard_rgb; ?>,0) 30%, rgba(<?php echo $billboard_rgb; ?>,1) 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(30%,rgba(<?php echo $billboard_rgb; ?>,0)), color-stop(100%,rgba(<?php echo $billboard_rgb; ?>,1)));
	background: -webkit-linear-gradient(top,  rgba(<?php echo $billboard_rgb; ?>,0) 30%,rgba(<?php echo $billboard_rgb; ?>,1) 100%);
	background: -o-linear-gradient(top,  rgba(<?php echo $billboard_rgb; ?>,0) 30%,rgba(<?php echo $billboard_rgb; ?>,1) 100%);
	background: -ms-linear-gradient(top,  rgba(<?php echo $billboard_rgb; ?>,0) 30%,rgba(<?php echo $billboard_rgb; ?>,1) 100%);
	background: linear-gradient(to bottom,  rgba(<?php echo $billboard_rgb; ?>,0) 30%,rgba(<?php echo $billboard_rgb; ?>,1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00<?php echo $ie_billboard; ?>', endColorstr='#FF<?php echo $ie_billboard; ?>',GradientType=0 ); }	
	<?php 
	#CATEGORIES
	$categories = it_get_setting('categories');
	$visible_colors = it_get_setting('section_menu_visible_colors');
	foreach($categories as $category) {
		if(is_array($category)) {
			if(array_key_exists('id',$category)) {
				if(!empty($category['id'])) {
					$id = $category['id'];
					$icon = $category['icon'];
					$iconhd = $category['iconhd'];
					$iconwhite = $category['iconwhite'];
					$iconhdwhite = $category['iconhdwhite'];
					if(empty($iconwhite)) $iconwhite = $icon;
					if(empty($iconhdwhite)) $iconhdwhite = $iconhd;	
					$color = $category['color'];
					$color_rgb = empty($color) ? '' : implode(",", hex2rgb($color));
					?>
					<?php if($visible_colors) { ?>
					#section-menu ul li.menu-item-<?php echo $id; ?> > a{border-top:3px solid <?php echo $color; ?>;padding-top:7px;}
					#section-menu ul li.menu-item-<?php echo $id; ?> > a.no-icon{padding-top:17px;}
					<?php } ?>
					#section-menu ul li.menu-item-<?php echo $id; ?>.hover > a,
					#section-menu ul li.menu-item-<?php echo $id; ?>.over > a,
					#section-menu ul li.menu-item-<?php echo $id; ?>.current-menu-item > a {border-top-color:<?php echo $color; ?>;}					
					#section-menu ul li.menu-item-<?php echo $id; ?> .mega-wrapper .term-list a:hover, 
					#section-menu ul li.menu-item-<?php echo $id; ?> .mega-wrapper .term-list a.active, 
					#section-menu ul li.menu-item-<?php echo $id; ?> .mega-wrapper .post-list a:hover, 
					#section-menu ul li.menu-item-<?php echo $id; ?> .mega-wrapper .post-list a.view-all, 
					.post-blog.articles.gradient .article-panel.category-<?php echo $id; ?>.active h3 a,
					.compact-panel.category-<?php echo $id; ?>.active .article-title,
					.border-panel.category-<?php echo $id; ?>.active .article-title {color:<?php echo $color; ?>;}
					#section-menu ul li.menu-item-<?php echo $id; ?> .mega-wrapper .post-list a.view-all:hover {background-color:<?php echo $color; ?>;color:#FFF;}
					.porthole.category-<?php echo $id; ?> {border-bottom-color:<?php echo $color; ?>;border-left-color:<?php echo $color; ?>;}
					.porthole.category-<?php echo $id; ?> .porthole-color,
					.article-panel.active.category-<?php echo $id; ?> .category-icon-wrapper,
					.article-panel.active.category-<?php echo $id; ?> .user_rating {background:<?php echo $color; ?>;}
					.articles.gradient .article-panel.active.category-<?php echo $id; ?> .layer-gradient {
					background: -moz-linear-gradient(top,  rgba(0,0,0,0) 45%, rgba(<?php echo $color_rgb; ?>,1) 100%);
					background: -webkit-gradient(linear, left top, left bottom, color-stop(45%,rgba(0,0,0,0)), color-stop(100%,rgba(<?php echo $color_rgb; ?>,1)));
					background: -webkit-linear-gradient(top,  rgba(0,0,0,0) 45%,rgba(<?php echo $color_rgb; ?>,1) 100%);
					background: -o-linear-gradient(top,  rgba(0,0,0,0) 45%,rgba(<?php echo $color_rgb; ?>,1) 100%);
					background: -ms-linear-gradient(top,  rgba(0,0,0,0) 45%,rgba(<?php echo $color_rgb; ?>,1) 100%);
					background: linear-gradient(to bottom,  rgba(0,0,0,0) 45%,rgba(<?php echo $color_rgb; ?>,1) 100%);
					filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00000000', endColorstr='<?php echo $color; ?>',GradientType=0 );}
					.articles.gradient .article-panel.active.category-<?php echo $id; ?> .editor_rating.stars_wrapper, .overlay-panel.active.category-<?php echo $id; ?> .overlay-layer {background:rgba(<?php echo $color_rgb; ?>,.8);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $color; ?>', endColorstr='<?php echo $color; ?>',GradientType=1 ); /* IE6-9 */}
					.article-panel.category-<?php echo $id; ?> .meter-wrapper .meter{border-color:<?php echo $color; ?>;}	
					.ms-tabs-template .ms-thumb.category-<?php echo $id; ?> {border-left-color:rgba(<?php echo $color_rgb; ?>,.5);}
					.ms-tabs-template .ms-thumb-frame-selected .ms-thumb.category-<?php echo $id; ?> {border-left-color:rgba(<?php echo $color_rgb; ?>,1);}
					.border-panel.category-<?php echo $id; ?> {border-left-color:<?php echo $color; ?>;}
					/*.category-<?php echo $id; ?> .postnav-button.active,
					.category-<?php echo $id; ?> .postnav-button.active .article-info,*/
					.category-<?php echo $id; ?> .bar-label,
					#directory-<?php echo $id; ?> .bar-label {background:<?php echo $color; ?>;}
					.category-<?php echo $id; ?> .reaction.clickable.active, 
					.category-<?php echo $id; ?> .reaction.selected, 
					.category-<?php echo $id; ?> .reaction.selected .theme-icon-check,
					.category-<?php echo $id; ?> .postinfo .category-list a:hover,
					.category-<?php echo $id; ?> .postinfo .post-tags a,
					.category-<?php echo $id; ?> #recommended .sort-buttons a:hover, 
					.category-<?php echo $id; ?> #recommended .sort-buttons a.active,
					.category-<?php echo $id; ?> #comments a.reply-link,
					.category-<?php echo $id; ?> #comments span.current {color:<?php echo $color; ?>;}
					.category-<?php echo $id; ?> #comments .pagination a:hover {color:<?php echo $color; ?> !important;}
					.category-<?php echo $id; ?> .postinfo .post-tags a:hover {background:<?php echo $color; ?>;}
					.category-<?php echo $id; ?> .details-box-wrapper, 
					.category-<?php echo $id; ?> .total-wrapper,
					.category-<?php echo $id; ?> #comments .comment-rating-inner {border-top-color:<?php echo $color; ?>;}
					.category-<?php echo $id; ?> .large-meter .meter-wrapper .meter {border-color:<?php echo $color; ?>;}
					@media screen {
					.category-icon-<?php echo $id; ?> {background:url(<?php echo $icon; ?>) no-repeat 0px 0px;background-size:16px 16px !important;width:16px;height:16px;float:left;}
					.category-icon-<?php echo $id; ?>.white, #footer .category-icon-<?php echo $id; ?>, .sort-sections a.active .category-icon-<?php echo $id; ?> {background:url(<?php echo $iconwhite; ?>) no-repeat 0px 0px;background-size:16px 16px !important;width:16px;height:16px;float:left;}		
					}
					@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
					.category-icon-<?php echo $id; ?> {background:url(<?php echo $iconhd; ?>) no-repeat 0px 0px;background-size:16px 16px !important;width:16px;height:16px;float:left;}
					.category-icon-<?php echo $id; ?>.white, #footer .category-icon-<?php echo $id; ?>, .sort-sections a.active .category-icon-<?php echo $id; ?> {background:url(<?php echo $iconhdwhite; ?>) no-repeat 0px 0px;background-size:16px 16px !important;width:16px;height:16px;float:left;}		
					}
				<?php } 
			}
		}
	}	
	#AWARDS/BADGES
	$awards = it_get_setting('review_awards');
	foreach($awards as $award){ 
		if(is_array($award)) {
			if(array_key_exists(0, $award)) {
				$awardname = stripslashes($award[0]->name);
				$awardid = it_get_slug($awardname, $awardname);
				$awardicon = $award[0]->icon;
				$awardiconwhite = $award[0]->iconwhite;
				if(empty($awardiconwhite)) $awardiconwhite = $awardicon;
				?>
				.award-icon-<?php echo $awardid; ?> {background:url(<?php echo $awardicon; ?>) no-repeat 0px 0px;background-size:16px 16px !important;width:16px;height:16px;float:left;}
				.white .award-icon-<?php echo $awardid; ?>, #footer .award-icon-<?php echo $awardid; ?> {background:url(<?php echo $awardiconwhite; ?>) no-repeat 0px 0px;background-size:16px 16px !important;width:16px;height:16px;float:left;}
			<?php } 
		}
	}
#APPLY CUSTOM CSS - leave the opening/closing php tags to create better view source readability
#general
if( it_get_setting( 'custom_css' ) ) echo stripslashes( it_get_setting( 'custom_css' ) );	
?>
<?php 
#large only
if( it_get_setting( 'custom_css_lg' ) ) { ?> 
@media (min-width: 1200px) {<?php echo stripslashes( it_get_setting( 'custom_css_lg' ) )?>} 
<?php }
#medium and down
if( it_get_setting( 'custom_css_md' ) ) { ?> 
@media (max-width: 1199px) {<?php echo stripslashes( it_get_setting( 'custom_css_md' ) )?>} 
<?php }
#medium only
if( it_get_setting( 'custom_css_md_only' ) ) { ?> 
@media (min-width: 992px) and (max-width: 1199px) {<?php echo stripslashes( it_get_setting( 'custom_css_md_only' ) )?>} 
<?php }
#small and down
if( it_get_setting( 'custom_css_sm' ) ) { ?> 
@media (max-width: 991px) {<?php echo stripslashes( it_get_setting( 'custom_css_sm' ) )?>} 
<?php }
#small only
if( it_get_setting( 'custom_css_sm_only' ) ) { ?> 
@media (min-width: 768px) and (max-width: 991px) {<?php echo stripslashes( it_get_setting( 'custom_css_sm_only' ) )?>} 
<?php }
#extra small only
if( it_get_setting( 'custom_css_xs' ) ) { ?> 
@media (max-width: 767px) {<?php echo stripslashes( it_get_setting( 'custom_css_xs' ) )?>} 
<?php }	?>
</style>