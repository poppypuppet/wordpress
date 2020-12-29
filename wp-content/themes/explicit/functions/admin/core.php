<?php
/**
 *
 */
function it_options_init() {
	register_setting( IT_SETTINGS, IT_SETTINGS );
	
	# Add default options if they don't exist
	add_option( IT_SETTINGS, it_options( 'settings', 'default' ) );
	add_option( IT_INTERNAL_SETTINGS, it_options( 'internal', 'default' ) );
	# delete_option(IT_SETTINGS);
	# delete_option(IT_INTERNAL_SETTINGS);
	
	if( it_ajax_request() ) {
		# Ajax option save
		if( isset( $_POST['it_option_save'] ) ) {
			it_ajax_option_save();
			
		# Sidebar option save
		} elseif( isset( $_POST['it_sidebar_save'] ) ) {
			it_sidebar_option_save();
			
		} elseif( isset( $_POST['it_sidebar_delete'] ) ) {
			it_sidebar_option_delete();
						
		} elseif( isset( $_POST['action'] ) && $_POST['action'] == 'add-menu-item' ) {
			add_filter( 'nav_menu_description', create_function('','return "";') );
		}
	}
	
	# Option import
	if( ( !it_ajax_request() ) && ( isset( $_POST['it_import_options'] ) ) ) {
		it_import_options( $_POST[IT_SETTINGS]['import_options'] );

	# Reset options
	} elseif( ( !it_ajax_request() ) && ( isset( $_POST[IT_SETTINGS]['reset'] ) ) ) {
		it_load_defaults();
		wp_redirect( admin_url( 'admin.php?page=it-options&reset=true' ) );
		exit;
		
	# load demo settings
	} elseif( ( !it_ajax_request() ) && ( isset( $_POST[IT_SETTINGS]['load_demo'] ) ) ) {
		it_load_demo();
		wp_redirect( admin_url( 'admin.php?page=it-options&demo=true' ) );
		exit;
		
	# $_POST option save
	} elseif( ( !it_ajax_request() ) && ( isset( $_POST['it_admin_wpnonce'] ) ) ) {
		unset(  $_POST[IT_SETTINGS]['export_options'] );
	}
	
}

/**
 *
 */
function it_sidebar_option_delete() {
	check_ajax_referer( IT_SETTINGS . '_wpnonce', 'it_admin_wpnonce' );
	
	$data = $_POST;
	
	$saved_sidebars = get_option( IT_SIDEBARS );
	
	$msg = array( 'success' => false, 'sidebar_id' => $data['sidebar_id'], 'message' => sprintf( __( 'Error: Sidebar &quot;%1$s&quot; not deleted, please try again.', IT_TEXTDOMAIN ), $data['it_sidebar_delete'] ) );
	
	unset( $saved_sidebars[$data['sidebar_id']] );
	
	if( update_option( IT_SIDEBARS, $saved_sidebars ) ) {
		$msg = array( 'success' => 'deleted_sidebar', 'sidebar_id' => $data['sidebar_id'], 'message' => sprintf( __( 'Sidebar &quot;%1$s&quot; Deleted.', IT_TEXTDOMAIN ), $data['it_sidebar_delete'] ) );
	}
	
	$echo = json_encode( $msg );

	@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
	echo $echo;
	exit;
}

/**
 *
 */
function it_sidebar_option_save() {
	check_ajax_referer( IT_SETTINGS . '_wpnonce', 'it_admin_wpnonce' );
	
	$data = $_POST;
	
	$saved_sidebars = get_option( IT_SIDEBARS );
	
	$msg = array( 'success' => false, 'sidebar' => $data['custom_sidebars'], 'message' => sprintf( __( 'Error: Sidebar &quot;%1$s&quot; not saved, please try again.', IT_TEXTDOMAIN ), $data['custom_sidebars'] ) );
	
	if( empty( $saved_sidebars ) ) {
		$update_sidebar[$data['it_sidebar_id']] = $data['custom_sidebars'];
		
		if( update_option( IT_SIDEBARS, $update_sidebar ) )
			$msg = array( 'success' => 'saved_sidebar', 'sidebar' => $data['custom_sidebars'], 'sidebar_id' => $data['it_sidebar_id'], 'message' => sprintf( __( 'Sidebar &quot;%1$s&quot; Added.', IT_TEXTDOMAIN ), $data['custom_sidebars'] ) );
		
	} elseif( is_array( $saved_sidebars ) ) {
		
		if( in_array( $data['custom_sidebars'], $saved_sidebars ) ) {
			$msg = array( 'success' => false, 'sidebar' => $data['custom_sidebars'], 'message' => sprintf( __( 'Sidebar &quot;%1$s&quot; Already Exists.', IT_TEXTDOMAIN ), $data['custom_sidebars'] ) );
			
		} elseif( !in_array( $data['custom_sidebars'], $saved_sidebars ) ) {
			$sidebar[$data['it_sidebar_id']] = $data['custom_sidebars'];
			$update_sidebar = $saved_sidebars + $sidebar;
			
			if( update_option( IT_SIDEBARS, $update_sidebar ) )
				$msg = array( 'success' => 'saved_sidebar', 'sidebar' => $data['custom_sidebars'], 'sidebar_id' => $data['it_sidebar_id'], 'message' => sprintf( __( 'Sidebar &quot;%1$s&quot; Added.', IT_TEXTDOMAIN ), $data['custom_sidebars'] ) );
			
		}
	}
		
	$echo = json_encode( $msg );

	@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
	echo $echo;
	exit;
}

/**
 *
 */
function it_ajax_option_save() {
	check_ajax_referer( IT_SETTINGS . '_wpnonce', 'it_admin_wpnonce' );
	
	$data = it_prep_data($_POST);
	
	$count = count($_POST, COUNT_RECURSIVE);
	
	unset( $data['_wp_http_referer'], $data['_wpnonce'], $data['action'], $data['it_full_submit'], $data[IT_SETTINGS]['export_options'] );
	unset( $data['it_admin_wpnonce'], $data['it_option_save'], $data['option_page'] );
	
	$msg = array( 'success' => false, 'message' => __( 'Error: Options not saved, please try again.', IT_TEXTDOMAIN ) );
	
	if( get_option( IT_SETTINGS ) != $data[IT_SETTINGS] ) {
		
		if( update_option( IT_SETTINGS, $data[IT_SETTINGS] ) )
			$msg = array( 'success' => 'options_saved', 'message' => $count . __( ' Total Options Saved.', IT_TEXTDOMAIN ) );
			
	} else {
		$msg = array( 'success' => true, 'message' => $count . __( ' Total Options Saved.', IT_TEXTDOMAIN ) );
	}
	
	$echo = json_encode( $msg );

	@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
	echo $echo;
	exit;
}

/**
 * 
 */
function it_shortcode_generator() {

	$shortcodes = it_shortcodes();
	
	$options = array();
	
	foreach( $shortcodes as $shortcode ) {
		$shortcode = str_replace( '.php', '',$shortcode );
		$shortcode = preg_replace( '/[0-9-]/', '', $shortcode );
		
		if( $shortcode[0] != '_' ) {
			$class = 'it' . ucwords( $shortcode );
			$options[] = call_user_func( array( &$class, '_options'), $class );
		}
	}
	
	return $options;
}

/**
 *
 */
function it_check_wp_version(){
	global $wp_version;
	
	$check_WP = '3.7';
	$is_ok = version_compare($wp_version, $check_WP, '>=');
	
	if ( ($is_ok == FALSE) ) {
		return false;
	}
	
	return true;
}

/**
 * 
 */
function it_sociable_option() {
	$sociables = array(
		'twitter' => 'Twitter',
		'facebook' => 'Facebook',
		'googleplus' => 'Google+',
		'pinterest' => 'Pinterest',
		'vimeo' => 'Vimeo',
		'tumblr' => 'Tumblr',
		'instagram' => 'Instagram',
		'flickr' => 'Flickr',
		'youtube' => 'Youtube',
		'linkedin' => 'LinkedIn',
		'stumbleupon' => 'StumbleUpon',
		'skype' => 'Skype'
		);
	
	return array( 'sociables' => $sociables );
}

/**
 * 
 */
function it_reactions_option() {
	$reactions = array(
		'' => __('Choose One...',IT_TEXTDOMAIN),
		'emo-happy' => __('Happy',IT_TEXTDOMAIN),
		'emo-squint' => __('Glad',IT_TEXTDOMAIN),
		'emo-grin' => __('Elated',IT_TEXTDOMAIN),
		'emo-wink' => __('Wink',IT_TEXTDOMAIN),
		'emo-wink2' => __('Wink 2',IT_TEXTDOMAIN),
		'emo-thumbsup' => __('Thumbs Up',IT_TEXTDOMAIN),
		'emo-laugh' => __('Laugh',IT_TEXTDOMAIN),
		'emo-sunglasses' => __('Cool',IT_TEXTDOMAIN),
		'emo-beer' => __('Cheers!',IT_TEXTDOMAIN),
		'emo-coffee' => __('Coffee',IT_TEXTDOMAIN),
		'emo-tongue' => __('Tongue Out',IT_TEXTDOMAIN),
		'emo-saint' => __('Halo',IT_TEXTDOMAIN),
		'emo-sleep' => __('Sleep',IT_TEXTDOMAIN),
		'emo-displeased' => __('Unsure',IT_TEXTDOMAIN),
		'emo-surprised' => __('Surprised',IT_TEXTDOMAIN),
		'emo-unhappy' => __('Sad',IT_TEXTDOMAIN),
		'emo-cry' => __('Cry',IT_TEXTDOMAIN),
		'emo-angry' => __('Angry',IT_TEXTDOMAIN),
		'emo-shoot' => __('Gun',IT_TEXTDOMAIN),
		'emo-devil' => __('Devil',IT_TEXTDOMAIN)
		);
	
	return array( 'reactions' => $reactions );
}

/**
 *
 */
function it_signoffs() {
	$signoff = it_get_setting('signoff');
	$options = array();	
	if ( isset($signoff['keys']) && $signoff['keys'] != '#' ) {
		$signoff_keys = explode(',',$signoff['keys']);
		foreach ($signoff_keys as $skey) {
			if ( $skey != '#') {
				$signoff_name = ( !empty( $signoff[$skey]['name'] ) ) ? $signoff[$skey]['name'] : '#';	
				$options[$signoff_name] = $signoff_name;	
			}
		}
	}
	return $options;
}

/**
 *
 */
function it_awards_meta() {	
	$awards = it_get_setting('review_awards');
	$options = array();				
	foreach($awards as $award) {	
		if(isset($award[0]) && is_object($award[0])) {
			$name = stripslashes($award[0]->name);
			$meta_name = $award[0]->meta_name;
			$icon = $award[0]->icon;
			$isBadge = $award[0]->isBadge;
			if(!empty($name) && empty($isBadge)) {
				$options[$meta_name] = array('name' => $name, 'icon' => $icon);
			}
		}
	}	
	return $options;
}

/**
 *
 */
function it_badges_meta() {	
	$awards = it_get_setting('review_awards');	
	$options = array();			
	foreach($awards as $award) {	
		if(isset($award[0]) && is_object($award[0])) {
			$name = stripslashes($award[0]->name);
			$meta_name = $award[0]->meta_name;
			$icon = $award[0]->icon;
			$isBadge = $award[0]->isBadge;
			if(!empty($name) && !empty($isBadge)) {
				$options[$meta_name] = array('name' => $name, 'icon' => $icon);
			}
		}
	}	
	return $options;
}

/**
 *
 */
function it_reactions_meta() {
	$reactions = it_get_setting('reactions');
	$options = array();
	if ( isset($reactions['keys']) && $reactions['keys'] != '#' ) {
		$reactions_keys = explode(',',$reactions['keys']);
		foreach ($reactions_keys as $rkey) {
			if ( $rkey != '#') {				
				$reaction_name = ( !empty( $reactions[$rkey]['name'] ) ) ? $reactions[$rkey]['name'] : '#';	
				$reaction_slug = ( !empty( $reactions[$rkey]['slug'] ) ) ? $reactions[$rkey]['slug'] : '#';	
				$reaction_icon = ( !empty( $reactions[$rkey]['icon'] ) ) ? $reactions[$rkey]['icon'] : '#';	
				$reaction_preset = ( !empty( $reactions[$rkey]['preset'] ) ) ? $reactions[$rkey]['preset'] : '#';				
				if($reaction_icon=='#') {
					$icon = '<span class="theme-icon-' . $reaction_preset . ' meta-icon"></span>';
				} else {
					$icon = '<span class="meta-icon"><img src="' . $reaction_icon . '" /></span>';
				}
				$options[$reaction_slug] = array('name' => $reaction_name, 'icon' => $icon);
			}
		}
	}	
	return $options;
}

/**
 * 
 */
function it_tinymce_init_size() {
	if( isset( $_GET['page'] ) ) {
		if( $_GET['page'] == 'it-options' ) {
			$tinymce = 'TinyMCE_' . IT_SETTINGS . '_content_size';
			if( !isset( $_COOKIE[$tinymce] ) )
				setcookie($tinymce, 'cw=577&ch=251');
		}
	}
}

/**
 *
 */
