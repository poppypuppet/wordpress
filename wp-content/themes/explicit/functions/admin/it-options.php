<?php
$option_tabs = array(
	'it_generalsettings_tab' => array(__( 'General Settings', IT_TEXTDOMAIN ), 'tools'),
	'it_menus_tab' => array(__( 'Menus', IT_TEXTDOMAIN ), 'list'),
	'it_style_tab' => array(__( 'Style', IT_TEXTDOMAIN ), 'style'),
	'it_pages_tab' => array(__( 'Page Builders', IT_TEXTDOMAIN ), 'builder'),
	'it_loop_tab' => array(__( 'Post Loops', IT_TEXTDOMAIN ), 'pin'),		
	'it_posts_tab' => array(__( 'Template Setup', IT_TEXTDOMAIN ), 'settings'),
	'it_reviews_tab' => array(__( 'Reviews', IT_TEXTDOMAIN ), 'star'),
	'it_categories_tab' => array(__( 'Categories', IT_TEXTDOMAIN ), 'folder-open'),
	'it_awards_tab' => array(__( 'Awards and Badges', IT_TEXTDOMAIN ), 'awarded'),
	'it_reactions_tab' => array(__( 'Reactions', IT_TEXTDOMAIN ), 'emo-happy'),
	'it_sidebar_tab' => array(__( 'Custom Sidebars', IT_TEXTDOMAIN ), 'sidebar'),
	'it_signoff_tab' => array(__( 'Signoffs', IT_TEXTDOMAIN ), 'signoff'),
	'it_advertising_tab' => array(__( 'Advertising', IT_TEXTDOMAIN ), 'dollar'),
	'it_footer_tab' => array(__( 'Footer', IT_TEXTDOMAIN ), 'footer'),
	'it_sociable_tab' => array(__( 'Social', IT_TEXTDOMAIN ), 'twitter'),
	'it_advanced_tab' => array(__( 'Advanced', IT_TEXTDOMAIN ), 'cog-alt')
);

#add woocommerce tab
if(function_exists('is_woocommerce')) {
	$option_tabs['it_woocommerce_tab'] = array(__( 'WooCommerce', IT_TEXTDOMAIN), 'tag' );
}

#add buddypress tab
if(function_exists('bp_current_component') || function_exists('is_bbpress')) {
	$option_tabs['it_buddypress_tab'] = array(__( 'BuddyPress/bbPress', IT_TEXTDOMAIN), 'users' );
}

