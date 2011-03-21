<?php
/**
 * Minimal Georgia Theme Functions
 *
 * There's lots of stuff here, all the functions are defined within
 * the MinimalGeorgia class which is fired during after_theme_setup
 * action. If you need access to the $minimalgeorgia object outside
 * the class declare it as global.
 *
 * @package WordPress
 * @subpackage Minimal Georgia
 * @version 1.4.1
 * 
 */

// Set the content width, for videos and photos for defaults
if (!isset( $content_width))
	$content_width = 640;

/*
 * Minimal Georgia
 * 
 * This is our base class which defines all the theme options, settings,
 * behaviour, sidebars, etc. The class is initialized into a global
 * $minimalgeorgia object upon after_theme_setup (see bottom of class).
 * 
 */
class MinimalGeorgia {
	var $options = array();
	var $defaults = array();
	
	/*
	 * Constructor
	 * 
	 * Fired at WordPress after_setup_theme (see add_action at the end 
	 * of the class), registers the theme capabilities, navigation menus,
	 * as well as a set of actions and filters used by Minimal Georgia.
	 * 
	 * $this->options is used to store all the theme options, while
	 * $this->defaults holds their default values.
	 * 
	 */
	function __construct() {
		
		// Load Minimal Georgia text domain
		load_theme_textdomain('minimalgeorgia', TEMPLATEPATH . '/languages');
		
		// Default options, lower-level ones are added during firstrun
		$this->defaults = array(
			'color-scheme' => 'blue',
			'footer-note' => __('Yes, you can type any text you like here in this footer note. Visit your theme settings page from within your admin panel for more info and other settings.', 'minimalgeorgia')
		);

		// Theme supports
		add_theme_support('automatic-feed-links');
		add_theme_support('post-formats', array('gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));
		
		// Editor style for TinyMCE.
		add_editor_style();
		
		// Load options (calls get_option())
		$this->load_options();
		
		// Register our primary navigation (top right) and 404 page links
		if (function_exists('register_nav_menu')) {
			add_theme_support('nav_menus');
			register_nav_menu('primary', __('Primary Navigation Menu', 'minimalgeorgia'));
			register_nav_menu('menu-404', __('Page Not Found Menu', 'minimalgeorgia'));
		}
		
		/*
		 * Actions
		 * 
		 * Registers sidebars for widgets, registers admin settings, fires
		 * a firstrun during admin init, registers a theme deactivation hook,
		 * adds the menu options, fires a welcome notice, footer text in template,
		 * color scheme preview scripts (sidebar), custom css.
		 * 
		 */
		add_action('widgets_init', array(&$this, 'register_sidebars'));
		add_action('admin_init', array(&$this, 'register_admin_settings'));
		add_action('admin_init', array(&$this, 'firstrun'));
		add_action('switch_theme', array(&$this, 'deactivate'));
		add_action('admin_menu', array(&$this, 'add_admin_options'));
		add_action('admin_notices' , array(&$this, 'welcome_notice'));
		add_action('minimalgeorgia_footer', array(&$this, 'footer_text'));
		add_action('wp_enqueue_scripts', array(&$this, 'colorscheme_preview_scripts'));
		add_action('wp_print_styles', array(&$this, 'custom_css'));
		
		/*
		 * Filters
		 * 
		 * Removes unnecessary CSS from WordPress galleries, adds an
		 * auto paragraph to footer note, the body class (for color scheme)
		 * 
		 */
		add_filter('gallery_style', array(&$this, 'remove_gallery_css'));
		add_filter('minimalgeorgia_footer_note', 'wpautop');
		add_filter('body_class', array(&$this, 'body_class'));
	}
	
	/*
	 * Custom CSS Output
	 * 
	 * Checks the custom CSS theme option and outputs the stylesheets inside
	 * a <style> tag in the header. Function is run during wp_print_styles.
	 * 
	 */
	function custom_css() {
		if (isset($this->options['custom-css']) && strlen($this->options['custom-css']))
			echo "<style>\n" . $this->options['custom-css'] . "\n</style>\n";
	}
	
	/*
	 * Color Scheme Preview
	 * 
	 * This is fired during wp_loaded and includes the Minimal Georgia
	 * color scheme preview script/style if no sidebar widgets have 
	 * been defined.
	 * 
	 */
	function colorscheme_preview_scripts() {
		if (!is_dynamic_sidebar()) {
			wp_enqueue_script('minimalgeorgia-preview', get_stylesheet_directory_uri() . '/js/preview.js', array('jquery'));
			wp_enqueue_style('minimalgeorgia-preview', get_stylesheet_directory_uri() . '/preview.css');
		}
	}
	
	/*
	 * Load Options
	 * 
	 * Fired during theme setup, loads all the options into the $options
	 * array accessible from all other functions.
	 * 
	 */
	function load_options() {
		$this->options = (array) get_option('minimalgeorgia-options');
	}
	
	/*
	 * Save Options
	 * 
	 * Calls the update_option function and saves the current $options
	 * array. Call this after modifying the values of $this->options.
	 * 
	 */
	function update_options() {
		return update_option('minimalgeorgia-options', $this->options);
	}
	
	/*
	 * Theme Deactivation
	 * 
	 * Remove all the options after theme deactivation. This includes
	 * footer note, color scheme and all the rest, let's be nice
	 * and keep the database clean, even if the users didn't like our theme.
	 * 
	 */
	function deactivate() {
		delete_option('minimalgeorgia-options');
	}
	
	/*
	 * First Run
	 * 
	 * This method is fired on every call, which is why it checks the
	 * $options array to see if the theme was activated to make sure this
	 * runs only once. Populates the $options array with defaults and a few
	 * mandatory options.
	 * 
	 */
	function firstrun() {
		if (!isset($this->options['activated']) || !$this->options['activated']) {
			$this->options = $this->defaults;
			
			// Mandatory options during first run
			$this->options['options-visited'] = false;
			$this->options['activated'] = true;

			// Update the options.
			$this->update_options();
		}
	}
	
	/*
	 * Register Sidebars
	 * 
	 * Registers a single right sidebar ready for widgets. An extra
	 * Color picker widget is defined.
	 * 
	 */
	function register_sidebars() {
		register_sidebar(array(
			'before_widget' => '<div class="widget">',
			'after_widget' => '</div>',
			'before_title' => '<p class="heading">',
			'after_title' => '</p>',
		));

		register_widget('MinimalGeorgiaColorPickerWidget');
	}
	
	/*
	 * Valid Color Schemes
	 * 
	 * This function returns an array of the available color schemes, where
	 * an array key is the value used in the database and the HTML layout,
	 * and value is used for captions. The function is used for theme settings
	 * page as well as options validation. Default is blue.
	 * 
	 */
	function get_valid_color_schemes() {
		return array(
			'red' => __('Inferno', 'minimalgeorgia'),
			'blue' => __('Sapphire', 'minimalgeorgia'),
			'green' => __('Emeraldo', 'minimalgeorgia'),
			'gray' => __('Silent Gray', 'minimalgeorgia'),
			'purple' => __('Liquid Purple', 'minimalgeorgia')
		);
	}
	
	/*
	 * Gallery CSS Fix
	 * 
	 * Wordpress adds a style block when rendering the gallery. Since our
	 * gallery is styled in our own stylesheet, and since W3C does not
	 * permit style tags that are not within the head tag, we get rid of
	 * them via a simple preg_replace.
	 * 
	 */
	function remove_gallery_css($css) {
		return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
	}
	
	/*
	 * Register Settings
	 * 
	 * Fired during admin_init, this function registers the settings used
	 * in the Theme Options section, as well as attaches a validator to
	 * clean up the incoming data.
	 * 
	 */
	function register_admin_settings() {
		register_setting('minimalgeorgia-options', 'minimalgeorgia-options', array(&$this, 'validate_options'));
		
		// Settings fields and sections
		add_settings_section('section_general', __('General Settings', 'minimalgeorgia'), array(&$this, 'section_general'), 'minimalgeorgia-options');
		add_settings_field('color-scheme', __('Color Scheme', 'minimalgeorgia') , array(&$this, 'setting_color_scheme'), 'minimalgeorgia-options', 'section_general');
		add_settings_field('footer-note', __('Footer Note', 'minimalgeorgia'), array(&$this, 'setting_footer_note'), 'minimalgeorgia-options', 'section_general');
		add_settings_field('custom-css', __('Custom CSS', 'minimalgeorgia'), array(&$this, 'setting_custom_css'), 'minimalgeorgia-options', 'section_general');
	}
	
	/*
	 * Options Validation
	 * 
	 * This function is used to validate the incoming options, mostly from
	 * the Theme Options admin page. We make sure that the 'activated' array
	 * is untouched and then verify the rest of the options.
	 * 
	 */
	function validate_options($options) {
		// Mandatory.
		$options['activated'] = true;
		
		// Theme options.
		$options['color-scheme'] = array_key_exists($options['color-scheme'], $this->get_valid_color_schemes()) ? $options['color-scheme'] : 'blue';
		$options['footer-note'] = trim(strip_tags($options['footer-note'], '<a><b><strong><em><ul><ol><li><div><span>'));
		$options['custom-css'] = trim(strip_tags($options['custom-css']));
		
		return $options;
	}
	
	/*
	 * Add Menu Options
	 * 
	 * Registers a Theme Options page that appears under the Appearance
	 * menu in the WordPress dashboard. Uses the theme_options to render
	 * the page contents, requires edit_theme_options capabilitites.
	 *
	 */
	function add_admin_options() {
		add_theme_page(__('Theme Options', 'minimalgeorgia'), __('Theme Options', 'minimalgeorgia'), 'edit_theme_options', 'minimalgeorgia-settings', array(&$this, 'theme_options'));
	}
	
	/*
	 * Comment Walker
	 * 
	 * This is used in the comments template, does the comments rendering.
	 * Taken from Twenty Ten and localized. Nothing much here.
	 * 
	 */
	function comment_walker($comment, $args, $depth) {
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
	
	/*
	 * Theme Options
	 * 
	 * This is the function that renders the Theme Options page under
	 * the Appearance menu in the admin section. Upon visiting this the
	 * first time we make sure that a state (options-visited) is saved
	 * to our options array.
	 * 
	 * The rest is handled by the Settings API and some HTML magic.
	 * 
	 */
	function theme_options() {
		
		if (!isset($this->options['options-visited']) || !$this->options['options-visited']) {
			$this->options['options-visited'] = true;
			$this->update_options();
		}
?>
<div class="wrap">
	<div id="icon-themes" class="icon32"><br></div>
	<h2><?php _e('Minimal Georgia Options', 'minimalgeorgia'); ?></h2>

	<form method="post" action="options.php">
		<?php wp_nonce_field('update-options'); ?>
		<?php settings_fields('minimalgeorgia-options'); ?>
		<?php do_settings_sections('minimalgeorgia-options'); ?>
		<p class="submit">
			<input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
		</p>
	</form>
</div>
<?php
	}
	
	/*
	 * Welcome Notice
	 * 
	 * This notice is displayed to new users that have just activated the
	 * Minimal Georgia theme. It displays a message on top saying that we've
	 * got options with a link to the Theme Options page. As soon as that page
	 * has been visited at least once, the message no longer bothers the visitor.
	 * 
	 */
	function welcome_notice() {
		if (!isset($_REQUEST['page']) || $_REQUEST['page'] !== 'minimalgeorgia-settings')
			if (!isset($this->options['options-visited']) || !$this->options['options-visited'])
				echo "<div class='update-nag'>" . __("Welcome to <strong>Minimal Georgia</strong>. Thank you so much for using this theme. Now head over to the <a href='themes.php?page=minimalgeorgia-settings'>Theme Options</a> and have some fun!") . "</div>";
	}
	
	/*
	 * Body Class
	 * 
	 * Fired during the body_class() filter, appends the Minimal
	 * Georgia color scheme. Styles defined in the theme style.css
	 *
	 */
	function body_class($classes) {
		$classes[] = 'mg-' . $this->options['color-scheme'];
		return $classes;
	}
	 
	 /*
	  * Footer Text
	  * 
	  * Fired during minimalgeorgia_footer action in footer.php, formats
	  * the author credit link and echoes the footer-note set in the
	  * theme options by passing it through the footer note filter
	  * (which adds auto paragraphs).
	  *
	  */
	function footer_text() {
		$author_credit = "\n\n" . sprintf(__('Powered by %1$s running %2$s by %3$s', 'minimalgeorgia'), '<a href="http://wordpress.org">WordPress</a>', 'Minimal Georgia', '<a title="Konstantin" href="http://kovshenin.com">Konstantin</a>');
		echo apply_filters('minimalgeorgia_footer_note', $this->options['footer-note'] . $author_credit);
	}
	 
	
	/*
	 * Settings: General Section
	 * 
	 * Used via the Settings API to output the description of the
	 * general settings under Theme Options in Appearance.
	 * 
	 */
	function section_general() {
		_e('These settings affect the general look of your theme.', 'minimalgeorgia');
	}
	
	/*
	 * Settings: Color Scheme
	 * 
	 * Outputs a select box with available color schemes for the Theme
	 * Options page, as well as sets the selected color scheme as defined
	 * in $options.
	 * 
	 */
	function setting_color_scheme() {
	?>
		<select name="minimalgeorgia-options[color-scheme]">
			<?php
				$color_schemes = $this->get_valid_color_schemes();
				foreach ($color_schemes as $value => $caption):
			?>
			<option value="<?php echo $value; ?>" <?php selected($value == $this->options['color-scheme']); ?>><?php echo $caption; ?></option>
			<?php
				endforeach;
			?>
		</select><br />
		<span class="description"><?php _e('Browse to your home page to see the new color scheme in action.', 'minimalgeorgia'); ?></span>
	<?php
	}
	
	/*
	 * Settings: Footer Note
	 * 
	 * Outputs a textarea for the footer note under Theme Options in
	 * Appearance. Populates the textarea with the currently set
	 * footer note from the $options array.
	 * 
	 */
	function setting_footer_note() {
	?>
		<textarea rows="5" class="large-text code" name="minimalgeorgia-options[footer-note]"><?php echo esc_textarea($this->options['footer-note']); ?></textarea><br />
		<span class="description"><?php _e('This is the text that appears at the bottom of every page, right next to the copyright notice.', 'minimalgeorgia'); ?></span>
	<?php
	}
	
	/*
	 * Settings: Custom CSS
	 * 
	 * Outputs a textarea for the custom CSS in Theme Options. The value
	 * is output during wp_head() if it exists.
	 * 
	 */
	function setting_custom_css() {
	?>
		<textarea rows="5" class="large-text code" name="minimalgeorgia-options[custom-css]"><?php echo esc_textarea($this->options['custom-css']); ?></textarea><br />
		<span class="description"><?php _e('Custom stylesheets are included in the head section after all the theme stylesheets are loaded.', 'minimalgeorgia'); ?></span>
	<?php
	}
};

// Initialize the above class after theme setup
add_action('after_setup_theme', create_function('', 'global $minimalgeorgia; $minimalgeorgia = new MinimalGeorgia();'));

/*
 * Color Picker Widget
 * 
 * This is the Color Picker widget class used by Minimal Georgia to
 * show off it's multi-color capabilities. The widget is not intended
 * but may be used by the end-user.
 * 
 */
class MinimalGeorgiaColorPickerWidget extends WP_Widget {
	
	/*
	 * Widget Constructor
	 * 
	 * Initializes the new widget and enqueues a stylesheet and a javascript
	 * if the widget is active. Scripts and styles should be same as 
	 * $minimalgeorgia->colorscheme_preview_scripts
	 * 
	 */
	function MinimalGeorgiaColorPickerWidget() {
		parent::WP_Widget(false, $name = __('MG Color Picker', 'minimalgeorgia'), $widget_options = array('description' => __('A Minimal Georgia color picker widget for your sidebar.', 'minimalgeorgia')));
		
		if (is_active_widget(false, false, $this->id_base, true)) {
			wp_enqueue_style('minimalgeorgia-preview', get_stylesheet_directory_uri() . '/preview.css');
			wp_enqueue_script('minimalgeorgia-preview', get_stylesheet_directory_uri() . '/js/preview.js', array('jquery'));
		}
	}
	
	/*
	 * Widget Form
	 * 
	 * Outputs the widget form data. We're only using one form field
	 * called title.
	 * 
	 */
	function form($instance) {
		$title = esc_attr($instance['title']);
        ?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'minimalgeorgia'); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
        <?php 
	}
	
	/*
	 * Widget Update
	 * 
	 * This is the WordPress magic used to save and restore widget
	 * instances, validation goes here.
	 *
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	
	/*
	 * Widget Output
	 * 
	 * This function is used by WordPress (or the_widget()) to output
	 * the contents of the widget. Note that we're using a global
	 * $minimalgeorgia object, so we're assuming that it has been
	 * initialized. Used to gather valid color schemes.
	 * 
	 * @global $minimalgeorgia
	 *
	 */
	function widget($args, $instance) {
		global $minimalgeorgia;
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        
        echo $before_widget;
        if ($title)	echo $before_title . $title . $after_title; 
		?>
			<p class="color-scheme-selector">
				<?php foreach ($minimalgeorgia->get_valid_color_schemes() as $value => $caption): ?>
				<a data="<?php echo $value; ?>" href="#" title="<?php echo $caption; ?>"><?php echo $caption; ?></a>
				<?php endforeach; ?>
			</p>
        <?php
        echo $after_widget;
	}
};
