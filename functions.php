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
 * @version 1.2
 * @since 1.0
 */

	// Set the content width, for videos and photos for defaults.
	if (!isset( $content_width))
		$content_width = 640;

	// Enable localization
	load_theme_textdomain('minimalgeorgia', TEMPLATEPATH . '/languages');
	
	// Register our only sidebar.
	register_sidebar(array(
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<p class="heading">',
		'after_title' => '</p>',
	));
	
	add_filter('minimalgeorgia-footer', 'wpautop');
	
	/*
	 * Valid Color Schemes
	 * 
	 * Used for validation and forms output.
	 */
	function minimalgeorgia_get_valid_color_schemes() {
		return array(
			'red' => __('Inferno', 'minimalgeorgia'),
			'blue' => __('Saphirre', 'minimalgeorgia'),
			'green' => __('Emeraldo', 'minimalgeorgia'),
			'gray' => __('Silent Gray', 'minimalgeorgia'),
			'purple' => __('Liquid Purple', 'minimalgeorgia')
		);
	}
	
	// Setup the Minimal Georgia theme
	function minimalgeorgia_setup() {
		add_theme_support('automatic-feed-links');		
		
		// Register our primary navigation (top right) and 404 page links.
		if (function_exists('register_nav_menu')) {
			add_theme_support('nav_menus');
			register_nav_menu('primary', __('Primary Navigation Menu', 'minimalgeorgia'));
			register_nav_menu('menu-404', __('Page Not Found Menu', 'minimalgeorgia'));
		}

	}
	add_action('after_setup_theme', 'minimalgeorgia_setup');

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
			<div id="comment-<?php comment_ID(); ?>" class="comment-wrapper">
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
		$options = get_option('minimalgeorgia-options');
		if (!isset($options['options-visited']) || !$options['options-visited'])
			echo "<div class='update-nag'>" . __("Welcome to <strong>Minimal Georgia</strong>. Thank you so much for using this theme. Now head over to the <a href='themes.php?page=minimalgeorgia-settings'>Theme Options</a> and have some fun!") . "</div>";
	}
	add_action('admin_notices' , 'minimalgeorgia_welcome_notice');

	// Theme activation/deactivation hooks
	function minimalgeorgia_admin_init() {
		register_setting('minimalgeorgia-options', 'minimalgeorgia-options', 'minimalgeorgia_validate_options');
		// register_setting('minimalgeorgia-options', 'mg-footer-note', 'minimalgeorgia_sanitize_footer_note');
	}
	add_action('admin_init','minimalgeorgia_admin_init');
	
	function minimalgeorgia_validate_options($options) {
		// Mandatory.
		$options['options-visited'] = true;
		$options['activated'] = true;
		
		// Theme options.
		$options['color-scheme'] = array_key_exists($options['color-scheme'], minimalgeorgia_get_valid_color_schemes()) ? $options['color-scheme'] : 'blue';
		$options['footer-note'] = trim(strip_tags($options['footer-note'], '<a><b><strong><em><ul><ol><li><div><span>'));
		
		return $options;
	}
	
	function minimalgeorgia_firstrun() {
		$options = get_option('minimalgeorgia-options');
		if (!isset($options['activated']) || !$options['activated']) {
			// General settings
			$options['color-scheme'] = 'blue';
			$options['footer-note'] = __('Yes, you can type any text you like here in this footer note. Visit your theme settings page from within your admin panel for more info and other settings.', 'minimalgeorgia');
			$options['options-visited'] = false;
			$options['activated'] = true;

			// Update the options.
			update_option('minimalgeorgia-options', $options);
		}
	}
	
	function minimalgeorgia_deactivate() {
		delete_option('minimalgeorgia-options');
	}
	
	add_action('admin_init', 'minimalgeorgia_firstrun');
	add_action('switch_theme', 'minimalgeorgia_deactivate');

	// Register a theme settings page.
	function minimalgeorgia_options() {
		add_theme_page(__('Theme Options', 'minimalgeorgia'), __('Theme Options', 'minimalgeorgia'), 'edit_theme_options', 'minimalgeorgia-settings', 'minimalgeorgia_admin');
	}
	add_action('admin_menu', 'minimalgeorgia_options');

	function minimalgeorgia_admin() {
		$options = (array) get_option('minimalgeorgia-options');
		$options['options-visited'] = true;
		update_option('minimalgeorgia-options', $options);
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
					<select name="minimalgeorgia-options[color-scheme]">
						<?php
							$color_schemes = minimalgeorgia_get_valid_color_schemes();
							foreach ($color_schemes as $value => $caption):
						?>
						<option value="<?php echo $value; ?>" <?php selected($value == $options['color-scheme']); ?>><?php echo $caption; ?></option>
						<?php
							endforeach;
						?>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Footer Note', 'minimalgeorgia'); ?></th>
				<td><textarea rows="5" class="large-text code" name="minimalgeorgia-options[footer-note]"><?php echo $options['footer-note']; ?></textarea></td>
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