function it_import_options( $import ) {
	
	$imported_options = it_decode( $import, $serialize = true );
	
	if( is_array( $imported_options ) ) {
		
		if( array_key_exists( 'it_options_export', $imported_options ) ) {
			if( get_option( IT_SETTINGS ) != $imported_options ) {

				if( update_option( IT_SETTINGS, $imported_options ) )
					wp_redirect( admin_url( 'admin.php?page=it-options&import=true' ) );
				else
					wp_redirect( admin_url( 'admin.php?page=it-options&import=false' ) );

			} else {
				wp_redirect( admin_url( 'admin.php?page=it-options&import=true' ) );
			}
			
		} else {
			wp_redirect( admin_url( 'admin.php?page=it-options&import=false' ) );
		}
		
	} else {
		wp_redirect( admin_url( 'admin.php?page=it-options&import=false' ) );
	}
	
	exit;
}

/**
 *
 */
function it_load_defaults() {
	update_option( IT_SETTINGS, it_options( 'settings', 'default' ) );
	update_option( IT_WIDGETS, it_options( 'widgets', 'default' ) );
	update_option( IT_MODS, it_options( 'mods', 'default' ) );
	delete_option( IT_SIDEBARS );	
}

/**
 *
 */
function it_load_demo() {
	#load the theme options
	update_option( IT_SETTINGS, it_options( 'settings', 'demo' ) );
	#load the sidebar_widgets array
	update_option( IT_WIDGETS, it_options( 'widgets', 'demo' ) );
	#load the theme_mods array
	update_option( IT_MODS, it_options( 'mods', 'demo' ) );
	
	#load each individual widget
	$options = it_decode( it_options( 'widget', 'demo' ), $serialize = true );
	foreach ($options as $option_name => $option_value) {
		update_option($option_name, $option_value);
	}
}

/**
 *
 */
