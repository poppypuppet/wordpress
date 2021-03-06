jQuery.noConflict(); 
	
"use strict";
	
(function ($) {
    $(function () {
		//user view count
		$(document).ready(function(e) { 
			var postID = $('#page-content').data('postid');
			$.post(itAjax.ajaxurl, {
				action: 'itajax-view',
				postID: postID
			}, function (response) {
				jQuery('.control-box .view-count').html(response.content);
			});
		});
		// like button
		$('body').on('click', 'a.do-like', function(e){
			$(this).removeClass('do-like');
			var postID = $(this).data('postid');
			var likeaction = $(this).data('likeaction');
			var location = $("#content").data('location');	 
			var _this = this;
			$.post(itAjax.ajaxurl, {
				action: 'itajax-like',
				postID: postID,
				likeaction: likeaction,
				location: location
			}, function (response) {
				$(_this).addClass('do-like');
				$('a.like-button.' + postID + ' .numcount').html(response.content);
				if(likeaction=='like') {
					$('a.like-button.' + postID + ' .icon').removeClass('like').addClass('unlike');
					$('a.like-button.' + postID).data('likeaction', 'unlike');
				} else {
					$('a.like-button.' + postID + ' .icon').removeClass('unlike').addClass('like');
					$('a.like-button.' + postID).data('likeaction', 'like');
				}
				$('#ajax-error').hide();
			});
		});		
		// menu top level item mouseovers
		var timeout;		
		$('body').on('mouseover', '.mega-menu li.unloaded', function(e) {
			
			var loop = $(this).data('loop');
			var thumbnail = $(this).data('thumbnail');
			var numarticles = $(this).data('numarticles');
			var object = $(this).data('object');
			var objectid = $(this).data('objectid');
			var object_name = $(this).data('object_name');
			var type = $(this).data('type');
			var _this = this;
			
			timeout = setTimeout(function(){
			
				$(_this).children(".mega-loader").show();
				
				$.post(itAjax.ajaxurl, {
					action: 'itajax-menu-terms',
					object: object,
					objectid: objectid,
					object_name: object_name,
					loop: loop,
					thumbnail: thumbnail,
					numarticles: numarticles,
					type: type
				}, function (response) {
					$(_this).children(".mega-content").html(response.content);
					equalHeightColumns($("#section-menu .mega-wrapper .post-list a.post-item"));	
					equalHeightColumns($(".mega-menu .term-list, .mega-menu .post-list"));		
					$('#ajax-error').hide();
					$(_this).children(".mega-loader").hide();
					menuHovers();	
					$(_this).addClass('loaded').removeClass('unloaded');
				});				
			 }, 400);
		});
		$('body').on('mouseleave', '.mega-menu li.unloaded', function(e) {
			clearTimeout(timeout);
		});
		$(".mega-menu li").hover(
			function() {
				$(this).children(".mega-content").show();
				equalHeightColumns($("#section-menu .mega-wrapper .post-list a.post-item"));	
				equalHeightColumns($(".mega-menu .term-list, .mega-menu .post-list"));
			},
			function() {
				$(this).children(".mega-content").hide();
				$(this).children(".mega-loader").hide();		
			}
		);
		// menu second-level item mouseovers
		$('body').on('mouseover', '.mega-menu a.list-item.inactive', function(e) {
			
			var loop = $(this).parent().parent().parent().parent().data('loop');
			var thumbnail = $(this).parent().parent().parent().parent().data('thumbnail');
			var numarticles = $(this).parent().parent().parent().parent().data('numarticles');
			var object = $(this).parent().parent().parent().parent().data('object');
			var object_name = $(this).parent().parent().parent().parent().data('object_name');
			var size = $(this).data('size');
			var width = $(this).data('width');
			var height = $(this).data('height');
			var sorter = $(this).data('sorter');
			var _this = this;
			
			timeout = setTimeout(function(){
			
				$(".mega-menu .post-list .loading").show();
				$(".mega-menu .post-list a").animate({opacity: "0.15"}, 0);	
				$(_this).addClass('active').removeClass('inactive');
				$(_this).siblings().addClass('inactive').removeClass('active');
				
				$.post(itAjax.ajaxurl, {
					action: 'itajax-sort',
					sorter: sorter,
					object: object,
					object_name: object_name,
					loop: loop,
					thumbnail: thumbnail,
					numarticles: numarticles,
					size: size,
					width: width,
					height: height
				}, function (response) {
					$(_this).parent().siblings(".post-list").html(response.content);				
					$('#ajax-error').hide();
					equalHeightColumns($("#section-menu .mega-wrapper .post-list a.post-item"));
					equalHeightColumns($(".mega-menu .term-list, .mega-menu .post-list"));	
					$(".mega-menu .post-list .loading").hide();
					$(".mega-menu .post-list a").animate({opacity: "1"}, 500);	
					menuHovers();	
				});				
			 }, 400);
		});
		$('body').on('mouseleave', '.mega-menu a.list-item.inactive', function(e) {
			clearTimeout(timeout);
		});		
		// main loop sorting
		$('body').on('click', '.sortbar .sort-metrics a', function(e){	
			$(this).addClass('active');
			$(this).siblings().removeClass('active');	
						
			var view = $(this).parent().data('view');
			var loop = $(this).parent().data('loop');
			var location = $(this).parent().data('location');
			var thumbnail = $(this).parent().data('thumbnail');
			var rating = $(this).parent().data('rating');
			var meta = $(this).parent().data('meta');
			var icon = $(this).parent().data('icon');
			var award = $(this).parent().data('award');
			var badge = $(this).parent().data('badge');
			var authorship = $(this).parent().data('authorship');
			var excerpt = $(this).parent().data('excerpt');
			var sorter = $(this).data('sorter');
			var columns = $(this).parent().data('columns');
			var layout = $(this).parent().data('layout');
			var numarticles = $(this).parent().data('numarticles');
			var paginated = $(this).parent().data('paginated');
			var largefirst = $(this).parent().data('largefirst');
			var timeperiod = $(this).parent().data('timeperiod');
			var title = $(this).data('original-title');
			var container = $(this).closest('.post-container');
			var currentquery = container.data('currentquery');
			var _this = this;
			var outer = '.after-header ';
			
			//sort button clicked is within the footer
			if($(this).closest('#footer-wrapper').length > 0) {	
				outer = '#footer-wrapper ';
			}			
			
			container.find(".load-more-wrapper").hide();
			container.find(".loading.load-sort").show();
			container.find(".loop").animate({opacity: "0.15"}, 0);	
			container.find(".sortbar .label-text").not(".static").animate({opacity: "0.15"}, 0);
					
			$.post(itAjax.ajaxurl, {
				action: 'itajax-sort',
				view: view,
				loop: loop,
				location: location,
				thumbnail: thumbnail,
				rating: rating,
				meta: meta,
				award: award,
				badge: badge,
				authorship: authorship,
				icon: icon,
				excerpt: excerpt,
				sorter: sorter,
				columns: columns,
				layout: layout,
				numarticles: numarticles,				
				paginated: paginated,
				largefirst: largefirst,
				title: title,
				timeperiod: timeperiod,
				currentquery: currentquery
			}, function (response) {				
				container.find(".loading").hide();
				container.find(".loop").animate({opacity: "1"}, 500);
				container.find(".sortbar .label-text").animate({opacity: "1"}, 500);
				container.find(".loop").html(response.content);
				if(response.updatepagination==1) {
					container.find(".pagination-wrapper").html(response.pagination);
					container.find(".pagination-wrapper.mobile").html(response.paginationmobile);
				}
				container.find(".sortbar .label-text").html(title);
				container.find(".pagination").data("sorter", sorter);
				container.find(".load-more-wrapper").data("paginated", 1);
				container.find(".load-more-wrapper").data("sorter", sorter);
				if(response.pages > 1) {
					container.find(".load-more-wrapper").show();
					container.find(".last-page").hide();
				}
				$("#ajax-error").hide();
				//sort button clicked is within the trending slider
				if($(_this).closest('.trending-wrapper').length > 0) {
					$(".trending-content").smoothDivScroll("jumpToElement", "first");
				}
				dynamicElements();
			});
		});	
		// sections sorting
		$('body').on('click', '.sortbar .sort-sections a', function(e){	
			$(this).addClass('active');
			$(this).siblings().removeClass('active');				
			
			var sorter = $(this).data('sorter');
			var view = $(this).parent().data('view');
			var loop = $(this).parent().data('loop');
			var location = $(this).parent().data('location');
			var thumbnail = $(this).parent().data('thumbnail');
			var rating = $(this).parent().data('rating');
			var meta = $(this).parent().data('meta');
			var icon = $(this).parent().data('icon');
			var award = $(this).parent().data('award');
			var badge = $(this).parent().data('badge');
			var authorship = $(this).parent().data('authorship');
			var excerpt = $(this).parent().data('excerpt');			
			var columns = $(this).parent().data('columns');
			var layout = $(this).parent().data('layout');
			var numarticles = $(this).parent().data('numarticles');
			var largefirst = $(this).parent().data('largefirst');
			var _this = this;	
			
			$(this).parent().parent().parent().find(".loading.load-sort").show();
			$(this).parent().parent().parent().find(".loop").animate({opacity: "0.15"}, 0);	
					
			$.post(itAjax.ajaxurl, {
				action: 'itajax-sort',
				view: view,
				loop: loop,
				location: location,
				thumbnail: thumbnail,
				rating: rating,
				meta: meta,
				award: award,
				badge: badge,
				authorship: authorship,
				icon: icon,
				excerpt: excerpt,
				sorter: sorter,
				columns: columns,
				layout: layout,
				numarticles: numarticles,	
				largefirst: largefirst
			}, function (response) {				
				$(_this).parent().parent().parent().find(".loading").hide();
				$(_this).parent().parent().parent().find(".loop").animate({opacity: "1"}, 500);
				$(_this).parent().parent().parent().find(".loop").html(response.content);		
				$("#ajax-error").hide();
				dynamicElements();
			});
		});		
		// main loop pagination
		$('body').on('click', '.pagination a', function(e){
			$(this).addClass('active');
			$(this).siblings().removeClass('active');
			
			$('html, body').animate({
				scrollTop: $(this).parent().parent().parent().offset().top - 100
			}, 300);
			
			var view = $(this).parent().data('view');
			var loop = $(this).parent().data('loop');
			var location = $(this).parent().data('location');
			var sorter = $(this).parent().data('sorter');
			var columns = $(this).parent().data('columns');
			var layout = $(this).parent().data('layout');
			var thumbnail = $(this).parent().data('thumbnail');
			var rating = $(this).parent().data('rating');
			var meta = $(this).parent().data('meta');
			var icon = $(this).parent().data('icon');
			var award = $(this).parent().data('award');
			var badge = $(this).parent().data('badge');
			var authorship = $(this).parent().data('authorship');
			var excerpt = $(this).parent().data('excerpt');
			var numarticles = $(this).parent().data('numarticles');
			var largefirst = $(this).parent().data('largefirst');
			var paginated = $(this).data('paginated');
			var container = $(this).closest('.post-container');
			var currentquery = container.data('currentquery');
			var _this = this;			
			var outer = '.after-header ';
			
			//sort button clicked is within the footer
			if($(this).closest('#footer-wrapper').length > 0) {	
				outer = '#footer-wrapper ';
			}	
			
			container.find(".loading.load-sort").show();
			container.find(".loop").animate({opacity: "0.15"}, 0);	
			
			$.post(itAjax.ajaxurl, {
				action: 'itajax-sort',
				view: view,
				loop: loop,
				location: location,
				thumbnail: thumbnail,
				rating: rating,
				meta: meta,
				award: award,
				badge: badge,
				authorship: authorship,
				icon: icon,
				excerpt: excerpt,
				sorter: sorter,
				columns: columns,
				layout: layout,
				numarticles: numarticles,
				largefirst: largefirst,				
				paginated: paginated,
				currentquery: currentquery
			}, function (response) {
				container.find(".loading").hide();
				container.find(".loop").animate({opacity: "1"}, 500);
				container.find(".loop").html(response.content);
				if(response.updatepagination==1) {
					container.find(".pagination-wrapper").html(response.pagination);
					container.find(".pagination-wrapper.mobile").html(response.paginationmobile);
				}
				container.find(".sortbar .sort-buttons").data("paginated", paginated);
				$('#ajax-error').hide();
				//add to browser history
				//history.pushState({}, document.title, window.location.pathname + window.location.hash);
				dynamicElements();
			});
		});		
		// infinite load more
		$('body').on('click', '.load-more-wrapper', function(e){
			var view = $(this).data('view');
			var loop = $(this).data('loop');
			var location = $(this).data('location');
			var sorter = $(this).data('sorter');
			var columns = $(this).data('columns');
			var layout = $(this).data('layout');
			var thumbnail = $(this).data('thumbnail');
			var rating = $(this).data('rating');
			var meta = $(this).data('meta');
			var icon = $(this).data('icon');
			var award = $(this).data('award');
			var badge = $(this).data('badge');
			var authorship = $(this).data('authorship');
			var excerpt = $(this).data('excerpt');
			var numarticles = $(this).data('numarticles');
			var numpages = $(this).data('numpages');
			var paginated = $(this).data('paginated') + 1;
			var container = $(this).closest('.post-container');
			var currentquery = container.data('currentquery');
			var _this = this;
			
			$(this).hide();
			container.find(".loading.load-infinite").show();	
			
			$.post(itAjax.ajaxurl, {
				action: 'itajax-sort',
				view: view,
				loop: loop,
				location: location,
				thumbnail: thumbnail,
				rating: rating,
				meta: meta,
				award: award,
				badge: badge,
				authorship: authorship,
				icon: icon,
				excerpt: excerpt,
				sorter: sorter,
				columns: columns,
				layout: layout,
				numarticles: numarticles,	
				numpages: numpages,			
				paginated: paginated,
				currentquery: currentquery
			}, function (response) {
				if(numpages > paginated && response.pages > paginated) {
					$(_this).show();
					container.find(".last-page").hide();
				} else {
					container.find(".last-page").show();
				}
				container.find(".loading").hide();
				container.find(".loop").append(response.content);
				$(_this).data('paginated', paginated);
				$('#ajax-error').hide();
				dynamicElements();
			});
		});
		// recommended filtering
		$('body').on('click', '#recommended .sort-buttons a', function(e){
			$("#recommended .loading").show();
			$("#recommended .loop").animate({opacity: "0.15"}, 0);	
			$(this).addClass('active');
			$(this).siblings().removeClass('active');
			
			var postID = $(this).parent().data('postid');
			var loop = $(this).parent().data('loop');
			var location = $(this).parent().data('location');		
			var thumbnail = $(this).parent().data('thumbnail');
			var icon = $(this).parent().data('icon');
			var columns = $(this).parent().data('columns');
			var rating = $(this).parent().data('rating');
			var numarticles = $(this).parent().data('numarticles');
			var authorship = $(this).parent().data('authorship');
			var excerpt = $(this).parent().data('excerpt');
			var sorter = $(this).data('sorter');
			var method = $(this).data('method');
			
			$.post(itAjax.ajaxurl, {
				action: 'itajax-sort',
				postID: postID,
				loop: loop,
				location: location,
				thumbnail: thumbnail,
				icon: icon,
				columns: columns,
				rating: rating,
				numarticles: numarticles,
				authorship: authorship,
				excerpt: excerpt,				
				sorter: sorter,
				method: method
			}, function (response) {
				$("#recommended .loading").hide();
				$("#recommended .loop").animate({opacity: "1"}, 500);
				$("#recommended .loop").html(response.content);
				$('#ajax-error').hide();
				dynamicElements();
			});
		});		
		// star user ratings
		$('.rating-wrapper .rateit').bind('rated reset', function (e) {
			 var ri = $(this);
			
			 var noupdate = ri.data('noupdate');
			 var rating = ri.rateit('value');
			 var postID = ri.data('postid');
			 var meta = ri.data('meta');
			 var divID = ri.parent().parent().parent().attr('id');
			 var metric = 'stars';
			 var unlimitedratings = ri.data('unlimitedratings');
		
			 //disable rating ability after user submits rating
			 if(unlimitedratings != 1) {
				ri.rateit('readonly', true);
			 }
			 
			 if(noupdate==1) {
				 var divID = $(this).parent().parent().parent().attr("id");
				 $('#' + divID + ' .hidden-rating-value').val(rating);
			 } else {	
			 
			 	$.post(itAjax.ajaxurl, {
					action: 'itajax-user-rate',
					postID: postID,
					meta: meta,
					rating: rating,
					metric: metric,
					divID: divID
				}, function (response) {
					$('.user-rating .rated-legend').addClass('active');
					$('.ratings .total .user_rating > div').delay(200)
						.fadeOut(200)
						.delay(500)
						.queue(function(n) {
							$(this).html(response.totalrating);
							n();
						}).fadeIn(400);
					 $('#' + response.divID + ' .theme-icon-check').delay(200).fadeIn(100);	
					 $('.user-container	.meter').css('-webkit-transform','rotate(' + response.amount + ')');
					 $('.user-container	.meter').css('-moz-transform','rotate(' + response.amount + ')');
					 $('.user-container	.meter').css('-o-transform','rotate(' + response.amount + ')');
					 $('.user-container	.meter').css('msTransform','rotate(' + response.amount + ')');
					 $('.user-container	.meter').css('transform','rotate(' + response.amount + ')');					 
					 if(response.cssfill == 'showfill') {
						 $('.user-container .meter-slice').addClass('showfill');
						 if($('.user-container .meter-slice .meter.fill').length > 0) {
							$('.user-container .meter-slice .meter.fill').show();
							$('.user-container .meter-slice .meter.fill').css('-webkit-transform','rotate(' + response.amount + ')');
							$('.user-container .meter-slice .meter.fill').css('-moz-transform','rotate(' + response.amount + ')');
							$('.user-container .meter-slice .meter.fill').css('-o-transform','rotate(' + response.amount + ')');
							$('.user-container .meter-slice .meter.fill').css('msTransform','rotate(' + response.amount + ')');
							$('.user-container .meter-slice .meter.fill').css('transform','rotate(' + response.amount + ')');							
						 } else {
							$('.user-container .meter-slice').append('<div class="meter fill" style="-webkit-transform:rotate(' + response.amount + ');-moz-transform:rotate(' + response.amount + ');-o-transform:rotate(' + response.amount + ');-ms-transform:rotate(' + response.amount + ');transform:rotate(' + response.amount + ');"></div>');
						 }
					 } else {
						  $('.user-container .meter-slice').removeClass('showfill');
						  $('.user-container .meter-slice .meter.fill').hide();
					 }	
					 // hide comment ratings after top ratings are added
				 	 jQuery('#respond .rating-wrapper').hide();
					 jQuery('.hidden-rating-value').val('');
				});
			 }
		 });
	
		// update user ratings
		$( ".user-rating .form-selector" ).on( "slidestop", function( event, ui ) {
			var meta = $(this).parent().parent().parent().data('meta');
			var divID = $(this).parent().parent().parent().attr("id");			
			var postID = $(this).parent().parent().parent().data('postid');
			var rating = ui.value;
			var metric = $(this).parent().parent().parent().data('metric');	
			
			$.post(itAjax.ajaxurl, {
				action: 'itajax-user-rate',
				postID: postID,
				meta: meta,
				rating: rating,
				metric: metric,
				divID: divID
			}, function (response) {
				$('.ratings .rated-legend').addClass('active');
				$('#' + response.divID + '_wrapper').addClass('active');
				 if(response.unlimitedratings != 1) {
					$('#' + response.divID + '_wrapper').removeClass('rateable');
				 }				 
				 $('#' + response.divID + ' .rating-value').fadeOut(100)
					.delay(100)
					.queue(function(n) {
						$(this).html(response.newrating);
						n();
					}).fadeIn(150);
				 $('.ratings .total .user_rating > div').delay(200)
					.fadeOut(200)
					.delay(500)
					.queue(function(n) {
						$(this).html(response.totalrating);
						n();
					}).fadeIn(400);
				 $('#' + response.divID + ' .theme-icon-check').delay(200).fadeIn(100);	
				 $('.user-container	.meter').css('-webkit-transform','rotate(' + response.amount + ')');
				 $('.user-container	.meter').css('-moz-transform','rotate(' + response.amount + ')');
				 $('.user-container	.meter').css('-o-transform','rotate(' + response.amount + ')');
				 $('.user-container	.meter').css('msTransform','rotate(' + response.amount + ')');
				 $('.user-container	.meter').css('transform','rotate(' + response.amount + ')');				 
				 if(response.cssfill == 'showfill') {
					 $('.user-container .meter-slice').addClass('showfill');
					 if($('.user-container .meter-slice .meter.fill').length > 0) {
						$('.user-container .meter-slice .meter.fill').show();
					 	$('.user-container .meter-slice .meter.fill').css('-webkit-transform','rotate(' + response.amount + ')');
						$('.user-container .meter-slice .meter.fill').css('-moz-transform','rotate(' + response.amount + ')');
						$('.user-container .meter-slice .meter.fill').css('-o-transform','rotate(' + response.amount + ')');
						$('.user-container .meter-slice .meter.fill').css('msTransform','rotate(' + response.amount + ')');
						$('.user-container .meter-slice .meter.fill').css('transform','rotate(' + response.amount + ')');
					 } else {
					 	$('.user-container .meter-slice').append('<div class="meter fill" style="-webkit-transform:rotate(' + response.amount + ');-moz-transform:rotate(' + response.amount + ');-o-transform:rotate(' + response.amount + ');-ms-transform:rotate(' + response.amount + ');transform:rotate(' + response.amount + ');"></div>');
					 }
				 } else {
					  $('.user-container .meter-slice').removeClass('showfill');
					  $('.user-container .meter-slice .meter.fill').hide();
				 }	
				 // hide comment ratings after top ratings are added
				 jQuery('#respond .rating-wrapper').hide();
				 jQuery('.hidden-rating-value').val('');	
				 jQuery('.ratings .form-selector-wrapper').hide();				
			});			
		});
		
		// reaction button
		$('body').on('click', '.reaction.clickable', function(e){
			var postID = $('.reactions-wrapper').data('postid');
			var unlimitedreactions = $('.reactions-wrapper').data('unlimitedreactions');
			var reaction = $(this).data('reaction'); 
			var _this = this;
			$('.reaction-percentage').stop().animate({opacity: ".1"}, 100);
			$(this).addClass('selected');
			$(this).siblings().removeClass('selected');
			if(unlimitedreactions==0) {
				$(this).removeClass('clickable');
				$(this).siblings().addClass('clickable');
			}
			$.post(itAjax.ajaxurl, {
				action: 'itajax-reaction',
				postID: postID,
				reaction: reaction,
				unlimitedreactions: unlimitedreactions
			}, function (response) {
				if(unlimitedreactions==1) $(_this).addClass('clickable');
				$.each(response, function(key, value) {
					$('.reaction-percentage.' + key).html(value);
					var c = parseInt(value.replace('%',''));
					c = Math.round(c / 10);
					$('.reaction-percentage.' + key).removeClass().addClass('size' + c).addClass('reaction-percentage').addClass(key);					
				});
				$('.reaction-percentage').stop().animate({opacity: "1"}, 1200);
				$('#ajax-error').hide();
			});
		});
		
	});
}(jQuery));