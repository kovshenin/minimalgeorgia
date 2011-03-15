<?php
/**
 * The template for displaying Pages.
 *
 * Nothing special here, similar to index.php
 *
 * @package WordPress
 * @subpackage Minimal Georgia
 * @version 1.3
 */

get_header(); ?>
		<div class="grid_6 posts-list">
			<?php while (have_posts()): the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="grid_1 alpha right-arrow-container">
					<span class="right-arrow">&nbsp;</span>
					<p class="date"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'minimalgeorgia'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_time('F j, Y'); ?></a></p>
					<p class="comments-count"><?php comments_popup_link('0','1','%'); ?></p>
				</div>
				<div class="grid_5 omega content-container">
					<?php if (get_the_title()): ?>
					<h1 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'minimalgeorgia'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
					<?php endif; ?>
					<div class="post-content <?php if (!get_the_title()) echo 'no-title'; ?>">
						<?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'minimalgeorgia') ); ?>
					</div>
					<div class="post-meta"><?php wp_link_pages(array('before' => '<p class="page-link">' . __('Pages:', 'minimalgeorgia'), 'after' => '</p>')); ?></div>
					<?php edit_post_link(__('Edit this page', 'minimalgeorgia'), '<p>', '</p>'); ?>
					
					<?php comments_template('', true); ?>
				</div>
			</div>
			<?php endwhile; ?>
		</div>
		<?php get_sidebar(); ?>
<?php get_footer(); ?>
