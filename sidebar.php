<?php
/**
 * The Holy Sidebar
 *
 * There's one widgetized area that can be used. In case it isn't
 * we fall back with some static content.
 *
 * @package WordPress
 * @subpackage Minimal Georgia
 * @version 1.3
 */
?>
		<div class="grid_2 sidebar">
			<?php if (!dynamic_sidebar()): ?>
			<div class="widget">
				<?php get_search_form(); ?>
			</div>
			
			<div class="widget">
				<p class="heading"><?php _e('Color Schemes', 'minimalgeorgia'); ?></p>
				<p class="color-scheme-selector">
					<a data="red" href="#" title="<?php _e('Inferno', 'minimalgeorgia'); ?>"><?php _e('Inferno', 'minimalgeorgia'); ?></a>
					<a data="blue" href="#" title="<?php _e('Sapphire', 'minimalgeorgia'); ?>"><?php _e('Sapphire', 'minimalgeorgia'); ?></a>
					<a data="green" href="#" title="<?php _e('Emeraldo', 'minimalgeorgia'); ?>"><?php _e('Emeraldo', 'minimalgeorgia'); ?></a>
					<a data="gray" href="#" title="<?php _e('Silent Gray', 'minimalgeorgia'); ?>"><?php _e('Silent Gray', 'minimalgeorgia'); ?></a>
					<a data="purple" href="#" title="<?php _e('Liquid Purple', 'minimalgeorgia'); ?>"><?php _e('Liquid Purple', 'minimalgeorgia'); ?></a>
				</p>
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
