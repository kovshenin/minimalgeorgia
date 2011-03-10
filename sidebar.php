<?php
/**
 * The Holy Sidebar
 *
 * There's one widgetized area that can be used. In case it isn't
 * we fall back with some static content.
 *
 * @package WordPress
 * @subpackage Minimal Georgia
 * @since 1.0
 */
?>
		<div class="grid_2 sidebar">
			<?php if (!dynamic_sidebar()): ?>
			<div class="widget">
				<?php get_search_form(); ?>
			</div>
			
			<div class="widget">
				<p class="heading"><?php _e('Hey There!', 'minimalgeorgia'); ?></p>
				<p><?php _e('Welcome to the Minimal Georgia theme. You\'re seeing this text because you haven\'t configured your widgets. Browse to the Widgets section in your admin panel.', 'minimalgeorgia'); ?></p>
				<p><a href="http://kovshenin.com/wordpress/themes/minimal-georgia/"><?php _e('About the theme &raquo;', 'minimalgeorgia'); ?></a></p>
			</div>

			<div class="widget">
				<p class="heading"><?php _e('Archives', 'minimalgeorgia'); ?></p>
				<ul>
					<?php wp_get_archives(); ?>
				</ul>
			</div>
			
			<div class="widget">
				<p class="heading"><?php _e('Categories', 'minimalgeorgia'); ?></p>
				<ul>
					<?php wp_list_categories('title_li='); ?>
				</ul>
			</div>
			
			<div class="widget">
				<p class="heading"><?php _e('Blogroll', 'minimalgeorgia'); ?></p>
				<ul>
					<?php wp_list_bookmarks('title_li=&categorize=0'); ?>
				</ul>
			</div>
			<?php endif; ?>
		</div>
