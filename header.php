<!DOCTYPE html>
<html>
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/reset.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/960.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div class="header-fill">
		<div class="container_8 header">
			<div class="grid_1">
				&nbsp;
			</div>
			<div class="grid_2">
				<a href="<?php bloginfo('url'); ?>" class="logo"><?php bloginfo('name'); ?></a>
			</div>
			<div class="grid_5">
				<?php wp_nav_menu(array('menu' => 'primary', 'menu_id' => 'menu-header', 'theme_location' => 'primary', 'depth' => 1)); ?> 
			</div>
		</div>
	</div>
	
	<div class="clear"></div>
	<div class="container_8 content">
