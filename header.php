<?php
/**
 * The Header Area
 *
 * Appropriate stylesheets, wp_head and color-scheme selection
 * using the body class. The primary navigation menu is present
 * here.
 *
 * @package WordPress
 * @subpackage Minimal Georgia
 * @since 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/reset.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/960.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<?php if (is_singular() && get_option('thread_comments')) { wp_enqueue_script('comment-reply'); } ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class('mg-' . get_option('mg-color-scheme')); ?>>
	<div class="header-fill">
		<div class="container_8 header">
			<div class="grid_1">
				&nbsp;
			</div>
			<div class="grid_2">
				<a href="<?php echo home_url(); ?>" class="logo"><?php bloginfo('name'); ?></a>
			</div>
			<div class="grid_5 pre-menu">
				<?php wp_nav_menu(array('menu' => 'primary', 'menu_id' => 'menu-header', 'theme_location' => 'primary', 'depth' => 1)); ?> 
			</div>
		</div>
	</div>
	
	<div class="clear"></div>
	<div class="container_8 content">
