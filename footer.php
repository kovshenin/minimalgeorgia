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
 * @version 1.4
 */

	
?>
	</div>
	<div class="clear"></div>
	<div class="container_8 footer">
		<div class="grid_1">
			<p><?php _e('Copyright', 'minimalgeorgia'); ?> &copy; <?php echo date('Y'); ?></p>
		</div>
		<div class="grid_5">
			<?php do_action('minimalgeorgia_footer'); ?>
		</div>
	</div>
	<div class="clear"></div>
	<?php wp_footer(); ?>
</body>
</html>
