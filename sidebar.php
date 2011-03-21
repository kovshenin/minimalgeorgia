<?php
/**
 * The Holy Sidebar
 *
 * There's one widgetized area that can be used. In case it isn't
 * we fall back with some static content.
 *
 * @package WordPress
 * @subpackage Minimal Georgia
 * @version 1.4
 */
?>
		<div class="grid_2 sidebar">
			<?php if (!dynamic_sidebar()): ?>
			<?php
				// Sidebar arguments, should be same as in functions.php
				$sidebar_args = array(
					'before_widget' => '<div class="widget">',
					'after_widget' => '</div>',
					'before_title' => '<p class="heading">',
					'after_title' => '</p>',
				);
				
				// The Search widget
				the_widget('WP_Widget_Search', array(), $sidebar_args);
				
				// Color Picker
				the_widget('MinimalGeorgiaColorPickerWidget', 'title=' . __('Color Schemes', 'minimalgeorgia'), $sidebar_args);
				
				// Welcome Note
				$about_the_theme = "\n\n" . '<a href="http://kovshenin.com/wordpress/themes/minimal-georgia/">' . __('About the theme &raquo;', 'minimalgeorgia') . '</a>';
				the_widget('WP_Widget_Text', array(
					'title' => __('Hey There!', 'minimalgeorgia'),
					'text' => __("Welcome to the Minimal Georgia theme. You're seeing this text because you haven't configured your widgets. Browse to the Widgets section in your admin panel.", 'minimalgeorgia') . $about_the_theme,
					'filter' => true // adds paragraphs
				), $sidebar_args);
				
				// And the rest
				the_widget('WP_Widget_Archives', array(), $sidebar_args);
				the_widget('WP_Widget_Categories', array(), $sidebar_args);
				the_widget('WP_Widget_Links', array(), $sidebar_args);
				
			?>
			<?php endif; ?>
		</div>
