<?php 
/*
this file contains functions relating to theme presentation that apply to all areas 
of the theme, including all posts, pages, and post types.
*/

if (!function_exists('it_sidebars')) {
	#register sidebars
	function it_sidebars() {
		#setup array of default sidebars
		$sidebars = array(
			'loop-sidebar' => array(
				'name' => __( 'Loop Sidebar', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the sidebar of the main loop.', IT_TEXTDOMAIN )
			),
			'grid-sidebar' => array(
				'name' => __( 'Grid Sidebar', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the sidebar of the Grid page builder element if unique sidebar is turned on in the theme options.', IT_TEXTDOMAIN )
			),
			'list-sidebar' => array(
				'name' => __( 'Blog Sidebar', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the sidebar of the Blog page builder element if unique sidebar is turned on in the theme options.', IT_TEXTDOMAIN )
			),
			'page-sidebar' => array(
				'name' => __( 'Page Sidebar', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the sidebar of the page content.', IT_TEXTDOMAIN )
			),
			'widgets-column-1' => array(
				'name' => __( 'Widgets Column 1', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the widgets column 1 which is available via the page builder.', IT_TEXTDOMAIN )
			),
			'widgets-column-2' => array(
				'name' => __( 'Widgets Column 2', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the widgets column 2 which is available via the page builder.', IT_TEXTDOMAIN )
			),
			'widgets-column-3' => array(
				'name' => __( 'Widgets Column 3', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the widgets column 3 which is available via the page builder.', IT_TEXTDOMAIN )
			),			
			'connect-widgets' => array(
				'name' => __( 'Connect Widgets', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the connect bar to the right of the email signup form.', IT_TEXTDOMAIN )
			),
			'footer-column-1' => array(
				'name' => __( 'Footer Column 1', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the first footer column.', IT_TEXTDOMAIN )
			),
			'footer-column-2' => array(
				'name' => __( 'Footer Column 2', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the second footer column.', IT_TEXTDOMAIN )
			),
			'footer-column-3' => array(
				'name' => __( 'Footer Column 3', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the third footer column.', IT_TEXTDOMAIN )
			),
			'footer-column-4' => array(
				'name' => __( 'Footer Column 4', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the fourth footer column.', IT_TEXTDOMAIN )
			),
			'footer-column-5' => array(
				'name' => __( 'Footer Column 5', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the fifth footer column.', IT_TEXTDOMAIN )
			),
			'footer-column-6' => array(
				'name' => __( 'Footer Column 6', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the sixth footer column.', IT_TEXTDOMAIN )
			)
		);
		
		#add woocommerce sidebar
		if(function_exists('is_woocommerce')) {
			$sidebars['woo-sidebar'] = array(
				'name' => __( 'WooCommerce Sidebar', IT_TEXTDOMAIN ), 
				'desc' => __( 'These widgets appear in the sidebar of the WooCommerce pages (if unique WooCommerce sidebars are turned on in the theme options).', IT_TEXTDOMAIN)
			);	
		}
		
		#add buddypress sidebar
		if(function_exists('bp_current_component')) {
			$sidebars['bp-sidebar'] = array(
				'name' => __( 'BuddyPress Sidebar', IT_TEXTDOMAIN ), 
				'desc' => __( 'These widgets appear in the sidebar of the BuddyPress pages (if unique BuddyPress sidebars are turned on in the theme options).', IT_TEXTDOMAIN)
			);	
		}
		
		#register sidebars
		foreach ( $sidebars as $type => $sidebar ){
			register_sidebar(array(
				'name' => $sidebar['name'],
				'id'=> $type,
				'description' => $sidebar['desc'],
				'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<div class="header clearfix"><div class="bar-label">',
				'after_title' => '</div></div>',
			));
		}
		
		#register custom sidebars areas
		$custom_sidebars = get_option( IT_SIDEBARS );
		if( !empty( $custom_sidebars ) ) {
			foreach ( $custom_sidebars as $id => $name ) {
				register_sidebar(array(
					'name' => $name,
					'id'=> "it_custom_sidebar_{$id}",
					'description' => '"' . $name . '"' . __(' custom sidebar was created in the Theme Options', IT_TEXTDOMAIN),
					'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
					'after_widget' => '</div>',
					'before_title' => '<div class="header"><div class="bar-label">',
					'after_title' => '</div></div>',
				));
			}
		}		
	}
}
if (!function_exists('it_widgets')) {
	#register widgets
	function it_widgets() {
		# Load each widget file.
		if ( file_exists( CHILD_THEME_WIDGETS . '/widget-latest-articles.php' ) )
			require_once( CHILD_THEME_WIDGETS . '/widget-latest-articles.php' );
		else if ( file_exists( THEME_WIDGETS . '/widget-latest-articles.php' ) )
			require_once THEME_WIDGETS . '/widget-latest-articles.php';
		if ( file_exists( CHILD_THEME_WIDGETS . '/widget-top-reviewed.php' ) )
			require_once( CHILD_THEME_WIDGETS . '/widget-top-reviewed.php' );
		else if ( file_exists( THEME_WIDGETS . '/widget-top-reviewed.php' ) )
			require_once THEME_WIDGETS . '/widget-top-reviewed.php';	
		if ( file_exists( CHILD_THEME_WIDGETS . '/widget-social-counts.php' ) )
			require_once( CHILD_THEME_WIDGETS . '/widget-social-counts.php' );
		else if ( file_exists( THEME_WIDGETS . '/widget-social-counts.php' ) )
			require_once THEME_WIDGETS . '/widget-social-counts.php';	
		if ( file_exists( CHILD_THEME_WIDGETS . '/widget-list-paged.php' ) )
			require_once( CHILD_THEME_WIDGETS . '/widget-list-paged.php' );
		else if ( file_exists( THEME_WIDGETS . '/widget-list-paged.php' ) )
			require_once THEME_WIDGETS . '/widget-list-paged.php';	
		if ( file_exists( CHILD_THEME_WIDGETS . '/widget-sections.php' ) )
			require_once( CHILD_THEME_WIDGETS . '/widget-sections.php' );
		else if ( file_exists( THEME_WIDGETS . '/widget-sections.php' ) )
			require_once THEME_WIDGETS . '/widget-sections.php';
		if ( file_exists( CHILD_THEME_WIDGETS . '/widget-top-ten.php' ) )
			require_once( CHILD_THEME_WIDGETS . '/widget-top-ten.php' );
		else if ( file_exists( THEME_WIDGETS . '/widget-top-ten.php' ) )
			require_once THEME_WIDGETS . '/widget-top-ten.php';
		if ( file_exists( CHILD_THEME_WIDGETS . '/widget-social-tabs.php' ) )
			require_once( CHILD_THEME_WIDGETS . '/widget-social-tabs.php' );
		else if ( file_exists( THEME_WIDGETS . '/widget-social-tabs.php' ) )
			require_once THEME_WIDGETS . '/widget-social-tabs.php';
		if ( file_exists( CHILD_THEME_WIDGETS . '/widget-reviews.php' ) )
			require_once( CHILD_THEME_WIDGETS . '/widget-reviews.php' );
		else if ( file_exists( THEME_WIDGETS . '/widget-reviews.php' ) )
			require_once THEME_WIDGETS . '/widget-reviews.php';
		if ( file_exists( CHILD_THEME_WIDGETS . '/widget-trending.php' ) )
			require_once( CHILD_THEME_WIDGETS . '/widget-trending.php' );
		else if ( file_exists( THEME_WIDGETS . '/widget-trending.php' ) )
			require_once THEME_WIDGETS . '/widget-trending.php';
	
		# Register each widget.
		register_widget( 'it_latest_articles' );
		register_widget( 'it_top_reviewed' );
		register_widget( 'it_social_counts' );
		register_widget( 'it_list_paged' );
		register_widget( 'it_top_ten' );
		register_widget( 'it_social_tabs' );
		register_widget( 'it_reviews' );
		register_widget( 'it_trending' );
		register_widget( 'it_sections' );
	}
}
if (!function_exists('it_header_scripts')) {
	#head scripts and css
	function it_header_scripts() { ?>
	
		<?php #begin style ?> 		
		<link media="screen, projection, print" rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" /> 
		<?php if(!it_get_setting('responsive_disable')) { ?>
			<link media="screen, projection" rel="stylesheet" href="<?php echo THEME_STYLES_URI; ?>/responsive.css" type="text/css" />
		<?php } ?>				
		<?php #end style ?>
		
		<?php #custom favicon ?>	
		<link rel="shortcut icon" href="<?php if( it_get_setting( 'favicon_url' ) ) { ?><?php echo esc_url( it_get_setting( 'favicon_url' ) ); ?><?php } else { ?>/favicon.ico<?php } ?>" />
		
		<?php #google fonts  
		#get specified subsets if any
		$subset = '';
		$subsets = ( is_array( it_get_setting("font_subsets") ) ) ? it_get_setting("font_subsets") : array();
		foreach ($subsets as $s) {
			$subset .= $s . ',';
		}
		#remove last comma
		if(!empty($subset)) $subset = mb_substr($subset, 0, -1);
		#custom typography fonts
		$fonts = array();
		$f = it_get_setting('font_section_menu');
		$f = str_replace(' ', '+', str_replace('"', '', str_replace(', sans-serif', '', $f)));
		$fonts[$f] = $f;
		$f = it_get_setting('font_slideout_menu');
		$f = str_replace(' ', '+', str_replace('"', '', str_replace(', sans-serif', '', $f)));
		$fonts[$f] = $f;
		$f = it_get_setting('font_utility_menu');
		$f = str_replace(' ', '+', str_replace('"', '', str_replace(', sans-serif', '', $f)));
		$fonts[$f] = $f;
		$f = it_get_setting('font_section_headers');
		$f = str_replace(' ', '+', str_replace('"', '', str_replace(', sans-serif', '', $f)));
		$fonts[$f] = $f;
		$f = it_get_setting('font_links');
		$f = str_replace(' ', '+', str_replace('"', '', str_replace(', sans-serif', '', $f)));
		$fonts[$f] = $f;
		$f = it_get_setting('font_titles');
		$f = str_replace(' ', '+', str_replace('"', '', str_replace(', sans-serif', '', $f)));
		$fonts[$f] = $f;
		$f = it_get_setting('font_headliner');
		$f = str_replace(' ', '+', str_replace('"', '', str_replace(', sans-serif', '', $f)));
		$fonts[$f] = $f;
		$f = it_get_setting('font_awards');
		$f = str_replace(' ', '+', str_replace('"', '', str_replace(', sans-serif', '', $f)));
		$fonts[$f] = $f;
		$f = it_get_setting('font_numbers');
		$f = str_replace(' ', '+', str_replace('"', '', str_replace(', sans-serif', '', $f)));
		$fonts[$f] = $f;
		$f = it_get_setting('font_section_titles');
		$f = str_replace(' ', '+', str_replace('"', '', str_replace(', sans-serif', '', $f)));
		$fonts[$f] = $f;
		$f = it_get_setting('font_text');
		$f = str_replace(' ', '+', str_replace('"', '', str_replace(', sans-serif', '', $f)));
		$fonts[$f] = $f;
		$f = it_get_setting('font_serif');
		$f = str_replace(' ', '+', str_replace('"', '', str_replace(', sans-serif', '', $f)));
		$fonts[$f] = $f;
		#don't repeat fonts
		$fonts = array_unique($fonts);
		foreach ($fonts as $font) {
			#exclude web fonts and default google fonts
			if(!empty($font) && (strpos($font, 'Arial')===false && strpos($font, 'Verdana')===false && strpos($font, 'Lucida+Sans')===false && strpos($font, 'Georgia')===false && strpos($font, 'Times+New+Roman')===false && strpos($font, 'Trebuchet+MS')===false && strpos($font, 'Courier+New')===false && strpos($font, 'Haettenschweiler')===false && strpos($font, 'Tahoma')===false && strpos($font, 'Roboto+Consensed')===false && strpos($font, 'Dosis')===false && strpos($font, 'Roboto+Slab')===false && strpos($font, 'Asap')===false && strpos($font, 'spacer')===false))
				echo "<link href='http://fonts.googleapis.com/css?family=".$font."&subset=".$subset."' rel='stylesheet' type='text/css'> \n";
		}
		#default fonts 
		$family = 'http://fonts.googleapis.com/css?family=Dosis|Asap:400,700|Roboto+Condensed:300italic,400,700,300|Roboto+Slab:400,300,700&amp;subset=';  
		echo '<link href="'.$family.$subset.'" rel="stylesheet" type="text/css">';
		?>
		
	<?php }
}
if (!function_exists('it_demo_styles')) {
	#demo panel scripts
	function it_demo_styles() { 
		$show_demo = it_get_setting('show_demo_panel');
		if($show_demo) { ?>
		
		<link id="menu-fonts-link" href='#' rel='stylesheet' type='text/css'>
		<link id="content-header-fonts-link" href='#' rel='stylesheet' type='text/css'>
		<link id="section-header-fonts-link" href='#' rel='stylesheet' type='text/css'>
		<link id="body-fonts-link" href='#' rel='stylesheet' type='text/css'>
		<link id="panels-fonts-link" href='#' rel='stylesheet' type='text/css'>
        <link id="number-fonts-link" href='#' rel='stylesheet' type='text/css'>
		<style id="menu-fonts-style" type="text/css"></style>
		<style id="content-header-fonts-style" type="text/css"></style>
		<style id="section-header-fonts-style" type="text/css"></style>
		<style id="body-fonts-style" type="text/css"></style>
		<style id="panels-fonts-style" type="text/css"></style>  
        <style id="number-fonts-style" type="text/css"></style>  
		
	<?php }
	}
}
if (!function_exists('it_demo_panel')) {
	#demo panel content
	function it_demo_panel() { 
		$show_demo = it_get_setting('show_demo_panel');
		if($show_demo) it_get_template_part('demo-panel');
	}
}
if (!function_exists('it_footer_styles')) {
	#custom javascript
	function it_footer_styles() { 		
		it_get_template_part('css'); # styles with php variables	
	}
}
if (!function_exists('it_footer_scripts')) {
	#custom javascript
	function it_footer_scripts() { 	
		it_get_template_part('scripts'); # custom js  	
	}
}
if (!function_exists('it_custom_javascript')) {
	#custom javascript
	function it_custom_javascript() {
		$custom_js = it_get_setting( 'custom_js' );
		
		if( empty( $custom_js ) )
			return;
			
		$custom_js = preg_replace( "/(\r\n|\r|\n)\s*/i", '', $custom_js );
		?><script type="text/javascript">
		/* <![CDATA[ */
		<?php echo stripslashes( $custom_js ); ?>
		/* ]]> */
	</script>
	<?php
	}
}
if (!function_exists('it_hide_pagination')) {
	#after post
	function it_hide_pagination() { ?>
	<!--
	<div class="hide-pagination">
		<?php /* there is an error when running ThemeCheck that says this theme does not have pagination when
		in fact it does, so this code is added to bypass that error, but it is hidden so it doesn't show up on the page */
		paginate_links();
		$args="";
		wp_link_pages( $args );
		?>
	</div>
	-->	
	<?php }
}
if (!function_exists('it_background_ad')) {
	#html display of background ad
	function it_background_ad() {
		$out = '';
		$url = it_get_setting('ad_background');	
		if(!empty($url)) $out .= '<a id="background-ad" href="' . $url .'"></a>';
		return $out;
	}
}
if (!function_exists('it_excerpt')) {
	#get custom length excerpts
	function it_excerpt($len = 230) {
		$excerpt = get_the_excerpt();
		$len++;
		if ( mb_strlen( $excerpt ) > $len ) {
			$subex = mb_substr( $excerpt, 0, $len - 5 );
			$exwords = explode( ' ', $subex );
			$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
			if ( $excut < 0 ) {
				$excerpt = mb_substr( $subex, 0, $excut );
			} else {
				$excerpt = $subex;
			}
			$excerpt .= '[...]';
		}
		return $excerpt;
	}
}
if (!function_exists('it_title')) {
	#get custom length titles
	function it_title($len = 110) {
		$title = get_the_title();		
		if (!empty($len) && mb_strlen($title)>$len) $title = mb_substr($title, 0, $len-3) . "...";
		return $title;
	}
}
if (!function_exists('it_signup_form')) {
	#html display of signup form
	function it_signup_form() {
	?>
	
		<div class="sortbar-right">
			<form id="feedburner_subscribe" class="subscribe" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo it_get_setting('feedburner_name'); ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
										
				<div class="email-label"><?php echo it_get_setting("loop_email_label"); ?></div>
			
				<div class="input-group info" title="<?php echo it_get_setting("loop_email_label"); ?>">
					<input class="col-md-2" id="appendedInputButton" type="text" name="email" placeholder="<?php _e('Email address',IT_TEXTDOMAIN); ?>">
					<button class="btn theme-icon-check" type="button"></button>
				</div>
				
				<input type="hidden" value="<?php echo it_get_setting('feedburner_name'); ?>" name="uri"/>
				<input type="hidden" name="loc" value="en_US"/>
			
			</form>
		</div>
		
	<?php 	
	}
}
if (!function_exists('it_archive_title')) {
	#html display of archive title
	function it_archive_title() {
		$out = '';
		if(!is_archive() && !is_search()) return false;			
		#determine title
		if(is_archive()) {
			if(isset($posts[0])) $post = $posts[0]; # Hack. Set $post so that the_date() works.
			if (is_category()) {
				$out = single_cat_title('', false);
			} elseif( is_tag() ) {
				$out = __("Posts Tagged &#8216;", IT_TEXTDOMAIN) . single_tag_title('', false) . "&#8217;";
			} elseif (is_day()) {
				$out = __("Archive for ", IT_TEXTDOMAIN) . get_the_date('F jS, Y');
			} elseif (is_month()) {
				$out = __("Archive for ", IT_TEXTDOMAIN) . get_the_date('F, Y');
			} elseif (is_year()) {
				$out = __("Archive for ", IT_TEXTDOMAIN) . get_the_date('Y');
			} elseif (is_author()) {
				$author = get_query_var('author_name') ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));	
				$out = __("All posts by ", IT_TEXTDOMAIN) . $author->display_name;
			} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
				$out = __("Blog Archives", IT_TEXTDOMAIN);
			}
		}
		if(is_search()) {
			$out = __('Search results for ' , IT_TEXTDOMAIN) . '"' . get_search_query() . '"';	
		}
		$out = '<h1 class="main-title archive-title">' . $out . '</h1>';
		return $out;	
	}
}
if (!function_exists('it_pagination')) {
	#html display of pagination
	function it_pagination($pages = '', $format, $range = 3) {	
		global $paged;
		$out = '';	
		$range = empty($range) ? 3 : $range;
		$loop = isset($format['loop']) ? $format['loop'] : '';
		$cols = isset($format['columns']) ? $format['columns'] : '';
		$layout = isset($format['layout']) ? $format['layout'] : '';
		$view = isset($format['view']) ? $format['view'] : '';
		$sort = isset($format['sort']) ? $format['sort'] : '';
		$numarticles = isset($format['numarticles']) ? $format['numarticles'] : '';
		$location = isset($format['location']) ? $format['location'] : '';
		$thumbnail = isset($format['thumbnail']) ? $format['thumbnail'] : '';
		$rating = isset($format['rating']) ? $format['rating'] : '';
		$icon = isset($format['icon']) ? $format['icon'] : '';
		$meta = isset($format['meta']) ? $format['meta'] : '';
		$award = isset($format['award']) ? $format['award'] : '';
		$badge = isset($format['badge']) ? $format['badge'] : '';
		$authorship = isset($format['authorship']) ? $format['authorship'] : '';
		$excerpt = isset($format['excerpt']) ? $format['excerpt'] : '';
		$large_first = isset($format['large_first']) ? $format['large_first'] : '';
		$this_paged = isset($format['paged']) ? $format['paged'] : 1;
		if(empty($paged)) $paged = $this_paged;	
		if($pages == '') {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if(!$pages)	$pages = 1;
		} 
		$start = $paged - $range;
		$stop = $paged + $range;
		$leftshown = false;
		$firstshown = false;
		$s = $start;
		if(1 != $pages)	{
			$out .= '<div class="pagination bar-header clearfix" data-loop="'.$loop.'" data-location="'.$location.'" data-sorter="'.$sort.'" data-columns="'.$cols.'" data-view="'.$view.'" data-thumbnail="'.$thumbnail.'" data-rating="'.$rating.'" data-icon="'.$icon.'" data-meta="'.$meta.'" data-numarticles="'.$numarticles.'" data-layout="'.$layout.'" data-award="'.$award.'" data-badge="'.$badge.'" data-authorship="'.$authorship.'" data-excerpt="'.$excerpt.'" data-largefirst="'.$large_first.'">';			
			for ($i = $start; $i <= $stop; $i++) {	
				if($i>0 && $i<=$pages) {
					$s++;
					$leftnum = $i - 1;
					$class="inactive";
					if($paged == $i) $class="active";
					#first page
					if($start > 1 && !$firstshown && !it_get_setting('first_last_disable')) {
						$firstshown = true;
						$out .= '<a class="styled inactive arrow first" data-paginated="1"><span class="theme-icon-first"></span></a>';	
					}
					#left arrow	
					if($start > 2 && !$leftshown && !it_get_setting('prev_next_disable')) {
						$leftshown = true;						
						if($leftnum > 1) $out .= '<a class="styled inactive arrow previous" data-paginated="' . $leftnum . '"><span class="theme-icon-previous"></span></a>';	
					}
					#page number
					$out .= '<a class="styled ' . $class . '" data-paginated="' . $i . '">' . $i . '</a>';						
				}
			}
			#right and last arrows	
			if($stop < $pages) {
				$rightnum = $s + 1;
				if(!it_get_setting('prev_next_disable') && $rightnum<=$pages) $out .= '<a class="styled inactive arrow next" data-paginated="' . $rightnum . '"><span class="theme-icon-next"></span></a>';	
				if(!it_get_setting('first_last_disable')) $out .= '<a class="styled inactive arrow last" data-paginated="' . $pages . '"><span class="theme-icon-last"></span></a>';	
			}		
			$out .= '</div>';
			return $out;
		}
	}
}
if (!function_exists('it_get_postnav')) {
	#html display of post nav
	function it_get_postnav() {	
		$out = '';
		$previous_hidden = '';
		$next_hidden = '';	
		$next_title = '';
		$next_url = '';
		$previous_title = '';
		$previous_url = '';
		$random_url = it_get_random_article();
		$next_post = get_next_post();
		if (!empty( $next_post )) {
			$next_title = $next_post->post_title;
			$next_url = get_permalink( $next_post->ID );
		} else {
			$next_hidden = ' hidden';	
		}
		$previous_post = get_previous_post();
		if (!empty( $previous_post )) {
			$previous_title = $previous_post->post_title;
			$previous_url = get_permalink( $previous_post->ID );
		} else {
			$previous_hidden = ' hidden';	
		}	
		
		$out .= '<div id="postnav">';
			$out .= '<div class="postnav-button previous-button add-active' . $previous_hidden . '">';			
				$out .= '<a class="styled" href="' . $previous_url . '"><span class="theme-icon-previous"></span></a>';
				$out .= '<div class="article-info">';
					$out .= '<a class="styled" href="' . $previous_url . '"></a>';
					$out .= '<span class="theme-icon-left-open"></span>';
					$out .= '<div class="article-label">' . __('previous article',IT_TEXTDOMAIN) . '</div>';
					$out .= '<div class="article-title">' . $previous_title . '</div>';
				$out .= '</div>';
			$out .= '</div>';
			$out .= '<div class="postnav-button random-button add-active">';	
				$out .= '<a class="styled" href="' . $random_url . '" title="' . __('Random Article',IT_TEXTDOMAIN) . '"><span class="theme-icon-random"></span></a>';
			$out .= '</div>';
			$out .= '<div class="postnav-button next-button add-active' . $next_hidden . '">';			
				$out .= '<a class="styled" href="' . $next_url . '"><span class="theme-icon-next"></span></a>';
				$out .= '<div class="article-info">';
					$out .= '<a class="styled" href="' . $next_url . '"></a>';
					$out .= '<span class="theme-icon-right-open"></span>';
					$out .= '<div class="article-label">' . __('next article',IT_TEXTDOMAIN) . '</div>';
					$out .= '<div class="article-title">' . $next_title . '</div>';
				$out .= '</div>';
			$out .= '</div>';				
		$out .= '</div>';
		
		return $out;
	}
}
if (!function_exists('it_get_sharing')) {
	#html display of social sharing options
	function it_get_sharing($args) {
		extract($args);
			
		$out = '';	
		
		$description = !empty($description) ? ' addthis:description="'.$description.'"' : '';
		
		$out .= '<div class="addthis_toolbox addthis_default_style addthis_20x20_style" addthis:title="'.$title.'" addthis:url="'.$url.'"'.$description.'>';
		$out .= '<a class="addthis_button_compact add-active"><span class="theme-icon-plus"></span></a>';
		$out .= '<a class="addthis_counter_facebook add-active info-bottom" title="' . __('Share',IT_TEXTDOMAIN) . '"><span class="theme-icon-facebook share-span"></span></a>';
		$out .= '<a class="addthis_counter_twitter add-active info-bottom" title="' . __('Tweet',IT_TEXTDOMAIN) . '"><span class="theme-icon-twitter share-span"></span></a>';	
		$out .= '</div>';
		if(it_get_setting('click_track_disable')) {
			$out .= '<script type="text/javascript">';
			$out .= 'var addthis_config = {';
			$out .= 'data_track_clickback: false ';
			$out .= '} ';
			$out .= '</script>';
		}
		$out .= '<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-52bdedab6bba4f2c"></script>';

		return $out;
	}	
}
if (!function_exists('it_secondary_menu')) {
	#html display of secondary menu
	function it_secondary_menu($menu, $position, $full = true) {
		$out = '';
		
		if($full) $out .= '<div class="standard-menu ' . $position . '">';
		if($full) $out .= '<div class="secondary-menu-full">' . $menu . '</div>';
		if($full) $out .= '<div class="secondary-menu-compact"><ul><li>';
		if($full) $out .= '<a id="secondary-menu-selector">';
		if($full) $out .= it_get_setting('secondary_menu_label')!='' ? it_get_setting('secondary_menu_label') : __('MORE', IT_TEXTDOMAIN);
		if($full) $out .= '<span class="theme-icon-down-fat"></span></a>';
		$out .= $menu;
		if($full) $out .= '</li></ul></div>';
		if($full) $out .= '</div>';
		
		return $out;
	}
}
if (!function_exists('it_section_menu')) {
	#html display of section menu
	function it_section_menu($compact = false) {
		global $post;
		$out = '<ul id="menu-section-menu" class="menu">';	
		if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'section-menu' ] ) ) {
			$menu = wp_get_nav_menu_object( $locations[ 'section-menu' ] );                                    
			$menu_items = wp_get_nav_menu_items($menu->term_id); 
			$numarticles = it_get_setting('section_menu_article_num');
			$preload = it_get_setting('section_menu_preload');
			$unloaded = $preload ? ' loaded' : ' unloaded';
			if(empty($numarticles)) $numarticles = 5;
			$thumbnail_disable = it_get_setting('section_menu_thumbnails_disable');
			$thumbnail = $thumbnail_disable ? false : true;
			#loop through each menu item
			foreach ( (array) $menu_items as $key => $menu_item ) {
				#resets
				$selected = '';
				$icon = '';
				$method = '';
				$term_link = '';
				$current = '';
				$loading = '';
				$placeholder = '';
				$object_name = '';
				$menu_content = '';
				$menu_args = array();
				$args = array();
				$terms = array();
				$loop = 'menu';
				$menu_item_type = 'mega';
				$csswhite = ' white';
				$cssicon = '';
				$cssmega = '';
				$menu_content = '';				
				if(it_get_setting('section_menu_icons_disable')) $cssicon = ' no-icon';
				
				#menu item variables
				$title = $menu_item->title;
				$url = $menu_item->url;
				$parentid = $menu_item->menu_item_parent;
				$objectid = $menu_item->object_id;
				$type = $menu_item->type;
				$object = $menu_item->object;
				$target = $menu_item->target;
				$classes = $menu_item->classes;
				$args = array('posts_per_page' => $numarticles);	
				
				$classes = !empty($classes) ? implode(' ', $classes) : '';	
				$target = $target ? ' target="_blank"' : '';	
		
				if($object=='category') {
					$method = $object;
					$object_name = 'category_name';
					if(is_category()) {
						if($objectid == get_query_var('cat')) $current = 'current-menu-item';					
					} elseif(is_single()) {
						if(in_category($objectid, $post->ID)) $current = 'current-menu-item';	
					}
					if(!it_get_setting('section_menu_icons_disable')) $icon = it_get_category_icon($objectid, $csswhite);			
				} elseif($object=='post_tag') {
					$method = $object;
					$object_name = 'tag';					
					if(is_tag()) {
						if($objectid == get_query_var('tag_id')) $current = 'current-menu-item';
					} elseif(is_single()) {
						if(has_tag($objectid, $post->ID)) $current = 'current-menu-item';	
					}					
				} else {
					$menu_item_type = 'standard';
					if(is_page() && $objectid == $post->ID) $current = 'current-menu-item';
				}
			 
				#this is a mega menu item
				if($menu_item_type=='mega') {
					$cssmega = ' mega-menu-item';
					if($compact) { #just terms are displayed for mmenu purposes instead of full blown mega menu content
						$menu_terms = get_terms($object, array('parent' => $objectid, 'hide_empty' => 0));
						if(!empty($menu_terms)) {
							$menu_content .= '<ul>';
							foreach ( $menu_terms as $term ) { 
								$term_counter++;
								$term_name = $term->name;
								$term_slug = $term->slug;
								$term_link = get_term_link($term_slug, $object);							
								if($term_counter==1) {
									$cssactive = ' active';
									$cssfirst = ' first';
								} else {
									$cssactive = ' inactive';
									$cssfirst = '';
								}							
								$menu_content .= '<li><a class="list-item' . $cssactive . $cssfirst . '" data-sorter="'.$term_slug.'" href="' . $term_link . '">' . $term_name . '</a></li>';							
							}
							$menu_content .= '</ul>';
						}
						$placeholder = $menu_content;
					} else {
						if($preload) {
							$menu_args = array('object' => $object, 'objectid' => $objectid, 'object_name' => $object_name, 'loop' => $loop, 'thumbnail' => $thumbnail, 'numarticles' => $numarticles, 'type' => $menu_item_type);
							$menu_content = it_mega_menu_item($menu_args);
						}
						$loading = '<ul class="placeholder mega-loader"><li><div class="loading"><span class="theme-icon-spin2"></span></div></li></ul>';
						$placeholder = '<div class="placeholder mega-content">' . $menu_content . '</div>';
					}
				}
				
				#display the menu item
				$out .= '<li id="menu-item-' . $objectid . '" class="menu-item menu-item-' . $objectid . ' ' . $type . ' ' . $current . $unloaded . $cssmega . '" data-loop="' . $loop . '" data-method="' . $method . '" data-numarticles="' . $numarticles . '" data-object_name="'.$object_name.'" data-object="'.$object.'" data-objectid="'.$objectid.'" data-thumbnail="'.$thumbnail.'" data-type="'.$menu_item_type.'">';
					$out .= '<a class="parent-item ' . $classes . $cssicon . '" href="' . $url . '"' . $target . '>' . $icon . '<span class="category-title">' . $title . '</span><span class="down-arrow">&nbsp;</span></a>';
					$out .= $loading;
					$out .= $placeholder;
				$out .= '</li>';
			}		
		}
		$out .= '</ul>';	
		return $out;
	}
}
if (!function_exists('it_mega_menu_item')) {
	#html display of section menu
	function it_mega_menu_item($args) {
		
		extract($args);
		
		#defaults
		$out = '';
		$args = array();
		$format = array();
		$term_count = 0;
		$post_count = 0;
		$term_counter = 0;
		$mega_dropdown = false;
		$width = 168;
		$height = 117;
		
		#see if this term has sub terms
		$terms = get_terms($object, array('parent' => $objectid, 'hide_empty' => 0));
		if(!empty($terms)) $first_term = $terms[0]->slug;		
	
		#only get loop for mega menu items
		if($type == 'mega') {
			#no term list was found, don't display sub terms
			if(empty($terms)) {
				$term = get_term_by('id', $objectid, $object);
				$first_term = $term->slug;
			}		
			$term_count = count($terms);	
			#add first object to args
			$args[$object_name] = $first_term;
			#get the link for the first object
			$term_link = get_term_link($first_term, $object);
			if(is_wp_error($term_link)) {
				echo '<div id="ajax-error">' . $term_link->get_error_message() . '</div><style type="text/css">#ajax-error{display:block !important;}</style>';	
				$term_link = '';
			}
			#setup args
			$size = $term_count > 0 ? 'menu' : 'menu-large';
			$format = array('loop' => $loop, 'location' => $loop, 'thumbnail' => $thumbnail, 'rating' => false, 'icon' => false, 'size' => $size, 'width' => $width, 'height' => $height);
			$args = array('posts_per_page' => $numarticles, $object_name => $first_term, 'post_status' => 'publish');
			#query posts
			$loop = it_loop($args, $format);
			$post_count = $loop['posts'];
			
		}
		
		if($term_count > 0 || $post_count > 0) $mega_dropdown = true;
	
		#begin mega drop down
		if($mega_dropdown) {
			$out .= '<div class="mega-wrapper';
			if($term_count == 0) $out .= ' solo';
			$out .= '">';
				$out .= '<div class="post-list clearfix">';
					$out .= '<div class="loading"><span class="theme-icon-spin2"></span></div>';
					$out .= '<div class="clearfix">' . $loop['content'] . '</div>';
					$out .= '<a class="view-all" href="' . $term_link . '">' . __('VIEW ALL',IT_TEXTDOMAIN) . '<span class="theme-icon-right-fat"></span></a>';
				$out .= '</div>';
				
				#begin sub term menu list
				if($term_count > 0) {
					$out .= '<div class="term-list">';
						foreach ( $terms as $term ) { 
							$term_counter++;
							$term_name = $term->name;
							$term_slug = $term->slug;
							$term_link = get_term_link($term_slug, $object);							
							if($term_counter==1) {
								$cssactive = ' active';
								$cssfirst = ' first';
							} else {
								$cssactive = ' inactive';
								$cssfirst = '';
							}							
							$out .= '<a class="list-item' . $cssactive . $cssfirst . '" data-sorter="'.$term_slug.'" href="' . $term_link . '" data-size="'.$size.'" data-width="'.$width.'" data-height="'.$height.'">' . $term_name . '</a>';							
						}
					$out .= '</div>';
				}							
			$out .= '</div>';				
		}
		return $out;	
	}
}
if (!function_exists('it_widget_panel')) {
	#html display of sidebar
	function it_widget_panel($widgets, $class, $wrapper = true) {
		$out = '';
		$class = !empty($class) ? $class : '';
		if($wrapper) $out .= '<div class="widgets-wrapper"><div class="widgets ' . $class . '">';
		#put the sidebar in a variable for later display
		ob_start();
		dynamic_sidebar($widgets);
		$sidebar = ob_get_contents();
		ob_end_clean();			
		if ( !empty($sidebar) ) {				
			$out .= $sidebar;
		} else {
			$out .= '<div class="widget">';			
				$out .= '<div class="header">';					
					$out .= '<h3>'.$widgets.'</h3>';						
				$out .= '</div>';
			$out .= '</div>';			
		}			
		if($wrapper) $out .= '</div></div>';	
		return $out;	
	}
}
if (!function_exists('it_featured_image')) {
	#get featured image
	function it_featured_image($args) {
		extract($args);
		$caption_text = get_post(get_post_thumbnail_id())->post_excerpt;
		if(empty($caption_text)) $caption = false;
		$out = '';
		$featured_image = '';
		if($wrapper) $out.='<div class="featured-image-wrapper"><div class="featured-image-inner">';
		if($type=='hero') {
			$featured_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($postid), $size );
			if(empty($featured_image_url)) $featured_image_url[] = THEME_IMAGES.'/placeholder-'.$width.'.png';
			$featured_image .= '<img src="'.THEME_IMAGES.'/blank.gif" data-src="'.$featured_image_url[0].'" alt="featured image" width="'.$width.'" height="'.$height.'" />';
		} else {
			if($itemprop) {
				$featured_image .= get_the_post_thumbnail($postid, $size, array( 'title' => get_the_title(), 'itemprop' => 'image' ));
			} else {
				$featured_image .= get_the_post_thumbnail($postid, $size, array( 'title' => get_the_title()));
			}
		}
		if(empty($featured_image)) {
			$featured_image .= '<img';
			if($itemprop) $featured_image .= ' itemprop="image"';
			if($type=='hero') {
				$featured_image .= ' src="'.THEME_IMAGES.'/blank.gif" data-src="'.THEME_IMAGES.'/placeholder-'.$width.'.png"';
			} else {
				$featured_image .= ' src="'.THEME_IMAGES.'/placeholder-'.$width.'.png"';
			}
			$featured_image .= ' alt="featured image" width="'.$width.'" height="'.$height.'" />';
		}
		$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
		if($link) $out .= '<a class="darken featured-image info" href="' . $large_image_url[0] . '" title="' . __('Click for full view',IT_TEXTDOMAIN) . '">';
		$out .= $featured_image;
		if($link) $out .= '</a>';
		if($caption) $out .= '<div class="wp-caption">' . $caption_text . '</div>';
		if($wrapper) $out.='</div></div>';
		return $out;
	}
}
if (!function_exists('it_video')) {
	#html display of featured video
	function it_video( $args = array() ) {	
		extract( $args );	
		$out = '';
		$video_id = '';
		# Vimeo video
		if( preg_match_all( '#https?://(www.vimeo|vimeo)\.com(/|/clip:)(\d+)(.*?)#i', $url, $matches ) ) {
			if( !empty( $parse ) ) {				
				
				if ( preg_match( '#https?://(www.vimeo|vimeo)\.com(/|/clip:)(\d+)(.*?)#i', $url, $matches ) > 0 ) {
					$video_id = $matches[3];			
				} elseif ( preg_match('/^([a-zA-Z0-9\-\_]+)$/i', $url, $matches ) > 0 ) {
					$video_id = $matches[1];
				}
				
				if($frame) $out .= '<div class="video-container featured-video-wrapper">';
				
					if($type=='link') {
						
						$out .= '<a href="http://player.vimeo.com/video/' . $video_id . '?title=0&amp;byline=0&amp;portrait=0&amp;autoplay=0&amp;loop=0&js_api=1&js_swf_id=vimeo_video_' . $video_id . '" data-type="video">Vimeo video</a>';
						
					} else {
			
						$out .= '<iframe id="vimeo_video_' . $video_id . ' class="vimeo_video" src="http://player.vimeo.com/video/' . $video_id . '?badge=0&amp;title=0&amp;byline=0&amp;portrait=0&amp;autoplay=' . $autoplay . '&amp;loop=0" width="' . $width . '" height="' . $height . '" webkitallowfullscreen mozallowfullscreen allowfullscreen frameborder="0"></iframe>';
						
					}
				
				if($frame) $out .= '</div>';
				
				return $out;				
				
			} else {				
				return 'vimeo';				
			}
			
		} elseif( preg_match( '#https?://(www.youtube|youtube|[A-Za-z]{2}.youtube)\.com/(.*?)#i', $url, $matches ) ) {
			
			if( !empty( $parse ) ) {					
				
				$controls = empty( $video_controls ) ? 0 : 1;
				
				if ( preg_match( '/^https?\:\/\/(?:(?:[a-zA-Z0-9\-\_\.]+\.|)youtube\.com\/watch\?v\=|youtu\.be\/)([a-zA-Z0-9\-\_]+)/i', $url, $matches ) > 0 ) {
					$video_id = $matches[1];			
				} elseif ( preg_match('/^([a-zA-Z0-9\-\_]+)$/i', $url, $matches ) > 0 ) {
					$video_id = $matches[1];					
				}
				
				if($frame) $out .= '<div class="video-container featured-video-wrapper">';
				
					if($type=='link') {
						
						$out .= '<a href="https://www.youtube.com/embed/' . $video_id . '?hd=1&wmode=opaque&controls=' . $controls . '&showinfo=0" data-type="video">Youtube video</a>';
						
					} else {
		
						$out .= '<iframe id="youtube_video_' . $video_id . '" class="youtube_video" src="https://www.youtube.com/embed/' . $video_id . '?autohide=1&amp;autoplay=' . $autoplay . '&amp;controls=' . $controls . '&amp;disablekb=0&amp;hd=1&amp;loop=0&amp;rel=1&amp;showinfo=0&amp;showsearch=0&amp;wmode=transparent&amp;enablejsapi=1" width="' . $width . '" height="' . $height . '" allowfullscreen></iframe>';
						
					}
				
				if($frame) $out .= '</div>';
				
				return $out;				
				
			} else {		
				return 'youtube';
			}
				
		} else {
			return false;
		}
	}
}
if (!function_exists('it_get_ad')) {
	#inject ad into loop
	function it_get_ad($ads, $postcount, $adcount, $cols, $nonajax) {	
		$out = '';					
		$csscol = ' col-md-12';
		switch($cols) {
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
		if(it_get_setting('ad_num')!=0 && (($postcount==it_get_setting('ad_offset')+1) || (($postcount-it_get_setting('ad_offset')-1) % (it_get_setting('ad_increment'))==0) && $postcount>it_get_setting('ad_offset') && (it_get_setting('ad_num')>$adcount)) && ($nonajax || it_get_setting('ad_ajax'))) {				
			$out.='<div class="article-panel clearfix it-ad' . $csscol . '">';			
				$out .= do_shortcode($ads[$adcount]);		
			$out.='</div>';	
			$adcount++; #increase adcount		
			$postcount++; #increase postcount				
		}	
		$counts=array('ad' => $out, 'postcount' => $postcount, 'adcount' => $adcount);	
		return $counts;	
	}
}
if (!function_exists('it_show_ad')) {
	#inject ad into loop
	function it_show_ad($ad, $id, $row = false) {	
		if(!empty($ad)) {
			if($row) echo '</div><div class="row">';
			echo '<div class="col-md-12 it-ad-wrapper">';
				echo '<div class="it-ad" id="it-ad-'.$id.'">';
					echo do_shortcode($ad);
				echo '</div>';
			echo '</div>';
		}
	}
}
if (!function_exists('it_get_categories')) {	
	#html display of list of comma separated categories
	function it_get_categories($postid, $label = false) {
		$categories = get_the_category($postid);
		$separator = ', ';
		$out = '';
		if($categories) {
			$out .= '<div class="category-list">';
				if($label) $out .= '<span class="theme-icon-category"></span>';
				
				foreach($categories as $category) {
					$out .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", IT_TEXTDOMAIN ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
				}
				$out = substr_replace($out,"",-2);
				
			$out .= '</div>';
		}	
		return $out;
	}
}
if (!function_exists('it_get_primary_categories')) {	
	#html display of list of categories with optional icons
	function it_get_primary_categories($args) {
		
		extract($args);
		
		if(empty($postid)) return false;
		
		#get this post's primary category
		$primary = get_post_meta($postid, '_primary_category', true);
		
		#get ids of all category icons specified in theme options
		$categories = it_get_setting('categories');	
		$category_ids = array();	
		foreach($categories as $category) {
			if(is_array($category)) {
				if(array_key_exists('id',$category)) {
					if(!empty($category['id'])) $category_ids[] = $category['id'];	
				}
			}
		}
		
		#handle white css
		$csswhite = '';
		if($white) $csswhite = ' white';
		$out='';
		$cats='';	
		$shown = array();	
		$categories_assigned = get_the_category($postid);
		#loop through all assigned categories
		foreach($categories_assigned as $category_assigned){	
			$this_id = $category_assigned->term_id;
			$this_name = $category_assigned->name;
			$this_ancestors = get_ancestors($this_id, 'category');
			#this category matches one setup in the theme options		
			if(in_array($this_id, $category_ids)) {	
				if(empty($primary) || $primary==$this_id) {
					$shown[] = $this_id;
					if($id) $cats .= $this_id;	
					#the images are actually background images assigned in the css.php file			
					if($icon) $cats .= it_get_category_icon($this_id, $csswhite);
					if($label) $cats .= '<span class="category-name category-name-' . $this_id . '">' . $this_name . '</span>';	
					if($single) break;	
				}
			}	
			#check ancestors
			foreach($this_ancestors as $this_ancestor){
				#this category matches one setup in the theme options		
				if(in_array($this_ancestor, $category_ids) && !in_array($this_ancestor, $shown)) {	
					if(empty($primary) || $primary==$this_id) {
						if($id) $cats .= $this_ancestor;	
						#the images are actually background images assigned in the css.php file			
						if($icon) $cats .= it_get_category_icon($this_ancestor, $csswhite);
						if($label) $cats .= '<span class="category-name category-name-' . $this_ancestor . '">' . get_cat_name($this_ancestor) . '</span>';	
						if($single) break 2;	
					}
				}
			}			
		}
		if(!empty($cats)) {
			if($wrapper) $out.='<div class="category-icon-wrapper">';
				$out.=$cats;
			if($wrapper) $out.='</div>';
		}
		
		return $out;	
	}
}
if (!function_exists('it_get_category_icon')) {	
	#html display of individual category icon
	function it_get_category_icon($id, $csswhite) {
		$out = '<span class="category-icon category-icon-' . $id . $csswhite . '"></span>';
		return $out;
	}
}
if (!function_exists('it_get_tags')) {	
	#get tags for the current post excluding template tags
	function it_get_tags($postid, $separator = '') {
		$out = '';	
		$tags = wp_get_post_tags($postid); #get all tag objects for this post
		$count=0;
		$tagcount=0;
		foreach($tags as $tag) {	#determine number of tags
			$tagcount++;
		}		
		foreach($tags as $tag) {	#display tag list
			$count++;			
			$tag_link = get_tag_link($tag->term_id);
			$out .= '<a href="'.$tag_link.'" title="'.$tag->name.' Tag" class="'.$tag->slug.'">'.$tag->name.'</a>';
			if($count<$tagcount) {
				$out .= $separator; #add the separator if this is not the last tag
			}						
		}	
		#satisfy theme check requirements
		$out .= get_the_tag_list('<div class="hidden-tags">',', ','</div>');	
		return $out;
	}
}
if (!function_exists('it_get_authorship')) {	
	#get authorship (date and author) into variable
	function it_get_authorship($type = 'both', $prefix = true, $csscat = '') {
		$out = '';
		$out .= '<div class="authorship type-' . $type . $csscat . '">';
			if($type!='date') {
				$out .= '<span class="author">';
					if($prefix) $out .= __('by',IT_TEXTDOMAIN) . '&nbsp;';
					$out .= '<a class="styled" href="' . get_author_posts_url(get_the_author_meta('ID')) . '">';
						$out .= get_the_author();
					$out .= '</a>';
				$out .= '</span>';
			}
			if($type!='author') {
				$out .= '<span class="date">';
					if($prefix) $out .= '&nbsp;' . __('on',IT_TEXTDOMAIN) . '&nbsp;';
					$out .=  get_the_date();
				$out .= '</span>';
			}
		$out .= '</div>';
		return $out;
	}
}
if (!function_exists('it_get_loadmore')) {
	#html display of load more button
	function it_get_loadmore($args) {
		extract($args);
		$out = '';
		if($paged >= $numpages) return false;
		$out .= '<div class="load-more-wrapper add-active" data-loop="'.$loop.'" data-location="'.$location.'" data-sorter="'.$sort.'" data-columns="'.$columns.'" data-layout="'.$layout.'" data-view="'.$view.'" data-thumbnail="'.$thumbnail.'" data-rating="'.$rating.'" data-icon="'.$icon.'" data-meta="'.$meta.'" data-numarticles="'.$numarticles.'" data-paginated="' . $paged . '" data-numpages="' . $numpages . '" data-badge="'.$badge.'" data-award="'.$award.'" data-authorship="'.$authorship.'" data-excerpt="'.$excerpt.'">';
			$out .= '<div class="load-more">';
				$out .= __('LOAD MORE',IT_TEXTDOMAIN);
				$out .= '<span class="theme-icon-down-fat"></span>';
			$out .= '</div>';
		$out .= '</div>';
		return $out;	
	}
}	
if (!function_exists('it_get_contents_menu')) {
	#html display of the contents menu
	function it_get_contents_menu($postid, $disabled) {
		$out = '';
		$cssadminbar = is_admin_bar_showing() ? ' admin-bar' : '';
		$layout = it_get_setting('contents_menu_position');
		$cssvertical = $layout=='vertical' ? ' vertical' : '';
		$details_position = it_get_setting('review_details_position');
		$ratings_position = it_get_setting('review_ratings_position');
		
		$out .= '<div class="contents-menu-wrapper' . $cssvertical . '">';
			$out .= '<div class="bar-header sortbar full-width contents-menu' . $cssadminbar . '">';
				$out .= '<div class="bar-label-wrapper no-filters">';
					$out .= '<div class="bar-label light">';
						$out .= '<div class="label-text"><span class="theme-icon-bookmark"></span>' . __('Contents',IT_TEXTDOMAIN) . '</div>';
					$out .= '</div>';
				$out .= '</div>';
				$out .= '<ul class="sort-buttons nav">';
					
					if(!in_array('overview', $disabled) && $details_position=='top') $out .= '<li id="overview-anchor-wrapper"><a href="#overview-anchor">' . __('Overview',IT_TEXTDOMAIN) . '</a></li>';
					if(!in_array('rating', $disabled) && $ratings_position=='top') $out .= '<li id="rating-anchor-wrapper"><a href="#rating-anchor"><span class="theme-icon-reviewed"></span>' . __('Rating',IT_TEXTDOMAIN) . '</a></li>';
					
					$out .= '<li id="content-anchor-wrapper"><a href="#content-anchor">' . __('Full Article',IT_TEXTDOMAIN) . '</a></li>';
					
					if(!in_array('overview', $disabled) && $details_position=='bottom') $out .= '<li id="overview-anchor-wrapper"><a href="#overview-anchor">' . __('Overview',IT_TEXTDOMAIN) . '</a></li>';
					if(!in_array('rating', $disabled) && $ratings_position=='bottom') $out .= '<li id="rating-anchor-wrapper"><a href="#rating-anchor"><span class="theme-icon-reviewed"></span>' . __('Rating',IT_TEXTDOMAIN) . '</a></li>';
					
					if(!in_array('comments', $disabled)) $out .= '<li id="comments-anchor-wrapper"><a href="#comments"><span class="theme-icon-commented"></span>' . __('Comments',IT_TEXTDOMAIN) . '</a></li>';
				$out .= '</ul>';
			$out .= '</div>';
		$out .= '</div>';
		
		return $out;	
	}
}
if (!function_exists('it_get_sortbar')) {	
	#html display of sortbar
	function it_get_sortbar($args) {
		extract($args);
		$out = '';	
		$i = 0;
		$cssactive = '';
		$active_shown = false;
		if(empty($title) && empty($theme_icon) && empty($category_icon)) $disable_title = true;
		$timeperiod = !empty($timeperiod) ? $timeperiod : '';
		$cssfilters = $disable_filters ? ' no-filters' : '';
		$cssheader = $disable_title && $disable_filters ? ' hidden' : '';
		$theme_icon = !empty($theme_icon) ? '<span class="theme-icon-' . $theme_icon . '"></span>' : '';
		$category_icon = isset($category_icon) ? $category_icon : '';
		$csswrapper = isset($type) ? $type : 'metrics';
		$type = isset($type) ? $type : '';
		$default = isset($default) ? $default : '';
		$out .= '<div class="bar-header sortbar clearfix' . $cssheader . ' ' . $cssclass . '">';					
			if(!$disable_title) $out .= '<div class="bar-label-wrapper' . $cssfilters . '"><div class="bar-label"><div class="label-text">' . $theme_icon . $category_icon . $title . '</div></div></div>';
			if(!$disable_filters) {		
				if(!it_get_setting("loop_tooltips_disable")) $infoclass="info-bottom";	
				
				$out .= '<div class="sort-buttons sort-' . $csswrapper . '" data-loop="' . $loop . '" data-location="' . $location . '" data-view="' . $view . '" data-numarticles="'.$numarticles.'" data-columns="' . $cols . '" data-paginated="1" data-thumbnail="'.$thumbnail.'" data-rating="'.$rating.'" data-meta="'.$meta.'" data-layout="'.$layout.'" data-icon="'.$icon.'" data-badge="'.$badge.'" data-award="'.$award.'" data-authorship="'.$authorship.'" data-excerpt="'.$excerpt.'" data-largefirst="'.$large_first.'" data-timeperiod="'.$timeperiod.'">';	
				
					if($type=='sections') {	
					
						$sections = it_get_setting('widgets_section_categories');	
						
						if(empty($sections)) return false;					
						
						foreach ($sections as $section) {
							
							$i++;
							$cssactive = $i==1 ? ' active' : '';
							$icon = it_get_category_icon($section, '');
							$title = get_cat_name($section);
							$out .= '<a data-sorter="' . $section . '" class="' . $infoclass . $cssactive . ' styled" title="' . $title . '">' . $icon . '</a>';
							
						}
							
					} else {	
								
						if(!in_array('recent', $disabled_filters)) {
							if(!$active_shown && (empty($default) || $default=='recent')) {
								$active_shown = true;
								$cssactive='active';	
							} else {
								$cssactive='';
							}
							$out .= '<a data-sorter="recent" class="styled theme-icon-recent recent ' . $cssactive . ' ' . $infoclass . '" title="' . $title . '">&nbsp;</a>';
						}
						if(!in_array('viewed', $disabled_filters)) {
							if(!$active_shown && (empty($default) || $default=='viewed')) {
								$active_shown = true;
								$cssactive='active';	
							} else {
								$cssactive='';
							}
							$out .= '<a data-sorter="viewed" class="styled theme-icon-viewed viewed ' . $cssactive . ' ' . $infoclass . '" title="' . __('Most Viewed', IT_TEXTDOMAIN) . '">&nbsp;</a>';
						}	
						if(!in_array('liked', $disabled_filters)) {
							if(!$active_shown && (empty($default) || $default=='liked')) {
								$active_shown = true;
								$cssactive='active';	
							} else {
								$cssactive='';
							} 
							$out .= '<a data-sorter="liked" class="styled theme-icon-liked liked ' . $cssactive . ' ' . $infoclass . '" title="' . __('Most Liked', IT_TEXTDOMAIN) . '">&nbsp;</a>';
						}			
						if(!in_array('reviewed', $disabled_filters)) {
							if(!$active_shown && (empty($default) || $default=='reviewed')) {
								$active_shown = true;
								$cssactive='active';	
							} else {
								$cssactive='';
							}
							$out .= '<a data-sorter="reviewed" class="styled theme-icon-reviewed reviewed ' . $cssactive . ' ' . $infoclass . '" title="' . __('Best Reviewed', IT_TEXTDOMAIN) . '">&nbsp;</a>';
						}					 
						if(!in_array('rated', $disabled_filters)) {
							if(!$active_shown && (empty($default) || $default=='rated')) {
								$active_shown = true;
								$cssactive='active';	
							} else {
								$cssactive='';
							}
							$out .= '<a data-sorter="users" class="styled theme-icon-users users ' . $cssactive . ' ' . $infoclass . '" title="' . __('Highest Rated', IT_TEXTDOMAIN) . '">&nbsp;</a>';
						}					
						if(!in_array('commented', $disabled_filters)) {
							if(!$active_shown && (empty($default) || $default=='commented')) {
								$active_shown = true;
								$cssactive='active';	
							} else {
								$cssactive='';
							}
							$out .= '<a data-sorter="commented" class="styled theme-icon-commented commented ' . $cssactive . ' ' . $infoclass . '" title="' . __('Most Commented', IT_TEXTDOMAIN) . '">&nbsp;</a>';
						}					
						if(!in_array('awarded', $disabled_filters)) {
							if(!$active_shown && (empty($default) || $default=='awarded')) {
								$active_shown = true;
								$cssactive='active';	
							} else {
								$cssactive='';
							}
							$out .= '<a data-sorter="awarded" class="styled theme-icon-awarded awarded ' . $cssactive . ' ' . $infoclass . '" title="' . __('Recently Awarded', IT_TEXTDOMAIN) . '">&nbsp;</a>';
						}
						if(!in_array('title', $disabled_filters)) {	
							if(!$active_shown && (empty($default) || $default=='title')) {
								$active_shown = true;
								$cssactive='active';	
							} else {
								$cssactive='';
							}
							$out .= '<a data-sorter="title" class="styled theme-icon-sort title ' . $cssactive . ' ' . $infoclass . '" title="' . __('Alphabetical By Title', IT_TEXTDOMAIN) . '">&nbsp;</a>';
						}
					}
				$out .= '</div>';	
			}			
		$out .= '</div>';		
		return $out;	
	}
}
if (!function_exists('it_get_likes')) {	
	#html display of likes
	function it_get_likes($args) {
		extract($args);
		$out = '';
		$tooltip = '';
		#determine if this post was already liked
		$ip=it_get_ip();
		$ips = get_post_meta($postid, IT_META_LIKE_IP_LIST, $single = true);
		$likeaction='like'; #default action is to like
		if(strpos($ips,$ip) !== false) $likeaction='unlike'; #already liked, need to unlike instead
		$likes = get_post_meta($postid, IT_META_TOTAL_LIKES, $single = true);	
		$label_text=__(' likes',IT_TEXTDOMAIN);
		if($likes==1) $label_text=__(' like',IT_TEXTDOMAIN);
		if(empty($likes) && $label) $likes=0; #display 0 if displaying the label
		if(empty($tooltip_hide)) $tooltip = ' info-bottom';
		if($clickable) {
			$out.='<a class="styled like-button do-like '.$postid.$tooltip.'" data-postid="'.$postid.'" data-likeaction="'.$likeaction.'" title="'.__('Likes',IT_TEXTDOMAIN).'">';
		} else {
			$out='<span class="metric' . $tooltip . '" title="'.__('Likes',IT_TEXTDOMAIN).'">';
		}
		if($icon) $out.='<span class="icon theme-icon-liked '.$likeaction.'"></span>';
		$out.='<span class="numcount">'.$likes;
		if($label) $out.=$label_text;
		$out.='</span>';
		if($clickable) {
			$out.='</a>';
		} else {
			$out.='</span>';
		}
		return $out;
	}
}
if (!function_exists('it_get_views')) {	
	#html display of views
	function it_get_views($args) {
		extract($args);
		$tooltip = '';
		$views = get_post_meta($postid, IT_META_TOTAL_VIEWS, $single = true);
		$label_text=__(' views',IT_TEXTDOMAIN);
		if($views==1) $label_text=__(' view',IT_TEXTDOMAIN);
		if(empty($tooltip_hide)) $tooltip = ' info-bottom';
		$out='<span class="metric' . $tooltip . '" title="'.__('Views',IT_TEXTDOMAIN).'">';
		if(!empty($views)) {
			if($icon) $out.='<span class="icon theme-icon-viewed"></span>';
			$out.='<span class="numcount">';
			$out.='<span class="view-count">'.$views.'</span>';
			if($label) $out.='<span class="labeltext">'.$label_text.'</span>';
			$out.='</span>';
		}
		$out.='</span>';
		return $out;
	}
}
if (!function_exists('it_get_comments')) {	
	#html display of comment count
	function it_get_comments($args) {
		extract($args);
		$tooltip = '';
		$comments = get_comments_number($postid);
		$label_text=__(' comments',IT_TEXTDOMAIN);
		if($comments==1) $label_text=__(' comment',IT_TEXTDOMAIN);
		if(empty($tooltip_hide)) $tooltip = ' info-bottom';
		$out='<span class="metric' . $tooltip . '" title="'.__('Comments',IT_TEXTDOMAIN).'">';
		if($comments>0 || $showifempty) {
			if($anchor_link) $out.='<a href="#comments">';
				if($icon) $out.='<span class="icon theme-icon-commented"></span>';
				$out.='<span class="numcount">'.$comments;
				if($label) $out.=$label_text;
				$out.='</span>';
			if($anchor_link) $out.='</a>';
		}
		$out.='</span>';
		return $out;
	}
}
if (!function_exists('it_get_affiliate_code')) {	
	#html display of affiliate code
	function it_get_affiliate_code($postid, $css = '') {
		$code = get_post_meta($postid, IT_META_AFFILIATE_CODE, $single = true);
		if(empty($code) || $code=='') return false;
		$out = '';
		$out .= '<div class="affiliate-code clearfix ' . $css . '">';
			$out .= stripslashes(do_shortcode($code));
		$out .= '</div>';
		return $out;
	}
}
if (!function_exists('it_author_latest_article')) {	
	#html display of author's latest article
	function it_author_latest_article($authorid) {
		$out = '';
		$authorargs = array( 'post_type' => 'any', 'author' => $authorid, 'showposts' => 1);
		$recentPost = new WP_Query($authorargs);
		if($recentPost->have_posts()) : while($recentPost->have_posts()) : $recentPost->the_post();	
			$out.=__( 'Latest Article: ', IT_TEXTDOMAIN );
			$out.='<a href="'.get_permalink().'">'.get_the_title().'</a>';
		endwhile;
		endif;
		return $out;	
	}
}
if (!function_exists('it_get_author_loop')) {
	#html display of author listing loop
	function it_get_author_loop() {
		$out='';
		#get the author array based on theme settings
		$avatar_size = 105;	
		$display_admins = it_get_setting('author_admin_enable');
		$hide_empty = it_get_setting('author_empty_disable');
		$manual_exclude = it_get_setting('author_exclude');		
		$order_by = it_get_setting('author_order');
		$role = it_get_setting('author_role');
		$authors = it_get_authors($display_admins, $order_by, $role, $hide_empty, $manual_exclude);	
		#loop through authors	
		if(empty($authors)) return false;						
		foreach($authors as $author) {
			$authorid = $author['ID'];			
			
			$out .= '<div class="author-panel clearfix">';	                
        
                $out .= '<div class="author-avatar-wrapper">';
            
                    $out .= '<div class="author-avatar">';
        
                        $out .= '<a href="' . get_author_posts_url($authorid) .'">' . get_avatar($authorid, $avatar_size) . '</a>';
                        
                    $out .= '</div>';
					
					$out .= '<h2 class="author-name"><a href="' . get_author_posts_url($authorid) . '" class="contributor-link">' . get_the_author_meta('display_name', $authorid) . '</a></h2>';
                    
                    $out .= it_author_profile_fields($authorid);
					
					$out .= '<div class="author-link">' . it_author_latest_article($authorid) . '</div>';
                    
                    $out .= '<div class="author-link"><a href="' . get_author_posts_url($authorid) . '">' . __('All articles from this author',IT_TEXTDOMAIN) . '<span class="theme-icon-right-fat"></span></a></div>';
                
                $out .= '</div>';
                
                $out .= '<div class="author-bio">';
                        
                    $out .= get_the_author_meta('description', $authorid);
                        
                $out .= '</div>';
				
			$out .= '</div>';
			
		} 
		
		return $out;
	}
}
if (!function_exists('it_get_content')) {
	#html display of the main page content
	function it_get_content($article_title) {	
		$out = '';
		
		$content = get_the_content();
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		
		if(empty($content) && empty($article_title)) return false;
			
		$out .= '<div class="the-content">';
                            
			do_action('it_before_single_content'); 
			
			if(!empty($article_title)) $out .= '<div class="section-title">' . $article_title . '</div>'; 

			$out .= '<div id="content-anchor"></div><div id="content-anchor-inner" class="clearfix">' . $content . '</div>';
	
			do_action('it_after_single_content');
					
		$out .= '</div>';
		
		return $out;
	}
}
if (!function_exists('it_get_reactions')) {	
	#html display of the reactions
	function it_get_reactions($postid) {
		$out = '';
		$buttons = '';
		$i = 0;
		#get all reactions from theme options
		$reactions = it_get_setting('reactions');
		$reactions_style = it_get_setting('reactions_style');
		$reactions_title = it_get_setting('reactions_title');		
		$reactions_style = !empty($reactions_style) ? $reactions_style : 'both';	
		$reactions_title = !empty($reactions_title) ? $reactions_title : __("What's your reaction?",IT_TEXTDOMAIN);
		if ( isset($reactions['keys']) && $reactions['keys'] != '#' ) {
			
			#get excluded reactions for this post
			$excluded_reactions = get_post_meta($postid, IT_META_REACTIONS, $single = true);
			if(unserialize($excluded_reactions)) $excluded_reactions = unserialize($excluded_reactions);
			$excluded_reactions = is_array($excluded_reactions) ? $excluded_reactions : array();
			
			#get total reactions for this post
			$total_reactions = get_post_meta($postid, IT_META_TOTAL_REACTIONS, $single = true);
			$total_reactions = !empty($total_reactions) ? $total_reactions : 0;
			
			$unlimitedreactions = it_get_setting('reaction_limit_disable') ? 1 : 0;
			
			$buttons .= '<div class="reactions-wrapper clearfix" data-postid="' . $postid . '" data-unlimitedreactions="' . $unlimitedreactions . '">';
				$buttons .= '<div class="reactions-inner">';
					$buttons .= '<div class="section-title">' . $reactions_title . '</div>';
					$reactions_keys = explode(',',$reactions['keys']);
					foreach ($reactions_keys as $rkey) {
						if ( $rkey != '#') {
							$reaction_name = ( !empty( $reactions[$rkey]['name'] ) ) ? $reactions[$rkey]['name'] : '#';	
							$reaction_slug = ( !empty( $reactions[$rkey]['slug'] ) ) ? $reactions[$rkey]['slug'] : it_get_slug($reaction_name, $reaction_name);	
							$reaction_icon = ( !empty( $reactions[$rkey]['icon'] ) ) ? $reactions[$rkey]['icon'] : '#';	
							$reaction_preset = ( !empty( $reactions[$rkey]['preset'] ) ) ? $reactions[$rkey]['preset'] : '#';
							
							#check to see if this reaction is excluded for this post
							if(!empty($reaction_slug) && !in_array($reaction_slug,$excluded_reactions)) {
								
								$i++;
								
								#get current reaction number
								$number = get_post_meta($postid, '_'.$reaction_slug, $single = true);
								#$number = get_post_meta($postid, $reaction_slug, $single = true);
								$number = !empty($number) ? $number : 0;
								
								#calculate percentage
								$percentage = $total_reactions != 0 ? round(($number / $total_reactions) * 100, 0) : 0;
								$percentage .= '%';
								
								#determine if this reaction was already clicked by this user
								$ip = it_get_ip();
								$ips = get_post_meta($postid, '_'.$reaction_slug.'_ips', $single = true);
								#$ips = get_post_meta($postid, $reaction_slug.'_ips', $single = true);
								$pos = strpos($ips,$ip);
								$clickcss = ' clickable';
								if($pos !== false && !it_get_setting('reaction_limit_disable')) {
									$clickcss = ' selected';
								}
								
								#preset image or custom icon
								if($reaction_icon=='#') {
									$icon = '<span class="theme-icon-' . $reaction_preset . '"></span>';
								} else {
									$icon = '<img src="' . $reaction_icon . '" />';
								}
								
								#generate css reaction size class
								$reactioncss = is_numeric(str_replace('%','',$percentage)) ? round(str_replace('%','',$percentage) / 10) : '';
								$reactioncss = ' size' . $reactioncss;								
								
								#html display of button
								$buttons .= '<div class="reaction add-active' . $clickcss. '" data-reaction="' . $reaction_slug . '">';
									$buttons .= '<span class="theme-icon-check"></span>';									
									if($reactions_style!='text') $buttons .= '<div class="reaction-icon">' . $icon . '</div>';
									if($reactions_style!='icon') $buttons .= '<div class="reaction-text">' . $reaction_name . '</div>';
									$buttons .= '<div class="reaction-percentage ' . $reaction_slug . $reactioncss . '">' . $percentage . '</div>';
								$buttons .= '</div>';	
								
							}
							
						}
					}
				$buttons .= '</div>';
			$buttons .= '</div>';
			
		}
		#at least one reaction exists and is not excluded for this post
		if($i > 0) $out = $buttons;
		return $out;
	}
}
if (!function_exists('it_get_post_info')) {	
	#html display of post info panel
	function it_get_post_info($postid) {
		$out = '';	
		$out .= '<div class="postinfo">';	
			$out .= '<div class="row">';
				$out .= '<div class="col-md-6 col-sm-6">' . it_get_categories($postid, true) . '</div>';
				$out .= '<div class="col-md-6 col-sm-6"><div class="post-tags"><span class="theme-icon-tag"></span>'.it_get_tags($postid).'</div></div>';	
			$out .= '</div>';
			if(!it_component_disabled('author', $postid)) {
				$out .= '<div class="bar-header full-width">';
					$out .= '<div class="bar-label-wrapper">';
						$out .= '<div class="bar-label light">';
							$out .= '<div class="label-text"><span class="theme-icon-username"></span>' . __('About the Author',IT_TEXTDOMAIN) . '</div>';
						$out .= '</div>';
					$out .= '</div>';					
					$out .= '<a class="info author-name" title="'.__('See all posts from this author',IT_TEXTDOMAIN).'" href="'.get_author_posts_url(get_the_author_meta('ID')).'">';
						$out .= get_the_author_meta('display_name');
					$out .= '</a>';					
				$out .= '</div>';
				$out .= '<div class="author-info clearfix">';
					$out .= it_get_author_avatar(70);			
					$out .= '<div class="author-bio">' . get_the_author_meta('description') . '</div>';
					$out .= it_author_profile_fields(get_the_author_meta('ID'));
				$out .= '</div>';	
			}
		$out .= '</div>';
			
		return $out;
	}
}
if (!function_exists('it_get_author_avatar')) {
	#html display of author avatar
	function it_get_author_avatar($size) {
		$out = '';
		$out .= '<div class="author-image thumbnail">';
			$out .= '<a class="info" title="'.__('See all posts from this author',IT_TEXTDOMAIN).'" href="'.get_author_posts_url(get_the_author_meta('ID')).'">';
				$out .= get_avatar(get_the_author_meta('user_email'), $size);
			$out .= '</a>';
		$out .= '</div>';
		
		return $out;		
	}
}
if (!function_exists('it_get_recommended')) {	
	#html display of related posts
	function it_get_recommended($postid) {
		$out = '';
		if(it_component_disabled('recommended', $postid)) return false;	
		#theme options variables
		$disable_filters = it_component_disabled('recommended_filters', $postid);
		$label = it_get_setting('post_recommended_label');	
		$numarticles = it_get_setting('post_recommended_num');	
		$numfilters = it_get_setting('post_recommended_filters_num');
		$method = it_get_setting('post_recommended_method');	
		$method = ( !empty($method) ) ? $method : 'tags';	
		#defaults
		$label = ( !empty($label) ) ? $label : __('Related',IT_TEXTDOMAIN);
		$numarticles = ( !empty($numarticles) ) ? $numarticles : 6;	
		$numfilters = ( !empty($numfilters) ) ? $numfilters : 3;	
		$loop = 'recommended';
		$location = 'widget_a';
		$container = '#recommended';
		$view = 'list';
		$columns = 1;
		$thumbnail = true;
		$rating = true;
		$icon = false;
		$meta = false;
		$award = false;
		$badge = false;
		$excerpt = true;
		$authorship = it_get_setting('loop_authorship_disable');
		$authorship = !$authorship;
		$first = false;
		$large_first = false;
		$layout = '';		
		#setup the query            
		$args=array('posts_per_page' => $numarticles, 'post__not_in' => array($postid));	
		#setup loop format
		$format = array('loop' => $loop, 'location' => $location, 'thumbnail' => $thumbnail, 'rating' => $rating, 'icon' => $icon, 'meta' => $meta, 'award' => $award, 'badge' => $badge, 'excerpt' => $excerpt, 'authorship' => $authorship, 'nonajax' => true, 'numarticles' => $numarticles, 'columns' => $columns, 'view' => $view, 'sort' => 'recent', 'first' => $first, 'size' => 'portholes', 'large_first' => $first);	
		$filters = '';
		$count = 0;
		$testargs = $args;
		#recommended methods
		switch($method) {
			case 'tags':
				$terms = wp_get_post_terms($postid, 'post_tag');				
				foreach($terms as $term) {				
					$testargs['tag_id'] = $term->term_id;
					if($count==0) $args['tag_id'] = $term->term_id;
					$itposts = new WP_Query( $testargs );
					if($itposts->have_posts()) {
						$count++;
						
						$filters .= '<a data-sorter="'.$term->term_id.'" data-method="tags" class="info';
						if($count==1) $filters .= ' active';
						$filters .= '" title="' . __('More articles tagged: ', IT_TEXTDOMAIN) . $term->name . '">'.$term->name.'<span class="bottom-arrow"></span></a>';
						
						if($count == $numfilters) break;	
					}
				}
			break;
			case 'categories':
				$terms = wp_get_post_terms($postid, 'category');	
				foreach($terms as $term) {				
					$testargs['cat'] = $term->term_id;
					if($count==0) $args['cat'] = $term->term_id;
					$itposts = new WP_Query( $testargs );
					if($itposts->have_posts()) {
						$count++;
						
						$filters .= '<a data-sorter="'.$term->term_id.'" data-method="categories" class="info';
						if($count==1) $filters .= ' active';
						$filters .= '" title="' . __('More articles filed under: ', IT_TEXTDOMAIN) . $term->name . '">'.$term->name.'<span class="bottom-arrow"></span></a>';				
						
						if($count == $numfilters) break;
					}
				}
			break;
			case 'tags_categories':
				#tag			
				$terms = wp_get_post_terms($postid, 'post_tag');			
				foreach($terms as $term) {				
					$testargs['tag_id'] = $term->term_id;
					if($count==0) $args['tag_id'] = $term->term_id;	
					$itposts = new WP_Query( $testargs );
					$half = round($numfilters/2, 0);
					if($itposts->have_posts()) {	
						$count++;
						
						$filters .= '<a data-sorter="'.$term->term_id.'" data-method="tags" class="info';
						if($count==1) $filters .= ' active';
						$filters .= '" title="' . __('More articles tagged: ', IT_TEXTDOMAIN) . $term->name . '">'.$term->name.'<span class="bottom-arrow"></span></a>';
							
						if($count == $half) break;
					}
				}
				
				#category
				$testargs = $args;
				$terms = wp_get_post_terms($postid, 'category');			
				foreach($terms as $term) {				
					$testargs['cat'] = $term->term_id;
					if($count==0) $args['cat'] = $term->term_id;				
					$itposts = new WP_Query( $testargs );
					if($itposts->have_posts()) {	
						$count++;
					
						$filters .= '<a data-sorter="'.$term->term_id.'" data-method="categories" class="info';
						if($count==1) $filters .= ' active';
						$filters .= '" title="' . __('More articles filed under: ', IT_TEXTDOMAIN) . $term->name . '">'.$term->name.'<span class="bottom-arrow"></span></a>';
							
						if($count == $numfilters) break;					
					}
				}
			break;
		}	
		if($count>0) {
			$out .= '<div id="recommended">';
				$out .= '<div class="bar-header sortbar full-width clearfix">';
					$out .= '<div class="bar-header-inner">';
						$out .= '<div class="bar-label-wrapper no-filters">';
							$out .= '<div class="bar-label light">';
								$out .= '<div class="label-text"><span class="theme-icon-thumbs-up"></span>' . $label . '</div>';
							$out .= '</div>';
						$out .= '</div>';
						$out .= '<div class="sort-buttons" data-postid="'.$postid.'" data-loop="' . $loop . '" data-location="' . $location . '" data-view="' . $view . '" data-numarticles="' . $numarticles . '" data-columns="' . $columns . '" data-paginated="1" data-thumbnail="'.$thumbnail.'" data-rating="'.$rating.'" data-meta="'.$meta.'" data-layout="'.$layout.'" data-icon="'.$icon.'" data-badge="'.$badge.'" data-award="'.$award.'" data-authorship="'.$authorship.'" data-excerpt="'.$excerpt.'" data-largefirst="'.$large_first.'">';
							if(!$disable_filters) $out .= $filters;
						$out .= '</div>';
					$out .= '</div>';
				$out .= '</div>';			
								
				$out .= '<div class="loading"><span class="theme-icon-spin2"></span></div>';	
				
				$out .= '<div class="articles gradient post-blog compact widget_a clearfix">';
					$out .= '<div class="content-inner">';				
						$out .= '<div class="loop list">';	
						
							#display the loop
							$loop = it_loop($args, $format); 
							$out .= $loop['content'];
						
						$out .= '</div>';
					$out .= '</div>';
				$out .= '</div>';
			$out .= '</div>';
		}
		wp_reset_query();
		return $out;
	}
}
if (!function_exists('it_login_form')) {	
	#html display of login form 
	function it_login_form() {
		$out = '';
		$homeurl = force_ssl_login() ? str_replace('http://','https://',home_url()) : home_url();
		$out .= '<form method="post" action="' . $homeurl . '/wp-login.php" class="sticky-login-form">';
			$out .= '<div id="sticky-login-submit" class="sticky-submit login">';
				$out .= '<span class="theme-icon-check"></span>';
				$out .= __('LOGIN',IT_TEXTDOMAIN);
			$out .= '</div>';  
			$out .= '<div class="input-group">';
				$out .= '<span class="input-group-addon theme-icon-username"></span>';
				$out .= '<input type="text" name="log" value="' . esc_attr(stripslashes($user_login)) . '" id="user_login" tabindex="11" placeholder="username" />';
			$out .= '</div>';
			$out .= '<div class="input-group">';
				$out .= '<span class="input-group-addon theme-icon-password"></span>';
				$out .= '<input type="password" name="pwd" value="" id="user_pass" tabindex="12" placeholder="password" />';
			$out .= '</div>'; 		                           
			$out .= '<input type="hidden" name="redirect_to" value="' . $_SERVER['REQUEST_URI'] . '" />';
			$out .= '<input type="hidden" name="user-cookie" value="1" /> '; 		               
		$out .= '</form>';
		
		return $out;
	}
}
if (!function_exists('it_register_form')) {	
	#html display of register form 
	function it_register_form() {
		$out = '';
		$homeurl = force_ssl_login() ? str_replace('http://','https://',site_url('wp-login.php?action=register', 'login_post')) : site_url('wp-login.php?action=register', 'login_post');
		$out .= '<form method="post" action="' . $homeurl . '" class="sticky-register-form">';
			$out .= '<div id="sticky-register-submit" class="sticky-submit register">';
				$out .= '<span class="theme-icon-check"></span>';
				$out .= __('REGISTER',IT_TEXTDOMAIN);
			$out .= '</div>';  
			$out .= '<div class="input-group">';
				$out .= '<span class="input-group-addon theme-icon-username"></span>';
				$out .= '<input type="text" name="user_login" value="' . esc_attr(stripslashes($user_login)) . '" id="user_register" tabindex="11" placeholder="username" />';
			$out .= '</div>';
			$out .= '<div class="input-group">';
				$out .= '<span class="input-group-addon at-symbol">@</span>';
				$out .= '<input type="text" name="user_email" value="' . esc_attr(stripslashes($user_email)) . '" id="user_email" tabindex="12" placeholder="email" />';
			$out .= '</div>'; 		                           
			$out .= '<input type="hidden" name="redirect_to" value="' . $_SERVER['REQUEST_URI'] . '?register=true" />';
			$out .= '<input type="hidden" name="user-cookie" value="1" /> '; 		               
		$out .= '</form>';
		
		return $out;
	}
}
if (!function_exists('it_email_form')) {
	#html display of email form 
	function it_email_form() {
		$out = '';
		
		$email_label = it_get_setting("email_label");
		if(empty($email_label)) $email_label = __('ENTER YOUR E-MAIL',IT_TEXTDOMAIN); 
		
		$onsubmit = "window.open('http://feedburner.google.com/fb/a/mailverify?uri=" . it_get_setting("feedburner_name") . "', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true";
		
		$out .= '<div class="connect-email info" title="' . __('Hit enter when done',IT_TEXTDOMAIN) . '">';
		
			$out .= '<form id="feedburner_subscribe" class="subscribe" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="' . $onsubmit . '">';
				
				$out .= '<input type="text" class="email-textbox" name="email" placeholder="' . $email_label . '">';
				
				$out .= '<span class="theme-icon-email"></span>';
				
				$out .= '<input type="hidden" value="' . it_get_setting('feedburner_name') . '" name="uri"/>';
				$out .= '<input type="hidden" name="loc" value="en_US"/>';
			
			$out .= '</form>';
		
		$out .= '</div>';
		
		return $out;
	}
}
if (!function_exists('it_social_badges')) {
	#html display of social badges
	function it_social_badges($pos = 'top') {
		$out = '<div class="social-badges">';
		$social = it_get_setting( 'sociable' );
		if( $social['keys'] != '#' ) {
			$social_keys = explode( ',', $social['keys'] );
	
			foreach ( $social_keys as $key ) {
				if( $key != '#' ) {
	
					$social_link = ( !empty( $social[$key]['link'] ) ) ? $social[$key]['link'] : '#top';
					$social_icon = ( !empty( $social[$key]['icon'] ) ) ? $social[$key]['icon'] : 'none';
					$social_custom = ( !empty( $social[$key]['custom'] ) ) ? $social[$key]['custom'] : '#';
					$social_hover = ( !empty( $social[$key]['hover'] ) ) ? $social[$key]['hover'] : ucwords($social_icon);					
					
					if( !empty( $social[$key]['custom'] ) )
						$out .= '<a href="'.esc_url( $social_link ).'" class="styled info-' . $pos . '" title="'.$social_hover.'" rel="nofollow" target="_blank"><img src="' . esc_url( $social_custom ) . '" alt="link" /></a>';
	
					elseif( empty( $social[$key]['custom'] ) )
						$out .= '<a href="'.esc_url( $social_link ).'" class="styled theme-icon-'.$social_icon.' info-' . $pos . '" title="'.$social_hover.'" rel="nofollow" target="_blank"></a>';
					  
				}
			}
		}	
		$out .= '</div>';
		return $out;
	}
}
if (!function_exists('it_comment')) {	
	function it_comment($comment, $args, $depth) {
		global $post;	
		$GLOBALS['comment'] = $comment; ?>		
		
		<li id="li-comment-<?php comment_ID(); ?>">
			<div class="comment clearfix" id="comment-<?php comment_ID(); ?>">
				<div class="comment-avatar-wrapper">
					<div class="comment-avatar">
						<?php echo get_avatar($comment, 50); ?>
					</div>
				</div>
				<div class="comment-content clearfix">
				
					<div class="comment-author"><?php printf(__('%s',IT_TEXTDOMAIN), get_comment_author_link()) ?></div>
					
					<a class="comment-meta" href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s',IT_TEXTDOMAIN), get_comment_date(),  get_comment_time()) ?></a>
					<?php $editlink = get_edit_comment_link();
					if(!empty($editlink)) { ?>
						<a class="edit-link" href="<?php echo $editlink; ?>"><span class="theme-icon-pencil"></span></a>
					<?php } ?>
					
					<br class="clearer" />
					
					<?php if ($comment->comment_approved == '0') : ?>
					
						<div class="comment-moderation">
							<?php _e('Your comment is awaiting moderation.',IT_TEXTDOMAIN) ?>                               
						</div>
						
					<?php endif; ?>  
					
					<?php echo it_get_comment_rating($post->ID, $comment->comment_ID); ?>
					
					<?php if(strpos(get_comment_text(),'it_hide_this_comment')===false) { ?>
					
						<div class="comment-text">
						
							<?php comment_text() ?>
							
						</div>    
						
					<?php } ?>            
						
					<div class="info reply-wrapper" title="<?php _e('Reply to this comment',IT_TEXTDOMAIN); ?>"><?php echo get_comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => '<span class="theme-icon-forward"></span>'))); ?></div>                 
					
				</div>
                
			</div>
		
	<?php } 
}
if (!function_exists('it_before_comment_fields')) {	
	#add container to comment form fields
	function it_before_comment_fields() {
		$out = '';
		$width = '';
		global $post;
		$post_type = get_post_meta( $post->ID, IT_META_POST_TYPE, $single = true );
		$disable_review = get_post_meta( $post->ID, IT_META_DISABLE_REVIEW, $single = true );
		if(it_get_setting('review_user_rating_disable') || $post_type=='article' || $disable_review=='true') $width=' full';
		$out .= '<div class="comment-fields-container'.$width.'">';
		$out .= '<div class="comment-fields-inner">';
		echo $out;	
	}
}
if (!function_exists('it_after_comment_fields')) {
	function it_after_comment_fields() {
		$out = '';
		$out .= '</div>';
		$out .= '</div>';	
		global $post;	
		$metric = it_get_setting('review_rating_metric');
		$metric_meta = get_post_meta($post->ID, IT_META_METRIC, $single = true);
		if(!empty($metric_meta) && $metric_meta!='') $metric = $metric_meta;
		$cssmetric = ' ' . $metric . '-wrapper';	
		$post_type = get_post_meta( $post->ID, IT_META_POST_TYPE, $single = true );
		$disable_review = get_post_meta( $post->ID, IT_META_DISABLE_REVIEW, $single = true );
		if(!it_get_setting('review_user_rating_disable') && $post_type!='article' && $disable_review!='true') {
			if(!it_get_setting('review_user_comment_rating_disable')) {
				$out .= '<div class="comment-ratings-container clearfix">';
				$out .= '<div class="comment-ratings-inner ratings'.$cssmetric.'">';
					$out .= it_get_comment_criteria($post->ID);					
				$out .= '</div>';
				$out .= '</div>';
			}			
		}
		echo $out;	
	}
}
if (!function_exists('it_author_profile_fields')) {
	#html display of author's profile fields
	function it_author_profile_fields($authorid) {
		$out='<div class="author-profile-fields">';
		if(get_the_author_meta('twitter', $authorid))
			$out.='<a class="theme-icon-twitter info" title="'. __( 'Find me on Twitter', IT_TEXTDOMAIN ) .'" href="http://twitter.com/'. get_the_author_meta('twitter', $authorid) .'" target="_blank" rel="nofollow"></a>';
		if(get_the_author_meta('facebook', $authorid))
			$out.='<a class="theme-icon-facebook info" title="'. __( 'Find me on Facebook', IT_TEXTDOMAIN ) .'" href="http://www.facebook.com/'. get_the_author_meta('facebook', $authorid) .'" target="_blank" rel="nofollow"></a>';
		if(get_the_author_meta('googleplus', $authorid))
			$out.='<a class="theme-icon-googleplus info" title="'. __( 'Find me on Google+', IT_TEXTDOMAIN ) .'" href="'. get_the_author_meta('googleplus', $authorid) .'" target="_blank" rel="nofollow"></a>';
		if(get_the_author_meta('linkedin', $authorid))
			$out.='<a class="theme-icon-linkedin info" title="'. __( 'Find me on LinkedIn', IT_TEXTDOMAIN ) .'" href="http://www.linkedin.com/in/'. get_the_author_meta('linkedin', $authorid) .'" target="_blank" rel="nofollow"></a>';
		if(get_the_author_meta('pinterest', $authorid))
			$out.='<a class="theme-icon-pinterest info" title="'. __( 'Find me on Pinterest', IT_TEXTDOMAIN ) .'" href="http://www.pinterest.com/'. get_the_author_meta('pinterest', $authorid) .'" target="_blank" rel="nofollow"></a>';
		if(get_the_author_meta('flickr', $authorid))
			$out.='<a class="theme-icon-flickr info" title="'. __( 'Find me on Flickr', IT_TEXTDOMAIN ) .'" href="http://www.flickr.com/photos/'. get_the_author_meta('flickr', $authorid) .'" target="_blank" rel="nofollow"></a>';
		if(get_the_author_meta('youtube', $authorid))
			$out.='<a class="theme-icon-youtube info" title="'. __( 'Find me on YouTube', IT_TEXTDOMAIN ) .'" href="http://www.youtube.com/user/'. get_the_author_meta('youtube', $authorid) .'" target="_blank" rel="nofollow"></a>';
		if(get_the_author_meta('instagram', $authorid))
			$out.='<a class="theme-icon-instagram info" title="'. __( 'Find me on Instagram', IT_TEXTDOMAIN ) .'" href="http://instagram.com/'. get_the_author_meta('instagram', $authorid) .'" target="_blank" rel="nofollow"></a>';
		if(get_the_author_meta('vimeo', $authorid))
			$out.='<a class="theme-icon-vimeo info" title="'. __( 'Find me on Vimeo', IT_TEXTDOMAIN ) .'" href="http://www.vimeo.com/'. get_the_author_meta('vimeo', $authorid) .'" target="_blank" rel="nofollow"></a>';	
		if(get_the_author_meta('stumbleupon', $authorid))
			$out.='<a class="theme-icon-stumbleupon info" title="'. __( 'Find me on StumbleUpon', IT_TEXTDOMAIN ) .'" href="http://www.stumbleupon.com/stumbler/'. get_the_author_meta('stumbleupon', $authorid) .'" target="_blank" rel="nofollow"></a>';
		if(get_the_author_meta('user_email', $authorid) && !it_get_setting('email_link_disable'))
			$out.='<a class="theme-icon-email info" title="'. __( 'E-mail Me', IT_TEXTDOMAIN ) .'" href="mailto:'. get_the_author_meta('user_email', $authorid) .'" rel="nofollow"></a>';
		if(get_the_author_meta('user_url', $authorid))
			$out.='<a class="theme-icon-globe info" title="'. __( 'My Website', IT_TEXTDOMAIN ) .'" href="'. get_the_author_meta('user_url', $authorid) .'" target="_blank" rel="nofollow"></a>';	
		$out.='</div>';
		return $out;	
	}
}
if (!function_exists('it_footer_layout')) {
	#get footer layout
	function it_footer_layout($l){
		$col1 = '';
		$col2 = '';
		$col3 = '';
		$col4 = '';
		$col5 = '';
		$col6 = '';
		switch($l) {
			case 'a':
				$col1=12;
			break;
			case 'b':
				$col1=6;
				$col2=6;
			break;
			case 'c':
				$col1=4;
				$col2=4;
				$col3=4;
			break;	
			case 'd':
				$col1=3;
				$col2=3;
				$col3=3;
				$col4=3;
			break;
			case 'e':
				$col1=2;
				$col2=2;
				$col3=2;
				$col4=2;
				$col5=2;
				$col6=2;
			break;
			case 'f':
				$col1=10;
				$col2=2;
			break;
			case 'g':
				$col1=9;
				$col2=3;
			break;
			case 'h':
				$col1=8;
				$col2=4;
			break;
			case 'i':
				$col1=6;
				$col2=3;
				$col3=3;
			break;
			case 'j':
				$col1=2;
				$col2=10;
			break;
			case 'k':
				$col1=3;
				$col2=9;
			break;
			case 'l':
				$col1=4;
				$col2=8;
			break;
			case 'm':
				$col1=3;
				$col2=3;
				$col3=6;
			break;
			case 'n':
				$col1=4;
				$col2=2;
				$col3=2;
				$col4=2;
				$col5=2;
			break;
			case 'o':
				$col1=4;
				$col2=4;
				$col3=2;
				$col4=2;
			break;
			case 'p':
				$col1=3;
				$col2=3;
				$col3=2;
				$col4=2;
				$col5=2;
			break;
			case 'q':
				$col1=2;
				$col2=2;
				$col3=2;
				$col4=2;
				$col5=4;
			break;
			case 'r':
				$col1=2;
				$col2=2;
				$col3=4;
				$col4=4;
			break;
			case 's':
				$col1=2;
				$col2=2;
				$col3=2;
				$col4=3;
				$col5=3;
			break;
			case 't':
				$col1=4;
				$col2=3;
				$col3=3;
				$col4=2;
			break;
			case 'u':
				$col1=4;
				$col2=2;
				$col3=3;
				$col4=3;
			break;
			case 'v':
				$col1=4;
				$col2=3;
				$col3=2;
				$col4=3;
			break;
			case 'w':
				$col1=2;
				$col2=3;
				$col3=3;
				$col4=4;
			break;
			case 'x':
				$col1=3;
				$col2=3;
				$col3=2;
				$col4=4;
			break;
			case 'y':
				$col1=3;
				$col2=2;
				$col3=3;
				$col4=4;
			break;
			case 'z':
				$col1=4;
				$col2=2;
				$col3=4;
				$col4=2;
			break;
			case 'aa':
				$col1=4;
				$col2=2;
				$col3=2;
				$col4=4;
			break;
			case 'ab':
				$col1=2;
				$col2=4;
				$col3=2;
				$col4=4;
			break;
			case 'ac':
				$col1=3;
				$col2=2;
				$col3=3;
				$col4=2;
				$col5=2;
			break;
			case 'ad':
				$col1=3;
				$col2=2;
				$col3=2;
				$col4=2;
				$col5=3;
			break;
		}
		$layout = array('col1' => $col1, 'col2' => $col2, 'col3' => $col3, 'col4' => $col4, 'col5' => $col5, 'col6' => $col6);
		return $layout;
	}
}
if (!function_exists('it_widgets_layout')) {
	#get footer layout
	function it_widgets_layout($l){
		$col1 = '';
		$col2 = '';
		$col3 = '';
		switch($l) {			
			case 'a':
				$col1=6;
				$col2=6;
			break;
			case 'b':
				$col1=4;
				$col2=4;
				$col3=4;
			break;	
			case 'c':
				$col1=6;
				$col2=3;
				$col3=3;
			break;
			case 'd':
				$col1=3;
				$col2=6;
				$col3=3;
			break;	
			case 'e':
				$col1=3;
				$col2=3;
				$col3=6;
			break;		
		}
		$layout = array('col1' => $col1, 'col2' => $col2, 'col3' => $col3);
		return $layout;
	}
}
if (!function_exists('it_wrapper_start')) {
	#woocommerce actions
	function it_wrapper_start() { 	
		$sidebar_position = it_get_setting('woo_layout');
		$sidebar = __('Page Sidebar',IT_TEXTDOMAIN);
		if(it_get_setting('woo_sidebar_unique')) $sidebar = __('WooCommerce Sidebar',IT_TEXTDOMAIN);
		$args = array('delimiter' => ' <span class="theme-icon-right-fat"></span> ');
		$builders = it_get_setting('woo_above_builder');
		if(!empty($builders) && count($builders) > 2) {
			foreach($builders as $builder) {
				it_shortcode($builder);			
			}
		} 
		?>
		
		<div class="container">
		
			<div id="page-content" class="woo-page">
			
				<div class="row">
							
					<?php if($sidebar_position=='sidebar-left') { ?>
        
                        <div class="col-md-4">
                    
                            <?php echo it_widget_panel($sidebar, $sidebar_position); ?>
                            
                        </div>
                                    
                    <?php } ?>
                    
                    <div id="main-content" class="col-md-8">
                        
						<?php if(function_exists('woocommerce_breadcrumb') && !it_get_setting('woo_breadcrumb_disable')) { ?>
                        
                            <div class="bar-header clearfix full-width woo-breadcrumb">
                            
                                <div class="bar-label-wrapper">
                            
                                    <div class="bar-label light">
                                    
                                        <div class="label-text">
                                        
                                            <?php _e('NAV',IT_TEXTDOMAIN); ?>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                
                                <div class="bar-controls">
                            
                                    <?php woocommerce_breadcrumb($args); ?>
                                    
                                </div>
                               
                            </div>
                            
                        <?php } ?>							
						
	<?php }
}
if (!function_exists('it_wrapper_end')) {
	function it_wrapper_end() {	
		$sidebar_position = it_get_setting('woo_layout');
		$sidebar = __('Page Sidebar',IT_TEXTDOMAIN);
		if(it_get_setting('woo_sidebar_unique')) $sidebar = __('WooCommerce Sidebar',IT_TEXTDOMAIN);			
		?>							
								
                        <div class="pagination-wrapper">
                        
                            <?php if(function_exists('woocommerce_pagination')) woocommerce_pagination(); ?>
                            
                        </div> 
                        
                    </div>         
                     
                    <?php if($sidebar_position=='sidebar-right') { ?>
        
                        <div class="col-md-4">
                    
                            <?php echo it_widget_panel($sidebar, $sidebar_position); ?>
                            
                        </div>
                                    
                    <?php } ?>
				
				</div>
				
			</div>
			
		</div>
		
		<?php 
		$builders = it_get_setting('woo_below_builder');
		if(!empty($builders) && count($builders) > 2) {
			foreach($builders as $builder) {
				it_shortcode($builder);			
			}
		} 
	}
}
#get shortcode syntax based on builder panel
if (!function_exists('it_shortcode')) {
	function it_shortcode($builder) {		
		$shortcode = '';
		if(is_array($builder)) {
			extract($builder);
			if(!empty($id)) {
				if($id=='page-content' || $id=='directory') {
					
					#shortcodes not used for some builder panels					
					it_get_template_part($id);	
										
				} else {
					
					#one common place to disable filters for theme options page builders
					$disabled_filters = it_get_setting('loop_filter_disable');
					
					#build the shortcode
					$shortcode .= '[' . $id;
					$shortcode .= !empty($included_categories) ? ' included_categories="' . implode(',',$included_categories) . '"' : '';
					$shortcode .= !empty($included_tags) ? ' included_tags="' . implode(',',$included_tags) . '"' : '';
					$shortcode .= !empty($excluded_categories) ? ' excluded_categories="' . implode(',',$excluded_categories) . '"' : '';
					$shortcode .= !empty($excluded_tags) ? ' excluded_tags="' . implode(',',$excluded_tags) . '"' : '';
					$shortcode .= !empty($loading) ? ' loading="' . $loading . '"' : '';
					$shortcode .= !empty($title) ? ' title="' . stripslashes($title) . '"' : '';
					$shortcode .= !empty($subtitle) ? ' subtitle="' . stripslashes($subtitle) . '"' : '';
					$shortcode .= !empty($icon) ? ' icon="' . $icon . '"' : '';
					$shortcode .= !empty($disabled_filters) ? ' disabled_filters="' . implode(',',$disabled_filters) . '"' : '';
					$shortcode .= !empty($rows) ? ' rows="' . $rows . '"' : '';
					$shortcode .= !empty($rows) ? ' postsperpage="' . $rows . '"' : '';
					$shortcode .= !empty($start) ? ' start="' . $start . '"' : '';
					$shortcode .= !empty($increment) ? ' increment="' . $increment . '"' : '';
					$shortcode .= !empty($disable_ads) ? ' disable_ads="' . $disable_ads . '"' : '';
					$shortcode .= !empty($disable_excerpt) ? ' disable_excerpt="' . $disable_excerpt . '"' : '';
					$shortcode .= !empty($disable_authorship) ? ' disable_authorship="' . $disable_authorship . '"' : '';
					$shortcode .= !empty($targeted) ? ' targeted="' . $targeted . '"' : '';
					$shortcode .= !empty($timeperiod) ? ' timeperiod="' . $timeperiod . '"' : '';
					$shortcode .= ']';
					$shortcode .= !empty($html) ? $html . '[/' . $id . ']' : '';
					
					#execute the shortcode
					if(!empty($shortcode)) echo do_shortcode($shortcode);	
									
				}
			}
		}	
	}
}
?>