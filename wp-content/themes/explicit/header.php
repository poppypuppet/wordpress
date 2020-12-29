<!DOCTYPE HTML>

<html <?php language_attributes(); ?>>

<head>

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    
    <?php if(!it_get_setting('responsive_disable')) { ?>
    	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <?php } ?>
	
	<?php if (is_search()) { ?>
	   <meta name="robots" content="noindex, nofollow" /> 
	<?php } ?>

	<title><?php wp_title( '|', true, 'right' );?></title>
    
    <?php do_action('it_head'); ?>    
    	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
    
    <?php echo it_get_setting('analytics_code'); // google analytics code ?> 
    
	<?php wp_head(); ?>
	
</head>

<?php $body_class = 'it-background woocommerce bp-page';
if(it_get_setting('responsive_disable')) $body_class .= ' responsive-disable'; ?>

<body <?php body_class($body_class); ?>>

    <div id="ajax-error"></div>
    
    <div id="fb-root"></div>
    
    <?php it_get_template_part('header'); # header bar containing logo and ad ?>
    
    <?php it_get_template_part('sticky'); # the sticky bar ?>
    
    <?php #determine how far down to push main site content
    $header_disable = it_get_setting('logobar_disable_global');
    $sticky_disable = it_get_setting('sticky_disable_global');
    $cssheader = $header_disable ? ' no-header' : '';
    $csssticky = $sticky_disable ? ' no-sticky' : '';
    ?>
    
    <div class="after-header<?php echo $cssheader . $csssticky; ?>">
    
    <?php echo it_background_ad(); #full screen background ad ?>