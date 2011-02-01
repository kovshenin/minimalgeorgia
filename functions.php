<?php
	if (!isset( $content_width))
		$content_width = 640;

	if (function_exists('register_sidebar')) 
	{
		register_sidebar(array(
			'before_widget' => '<div class="widget">',
			'after_widget' => '</div>',
			'before_title' => '<p class="heading">',
			'after_title' => '</p>',
		));
	}
		
	if (function_exists('register_nav_menu'))
	{
		add_theme_support('nav_menus');
		register_nav_menu('primary', __('Primary Navigation Menu', 'minimalgeorgia'));
	}

	function remove_gallery_css($css) {
		return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
	}
	add_filter('gallery_style', 'remove_gallery_css');


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
