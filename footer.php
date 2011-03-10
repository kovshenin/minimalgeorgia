<?php
/**
 * Footer Area
 *
 * The footer area, nothing special. The text in the footer
 * can be edited from within the theme options in the
 * WordPress admin.
 *
 * @package WordPress
 * @subpackage Minimal Georgia
 * @since 1.0
 */
	global $mg_options;
	$author_credit = "\n\n" . sprintf(__('Powered by %1$s running %2$s by %3$s', 'minimalgeorgia'), '<a href="http://wordpress.org">WordPress</a>', 'Minimal Georgia', '<a title="Konstantin" href="http://kovshenin.com">Konstantin</a>');
?>
	</div>
	<div class="clear"></div>
	<div class="container_8 footer">
		<div class="grid_1">
			<p><?php _e('Copyright', 'minimalgeorgia'); ?> &copy; <?php echo date('Y'); ?></p>
		</div>
		<div class="grid_5">
			<?php echo apply_filters('minimalgeorgia-footer', $mg_options['footer-note'] . $author_credit); ?>
		</div>
	</div>
	<div class="clear"></div>
	<?php wp_footer(); ?>
</body>
</html>