function it_options( $type, $state ) {	

	$options = '';
	
	switch($type) {
		case "settings":
		
			if($state=='demo') {
				
				#demo settings code
				$options = '7T1rj-M2kt8D5D9oECCZwdluS373IMhmkslegMnjMnMXHHb2BFqibE7Lolak2u3M9n8_UhIlStSD6ra7OxkvFsG0zHqyWFUsvsClZc0vP5JL07r88l8xpi9dREIfHGwfb3D65SW5nGY_0iiG-UdzJUAgcSIUUoQDm4GDtS8agUvz8iO6HNejuCWXy-wrp2bHkZ8jX8yzX7aUhpcXF_v9foQCNyY0QsCnW7iDZOTg3QW8CX3kIHqxD4cODigM6EUc-hi45MIam9OLsXnBsY_CYFOwPpbp7pFLt_lvk-wna74s2pty-y1Emy3NfxSaW40b2jO57K1biLY6smh_s27K0k0L6iiwFd0urSMzMEwIlXkQGvDANWKwJQaE9ovWs-wLoci5OtSwPDk2yymlMs_Lei7kzlvOT8OI0oeLGl7qDdVcrNpFaLDX2UwdDwHc22EEPXTT0llLqbEP1tC38TWMIuRCtc3PcG98GzFmfEiMd9gFB9VMOR6KdjCEEcKuIh_wfRUGBMA_MLTEdrBEV2VWfHFYF-Gd7RBSKELo-AtEh8AdbiFwYWR89Fgv0csAB_DlbYFooiCy_Y2GlqT2O9fGgX_oB0R2XUA1nN2Qfu13br_2ZFdoUbizUaq_IcEOGwrGxyySJIos9LgqI_vQxmg-BqCTBJcdDGKbHkKoBKYd3ICCo3EdHDNrPvp0I5M1rUMCUlO2g7hQgPB0s8bBm4AmI0Wj60v0OoBkSXHggkiPljWpBwsxQZx23lC4ZeBRGKmDkMRrPdmEy3GwjyMbOA7zhtrNU7NS1D2uGTVSe5tHHaJAfV_jGRIoLofS2lS7tGhtr3FUx9hUDWsSEIU3tI2ruQpSL8lCjbUpDGZRSOXKamq-xjfQVZp7jUIAllLUCjFRDUSiYK83CgRs6sI18v01BlEJqstOPIxpu-CLmvb1snzXxFkGVN8lc5WUx0K_LQ_pllFpNcHYBP0BNVxHCuizQIxj2kVt0gjURa4kW0yRj-ihl2wyTAex3MOVlJIO8ZbQYc1awLrkK5H0UXDVFqNMuTFFlOU5La3nausuBUxqQYINi0IdckxlSOYTcE8A4DLhpRGlAqxqAbrIlFQG9myYa6ssbd1FoGRsLFSvW22lLIWwla6utKbNUB38leiV3E9Hl_C2vYyXsIza08jsvIi3XsfILwIa4B3FUiST_WvJSwRCq8hVJAlxRLdY1pcYf4lCmjkQ4nF_2txqWeQbmvi2dNeSjyzy-TFwUbDpRhfhfau3H-fSKrOYCs5bdGm1KFQQ3ETSx3pd5kR_BRvoGn-PatA8DbUK_kPOqJ5uzTvqdqKhW-4JPyU7XdxRl9MWXQrO9sjdQPpJDPtmV6ulzRnT5qrDjaohN_fQKHD82GVpNAUbos5hBdLpspjBdriN1zcMI0HX8Nmn3C3zFiMXgopSXpdDnueaTdsb36V1v0_aiyyOFO3EQPgx8FCAKHzKAW-ZD9qUVz0NW3fU8FJDw2sfb_rlE69kiD99PjG7o25XGjGQ6SRg6b-uet8m5VGWxHf4XREU6JZNYMgwDv-KDrjooS_yoNakb4XQOdloUqrAeQUPRJ3nmgNrMBlMB7PBfLAYLAerwRdSf-Q138jZsuxAmRXOuiaFfby6AOfO3Pg2pfjX8TrWPWaITyJXFBi_20LnymAZDY7pJ50uTs7x4BwP_iLxYFEKB3IIKJY-eRBQIoCVbBg699NDxe2Kpm-luMmD0bl_nl7_5CMoXaip9tC8K4cqdbDYP3TuoHvV1vvFZ6GWH1DgGv9NzsFZpD9PIjEVn98ACgk1_jOj-Smb_vRcyTwnpn-JgFqtU9QFVhDTLd8odE59nlrqk2-DG0_P3fP0umcirYLbbBRhvkdXd1NsGRqxmBBdA7-t2j6TAWgEgsoO0-YdL9nSss3Yw7G6Q88pduLMKxBiM47DkoMNjhAsco2pkK9aouPpuLqVkSeU6sZOngcV9rqc1binfEOM7WC_detIvhdyB5DfuZHWlGqrTZrxao6hIEKbmgN1H6GPcWivAdNm3_M8eY05QQFvHBiFjDIMNrUnbMaqtSczWmYnG6izk7Nobe_wGvmwbSeJWd7tJO171Tf8vCreC7okXC9Qy5RBCXLhGkTqRu2cv6zFMCof-ZjKWDwIaByxNBztUqTShjKBZ7Gq6xtM-urNlEErFihsJd_tW_BbArur1IWVcCz83IDtQg_EPu042CYcCtmCiHnyGsLFFuqARthngyWqUTYn21fZxU7ZMqADQokFfYPNagekvEE3XxfG0ri0rDqYGumFPbAMDP3B2sohoBgo6UmJysxCKO6H2PeN3-A1gnvVkSeKKyHo7YeEK4sgSIIBUcWYFzqgeKeGrAK0Iz2ogSD04MMObU9kaSPo4B1TN58d7yCLHW7NQYVqPJO6TEFSjiS5X_5fHBs7PkoM4BNs-OiqYNNaNiHzkE_5xun2Yy_WuAm-Dm6iMpcl9cDdocCGQZ8Oz2lnOOAupIfeVlOZXcCbpF6hEY8zAOYKalbPAmYR8ZqfkV3LVRGrDFs-TJKfsUMOU8QOqvlRlAwe5tEoSxyIWlpMcu38iJ2MQuB-ewhwSBDJ05rxy1-KvSv0-wRz-hdzVT2xFe6dAA_atSCkCYSNAFAGEb_YFZjbrOjXLe0PqT89krQVbDrSek0gLdJWYG6zGlyztLl5vA2hgzzEfAYqjqrcUeh2pG2yF4XwdkhVBblTtWtBb7OKV7MmhHt_Iyefd1RALa42uQWAXw-giitSlXKufFtbdzIb-bx_gSX3o5l7iZjWWQbEGI6Qo4iXnq2oC4QJMPN4LGwgUHCee6dmXYuPv_qYKgT35aPMFXnT3s3jJaLflRjgs7_jE20zgzwTlNE2G0Fu8lJ74eC6jfNbh8plh1Or7F5kdcYOKCPWGDslCOErmxUnMH6PIviwursv5Tb15bdyKLhbnK3Ab1ehhJ9tCQ7FRpY4cGkEnKsH0-P9abcGr_x0tYq9RZdmHriqYLfZOYBmZQpTfu2iBzXI-9FtU6LADCuYmxUoorNdBrnNdus3K0-4z_8BfgwfTHX3odqmOIH3uoS3WW2Coi0D3GY78Lst7r9iwM_kPrjF3Y2ujsX9q4JZw-LKILfZ5noN3_d9HIE1elAF3p-2lu9zVew6vk8Bu81207coU0yIXwHKVHAw3iDv4YbxMai3KlTgX6f4bV_G36JSUUWwawC5Us1xu1ZFl_wU-xTxxR4pYT-5Uu9PvFWnAv2uBn2LSkVX2CpcolFTy2P-Hj1OjL4bXR2PuY96x-gySKI9S89lvvbYnB7BwHkEl3ln2louE6rYdVymApZos30Kk9e5v4cEbQLjx4CEKAK1de6TafVoPLRqd1ncNsio2KiGSouW84paI3ii7ameL_0VR_TB4_39iWv50rAGvY4vVeHqq1eWbvVKV6qmKtdk2njeyRwPTHNgWgNzMjDL9S-zrv5FqpdQNd9Tk8HxuYt6d1Xz1T0ZWExgN5BVKbNRTIEvKOpe_VWCTcj2hMwWHtR1NdGO4rARWKhVD9gqA6dA15B0slwBDOAG6AFW2E2XCPkOU-0b2Spa6gJblMGA72NG1gfBlZ0uo1HSe7dBzf6XvP5qNm3jVTdb1O6mWs6OeA_mDgWIdSkcbpg7KF2DOZdoy7dwLk9FvXoP50piYL-Vz3KvzFPxMEwI1V-nmiqiwsn0tJxUdVK6EE5JIr_wvIU3HivmU7pQuDEw8Vbla06bN8bxttuOgDeX27oaSNMrG9uZrVxXq8PzXIHo4jyPrBKI272bcb2xy_3S1jLZWqKxvL2u2QPT2IWscQRDCKjGxVOsLZvVAme7a7kRMlsB6XRZkw6XNT_FMNlh5rC1fNbqZOR7OC3rZEz09lqzE7PS020t4Xhcc7D77LbObuvObmvS5raUDcRNfutEyU6yWVrHc50q00kY6OG7pidko7f3WpycmZ7-a-ytF-e06-y_jum_pjpp17TDfY2POFKS-1-H9For4ZqcgLC-uzpquinI93VTR006y0z0dU8mcNbe2T2d3dOx3FPt1siV7lFCvTOCDa6lUUrVDTSrr268Np547Oi983A6D6d7D6feh7ErVfLSVe6A_5wVmxcauy74NQ7YM3isUaya-HHN211rBoK9WoByAjI9fgyMcLg9aCUhixMR7zFvGp-Ihd5zpslJGSlrJF1oXeTrrN_u8wOGd7ZHnVX8s1WerbLZKouEGJFXfLKffV8zaxU7_Rfd53BeJ2u9778ixq9I2pRc7y9NaQcujkhYB3Fy02SjArqPZZoJ8cc1zYSFp2CaEiNHcZgdJqmzc-RsmGfDbDHMLp850fSZPnT4ITZDMuxGnynkgxkQqIUpG-fx7cPnk5cABRutKv34dPR7mOjkdFz0ttL5qXk5rgetN9AWDzrNPejZTM9mqmumXf502u5Px_mWfn7xIqh7P6bkS5f5Hn1Ct6DrevcTFO2dCPyhNyuan4Z2jzWD1Wk46G2S1in5OIrXbDFDjXsVzsZ4Nsa7-MaZuK2w9XKQn8AmgFS6L6HdMTa1Pt3utVQLgvCD714rk3-k3WtlJh5191odK03Lq2vJKtVb7u7mTBvtVseTnq33bL2d1lvvVVX7vZWf5Guv0L92sPFDhGDg-gfdCqiDvSaIsrkev6t8CDwtU52dhHSPsL88CQO9TdQ8IRsP6VzbDVarPno227PZ3terLrQy1zfIuZJuTOzIXP2m1qeu2ns-uMbRI1XtU-KPWrVPWXgCVXuZkcfIWBV71chYz1Z7ttpmq-3jU5daPvXHHT8aD109n4qaWp_aOjc-XgP_kawzJf6o1pmy8ASsU2bkMXyqYq8aPvVstWerbbbaPj511T77FyC_AwojI4ww9jS3i-45RD3AqYv-CelHKvontB-16J9w8ASK_hIfDzr_bzNZnR2lZ8M9Gy48QraaXBS47LzPOX2Put2p5gct6tueuii1RwF8pKIUJ_2oRSnOwBMoShVsPKQvbbBRjavBz5Z6ttR7OU-zPS8Vsfct8KDh4cj4HUe6G_P5ZXwMZF8Hceq9e5xo6AMHPtLevZz-o-7dy7l4Anv3Krw8aKrabsU6a1VnWz7bsrYt6zvgurPec_2LRGv975_zSHjTOd38UtCm206lg7ur6nt18ku86ZHdWaNyhcW--eVNu34n-alwX1FeGEEC1Sdx4A4PfRBvtifpk-x83awzvfxuC2FE9KZATrltg4BLScA1lC53PbJ8Uy35ft8C-uybdvnyZ3i3gHZJVxyXYeKROAojRLpqwXeXca4l409wOxqN9Cx0B7edIk4lEV1EQh-CE8q41BqCb4GrJyCRGjYIuJDkc6LDqQRLihCzzsdUfvv276-f6RloJN-uoOFfyBZjehrx6qLU7NhRqkHEk0azxgfG5Su2pyzgLHmwkSLNIn-gdxNgz8u1Mul-pVL02dsU1DAVU81yj0KWmUhD320RMdj_gfG-RD_7y1jjm5HBn0J1QGA4LAxSaABi7EBwMLKmhH84sCZ7EFADBQZLgIwkCTJw8hIvaxC4_EvAfiUwosmv7N8UG_wBVGJcI5BAMYuLqINdaKxj5LswGhm_RAluTj4DBgZm81QuaMYA-9tIfnbRNXJj4CdYjTUgiIyMdwwv-5ug5MZ1BBk3ETT4HjFI2M-ff_b5Z9zLtyjhG4YDBVf8kgNEubCAiXrgf1Lo-yjYcA4jI0ouIycGwfxZWv55zRP8RBcHY4MHTGuHNZR-p5wulw74DCFJFciUEsEdSjW241T2XHMcyfuvGDaXSZ_Q4hiyp38JV0HCBL8cb2T8lBACGSIYcaQs_DpMhphmDZMyDy-ye4ghGCTKjMNkLpM0COCe-JA_pDIw2DduQiwHSropPYbMkTIlMewehO4acOxcC3x9M-kPQmKY6P-QqPyavxXD_kMAZRQTm-C9yhiNWXxICPMQClmTRCkBwzpqcxg97sdvGgi6F-Tng7cmNwRu9R56ay6885c-f17u2kheOf76vXha3OWdd2nOwhuj-M84vHmZtfhyk4ICYxtBT8DpzjaG7OuFGMAURBtIBYr0ovQKFbTbGCRy-pJpntRYF0wn0_nyZj7msxjBCsMiaABXfExuKhKfGYz4nt5HJH6Yj8X3C8H1Bcj_xTSc_LvqEBkXHgthUs9MFgupZ_hDwyEf0YfAkTVwccFffweuNdpgvGGj48BcS_qqaqKB9NeLD4TJSdaHtNHoA6no9SLFz__8_DP-4dlwaPyYq_RdolLjN0hC5iPRNTSGw6Itc3aG4wNCCpXlpLIvn39m8P-VbCtJuMDhcu1j56rczgUUDIE7dHzEukwAOGAYxuvh1DSXS3NhrazZ0jJX03pQ4uMc0LQsczKZWnOrvi0bzztQdHhMcVU9TMRCXllXzyVZja-ZiQQu3o_kj__-t_GPf74YhTHZPv94-yLDISm85slsN3l4Y4tZf9qpZ9Z4baIEBTza-kTFVPYIEe6mMqkA9CCwiZDbi0AC0IOAjwjtRSAB6CIg6VX4kW4iixqgLkIV78xfpIh6dXsB1UVKYo_5wwA6GiLNVZgeZJjT5Lff9iIjYLrISCCU5W8w6KYyU0B6mAGNWC7GX07uYwY5UA-lxTR5cqeX0gRMn5FPd36_kc8Bephz-vAsjg69zLmA6kGKpcz-GoPI7UWqgOoglT8Bk44CGmF_DTRG6aoWrEsu2UoR9WE3nWkVoocZ7AAKeplBAtBDBjbVgbiXDClEDxLJfYy9SKQQXd0-Kfcff7LH3sEg7iSVP1OkQPbwA-KhoT5-QMD08GviSfdefi0H6hdzuCL6xpwEpoc8fE6NAg_3kicH6jIJs4Bhfip5x8mF3W5H9iAyXJ9-yh6N6tdPAqiLkGTqfIa8ifhL191FJtY8iHfKMs9YXUfkgy5w2ERfntaqT1NJLpOXbCBtXEKSL7_Foc0ATJ17ctOmln7TiX7TqX7TmX7TuX7ThX7TpX7TldalwlkfjDWMLJ3s2mz-h2O1g13VYzs4PER8nm1TeKNz-S8zNBcxs-9oLmJIUhiKI55E69VnIkLsOPI1nBjdI16bSh7kq13WgME1oFhVUoiY64sgm6vIhKzKrp68VVrySHBdqHEonY6GfkzsrJJWwjqXl84JR8taZkWFBHF8Mb4w2Ux6OZ_PZwtrNp9Ml1NrPF9-E0H_azZp3kpXJ-ey8-6N11CVvXm9NAdpVa4QywMOXGN8VWo-MSvC8AqRaCmpSXXqObrkKmibOLzyoaxk-KULqPMkLwcmW7y3-V_67_vNFBxs4gB2uvCqAGscuczoOq60znkXRprOvWxe2S5WHWZjqRQFysWeDHBI0Q7ySWheFauUA3k3ZG2THqhUlwRYUpNJmRgiVyCYLBamObXM2dyaLCez-XQpVWje7SGbLRrrg_G3CtKi-Fat3Dzz4iBZJn_uDsgAuS8-XoPI-EAG3gfytTti1F_7SaAirw7vwOZnZrrPyYt_jP85CL---L905I349YbP3ZGP04Lbi2_ef8V_ef_VZfoP8v6rl8h7_kzG9-rwo_uc0XvxMSGUrlNkvzEKLz-QERMbufwfvM4X_kcmaTIkAeW1qpGsx2yyXNT0XjIRRiFg0076M-vFUboW8SpJGZ6nEr54eXv73MVOzKkOxEpCopzsj0Gld_c5-hc1BcNq2PD4cczIlt8VEeN1Zs3NhTmb_e3n8bImLKSALKFYS7mKsO2VsvSeLA0Uxz6ltzBLb-6WlssWZYtXF_-ZBeGdxrX8KLjqvuN_i6-bs65s80Izr8vKqH5kZietzOaZQBFqHpnfaSu_q2qYfVRu65aN_hxGfIdHBop5-A4FNn-hoSPcT0snae1stbaRpf8H';	
				
			} else {
				
				#default settings code
				$options = '1VtPj-smEP8qKz2pt0qJs5vs7ju29_bQS08WtolD1zYp4M3mPfW7F2yDwWAPPK0q9erMj_nDzDAzEPSaHbLX7_x1n73-9HdPxdeK8GuD7nlDazp--cpfd9OP5sPz9EFR5T1r1in3O5v0Ripx2SDe28QXTOqLiKWWUuSXaoP6caYmXR4huV7-jN5JSTuA-mn6wgUp3-4x6z-HEdtanAIgyKohRqBx9ZcO3_Irw2fyEcFBETeowE1O3zFjpMIRG6JAgrT4ihmhMTuIOtTcpS48L-kmB_2l7LmgbV5yvkF88Ijzpo7Q2aJvq5x2zT0NxFsIFJDsI1GTtkqj5-06_YtL_hePcVdcCiJjqMVdn4v7dd41vaktrtGqmw-wwbFi3NzmBYCy3QyiXYVYHK_sEIZdKSeKtyHUWQGdBWazqDrblrShLEdlibutWHTJLxhV9mLTj7uAl1n0ucph3EP9GoiWAaX08aj3_g7N1HlBWUiwRz9JWiCBP8SWVEcfEtbk5GfuEUPFJSBVtkZe0A9ceeRnPw1Z5HlRewi8th8FaZqCIgah3F0_Uyq21TgF6MPm_WVNtAkUNvDRZ3WmncjteNsImWwNk3PyDUfE9Qhs5KFCewFxO6yCIHaObr0gDRH3JN1sDMDMpB_HKGPAbqTV7GkDBunnsGxI98ZjaiBFLIho8Bb10aeGDHAIQrq6wZAejzZSRjhNBKBKKm9FlA94CQIgNo7J0E3GebTJRmqIgeNsXd8Wm77iaqF9BdrK7HEdBcjn8HPSD7AlijbJebksGM8Rq18pExeqJJdZbjOv-QhGbzGllsUCiSR6geoI-sG_5dK4puwO92UD-fbKe5t09KJYOUgnD4l3FNMNjYIw1C3qovWdHRBQqaej5opqXNWyz5CIu0zwW8fpo4cB9vbJAwz-HxFqpDuTjsjNipPsFIIBwj2HMJB8jtkawsWacGjFCgMm1QqRjJ5DMIjX7Gc6O8d2CTMCDivL_TUoLmxlHdXJ3AkKZZyiRaQBqbW_4I9rQ0oiYjTIlphtBZ6W5GCG0AwEvQrcLXTQjvfHb78_7Hc-mwnE-yJW9wkRmBto26Om8YNfMNxVsryItrEBRMj2ssRETTWelqiFqbVvPPva3EhVY8HXgqv0RWsoveb4o8TsKr0Sd_Xm4Ghno95VDT39hiSP7-R1Z_XvgvU6UP-xoCpt5DL_1zEl90yct1S2SVuF497GcClbgZjff5tInCh-Zs7YK7MPhfyMkeiZ7OZIOy5qlSJ6ncNx54etZOtnOICzg_1R-WfLqVXUXCWv8Bn1jfDmK9b-2HorXLLeVnqTQSgd0GmPtEwMvxNsHWJZFoIFdDalAGXkm6S1Kg3DGjFBStkkQAfEsxEGDTUs9_np5FRQIWjrB-YMjT2NZgQX98afdUlOF78FGvaC4ZK20i6V3I4WyxqxCmQKVHOd8wkOGNhbyc1cJhv8SfuHVjnUA2o4fWjIm-Uiz2uLnUkjVJ8p89TGrMe0th4-hDv6wqFeas9yVLWky3GHCmNIMPsY3tMauL3KfrwiPGWRedw8LfJRNn0V0_lNAEatrbeGTJ1gpOgFDcwDJ6Q7RzPDdVJKM7SBknaMNBn6QpYP3Cg43uxMNF9svWednQUXKv0zk73hu984fQlYfBKFIaGOMunBjJTeNJQLZLWsVtgM2JLJ6o8RBOmRxeoxh_ht89YjRd99SF--nM2uD3wmHK6I8Ee6W2lsgPWy9YV5LewqqMykmmPsgNvBDmwTkZNT-mn3MFdyq2Bt1jhw5oJH0DvmoMgLYIdrFAdciDueIKpBiL53WFgJKjHNjH6Z_Vej5Kg-awXJRiGqXV8Nf-FIUlRbF5UvFt3tIgM6Im-OawLUzhXCJ0TyfrGHzsRu26pxuUdT8aav_-fWTzDry7IUgiz69NkWNcMOhjkW_43lEwxkbjhJ3dHz-RMPu5NbZn_iZqIKPHQs0sWN1Xq_LGnneWiBz5TFVPQOyr1f3Xg6UI1XBSCXwwIAMbB1MfPCJF0MCmBlTisJcqZ_EDdTsyyBqboNk7lk3QbUD-gWxS2kWwxDW0oz6wJVOwVACUacp4gpRpxRECtLPD2ABBkdfUwCGz2ISmGjMRAbCzIN_UAuTx4kwQ3MHC7FDQwowWj6njjFaBqT4G0Vkc23LPnvSd42oxJYWS8bEljNKCg77BwnFbLBVkMzkNdLEAbpZTuRmvvAfB6XiIRTqUWkSzqVBkCCDsP4NkmHEZHAYhwfprAYEdC2H9z9m0eH4KmQrSETwlS3ZilhqjEJaUdPPZLSjgGlHQnKEKlHwoBJ0EeN_eRJTJP0MSDIJazj3h4tgg6xC-NS9mkAxZx1pwAIYmS5eoHKt5rRvqvgrgSFp6q7wIRR1Uclw-3mi0MrY8rexG6f_KWdqyUJ2MPLatIsnvQQT_oYT_oUT3qMJz3Fkz7Hk77EXtSpPdhF-Nj02G_l8rAKPXi83of7J-hZj7noYWrayCFy85oN46romSpx4zpcxjnwxl4HiLgRoZRVE8zttecnOsMzFyx7iG0W2jo1pXWDr00PyGQOJQtwZfRMZMEQp4zar77AMcqYt2KoxAWlb4Bo-yX5-KQ33xy22Tffk5nH2h54nm8eiskG6o3lJOaJ-kQLvUYwT8FpSZw7n5XpyqM9XXEGQSdXMy_zjo_g4emSemgJDzUv6m8TnzHUnGusNu7PLkb5Vg1Vctk1EfsN8FKUfwE';
				
			}
			
			# Decode options and unserialize			
			$options = it_decode( $options, $serialize = true );
			if(is_array($options))
				foreach( $options as $key => $value )
					if( is_array( $value ) )
						foreach( $value as $key2 => $value2 )
							$options[$key][$key2] = str_replace( '%site_url%', THEME_IMAGES . '/activation', $value2 );
		
		break;
		case "widgets":
		
			if($state=='demo') {
				
				#demo widgets code
				$options = 'jVRZboMwEL1N_5CCTWhjDmM54KCRiE3tgbSKcvdC2Qw4wC88vW3GIxg5sadl4YV9fFcak0fJQYkUoZb8AVku0XY_EsEa5Muyzx5pq-tdqmrxNyT970LrMrCQyaswIyZkT2CnxLaq3UdAXgiUFrkwCGkhbUB7eMv21cNKkcssyA1kK85Ol4QDobqBApRb4AVtARYP03rBdMg1xm9yGVmDfNgg6mHAwgUCdclRqjExMJI47hqE1SmIgqe6UjgxuT23EVZ-oi0_ZO6HOmqyGbxWLuTf0NkZVhOfd7VNrunORInjOx4WrVuuINVFdVdBuN6RN7IHyMhIRkYyJyYaqTJQ-ZEm6L4a9ah5aqczsa263DEPHaRaqcZTsHyTU1tvt4Z66G5aozTr8smRB3o-nCTelfaNaiBUoubtiVlU9z4p2ZWjnuI8D3KfKPIQ-VZsv_zz8jj5YfESdpnU0sqivvP-CvBwfZeG1UX5gxtrP9qO5gcgXjWO4jrve2ARxohfXktjm_fjXIjXHw';
				
			} else {
				
				#default widgets code
				$options = 'jdJdjoMgEAfw2-wbieBHu3iHvYKhOHUnUXAB22yMd19J0eDWxr7w8v8xMDCC008-Wr9-_Azalfe-QiWkwxtUd6wbcPYRlIInfJwsPwVph0sHaljTgo_Ik9Ly8wJAGPlNWBDI6RzSLKQGJChHem2djQzz5rQ1UnfzSRuWepYE5o-Z7xvnmc9ZyKVw0GiDG5HPogigAyfWaIp2tlr3xGINF2H-PQNd2uxFAzVpDNYvJKNBorqiQgd7-Kt8KtmidTvqudwLuHbhy-3lS_vhn-d3bodOEfqGYW-YNDb58hdaKZCObGdrQ65aOzC7t9kn7JikxyQ7JvkxKWKSrgNqxG91A2NRq2iGpz8';
				
			}
			
			# Decode options and unserialize
			$options = it_decode( $options, $serialize = true );
			foreach( $options as $key => $value )
				if( is_array( $value ) )
					foreach( $value as $key2 => $value2 )
						$options[$key][$key2] = str_replace( '%site_url%', THEME_IMAGES . '/activation', $value2 );
		
		break;
		case 'widget':
		
			if($state=='demo') {
				
				#demo individual widget code
				$options = '7VrdT-M4EH9faf8HP6G9h7tN0pSW8MSygJD22BVUt4_ITSathRPnYocuQvzv53w4X07bBAFXtJVAQvb4N-OZn2fGDtgxp84jd8yxc_BvwsTxingLELc4dpfkHng-eIwdM5OyCqnbIKGC5LKFCHHM4ycpMmkCuVjAgsXkGVBWyyYibqlE46l1gri0BnnoPBLHSrHHKbhaKIigUAjVVH7LUNBliGb_lLPTYrIw-KFaVkzY5chIweOFtvyEUjTDC14tV-vDJGjZXWGPyhG7GAlYrCyfS3dw50gpXSbBPMSENmYPi9kYCxIuGlMKkbgsbEwoL-EVjr1yxqgbAQJ3LpljGZHGjGkotEQsWcyXJGrMK1rALxfiSDTUKeMpfmCJ0FyqKFlOKCt8EvM60hNxRls4YBlNDpzHLECzJaAvlC22c0ExyDJfkQz2OyCDsZYMxpuQAfqQwd6WEOwmGS7SjQjenwbT8e-RE8y3zQlmbxq4fWgw3kaDQ60u_M3uCfD-tWG0q-nAWM8DYx0PjLdMB8aLpIN5Hx4cbuPBWOPBBQ6G0MDa02DXadCv8zT0zpPIvjPCC_DKpnOkmk7L2kAqFZTThAvZa_xIIdDPutJaIfIIx3MKtzG4EDY9YI5aMpTcQTMmGoxMYqu2zKGmqkuqrUySpi0yaYm4LAik0W2xcUsso1JLqPR3KUSjJZ6DPAqYbobzCRUQ86bQsPO0w1XUeKEqyqUT7h5es-neeAbUrn-cXJx9RSfXs8vTb2c3e_oXUepHf_NF6W--B_qb_zf94YUKSvtVRBaUnHjVE4ZdPmFY_W8s1w2QwReL3_7-4G2Jr1m-Kbx2UOx9UAYFxd4HZaeC0jsTTrVMyMEVhIVcb6w3BVjh3Jydzi6_X90Mi-x4H9lBd-dR32g0Y9kzGpN9NF78CjvSzxlzCaayUU1C0dF3ZC8jagNiRYRsLBsbUJb62IU5Y3edPltENOGdPkl3ncy7XywiIjvnGLpYt4Nm2btoVj9WmOtYIfC84oSlOHFUP_FMXlzikp7de9_sk6MqF4gV1J_a1bnSjkWn-9Y7on7QfCq7_rUGREsmmJ6KjvTXvvxi1wxTPa21BPQi0zM2lhYbwaL2BfX5X2ILPAGhXmgnGxopBTNjEZpBiGZLwtFPgLtK5J3ezY1ywwFEEBPmae-3mKoKVKSjvae2e-q5jaCIIfSqwl6rTT06j9n12dXXy6uLYZ3HtBndV9MzqfTYr6FH-ds0hgWhVQ9qrdCARNP6P40Q30ugMGmWky3uLfuVcxJ6SCwBcZH4PpJ1EIUAnuaflhbp19EzE23-2vhnK40P2P9RJ17E-HPAWp8eYl5hGM7jU-1YFxIc0n_WGa6oFXoBv4TeAIx63LCLLxs3xIM5jrXPVDVgOWir_WXJUcY5AMR8H2KOZAAiCgLoA0pCSgIi0xByc3Ceg3PksVWIBMsYIplC7omXYIpSZyMsmZN-okEU7oH-hc5ZLOWkGh6BS3ziKhjn44ePHw6obGnowUIc539Tkv59wSSsxJ9lln2PstsMSmfSX9TcK89UujHIxIqw5OlKaUgBP-eIXegnUSSjhkMXKuj8m1AO6atDUIPMjkKuy8uEsOehVbHoky_3SkIuMsxs0_IHo3TAkxcflEahkP5jvXHSNBw-5E6UgKVX3SVjHDKLmgGROrPR_FKDWO4vTcHn3NElDcoWLXu-rr_s9ODu038';
				
			} else {
				
				#default individual widget code
				$options = 'xZLNDoIwEITfxpsJFH9weRhTy0aaUIrtoibEdxe0oEUOmGA8tZmZZL_ZlkMMtYVwDYtTpSm5yPSItOdGZPKM9ikmHBjUElhzidp4lyZJObqMhcCpvdDFhK4KcqqEoHFi56RGl6m-FG_mraFhzt6rKif5ZOoj4SOy9YEFJzxqI8eQV7Mg91CZRPPYj-D5zKVCv5RC4p91wsl1pk1lzJ9qUGBBS6GVas6RfbIv9rlxQlGpA5p-8HrqRnajbKW2_wYLBmD2xRNA3SYiP2Gx_TS_f87hJyK8kod2uwM';
				
			}
		
		break;
		case 'mods':
		
			if($state=='demo') {
				
				#demo theme_mods code
				$options = 'Zc1LCoAwDATQ27gT_FSQ9DAlVhdBbdGmgoh312JF0UU2M48JQgEbQSab8xzkNSSTtywNLmrsjFeD1chkjbtyiSBgO2ERoet0qNOAIyEQZdgSD7GmxXn9IBFQfiMm3X9FJV-fPNNA_Cf7fgA';
				
			} else {
				
				#default theme_mods code
				$options = 'S7QytKrOtDKwTgLiWgA';
				
			}
			
			# Decode options and unserialize
			$options = it_decode( $options, $serialize = true );
			foreach( $options as $key => $value )
				if( is_array( $value ) )
					foreach( $value as $key2 => $value2 )
						$options[$key][$key2] = str_replace( '%site_url%', THEME_IMAGES . '/activation', $value2 );
		
		break;
		case "internal":
		
			$options = array();
			
			if( defined( 'FRAMEWORK_VERSION' ) )
				$options['framework_version'] = FRAMEWORK_VERSION;
				
			if( defined( 'DOCUMENTATION_URL' ) )
				$options['documentation_url'] = DOCUMENTATION_URL;
				
			if( defined( 'SUPPORT_URL' ) )
				$options['support_url'] = SUPPORT_URL;
		
		break;	
	}
	
	return $options;
}

