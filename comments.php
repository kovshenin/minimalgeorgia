<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments and the comment 
 * form. The actual display of comments is handled by a callback to 
 * comments_walker which is located in the functions.php file (inside
 * the MinimalGeorgia base class).
 *
 * @package WordPress
 * @subpackage Minimal Georgia
 * @version 1.4
 */
 
global $minimalgeorgia;
?>

			<div id="comments">
<?php if ( post_password_required() ) : ?>
				<p class="nopassword"><?php _e('This post is password protected. Enter the password to view any comments.', 'minimalgeorgia'); ?></p>
			</div><!-- #comments -->
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>

<?php
	// You can start editing here -- including this comment!
?>

<?php if (have_comments()): ?>
			<h3 id="comments-title"><?php
			printf(_n('One Response to %2$s', '%1$s Responses to %2$s', get_comments_number(), 'minimalgeorgia'),
			number_format_i18n( get_comments_number() ), '<em>' . get_the_title() . '</em>' );
			?></h3>

<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link(__('<span class="meta-nav">&larr;</span> Older Comments', 'minimalgeorgia')); ?></div>
				<div class="nav-next"><?php next_comments_link(__('Newer Comments <span class="meta-nav">&rarr;</span>', 'minimalgeorgia')); ?></div>
			</div> <!-- .navigation -->
<?php endif; // check for comment navigation ?>

			<ol class="commentlist">
				<?php
					wp_list_comments(array('callback' => array(&$minimalgeorgia, 'comment_walker')));
				?>
			</ol>

<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link(__('<span class="meta-nav">&larr;</span> Older Comments', 'minimalgeorgia')); ?></div>
				<div class="nav-next"><?php next_comments_link(__('Newer Comments <span class="meta-nav">&rarr;</span>', 'minimalgeorgia')); ?></div>
			</div><!-- .navigation -->
<?php endif; // check for comment navigation ?>

<?php else : // or, if we don't have comments:

	/* If there are no comments and comments are closed,
	 * let's leave a little note, shall we?
	 */
	if (!comments_open() && !is_page()):
?>
	<p class="nocomments"><?php _e('Comments are closed.', 'minimalgeorgia'); ?></p>
<?php endif; // end ! comments_open() ?>

<?php endif; // end have_comments() ?>

<?php comment_form(); ?>

</div><!-- #comments -->
