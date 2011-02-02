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
			<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar()): ?>
			<div class="widget">
				<form role="search" method="get" id="searchform" action="<?php echo home_url(); ?>">
					<div>
						<label class="screen-reader-text" for="s"><?php _e('Search for:', 'minimalgeorgia'); ?></label>
						<input type="text" value="" name="s" id="s">
						<input type="submit" id="searchsubmit" value="<?php _e('Search', 'minimalgeorgia'); ?>">
						</div>
				</form>
			</div>
			
			<div class="widget">
				<p class="heading"><?php _e('Hey There!', 'minimalgeorgia'); ?></p>
				<p><?php _e('Welcome to the Minimal Georgia theme. You\'re seeing this text because you haven\'t configured your widgets. Browse to the Widgets section in your admin panel.', 'minimalgeorgia'); ?></p>
				<p><a href="http://kovshenin.com/wordpress/themes/minimal-georgia/"><?php _e('About the theme &raquo;', 'minimalgeorgia'); ?></a></p>
			</div>

			<div class="widget">
				<p class="heading"><?php _e('Archives', 'minimalgeorgia'); ?></p>
				<ul>
					<li><a href="#">January 2011</a></li>
					<li><a href="#">December 2010</a></li>
					<li><a href="#">November 2010</a></li>
					<li><a href="#">October 2010</a></li>
					<li><a href="#">September 2010</a></li>
					<li><a href="#">August 2010</a></li>
				</ul>
			</div>
			
			<div class="widget">
				<p class="heading"><?php _e('Categories', 'minimalgeorgia'); ?></p>
				<ul>
					<li><a href="#">WordPress</a></li>
					<li><a href="#">Development</a></li>
					<li><a href="#">Design</a></li>
					<li><a href="#">Python</a></li>
					<li><a href="#">App Engine</a></li>
				</ul>
			</div>
			
			<div class="widget">
				<p class="heading"><?php _e('Blogroll', 'minimalgeorgia'); ?></p>
				<ul>
					<li><a href="http://smashingmagazine.com">Smashing Magazine</a></li>
					<li><a href="http://mashable.com">Mashable</a></li>
					<li><a href="http://techcrunch.com">TechCrunch</a></li>
				</ul>
			</div>
			<?php endif; ?>
		</div>
