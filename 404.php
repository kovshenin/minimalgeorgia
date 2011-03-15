<?php
/**
 * The 404 Template
 *
 * There's a menu here that could be edited through the WordPress
 * Admininstration area, other than that, nothing much, handles
 * 404 requests, duh!
 *
 * @package WordPress
 * @subpackage Minimal Georgia
 * @version 1.3
 */

get_header(); ?>
		<div class="grid_6 posts-list">
			<div class="hentry">
				<div class="grid_1 alpha right-arrow-container">
					<span class="right-arrow">&nbsp;</span>
					&nbsp;
				</div>
				<div class="grid_5 omega content-container">
					<h1 class="post-title"><?php _e('Not Found', 'minimalgeorgia'); ?></h1>
					<div class="post-content no-title">
						<p><?php _e("We're deeply sorry, but the page you were looking for cannot be found. Try something from the list below:", 'minimalgeorgia'); ?></p>
						<?php wp_nav_menu(array('menu' => 'menu-404', 'menu_id' => 'menu-404', 'theme_location' => 'menu-404')); ?> 
					</div>
				</div>
			</div>
		</div>
		<?php get_sidebar(); ?>
<?php get_footer(); ?>
