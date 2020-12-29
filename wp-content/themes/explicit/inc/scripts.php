<script type="text/javascript">
	jQuery.noConflict(); 
	
	"use strict";
	
	//master slider (only call if current page contains a masterslider, else it will error out)
	if (jQuery("#masterslider").length > 0){
		<?php $transition = it_get_setting('hero_transition'); 
		if(empty($transition)) $transition = 'mask'; 
		$autoplay = it_get_setting('hero_autoplay');
		$autoplay = $autoplay ? 1 : 0;
		?>
		var slider = new MasterSlider();
		slider.setup('masterslider' , {
			width:859,
			height:547,
			space:5,
			speed:40,
			view:'<?php echo $transition; ?>',
			autoplay: <?php echo $autoplay; ?>,
			loop: true,
			preload: 'all',
			overPause: true,
			fillMode: 'fill',
			dir: 'h'
		});
		slider.control('arrows');	
		<?php if(!it_get_setting('hero_timer_disable')) { ?>slider.control('circletimer' , {color:"#FFFFFF" , stroke:9});<?php } ?>
		slider.control('thumblist' , {autohide:false ,dir:'v',speed:20});
	}
	
	//DOCUMENT.READY
	jQuery(document).ready(function() { 
	
		//add bootstrap classes to wordpress generated elements
		jQuery('.avatar-70, .avatar-50, .avatar-40').addClass('img-circle');
		jQuery('.comment-reply-link').addClass('btn');
		jQuery('#reply-form input#submit').addClass('btn');
		
		//disable responsiveness
		<?php if(it_get_setting('responsive_disable')) { ?>
			jQuery('.col-md-1').removeClass('col-md-1').addClass('col-xs-1');
			jQuery('.col-md-2').removeClass('col-md-2').addClass('col-xs-2');
			jQuery('.col-md-3').removeClass('col-md-3').addClass('col-xs-3');
			jQuery('.col-md-4').removeClass('col-md-4').addClass('col-xs-4');
			jQuery('.col-md-5').removeClass('col-md-5').addClass('col-xs-5');
			jQuery('.col-md-6').removeClass('col-md-6').addClass('col-xs-6');
			jQuery('.col-md-7').removeClass('col-md-7').addClass('col-xs-7');
			jQuery('.col-md-8').removeClass('col-md-8').addClass('col-xs-8');
			jQuery('.col-md-9').removeClass('col-md-9').addClass('col-xs-9');
			jQuery('.col-md-10').removeClass('col-md-10').addClass('col-xs-10');
			jQuery('.col-md-11').removeClass('col-md-11').addClass('col-xs-11');
			jQuery('.col-md-12').removeClass('col-md-12').addClass('col-xs-12');
		<?php } ?>
		//move slider next arrow for videos
		if (jQuery("#masterslider").length > 0){
			slider.api.addEventListener(MSSliderEvent.VIDEO_PLAY , function(){ 
				jQuery('.ms-nav-next').addClass('video-playing');
			});
			slider.api.addEventListener(MSSliderEvent.VIDEO_CLOSE , function(){
				jQuery('.ms-nav-next').removeClass('video-playing');
			});
		}
		//hide various jQuery elements until they are loaded
		jQuery('#sticky-menus').show();
		jQuery('.it-widget-tabs').show();		
		jQuery('.bar-label').show();		
		//jquery nav menus
		jQuery("#sticky-menu")
			.mmenu({
				position: "left",
				zposition: "back",
				counters: true,
				dragOpen: true,
				header: {
					add: true,
					update: true,
					title: "<?php echo it_get_setting('sticky_menu_label')!='' ? it_get_setting('sticky_menu_label') : __('Navigation',IT_TEXTDOMAIN); ?>"
				},
				searchfield: true
			}, {
				selectedClass: "current-menu-item"
			})
			.on(
				"opening.mm",
				function()
				{
					jQuery("#sticky-bar.admin-bar").not(".no-header").css("top", "110px");
					jQuery(".contents-menu-wrapper").hide();
					jQuery(".contents-menu-wrapper").css({ opacity: 0 });
				}
			)
			.on(
				"closed.mm",
				function()
				{
					jQuery("#sticky-bar.admin-bar").not(".no-header").css("top", "142px");
					jQuery(".contents-menu-wrapper").show();
					jQuery(".contents-menu-wrapper").css({ opacity: 1 });
				}
			);
		jQuery("#section-menu-mobile")
			.mmenu({
				position: "right",
				zposition: "back",
				counters: true,
				dragOpen: true,
				header: {
					add: true,
					update: true,
					title: "<?php echo it_get_setting('section_menu_label')!='' ? it_get_setting('section_menu_label') : __('Sections',IT_TEXTDOMAIN); ?>"
				},
				searchfield: true
			}, {
				selectedClass: "current-menu-item"
			})
			.on(
				"opening.mm",
				function()
				{
					jQuery("#sticky-bar.admin-bar").not(".no-header").css("top", "110px");
				}
			)
			.on(
				"closed.mm",
				function()
				{
					jQuery("#sticky-bar.admin-bar").not(".no-header").css("top", "142px");
				}
			);		
		//superfish
		jQuery('#sticky-menu ul').superfish({
			hoverClass:  'over',
			delay:       500,
			animation:   {height:'show'},
			speed:       160,
			disableHI:   true,
			autoArrows:  false
		});
		jQuery('#section-menu ul').superfish({
			hoverClass:  'over',
			delay:       300,
			speed:       100,
			disableHI:   true,
			autoArrows:  false
		});
		jQuery('.utility-menu ul').superfish({
			hoverClass:  'over',
			delay:       500,
			animation:   {height:'show'},
			speed:       160,
			disableHI:   true,
			autoArrows:  false
		});
		
		//hide scrollers until fully loaded
		jQuery('.explicit-inner').show();
		jQuery('.trending-wrapper').show();
		
		jQuery(".trending-content").smoothDivScroll({
			manualContinuousScrolling: true,
			visibleHotSpotBackgrounds: "always",
			hotSpotScrollingStep: 4,
			hotSpotScrollingInterval: 4,
			touchScrolling: true
		});
		jQuery(".explicit-content").smoothDivScroll({
			manualContinuousScrolling: true,
			visibleHotSpotBackgrounds: "always",
			hotSpotScrollingStep: 4,
			hotSpotScrollingInterval: 4,
			touchScrolling: true
		});	
		jQuery(".trending-content .scrollableArea").addClass("loop");
		
		//jquery ui slider
		<?php
		global $post;
		$metric = it_get_setting('review_rating_metric');
		$metric_meta = get_post_meta($post->ID, IT_META_METRIC, $single = true);
		if(!empty($metric_meta) && $metric_meta!='') $metric = $metric_meta;
		switch($metric) {
			case 'number':
				$value = 5;
				$min = 0;
				$max = 10;
				$step = .1;
			break;
			case 'percentage':
				$value = 50;
				$min = 0;
				$max = 100;
				$step = 1;
			break;
			case 'letter':
				$value = 7;
				$min = 1;
				$max = 14;
				$step = 1;
			break;
			case 'stars':
				$value = 2.5;
				$min = 0;
				$max = 5;
				$step = .5;
			break;
			default:
				$value = 5;
				$min = 0;
				$max = 10;
				$step = .1;
			break;
		}
		?>
		jQuery('.form-selector').slider({
			value: <?php echo $value; ?>,
			min: <?php echo $min; ?>,
			max: <?php echo $max; ?>,
			step: <?php echo $step; ?>,
			orientation: "horizontal",
			range: "min",
			animate: true,
			slide: function( event, ui ) {
				var rating = ui.value;
				<?php if($metric=='letter') { ?>				
					var numbers = {'1':'F', '2':'F+', '3':'D-', '4':'D', '5':'D+', '6':'C-', '7':'C', '8':'C+', '9':'B-', '10':'B', '11':'B+', '12':'A-', '13':'A', '14':'A+'};					
					var rating = numbers[rating];
				<?php } elseif($metric=='percentage') { ?>	
					var rating = rating + '<span class="percentage">&#37;</span>';
				<?php } ?>			
				jQuery(this).parent().siblings('.rating-value').html( rating );
			}
		});
		
		//HD images		
		if (window.devicePixelRatio == 2) {	
			var images = jQuery("img.hires");		
			// loop through the images and make them hi-res
			for(var i = 0; i < images.length; i++) {		
				// create new image name
				var imageType = images[i].src.substr(-4);
				var imageName = images[i].src.substr(0, images[i].src.length - 4);
				imageName += "@2x" + imageType;		
				//rename image
				images[i].src = imageName;
			}
		}
		
		<?php if(!it_get_setting('colorbox_disable')) { ?>			
			jQuery('a.featured-image').colorbox();
			jQuery('.colorbox').colorbox();
			jQuery(".the-content a[href$='.jpg'],a[href$='.png'],a[href$='.gif']").colorbox(); 
			<?php if(it_get_setting('colorbox_slideshow')) { ?>
				jQuery('.the-content .gallery a').colorbox({rel:'gallery',slideshow:true});
			<?php } else { ?>
				jQuery('.the-content .gallery a').colorbox({rel:'gallery'});
			<?php } ?>
		<?php } ?> 
		
		//placeholder text for IE9
		jQuery('input, textarea').placeholder();
		
		//insert content menu items
		jQuery(jQuery('#content-anchor-inner').find('.content-section-divider').get().reverse()).each(function () {
			var id = jQuery(this).attr('id');
			var label = jQuery(this).data('label');
			jQuery( '#content-anchor-wrapper' ).after( '<li><a href="#' + id + '">' + label + '</a></li>' );		
		});
		
		<?php if(is_admin_bar_showing()) { ?>
			var fromTop = 151;
		<?php } else { ?>
			var fromTop = 119;	
		<?php } ?>
		//attach scrollspy
		jQuery('body').scrollspy({ target: '.contents-menu', offset: fromTop });
		
		//functions that need to run after ajax buttons are clicked
		dynamicElements();	
		
		//menu hover fx
		menuHovers();	
				
	});
	
	//applied to elements within ajax panels
	function dynamicElements() {
		//portholes mouseovers
		jQuery(".portholes .porthole-link").hover(
			function() {
				jQuery(this).siblings(".porthole-color").stop().animate({
					'opacity':'.8'
				}, 150);
				jQuery(this).siblings(".porthole-layer").stop().animate({
					'opacity':'0'
				}, 350);
				jQuery(this).siblings(".porthole-info").find(".rating-wrapper").stop().animate({
					'opacity':'.9'
				}, 100);
				jQuery(this).siblings(".porthole-info").stop().delay(0).queue(function(next){
					jQuery(this).addClass("active");
					next();
				});
			},
			function() {
				jQuery(this).siblings(".porthole-color").stop().animate({
					'opacity':'0'
				}, 550);
				jQuery(this).siblings(".porthole-layer").stop().animate({
					'opacity':'.9'
				}, 250);
				jQuery(this).siblings(".porthole-info").find(".rating-wrapper").stop().animate({
					'opacity':'0'
				}, 550);
				jQuery(this).siblings(".porthole-info").stop().delay(150).queue(function(next){
					jQuery(this).removeClass("active");
					next();
				});
			}
		);
		//active hover
		jQuery(".add-active").hover(
			function() {
				jQuery(this).addClass("active");
			},
			function() {
				jQuery(this).removeClass("active");
			}
		);
		//image hovers
		jQuery(".active-image").hover(
			function() {
				jQuery(this).find('img').stop().animate({ opacity: .4 }, 150);
			},
			function() {
				jQuery(this).find('img').stop().animate({ opacity: 1.0 }, 500);
			}
		);
		jQuery(".the_content").hover(
			function() {
				jQuery(this).find('img').stop().animate({ opacity: .4 }, 150);
			},
			function() {
				jQuery(this).find('img').stop().animate({ opacity: 1.0 }, 500);
			}
		);
		//jQuery tooltips				
		jQuery('.info').tooltip();	
		jQuery('.info-top').tooltip();	
		jQuery('.info-bottom').tooltip({ placement: 'bottom' });
		jQuery('.info-left').tooltip({ placement: 'left' });
		jQuery('.info-right').tooltip({ placement: 'right' });
		//jQuery popovers
		jQuery('.popthis').popover();
		//jQuery alert dismissals
		jQuery(".alert").alert();
		//jQuery fitvids
		jQuery('.video_frame').fitVids();
		//equal height columns
		equalHeightColumns(jQuery(".widget-panel"));
		equalHeightColumns(jQuery(".loop.grid .article-panel"));
		//if items are dynamically added on page load, need to account for new width
		resizeContentsMenu();
		resizeStickyMenu();			
	}
	
	//call equal height columns when window is resized
	jQuery(window).resize(function() {
		equalHeightColumns(jQuery(".widget-panel"));
		equalHeightColumns(jQuery(".loop.grid .article-panel"));
		resizeContentsMenu();	
		resizeStickyMenu();	
	});	
	
	//call equal height columns when widgets is resized
	jQuery("#widgets").resize(function(e){
		equalHeightColumns(jQuery(".widget-panel"));
	});
	
	//call equal height columns when main menu items are hovered since sub menus are
	//hidden and don't have heights until visible
	jQuery('body').on('mouseover', '#section-menu-full a.parent-item', function(e){
		equalHeightColumns(jQuery("#section-menu-full ul.term-list, #section-menu-full li.post-list"), true);
	});
	//equal height columns
	function equalHeightColumns(group, nolimit) {
		tallest = 0;
		width = jQuery(window).width();							
		group.each(function() {
			jQuery(this).removeAttr('style');			
			thisHeight = jQuery(this).height();
			if(thisHeight > tallest) {
				tallest = thisHeight;
			}
		});
		if(width > 991 || nolimit) {
			group.height(tallest);
		}
	}	
	
	<?php if(is_admin_bar_showing()) { ?>
		var topOffset = 102;
		var barOffset = 200;
	<?php } else { ?>
		var topOffset = 70;	
		var barOffset = 208;
	<?php } ?>
	
	jQuery(window).scroll(function() {
		if (jQuery(this).scrollTop() > 110) {
			jQuery('#sticky-bar').addClass('fixed');
			jQuery('#sticky-bar.logo-slide .logo a').stop().animate({ opacity: 1.0, left: '0px' }, 100);	
		} else {
			if(!jQuery('#sticky-menu').is(':visible') && !jQuery('#section-menu-mobile').is(':visible')) {
				jQuery('#sticky-bar').removeClass('fixed');
				jQuery('#sticky-bar.logo-slide .logo a').stop().animate({ opacity: 0, left: '-100px' }, 500);	
			}
		}
		if(jQuery(this).scrollTop() > 44) {
			jQuery('#sticky-bar').addClass('sticky-mobile');
		} else {
			jQuery('#sticky-bar').removeClass('sticky-mobile');
		}
		
		//back to top arrow
		if (jQuery(this).scrollTop() < 150) {
			jQuery("#back-to-top").fadeOut();
		}
		else {
			jQuery("#back-to-top").fadeIn();
		}	
		
		resizeContentsMenu();	
		resizeStickyMenu();
	});		

	function resizeStickyMenu() {
		//see if compact versions of menus should be shown
		if(jQuery('#section-menu-full').length > 0) {
			var megaWidth = jQuery('.mega-menu').width();
			if(jQuery('.mega-menu').length == 0) {
				var megaWidth = jQuery('.non-mega-menu').width();
			}
			var standardWidth = jQuery('.secondary-menu-full').width();
			var compactWidth = jQuery('.secondary-menu-compact').width();
			var menusWidth = megaWidth + standardWidth;
			var compactMenusWidth = megaWidth + compactWidth;
			var logoWidth = jQuery('#sticky-bar .logo').width();
			//var logoLeft = jQuery('#sticky-bar .logo').offset();
			//logoWidth = logoWidth + logoLeft.left;
			var newWidth = jQuery('#new-articles').width();
			var stickyWidth = jQuery('#sticky-menu-selector').width();
			var randomWidth = jQuery('#random-article').width();
			var controlsWidth = jQuery('#sticky-controls').width();
			var barWidth = jQuery('#sticky-bar > .row > .col-md-12 > .container').width();
			if(barWidth === null) barWidth = jQuery('#sticky-bar > .row > .col-xs-12 > .container').width();
			var extraWidth = logoWidth + newWidth + stickyWidth + randomWidth + controlsWidth;
			var limitWidth = barWidth - extraWidth;
			//alert('megaWidth=' + megaWidth + '\nstandardWidth=' + standardWidth + '\nmenusWidth=' + menusWidth + '\nlogoWidth=' + logoWidth + '\nnewWidth=' + newWidth + '\nstickyWidth=' + stickyWidth + '\nrandomWidth=' + randomWidth + '\ncontrolsWidth=' + controlsWidth + '\nbarWidth=' + barWidth + '\nextraWidth=' + extraWidth + '\nlimitWidth=' + limitWidth);
			//mega menu alone passes limit
			if(megaWidth > limitWidth) {
				jQuery('#section-menu-full').hide();
				jQuery('#section-menu-compact').show();
			}
			//standard menu alone passes limit
			if(standardWidth > limitWidth) {
				jQuery('.secondary-menu-full').hide();
				jQuery('.secondary-menu-compact').show();
			}
			//both menus together pass limit
			if(menusWidth > limitWidth) {
				//first reduce standard menu
				jQuery('.secondary-menu-full').hide();
				jQuery('.secondary-menu-compact').show();
				//compact standard plus mega menu pass limit
				if(compactMenusWidth > limitWidth) {
					jQuery('#section-menu-full').hide();
					jQuery('#section-menu-compact').show();
				}
			}
		}
	}
		
	function resizeContentsMenu() {
		//bookmark positioning			
		if(jQuery('.contents-menu-wrapper').length > 0) {			
			var menuOffset = jQuery('.contents-menu-wrapper').offset().top - topOffset;
			var newWidth = jQuery('.contents-menu-wrapper').width() - 2;
			var btnWidth = jQuery('.contents-menu-wrapper ul.sort-buttons').width();
			var lblWidth = jQuery('.contents-menu-wrapper .bar-label-wrapper').width();
			var wrapperWidth = jQuery('#main-content').width() - 2;
			var barWidth = btnWidth + lblWidth;
			if (barWidth > wrapperWidth) {
				jQuery('.contents-menu-wrapper').addClass('vertical');				
			}
			if (!jQuery('.contents-menu-wrapper').hasClass('vertical') && jQuery(this).scrollTop() > menuOffset) {
				jQuery('.contents-menu').addClass('fixed').width(newWidth);				
			} else {
				jQuery('.contents-menu').removeClass('fixed').removeAttr('style');
			}	
			//show the menu after scrolling and hide after a while (only for vertical layout)
			if(jQuery('.contents-menu-wrapper').hasClass('vertical')) {
				if(!jQuery('.contents-menu-wrapper').is(':visible')) {
					jQuery('.contents-menu-wrapper').stop().fadeIn(100);
				}
			}
		}	
		if(jQuery('.contents-menu-wrapper').hasClass('vertical')) {
			<?php if(is_admin_bar_showing()) { ?>
				var newOffset = 100;
			<?php } else { ?>
				var newOffset = 68;	
			<?php } ?>
			jQuery('body').data()['bs.scrollspy'].options.offset = newOffset; // Set the new offset 
			jQuery('body').data()['bs.scrollspy'].process(); // Force scrollspy to recalculate the offsets to your targets 
			jQuery('body').scrollspy('refresh'); // Refresh the scrollspy.			
		}
	}
	
	//if disqus is active need to adjust anchor link from comments to disqus thread
	function disqusContentsMenu() {
		if (jQuery("#disqus_thread").length > 0){
			jQuery("#comments-anchor-wrapper a").attr("href", "#disqus_thread");
		}	
	}
	
	//hide contents menu 2 seconds after scrolling has stopped
	(function() {        
		var timer;
		jQuery(window).bind('scroll',function () {
			clearTimeout(timer);
			timer = setTimeout( refresh , 1800 );
		});
		var refresh = function () { 
			//only want to do this for vertical style and only if mouse is not currently hovering over the menu
			if(jQuery('.contents-menu-wrapper').hasClass('vertical') && jQuery('.contents-menu-wrapper:hover').length == 0) {
				jQuery('.contents-menu-wrapper').fadeOut(1200);
			}
		};
	})();
	
	//hide contents menu after user mouses out
	(function() {        
		var timer;
		jQuery('body').on('mouseenter', '.contents-menu-wrapper.vertical', function(e) {
			jQuery('.contents-menu-wrapper').stop(true, true).fadeIn(100);
			clearTimeout(timer);
		});
		jQuery('body').on('mouseleave', '.contents-menu-wrapper.vertical', function(e) {
			clearTimeout(timer);
			timer = setTimeout( refresh , 1800 );
		});
		var refresh = function () { 
			//only want to do this for vertical style and only if mouse is not currently hovering over the menu
			if(jQuery('.contents-menu-wrapper').hasClass('vertical') && jQuery('.contents-menu-wrapper:hover').length == 0) {
				jQuery('.contents-menu-wrapper').fadeOut(1200);
			}
		};
	})();	
		
	/**
	* Check a href for an anchor. If exists, and in document, scroll to it.
	* If href argument ommited, assumes context (this) is HTML Element,
	* which will be the case when invoked by jQuery after an event
	*/
	function scroll_if_anchor(href) {
	    href = typeof(href) == "string" ? href : jQuery(this).attr("href");
		
		//do not interfere with bootstrap carousels
		if(jQuery(href).length > 0 && !jQuery(this).hasClass('no-scroll')) {			
			<?php if(is_admin_bar_showing()) { ?>
				var fromTop = 150;
			<?php } else { ?>
				var fromTop = 118;	
			<?php } ?>
			
			//subtract contents menu height (and margin)
			if(jQuery('.contents-menu-wrapper').hasClass('vertical')) {
				fromTop = fromTop - 51;
			}
		
			// If our Href points to a valid, non-empty anchor, and is on the same page (e.g. #foo)
			// Legacy jQuery and IE7 may have issues: http://stackoverflow.com/q/1593174
			if(href.indexOf("#") == 0) {
				var $target = jQuery(href);
		
				// Older browser without pushState might flicker here, as they momentarily
				// jump to the wrong position (IE < 10)
				if($target.length) {
					jQuery('html, body').animate({ scrollTop: $target.offset().top - fromTop });
					if(history && "pushState" in history) {
						history.pushState({}, document.title, window.location.pathname + href);
						return false;
					}
				}
			}
		}
	}
	// When our page loads, check to see if it contains an anchor
	scroll_if_anchor(window.location.hash);
	// Intercept all anchor clicks
	jQuery("body").on("click", "a", scroll_if_anchor);	
	
	//menu hovers
	function menuHovers() {
		jQuery(".menu .post-list a").hover(
			function() {
				jQuery(this).children('img').stop().animate({ opacity: .3 }, 150);
			},
			function() {
				jQuery(this).children('img').stop().animate({ opacity: 1.0 }, 500);
			}
		);	
	}
	//new articles effects 
	jQuery("#new-articles .selector").hover(
		function() {
			jQuery(this).addClass('over');
		},
		function() {
			jQuery(this).removeClass('over');
		}
	);
	jQuery("#new-articles .selector").click(function() {
		jQuery('#new-articles .post-container').animate({				 
			height: 'toggle'				 
		}, 100, 'linear' );
		jQuery(this).toggleClass('active');
	});	
	//show search box	
	jQuery("#menu-search-button").hover(
		function() {
			jQuery(this).toggleClass('hover');
		}
	);	
	jQuery("#menu-search-button").click(
		function() {
			jQuery('#menu-search').fadeToggle("fast");
			jQuery(this).toggleClass('active');
		}
	);
	//hide superfish more drop down on mobile if clicked again
	jQuery("#secondary-menu-selector").click(
		function() {			
			if(jQuery('.secondary-menu-compact ul.menu').is(':visible')) {
				jQuery('.secondary-menu-compact ul.menu').hide();
			}	
		}
	);
	//search form submission
	jQuery("#searchformtop input").keypress(function(event) {
		if (event.which == 13) {
			event.preventDefault();
			var len = jQuery("#s").val().length;
			if(len >=3) {
				jQuery("#searchformtop").submit();
			} else {
				alert("Search term must be at least 3 characters in length");	
			}
		}
	});
	//email subscribe form submission
	jQuery("#feedburner_subscribe button").click(function() {		
		jQuery("#feedburner_subscribe").submit();		
	});
	//show login form
	jQuery("#sticky-login").click(function() {
		jQuery('#sticky-login-form').animate({				 
			height: 'toggle'				 
		}, 100, 'linear' );	
		jQuery('#sticky-register-form').hide();	
		jQuery('#sticky-register').removeClass('active');
		jQuery(this).toggleClass('active');
	});
	//show register form
	jQuery("#sticky-register").click(function() {
		jQuery('#sticky-register-form').animate({				 
			height: 'toggle'				 
		}, 100, 'linear' );	
		jQuery('#sticky-login-form').hide();	
		jQuery('#sticky-login').removeClass('active');
		jQuery(this).toggleClass('active');
	});
	//submit button hover effects
	jQuery(".sticky-submit").hover(function() {
		jQuery(this).toggleClass("active");
	});
	//login form submission
	jQuery(".sticky-login-form #user_pass").keypress(function(event) {
		if (event.which == 13) {
			jQuery("#sticky-login-form .loading").show();
			jQuery("form.sticky-login-form").animate({opacity: "0.15"}, 0);
			event.preventDefault();
			jQuery(".sticky-login-form").submit();
		}		
	});
	jQuery("#sticky-login-submit").click(function() {
		jQuery("#sticky-login-form .loading").show();
		jQuery("form.sticky-login-form").animate({opacity: "0.15"}, 0);
		jQuery(".sticky-login-form").submit();
	});
	//register form submission
	jQuery(".sticky-register-form #user_email").keypress(function(event) {
		if (event.which == 13) {
			jQuery("#sticky-register-form .loading").show();
			jQuery("form.sticky-register-form").animate({opacity: "0.15"}, 0);
			event.preventDefault();
			jQuery(".sticky-register-form").submit();
		}
	});
	jQuery("#sticky-register-submit").click(function() {
		jQuery("#sticky-register-form .loading").show();
		jQuery("form.sticky-register-form").animate({opacity: "0.15"}, 0);
		jQuery(".sticky-register-form").submit();
	});
	//hide check password message
	jQuery(".check-password").click(function() {
		jQuery(this).animate({				 
			height: 'toggle'				 
		}, 100, 'linear' );	
	});	
	//scroll all #top elements to top
	jQuery("a[href='#top']").click(function() {
		jQuery("html, body").animate({ scrollTop: 0 }, "slow");
		return false;
	});	
	//image darkening
	jQuery('body').on('mouseenter', '.darken', function(e) {
		jQuery(this).find('img').stop().animate({ opacity: .4 }, 150);
	}).on('mouseleave', '.darken', function(e) {
		jQuery(this).find('img').stop().animate({ opacity: 1.0 }, 500);
	});
	//reaction mouseovers
	jQuery('body').on('mouseenter', '.reaction.clickable', function(e) {
		jQuery(this).addClass('active');
	}).on('mouseleave', '.reaction', function(e) {
		jQuery(this).removeClass('active');
	});	
	// user rating panel display
	<?php $top_rating_disable = it_get_setting('review_top_rating_disable');
	if((!it_get_setting('review_registered_user_ratings') || is_user_logged_in()) && !$top_rating_disable) { ?>
		jQuery('body').on('mouseover', '.user-rating .rating-wrapper.rateable', function(e) {
			jQuery(this).addClass('over');
			jQuery(this).find('.form-selector-wrapper').fadeIn(100);		
		});
		jQuery('body').on('mouseleave', '.user-rating .rating-wrapper', function(e) {	
			jQuery(this).stop().delay(100)
						.queue(function(n) {
							jQuery(this).removeClass('over');
							n();
						});	
			jQuery(this).find('.form-selector-wrapper').stop().fadeOut(500);		
		});	
	<?php } ?>
	// user comment rating panel display
	jQuery('body').on('mouseover', '#respond .rating-wrapper.rateable', function(e) {
		jQuery(this).addClass('over');
		jQuery(this).find('.form-selector-wrapper').fadeIn(100);		
	});
	jQuery('body').on('mouseleave', '#respond .rating-wrapper', function(e) {	
		jQuery(this).stop().delay(100)
					.queue(function(n) {
						jQuery(this).removeClass('over');
						n();
					});	
		jQuery(this).find('.form-selector-wrapper').stop().fadeOut(500);		
	});	
	// user comment rating
	jQuery( "#respond .form-selector" ).on( "slidestop", function( event, ui ) {
		var divID = jQuery(this).parent().parent().parent().attr("id");	
		var rating = jQuery(this).parent().siblings('.rating-value').html();
		jQuery('#' + divID + ' .theme-icon-check').delay(100).fadeIn(100);
		jQuery('#' + divID + ' .hidden-rating-value').val(rating);
	});	
	
	//pinterest
	if(jQuery('#pinterest-social-tab').length > 0) {
		(function(d){
			var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
			p.type = 'text/javascript';
			p.async = true;
			p.src = '//assets.pinterest.com/js/pinit.js';
			f.parentNode.insertBefore(p, f);
		}(document));
	}
	
	//facebook
	if(jQuery('#facebook-social-tab').length > 0) {
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&status=0";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	}
		
	//WINDOW.LOAD
	jQuery(window).load(function() {		
		
		//flickr
		<?php #deal with default values
		$flickr_count = it_get_setting('flickr_number');
		if(empty($flickr_count)) $flickr_count=9;
		?>
		if(jQuery('#flickr-social-tab').length > 0) {
			jQuery('.flickr').jflickrfeed({
				limit: <?php echo $flickr_count; ?>,
				qstrings: {
					id: '<?php echo it_get_setting('flickr_id'); ?>'
				},
				itemTemplate: '<li>'+
								'<a rel="colorbox" class="darken small" href="{{image}}" title="{{title}}">' +
									'<img src="{{image_s}}" alt="{{title}}" width="87" height="87" />' +
								'</a>' +
							  '</li>'
			}, function(data) {
			});	
		}
		
		//tabs - these must go in window.load so pinterest will work inside a tab
		jQuery('.widgets-wrapper .it-social-tabs').tabs({ fx: { opacity: 'toggle', duration: 150 } });
		jQuery('#footer .it-social-tabs').tabs({ active: 2, fx: { opacity: 'toggle', duration: 150 } });
		jQuery('.share-wrapper').show();
		equalHeightColumns(jQuery(".loop.grid .article-panel"));
		disqusContentsMenu();
		
		//show ads after mmenu is setup because it wraps the page in a div
		//causing google adsense to reload
		jQuery('.it-ad').animate({opacity: '1'}, 0);		
					
		});	
	
	jQuery.noConflict();
	
</script>