# turn variables into proper class types
function it_prep_data( $data ) {							
	#create itCriteria objects based on entered details	
	$criteria = $data[IT_SETTINGS]['review_criteria'];		
	if ( isset($criteria['keys']) && $criteria['keys'] != '#' ) {
		$criteria_keys = explode(',',$criteria['keys']);
		foreach ($criteria_keys as $id) {
			$val = ( ( $id != '#' ) && ( isset( $data[$id] ) ) ) ? $data[$id] : '';
			if ( $id != '#') {
				$criteria_name = ( !empty( $criteria[$id]['name'] ) ) ? $criteria[$id]['name'] : '';
				$criteria_weight = ( !empty( $criteria[$id]['weight'] ) ) ? $criteria[$id]['weight'] : '';
				if(is_array($data)) array_push($data[IT_SETTINGS]['review_criteria'][$id],new itCriteria($criteria_name, $criteria_weight));						
			}
		}
	}
	#create itDetail objects based on entered details	
	$details = $data[IT_SETTINGS]['review_details'];		
	if ( isset($details['keys']) && $details['keys'] != '#' ) {
		$details_keys = explode(',',$details['keys']);
		foreach ($details_keys as $id) {
			$val = ( ( $id != '#' ) && ( isset( $data[$id] ) ) ) ? $data[$id] : '';
			if ( $id != '#') {
				$details_name = ( !empty( $details[$id]['name'] ) ) ? $details[$id]['name'] : '';
				if(is_array($data)) array_push($data[IT_SETTINGS]['review_details'][$id],new itDetail($details_name));						
			}
		}
	}	
	#create itAward objects based on entered awards
	$awards = $data[IT_SETTINGS]['review_awards'];			
	if ( isset($awards['keys']) && $awards['keys'] != '#' ) {
		$awards_keys = explode(',',$awards['keys']);
		foreach ($awards_keys as $id) {
			$val = ( ( $id != '#') && ( isset( $data[$id] ) ) ) ? $data[$id] : '';
			if ( $id != '#') {
				$award_name = ( !empty( $awards[$id]['name'] ) ) ? $awards[$id]['name'] : '';
				$award_slug = ( !empty( $awards[$id]['slug'] ) ) ? $awards[$id]['slug'] : '';
				$award_icon = ( !empty( $awards[$id]['icon'] ) ) ? $awards[$id]['icon'] : '';
				$award_iconhd = ( !empty( $awards[$id]['iconhd'] ) ) ? $awards[$id]['iconhd'] : '';
				$award_iconwhite = ( !empty( $awards[$id]['iconwhite'] ) ) ? $awards[$id]['iconwhite'] : '';
				$award_iconhdwhite = ( !empty( $awards[$id]['iconhdwhite'] ) ) ? $awards[$id]['iconhdwhite'] : '';
				$award_badge = ( !empty( $awards[$id]['badge'] ) ) ? $awards[$id]['badge'] : false;
				if(is_array($data)) array_push($data[IT_SETTINGS]['review_awards'][$id],new itAward($award_name, $award_slug, $award_icon, $award_iconhd, $award_iconwhite, $award_iconhdwhite, $award_badge));						
			}
		}
	}			
	#die (var_export($data));
	return $data;
}

/**
 * 
 */
