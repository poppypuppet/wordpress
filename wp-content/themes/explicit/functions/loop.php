<?php 
if(!function_exists('it_loop')) {
	function it_loop($args, $format, $timeperiod = '') {
	
		if(!is_array($format)) $format = array();
		extract($format);
		if(empty($location)) $location = $loop; #a specified location overrides the loop parameter
		
		#don't care about pagename if we're displaying a post loop on a content page
		$args['pagename'] = '';
		
		#add a filter if this loop needs a time constraint (can't add to query args directly)
		global $timewhere;
		$timewhere = $timeperiod;
		if(!empty($timeperiod)) {		
			add_filter( 'posts_where', 'filter_where' );
		}	
		#query the posts
		$itposts = new WP_Query( $args );
		#remove the filter after we're done
		if(!empty($timeperiod)) {				
			remove_filter( 'posts_where', 'filter_where' );
		}
		
		#setup ads array
		$ads=array();
		$ad1=it_get_setting('loop_ad_1');
		$ad2=it_get_setting('loop_ad_2');
		$ad3=it_get_setting('loop_ad_3');
		$ad4=it_get_setting('loop_ad_4');
		$ad5=it_get_setting('loop_ad_5');
		$ad6=it_get_setting('loop_ad_6');
		$ad7=it_get_setting('loop_ad_7');
		$ad8=it_get_setting('loop_ad_8');
		$ad9=it_get_setting('loop_ad_9');
		$ad10=it_get_setting('loop_ad_10');
		if(!empty($ad1)) array_push($ads,$ad1);
		if(!empty($ad2)) array_push($ads,$ad2);
		if(!empty($ad3)) array_push($ads,$ad3);
		if(!empty($ad4)) array_push($ads,$ad4);
		if(!empty($ad5)) array_push($ads,$ad5);
		if(!empty($ad6)) array_push($ads,$ad6);
		if(!empty($ad7)) array_push($ads,$ad7);
		if(!empty($ad8)) array_push($ads,$ad8);
		if(!empty($ad9)) array_push($ads,$ad9);
		if(!empty($ad10)) array_push($ads,$ad10);
		if(it_get_setting('ad_shuffle')) shuffle($ads);
	
		#counters
		$i=0;
		$p=0;
		$m=0;	
		$a=0;
		$b=0;
		$out = '';
		#sometimes the following variables are not passed
		$width = isset($width) ? $width : '';
		$height = isset($height) ? $height : '';
		$size = isset($size) ? $size : '';
		$nonajax = isset($nonajax) ? $nonajax : '';
		$disable_ads = isset($disable_ads) ? $disable_ads : false;
		
		$updatepagination=1;
		$perpage = $args['posts_per_page'];
		$posts_shown = $itposts->found_posts;
		if($posts_shown > $perpage) $posts_shown = $perpage;
		$percol = ceil($posts_shown / 4); #articles per column for new articles panel
		$first = true;
		if ($itposts->have_posts()) : while ($itposts->have_posts()) : $itposts->the_post(); $m++;	
			
			#featured video
			$video = get_post_meta(get_the_ID(), "_featured_video", $single = true);
			
			#subtitle
			$subtitle = get_post_meta(get_the_ID(), "_subtitle", $single = true);
				
			#get just the primary category id
			$categoryargs = array('postid' => get_the_ID(), 'label' => false, 'icon' => false, 'white' => true, 'single' => true, 'wrapper' => false, 'id' => true);	
			$category_id = it_get_primary_categories($categoryargs);
			
			#re-setup category args for actual display
			$categoryargs = array('postid' => get_the_ID(), 'label' => true, 'icon' => true, 'white' => false, 'single' => false, 'wrapper' => false, 'id' => false);
				
			$awardsargs = array('postid' => get_the_ID(), 'single' => true, 'badge' => false, 'white' => false, 'wrapper' => true);
			
			$editorargs = array('postid' => get_the_ID(), 'single' => false, 'meter' => true);
			
			$userargs = array('postid' => get_the_ID(), 'single' => false, 'user_icon' => true, 'small' => '');
			
			$likesargs = array('postid' => get_the_ID(), 'label' => false, 'icon' => true, 'clickable' => false);
			
			$viewsargs = array('postid' => get_the_ID(), 'label' => false, 'icon' => true);
			
			$commentsargs = array('postid' => get_the_ID(), 'label' => false, 'icon' => true, 'showifempty' => false, 'anchor_link' => false);
			
			$imageargs = array('postid' => get_the_ID(), 'size' => $size, 'width' => $width, 'height' => $height, 'wrapper' => false, 'itemprop' => false, 'link' => false, 'type' => 'normal', 'caption' => false);
			
			$videoargs = array('url' => $video, 'video_controls' => it_get_setting('loop_video_controls'), 'parse' => true, 'width' => $width, 'height' => $height, 'frame' => true, 'autoplay' => 0, 'type' => 'embed');
			
			$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $size );
					
			switch ($location) {
				case 'portholes': #PORTHOLES
					
					#reset args for actual category icon display
					$categoryargs['icon'] = true;
					$categoryargs['single'] = true;
					$categoryargs['label'] = false;
					$categoryargs['white'] = true;
					$awardsargs['white'] = true;
					$editorargs['meter'] = false;
					
					#defaults
					$deg = array();					
					$deg = it_get_rotate(get_the_ID(), 'editor');					
					$more_text = __('full review',IT_TEXTDOMAIN);
					$cssrated = '';
					
					#non-rated articles
					if(!it_has_rating(get_the_ID(), 'editor')) {
						$cssrated = ' non-rated';
						$deg['amount'] = '360deg';
						$deg['showfill'] = true;
						$more_text = __('read more',IT_TEXTDOMAIN);
					}
					
					$cssfill = $deg['showfill'] ? ' showfill' : '';
					
					#get circle image
					$circle_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'circle-large' );
				
					$out.='<div class="porthole category-' . $category_id . '">';
                        
						$out.='<div class="porthole-image" style="background-image:url(' . $featured_image[0] . ');"></div>';
						
						$out.='<a class="porthole-link" href="' . get_permalink() . '">&nbsp;</a>';
						
						$out.='<div class="porthole-layer"></div>';
						
						$out.='<div class="porthole-color"></div>';
						
						$out.='<div class="porthole-info">';
						
							$out.='<div class="porthole-inner">';
							
								if(!it_get_setting('portholes_award_disable')) $out.=it_get_awards($awardsargs);
								
								if(!it_get_setting('portholes_user_rating_disable')) $out.=it_show_user_rating($userargs);
								
								$out.='<div class="meter-circle-wrapper">';
								
									$out.='<div class="meter-circle' . $cssrated . ' porthole-circle">';
									
										$out.='<div class="image" style="background-image:url(' . $circle_image[0] . ');"></div>';
											
										$out.='<div class="meter-wrapper">';
											
											$out.='<div class="meter-slice' . $cssfill . '">';
										
												$out.='<div class="meter" style="-webkit-transform:rotate(' . $deg['amount'] . ');-moz-transform:rotate(' . $deg['amount'] . ');-o-transform:rotate(' . $deg['amount'] . ');-ms-transform:rotate(' . $deg['amount'] . ');transform:rotate(' . $deg['amount'] . ');"></div>';
												
												if($deg['showfill']) $out.='<div class="meter fill" style="-webkit-transform:rotate(' . $deg['amount'] . ');-moz-transform:rotate(' . $deg['amount'] . ');-o-transform:rotate(' . $deg['amount'] . ');-ms-transform:rotate(' . $deg['amount'] . ');transform:rotate(' . $deg['amount'] . ');"></div>';
												
											$out.='</div>';
											
										$out.='</div>';
										
										$out.='<div class="rating-wrapper">';
										
											$out.=it_show_editor_rating($editorargs);
											
											$out.='<div class="full-review">' . $more_text . '<span class="theme-icon-right-thin"></span></div>';
											
										$out.='</div>';										
										
									$out.='</div>';
									
								$out.='</div>';
							
								$out.=it_get_primary_categories($categoryargs);
								
								$out.='<div class="article-info">';
			
									$out.='<h3>' . it_title(80) . '</h3>';
								
								$out.='</div>';
								
								if(!it_get_setting('portholes_meta_disable')) {
								
									$out.='<div class="article-meta">';
									
										if(!it_get_setting('loop_likes_disable')) $out.=it_get_likes($likesargs);
										
										if(!it_get_setting('loop_views_disable')) $out.=it_get_views($viewsargs);
										
										if(!it_get_setting('loop_comments_disable')) $out.=it_get_comments($commentsargs);
									
									$out.='</div>';
									
								}
								
							$out.='</div>';
							
						$out.='</div>';
						
					$out.='</div>';
				
				break;	
				case 'hero': #HERO SCROLLER
					
					$imageargs['type'] = 'hero';
					$categoryargs['single'] = true;
					$categoryargs['white'] = true;
					$awardsargs['white'] = true;
					$likesargs['tooltip_hide'] = true;
					$viewsargs['tooltip_hide'] = true;
					$commentsargs['tooltip_hide'] = true;
					$videoargs['frame'] = false;
					$videoargs['type'] = 'link';
					$videoargs['video_controls'] = it_get_setting('hero_video_controls');
					
					$csscat = ' no-margin';
					
					$csscircles = $circles ? '' : ' no-circles';
					
					$interval = it_get_setting('hero_interval');
					if(empty($interval)) $interval = '7';
					
					#get circle image
					$circle_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'tiny' );
					if(empty($circle_image)) $circle_image[] = THEME_IMAGES.'/placeholder-45.png';
					
					$out.='<div class="ms-slide" data-delay="' . $interval . '">';
					
						if(it_get_setting('hero_full_click')) {
							
							$out.='<div class="ms-layer ms-caption hero-link-full" data-type="text">';
							
							$out.='<a class="hero-link-full" href="' . get_permalink() . '"></a>';
							
							$out.='</div>';
							
						}
                                
						$out.= it_featured_image($imageargs);
						
						if($title) {
						
							$out.='<div class="ms-layer ms-caption ms-caption-title" data-type="text" data-effect="bottom(80)" data-duration="300" data-ease="easeOutQuart" data-delay="0">';
							
								$out.='<h2><a href="' . get_permalink() . '">' . it_title(200) . '</a></h2>';
								
							$out.='</div>';
							
						}
						
						if($category || $authorship || $rating || $award || $meta) {
						
							$out.='<div class="ms-layer ms-caption ms-caption-column" data-type="text" data-effect="right(90)" data-duration="300" data-ease="easeOutQuart" data-delay="0">';
							
								$out.='<div class="hero-column">';
								
									$out.='<a class="hero-link" href="' . get_permalink() . '"></a>';
									
									if($category) {
								
										$out.='<div class="hero-panel hero-category">' . it_get_primary_categories($categoryargs) . '</div>';
										
									}
									
									if($authorship) {
										
										$out.='<div class="hero-panel hero-authorship">';
										
											$out.= it_get_authorship('date', false, $csscat);
											
											$out.='<div class="hero-flourish"></div>';
											
											$out.= it_get_authorship('author', false, $csscat);
											
										$out.='</div>';
										
									}
									
									if($rating) {
										
										$out.='<div class="hero-panel hero-rating">';
										
											$out.= it_show_editor_rating($editorargs);
										
											$out.= it_show_user_rating($userargs);
											
										$out.='</div>';
										
									}
									
									if($award) {
									
										$out.='<div class="hero-panel hero-award">';
										
											$out.= it_get_awards($awardsargs);
										
										$out.='</div>';
										
									}
									
									if($meta) {
							
										$out.='<div class="hero-panel hero-meta">';
										
											$out.=it_get_likes($likesargs);
											
											$out.=it_get_views($viewsargs);
											
											$out.=it_get_comments($commentsargs);
										
										$out.='</div>';
										
									}
								
								$out.='</div>';
								
							$out.='</div>';
							
						}
						
						if(!$video_disable && !empty($video)) {
							
							$out.=it_video($videoargs);					
						
						}
						
						$out.='<div class="ms-thumb category-' . $category_id . $csscircles . '">';
						
							$out.='<h3>' . it_title(105) . '</h3>';
							
							if($circles) $out.='<div class="circle-image"><img src="' . $circle_image[0] . '" alt="circle image" width="45" height="45" /></div>';
							
						$out.='</div>';
						
					$out.='</div> ';
					
				break;	
				case 'headliner': #HEADLINER
				
					$csscat = ' no-margin';
				
					#get thumbnail image
					$thumbnail_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'wide' );	
					
					$categoryargs['single'] = true;
					$categoryargs['white'] = true;
					
					$this_category = it_get_primary_categories($categoryargs);
					if(empty($this_category)) $category = false;
					
					$out.='<div class="headliner-panel add-active">';	
				
						$out.='<div class="headliner-image" style="background-image:url(' . $featured_image[0] . ');"></div>';
							
						$out.='<a class="headliner-link" href="' . get_permalink() . '">&nbsp;</a>';
						
						$out.='<div class="headliner-layer"></div>';
						
						$out.='<div class="headliner-info clearfix">';
						
							$out.='<div class="image-wrapper">';
						
								$out.='<div class="image-thumbnail" style="background-image:url(' . $thumbnail_image[0] . ');"></div>';
								
								$out.='<div class="image-gradient"></div>';
								
							$out.='</div>';
						
							$out.='<a class="styled title" href="'.get_permalink().'">'.it_title(90).'</a>';
							
							if($authorship) {
									
								$out.='<div class="headliner-authorship">';
								
									$out.= it_get_authorship('date', false, $csscat);
									
									$out.= it_get_authorship('author', true, $csscat);
									
								$out.='</div>';
								
							}
							
							if($category) {
							
								$out.='<div class="headliner-category">' . $this_category . '</div>';
								
							}
							
							$out.='<div class="headliner-readmore">';
							
								$out.='<div class="readmore">' . __('READ STORY',IT_TEXTDOMAIN) . '<span class="theme-icon-right-fat"></span></div>';
							
							$out.='</div>';										
							
						$out.='</div>';
						
					$out.='</div>';
				
				break;		
				case 'explicit': #EXPLICIT SCROLLER
				
					$out.='<div class="explicit-panel add-active">';
					
						$out.='<a class="explicit-link" href="' . get_permalink() . '"></a>';
						
						$out.='<div class="explicit-image">' . it_featured_image($imageargs) . '</div>';
						
						$out.='<div class="explicit-gradient"></div>';
							
						$out.='<div class="explicit-info">';
						
							if($rating) {
								
								$out.=it_show_editor_rating($editorargs);
								
								$out.=it_show_user_rating($userargs);
							
							}

							if($title) $out.= '<h3>' . it_title(100) . '</h3>';
						
						$out.='</div>';
						
					$out.='</div>';
				
				break;
				case 'trending slider': #TRENDING BUILDER PANEL	
				
					$viewsargs['icon'] = false;
					$likesargs['icon'] = false;
					$commentsargs['icon'] = false;	
					
					#get circle image
					$circle_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'tiny' );
				
					$out.='<div class="trending-panel add-active active-image">';
					
						$out.='<a class="trending-link" href="'.get_permalink().'"></a>';
				
						$out.='<div class="trending-number">';
						
							if($metric=='liked') $out.=it_get_likes($likesargs);
								
							if($metric=='viewed') $out.=it_get_views($viewsargs);
							
							if($metric=='commented') $out.=it_get_comments($commentsargs);
						
						$out.='</div>';
						
						$out.='<div class="trending-circle-image"><img src="' . $circle_image[0] . '" alt="circle image" width="45" height="45" /></div>';
						
						$out.='<div class="trending-title">'.it_title('80').'</div>';
						
					$out.='</div>';
				
				break;
				case 'top ten': #TOP TEN BUILDER PANEL
				
					$number = $i+1;	
					
					$csslast = ($i+1) % 5 == 0 ? ' last' : '';		
				
					$out.='<div class="top-ten-panel add-active' . $csslast . '">';
					
						$out.='<a class="top-ten-link" href="'.get_permalink().'"></a>';
				
						$out.='<div class="top-ten-number">' . $number . '</div>';
						
						$out.='<div class="top-ten-title">'.it_title('100').'</div>';
						
					$out.='</div>';
					
					if (($i+1) % 5 == 0) $out.='<br class="clearer" />';
				
				break;	
				case 'new articles': #NEW ARTICLES	
				
					$categoryargs['single'] = true;
					$categoryargs['white'] = true;
					$categoryargs['label'] = false;
				
					$category = it_get_primary_categories($categoryargs);	
				
					$out.='<div class="list-item';
					if(empty($category)) $out.=' no-icon';
					$out.='">';
						
						$out.='<a href="'.get_permalink().'"';
						
						if($first) $out.=' class="first"';
						
						$out.='>'.get_the_title().'</a>';	
						
						$out.=$category;							
						
					$out.='</div>';
					
					if($m % $percol==0) {
						$first = false;
						$out.='</div><div class="column">';
					}
				
				break;		
				case 'menu': #POSTS LISTED WITHIN MEGA MENU	
				
					$cssthumbnail = $thumbnail ? '' : ' no-thumbnail';
					$out.='<a href="'.get_permalink().'" class="post-item' . $cssthumbnail . '">' . get_the_title();
					if($thumbnail) $out.=it_featured_image($imageargs);
					$out.='</a>';										
					
				break;
				case 'main loop': #MAIN LOOP
				
					#setup variables
					$len_excerpt = it_get_setting('loop_excerpt_length');
					$loop_subtitle = it_get_setting('loop_subtitle');					
					if(empty($len_excerpt) || !is_numeric($len_excerpt)) $len_excerpt = $view == 'list' ? 700 : 480;
					$len_title = $view == 'list' ? 200 : 85;						
					$csspost = is_sticky() ? ' sticky-post' : '';	
					#defaults
					$width = 263;
					$height = 180;
					if(empty($size)) $size = 'grid-4';					
					$csscol = ' col-md-12';
					#column-specific
					switch($columns) {
						case '2':
							$width = 360;
							$height = 250;
							$csscol = ' col-md-6';
							$size = 'grid-3';
						break;
						case '3':
							if($layout=='full') {
								$width = 360;
								$height = 250;
								$csscol = ' col-md-4';
								$size = 'grid-3';
							} else {
								$width = 263;
								$height = 180;
								$csscol = ' col-md-4';
								$size = 'grid-4';	
							}
						break;	
						case '4':
							$width = 263;
							$height = 180;
							$csscol = ' col-md-3';
							$size = 'grid-4';	
						break;
					}
						
					#show ads in the loop
					if(!$disable_ads) {			
						$the_ad = it_get_ad($ads, $m, $a, $columns, $nonajax);
						$m = $the_ad['postcount']; #get updated post count
						$a = $the_ad['adcount']; #get updated ad count	
					}
					
					#loop specific arg adjustments
					$categoryargs['label'] = false;
					$categoryargs['white'] = true;
					$categoryargs['wrapper'] = true;
					$categoryargs['single'] = true;
					$badgesargs = $awardsargs;
					$badgesargs['badge'] = true;
					$likesargs['clickable'] = true;
					$videoargs['width'] = $width;
					$videoargs['height'] = $height;
					
					$cats = it_get_primary_categories($categoryargs);					
					$csscat = !empty($cats) ? '' : ' no-margin';
					
					$title = '<h3><a href="'.get_permalink().'">';
					if(is_sticky()) $title .= '<span class="theme-icon-pin"></span>';
					$title .= it_title($len_title);
					if($loop_subtitle) $title .= '<span class="loop-subtitle">&nbsp;&mdash;&nbsp;' . $subtitle . '</span>';
					$title .= '</a></h3>';
					
					$imageargs['size'] = $size;
					$imageargs['width'] = $width;
					$imageargs['height'] = $height;
					
					$video_disable = false;
					if(empty($video) || !it_get_setting('loop_video')) $video_disable = true;
					$cssvideo = $video_disable ? '' : ' video';
					
					#begin html output
					$out .= $the_ad['ad'];
											
					$out.='<div class="article-panel add-active clearfix category-' . $category_id . $csscol . $csspost . $cssvideo . ' ' . $size . '">';
					
						$out.='<a class="layer-link" href="' . get_permalink() . '">&nbsp;</a>';
					
						$out.='<div class="article-image-wrapper">';                      
							
							$out.='<div class="article-image">';
							
								$out.='<div class="layer-gradient"></div>';
							
								if($rating && !it_get_setting('loop_rating_disable')) $out.=it_show_editor_rating($editorargs);
							
								if(!$video_disable) {
									$out.=it_video($videoargs);
								} else {                        
									$out.='<a href="'.get_permalink().'">'.it_featured_image($imageargs).'</a>';
								}
								
								$out .= $cats;
								
								if($rating && !it_get_setting('loop_rating_disable')) $out.=it_show_user_rating($userargs);	
								
								if($view=='grid') $out .= $title;
							
							$out.='</div>';
					
						$out.='</div>'; 
						
						if(!it_get_setting('loop_authorship_disable') && $view=='grid') $out.=it_get_authorship('date', false, $csscat);
						
						$out .= '<div class="article-info">';
						
							if(!$video_disable && $view!='list') $out .= $title;
						
							if($award && !it_get_setting('loop_award_disable')) $out.=it_get_awards($awardsargs); 
							
							if($view=='list') {
								
								$out .= $title;
								
								if(!it_get_setting('loop_authorship_disable')) $out.=it_get_authorship();
								
							}
							
							if(!it_get_setting('loop_excerpt_disable')) {
								
								$out.='<div class="excerpt">';
							
									$out.='<div class="excerpt-text">' . it_excerpt($len_excerpt) . '</div>';
								
								$out.='</div>';
							
							}
							
							if(!it_get_setting('loop_badge_disable')) $out.=it_get_awards($badgesargs);
							
							if(!it_get_setting('loop_meta_disable')) {
						
								$out.='<div class="article-meta">';
								
									if(!it_get_setting('loop_likes_disable')) $out.=it_get_likes($likesargs);
									
									if(!it_get_setting('loop_views_disable')) $out.=it_get_views($viewsargs);
									
									if(!it_get_setting('loop_comments_disable')) $out.=it_get_comments($commentsargs);
								
								$out.='</div>';
								
							}
							
							if(!it_get_setting('loop_authorship_disable') && $view=='grid') $out.=it_get_authorship('author');
							
						$out.='</div>';						
						 
					$out.='</div>';
					
					if($m % $columns==0) $out.='<br class="clearer" />';
				
				break;
				case 'widget_a': #WIDGET A
				
					$csscol = ' col-md-12';
					#column-specific
					switch($columns) {
						case '2':
							$csscol = ' col-md-6';
						break;
						case '3':							
							$csscol = ' col-md-4';							
						break;	
						case '4':
							$csscol = ' col-md-3';
						break;
					}	
				
					#setup variables
					$len_excerpt = it_get_setting('loop_excerpt_length');
					if(empty($len_excerpt) || !is_numeric($len_excerpt)) $len_excerpt = 480;
					$len_title = 200;						
					$csspost = is_sticky() ? ' sticky-post' : '';	
						
					#show ads in the loop
					if(!$disable_ads) {			
						$the_ad = it_get_ad($ads, $m, $a, $columns, $nonajax);
						$m = $the_ad['postcount']; #get updated post count
						$a = $the_ad['adcount']; #get updated ad count	
					}
					
					#loop specific arg adjustments
					$categoryargs['label'] = false;
					$categoryargs['white'] = true;
					$categoryargs['wrapper'] = true;
					$categoryargs['single'] = true;
					$badgesargs = $awardsargs;
					$badgesargs['badge'] = true;
					$likesargs['clickable'] = true;
					$videoargs['width'] = $width;
					$videoargs['height'] = $height;
					
					$cats = it_get_primary_categories($categoryargs);					
					$csscat = !empty($cats) ? '' : ' no-margin';
					
					$title = '<h3><a href="'.get_permalink().'">';
					if(is_sticky()) $title .= '<span class="theme-icon-pin"></span>';
					$title .= it_title($len_title) . '</a></h3>';
					
					$imageargs['size'] = 'circle-large';
					$imageargs['width'] = 115;
					$imageargs['height'] = 115;	
					
					$cssimage = has_post_thumbnail(get_the_ID()) && $thumbnail ? '' : ' no-image';		
					
					#begin html output
					$out .= $the_ad['ad'];
											
					$out.='<div class="article-panel add-active clearfix category-' . $category_id . $csscol . $csspost . $cssimage . '">';
					
						$out.='<a class="layer-link" href="' . get_permalink() . '">&nbsp;</a>';
						
						if(has_post_thumbnail(get_the_ID()) && $thumbnail) {
					
							$out.='<div class="article-image-wrapper">';                      
								
								$out.='<div class="article-image">';
								
									$out.='<div class="layer-gradient"></div>';
								
									if($rating) $out.=it_show_editor_rating($editorargs);								
									                    
									$out.='<a href="'.get_permalink().'">'.it_featured_image($imageargs).'</a>';
									
									if($icon) $out .= $cats;
									
									if($rating) $out.=it_show_user_rating($userargs);
								
								$out.='</div>';
						
							$out.='</div>';  
							
						}
						
						$out .= '<div class="article-info">';
						
							if($award) $out.=it_get_awards($awardsargs); 
								
							$out .= $title;
							
							if($authorship) $out.=it_get_authorship();
							
							if($excerpt) {
								
								$out.='<div class="excerpt">';
							
									$out.='<div class="excerpt-text">' . it_excerpt($len_excerpt) . '</div>';
								
								$out.='</div>';
							
							}
							
							if($badge) $out.=it_get_awards($badgesargs);
							
							if($meta) {
						
								$out.='<div class="article-meta">';
								
									$out.=it_get_likes($likesargs);
									
									$out.=it_get_views($viewsargs);
									
									$out.=it_get_comments($commentsargs);
								
								$out.='</div>';
								
							}
							
						$out.='</div>';						
						 
					$out.='</div>';
				
				break;
				case 'widget_b': #WIDGET B	
				
					$csscol = ' col-md-12';
					#column-specific
					switch($columns) {
						case '2':
							$csscol = ' col-md-6';
						break;
						case '3':							
							$csscol = ' col-md-4';							
						break;	
						case '4':
							$csscol = ' col-md-3';
						break;
					}									
					
					$imageargs['size'] = 'micro';
					$imageargs['width'] = 30;
					$imageargs['height'] = 30;	
					
					$len_title = 200;
					
					$cssimage = has_post_thumbnail(get_the_ID()) && $thumbnail ? '' : ' no-image';	
					
					$out.='<div class="' . $csscol . '">';	
											
					$out.='<div class="compact-panel add-active active-image clearfix category-' . $category_id . $cssimage . '">';
					
						$out.='<a class="layer-link" href="' . get_permalink() . '">&nbsp;</a>';
						
						if(has_post_thumbnail(get_the_ID()) && $thumbnail) {
					
							$out.='<div class="article-image-wrapper">';   												
									                    
								$out.=it_featured_image($imageargs);
						
							$out.='</div>';  
							
						}
						
						$out .= '<div class="article-info">';
								
							$out .= '<div class="article-title">' . it_title($len_title) . '</div>';
							
						$out.='</div>';						
						 
					$out.='</div>';
					
					$out.='</div>';
				
				break;
				case 'widget_c': #WIDGET C
				
					$csscol = ' col-md-12';
					#column-specific
					switch($columns) {
						case '2':
							$csscol = ' col-md-6';
						break;
						case '3':							
							$csscol = ' col-md-4';							
						break;	
						case '4':
							$csscol = ' col-md-3';
						break;
					}	
				
					$len_title = 200;
					
					$out.='<div class="' . $csscol . '">';
											
					$out.='<div class="border-panel add-active clearfix category-' . $category_id . '">';
					
						$out.='<a class="layer-link" href="' . get_permalink() . '">&nbsp;</a>';
						
						$out .= '<div class="article-info">';
						
							if($authorship) $out.=it_get_authorship('date', false);
								
							$out .= '<div class="article-title">' . it_title($len_title) . '</div>';
							
							if($authorship) $out.=it_get_authorship('author');
							
							if($meta) {
						
								$out.='<div class="article-meta">';
								
									$out.=it_get_likes($likesargs);
									
									$out.=it_get_views($viewsargs);
									
									$out.=it_get_comments($commentsargs);
								
								$out.='</div>';
								
							}
							
						$out.='</div>';						
						 
					$out.='</div>';
					
					$out.='</div>';
				
				break;
				case 'widget_d': #WIDGET D
				
					$csscol = ' col-md-12';
					#column-specific
					switch($columns) {
						case '2':
							$csscol = ' col-md-6';
						break;
						case '3':							
							$csscol = ' col-md-4';								
						break;	
						case '4':
							$csscol = ' col-md-3';	
						break;
					}	
					
					$isfirst = ($i==0 && $large_first) ? true : false;
					$cssfirst = $isfirst ? ' first' : ''; 
					$haseditor = it_has_rating(get_the_ID(), 'editor') ? true : false;
					$hasuser = it_has_rating(get_the_ID(), 'user') ? true : false;
					$cssrating = ($haseditor || $hasuser) ? ' has-rating' : '';
					
					$len_title = 70;
					
					$awardsargs['white'] = true;
					$categoryargs['label'] = false;
					$categoryargs['white'] = true;
					$categoryargs['wrapper'] = false;
					$categoryargs['single'] = true;
					
					$awards = it_get_awards($awardsargs);
					
					$cssaward = !empty($awards) ? ' has-award' : '';
					
					$out .= '<div class="' . $csscol . '">';
											
					$out .= '<div class="overlay-panel add-active clearfix category-' . $category_id  . $cssfirst . $cssrating . $cssaward . '">';
					
						$out .= '<div class="overlay-image" style="background-image:url(' . $featured_image[0] . ');"></div>';
					
						$out .= '<a class="overlay-link" href="' . get_permalink() . '">&nbsp;</a>';
						
						$out .= '<div class="overlay-layer"></div>';
						
						$out .= '<div class="overlay-info">';
						
							if($award && $isfirst) $out .= $awards; 
								
							$out .= '<div class="article-title">' . it_title($len_title) . '</div>';
							
							if($icon) $out.=it_get_primary_categories($categoryargs);	
							
							if($rating) $out.=it_show_editor_rating($editorargs);	
							
							if($rating) $out.=it_show_user_rating($userargs);
							
							if($meta && $isfirst) {
						
								$out .= '<div class="article-meta">';
								
									$out .= it_get_likes($likesargs);
									
									$out .= it_get_views($viewsargs);
									
									$out .= it_get_comments($commentsargs);
								
								$out .= '</div>';
								
							}
							
						$out .= '</div>';						
						 
					$out .= '</div>';
					
					$out .= '</div>';
				
				break;
				case 'widget_e': #WIDGET E
				
					$width = 360;
					$height = 250;
					$size = 'grid-3';	
					
					$csscol = ' col-md-12';
					#column-specific
					switch($columns) {
						case '2':
							$width = 360;
							$height = 250;
							$csscol = ' col-md-6';
							$size = 'grid-3';
						break;
						case '3':
							if($layout=='full') {
								$width = 360;
								$height = 250;
								$csscol = ' col-md-4';
								$size = 'grid-3';
							} else {
								$width = 263;
								$height = 180;
								$csscol = ' col-md-4';
								$size = 'grid-4';	
							}
						break;	
						case '4':
							$width = 263;
							$height = 180;
							$csscol = ' col-md-3';
							$size = 'grid-4';	
						break;
					}			
					
					$awardsargs['white'] = true;
					$categoryargs['label'] = false;
					$categoryargs['white'] = true;
					$categoryargs['wrapper'] = true;
					$categoryargs['single'] = true;
					
					$len_title = 85;
					
					$cats = it_get_primary_categories($categoryargs);
					
					$title = '<h3><a href="'.get_permalink().'">' . it_title($len_title) . '</a></h3>';
					
					$imageargs['size'] = $size;
					$imageargs['width'] = $width;
					$imageargs['height'] = $height;
					
					$video_disable = false;
					if(empty($video) || !it_get_setting('loop_video')) $video_disable = true;
					$cssvideo = $video_disable ? '' : ' video';
					
					$awards = it_get_awards($awardsargs);
					
					$cssaward = !empty($awards) ? ' has-award' : '';
					$cssright = ($i+1) % 2 == 0 ? ' right' : '';
					$csscat = '';	
											
					$out.='<div class="article-panel add-active clearfix category-' . $category_id . $csscol . $cssvideo . $cssright . ' ' . $size . '">';
					
						$out.='<a class="layer-link" href="' . get_permalink() . '">&nbsp;</a>';
						
						if(has_post_thumbnail(get_the_ID()) || (!$video_disable && $thumbnail)) {
					
							$out.='<div class="article-image-wrapper">';                      
								
								$out.='<div class="article-image">';
								
									$out.='<div class="layer-gradient"></div>';
								
									if($rating && !it_get_setting('loop_rating_disable')) $out.=it_show_editor_rating($editorargs);
								
									if(!$video_disable) {
										$out.=it_video($videoargs);
									} else {                        
										$out.='<a href="'.get_permalink().'">'.it_featured_image($imageargs).'</a>';
									}
									
									if($icon) $out .= $cats;
									
									if($rating && !it_get_setting('loop_rating_disable')) $out.=it_show_user_rating($userargs);	
									
									$out .= $title;
								
								$out.='</div>';
						
							$out.='</div>'; 
							
							if($authorship) $out.=it_get_authorship('date', false, $csscat); 
							
						}
						
					$out.='</div>';
				
				break;
				
				case 'trending': #TRENDING WIDGET
				
					$viewsargs['icon'] = false;
					$likesargs['icon'] = false;
					$commentsargs['icon'] = false;
					
					$size = 'large';
					if($i>0) $size = 'medium';
					if($i>3) $size = 'small';
					if($i>5) $size = 'tiny';
				
					$out.='<div class="trending-bar add-active bar-' . $i . ' ' . $size . '">';
					
						$out.='<a class="trending-link" href="'.get_permalink().'">&nbsp;</a>';	
						
						$out.='<div class="title">'.it_title('200').'</div>';
						
						$out.='<div class="trending-meta">';
							
							if($metric=='liked') $out.=it_get_likes($likesargs);
							
							if($metric=='viewed') $out.=it_get_views($viewsargs);
							
							if($metric=='commented') $out.=it_get_comments($commentsargs);
						
						$out.='</div>';	
						
						$out.='<div class="trending-color"></div>';
						
					$out.='</div>';				
				
				break;	
				
				
				
				case 'directory': #MINISITE DIRECTORY	
				
					$editorargs['small'] = 'small';		
				
					$out.='<div class="listing">';
						
						if($rating) $out.=it_show_editor_rating($editorargs);
						
						$out.='<a href="'.get_permalink().'">'.get_the_title() . it_featured_image($imageargs) . '</a>';										
						
					$out.='</div>';
				
				break;
				case 'directory compact': #MINISITE DIRECTORY COMPACT		
				
					$out.='<div class="listing compact">';
						
						$out.='<a href="'.get_permalink().'">'.get_the_title().'</a>';										
						
					$out.='</div>';
				
				break;
				
			} 
			
			$i++; endwhile; 
			else:
				
				$out.='<div class="filter-error">'.__('Try a different filter', IT_TEXTDOMAIN).'</div>';
				$updatepagination=0;
			
			endif;
		
		$pages = $itposts->max_num_pages;
		$posts = $posts_shown;
		wp_reset_postdata();
		
		return array('content' => $out, 'pages' => $pages, 'updatepagination' => $updatepagination, 'posts' => $posts);
	} 
}
?>