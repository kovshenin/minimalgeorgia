		<div class="grid_2 sidebar">
			<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar()): ?>
			<div class="widget">
				<form role="search" method="get" id="searchform" action="<?php bloginfo('url'); ?>">
					<div>
						<label class="screen-reader-text" for="s"><?php _e('Search for:', 'minimalgeorgia'); ?></label>
						<input type="text" value="" name="s" id="s">
						<input type="submit" id="searchsubmit" value="<?php _e('Search', 'minimalgeorgia'); ?>">
						</div>
				</form>
			</div>
			
			<div class="widget">
				<p class="heading">Hey There!</p>
				<p>Welcome to the Minimal Georgia theme. You're seeing this widget because you haven't
				configured your sidebar widgets. Browse to Appearance &mdash; Widgets in your admin panel.</p>
				<p><a href="http://kovshenin.com/wordpress/themes/minimal-georgia/">About the theme &raquo;</a></p>
			</div>
			
			<div class="widget">
				<p class="heading">Archives</p>
				<ul>
					<li><a href="#">October 2010</a></li>
					<li><a href="#">October 2010</a></li>
					<li><a href="#">October 2010</a></li>
					<li><a href="#">October 2010</a></li>
					<li><a href="#">October 2010</a></li>
				</ul>
			</div>
			
			<div class="widget">
				<p class="heading">Categories</p>
				<ul>
					<li><a href="#">WordPress</a></li>
					<li><a href="#">Development</a></li>
					<li><a href="#">Design</a></li>
					<li><a href="#">Python</a></li>
					<li><a href="#">App Engine</a></li>
				</ul>
			</div>
			
			<div class="widget">
				<p class="heading">Blogroll</p>
				<ul>
					<li><a href="#">Smashing Magazine</a></li>
					<li><a href="#">Mashable</a></li>
					<li><a href="#">TechCrunch</a></li>
				</ul>
			</div>
			<?php endif; ?>
		</div>