function it_icons() {
	$icons = array(		
		'emo-happy' => __( 'Smily Happy', IT_TEXTDOMAIN ),
		'picture' => __( 'Picture', IT_TEXTDOMAIN ),
		'emo-wink2' => __( 'Smily Wink', IT_TEXTDOMAIN ),
		'emo-unhappy' => __( 'Smily Unhappy', IT_TEXTDOMAIN ),
		'emo-sleep' => __( 'Smily Sleep', IT_TEXTDOMAIN ),
		'emo-thumbsup' => __( 'Smily Thumbs Up', IT_TEXTDOMAIN ),
		'emo-devil' => __( 'Smily Devil', IT_TEXTDOMAIN ),
		'emo-surprised' => __( 'Smily Surprised', IT_TEXTDOMAIN ),
		'emo-tongue' => __( 'Smily Tongue', IT_TEXTDOMAIN ),
		'emo-coffee' => __( 'Smily Coffee', IT_TEXTDOMAIN ),
		'emo-sunglasses' => __( 'Smily Sunglasses', IT_TEXTDOMAIN ),
		'emo-displeased' => __( 'Smily Displeased', IT_TEXTDOMAIN ),
		'emo-beer' => __( 'Smily Beer', IT_TEXTDOMAIN ),
		'emo-grin' => __( 'Smily Grin', IT_TEXTDOMAIN ),
		'emo-angry' => __( 'Smily Angry', IT_TEXTDOMAIN ),
		'emo-saint' => __( 'Smily Saint', IT_TEXTDOMAIN ),
		'emo-cry' => __( 'Smily Cry', IT_TEXTDOMAIN ),
		'emo-shoot' => __( 'Smily Shoot', IT_TEXTDOMAIN ),
		'emo-squint' => __( 'Smily Squint', IT_TEXTDOMAIN ),
		'emo-laugh' => __( 'Smily Laugh', IT_TEXTDOMAIN ),
		'spin2' => __( 'Spinner', IT_TEXTDOMAIN ),
		'firefox' => __( 'Firefox', IT_TEXTDOMAIN ),
		'chrome' => __( 'Chrome', IT_TEXTDOMAIN ),
		'opera' => __( 'Opera', IT_TEXTDOMAIN ),
		'ie' => __( 'IE', IT_TEXTDOMAIN ),
		'star-full' => __( 'Star Full', IT_TEXTDOMAIN ),
		'star' => __( 'Star', IT_TEXTDOMAIN ),
		'star-half-empty' => __( 'Star Half Empty', IT_TEXTDOMAIN ),
		'star-half' => __( 'Star Half', IT_TEXTDOMAIN ),
		'check' => __( 'Check', IT_TEXTDOMAIN ),
		'plus' => __( 'Plus', IT_TEXTDOMAIN ),
		'minus' => __( 'Minus', IT_TEXTDOMAIN ),
		'password' => __( 'Password', IT_TEXTDOMAIN ),
		'pin' => __( 'Pin', IT_TEXTDOMAIN ),
		'doc' => __( 'Document', IT_TEXTDOMAIN ),
		'folder-open' => __( 'Folder Open', IT_TEXTDOMAIN ),
		'cog-alt' => __( 'Gears', IT_TEXTDOMAIN ),
		'wrench' => __( 'Wrench', IT_TEXTDOMAIN ),
		'basket' => __( 'Basket', IT_TEXTDOMAIN ),
		'right-hand' => __( 'Right Hand', IT_TEXTDOMAIN ),
		'left-hand' => __( 'Left Hand', IT_TEXTDOMAIN ),
		'signal' => __( 'Signal', IT_TEXTDOMAIN ),
		'laptop' => __( 'Laptop', IT_TEXTDOMAIN ),
		'tablet' => __( 'Tablet', IT_TEXTDOMAIN ),
		'globe' => __( 'Globe', IT_TEXTDOMAIN ),
		'scissors' => __( 'Scissors', IT_TEXTDOMAIN ),
		'fire' => __( 'Fire', IT_TEXTDOMAIN ),
		'credit-card' => __( 'Credit Card', IT_TEXTDOMAIN ),
		'beaker' => __( 'Beaker', IT_TEXTDOMAIN ),
		'truck' => __( 'Truck', IT_TEXTDOMAIN ),
		'dollar' => __( 'Dollar', IT_TEXTDOMAIN ),
		'sort' => __( 'Sort', IT_TEXTDOMAIN ),
		'coffee' => __( 'Coffee', IT_TEXTDOMAIN ),
		'food' => __( 'Food', IT_TEXTDOMAIN ),
		'search' => __( 'Search', IT_TEXTDOMAIN ),
		'email' => __( 'Email', IT_TEXTDOMAIN ),
		'liked' => __( 'Liked', IT_TEXTDOMAIN ),
		'username' => __( 'Username', IT_TEXTDOMAIN ),
		'users' => __( 'Users', IT_TEXTDOMAIN ),
		'register' => __( 'Register', IT_TEXTDOMAIN ),
		'camera' => __( 'Camera', IT_TEXTDOMAIN ),
		'grid' => __( 'Grid', IT_TEXTDOMAIN ),
		'list' => __( 'List', IT_TEXTDOMAIN ),
		'x' => __( 'X', IT_TEXTDOMAIN ),
		'plus-squared' => __( 'Plus Squared', IT_TEXTDOMAIN ),
		'minus-squared' => __( 'Minus Squared', IT_TEXTDOMAIN ),
		'help-circled' => __( 'Help Circled', IT_TEXTDOMAIN ),
		'info-circled' => __( 'Info Circled', IT_TEXTDOMAIN ),
		'home' => __( 'Home', IT_TEXTDOMAIN ),
		'link' => __( 'Link', IT_TEXTDOMAIN ),
		'attach' => __( 'Attach', IT_TEXTDOMAIN ),
		'tag' => __( 'Tag', IT_TEXTDOMAIN ),
		'bookmark' => __( 'Bookmark', IT_TEXTDOMAIN ),
		'flag' => __( 'Flag', IT_TEXTDOMAIN ),
		'thumbs-up' => __( 'Thumbs Up', IT_TEXTDOMAIN ),
		'thumbs-down' => __( 'Thumbs Down', IT_TEXTDOMAIN ),
		'forward' => __( 'Forward', IT_TEXTDOMAIN ),
		'pencil' => __( 'Pencil', IT_TEXTDOMAIN ),
		'signoff' => __( 'Signoff', IT_TEXTDOMAIN ),
		'commented' => __( 'Commented', IT_TEXTDOMAIN ),
		'comments' => __( 'Comments', IT_TEXTDOMAIN ),
		'attention' => __( 'Attention', IT_TEXTDOMAIN ),
		'alert' => __( 'Alert', IT_TEXTDOMAIN ),
		'book' => __( 'Book', IT_TEXTDOMAIN ),
		'category' => __( 'Category', IT_TEXTDOMAIN ),
		'rss' => __( 'RSS', IT_TEXTDOMAIN ),
		'cog' => __( 'Gear', IT_TEXTDOMAIN ),
		'emo-wink' => __( 'Smily Wink 2', IT_TEXTDOMAIN ),
		'login' => __( 'Login', IT_TEXTDOMAIN ),
		'logout' => __( 'Logout', IT_TEXTDOMAIN ),
		'recent' => __( 'Recent', IT_TEXTDOMAIN ),
		'window' => __( 'Window', IT_TEXTDOMAIN ),
		'down-open' => __( 'Arrow Down Open', IT_TEXTDOMAIN ),
		'left-open' => __( 'Arrow Left Open', IT_TEXTDOMAIN ),
		'right-open' => __( 'Arrow Right Open', IT_TEXTDOMAIN ),
		'up-open' => __( 'Arrow Up Open', IT_TEXTDOMAIN ),
		'down' => __( 'Arrow Down', IT_TEXTDOMAIN ),
		'left' => __( 'Arrow Left', IT_TEXTDOMAIN ),
		'right' => __( 'Arrow Right', IT_TEXTDOMAIN ),
		'up' => __( 'Arrow Up', IT_TEXTDOMAIN ),
		'down-bold' => __( 'Arrow Down Bold', IT_TEXTDOMAIN ),
		'up-bold' => __( 'Arrow Up Bold', IT_TEXTDOMAIN ),
		'right-thin' => __( 'Arrow Right Thin', IT_TEXTDOMAIN ),
		'random' => __( 'Random', IT_TEXTDOMAIN ),
		'loop' => __( 'Loop', IT_TEXTDOMAIN ),
		'play' => __( 'Play', IT_TEXTDOMAIN ),
		'stop' => __( 'Stop', IT_TEXTDOMAIN ),
		'pause' => __( 'Pause', IT_TEXTDOMAIN ),
		'last' => __( 'Last', IT_TEXTDOMAIN ),
		'first' => __( 'First', IT_TEXTDOMAIN ),
		'next' => __( 'Next', IT_TEXTDOMAIN ),
		'previous' => __( 'Previous', IT_TEXTDOMAIN ),
		'target' => __( 'Target', IT_TEXTDOMAIN ),
		'style' => __( 'Style', IT_TEXTDOMAIN ),
		'sidebar' => __( 'Sidebar', IT_TEXTDOMAIN ),
		'wifi' => __( 'Wifi', IT_TEXTDOMAIN ),
		'awarded' => __( 'Awarded', IT_TEXTDOMAIN ),
		'battery' => __( 'Battery', IT_TEXTDOMAIN ),
		'monitor' => __( 'Monitor', IT_TEXTDOMAIN ),
		'mobile' => __( 'Mobile', IT_TEXTDOMAIN ),
		'cloud' => __( 'Cloud', IT_TEXTDOMAIN ),
		'moon' => __( 'Moon', IT_TEXTDOMAIN ),
		'leaf' => __( 'Leaf', IT_TEXTDOMAIN ),
		'suitcase' => __( 'Suitcase', IT_TEXTDOMAIN ),
		'brush' => __( 'Brush', IT_TEXTDOMAIN ),
		'magnet' => __( 'Magnet', IT_TEXTDOMAIN ),
		'chart-pie' => __( 'Pie Chart', IT_TEXTDOMAIN ),
		'trending' => __( 'Trending', IT_TEXTDOMAIN ),
		'reviewed' => __( 'Reviewed', IT_TEXTDOMAIN ),
		'water' => __( 'Water', IT_TEXTDOMAIN ),
		'floppy' => __( 'Disk', IT_TEXTDOMAIN ),
		'key' => __( 'Key', IT_TEXTDOMAIN ),
		'gauge' => __( 'Gauge', IT_TEXTDOMAIN ),
		'cc' => __( 'License', IT_TEXTDOMAIN ),
		'flickr' => __( 'Flickr', IT_TEXTDOMAIN ),
		'vimeo' => __( 'Vimeo', IT_TEXTDOMAIN ),
		'twitter' => __( 'Twitter', IT_TEXTDOMAIN ),
		'googleplus' => __( 'Google Plus', IT_TEXTDOMAIN ),
		'pinterest' => __( 'Pinterest', IT_TEXTDOMAIN ),
		'tumblr' => __( 'Tumblr', IT_TEXTDOMAIN ),
		'linkedin' => __( 'LinkedIn', IT_TEXTDOMAIN ),
		'stumbleupon' => __( 'StumbleUpon', IT_TEXTDOMAIN ),
		'lastfm' => __( 'LastFM', IT_TEXTDOMAIN ),
		'spotify' => __( 'Spotify', IT_TEXTDOMAIN ),
		'instagram' => __( 'Instagram', IT_TEXTDOMAIN ),
		'dropbox' => __( 'Dropbox', IT_TEXTDOMAIN ),
		'skype' => __( 'Skype', IT_TEXTDOMAIN ),
		'paypal' => __( 'Paypal', IT_TEXTDOMAIN ),
		'picasa' => __( 'Picasa', IT_TEXTDOMAIN ),
		'footer' => __( 'Footer', IT_TEXTDOMAIN ),
		'pages' => __( 'Pages', IT_TEXTDOMAIN ),
		'settings' => __( 'Settings', IT_TEXTDOMAIN ),
		'builder' => __( 'Builder', IT_TEXTDOMAIN ),
		'viewed' => __( 'Viewed', IT_TEXTDOMAIN ),
		'zoom-in' => __( 'Zoom In', IT_TEXTDOMAIN ),
		'zoom-out' => __( 'Zoom Out', IT_TEXTDOMAIN ),
		'lock' => __( 'Lock', IT_TEXTDOMAIN ),
		'lock-open' => __( 'Lock Open', IT_TEXTDOMAIN ),
		'down-fat' => __( 'Arrow Down Fat', IT_TEXTDOMAIN ),
		'left-fat' => __( 'Arrow Left Fat', IT_TEXTDOMAIN ),
		'right-fat' => __( 'Arrow Right Fat', IT_TEXTDOMAIN ),
		'up-fat' => __( 'Arrow Up Fat', IT_TEXTDOMAIN ),
		'facebook' => __( 'Facebook', IT_TEXTDOMAIN ),
		'wikipedia' => __( 'Wikipedia', IT_TEXTDOMAIN ),
		'html5' => __( 'HTML5', IT_TEXTDOMAIN ),
		'reddit' => __( 'Reddit', IT_TEXTDOMAIN ),
		'appstore' => __( 'Appstore', IT_TEXTDOMAIN ),
		'youtube' => __( 'Youtube', IT_TEXTDOMAIN ),
		'windows' => __( 'Windows', IT_TEXTDOMAIN ),
		'yahoo' => __( 'Yahoo', IT_TEXTDOMAIN ),
		'gmail' => __( 'Gmail', IT_TEXTDOMAIN ),
		'wordpress' => __( 'WordPress', IT_TEXTDOMAIN ),
		'acrobat' => __( 'Acrobat', IT_TEXTDOMAIN ),
		'quote-circled' => __( 'Quote Circled', IT_TEXTDOMAIN ),
		'video' => __( 'Video', IT_TEXTDOMAIN ),
		'tools' => __( 'Tools', IT_TEXTDOMAIN ),		
		);
	asort($icons);
	return $icons;
}

/**
 * 
 */
