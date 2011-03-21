<?php
/**
 * Single Post
 *
 * A single post. There's not much to say..
 *
 * @package WordPress
 * @subpackage Minimal Georgia
 * @version 1.4
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
					<div class="post-meta">
						<?php wp_link_pages(array('before' => '<p class="page-link">' . __('Pages:', 'minimalgeorgia'), 'after' => '</p>')); ?>
						<p class="the-tags">
							<?php the_tags(); ?><br />
							<?php _e('Categories: '); ?> <?php the_category(', '); ?>
						</p>
					</div>
					<?php edit_post_link(__('Edit this post', 'minimalgeorgia'), '<p>', '</p>'); ?>
					
					<?php comments_template('', true); ?>
				</div>
			</div>
			<?php endwhile; ?>
			
			<div class="pagination">
				<div class="grid_1 alpha">
					&nbsp;
				</div>
				<div class="grid_5 omega">
					<?php if ($wp_query->max_num_pages > 1): ?>
						<div class="left"><?php next_posts_link(__('&larr; Older posts', 'minimalgeorgia')); ?></div>
						<div class="right"><?php previous_posts_link(__('Newer posts &rarr;', 'minimalgeorgia')); ?></div>
					<?php endif; ?>
				</div>
			</div>

		</div>
		<?php get_sidebar(); ?>
<?php get_footer(); ?>