$options = array(
	
	/**
	 * Navigation
	 */
	array(
		'name' => $option_tabs,
		'type' => 'navigation'
	),
	
	/**
	 * General Settings
	 */
	array(
		'name' => array( 'it_generalsettings_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Logos & Branding', IT_TEXTDOMAIN ),
			'desc' => __( 'General settings for logos and branding of your site.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		
		array(
			'name' => __( 'Logo Settings', IT_TEXTDOMAIN ),
			'desc' => __( 'You can choose whether you wish to display a custom logo or your site title.', IT_TEXTDOMAIN ),
			'id' => 'display_logo',
			'options' => array(
				'true' => __( 'Custom Image Logo', IT_TEXTDOMAIN ),
				'' => __( 'Display Site Title', IT_TEXTDOMAIN )
			),
			'type' => 'radio'
		),
		array(
			'name' => __( 'Hide Tagline', IT_TEXTDOMAIN ),
			'desc' => __( 'This disables the tagline (site description) from displaying without requiring you to actually delete the Tagline from Settings >> General (good for SEO purposes). The tagline only actually displays if you have the logo bar set to display.', IT_TEXTDOMAIN ),
			'id' => 'description_disable',
			'options' => array( 'true' => __( 'Hide the site Tagline from the logo bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Custom Logo', IT_TEXTDOMAIN ),
			'desc' => __( 'Upload an image to use as your logo. If you are displaying your logo in the sticky bar, max height is 60px.', IT_TEXTDOMAIN ),
			'id' => 'logo_url',
			'type' => 'upload'
		),
		array(
			'name' => __( 'Logo Width (optional)', IT_TEXTDOMAIN ),
			'desc' => __( 'This adds a width attribute to your logo image tag for page performance purposes. Do not include the "px" part, just the number itself.', IT_TEXTDOMAIN ),
			'id' => 'logo_width',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),		
		array(
			'name' => __( 'Logo Height (optional)', IT_TEXTDOMAIN ),
			'desc' => __( 'This adds a height attribute to your logo image tag for page performance purposes. Do not include the "px" part, just the number itself.', IT_TEXTDOMAIN ),
			'id' => 'logo_height',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Custom HD Logo', IT_TEXTDOMAIN ),
			'desc' => __( 'Upload an image to use as your logo for retina displays. If you are displaying your logo in the sticky bar, max height is 120px.', IT_TEXTDOMAIN ),
			'id' => 'logo_url_hd',
			'type' => 'upload'
		),
		array(
			'name' => __( 'Login Logo', IT_TEXTDOMAIN ),
			'desc' => __( 'Upload an image to use as your logo for login page.', IT_TEXTDOMAIN ),
			'id' => 'login_logo_url',
			'type' => 'upload'
		),
		array(
			'name' => __( 'Custom Favicon', IT_TEXTDOMAIN ),
			'desc' => __( 'Upload an image to use as your favicon.', IT_TEXTDOMAIN ),
			'id' => 'favicon_url',
			'type' => 'upload'
		), 
		
		array(
			'name' => __( 'Sticky Bar & Header', IT_TEXTDOMAIN ),
			'desc' => __( 'The fixed bar that displays menus and controls at the top of the site.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Disable Header', IT_TEXTDOMAIN ),
			'desc' => __( 'Disable the area that shows the larger logo, header ad, and social badges', IT_TEXTDOMAIN ),
			'id' => 'logobar_disable_global',
			'options' => array( 'true' => __( 'Hide the entire header area.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Header Logo', IT_TEXTDOMAIN ),
			'desc' => __( 'This is useful if you want to display the logo in the sticky bar and also display the header without displaying the logo twice', IT_TEXTDOMAIN ),
			'id' => 'logo_disable_global',
			'options' => array( 'true' => __( 'Hide the logo only from the header.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Social Badges', IT_TEXTDOMAIN ),
			'id' => 'header_social_disable',
			'options' => array( 'true' => __( 'Disable the social badges that display on the right of the header.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Sticky Bar', IT_TEXTDOMAIN ),
			'id' => 'sticky_disable_global',
			'options' => array( 'true' => __( 'Hide the entire sticky bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Sticky Logo', IT_TEXTDOMAIN ),
			'id' => 'sticky_logo_disable_global',
			'options' => array( 'true' => __( 'Do not display the logo in the sticky bar.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Sticky Logo', IT_TEXTDOMAIN ),
			'desc' => __( 'Upload an image to use as the logo in your sticky bar. If you leave this blank it will use the main logo.', IT_TEXTDOMAIN ),
			'id' => 'sticky_logo_url',
			'type' => 'upload'
		),
		array(
			'name' => __( 'HD Sticky Logo', IT_TEXTDOMAIN ),
			'desc' => __( 'Upload an image to use as the logo in your sticky bar for retina displays. If you leave this blank it will use the main HD logo.', IT_TEXTDOMAIN ),
			'id' => 'sticky_logo_url_hd',
			'type' => 'upload'
		),
		array(
			'name' => __( 'Logo Width (optional)', IT_TEXTDOMAIN ),
			'desc' => __( 'This adds a width attribute to your logo image tag for page performance purposes. Do not include the "px" part, just the number itself.', IT_TEXTDOMAIN ),
			'id' => 'sticky_logo_width',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),		
		array(
			'name' => __( 'Logo Height (optional)', IT_TEXTDOMAIN ),
			'desc' => __( 'This adds a height attribute to your logo image tag for page performance purposes. Do not include the "px" part, just the number itself.', IT_TEXTDOMAIN ),
			'id' => 'sticky_logo_height',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),	
		array(
			'name' => __( 'Disable New Articles', IT_TEXTDOMAIN ),
			'id' => 'new_articles_disable',
			'options' => array( 'true' => __( 'Disable the new articles panel from displaying on the front page.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'New Articles Prefix', IT_TEXTDOMAIN ),
			'desc' => __( 'The prefix to display before the time period in the tooltip. Leave blank to only display the time period.', IT_TEXTDOMAIN ),
			'id' => 'new_prefix',
			'htmlentities' => true,
			'type' => 'text'
		),	
		array(
			'name' => __( 'New Articles Label Override', IT_TEXTDOMAIN ),
			'desc' => __( 'Roll your own label instead of letting the system generate one - displays in the hover tooltip.', IT_TEXTDOMAIN ),
			'id' => 'new_label_override',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'New Articles Time Period', IT_TEXTDOMAIN ),
			'desc' => __( 'Show count and posts for only this time period.', IT_TEXTDOMAIN ),
			'id' => 'new_timeperiod',
			'target' => 'new_timeperiod',
			'nodisable' => true,
			'type' => 'select'
		),
		array(
			'name' => __( 'Max Number of Posts', IT_TEXTDOMAIN ),
			'desc' => __( 'Limits the total number of new articles displayed.', IT_TEXTDOMAIN ),
			'id' => 'new_number',
			'target' => 'new_number',
			'nodisable' => true,
			'type' => 'select'
		),
		array(
			'name' => __( 'Disable Random Article', IT_TEXTDOMAIN ),
			'id' => 'random_disable',
			'options' => array( 'true' => __( 'Disable the random article button next to the main menu', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Search', IT_TEXTDOMAIN ),
			'id' => 'search_disable',
			'options' => array( 'true' => __( 'Disable the search box in the sticky bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Login/Register', IT_TEXTDOMAIN ),
			'id' => 'sticky_controls_disable',
			'options' => array( 'true' => __( 'Disable the login/logout and register/account links in the sticky bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Use WP Login Screen', IT_TEXTDOMAIN ),
			'id' => 'sticky_force_wp_login',
			'options' => array( 'true' => __( 'Clicking the login button should take the user to the standard WordPress login page', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'More Settings', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings pertain to elements that are available/visible across your entire site.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),			
		array(
			'name' => __( 'Disable Comments Globally', IT_TEXTDOMAIN ),
			'desc' => __( 'This globally disables comments from displaying, even if you have it turned on in other areas of the theme.', IT_TEXTDOMAIN ),
			'id' => 'comments_disable_global',
			'options' => array( 'true' => __( 'Completely disable the comments for the entire site', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Disable User E-mail Links', IT_TEXTDOMAIN ),
			'desc' => __( 'The author info at the bottom of posts as well as the author archive listing pages list social profile links for the user, including a link showing email address of the user. Use this setting to disable the user email addresses from displaying in this list of links.', IT_TEXTDOMAIN ),
			'id' => 'email_link_disable',
			'options' => array( 'true' => __( "Disable users' email address link from list of social links", IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Google Analytics Code', IT_TEXTDOMAIN ),
			'desc' =>  __( 'After signing up with Google Analytics paste the code that it gives you here.', IT_TEXTDOMAIN ),
			'id' => 'analytics_code',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Custom CSS', IT_TEXTDOMAIN ),
			'desc' => __( 'This is a great place for doing quick custom styles.  For example if you wanted to change the site title color then you would paste this:', IT_TEXTDOMAIN ) . '<br /><br /><code>#logo a { color: blue; }</code>',
			'id' => 'custom_css',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Custom CSS Large', IT_TEXTDOMAIN ),
			'desc' => __( 'Style entered into this box will only be applied to large viewports (1200px +)', IT_TEXTDOMAIN ),
			'id' => 'custom_css_lg',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Custom CSS Medium', IT_TEXTDOMAIN ),
			'desc' => __( 'Style entered into this box will only be applied to medium viewports (992px to 1199px)', IT_TEXTDOMAIN ),
			'id' => 'custom_css_md_only',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Custom CSS Small', IT_TEXTDOMAIN ),
			'desc' => __( 'Style entered into this box will only be applied to small viewports (768px to 991px)', IT_TEXTDOMAIN ),
			'id' => 'custom_css_sm_only',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Custom CSS Tiny', IT_TEXTDOMAIN ),
			'desc' => __( 'Style entered into this box will only be applied to tiny viewports (767px -)', IT_TEXTDOMAIN ),
			'id' => 'custom_css_xs',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Custom CSS Medium And Down', IT_TEXTDOMAIN ),
			'desc' => __( 'Style entered into this box will be applied to medium, small, and tiny viewports (1199px -)', IT_TEXTDOMAIN ),
			'id' => 'custom_css_md',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Custom CSS Small And Down', IT_TEXTDOMAIN ),
			'desc' => __( 'Style entered into this box will be applied to small and tiny viewports (991px -)', IT_TEXTDOMAIN ),
			'id' => 'custom_css_sm',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Custom JavaScript', IT_TEXTDOMAIN ),
			'desc' => __( 'In case you need to add some custom javascript you may insert it here.', IT_TEXTDOMAIN ),
			'id' => 'custom_js',
			'type' => 'textarea'
		),			
		
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Menus
	 */
	array(
		'name' => array( 'it_menus_tab' => $option_tabs ),
		'type' => 'tab_start'
	),	
		array(
			'name' => __( 'Disable Sticky Menu', IT_TEXTDOMAIN ),			
			'id' => 'sticky_menu_disable',
			'options' => array( 'true' => __( 'Do not display the sticky menu on the left of the sticky bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Section Menu Type', IT_TEXTDOMAIN ),
			'id' => 'section_menu_type',
			'desc' => __( 'Choosing Mega menu style will enable latest posts from each category or tag to display directly in the menu on mouse hover.', IT_TEXTDOMAIN ),
			'options' => array( 
				'standard' => __( 'Standard menu', IT_TEXTDOMAIN ),
				'mega' => __( 'Mega menu', IT_TEXTDOMAIN ),
				'none' => __( 'Disable', IT_TEXTDOMAIN )
			),
			'default' => 'mega',
			'type' => 'radio'
		),
		array(
			'name' => __( 'Pre-load Mega Menus', IT_TEXTDOMAIN ),			
			'id' => 'section_menu_preload',
			'desc' => __( 'Adds a small amount of initial overhead so users do not have to wait to see posts when hovering over mega menu items. The expense is negligible in most cases.', IT_TEXTDOMAIN ),
			'options' => array( 'true' => __( 'Mega menu drop downs should populate on page load', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Icons', IT_TEXTDOMAIN ),			
			'id' => 'section_menu_icons_disable',
			'options' => array( 'true' => __( 'Do not display icons in the section menu', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Visible Colors', IT_TEXTDOMAIN ),			
			'id' => 'section_menu_visible_colors',
			'options' => array( 'true' => __( 'Show category colors by default without requiring hover', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Mega Menu Layout', IT_TEXTDOMAIN ),
			'id' => 'section_menu_article_num',
			'options' => array( 
				'5' => __( '1 Row (5 Posts)', IT_TEXTDOMAIN ),
				'10' => __( '2 Rows (10 Posts)', IT_TEXTDOMAIN ),
				'15' => __( '3 Rows (15 Posts)', IT_TEXTDOMAIN )
			),
			'default' => '5',
			'type' => 'radio'
		),
		array(
			'name' => __( 'Disable Mega Menu Images', IT_TEXTDOMAIN ),			
			'id' => 'section_menu_thumbnails_disable',
			'options' => array( 'true' => __( 'Disable thumbnails in the mega menu post list', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Sticky Menu Label', IT_TEXTDOMAIN ),
			'desc' => __( 'The label that displays for the menu when in responsive view. If left blank it will display "Navigation".', IT_TEXTDOMAIN ),
			'id' => 'sticky_menu_label',
			'default' => '',
			'htmlspecialchars' => false,
			'type' => 'text'
		),
		array(
			'name' => __( 'Section Menu Label', IT_TEXTDOMAIN ),
			'desc' => __( 'The label that displays for the menu when in responsive view. If left blank it will display "SECTIONS".', IT_TEXTDOMAIN ),
			'id' => 'section_menu_label',
			'default' => '',
			'htmlspecialchars' => false,
			'type' => 'text'
		),	
		array(
			'name' => __( 'Secondary Menu Label', IT_TEXTDOMAIN ),
			'desc' => __( 'The label that displays for the menu when in responsive view. If left blank it will display "More".', IT_TEXTDOMAIN ),
			'id' => 'secondary_menu_label',
			'default' => '',
			'htmlspecialchars' => false,
			'type' => 'text'
		),			
		array(
			'name' => __( 'Secondary Menu Position', IT_TEXTDOMAIN ),
			'id' => 'secondary_menu_position',
			'desc' => __( 'Choosing After will cause the menu to display to the right of the Section menu, choosing Before will cause it to display to the left of the Section menu.', IT_TEXTDOMAIN ),
			'options' => array( 
				'after' => __( 'After the Section menu', IT_TEXTDOMAIN ),
				'before' => __( 'Before the Section menu', IT_TEXTDOMAIN ),
				'none' => __( 'Disable', IT_TEXTDOMAIN )
			),
			'default' => 'after',
			'type' => 'radio'
		),
		array(
			'name' => __( 'Disable mmenu', IT_TEXTDOMAIN ),			
			'id' => 'mmenu_disable',
			'desc' => __( 'Use this if you are having issues with Google Adsense ads either not displaying or double-loading on page load. Note: this will force the sticky menu to be disabled.', IT_TEXTDOMAIN ),
			'options' => array( 'true' => __( 'Completely disable the slide-out jQuery mmenu functionality', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Utility Menu Label', IT_TEXTDOMAIN ),
			'desc' => __( 'The label that displays at the left of the utility menu. If left blank it will display "NAV".', IT_TEXTDOMAIN ),
			'id' => 'sub_menu_label',
			'default' => '',
			'htmlspecialchars' => false,
			'type' => 'text'
		),	
	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Styles
	 */
	array(
		'name' => array( 'it_style_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
		
		array(
			'name' => __( 'Accents', IT_TEXTDOMAIN ),
			'desc' => __( 'Used for links, titles, buttons, and other accent colors.', IT_TEXTDOMAIN ),
			'id' => 'color_accent',
			'default' => 'ff2654',
			'type' => 'color'
		),	
		array(
			'name' => __( 'Header Background', IT_TEXTDOMAIN ),
			'id' => 'color_header',
			'default' => '000000',
			'type' => 'color'
		),
		array(
			'name' => __( 'Header Icons', IT_TEXTDOMAIN ),
			'id' => 'color_header_icons',
			'default' => 'DEDEE6',
			'type' => 'color'
		),
		array(
			'name' => __( 'Menu Background', IT_TEXTDOMAIN ),
			'id' => 'color_menu',
			'default' => '19191A',
			'type' => 'color'
		),
		array(
			'name' => __( 'Menu Top Border', IT_TEXTDOMAIN ),
			'id' => 'color_menu_border',
			'default' => '4D4D52',
			'type' => 'color'
		),
		array(
			'name' => __( 'Menu Text', IT_TEXTDOMAIN ),
			'id' => 'color_menu_text',
			'default' => 'DEDEE6',
			'type' => 'color'
		),
		array(
			'name' => __( 'Menu Icons', IT_TEXTDOMAIN ),
			'desc' => __( 'Random article, search, account controls, etc.', IT_TEXTDOMAIN ),
			'id' => 'color_menu_icons',
			'default' => '75757C',
			'type' => 'color'
		),
		array(
			'name' => __( 'Other Backgrounds', IT_TEXTDOMAIN ),
			'desc' => __( 'Used for explicit slider, top ten slider, etc.', IT_TEXTDOMAIN ),
			'id' => 'color_other',
			'default' => '202022',
			'type' => 'color'
		),
		array(
			'name' => __( 'Boxed Background', IT_TEXTDOMAIN ),
			'desc' => __( 'Used for the boxed wrapper that contains the main content. Only applied if the boxed wrapper is actually turned on for the desired page in the theme options.', IT_TEXTDOMAIN ),
			'id' => 'color_boxed',
			'default' => 'f3f3fb',
			'type' => 'color'
		),	
		array(
			'name' => __( 'Main Text', IT_TEXTDOMAIN ),
			'id' => 'color_main_text',
			'default' => '333333',
			'type' => 'color'
		),	
		array(
			'name' => __( 'Outer Boxed Background', IT_TEXTDOMAIN ),
			'desc' => __( 'Overrides the main background color selected in Appearance >> Background only when the boxed wrapper is used.', IT_TEXTDOMAIN ),
			'id' => 'color_boxed_bg',
			'default' => 'e3e3ea',
			'type' => 'color'
		),
		array(
			'name' => __( 'Billboard Background', IT_TEXTDOMAIN ),
			'desc' => __( 'Overrides the Outer Boxed Background color selected above when the Billboard post layout is used.', IT_TEXTDOMAIN ),
			'id' => 'color_billboard_bg',
			'default' => 'e3e3ea',
			'type' => 'color'
		),
		array(
			'name' => __( 'Footer Background', IT_TEXTDOMAIN ),
			'id' => 'color_footer',
			'default' => '202022',
			'type' => 'color'
		),
		array(
			'name' => __( 'Footer Text', IT_TEXTDOMAIN ),
			'id' => 'color_footer_text',
			'default' => 'C9CCD8',
			'type' => 'color'
		),
		array(
			'name' => __( 'Footer Icons', IT_TEXTDOMAIN ),
			'id' => 'color_footer_icons',
			'default' => '626268',
			'type' => 'color'
		),
		
		array(
			'name' => __( 'Category Colors', IT_TEXTDOMAIN ),
			'desc' => __( 'Setup unique colors for each of your categories in the Categories tab on the left.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Fonts', IT_TEXTDOMAIN ),
			'desc' => __( 'You can override the default fonts for several parts of the theme by selecting them below. Leave the font unselected to use the default font, or if you have already made a selection and want to set it back to the default, select "Choose One..." For performance reasons only selected fonts will be imported from Google, which means we cannot display all the actual font faces in this list. To preview what each font looks like without having to activate each one, go to Google Fonts and take a look at it: http://www.google.com/fonts/', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Section Menu Font Face', IT_TEXTDOMAIN ),
			'desc' => __( 'Applies to the main section menu and the secondary menu.', IT_TEXTDOMAIN ),
			'id' => 'font_section_menu',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Section Menu Font Size', IT_TEXTDOMAIN ),
			'id' => 'font_section_menu_size',
			'target' => 'font_size',
			'type' => 'select'
		),
		array(
			'name' => __( 'Slide-out Menu Font Face', IT_TEXTDOMAIN ),
			'desc' => __( 'Applies to the slide-out sticky menu (all views) and section menu (mobile view only).', IT_TEXTDOMAIN ),
			'id' => 'font_slideout_menu',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Slide-out Menu Font Size', IT_TEXTDOMAIN ),
			'id' => 'font_slideout_menu_size',
			'target' => 'font_size',
			'type' => 'select'
		),
		array(
			'name' => __( 'Utility Menu Font Face', IT_TEXTDOMAIN ),
			'desc' => __( 'Applies to the utility menu available in the page builders, the contents menu on single review pages, and the related post tab links.', IT_TEXTDOMAIN ),
			'id' => 'font_utility_menu',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Utility Menu Font Size', IT_TEXTDOMAIN ),
			'desc' => __( 'Note: not all heights will adjust for larger font sizes.', IT_TEXTDOMAIN ),
			'id' => 'font_utility_menu_size',
			'target' => 'font_size',
			'type' => 'select'
		),
		array(
			'name' => __( 'Section Headers Font Face', IT_TEXTDOMAIN ),
			'desc' => __( 'Applies to various section headers throughout the site.', IT_TEXTDOMAIN ),
			'id' => 'font_section_headers',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Section Headers Font Size', IT_TEXTDOMAIN ),
			'desc' => __( 'Note: not all heights will adjust for larger font sizes.', IT_TEXTDOMAIN ),
			'id' => 'font_section_headers_size',
			'target' => 'font_size',
			'type' => 'select'
		),
		array(
			'name' => __( 'Links/Panels Font Face', IT_TEXTDOMAIN ),
			'desc' => __( 'Applies to most places that are clickable, whether links or entire panels. Includes the hero slider, page builder components, post lists, directory, etc. Font size adjustments must be done manually in the CSS.', IT_TEXTDOMAIN ),
			'id' => 'font_links',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Post Titles Font Face', IT_TEXTDOMAIN ),
			'desc' => __( 'Applies when a large post title format is used, such as in the hero slider, list view post loops, and single page standard view (non-billboard) titles.', IT_TEXTDOMAIN ),
			'id' => 'font_titles',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Post Titles Font Size', IT_TEXTDOMAIN ),
			'id' => 'font_titles_size',
			'target' => 'font_size',
			'type' => 'select'
		),
		array(
			'name' => __( 'Single Title Font Size', IT_TEXTDOMAIN ),
			'desc' => __( 'Applies to single page standard view (non-billboard) titles.', IT_TEXTDOMAIN ),
			'id' => 'font_titles_single_size',
			'target' => 'font_size',
			'type' => 'select'
		),
		array(
			'name' => __( 'Hero Slider Font Size', IT_TEXTDOMAIN ),
			'desc' => __( 'Applies to the title of the hero slider. For the left nav links use the Links/Panels Font Face option.', IT_TEXTDOMAIN ),
			'id' => 'font_hero_size',
			'target' => 'font_size',
			'type' => 'select'
		),
		array(
			'name' => __( 'Headliner Font Face', IT_TEXTDOMAIN ),
			'desc' => __( 'Applies to the large title in the headliner page builder component as well as the main title on single pages when Billboard layout is used.', IT_TEXTDOMAIN ),
			'id' => 'font_headliner',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Headliner Font Size', IT_TEXTDOMAIN ),
			'id' => 'font_headliner_size',
			'target' => 'font_size',
			'type' => 'select'
		),
		array(
			'name' => __( 'Awards Font Face', IT_TEXTDOMAIN ),
			'desc' => __( 'Applies to the award text that displays next to the award icon in all areas of the theme.', IT_TEXTDOMAIN ),
			'id' => 'font_awards',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Awards Font Size', IT_TEXTDOMAIN ),
			'id' => 'font_awards_size',
			'target' => 'font_size',
			'type' => 'select'
		),
		array(
			'name' => __( 'Numbers Font Face', IT_TEXTDOMAIN ),
			'desc' => __( 'Applies any time a number is used, such as trending and top ten counts, ratings, post pagination, and social counts. Font size adjustments must be done manually in the CSS.', IT_TEXTDOMAIN ),
			'id' => 'font_numbers',
			'target' => 'fonts',
			'type' => 'select'
		),		
		array(
			'name' => __( 'Section Titles Font Face', IT_TEXTDOMAIN ),
			'desc' => __( 'Applies to the major section titles on single posts only.', IT_TEXTDOMAIN ),
			'id' => 'font_section_titles',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Section Titles Font Size', IT_TEXTDOMAIN ),
			'id' => 'font_section_titles_size',
			'target' => 'font_size',
			'type' => 'select'
		),
		array(
			'name' => __( 'Text Font Face', IT_TEXTDOMAIN ),
			'desc' => __( 'Applies to normal body copy within the theme, including excerpts, details, page/post content, etc.', IT_TEXTDOMAIN ),
			'id' => 'font_text',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Text Font Size', IT_TEXTDOMAIN ),
			'id' => 'font_text_size',
			'target' => 'font_size',
			'type' => 'select'
		),
		array(
			'name' => __( 'Serif Font Face', IT_TEXTDOMAIN ),
			'desc' => __( 'Applies anywhere that the default "Roboto Slab" font is used, which includes various spots throughout the theme. Some of these include the post author/date and author names in the author listing page.', IT_TEXTDOMAIN ),
			'id' => 'font_serif',
			'target' => 'fonts',
			'type' => 'select'
		),
		
		array(
			'name' => __( 'Add Subsets', IT_TEXTDOMAIN ),
			'desc' => __( 'Leave this unselected unless you specifically want to add subsets beyond Latin. This will only work for fonts that actually have the specific subset (refer to Google Fonts to see which ones have subsets). This also adds the character sets to the default theme fonts. Be careful! Adding subsets will impact page load times.', IT_TEXTDOMAIN ),
			'id' => 'font_subsets',
			'options' => array(
				'latin' => 'Latin',
				'latin-ext' => 'Latin Extended',
				'cyrillic' => 'Cyrillic',
				'cyrillic-ext' => 'Cyrillic Extended',
				'greek' => 'Greek',
				'greek-ext' => 'Greek Extended'
			),
			'type' => 'checkbox'
		),

	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Page Builders
	 */
	array(
		'name' => array( 'it_pages_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Front Page Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'Used for your front page if Settings >> Reading >> "Front page displays" is set to "Your latest posts".', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Page Builder', IT_TEXTDOMAIN ),
			'id' => 'front_builder',
			'type' => 'builder'
		),

		array(
			'name' => __( 'Archive Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'All category, tag, author, and date listing archive pages.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Page Builder', IT_TEXTDOMAIN ),
			'id' => 'archive_builder',
			'type' => 'builder'
		),
		
		array(
			'name' => __( 'Search Results Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'All pages that list search results.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Page Builder', IT_TEXTDOMAIN ),
			'id' => 'search_builder',
			'type' => 'builder'
		),			
		
		array(
			'name' => __( 'Standard Page Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'All standard pages created in the WordPress >> Pages area (also includes 404s). You should choose "Page/Post Content" at the very minimum. You can selectively override these settings in the Layout Options for each specific page.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Page Builder', IT_TEXTDOMAIN ),
			'id' => 'page_builder',
			'type' => 'builder'
		),
		
		array(
			'name' => __( 'Single Post Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'All individual posts. You should choose "Page/Post Content" at the very minimum. You can selectively override these settings in the Layout Options for each specific post.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),		
		array(
			'name' => __( 'Page Builder', IT_TEXTDOMAIN ),
			'id' => 'single_builder',
			'type' => 'builder'
		),	
		
		array(
			'name' => __( 'Author Listing Page Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'Pages with the "Author Listing" page template assigned.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Page Builder', IT_TEXTDOMAIN ),
			'id' => 'author_builder',
			'type' => 'builder'
		),
		
		array(
			'name' => __( '404 Pages', IT_TEXTDOMAIN ),
			'desc' => __( 'Any time a page is not found and the theme presents a "404 error" page.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Page Builder', IT_TEXTDOMAIN ),
			'id' => '404_builder',
			'type' => 'builder'
		),	
		
		array(
			'name' => __( 'Hero Slider', IT_TEXTDOMAIN ),
			'desc' => __( 'Settings that apply to all instances of the hero slider. Note: you can currently only have one hero slider maximum on each page.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),		
		array(
			'name' => __( 'Autoplay', IT_TEXTDOMAIN ),
			'id' => 'hero_autoplay',
			'options' => array( 'true' => __( 'The slider should automatically cycle posts', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Interval', IT_TEXTDOMAIN ),
			'desc' => __( 'The number of seconds to display each item in the carousel before rotating.', IT_TEXTDOMAIN ),
			'id' => 'hero_interval',
			'target' => 'seconds',
			'nodisable' => true,
			'type' => 'select'
		),
		array(
			'name' => __( 'Transition', IT_TEXTDOMAIN ),
			'desc' => __( 'The effect used to transition from one slide to the next', IT_TEXTDOMAIN ),
			'id' => 'hero_transition',
			'target' => 'featured_transition',
			'type' => 'select'
		),
		array(
			'name' => __( 'Disable Timer', IT_TEXTDOMAIN ),
			'id' => 'hero_timer_disable',
			'options' => array( 'true' => __( 'Hide the timer at the top left of the slider', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Click Anywhere', IT_TEXTDOMAIN ),
			'id' => 'hero_full_click',
			'options' => array( 'true' => __( 'Click anywhere in the hero slider to go to the post', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Circles', IT_TEXTDOMAIN ),
			'id' => 'hero_circles_disable',
			'options' => array( 'true' => __( 'Hide the circle thumbnails in the left nav', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Category', IT_TEXTDOMAIN ),
			'id' => 'hero_category_disable',
			'options' => array( 'true' => __( 'Hide the category icon', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Rating', IT_TEXTDOMAIN ),
			'id' => 'hero_rating_disable',
			'options' => array( 'true' => __( 'Hide the rating (if one exists)', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Award', IT_TEXTDOMAIN ),
			'id' => 'hero_award_disable',
			'options' => array( 'true' => __( 'Hide the award (if article has an award)', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Disable Meta', IT_TEXTDOMAIN ),
			'id' => 'hero_meta_disable',
			'options' => array( 'true' => __( 'Hide the likes/views/comments', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Disable Title', IT_TEXTDOMAIN ),
			'id' => 'hero_title_disable',
			'options' => array( 'true' => __( 'Hide the article title that overlays the main image', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Disable Video', IT_TEXTDOMAIN ),
			'id' => 'hero_video_disable',
			'options' => array( 'true' => __( 'Do not display featured videos in the slider', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Show Youtube Controls', IT_TEXTDOMAIN ),
			'id' => 'hero_video_controls',
			'options' => array( 'true' => __( 'Display controls for Youtube videos in the slider', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Widgets', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings pertain to every instance the Widgets page builder is used.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'You can select any type of layout you want for the widget columns.', IT_TEXTDOMAIN ),
			'id' => 'widgets_layout',
			'options' => array(
				'a' => THEME_ADMIN_ASSETS_URI . '/images/widgets_a.png',
				'b' => THEME_ADMIN_ASSETS_URI . '/images/widgets_b.png',
				'c' => THEME_ADMIN_ASSETS_URI . '/images/widgets_c.png',
				'd' => THEME_ADMIN_ASSETS_URI . '/images/widgets_d.png',
				'e' => THEME_ADMIN_ASSETS_URI . '/images/widgets_e.png',
			),
			'default' => 'c',
			'type' => 'layout'
		),
		array(
			'name' => __( 'Section Widget Categories', IT_TEXTDOMAIN ),
			'desc' => __( 'This is where you select the categories that will display in the Sections widget category tabs.', IT_TEXTDOMAIN ),
			'id' => 'widgets_section_categories',
			'target' => 'cat',
			'type' => 'multidropdown',
			'shortcode_multiply' => true
		),	
		
		array(
			'name' => __( 'Portholes', IT_TEXTDOMAIN ),
			'desc' => __( 'The grid of tall posts with circle thumbnails in the middle.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Layout', IT_TEXTDOMAIN ),
			'id' => 'portholes_cols',
			'options' => array(
				'3' => THEME_ADMIN_ASSETS_URI . '/images/portholes_3.png',
				'4' => THEME_ADMIN_ASSETS_URI . '/images/portholes_4.png',
				'5' => THEME_ADMIN_ASSETS_URI . '/images/portholes_5.png',
				'6' => THEME_ADMIN_ASSETS_URI . '/images/portholes_6.png'
			),
			'default' => '6',
			'type' => 'layout'
		),		
		array(
			'name' => __( 'Disable Award', IT_TEXTDOMAIN ),
			'id' => 'portholes_award_disable',
			'options' => array( 'true' => __( 'Disable the award (if any) at the top left', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable User Rating', IT_TEXTDOMAIN ),
			'id' => 'portholes_user_rating_disable',
			'options' => array( 'true' => __( 'Disable the user rating (if any) at the top right', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Meta', IT_TEXTDOMAIN ),
			'id' => 'portholes_meta_disable',
			'options' => array( 'true' => __( 'Disable the likes, views, and comments at the bottom', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( "Connect", IT_TEXTDOMAIN ),
			'desc' => __( 'The bar that displays the email signup, social counts, and social badges', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Disable Email Signup', IT_TEXTDOMAIN ),
			'id' => 'connect_email_disable',
			'options' => array( 'true' => __( 'Disable the email signup form right of the main label', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Email label', IT_TEXTDOMAIN ),
			'desc' => __( 'This is the placeholder text that displays in the email singup textbox.', IT_TEXTDOMAIN ),
			'id' => 'email_label',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Disable Social Counts', IT_TEXTDOMAIN ),
			'id' => 'connect_counts_disable',
			'options' => array( 'true' => __( 'Disable the social counts right of the email singup', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Social Badges', IT_TEXTDOMAIN ),
			'id' => 'connect_social_disable',
			'options' => array( 'true' => __( 'Disable the social badges at the very right of the connect bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	

	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Post Loops
	 */
	array(
		'name' => array( 'it_loop_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
		array(
			'name' => __( 'Grid Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'Dictates how the sidebar will be displayed (if any)', IT_TEXTDOMAIN ),
			'id' => 'grid_layout',
			'options' => array(
				'a' => THEME_ADMIN_ASSETS_URI . '/images/grid_a.png',
				'b' => THEME_ADMIN_ASSETS_URI . '/images/grid_b.png',
				'c' => THEME_ADMIN_ASSETS_URI . '/images/grid_c.png',
				'd' => THEME_ADMIN_ASSETS_URI . '/images/grid_d.png',
				'e' => THEME_ADMIN_ASSETS_URI . '/images/grid_e.png',
				'f' => THEME_ADMIN_ASSETS_URI . '/images/grid_f.png',
			),
			'default' => 'e',
			'type' => 'layout'
		),	
		array(
			'name' => __( 'Grid Unique Sidebar', IT_TEXTDOMAIN ),
			'id' => 'grid_unique_sidebar',
			'options' => array( 'true' => __( 'Use the "Grid Sidebar" instead of the "Loop Sidebar"', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Blog Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'Dictates how the sidebar will be displayed (if any)', IT_TEXTDOMAIN ),
			'id' => 'list_layout',
			'options' => array(
				'a' => THEME_ADMIN_ASSETS_URI . '/images/loop_a.png',
				'b' => THEME_ADMIN_ASSETS_URI . '/images/loop_b.png',
				'c' => THEME_ADMIN_ASSETS_URI . '/images/loop_c.png',
			),
			'default' => 'a',
			'type' => 'layout'
		),
		array(
			'name' => __( 'Blog Unique Sidebar', IT_TEXTDOMAIN ),
			'id' => 'list_unique_sidebar',
			'options' => array( 'true' => __( 'Use the "Paged Blog Sidebar" instead of the "Loop Sidebar"', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
			
		array(
			'name' => __( 'Control Bar', IT_TEXTDOMAIN ),
			'desc' => __( 'Common options for the filter bar at the top of all post loops.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),		
		array(
			'name' => __( 'Disable Filter Buttons', IT_TEXTDOMAIN ),
			'desc' => __( 'You can disable individual filter buttons.', IT_TEXTDOMAIN ),
			'id' => 'loop_filter_disable',
			'options' => array(
				'liked' => 'Liked',
				'viewed' => 'Viewed',
				'reviewed' => 'Reviewed',
				'rated' => 'Rated',
				'commented' => 'Commented',
				'awarded' => 'Awarded',
				'title' => 'Alphabetical'
			),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Filter Tooltips', IT_TEXTDOMAIN ),
			'id' => 'loop_tooltips_disable',
			'options' => array( 'true' => __( 'Disable the filter button tooltips', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'This will disable the tooltips that display when you hover over the filter buttons', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Articles', IT_TEXTDOMAIN ),
			'desc' => __( 'Common options for the articles and layout of all post loops.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Append Subtitle', IT_TEXTDOMAIN ),
			'id' => 'loop_subtitle',
			'options' => array( 'true' => __( 'Display the subtitle after the post title', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Award', IT_TEXTDOMAIN ),
			'id' => 'loop_award_disable',
			'options' => array( 'true' => __( 'Awards will only display on single post pages', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Badges', IT_TEXTDOMAIN ),
			'id' => 'loop_badge_disable',
			'options' => array( 'true' => __( 'Badges will only display on single post pages', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Authorship', IT_TEXTDOMAIN ),
			'id' => 'loop_authorship_disable',
			'options' => array( 'true' => __( 'The author and date of the post', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Excerpt Length', IT_TEXTDOMAIN ),
			'desc' => __( 'Leave blank for default excerpt lengths. Or, specify your desired excerpt length in characters (not words). For reference, the default is 520 characters for grid layouts and 800 characters for list layouts.', IT_TEXTDOMAIN ),
			'id' => 'loop_excerpt_length',
			'type' => 'text'
		),
		array(
			'name' => __( 'Disable Excerpt', IT_TEXTDOMAIN ),
			'id' => 'loop_excerpt_disable',
			'options' => array( 'true' => __( 'Only the title will display, no excerpt', IT_TEXTDOMAIN ) ),
			'desc' => __( 'It is helpful to hide this if you have a lot of badges and awards you want to display for your posts in order to present a cleaner layout to the user', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Likes', IT_TEXTDOMAIN ),
			'id' => 'loop_likes_disable',
			'options' => array( 'true' => __( 'Likes will only display on single post pages', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Views', IT_TEXTDOMAIN ),
			'id' => 'loop_views_disable',
			'options' => array( 'true' => __( 'Views will only display on single post pages', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Comments', IT_TEXTDOMAIN ),
			'id' => 'loop_comments_disable',
			'options' => array( 'true' => __( 'Comments will only display on single post pages', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'The number of comments will not display in the main loop. Keep in mind the comments will automatically be hidden if there are no comments for the post even if this option is unselected.', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Rating', IT_TEXTDOMAIN ),
			'id' => 'loop_rating_disable',
			'options' => array( 'true' => __( 'Ratings will only display on single post pages', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable All Meta Info', IT_TEXTDOMAIN ),
			'id' => 'loop_meta_disable',
			'options' => array( 'true' => __( 'Disregard above options and disable entire meta bar', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'The bar at the bottom of each post in the loop containing the views, likes, date, rating, etc. will be completely hidden.', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Show Featured Videos', IT_TEXTDOMAIN ),
			'id' => 'loop_video',
			'options' => array( 'true' => __( 'Show featured videos in place of images', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'When the post has a featured video assigned, display it instead of the featured image.', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Show Video Controls', IT_TEXTDOMAIN ),
			'id' => 'loop_video_controls',
			'options' => array( 'true' => __( 'Show video controls for featured videos (youtube only)', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'When the slide has a featured video, display the controls at the bottom of the video (only applies to Youtube videos).', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Pagination', IT_TEXTDOMAIN ),
			'desc' => __( 'The page number buttons and navigation that appear below the post loop.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Range', IT_TEXTDOMAIN ),
			'desc' => __( 'The number of pages to display to the right and left of the current page. Setting this to 3 for example will result in 7 total possible page number buttons generated (3 on the left, 3 on the right, plus the current page) in addition to the arrow navigation (if enabled).', IT_TEXTDOMAIN ),
			'id' => 'page_range',
			'target' => 'range_number',
			'type' => 'select',
			'nodisable' => true,
		),	
		array(
			'name' => __( 'Range (Mobile)', IT_TEXTDOMAIN ),
			'desc' => __( 'You can set a different range for mobile views so that the pagination fits into one row. If you want the pagination to fit into one row set this to 2.', IT_TEXTDOMAIN ),
			'id' => 'page_range_mobile',
			'target' => 'range_number',
			'type' => 'select',
			'nodisable' => true,
		),	
		array(
			'name' => __( 'Disable Prev/Next Navigation', IT_TEXTDOMAIN ),
			'id' => 'prev_next_disable',
			'options' => array( 'true' => __( 'Hide the next and previous navigation arrows.', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'These arrows display on the right and left of the pagination. They do not navigate to the next and previous pages, but rather the next and previous blocks of page numbers. For instance, if the range is set to 6 the next arrow will increase the current page 8 slots (range + current page + 1).', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable First/Last Navigation', IT_TEXTDOMAIN ),
			'id' => 'first_last_disable',
			'options' => array( 'true' => __( 'Hide the first and last navigation arrows.', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'These arrows display on the right and left of the pagination and they are used for quickly navigating to the first or last page.', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),		
	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Template Options
	 */
	array(
		'name' => array( 'it_posts_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Front Page', IT_TEXTDOMAIN ),
			'desc' => __( 'Adjustment options for pages with the "Front Page" page template assigned.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Boxed', IT_TEXTDOMAIN ),
			'id' => 'front_boxed',
			'options' => array( 'true' => __( 'Contain the page content in a boxed wrapper.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Archives', IT_TEXTDOMAIN ),
			'desc' => __( 'Adjustment options for category/tag/date/search listing pages.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Boxed', IT_TEXTDOMAIN ),
			'id' => 'archive_boxed',
			'options' => array( 'true' => __( 'Contain the page content in a boxed wrapper.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Ignore Excludes/Limits', IT_TEXTDOMAIN ),
			'desc' => __( 'This applies to the Paged Grid, Infinite Grid, Paged Blog, and Infinite Blog builder panels. If you have selected any categories or tags in any of the excluded or limited drop downs and you do not want those settings to apply to your archive listing pages, turn on this option.', IT_TEXTDOMAIN ),
			'id' => 'archive_ignore_excludes',
			'options' => array( 'true' => __( 'Disregard any category or tag exclusions or limits for Grid/Blog panels.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
	
		array(
			'name' => __( 'Standard Pages', IT_TEXTDOMAIN ),
			'desc' => __( 'Show/hide various components for standard pages.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Boxed', IT_TEXTDOMAIN ),
			'id' => 'page_boxed',
			'options' => array( 'true' => __( 'Contain the page content in a boxed wrapper.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Sidebar Position', IT_TEXTDOMAIN ),
			'desc' => __( 'You can specify a layout with or without a sidebar.', IT_TEXTDOMAIN ),
			'id' => 'page_sidebar_position',
			'options' => array(
				'sidebar-right' => THEME_ADMIN_ASSETS_URI . '/images/footer_g.png',
				'sidebar-left' => THEME_ADMIN_ASSETS_URI . '/images/footer_k.png',
				'full' => THEME_ADMIN_ASSETS_URI . '/images/footer_a.png',				
			),
			'default' => 'sidebar-right',
			'type' => 'layout'
		),		
		array(
			'name' => __( 'Disable Control Bar', IT_TEXTDOMAIN ),
			'id' => 'page_controlbar_disable',
			'options' => array( 'true' => __( 'Disable the entire control bar above the page title', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Page Navigation', IT_TEXTDOMAIN ),
			'id' => 'page_postnav_disable',
			'options' => array( 'true' => __( 'Disable the page navigation in the control bar', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable View Count', IT_TEXTDOMAIN ),
			'id' => 'page_views_disable',
			'options' => array( 'true' => __( 'Disable the view count in the control bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Like Button', IT_TEXTDOMAIN ),
			'id' => 'page_likes_disable',
			'options' => array( 'true' => __( 'Disable the like button in the control bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Comment Count', IT_TEXTDOMAIN ),
			'id' => 'page_comment_count_disable',
			'options' => array( 'true' => __( 'Disable the comment count in the control bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Sharing', IT_TEXTDOMAIN ),
			'id' => 'page_sharing_disable',
			'options' => array( 'true' => __( 'Disable the social sharing in the control bar', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Disable Date/Author', IT_TEXTDOMAIN ),
			'id' => 'page_authorship_disable',
			'options' => array( 'true' => __( 'Disable the page date and author below the page title', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Featured Image Size', IT_TEXTDOMAIN ),
			'desc' => __( 'The default featured image size for all standard pages only', IT_TEXTDOMAIN ),
			'id' => 'page_featured_image_size',
			'options' => array(
				'none' => THEME_ADMIN_ASSETS_URI . '/images/image_none.png',
				'180' => THEME_ADMIN_ASSETS_URI . '/images/image_small.png',
				'360' => THEME_ADMIN_ASSETS_URI . '/images/image_medium.png',
				'790' => THEME_ADMIN_ASSETS_URI . '/images/image_large.png',
			),
			'default' => '360',
			'type' => 'layout'
		),
		array(
			'name' => __( 'Disable Video', IT_TEXTDOMAIN ),
			'id' => 'page_video_disable',
			'options' => array( 'true' => __( 'When a page has a featured video assigned do not display it.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Enable Comments', IT_TEXTDOMAIN ),
			'id' => 'page_comments',
			'options' => array( 'true' => __( 'Enable comments on regular pages', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Single Posts', IT_TEXTDOMAIN ),
			'desc' => __( 'Show/hide various components for single post views.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Boxed', IT_TEXTDOMAIN ),
			'id' => 'post_boxed',
			'options' => array( 'true' => __( 'Contain the page content in a boxed wrapper.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Layout', IT_TEXTDOMAIN ),
			'id' => 'post_layout',
			'options' => array(
				'classic' => THEME_ADMIN_ASSETS_URI . '/images/layout_classic.png',
				'billboard' => THEME_ADMIN_ASSETS_URI . '/images/layout_billboard.png',
				),
			'default' => 'classic',
			'type' => 'layout'
		),
		array(
			'name' => __( 'Sidebar Position', IT_TEXTDOMAIN ),
			'desc' => __( 'You can specify a layout with or without a sidebar.', IT_TEXTDOMAIN ),
			'id' => 'post_sidebar_position',
			'options' => array(
				'sidebar-right' => THEME_ADMIN_ASSETS_URI . '/images/footer_g.png',
				'sidebar-left' => THEME_ADMIN_ASSETS_URI . '/images/footer_k.png',
				'full' => THEME_ADMIN_ASSETS_URI . '/images/footer_a.png',				
			),
			'default' => 'sidebar-right',
			'type' => 'layout'
		),
		array(
			'name' => __( 'Default Post Type', IT_TEXTDOMAIN ),
			'id' => 'post_type_default',
			'desc' => __( 'You can select whether a post is an Article or a Review on a post-by-post basis in the Review Options panel when editing the post. Use this option to select whether the default option should be Article or Review.', IT_TEXTDOMAIN ),
			'options' => array( 
				'true' => __( 'Article', IT_TEXTDOMAIN ),
				'false' => __( 'Review', IT_TEXTDOMAIN ),
			),
			'default' => 'true',
			'type' => 'radio'
		),	
		array(
			'name' => __( 'Disable Control Bar', IT_TEXTDOMAIN ),
			'id' => 'post_controlbar_disable',
			'options' => array( 'true' => __( 'Disable the entire control bar above the post title', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Post Navigation', IT_TEXTDOMAIN ),
			'id' => 'post_postnav_disable',
			'options' => array( 'true' => __( 'Disable the post navigation in the control bar', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Disable View Count', IT_TEXTDOMAIN ),
			'id' => 'post_views_disable',
			'options' => array( 'true' => __( 'Disable the view count in the control bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Like Button', IT_TEXTDOMAIN ),
			'id' => 'post_likes_disable',
			'options' => array( 'true' => __( 'Disable the like button in the control bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Comment Count', IT_TEXTDOMAIN ),
			'id' => 'post_comment_count_disable',
			'options' => array( 'true' => __( 'Disable the comment count in the control bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Sharing', IT_TEXTDOMAIN ),
			'id' => 'post_sharing_disable',
			'options' => array( 'true' => __( 'Disable the social sharing in the control bar', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Sharing Position', IT_TEXTDOMAIN ),
			'desc' => __( 'The social sharing links can be displayed in different positions. This affects both posts and pages.', IT_TEXTDOMAIN ),
			'id' => 'sharing_position',
			'options' => array(
				'control_bar' => __( 'Inside the top "control" bar', IT_TEXTDOMAIN ),
				'above_image' => __( 'Above the featured image', IT_TEXTDOMAIN ),	
				'above_content' => __( 'Above the post content', IT_TEXTDOMAIN ),	
				'below_content' => __( 'Below the post content', IT_TEXTDOMAIN ),		
			),
			'default' => 'control-bar',
			'type' => 'radio'
		),
		array(
			'name' => __( 'Disable Date/Author', IT_TEXTDOMAIN ),
			'id' => 'post_authorship_disable',
			'options' => array( 'true' => __( 'Disable the post date and author below the post title', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Author Avatar', IT_TEXTDOMAIN ),
			'id' => 'post_authorship_avatar_disable',
			'options' => array( 'true' => __( 'Disable the author avatar at the top of the post', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Featured Image Size', IT_TEXTDOMAIN ),
			'desc' => __( 'The default featured image size for all standard posts only', IT_TEXTDOMAIN ),
			'id' => 'post_featured_image_size',
			'options' => array(
				'none' => THEME_ADMIN_ASSETS_URI . '/images/image_none.png',
				'180' => THEME_ADMIN_ASSETS_URI . '/images/image_small.png',
				'360' => THEME_ADMIN_ASSETS_URI . '/images/image_medium.png',
				'790' => THEME_ADMIN_ASSETS_URI . '/images/image_large.png',
			),
			'default' => '360',
			'type' => 'layout'
		),
		array(
			'name' => __( 'Disable Clickable Image', IT_TEXTDOMAIN ),
			'desc' => __( 'Turn this off to disable clicking on the featured image, which opens the largest size of the image in a lightbox (if the lightbox effect is not disabled) or as a new page in the browser.', IT_TEXTDOMAIN ),
			'id' => 'clickable_image_disable',
			'options' => array( 'true' => __( 'Featured image should not be clickable.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Featured Image Captions', IT_TEXTDOMAIN ),
			'id' => 'featured_image_caption',
			'options' => array( 'true' => __( 'Display caption text under featured image if any exists.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Disable Lightbox Effect', IT_TEXTDOMAIN ),
			'id' => 'colorbox_disable',
			'options' => array( 'true' => __( 'Disable the lightbox when clicking on featured image/galleries', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Lightbox Slideshow', IT_TEXTDOMAIN ),
			'id' => 'colorbox_slideshow',
			'options' => array( 'true' => __( 'Gallery lightboxes should behave as a slideshow', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Video', IT_TEXTDOMAIN ),
			'id' => 'post_video_disable',
			'options' => array( 'true' => __( 'When a post has a featured video assigned do not display it.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Contents Menu Behavior', IT_TEXTDOMAIN ),
			'desc' => __( 'This is the fixed, post-specific navigation menu that links to different parts of the post. If you choose opt-in you can selectively enable this menu for specific posts (otherwise it will be disabled). If you choose one of the first two options you can selectively disable it for specific posts (otherwise it will be enabled).', IT_TEXTDOMAIN ),
			'id' => 'contents_menu',
			'options' => array(
				'both' => __( 'Show on Articles and Reviews', IT_TEXTDOMAIN ),
				'reviews' => __( 'Show only on Reviews', IT_TEXTDOMAIN ),	
				'optin' => __( 'Opt-in', IT_TEXTDOMAIN ),
				'none' => __( 'Disable', IT_TEXTDOMAIN ),				
			),
			'default' => 'reviews',
			'type' => 'radio'
		),
		array(
			'name' => __( 'Contents Menu Position', IT_TEXTDOMAIN ),
			'desc' => __( 'If you select the Horizontal option the position will automatically switch to vertical if the menu does not have room for all of the menu items for each specific page. This option is useful if you want to force vertical position regardless of the number of menu items.', IT_TEXTDOMAIN ),
			'id' => 'contents_menu_position',
			'options' => array(
				'horizontal' => __( 'Horizontal', IT_TEXTDOMAIN ),
				'vertical' => __( 'Vertical', IT_TEXTDOMAIN ),					
			),
			'default' => 'horizontal',
			'type' => 'radio'
		),
		array(
			'name' => __( 'Content Title', IT_TEXTDOMAIN ),
			'desc' => __( 'Useful if you are using reviews and you want to display a header above the review content.', IT_TEXTDOMAIN ),
			'id' => 'article_title',
			'type' => 'text'
		),
		array(
			'name' => __( 'Posts Content Title Disable', IT_TEXTDOMAIN ),
			'desc' => __( 'By default the content title displays on both Review and Article post types. Use this option if you want the content title to be disabled on posts with the Article post type.', IT_TEXTDOMAIN ),
			'id' => 'post_article_title_disable',
			'options' => array( 'true' => __( 'Disable the content title on standard article posts (non-review)', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Reactions Position', IT_TEXTDOMAIN ),
			'id' => 'reactions_position',
			'options' => array( 
				'top' => __( 'Above the post content', IT_TEXTDOMAIN ),
				'bottom' => __( 'Below the post content', IT_TEXTDOMAIN ),
				'none' => __( 'Disable reactions', IT_TEXTDOMAIN ),
			),
			'default' => 'bottom',
			'type' => 'radio'
		),
		array(
			'name' => __( 'Affiliate Link Position', IT_TEXTDOMAIN ),
			'id' => 'affiliate_position',
			'options' => array( 
				'before-overview' => __( 'At the top of the Overview section', IT_TEXTDOMAIN ),
				'after-overview' => __( 'At the bottom of the Overview section', IT_TEXTDOMAIN ),
				'rating' => __( 'After the Rating', IT_TEXTDOMAIN ),
				'before-content' => __( 'Above the post content', IT_TEXTDOMAIN ),
				'after-content' => __( 'Below the post content', IT_TEXTDOMAIN ),
			),
			'default' => 'bottom',
			'type' => 'radio'
		),
		array(
			'name' => __( 'Recommended Title', IT_TEXTDOMAIN ),
			'desc' => __( 'The title text to display above the reactions buttons', IT_TEXTDOMAIN ),
			'id' => 'reactions_title',
			'htmlentities' => true,
			'type' => 'text'
		),	
		array(
			'name' => __( 'Reactions Style', IT_TEXTDOMAIN ),
			'id' => 'reactions_style',
			'options' => array( 
				'icon' => __( 'Icon only', IT_TEXTDOMAIN ),
				'name' => __( 'Name only', IT_TEXTDOMAIN ),
				'both' => __( 'Icon + Name', IT_TEXTDOMAIN ),
			),
			'default' => 'both',
			'type' => 'radio'
		),		
		array(
			'name' => __( 'Disable Author Info', IT_TEXTDOMAIN ),
			'id' => 'post_author_disable',
			'options' => array( 'true' => __( 'Disable the author information below the post', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Recommended', IT_TEXTDOMAIN ),
			'id' => 'post_recommended_disable',
			'options' => array( 'true' => __( 'Disable the recommended posts section', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Recommended Method', IT_TEXTDOMAIN ),
			'id' => 'post_recommended_method',
			'desc' => __( 'For the "Same tags OR same categories" method, use the "Number of Recommended Filters" option below to set how many of EACH will display, rather than how many TOTAL as is applied to the rest of the methods. So setting this to "2" will cause the first two tags and the first two categories to display, resulting in four total filters.', IT_TEXTDOMAIN ),
			'options' => array( 
				'tags' => __( 'Same tags', IT_TEXTDOMAIN ),
				'categories' => __( 'Same categories', IT_TEXTDOMAIN ),
				'tags_categories' => __( 'Same tags OR same categories (tags will appear first in order)', IT_TEXTDOMAIN ),
			),
			'default' => 'tags',
			'type' => 'radio'
		),	
		array(
			'name' => __( 'Recommended Label', IT_TEXTDOMAIN ),
			'desc' => __( 'The title text to display in the title of the recommended section', IT_TEXTDOMAIN ),
			'id' => 'post_recommended_label',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Number of Recommended Filters', IT_TEXTDOMAIN ),
			'desc' => __( 'The number of filter buttons to display in the recommended filter bar.', IT_TEXTDOMAIN ),
			'id' => 'post_recommended_filters_num',
			'target' => 'recommended_filters_number',
			'type' => 'select'
		),
		array(
			'name' => __( 'Disable Recommended Filters', IT_TEXTDOMAIN ),
			'id' => 'post_recommended_filters_disable',
			'options' => array( 'true' => __( 'Disable the filter buttons from the recommended section', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Number of Recommended Posts', IT_TEXTDOMAIN ),
			'desc' => __( 'The number of total posts to display in the recommended section.', IT_TEXTDOMAIN ),
			'id' => 'post_recommended_num',
			'target' => 'recommended_number',
			'type' => 'select'
		),
		array(
			'name' => __( 'Disable Comments', IT_TEXTDOMAIN ),
			'id' => 'post_comments_disable',
			'options' => array( 'true' => __( 'Disable the comments (useful for Facebook comment plugins)', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Author Listing', IT_TEXTDOMAIN ),
			'desc' => __( 'Adjustment options for pages with the "Author Listing" page template assigned.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Boxed', IT_TEXTDOMAIN ),
			'id' => 'author_boxed',
			'options' => array( 'true' => __( 'Contain the page content in a boxed wrapper.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Enable Admins', IT_TEXTDOMAIN ),
			'id' => 'author_admin_enable',
			'options' => array( 'true' => __( 'Allow the admin user role to display in the list', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Hide Empty', IT_TEXTDOMAIN ),
			'id' => 'author_empty_disable',
			'options' => array( 'true' => __( 'Hide authors with zero posts', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Manual Exclude', IT_TEXTDOMAIN ),
			'desc' => __( 'Enter a comma-separated list of usernames to exclude', IT_TEXTDOMAIN ),
			'id' => 'author_exclude',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'User Role', IT_TEXTDOMAIN ),
			'desc' => __( 'Select a user role to display', IT_TEXTDOMAIN ),
			'id' => 'author_role',
			'target' => 'author_role',
			'type' => 'select'
		),
		array(
			'name' => __( 'Order', IT_TEXTDOMAIN ),
			'desc' => __( 'Select how to order the list', IT_TEXTDOMAIN ),
			'id' => 'author_order',
			'target' => 'author_order',
			'type' => 'select'
		),
	
	array(
		'type' => 'tab_end'
	),

	/**
	 * Reviews
	 */
	array(
		'name' => array( 'it_reviews_tab' => $option_tabs ),
		'type' => 'tab_start'
	),

		array(
			'name' => __( 'Details', IT_TEXTDOMAIN ),
			'desc' => __( 'Details are additional descriptive data about the article that you want to list in the overview area. They are different than categories because they are not so much classification data as they are describing data. For instance, if you were writing an article on a movie, a category might be Director and a detail might be Plot Synopsis, because a director can be assigned to multiple movies but a plot synopsis is descriptive only for a single movie. You can of course choose how to use categories and Details however you want for your articles, these are just suggestions to help you understand the difference between them. It is completely up to you.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
			
		array(
			'name' => '',
			'id' => 'review_details',
			'type' => 'details'
		),	
		
		array(
			'name' => __( 'Ratings', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings dictate how you want to rate the articles, if at all.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),		
		array(
			'name' => __( 'Rating Metric', IT_TEXTDOMAIN ),
			'desc' => __( 'The type of rating metric to use', IT_TEXTDOMAIN ),
			'id' => 'review_rating_metric',
			'options' => array( 
				'stars' => __( 'Stars', IT_TEXTDOMAIN ),
				'number' => __( 'Numbers', IT_TEXTDOMAIN ),
				'percentage' => __( 'Percentages', IT_TEXTDOMAIN ),
				'letter' => __( 'Letter Grades', IT_TEXTDOMAIN )
			),
			'default' => 'stars',
			'type' => 'radio'
		),		
		array(
			'name' => __( 'Rating Criteria (automatically averaged into the total score)', IT_TEXTDOMAIN ),
			'id' => 'review_criteria',
			'type' => 'criteria'
		),			
		array(
			'name' => __( 'Disable Editor Ratings', IT_TEXTDOMAIN ),
			'desc' => __( 'This will disable the editor ratings from appearing anywhere in the site.', IT_TEXTDOMAIN ),
			'id' => 'review_editor_rating_disable',
			'options' => array( 'true' => __( 'Do not use editor ratings at all', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Disable User Ratings', IT_TEXTDOMAIN ),
			'desc' => __( 'This will disable the user rating from appearing anywhere in the site.', IT_TEXTDOMAIN ),
			'id' => 'review_user_rating_disable',
			'options' => array( 'true' => __( 'Do not use user ratings at all', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Hide Editor Ratings', IT_TEXTDOMAIN ),
			'desc' => __( 'This should be used if you DO want to use editor ratings but ONLY want them to be visible on the full review page.', IT_TEXTDOMAIN ),
			'id' => 'review_editor_rating_hide',
			'options' => array( 'true' => __( 'Hides editor rating from image overlays', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Hide User Ratings', IT_TEXTDOMAIN ),
			'desc' => __( 'This should be used if you DO want to use user ratings but ONLY want them to be visible on the full review page.', IT_TEXTDOMAIN ),
			'id' => 'review_user_rating_hide',
			'options' => array( 'true' => __( 'Hides user rating from image overlays', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable "Top" User Ratings', IT_TEXTDOMAIN ),
			'desc' => __( 'This will disable th ability for users to rate articles at the top of the article and require them to use the comment system to add their comment.', IT_TEXTDOMAIN ),
			'id' => 'review_top_rating_disable',
			'options' => array( 'true' => __( 'Only allow user ratings from comments (if enabled)', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Ratings Header Label', IT_TEXTDOMAIN ),
			'desc' => __( 'This is the main header that displays at the top of the ratings section.', IT_TEXTDOMAIN ),
			'id' => 'review_ratings_header',
			'htmlentities' => true,
			'type' => 'text'
		),	
		array(
			'name' => __( 'Editor Rating Label', IT_TEXTDOMAIN ),
			'desc' => __( 'This is the header that displays at the top of the editor ratings column.', IT_TEXTDOMAIN ),
			'id' => 'review_editor_header',
			'htmlentities' => true,
			'type' => 'text'
		),	
		array(
			'name' => __( 'User Rating Label', IT_TEXTDOMAIN ),
			'desc' => __( 'This is the header that displays at the top of the user ratings column.', IT_TEXTDOMAIN ),
			'id' => 'review_user_header',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Total Editor Rating Label', IT_TEXTDOMAIN ),
			'desc' => __( 'Used as the label that displays below the total editor rating', IT_TEXTDOMAIN ),
			'id' => 'review_total_editor_label',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Total User Rating Label', IT_TEXTDOMAIN ),
			'desc' => __( 'Used as the label that displays below the total user rating', IT_TEXTDOMAIN ),
			'id' => 'review_total_user_label',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Hide Number of User Ratings', IT_TEXTDOMAIN ),
			'id' => 'review_user_ratings_number_disable',
			'options' => array( 'true' => __( 'Hide number of user ratings next to the total user score label', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Registration Required', IT_TEXTDOMAIN ),
			'desc' => __( 'If you turn this on the theme will keep track of ratings based on WordPress username, otherwise it will use the IP address of the user.', IT_TEXTDOMAIN ),
			'id' => 'review_registered_user_ratings',
			'options' => array( 'true' => __( 'Anonymous users will not be able to add ratings.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings apply to the way review articles display.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Details Position', IT_TEXTDOMAIN ),
			'id' => 'review_details_position',
			'options' => array( 
				'top' => __( 'Above the post content', IT_TEXTDOMAIN ),
				'bottom' => __( 'Below the post content', IT_TEXTDOMAIN ),
				'none' => __( 'Disable details', IT_TEXTDOMAIN ),
			),
			'default' => 'top',
			'type' => 'radio'
		),	
		array(
			'name' => __( 'Ratings Position', IT_TEXTDOMAIN ),
			'id' => 'review_ratings_position',
			'options' => array( 
				'top' => __( 'Above the post content', IT_TEXTDOMAIN ),
				'bottom' => __( 'Below the post content', IT_TEXTDOMAIN ),
				'none' => __( 'Disable details', IT_TEXTDOMAIN ),
			),
			'default' => 'top',
			'type' => 'radio'
		),	
		array(
			'name' => __( 'Positives Label', IT_TEXTDOMAIN ),
			'desc' => __( 'Used as the title for the positives section', IT_TEXTDOMAIN ),
			'id' => 'review_positives_label',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Negatives Label', IT_TEXTDOMAIN ),
			'desc' => __( 'Used as the title for the negatives section', IT_TEXTDOMAIN ),
			'id' => 'review_negatives_label',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Bottom Line Label', IT_TEXTDOMAIN ),
			'desc' => __( 'Used as the title for the bottom line section', IT_TEXTDOMAIN ),
			'id' => 'review_bottomline_label',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Hide Badges', IT_TEXTDOMAIN ),
			'desc' => __( 'If taxonomies, details, and badges are all hidden the entire details box will not be displayed', IT_TEXTDOMAIN ),
			'id' => 'review_badges_hide',
			'options' => array( 'true' => __( 'Hide the listing of badges in the details box', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Hide Details', IT_TEXTDOMAIN ),
			'desc' => __( 'If taxonomies, details, and badges are all hidden the entire details box will not be displayed', IT_TEXTDOMAIN ),
			'id' => 'review_details_hide',
			'options' => array( 'true' => __( 'Hide the listing of details in the details box', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Details Label', IT_TEXTDOMAIN ),
			'desc' => __( 'The title text to display next to the icon in the details section', IT_TEXTDOMAIN ),
			'id' => 'review_details_label',
			'htmlentities' => true,
			'type' => 'text'
		),			
		array(
			'name' => __( 'Disable Comment Ratings', IT_TEXTDOMAIN ),
			'id' => 'review_user_comment_rating_disable',
			'options' => array( 'true' => __( 'Do not allow users to rate articles in the comments', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Comment Pros/Cons', IT_TEXTDOMAIN ),
			'id' => 'review_user_comment_procon_disable',
			'options' => array( 'true' => __( 'Do not allow users to enter pros and cons with their comment', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Allow Blank Comments', IT_TEXTDOMAIN ),
			'desc' => __( 'Use this if you want your users to be able to submit ratings and/or pros/cons without having to additionally enter standard comment text. Only applies if user comment ratings are enabled.', IT_TEXTDOMAIN ),
			'id' => 'review_allow_blank_comments',
			'options' => array( 'true' => __( 'Allow users to post comments without actual comment text', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),

	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Categories
	 */
	array(
		'name' => array( 'it_categories_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
		
		array(
			'name' => __( 'Add attributes to your categories such as icons and colors. First you need to create the category in Posts >> Categories (or while editing posts), then it will become available to select from the drop down lists below so you can add attributes to the category.', IT_TEXTDOMAIN ),
			'id' => 'categories',
			'type' => 'categories'
		),
	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Awards
	 */
	array(
		'name' => array( 'it_awards_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
		
		array(
			'name' => __( 'Create Awards and Badges', IT_TEXTDOMAIN ),
			'desc' => __( 'You can create as many awards and badges as you want here and they will be visible to assign to posts on the post edit screen.', IT_TEXTDOMAIN ),
			'id' => 'review_awards',
			'type' => 'awards'
		),
	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Reactions
	 */
	array(
		'name' => array( 'it_reactions_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
		
		array(
			'name' => __( 'Create the various reactions that your users can interact with for articles', IT_TEXTDOMAIN ),
			'id' => 'reactions',
			'type' => 'reactions'
		),
	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Sidebar
	 */
	array(
		'name' => array( 'it_sidebar_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Create New Sidebar', IT_TEXTDOMAIN ),
			'desc' => __( 'You can create additional sidebars to use. To display your new sidebar then you will need to select it in the &quot;Custom Sidebar&quot; dropdown when editing a post or page.', IT_TEXTDOMAIN ),
			'id' => 'custom_sidebars',
			'type' => 'sidebar'
		),
	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Signoff
	 */
	array(
		'name' => array( 'it_signoff_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Create New Signoff', IT_TEXTDOMAIN ),
			'desc' => __( 'You can create an unlimited number of signoff text areas and then choose the one you want to use for each post.', IT_TEXTDOMAIN ),
			'id' => 'signoff',
			'type' => 'signoff'
		),
	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Advertising
	 */
	array(
		'name' => array( 'it_advertising_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'General', IT_TEXTDOMAIN ),
			'desc' => __( 'Ads that appear on every page.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Header', IT_TEXTDOMAIN ),
			'desc' => __( 'Displays to the right of the logo in the main site header.', IT_TEXTDOMAIN ),
			'id' => 'ad_header',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Responsive', IT_TEXTDOMAIN ),
			'desc' => __( 'If you are using a responsive Google Adsense unit for your header ad you need to turn on this option or else the ad will not display.', IT_TEXTDOMAIN ),
			'id' => 'responsive_header_ad',
			'options' => array( 'true' => __( 'I am using a responsive Adsense unit for my header ad', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Footer', IT_TEXTDOMAIN ),
			'desc' => __( 'Displays above the dark footer container but below the main content wrapper.', IT_TEXTDOMAIN ),
			'id' => 'ad_footer',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		
		array(
			'name' => __( 'Page Builders', IT_TEXTDOMAIN ),
			'desc' => __( 'Ads that appear between page builder panels.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Before Portholes', IT_TEXTDOMAIN ),
			'id' => 'ad_portholes_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Portholes', IT_TEXTDOMAIN ),
			'id' => 'ad_portholes_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Hero', IT_TEXTDOMAIN ),
			'id' => 'ad_hero_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Hero', IT_TEXTDOMAIN ),
			'id' => 'ad_hero_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Grid', IT_TEXTDOMAIN ),
			'id' => 'ad_grid_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Grid', IT_TEXTDOMAIN ),
			'id' => 'ad_grid_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Blog', IT_TEXTDOMAIN ),
			'id' => 'ad_list_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Blog', IT_TEXTDOMAIN ),
			'id' => 'ad_list_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Explicit', IT_TEXTDOMAIN ),
			'id' => 'ad_explicit_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Explicit', IT_TEXTDOMAIN ),
			'id' => 'ad_explicit_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Headliner', IT_TEXTDOMAIN ),
			'id' => 'ad_headliner_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Headliner', IT_TEXTDOMAIN ),
			'id' => 'ad_headliner_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Connect', IT_TEXTDOMAIN ),
			'id' => 'ad_connect_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Connect', IT_TEXTDOMAIN ),
			'id' => 'ad_connect_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Widgets', IT_TEXTDOMAIN ),
			'id' => 'ad_widgets_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Widgets', IT_TEXTDOMAIN ),
			'id' => 'ad_widgets_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Top Ten', IT_TEXTDOMAIN ),
			'id' => 'ad_topten_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Top Ten', IT_TEXTDOMAIN ),
			'id' => 'ad_topten_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Trending', IT_TEXTDOMAIN ),
			'id' => 'ad_trending_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Trending', IT_TEXTDOMAIN ),
			'id' => 'ad_trending_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Utility Menu', IT_TEXTDOMAIN ),
			'id' => 'ad_utility_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Utility Menu', IT_TEXTDOMAIN ),
			'id' => 'ad_utility_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Custom HTML', IT_TEXTDOMAIN ),
			'id' => 'ad_html_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Custom HTML', IT_TEXTDOMAIN ),
			'id' => 'ad_html_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Directory', IT_TEXTDOMAIN ),
			'id' => 'ad_directory_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Directory', IT_TEXTDOMAIN ),
			'id' => 'ad_directory_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		
		array(
			'name' => __( 'Single Posts', IT_TEXTDOMAIN ),
			'desc' => __( 'Ads that appear only on single posts.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Before Billboard', IT_TEXTDOMAIN ),
			'desc' => __( 'Displays above the large billboard header for billboard style posts only.', IT_TEXTDOMAIN ),
			'id' => 'ad_billboard_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Billboard', IT_TEXTDOMAIN ),
			'desc' => __( 'Displays below the large billboard header for billboard style posts only.', IT_TEXTDOMAIN ),
			'id' => 'ad_billboard_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Control Bar', IT_TEXTDOMAIN ),
			'desc' => __( 'Displays above the control bar on single posts.', IT_TEXTDOMAIN ),
			'id' => 'ad_controlbar_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Control Bar', IT_TEXTDOMAIN ),
			'desc' => __( 'Displays below the control bar on single posts.', IT_TEXTDOMAIN ),
			'id' => 'ad_controlbar_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Title', IT_TEXTDOMAIN ),
			'desc' => __( 'Displays above the main title on single posts for standard style posts only.', IT_TEXTDOMAIN ),
			'id' => 'ad_title_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Title', IT_TEXTDOMAIN ),
			'desc' => __( 'Displays below the main title on single posts for standard style posts only.', IT_TEXTDOMAIN ),
			'id' => 'ad_title_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Content Container', IT_TEXTDOMAIN ),
			'desc' => __( 'Displays above all of the post content but under the main title.', IT_TEXTDOMAIN ),
			'id' => 'ad_main_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Content Container', IT_TEXTDOMAIN ),
			'desc' => __( 'Displays below all of the post content.', IT_TEXTDOMAIN ),
			'id' => 'ad_main_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Featured Video', IT_TEXTDOMAIN ),
			'id' => 'ad_video_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Featured Video', IT_TEXTDOMAIN ),
			'id' => 'ad_video_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Featured Image', IT_TEXTDOMAIN ),
			'id' => 'ad_image_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Featured Image', IT_TEXTDOMAIN ),
			'id' => 'ad_image_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Contents Menu', IT_TEXTDOMAIN ),
			'id' => 'ad_contents_menu_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Contents Menu', IT_TEXTDOMAIN ),
			'id' => 'ad_contents_menu_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Details', IT_TEXTDOMAIN ),
			'id' => 'ad_details_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Details', IT_TEXTDOMAIN ),
			'id' => 'ad_details_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Rating Criteria', IT_TEXTDOMAIN ),
			'id' => 'ad_criteria_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Rating Criteria', IT_TEXTDOMAIN ),
			'id' => 'ad_criteria_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Content', IT_TEXTDOMAIN ),
			'desc' => __( 'Displays just before the main post content but after upper post components such as featured image and contents menu.', IT_TEXTDOMAIN ),
			'id' => 'ad_content_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Content', IT_TEXTDOMAIN ),
			'desc' => __( 'Displays just after the main post content but before lower post components such as recommended and comments.', IT_TEXTDOMAIN ),
			'id' => 'ad_content_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Post Info', IT_TEXTDOMAIN ),
			'id' => 'ad_postinfo_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Post Info', IT_TEXTDOMAIN ),
			'id' => 'ad_postinfo_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Recommended', IT_TEXTDOMAIN ),
			'id' => 'ad_recommended_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Recommended', IT_TEXTDOMAIN ),
			'id' => 'ad_recommended_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Comments', IT_TEXTDOMAIN ),
			'id' => 'ad_comments_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Comments', IT_TEXTDOMAIN ),
			'id' => 'ad_comments_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Background Ad URL', IT_TEXTDOMAIN ),
			'desc' => __( 'The URL to direct the user to when they click anywhere on the background. Leave this blank to disable it. For the image to use for the ad, use the page background image URL options.', IT_TEXTDOMAIN ),
			'id' => 'ad_background',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Post Loops', IT_TEXTDOMAIN ),
			'desc' => __( 'These ads will get injected into your post loops (article listing pages)', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'AJAX Ads', IT_TEXTDOMAIN ),
			'desc' => __( 'You should turn this off if you are using an ad vendor that does not allow ads to display on dynamically-generated pages such as Google Adsense.', IT_TEXTDOMAIN ),
			'id' => 'ad_ajax',
			'options' => array( 'true' => __( 'Display ads on AJAX (dynamically-loaded) pages.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Shuffle', IT_TEXTDOMAIN ),
			'id' => 'ad_shuffle',
			'options' => array( 'true' => __( 'Shuffle the display of the ads', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Number of Ads', IT_TEXTDOMAIN ),
			'desc' => __( 'The total number of ads to display in the loop regardless of how many ad slots are filled out below', IT_TEXTDOMAIN ),
			'id' => 'ad_num',
			'target' => 'ad_number',
			'type' => 'select'
		),
		array(
			'name' => __( 'Increment', IT_TEXTDOMAIN ),
			'desc' => __( 'Display an ad every Nth post. For instance, if "3" is selected, every 3rd post will be an ad.', IT_TEXTDOMAIN ),
			'id' => 'ad_increment',
			'target' => 'ad_number',
			'nodisable' => true,
			'type' => 'select'
		),
		array(
			'name' => __( 'Off-set', IT_TEXTDOMAIN ),
			'desc' => __( 'Number of posts to display before the first ad appears', IT_TEXTDOMAIN ),
			'id' => 'ad_offset',
			'target' => 'ad_number',
			'type' => 'select'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'desc' => __( 'Enter the HTML for the ad here', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_1',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_2',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_3',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_4',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_5',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_6',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_7',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_8',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_9',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_10',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		
		
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Footer
	 */
	array(
		'name' => array( 'it_footer_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'You can select any type of layout you want for the footer columns.', IT_TEXTDOMAIN ),
			'id' => 'footer_layout',
			'options' => array(
				'a' => THEME_ADMIN_ASSETS_URI . '/images/footer_a.png',
				'b' => THEME_ADMIN_ASSETS_URI . '/images/footer_b.png',
				'c' => THEME_ADMIN_ASSETS_URI . '/images/footer_c.png',
				'd' => THEME_ADMIN_ASSETS_URI . '/images/footer_d.png',
				'e' => THEME_ADMIN_ASSETS_URI . '/images/footer_e.png',
				'f' => THEME_ADMIN_ASSETS_URI . '/images/footer_f.png',
				'g' => THEME_ADMIN_ASSETS_URI . '/images/footer_g.png',
				'h' => THEME_ADMIN_ASSETS_URI . '/images/footer_h.png',
				'i' => THEME_ADMIN_ASSETS_URI . '/images/footer_i.png',
				'j' => THEME_ADMIN_ASSETS_URI . '/images/footer_j.png',
				'k' => THEME_ADMIN_ASSETS_URI . '/images/footer_k.png',
				'l' => THEME_ADMIN_ASSETS_URI . '/images/footer_l.png',
				'm' => THEME_ADMIN_ASSETS_URI . '/images/footer_m.png',
				'n' => THEME_ADMIN_ASSETS_URI . '/images/footer_n.png',
				'o' => THEME_ADMIN_ASSETS_URI . '/images/footer_o.png',
				'p' => THEME_ADMIN_ASSETS_URI . '/images/footer_p.png',
				'q' => THEME_ADMIN_ASSETS_URI . '/images/footer_q.png',
				'r' => THEME_ADMIN_ASSETS_URI . '/images/footer_r.png',
				's' => THEME_ADMIN_ASSETS_URI . '/images/footer_s.png',
				't' => THEME_ADMIN_ASSETS_URI . '/images/footer_t.png',
				'u' => THEME_ADMIN_ASSETS_URI . '/images/footer_u.png',
				'v' => THEME_ADMIN_ASSETS_URI . '/images/footer_v.png',
				'w' => THEME_ADMIN_ASSETS_URI . '/images/footer_w.png',
				'x' => THEME_ADMIN_ASSETS_URI . '/images/footer_x.png',
				'y' => THEME_ADMIN_ASSETS_URI . '/images/footer_y.png',
				'z' => THEME_ADMIN_ASSETS_URI . '/images/footer_z.png',
				'aa' => THEME_ADMIN_ASSETS_URI . '/images/footer_aa.png',
				'ab' => THEME_ADMIN_ASSETS_URI . '/images/footer_ab.png',
				'ac' => THEME_ADMIN_ASSETS_URI . '/images/footer_ac.png',
				'ad' => THEME_ADMIN_ASSETS_URI . '/images/footer_ad.png',
			),
			'default' => 'd',
			'type' => 'layout'
		),
		array(
			'name' => __( 'Disable Footer', IT_TEXTDOMAIN ),
			'id' => 'footer_disable',
			'options' => array( 'true' => __( 'Completely disable the entire footer area', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Copyright Text', IT_TEXTDOMAIN ),
			'desc' => __( 'This will overwrite the default automatic copyright text in the left of the subfooter.', IT_TEXTDOMAIN ),
			'id' => 'copyright_text',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),		
		array(
			'name' => __( 'Credits Text', IT_TEXTDOMAIN ),
			'desc' => __( 'This will overwrite the default automatic credits text in the right of the subfooter.', IT_TEXTDOMAIN ),
			'id' => 'credits_text',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Disable Subfooter', IT_TEXTDOMAIN ),
			'id' => 'subfooter_disable',
			'options' => array( 'true' => __( 'Disable the subfooter area which holds the copyright info', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Sociable
	 */
	array(
		'name' => array( 'it_sociable_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Feedburner Feed ID', IT_TEXTDOMAIN ),
			'desc' => __( 'Necessary for the newsletter signup form to function properly. This article explains how to find your feedburner feed name: http://netprofitstoday.com/blog/how-to-find-your-feedburner-id/', IT_TEXTDOMAIN ),
			'id' => 'feedburner_name',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		
		array(
			'name' => __( 'RSS Feed URL', IT_TEXTDOMAIN ),
			'desc' => __( 'Necessary to connect an RSS button to your actual RSS feed URL.', IT_TEXTDOMAIN ),
			'id' => 'rss_url',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		
		array(
			'name' => __( 'Twitter Username', IT_TEXTDOMAIN ),
			'desc' => __( 'Not a full URL, just your Twitter username.', IT_TEXTDOMAIN ),
			'id' => 'twitter_username',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		
		array(
			'name' => __( 'Pinterest User URL', IT_TEXTDOMAIN ),
			'desc' => __( 'The URL for your user profile on Pinterest', IT_TEXTDOMAIN ),
			'id' => 'pinterest_url',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		
		array(
			'name' => __( 'Google+ Profile URL', IT_TEXTDOMAIN ),
			'desc' => __( "Your actual Google+ profile URL. This is the link users are taken to when they click on the Google+ social count and it is also used to generate your Google+ follower count.", IT_TEXTDOMAIN ),
			'id' => 'googleplus_profile_url',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),	
		
		array(
			'name' => __( 'Youtube User ID', IT_TEXTDOMAIN ),
			'desc' => __( 'To find your ID, sign in to YouTube and check your Advanced Account Settings page. You will see your ID listed in the Account Information section.', IT_TEXTDOMAIN ),
			'id' => 'youtube_username',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),	
		
		array(
			'name' => __( 'Youtube URL', IT_TEXTDOMAIN ),
			'desc' => __( 'When users click on the subscriber count in your social counts widget they will be taken to this URL.', IT_TEXTDOMAIN ),
			'id' => 'youtube_url',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),	
		
		array(
			'name' => __( 'Facebook Widget Settings', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings apply to the Facebook tab in the Social Tabs widget.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		
		array(
			'name' => __( 'Facebook Page URL', IT_TEXTDOMAIN ),
			'desc' => __( 'The URL of your Facebook page', IT_TEXTDOMAIN ),
			'id' => 'facebook_url',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		
		array(
			'name' => __( 'Color Scheme', IT_TEXTDOMAIN ),
			'desc' => __( 'Light is better for light backgrounds, dark is better for dark backgrounds', IT_TEXTDOMAIN ),
			'id' => 'facebook_color_scheme',
			'options' => array( 
				'light' => __( 'Light', IT_TEXTDOMAIN ),
				'dark' => __( 'Dark', IT_TEXTDOMAIN )
			),
			'type' => 'radio'
		),
		
		array(
			'name' => __( 'Show Faces', IT_TEXTDOMAIN ),
			'id' => 'facebook_show_faces',
			'options' => array( 'true' => __( 'Show profile photos at the bottom', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Show Stream', IT_TEXTDOMAIN ),
			'id' => 'facebook_stream',
			'options' => array( 'true' => __( 'Show the profile stream for the public profile', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Show Header', IT_TEXTDOMAIN ),
			'id' => 'facebook_show_header',
			'options' => array( 'true' => __( 'Show the "Find us on Facebook" bar at the top', IT_TEXTDOMAIN ) ),
			'desc' => __( 'Note: this only displays if either the stream or faces are displayed.', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Border Color', IT_TEXTDOMAIN ),
			'desc' => __( 'The color of the borders around the Like Box', IT_TEXTDOMAIN ),
			'id' => 'facebook_border_color',
			'type' => 'color'
		),			
		
		array(
			'name' => __( 'Twitter Widget Settings', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings apply to the Twitter tab in the Social Tabs widget.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Twitter Widget Code', IT_TEXTDOMAIN ),
			'desc' => __( 'Go to https://twitter.com/settings/widgets and create a new widget. Then put the generated widget code into this box.', IT_TEXTDOMAIN ),
			'id' => 'twitter_widget_code',
			'default' => '',
			'type' => 'textarea'
		),
		
		array(
			'name' => __( 'Flickr Widget Settings', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings apply to the Flickr tab in the Social Tabs widget.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		
		array(
			'name' => __( 'Flickr Account ID', IT_TEXTDOMAIN ),
			'desc' => __( 'Your Flickr Account ID. Use this service to find it: http://idgettr.com/', IT_TEXTDOMAIN ),
			'id' => 'flickr_id',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		
		array(
			'name' => __( 'Number of Photos', IT_TEXTDOMAIN ),
			'desc' => __( 'The number of photos to display in the widget.', IT_TEXTDOMAIN ),
			'id' => 'flickr_number',
			'target' => 'flickr_number',
			'type' => 'select'
		),
		
		array(
			'name' => __( 'Social Badges', IT_TEXTDOMAIN ),
			'desc' => __( 'These social badges appear in the header of your site next to the logo.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
	
		array(
			'name' => __( 'Social Badges', IT_TEXTDOMAIN ),
			'desc' => __( 'Social Badges', IT_TEXTDOMAIN ),
			'id' => 'sociable',
			'type' => 'sociable'
		),
		
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Advanced
	 */
	array(
		'name' => array( 'it_advanced_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Custom Admin Logo', IT_TEXTDOMAIN ),
			'desc' => __( 'Upload an image to replace the default theme logo.', IT_TEXTDOMAIN ),
			'id' => 'admin_logo_url',
			'type' => 'upload'
		),
		array(
			'name' => __( 'Disable Image Sizes', IT_TEXTDOMAIN ),
			'desc' => __( 'If you are not using an image size anywhere in your theme and you want to block WordPress from creating an additional image for that size, you can selectively turn off creation of these images here.', IT_TEXTDOMAIN ),
			'id' => 'image_size_disable',
			'options' => array(
				'micro' => __('Micro - smallest sized thumbnails in widgets',IT_TEXTDOMAIN),
				'tiny' => __('Tiny - circle thumbnails in the hero slider',IT_TEXTDOMAIN),
				'menu' => __('Menu - thumbnails in mega menu',IT_TEXTDOMAIN),
				'menu-large' => __('Large Menu - thumbnails in mega menu when left nav is hidden',IT_TEXTDOMAIN),
				'portholes' => __('Backgrounds - dim background images used in portholes and other areas',IT_TEXTDOMAIN),
				'circle-large' => __('Porholes - circle images used in portholes',IT_TEXTDOMAIN),
				'grid-3' => __('Grid 3 - post loop thumbnail images',IT_TEXTDOMAIN),
				'grid-4' => __('Grid 4 - smaller post loop thumbnail images',IT_TEXTDOMAIN),
				'hero' => __('Hero slider',IT_TEXTDOMAIN),
				'hero-wide' => __('Hero slider (Wide) - used when the right info column is hidden',IT_TEXTDOMAIN),
				'wide' => __('Headliner content area',IT_TEXTDOMAIN),
				'tall' => __('Explicit slider',IT_TEXTDOMAIN),
				'single-180' => __('Small Single Post/Page Featured Image',IT_TEXTDOMAIN),
				'single-360' => __('Medium Single Post/Page Featured Image',IT_TEXTDOMAIN),
				'single-790' => __('Large Single Post/Page Featured Image',IT_TEXTDOMAIN),
				'single-1095' => __('Full-Width Single Post/Page Featured Image',IT_TEXTDOMAIN)
			),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Import Options', IT_TEXTDOMAIN ),
			'desc' => __( 'Copy your export code here to import your theme settings.', IT_TEXTDOMAIN ),
			'id' => 'import_options',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Export Options', IT_TEXTDOMAIN ),
			'desc' => __( 'When moving your site to a new Wordpress installation you can export your theme settings here.', IT_TEXTDOMAIN ),
			'id' => 'export_options',
			'type' => 'export_options'
		),
		
		/*array(
			'name' => __( 'Custom Homepage Content', IT_TEXTDOMAIN ),
			'desc' => __( 'You can add some custom content to your homepage. This will display above the post loop on the homepage.', IT_TEXTDOMAIN ),
			'id' => 'homepage_content',
			'type' => 'editor'
		),*/
		
		array(
			'name' => __( 'Disable Unique Views', IT_TEXTDOMAIN ),
			'desc' => __( 'This turns off the ip address check so that every time a page is accessed the view count increments by one.', IT_TEXTDOMAIN ),
			'id' => 'unique_views_disable',
			'options' => array( 'true' => __( 'Post views will increment on every page view', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Allow Unlimited User Ratings', IT_TEXTDOMAIN ),
			'desc' => __( 'This is only for development/testing purposes and will continually add user ratings and re-average the total score each time a user rates a criteria.', IT_TEXTDOMAIN ),
			'id' => 'rating_limit_disable',
			'options' => array( 'true' => __( 'TESTING PURPOSES ONLY', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		
		array(
			'name' => __( 'Allow Unlimited User Reactions', IT_TEXTDOMAIN ),
			'desc' => __( 'This is only for development/testing purposes and will continually stack reactions when users click the reaction buttons instead of "switching" their existing reaction.', IT_TEXTDOMAIN ),
			'id' => 'reaction_limit_disable',
			'options' => array( 'true' => __( 'TESTING PURPOSES ONLY', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		
		array(
			'name' => __( 'Disable Social Click Tracking', IT_TEXTDOMAIN ),
			'id' => 'click_track_disable',
			'options' => array( 'true' => __( 'Disable the click tracking for the social sharing links on pages and posts', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),
			
	array(
		'type' => 'tab_end'
	),
	
);

# add woocommerce options
if(function_exists('is_woocommerce')) {
	$woocommerce_options = array(			
		array(
			'name' => array( 'it_woocommerce_tab' => $option_tabs ),
			'type' => 'tab_start'
		),
		array(
			'name' => __( '', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings apply to all WooCommerce related pages.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Disable Breadcrumbs', IT_TEXTDOMAIN ),
			'id' => 'woo_breadcrumb_disable',
			'options' => array( 'true' => __( 'Disable the breadcrumb navigation from all woocommerce pages', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Show Above', IT_TEXTDOMAIN ),
			'desc' => __( 'Select which page builder components you want to display above the main content of all WooCommerce pages.', IT_TEXTDOMAIN ),
			'id' => 'woo_above_builder',
			'type' => 'builder'
		),
		array(
			'name' => __( 'Show Below', IT_TEXTDOMAIN ),
			'desc' => __( 'Select which page builder components you want to display below the main content of all WooCommerce pages.', IT_TEXTDOMAIN ),
			'id' => 'woo_below_builder',
			'type' => 'builder'
		),	
		array(
			'name' => __( 'Boxed', IT_TEXTDOMAIN ),
			'id' => 'woo_boxed',
			'options' => array( 'true' => __( 'Contain the page content in a boxed wrapper.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'You can specify a layout with or without a sidebar.', IT_TEXTDOMAIN ),
			'id' => 'woo_layout',
			'options' => array(
				'sidebar-right' => THEME_ADMIN_ASSETS_URI . '/images/footer_g.png',
				'sidebar-left' => THEME_ADMIN_ASSETS_URI . '/images/footer_k.png',
				'full' => THEME_ADMIN_ASSETS_URI . '/images/footer_a.png',				
			),
			'default' => 'sidebar-right',
			'type' => 'layout'
		),
		array(
			'name' => __( 'Use "WooCommerce" Sidebar', IT_TEXTDOMAIN ),
			'id' => 'woo_sidebar_unique',
			'options' => array( 'true' => __( 'Use the "WooCommerce" instead of the "Page" sidebar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'type' => 'tab_end'
		)
		
	);
	
	$options = array_merge($options,$woocommerce_options);
}

# add buddypress options
if(function_exists('bp_current_component') || function_exists('is_bbpress')) {
	$buddypress_options = array(			
		array(
			'name' => array( 'it_buddypress_tab' => $option_tabs ),
			'type' => 'tab_start'
		),
		array(
			'name' => __( '', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings apply to all BuddyPress and bbPress related pages unless otherwise noted.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Page Builder', IT_TEXTDOMAIN ),
			'id' => 'bp_builder',
			'type' => 'builder'
		),	
		array(
			'name' => __( 'Boxed', IT_TEXTDOMAIN ),
			'id' => 'bp_boxed',
			'options' => array( 'true' => __( 'Contain the page content in a boxed wrapper.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'You can specify a layout with or without a sidebar.', IT_TEXTDOMAIN ),
			'id' => 'bp_layout',
			'options' => array(
				'sidebar-right' => THEME_ADMIN_ASSETS_URI . '/images/footer_g.png',
				'sidebar-left' => THEME_ADMIN_ASSETS_URI . '/images/footer_k.png',
				'full' => THEME_ADMIN_ASSETS_URI . '/images/footer_a.png',				
			),
			'default' => 'sidebar-right',
			'type' => 'layout'
		),
		array(
			'name' => __( 'Use "BuddyPress" Sidebar', IT_TEXTDOMAIN ),
			'id' => 'bp_sidebar_unique',
			'options' => array( 'true' => __( 'Use the "BuddyPress" instead of the "Page" sidebar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Use WordPress Registration', IT_TEXTDOMAIN ),
			'id' => 'bp_register_disable',
			'desc' => __( 'Turn this on if you want to be able to use the registration form in the sticky bar. Otherwise the register link in the sticky bar will redirect the user to the BuddyPress registration page.', IT_TEXTDOMAIN ),
			'options' => array( 'true' => __( 'Enables registration directly from the sticky bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'type' => 'tab_end'
		)
		
	);
	
	$options = array_merge($options,$buddypress_options);
}

return array(
	'load' => true,
	'name' => 'options',
	'options' => $options
);
	
?>