function it_fonts() {
	$fonts = array(
		'Arial, Helvetica, sans-serif' => 'Arial',
		'Verdana, Geneva, Tahoma, sans-serif' => 'Verdana',
		'"Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif' => 'Lucida',
		'Georgia, Times, "Times New Roman", serif' => 'Georgia',
		'"Times New Roman", Times, Georgia, serif' => 'Times New Roman',
		'"Trebuchet MS", Tahoma, Arial, sans-serif' => 'Trebuchet',
		'"Courier New", Courier, monospace' => 'Courier New',
		'Impact, Haettenschweiler, "Arial Narrow Bold", sans-serif' => 'Impact',
		'Tahoma, Geneva, Verdana, sans-serif' => 'Tahoma',	
		'spacer' => '                ',
		'ABeeZee, sans-serif' => 'ABeeZee',
		'Abel, sans-serif' => 'Abel',
		'Abril Fatface, sans-serif' => 'Abril Fatface',
		'Aclonica, sans-serif' => 'Aclonica',
		'Acme, sans-serif' => 'Acme',
		'Actor, sans-serif' => 'Actor',
		'Adamina, sans-serif' => 'Adamina',
		'Advent Pro, sans-serif' => 'Advent Pro',
		'Aguafina Script, sans-serif' => 'Aguafina Script',
		'Akronim, sans-serif' => 'Akronim',
		'Aladin, sans-serif' => 'Aladin',
		'Aldrich, sans-serif' => 'Aldrich',
		'Alegreya, sans-serif' => 'Alegreya',
		'Alegreya SC, sans-serif' => 'Alegreya SC',
		'Alex Brush, sans-serif' => 'Alex Brush',
		'Alfa Slab One, sans-serif' => 'Alfa Slab One',
		'Alice, sans-serif' => 'Alice',
		'Alike, sans-serif' => 'Alike',
		'Alike Angular, sans-serif' => 'Alike Angular',
		'Allan, sans-serif' => 'Allan',
		'Allerta, sans-serif' => 'Allerta',
		'Allerta Stencil, sans-serif' => 'Allerta Stencil',
		'Allura, sans-serif' => 'Allura',
		'Almendra, sans-serif' => 'Almendra',
		'Almendra Display, sans-serif' => 'Almendra Display',
		'Almendra SC, sans-serif' => 'Almendra SC',
		'Amarante, sans-serif' => 'Amarante',
		'Amaranth, sans-serif' => 'Amaranth',
		'Amatic SC, sans-serif' => 'Amatic SC',
		'Amethysta, sans-serif' => 'Amethysta',
		'Anaheim, sans-serif' => 'Anaheim',
		'Andada, sans-serif' => 'Andada',
		'Andika, sans-serif' => 'Andika',
		'Angkor, sans-serif' => 'Angkor',
		'Annie Use Your Telescope, sans-serif' => 'Annie Use Your Telescope',
		'Anonymous Pro, sans-serif' => 'Anonymous Pro',
		'Antic, sans-serif' => 'Antic',
		'Antic Didone, sans-serif' => 'Antic Didone',
		'Antic Slab, sans-serif' => 'Antic Slab',
		'Anton, sans-serif' => 'Anton',
		'Arapey, sans-serif' => 'Arapey',
		'Arbutus, sans-serif' => 'Arbutus',
		'Arbutus Slab, sans-serif' => 'Arbutus Slab',
		'Architects Daughter, sans-serif' => 'Architects Daughter',
		'Archivo Black, sans-serif' => 'Archivo Black',
		'Archivo Narrow, sans-serif' => 'Archivo Narrow',
		'Arimo, sans-serif' => 'Arimo',
		'Arizonia, sans-serif' => 'Arizonia',
		'Armata, sans-serif' => 'Armata',
		'Artifika, sans-serif' => 'Artifika',
		'Arvo, sans-serif' => 'Arvo',
		'Asap, sans-serif' => 'Asap',
		'Asset, sans-serif' => 'Asset',
		'Astloch, sans-serif' => 'Astloch',
		'Asul, sans-serif' => 'Asul',
		'Atomic Age, sans-serif' => 'Atomic Age',
		'Aubrey, sans-serif' => 'Aubrey',
		'Audiowide, sans-serif' => 'Audiowide',
		'Autour One, sans-serif' => 'Autour One',
		'Average, sans-serif' => 'Average',
		'Average Sans, sans-serif' => 'Average Sans',
		'Averia Gruesa Libre, sans-serif' => 'Averia Gruesa Libre',
		'Averia Libre, sans-serif' => 'Averia Libre',
		'Averia Sans Libre, sans-serif' => 'Averia Sans Libre',
		'Averia Serif Libre, sans-serif' => 'Averia Serif Libre',
		'Bad Script, sans-serif' => 'Bad Script',
		'Balthazar, sans-serif' => 'Balthazar',
		'Bangers, sans-serif' => 'Bangers',
		'Basic, sans-serif' => 'Basic',
		'Battambang, sans-serif' => 'Battambang',
		'Baumans, sans-serif' => 'Baumans',
		'Bayon, sans-serif' => 'Bayon',
		'Belgrano, sans-serif' => 'Belgrano',
		'Belleza, sans-serif' => 'Belleza',
		'BenchNine, sans-serif' => 'BenchNine',
		'Bentham, sans-serif' => 'Bentham',
		'Berkshire Swash, sans-serif' => 'Berkshire Swash',
		'Bevan, sans-serif' => 'Bevan',
		'Bigelow Rules, sans-serif' => 'Bigelow Rules',
		'Bigshot One, sans-serif' => 'Bigshot One',
		'Bilbo, sans-serif' => 'Bilbo',
		'Bilbo Swash Caps, sans-serif' => 'Bilbo Swash Caps',
		'Bitter, sans-serif' => 'Bitter',
		'Black Ops One, sans-serif' => 'Black Ops One',
		'Bokor, sans-serif' => 'Bokor',
		'Bonbon, sans-serif' => 'Bonbon',
		'Boogaloo, sans-serif' => 'Boogaloo',
		'Bowlby One, sans-serif' => 'Bowlby One',
		'Bowlby One SC, sans-serif' => 'Bowlby One SC',
		'Brawler, sans-serif' => 'Brawler',
		'Bree Serif, sans-serif' => 'Bree Serif',
		'Bubblegum Sans, sans-serif' => 'Bubblegum Sans',
		'Bubbler One, sans-serif' => 'Bubbler One',
		'Buda, sans-serif' => 'Buda',
		'Buenard, sans-serif' => 'Buenard',
		'Butcherman, sans-serif' => 'Butcherman',
		'Butterfly Kids, sans-serif' => 'Butterfly Kids',
		'Cabin, sans-serif' => 'Cabin',
		'Cabin Condensed, sans-serif' => 'Cabin Condensed',
		'Cabin Sketch, sans-serif' => 'Cabin Sketch',
		'Caesar Dressing, sans-serif' => 'Caesar Dressing',
		'Cagliostro, sans-serif' => 'Cagliostro',
		'Calligraffitti, sans-serif' => 'Calligraffitti',
		'Cambo, sans-serif' => 'Cambo',
		'Candal, sans-serif' => 'Candal',
		'Cantarell, sans-serif' => 'Cantarell',
		'Cantata One, sans-serif' => 'Cantata One',
		'Cantora One, sans-serif' => 'Cantora One',
		'Capriola, sans-serif' => 'Capriola',
		'Cardo, sans-serif' => 'Cardo',
		'Carme, sans-serif' => 'Carme',
		'Carrois Gothic, sans-serif' => 'Carrois Gothic',
		'Carrois Gothic SC, sans-serif' => 'Carrois Gothic SC',
		'Carter One, sans-serif' => 'Carter One',
		'Caudex, sans-serif' => 'Caudex',
		'Cedarville Cursive, sans-serif' => 'Cedarville Cursive',
		'Ceviche One, sans-serif' => 'Ceviche One',
		'Changa One, sans-serif' => 'Changa One',
		'Chango, sans-serif' => 'Chango',
		'Chau Philomene One, sans-serif' => 'Chau Philomene One',
		'Chela One, sans-serif' => 'Chela One',
		'Chelsea Market, sans-serif' => 'Chelsea Market',
		'Chenla, sans-serif' => 'Chenla',
		'Cherry Cream Soda, sans-serif' => 'Cherry Cream Soda',
		'Cherry Swash, sans-serif' => 'Cherry Swash',
		'Chewy, sans-serif' => 'Chewy',
		'Chicle, sans-serif' => 'Chicle',
		'Chivo, sans-serif' => 'Chivo',
		'Cinzel, sans-serif' => 'Cinzel',
		'Cinzel Decorative, sans-serif' => 'Cinzel Decorative',
		'Clicker Script, sans-serif' => 'Clicker Script',
		'Coda, sans-serif' => 'Coda',
		'Coda Caption, sans-serif' => 'Coda Caption',
		'Codystar, sans-serif' => 'Codystar',
		'Combo, sans-serif' => 'Combo',
		'Comfortaa, sans-serif' => 'Comfortaa',
		'Coming Soon, sans-serif' => 'Coming Soon',
		'Concert One, sans-serif' => 'Concert One',
		'Condiment, sans-serif' => 'Condiment',
		'Content, sans-serif' => 'Content',
		'Contrail One, sans-serif' => 'Contrail One',
		'Convergence, sans-serif' => 'Convergence',
		'Cookie, sans-serif' => 'Cookie',
		'Copse, sans-serif' => 'Copse',
		'Corben, sans-serif' => 'Corben',
		'Courgette, sans-serif' => 'Courgette',
		'Cousine, sans-serif' => 'Cousine',
		'Coustard, sans-serif' => 'Coustard',
		'Covered By Your Grace, sans-serif' => 'Covered By Your Grace',
		'Crafty Girls, sans-serif' => 'Crafty Girls',
		'Creepster, sans-serif' => 'Creepster',
		'Crete Round, sans-serif' => 'Crete Round',
		'Crimson Text, sans-serif' => 'Crimson Text',
		'Croissant One, sans-serif' => 'Croissant One',
		'Crushed, sans-serif' => 'Crushed',
		'Cuprum, sans-serif' => 'Cuprum',
		'Cutive, sans-serif' => 'Cutive',
		'Cutive Mono, sans-serif' => 'Cutive Mono',
		'Damion, sans-serif' => 'Damion',
		'Dancing Script, sans-serif' => 'Dancing Script',
		'Dangrek, sans-serif' => 'Dangrek',
		'Dawning of a New Day, sans-serif' => 'Dawning of a New Day',
		'Days One, sans-serif' => 'Days One',
		'Delius, sans-serif' => 'Delius',
		'Delius Swash Caps, sans-serif' => 'Delius Swash Caps',
		'Delius Unicase, sans-serif' => 'Delius Unicase',
		'Della Respira, sans-serif' => 'Della Respira',
		'Denk One, sans-serif' => 'Denk One',
		'Devonshire, sans-serif' => 'Devonshire',
		'Didact Gothic, sans-serif' => 'Didact Gothic',
		'Diplomata, sans-serif' => 'Diplomata',
		'Diplomata SC, sans-serif' => 'Diplomata SC',
		'Domine, sans-serif' => 'Domine',
		'Donegal One, sans-serif' => 'Donegal One',
		'Doppio One, sans-serif' => 'Doppio One',
		'Dorsa, sans-serif' => 'Dorsa',
		'Dosis, sans-serif' => 'Dosis',
		'Dr Sugiyama, sans-serif' => 'Dr Sugiyama',
		'Droid Sans, sans-serif' => 'Droid Sans',
		'Droid Sans Mono, sans-serif' => 'Droid Sans Mono',
		'Droid Serif, sans-serif' => 'Droid Serif',
		'Duru Sans, sans-serif' => 'Duru Sans',
		'Dynalight, sans-serif' => 'Dynalight',
		'EB Garamond, sans-serif' => 'EB Garamond',
		'Eagle Lake, sans-serif' => 'Eagle Lake',
		'Eater, sans-serif' => 'Eater',
		'Economica, sans-serif' => 'Economica',
		'Electrolize, sans-serif' => 'Electrolize',
		'Elsie, sans-serif' => 'Elsie',
		'Elsie Swash Caps, sans-serif' => 'Elsie Swash Caps',
		'Emblema One, sans-serif' => 'Emblema One',
		'Emilys Candy, sans-serif' => 'Emilys Candy',
		'Engagement, sans-serif' => 'Engagement',
		'Englebert, sans-serif' => 'Englebert',
		'Enriqueta, sans-serif' => 'Enriqueta',
		'Erica One, sans-serif' => 'Erica One',
		'Esteban, sans-serif' => 'Esteban',
		'Euphoria Script, sans-serif' => 'Euphoria Script',
		'Ewert, sans-serif' => 'Ewert',
		'Exo, sans-serif' => 'Exo',
		'Expletus Sans, sans-serif' => 'Expletus Sans',
		'Fanwood Text, sans-serif' => 'Fanwood Text',
		'Fascinate, sans-serif' => 'Fascinate',
		'Fascinate Inline, sans-serif' => 'Fascinate Inline',
		'Faster One, sans-serif' => 'Faster One',
		'Fasthand, sans-serif' => 'Fasthand',
		'Federant, sans-serif' => 'Federant',
		'Federo, sans-serif' => 'Federo',
		'Felipa, sans-serif' => 'Felipa',
		'Fenix, sans-serif' => 'Fenix',
		'Finger Paint, sans-serif' => 'Finger Paint',
		'Fjalla One, sans-serif' => 'Fjalla One',
		'Fjord One, sans-serif' => 'Fjord One',
		'Flamenco, sans-serif' => 'Flamenco',
		'Flavors, sans-serif' => 'Flavors',
		'Fondamento, sans-serif' => 'Fondamento',
		'Fontdiner Swanky, sans-serif' => 'Fontdiner Swanky',
		'Forum, sans-serif' => 'Forum',
		'Francois One, sans-serif' => 'Francois One',
		'Freckle Face, sans-serif' => 'Freckle Face',
		'Fredericka the Great, sans-serif' => 'Fredericka the Great',
		'Fredoka One, sans-serif' => 'Fredoka One',
		'Freehand, sans-serif' => 'Freehand',
		'Fresca, sans-serif' => 'Fresca',
		'Frijole, sans-serif' => 'Frijole',
		'Fruktur, sans-serif' => 'Fruktur',
		'Fugaz One, sans-serif' => 'Fugaz One',
		'GFS Didot, sans-serif' => 'GFS Didot',
		'GFS Neohellenic, sans-serif' => 'GFS Neohellenic',
		'Gabriela, sans-serif' => 'Gabriela',
		'Gafata, sans-serif' => 'Gafata',
		'Galdeano, sans-serif' => 'Galdeano',
		'Galindo, sans-serif' => 'Galindo',
		'Gentium Basic, sans-serif' => 'Gentium Basic',
		'Gentium Book Basic, sans-serif' => 'Gentium Book Basic',
		'Geo, sans-serif' => 'Geo',
		'Geostar, sans-serif' => 'Geostar',
		'Geostar Fill, sans-serif' => 'Geostar Fill',
		'Germania One, sans-serif' => 'Germania One',
		'Gilda Display, sans-serif' => 'Gilda Display',
		'Give You Glory, sans-serif' => 'Give You Glory',
		'Glass Antiqua, sans-serif' => 'Glass Antiqua',
		'Glegoo, sans-serif' => 'Glegoo',
		'Gloria Hallelujah, sans-serif' => 'Gloria Hallelujah',
		'Goblin One, sans-serif' => 'Goblin One',
		'Gochi Hand, sans-serif' => 'Gochi Hand',
		'Gorditas, sans-serif' => 'Gorditas',
		'Goudy Bookletter 1911, sans-serif' => 'Goudy Bookletter 1911',
		'Graduate, sans-serif' => 'Graduate',
		'Grand Hotel, sans-serif' => 'Grand Hotel',
		'Gravitas One, sans-serif' => 'Gravitas One',
		'Great Vibes, sans-serif' => 'Great Vibes',
		'Griffy, sans-serif' => 'Griffy',
		'Gruppo, sans-serif' => 'Gruppo',
		'Gudea, sans-serif' => 'Gudea',
		'Habibi, sans-serif' => 'Habibi',
		'Hammersmith One, sans-serif' => 'Hammersmith One',
		'Hanalei, sans-serif' => 'Hanalei',
		'Hanalei Fill, sans-serif' => 'Hanalei Fill',
		'Handlee, sans-serif' => 'Handlee',
		'Hanuman, sans-serif' => 'Hanuman',
		'Happy Monkey, sans-serif' => 'Happy Monkey',
		'Headland One, sans-serif' => 'Headland One',
		'Henny Penny, sans-serif' => 'Henny Penny',
		'Herr Von Muellerhoff, sans-serif' => 'Herr Von Muellerhoff',
		'Holtwood One SC, sans-serif' => 'Holtwood One SC',
		'Homemade Apple, sans-serif' => 'Homemade Apple',
		'Homenaje, sans-serif' => 'Homenaje',
		'IM Fell DW Pica, sans-serif' => 'IM Fell DW Pica',
		'IM Fell DW Pica SC, sans-serif' => 'IM Fell DW Pica SC',
		'IM Fell Double Pica, sans-serif' => 'IM Fell Double Pica',
		'IM Fell Double Pica SC, sans-serif' => 'IM Fell Double Pica SC',
		'IM Fell English, sans-serif' => 'IM Fell English',
		'IM Fell English SC, sans-serif' => 'IM Fell English SC',
		'IM Fell French Canon, sans-serif' => 'IM Fell French Canon',
		'IM Fell French Canon SC, sans-serif' => 'IM Fell French Canon SC',
		'IM Fell Great Primer, sans-serif' => 'IM Fell Great Primer',
		'IM Fell Great Primer SC, sans-serif' => 'IM Fell Great Primer SC',
		'Iceberg, sans-serif' => 'Iceberg',
		'Iceland, sans-serif' => 'Iceland',
		'Imprima, sans-serif' => 'Imprima',
		'Inconsolata, sans-serif' => 'Inconsolata',
		'Inder, sans-serif' => 'Inder',
		'Indie Flower, sans-serif' => 'Indie Flower',
		'Inika, sans-serif' => 'Inika',
		'Irish Grover, sans-serif' => 'Irish Grover',
		'Istok Web, sans-serif' => 'Istok Web',
		'Italiana, sans-serif' => 'Italiana',
		'Italianno, sans-serif' => 'Italianno',
		'Jacques Francois, sans-serif' => 'Jacques Francois',
		'Jacques Francois Shadow, sans-serif' => 'Jacques Francois Shadow',
		'Jim Nightshade, sans-serif' => 'Jim Nightshade',
		'Jockey One, sans-serif' => 'Jockey One',
		'Jolly Lodger, sans-serif' => 'Jolly Lodger',
		'Josefin Sans, sans-serif' => 'Josefin Sans',
		'Josefin Slab, sans-serif' => 'Josefin Slab',
		'Joti One, sans-serif' => 'Joti One',
		'Judson, sans-serif' => 'Judson',
		'Julee, sans-serif' => 'Julee',
		'Julius Sans One, sans-serif' => 'Julius Sans One',
		'Junge, sans-serif' => 'Junge',
		'Jura, sans-serif' => 'Jura',
		'Just Another Hand, sans-serif' => 'Just Another Hand',
		'Just Me Again Down Here, sans-serif' => 'Just Me Again Down Here',
		'Kameron, sans-serif' => 'Kameron',
		'Karla, sans-serif' => 'Karla',
		'Kaushan Script, sans-serif' => 'Kaushan Script',
		'Kavoon, sans-serif' => 'Kavoon',
		'Keania One, sans-serif' => 'Keania One',
		'Kelly Slab, sans-serif' => 'Kelly Slab',
		'Kenia, sans-serif' => 'Kenia',
		'Khmer, sans-serif' => 'Khmer',
		'Kite One, sans-serif' => 'Kite One',
		'Knewave, sans-serif' => 'Knewave',
		'Kotta One, sans-serif' => 'Kotta One',
		'Koulen, sans-serif' => 'Koulen',
		'Kranky, sans-serif' => 'Kranky',
		'Kreon, sans-serif' => 'Kreon',
		'Kristi, sans-serif' => 'Kristi',
		'Krona One, sans-serif' => 'Krona One',
		'La Belle Aurore, sans-serif' => 'La Belle Aurore',
		'Lancelot, sans-serif' => 'Lancelot',
		'Lato, sans-serif' => 'Lato',
		'League Script, sans-serif' => 'League Script',
		'Leckerli One, sans-serif' => 'Leckerli One',
		'Ledger, sans-serif' => 'Ledger',
		'Lekton, sans-serif' => 'Lekton',
		'Lemon, sans-serif' => 'Lemon',
		'Libre Baskerville, sans-serif' => 'Libre Baskerville',
		'Life Savers, sans-serif' => 'Life Savers',
		'Lilita One, sans-serif' => 'Lilita One',
		'Limelight, sans-serif' => 'Limelight',
		'Linden Hill, sans-serif' => 'Linden Hill',
		'Lobster, sans-serif' => 'Lobster',
		'Lobster Two, sans-serif' => 'Lobster Two',
		'Londrina Outline, sans-serif' => 'Londrina Outline',
		'Londrina Shadow, sans-serif' => 'Londrina Shadow',
		'Londrina Sketch, sans-serif' => 'Londrina Sketch',
		'Londrina Solid, sans-serif' => 'Londrina Solid',
		'Lora, sans-serif' => 'Lora',
		'Love Ya Like A Sister, sans-serif' => 'Love Ya Like A Sister',
		'Loved by the King, sans-serif' => 'Loved by the King',
		'Lovers Quarrel, sans-serif' => 'Lovers Quarrel',
		'Luckiest Guy, sans-serif' => 'Luckiest Guy',
		'Lusitana, sans-serif' => 'Lusitana',
		'Lustria, sans-serif' => 'Lustria',
		'Macondo, sans-serif' => 'Macondo',
		'Macondo Swash Caps, sans-serif' => 'Macondo Swash Caps',
		'Magra, sans-serif' => 'Magra',
		'Maiden Orange, sans-serif' => 'Maiden Orange',
		'Mako, sans-serif' => 'Mako',
		'Marcellus, sans-serif' => 'Marcellus',
		'Marcellus SC, sans-serif' => 'Marcellus SC',
		'Marck Script, sans-serif' => 'Marck Script',
		'Margarine, sans-serif' => 'Margarine',
		'Marko One, sans-serif' => 'Marko One',
		'Marmelad, sans-serif' => 'Marmelad',
		'Marvel, sans-serif' => 'Marvel',
		'Mate, sans-serif' => 'Mate',
		'Mate SC, sans-serif' => 'Mate SC',
		'Maven Pro, sans-serif' => 'Maven Pro',
		'McLaren, sans-serif' => 'McLaren',
		'Meddon, sans-serif' => 'Meddon',
		'MedievalSharp, sans-serif' => 'MedievalSharp',
		'Medula One, sans-serif' => 'Medula One',
		'Megrim, sans-serif' => 'Megrim',
		'Meie Script, sans-serif' => 'Meie Script',
		'Merienda, sans-serif' => 'Merienda',
		'Merienda One, sans-serif' => 'Merienda One',
		'Merriweather, sans-serif' => 'Merriweather',
		'Merriweather Sans, sans-serif' => 'Merriweather Sans',
		'Metal, sans-serif' => 'Metal',
		'Metal Mania, sans-serif' => 'Metal Mania',
		'Metamorphous, sans-serif' => 'Metamorphous',
		'Metrophobic, sans-serif' => 'Metrophobic',
		'Michroma, sans-serif' => 'Michroma',
		'Milonga, sans-serif' => 'Milonga',
		'Miltonian, sans-serif' => 'Miltonian',
		'Miltonian Tattoo, sans-serif' => 'Miltonian Tattoo',
		'Miniver, sans-serif' => 'Miniver',
		'Miss Fajardose, sans-serif' => 'Miss Fajardose',
		'Modern Antiqua, sans-serif' => 'Modern Antiqua',
		'Molengo, sans-serif' => 'Molengo',
		'Molle, sans-serif' => 'Molle',
		'Monda, sans-serif' => 'Monda',
		'Monofett, sans-serif' => 'Monofett',
		'Monoton, sans-serif' => 'Monoton',
		'Monsieur La Doulaise, sans-serif' => 'Monsieur La Doulaise',
		'Montaga, sans-serif' => 'Montaga',
		'Montez, sans-serif' => 'Montez',
		'Montserrat, sans-serif' => 'Montserrat',
		'Montserrat Alternates, sans-serif' => 'Montserrat Alternates',
		'Montserrat Subrayada, sans-serif' => 'Montserrat Subrayada',
		'Moul, sans-serif' => 'Moul',
		'Moulpali, sans-serif' => 'Moulpali',
		'Mountains of Christmas, sans-serif' => 'Mountains of Christmas',
		'Mouse Memoirs, sans-serif' => 'Mouse Memoirs',
		'Mr Bedfort, sans-serif' => 'Mr Bedfort',
		'Mr Dafoe, sans-serif' => 'Mr Dafoe',
		'Mr De Haviland, sans-serif' => 'Mr De Haviland',
		'Mrs Saint Delafield, sans-serif' => 'Mrs Saint Delafield',
		'Mrs Sheppards, sans-serif' => 'Mrs Sheppards',
		'Muli, sans-serif' => 'Muli',
		'Mystery Quest, sans-serif' => 'Mystery Quest',
		'Neucha, sans-serif' => 'Neucha',
		'Neuton, sans-serif' => 'Neuton',
		'New Rocker, sans-serif' => 'New Rocker',
		'News Cycle, sans-serif' => 'News Cycle',
		'Niconne, sans-serif' => 'Niconne',
		'Nixie One, sans-serif' => 'Nixie One',
		'Nobile, sans-serif' => 'Nobile',
		'Nokora, sans-serif' => 'Nokora',
		'Norican, sans-serif' => 'Norican',
		'Nosifer, sans-serif' => 'Nosifer',
		'Nothing You Could Do, sans-serif' => 'Nothing You Could Do',
		'Noticia Text, sans-serif' => 'Noticia Text',
		'Nova Cut, sans-serif' => 'Nova Cut',
		'Nova Flat, sans-serif' => 'Nova Flat',
		'Nova Mono, sans-serif' => 'Nova Mono',
		'Nova Oval, sans-serif' => 'Nova Oval',
		'Nova Round, sans-serif' => 'Nova Round',
		'Nova Script, sans-serif' => 'Nova Script',
		'Nova Slim, sans-serif' => 'Nova Slim',
		'Nova Square, sans-serif' => 'Nova Square',
		'Numans, sans-serif' => 'Numans',
		'Nunito, sans-serif' => 'Nunito',
		'Odor Mean Chey, sans-serif' => 'Odor Mean Chey',
		'Offside, sans-serif' => 'Offside',
		'Old Standard TT, sans-serif' => 'Old Standard TT',
		'Oldenburg, sans-serif' => 'Oldenburg',
		'Oleo Script, sans-serif' => 'Oleo Script',
		'Oleo Script Swash Caps, sans-serif' => 'Oleo Script Swash Caps',
		'Open Sans, sans-serif' => 'Open Sans',
		'Open Sans Condensed, sans-serif' => 'Open Sans Condensed',
		'Oranienbaum, sans-serif' => 'Oranienbaum',
		'Orbitron, sans-serif' => 'Orbitron',
		'Oregano, sans-serif' => 'Oregano',
		'Orienta, sans-serif' => 'Orienta',
		'Original Surfer, sans-serif' => 'Original Surfer',
		'Oswald, sans-serif' => 'Oswald',
		'Over the Rainbow, sans-serif' => 'Over the Rainbow',
		'Overlock, sans-serif' => 'Overlock',
		'Overlock SC, sans-serif' => 'Overlock SC',
		'Ovo, sans-serif' => 'Ovo',
		'Oxygen, sans-serif' => 'Oxygen',
		'Oxygen Mono, sans-serif' => 'Oxygen Mono',
		'PT Mono, sans-serif' => 'PT Mono',
		'PT Sans, sans-serif' => 'PT Sans',
		'PT Sans Caption, sans-serif' => 'PT Sans Caption',
		'PT Sans Narrow, sans-serif' => 'PT Sans Narrow',
		'PT Serif, sans-serif' => 'PT Serif',
		'PT Serif Caption, sans-serif' => 'PT Serif Caption',
		'Pacifico, sans-serif' => 'Pacifico',
		'Paprika, sans-serif' => 'Paprika',
		'Parisienne, sans-serif' => 'Parisienne',
		'Passero One, sans-serif' => 'Passero One',
		'Passion One, sans-serif' => 'Passion One',
		'Patrick Hand, sans-serif' => 'Patrick Hand',
		'Patrick Hand SC, sans-serif' => 'Patrick Hand SC',
		'Patua One, sans-serif' => 'Patua One',
		'Paytone One, sans-serif' => 'Paytone One',
		'Peralta, sans-serif' => 'Peralta',
		'Permanent Marker, sans-serif' => 'Permanent Marker',
		'Petit Formal Script, sans-serif' => 'Petit Formal Script',
		'Petrona, sans-serif' => 'Petrona',
		'Philosopher, sans-serif' => 'Philosopher',
		'Piedra, sans-serif' => 'Piedra',
		'Pinyon Script, sans-serif' => 'Pinyon Script',
		'Pirata One, sans-serif' => 'Pirata One',
		'Plaster, sans-serif' => 'Plaster',
		'Play, sans-serif' => 'Play',
		'Playball, sans-serif' => 'Playball',
		'Playfair Display, sans-serif' => 'Playfair Display',
		'Playfair Display SC, sans-serif' => 'Playfair Display SC',
		'Podkova, sans-serif' => 'Podkova',
		'Poiret One, sans-serif' => 'Poiret One',
		'Poller One, sans-serif' => 'Poller One',
		'Poly, sans-serif' => 'Poly',
		'Pompiere, sans-serif' => 'Pompiere',
		'Pontano Sans, sans-serif' => 'Pontano Sans',
		'Port Lligat Sans, sans-serif' => 'Port Lligat Sans',
		'Port Lligat Slab, sans-serif' => 'Port Lligat Slab',
		'Prata, sans-serif' => 'Prata',
		'Preahvihear, sans-serif' => 'Preahvihear',
		'Press Start 2P, sans-serif' => 'Press Start 2P',
		'Princess Sofia, sans-serif' => 'Princess Sofia',
		'Prociono, sans-serif' => 'Prociono',
		'Prosto One, sans-serif' => 'Prosto One',
		'Puritan, sans-serif' => 'Puritan',
		'Purple Purse, sans-serif' => 'Purple Purse',
		'Quando, sans-serif' => 'Quando',
		'Quantico, sans-serif' => 'Quantico',
		'Quattrocento, sans-serif' => 'Quattrocento',
		'Quattrocento Sans, sans-serif' => 'Quattrocento Sans',
		'Questrial, sans-serif' => 'Questrial',
		'Quicksand, sans-serif' => 'Quicksand',
		'Quintessential, sans-serif' => 'Quintessential',
		'Qwigley, sans-serif' => 'Qwigley',
		'Racing Sans One, sans-serif' => 'Racing Sans One',
		'Radley, sans-serif' => 'Radley',
		'Raleway, sans-serif' => 'Raleway',
		'Raleway Dots, sans-serif' => 'Raleway Dots',
		'Rambla, sans-serif' => 'Rambla',
		'Rammetto One, sans-serif' => 'Rammetto One',
		'Ranchers, sans-serif' => 'Ranchers',
		'Rancho, sans-serif' => 'Rancho',
		'Rationale, sans-serif' => 'Rationale',
		'Redressed, sans-serif' => 'Redressed',
		'Reenie Beanie, sans-serif' => 'Reenie Beanie',
		'Revalia, sans-serif' => 'Revalia',
		'Ribeye, sans-serif' => 'Ribeye',
		'Ribeye Marrow, sans-serif' => 'Ribeye Marrow',
		'Righteous, sans-serif' => 'Righteous',
		'Risque, sans-serif' => 'Risque',
		'Roboto, sans-serif' => 'Roboto',
		'Roboto Condensed, sans-serif' => 'Roboto Condensed',
		'Rochester, sans-serif' => 'Rochester',
		'Rock Salt, sans-serif' => 'Rock Salt',
		'Rokkitt, sans-serif' => 'Rokkitt',
		'Romanesco, sans-serif' => 'Romanesco',
		'Ropa Sans, sans-serif' => 'Ropa Sans',
		'Rosario, sans-serif' => 'Rosario',
		'Rosarivo, sans-serif' => 'Rosarivo',
		'Rouge Script, sans-serif' => 'Rouge Script',
		'Ruda, sans-serif' => 'Ruda',
		'Rufina, sans-serif' => 'Rufina',
		'Ruge Boogie, sans-serif' => 'Ruge Boogie',
		'Ruluko, sans-serif' => 'Ruluko',
		'Rum Raisin, sans-serif' => 'Rum Raisin',
		'Ruslan Display, sans-serif' => 'Ruslan Display',
		'Russo One, sans-serif' => 'Russo One',
		'Ruthie, sans-serif' => 'Ruthie',
		'Rye, sans-serif' => 'Rye',
		'Sacramento, sans-serif' => 'Sacramento',
		'Sail, sans-serif' => 'Sail',
		'Salsa, sans-serif' => 'Salsa',
		'Sanchez, sans-serif' => 'Sanchez',
		'Sancreek, sans-serif' => 'Sancreek',
		'Sansita One, sans-serif' => 'Sansita One',
		'Sarina, sans-serif' => 'Sarina',
		'Satisfy, sans-serif' => 'Satisfy',
		'Scada, sans-serif' => 'Scada',
		'Schoolbell, sans-serif' => 'Schoolbell',
		'Seaweed Script, sans-serif' => 'Seaweed Script',
		'Sevillana, sans-serif' => 'Sevillana',
		'Seymour One, sans-serif' => 'Seymour One',
		'Shadows Into Light, sans-serif' => 'Shadows Into Light',
		'Shadows Into Light Two, sans-serif' => 'Shadows Into Light Two',
		'Shanti, sans-serif' => 'Shanti',
		'Share, sans-serif' => 'Share',
		'Share Tech, sans-serif' => 'Share Tech',
		'Share Tech Mono, sans-serif' => 'Share Tech Mono',
		'Shojumaru, sans-serif' => 'Shojumaru',
		'Short Stack, sans-serif' => 'Short Stack',
		'Siemreap, sans-serif' => 'Siemreap',
		'Sigmar One, sans-serif' => 'Sigmar One',
		'Signika, sans-serif' => 'Signika',
		'Signika Negative, sans-serif' => 'Signika Negative',
		'Simonetta, sans-serif' => 'Simonetta',
		'Sintony, sans-serif' => 'Sintony',
		'Sirin Stencil, sans-serif' => 'Sirin Stencil',
		'Six Caps, sans-serif' => 'Six Caps',
		'Skranji, sans-serif' => 'Skranji',
		'Slackey, sans-serif' => 'Slackey',
		'Smokum, sans-serif' => 'Smokum',
		'Smythe, sans-serif' => 'Smythe',
		'Sniglet, sans-serif' => 'Sniglet',
		'Snippet, sans-serif' => 'Snippet',
		'Snowburst One, sans-serif' => 'Snowburst One',
		'Sofadi One, sans-serif' => 'Sofadi One',
		'Sofia, sans-serif' => 'Sofia',
		'Sonsie One, sans-serif' => 'Sonsie One',
		'Sorts Mill Goudy, sans-serif' => 'Sorts Mill Goudy',
		'Source Code Pro, sans-serif' => 'Source Code Pro',
		'Source Sans Pro, sans-serif' => 'Source Sans Pro',
		'Special Elite, sans-serif' => 'Special Elite',
		'Spicy Rice, sans-serif' => 'Spicy Rice',
		'Spinnaker, sans-serif' => 'Spinnaker',
		'Spirax, sans-serif' => 'Spirax',
		'Squada One, sans-serif' => 'Squada One',
		'Stalemate, sans-serif' => 'Stalemate',
		'Stalinist One, sans-serif' => 'Stalinist One',
		'Stardos Stencil, sans-serif' => 'Stardos Stencil',
		'Stint Ultra Condensed, sans-serif' => 'Stint Ultra Condensed',
		'Stint Ultra Expanded, sans-serif' => 'Stint Ultra Expanded',
		'Stoke, sans-serif' => 'Stoke',
		'Strait, sans-serif' => 'Strait',
		'Sue Ellen Francisco, sans-serif' => 'Sue Ellen Francisco',
		'Sunshiney, sans-serif' => 'Sunshiney',
		'Supermercado One, sans-serif' => 'Supermercado One',
		'Suwannaphum, sans-serif' => 'Suwannaphum',
		'Swanky and Moo Moo, sans-serif' => 'Swanky and Moo Moo',
		'Syncopate, sans-serif' => 'Syncopate',
		'Tangerine, sans-serif' => 'Tangerine',
		'Taprom, sans-serif' => 'Taprom',
		'Tauri, sans-serif' => 'Tauri',
		'Telex, sans-serif' => 'Telex',
		'Tenor Sans, sans-serif' => 'Tenor Sans',
		'Text Me One, sans-serif' => 'Text Me One',
		'The Girl Next Door, sans-serif' => 'The Girl Next Door',
		'Tienne, sans-serif' => 'Tienne',
		'Tinos, sans-serif' => 'Tinos',
		'Titan One, sans-serif' => 'Titan One',
		'Titillium Web, sans-serif' => 'Titillium Web',
		'Trade Winds, sans-serif' => 'Trade Winds',
		'Trocchi, sans-serif' => 'Trocchi',
		'Trochut, sans-serif' => 'Trochut',
		'Trykker, sans-serif' => 'Trykker',
		'Tulpen One, sans-serif' => 'Tulpen One',
		'Ubuntu, sans-serif' => 'Ubuntu',
		'Ubuntu Condensed, sans-serif' => 'Ubuntu Condensed',
		'Ubuntu Mono, sans-serif' => 'Ubuntu Mono',
		'Ultra, sans-serif' => 'Ultra',
		'Uncial Antiqua, sans-serif' => 'Uncial Antiqua',
		'Underdog, sans-serif' => 'Underdog',
		'Unica One, sans-serif' => 'Unica One',
		'UnifrakturCook, sans-serif' => 'UnifrakturCook',
		'UnifrakturMaguntia, sans-serif' => 'UnifrakturMaguntia',
		'Unkempt, sans-serif' => 'Unkempt',
		'Unlock, sans-serif' => 'Unlock',
		'Unna, sans-serif' => 'Unna',
		'VT323, sans-serif' => 'VT323',
		'Vampiro One, sans-serif' => 'Vampiro One',
		'Varela, sans-serif' => 'Varela',
		'Varela Round, sans-serif' => 'Varela Round',
		'Vast Shadow, sans-serif' => 'Vast Shadow',
		'Vibur, sans-serif' => 'Vibur',
		'Vidaloka, sans-serif' => 'Vidaloka',
		'Viga, sans-serif' => 'Viga',
		'Voces, sans-serif' => 'Voces',
		'Volkhov, sans-serif' => 'Volkhov',
		'Vollkorn, sans-serif' => 'Vollkorn',
		'Voltaire, sans-serif' => 'Voltaire',
		'Waiting for the Sunrise, sans-serif' => 'Waiting for the Sunrise',
		'Wallpoet, sans-serif' => 'Wallpoet',
		'Walter Turncoat, sans-serif' => 'Walter Turncoat',
		'Warnes, sans-serif' => 'Warnes',
		'Wellfleet, sans-serif' => 'Wellfleet',
		'Wendy One, sans-serif' => 'Wendy One',
		'Wire One, sans-serif' => 'Wire One',
		'Yanone Kaffeesatz, sans-serif' => 'Yanone Kaffeesatz',
		'Yellowtail, sans-serif' => 'Yellowtail',
		'Yeseva One, sans-serif' => 'Yeseva One',
		'Yesteryear, sans-serif' => 'Yesteryear',
		'Zeyada, sans-serif' => 'Zeyada'
		);		
	return $fonts;
}


?>
