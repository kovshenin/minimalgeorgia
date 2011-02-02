<?php
/**
 * Minimal Georgia Functions
 *
 * Lot's of stuff in here, perhaps needs some refactoring into
 * class-style actions and filters. Comment templates, navigation menus
 * theme settings, etc.
 *
 * @package WordPress
 * @subpackage Minimal Georgia
 * @since 1.0
 */

	// Set the content width, for videos and photos for defaults.
	if (!isset( $content_width))
		$content_width = 640;

	// Enable localization
	load_theme_textdomain('minimalgeorgia', TEMPLATEPATH . '/languages');
	
	// Register our only sidebar.
	if (function_exists('register_sidebar')) {
		register_sidebar(array(
			'before_widget' => '<div class="widget">',
			'after_widget' => '</div>',
			'before_title' => '<p class="heading">',
			'after_title' => '</p>',
		));
	}

	// Register our primary navigation (top right).
	if (function_exists('register_nav_menu')) {
		add_theme_support('nav_menus');
		register_nav_menu('primary', __('Primary Navigation Menu', 'minimalgeorgia'));
		register_nav_menu('menu-404', __('Page Not Found Menu', 'minimalgeorgia'));
	}

	// Non-relevant stylesheets for galleries, remove them.
	function minimalgeorgia_remove_gallery_css($css) {
		return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
	}
	add_filter('gallery_style', 'minimalgeorgia_remove_gallery_css');

	// We'll use this function as a walker-talker throughout comments and pings.
	function minimalgeorgia_comment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		switch ($comment->comment_type):
			case '':
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<div id="comment-<?php comment_ID(); ?>">
			<div class="comment-author vcard">
				<?php echo get_avatar($comment, 40); ?>
				<?php printf(__('%s <span class="says">says:</span>', 'minimalgeorgia'), sprintf('<cite class="fn">%s</cite>', get_comment_author_link())); ?>
			</div><!-- .comment-author .vcard -->
			<?php if ($comment->comment_approved == '0'): ?>
				<em><?php _e('Your comment is awaiting moderation.', 'minimalgeorgia'); ?></em>
				<br />
			<?php endif; ?>

			<div class="comment-meta commentmetadata"><a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
				<?php
					/* translators: 1: date, 2: time */
					printf(__('%1$s at %2$s', 'minimalgeorgia'), get_comment_date(), get_comment_time()); ?></a><?php edit_comment_link(__('(Edit)', 'minimalgeorgia'), ' ');
				?>
			</div><!-- .comment-meta .commentmetadata -->

			<div class="comment-body"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
			</div><!-- .reply -->
		</div><!-- #comment-##  -->

		<?php
				break;
			case 'pingback':
			case 'trackback':
		?>
		<li class="post pingback">
			<p><?php _e('Pingback:', 'minimalgeorgia'); ?> <?php comment_author_link(); ?><?php edit_comment_link(__('(Edit)', 'minimalgeorgia'), ' '); ?></p>
		<?php
				break;
		endswitch;
	}

	// Add a welcome notice for new users.
	function minimalgeorgia_welcome_notice() {
		if (!get_option('mg-options-visited'))
			echo "<div class='update-nag'>" . __("Welcome to <strong>Minimal Georgia</strong>. Thank you so much for using this theme. Now head over to the <a href='themes.php?page=minimalgeorgia-settings'>Theme Options</a> and have some fun!") . "</div>";
	}
	add_action('admin_notices' , 'minimalgeorgia_welcome_notice');

	// Theme activation/deactivation hooks
	function minimalgeorgia_admin_init() {
		register_setting('minimalgeorgia-options', 'mg-color-scheme');
		register_setting('minimalgeorgia-options', 'mg-footer-note');
	}
	add_action('admin_init','minimalgeorgia_admin_init');
	
	function minimalgeorgia_firstrun() {
		$check = get_option('mg-activated');
		if ($check != "set") {
			// General settings
			update_option('mg-color-scheme', 'blue');
			update_option('mg-footer-note', __('Yes, you can type any text you like here in this footer note. Visit your theme settings page from within your admin panel for more info and other settings.', 'minimalgeorgia'));
			update_option('mg-options-visited', false);

			// Add marker so it doesn't run in future
			update_option('mg-activated', 'set');
		}
	}
	
	function minimalgeorgia_deactivate() {
		delete_option('mg-activated');
		delete_option('mg-options-visited');
		
		delete_option('mg-color-scheme');
		delete_option('mg-footer-note');
	}
	
	add_action('admin_init', 'minimalgeorgia_firstrun');
	add_action('switch_theme', 'minimalgeorgia_deactivate');

	// Register a theme settings page.
	function minimalgeorgia_options() {
		add_theme_page(__('Theme Options', 'minimalgeorgia'), __('Theme Options', 'minimalgeorgia'), 'edit_theme_options', 'minimalgeorgia-settings', 'minimalgeorgia_admin');
	}
	add_action('admin_menu', 'minimalgeorgia_options');

	function minimalgeorgia_admin() {
		update_option('mg-options-visited', true);
?>
<div class="wrap">
	<div id="icon-themes" class="icon32"><br></div>
	<h2><?php _e('Minimal Georgia Options', 'minimalgeorgia'); ?></h2>

	<form method="post" action="options.php">
	<?php wp_nonce_field('update-options'); ?>
	<?php settings_fields('minimalgeorgia-options'); ?>

		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Color Scheme', 'minimalgeorgia'); ?></th>
				<td>
					<select name="mg-color-scheme">
						<?php
							$selected = array(get_option('mg-color-scheme') => 'selected="selected"');
						?>
						<option value="blue" <?php echo @$selected['blue']; ?>><?php _e('Sapphire', 'minimalgeorgia'); ?></option>
						<option value="red" <?php echo @$selected['red']; ?>><?php _e('Inferno', 'minimalgeorgia'); ?></option>
						<option value="green" <?php echo @$selected['green']; ?>><?php _e('Emeraldo', 'minimalgeorgia'); ?></option>
						<option value="gray" <?php echo @$selected['gray']; ?>><?php _e('Silent Gray', 'minimalgeorgia'); ?></option>
						<option value="purple" <?php echo @$selected['purple']; ?>><?php _e('Liquid Purple', 'minimalgeorgia'); ?></option>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Footer Note', 'minimalgeorgia'); ?></th>
				<td><textarea rows="5" class="large-text code" name="mg-footer-note"><?php echo get_option('mg-footer-note'); ?></textarea></td>
			</tr>
		</table>

		<input type="hidden" name="action" value="update" />
		<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Changes', 'minimalgeorgia') ?>" />
		</p>
	</form>
</div>
<?php
	}
